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
$new_action=false;

if(!isset($_SESSION['currentStep'])) {
	 $_SESSION['currentStep'] = $user->id_step;
} else {
	if(isset($_POST['id_step_next']) && is_numeric($_POST['id_step_next']) && isset($_POST['id_step_origin']) && is_numeric($_POST['id_step_origin'])) {
		$_SESSION['currentStep'] = $_POST['id_step_next'];
		$db->query("UPDATE fsf_user SET way_user = CONCAT('".$_POST['id_step_next']."', ';', way_user), id_step = '".$_POST['id_step_next']."'  WHERE login_user = '".$_SESSION['login_user']."' and id_instance = '".$_SESSION['instance']."' ; ");
		$new_action = true;
	}
}


$db->query("SELECT id_metric, value FROM fsf_user_metric u WHERE login_user ='".$_SESSION['login_user']."' ;");
if ($db->get_num_rows() == 0) {
	$db->query("SELECT id_metric, default_value FROM fsf_metric WHERE id_instance = '".$_SESSION['instance']."' ORDER BY id_metric;");
	if($db->get_num_rows() > 0) {
		foreach ($db->fetch_array() as $k => $v) {
			$db->query("INSERT INTO fsf_user_metric (login_user, id_metric, value) VALUES ('".$_SESSION['login_user']."', '".$v['id_metric']."', '".$v['default_value']."');");
		}
	}
}
$db->query("SELECT id_step, summary, text, variation_metrics FROM fsf_step s WHERE id_step = '".$_SESSION['currentStep']."' ;");
$step = $db->fetchNextObject();

if ($new_action == true) {
	if(isset($step->variation_metrics) && !empty($step->variation_metrics)) {
		$tab_variation = explode(";", $step->variation_metrics);
	}
	$db->query("SELECT id_metric, default_value FROM fsf_metric WHERE id_instance = '".$_SESSION['instance']."' ORDER BY id_metric;");
	if($db->get_num_rows()>0 && isset($tab_variation) && !empty($tab_variation)) {
		$count = 0;
		foreach ($db->fetch_array() as $k => $v) {
			$db->query("UPDATE fsf_user_metric SET value = value + ".$tab_variation[$count++]." WHERE login_user = '".$_SESSION['login_user']."' AND id_metric = '".$v['id_metric']."' ;");
		}
	}
}


$db->query("SELECT u.id_metric, u.value, m.min_value, m.max_value, m.low_value, m.high_value, m.unit_metric, name_metric FROM fsf_user_metric u JOIN fsf_metric m ON m.id_metric = u.id_metric WHERE u.login_user = '".$_SESSION['login_user']."' ;");
$metrics = $db->fetch_array();



$db->query("SELECT id_step_target, text_link FROM fsf_step_link s WHERE id_step_origin = '".$_SESSION['currentStep']."' ;");
$link =array();
if($db->get_num_rows() > 0) {
	$link = $db->fetch_array();
}
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
		echo'<a href="#" onclick="display_step('.$v['id_step_target'].', '.$step->id_step.')">'.$v['text_link'].'</a><br/>';
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
