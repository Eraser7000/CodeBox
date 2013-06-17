<h3>Projecten</h3>


<div class = "datagrid">
<?php
	$result = $this->globalfunc->studyprojects($studyid);
	$base = base_url() . "index.php";
	if(count($result) == 0) { echo ("Er zijn geen projecten om weer te geven!"); } else
	{
		echo("<table><tr><th>Project</th><th>Deadline</th><th>Moderatie</th></tr>");
		foreach($result as $row)
		{
			$deadline = $this->globalfunc->getexpireprojectdatafromdb($row->id);
			date_default_timezone_set('Europe/Amsterdam');
			$date = new DateTime();
			$date->setTimestamp($deadline);
			$datedisplay = $date->format('d/m/Y H:i:s');
			//echo("<li><a href='$base/overzicht/userlistbysubject/$studyid/$row->subjectid'>$row->name</a></li>");
			//echo("<tr><td><a href='$base/overzicht/userlistbysubject/$studyid/$row->subjectid'>$row->name</a></td></tr>");
			echo("<tr><td><a href='$base/overzicht/grouplistbyproject/$studyid/$row->id'>$row->Name</a></td><td>$datedisplay</td><td><a href='$base/overzicht/removeproject/$row->id' onclick=\"return confirm('Zeker weten? Alle inhoud van dit project wordt verwijderd!')\" '>Verwijder project</a></td></tr>");
		}
		echo("</table>");
	}
?>
</div>
<br/>
<a href='<?php echo $base; ?>/overzicht/addproject/<?php echo $studyid ?>/'>Nieuw project</a>
<br/><br/>
<input type = "button" name = "ReturnButton" onclick = "history.go(-1);" value="Terug"/>