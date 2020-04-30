<?php
declare(strict_types=1);

namespace Maximumstart\Alert_System;

class Logger {
  /**
   * @param string $level Error level.
   * @param array $info Additional data.
   *
   * @return bool
   */
  public static function log(string $level, array $info = []): bool {
    $data = [ 'status' => $level ];
    do_action('logger', array_merge($data, $info));

    return true;
  }
}
