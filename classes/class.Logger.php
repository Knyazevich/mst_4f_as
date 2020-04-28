<?php

namespace Maximumstart\Alert_System;

class Logger {
  /**
   * @param string $level Error level.
   * @param array $info Additional data.
   */
  public static function log($level, $info = []) {
    $data = [ 'status' => $level ];
    do_action('logger', array_merge($data, $info));
  }
}
