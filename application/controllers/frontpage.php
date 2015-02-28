<?php if (!defined('BASEPATH')) die();
class Frontpage extends Main_Controller {

   public function index()
	{
      // $this->load->view('include/header');
      // $this->load->view('frontpage');
      // $this->load->view('include/footer');
	  	$data = array(
		 
		    'title' => 'Agent Login',
		     
		);
      $this->template->load('default', 'login', $data);
	}
   
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
