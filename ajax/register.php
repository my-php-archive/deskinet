<?php
include('../config.php');
include('../functions.php');
// Comprobar country = pais y eso de la db y cosas asi

if(isLogged()) { die('0:No puedes acceder si est&aacute;s logeado'); }

include('../recaptcha.php');

$dac = false; // true dice la url para activar, false no

// Bloquear emails de ciertas URL ^^
$blockedurls = array('@yopmail.com','@yopmail.fr','@yopmail.net','@jetable.fr.nf','@nospam.ze.tc','@nomail.xl.cx','@mega.zik.dj','@speed.1s.fr','@cool.fr.nf','@courriel.fr.nf','@moncourrier.fr.nf','@monemail.fr.nf','@monmail.fr.nf');

// NOTA: Si va mal el registro, sencillamente paro la ejecución del script, que para algo está el javascript...
$error = null;
if($_POST) {
	$_POST['dia'] = (int) $_POST['dia'];
	$_POST['mes'] = (int) $_POST['mes'];
	if(strlen($_POST['anio']) == 2) { $_POST['anio'] = (int) '19'.$_POST['anio']; }
	// test email - users
$resp = recaptcha_check_answer($config['recaptcha_privatekey'], $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
if(!$_POST['nick'] || !$_POST['password'] || !$_POST['email'] || !$_POST['dia'] || !$_POST['mes'] || !$_POST['anio'] || !$_POST['sexo'] || !$_POST['recaptcha_challenge_field'] || !$_POST['recaptcha_response_field'] || !$_POST['pais'] || !$_POST['provincia'] || !$_POST['ciudad']) { die('0:Faltan campos'); }
if(empty($_POST['nick']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['dia']) || empty($_POST['mes']) || empty($_POST['anio']) || empty($_POST['recaptcha_response_field'])) { die('0:Has dejado alg&uacute;n campo en blanco'); }
if(strlen($_POST['nick']) < 6 || strlen($_POST['nick']) > 15) { die('nick:El nick debe tener entre 6 y 15 caracteres'); }
if(strlen($_POST['password']) < 6 || strlen($_POST['password']) > 35) { die('password:La contras&ntilde; debe tener entre 6 y 32 caracteres'); }
if(strlen($_POST['email']) > 35) { die('email:El email no puede tener m&aacute;s de 35 caracteres'); }
if(!preg_match('/^[a-z0-9_]+$/i', $_POST['nick'])) { die('nick:El nick solo puede tener caracteres alfanumericos (n&acute;meros y letras, excepto la &ntilde;)'); }
if(mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE nick = '".mysql_clean($_POST['nick'])."'"))) { die('nick:El nick ya est&aacute; en uso'); }
if(!preg_match('/^[a-z0-9_\.\-]{1,64}@[a-z0-9_\.\-]{1,255}\.([a-z]{2,3})+$/i', $_POST['email'])) { die('email:El email no es v&aacute;lido'); }
foreach($blockedurls as $url) {
	if(strpos($_POST['email'], $url) !== false) { die('email:No permitimos emails '.$url); break; }
}
if(mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE email = '".mysql_clean($_POST['email'])."'"))) { die('email:El email ya est&aacute; en uso'); }
if(!preg_match('/^[a-z0-9]+$/i', $_POST['password'])) { die('password:La contrase&ntilde;a solo puede tener letras, n&uacute;meros y gui&oacute;n bajo)'); }
//if($_POST['password'] != $_POST['password2']) { die('password:Las contrase&ntilde;as no coinciden'); }
if(!mysql_num_rows(mysql_query("SELECT id FROM `countries` WHERE id = '".mysql_clean($_POST['pais'])."'"))) { die('pais:No existe el pa&iacute;s'); }
if(!mysql_num_rows(mysql_query("SELECT id FROM `provinces` WHERE id = '".mysql_clean($_POST['provincia'])."' && country = '".mysql_clean($_POST['pais'])."'"))) { die('provincia:No existe la provincia o no corresponde al pa&iacute;s'); }
if(empty($_POST['ciudad'])) {
  if(!mysql_num_rows(mysql_query("SELECT id FROM `cities` WHERE province = '".mysql_clean($_POST['provincia'])."'"))) {
    $_POST['ciudad'] = '0';
    $_POST['ciudad_text'] = 'Indefinido';
  } else {
    die('ciudad:Pon tu ciudad');
  }
} else {
  if(!mysql_num_rows($q=mysql_query("SELECT name FROM `cities` WHERE id = '".mysql_clean($_POST['ciudad'])."' && province = '".mysql_clean($_POST['provincia'])."'"))) { die('ciudad:La ciudad no existe o no corresponde a la provincia'); }
  $f = mysql_fetch_row($q);
  $_POST['ciudad_text'] = $f[0];
}
if((($_POST['mes'] == 2 && $_POST['dia'] > 29) || (($_POST['mes']%2) == 0 && $_POST['dia'] > 30) || (($_POST['mes']%2) != 0 && $_POST['dia'] > 31)) || $_POST['mes'] > 12 || $_POST['anio'] > (date('Y')-$config['min_age']) || strlen($_POST['anio']) != 4 || !preg_match('/^[0-9]+$/', $_POST['dia']) || !preg_match('/^[0-9]+$/', $_POST['mes']) || !preg_match('/^[0-9]+$/', $_POST['anio'])) { die('nacimiento:La fecha de nacimiento no es v&aacute;lida'); }
if(!$resp->is_valid) { die('recaptcha:El c&oacute;digo de la imagen no es correcto'); }
if(!$_POST['terminos']) { die('terminos:Debes aceptar los terminos y condiciones'); }
mysql_query("INSERT INTO `users` (nick, password, email, country, province, city, city_text, birth_day, birth_month, birth_year, gender, reg_time, newsletter, avatar) VALUES ('".mysql_clean($_POST['nick'])."','".md5($_POST['password'])."','".mysql_clean($_POST['email'])."','".mysql_clean($_POST['pais'])."','".mysql_clean($_POST['provincia'])."','".mysql_clean($_POST['ciudad'])."', '".mysql_clean($_POST['ciudad_text'])."', '".(strlen($_POST['dia']) == 1 ? '0'.$_POST['dia'] : $_POST['dia'])."','".(strlen($_POST['mes']) == 1 ? '0'.$_POST['mes'] : $_POST['mes'])."','".mysql_clean($_POST['anio'])."','".($_POST['sexo'] == 'm' ? '1' : '2')."','".time()."','".($_POST['noticias'] ? '1' : '0')."', 'a32_".mt_rand(1, 5)."')") or die('0Ha ocurrido un error, contacta con un administrador'."\n\n");
mysql_query("UPDATE `users` SET avatar = '0.gif?".mysql_insert_id()."' WHERE id = '".mysql_insert_id()."'");
$c = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
$count = count($c)-1;
$r = mt_rand(12, 15);
for($i=1;$i<=$r;$i++) {
	$hash .= $c[mt_rand(0, $count)];
}
$message = 'Hola '.$_POST['nick'].':';
$message .= "\n\n";
$message .= 'Bienvenido a '.$config['script_name'];
$message .= "\n\n";
$message .= "Para confirmar tu dirección de correo electrónico ingresa al siguiente link:";
$message .= "\n\n";
$message .= 'http://'.$config['script_url'].'/registro-confirmar/'.$hash.'/'.str_replace('@', '/', $_POST['email']).'/';
$message .= "\n\n";
$message .= 'Muchas gracias, ¡y que lo disfrutes!';
$message .= "\n\n";
$message .= 'El staff de '.$config['script_name'];
$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/plain; charset=iso-8859-1\n";
$headers .= "From: ".$config['script_name']." <".$config['noreply_email'].">\n";
$headers .= "To: ".$_POST['nick']." <".$_POST['email'].">\n";
$headers .= "Reply-To: ".$config['noreply_email']."\n";
$headers .= "X-Priority: 1\n";
$headers .= "X-MSMail-Priority: High\n";
$headers .= "X-Mailer: PHP/".phpversion();
// \r\n al final???
mail($_POST['email'], 'Registro en '.$config['script_name2'], $message, $headers);
mysql_query("INSERT INTO `confirmemail` (email, hash, time) VALUES ('".mysql_clean($_POST['email'])."','".$hash."','".time()."')") or die(mysql_error());
if($dac) {
	$dact = '<br />Por motivos del host, te dejamos aqu&iacute;la URL de activaci&oacute;n:<br /><a href="http://'.$config['script_url'].'/registro-confirmar/'.$hash.'/'.str_replace('@', '/', $_POST['email']).'/">http://'.$config['script_url'].'/registro-confirmar/'.$hash.'/'.str_replace('@', '/', $_POST['email']).'/</a>';
}
//die('Te has registrado en '.$config['script_name'].', una vez que confirmes el EMail que te hemos enviado podr&aacute;s logearte.<br />Es posible que el email tarde en llegar o llega a la carpeta de correo no deseado (spam).'.$dact);
die('1:Te hemos enviado un correo a <b>'.htmlspecialchars($_POST['email']).'</b> con los &uacute;ltimos pasos para finalizar con el registro.
<br />
<br />
Si en los pr&oacute;ximos minutos no lo encuentras en tu bandeja de entrada, por favor, revisa tu carpeta de correo no deseado, es posible que se haya filtrado.
<br />
<br />
&iexcl;Muchas gracias!');
}
?>