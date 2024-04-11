<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if(!$_GET['group'] || !mysql_num_rows($qgroup = mysql_query("SELECT * FROM `groups` WHERE urlname = '".mysql_clean($_GET['group'])."'"))) {
	$groupdie = true;
	$txt['page_title'] = 'Comunidad inexistente';
}
if(!$groupdie) {
$group = mysql_fetch_array($qgroup);
if($group['private'] == '1' && !isLogged()) { die(error('OOPS!', 'Debes estar logeado para ver esta comunidad', 'P&aacute;gina principal de comunidades', '/comunidades/')); }
$cat = mysql_fetch_array(mysql_query("SELECT urlname, name FROM `group_categories` WHERE id = '".$group['cat']."'"));
$subcat = mysql_fetch_array(mysql_query("SELECT urlname, name FROM `group_categories` WHERE id = '".$group['subcat']."'"));
$creator = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$group['creator']."'"));
if(mysql_num_rows($q = mysql_query("SELECT * FROM `group_members` WHERE `group` = '".$group['id']."' AND user = '".$currentuser['id']."'"))) {
	$currentuser['group'] = mysql_fetch_array($q);
	$currentuser['isMember'] = true;
}
$txt['page_title'] = htmlspecialchars($group['name']);
}// groupdie
?>