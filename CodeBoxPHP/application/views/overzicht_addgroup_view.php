		<?php echo form_open('verifyaddproject/handlegroup/' . $studyid . "/" . $projectid); $basecss = base_url(); ?>
		</br></br>
		<b>Groepnaam:</b><br/>
		<input id = "groupname" type="text" size="12" maxlength="20" name="groupname" Class = "boxes"><br />
		<button id = "button" type="submit">Aanmaken</button><br/>
		<br/><b><?php echo form_error('groupname'); ?></b><br/>

<input type = "button" name = "ReturnButton" onclick = "history.go(-1);" value="Terug"/>