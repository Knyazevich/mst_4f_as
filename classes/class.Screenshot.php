<?php
declare(strict_types=1);

namespace Maximumstart\Alert_System;

use Exception;

class Screenshot {
  private $API_KEY;
  private $recipients_emails;
  private $pages_to_screenshot;
  private $attachments;
  private $screenshots_links;

  public function __construct() {
    if (empty(DB_Options::get('is_screenshots_enabled'))) {
      return;
    }

    $this->API_KEY = DB_Options::get('apiflash_api_key');
    $this->recipients_emails = DB_Options::get('screenshots_recipients_emails');
    $this->pages_to_screenshot = DB_Options::get('pages_to_screenshot');
    $this->screenshots_links = [];
  }

  public function take_and_send_all(): bool {
    try {
      $this->take_and_save_all(false);
      $this->send_screenshots();
      $this->remove_screenshots();

      return true;
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
      return false;
    }
  }

  private function take_and_save_all(bool $is_preload) {
    try {
      $pages = explode("\n", str_replace("\r", '', $this->pages_to_screenshot));

      foreach ($pages as $page) {
        $this->take($page, $is_preload);
      }

      if ($is_preload) exit;

      $this->download_screenshots();

      if (empty(MST_4F_AS_SCREENSHOTS_PATH)) {
        throw new Exception('MST_4F_AS_SCREENSHOTS_PATH constant is empty.');
      }

      $screenshots = array_diff(scandir(MST_4F_AS_SCREENSHOTS_PATH), [ '.', '..' ]);

      if (!sizeof($screenshots)) {
        Logger::log('warning', [ 'error' => 'There are no screenshots to send.' ]);
        exit;
      }

      $this->attachments = array_map(function(string $screenshot): string {
        return sprintf('%s/%s', MST_4F_AS_SCREENSHOTS_PATH, $screenshot);
      }, $screenshots);
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
    }
  }

  private function take(string $page_url, bool $fresh = false): array {
    try {
      if (empty($this->API_KEY)) {
        throw new Exception('ApiFlash key must be provided.');
      }

      $request_url = add_query_arg([
        'access_key' => $this->API_KEY,
        'url' => urlencode($page_url),
        'format' => 'jpeg',
        'full_page' => true,
        'fresh' => $fresh,
        'ttl' => 2 * 3600,
        'delay' => 2,
        'quality' => 60,
        'response_type' => 'json'
      ], 'https://api.apiflash.com/v1/urltoimage');

      $json = json_decode(file_get_contents($request_url));

      if (empty($json)) {
        throw new Exception('Maximum api call count reached.');
      }

      $this->screenshots_links[] = $json->url;

      return $this->screenshots_links;
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
      exit;
    }
  }

  private function download_screenshots() {
    foreach ($this->screenshots_links as $screenshots_link) {
      $current_datetime = date('Y-m-d-H-i');
      $random_id = wp_rand(1000000000, 9999999999);
      $image = file_get_contents($screenshots_link);

      file_put_contents(
        MST_4F_AS_SCREENSHOTS_PATH . sprintf('/%s--%s.jpeg', $current_datetime, $random_id),
        $image
      );
    }
  }

  private function send_screenshots() {
    try {
      $recipients = explode("\n", str_replace("\r", '', $this->recipients_emails));
      $date = date('Y-m-d');

      if (empty($this->attachments)) {
        throw new Exception('Message is empty.');
      }

      if (!sizeof($recipients)) {
        throw new Exception('There are no recipients for the screenshots.');
      }

      foreach ($recipients as $recipient) {
        wp_mail(
          sanitize_email($recipient),
          sprintf('[%s] Report of the 4F funds', $date),
          'Hi! A bunch of new screenshots already here.',
          '',
          $this->attachments
        );
      }
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
    }
  }

  private function remove_screenshots() {
    try {
      if (empty(MST_4F_AS_SCREENSHOTS_PATH)) {
        throw new Exception('MST_4F_AS_FUNDS_ARCHIVE_PATH constant is empty.');
      }

      $files = glob(MST_4F_AS_SCREENSHOTS_PATH . '/*');

      foreach ($files as $file) {
        if (is_file($file)) {
          unlink($file);
        }
      }
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
    }
  }

  public function preload_screenshots(): bool {
    try {
      $this->take_and_save_all(true);
      return true;
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
      return false;
    }
  }
}
