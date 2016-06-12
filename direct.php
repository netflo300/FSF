<?php
session_start();
require_once ("class/db.class.php");
require_once ("lib/fonctions.php");

$db = new Db();

if (!isset($_GET)) {
	Header("Location:index.php");
	die;
}
$_SESSION = array();

if (isset($_GET['login']) && !empty($_GET['login'])) {
	$db->query("SELECT login_user FROM fsf_user WHERE login_user = '".$_GET['login']."' and id_instance = '".$_GET['selectInstance']."' ;");
	$_SESSION['login_user'] = $_GET['login'];
	$_SESSION['instance'] = $_GET['selectInstance'];
	$_SESSION['mode'] = 'utilisateur';
	Header("Location:game.php");
	die;
} 