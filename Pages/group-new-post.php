<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
if(!$_GET['group'] || !mysql_num_rows($qgroup = mysql_query("SELECT * FROM `groups` WHERE urlname = '".mysql_clean($_GET['group'])."'"))) {
	include('groups.php');
	include('footer.php');
	die;
}

$group = mysql_fetch_array($qgroup);
$cat = mysql_fetch_array(mysql_query("SELECT urlname, name FROM `group_categories` WHERE id = '".$group['cat']."'"));
$subcat = mysql_fetch_array(mysql_query("SELECT urlname, name FROM `group_categories` WHERE id = '".$group['subcat']."'"));
$creator = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$group['creator']."'"));
if(mysql_num_rows($q = mysql_query("SELECT * FROM `group_members` WHERE `group` = '".$group['id']."' AND user = '".$currentuser['id']."'"))) {
	$currentuser['group'] = mysql_fetch_array($q);
	$currentuser['isMember'] = true;
}
if(!$currentuser['isMember'] && !isAllowedTo('edit_post_groups')) { die(error('OOPS!', 'Debes ser miembro de la comunidad para poder postear', '&Iacute;ndice de '.($group['private'] == '1' ? 'comunidades' : 'la comunidad'), ($group['private'] == '1' ? '/comunidades/' : '/comunidades/'.htmlspecialchars($group['urlname']).'/'))); }
if($currentuser['group']['rank'] < 2 && !isAllowedTo('edit_post_groups')) { die(error('OOPS!', 'Debes ser al menos <strong>posteador</strong> para poder publicar un nuevo tema', '&Iacute;ndice de la comunidad', '/comunidades/'.htmlspecialchars($group['urlname']).'/')); }

if($_GET['post'] && !mysql_num_rows(mysql_query("SELECT * FROM `group_posts` WHERE id = '".mysql_clean($_GET['post'])."' && author = '".$currentuser['id']."'")) && !isAllowedTo('edit_post_groups') && $currentuser['group']['rank'] < 3) {
	include('groups.php');
	include('footer.php');
	die;
} elseif($_GET['post']) {
	$post = mysql_fetch_array(mysql_query("SELECT * FROM `group_posts` WHERE id = '".mysql_clean($_GET['post'])."'"));
	if($post['poll']=='1') {
		$poll = mysql_fetch_assoc(mysql_query("SELECT * FROM `polls` WHERE id = '".$post['poll']."'"));
		$opts = explode('^', htmlspecialchars($poll['options']));
        $poll['options'] = array();
		foreach($opts as $o) {
			$e = explode('*', $o);
			$poll['options'][$e[0]] = $e[1];
		}
	}

}
$url = ($post ? '/comunidades/'.$group['urlname'].'/editar-tema/'.$post['id'] : '/comunidades/'.$group['urlname'].'/agregar');
	
if($currentuser['group']['rank'] == '4' || isAllowedto('stick_post_groups')) { $cstick = true; }

