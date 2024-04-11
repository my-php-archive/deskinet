<?php
//NOTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
//NOTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
//NOTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
//NOTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
//NOTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
//NOTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
// SI HAY $COMMENTS ENTONCES NO SE PUEDE COMENTAR!
if(!defined($config['define'])) { die; }
if(!isLogged()) {
	include('./Pages/register.php');
    include('./footer.php');
    die;
}
unset($csticky, $ssticky, $private, $comments, $csticky, $cprivate, $ccomments, $postp);
if(isAllowedTo('stick')) { $csticky = true; }
if(isAllowedTo('superstick')) { $ssticky = true; }
if(isAllowedTo('patrocinadores')) { $postp = true; }
if($currentuser['rank'] != 0) { $cprivate = true; }
if($currentuser['rank'] != 0) { $ccomments = true; }

if($_GET['edit']) {
	if(!mysql_num_rows($q = mysql_query("SELECT * FROM `posts` WHERE id = '".mysql_clean($_GET['edit'])."'"))) {
		die(error('OOPS!', 'El post que intentas editar no existe', 'Ir a la p&aacute;gina principal', '/'));
	}
	$epost = mysql_fetch_array($q);
	if(!isAllowedTo('editposts') && $epost['author'] != $currentuser['id']) {
		die(error('OOPS!', 'No tienes permisos para editar este post', 'Ir a la p&aacute;gina principal', '/'));
	}
} elseif($_GET['draft']) {
  if(!mysql_num_rows($q = mysql_query("SELECT * FROM `drafts` WHERE id = '".mysql_clean($_GET['draft'])."'"))) {
    die(error('OOPS!', 'El borrador que intentas editar no existe', 'Ir a la p&aacute;gina principal', '/'));
  }
  $draft = mysql_fetch_assoc($q);
  if($draft['user'] != $currentuser['id']) {
    die(error('OOPS!', 'No puedes editar borradores de otros', 'Ir a la p&aacute;gina principal', '/'));
  }
}

