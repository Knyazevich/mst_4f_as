<?php

namespace Maximumstart\Alert_System;

class Screenshot {
  private $API_KEY;
  private $recipients_emails;
  private $pages_to_screenshot;
  private $attachments;
  private $screenshot_path;
  private $screenshots_links;

  public function __construct() {
    if (empty(DB_Options::get('is_screenshots_enabled'))) {
      return;
    }

    $this->API_KEY = DB_Options::get('apiflash_api_key');
    $this->recipients_emails = DB_Options::get('screenshots_recipients_emails');
    $this->pages_to_screenshot = DB_Options::get('pages_to_screenshot');
    $this->screenshot_path = WP_PLUGIN_DIR . '/mst_4f_as/screenshots/';
    $this->screenshots_links = [];
  }

  /**
   * Used as an entry for the cron task.
   * */
  public function take_and_send_all() {
    try {
      $this->take_and_save_all(false);
      $this->send_screenshots();
      $this->remove_screenshots();
    } catch (\Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
    }
  }

  private function take_and_save_all($is_preload = false) {
    $pages = explode("\n", str_replace("\r", '', $this->pages_to_screenshot));

    foreach ($pages as $page) {
      $this->take($page, $is_preload);
    }

    if ($is_preload) {
      exit;
    }

    $this->download_screenshots();

    $screenshots = array_diff(scandir($this->screenshot_path), [ '.', '..' ]);

    if (!sizeof($screenshots)) {
      return;
    }

    $this->attachments = array_map(function ($screenshot) {
      return $this->screenshot_path . $screenshot;
    }, $screenshots);
  }

  private function take($page_url, $fresh = false) {
    if (empty($this->API_KEY)) {
      Logger::log('error', [ 'error' => 'ERROR: ApiFlash key must be provided' ]);
      wp_die('ERROR: ApiFlash key must be provided ' . print_r(debug_backtrace(), 1));
    }

    $request_url = add_query_arg([
      'access_key' => $this->API_KEY,
      'url' => urlencode($page_url),
      'format' => 'jpeg',
      'full_page' => true,
      'fresh' => $fresh,
      'delay' => 2,
      'quality' => 60,
      'response_type' => 'json'
    ], 'https://api.apiflash.com/v1/urltoimage');

    $json = json_decode(file_get_contents($request_url));

    if (empty($json)) {
      Logger::log('error', [ 'error' => 'Maximum api call count reached' ]);
      wp_die();
    }

    $this->screenshots_links[] = $json->url;
  }

  private function download_screenshots() {
    foreach ($this->screenshots_links as $screenshots_link) {
      $current_datetime = date('Y-m-d-H-i');
      $random_id = wp_rand(1000000000, 9999999999);
      $image = file_get_contents($screenshots_link);

      file_put_contents(
        $this->screenshot_path . sprintf('%s--%s.jpeg', $current_datetime, $random_id),
        $image
      );
    }
  }

  private function send_screenshots() {
    $recipients = explode("\n", str_replace("\r", '', $this->recipients_emails));
    $date = date('Y-m-d');

    if (!sizeof($this->attachments) || !sizeof($recipients)) return;

    foreach ($recipients as $recipient) {
      wp_mail(
        sanitize_email($recipient),
        sprintf('[%s] Report of the 4F funds', $date),
        'Hi! A bunch of new screenshots already here.',
        '',
        $this->attachments
      );
    }
  }

  private function remove_screenshots() {
    $files = glob($this->screenshot_path . '*');

    foreach ($files as $file) {
      if (is_file($file))
        unlink($file);
    }
  }

  public function preload_screenshots() {
    try {
      $this->take_and_save_all(true);
    } catch (\Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
    }
  }
}
