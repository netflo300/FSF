<?php 
session_start();
require_once ("class/db.class.php");
require_once ("lib/fonctions.php");
require_once ("class/fckeditor/fckeditor.php");

$db = new Db();

$db->query("SELECT id_step_target, s.summary, text_link, rule_id FROM fsf_step_link l join fsf_step s on l.id_step_target = s.id_step WHERE id_step_origin = '".$_POST['id_step']."' ;");
?>

<h1>G&eacute;rer les liens</h1>
<table class="tableau">
<thead><tr><th>Lien</th><th>Texte</th><th>Regle</th></tr></thead>
<tbody>
<?php 
if($db->get_num_rows()>0) {
	foreach ($db->fetch_array() as $k => $v) {
		echo '<tr><td>'.$v['summary'].'</td><td>'.$v['text_link'].'</td><td>'.$v['rule_id'].'</td></tr>';
	}
}

?>


</tbody>
</table>



	
	
	