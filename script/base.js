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
