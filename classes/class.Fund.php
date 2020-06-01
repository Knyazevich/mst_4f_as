<?php
declare(strict_types=1);

namespace Maximumstart\Alert_System;

use Exception;

class Fund {
  private $fund_id;
  private $class_id;

  public function __construct($options) {
    $this->fund_id = $options['fund_id'];
    $this->class_id = $options['class_id'];
  }

  /**
   * Returns fund data by its category. Useful to pick a group of comparison rules.
   *
   * @param string $fund_category Category from JSON data.
   * @return string One of two values: 'income' or 'equity'.
   */
  public static function get_fund_type(string $fund_category): string {
    if (preg_match('/.*?(income|Income).*?/', $fund_category)) {
      return 'income';
    }

    if (preg_match('/.*?(equity|Equity).*?/', $fund_category)) {
      return 'equity';
    }

    return '';
  }

  /**
   * Saves current file to archive to compare actual fund data with it in the next comparison.
   */
  public function archive_fund() {
    try {
      $external_fund_path = $this->get_json_path_by_fund_url('external');
      $local_fund_path = $this->get_json_path_by_fund_url('local');

      if (copy($external_fund_path, $local_fund_path) === false) {
        throw new Exception(sprintf(
          'Fund file copying error from %s to %s.',
          $external_fund_path,
          $local_fund_path
        ));
      }
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
    }
  }

  private function get_json_path_by_fund_url(string $origin = 'external'): string {
    try {
      if (empty(MST_4F_AS_FUNDS_EXTERNAL_PATH) || empty(MST_4F_AS_FUNDS_ARCHIVE_PATH)) {
        throw new Exception('One or both path constants are empty.');
      }

      return sprintf(
        '%s/3_%s__%s.json',
        $origin === 'external' ? MST_4F_AS_FUNDS_EXTERNAL_PATH : MST_4F_AS_FUNDS_ARCHIVE_PATH,
        strtoupper($this->fund_id),
        strtoupper($this->class_id)
      );
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
      return '';
    }
  }

  /**
   * Returns fund's JSON data by a file's origin.
   *
   * @param string $origin File location: 'external' for the actual fund data, 'archived' for the last saved data.
   * @return mixed|null
   */
  public function get_json_data(string $origin = 'external') {
    $path = $this->get_json_path_by_fund_url($origin);

    if ($origin === 'archived' && !$this->archived_file_exists($path)) {
      return $this->get_current_json($this->get_json_path_by_fund_url('external'));
    }

    return $this->get_current_json($this->get_json_path_by_fund_url($origin));
  }

  private function archived_file_exists(string $file_name): bool {
    return file_exists(sprintf('%s/%s.json', MST_4F_AS_FUNDS_ARCHIVE_PATH, $file_name));
  }

  private function get_current_json(string $path) {
    try {
      $json = file_get_contents($path);

      if ($json === false) {
        throw new Exception(sprintf('JSON fetching error by path %s.', $path));
      }

      $parsed_json = json_decode($json);

      if ($parsed_json === null) {
        throw new Exception(sprintf('JSON parsing error by path %s.', $path));
      }

      return $parsed_json;
    } catch (Exception $e) {
      Logger::log('error', [ 'error' => $e ]);
      return null;
    }
  }
}
