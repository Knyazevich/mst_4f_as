<?php

namespace Maximumstart\Alert_System;

use DateTime;

class Fund_Parameter {
  private $title;
  private $diff_type;
  private $handler;
  private $change_percentage;

  /**
   * Has rules and methods for fund data comparing.
   * @param string $title Parameter title.
   * @param $handler
   * @param string $diff_type Difference type. Possible values: 'inc', 'dec', 'any'. Default to 'any'.
   * @param bool|int|float $change_percentage Changing percentage. In $diff_type is 'inc' or 'dec, then you can set the
   * difference percentage as a integer or float. Default to false.
   */
  public function __construct($title, $handler, $diff_type = 'any', $change_percentage = false) {
    $this->title = $title;
    $this->handler = $handler;
    $this->diff_type = $diff_type;
    $this->change_percentage = $change_percentage;
  }

  public function compare($current, $previous) {
    $is_equal = $this->get_comparing_method()($current, $previous);
    $percentage_difference = $this->percentage_difference($current, $previous);

    return [
      'title' => $this->title,
      'is_equal' => $is_equal,
      'diff_type' => $this->diff_type,
      'diff_value' => $percentage_difference,
      'is_alert' => $this->is_alert($this->diff_type, $this->change_percentage, $percentage_difference),
      'change_percentage' => $this->change_percentage,
    ];
  }

  private function get_comparing_method() {
    $methods = [
      'int' => [ $this, 'compare_int' ],
      'string' => [ $this, 'compare_strings' ],
      'float' => [ $this, 'compare_float' ],
      'date' => [ $this, 'compare_dates' ],
      'year_returns_array' => [ $this, 'compare_year_returns_array' ],
    ];

    return $methods[$this->handler];
  }

  private function percentage_difference($current, $previous) {
    if (empty((float) $current) || empty((float) $previous)) {
      return 0;
    }

    if (is_array($current) || is_array($previous)) {
      return 0;
    }

    return (($previous - $current) / $current) * 100;
  }

  private function is_alert($diff_type, $diff_value, $change_percentage) {
    switch ($diff_type) {
      case 'inc':
        if ($diff_value > $change_percentage) {
          return true;
        }
        break;
      case 'dec':
        if ($diff_value < $change_percentage) {
          return true;
        }
        break;
      default:
        if ($diff_value !== $change_percentage) {
          return true;
        } else {
          return false;
        }
    }
  }

  public function get_property($property_name) {
    return $this->{$property_name};
  }

  private function compare_strings($current, $previous) {
    return trim((string) $current) === trim((string) $previous);
  }

  private function compare_int($current, $previous) {
    return (int) $current === (int) $previous;
  }

  private function compare_float($current, $previous) {
    return (float) $current === (float) $previous;
  }

  private function compare_dates($current, $previous) {
    $current_date = new DateTime(str_replace('/', '-', $current));
    $previous_date = new DateTime(str_replace('/', '-', $previous));

    $interval = $previous_date->diff($current_date);

    return is_null($interval->format('%s'));
  }

  private function compare_year_returns_array($current, $previous) {
    return (array) $current === (array) $previous;
  }
}