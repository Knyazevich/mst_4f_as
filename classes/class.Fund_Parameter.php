<?php
declare(strict_types=1);

namespace Maximumstart\Alert_System;

use DateTime;
use Exception;
use stdClass;

class Fund_Parameter {
  private $title;
  private $diff_type;
  private $handler;
  private $change_percentage;

  /**
   * Has rules and methods for fund data comparing.
   *
   * @param string $title Parameter title.
   * @param string $handler Data comparison handler.
   * @param string $diff_type Difference type. Possible values: 'inc', 'dec', 'any'. Default to 'any'.
   * @param int|float $change_percentage Changing percentage. In $diff_type is 'inc' or 'dec, then you can set the
   * difference percentage as a integer or float. Default to false.
   */
  public function __construct(string $title, string $handler, string $diff_type = 'any', int $change_percentage = 0) {
    $this->title = $title;
    $this->handler = $handler;
    $this->diff_type = $diff_type;
    $this->change_percentage = $change_percentage;
  }

  public function compare($current, $previous): array {
    try {
      $is_equal = $this->get_comparing_method()($current, $previous);

      if ($this->handler === 'numeric') {
        $percentage_difference = $this->percentage_difference($current, $previous);
      } else {
        $percentage_difference = 0.0;
      }

      return [
        'title' => $this->title,
        'is_equal' => $is_equal,
        'diff_type' => $this->diff_type,
        'diff_value' => $percentage_difference,
        'is_alert' => $this->is_alert($is_equal, $percentage_difference),
        'change_percentage' => $this->change_percentage,
        'handler' => $this->handler,
      ];
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
      return [];
    }
  }

  private function get_comparing_method(): callable {
    // All comparing methods must return true if both values are equal.
    $methods = [
      'numeric' => [ $this, 'compare_numbers' ],
      'string' => [ $this, 'compare_strings' ],
      'date' => [ $this, 'compare_dates' ],
      'array' => [ $this, 'compare_array' ],
      'object' => [ $this, 'compare_object' ],
    ];

    return $methods[$this->handler];
  }

  private function percentage_difference($current, $previous): float {
    $current = floatval(preg_replace('/[^-0-9.]/', '', $current));
    $previous = floatval(preg_replace('/[^-0-9.]/', '', $previous));

    if ($previous === 0.0) {
      return 0.0;
    }

    return round(($current - $previous) / $previous * 100);
  }

  private function is_alert(bool $is_equal, float $percentage_difference): bool {
    if ($is_equal) {
      return false;
    }

    if ($this->handler === 'numeric') {
      if (
        $this->diff_type === 'inc' &&
        $this->change_percentage === 0 &&
        $percentage_difference > 0
      ) {
        return true;
      }

      if (
        $this->diff_type === 'inc' &&
        $this->change_percentage === 0 &&
        $percentage_difference < 0
      ) {
        return false;
      }

      if (
        $this->diff_type === 'dec' &&
        $this->change_percentage === 0 &&
        $percentage_difference < 0
      ) {
        return true;
      }

      if (
        $this->diff_type === 'dec' &&
        $this->change_percentage === 0 &&
        $percentage_difference > 0
      ) {
        return false;
      }

      if (
        $this->diff_type === 'inc' &&
        $this->change_percentage !== 0 &&
        $percentage_difference > $this->change_percentage
      ) {
        return true;
      }

      if (
        $this->diff_type === 'dec' &&
        $this->change_percentage !== 0 &&
        $percentage_difference < $this->change_percentage
      ) {
        return true;
      }

      if (
        $this->diff_type === 'any' &&
        $this->change_percentage === 0 &&
        ($percentage_difference < 0 || $percentage_difference > 0)
      ) {
        return true;
      }

      if (
        $this->diff_type === 'any' &&
        $this->change_percentage !== 0 &&
        ($percentage_difference > $this->change_percentage || $percentage_difference < $this->change_percentage)
      ) {
        return true;
      }
    }

    return true;
  }

  public function get_property(string $property_name) {
    return $this->{$property_name};
  }

  private function compare_strings(string $current, string $previous): bool {
    return trim($current) === trim($previous);
  }

  private function compare_numbers($current, $previous): bool {
    $current = floatval(preg_replace('/[^-0-9.]/', '', $current));
    $previous = floatval(preg_replace('/[^-0-9.]/', '', $previous));

    return $current === $previous;
  }

  private function compare_dates(string $current, string $previous): bool {
    $current_date = new DateTime(str_replace('/', '-', $current));
    $previous_date = new DateTime(str_replace('/', '-', $previous));

    $interval = $previous_date->diff($current_date);

    return $interval->days === 0;
  }

  private function compare_array(array $current, array $previous): bool {
    // Here always must be two dashes to compare just objects properties.
    return $current == $previous;
  }

  private function compare_object(stdClass $current, stdClass $previous): bool {
    // Here always must be two dashes to compare just objects properties.
    return $current == $previous;
  }
}
