<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Overzicht extends MY_Controller 
{
	//constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('globalfunc','',TRUE);
		$this->load->model('user','',TRUE);
		$this->load->helper(array('form'));
	}
	//Calls the primary view, which handles the screen for the 'docent' and the 'student', and loading the views accordingly.
	function index()
	{
		$data['title'] = "Overzicht";
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$rolename = $session_data['role'];
		$data['rolename'] = $rolename;
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu', $data);
		if($rolename != 'student' && $rolename != 'gast')
		{
			$this->load->view('overzicht_docent_view', $data);
		}
		else
		{
			$date = new DateTime();
			$date->setTimestamp($this->globalfunc->todaydateindbformat());
			$data['datenow'] = $date->format('d/m/Y H:i:s');
			$this->load->view('overzicht_student_view', $data);
		}
		$this->load->view('templates/footer', $data);
	}
	//Mails all users of a subject who have not delivered their package on this site yet.
	function mailusers($subjectid)
	{
		if($this->globalfunc->subjectexists($subjectid))
		{
			$data['title'] = "Email";
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['subjectid'] = $subjectid;
				$data['rolename'] = $rolename;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('email_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
		else
		{
			redirect('overzicht','refresh');
		}
	}
	//Function which handles the overviewtype for the teacher accordingly to his/her choice.
	function choice($studyid)
	{
		if(is_numeric($studyid) && $this->globalfunc->studyexists($studyid))
		{
			$data['title'] = "Overzicht - " . $this->globalfunc->getstudynamefromid($studyid);
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['studyid'] = $studyid;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				//$this->load->view('overzicht_students_view', $data);
				$this->load->view('overzicht_docentch_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
		else
		{
			redirect('overzicht', 'refresh');
		}
	}
	//Loads a list of groups belonging to a specific project
	function grouplistbyproject($studyid,$projectid)
	{
		if(is_numeric($studyid) && is_numeric($projectid) && $this->globalfunc->studyexists($studyid) && $this->globalfunc->projectexists($projectid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['title'] = "Overzicht - " . $this->globalfunc->getstudynamefromid($studyid) . " - " . $this->globalfunc->getprojectnamefromid($projectid);
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['studyid'] = $studyid;
				$data['projectid'] = $projectid;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('overzicht_groep_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
		else
		{
			redirect('overzicht', 'refresh');
		}
	}
	//Function to add users to the specified group.
	function addusertogroup($studyid,$projectid,$groupid)
	{
		if(is_numeric($studyid) && is_numeric($groupid) && $this->globalfunc->studyexists($studyid) && $this->globalfunc->projectexists($projectid) && $this->globalfunc->groupexists($groupid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['title'] = "Project toevoegen";
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['studyid'] = $studyid;
				$data['projectid'] = $projectid;
				$data['groupid'] = $groupid;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('overzicht_addusertogroup_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
	}
	//Function to create new groups for the specified project.
	function addgroup($studyid,$projectid)
	{
		if(is_numeric($studyid) && is_numeric($projectid) && $this->globalfunc->studyexists($studyid) && $this->globalfunc->projectexists($projectid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['title'] = "Project toevoegen";
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['studyid'] = $studyid;
				$data['projectid'] = $projectid;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('overzicht_addgroup_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
	}
	//Function to create new projects for the teacher.
	function addproject($studyid)
	{
		if(is_numeric($studyid) && $this->globalfunc->studyexists($studyid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['title'] = "Project toevoegen";
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['studyid'] = $studyid;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('overzicht_addproject_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
	}
	//Function to remove projects from the db.
	function removeproject($projectid)
	{
		if(is_numeric($projectid) && $this->globalfunc->projectexists($projectid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['title'] = "Project verwijderen";
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->globalfunc->deleteproject($projectid);
				$this->load->view('templates/footer', $data);
				echo("<script>alert('Project verwijderd!');history.go(-1);</script>");
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
	}
	//Function to remove users from a group in the db.
	function removeuserfromgroup($groupid, $username)
	{
		if(is_numeric($groupid) && !is_numeric($username) && $this->user->isuseringroup($username,$groupid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['title'] = "Project verwijderen";
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->globalfunc->deleteuserfromgroup($groupid,$username);
				$this->load->view('templates/footer', $data);
				echo("<script>alert('Leerling verwijderd!');history.go(-1);</script>");
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
	}
	//Function to delete a group from a project.
	function removegroup($groupid)
	{
		if($this->globalfunc->groupexists($groupid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['title'] = "Groep verwijderen";
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->globalfunc->deletegroup($groupid);
				$this->load->view('templates/footer', $data);
				echo("<script>history.go(-1);</script>");
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
	}
	//Loads a list containing all projects for the specified study.
	function projects($studyid)
	{
		if(is_numeric($studyid) && $this->globalfunc->studyexists($studyid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['title'] = "Overzicht - " . $this->globalfunc->getstudynamefromid($studyid);
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['studyid'] = $studyid;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('overzicht_project_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
		else
		{
			redirect('overzicht', 'refresh');
		}
	}
	//Loads a list of members belonging to a group in a project [simplicity himself!]
	function projectmembers($studyid,$projectid,$groupid)
	{
		if(is_numeric($studyid) && is_numeric($projectid) && is_numeric($groupid) && $this->globalfunc->studyexists($studyid) && $this->globalfunc->projectexists($projectid) && $this->globalfunc->groupexists($groupid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['title'] = "Overzicht - " . $this->globalfunc->getstudynamefromid($studyid) . " - " . $this->globalfunc->getprojectnamefromid($projectid) . " - " . $this->globalfunc->getgroupnamefromid($groupid);
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['studyid'] = $studyid;
				$data['projectid'] = $projectid;
				$data['groupid'] = $groupid;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('overzicht_grouplist_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
		else
		{
			redirect('overzicht', 'refresh');
		}	
	}
	//Loads a list containing all students for the specified study.
	function studentlist($studyid)
	{
		if(is_numeric($studyid) && $this->globalfunc->studyexists($studyid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['title'] = "Overzicht - " . $this->globalfunc->getstudynamefromid($studyid);
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['studyid'] = $studyid;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('overzicht_students_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
		else
		{
			redirect('overzicht', 'refresh');
		}
	}
	//Loads all information of a student in the specified study. This checks if the user has delivered his stuff or not.
	function student($studyid,$studentname)
	{
		if(is_numeric($studyid) && $this->user->userexists($studentname) && $this->globalfunc->studyexists($studyid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['student_full_name'] = $this->user->getfullnamefromdb($studentname);
				$data['title'] = "Overzicht - " . $this->globalfunc->getstudynamefromid($studyid) . " / " . $data['student_full_name'];
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['studyid'] = $studyid;
				$data['studentname'] = $studentname;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('overzicht_subjects_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
		else
		{
			redirect('overzicht', 'refresh');
		}
	}
	//Loads an overview of all subjects for the specified study.
	function subjectlist($studyid)
	{
		if(is_numeric($studyid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['title'] = "Overzicht - " . $this->globalfunc->getstudynamefromid($studyid);
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['studyid'] = $studyid;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('overzicht_subjectlist_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
		else
		{
			redirect('overzicht', 'refresh');
		}
	}
	//Loads all users of a specified subject in the specified study.
	function userlistbysubject($studyid,$subjectid)
	{	
		if(is_numeric($studyid) && is_numeric($subjectid) && $this->globalfunc->subjectexists($subjectid) && $this->globalfunc->studyexists($studyid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] != "student" && $session_data['role'] != "gast")
			{
				$data['subject_name'] = $this->globalfunc->getsubjectnamefromid($subjectid);
				$data['title'] = "Overzicht - " . $this->globalfunc->getstudynamefromid($studyid) . " / " .  $data['subject_name'];
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['studyid'] = $studyid;
				$data['subjectid'] = $subjectid;
				$data['short_subject_name'] = $this->globalfunc->getshortsubjectnamefromid($subjectid);
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('overzicht_userspersubject_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
		else
		{
			redirect('overzicht', 'refresh');
		}
	}
	//Redirects to the downloadpage where the teacher is able to download the specified file.
	function subject($studyid,$studentname,$subjectid)
	{
		if(is_numeric($studyid) && !is_numeric($studentname) && is_numeric($subjectid) && $this->globalfunc->subjectexists($subjectid) && $this->globalfunc->studyexists($studyid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] == "docent" || $session_data['role'] == "administrator")
			{
				$data['student_full_name'] = $this->user->getfullnamefromdb($studentname);
				$data['subject_name'] = $this->globalfunc->getsubjectnamefromid($subjectid);
				$data['title'] = "Overzicht - " . $this->globalfunc->getstudynamefromid($studyid) . " / " . $data['student_full_name'] . " / " . $data['subject_name'];
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['studyid'] = $studyid;
				$data['studentname'] = $studentname;
				$data['subjectid'] = $subjectid;
				$data['short_subject_name'] = $this->globalfunc->getshortsubjectnamefromid($subjectid);
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('overzicht_download_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
		else
		{
			redirect('overzicht', 'refresh');
		}
	}
	//Redirects to the downloadpage where the teacher is able to download the project file.
	function download_projectfile($projectid,$groupid)
	{
		if(is_numeric($projectid) && is_numeric($groupid) && $this->globalfunc->projectexists($projectid) && $this->globalfunc->groupexists($groupid))
		{
			$session_data = $this->session->userdata('logged_in');
			if($session_data['role'] == "docent" || $session_data['role'] == "administrator")
			{
				$data['title'] = "Overzicht - Download";
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['projectid'] = $projectid;
				$data['groupid'] = $groupid;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('overzicht_download_proj_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				redirect('home', 'refresh');
			}
		}
		else
		{
			redirect('overzicht', 'refresh');
		}
	}
}

?>