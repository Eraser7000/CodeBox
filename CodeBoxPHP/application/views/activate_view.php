<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<link href= "<?=base_url()?>/css/StyleInlog.css" rel="Stylesheet" type="text/css"/>
		<title>Activeren - CodeBox</title>
	</head>
	<body>
	    <?php echo form_open('verifyactivation'); ?>
			<div id = "Form">
				<div id = "padding">
					</br></br>
					<h1>Geef een nieuw wachtwoord</h1>
					<h2>Dit wachtwoord mag niet gelijk zijn aan uw NHL-account wachtwoord!</h2><br/>
					Notitie, dit wachtwoord kan niet gewijzigd worden!
					<h2>Nieuw wachtwoord</h2><img id = "logo" src="<?=base_url()?>/images/nhl_logo.png" alt="Logo">
					<input id = "password" type="password" size="12" maxlength="20" name="password" Class = "boxes"><br />
					<h2>Bevestiging wachtwoord</h2>
					<input id = "passwordconfirm" type="password" size="12" maxlength="20" name="passwordconfirm" Class = "boxes"><br />
					</br>
					<button id = "button" type="submit">Activeren >></button>
					</br>
					<br/><b><?php echo form_error('password'); ?></b><br/>
					<h3>Storing of vraag? Bel support 058-251 2552</h3>
				</div>
			</div>
		</form>
	</body>
</html>