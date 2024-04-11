<?php
if(!defined('admin')) { die; }
if(!isAllowedTo('changerank')) { die; }
if($_GET['rank'] && mysql_num_rows($r = mysql_query("SELECT * FROM `ranks` WHERE id = '".mysql_clean($_GET['rank'])."'"))) {
	$rank = mysql_fetch_array($r);
	$permissions = explode(',', $rank['permissions']);
} else { $permissions = array(); }
$ranks = array(
	'patrocinadores' => 'Publicar en patrocinadores',
	'maintenance' => 'Ver mantenimiento',
	'deletecomments' => 'Borrar comentarios',
	'stick' => 'Fijar posts',
	'superstick' => 'Superstickear',
	'editposts' => 'Editar post de otros',
	'deleteposts' => 'Borrar post de otros',
	'showrevposts' => 'Ver post en revisi&oacute;n',
	'showpanel' => 'Ver panel Admin',
	'notes' => 'Ver notas',
	'editnotes' => 'Editar notas',
	'complaints' => 'Ver denuncias',
	'ban' => 'Banear',
	'banadmins' => 'Banear administradores',
	'ban_all' => 'Baneo total',
	'ban_lock' => 'Banear y bloquear',
	'banlist' => 'Ver lista de baneados',
	'userlist' => 'Ver lista de usuarios',
	'adminuser' => 'Administrar usuario',
	'changerank' => 'Dar rango',
	'ranks' => 'Ver rangos',
	'controlips' => 'Administrar IPs',
	'editsettings' => 'Cambiar la configuraci&oacute;n',
	'official_group' => 'Comunidades oficiales',
	'groups_memberlist' => 'Ver lista de miembros completa',
	'edit_groups' => 'Editar comunidades',
	'edit_members' => 'Editar miembros',
	'groups_changerank' => 'Cambiar rangos en comunidades',
	'delete_groups' => 'Borrar comunidades',
	'stick_post_groups' => 'Fijar temas',
	'edit_post_groups' => 'Editar temas',
	'delete_post_groups' => 'Borrar temas',
	'groups_delete_comments' => 'Borrar respuestas',
	'comment_complaints' => 'Denuncias de comentarios'
);
$desc = array(
	'patrocinadores' => 'Si se activa, los usuarios podr&aacute;n postear en la categor&iacute;a de patrocinadores.',
	'maintenance' => 'Si se activa, los usuarios podr&aacute;n acceder a la web cuando esta est&eacute; en mantenimiento.',
	'deletecomments' => 'Si se activa, los usuarios podr&aacute;n borrar cualquier comentario.',
	'stick' => 'Si se activa, los usuarios podr&aacute;n fijar y desfijar posts.',
	'superstick' => 'Si se activa, los usuarios podr&aacute;n hacer "superstickies", que son los amarillos importantes.',
	'editposts' => 'Si se activa, los usuarios podr&aacute;n editar cualquier post, sea o no el autor.',
	'deleteposts' => 'Si se activa, los usuarios podr&aacute;n borrar cualquier post, sea o no el autor.',
	'showrevposts' => 'Si se activa, los usuarios podr&aacute;n ver post que hayan sido bloqueados por la cantidad de denuncias.',
	'showpanel' => 'Si se activa, los usuarios podr&aacute;n ver el panel admin, aunque no puedan acceder a algunas de sus opciones. Atenci&oacute;n, aunque tenga otros permisos, sin este, no acceder&aacute; a ninguna opci&oacute;n.',
	'notes' => 'Si se activa, los usuarios podr&aacute;n ver y crear notas.',
	'editnotes' => 'Si se activa, los usuarios podr&aacute;n editar notas de otros.',
	'complaints' => 'Si se activa, los usuarios podr&aacute;n ver y aceptar o rechazar denuncias.',
	'ban' => 'Si se activa, los usuarios podr&aacute;n banear y desbanear.',
	'banadmins' => 'Si se activa, los usuarios podr&aacute;n banear a los administradores del sitio (Rango ID: 8).',
	'ban_all' => 'Si se activa, los usuarios podr&aacute;n usar el baneo total, borrando post, temas, comentarios y respuestas del usuario',
	'ban_lock' => 'Si se activa, los usuarios podr&aacute;n bloquear a los baneados para que no puedan entrar a ninguna parte de la web',
	'banlist' => 'Si se activa, los usuarios podr&aacute;n ver la lista de baneados.',
	'userlist' => 'Si se activa, los usuarios podr&aacute;n ver la lista de usuarios.',
	'adminuser' => 'Si se activa, los usuarios podr&aacute;n administrar usuarios: cambiarles el avatar, mensaje y ciudad.',
	'changeuser' => 'Si se activa, los usuarios podr&aacute;n cambiar cualquier cosa de los usuarios.',
	'changerank' => 'Si se activa, los usuarios podr&aacute;n cambiar el rango de los usuarios.',
	'ranks' => 'Si se activa, los usuarios podr&aacute;n ver la lista de rangos',
	'controlips' => 'Si se activa, los usuarios podr&aacute;n ver la lista de IPs.',
	'editsettings' => 'Si se activa, los usuarios podr&aacute;n cambiar la configuraci&oacute;n de la web',
	'official_group' => 'Si se activa, los usuarios podr&aacute;n crear comunidades oficiales.',
	'groups_memberlist' => 'Si se activa, los usuarios podr&aacute;n ver todas las opciones de la lista de miembros de las comunidades.',
	'edit_groups' => 'Si se activa, los usuarios podr&aacute;n editar comunidades ajenas.',
	'edit_members' => 'Si se activa, los usuarios podr&aacute;n banear y desbanear usuarios en las comunidades.',
	'groups_changerank' => 'Si se activa, los usuarios podr&aacute;n cambiar el rango a los usuarios de cualquier comunidad.',
	'delete_groups' => 'Si se activa, los usuarios podr&aacute;n borrar comunidades ajenas.',
	'stick_post_groups' => 'Si se activa, los usuarios podr&aacute;n fijar temas de comunidades ajenas.',
	'edit_post_groups' => 'Si se activa, los usuarios podr&aacute;n editar temas de comunidades ajenas.',
	'delete_post_groups' => 'Si se activa, los usuarios podr&aacute;n borrar temas de comunidades ajenas.',
	'groups_delete_comments' => 'Si se activa, los usuarios podr&aacute;n borrar respuestas en temas ajenos de las comunidades.',
	'comment_complaints' => 'Si se activa, los usuarios podr&aacute;n ver denuncias de comentarios en cualquier post.'
);

