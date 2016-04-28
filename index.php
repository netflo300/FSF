<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require_once ("class/db.class.php");
require_once ("lib/fonctions.php");
require_once ("class/fckeditor/fckeditor.php");
travaux();

$db = new Db();

if(isset($_GET['mode'])) {
	$_SESSION['mode'] = $_GET['mode'];
}


if (!isset($_SESSION['mode'])) {
	entete("Ecrire");
	?>
	<a href="?mode=redactionnel">Mode redactionnel</a><br />
	<a href="?mode=utilisateur">Mode utilisateur</a><br />
	<a href="?mode=administrateur">Mode administrateur</a>
	<?php 
	die;
}

if($_SESSION['mode'] == 'redactionnel') {
	include("ecrire.php");
	die;
}

if($_SESSION['mode'] == 'utilisateur') {
	include("user.php");
	die;
}

if($_SESSION['mode'] == 'administrateur') {
	include("admin.php");
	die;
}

