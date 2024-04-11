<?php
if(!defined('admin')) { header('Location: /index.php'); }
if(!isAllowedTo('changerank')) { die; }
?>
<iframe name="hit" style="display:none;"></iframe>
<a name="mda"></a>
<div style="display:none;text-align:center;" id="mensajes_div"></div>
<center>
<form name="rf" method="post" onsubmit="admin_rank(this);" action="/blank.html" target="hit">
Seleccionar:
<br />
<label>ID <input type="radio" name="st" value="id" /></label>&nbsp;&nbsp;<label><input type="radio" name="st" value="nick" /> Nick</label>
<br />
ID/Nombre:
<div id="user_data" style="display:none;"></div>
<br />
<input type="text" name="user" size="30" />
<br />
<input type="submit" class="button" style="font-size:11px;" value="Seleccionar" onclick="ra = 'check';" />
<div id="form_select"></div>
</form>
</center>