<h3>Algemene informatie</h3>

<?php
	$var = $this->user->getfullnamefromldap($username);
	echo("Naam: $var");
?>