<?php if (!defined('BASEPATH')) die();
class Frontpage extends Main_Controller {

   public function index()
	{

	  $data['js'] = array(
	  						'bootstrap-min' => 'assets/js/bootstrap.min.js',
	  						'custom' => 'assets/js/custom.js'
	  					);

      $this->load->view('include/header');
      $this->load->view('frontpage');
      $this->load->view('include/footer', $data);
	}
   
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */