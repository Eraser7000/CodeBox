			
		<h3>Uploaden bestand</h3>
		Hier kunt u uw opdracht inleveren:<br/><br/>
		<?php echo $error;?>
		<?php echo form_open_multipart('inleveren/project_upload/' . $username . "/" . $projectid); ?>
		<b>Bestand kiezen:</b><br/><br/>
		<input type="file" name="userfile" size="20" />
		<br /><br />
		<input type="submit" value="Uploaden en versturen" /> <input type="button" value="Annnuleren" name="CancelButton" onclick="history.go(-1);" />
		</form>