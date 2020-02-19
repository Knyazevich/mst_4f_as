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

class Main {
  public function __construct() {
    $this->set_screenshots_taking_cron_task();
    $this->init_actions();
    $this->init_admin_setting_page();
  }

  public function set_screenshots_taking_cron_task() {
    $screenshot_instance = new Screenshot();

    new Cron([
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

  private function init_actions() {
    add_action('plugins_loaded', [ $this, 'load_text_domain' ]);
    add_action('wp_head', [ $this, 'add_force_redirection_js_parameters_to_head' ]);
    register_activation_hook(__FILE__, [ $this, 'setup_plugin_on_activation' ]);
    register_deactivation_hook(__FILE__, [ $this, 'setup_plugin_on_deactivation' ]);
  }

  private function init_admin_setting_page() {
    new Settings_Page();
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

  public function add_force_redirection_js_parameters_to_head() {
    ?>
    <script>
      var mst_4f_as_force_redirect_options = {
        isEnabled: <?php echo (int) DB_Options::get('force_redirect_enabled'); ?>,
        redirectionURL: '<?php echo DB_Options::get('force_redirect_url'); ?>',
      }
    </script>
    <?php
  }
}

new Main();
