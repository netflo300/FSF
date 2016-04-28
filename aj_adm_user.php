<?php
session_start();

require_once ("class/db.class.php");
$db = new Db();

if(isset($_POST['login'])) {
	$db->query("UPDATE fsf_user SET check_activate = (check_activate + 1)%2 WHERE login_user = '".$_POST['login']."' ;");
}

if(isset($_POST['step'])) {
	$db->query("UPDATE fsf_user SET id_step = '".$_POST['step']."' WHERE login_user = '".$_POST['login_user']."' ;");
}

$select_step = '<select onchange="change_step(this);">';
$db->query("SELECT id_step, summary FROM fsf_step");
if($db->get_num_rows()>0) {
	foreach ($db->fetch_array() as $k => $v) {
		$select_step .= '<option value="'.$v['id_step'].'">'.$v['summary'].'</option>';
	}
}
$select_step .= '</select>';


?>
<table>
	<caption>Joueurs</caption>
	<thead>
	<tr>
		<th>login</th><th>activ&eacute;</th><th>step</th>
		<?php 
		/*
		$db->query("SELECT id_metric, name_metric FROM fsf_metric ");
		$metric_count = 0;
		foreach ($db->fetch_array() as $k => $v) {
			echo'<th>'.$v['name_metric'].'</th>';
			$select_cause .= 'm'.$v['id_metric'] 
			$metric_count++;
		}
		*/
		?>
		
	</tr>
	</thead>
	<tbody>
<?php 
$db->query("SELECT login_user, check_activate, name_instance, u.id_step, summary FROM fsf_user u join fsf_instance i on i.id_instance = u.id_instance LEFT JOIN fsf_step s ON s.id_step = u.id_step");
if ($db->get_num_rows()>0) {
	foreach ($db->fetch_array() as $k => $v) {
		if (isset($v['id_step']) && !empty($v['id_step'])) {
			$specific_select_step = str_replace('<option value="'.$v['id_step'].'">'.$v['summary'].'</option>', '<option value="'.$v['id_step'].'" selected="selected">'.$v['summary'].'</option>', $select_step);
			$specific_select_step = str_replace('<select onchange="change_step(this);">', '<select onchange="change_step(this,\''.$v['login_user'].'\');">', $specific_select_step);
		}
		echo'<tr><td>'.$v['login_user'].'</td><td><input type="checkbox" '.($v['check_activate']=='1'?'checked="checked"':'').' onchange="activate_user(\''.$v['login_user'].'\');" /></td><td>'.$specific_select_step.'</td></tr>';
	}
}
?>
</tbody>
</table>
<input type="button" value="Actualiser" onclick="ajax('aj_adm_user.php', 'actu=1', 'game_user');" />
