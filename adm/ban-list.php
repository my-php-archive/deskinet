<?php
if(!defined('admin')) { header('Location: /index.php'); }
$sort_by = (!$_GET['sort_by'] || ($_GET['sort_by'] != 'nick' && $_GET['sort_by'] != 'mod' && $_GET['sort_by'] != 'reason' && $_GET['sort_by'] != 'time' && $_GET['sort_by'] != 'end' && $_GET['sort_by'] != 'active') ? 'time' : mysql_clean($_GET['sort_by']));
?>
<table class="linksList">
		<thead>
			<tr>
				<th><a href="?sort_by=nick" <?=($sort_by == 'nick' ? ' class="here"' : '');?>>Usuario</a></th>
				<th><a href="?sort_by=mod" <?=($sort_by == 'mod' ? ' class="here"' : '');?>>Moderador</a></th>
                <th><a href="?sort_by=reason" <?=($sort_by == 'reason' ? ' class="here"' : '');?>>Causa</a></th>
				<th><a href="?sort_by=from" <?=($sort_by == 'time' ? ' class="here"' : '');?>>Desde</a></th>
                <th><a href="?sort_by=end" <?=($sort_by == 'end' ? ' class="here"' : '');?>>Hasta</a></th>
                <th><a href="?sort_by=active" <?=($sort_by == 'active' ? ' class="here"' : '');?>>Activo</a></th>
                <th></th>
			</tr>
		</thead>
	<tbody>
		<tbody>
        <?php
		if($sort_by == 'nick' || $sort_by == 'mod') {
			$sort_by = 'u.nick';
		} else {
			$sort_by = 'b.'.$sort_by;
		}
		$query = mysql_query("SELECT b.*, IF(b.end = 0, 1, 0) AS permanent FROM bans AS b, users AS u WHERE u.id = b.".($sort_by == 'mod' ? 'mod' : 'user')." ORDER BY ".$sort_by." ".($sort_by == 'reason' || $sort_by == 'mod' || $sort_by == 'nick' ? 'ASC' : 'DESC').", active DESC, permanent DESC, end DESC, time DESC") or die(mysql_error());
		if(!mysql_num_rows($query)) {
			echo '<tr><td colspan="6" align="center">No hay baneados</td></tr></tbody></tbody></table>';
		} else {
			while($ban = mysql_fetch_array($query)) {
				$mod = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$ban['mod']."'"));
				$user = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$ban['user']."'"));
				echo '<tr>
						<td><a href="/perfil/'.$user['nick'].'">'.$user['nick'].'</a></td>
						<td><a href="/perfil/'.$mod['nick'].'">'.$mod['nick'].'</a></td>
						<td>'.htmlspecialchars($ban['reason']).'</td>
						<td>'.gmdate('d/m/Y H:i', $ban['time']).'</td>
						<td>'.($ban['end'] == '0' ? 'Permanente' : gmdate('d/m/Y H:i', $ban['end'])).'</td>
						<td>'.($ban['active'] == '1' ? 'S&iacute;' : 'No').'</td>
						<td>'.($ban['active'] == '1' ? '<a href="/admin/desbanear/?ban='.$ban['id'].'">Desbanear</a>' : '').'</td>
					</tr>';
			}
			echo '</tbody></tbody></table>';
		} // M_N_R
		?>