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

require plugin_dir_path(__FILE__) . 'classes/class.DB_Options.php';
require plugin_dir_path(__FILE__) . 'classes/class.Settings_Page.php';
require plugin_dir_path(__FILE__) . 'classes/class.Screenshot.php';
require plugin_dir_path(__FILE__) . 'classes/class.Fund_Report.php';
require plugin_dir_path(__FILE__) . 'classes/class.AJAX.php';
require plugin_dir_path(__FILE__) . 'classes/class.Logger.php';
require plugin_dir_path(__FILE__) . 'classes/class.Endpoints.php';

class Main {
  public function __construct() {
    $this->init_actions();
    $this->init_admin_setting_page();
    $this->init_AJAX_handlers();
  }

  private function init_actions() {
    add_action('init', [ $this, 'init_endpoints' ]);
    add_action('plugins_loaded', [ $this, 'load_text_domain' ]);
    add_action('admin_enqueue_scripts', [ $this, 'add_admin_script' ]);
    register_activation_hook(__FILE__, [ $this, 'setup_plugin_on_activation' ]);
  }

  private function init_admin_setting_page() {
    new Settings_Page();
  }

  public function init_AJAX_handlers() {
    new AJAX();
  }

  public function init_endpoints() {
    new Endpoints();
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
