<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//define('_useLDAP_',false);

class VerifyAddProject extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('globalfunc','',TRUE);
		$this->load->model('user','',TRUE);
	}
	function index()
	{
		//
	}
	//Handles the add projectfunction.
	function handleuser($studyid,$projectid,$groupid)
	{
		$this->load->library('form_validation');
	    $this->form_validation->set_rules('usernameoptions', 'usernameoptions', 'required|xss_clean|callback_is_user');
	    $this->form_validation->set_message('required', 'Leerling vereist!');
	    $this->form_validation->set_error_delimiters('', '');
	    $session_data = $this->session->userdata('logged_in');
	    $data['title'] = "Leerling toevoegen:";
	    $data['studyid'] = $studyid;
	    $data['projectid'] = $studyid;
	    $data['groupid'] = $groupid;
 		if($this->form_validation->run() == FALSE)
		{
			$data['username'] = $session_data['username'];
			$rolename = $session_data['role'];
			$data['rolename'] = $rolename;
			$this->load->view('templates/header', $data);
			$this->load->view('templates/menu', $data);
			//$this->load->view('overzicht_students_view', $data);
			$this->load->view('overzicht_addusertogroup_view',$data); //$this->user->ldapavailable()
			$this->load->view('templates/footer', $data);
		}
		else
		{
			$username = $this->input->post('usernameoptions');
			if($this->user->getgroupidfromuser($username,$projectid) == -1)
			{
				$this->globalfunc->addusertogroup($groupid,$username);
				echo("<script>alert('Leerling toegevoegd!');</script>");
				echo("<script>history.go(-2);</script>");
			}
			else
			{
				echo("<script>alert('Leerling niet toegevoegd! Deze leerling zit al in een andere groep van dit project!');</script>");
				echo("<script>history.go(-1);</script>");				
			}
			//redirect('overzicht', 'refresh');
		}
	}
	//Checks if the specified user exists
	function is_user($username)
	{
		if(!$this->user->userexitsindatabase($username))
		{
			$this->form_validation->set_message('is_user', 'Gebruiker bestaat niet!');
			return false;
		}
		else
		{
			return true;
		}
	}
	//Handles the add projectfunction.
	function handlegroup($studyid,$projectid)
	{
		$this->load->library('form_validation');
	    $this->form_validation->set_rules('groupname', 'groupname', 'trim|required|xss_clean');
	    $this->form_validation->set_message('required', 'Groepnaam vereist!');
	    $this->form_validation->set_error_delimiters('', '');
	    $session_data = $this->session->userdata('logged_in');
	    $data['title'] = "Project toevoegen:";
	    $data['studyid'] = $studyid;
	    $data['projectid'] = $projectid;
 		if($this->form_validation->run() == FALSE)
		{
			$data['username'] = $session_data['username'];
			$rolename = $session_data['role'];
			$data['rolename'] = $rolename;
			$this->load->view('templates/header', $data);
			$this->load->view('templates/menu', $data);
			//$this->load->view('overzicht_students_view', $data);
			$this->load->view('overzicht_addgroup_view',$data); //$this->user->ldapavailable()
			$this->load->view('templates/footer', $data);
		}
		else
		{
			$groupname = $this->input->post('groupname');
			$this->globalfunc->addgroup($projectid,$groupname);
			echo("<script>alert('Groep toegevoegd!');</script>");
			echo("<script>history.go(-2);</script>");
			//redirect('overzicht', 'refresh');
		}
	}
	//Handles the add projectfunction.
	function handleproject($studyid)
	{
		$this->load->library('form_validation');
	    $this->form_validation->set_rules('projectname', 'projectname', 'trim|required|xss_clean');
	    $this->form_validation->set_rules('expiredate', 'expiredate', 'trim|required|xss_clean|callback_is_valid_date');
	    $this->form_validation->set_rules('expiretime', 'expiretime', 'trim|required|xss_clean|callback_is_valid_time');
	    $this->form_validation->set_message('required', '');
	    $this->form_validation->set_message('is_valid_date', 'Datum is onjuist [formaat: dag/maand/jaar, let op, de eeste 2 stukken moeten 2 getallen groot zijn, dus 02/02/2010 is goed, 2/2/2010 is fout]');
	    $this->form_validation->set_message('is_valid_time', 'Tijd is onjuist [formaat: uur:minuut:seconden');
	    $this->form_validation->set_error_delimiters('', '');
	    $session_data = $this->session->userdata('logged_in');
	    $data['title'] = "Project toevoegen:";
	    $data['studyid'] = $studyid;
 		if($this->form_validation->run() == FALSE)
		{
			$data['username'] = $session_data['username'];
			$rolename = $session_data['role'];
			$data['rolename'] = $rolename;
			$this->load->view('templates/header', $data);
			$this->load->view('templates/menu', $data);
			//$this->load->view('overzicht_students_view', $data);
			$this->load->view('overzicht_addproject_view',$data); //$this->user->ldapavailable()
			$this->load->view('templates/footer', $data);
		}
		else
		{
			$projectname = $this->input->post('projectname');
			$timestamp = strtotime($this->input->post('expiredate') . " " . $this->input->post('expiretime'));
			$this->globalfunc->addproject($studyid,$projectname,$timestamp);
			echo("<script>alert('Project toegevoegd!');</script>");
			echo("<script>history.go(-2);</script>");
			//redirect('overzicht', 'refresh');
		}
	}
	//Checks if the provided date is valid
	function is_valid_date()
	{
		/*
		$date = $this->input->post('expiredate');
		$datep = explode('/',$date);
		if(count($datep) == 3)
		{
			var_dump($datep);
			return checkdate(intval($date[1]), intval($date[0]), intval($date[2])); //the other way around, because Americans cannot create valid dates :P
		}
		$datep = explode('-',$date);
		if(count($datep) == 3)
		{
			var_dump($datep);
			return checkdate(intval($date[1]), intval($date[0]), intval($date[2]));
		}*/

		$date_format = 'd-m-Y';
		$input = $this->input->post('expiredate');

		$input = trim($input);
		$time = strtotime($input);
		if(date($date_format, $time) == $input)
		{
			return true;
		}
		else
		{
			return false;
		}
		//return false;
	}
	//Checks if the provided time is valid
	function is_valid_time()
	{
		$time = $this->input->post('expiretime');
		$time = explode(':',$time);
		if(count($time) == 3)
		{
			if(intval($time[0]) >= 0 && intval($time[0]) < 24 && intval($time[1]) < 60 && intval($time[1]) >= 0 && intval($time[2]) < 60 && intval($time[2]) >= 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else if(count($time) == 2)
		{
			if(intval($time[0]) >= 0 && intval($time[0]) < 24 && intval($time[1]) < 60 && intval($time[1]) >= 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		return false;
	}
}
?>