<?php

namespace Maximumstart\Alert_System;

class EmailPlainPresenter implements Presenter {
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
      $result .= sprintf(
        '<h1>Updates for %s. Current fund JSON date: %s, previous data JSON created: %s</h1><br>',
        $fund_name,
        $current_fund->last_updated,
        $current_archived_fund->last_updated
      );

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
          'The fund "%s" %s (%s -> %s) on %s - %s <br>',
          $fund_name,
          $this->format_difference($comparing_result['is_equal'], $comparing_result['diff_value']),
          $previous_fund_value,
          $current_fund_value,
          $comparing_result['title'],
          $this->get_alert_html($comparing_result['is_alert'])
        );
      }

      return $result;
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
    }
  }

  /**
   * Returns formatted string to paste in the message.
   *
   * @param bool $is_equal
   * @param float $difference Difference percentage.
   * @return string Formatted string.
   */
  private function format_difference(bool $is_equal, float $difference): string {
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

  private function get_alert_html(bool $is_alert): string {
    if ($is_alert) {
      return '<span style="color: red">Alert</span>';
    } else {
      return '<span style="color: green">No alert</span>';
    }
  }
}
