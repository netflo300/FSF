<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<link rel="stylesheet" type="text/css" href="css/style_admin.css" />
<title>Admin</title>
<script type="text/javascript" src="script/ajax.js"></script>
<script type="text/javascript">

function activate_user(login) {
	ajax('aj_adm_user.php', 'login='+login, 'game_user');
}

function change_step(select, login) {
	ajax('aj_adm_user.php', 'login_user='+login+'&step='+select.value, 'game_user')
}

</script>
</head>
<body>
<div id="null"></div>
<div id="game_user">
	
</div>
<div id="game_question">
	
</div>
<span id="count"> </span>
<script type="text/javascript">ajax('aj_adm_user.php', '', 'game_user');</script>
</body>
</html>



