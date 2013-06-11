<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyActivation extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('user','',TRUE);
		$this->load->model('role','',TRUE);
	}
	//Handles the activation form.
	function index()
	{
		$this->load->library('form_validation');
	    $this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean|min_length[5]|max_length[20]|matches[passwordconfirm]');
	    $this->form_validation->set_rules('passwordconfirm', 'passwordconfirm', 'trim|required|xss_clean|min_length[5]|max_length[20]|callback_updateuser');
	    $this->form_validation->set_message('required', '');
	    $this->form_validation->set_message('min_length', 'Minimale lengte is 5 tekens!');
	    $this->form_validation->set_message('max_length', 'Maximale lengte is 20 tekens!');
	    $this->form_validation->set_message('matches', 'Wachtwoorden komen niet overeen!');
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('activate_view');
		}
		else
		{
			echo("<script>alert('Wachtwoord ingesteld, je kunt nu inloggen op CodeBox!');</script>");
			$this->session->unset_userdata('logged_in');
			session_destroy();
			redirect('login', 'refresh');
		}
	}
	//Updates the user in the database
	function updateuser($password)
	{
		$session_data = $this->session->userdata('logged_in');
		$username = $session_data['username'];
		//$this->session->set_userdata('activated',1);
		$this->user->activateaccount($username,$password);
	}
}
?>