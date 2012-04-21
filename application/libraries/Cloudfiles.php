<?php

class Cloudfiles {

   private $user = '';
   private $api_key = '';

   private $auth;
   private $conn;
   private $cont;
   private $cont_name;

   public function __construct() 
   {
      include_once 'rs/cloudfiles.php';

      $ci =& get_instance();
      $ci->config->load('cloudfiles');
      $this->user = $ci->config->item('cf_user');
      $this->api_key = $ci->config->item('cf_api_key');

      $this->auth = new CF_Authentication($this->user, $this->api_key);  
      $this->auth->ssl_use_cabundle();
      $this->auth->authenticate();

      $this->conn = new CF_Connection($this->auth);
      $this->conn->ssl_use_cabundle();
   }

   public function create_container($cname)
   {
      if (!$cname)
         return false;

      if (!$this->conn->create_container($cname))
         return false;

      return true;
   }

   public function delete_container($cname)
   {
      if (!$cname)
         return false;

      try 
      {
         $this->conn->delete_container($cname);
      }
      catch (Exception $excp)
      {
         $excp = $excp->getMessage();

         switch ($excp)
         {
            case 'NoSuchContainerException':
               break;
            default: 
               return false;
         }
      }

      return true;

   }

   private function get_container($c)
   {
      if (isset($this->cont) && $this->cont_name == $c)
         return $this->cont; 

      try
      {
         $container = $this->conn->get_container($c);

         // caching the current container
         // so that we don't need to access
         // it a million times.
         $this->cont = $container;
         $this->cont_name = $c;
      }
      catch (Exception $excp)
      {
         return false;
      }
      
      return $container;

   }

   public function make_container_private($c)
   {
      if (!$container = $this->get_container($c))
         return false;

      try
      {
         $container->make_private();
      }
      catch (Exception $excp)
      {
         return false;
      }

      return true;
   }


   public function make_container_public($c)
   {
      if (!$container = $this->get_container($c))
         return false;

      try
      {
         $container->make_public();
      }
      catch (Exception $excp)
      {
         return false;
      }

      return true;
   }

   private function get_object($c, $f)
   {
      if (!$container = $this->get_container($c))
         return false;

      if (!$obj = $container->get_object($f))
         return false;

      return $obj;
   }

   public function create_object($c, $f)
   {
      if (!file_exists($f))
         return false;

      if (!$container = $this->get_container($c))
         return false;

      if (!$obj = $container->create_object(basename($f))) 
         return false;

      try 
      {
         $obj->load_from_filename($f);
      }
      catch (Exception $excp)
      {
         return false;
      }

      return true;

   }

   public function delete_object($c, $f)
   {
      if (!$container = $this->get_container($c))
         return false;

      try
      {
         $container->delete_object($f);
      } 
      catch (Exception $excp)
      {
         $excp = $excp->getMessage();

         switch ($excp)
         {
            case 'NoSuchObjectException':
               break;
            default:
               return false;
         }
      }
      
      return true;
   }


   public function get_object_url($c, $f, $ssl = true)
   {
      if (!$obj = $this->get_object($c, $f))
         return false;

      if ($ssl)
         $url = $obj->public_ssl_uri();
      else
         $url = $obj->public_uri();

      if (!$url)
         return false;

      return $url;
   }

   public function list_objects($c)
   {
      if (!$container = $this->get_container($c))
         return false;

      try
      {
         $list = $container->list_objects();
      }
      catch (Exception $excp)
      {
         $excp = $excp->getMessage();
         // docs saay only excp is InvalidResponseException
         return false;
      }

      return $list;
   }

}
