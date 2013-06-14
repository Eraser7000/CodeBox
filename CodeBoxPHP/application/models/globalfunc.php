<?php
Class Globalfunc extends CI_Model
{
	//Gets all studies from the database [local]
	function studies()
	{
		$query = $this->db->query("SELECT id, name FROM study ORDER BY name ASC");
		return $query->result();
	}
	//Returns name of a study by its unique id.
	function getstudynamefromid($studyid)
	{
		$query = $this->db->query("SELECT name FROM study WHERE id = '$studyid'");
		foreach($query->result() as $row)
		{
			return $row->name;
		}
	}
	//Returns name of a group by its unique id.
	function getgroupnamefromid($groupid)
	{
		$query = $this->db->query("SELECT name FROM groups WHERE id = '$groupid'");
		foreach($query->result() as $row)
		{
			return $row->name;
		}
	}
	//Checks if a file for a project is send or not.
	function projectdelivered($groupid,$projectid)
	{
		//$this->load->model('globalfunc','',TRUE);
		$short_project_name = $this->getshortprojectnamefromid($projectid);
		$short_group_name = $this->getshortgroupnamefromid($groupid);

		$filename = "proj_" . $short_project_name . "_" . $short_group_name . "_";
		$result = glob("files/$filename*.*");
		if(count($result) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//Returns the name of a project from the database according to its ID
	function getprojectnamefromid($projectid)
	{
		$query = $this->db->query("SELECT Name FROM project WHERE id = '$projectid'");
		foreach($query->result() as $row)
		{
			return $row->Name;
		}		
	}
	//Returns ID of a study by its name
	function getstudyidfromname($studyname)
	{
		$query = $this->db->query("SELECT id FROM study WHERE name = '$studyname'");
		foreach($query->result() as $row)
		{
			return $row->id;
		}
	}
	/*
	function getstudentnamefromid($studentid)
	{
		$query = $this->db->query("SELECT username FROM users WHERE id = '$studentid'");
		foreach($query->result() as $row)
		{
			return $row->username;
		}
	}*/
	//Gets subjectname from the database providing the unique id.
	function getsubjectnamefromid($subjectid)
	{
		$query = $this->db->query("SELECT name FROM subject WHERE subjectid = '$subjectid'");
		foreach($query->result() as $row)
		{
			return $row->name;
		}
	}
	//Checks if a subject is expired or not.
	function expiredsubject($subjectid)
	{
		if($this->todaydateindbformat() >= $this->getexpiredatafromdb($subjectid))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//Checks if a project is expired or not.
	function expiredproject($projectid)
	{
		if($this->todaydateindbformat() >= $this->getexpireprojectdatafromdb($projectid))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//Checks if a subject exists in our local database.
	function subjectexists($subjectid)
	{
		$query = $this->db->query("SELECT * FROM subject WHERE subjectid = '$subjectid'");
		$count = count($query->result());
		if($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//Checks if a project exists in our local database.
	function projectexists($projectid)
	{
		$query = $this->db->query("SELECT * FROM project WHERE id = '$projectid'");
		$count = count($query->result());
		if($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//Deletes all subjects from the database.
	function deleteallsubjects()
	{
		$query = $this->db->query("DELETE FROM subject");
	}
	//Deletes a specific subject
	function deletesubject($subjectid)
	{
		$query = $this->db->query("DELETE FROM files WHERE subjectid = '$subjectid'");
		$query2 = $this->db->query("DELETE FROM subject WHERE subjectid = '$subjectid'");
	}
	//Adds a project to the db.
	function addgroup($projectid,$groupname)
	{
		$shortname = str_replace(' ','',$groupname);
		$shortname = str_replace('_','',$groupname);
		$query = $this->db->query("INSERT INTO groups (name,shortname,projectid) VALUES ('$groupname','$shortname','$projectid') ");
	}
	//Adds a user to a group in the db.
	function addusertogroup($groupid,$username)
	{
		$query = $this->db->query("INSERT INTO groupenrole (username,groupid) VALUES ('$username','$groupid') ");
	}
	//Removes a user from a group in the db.
	function deleteuserfromgroup($groupid,$username)
	{
		$query = $this->db->query("DELETE FROM groupenrole WHERE username ='$username' AND groupid = '$groupid'");
	}
	//Deletes a group including its content
	function deletegroup($groupid)
	{
		$query = $this->db->query("DELETE FROM groups WHERE id = '$groupid'");
		$query = $this->db->query("DELETE FROM groupenrole WHERE groupid = '$groupid'");
	}
	//Adds a project to the db.
	function addproject($studyid,$projectname,$timestamp)
	{
		$shortname = str_replace(' ','',$projectname);
		$shortname = str_replace('_','',$projectname);
		$query = $this->db->query("INSERT INTO project (name,shortname,studyid,expire) VALUES ('$projectname','$shortname','$studyid','$timestamp') ");
	}
	//Deletes a project, including its content in the database.
	function deleteproject($projectid)
	{
		$query = $this->db->query("SELECT * FROM groups WHERE projectid = '$projectid'");
		foreach($query->result() as $row)
		{
			$this->deletegroup($row->id);
		}
		$query = $this->db->query("DELETE FROM project WHERE id = '$projectid'");
	}
	//Deletes a file
	function deletefile($user,$subjectid)
	{
		$query = $this->db->query("SELECT * FROM users,subject WHERE subject.subjectid = '$subjectid' AND users.username = '$user'");
		$fileformat = "";
		foreach($query->result() as $row)
		{
			$shortname = $row->Shortname;
			$fileformat = $shortname . "_" . $user . "_";
 			break;
		}
		$path = 'files/';
		$files = glob($path.$fileformat.'*'); // get all file names
    	foreach($files as $file)
    	{ // iterate files
      		if(is_file($file))
      		{
        		unlink($file);
        	}
    	} 
    	$query = $this->db->query("DELETE FROM files WHERE name like '$fileformat%'");
	}
	//Deletes a projectfile
	function deleteprojectfile($projectid,$groupid)
	{
		$query = $this->db->query("SELECT project.SHORTNAME, groups.shortname FROM project,groups WHERE project.id = groups.projectid AND project.id = '$projectid' AND groups.id = '$groupid'");
		$fileformat = "";
		foreach($query->result() as $row)
		{
			$project_short_name = $row->SHORTNAME;
			$group_short_name = $row->shortname;
			$fileformat = "proj_" . $project_short_name . "_" . $group_short_name . "_";
 			break;
		}
		$path = 'files/';
		$files = glob($path.$fileformat.'*'); // get all file names
    	foreach($files as $file)
    	{ // iterate files
      		if(is_file($file))
      		{
        		unlink($file);
        	}
    	} 
    	$query = $this->db->query("DELETE FROM project_files WHERE name like '$fileformat%'");
	}
	//Returns a nice list of groupmembers belonging to a group
	function projectgroupmembers($groupid)
	{
		$query = $this->db->query("SELECT * FROM groupenrole WHERE groupid = '$groupid'");
		return $query->result();
	}
	//Checks if a study exists in our local database.
	function studyexists($studyid)
	{
		$query = $this->db->query("SELECT * FROM study WHERE id = '$studyid'");
		$count = 0;
		foreach($query->result() as $row)
		{
			$count++;
		}
		if($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//Checks if a group actually exists, this is used to prevent vague groups from being created
	function groupexists($groupid)
	{
		$query = $this->db->query("SELECT * FROM groups WHERE id = '$groupid'");
		$count = count($query->result());
		if($count > 0)
		{
			return true;
		}
		return false;
	}
	//Returns the shortname of a subject from the database.
	function getshortsubjectnamefromid($subjectid)
	{
		$query = $this->db->query("SELECT shortname FROM subject WHERE subjectid = '$subjectid'");
		foreach($query->result() as $row)
		{
			return $row->shortname;
		}
	}
	//Returns the shortname of a project from the database.
	function getshortprojectnamefromid($projectid)
	{
		$query = $this->db->query("SELECT shortname FROM project WHERE id = '$projectid'");
		foreach($query->result() as $row)
		{
			return $row->shortname;
		}
	}
	//Returns the shortname of a group from the database.
	function getshortgroupnamefromid($groupid)
	{
		$query = $this->db->query("SELECT shortname FROM groups WHERE id = '$groupid'");
		foreach($query->result() as $row)
		{
			return $row->shortname;
		}
	}
	//Today's date, rather useless, because time() does the same, whoopsie!
	function todaydateindbformat()
	{
		date_default_timezone_set('Europe/Amsterdam');
		$date = date('d-m-Y h:i:s a', time());
		$ts2 = date_create($date)->format('U');
		return $ts2;
	}
	//Returns the expiration date of a subject from the local database.
	function getexpiredatafromdb($subjectid)
	{
		$query = $this->db->query("SELECT expire FROM subject WHERE subjectid = '$subjectid' LIMIT 1");
		foreach($query->result() as $row)
		{
			return $row->expire;
		}
		return -1;
	}
	//Returns the expiration date of a project from the local database.
	function getexpireprojectdatafromdb($projectid)
	{
		$query = $this->db->query("SELECT expire FROM project WHERE id = '$projectid' LIMIT 1");
		foreach($query->result() as $row)
		{
			return $row->expire;
		}
		return -1;
	}
	//Returns all subjects from a specific study.
	function studysubjects($studyid)
	{
		$query = $this->db->query("SELECT subjectid,name FROM subject WHERE studyid = '$studyid' ORDER BY name");
		return $query->result();
	}
	//Returns all groups from a specific project.
	function projectgroups($projectid)
	{
		$query = $this->db->query("SELECT * FROM groups WHERE projectid = '$projectid' ORDER BY Name");
		return $query->result();
	}
	//Returns all projects from a specific study.
	function studyprojects($studyid)
	{
		$query = $this->db->query("SELECT * FROM project WHERE studyid = '$studyid' ORDER BY name");
		return $query->result();
	}
	//Returns all students of a specific study.
	function students($studyid)
	{
		$query = $this->db->query("SELECT username,fullname FROM users WHERE studyid = '$studyid' ORDER BY username ASC");
		return $query->result();
	}
	//Returns all students having a specified subject.
	function getstudentsinsubject($studyid,$subjectid)
	{
		$query = $this->db->query("SELECT username,fullname FROM users,subject WHERE users.studyid = '$studyid' AND subject.subjectid = '$subjectid'  ORDER BY username");
		return $query->result();		
	}
	//Cleans up useless database entries. Such as non-existing files.
	function cleanupdbentries()
	{
		$query = $this->db->query("SELECT * FROM files");
		foreach($query->result() as $row)
		{
			$filename = $row->name;
			$count = 0;
			$result = glob ("files/$filename*.*");
			foreach($result as $row2)
			{
				$count++;
			}
			if($count == 0)
			{
				$query = $this->db->query("DELETE FROM files WHERE name = '$row->name'");
			}
		}
		$query2 = $this->db->query("SELECT * FROM project_files");
		foreach($query2->result() as $row)
		{
			$filename = $row->name;
			$count = 0;
			$result = glob ("files/$filename*.*");
			foreach($result as $row2)
			{
				$count++;
			}
			if($count == 0)
			{
				$query = $this->db->query("DELETE FROM project_files WHERE name = '$row->name'");
			}
		}
	}
}
?>