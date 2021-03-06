<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start(); //we need to call PHP's session object to access it through CI
class Inleveren extends MY_Controller 
{
	//constructs the function
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('user','',TRUE);
		$this->load->model('globalfunc','',TRUE);
		$session_data = $this->session->userdata('logged_in');
		$rolename = $session_data['role'];
		if($rolename == 'administrator' || $rolename == 'docent')
		{
			redirect('home', 'refresh');
		}
	}
	//called when the controller inleveren is being called from index [without any parameters]
	//This gives a list of subjects for the study the person is in.
	function index()
	{
		$data['title'] = "Inleveren";
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$rolename = $session_data['role'];
		$data['rolename'] = $rolename;
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu', $data);
		$result = $this->user->subjects($data['username']);
		$this->load->view('enroledvakken_view', $data);
		$this->load->view('templates/footer', $data);
		redirect('overzicht', 'refresh');
	}
	//Called when the user clicks 'inleveren', this will redirect to the upload screen giving the required parameters to the 
	//uploadfunction to be parsed.
	function vak($subjectid)
	{
		if(is_numeric($subjectid))
		{
			$data['title'] = "Inleveren";
			if(!$this->globalfunc->expiredsubject($subjectid) && $this->globalfunc->subjectexists($subjectid))
			{
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$username = $data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['version'] = 1;
				$isdelivered = $this->user->isalreadysend($username,$subjectid);
				if(!$isdelivered)
				{
					$this->load->view('templates/header', $data);
					$this->load->view('templates/menu', $data);
					$data['subjectid'] = $subjectid;
					$data['error'] = ' ';
					$this->load->view('inleveren_view', $data);
					$this->load->view('templates/footer', $data);
				}
				else
				{
					echo("<script>alert('Al ingeleverd!');</script>");
					redirect('inleveren', 'refresh');
				}
			}
			else
			{
					redirect('inleveren', 'refresh');
			}
		}
		else
		{
			redirect($subjectid, 'refresh');
		}
	}
	function project($projectid)
	{
		if(is_numeric($projectid))
		{
			$data['title'] = "Inleveren";
			if(!$this->globalfunc->expiredproject($projectid) && $this->globalfunc->projectexists($projectid))
			{
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$username = $data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['version'] = 1;
				$isdelivered = $this->globalfunc->projectdelivered($username,$projectid);
				if(!$isdelivered)
				{
					$this->load->view('templates/header', $data);
					$this->load->view('templates/menu', $data);
					$data['projectid'] = $projectid;
					$data['error'] = ' ';
					$this->load->view('inleveren_project_view', $data);
					$this->load->view('templates/footer', $data);
				}
				else
				{
					echo("<script>alert('Al ingeleverd!');</script>");
					redirect('inleveren', 'refresh');
				}
			}
			else
			{
					redirect('inleveren', 'refresh');
			}
		}
		else
		{
			redirect($projectid, 'refresh');
		}
	}
	//Called when the user presses the 'aanpassen' button, which handles the editability of the specific file.
	//It also uploads the new file to its required position.
	function edit($subjectid)
	{
		if(is_numeric($subjectid))
		{
			if(!$this->globalfunc->expiredsubject($subjectid) && $this->globalfunc->subjectexists($subjectid))
			{
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$username = $data['username'];
				$data['title'] = "Aanpassen";
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['version'] = 1;					
				$isdelivered = $this->user->isalreadysend($username,$subjectid);
				if($isdelivered)
				{
					$this->load->view('templates/header', $data);
					$this->load->view('templates/menu', $data);
					$data['subjectid'] = $subjectid;
					$data['error'] = ' ';
					$this->load->view('inleveren_view', $data);
					$this->load->view('templates/footer', $data);
				}
				else
				{
					echo("<script>alert('Hier ging even wat mis, we gaan even terug naar de vorige pagina.');</script>");
					redirect('inleveren', 'refresh');
				}
			}
			else
			{
				redirect('inleveren', 'refresh');
			}
		}
		else
		{
			redirect($subjectid, 'refresh');
		}
	}
	//Called when the user presses the 'aanpassen' button, which handles the editability of the specific file.
	//It also uploads the new file to its required position.
	//The same as the function above, but in this case for projects, which will be updated to the projecttable instead of the usual files table.
	function editproj($groupid, $projectid)
	{
		if(is_numeric($projectid) && is_numeric($groupid))
		{
			if(!$this->globalfunc->expiredproject($projectid) && $this->globalfunc->projectexists($projectid))
			{
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$username = $data['username'];
				$data['title'] = "Aanpassen";
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['version'] = 1;					
				$isdelivered = $this->globalfunc->projectdelivered($groupid,$projectid);
				if($isdelivered)
				{
					$this->load->view('templates/header', $data);
					$this->load->view('templates/menu', $data);
					$data['projectid'] = $projectid;
					$data['error'] = ' ';
					$this->load->view('inleveren_project_view', $data);
					$this->load->view('templates/footer', $data);
				}
				else
				{
					echo("<script>alert('Hier ging even wat mis, we gaan even terug naar de vorige pagina.');</script>");
					redirect('inleveren', 'refresh');
				}
			}
			else
			{
				redirect('inleveren', 'refresh');
			}
		}
		else
		{
			redirect('inleveren', 'refresh');
		}
	}
	//Handles the upload for a project file, this one differs from the one above.
	//Will accept username and project id to create a file containing proj_projectshortname_groupshortname_version
	function project_upload($username,$projectid)
	{
		if(!is_numeric($username) && is_numeric($projectid))
		{
			$data['title'] = "Inleveren";
			if(!$this->globalfunc->expiredproject($projectid) && $this->globalfunc->projectexists($projectid) && $this->user->userexists($username))
			{
				$version = 1;
				$config['upload_path'] = 'files/';
				$config['allowed_types'] = '*';
				$config['max_size']	= '0';
				$data['title'] = 'Inleveren';
				$groupid = $this->user->getgroupidfromuser($username,$projectid);
				$short_project_name = $this->globalfunc->getshortprojectnamefromid($projectid);
				$short_group_name = $this->globalfunc->getshortgroupnamefromid($groupid);
				$fileformat = "proj_" . $short_project_name . "_" . $short_group_name . "_" . $version;
				$result = glob ("files/$fileformat*.*");
				while(count(glob("files/$fileformat.*")) != 0)
				{
					$version++;
					$fileformat = "proj_" . $short_project_name . "_" . $short_group_name . "_" . $version;
				}
				$config['file_name'] = "proj_" . $short_project_name . "_" . $short_group_name . "_" . $version;
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload())
				{
					$data['error'] = $this->upload->display_errors();
					$session_data = $this->session->userdata('logged_in');
					$data['username'] = $session_data['username'];
					$rolename = $session_data['role'];
					$data['rolename'] = $rolename;
					$data['projectid'] = $projectid;
					//$data['version'] = $version;
					$this->load->view('templates/header', $data);
					$this->load->view('templates/menu', $data);
					$this->load->view('inleveren_project_view', $data);
					$this->load->view('templates/footer', $data);
				}
				else
				{
					$uploadarr = $this->upload->data();
					$data['upload_data'] = $this->upload->data();
					$session_data = $this->session->userdata('logged_in');
					$data['username'] = $session_data['username'];
					$rolename = $session_data['role'];
					$data['rolename'] = $rolename;
					$this->load->view('templates/header', $data);
					$this->load->view('templates/menu', $data);
					$this->load->view('inleveren_fin_view', $data);
					$this->load->view('templates/footer', $data);
					$user = $data['username'];
					$file = $uploadarr['full_path'];
					
					$checkquery = $this->db->query("SELECT * FROM project_files WHERE groupid = '$groupid' AND projectid = '$projectid'");
					$querycount = 0;
					$fileid = -1;
					foreach($checkquery->result() as $row)
					{
						$fileid = $row->id;
						$querycount++;
					}
					if($querycount > 0)
					{
						$query = $this->db->query("UPDATE project_files SET location='$file',projectid='$projectid',groupid=$groupid,version='$version',name='$fileformat' WHERE id = '$fileid'");
					}
					else
					{
						$query = $this->db->query("INSERT INTO project_files (location, projectid, groupid, viewed, version, name) VALUES ('$file','$projectid',$groupid,0, '$version', '$fileformat')");
					}
					if(!$query)
					{
						redirect('inleveren', 'refresh');
					}
				}
			}
			else
			{
				redirect('inleveren', 'refresh');
			}
		}
		else
		{
			redirect('inleveren', 'refresh');
		}
	}
	//Handles the upload of the specific file. It also parses the subjectname and username into the file's name.
	//This function also creates a database entry containing specific information of the file.
	function do_upload($subject,$username)
	{
		$data['title'] = "Inleveren";
		if(!$this->globalfunc->expiredsubject($subject) && $this->globalfunc->subjectexists($subject) && $this->user->userexists($username))
		{
			$version = 1;
			$config['upload_path'] = 'files/';
			$config['allowed_types'] = '*';
			$config['max_size']	= '0';
			$data['title'] = 'Inleveren';
			$short_subject_name = $this->globalfunc->getshortsubjectnamefromid($subject);
			$fileowner = $username;
			$splittest = explode('_',$username);
			if($splittest[0] == "admin")
			{
				$fileowner = $splittest[1];
			}
			$fileformat = $short_subject_name . "_" . $fileowner . "_" . $version;
			$result = glob ("files/$fileformat*.*");
			while(count(glob("files/$fileformat.*")) != 0)
			{
				$version++;
				$fileformat = $short_subject_name . "_" . $fileowner . "_" . $version;
			}
			$config['file_name'] = $short_subject_name . "_" . $fileowner . "_" . $version;
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload())
			{
				$data['error'] = $this->upload->display_errors();
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$data['subjectid'] = $subject;
				//$data['version'] = $version;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('inleveren_view', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				$uploadarr = $this->upload->data();
				$data['upload_data'] = $this->upload->data();
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$rolename = $session_data['role'];
				$data['rolename'] = $rolename;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu', $data);
				$this->load->view('inleveren_fin_view', $data);
				$this->load->view('templates/footer', $data);
				$user = $data['username'];
				$file = $uploadarr['full_path'];
				
				$checkquery = $this->db->query("SELECT * FROM files WHERE owner = '$user' AND subjectid = '$subject'");
				$querycount = 0;
				$fileid = -1;
				foreach($checkquery->result() as $row)
				{
					$fileid = $row->id;
					$querycount++;
				}
				if($querycount > 0)
				{
					$query = $this->db->query("UPDATE files SET location='$file',owner='$user',subjectid='$subject',version='$version',name='$fileformat' WHERE id = '$fileid'");
				}
				else
				{
					$query = $this->db->query("INSERT INTO files (location, owner, subjectid, viewed, version, name) VALUES ('$file','$user','$subject',0, '$version', '$fileformat')");
				}
				if(!$query)
				{
					redirect('inleveren', 'refresh');
				}
			}
		}
		else
		{
			redirect('inleveren', 'refresh');
		}
	}
}

?>