<?php

require_once( __DIR__ . '/logs-list.php');

class Admin_Page {

  private $settings_api;

  function __construct() {
    $page = $_GET['page'];
    $this->settings_api = new WeDevs_Settings_API;
    add_action( 'admin_menu', array($this, 'admin_menu') );
    add_action( 'admin_init', array($this, 'admin_init') );
    if ($page == 'loginlogger') {
      add_action( 'admin_enqueue_scripts', array($this, 'admin_page_style') );
    }
  }

  // Initialize
  function admin_init() {
    $this->settings_api->set_sections( $this->get_settings_sections() );
    $this->settings_api->set_fields( $this->get_settings_fields() );
    $this->settings_api->admin_init();
  }

  // Creates settings page
  function admin_menu() {
    add_options_page( 'LoginLogger', 'LoginLogger', 'manage_options', 'loginlogger', array($this, 'settings_page') );
  }

  // Gets settings sections
  function get_settings_sections() {
    $sections = array(
      array(
        'id' => 'logs',
        'title' => 'Logs'
      ),
      array(
        'id' => 'settings',
        'title' => 'Settings'
      )
    );
    return $sections;
  }

  // Gets settings fields
  function get_settings_fields() {
    $settings_fields = array(
      'logs' => array(),
      'settings' => array(
        array(
          'name'       => 'siteKey',
          'label'       => __( 'Site Key', 'loginlogger' ),
          'desc'       => __( 'You can get this key <a href="https://www.google.com/recaptcha/admin" target="_blank">HERE</a>.', 'loginlogger' ),
          'type'       => 'text',
          'default'      => ''
        ),
        array(
          'name'       => 'secretKey',
          'label'       => __( 'Secret Key', 'loginlogger' ),
          'desc'       => __( 'You can get this key <a href="https://www.google.com/recaptcha/admin" target="_blank">HERE</a>.', 'loginlogger' ),
          'type'       => 'password',
          'default'      => ''
        ),
        array(
          'name'  => 'enabled',
          'label'  => __( 'Enabled', 'loginlogger' ),
          'desc'  => __( 'Enables the Google reCAPTCHA.', 'loginlogger' ),
          'type'  => 'radio',
          'default' => 'yes',
          'options' => array(
            'yes' => 'Yes',
            'no' => 'No'
          )
        )
      )
    );

    return $settings_fields;
  }
  
  function get_logs_list() {

  }

  // Settings page
  function settings_page() {
    ?><div class="wrap">
      <h1>LoginLogger</h1>
      <?php
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
      ?>
      <div id="logTable">
        <?php
          $wp_list_table = new Logs_List();
          $wp_list_table->prepare_items();
          $wp_list_table->display();
        ?>
      </div>
    </div><?php
  }
  
  // Admin page style
  function admin_page_style() {
    wp_enqueue_style( 'admin_css', plugins_url( 'assets/styles/admin-page.css', dirname(__FILE__) ), false );
    wp_enqueue_script ( 'admin_js', plugins_url( 'assets/scripts/admin-page.js', dirname(__FILE__) ), false );
  }

}
