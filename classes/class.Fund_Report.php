<?php
declare(strict_types=1);

namespace Maximumstart\Alert_System;

use Exception;

class Fund_Report {
  private $funds_to_check;
  private $message;
  private $recipients_emails;

  public function __construct() {
    if (empty(DB_Options::get('data_changing_alerts_enabled'))) {
      return;
    }

    $this->recipients_emails = DB_Options::get('data_changing_recipients_emails');
    $this->funds_to_check = DB_Options::get('pages_to_watch');
  }

  public function generate_report(): bool {
    try {
      $this->create_message();
      $this->send_data();
      $this->remove_archived_funds();
      $this->archive_funds();

      return true;
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
      return false;
    }
  }

  private function create_message(): string {
    try {
      $funds = explode("\n", str_replace("\r", '', $this->funds_to_check));

      if (empty($funds)) {
        throw new Exception('There are no funds to compare.');
      }

      foreach ($funds as $fund_url) {
        $fund = new Fund($this->get_fund_id_and_class_from_url($fund_url));
        $current_fund = $fund->get_json_data('external');
        $current_archived_fund = $fund->get_json_data('archived');

        $presenter = new EmailTablePresenter();
        $this->message .= $presenter->get_output($current_fund, $current_archived_fund);
      }

      return $this->message;
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
      return '';
    }
  }

  private function get_fund_id_and_class_from_url(string $url): array {
    $url_query = wp_parse_url($url, PHP_URL_QUERY);
    wp_parse_str($url_query, $queries);

    if (empty($queries) || empty($queries['fund_id']) || empty($queries['class_id'])) {
      return [];
    }

    return [
      'fund_id' => $queries['fund_id'],
      'class_id' => $queries['class_id'],
    ];
  }

  private function send_data() {
    try {
      $recipients = explode("\n", str_replace("\r", '', $this->recipients_emails));
      $date = date('Y-m-d');

      if (empty($this->message)) {
        throw new Exception('Message is empty.');
      }

      if (!sizeof($recipients)) {
        throw new Exception('There are no recipients for the report.');
      }

      foreach ($recipients as $recipient) {
        wp_mail(
          sanitize_email($recipient),
          sprintf('[%s] Report of the 4F funds', $date),
          $this->message,
          [ 'content-type: text/html' ]
        );
      }
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
    }
  }

  /**
   * Clears the archived funds folder.
   */
  private function remove_archived_funds() {
    try {
      if (empty(MST_4F_AS_FUNDS_ARCHIVE_PATH)) {
        throw new Exception('MST_4F_AS_FUNDS_ARCHIVE_PATH constant is empty.');
      }

      $files = glob(MST_4F_AS_FUNDS_ARCHIVE_PATH . '/*');

      foreach ($files as $file) {
        if (is_file($file)) {
          unlink($file);
        }
      }
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
    }
  }

  /**
   * Copies current funds data to the archive folder.
   */
  private function archive_funds() {
    try {
      $funds = explode("\n", str_replace("\r", '', $this->funds_to_check));

      if (empty($funds)) {
        throw new Exception('There are no funds to check.');
      }

      foreach ($funds as $fund_url) {
        $fund = new Fund($this->get_fund_id_and_class_from_url($fund_url));
        $fund->archive_fund();
      }
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
    }
  }
}
