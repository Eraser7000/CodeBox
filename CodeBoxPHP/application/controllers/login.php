<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Login extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('user','',true);
	}
	//Loads the view containing the required fields to log in.
	//This function also checks if LDAP is available or not for the user.
	function index()
	{
		if(!$this->session->userdata("logged_in"))
		{
			$this->load->model('user','',TRUE);
			$this->load->helper(array('form'));
			$this->load->view('login_view',array('available' => _useLDAP_));
		}
		else
		{
			redirect('home', 'refresh');
		}
	}
}
?>
