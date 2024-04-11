<?php
if(!defined('account_define')) { header('Location: /index.php'); }
?>
<style type="text/css" media="screen">
			.bloqueadosList a.bloqueadosU {
			-moz-border-radius:3px;
			background:#D5122D none repeat scroll 0 0;
			color:#FFF!important;
			display:block;
			float:right;
			padding:3px 5px;
			float: right;
			font-weight:normal;
			font-size:12px!important;
			position: absolute;
			top: 3px;
			right: 6px;
			}a.desbloqueadosU {
			-moz-border-radius:3px;
			background:#209c4f none repeat scroll 0 0;
			color:#FFF!important;
			display:block;
			float:right;
			padding:3px 5px;
			float: right;
			font-weight:normal;
			font-size:12px!important;
			position: absolute;
			top: 3px;
			right: 6px;
			}.bloqueadosList li {
				padding: 6px;
				position: relative;
				border-bottom: 1px solid #CCC;
			}.bloqueadosList a {
				font-weight:bold;
				font-size:13px;
			}
		</style>
        <?php
	$currentuser['blocked_array'] = (empty($currentuser['blocked']) ? '0' : explode(',', $currentuser['blocked']));
		if($currentuser['blocked_array'] == '0') {
			echo '<div class="emptyData">No has bloqueado ning&uacute;n usuario</div>';
		} else {
			echo '<ul class="bloqueadosList">';
			foreach($currentuser['blocked_array'] as $user) {
				$u = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$user."'"));
				echo '<li><a href="/perfil/'.$u['nick'].'">'.$u['nick'].'</a><span><a id="buser_2_'.$user.'" class="desbloqueadosU" href="#" onclick="buser('.$user.', false)" title="Desbloquear usuario">Desbloquear</a><a id="buser_1_'.$user.'" style="display:none;" class="bloqueadosU" href="#" onclick="buser('.$user.', true)" title="Bloquear usuario">Bloquear</a></span></li>';
			}
			echo '</ul>';
		}
		?>