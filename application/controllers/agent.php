<?php if (!defined('BASEPATH')) die();
class Agent extends Agent_Controller {

    public function index()
	{
      // $this->load->view('include/header');
      // $this->load->view('frontpage');
      // $this->load->view('include/footer');
	  $data = array(
		'title' => 'Agent Dashboard',	     
	  );

      $this->template->load('agent', 'agent/index', $data);
	}

	public function network()
	{
		// @start snippet
		include 'Services/Twilio/Capability.php';

		$accountSid = 'ACb5698fa310df3dd9c06aee561e56fca2';
		$authToken  = '95839b52989b9edc2dfbf80ddde6ac7f';

		$token = new Services_Twilio_Capability($accountSid, $authToken);
		$token->allowClientOutgoing('AP8c670af01a3f7b08a49ec96d63bd671f');
		$token->allowClientIncoming("JP05111987");
		// @end snippet

		$data = array(
			'title' => 'Agent Dashboard',
			'twtoken' => $token->generateToken(),
		);

		$this->load->view('agent/network.phtml',$data);
	}
   
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
