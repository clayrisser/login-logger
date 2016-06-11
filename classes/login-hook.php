<?php

class Login_Hook {
  
  function __construct() {
    add_action( 'wp_login_failed' , array($this, 'log_attempt') );
    add_action( 'login_form', array($this, 'insert_captcha') );
    add_action( 'login_enqueue_scripts', array($this, 'insert_captcha_script') );
    add_action( 'login_enqueue_scripts', array($this, 'style_login_form') );
    add_action( 'wp_authenticate', array($this, 'verify_captcha'));
  }
  
  function log_attempt() {
    $logJson = get_option( 'loggerlogin52' );
    $idCounter = get_option( 'loggerloginid52' );
    $idCounter++;
    $log = json_decode($logJson);
    $ip = '';
    $country = 'localhost';
    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    if ($ip == '::1') {
      $ip = '127.0.0.1';
    } else {
      $details = json_decode(file_get_contents('http://ipinfo.io/'.$ip.'/json'));
      $country = $details->country;
    }
    $username = $_POST['log'];
    $password = $_POST['pwd'];
    $attempt = array(
      'id'          => $idCounter,
      'date'        => time(),
      'ip'          => $ip,
      'country'     => $country,
      'username'    => $username,
      'password'    => $password
    );
    array_push($log, $attempt);
    $logJson = json_encode($log);
    update_option( 'loggerlogin52', $logJson );
    update_option( 'loggerloginid52', $idCounter );
  }
  
  function insert_captcha() {
    $siteKey = "6LfE-x0TAAAAAOGL1Bp0SKBMQtYiJWyswewHtJja";
    echo '<div class="g-recaptcha" style="margin-bottom:10px" data-sitekey="'.$siteKey.'"></div>';
  }
  
  function insert_captcha_script() {
    wp_enqueue_script( 'captcha-script', 'https://www.google.com/recaptcha/api.js', null, null, true );
  }
  
  function style_login_form() {
    ?>
    <style type="text/css">
        #loginform {
          width: 300px;
        }
    </style>
    <?php
  }
  
  function verify_captcha() {
    if (isset($_POST['g-recaptcha-response'])) {
      $captchaResponse = $_POST['g-recaptcha-response'];
      $secretKey = '6LfE-x0TAAAAAHQB7nctj7h9FRj_vz5pMDpkx1YI';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      $data = array(
        'secret' => $secretKey,
        'response' => $captchaResponse
      );
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $content = curl_exec($ch);
      curl_close($ch);
      $response = json_decode($content);
      if (!$captchaResponse || $captchaResponse == '' || $response->success != true) {
        $error = 'reCaptcha failed';
        wp_redirect(wp_login_url().'?error='.urlencode($error));
        exit();
      }
    }
  }
  
}
