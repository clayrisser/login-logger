<?php

class Inline_Script {

  function __construct() {
    add_action( 'wp_footer', array($this, 'insert_script') );
  }
  
  function insert_script() {
    $key = $this->get_option( 'key', 'podbuzzz' );
    $enabled = $this->get_option( 'enabled', 'podbuzzz' );
    if ($enabled == 'yes' && $key && $key != '') {
      echo '<script async src="https://www.podbuzzz.com/'.$key.'/podbuzz_review_prompt.js"></script>';
    }
  }
  
  function get_option( $option, $section ) {
    $options = get_option( $section );
    if ( isset( $options[$option] ) ) {
      return $options[$option];
    }
    return false;
  }
}
