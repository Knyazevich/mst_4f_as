<?php

namespace Maximumstart\Alert_System;

require plugin_dir_path(__FILE__) . 'class.Fund_Parameters_Collection.php';
require plugin_dir_path(__FILE__) . 'class.Fund.php';

class Fund_Report {
  private $funds_to_check;
  private $fields_to_check;
  private $message;
  private $recipients_emails;
  private $current_fund;

  public function __construct() {
    $this->recipients_emails = DB_Options::get('data_changing_recipients_emails');
    $this->funds_to_check = DB_Options::get('pages_to_watch');
    $this->fields_to_check = Fund_Parameters_Collection::get_income_funds_rules();
  }

  /**
   * Used as an entry for the cron task.
   * */
  public function generate_report() {
    $this->create_message();
    $this->send_data();
  }

  private function create_message() {
    $funds = explode("\n", str_replace("\r", '', $this->funds_to_check));

    if (empty($funds)) return;

    foreach ($funds as $fund_url) {
      $fund = new Fund($this->get_fund_id_and_class_from_url($fund_url));

      $this->current_fund = $fund->get_json_data();
      $this->generate_message_part_from_fund();
    }
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

    if (empty($json)) {
      return null;
    }

    $fund_name = $json->fund_name->value;

    $this->message .= sprintf(
      '<h1>Updates for %s. Current fund JSON date: %s, previous data JSON created: %s</h1><br>',
      $fund_name,
      $json->last_updated,
      $json->last_updated
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
        'The fund "%s" %s %s on %s - %s <br>',
        $fund_name,
        'lost',
        $comparing_result['diff_value'] . '%',
        $comparing_result['title'],
        '<span style="color: green">No alert</span>'
      );
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
