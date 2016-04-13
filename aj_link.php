<?php 
session_start();
require_once ("class/db.class.php");
require_once ("lib/fonctions.php");
require_once ("class/fckeditor/fckeditor.php");

$db = new Db();
if (isset($_POST)) {
	if(isset($_POST['action']) && $_POST['action'] == 'delete') {
		$db->query("DELETE FROM fsf_step_link WHERE id_step_origin = '".$_POST['id_step']."' AND id_step_target = '".$_POST['target']."' ;");
	}
	
	if(isset($_POST['action']) && $_POST['action'] == 'add') {
		$db->query("REPLACE INTO fsf_step_link (id_step_origin, id_step_target, rule_id, text_link) VALUES ('".$_POST['id_step']."', '".$_POST['target']."', '".$_POST['rule']."', '".addslashes(htmlentities($_POST['text']))."') ;");
		
	}
}





?>
<a href="#" class="close"><img src="images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
<h1>G&eacute;rer les liens</h1>
<table class="tableau">
<thead><tr><th>Lien</th><th>Texte</th><th>Regle</th><th>Action</th></tr></thead>
<tbody>
<?php 

$select_step = '<select id="target">';
$db->query("SELECT id_step, summary FROM fsf_step");
if($db->get_num_rows()>0) {
	foreach ($db->fetch_array() as $k => $v) {
		$select_step .= '<option value="'.$v['id_step'].'">'.$v['summary'].'</option>';
	}
}
$select_step .= '</select>';

$select_rule = '<select id="rule">';
$select_rule .= '<option></option>';
$db->query("SELECT rule_id FROM fsf_rule");
if($db->get_num_rows()>0) {
	foreach ($db->fetch_array() as $k => $v) {
		$select_rule .= '<option value="'.$v['rule_id'].'">'.$v['rule_id'].'</option>';
	}
}
$select_rule .= '</select>';

$db->query("SELECT id_step_target, s.summary, text_link, rule_id FROM fsf_step_link l join fsf_step s on l.id_step_target = s.id_step WHERE id_step_origin = '".$_POST['id_step']."' ;");

if($db->get_num_rows()>0) {
	$tab = $db->fetch_array();
	foreach ($tab as $k => $v) {
		echo '<tr><td>'.$v['summary'].'</td><td>'.$v['text_link'].'</td><td>'.$v['rule_id'].'</td><td><a href="#" onclick="supprimer_link('.$_POST['id_step'].','.$v['id_step_target'].');"><img src="images/delete.png" alt="S" title="Supprimer"/></a></td></tr>';
	}
	
	
}
echo '<tr><form method="POST"><td>'.$select_step.'</td><td><input type="text" id="text_link" /></td><td>'.$select_rule.'</td><td><a href="#" onclick="ajouter_link('.$_POST['id_step'].');"><img src="images/edit.png" alt="A" title="Ajouter"/></a></td></tr>';


?>


</tbody>
</table>



	
	
	