if($_POST) {
	if(empty($_POST['name'])) { $error = 'Introduce un nombre';
	} elseif(empty($_POST['points'])) { $error = 'Introduce una cantidad de puntos por d&iacute;a';
	} elseif(!preg_match('/^[0-9]+$/', $_POST['points'])) { $error = 'Los puntos deben ser numericos';
	}
	if($error) { echo '<center><span style="color:red;">'.$error.'</span></center><br />';
	} else {
		foreach($_POST as $name => $p) {
			if(substr($name, 0, 2) != 'p_') { continue; }
			$rp .= ','.$p;
		}
		$rp = substr($rp, 1);
		if(!$rank) {
			mysql_query("INSERT INTO `ranks` (name, points, permissions) VALUES ('".mysql_clean($_POST['name'])."', '".mysql_clean($_POST['points'])."', '".mysql_clean($rp)."')");
		} else {
			mysql_query("UPDATE `ranks` SET name = '".mysql_clean($_POST['name'])."', points = '".mysql_clean($_POST['points'])."', permissions = '".mysql_clean($rp)."' WHERE id = '".$rank['id']."'");
		}
		$ok = true;
		echo '<strong>El rango se ha '.($rank ? 'editado' : 'creado').' con &eacute;xito</strong>';
	}
}
if(!$ok) {
?>
<center>
<form name="form" method="post" action="<?=$url;?>">
<?php
if($rank) {
	echo '<span style="font-size:16px;font-weight:bold;">Editar el rango "'.$rank['name'].'"</span>';
} else {
	echo '<span style="font-size:16px;font-weight:bold;">Crear nuevo rango</span>';
}
?>
<br />
<br />
Nombre:
<br />
<input type="text" name="name" value="<?=$rank['name'];?>" />
<br />
<br />
Puntos por d&iacute;a:
<br />
<input type="text" name="points" value="<?=$rank['points'];?>" />
<br />
<br />
Permisos:
<style type="text/css">
#rd { width: 650px; align: center; margin: 10px 25px 10px 25px; border: 1px solid #333; vertical-align: baseline; border-bottom: none; }
#rd div.rank { display: block; height: 20px; vertical-align: baseline; padding-left: 10px; border-bottom: 1px solid #333; }
#rd div.right { float: right; display: inline; height: 20px; vertical-align: center; width: 100px; text-align: center; border-left: 1px solid #333; }
#rd div.hidden { display: none; border-top: 1px solid #333; height: 20px; vertical-align: baseline; padding: 0; }
</style>
<div id="rd">
<?php
foreach($ranks as $code => $name) {
	echo '<div class="rank">
	<div class="right"><input type="checkbox" name="p_'.$code.'" value="'.$code.'"'.(in_array($code, $permissions) ? ' checked' : '').' /></div>
	<strong>'.$name.'</strong>&nbsp;&nbsp;&nbsp;C&oacute;digo: '.$code.'&nbsp;&nbsp;&nbsp;<a href="#" onclick="if($(\'#h'.$code.'\').css(\'display\')==\'block\'){$(\'#h'.$code.'\').css(\'display\',\'none\');$(this).html(\'Mostrar descripci&oacute;n\');$(this).parent().css(\'height\', \'20px\');return false;}else{$(\'#h'.$code.'\').css(\'display\',\'block\');$(this).html(\'Ocultar descripci&oacute;n\');$(this).parent().css(\'height\', \'40px\');return false;}">Mostrar descripci&oacute;n</a>
	<div class="hidden" id="h'.$code.'">'.$desc[$code].'</div>
	</div>';
}
?>
</div>
<input type="submit" name="enviar" value="<?=($rank ? 'Editar rango' : 'Crear rango');?>" class="mBtn btnOk" />
</form>
</center>
<? } /*ok*/ ?>