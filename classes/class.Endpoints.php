<?php
declare(strict_types=1);

namespace Maximumstart\Alert_System;

class Endpoints {
  public function __construct() {
    $this->init_actions();
  }

  private function init_actions() {
    add_action('wp_loaded', [ $this, 'rewrite_rule' ]);
    add_filter('query_vars', [ $this, 'add_query_var' ]);
    add_action('parse_request', [ $this, 'parse_request' ]);
  }

  public function rewrite_rule() {
    add_rewrite_rule('alert-system$', 'index.php?alert-system=1', 'top');
  }

  public function add_query_var(array $query_vars): array {
    $query_vars[] = 'alert-system';
    return $query_vars;
  }

  public function parse_request(&$wp) {
    if (!array_key_exists('alert-system', $wp->query_vars)) {
      return;
    }

    $response = $this->get_callback($wp->query_vars['alert-system'])();

    if ($response === true) {
      wp_send_json_success();
    } else {
      wp_send_json_error($response);
    }
  }

  private function get_callback($action): callable {
    $screenshot_instance = new Screenshot();
    $report_instance = new Fund_Report();

    $callbacks = [
      'preload_screenshots' => [ $screenshot_instance, 'preload_screenshots' ],
      'take_screenshots' => [ $screenshot_instance, 'take_and_send_all' ],
      'generate_report' => [ $report_instance, 'generate_report' ],
    ];

    if (!$callbacks[$action]) {
      return function(): string {
        return 'No such action';
      };
    }

    return $callbacks[$action];
  }
}
