<h3>Maak uw keuze:</h3>


<div class = "datagrid">
	<table>
		<tr><th>Keuze</th></tr>
		<tr><td><a href="<?=base_url()?>index.php/overzicht/studentlist/<?php echo $studyid; ?>">Overzicht per student.</a></td></tr>
		<tr><td><a href="<?=base_url()?>index.php/overzicht/subjectlist/<?php echo $studyid; ?>">Overzicht per vak.</a></td></tr>
		<tr><td><a href="<?=base_url()?>index.php/overzicht/projects/<?php echo $studyid; ?>">Projecten.</a></td></tr>
	</table>
</div>
<br/>
<input type = "button" name = "ReturnButton" onclick = "history.go(-1);" value="Terug"/>