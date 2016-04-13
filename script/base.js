function replier_fieldset(f) {
	if (f.parentElement.nextElementSibling.style.display == "none") {
		f.parentElement.nextElementSibling.style.display="";
	} else {
		f.parentElement.nextElementSibling.style.display="none";
	}
}

function ajax_editer(id_step) {
	ajax('aj_editer.php', 'id_step='+id_step, 'popup_name');
 }

function ajax_link(id_step) {
	ajax('aj_link.php', 'id_step='+id_step, 'popup_name');
 }

function supprimer_link(source, target) {
	ajax('aj_link.php', 'action=delete&id_step='+source+'&target='+target, 'popup_name');
}

function ajouter_link(source) {
	var target = $('#target').val();
	var rule = $('#rule').val();
	var text = $('#text_link').val();
	ajax('aj_link.php', 'action=add&id_step='+source+'&target='+target+'&rule='+rule+'&text='+text, 'popup_name');
}