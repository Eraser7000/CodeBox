<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<link href= "<?=base_url()?>css/StyleInlog.css" rel="Stylesheet" type="text/css"/>
		<title>Login - CodeBox</title>
	</head>
	<body>
	    <?php echo form_open('verifylogin'); $basecss = base_url(); ?>
			<div id = "Form">
				<div id = "padding">
					</br></br>
					<h1>Log in met je NHL account</h1>
					<h2>Gebruikersnaam</h2><img id = "logo" src="<?=base_url()?>/images/nhl_logo.png" alt="Logo">
					<input id = "username" type="text" size="12" maxlength="15" name="username" Class = "boxes"><b><?php echo form_error('username'); ?></b><br />
					<h2>Wachtwoord</h2>
					<input id = "password" type="password" size="12" maxlength="30" name="password" Class = "boxes"><b><?php echo form_error('password'); ?></b><br />
					<br/>
					<button id = "button" type="submit">Inloggen >></button><a href="home/vergeten">wachtwoord vergeten?</a>
					<br/><br/>
					<div><b><?php if(!$available) { echo("<img src='$basecss/images/notdone.jpg'?> LDAP server niet bereikbaar, u kunt niet inloggen met uw NHL account."); } 
					else { echo("<img src='$basecss/images/done.jpg'?> U kunt inloggen met uw NHL account."); } ?></b></div>
					<h3>Storing of vraag? Bel support 058-251 2552</h3>
				</div>
			</div>
		</form>
	</body>
</html>