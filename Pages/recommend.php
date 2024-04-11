<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
if(!isLogged()) { die(error('OOPS!', 'Logeate para ver esta secci&oacute;n', array('Registrarme', 'Logearme'), array('/registro/', 'javascript:open_login_box();document.location.hash = "#";'))); }
if(!$_GET['post'] || !mysql_num_rows($q = mysql_query("SELECT id, title, cat FROM `posts` WHERE id = '".mysql_clean($_GET['post'])."'"))) { die(error('OOPS!', 'El post no existe, puede que lo hayan borrado', 'Ir a la p&aacute;gina principal', '/')); }
list($id, $title, $cat) = mysql_fetch_row($q);
list($cat) = mysql_fetch_row(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$cat."'"));

if($_POST) {
	if(empty($_POST['email1']) && empty($_POST['email2']) && empty($_POST['email3']) && empty($_POST['email4']) && empty($_POST['email5']) && empty($_POST['email6'])) {
		$error = 'Introduce alg&uacute;n EMail';
	} elseif(empty($_POST['titulo'])) {
		$error = 'Introduce un t&iacute;tulo';
	} elseif(empty($_POST['cuerpo'])) {
		$error = 'Introduce algo que escribir en el mensaje';
	} elseif(!preg_match('/^[a-z0-9_\.\-]{1,64}@[a-z0-9_\.\-]{1,255}\.([a-z]{2,3})+$/i', $_POST['email1']) && !preg_match('/^[a-z0-9_\.\-]{1,64}@[a-z0-9_\.\-]{1,255}\.([a-z]{2,3})+$/i', $_POST['email2']) && !preg_match('/^[a-z0-9_\.\-]{1,64}@[a-z0-9_\.\-]{1,255}\.([a-z]{2,3})+$/i', $_POST['email3']) && !preg_match('/^[a-z0-9_\.\-]{1,64}@[a-z0-9_\.\-]{1,255}\.([a-z]{2,3})+$/i', $_POST['email4']) && !preg_match('/^[a-z0-9_\.\-]{1,64}@[a-z0-9_\.\-]{1,255}\.([a-z]{2,3})+$/i', $_POST['email5']) && !preg_match('/^[a-z0-9_\.\-]{1,64}@[a-z0-9_\.\-]{1,255}\.([a-z]{2,3})+$/i', $_POST['email6'])) {
		$error = 'Alg&uacute;n EMail no es v&aacute;lido';
	}
	if($error) {
		die(error('OOPS!', $error, 'Reintentar', '/recomendar/'.$id));
	} else {
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/plain; charset=iso-8859-1\n";
		$headers .= "From: ".$config['script_name']." <".$config['noreply_email'].">\n";
		$headers .= "Reply-To: ".$config['noreply_email']."\n";
		$headers .= "X-Priority: 1\n";
		$headers .= "X-MSMail-Priority: High\n";
		$headers .= "X-Mailer: PHP/".phpversion();
		for($i=1;$i<=6;$i++) {
			mail($_POST['email'.$i], $_POST['titulo'], $_POST['cuerpo']."\n\nhttp://".$config['script_url']."/posts/".$cat."/".$id."/".url($title)."/", $headers);
		}
		die(error('YEAH!', 'Se ha recomendado el post.<br /><br />Gracias por recomendar '.$config['script_name'].' a tus amigos', 'Ir a la p&aacute;gina principal', '/'));
	}
}
?>
<div id="cuerpocontainer">
<!-- inicio cuerpocontainer -->
<div class="container600" style="width:600px;margin: 10px auto 0 auto;">
	<div class="box_title">
		<div class="box_txt post_recomendar" style="width:592px;height:22px;text-align:center;font-size:12px">Recomendar a tus amigos</div>
		<div class="box_rrs"><div class="box_rss"></div></div>
	</div>
	<div class="box_cuerpo"  align="center">
		<form action="" method="post">
			<b>Recomendarle este post hasta a seis amigos:</b>
			<br>
			<br>
			<input type="text" size=20 name="email1"> <input type="text" size=20 name="email2">
			<br><br>
			<input type="text" size=20 name="email3"> <input type="text" size=20 name="email4">
			<br><br>
			<input type="text" size=20 name="email5"> <input type="text" size=20 name="email6">
			<br>
			<br>
			<b>Asunto del mensaje:</b>
			<br>
			<br>
			<input type="text" size="40" name="titulo" value="<?=$title;?>">
			<br>			
			<br>
			<b>Mensaje:</b>
			<br>
			<br>
			<textarea name="cuerpo" cols="70" rows="8" wrap="hard" tabindex="6">Hola! Te recomiendo que veas este post! 
 
Saludos! 
 
<?=$currentuser['nick'];?></textarea>
			<br>
			<br>
			<br>
			<input type="submit" class="login" style="font-size:11px" value="Enviar mensaje" title="Enviar mensaje">
			<br>
			<br>
		</form>
	</div>
</div><div style="clear:both"></div>
<!-- fin cuerpocontainer -->
</div>