if($_POST) {
	if(!$_POST['title'] || !$_POST['message'] || !$_POST['category'] || !$_POST['tags'] || substr_count($_POST['tags'], ',') < 3) {
		die(error('Error', 'Ha ocurrido un error', 'Reintentar', '/agregar/'));
	}
	// parsear tags
	while(strpos(',,', $_POST['tags'])!==false){$_POST['tags'] = str_replace(',,',',', $_POST['tags']);}
	if($_POST['tags']{0} == ',') { $_POST['tags'] = substr($_POST['tags'], 1); }
	if($_POST['tags']{(strlen($_POST['tags'])-1)} == ',') { $_POST['tags'] = substr($_POST['tags'], 0, (strlen($_POST['tags'])-1)); }
	$tags = explode(',', $_POST['tags']);
	$c = count($tags);
	$ut = array();
	for($i=0;$i<$c;$i++) {
		$tag = trim($tags[$i]);
		if($tag == '' || in_array($tag, $ut)) { unset($tags[$i]); continue; }
		$tag = preg_replace('/.{1}(α|ι|ν|σ|ϊ|ρ|ό)/i', '\\1', $tag);
		if(!preg_match('/^[a-z0-9 ]+$/i', strtr($tag, 'αινσϊρ', 'aeioun'))) { die(error('OOPS!', 'Las tag s&oacute;lo admiten n&uacute;meros, letras y espacios', 'Agregar post', '/agregar/')); break; }
		$ut[] = $tag;
	}
	$_POST['tags'] = implode(',', $tags);
	if(substr_count($_POST['tags'], ',') < 3) { die(error('OOPS!', 'Escribe al menos 4 tag diferentes', 'Agregar post', '/agregar/'));  }
	if(!mysql_num_rows(mysql_query("SELECT * FROM `categories` WHERE id = '".mysql_clean($_POST['category'])."'"))) { die(error('OOPS!', '&iexcl;Categor&iacute;a no v&aacute;lida!', 'Agregar post', '/agregar/')); }
	if($_POST['category'] == '24' && !$postp) { die(error('OOPS!', 'No tienes permiso para postear en esta categor&iacute;a', 'Agregar post', '/agregar/')); }
	if(!$epost && mysql_num_rows(mysql_query("SELECT id FROM `posts` WHERE author = '".$currentuser['id']."' && time > '".(time()-180)."'"))) { die(error('ANTI-FLOOD', 'Debes esperar al menos 3 minutos antes de publicar otro post!', 'Ir a la p&aacute;gina principal', '/')); }
	if($csticky && $_POST['sticky']) { $sticky = true; }
	if($ssticky && $_POST['ssticky']) { $sstick = true; }
	if($cprivate && $_POST['private']) { $private = true; }
	if($ccomments && $_POST['comments']) { $comments = true; }
	if(!$_GET['edit']) {
		mysql_query("INSERT INTO `posts` (title, message, cat, tags, superstick, sticky, sticky_time, private, comments, author, time) VALUES ('".mysql_clean($_POST['title'])."','".mysql_clean($_POST['message'])."','".mysql_clean($_POST['category'])."','".mysql_clean($_POST['tags'])."','".($sstick ? time() : '0')."','".($sticky ? '1' : '0')."','".($sticky ? time() : '0')."','".($private ? '1' : '0')."','".($comments ? '0' : '1')."','".$currentuser['id']."','".time()."')");
		$pid = mysql_insert_id();
        if($draft) {
          mysql_query("DELETE FROM `drafts` WHERE id = '".$draft['id']."'");
        }
	} else {
		mysql_query("UPDATE `posts` SET title = '".mysql_clean($_POST['title'])."', message = '".mysql_clean($_POST['message'])."', cat = '".mysql_clean($_POST['category'])."', tags = '".mysql_clean($_POST['tags'])."',superstick = '".($sstick ? time() : '0')."', sticky = '".($sticky ? '1' : '0')."', sticky_time = '".($sticky ? time() : 0)."', private = '".($private ? '1' : '0')."', comments = '".($comments ? '0' : '1')."' WHERE id = '".$epost['id']."'");
		if($currentuser['id'] != $epost['author']) {
			mysql_query("INSERT INTO `mod-history` (`post_id`, `post_title`, `post_author`, `mod`, `action_type`, `action_reason`, `time`) VALUES ('".$epost['id']."','".$epost['title']."','".$epost['author']."','".$currentuser['id']."','2','".(empty($_POST['reason']) ? '0' : mysql_clean($_POST['reason']))."','".time()."')") or die(mysql_error());
		}
	}
	$qtags = array_unique(explode(',', mysql_clean($_POST['tags'])));
	if($epost) {
		$oldt = explode(',', $epost['tags']);
		foreach($oldt as $ot) {
			if(in_array($ot, $qtags)) {
				list($key) = array_keys($qtags, $ot);
				unset($qtags[$key]);
				$deletetags[] = $tag;
			}
		}
	}
	foreach($qtags as $tag) {
		if(mysql_num_rows(mysql_query("SELECT id FROM `tags` WHERE tag = '".$tag."'"))) {
			mysql_query("UPDATE `tags` SET num = num+1 WHERE tag = '".$tag."'");
		} else {
			mysql_query("INSERT INTO `tags` (tag, num) VALUES ('".$tag."', '1')");
		}
	}
	if($deletetags) {
		foreach($deletetags as $tag) {
			if(mysql_num_rows(mysql_query("SELECT id FROM `tags` WHERE tag = '".$tag."'"))) {
				mysql_query("UPDATE `tags` SET num = num-1 WHERE tag = '".$tag."'");
			}
		}
	}
	$p = mysql_fetch_array(mysql_query("SELECT id, title, cat FROM `posts` WHERE id = '".($_GET['edit'] ? $epost['id'] : $pid)."'"));
	$c = mysql_fetch_array(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$p['cat']."'"));
	if(!$epost) {
		$q = mysql_query("SELECT user FROM `follows` WHERE what = '2' && who = '".$currentuser['id']."'") or die(mysql_error());
		while(list($id) = mysql_fetch_row($q)) {
			mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, who, what, `where`) VALUES ('".$id."', 'public&oacute; un <a href=\"/posts/".$c['urlname']."/".$pid."/".url($p['title']).".html\" title=\"".htmlspecialchars($p['title'])."\">post</a>', '/posts/".$c['urlname']."/".$pid."/".url($p['title']).".html', 'sprite-document-text-image', '".time()."', '".$currentuser['id']."', '1', '".$pid."')") or die(mysql_error());
		}
	}
	die(error('YEAH!', ($_GET['edit'] ? 'El post se ha editado correctamente' : 'Tu post "'.htmlspecialchars($p['title']).'" se ha publicado correctamente'), 'Ir al post', '/posts/'.$c['urlname'].'/'.$p['id'].'/'.url($p['title']).'.html'));
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
        var current_draft = <?=($draft ? $draft['id'] : '0');?>;
        $(document).ready(function(){
			var orv = new Array(2);
			orv[0] = '<?=($post ? str_replace("'", "\'", $post['title']) : '');?>';
			orv[1] = '<?=($post ? str_replace("'", "\'", $post['message']) : '');?>';
            $('input[name=title]').keyup(function(){
                if ($(this).val().length >= 5 && _capsprot($(this).val()) > 80) $('.capsprot').show();
                else $('.capsprot').hide();
            });
			$('#markItUp, #npft').change(function() { if(this.value != (this.id=='npft' ? orv[0] : orv[1])) { window.onbeforeunload = function() { return 'Si sales perder\xe1s todo lo que hayas escrito.';  }; } else { window.onbeforeunload = null; } });
			$('#psb').click(function() { window.onbeforeunload = null; document.getElementById('npf').submit(); });
        });
