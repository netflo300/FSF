<?php 
session_start();
require_once ("class/db.class.php");
require_once ("lib/fonctions.php");
require_once ("class/fckeditor/fckeditor.php");

$db = new Db();

$db->query("SELECT summary, text, variation_metrics FROM fsf_step WHERE id_step = '".$_POST['id_step']."' AND id_instance = '".$_SESSION['instance']."' ;");
$o = $db->fetchNextObject();
?>

<h1>Ajouter une etape</h1>
<form method="POST">
<input type="text" name="summary" value="<?php echo stripslashes($o->summary) ; ?>" />
<?php
$fck = new FCKeditor('text');
//$editeur->BasePath = '../script/fckeditor/' ;
$fck->Config['SkinPath'] = 'skins/office2003/' ;
$fck->ToolbarSet = 'Default' ;
$fck->Value = stripslashes($o->text);
$fck->Width = 800 ;
$fck->Height = 400 ;
$fck->Config['EnterMode'] = 'br';
$fck->Create();

$variation = explode(';', $o->variation_metrics);
$db->query("SELECT id_metric, name_metric FROM fsf_metric WHERE id_instance = '".$_SESSION['instance']."' ;");
if ($db->get_num_rows() > 0) {
	$count = 0;
	foreach ($db->fetch_array() as $k => $v) {
		echo'Variation '.$v['name_metric'].' : <input type="text" name="metrics'.$v['id_metric'].'" value="'.(isset($variation[$count])&&!empty($variation[$count])?$variation[$count]:'0').'"/>';
		echo'<br />';
		$count++;
	}
}


?>
<input type="hidden" name="id_step" value="<?php echo $_POST['id_step'] ; ?>" />







<input type="submit" name="editer" />
</form>
	
	
	