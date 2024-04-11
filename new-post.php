<?php
//NOTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
//NOTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
//NOTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
//NOTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
//NOTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
//NOTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
// SI HAY $COMMENTS ENTONCES NO SE PUEDE COMENTAR!
if(!defined($config['define'])) { die; }
if(!isLogged()) { die; }
unset($sticky, $private, $comments, $csticky, $cprivate, $ccomments);
if($currentuser['rank'] == 8 || $currentuser['rank'] == 6) { $csticky = true; }
if($currentuser['rank'] != 0) { $cprivate = true; }
if($currentuser['rank'] != 0) { $ccomments = true; }

if($_GET['edit']) {
	if(!mysql_num_rows($q = mysql_query("SELECT * FROM `posts` WHERE id = '".mysql_clean($_GET['edit'])."'"))) {
		die(error('OOPS!', 'El post que intentas editar no existe', 'Ir a la p&aacute;gina principal', '/'));
	}
	$epost = mysql_fetch_array($q);
	if($currentuser['rank'] != 8 && $currentuser['rank'] != 6 && $epost['author'] != $currentuser['id']) {
		die(error('OOPS!', 'No tienes permisos para editar este post', 'Ir a la p&aacute;gina principal', '/'));
	}
}

if($_POST) {
	if(!$_POST['title'] || !$_POST['message'] || !$_POST['category'] || !$_POST['tags'] || substr_count($_POST['tags'], ',') < 3) {
		die(error('Error', 'Ha ocurrido un error', 'Reintentar', '/agregar/'));
	}
	$_POST['tags'] = str_replace(',,',',', $_POST['tags']);
	if($_POST['tags']{0} == ',') { $_POST['tags'] = substr($_POST['tags'], 1); }
	if($_POST['tags']{(strlen($_POST['tags'])-1)} == ',') { $_POST['tags'] = substr($_POST['tags'], 0, (strlen($_POST['tags'])-1)); }
	if(substr_count($_POST['tags'], ',') < 3) { die(error('OOPS!', '&iexcl;Tags no v&aacute;lidas!', 'Agregar post', '/agregar/')); }
	if(!mysql_num_rows(mysql_query("SELECT * FROM `categories` WHERE id = '".mysql_clean($_POST['category'])."'"))) { die(error('OOPS!', '&iexcl;Categor&iacute;a no v&aacute;lida!', 'Agregar post', '/agregar/')); }
	if(mysql_num_rows(mysql_query("SELECT id FROM `posts` WHERE author = '".$currentuser['id']."' && time > '".(time()-180)."'"))) { die(error('ANTI-FLOOD', 'Debes esperar al menos 3 minutos antes de publicar otro post!', 'Ir a la p&aacute;gina principal', '/')); }
	if($csticky && $_POST['sticky']) { $sticky = true; }
	if($epost && $epost['sticky'] == 1) { $sticky = true; }
	if($cprivate && $_POST['private']) { $private = true; }
	if($ccomments && $_POST['comments']) { $comments = true; }
	if(!$_GET['edit']) {
		mysql_query("INSERT INTO `posts` (title, message, cat, tags, sticky, sticky_time, private, comments, author, time) VALUES ('".mysql_clean($_POST['title'])."','".mysql_clean($_POST['message'])."','".mysql_clean($_POST['category'])."','".mysql_clean($_POST['tags'])."','".($sticky ? '1' : '0')."','".($sticky ? time() : '0')."','".($private ? '1' : '0')."','".($comments ? '0' : '1')."','".$currentuser['id']."','".time()."')");
	} else {
		mysql_query("UPDATE `posts` SET title = '".mysql_clean($_POST['title'])."', message = '".mysql_clean($_POST['message'])."', cat = '".mysql_clean($_POST['category'])."', tags = '".mysql_clean($_POST['tags'])."', sticky = '".($sticky ? '1' : '0')."', sticky_time = '".($sticky ? time() : 0)."', private = '".($private ? '1' : '0')."', comments = '".($comments ? '0' : '1')."' WHERE id = '".$epost['id']."'");
		if($currentuser['id'] != $epost['author']) {
			mysql_query("INSERT INTO `mod-history` (`post_id`, `post_title`, `post_author`, `mod`, `action_type`, `action_reason`, `time`) VALUES ('".$epost['id']."','".$epost['title']."','".$epost['author']."','".$currentuser['id']."','2','".(empty($_POST['reason']) ? '0' : mysql_clean($_POST['reason']))."','".time()."')") or die(mysql_error());
		}
	}
	$qtags = array_unique(explode(',', mysql_clean($_POST['tags'])));
	foreach($qtags as $tag) {
		if(mysql_num_rows($t = mysql_query("SELECT id FROM `search_tags` WHERE tag = '".$tag."'"))) {
			$ta = mysql_fetch_array($t);
			mysql_query("UPDATE `search_tags` SET num = num+1 WHERE id = '".$ta['id']."'");
		} else {
			mysql_query("INSERT INTO `search_tags` (tag, num) VALUES ('".$tag."', '1')");
		}
	}
	$p = mysql_fetch_array(mysql_query("SELECT id FROM `posts` WHERE ".($_GET['edit'] ? "id = '".$epost['id']."'" : "author = '".$currentuser['id']."'")." ORDER BY id DESC LIMIT 1"));
	$c = mysql_fetch_array(mysql_query("SELECT urlname FROM `categories` WHERE id = '".mysql_clean($_POST['category'])."'"));
	die(error('YEAH!', ($_GET['edit'] ? 'El post se ha editado correctamente' : 'Tu post "'.htmlspecialchars($_POST['title']).'" se ha publicado correctamente'), 'Ir al post', '/posts/'.$c['urlname'].'/'.$p['id'].'/'.url($_POST['title']).'.html'));
} // POST
if($currentuser['rank'] == 0) {
?>
<!-- mensaje top -->
<div id="mensaje-top">
<div class="msgtxt">Logra un post con m&aacute;s de 50 puntos y ser&aacute;s Full User</div>
</div>
<!-- fin mensaje-top-->
<? } ?>
<script type="text/javascript">
function _capsprot(s) {
            var len = s.length, strip = s.replace(/([A-Z])+/g, '').length, strip2 = s.replace(/([a-zA-Z])+/g, '').length,
            percent = (len  - strip) / (len - strip2) * 100;
            return percent;
        }
        $(document).ready(function(){
            $('input[name=title]').keyup(function(){
                if ($(this).val().length >= 5 && _capsprot($(this).val()) > 90) $('.capsprot').show();
                else $('.capsprot').hide();
            });
        });