</script>
<div id="cuerpocontainer">
<!--<form name="newpost" method="post" action="/agregar/" onsubmit="return np_previsualizar(this, false);" id="npf">-->
<!-- inicio cuerpocontainer -->
<div id="previewc" style="display:none;"><div id="preview"></div>
<div align="right"><input class="button" title="Cerrar previsualizaci&oacute;n" onclick="document.getElementById('previewc').style.display='none';" value="Cerrar previsualizaci&oacute;n" type="button"> <input id="psb" class="button" title="Est&aacute; perfecto" value="OK, est&aacute; perfecto" type="button">&nbsp;&nbsp;</div><br /></div>
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
								<li><?=ucfirst($config['script_name2']);?> NO acepta contenido sexual o er&oacute;tico.</li>
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
								<form name="newpost" method="post" action="" onsubmit="return np_previsualizar(this, false);" id="npf">
															<b>T&iacute;tulo:</b><br /><input id="npft" class="agregar titulo" type="text" size="60" maxlength="60" name="title" tabindex="1" value="<?=htmlspecialchars($epost['title'].$draft['title']);?>" /><span class="capsprot">El titulo no debe estar en may&uacute;sculas</span><br /><br />
								<b>Mensaje del post:</b><br />
								<textarea id="markItUp" class="agregar cuerpo" name="message" tabindex="2"><?=$epost['message'].$draft['content'];?></textarea>
                                <br />
					<div class="floatR">
						<a style="font-size:11px" href="javascript:openpopup()">M&aacute;s Emoticones</a>
						<script type="text/javascript">function openpopup(){ var winpops=window.open("/emoticones.php","","width=180px,height=500px,scrollbars,resizable");}</script>
					</div>
								<div id="emoticons" style="float:left"><?php
						$emoticonos = array(':)' => 'sonrisa', ';)' => 'guino', ':roll:' => 'duda', ':P' => 'lengua', ':D' => 'alegre', ':(' => 'triste', 'X(' => 'odio', ':cry:' => 'llorando', ':twisted:' => 'endiablado', ':|' => 'serio', ':?' => 'duda2', ':cool:' => 'picaro', '^^' => 'sonrizota', ':oops:' => 'timido', '8|' => 'increible', ':F' => 'babas');
						foreach($emoticonos as $code => $name) {
							echo '<a href="#" smile="'.$code.'"><img src="/images/space.gif" align="absmiddle" class="emoticono '.$name.'" alt="'.$name.'" title="'.$name.'" style="margin-right:10px;" /></a>';
						}
					?>
						</div>
								<br />
								<br />
								<b>Tags:</b><br /><input class="agregar tags" type="text" size="60" maxlength="128" name="tags" tabindex="4" value="<?=$epost['tags'].$draft['tags'];?>" /><br />
								<font class="size9">Una lista separada por comas, que describa el contenido. Ejemplo: <b>gol, ingleses, Mundial 86, futbol, Maradona, Argentina</b></font><br /><br />
								<b>Nota:</b> Cuanto mejor uses los tags, otros usuarios podr&aacute;n encontrar tu post m&aacute;s f&aacute;cilmente y por ende, conseguir&aacute;s m&aacute;s visitas.								<br /><br />
								<b>Categor&iacute;a:</b>
								<br />
                                <?php
								$query = mysql_query("SELECT id, name FROM `categories` ORDER BY name ASC");
								?>
								<select class="agregar" name="category" size="<?=($postp ? mysql_num_rows($query)+1 : mysql_num_rows($query));?>" style="width:230px;" tabindex="5">