if($_POST) {
	if(!$_POST['titulo'] || empty($_POST['titulo'])) { die(error('OOPS!', 'No has escrito un t&iacute;tulo', 'Reintentar', $url)); }
	if(!$_POST['cuerpo'] || empty($_POST['cuerpo'])) { die(error('OOPS!', 'No has escrito un mensaje', 'Reintentar', $url)); }
	if(!$_POST['tags'] || empty($_POST['tags'])) { die(error('OOPS!', 'No has escrito tags', 'Reintentar', $url)); }
	$tags = array_unique(explode(',', $_POST['tags']));
	if(count($tags) < 4) { die(error('OOPS!', 'Debes escribir al menos 4 tags', 'Reintentar', $url)); }
    if($_POST['poll']) {
	    // $options
	    $i = 1;
        $options = '';
	    foreach($_POST as $n => $opt) {
		    if(substr($n, 0, 8) != 'poll_opc') { continue; }
		    if(strpos('*', $opt) !== false || strpos('^', $opt) !== false) { die(error('OOPS!', 'No puedes usar asteriscos (*) o acentos circunflejos (^) en las opciones de la encuesta', 'Reintentar', $url)); break; }
            if(trim($opt) == '') { continue; }
            $options .= '^'.$i++.'*'.trim($opt);
	    }
	    $options = substr($options, 1);
        if(substr_count($options, '^') < 3) { die(error('OOPS!', 'Escribe al menos dos opciones para la encuesta', 'Reintentar', $url)); }
    }

	if(!$post && mysql_num_rows(mysql_query("SELECT id FROM `group_posts` WHERE author = '".$currentuser['id']."' && time > '".(time()-180)."'"))) { die(error('ANTI-FLOOD', 'Debes esperar al menos 3 minutos antes de publicar otro tema!', 'Ir a la p&aacute;gina principal', '/')); }
	// $options
	if($_POST['sticky'] && !$cstick && (($post && $post['sticky'] == '0') || !$post)) { unset($_POST['sticky']); }
	if(!$post) {
		mysql_query("INSERT INTO `group_posts` (title, message, tags, author, `group`, cat, time, comments, sticky, poll) VALUES ('".mysql_clean($_POST['titulo'])."', '".mysql_clean($_POST['cuerpo'])."', '".mysql_clean(implode(',', $tags))."', '".$currentuser['id']."', '".$group['id']."', '".$group['cat']."', '".time()."', '".($_POST['comments'] ? '0' : '1')."', '".($_POST['sticky'] ? time() : '0')."', '".($_POST['poll'] ? '1' : '0')."')") or die(mysql_error());
		//mysql_query("INSERT INTO `group_posts` (title, message, tags, author, `group`, cat, time, comments, sticky) VALUES ('".mysql_clean($_POST['titulo'])."', '".mysql_clean($_POST['cuerpo'])."', '".mysql_clean(implode(',', $tags))."', '".$currentuser['id']."', '".$group['id']."', '".$group['cat']."', '".time()."', '".($_POST['comments'] ? '0' : '1')."', '".($_POST['sticky'] ? time() : '0')."')") or die(mysql_error());
		$pid = mysql_insert_id();
        if($_POST['poll']) {
		    mysql_query("INSERT INTO `polls` (post, `group`, name, options, time, cvote) VALUES ('".$pid."', '".$group['id']."', '".mysql_clean($_POST['pollname'])."', '".mysql_clean($options)."', '".time()."', '".($_POST['cvote'] ? '1' : '0')."')");
        }
        mysql_query("UPDATE `groups` SET posts = posts+1 WHERE id = '".$group['id']."'");
	} else {
		mysql_query("UPDATE `group_posts` SET title = '".mysql_clean($_POST['titulo'])."', message = '".mysql_clean($_POST['cuerpo'])."', tags = '".mysql_clean(implode(',', $tags))."', comments = '".($_POST['comments'] ? '0' : '1')."', sticky = '".($_POST['sticky'] ? time() : '0')."', poll = '".($_POST['poll'] ? '1' : '0')."' WHERE id = '".$post['id']."'");

		if($poll) {
			if(!$_POST['poll']) {
				mysql_query("DELETE FROM `polls` WHERE id = '".$poll['id']."'");
				mysql_query("DELETE FROM `poll_votes` WHERE poll = '".$poll['id']."'");
			} else {
				mysql_query("UPDATE `polls` SET name = '".mysql_clean($_POST['pollname'])."', options = '".mysql_clean($options)."', cvote = '".($_POST['cvote'] ? '1' : '0')."' WHERE id = '".$poll['id']."'");
			}
		}
	}
	if(!$post) {
		$post = array('id' => $pid, 'title' => htmlspecialchars($_POST['titulo']), 'false' => true);
		$notified = array();
		$q = mysql_query("SELECT user FROM `follows` WHERE what = '3' && who = '".$group['id']."'") or die(mysql_error());
		while(list($id) = mysql_fetch_row($q)) {
			$notified[] = $id;
			mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, who, what, `where`) VALUES ('".$id."', 'public&oacute; un <a href=\"/comunidades/".$group['urlname']."/".$post['id']."/".url($post['title']).".html\" title=\"".htmlspecialchars($post['title'])."\">tema</a> en una <a href=\"/comunidades/".$group['urlname']."/\" title=\"".htmlspecialchars($group['name'])."\">comunidad</a>', '/comunidades/".$group['urlname']."/".$post['id']."/".url($post['title']).".html', 'sprite-block', '".time()."', '".$currentuser['id']."', '4', '".$pid."')") or die(mysql_error());
		}
		$q = mysql_query("SELECT user FROM `follows` WHERE what = '2' && who = '".$currentuser['id']."'") or die(mysql_error());
		while(list($id) = mysql_fetch_row($q)) {
			if(in_array($id, $notified)) { continue; }
			mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, who, what, `where`) VALUES ('".$id."', 'public&oacute; un <a href=\"/comunidades/".$group['urlname']."/".$post['id']."/".url($post['title']).".html\" title=\"".htmlspecialchars($post['title'])."\">tema</a>', '/comunidades/".$group['urlname']."/".$post['id']."/".url($post['title']).".html', 'sprite-block', '".time()."', '".$currentuser['id']."', '4', '".$pid."')") or die(mysql_error());
		}
	}
	die(error('YEAH!', ($post['false'] === true ? 'El tema se ha publicado con &eacute;xito' : 'El tema se ha editado con &eacute;xito'), 'Ir al tema', '/comunidades/'.$group['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html'));
}
?>
<div id="cuerpocontainer">
<div class="comunidades">
 
<div class="breadcrump">
<ul>
<li class="first"><a href="/comunidades/" title="Comunidades">Comunidades</a></li><li><a href="/comunidades/cat/<?=$cat['urlname'];?>/" title="<?=$cat['name'];?>"><?=$cat['name'];?></a></li><li><a href="/comunidades/<?=$group['urlname'];?>/"><?=htmlspecialchars($group['name']);?></a></li><li><?=($post ? 'Editar' : 'Nuevo');?> tema</li><li class="last"></li>
</ul>
</div>
 
	<div style="clear:both"></div>
 
 
