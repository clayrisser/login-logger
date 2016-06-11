<?php
/**
 * Plugin Name: LoginLogger
 * Plugin URI: http://tareq.wedevs.com/2012/06/wordpress-settings-api-php-class/
 * Description: WordPress Settings API testing
 * Author: JamRizzi
 * Author URI: http://tareq.weDevs.com
 * Version: 1.1
 */
 
register_activation_hook( __FILE__, 'myplugin_activate' );

function myplugin_activate() {
  $log = array();
  $logJson = json_encode($log);
  update_option( 'loggerlogin52', $logJson );
  update_option( 'loggerloginid52', 0 );
}
    
require_once( __DIR__ . '/classes/settings-api.php' );
require_once( __DIR__ . '/classes/admin-page.php' );
require_once( __DIR__ . '/classes/inline-script.php' );
require_once( __DIR__ . '/classes/login-hook.php' );

new Admin_Page();
new Inline_Script();
new Login_Hook();
