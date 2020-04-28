<?php
/**
 * Plugin Name: 4F Alert System
 * Plugin URI:  https://github.com/Knyazevich/mst_4f_as
 * Description: Creates and sends daily funds screenshots and data changing overviews.
 * Text Domain: mst_4f_as
 * Domain Path: /languages
 * Author URI:  https://github.com/Knyazevich
 * Author:      Pavlo Knyazevich
 * Requires at least: 5.0
 * Tested up to: 5.3.2
 * Requires PHP: 7.0
 * Version:     1.0.0
 *
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Maximumstart\Alert_System;

if (!defined('MST_4F_AS_VER')) {
  define('MST_4F_AS_VER', '1.0.0');
}

require plugin_dir_path(__FILE__) . 'classes/class.Cron.php';
require plugin_dir_path(__FILE__) . 'classes/class.DB_Options.php';
require plugin_dir_path(__FILE__) . 'classes/class.Settings_Page.php';
require plugin_dir_path(__FILE__) . 'classes/class.Screenshot.php';
require plugin_dir_path(__FILE__) . 'classes/class.Fund_Report.php';
require plugin_dir_path(__FILE__) . 'classes/class.AJAX.php';
require plugin_dir_path(__FILE__) . 'classes/class.Logger.php';

class Main {
  public function __construct() {
    $this->set_screenshots_taking_cron_task();
    $this->init_actions();
    $this->init_admin_setting_page();
    $this->init_AJAX_handlers();
  }

  public function set_screenshots_taking_cron_task() {
    $screenshot_instance = new Screenshot();
    $report_instance = new Fund_Report();

    new Cron([
      'id' => 'cron_jobs',
      'auto_activate' => false,
      'events' => [
        'mst_4f_as_preload_screenshots_every_day' => [
          'callback' => [ $screenshot_instance, 'preload_screenshots' ],
          'interval_name' => 'daily',
        ],
        'mst_4f_as_take_screenshots_every_day' => [
          'callback' => [ $screenshot_instance, 'take_and_send_all' ],
          'interval_name' => 'daily',
        ],
        'mst_4f_as_create_fund_report_every_day' => [
          'callback' => [ $report_instance, 'generate_report' ],
          'interval_name' => 'daily',
        ]
      ],
    ]);
  }

  private function init_actions() {
    add_action('plugins_loaded', [ $this, 'load_text_domain' ]);
    add_action('admin_enqueue_scripts', [ $this, 'add_admin_script' ]);
    register_activation_hook(__FILE__, [ $this, 'setup_plugin_on_activation' ]);
    register_deactivation_hook(__FILE__, [ $this, 'setup_plugin_on_deactivation' ]);
  }

  private function init_admin_setting_page() {
    new Settings_Page();
  }

  public function init_AJAX_handlers() {
    new AJAX();
  }

  public function load_text_domain() {
    load_plugin_textdomain(
      'mst_4f_as',
      false,
      dirname(plugin_basename(__FILE__)) . '/languages/'
    );
  }

  public function setup_plugin_on_activation() {
    DB_Options::set_basic_options();
    Cron::activate('cron_jobs');
  }

  public function setup_plugin_on_deactivation() {
    Cron::deactivate('cron_jobs');
  }

  public function add_admin_script() {
    wp_enqueue_script(
      'mst-4f-as-admin',
      plugins_url('assets/js/admin.min.js', __FILE__),
      [],
      MST_4F_AS_VER,
      true
    );

    wp_localize_script('mst-4f-as-admin', 'mst_4f_as_state', [
      'ajaxURL' => admin_url('admin-ajax.php'),
      'i18n' => [],
    ]);
  }
}

new Main();