<div id="izquierda">
<?php include('./Pages/groups-left.php');?>
</div>
<div id="centroDerecha">
 
	<div id="post_agregar" class="floatR">
	<div class="box_title">
		<div class="box_txt agregar_post">Agregar tema</div>
		<div class="box_rss"></div>
	</div>
	<div id="mensaje-top">
    <a target="_blank" href="/protocolo/">Importante: antes de crear un tema lee el protocolo.</a>
  </div>
	<div class="box_cuerpo">
		<div class="form-container">
			<form name="add_tema" method="post" action="<?=$url;?>" onsubmit="return groups_nt_check(this);">
				<div class="data">
					<label for="uname">T&iacute;tulo</label>
					<input class="c_input" type="text" value="<?=$post['title'];?>" name="titulo" tabindex="1" datatype="text" dataname="Titulo" />
				</div>
				<div class="data">
					<label for="uname">Cuerpo</label>
					<textarea class="c_input_desc" id="markItUp" name="cuerpo" tabindex="8" datatype="text" dataname="Cuerpo"><?=$post['message'];?></textarea>
				</div>
				<div class="data">
					<label for="uname">Tags</label>
					<input class="c_input" name="tags" type="text" value="<?=$post['tags'];?>" tabindex="9" datatype="tags" dataname="Tags" />
					Una lista de por lo menos cuatro Tags separados por comas, que describa el contenido.<br />
					Ejemplo: <b>gol, ingleses, Mundial 86, futbol, Maradona, Argentina</b><br />
					<b>Nota:</b> Cuanto mejor uses los Tags, otros usuarios podr&aacute;n encontrar tu tema m&aacute;s f&aacute;cilmente.
				</div>
                <div id="addpoll" style="display:<?=($post['poll'] == '1' ? 'block' : 'none');?>;">
                	<div class="data">
                	<label>Nombre de la encuesta:</label>
                	<input class="c_input" maxlength="50" type="text" value="<?=$poll['name'];?>" name="pollname" />
                	</div>
                	<div class="data">
                	<label>Cambiar voto:</label>
                	<input maxlength="50" type="checkbox"<?=($poll && $poll['cname'] == '1' ? ' checked' : '');?> name="pollname" />
                    <br />
                    Los usuarios podr&aacute;n quitar su voto y votar otra opci&oacute;n, o no volver a votar
                	</div>
                	<div class="data">
                	<label>Opciones:</label>
                	<div id="poll_options">
                    <?php
                    if(isset($poll['options'])) {
                      foreach($poll['options'] as $n=>$opt) {
                        echo '<div><br /><input class="c_input" style="width:80%;" maxlength="50" type="text" value="'.$opt.'" name="poll_opc'.$n.'" /><a style="float:right;margin-top:15px;cursor:pointer;" class="dopt"><img src="/images/borrar.png" width="10" height="10" /> Quitar opci&oacute;n</a></div>';
                        //echo '<input class="c_input" style="width:80%;" maxlength="50" type="text" value="'.$opt.'" name="poll_opc'.$n.'" />';
                      }
                    }
                    ?>
                    </div>
                    <br />
					<br />
					<a href="#" onclick="poll_add_opt();return false;"><img src="/images/add.png" width="10" height="10" /> Agregar otra opci&oacute;n</a>
                	</div>
                    <script type="text/javascript">var poll_con = <?=($poll ? count($poll['options']) : '0');?>;</script>
                    <? /*GUARDAR EN $POLL['options'] LAS OPCIONES YA "PARSEADAS"*/?>
                </div>
				<div class="data postLabel">
					<label for="uname">Opciones</label><br /><br />
					<input type="checkbox" name="cerrado" id="check_cerrado" tabindex="11"<?=($post['comments'] == '0' ? ' checked' : '');?> /> <label for="check_cerrado">No se permite responder</label><br />
					<? if($cstick) { ?><input type="checkbox" name="sticky" id="check_sticky" tabindex="12"<?=($post['sticky'] == '1' ? ' checked' : '');?> /> <label for="check_sticky">Sticky</label><br /><? } ?>
                    <label id="polllabel"><input type="checkbox" name="poll" id="poll"<?=($poll ? ' checked' : '');?> /> Agregar encuesta</label>
				</div>
				<div style="text-align:center">
					<input type="submit" tabindex="13" title="<?=($post ? 'Editar tema' : 'Agregar tema');?>" value="<?=($post ? 'Editar tema' : 'Agregar tema');?>" onclick="if(poll_con!='0'&&!document.getElementById('poll').checked){return confirm('Si continuas la encuesta se borrará');}" class="mBtn btnOk" name="Enviar" />
				</div>
			</form>
		</div>
	</div>
</div>
</div>

</div><div style="clear:both"></div>
</div> <!-- cuerpocontainer -->