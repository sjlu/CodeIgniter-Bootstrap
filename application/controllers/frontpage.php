<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontpage extends CI_Controller {

   private function loggedin_index()
   {
      $this->load->view('include/header');
      $this->load->view('include/menubar_loggedin');
		$this->load->view('dashboard');
      $this->load->view('include/footer');
   }

   private function loggedout_index()
   {
      $this->load->view('include/header');
      $this->load->view('include/menubar_loggedout');
      $this->load->view('frontpage');
      $this->load->view('include/footer');
   }

   public function index()
	{
      $this->load->library('session');
      if ($this->session->userdata('username'))
         $this->loggedin_index();
      else
         $this->loggedout_index();
	}

}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
