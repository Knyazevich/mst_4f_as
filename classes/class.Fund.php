<?php

namespace Maximumstart\Alert_System;

use Exception;

class Fund {
  private $external_jsons_path;
  private $local_jsons_path;
  private $fund_id;
  private $class_id;

  public function __construct($options) {
    $this->external_jsons_path = ABSPATH . 'funds/data';
    $this->local_jsons_path = plugin_dir_path(__DIR__) . '/funds';

    $this->fund_id = $options['fund_id'];
    $this->class_id = $options['class_id'];
  }

  public static function get_fund_type($fund_category) {
    if (preg_match('/.*?(income|Income).*?/', $fund_category)) {
      return 'income';
    } else {
      return 'equity';
    }
  }

  public function get_json_data($origin = 'external') {
    return $this->get_current_json($this->get_json_path_by_fund_url($origin));
  }

  private function get_current_json($path) {
    try {
      $json = file_get_contents($path);
      return json_decode($json);
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
      return null;
    }
  }

  private function get_json_path_by_fund_url($origin = 'external') {
    if ($origin === 'local') {
      return $this->local_jsons_path . '/fund.json';
    }

    return sprintf(
      '%s/2_%s__%s.json',
      $origin === 'external' ? $this->external_jsons_path : $this->local_jsons_path,
      strtoupper($this->fund_id),
      strtoupper($this->class_id)
    );
  }
}
