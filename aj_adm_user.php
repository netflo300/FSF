<?php
session_start();

require_once ("class/db.class.php");
$db = new Db();

if(isset($_POST['login'])) {
	$db->query("UPDATE fsf_user SET check_activate = (check_activate + 1)%2 WHERE login_user = '".$_POST['login']."' and id_instance = '".$_SESSION['instance']."' ;");
}

if(isset($_POST['step'])) {
	$db->query("UPDATE fsf_user SET id_step = '".$_POST['step']."' WHERE login_user = '".$_POST['login_user']."' and id_instance = '".$_SESSION['instance']."' ;");
}

if(isset($_POST['action']) && $_POST['action'] == 'change_metric') {
	$db->query("UPDATE fsf_user_metric SET value = value + ".$_POST['value']." WHERE login_user = '".$_POST['login_user']."' and id_metric = ".$_POST['id_metric'].";");
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
		$db->query("SELECT name_metric from fsf_metric WHERE id_instance = '".$_SESSION['instance']."' ;");
		if ($db->get_num_rows() > 0) {
			foreach($db->fetch_array() as $k => $v) {
				echo '<th>'.$v['name_metric'].'</th>';
			}
		}
		?>
	</tr>
	</thead>
	<tbody>
<?php 
$db->query("SELECT login_user, check_activate, u.id_step, summary FROM fsf_user u LEFT JOIN fsf_step s ON s.id_step = u.id_step WHERE u.id_instance = '".$_SESSION['instance']."' ;");
$tab = $db->fetch_array();
if ($db->get_num_rows()>0) {
	foreach ($tab as $k => $v) {
		if (isset($v['id_step']) && !empty($v['id_step'])) {
			$specific_select_step = str_replace('<option value="'.$v['id_step'].'">'.$v['summary'].'</option>', '<option value="'.$v['id_step'].'" selected="selected">'.$v['summary'].'</option>', $select_step);
			$specific_select_step = str_replace('<select onchange="change_step(this);">', '<select onchange="change_step(this,\''.$v['login_user'].'\');">', $specific_select_step);
		}
		echo'<tr><td>'.$v['login_user'].'</td><td><input type="checkbox" '.($v['check_activate']=='1'?'checked="checked"':'').' onchange="activate_user(\''.$v['login_user'].'\');" /></td><td>'.$specific_select_step.'</td>';
		$db->query("SELECT id_metric,value FROM fsf_user_metric m where login_user = '".$v['login_user']."' ;");
		if ($db->get_num_rows() > 0) {
			foreach($db->fetch_array() as $k2 => $v2) {
				echo '<td><input type="button" value="-1" onclick="change_metric_value(\''.$v2['id_metric'].'\', \''.$v['login_user'].'\', \'-1\');" /> '.$v2['value'].' <input type="button" value="+1" onclick="change_metric_value(\''.$v2['id_metric'].'\', \''.$v['login_user'].'\', \'1\');"/> </td>';
			}
		}
		echo'</tr>';
	
	}
}
?>
</tbody>
</table>
<input type="button" value="Actualiser" onclick="ajax('aj_adm_user.php', 'actu=1', 'game_user');" />
