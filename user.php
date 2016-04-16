<?php 
if(!isset($_SESSION['login_user'])) {
	Header("Location:login_user.php");
	die;
} else {
	
	if (isset($_POST)) {
		if(isset($_POST['selectInstance']) && is_numeric($_POST['selectInstance'])) {
			$_SESSION['instance'] = $_POST['selectInstance'];
		}
	}
		?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<title>Jeu</title>
</head>
<body>
<?php 
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
	$db->query("SELECT check_activate FROM fsf_user WHERE login_user = '".$_SESSION['login_user']."' and id_instance = '".$_SESSION['instance']."' ;");
	$o = $db->fetchNextObject();
	if ($o->check_activate == '0') {
?>
<h1>Bienvenue</h1>
<p>Votre compte est en cours d'activation..</p>
<a href="">rafraichir</a>
<?php
} else {
	?>
	<h1>Bienvenue</h1>
	<p>Vous allez experimenter un nouveau jeu interactif.</p>
	<a href="game.php">Commencer</a>
	<?php } ?> 
</body>
</html>
<?php }
}?>