 <?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if(!isLogged()) {
	include('./Pages/register.php');
    include('./footer.php');
    die;
}
include('recaptcha.php');
$saa = array('inbox', 'outbox', 'trash', 'dir', 'new', 'new-dir', 'read');
$sa = (!$_GET['sa'] || !in_array($_GET['sa'], $saa) ? 'inbox' : $_GET['sa']);
$alldir = explode(':', $currentuser['pm_dir']);
//echo '-->'.$currentuser['pm_dir'].'<-->';print_r($alldir);echo '<--';
$resp = recaptcha_check_answer($config['recaptcha_privatekey'], $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
if($sa == 'dir' && (!$_GET['dir'] || !eregi('^[a-z0-9]+$', $_GET['dir']) || !in_array($_GET['dir'], $alldir))) {
	$sa = 'inbox';
} else {
	$_dir = mysql_clean($_GET['dir']);
}
if($sa == 'read') {
	if((!$_GET['pm'] || !mysql_num_rows($pq = mysql_query("SELECT * FROM `pms` WHERE id = '".mysql_clean($_GET['pm'])."' && (user_to = '".$currentuser['id']."' OR user_from = '".$currentuser['id']."')")))) {
		$sa = 'inbox';
	} else {
		$pm = mysql_fetch_array($pq);
	}
}
if($sa == 'new-dir') {
	if(!$_POST['carpeta_nombre'] || !eregi('^[a-z0-9]+$', $_POST['carpeta_nombre'])) {
		die(error('OOPS!', 'El nombre para la carpeta no es v&aacute;lido<br />Solo se admiten letras y n&uacute;meros', 'Centro de mensajes', '/mensajes/'));
	}
	if(in_array($_POST['carpeta_nombre'], $alldir)) {
		die(error('OOPS!', 'Ya existe una carpeta con este nombre', 'Centro de mensajes', '/mensajes/'));
    }
	if(!@mysql_query("UPDATE `users` SET pm_dir = '".(empty($currentuser['pm_dir']) ? mysql_clean($_POST['carpeta_nombre']) : $currentuser['pm_dir'].':'.mysql_clean($_POST['carpeta_nombre']))."' WHERE id = '".$currentuser['id']."'")) {
		die(error('OOPS!', 'No se pudo crear la carpeta', 'Centro de mensajes', '/mensajes/'));
	}
	die(error('YEAH!', 'Se ha creado la carpeta', 'Centro de mensajes', '/mensajes/'));

}
if($_POST && $_POST['accion'] && ($_POST['accion'] == 'eliminar' || $_POST['accion'] == 'L' || $_POST['accion'] == 'NL' || $_POST['accion'] == 'mover')) {
	switch($_POST['accion']) {
		case 'eliminar':
			foreach($_POST as $key => $value) {
				if(substr($key, 0, 4) != 'm_o_') { continue; }
				if(!mysql_num_rows($q = mysql_query("SELECT * FROM `pms` WHERE (user_to = '".$currentuser['id']."' OR user_from = '".$currentuser['id']."') AND id = '".mysql_clean($value)."'"))) { $error = true; continue; }
				$m = mysql_fetch_array($q);
				$df = ($m['user_from'] == $currentuser['id'] ? 'deleted_from' : 'deleted_to');
				$mq = "UPDATE `pms` SET ".($m['user_from'] == $currentuser['id'] ? 'deleted_from' : 'deleted_to')." = '".($m[$df] == 0 ? '1' : '2')."', ".($m['user_from'] == $currentuser['id'] ? 'readed_from' : 'readed_to')." = '1' WHERE id = '".mysql_clean($value)."'";
				mysql_query($mq) or die('->'.mysql_error());
			}
			die(error('YEAH!', ($error ? 'No todos los mensajes pudieron eliminarse...' : 'Los mensajes se han eliminado'), 'Centro de mensajes', '/mensajes/'));
		break;
		case 'mover':
			foreach($_POST as $key => $value) {
				if(substr($key, 0, 4) != 'm_o_') { continue; }
				if(!mysql_num_rows($q = mysql_query("SELECT * FROM `pms` WHERE (user_to = '".$currentuser['id']."' OR user_from = '".$currentuser['id']."') AND id = '".mysql_clean($value)."'")) || !$_POST['mover_a_carpeta'] || !in_array($_POST['mover_a_carpeta'], $alldir)) { $error = true; continue; }
				$m = mysql_fetch_array($q);
				mysql_query("UPDATE `pms` SET ".($m['user_from'] == $currentuser['id'] ? 'dir_from' : 'dir_to')." = '".mysql_clean($_POST['mover_a_carpeta'])."' WHERE id = '".mysql_clean($value)."'");
			}
			die(error('YEAH!', ($error ? 'No todos los mensajes pudieron moverse...' : 'Los mensajes se han movido'), 'Centro de mensajes', '/mensajes/'));
		break;
		case 'L':
			foreach($_POST as $key => $value) {
				if(substr($key, 0, 4) != 'm_o_') { continue; }
				$q = mysql_query("SELECT * FROM `pms` WHERE (user_to = '".$currentuser['id']."' OR user_from = '".$currentuser['id']."') AND id = '".mysql_clean($value)."'") or die(mysql_error());
				if(!mysql_num_rows($q)) { $error = true; continue; }
				$m = mysql_fetch_array($q);
				mysql_query("UPDATE `pms` SET ".($m['user_from'] == $currentuser['id'] ? 'readed_from' : 'readed_to')." = '1' WHERE id = '".mysql_clean($value)."'");
			}
			die(error('YEAH!', ($error ? 'No todos los mensajes pudieron marcarse como leidos...' : 'Los mensajes se han marcado como leidos'), 'Centro de mensajes', '/mensajes/'));
		break;
		case 'NL':
			foreach($_POST as $key => $value) {
				if(substr($key, 0, 4) != 'm_o_') { continue; }
				if(!mysql_num_rows($q = mysql_query("SELECT * FROM `pms` WHERE (user_to = '".$currentuser['id']."' OR user_from = '".$currentuser['id']."') AND id = '".mysql_clean($value)."'"))) { $error = true; continue; }
				$m = mysql_fetch_array($q);
				mysql_query("UPDATE `pms` SET ".($m['user_from'] == $currentuser['id'] ? 'readed_from' : 'readed_to')." = '0' WHERE id = '".mysql_clean($value)."'");
			}
			die(error('YEAH!', ($error ? 'No todos los mensajes pudieron marcarse como no leidos...' : 'Los mensajes se han marcado como no leidos'), 'Centro de mensajes', '/mensajes/'));
		break;
	}
}

if($_POST && $_POST['hidden_carpeta_accion'] && ($_POST['hidden_carpeta_accion'] == 'eliminar' || $_POST['hidden_carpeta_accion'] == 'cambiar')) {
	if($_POST['hidden_carpeta_accion'] == 'cambiar') {
		if(!$_POST['carpeta'] || !$_POST['carpeta_nombre'] || !in_array($_POST['carpeta'], $alldir)) { die(error('OOPS!', '&iquest;Has puesto todos los datos de la carpeta? (Es solo uno, &iquest;&iexcl;C&oacute;mo has fallado!?', 'Centro de mensajes', '/mensajes/')); }
		if(!eregi('^[a-z0-9]+$', $_POST['carpeta_nombre'])) { die(error('OOPS!', 'La carpeta solo admite como nombre letras y n&uacute;meros', 'Centro de mensajes', '/mensajes/')); }
		if(eregi($_POST['carpeta_nombre'], $currentuser['pm_dir'])) { die(error('OOPS!', 'Ya existe una carpeta con este nombre', 'Centro de mensajes', '/mensajes/')); }
		unset($alldir[array_keys($alldir, $_POST['carpeta'])]);
		$alldir[] = $_POST['carpeta_nombre'];
		mysql_query("UPDATE `users` SET pm_dir = '".implode(',', $alldir)."' WHERE id = '".$currentuser['id']."'");
		mysql_query("UPDATE `pms` SET dir_from = '".mysql_clean($_POST['carpeta_nombre'])."' WHERE user_from = '".$currentuser['id']."' && dir = '".mysql_clean($_POST['carpeta'])."'");
		mysql_query("UPDATE `pms` SET dir_to = '".mysql_clean($_POST['carpeta_nombre'])."' WHERE user_to = '".$currentuser['id']."' && dir = '".mysql_clean($_POST['carpeta'])."'");
		die(error('YEAH!', 'La carpeta se ha actualizado', 'Centro de mensajes', '/mensajes/'));
	} else {
		if(!$_POST['carpeta'] ||  !eregi($_POST['carpeta'], $currentuser['pm_dir'])) { die(error('OOPS!', '&iquest;Has puesto todos los datos de la carpeta? (Es solo uno, &iquest;&iexcl;C&oacute;mo has fallado!?', 'Centro de mensajes', '/mensajes/')); }
		$mpdir = str_replace($_POST['carpeta'], '', $currentuser['pm_dir']);
		$mpdir = str_replace('::', ':', $mpdir);
		if(substr($mpdir, 0, 1) == ':') { $mpdir = substr($mpdir, 1); }
		if(substr($mpdir, -1) == ':') { $mpdir = substr($mpdir, 0, strlen($mpdir)-1); }
		mysql_query("UPDATE `users` SET pm_dir = '".$mpdir."' WHERE id = '".$currentuser['id']."'");
		mysql_query("UPDATE `pms` SET dir_from = '0' WHERE user_from = '".$currentuser['id']."' && dir = '".mysql_clean($_POST['carpeta'])."'");
		mysql_query("UPDATE `pms` SET dir_to = '0' WHERE user_to = '".$currentuser['id']."' && dir = '".mysql_clean($_POST['carpeta'])."'");
		die(error('YEAH!', 'La carpeta se ha eliminado', 'Centro de mensajes', '/mensajes/'));
	}
}

if($_POST && $_POST['new-pm']) {
	if(!$_POST['msg_to'] || empty($_POST['msg_to']) || !$_POST['msg_subject'] || empty($_POST['msg_subject']) || !$_POST['msg_body'] || (empty($_POST['recaptcha_response_field']) && $currentuser['rank'] == 0) || empty($_POST['msg_body'])) {
		die(error('CHAN!!', 'Rellena todos los campos', 'Centro de mensajes', '/mensajes/'));
	}
	if(!mysql_num_rows($q = mysql_query("SELECT id, blocked FROM `users` WHERE nick = '".mysql_clean($_POST['msg_to'])."'"))) {
		die(error('CHAN!!', 'El usuario al que tratas de enviar el mensaje no existe', 'Centro de mensajes', '/mensajes/'));
        }

    if(!$resp->is_valid && $currentuser['rank'] == 0) { die(error('CHAN!', 'Debes completar correctamente las letras de verificaci&oacute;n', 'Centro de mensajes', '/mensajes/'));
	}
	$u = mysql_fetch_array($q);
	if($u['id'] == $currentuser['id']) { die(error('CHAN!!', 'No puedes enviarte mensajes a t&iacute; mismo', 'Centro de mensajes', '/mensajes/')); }
	$u['blocked_array'] = (empty($u['blocked']) ? array() : explode(',', $u['blocked']));
	if(in_array($currentuser['id'], $u['blocked_array'])) { die(error('CHAN!!', 'No puedes enviar el mensaje porque has sido bloqueado por el destinatario', 'Centro de mensajes', '/mensajes/')); }
	mysql_query("INSERT INTO `pms` (user_to, user_from, title, message, time) VALUES ('".$u['id']."','".$currentuser['id']."','".mysql_clean($_POST['msg_subject'])."','".mysql_clean($_POST['msg_body'])."','".time()."')");
	die(error('YEAH!', 'El mensaje se ha enviado correctamente', 'Centro de mensajes', '/mensajes/'));


}
// 360 303 303
?>
<div id="cuerpocontainer">
<div class="container230 floatL">
	<div class="box_title"><div class="box_txt mensajes_carpetas">Carpetas</div><div class="box_rss"/>
	</div></div>
	<div class="box_cuerpo">
		<img src="/images/icon-mensajes-recibidos.gif" align="absmiddle" /> <a href="/mensajes/" class="m-menu">Mensajes Recibidos</a> <?php $rows = mysql_num_rows(mysql_query("SELECT * FROM `pms` WHERE user_to = '".$currentuser['id']."' && readed_to = '0' && deleted_to = '0'"));
		if($rows) { echo '('.$rows.')'; } ?><br />
		<img src="/images/icon-mensajes-enviados.gif" align="absmiddle" /> <a href="/mensajes/enviados/" class="m-menu">Mensajes Enviados</a><br />
		<img src="/images/icon-mensajes-eliminados.gif" align="absmiddle" /> <a href="/mensajes/eliminados/" class="m-menu">Mensajes Eliminados</a><br /><br />
		<img src="/images/icon-escribir-mensaje.gif" align="absmiddle" /> <a href="/mensajes/redactar/"  class="m-menu">Escribir mensaje</a><br /><br />


		Carpetas personales:<br />
		<?php
		// $currentuser['pm_dir'] = NOMBRE:NOMBRE:NOMBRE [SOLO a-z 0-9]
        if(!empty($currentuser['pm_dir'])) {
			$dirs = explode(':', $currentuser['pm_dir']);
			foreach($dirs as $dir) {
				echo '<img src="/images/icon-mensajes-carpeta.gif" align="absmiddle" />  <a href="/mensajes/carpetas-personales/'.$dir.'" class="m-menu">'.$dir.'</a> <a href="#" title="Opciones de la carpeta" onclick="document.getElementById(\'opciones_carpeta_'.$dir.'\').style.display = \'inline\';return false;">  <img src="/images/icon-mensajes-carpeta-opc.gif" align="absmiddle" border="0" /></a>
		<div id="opciones_carpeta_'.$dir.'" style="display:none;">
		<div style="display:inline;" id="opciones_carpeta_'.$dir.'"><br /><form name="mensajes_form_'.$dir.'" method="post"><input name="carpeta_nombre" onblur="if(this.value == \'\'){this.value = \'Cambiar nombre\';}" onfocus="if(this.value == \'Cambiar nombre\'){this.value = \'\';}" value="Cambiar nombre" size="17" /> <input class="button" title="Cambiar nombre de carpeta" onclick="document.getElementById(\'hidden_'.$dir.'\').value = \'cambiar\';" value="Cambiar" type="submit" /><input style="margin-top:5px;" class="button" title="Eliminar carpeta" onclick="document.getElementById(\'hidden_'.$dir.'\').value = \'eliminar\';" value="Eliminar carpeta" type="submit" /><input type="hidden" id="hidden_'.$dir.'" name="hidden_carpeta_accion" /><input type="hidden" name="carpeta" value="'.$dir.'" /></form></div>
		</div>
    <br />';
			}
		} else {
			echo 'No hay carpetas creadas<br />';
		}
		?>
    <br />
 
<div id="crear_carpeta_link" onclick="document.getElementById('crear_carpeta_div').style.display = 'block';return false;" style="cursor:pointer;">+ Crear carpeta<br /><br /></div>
<div id="crear_carpeta_div" style="display:none">
<form method="post" action="/mensajes/crear-carpeta">
Crear nueva carpeta:<br />
<input type="text" name="carpeta_nombre" size="30" /><br />
<input style="margin-top:5px;" class="button" type="submit" value="Crear carpeta" /> <input style="margin-top:5px;" class="button" type="button" value="Cancelar" onclick="document.getElementById('crear_carpeta_div').style.display = 'none';" />
</form>
</div>
</div>
 
</div>    <form name="mensajes" method="post">
		<div class="container702 floatR">
			<div id="m-mensaje" style="display:none;"></div>
      <div class="box_title">
    <?php
	if($sa == 'read') {
		echo '<div class="box_txt mensajes_ver" style="width:694px;height:2px;text-align:center;font-size:12px">'.$pm['title'].'</div>';
	} else {
		echo '<div class="box_txt mensajes_titulo">'.($sa == 'dir' ? 'Carpeta: '.$_dir : ($sa == 'new' ? 'Enviar un mensaje' : 'Carpeta: '.$sa)).'</div>';
	}
	?>
				<div class="box_rss"></div>
			</div>
			
			<div class="box_cuerpo" style="<?=($sa == 'read' ? 'width:686px;' : 'padding:0;');?>">
            	<?php
				if($sa == 'new') {
					if($_GET['to']) {
						$query = mysql_query("SELECT id, nick FROM `users` WHERE nick = '".mysql_clean($_GET['to'])."'");
						if(!mysql_num_rows($query)) {
							unset($_GET['to']);
						} else {
							$to = mysql_fetch_array($query);
							if($_GET['replyto']) {
								$query = mysql_query("SELECT title, message, time FROM `pms` WHERE id = '".mysql_clean($_GET['replyto'])."' && (user_to = '".$currentuser['id']."' || user_from = '".$currentuser['id']."')");
								if(!mysql_num_rows($query)) {
									unset($_GET['replyto']);
								} else {
									$replyto = mysql_fetch_array($query);
								}
							}
						}
					}
					?>
					<form name="compose" action="/mensajes/redactar/" method="post" style="padding:0px; margin:0px;" onsubmit="return mensajes_validar();">
		<div class="m-col1">De:</div>
		<div class="m-col2"><strong><?=$currentuser['nick'];?></strong></div>
		<div class="m-col1">Para:</div>
		<div class="m-col2"><input name="msg_to" type="text" size="20" tabindex="0" maxlength="120" value="<?=$to['nick'];?>"> <span style="font-size:10px">(Ingrese el nombre de usuario)</span>
    </div>
		<div class="m-col1">Asunto:</div>
		<div class="m-col2"><input name="msg_subject" type="text" size="35" tabindex="1" maxlength="120" value="<?=($replyto ? 'RE: '.$replyto['title'] : '(Sin asunto)');?>"></div>
		<div class="m-col1">Mensaje:</div>
		<div class="m-col2e">
			<textarea id="markItUp" name="msg_body" rows="10" style="width:590px; height:200px;" tabindex="2"><?php if($replyto) {
				echo 'El '.udate('d.m.Y', $replyto['time']).' a las '.udate('H:i:s', $replyto['time']).', '.$to['nick'].' escribi&oacute;:'."\n".$replyto['message']."\n"; }
				?></textarea>
			<div id="emoticons" style="float:left">
								<a href="#" smile=":)"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-286px; clip:rect(286px 16px 302px 0px);" alt="sonrisa" title="sonrisa" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile=";)"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-308px; clip:rect(308px 16px 324px 0px);" alt="gui&ntilde;o" title="gui&ntilde;o" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile=":roll:"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-330px; clip:rect(330px 16px 346px 0px);" alt="duda" title="duda" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile=":P"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-352px; clip:rect(352px 16px 368px 0px);" alt="lengua" title="lengua" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile=":D"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-374px; clip:rect(374px 16px 390px 0px);" alt="alegre" title="alegre" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile=":("><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-396px; clip:rect(396px 16px 412px 0px);" alt="triste" title="triste" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile="X("><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-418px; clip:rect(418px 16px 434px 0px);" alt="odio" title="odio" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile=":cry:"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-440px; clip:rect(440px 16px 456px 0px);" alt="llorando" title="llorando" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile=":twisted:"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-462px; clip:rect(462px 16px 478px 0px);" alt="endiablado" title="endiablado" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile=":|"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-484px; clip:rect(484px 16px 500px 0px);" alt="serio" title="serio" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile=":?"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-506px; clip:rect(506px 16px 522px 0px);" alt="duda" title="duda" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile=":cool:"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-528px; clip:rect(528px 16px 544px 0px);" alt="picaro" title="picaro" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile=":oops:"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-550px; clip:rect(550px 16px 566px 0px);" alt="timido" title="timido" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile="^^"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-572px; clip:rect(572px 16px 588px 0px);" alt="sonrizota" title="sonrizota" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile="8|"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-594px; clip:rect(594px 16px 610px 0px);" alt="increible!" title="increible!" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
				<a href="#" smile=":F"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-616px; clip:rect(616px 16px 632px 0px);" alt="babaaa" title="babaaa" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
			</div>
			<script type="text/javascript">function openpopup(){var winpops=window.open("/emoticones.php","","width=180px,height=500px,scrollbars,resizable");}</script>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:openpopup()'>M&aacute;s Emoticones</a>   </br>
            </br> 
            <tr>
								<?php if($currentuser['rank'] == 0) { ?>
								<td align="right" valign="top"><b>C&oacute;digo de la im&aacute;gen</b>:<span style="color:#F00;">*</span></td>
								<td><script type="text/javascript">var RecaptchaOptions={theme:"clean", lang:"es", tabindex:"17", custom_theme_widget:"recaptcha_widget"};</script>
<?=recaptcha_get_html($config['recaptcha_publickey']);?></td> <? } ?>
									</div>
		<div class="m-col1"></div>
		<br clear="left">	
	</div>
	<div class="m-bottom"><input type="submit" class="button" value="Enviar mensaje" name="new-pm"></div>
	</form>
				<?php
				} elseif($sa == 'read') {
					$ouser = mysql_fetch_array(mysql_query("SELECT id, nick FROM `users` WHERE id = '".$pm[($pm['user_to'] == $currentuser['id'] ? 'user_from' : 'user_to')]."'"));
					if($pm['readed_'.($pm['user_to'] == $currentuser['id'] ? 'to' : 'from')] == '0') {
						mysql_query("UPDATE `pms` SET readed_".($pm['user_to'] == $currentuser['id'] ? 'to' : 'from')." = '1' WHERE id = '".$pm['id']."'");
					}
					if($pm['user_from'] == '0') {
						echo '<div class="m-col1">De:</div>
				<div class="m-col2"><strong>Turinga</strong></div>';
					} else {
						echo '<div class="m-col1">'.($currentuser['id'] == $pm['user_to'] ? 'De' : 'Para').':</div>
				<div class="m-col2"><strong><a href="/perfil/'.$ouser['id'].'/id" alt="Ver Perfil" title="Ver Perfil">'.$ouser['nick'].'</a></strong></div>';
					}
				echo '<div class="m-col1">Enviado:</div>
				<div class="m-col2">'.udate('Y-m-d H:i:s', $pm['time']).'</div>
				<div class="m-col1">Asunto:</div>
				<div class="m-col2">'.$pm['title'].'</div>
				<div class="m-col1">Mensaje:</div>
				<div class="m-col2m">'.($pm['user_from'] == '0' ? utf8_encode(bbcode($pm['message'])) : bbcode($pm['message'])).'<br /></div>
				<br clear="left" />
			</div>
			<div class="m-bottom">
				<div class="m-borrar" style="width:700px;">';
				if($pm['user_to'] == $currentuser['id']) { echo '<input type="button" class="button" value="Responder" onclick="document.location = \'/mensajes/para/'.$ouser['nick'].'/'.$pm['id'].'/\';">&nbsp;&nbsp;'; }
				echo '<input type="hidden" id="mensajes_accion" name="accion" /><input name="m_o_'.$pm['id'].'" type="hidden" value="'.$pm['id'].'" />';
				echo '<input type="button" class="button" value="Eliminar" onclick="document.getElementById(\'mensajes_accion\').value = \'eliminar\'; document.mensajes.submit();">&nbsp;&nbsp;';
				if($pm['user_to'] == $currentuser['id']) { echo '<input type="button" class="button" value="Marcar como no le&iacute;do" onclick="document.getElementById(\'mensajes_accion\').value = \'NL\'; document.mensajes.submit();">&nbsp;&nbsp;'; }
 
					echo '<select id="mover_a_carpeta" onchange="if(this.options[this.selectedIndex].value != 0) {document.getElementById(\'mensajes_accion\').value = \'mover\'; document.mensajes.submit(); }">
						<option value="0">Mover a la carpeta</option>';
						foreach($dirs as $dir) { echo '<option value="'.$dir.'">'.$dir.'</option>'; }
					echo '</select>
        </div>
			</div>';
				} else {
				?>
				<div class="m-top">
					<div class="m-opciones"></div>
                    <?php
					if($sa == 'trash' || $sa == 'dir') {
						echo '<div class="m-remitente">Remitente</div>
						<div class="m-destinatario">Destinatario</div>
						<div class="m-asunto-carpetas">Asunto</div>';
					} else {
						echo '<div class="m-'.($sa == 'outbox' ? 'destinatario' : 'remitente').'">'.($sa == 'outbox' ? 'Destinatario' : 'Remitente').'</div>
						<div class="m-asunto">Asunto</div>';
					}
					?>
					<div class="m-fecha">Fecha</div>
				</div>
                <?php
				// deleted_from/to -> 0 => no 1 => basura 2 => definitivo
				if($sa != 'trash') {
					$q = "SELECT * FROM `pms` WHERE ".($sa == 'outbox' ? 'user_from' : 'user_to')." = '".$currentuser['id']."' AND ".($sa == 'inbox' ? 'deleted_to' : 'deleted_from')." = '0'";
				} else {
					$q = "SELECT * FROM `pms` WHERE (user_to = '".$currentuser['id']."' && deleted_to = '1') OR (user_from = '".$currentuser['id']."' && deleted_from = '1')";
				}
				if($sa == 'dir') { $q .= " AND ((user_to = '".$currentuser['id']."' AND dir_to = '".$_dir."') OR (user_from = '".$currentuser['id']."' AND dir_from = '".$dir."'))"; } else { $q .= " AND ((user_to = '".$currentuser['id']."' AND dir_to = '0') OR (user_from = '".$currentuser['id']."' AND dir_from = '0'))"; }
				$query = mysql_query($q) or die(mysql_error());
				$tp = ceil(mysql_num_rows($query));
				$pn = (eregi('^[0-9]+$', $_GET['pn']) && $_GET['pn'] ? $_GET['pn'] : 1);
				if($pn > $tp) { $pn = $tp; }
				if($pn < 1) { $pn = 1; }
				$pn--;
				$minp = $pn*10;
				$maxp = $pn+10;
				$pn++;
				$q .= " ORDER BY time DESC LIMIT ".$minp.",".$maxp;
				$query = mysql_query($q);
				if(!mysql_num_rows($query)) {
					echo '<div class="m-linea-mensaje" style="text-align:center;">Nada por aqu&iacute;...</div>';
				} else {
					echo '<script type="text/javascript">var men_leidos = new Array();</script>';
					while($pm = mysql_fetch_array($query)) {
						unset($fT);
						if($pm['user_from'] == '0') { $fT = true; }
						$ooc = ($sa == 'outbox' || $pm['readed_'.($pm['user_to'] == $currentuser['id'] ? 'to' : 'from')] == '1' ? '-open' : '');
						$ouser = mysql_fetch_array(mysql_query("SELECT id, nick FROM `users` WHERE id = '".$pm[($pm['user_to'] == $currentuser['id'] ? 'user_from' : 'user_to')]."'"));
						echo '<script type="text/javascript">men_leidos[(men_leidos.length-1)] = "m_o_'.$pm['id'].'";</script>
						<div class="m-linea-mensaje'.$ooc.'">
						<div class="m-opciones'.$ooc.'"><input name="m_o_'.$pm['id'].'" value="'.$pm['id'].'" type="checkbox"> <a href="/mensajes/leer/'.$pm['id'].'" alt="Leer mensaje" title="Leer mensaje"><img src="/images/icon-email'.$ooc.'.png" align="absmiddle" border="0"></a></div>';
						if($sa != 'outbox') {
							if($fT) {
								echo '<div class="m-remitente'.$ooc.'">Turinga</div>';
							} else {
								echo '<div class="m-remitente'.$ooc.'"><a href="/perfil/'.$ouser['id'].'/id"  alt="Ver Perfil" title="Ver Perfil">'.$ouser['nick'].'</a></div>';
							}
						}
						if($sa != 'inbox') {
							echo '<div class="m-destinatario'.$ooc.'"><a href="/perfil/'.$ouser['id'].'/id"  alt="Ver Perfil" title="Ver Perfil">'.$ouser['nick'].'</a></div>';
						}
						echo '<div class="m-asunto'.($sa == 'dir' || $sa == 'trash' ? '-carpetas' : '').$ooc.'"><a href="/mensajes/leer/'.$pm['id'].'"  alt="Leer mensaje" title="'.$pm['title'].'">'.$pm['title'].'</a></div>
						<div class="m-fecha'.$ooc.'">'.udate('Y-m-d H:i:s', $pm['time']).'</div>
					</div>';
					}
				}
				?>
				<div class="m-bottom">
				  <div class="m-seleccionar">
Seleccionar: <a class="m-seleccionar-text" href="#" onclick="mensajes_check(1);return false;">Todos</a>, <a class="m-seleccionar-text" href="#" onclick="mensajes_check(2);return false;">Ninguno</a>, <a class="m-seleccionar-text" href="#" onclick="mensajes_check(3);return false;">Le&iacute;dos</a>, <a class="m-seleccionar-text" href="#" onclick="mensajes_check(4);return false;">No le&iacute;dos</a>, <a class="m-seleccionar-text" href="#" onclick="mensajes_check(5);return false;">Invertir</a>
				  </div>
					<div class="m-borrar">
<input type="button" class="button" value="<?=($sa == 'trash' ? 'Eliminar definitivamente' : 'Eliminar');?>" onclick="document.getElementById('mensajes_accion').value = 'eliminar'; document.mensajes.submit();">
							<select name="marcar" onchange="if(this.options[this.selectedIndex].value != 0) { document.getElementById('mensajes_accion').value = this.options[this.selectedIndex].value; document.mensajes.submit(); }">
								<option value="0">Acciones:</option>
								<option value="L">Marcar como le&iacute;do</option>
								<option value="NL">Marcar como no le&iacute;do</option>
							</select> 
 <input id="mensajes_accion" type="hidden" name="accion" />
					<select name="mover_a_carpeta" onchange="if(this.options[this.selectedIndex].value != 0) { document.getElementById('mensajes_accion').value = 'mover'; document.mensajes.submit(); }">
						<option value="0">Mover a la carpeta</option>
						<?php foreach($dirs as $dir) { echo '<option value="'.$dir.'">'.$dir.'</option>'; } ?>
					</select>
</div>
				  &nbsp;&nbsp;<?php
						$pu = '/mensajes/';
						$pu .= ($sa == 'inbox' ? 'recibidos' : ($sa == 'outbox' ? 'enviados' : ($sa == 'trash' ? 'eliminados' : 'carpetas-personales')));
						$pu .= '/pagina';
                  				if($pn != 1) {
									echo '<a href="'.$pu.($pn-1).'">&laquo; Anterior</a>';
								}
								if($pn != 1 && $pn != $tp) { echo '&nbsp;&nbsp;'; }
								if($pn != $tp) {
									echo '<a href="'.$pu.($pn+1).'">Siguiente &raquo;</a>';
								}
							  ?>
				</div>
			</div>
            <? } /* READ */ ?>
		</div>
		</form>
	<div style="clear:both"></div>
	<hr />
<center><?=advert('728x90');?></center><div style="clear:both"></div>
</div><!--cc-->