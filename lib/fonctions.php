<?php 
function entete($titre) {
	$debug = 'POST : <br />';
	$debug.= str_replace("\n", '<br />', print_r($_POST, true)); 
	$debug.= '<br />GET : <br />';
	$debug.= str_replace("\n", '<br />', print_r($_GET, true)); 
	$debug.= '<br />SESSION : <br />';
	$debug.= str_replace("\n", '<br />', print_r($_SESSION, true)); 
	
  $res='';
  $res.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
	$res.='<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">'."\n";
	$res.='<head>'."\n";
	$res.='<title>'.$titre.'</title>'."\n";
	$res.='<meta name="Robots" content="Index,Follow" />'."\n";
	$res.='<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n";
	$res.='<meta http-equiv="Content-Language" content="fr" />'."\n";
	$res.='<meta name="Author" content="Florian Royal" />'."\n";
	$res.='<meta name="Expires" content="never" />'."\n";
	$res.='<script type="text/javascript" src="script/ajax.js" ></script>'."\n";
	$res.='<script type="text/javascript" src="script/jquery.min.js" ></script>'."\n";
	$res.='<script type="text/javascript" src="script/jquery-ui.min.js" ></script>'."\n";
	$res.='<script type="text/javascript" src="script/base.js" ></script>'."\n";
	$res.='<script type="text/javascript" src="script/jquery.stepProgressBar.js" ></script>'."\n";
	//$res.='<script type="text/javascript" src="scripts/builder.js" ></script>'."\n";
	//$res.='<script type="text/javascript" src="scripts/effects.js" ></script>'."\n";
	//$res.='<script type="text/javascript" src="scripts/controls.js" ></script>'."\n";
	//$res.='<script type="text/javascript" src="scripts/dragdrop.js" ></script>'."\n";
	
	//$res.='<script type="text/javascript" src="scripts/scriptaculous.js" ></script>'."\n";
	//$res.='<script type="text/javascript" src="scripts/slider.js" ></script>'."\n";
	//$res.='<script type="text/javascript" src="scripts/script.js" ></script>'."\n";
	//$res.='<script type="text/javascript" src="scripts/sound.js" ></script>'."\n";
	//$res.='<script type="text/javascript" src="scripts/info_bulle.js" ></script>'."\n";
	//$res.='<script type="text/javascript" src="scripts/tablefilter_all_min.js" ></script>'."\n";
	$res.=''."\n";
	$res.='<link href="css/base.css" rel="stylesheet" type="text/css" />'."\n";
	if (isset ($_SESSION['mode']) && $_SESSION['mode'] == 'utilisateur') {
		$res.='<link href="css/mobile.css" rel="stylesheet" type="text/css" />'."\n";
	}
	$res.='<link href="css/jquery.stepProgressBar.css" rel="stylesheet" type="text/css" />'."\n";
	//$res.='<link href="styles/filtergrid.css" rel="stylesheet" type="text/css" />'."\n";
	$res.='</head>'."\n";
	$res.='<body style="">'."\n";

	
	//$res.='<div id="modal"><span style="display:inline;float:right;cursor:pointer;"><img onclick="close_modal();" src="img/fermer.png" /></span><div class="titre" onmousemove="deplace();"></div><div id="modal_contenu" class="contenu"></div></div>'."\n";
	$res.='<div id="debug">'.$debug.'</div>'."\n";
	//$res.='<div id="overlay"></div>'."\n";
	//$res.='<div id="curseur" class="infobulle"></div>';
	echo $res ;
}

function message ($titre,$message,$time) {
	$res='';
	$res.='<script>';
	$res.='  message(\''.$titre.'\',\''.$message.'\',\''.$time.'\');';
	$res.='</script>';
	return $res ;	
}

function couleur_fond() {
	return '#FB1DE4;';
}

function clean_entry($var) {
	$resultat = strip_tags($var);
	$resultat = stripslashes($resultat);
	$resultat = str_replace('-', '', $resultat);
	$resultat = str_replace('*', '', $resultat);
	$resultat = str_replace('/', '', $resultat);
	return $resultat;
}

function footer() {
	$res='';
	$res.='<script type="text/javascript">
	
jQuery(function($){
	
	//Lorsque vous cliquez sur un lien de la classe poplight
	$("a.poplight").on("click", function() {
		var popID = $(this).data("rel"); //Trouver la pop-up correspondante
		var popID = "popup_name";
		var popWidth = $(this).data(\'width\'); //Trouver la largeur
	
		//Faire apparaitre la pop-up et ajouter le bouton de fermeture
		$(\'#\' + popID).fadeIn().css({ \'width\': popWidth}).prepend(\'<a href="#" class="close"><img src="images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>\');
	
		//Récupération du margin, qui permettra de centrer la fenêtre - on ajuste de 80px en conformité avec le CSS
		var popMargTop = ($(\'#\' + popID).width() + 80) / 2 ;
		var popMargLeft = ($(\'#\' + popID).width() + 80) / 2;
	
		//Apply Margin to Popup
		$(\'#\' + popID).css({
			\'margin-top\' : -popMargTop,
			\'margin-left\' : -popMargLeft
		});
	
		//Apparition du fond - .css({\'filter\' : \'alpha(opacity=80)\'}) pour corriger les bogues d\'anciennes versions de IE
		$(\'body\').append(\'<div id="fade"></div>\');
		$(\'#fade\').css({\'filter\' : \'alpha(opacity=80)\'}).fadeIn();
	
		//ajax_editer(1);
		return false;
	});
	
	
	//Close Popups and Fade Layer
	$(\'body\').on(\'click\', \'a.close, #fade\', function() { //Au clic sur le body...
		$(\'#fade , .popup_block\').fadeOut(function() {
			$(\'#fade, a.close\').remove();
	}); //...ils disparaissent ensemble
	
		return false;
	});
	
});
	
</script>';
	$res.='</body>'."\n";
	$res.='</html>'."\n";
	echo $res ;
}

function auth(){	
  return isset($_SESSION['uid']) ;
}

function travaux() {
	if (EN_TRAVAUX == "OUI") {
		header("Location:travaux.php");
		die;
	}
}

function ($chaine, $encodeUTF8=false) {
	if (!$encodeUTF8) return htmlentities($chaine);
	else return htmlentities($chaine, ENT_QUOTES, "UTF-8");
}

?>