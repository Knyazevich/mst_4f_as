<?php

namespace Maximumstart\Alert_System;

use Exception;

class Fund {
  private $fund_jsons_path;
  private $fund_id;
  private $class_id;

  public function __construct($options) {
    $this->fund_jsons_path = ABSPATH . 'funds/data';

    $this->fund_id = $options['fund_id'];
    $this->class_id = $options['class_id'];
  }

  public function get_json_data() {
    return $this->get_current_json($this->get_json_path_by_fund_url());
  }

  private function get_current_json($path) {
    try {
      $json = file_get_contents($path);
      return json_decode($json);
    } catch (Exception $e) {
      return null;
    }
  }

  private function get_json_path_by_fund_url() {
    return sprintf(
      '%s/2_%s__%s.json',
      $this->fund_jsons_path,
      strtoupper($this->fund_id),
      strtoupper($this->class_id)
    );
  }
}