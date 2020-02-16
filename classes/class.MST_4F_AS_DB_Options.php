<?php

class MST_4F_AS_DB_Options {
  public static function get($name) {
    return get_option('mst_4f_as_options')[$name];
  }

  public static function set_basic_options() {
    $options = self::getAll();

    if (!$options) {
      add_option(self::get_name(), [
        'is_enabled' => 1,
        'apiflash_api_key' => '',
        'screenshots_recipients_emails' => '',
        'pages_to_screenshot' => '',
      ]);
    }
  }

  public static function getAll() {
    return get_option('mst_4f_as_options');
  }

  public static function get_name() {
    return 'mst_4f_as_options';
  }
}