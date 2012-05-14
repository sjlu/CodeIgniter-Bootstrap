<?php

class Fb {
   
   private $appid = '';
   private $secret = '';

   public function __construct()
   {
      $ci =& get_instance();
      $ci->config->load('fb');
      $this->appid = $ci->config->item('fb_appid');
      $this->secret = $ci->config->item('fb_secret');

      //load the library
      $this->load();
   }

   private function load()
   {
      include_once 'fb/facebook.php';
      $credentials = array(
         'appId' => $this->appid,
         'secret' => $this->secret
      );

      $this->sdk = new Facebook($credentials);
   }      

}
