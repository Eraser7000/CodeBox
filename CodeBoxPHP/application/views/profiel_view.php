<h3>Algemene informatie</h3>

<?php
	$var = $this->user->getfullnamefromdb($username);
	echo("Naam: $var");
?>