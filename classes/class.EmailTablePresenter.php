<?php

namespace Maximumstart\Alert_System;

class EmailTablePresenter implements Presenter {
  public function get_output($current_fund, $current_archived_fund) {
    try {
      $result = '';

      $fund_type = Fund::get_fund_type($current_fund->fund_category->value);
      $collection = new Fund_Parameters_Collection();
      $ruleset = $collection->get_rules($fund_type);

      if (empty($current_fund) || empty($current_archived_fund)) {
        throw new Exception('Funds data must not be empty.');
      }

      if (!sizeof($ruleset)) {
        throw new Exception(sprintf('No rules for the fund type: %s', $fund_type));
      }

      $fund_name = $current_fund->fund_name->value;
      $fund_share_class = $current_fund->share_class_isin->value;

      $result .= /** @lang HTML */
        <<<HTML
<h1>Updates for {$fund_name} <span style="color:#38761d;">({$fund_share_class})</span></h1>
<h2>Current fund JSON date: {$current_fund->last_updated}</h2>
<h2>Previous data JSON created: {$current_archived_fund->last_updated}</h2><br>

<table border="1">
  <tr>
    <td style="padding: 2px 3px; background-color: rgb(60,120,216); font-weight: bold; color: #fff">Field name</td>
    <td style="padding: 2px 3px; background-color: rgb(60,120,216); font-weight: bold; color: #fff">Alert</td>
    <td style="padding: 2px 3px; background-color: rgb(60,120,216); font-weight: bold; color: #fff">Value D-1</td>
    <td style="padding: 2px 3px; background-color: rgb(60,120,216); font-weight: bold; color: #fff">Value D-0</td>
  </tr>


HTML;

      foreach ($ruleset as $field => $rules) {
        $current_fund_value = array_reduce(explode('.', $field), function($o, $p) {
          return $o->$p;
        }, $current_fund);

        $previous_fund_value = array_reduce(explode('.', $field), function($o, $p) {
          return $o->$p;
        }, $current_archived_fund);

        $comparing_result = $rules->compare($current_fund_value, $previous_fund_value);

        // Allows avoid an "Array to string conversion" error
        if (is_object($previous_fund_value) || is_object($current_fund_value)) {
          $previous_fund_value = 'Object';
          $current_fund_value = 'Object';
        }

        $result .= sprintf(
          '<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
          $comparing_result['title'],
          $this->get_alert_html($comparing_result['is_alert']),
          $previous_fund_value,
          $current_fund_value
        );
      }

      $result .= '</table><br><br>';

      return $result;
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
    }
  }

  private function get_alert_html(bool $is_alert): string {
    if ($is_alert) {
      return '<span style="color: red">Yes</span>';
    } else {
      return '<span style="color: green">No</span>';
    }
  }
}
