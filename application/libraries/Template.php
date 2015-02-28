<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
    class Template 
    {
        var $ci;
         
        function __construct() 
        {
            $this->ci =& get_instance();
        }

        function load($tpl_view, $body_view = null, $data = null) 
		{
		    if ( ! is_null( $body_view ) ) 
		    {
		        if ( file_exists( APPPATH.'views/'.$tpl_view.'/'.$body_view ) ) 
		        {
		            $body_view_path = $tpl_view.'/'.$body_view;
		        }
		        else if ( file_exists( APPPATH.'views/'.$tpl_view.'/'.$body_view.'.phtml' ) ) 
		        {
		            $body_view_path = $tpl_view.'/'.$body_view.'.phtml';
		        }
		        else if ( file_exists( APPPATH.'views/'.$body_view ) ) 
		        {
		            $body_view_path = $body_view;
		        }
		        else if ( file_exists( APPPATH.'views/'.$body_view.'.phtml' ) ) 
		        {
		            $body_view_path = $body_view.'.phtml';
		        }
		        else
		        {
		            show_error('Unable to load the requested file: ' . $tpl_name.'/'.$view_name.'.phtml');
		        }
		         
		        $body = $this->ci->load->view($body_view_path, $data, TRUE);
		         
		        if ( is_null($data) ) 
		        {
		            $data = array('body' => $body);
		        }
		        else if ( is_array($data) )
		        {
		            $data['body'] = $body;
		        }
		        else if ( is_object($data) )
		        {
		            $data->body = $body;
		        }
		    }
		     
		    $this->ci->load->view('templates/'.$tpl_view, $data);
		}

    }