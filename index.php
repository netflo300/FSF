<?php
session_start();
require_once ("class/db.class.php");
require_once ("lib/fonctions.php");
require_once ("class/fckeditor/fckeditor.php");
travaux();

if (false && !auth()) {
  Header("Location:login.php");
  die;
}
$db = new Db();



include("ecrire.php");
die;



include ("header.php");

echo 'Connect&eacute; en tant que : '.$_SESSION['login'];
?>
<script type="text/javascript">
<!--
	function ctrlNb(name) {
		if ($(name).value =='') {
			 $(name).style.backgroundColor='white';
		}
		else if (isNaN($(name).value)) {
		  $(name).style.backgroundColor='#FFAAAA';
	  }
		else {
			$(name).style.backgroundColor='lightgreen';
		}
	}
		
 function majNb(name) {
	if(($(name).value)!='' && !isNaN($(name).value)) {
		ajax('inscriptions.php', name+'='+$(name).value, 'inscriptions');
	}
 }

 function ctrlNom(name) {
		if ($(name).value =='') {
			 $(name).style.backgroundColor='#FFAAAA';
		}
		else {
			$(name).style.backgroundColor='lightgreen';
		}
	}

 function majParcours(num,checkUpdt,seqip) {
		if (($(eval('nom'+num)).value)!='' && !isNaN($(eval('parcours'+num)).value))  {
			ajax('inscriptions.php', 'nom='+$(eval('nom'+num)).value+'&parcours='+$(eval('parcours'+num)).value+'&checkUpdt='+checkUpdt+'&seqip='+seqip, 'inscriptions');
		}
	}

 function majParcours2(num,checkUpdt,seqip) {
		if (($(eval('Dnom'+num)).value)!='' && !isNaN($(eval('Dparcours'+num)).value))  {
			ajax('inscriptions.php', 'nom2='+$(eval('Dnom'+num)).value+'&parcours2='+$(eval('Dparcours'+num)).value+'&checkUpdt='+checkUpdt+'&seqip='+seqip, 'inscriptions');
		}
	}

	function delete_entry(seqip) {
		ajax('inscriptions.php', 'action=delete&seqip='+seqip, 'inscriptions');
	}

	function delete_entry2(seqip) {
		ajax('inscriptions.php', 'action=delete2&seqip='+seqip, 'inscriptions');
	}
//-->
</script>
<h1 style="text-align:center;margin:auto;">WeeCap 2016</h1>
<h2 style="text-align:center;margin:auto;color:red;">Le module d'inscription est maintenant ferm&eacute; pour toute demande de modification, merci d'envoyer un mail &agrave; pc@sgdf-lille-flandres.fr</h2>
<p>Le WeeCap 2016 aura lieu les 27 et 28 f&eacute;vrier prochain. A cette occasion les pionniers/caravelles qui sont chefs d'&eacute;quipes ou trois&egrave;me ann&eacute;e sont invit&eacute;s &agrave; participer &agrave; ce week-end.</p>
<p>Le week-end aura lieu &agrave; Lambersart au lyc&eacute;e Maria Goretti, Rue de Verlinghem &agrave; Lambersart</p> 
<p>Afin que le week-end se d&eacute;roule bien, il est demand&eacute; que chaque caravane vienne avec au moins un chef. Le (ou les chefs) de chaque caravane reste(nt) responsable(s) des jeunes qui l'accompagnent. Vous devez avoir avec vous les fiches sanitaires des jeunes qui participeront au week-end et prendre votre trousse de soins</p>
<p> Pour la nuit, merci d'apporter une tente patrouille (ou &eacute;quivalent au niveau place) par caravane</p>
<div id="inscriptions" style="text-align:center;">
<?php include "inscriptions.php" ; ?>

</div>
<a href="pdf.php">Recuperer votre recipiss&eacute; d'inscription</a>
<?php 
footer();
?>
