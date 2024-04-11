<?php
if(!defined('admin')) { die; }
if(!isAllowedTo('ranks')) { die; }
$sort_by = (!$_GET['sort_by'] || ($_GET['sort_by'] != 'nick' && $_GET['sort_by'] != 'mod' && $_GET['sort_by'] != 'reason' && $_GET['sort_by'] != 'time' && $_GET['sort_by'] != 'end' && $_GET['sort_by'] != 'active') ? 'time' : mysql_clean($_GET['sort_by']));
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
?>
<table class="linksList">
		<thead>
			<tr>
				<th width="100"><a class="here" href="#" onclick="return false;">Rango</a></th>
                <th width="50"><a class="here" href="#" onclick="return false;">Puntos</a></th>
				<th width="450"><a class="here" href="#" onclick="return false;">Permisos</a></th>
                <th width="100"><a class="here" href="#" onclick="return false;">Opciones</a></th>
			</tr>
		</thead>
	<tbody>
		<tbody>
        <?php
		$query = mysql_query("SELECT * FROM `ranks` ORDER BY id ASC");
		while($rank = mysql_fetch_array($query)) {
			$ex = explode(',', $rank['permissions']);
			$f = '';
			foreach($ranks as $name => $for) {
				if(!in_array($name, $ex)) { $f[] = $name; continue; }
				$r[$rank['id']] .= '<strong>'.$for.'</strong> ('.$name.'): '.$desc[$name].'<br />';
			}
			if(empty($r[$rank['id']]) || !$r[$rank['id']]) { $r[$rank['id']] = 'No tiene ning&uacute;n permiso<br />'; }
			$r[$rank['id']] .= '<br /><strong>No tiene permiso para:</strong>';
			if($f != '') {
				foreach($f as $name) {
					$r[$rank['id']] .= '<br /><strong>'.$ranks[$name].'</strong> ('.$name.') <span title="'.$desc[$name].'">[?]</span>';
				}
			}
			$ro = mysql_num_rows(mysql_query("SELECT id FROM `users` WHERE rank = '".$rank['id']."'"));
			$q = mysql_query("SELECT id, nick FROM `users` WHERE rank = '".$rank['id']."' ORDER BY id DESC LIMIT 30");
			$u[$rank['id']] = $ro.' usuarios con este rango.<br />';
			if($ro > 30) { $u[$rank['id']] .= 'Mostrando solo 30, para ver m&aacute;s, usa esta query desde PHPMyADMIN -> SQL:<br />SELECT u.id AS id, u.nick AS nick, r.name AS rango FROM users AS u, ranks AS r WHERE u.rank = \\\''.$rank['id'].'\\\' && r.id = \\\''.$rank['id'].'\\\' ORDER BY u.id DESC<br />'; }
			while($user = mysql_fetch_array($q)) {
				$u[$rank['id']] .= '<br /><strong>'.$user['nick'].'</strong> (ID: '.$user['id'].')';
			}
			echo '<tr>
				<td width="200">'.$rank['name'].'</td>
				<td width="50">'.$rank['points'].'</td>
				<td width="350">'.str_replace(',', ', ', $rank['permissions']).'</td>
				<td width="100"><a href="#" onclick="mydialog.alert(\'Usuarios con este rango\', users_d['.$rank['id'].']);mydialog.center();return false;" title="Ver usuarios con este rango">Usuarios</a><br /><a href="#" onclick="mydialog.alert(\'Permisos del rango\', rank_d['.$rank['id'].']);mydialog.center();return false;" title="Ver descripci&oacute;n de los permisos">M&aacute;s</a><br /><a href="/admin/editar-rango/'.$rank['id'].'/">Editar</a></td>
			</tr>';
		}
		echo '</tbody></tbody></table><script type="text/javascript">var rank_d = new Array('.count($r).');var users_d = new Array('.count($u).');';
		foreach($r as $id => $t) {
			echo "\nrank_d[$id] = '$t';";
		}
		foreach($u as $id => $t) {
			echo "\nusers_d[$id] = '$t';";
		}
		echo '</script>';
		?>