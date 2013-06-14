<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Activate extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->activated_check();
	}
	function index()
	{
		if($this->session->userdata('logged_in') && !_useLDAP_)
		{
			$this->load->helper(array('form'));
			$this->load->view('activate_view');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	//Checks whetever the registered user is activated or not.
	function activated_check()
	{
		if($this->session->userdata('logged_in') && !_useLDAP_)
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['activated'] == "ja")
			{
				redirect('home','refresh');
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
}