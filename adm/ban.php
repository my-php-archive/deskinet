<?php
if(!defined('admin')) { header('Location: /index.php'); }
if(!$_GET['ac'] || ($_GET['ac'] != '1' && $_GET['ac'] != '2')) { $_GET['ac'] = '1'; }
if($_GET['ban'] && !mysql_num_rows($q = mysql_query("SELECT id, user FROM `bans` WHERE id = '".mysql_clean($_GET['ban'])."'"))) { unset($_GET['ban']); }
if($_GET['ban']) {
	$ban = mysql_fetch_array($q);
	$user = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$ban['user']."'"));
	echo '<script type="text/javascript">ra = \'check\';admin_ban('.$_GET['ac'].', document.rf);</script>'; }
?>
<iframe name="hit" style="display:none;"></iframe>
<a name="mda"></a>
<div style="display:none;text-align:center;" id="mensajes_div"></div>
<center>
<form name="rf" method="post" onsubmit="admin_ban(<?=$_GET['ac'];?>, this);" action="/blank.html" target="hit">
Seleccionar:
<br />
<label>ID <input type="radio" name="st" value="id" /></label>&nbsp;&nbsp;<label><input type="radio" name="st" value="nick"<?=($ban ? ' checked' : '');?> /> Nick</label>
<br />
ID/Nombre:
<div id="user_data" style="display:none;"></div>
<br />
<input type="text" name="user" size="30" value="<?=$user['nick'];?>" />
<br />
<input type="submit" class="button" style="font-size:11px;" value="Seleccionar" onclick="ra = 'check';document.getElementById('bani').value = '';" />
<input type="hidden" name="ban" value="<?=$ban['id'];?>" id="bani" />
<div id="form_select"></div>
</form>
</center>