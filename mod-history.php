<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if(!isLogged()) { die; }
// 360 303 303
?>
<div id="cuerpocontainer">
<div id="resultados" style="width:100%">
	<table class="linksList">
		<thead>
			<tr>
				<th style="width:350px;overflow:hidden;">Post</th>
				<th>Acci&oacute;n</th>
				<th>Moderador</th>
				<th>Causa</th>
			</tr>
		</thead>
	<tbody>
		<tbody>
<?php
$query = mysql_query("SELECT * FROM `mod-history` ORDER BY time DESC LIMIT 20") or die(mysql_error());
if(mysql_num_rows($query)) {
while($mh = mysql_fetch_array($query)) {
	$author = mysql_fetch_array(mysql_query("SELECT id, nick FROM `users` WHERE id = '".$mh['post_author']."'")); 
	if(!empty($mh['mod'])){$mod = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$mh['mod']."'"));}
	echo '<tr>
		<td style="text-align:left;width:350px;overflow:hidden;">
			'.$mh['post_title'].'<br />
			Por <a href="/perfil/'.$author['nick'].'/">'.$author['nick'].'</a>
		</td>
		<td>';
	switch($mh['action_type']) {
		case '1': echo '<span class="color_green">Fijado</span>'; break;
		case '2': echo '<span class="color_green">Editado</span>'; break;
		case '3': echo '<span class="color_red">Eliminado</span>'; break;
		case '4': echo '<span class="color_red">Desfijado</span>'; break;
	}
		echo '</td>
		<td>
							'.(empty($mh['mod']) ? '-' : '<a href="/perfil/'.$mod['nick'].'">'.$mod['nick'].'</a>').'
					</td>
		<td>'.(empty($mh['action_reason']) ? '-' : htmlspecialchars($mh['action_reason'])).'</td>
	</tr>';
}
?>
</tbody>
		</tbody>
	</table>
<?php
} else {
echo '<tr><td colspan="4">No hay acciones de moderadores</td></tr></tbody></tbody></table>';
}
?>
</div><div style="clear:both"></div>
</div>