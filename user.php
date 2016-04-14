<?php 
if(!isset($_SESSION['login_user'])) {
	Header("Location:login_user.php");
	die;
} else {
	?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<title>Jeu</title>
</head>
<body>
<h1>Bienvenue</h1>
<p>Vous allez experimenter un nouveau jeu interactif.</p>
<a href="game.php">Commencer</a>
</body>
</html>	
	<?php 
}
?>