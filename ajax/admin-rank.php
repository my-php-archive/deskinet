<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('0Logeate'); }
if(!$_GET['sa'] || !$_GET['user'] || !$_GET['st']) { die('0Faltan datos'); }
if(!isAllowedTo('changerank')) { die('0A donde vas mangas verdes...'); }
if(($_GET['sa'] != 'check' && $_GET['sa'] != 'change') || ($_GET['st'] != 'id' && $_GET['st'] != 'nick')) { die('0Acci&oacute;n incorrecta'); }
if($_GET['sa'] == 'check') {
	if(!mysql_num_rows($query = mysql_query("SELECT id, nick, rank FROM `users` WHERE ".mysql_clean($_GET['st'])." = '".mysql_clean($_GET['user'])."'"))) { die('0El usuario no es correcto'); }
	$u = mysql_fetch_array($query);
	$select = '<br /><select name="rank" onchange="if(this.selectedIndex == 0) { document.getElementById(\'mensajes_div\').className = \'error\';document.getElementById(\'mensajes_div\').innerHTML = \'No puedes dar el rango de novato\'; }">';
	$q = mysql_query("SELECT id, name FROM `ranks` ORDER BY id ASC");
	while($r = mysql_fetch_array($q)) {
			$select .= '<option value="'.$r['id'].'"';
			if($u['rank'] == $r['id']) { $select .= ' selected'; }
			$select .= '>'.$r['name'].'</option>';
	}
	$select .= '</select><br /><input type="submit" class="button" style="font-size:11px;" value="Cambiar rango" onclick="ra = \'change\';" />';
	die(($_GET['st'] == 'id' ? 'Nick: '.$u['nick'] : 'ID: '.$u['id']).'SEP'.$select);
} else {
	if(!mysql_num_rows(mysql_query("SELECT id FROM `ranks` WHERE id = '".mysql_clean($_GET['rank'])."'"))) { die('0El rango no es v&aacute;lido'); }
	if(!mysql_num_rows($query = mysql_query("SELECT id FROM `users` WHERE ".mysql_clean($_GET['st'])." = '".mysql_clean($_GET['user'])."'"))) { die('0El usuario no es correcto'); }
	$u = mysql_fetch_array($query);
	mysql_query("UPDATE `users` SET rank = '".mysql_clean($_GET['rank'])."' WHERE id = '".$u['id']."'");
	die('1');
}
?>