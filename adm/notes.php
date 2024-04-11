<?php
if(!defined('admin')) { die; }
if(!isAllowedTo('notes')) { die; }
?>
<iframe name="hit" style="display:none;"></iframe>
<a name="mda"></a>
<div style="display:none;text-align:center;" id="mensajes_div" class="ok">Procesando...</div>
<form name="af" method="post" onsubmit="admin_notes('new', this.message.value);" action="/blank.html" target="hit">
A&ntilde;adir nota:
<br />
<textarea class="agregar cuerpo" style="height:200px;" id="markItUp" name="message"></textarea>
<br />
<input type="submit" class="button" style="font-size:11px;" value="A&ntilde;adir nota" />
<br />
Por favor, no a&ntilde;adir muchas notas e ir borrando las inservibles, a fin de que este sistema vaya bien y no se arme un lio ;)
</form>
<br />
<br />
Notas:
<br />
<?php
$query = mysql_query("SELECT * FROM `admin_notes` ORDER BY time DESC");
if(!mysql_num_rows($query)) { echo '<p id="block_nn">No hay notas...</p><script type="text/javascript">var first_node = \'nn\';</script>'; } else {
	$v = true;
	while($note = mysql_fetch_array($query)) {
		$r = explode(',', $note['read']);
		$e = explode(',', $note['edit']);
		if($v === true) { echo '<script type="text/javascript">var first_node = '.$note['id'].';</script>'; unset($v); }
		$author = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$note['author']."'"));
		echo '<blockquote id="block_'.$note['id'].'"><div class="cita">';
		if(in_array($currentuser['id'], $r)) {
			echo '<img src="/images/space.gif" width="16" height="16" align="absmiddle" style="margin-right:3px;display:inline;" class="systemicons rango0" alt="nueva" title="La nota es nueva" />';
			list($key) = array_keys($r, $currentuser['id']);
			unset($r[$key]);
			mysql_query("UPDATE `admin_notes` SET `read` = '".implode(',', $r)."' WHERE id = '".$note['id']."'") or die('->'.mysql_error());
		}
		if(in_array($currentuser['id'], $e)) {
			echo '<img src="/images/editar.png" width="10" height="10" align="absmiddle" style="margin-right:3px;" alt="editada" title="La nota ha sido editada" />';
			list($key) = array_keys($e, $currentuser['id']);
			unset($e[$key]);
			mysql_query("UPDATE `admin_notes` SET `edit` = '".implode(',', $e)."' WHERE id = '".$note['id']."'");
		}
		echo $author['nick'].' ('.gmdate('d/m/Y H:i:s', $note['time']).')'.(isAllowedTo('editnotes') || $note['author'] == $currentuser['id'] ? '<div class="box_rss"><img style="cursor:pointer;" src="/images/borrar.png" onclick="if(confirm(\'&iquest;Seguro que quieres borrar esta nota?\')){admin_notes(\'delete\', '.$note['id'].');}" alt="Borrar" title="Borrar" /> <img style="cursor:pointer;" src="/images/editar.png" onclick="admin_notes(\'edit\', '.$note['id'].');" alt="Editar" title="Editar" /></div>' : '').'</div><div class="citacuerpo" id="cita_cuerpo_'.$note['id'].'"><p>'.bbcode($note['message']).'</p></div></blockquote><br />';
	}
}
?>