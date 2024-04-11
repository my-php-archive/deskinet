<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if(isLogged()) { die; }
if(($_GET['id'] && !$_GET['code']) || ($_GET['code'] && !$_GET['id'])) { die(error('OOPS', 'Faltan datos', array('Ir a la p&aacute;gina principal', 'Solicitar contrase&ntilde;a'), array('/', '/password/'))); }
echo '<div id="cuerpocontainer">';
if(!$_GET['id']) {
	include('./recaptcha.php');
?>
<script type="text/javascript"> 
function validate_data()
{
	var f=document.forms.pass;
 
	var fit='email'.split(',');
	for(var i=0; i<fit.length; i++)
	{
		if(f[fit[i]].value=='')
		{
			alert('El campo ' + fit[i] + ' es obligatorio.');
			f[fit[i]].focus();
			return false;
		}
	}
	if($('#recaptcha_response_field').val()==''){
		alert('El campo captcha es obligatorio.');
		$('#recaptcha_response_field').focus();
		return false;
	}
	
	var params = 'email=' + encodeURI(f.email.value);
	params += '&recaptcha_challenge_field=' + encodeURI($('#recaptcha_challenge_field').val());
	params += '&recaptcha_response_field=' + encodeURI($('#recaptcha_response_field').val());
 
	$('input[name=send_pass]').enablebutton(false);
	$('input[name=email], input[name=recaptcha_response_field]').attr('disabled', 'disabled');
 
	$.ajax({
		type: 'POST',
		url: '/ajax/recoverpassword.php',
		data: params,
		dataType: 'html',
		success: function(t) {
			if(t == '1')  {
				$('#cuerpocontainer').html('<div class="container400" style="margin: 10px auto 0 auto;"><div class="box_title"><div class="box_txt show_error">Atenci&oacute;n</div><div class="box_rrs"><div class="box_rss"></div></div></div><div class="box_cuerpo"  align="center"><br />Se envi&oacute; un email a la direcci&oacute;n de email especificada<br />El link del email dejar&aacute; de funcionar dentro de 24 horas.<br /><br /><input type="button" class="mBtn btnOk" style="font-size:13px" value="Ir a la p&aacute;gina principal" title="Ir a la p&aacute;gina principal" onclick="document.location = \'/\'"><br /></div></div>');
			} else {
				alert(t);
				$('input[name=send_pass]').enablebutton();
	$('input[name=email], input[name=recaptcha_response_field]').removeAttr('disabled');
			}
		}
	});
 
	return false;
} /* validate_data() */
</script>
	<div id="form_div">
		<div class="container940">
			<div class="box_title">
				<div class="box_txt recuperar_pass">Recuperar mi contrase&ntilde;a</div>
				<div class="box_rrs">
					<div class="box_rss"></div>
				</div>
			</div>
			<div class="box_cuerpo">	
				<center>
				<br />
				<b class="size13">Completa tu email y te enviaremos las instrucciones para cambiar tu clave</b>
				<br />
				<br />
				<form name="pass" method="post" onsubmit="return validate_data();">
					<table width="500" border="0"  cellpadding="2" cellspacing="4">
						<tr>
							<td width="30%" align="right"><strong>EMail:</strong></td>
							<td ><input type="text" size="25" name="email" tabindex="1" /></td>
						</tr>
						<tr>
							<td align="right"><strong>C&oacute;digo de la im&aacute;gen:</strong></td>
							<td>
								<script type="text/javascript">var RecaptchaOptions={theme:"clean", lang:"es", tabindex:"2", custom_theme_widget:"recaptcha_widget"};</script>
<?=recaptcha_get_html($config['recaptcha_publickey']);?>
							</td>
						</tr>
					</table>
					<br />
					<input type="submit" value="Aceptar" name="send_pass" tabindex="3" />
				</form>
				<br />
				<br />
				</b>
				</div>
			</div>
		</div>
<div style="clear:both"></div>
<? } else { // get y eso
	mysql_query("DELETE FROM `recover_codes` WHERE time < '".(time()-86400)."'");
	if(!mysql_num_rows($q = mysql_query("SELECT email FROM `recover_codes` WHERE id = '".mysql_clean($_GET['id'])."' && code = '".mysql_clean($_GET['code'])."'"))) {  die(error('OOPS', 'Los datos son incorrectos, o ya ha expirado el tiempo.', array('Ir a la p&aacute;gina principal', 'Solicitar contrase&ntilde;a'), array('/', '/password/'))); }
	if($_POST) {
		if(!$_POST['password1'] || !$_POST['password2']) {
			$error = 'Escribe dos veces la contrase&ntilde;a';
		} elseif(strlen($_POST['password1']) < 6 || strlen($_POST['password1']) > 32) {
			$error = 'La contrase&ntilde;a debe tener entre 6 y 32 caracteres';
		} elseif($_POST['password1'] != $_POST['password2']) {
			$error = 'Las contrase&ntildes;as no coinciden';
		}
	}
	if(!$_POST || $error) { ?>
    <div id="form_div">
		<div class="container940">
			<div class="box_title">
				<div class="box_txt recuperar_pass">Recuperar mi password</div>
				<div class="box_rrs">
					<div class="box_rss"></div> 
				</div>
			</div>
			<div class="box_cuerpo">
				<center>
				<br />
				<b class="size13">Ingresa tu nueva contrase&ntilde;a</b>
				<br />
				<br />
                <? if($error) { echo '<span style="font-weight:bold;color:#F00;">'.$error.'</span><br />'; } ?>
				<form name="pass" method="post" action="/password/<?=$_GET['id'];?>/<?=$_GET['code'];?>/">
					<table width="500" border="0" cellpadding="2" cellspacing="4">
						<tr>
							<td width="30%" align="right"><strong>Contrase&ntilde;a:</strong></td>
							<td ><input type="password" size="25" name="password1"></td>
						</tr>
						<tr>
							<td width="30%" align="right"><strong>Confirmar contrase&ntilde;a:</strong></td>
							<td ><input type="password" size="25" name="password2"></td>
						</tr>
					</table>
					<br />
					<input type="submit" value="Aceptar" name="send_pass"/>
				</form>
				<br />
				<br />
				</b>
				</div>
			</div>
		</div>
<div style="clear:both"></div>
<?php
	} elseif($_POST && !$error) {
		$f = mysql_fetch_array($q);
		mysql_query("UPDATE `users` SET password = '".md5($_POST['password1'])."' WHERE email = '".$f['email']."'");
		mysql_query("DELETE FROM `recover_codes` WHERE id = '".mysql_clean($_GET['id'])."'");
		die(error('YEAH!', 'Has cambiado la contrase&ntilde;a', 'Ir a la p&aacute;gina principal', '/', false));
	} // POST
} /* get y eso */ ?>
</div>