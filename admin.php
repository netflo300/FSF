<?php 
entete("Admin");

if (isset($_POST)) {
	if(isset($_POST['selectInstance']) && is_numeric($_POST['selectInstance'])) {
		$_SESSION['instance'] = $_POST['selectInstance'];
	}
}

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
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<link rel="stylesheet" type="text/css" href="css/style_admin.css" />
<title>Admin</title>
<script type="text/javascript" src="script/ajax.js"></script>
<script type="text/javascript">

function activate_user(login) {
	ajax('aj_adm_user.php', 'login='+login, 'game_user');
}

function change_step(select, login) {
	ajax('aj_adm_user.php', 'login_user='+login+'&step='+select.value, 'game_user')
}


function change_metric_value (id_metric, login_user, value) {
	ajax('aj_adm_user.php', 'action=change_metric&id_metric='+id_metric+'&login_user='+login_user+'&value='+value, 'game_user');
}

</script>
</head>
<body>
<div id="null"></div>
<div id="game_user">
	
</div>
<div id="game_question">
	
</div>
<span id="count"> </span>
<script type="text/javascript">ajax('aj_adm_user.php', '', 'game_user');</script>
</body>
</html>
<?php }

footer();
?>


