<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

   private function create_form()
   {
      $this->load->view('include/header');
      $this->load->view('include/menubar_loggedout');
      $this->load->view('account/create');
      $this->load->view('include/footer');
   }

   private function create_validate()
   {
      /*
         Temporary, do nothing.
      */
   }

   public function create()
   {
      switch ($_SERVER['REQUEST_METHOD']) {
         case 'POST':
            $this->create_validate();
            break;
         case 'GET':
            $this->create_form();
            break;
      }

   }
   

   private function login_form()
   {
      $this->load->view('include/header');
      $this->load->view('include/menubar_loggedout');
      $this->load->view('account/login');
      $this->load->view('include/footer');
   }

   private function login_validate()
   {
      /*
         This is for temporary purposes
      */

      $users = array('sjlu');
      if (in_array($_POST['username'], $users))
      {
         $session_data = array();

         if ($_POST['password'] == 'vblprof')
            $session_data['account'] = 'professor';
         else if ($_POST['password'] == 'vblstud')
            $session_data['account'] = 'student';
         else
            $error = 'Incorrect username and password!'; 

      }
      else
         $error = 'Incorrect username and password!';

      $page_data = array('username' => $_POST['username']);
      if (!empty($error))
      {
         $page_data['error'] = $error;

         $this->load->view('include/header');
         $this->load->view('include/menubar_loggedout');
         $this->load->view('account/login', $page_data);
         $this->load->view('include/footer');
      }
      else
      {
         $session_data['username'] = $_POST['username'];

         $this->load->library('session');
         $this->session->set_userdata($session_data);
         redirect('/', 'refresh');
      }
   }

   public function login()
   {
      switch ($_SERVER['REQUEST_METHOD']) {
         case 'POST':
            $this->login_validate();
            break;
         case 'GET':
            $this->login_form();
            break;
      }
   }

   public function logout()
   {
      $this->load->library('session');
      $this->session->sess_destroy();

      redirect('/', 'refresh');
   }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
