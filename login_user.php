<?php
session_start();
require_once ("class/db.class.php");
if (isset($_POST['login']) && !empty($_POST['login'])) {
	$db = new Db();
	$db->query("SELECT root_step FROM fsf_instance WHERE id_instance = '".$_SESSION['instance']."' ;");
	$instance = $db->fetchNextObject();
	$db->query("REPLACE INTO FSF_USER (login_user, id_instance, way_user) VALUES ('".$_POST['login']."', '".$_SESSION['instance']."', '".$instance->way_user."'); ");
	$_SESSION['login_user'] = $_POST['login'];
	Header("Location:index.php");
	die;
} else {
	?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<title>Insert title here</title>
</head>
<body>
<h1>Authentification</h1>
<form action="" method="POST">
	<label>Joueur : </label>
	<input type="text" name="login" />
	<input type="submit" />
</form>
</body>
</html>	
	<?php 
}
?>