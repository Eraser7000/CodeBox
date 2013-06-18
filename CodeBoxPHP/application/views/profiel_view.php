<h3>Algemene informatie</h3>

<?php
	$name = $this->user->getfullnamefromdb($username);
	echo("Naam: $name <br/>");
	$role = $this->user->getrolefromdb($username);
	echo("Rol: $role <br/>");
	$study = $this->globalfunc->getstudynamefromid($this->user->getstudyid($username));
	echo("Studie: $study <br/>");
?>