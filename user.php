<?php 
if(!isset($_SESSION['login_user'])) {
	Header("Location:login_user.php");
	die;
} else {
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
	Header("Location:login_user.php");
	die;
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