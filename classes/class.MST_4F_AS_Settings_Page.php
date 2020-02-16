<?php

class MST_4F_AS_Settings_Page {
  public function __construct() {
    $this->init_actions();
  }

  private function init_actions() {
    add_action('admin_menu', [ $this, 'add_menu_page' ]);
    add_action('admin_init', [ $this, 'settings_init' ]);
  }

  public function add_menu_page() {
    add_menu_page(
      esc_html__('Alert System Settings', 'mst_4f_as'),
      esc_html__('Alert System Settings', 'mst_4f_as'),
      'manage_options',
      'mst_as_options',
      [ $this, 'render_option_page_content' ]
    );
  }

  public function settings_init() {
    register_setting('mst_4f_as_options', 'mst_4f_as_options');

    $this->register_settings_sections();
    $this->register_settings_fields();
  }

  private function register_settings_sections() {
    add_settings_section(
      'mst_4f_as_main_options_section',
      esc_html__('Screenshots settings', 'mst_4f_as'),
      null,
      'mst_4f_as_options'
    );
  }

  private function register_settings_fields() {
    add_settings_field(
      'mst_4f_as_is_enabled',
      esc_html__('Alert system enabled?', 'mst_4f_as'),
      [ $this, 'render_is_enabled_field' ],
      'mst_4f_as_options',
      'mst_4f_as_main_options_section'
    );

    add_settings_field(
      'mst_4f_as_apiflash_api_key',
      esc_html__('ApiFlash API Key', 'mst_4f_as'),
      [ $this, 'render_apiflash_key_field' ],
      'mst_4f_as_options',
      'mst_4f_as_main_options_section'
    );

    add_settings_field(
      'mst_4f_as_screenshots_recipients_emails',
      esc_html__('Screenshots recipients emails', 'mst_4f_as'),
      [ $this, 'render_screenshots_recipients_emails_field' ],
      'mst_4f_as_options',
      'mst_4f_as_main_options_section'
    );

    add_settings_field(
      'mst_4f_as_pages_to_screenshot',
      esc_html__('Pages to screenshot', 'mst_4f_as'),
      [ $this, 'render_pages_to_screenshot_field' ],
      'mst_4f_as_options',
      'mst_4f_as_main_options_section'
    );
  }

  public function render_option_page_content() {
    ?>
    <form action="<?php echo admin_url('options.php'); ?>" method="POST">
      <h1><?php esc_html_e('Alert System Settings', 'mst_4f_as'); ?></h1>

      <?php
      settings_fields('mst_4f_as_options');
      do_settings_sections('mst_4f_as_options');
      submit_button();
      ?>
    </form>
    <?php
  }

  public function render_is_enabled_field() {
    $value = MST_4F_AS_DB_Options::get('is_enabled');
    printf('<input type="checkbox" name="mst_4f_as_options[is_enabled]" %s value="1">', checked($value, true, false));
  }

  public function render_apiflash_key_field() {
    $value = esc_attr(MST_4F_AS_DB_Options::get('apiflash_api_key'));
    printf('<input type="text" name="mst_4f_as_options[apiflash_api_key]" value="%s" style="width: 400px">', $value);
  }

  public function render_screenshots_recipients_emails_field() {
    $value = esc_html(MST_4F_AS_DB_Options::get('screenshots_recipients_emails'));
    printf('<textarea name="mst_4f_as_options[screenshots_recipients_emails]" style="width: 400px">%s</textarea>', $value);
  }

  public function render_pages_to_screenshot_field() {
    $value = esc_html(MST_4F_AS_DB_Options::get('pages_to_screenshot'));
    printf('<textarea name="mst_4f_as_options[pages_to_screenshot]" style="width: 400px; height: 300px">%s</textarea>', $value);
  }
}

