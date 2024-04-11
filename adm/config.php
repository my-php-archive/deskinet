<?php
if(!defined('admin')) { header('Location: /index.php'); }
if($currentuser['rank'] != 8) { echo 'No tienes permiso para acceder aqu&iacute;...'; } else {
if($_POST) {
	$vars = array('db_server', 'db_name', 'db_user', 'db_password', 'script_name', 'script_name2', 'script_sl', 'script_desc', 'script_url', 'lang', 'cookie_name', 'define', 'recaptcha_privatekey', 'recaptcha_publickey', 'min_age', 'noreply_email', 'maintenance');
	if(!$_POST['db_password'] || empty($_POST['db_password'])) {
		$_POST['db_password'] = $config['db_password'];
	}
	if(!$_POST['script_url'] || empty($_POST['script_url'])) {
		$_POST['script_url'] = $_SERVER['HTTP_HOST'];
	}
	$_POST['maintenance'] = ($_POST['maintenance'] ? 'true' : 'false');
	if(count($_POST) != count($vars)) {
		echo '<center>Faltan datos...<br><br><a href="/admin/configuracion">Reintentar</a></center>';
		$error = true;
	}
	if(!$error) {
		foreach($vars as $var) {
			if(!$_POST[$var]) {
				echo '<center>Faltan datos...<br><br><a href="/admin/configuracion">Reintentar</a></center>';
				$error = true;
				break;
			}
		}
	}
	if(!$error) {
		$file = file('../config.php', FILE_USE_INCLUDE_PATH);
		$vars = array('db_server', 'db_name', 'db_user', 'db_password', 'script_name', 'script_name2', 'script_sl', 'script_desc', 'script_url', 'lang', 'cookie_name', 'define', 'recaptcha_privatekey', 'recaptcha_publickey', 'min_age', 'noreply_email', 'maintenance');
		$nc = array('maintenance', 'min_age');
		$implode = 'WTF|'.implode('|', $vars).'|FTW';
		$content = '';
		foreach($file as $line => $text) {
			if(preg_match("/^\$config\['".$implode."'\]/", $text, $match) && substr($text, 0, 7) == '$config') {
				$explode = explode(';', $text, 2);
				$content .= '$config[\''.$match[0].'\'] = '.(in_array($match[0], $nc) ? $_POST[$match[0]] : '\''.$_POST[$match[0]].'\'').';'.$explode[1];
			} else {
				$content .= $text;
			}
			$content .= "\n";
		}
		$write = fopen('/config.php', 'w', true);
		fwrite($write, $content);
		fclose($write);
		echo '<center>Los cambios se han realizado correctamente<br><br><a href="/">Ir a la p&aacute;gina principal</a></center>';
	}
} else {
?>
<form name="conf" method="post" onsubmit="admin_rank(this);" action="/admin/configuracion/">
<strong>Datos de conexi&oacute;n a la base de datos:</strong>
<br />
<br />
Servidor:
<br />
<input type="text" name="db_server" value="<?=$config['db_server'];?>" />
<br />
Nombre de la base de datos:
<br />
<input type="text" name="db_name" value="<?=$config['db_name'];?>" />
<br />
Usuario de la base de datos:
<br />
<input type="text" name="db_user" value="<?=$config['db_user'];?>" />
<br />
Contrase&ntilde;a de la base de datos <span style="font-size:7pt;">(Por seguridad, no se muestra, pero si lo dejas en blanco no cambiar&aacute;)</span>: 
<br />
<input type="password" name="db_password" />
<br />
<br />
<strong>Configuraci&oacute;n de la web:</strong>
<br />
<br />
Nombre de la web completo:
<br />
<input type="text" name="script_name" value="<?=$config['script_name'];?>" />
<br />
Nombre de la web sin signos, en minusculas:
<br />
<input type="text" name="script_name2" value="<?=$config['script_name2'];?>" />
<br />
Letra de abreviatura <span style="font-size:7pt;">(EJ: Si el nombre es Wescript!, la letra ser&aacute; W!)</span>:
<br />
<input type="text" name="script_sl" value="<?=$config['script_sl'];?>" />
<br />
Descripci&oacute;n de la web <span style="font-size:7pt;">(Peque&ntilde;a frase)</span>:
<br />
<input type="text" name="script_desc" value="<?=$config['script_desc'];?>" />
<br />
Direcci&oacute;n URL <span style="font-size:7pt;">(Dejalo en blanco si quieres, para que coja la URL automaticamente)</span>:
<br />
<input type="text" name="script_url" value="<?=$config['script_url'];?>" />
<br />
Edad m&iacute;nima para entrar <span style="font-size:7pt;">(0 (cero) o en blanco para que no halla l&iacute;mite)</span>:
<br />
<input type="text" name="min_age" value="<?=$config['min_age'];?>" />
<br />
Lenguaje por defecto <span style="font-size:7pt;">(Debe existir en la carpeta /Texts/)</span>:
<br />
<input type="text" name="lang" value="<?=$config['lang'];?>" />
<br />
Correo para mensajes automaticos:
<br />
<input type="text" name="noreply_email" value="<?=$config['noreply_email'];?>" />
<br />
<br />
<strong>Recaptcha:</strong><br />
<br />
<br />
Public key:
<br />
<input type="text" name="recaptcha_publickey" value="<?=$config['recaptcha_publickey'];?>" />
<br />
Private key:
<br />
<input type="text" name="recaptcha_privatekey" value="<?=$config['recaptcha_privatekey'];?>" />
<br />
<br />
<strong>Otros datos de la web:</strong> <a style="font-size:7pt;" href="#" onclick="document.getElementById('odw').style.display = 'block';return false;">(Mostrar)</a>
<div style="display:none;" id="odw">
<br />
Nombre de la cookie:
<br />
<input type="text" name="cookie_name" value="<?=$config['cookie_name'];?>" />
<br />
Nombre del "define":
<br />
<input type="text" name="define" value="<?=$config['define'];?>" />
<br />
</div>
<br />
<br />
<strong>Mantenimiento:</strong>&nbsp;&nbsp;<input type="checkbox" name="maintenance"<?=($config['maintenance'] === true ? ' checked' : '');?> />
<br />
<br />
<input type="submit" class="button" style="font-size:14px;" value="Cambiar configuraci&oacute;n" />
</form>
<? } /*POST*/ } /* RANGO */ ?>