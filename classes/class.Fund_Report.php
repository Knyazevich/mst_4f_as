<?php

namespace Maximumstart\Alert_System;

use Exception;

require plugin_dir_path(__FILE__) . 'class.Fund_Parameters_Collection.php';
require plugin_dir_path(__FILE__) . 'class.Fund.php';

class Fund_Report {
  private $funds_to_check;
  private $fields_to_check;
  private $message;
  private $recipients_emails;
  private $current_fund;
  private $current_cached_fund;

  public function __construct() {
    $this->recipients_emails = DB_Options::get('data_changing_recipients_emails');
    $this->funds_to_check = DB_Options::get('pages_to_watch');
    $this->fields_to_check = Fund_Parameters_Collection::get_income_funds_rules();
  }

  /**
   * Used as an entry for the cron task.
   * */
  public function generate_report() {
    try {
      $this->create_message();
      $this->send_data();
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
    }
  }

  private function create_message() {
    $funds = explode("\n", str_replace("\r", '', $this->funds_to_check));

    if (empty($funds)) {
      return null;
    }

    foreach ($funds as $fund_url) {
      $fund = new Fund($this->get_fund_id_and_class_from_url($fund_url));

      $this->current_fund = $fund->get_json_data('external');
      $this->current_cached_fund = $fund->get_json_data('local');

      $this->generate_message_part_from_fund();
    }

    return $this->message;
  }

  private function get_fund_id_and_class_from_url($url) {
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

  private function generate_message_part_from_fund() {
    $json = $this->current_fund;
    $cached_json = $this->current_cached_fund;

    if (empty($json)) {
      return null;
    }

    $fund_name = $json->fund_name->value;

    $this->message .= sprintf(
      '<h1>Updates for %s. Current fund JSON date: %s, previous data JSON created: %s</h1><br>',
      $fund_name,
      $json->last_updated,
      $cached_json->last_updated
    );

    foreach ($this->fields_to_check as $field => $rules) {
      $current_fund_value = array_reduce(explode('.', $field), function ($o, $p) {
        return $o->$p;
      }, $json);

      $previous_fund_value = array_reduce(explode('.', $field), function ($o, $p) {
        return $o->$p;
      }, $json);

      $comparing_result = $rules->compare($current_fund_value, $previous_fund_value);

      $this->message .= sprintf(
        'The fund "%s" %s (%s -> %s) on %s - %s <br>',
        $fund_name,
        $this->format_difference($comparing_result['is_equal'], $comparing_result['diff_value']),
        $previous_fund_value,
        $current_fund_value,
        $comparing_result['title'],
        $this->get_alert_html($comparing_result['is_alert'])
      );
    }
  }

  /**
   * Returns formatted string to paste in the message.
   *
   * @param bool $is_equal
   * @param float $difference Difference percentage.
   * @return string Formatted string.
   */
  private function format_difference($is_equal, $difference) {
    if ($difference === 0.0 && $is_equal) {
      return 'did not changed';
    } elseif ($difference === 0.0 && !$is_equal) {
      return 'changed';
    } elseif ($difference > 0) {
      return 'raise of ' . abs($difference) . '%';
    } else {
      return 'lost ' . abs($difference) . '%';
    }
  }

  private function get_alert_html($is_alert) {
    if ($is_alert) {
      return '<span style="color: red">Alert</span>';
    } else {
      return '<span style="color: green">No alert</span>';
    }
  }

  private function send_data() {
    $recipients = explode("\n", str_replace("\r", '', $this->recipients_emails));
    $date = date('Y-m-d');

    if (empty($this->message) || !sizeof($recipients)) return;

    foreach ($recipients as $recipient) {
      wp_mail(
        sanitize_email($recipient),
        sprintf('[%s] Report of the 4F funds', $date),
        $this->message,
        [ 'content-type: text/html' ]
      );
    }
  }
}
