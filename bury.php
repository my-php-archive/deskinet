<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if(!isLogged()) { die; }
if(!$_GET['id'] || !mysql_num_rows($query = mysql_query("SELECT * FROM `posts` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die(error('OOPS!', 'El post no existe, tal vez ya ha sido borrado', 'Ir a la p&aacute;gina principal', '/')); }
$post = mysql_fetch_array($query);
if($post['author'] == $currentuser['id']) { die(error('OOPS!', 'No puedes denunciar tu propio post', 'Ir a la p&aacute;gina principal', '/')); }
if($post['revision'] == '1') { die(error('OOPS!', 'El post ya est&aacute; siendo revisado', 'Ir a la p&aacute;gina principal', '/')); }
if(mysql_num_rows(mysql_query("SELECT * FROM `complaints` WHERE post = '".$post['id']."' && (user = '".$currentuser['id']."' || ip = '".mysql_clean($_SERVER['REMOTE_ADDR'])."')"))) { die(error('OOPS!', 'Ya has denunciado este post', 'Ir a la p&aacute;gina principal', '/')); }
// P
if($_POST) {
	if(!$_POST['razon']) { $_POST['razon'] = '0'; }
	$reason = (int) $_POST['razon'];
	if($reason < 0 || $reason > 12) { die(error('OOPS!', 'Hubo un error al procesar la denuncia', 'Reintentar', '/denunciar-post/'.$_GET['id'].'/')); }
	$reason = (string) $reason;
	if(!$_POST['cuerpo'] || empty($_POST['cuerpo'])) { die(error('OOPS!', 'Escribe un comentario', 'Reintentar', '/denunciar-post/'.$_GET['id'].'/')); }
	mysql_query("INSERT INTO `complaints` (post, user, ip, comment, reason, time) VALUES ('".$post['id']."', '".$currentuser['id']."', '".mysql_clean($_SERVER['REMOTE_ADDR'])."', '".mysql_clean($_POST['cuerpo'])."', '".$reason."','".time()."')");
	if(mysql_num_rows(mysql_query("SELECT * FROM `complaints` WHERE post = '".$post['id']."'")) >= 10) {
		mysql_query("UPDATE `posts` SET revision = '1' WHERE id = '".$post['id']."'");
		mysql_query("INSERT INTO `mod-history` (`post_id`, `post_title`, `post_author`, `mod`, `action_type`, `action_reason`, `time`) VALUES ('".$post['id']."','".$post['title']."','".$post['author']."','0','3','Por acumulaci&oacute;n de denuncias.','".time()."')") or die(mysql_error());
	}
	die(error('YEAH!', 'La denuncia fue enviada', 'Ir a la p&aacute;gina principal', '/'));
}
// P
$author = mysql_query("SELECT nick FROM `users` WHERE id = '".$post['author']."'");
?>
<div id="cuerpocontainer">
<div class="container400" style="height:350px;width:400px;margin: 10px auto 0 auto;">
	<div class="box_title">
		<div class="box_txt denunciar_post" style="width:392px;height:22px;text-align:left;font-size:12px">Denunciar post</div>
		<div class="box_rrs"><div class="box_rss"></div></div>
	</div>
	<div class="box_cuerpo" align="center">
		<form action="/denunciar-post/<?=$_GET['id'];?>" method="post">
			<b>Denunciar el post:</b>
			<br />
			<?=$post['id'];?> / <?=htmlspecialchars($post['title']);?>			<br />
			<br />
			<b>Creado por:</b>
			<br />
			<?=$author['nick'];?>			<br />			
			<br />
			<b>Raz&oacute;n de la denuncia:</b>
			<br />
			<select name="razon" style="color:black; background-color: #FAFAFA; font-size:12px">
				<option value="0">Re-post</option>
				<option value="1">Se hace Spam</option>
				<option value="2">Tiene links muertos</option>
				<option value="3">Es Racista o irrespetuoso</option>
				<option value="4">Contiene informaci&oacute;n personal</option>
				<option value="5">El Titulo esta en may&uacute;scula</option>
				<option value="6">Contiene Pedofilia</option>
				<option value="7">Es Gore o asqueroso</option>
				<option value="8">Est&aacute; mal la fuente</option>
				<option value="9">Post demasiado pobre / Crap</option>
				<option value="10"><?=$config['script_name'];?> no es un foro</option>
				<option value="11">No cumple con el protocolo</option>
				<option value="12">Otra raz&oacute;n (especificar)</option>
			</select>
			<br />
			<br />
			<b>Aclaraci&oacute;n y comentarios:</b>
			<br />
			<textarea name="cuerpo" cols="40" rows="5" wrap="hard" tabindex="6"></textarea>
			<br />
			<span class="size9">En el caso de ser Re-post se debe indicar el link del post original.</span>
			<br />
			<br />
			<input type="submit" class="login" style="font-size:11px" value="Enviar denuncia" title="Enviar denuncia">
			<br />
			<br />
		</form>
	</div>
</div><div style="clear:both"></div>
</div><!--cc-->