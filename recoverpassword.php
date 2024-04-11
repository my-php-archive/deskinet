<?php 
if(!$_POST['email'] || !$_POST['recaptcha_response_field'] || !$_POST['recaptcha_challenge_field']) { die('-.-'); }
include('../config.php');
mysql_query("DELETE FROM `recover_codes` WHERE time < '".(time()-86400)."'");
include('../functions.php');
if(isLogged()) { die('No puedes recuperar tu contrase&ntilde;a'); }
if(!preg_match('/^[a-z0-9_\.\-]{1,64}@[a-z0-9_\.\-]{1,255}\.([a-z]{2,3})+$/i', $_POST['email'])) { die('El email no es v&aacute;lido'); }
if(!mysql_num_rows(mysql_query("SELECT id FROM `users` WHERE email = '".mysql_clean($_POST['email'])."'"))) { die('No hay ning&uacute;n usuario con este email'); }
include('../recaptcha.php');
if(!recaptcha_check_answer($config['recaptcha_privatekey'], $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field'])) { die('El c&oacute;digo no es correcto'); }

$l = array_merge(range('0','9'), range('a', 'z'), range('A', 'Z'));
$c = count($c)-1;
do {
	for($i=1;$i<=15;$i++) {
		$code .= $l[mt_rand(0, $c)];
	}
} while(!mysql_num_rows(mysql_query("SELECT id FROM `recover_codes` WHERE code = '".$code."'")));
mysql_query("INSERT INTO `recover_codes` (email, code, time) VALUES ('".mysql_clean($_POST['email'])."', '".$code."', '".time()."')");
$message = "Hola\n\nHemos recibido una petición para recuperar contraseña con este email, si no la has pedido tú, ignora este email.\n\nPara restablecer tu contraseña, accede al siguiente link:\n\nhttp://turingax.net/password/".mysql_insert_id()."/".$code."/\n\nSaludos, el staff de Turinga!";
$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/plain; charset=iso-8859-1\n";
$headers .= "From: ".$config['script_name']." <".$config['noreply_email'].">\n";
//$headers .= "To:  <".$_POST['email'].">\n";
$headers .= "Reply-To: ".$config['noreply_email']."\n";
$headers .= "X-Priority: 1\n";
$headers .= "X-MSMail-Priority: High\n";
$headers .= "X-Mailer: PHP/".phpversion();
// \r\n al final???
mail($_POST['email'], 'Restablecer contraseña en '.$config['script_name2'], $message, $headers);
die('1');
?>