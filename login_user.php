<?php
session_start();
require_once ("class/db.class.php");
$db = new Db();
if (isset($_POST['login']) && !empty($_POST['login'])) {
	$db->query("SELECT login_user FROM fsf_user WHERE login_user = '".$_POST['login']."' and id_instance = '".$_POST['selectInstance']."' ;");
	if ($db->get_num_rows() == 0) {
		$db->query("SELECT root_step FROM fsf_instance WHERE id_instance = '".$_POST['selectInstance']."' ;");
		$instance = $db->fetchNextObject();
		$db->query("REPLACE INTO fsf_user (login_user, id_instance, id_step, way_user) VALUES ('".$_POST['login']."', '".$_POST['selectInstance']."', '".$instance->root_step."', '".$instance->root_step."'); ");
	}
	$_SESSION['login_user'] = $_POST['login'];
	$_SESSION['instance'] = $_POST['selectInstance'];
	Header("Location:index.php");
	die;
} else {
	$db->query("SELECT id_instance, name_instance FROM fsf_instance");
	$option = '';
	if($db->get_num_rows() > 0) {
		foreach ($db->fetch_array() as $k => $v) {
			$option .= '<option value="'.$v['id_instance'].'">'.$v['name_instance'].'</option>';
		}
	
	}
	?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/mobile.css" />
<title>Insert title here</title>
</head>
<body>
<div id="game">
<h1>Authentification</h1>

<form action="" method="POST">
	<label>Joueur : </label>
	<input type="text" name="login" /><br/>
	<label>Instance : </label><select name="selectInstance"><?php echo $option ;?></select>
	<input type="submit" />
</form>
</div>
</body>
</html>	
	<?php 
}
?>