<?php
/**
 * Plugin Name: LoginLogger
 * Plugin URI: http://tareq.wedevs.com/2012/06/wordpress-settings-api-php-class/
 * Description: WordPress Settings API testing
 * Author: JamRizzi
 * Author URI: http://tareq.weDevs.com
 * Version: 1.1
 */

require_once( __DIR__ . '/classes/settings-api.php' );
require_once( __DIR__ . '/classes/admin-page.php' );
require_once( __DIR__ . '/classes/inline-script.php' );

new Admin_Page();
new Inline_Script();
