<h3>Download project-bestand:</h3>

<div>
<?php
	if($rolename == 'docent' || $rolename == "administrator")
	{
		$this->load->helper('download');
		$path = 'files';
		$short_project_name = $this->globalfunc->getshortprojectnamefromid($projectid);
		$short_group_name = $this->globalfunc->getshortgroupnamefromid($groupid);
		$fileformat = "proj_" . $short_project_name . "_" . $short_group_name . "_";
		$result = glob ("$path/$fileformat*.*");
		$version = 1;
		foreach($result as $row)
		{
			$str = explode('_',$row);
			$version = $str[3];
		}
		$fileformat = "proj_" . $short_project_name . "_" . $short_group_name . "_" . $version;
		var_dump("$path/".$fileformat);
		var_dump($ext);
		if(file_exists("$path/$fileformat"))
		{
			$data = file_get_contents("$path/" . $fileformat);
			$name = $fileformat;
			force_download($name, $data);
			ob_clean();
			exit($data);
		}
		else
		{
			echo("Oeps dit bestand bestaat niet!");
		}
	}
?>
</div>

<br/>
<input type = "button" name = "ReturnButton" onclick = "history.go(-1);" value="Terug"/>