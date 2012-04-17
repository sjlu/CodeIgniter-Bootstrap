<?php

class Aws {
   
   private $aws_key = '';
   private $aws_secret = '';

   public function __construct()
   {
      $ci =& get_instance();
      $ci->config->load('aws');
      $this->aws_key = $ci->config->item('aws_key');
      $this->aws_secret = $ci->config->item('aws_secret');
   }

   public function load($library)
   {
      include_once 'aws/sdk.class.php';
      $credentials = array(
         'key' => $this->aws_key,
         'secret' => $this->aws_secret
      );

      switch ($library)
      {
         case 's3':
            $this->s3 = new AmazonS3($credentials);
            break;
         case 'ec2':
            $this->ec2 = new AmazonEC2($credentials);
            break;
         default:
      }
   }

}
