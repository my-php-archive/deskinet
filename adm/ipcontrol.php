<?php
if(!defined('admin')) { header('Location: /index.php'); }
$sort_by = (!$_GET['sort_by'] || ($_GET['sort_by'] != 'nick' && $_GET['sort_by'] != 'ip' && $_GET['sort_by'] != 'proxy' && $_GET['sort_by'] != 'cbr' && $_GET['sort_by'] != 'time' && $_GET['sort_by'] != 'num') ? 'nick' : mysql_clean($_GET['sort_by']));
?>
<form name="ipc" method="post" action="">
Mostrar:
<br />
<input type="radio" name="s" value="1" /> Todo
<br />
<input type="radio" name="s" value="2" /> IPs a las que han entrado como m&iacute;nimo X usuarios
<br />
<input type="radio" name="s" value="3" /> Usuario que ha entrado a una IP como m&iacute;nimo X veces
<br />
<input type="radio" name="s" value="4" /> IPs que us&oacute; un usuario
<br />
<input type="radio" name="s" value="5" /> Usuarios que usaron una IP
<br />
Usuario/IP: <input type="text" name="ui" size="20" />
<br />
N&uacute;mero de veces/usuarios: <input type="text" name="v" size="3" />
<br />
<input type="submit" class="button" value="Mostrar" />
</form>
</div> <!--CBC?-->
<br class="clear" />
<div class="box_title"></div>
<div class="box_cuerpo">
<table class="linksList">
		<thead>
			<tr>
				<th><a href="?sort_by=nick" <?=($sort_by == 'nick' ? ' class="here"' : '');?> title="Usuario que entr&oacute; con la IP correspondiente">Usuario</a></th>
				<th><a href="?sort_by=ip" <?=($sort_by == 'ip' ? ' class="here"' : '');?> title="IP en cuesti&oacute;n">IP</a></th>
                		<th><a href="?sort_by=proxy" <?=($sort_by == 'proxy' ? ' class="here"' : '');?> title="Si no usa proxy se deja en blanco, si no, se muestra el rastro del proxy">Proxy</a></th>
				<th><a href="?sort_by=cbr" <?=($sort_by == 'cbr' ? ' class="here"' : '');?> title="Si usa proxy, posible IP real">Posible IP</a></th>
				<th><a href="?sort_by=num" <?=($sort_by == 'num' ? ' class="here"' : '');?> title="N&uacute;mero de entradas a la IP correspondiente">N&uacute;mero</a></th>
				<th><a href="?sort_by=time" <?=($sort_by == 'time' ? ' class="here"' : '');?> title="Fecha de entrada a la IP">Fecha</a></th>
                <th></th>
			</tr>
		</thead>
	<tbody>
		<tbody>
        <?php
		if($sort_by == 'nick') { $sort_by = 'u.nick'; } else { $sort_by = 'i.'.$sort_by; }
		if($_POST['s'] == 2) {
			$query = mysql_query("SELECT i.*, u.nick AS nick, COUNT(i.*) AS num FROM ips AS i, users AS u WHERE u.id = i.user && i.ip = '".mysql_clean($_POST['ui'])."' && num >= '".mysql_clean($_POST['v'])."' GROUP BY i.ip ORDER BY ".$sort_by." ".($sort_by == 'nick' || $sort_by == 'num' ? 'ASC' : 'DESC').", u.nick ASC") or die(mysql_error());
		} elseif($_POST['s'] == 3) {
			$query = mysql_query("SELECT i.*, u.nick AS nick, COUNT(i.*) AS num FROM ips AS i, users AS u WHERE u.id = i.user && u.nick = '".mysql_clean($_POST['ui'])."' && num >= '".mysql_clean($_POST['v'])."' GROUP BY i.ip ORDER BY ".$sort_by." ".($sort_by == 'nick' || $sort_by == 'num' ? 'ASC' : 'DESC').", u.nick ASC") or die(mysql_error());
		} elseif($_POST['s'] == 4) {
			$query = mysql_query("SELECT i.*, u.nick AS nick, COUNT(i.*) AS num FROM ips AS i, users AS u WHERE u.id = i.user && u.nick = '".mysql_clean($_POST['ui'])."' GROUP BY i.ip ORDER BY ".$sort_by." ".($sort_by == 'nick' || $sort_by == 'num' ? 'ASC' : 'DESC').", u.nick ASC") or die(mysql_error());
		} elseif($_POST['s'] == 5) {
			$query = mysql_query("SELECT i.*, u.nick AS nick, COUNT(i.*) AS num FROM ips AS i, users AS u WHERE u.id = i.user && i.ip = '".mysql_clean($_POST['ui'])."' && num >= '".mysql_clean($_POST['v'])."' GROUP BY i.ip ORDER BY ".$sort_by." ".($sort_by == 'nick' || $sort_by == 'num' ? 'ASC' : 'DESC').", u.nick ASC") or die(mysql_error());
		} else {
			$query = mysql_query("SELECT i.*, u.nick AS nick, COUNT(i.*) AS num FROM ips AS i, users AS u WHERE u.id = i.user GROUP BY i.ip ORDER BY ".$sort_by." ".($sort_by == 'nick' || $sort_by == 'num' ? 'ASC' : 'DESC').", u.nick ASC") or die(mysql_error());
		}
		if(!mysql_num_rows($query)) {
			echo '<tr><td colspan="6" align="center">No hay resultados, &iquest;Son todos los datos correctos?</td></tr></tbody></tbody></table>';
		} else {
			while($data = mysql_fetch_array($query)) {
				echo '<tr>
						<td><a href="/perfil/'.$data['nick'].'">'.$data['nick'].'</a></td>
						<td>'.$data['ip'].'</td>
						<td>'.$data['proxy'].'</td>
						<td>'.$data['cbr'].'</td>
						<td>'.$data['num'].'</td>
						<td>'.date('d/m/Y H:i:s', $data['time']).'</td>
						</tr>';
			}
			echo '</tbody></tbody></table>';
		} // M_N_R
		?>