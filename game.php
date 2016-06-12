<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
require_once ("class/db.class.php");
require_once ("lib/fonctions.php");

$db = new Db();

if(!isset($_SESSION['login_user'])) {
	Header("Location:login_user.php");
	die;
}

$db->query("SELECT login_user, id_step FROM fsf_user u WHERE id_instance = '".$_SESSION['instance']."' AND login_user = '".$_SESSION['login_user']."' ;");
$user = $db->fetchNextObject();

$_SESSION['currentStep'] = $user->id_step;


entete('Game');
?>

<div id="game">
<script type="text/javascript">display_step(<?php echo $_SESSION['currentStep'];?>);</script>
</div>
<?php 
footer();
?>