<?php
declare(strict_types=1);

namespace Maximumstart\Alert_System;

class DB_Options {
  public static function get(string $name) {
    if (!empty(get_option('mst_4f_as_options')[$name])) {
      return get_option('mst_4f_as_options')[$name];
    } else {
      return null;
    }
  }

  public static function set_basic_options() {
    $options = self::getAll();

    if (!$options) {
      add_option(self::get_name(), [
        'is_screenshots_enabled' => 1,
        'apiflash_api_key' => '',
        'screenshots_recipients_emails' => '',
        'pages_to_screenshot' => '',
        'data_changing_alerts_enabled' => '1',
        'data_changing_recipients_emails' => '',
        'pages_to_watch' => '',
      ]);
    }
  }

  public static function getAll() {
    return get_option('mst_4f_as_options');
  }

  public static function get_name(): string {
    return 'mst_4f_as_options';
  }
}
