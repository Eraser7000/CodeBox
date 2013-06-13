		<?php echo form_open('verifyaddproject/handleuser/' . $studyid . "/" . $projectid .  "/" . $groupid); $basecss = base_url(); ?>
		</br></br>
		<b>Gebruikersnaam:</b><br/>
		<?php
			$result = $this->globalfunc->students($studyid);
			$options = array();
			foreach($result as $row)
			{
				$options = array_merge($options, array($row->username => ucfirst($row->username[0]) . " | " . $row->fullname));
			}
			echo form_dropdown('usernameoptions', $options);
		?>
		<button id = "button" type="submit">Toevoegen</button><br/>
		<br/><b><?php echo validation_errors(); ?></b><br/>

<input type = "button" name = "ReturnButton" onclick = "history.go(-2);" value="Terug"/>