</script>
<div id="cuerpocontainer">
<!--<form name="newpost" method="post" action="/agregar/" onsubmit="return np_previsualizar(this, false);" id="npf">-->
<!-- inicio cuerpocontainer -->
<div id="preview" style="display:none;"></div>
				<div id="form_div">
				<div class="container250 floatL">
				
				
					<div class="box_title">
						<div class="box_txt para_un_buen_post"> Para hacer un buen post</div>
						<div class="box_rrs"><div class="box_rss"></div></div>
					</div>
					<div class="box_cuerpo">
						Para hacer un buen post es importante que tengas en cuenta los siguientes puntos. Esto ayuda a mantener una mejor calidad de contenido y evitar que sea eliminado por los moderadores.						<p>
							<b>El t&iacute;tulo:</b>
							<br />
							<ul>
								<li><img src="/images/icon-good.png" align="absmiddle" vspace="2"> Que sea descriptivo</li>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2"> TODO EN MAYUSCULA</li>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2"> !!!!!!!Exagerados!!!!!!</a></li>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2"> PARCIALMENTE en mayusculas!</li>
							</ul>
						</p>
						<p>
							<b>Contenido:</b>
							<br />
							<ul>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2" /> Informaci&oacute;n personal o de un tercero</li>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2" /> Fotos de personas menores de edad</li>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2" /> Muertos, sangre, v&oacute;mitos, etc.</li>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2" /> Con contenido racista y/o peyorativo</li>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2" /> Poca calidad (una imagen, texto pobre)</li>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2" /> Chistes escritos, adivinanzas, trivias</li>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2" /> Haciendo preguntas o criticas.</li>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2" /> Insultos o malos modos.</li>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2" /> Con intenci&oacute;n de armar pol&eacute;mica.</li>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2" /> Apolog&iacute;a de delito.</li>
								<li><img src="/images/icon-bad.png" align="absmiddle" vspace="2" /> Software spyware, malware, virus o troyanos.</li>
							</ul>
						</p>
						<p>
							<b>Atenci&oacute;n:</b>
							<br />
							<ul>
								<li>Sexringa! NO acepta contenido de menores de 18 anios.<!-- Para postear ese tipo de contenido existe <a href='http://www.poringa.net/'>Poringa</a>--></li>
								<li>Si se comparte un video o un swf debes publicar la URL</li>
								<li>Debes indicar la fuente si no es material propio.</li>
							</ul>
						</p>
					</div>
				</div>
				<div id="post_agregar" class="floatR">
					<div class="box_title">
						<div class="box_txt agregar_post">Agregar nuevo post</div>
						<div class="box_rrs"><div class="box_rss"></div></div>
					</div>
						<div id="mensaje-top">
							<a href="/protocolo/" target="_blank">Importante: antes de crear un post lee el protocolo.</a>
						</div>
							<div class="box_cuerpo">
								<form name="newpost" method="post" action="/<?=($_GET['edit'] ? 'editar-post/'.$_GET['edit'] : 'agregar');?>/" onsubmit="return np_previsualizar(this, false);" id="npf">
															<b>T&iacute;tulo:</b><br /><input class="agregar titulo" type="text" size="60" maxlength="60" name="title" tabindex="1" value="<?=htmlspecialchars($epost['title']);?>" /><span class="capsprot"><font color="#0000CD"><b> El titulo no debe estar en may&uacute;sculas</b></font></span><br /><br />
								<b>Mensaje del post:</b><br />
								<textarea id="markItUp" class="agregar cuerpo" name="message" tabindex="2"><?=$epost['message'];?></textarea>
                                <br />
					<div class="floatR">
						<a style="font-size:11px" href="javascript:openpopup()">M&aacute;s Emoticones</a>
						<script type="text/javascript">function openpopup(){ var winpops=window.open("/emoticones.php","","width=180px,height=500px,scrollbars,resizable");}</script>
					</div>
								<div id="emoticons" style="float:left"><!--<a href="#" smile=":)"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-286px; clip:rect(286px 16px 302px 0px);" alt="sonrisa" title="sonrisa" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>
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
						<a href="#" smile=":F"><span style="position:relative;"><img border=0 src="http://i.t.net.ar/images/big2.gif" style="position:absolute; top:-616px; clip:rect(616px 16px 632px 0px);" alt="babaaa" title="babaaa" /><img border=0 src="http://i.t.net.ar/images/space.gif" style="width:20px;height:16px" align="absmiddle" /></span></a>-->
						<?php
						$emoticonos = array(':)' => 'sonrisa', ';)' => 'guino', ':roll:' => 'duda', ':P' => 'lengua', ':D' => 'alegre', ':(' => 'triste', 'X(' => 'odio', ':cry:' => 'llorando', ':twisted:' => 'endiablado', ':|' => 'serio', ':?' => 'duda2', ':cool:' => 'picaro', '^^' => 'sonrizota', ':oops:' => 'timido', '8|' => 'increible', ':F' => 'babas');
						foreach($emoticonos as $code => $name) {
							echo '<a href="#" smile="'.$code.'"><img src="/images/space.gif" align="absmiddle" class="emoticono '.$name.'" alt="'.$name.'" title="'.$name.'" style="margin-right:10px;" /></a>';
						}
					?>
						</div>
								<br />
								<br />
								<b>Tags:</b><br /><input class="agregar tags" type="text" size="60" maxlength="128" name="tags" tabindex="4" value="<?=$epost['tags'];?>" /><br />
								<font class="size9">Una lista separada por comas, que describa el contenido. Ejemplo: <b>gol, ingleses, Mundial 86, futbol, Maradona, Argentina</b></font><br /><br />
								<b>Nota:</b> Cuanto mejor uses los tags, otros usuarios podr&aacute;n encontrar tu post m&aacute;s f&aacute;cilmente y por ende, conseguir&aacute;s m&aacute;s visitas.								<br /><br />
								<b>Categor&iacute;a:</b>
								<br />
								<select class="agregar" name="category" size="13" style="width:230px;" tabindex="5">
