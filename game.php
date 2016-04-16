<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
require_once ("class/db.class.php");
require_once ("lib/fonctions.php");

$db = new Db();

if(!isset($_SESSION['login_user'])) {
	Header("Location:login_user.php");
	die;
} else {

	if (isset($_POST)) {
		if(isset($_POST['selectInstance']) && is_numeric($_POST['selectInstance'])) {
			$_SESSION['instance'] = $_POST['selectInstance'];
		}
	}
}

$db->query("SELECT login_user, way_user FROM fsf_user u WHERE id_instance = '".$_SESSION['instance']."' AND login_user = '".$_SESSION['login_user']."' ;");
$user = $db->fetchNextObject();

if(!isset($_SESSION['currentStep'])) {
	 $steps = explode(";", $user->way_user);
	 $_SESSION['currentStep'] = $steps[0];
} 


$db->query("SELECT id_metric, value FROM fsf_user_metric u WHERE login_user ='".$_SESSION['login_user']."' ;");
if ($db->get_num_rows() == 0) {
	$db->query("SELECT id_metric, default_value FROM fsf_metric WHERE id_instance = '".$_SESSION['instance']."' ;");
	if($db->get_num_rows() > 0) {
		foreach ($db->fetch_array() as $k => $v) {
			$db->query("INSERT INTO fsf_user_metric (login_user, id_metric, value) VALUES ('".$_SESSION['login_user']."', '".$v['id_metric']."', '".$v['default_value']."');");
		}
	}
}

$db->query("SELECT u.id_metric, u.value, m.min_value, m.max_value, m.low_value, m.high_value, m.unit_metric, name_metric FROM fsf_user_metric u JOIN fsf_metric m ON m.id_metric = u.id_metric ;");
$metrics = $db->fetch_array();

$db->query("SELECT id_step, summary, text FROM fsf_step s WHERE id_step = '".$_SESSION['currentStep']."' ;");
$step = $db->fetchNextObject();

$db->query("SELECT id_step_target, text_link FROM fsf_step_link s WHERE id_step_origin = '".$_SESSION['currentStep']."' ;");
$link =array();
if($db->get_num_rows() > 0) {
	$link = $db->fetch_array();
}

entete('Game');
?>


<h1>Joueur : <?php echo $user->login_user?></h1>
<table>
<?php 
$progreesBarData = array();
foreach ($metrics as $k => $v) {
	echo'<tr><td class="mobile">'.$v['name_metric'].'</td><td width="600"><div id="myGoal'.$v['id_metric'].'"></div></td></tr>';
	$progreesBarData[$v['id_metric']] = array();
	$progreesBarData[$v['id_metric']]['value'] = $v['value'];
	$progreesBarData[$v['id_metric']]['min_value'] = $v['min_value'];
	$progreesBarData[$v['id_metric']]['max_value'] = $v['max_value'];	
	$progreesBarData[$v['id_metric']]['low_value'] = $v['low_value'];	
	$progreesBarData[$v['id_metric']]['high_value'] = $v['high_value'];
	$progreesBarData[$v['id_metric']]['unit_metric'] = $v['unit_metric'];
}
?>
</table>
<h3><?php echo $step->summary ;?></h3>
<p><?php echo $step->text ;?></p>
<?php 
if(!empty($link)) {
	foreach($link as $k => $v) {
		echo'<a href="#">'.$v['text_link'].'</a><br/>';
	}
}

?>


<script type="text/javascript">
<?php 
foreach ($progreesBarData as $k => $v) {
	echo'$(\'#myGoal'.$k.'\').stepProgressBar({
	  currentValue: '.$v['value'].',
	  steps: [
	    { value: '.$v['min_value'].'  },
	    { value: '.$v['low_value'].'  },
	    { value: '.$v['high_value'].'},
	    { value: '.$v['max_value'].'}
	  ],
	  unit: \''.($v['unit_metric']).'\'
	});';
}
?>
</script>
<?php 
footer();
?>