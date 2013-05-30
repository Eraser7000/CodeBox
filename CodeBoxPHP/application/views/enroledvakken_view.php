<h3>Selecteer uw vak:</h3>
Welkom, deze vakken zijn beschikbaar voor uw opleiding.
<br/><br/>
<div>
<?php
	$result = $this->user->subjects($username);
	$count = 0;
	foreach ($result as $row)
	{
		$vaknaam = $row->name;
		$alreadysend = $this->user->isalreadysend($username,$row->subjectID);
		$isexpired = $this->globalfunc->expiredsubject($row->subjectID);
		if(!$isexpired)
		{
			if($alreadysend)
			{
				echo "<li>$vaknaam - Voldaan. [<a href='<?=base_url()?>/inleveren/edit/$row->subjectID/'>aanpassen</a>]</li>";
			}
			else
			{
				echo "<li>$vaknaam - Niet voldaan! <a href='<?=base_url()?>/inleveren/vak/$row->subjectID'>[Inleveren]</a></li>";
			}
		}
		else
		{
			echo("<li>$vaknaam - Deadline is overschreden. [Inleveren en aanpassen niet mogelijk]</li>");
		}
		$count++;
    }
	if($count == 0)
	{
		echo("Er zijn geen vakken beschikbaar!");
	}
?>
</div>