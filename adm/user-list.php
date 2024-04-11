<?php
if(!defined('admin')) { header('Location: /index.php'); }
$sort_by = (!$_GET['sort_by'] || ($_GET['sort_by'] != 'nick' && $_GET['sort_by'] != 'name' && $_GET['sort_by'] != 'email' && $_GET['sort_by'] != 'reg_time' && $_GET['sort_by'] != 'active') ? 'nick' : mysql_clean($_GET['sort_by']));
?>
<script type="text/javascript">$('.hideHelp').tipsy({gravity: 's'});</script>
<table class="linksList">
		<thead>
			<tr>
				<th><a href="?sort_by=nick" <?=($sort_by == 'nick' ? ' class="here"' : '');?>>Usuario</a></th>
				<th><a href="?sort_by=name" <?=($sort_by == 'name' ? ' class="here"' : '');?>>Nombre</a></th>
                <th><a href="?sort_by=email" <?=($sort_by == 'email' ? ' class="here"' : '');?>>EMail</a></th>
				<th><a href="?sort_by=reg_time" <?=($sort_by == 'reg_time' ? ' class="here"' : '');?>>Registrado</a></th>
				<th><a href="?sort_by=active" <?=($sort_by == 'active' ? ' class="here"' : '');?>>Activo</a></th>
                <th></th>
			</tr>
		</thead>
	<tbody>
		<tbody>
        <?php
		//if($sort_by != 'ban') { $sort_by = 'u.'.$sort_by; }
		$query = mysql_query("SELECT * FROM `users` ORDER BY ".$sort_by." ".($sort_by == 'nick' || $sort_by == 'name' ? 'ASC' : 'DESC').", nick ASC") or die(mysql_error());
		if(!mysql_num_rows($query)) {
			echo '<tr><td colspan="6" align="center">No hay baneados</td></tr></tbody></tbody></table>';
		} else {
			while($user = mysql_fetch_array($query)) {
				echo '<tr>
						<td><a href="/perfil/'.$user['nick'].'">'.$user['nick'].'</a></td>
						<td>'.($currentuser['rank'] == 8 ? htmlspecialchars($user['name']) : '<span style="font-style:italic;" class="hideHelp" title="Algunos datos se ocultan a los moderadores para conservar la intimidad del usuario">Oculto (?)</span>').'</td>
						<td>'.($currentuser['rank'] == 8 ? htmlspecialchars($user['email']) : '<span style="font-style:italic;" class="hideHelp" title="Algunos datos se ocultan a los moderadores para conservar la intimidad del usuario">Oculto (?)</span>').'</td>
						<td>'.gmdate('d/m/Y H:i', $user['reg_time']).'</td>
						<td>'.($user['active'] == '1' ? 'S&iacute;' : 'No').'</td>
						</tr>';
			}
			echo '</tbody></tbody></table>';
		} // M_N_R
		?>