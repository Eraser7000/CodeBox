<h3>Overzicht van al uw vakken:</h3>

<h3><?php echo "Het is nu: " . $datenow; ?></h3>

<h3>Vakken:</h3>
<div class = "datagrid">
<?php
	$result = $this->user->subjects($username);
	$count = count($result);
	$result2 = $this->user->projects($username);
	$count2 = count($result2);
	if($count == 0)
	{
		echo("Er zijn geen vakken beschikbaar voor deze student!");
	}
	else
	{
		echo("<table><tr><th>Vak</th><th>Status</th><th>Deadline</th><th>Inleveren</th></tr>");
		foreach ($result as $row)
		{
			$vaknaam = $row->name;
			$alreadysend = $this->user->isalreadysend($username,$row->subjectID);
			$deadline = $this->globalfunc->getexpiredatafromdb($row->subjectID);
			$expired = $this->globalfunc->expiredsubject($row->subjectID);
			date_default_timezone_set('Europe/Amsterdam');
			$date = new DateTime();
			$date->setTimestamp($deadline);
			$datedisplay = $date->format('d/m/Y H:i:s');
			$expiretxt = "";
			$basecss = base_url();
			$base = base_url() . "index.php";
			if($expired)
			{
				$expiretxt = "<img src='$basecss/images/notdone.jpg' alt='Verlopen'>";
			}
			if(!$alreadysend)
			{
				if(!$expired)
				{
					//echo "<li>$vaknaam - Niet voldaan [Deadline: $datedisplay - $expiretxt]</li>";
					echo("<tr><td>$vaknaam</td><td>Niet voldaan <img src='$basecss/images/notdone.jpg' alt='Niet voldaan'></td><td>$datedisplay $expiretxt</td><td><a href='$base/inleveren/vak/$row->subjectID'>Inleveren</a></td></tr>");
				}
				else
				{
					echo("<tr><td>$vaknaam</td><td>Niet voldaan <img src='$basecss/images/notdone.jpg' alt='Niet voldaan'></td><td>$datedisplay $expiretxt</td><td>Deadline verstreken.</td></tr>");
				}
			}
			else
			{
				if(!$expired)
				{
					//echo "<li>$vaknaam - Ingeleverd</a></li>";
					echo("<tr><td>$vaknaam</td><td>Voldaan <img src='$basecss/images/done.jpg' alt='Voldaan'></td><td>$datedisplay $expiretxt</td><td><a href='$base/inleveren/edit/$row->subjectID/'>aanpassen</a></td></tr>");
				}
				else
				{
					echo("<tr><td>$vaknaam</td><td>Voldaan <img src='$basecss/images/done.jpg' alt='Voldaan'></td><td>$datedisplay $expiretxt</td><td>Aanpassen niet mogelijk.</td></tr>");
				}
			}
	    }
	    echo("</table>");	    
	}
?>
</div>
<br/><br/>
<h3>Projecten:</h3>
<div class = "datagrid">
	<?php
	if($count2 == 0)
	{
		echo("Er zijn geen projecten beschikbaar voor deze student!");
	}
	else
	{
		echo("<table><tr><th>Project</th><th>Groep</th><th>Status</th><th>Deadline</th><th>Inleveren</th></tr>");
	    foreach($result2 as $row)
	    {
	    	$groupid = $this->user->getgroupidfromuser($username,$row->id);
	    	$groupname = $this->globalfunc->getgroupnamefromid($groupid);
			$alreadysend = $this->globalfunc->projectdelivered($groupid,$row->id); //groupid, projectid
			$deadline = $this->globalfunc->getexpireprojectdatafromdb($row->id);
			$expired = $this->globalfunc->expiredproject($row->id); //projectid
			$projectnaam = $row->name;
			date_default_timezone_set('Europe/Amsterdam');
			$date = new DateTime();
			$date->setTimestamp($deadline);
			$datedisplay = $date->format('d/m/Y H:i:s');
			$expiretxt = "";
			$basecss = base_url();
			$base = base_url() . "index.php";
			if($expired)
			{
				$expiretxt = "<img src='$basecss/images/notdone.jpg' alt='Verlopen'>";
			}
			if(!$alreadysend)
			{
				if(!$expired)
				{
					//echo "<li>$vaknaam - Niet voldaan [Deadline: $datedisplay - $expiretxt]</li>";
					echo("<tr><td>$projectnaam</td><td>$groupname</td><td>Niet voldaan <img src='$basecss/images/notdone.jpg' alt='Niet voldaan'></td><td>$datedisplay $expiretxt</td><td><a href='$base/inleveren/project/$row->id'>Inleveren</a></td></tr>");
				}
				else
				{
					echo("<tr><td>$projectnaam</td><td>$groupname</td><td>Niet voldaan <img src='$basecss/images/notdone.jpg' alt='Niet voldaan'></td><td>$datedisplay $expiretxt</td><td>Deadline verstreken.</td></tr>");
				}
			}
			else
			{
				if(!$expired)
				{
					//echo "<li>$vaknaam - Ingeleverd</a></li>";
					echo("<tr><td>$projectnaam</td><td>$groupname</td><td>Voldaan <img src='$basecss/images/done.jpg' alt='Voldaan'></td><td>$datedisplay $expiretxt</td><td><a href='$base/inleveren/editproj/$groupid/$row->id/'>aanpassen</a></td></tr>");
				}
				else
				{
					echo("<tr><td>$projectnaam</td><td>$groupname</td><td>Voldaan <img src='$basecss/images/done.jpg' alt='Voldaan'></td><td>$datedisplay $expiretxt</td><td>Aanpassen niet mogelijk.</td></tr>");
				}
			}    	
	    }
	    echo("</table>");
	}
?>
</div>