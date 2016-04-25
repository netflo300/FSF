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

$db->query("SELECT id_step_target, text_link, s.rule_id, r.rule_content, id_step_origin  FROM fsf_step_link s left join fsf_rule r ON r.rule_id = s.rule_id WHERE id_step_origin = '".$_SESSION['currentStep']."' ;");
$link =array();
if($db->get_num_rows() > 0) {
	$link = $db->fetch_array();
}

$db->query("SELECT * FROM fsf_code WHERE id_code = '".$_POST['id_code']."' ; ");
$code = $db->fetchNextObject();

if($code->value_code != $_POST['value']) {
	$rand_code = $_POST['id_code'];
	?>
	<label>Entrez le code n°<?php echo $rand_code; ?></label>
	<input type="text" name="code" onchange="aj_code(this, <?php echo $rand_code; ?>);"  onkeyup="aj_code(this, <?php echo $rand_code; ?>);"/>
	<?php 
} else {
	if(!empty($link)) {
		foreach($link as $k => $v) {
			$display_link = true;
			if (isset($v['rule_id']) && !empty($v['rule_id']) && !empty($v['rule_content'])) {
				$rule_query = str_replace('&login', $_SESSION['login_user'], $v['rule_content']);
				$db->query($rule_query);
				$o = $db->fetchNextObject();
				if ($o->result == '0') {
					$display_link = false;
				}
			}
			if ($display_link == true) {
				echo'<a href="#" onclick="display_step('.$v['id_step_target'].', '.$v['id_step_origin'].')">'.$v['text_link'].'</a><br/>';
			}
		}
	}
}
