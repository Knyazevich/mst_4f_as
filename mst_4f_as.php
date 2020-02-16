<?php
/**
 * Plugin Name: 4F Alert System
 * Plugin URI: https://github.com/Knyazevich
 * Description: 4F Custom Visual Composer modules to render some API data
 * Text Domain: mst_4f_as
 * Domain Path: /languages
 * Author URI:  https://github.com/Knyazevich
 * Author:      Pavlo Knyazevich
 * Version:     1.0.0
 *
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('MST_4F_AS_VER')) {
  define('MST_4F_AS_VER', '1.0.0');
}

require plugin_dir_path(__FILE__) . 'classes/class.Kama_Cron.php';
require plugin_dir_path(__FILE__) . 'classes/class.MST_4F_AS_DB_Options.php';
require plugin_dir_path(__FILE__) . 'classes/class.MST_4F_AS_Settings_Page.php';
require plugin_dir_path(__FILE__) . 'classes/class.MST_4F_AS_Screenshot.php';

class MST_4F_Alert_System {
  public function __construct() {
    $this->set_screenshots_taking_cron_task();
    $this->init_actions();
    $this->init_admin_setting_page();
  }

  private function init_actions() {
    add_action('plugins_loaded', [ $this, 'load_text_domain' ]);
    register_activation_hook(__FILE__, [ $this, 'setup_plugin_on_activation' ]);
    register_deactivation_hook(__FILE__, [ $this, 'setup_plugin_on_deactivation' ]);
  }

  private function init_admin_setting_page() {
    new MST_4F_AS_Settings_Page();
  }

  public function set_screenshots_taking_cron_task() {
    $screenshot_instance = new MST_4F_AS_Screenshot;

    new Kama_Cron([
      'id' => 'cron_jobs',
      'auto_activate' => false,
      'events' => [
        'take_screenshots_every_day' => [
          'callback' => [ $screenshot_instance, 'take_and_send_all' ],
          'interval_name' => 'daily',
        ],
      ],
    ]);
  }

  public function load_text_domain() {
    load_plugin_textdomain(
      'mst_4f_as',
      false,
      dirname(plugin_basename(__FILE__)) . '/languages/'
    );
  }

  public function setup_plugin_on_activation() {
    MST_4F_AS_DB_Options::set_basic_options();
    Kama_Cron::activate('cron_jobs');
  }

  public function setup_plugin_on_deactivation() {
    Kama_Cron::deactivate('cron_jobs');
  }
}

new MST_4F_Alert_System();