<option value="0" selected>Elegir una categor&iacute;a</option>
<?php
while($cat = mysql_fetch_array($query)) {
	if($cat['id'] == '24' && !$postp) { continue; }
	echo '<option '.($epost['cat'] == $cat['id'] || $draft['cat'] == $cat['id'] ? 'selected ' : '').'value="'.$cat['id'].'">'.$cat['name'].'</option>';
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
 if($csticky || $ssticky || $cprivate || $ccomments) {
 echo '<b>Opciones:</b>
								<br />';
 if($csticky) {
	 							echo '<input class="agregar check" type="checkbox" name="sticky" tabindex="'.$tab++.'"'.($epost['sticky'] == 1 || $draft['stick'] == 1 ? ' checked' : '').' /> Sticky<br />';
 }
 if($ssticky) {
	 							echo '<input class="agregar check" type="checkbox" name="ssticky" tabindex="'.$tab++.'"'.(($epost && $epost['superstick'] != '0') || ($draft && $draft['superstick'] != '0') ? ' checked' : '').' /> Super sticky<br />';
 }
 if($cprivate) {
								echo '<input class="agregar check" type="checkbox" name="private" tabindex="'.$tab++.'"'.($epost['private'] == 1 || $draft['private'] == '1' ? ' checked' : '').' /> Solo usuarios registrados<br />';
 }
 if($ccomments) {
								echo '<input class="agregar check" type="checkbox" name="comments" tabindex="'.$tab++.'"'.(($epost && $epost['comments'] == 0) || ($draft && $draft['comments'] == '0') ? ' checked' : '').' /> No permitir comentarios<br />';
 }
 }
 ?>


								<div class="clearBoth"></div>
								<center>
									<input onclick="np_previsualizar(document.getElementById('npf'), true);" type="button" class="button" style="font-size:15px" value="Previsualizar" title="Previsualizar" tabindex="<?=$tab++;?>"><input id="borrador-save" class="button" type="button" onclick="np_previsualizar(document.getElementById('npf'), true, true);" style="font-size:15px" value="Guardar en borradores" title="Guardar en borradores" tabindex="<?=$tab;?>" />
								</center>
										</form>
                                        <div id="borrador-guardado"></div>
							</div>
					</div>
				</div><div style="clear:both"></div>
<!-- fin cuerpocontainer -->
</div>