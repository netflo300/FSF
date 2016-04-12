<?php 
session_start();
require_once ("class/db.class.php");
require_once ("lib/fonctions.php");
require_once ("class/fckeditor/fckeditor.php");

$db = new Db();

$db->query("SELECT summary, text FROM fsf_step WHERE id_step = '".$_POST['id_step']."' AND id_instance = '".$_SESSION['instance']."' ;");
$o = $db->fetchNextObject();
?>

<h1>Ajouter une etape</h1>
<form method="POST">
<input type="text" name="summary" value="<?php echo stripslashes($o->summary) ; ?>" />
<?php
$fck = new FCKeditor('newStep');
//$editeur->BasePath = '../script/fckeditor/' ;
$fck->Config['SkinPath'] = 'skins/office2003/' ;
$fck->ToolbarSet = 'Default' ;
$fck->Value = stripslashes($o->text);
$fck->Width = 800 ;
$fck->Height = 400 ;
$fck->Config['EnterMode'] = 'br';
$fck->Create();
?>
<input type="hidden" name="id_step" value="<?php echo $_POST['id_step'] ; ?>" />
<input type="submit" name="editer" />
</form>
	
	
	