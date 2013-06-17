<h3>Selecteer groep:</h3>

<div class = "datagrid">
<?php 
	$result = $this->globalfunc->projectgroupmembers($groupid);
	$count = count($result);
	$base = base_url() . "index.php";
	if($count == 0)
	{
		echo("Geen studenten gevonden voor deze groep!");
	}
	else
	{
		echo("<table><tr><th>Groepleden</th><th>Moderatie</th></tr>");
		foreach($result as $row)
		{
			$fullname = $this->user->getfullnamefromdb($row->username);
			//echo("<tr><td><a href='$base" . "/overzicht/projectmembers/$studyid/$projectid/$row->id'>$row->Name</a></td></tr>");
			echo("<tr><td>$fullname</td><td><a href='$base/overzicht/removeuserfromgroup/$groupid/$row->username' onclick = \"return confirm ('Zeker weten dat u deze leerling uit deze groep wilt verwijderen?');\">Verwijderen</a></td></tr>");
		}
		echo("</table>");
	}
?>
</div>
<br/>
<a href='<?php echo $base ?>/overzicht/addusertogroup/<?php echo $studyid . '/' . $projectid . "/" . $groupid ?>/'>Leerling toevoegen</a>
<br/>
<br/>
<input type = "button" name = "ReturnButton" onclick = "history.go(-1);" value="Terug"/>