<option value="0" selected>Elegir una categor&iacute;a</option>
<?php
$query = mysql_query("SELECT id, name FROM `categories` ORDER BY name ASC");
while($cat = mysql_fetch_array($query)) {
	echo '<option '.($epost['cat'] == $cat['id'] ? 'selected ' : '').'value="'.$cat['id'].'">'.$cat['name'].'</option>';
}
?>
								</select>
								<br />
								<br />
                                <?php
								if($_GET['edit'] && $epost['author'] != $currentuser['id']) {
									echo 'Raz&oacute;n de edici&oacute;n:<br /><input type="text" maxlength="100" name="reason" /><br /><br />';
								}
								?>
 <?php
 $tab = '6';
 if($csticky || $cprivate || $ccomments) {
 echo '<b>Opciones:</b>
								<br />';
 if($csticky) {
	 							echo '<input class="agregar check" type="checkbox" name="sticky" tabindex="'.$tab++.'"'.($epost['sticky'] == 1 ? ' checked' : '').' /> Sticky<br />';
 }
 if($cprivate) {
								echo '<input class="agregar check" type="checkbox" name="private" tabindex="'.$tab++.'"'.($epost['private'] == 1 ? ' checked' : '').' /> Solo usuarios registrados<br />';
 }
 if($ccomments) {
								echo '<input class="agregar check" type="checkbox" name="comments" tabindex="'.$tab++.'"'.($epost['comments'] == 0 && $_GET['edit'] ? ' checked' : '').' /> No permitir comentarios<br />';
 }
 }
 ?>

 
								<div class="clearBoth"></div>
								<center>
									<input onclick="np_previsualizar(document.getElementById('npf'), true);" type="button" class="button" style="font-size:15px" value="Previsualizar" title="Previsualizar" tabindex="<?=$tab;?>">
								</center>
										</form>
							</div>
					</div>
				</div><div style="clear:both"></div>
<!-- fin cuerpocontainer -->
</div>