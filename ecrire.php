<?php

if (isset($_POST)) {
	if(isset($_POST['selectInstance']) && is_numeric($_POST['selectInstance'])) {
		$_SESSION['instance'] = $_POST['selectInstance'];
	}
	
	if(isset($_POST['editer'])) {
		$var ='';
		foreach ($_POST as $k => $v) {
			if(strstr($k,'metric')) {
				$var.=';'.$v;
			}
		}
		$var = substr($var, 1);
		
		$db->query("UPDATE fsf_step SET summary='".addslashes(htmlentities($_POST['summary']))."', text='".addslashes($_POST['text'])."', variation_metrics = '".$var."'  WHERE id_instance='".$_SESSION['instance']."' AND id_step='".$_POST['id_step']."' ; ");
	}
	
}


entete("Ecrire");


if (!isset($_SESSION['instance'])) {
	$db->query("SELECT id_instance, name_instance FROM fsf_instance");
	$option = '';
	if($db->get_num_rows() > 0) {
		foreach ($db->fetch_array() as $k => $v) {
			$option .= '<option value="'.$v['id_instance'].'">'.$v['name_instance'].'</option>';
		}
		
	}
	?>
	<h1>Choisir une instance</h1>
	<form method="POST">
	<label>Instance</label>
	<select name="selectInstance"><?php echo $option ;?></select>
	<input type="submit">
	</form>
	<?php 
} else {
	$db->query("SELECT id_step, text, summary from fsf_step WHERE id_instance = '".$_SESSION['instance']."' ;");
	if($db->get_num_rows() > 0) {
		foreach ($db->fetch_array() as $k => $v) {
			?>
			<fieldset>
			<legend><a href="#" class="fieldset" onclick="replier_fieldset(this);">-</a> Step <?php echo $v['id_step']. ' : ' . stripslashes($v['summary']) ;?></legend>
			<div><?php echo $v['text'] ;?>
			<br />
			<a href="#" data-width="800" data-height="800" data-rel="popup_name" class="poplight" onclick="ajax_editer(1);">Modifer</a>
			
			
			</div>
			</fieldset>
			
			<?php 
		}
	
	}
	
	
	
	?>
	
<a href="#" data-width="800" data-rel="popup_name" class="poplight">En savoir plus</a>
	
	
<div id="popup_name" class="popup_block">

</div>
	
	
	<?php 
}



footer();
?>
