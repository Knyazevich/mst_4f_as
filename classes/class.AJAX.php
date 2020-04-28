<?php

namespace Maximumstart\Alert_System;

class AJAX {
  public function __construct() {
    $this->init_admin_handlers();
  }

  public function init_admin_handlers() {
    $handlers = [
      'mst_4f_preload_screenshots' => [ $this, 'preload_screenshots' ],
      'mst_4f_force_screenshots' => [ $this, 'force_take_screenshots' ],
      'mst_4f_force_comparison' => [ $this, 'force_compare_funds' ],
    ];

    foreach ($handlers as $name => $callback) {
      add_action("wp_ajax_{$name}", $callback);
    }
  }

  public function preload_screenshots() {
    try {
      $s = new Screenshot();
      $s->preload_screenshots();

      wp_send_json_success();
    } catch (\Exception $e) {
      wp_send_json_error([ 'error' => $e ]);
    }

    wp_die();
  }

  public function force_take_screenshots() {
    try {
      $s = new Screenshot();
      $s->take_and_send_all();

      wp_send_json_success();
    } catch (\Exception $e) {
      wp_send_json_error([ 'error' => $e ]);
    }

    wp_die();
  }

  public function force_compare_funds() {
    try {
      $f = new Fund_Report();
      $f->generate_report();

      wp_send_json_success();
    } catch (\Exception $e) {
      wp_send_json_error([ 'error' => $e ]);
    }

    wp_die();
  }
}
