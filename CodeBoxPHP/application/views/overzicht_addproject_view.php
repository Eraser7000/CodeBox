		<?php echo form_open('verifyaddproject/handleproject/' . $studyid); $basecss = base_url(); ?>
		</br></br>
		<b>Projectnaam:</b><br/>
		<input id = "projectname" type="text" size="12" maxlength="20" name="projectname" Class = "boxes"><br />
		<b>Vervaldatum:</b><br/>
		<input id = "expiredate" type="text" size="12" maxlength="20" name="expiredate" Class = "boxes"><br />
		<b>Vervaltijdstip:</b><br/>
		<input id = "expiretime" type="text" size="12" maxlength="20" name="expiretime" Class = "boxes"><br />
		<button id = "button" type="submit">Aanmaken</button><br/>
		<br/><b><?php echo validation_errors(); ?></b><br/>

<input type = "button" name = "ReturnButton" onclick = "history.go(-1);" value="Terug"/>