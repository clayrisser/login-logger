<?php

class Helper {
  
  function plugin_root_url() {
    $basename = plugin_basename( __FILE__ );
    $length = 0;
    for ($slashcount = 0; $length < strlen($basename); $length++) {
      if ($basename[$length] == '/') {
        break;
      }
    }
    $plugin = substr($basename, 0, $length);
    return plugins_url( '', dirname(__FILE__) );
  }
}