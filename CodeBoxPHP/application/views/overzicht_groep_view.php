<h3>Selecteer groep:</h3>

<div class = "datagrid">
<?php 
	$result = $this->globalfunc->projectgroups($projectid);
	$count = count($result);
	$base = base_url() . "index.php";
	if($count == 0)
	{
		echo("Geen groepen voor dit project!");
	}
	else
	{
		echo("<table border='1'><tr><th>Groep</th><th>Moderatie</th><th>Download</th><th>Deadline</th></tr>");
		foreach($result as $row)
		{
			$delivered = $this->globalfunc->projectdelivered($row->id,$projectid);
			$expired = $this->globalfunc->expiredproject($projectid);
			$basecss = base_url();
			$deadlinetxt = "";
			if(!$expired)
			{
				$deadlinetxt = "Actief";
			}
			else
			{
				$deadlinetxt = "Verlopen";
			}
			if($delivered)
			{
				echo("<tr><td><a href='$base" . "/overzicht/projectmembers/$studyid/$projectid/$row->id'>$row->Name</a></td><td><a href='$base" . "/overzicht/removegroup/$row->id' onclick=\"return confirm ('Zeker weten dat u deze groep wilt verwijderen?');\">Verwijderen</a></td><td><a href='$base/overzicht/download_projectfile/$projectid/$row->id'>Download</a></td><td>$deadlinetxt</td></tr>");
			}
			else
			{
				//echo("<img src='$basecss/images/notdone.jpg' alt='Niet Voldaan'> Nog niet ingeleverd.<br/>");
				echo("<tr><td><a href='$base" . "/overzicht/projectmembers/$studyid/$projectid/$row->id'>$row->Name</a></td><td><a href='$base" . "/overzicht/removegroup/$row->id' onclick=\"return confirm ('Zeker weten dat u deze groep wilt verwijderen?');\">Verwijderen</a></td><td>Niet beschikbaar</td><td>$deadlinetxt</td></tr>");
			}
		}
		echo("</table>");
	}
?>
</div>
<br/>
<a href='<?php echo $base; ?>/overzicht/addgroup/<?php echo $studyid . "/" . $projectid; ?>/'>Nieuwe groep</a>
<br/><br/>
<input type = "button" name = "ReturnButton" onclick = "history.go(-1);" value="Terug"/>