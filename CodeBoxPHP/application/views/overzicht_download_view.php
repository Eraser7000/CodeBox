<h3>Download bestand:</h3>

<div>
<?php
	if($rolename == 'docent' || $rolename == "administrator")
	{
		$studentvar = $studentname;
		$adminvar = explode('_',$studentvar);
		$path = 'files';
		if($adminvar[0] == "admin")
		{
			$studentvar = $adminvar[1];
		}
		$this->load->helper('download');
		$fileformat = $short_subject_name . "_" . $studentvar . "_";
		$result = glob ("$path/$fileformat*.*");
		$version = 1;
		foreach($result as $row)
		{
			$str = explode('_',$row);
			$version = $str[2];
		}
		$fileformat = $short_subject_name . "_" . $studentvar . "_" . $version;
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