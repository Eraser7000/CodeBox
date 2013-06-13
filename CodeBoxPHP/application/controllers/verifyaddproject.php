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
	    $this->form_validation->set_message('required', 'Projectnaam vereist!');
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
			$this->globalfunc->addproject($studyid,$projectname);
			echo("<script>alert('Project toegevoegd!');</script>");
			echo("<script>history.go(-2);</script>");
			//redirect('overzicht', 'refresh');
		}
	}
}
?>