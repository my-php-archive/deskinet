<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if(!$_GET['group']){die('Faltan datos');}
if(!mysql_num_rows($qgroup = mysql_query("SELECT * FROM `groups` WHERE urlname = '".mysql_clean($_GET['group'])."'"))) {
	$groupdie = true;
	$txt['page_title'] = 'Comunidad inexistente';
} elseif(!mysql_num_rows($qpost = mysql_query("SELECT * FROM `group_posts` WHERE id = '".mysql_clean($_GET['post'])."'"))) {
	$np = true;
	$txt['page_title'] = 'Tema inexistente';
}
if(!$groupdie && !$np) {
$group = mysql_fetch_array($qgroup);
$cat = mysql_fetch_array(mysql_query("SELECT urlname, name FROM `group_categories` WHERE id = '".$group['cat']."'"));
$subcat = mysql_fetch_array(mysql_query("SELECT urlname, name FROM `group_categories` WHERE id = '".$group['subcat']."'"));
$creator = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$group['creator']."'"));
if(mysql_num_rows($q = mysql_query("SELECT * FROM `group_members` WHERE `group` = '".$group['id']."' AND user = '".$currentuser['id']."'"))) {
	$currentuser['group'] = mysql_fetch_array($q);
	$currentuser['isMember'] = true;
}
if(!$currentuser['isMember'] && $group['private'] == '1') {
	$gom = true;
	$txt['page_title'] = $config['script_desc'];
} else {
//post!
$post = mysql_fetch_array($qpost);
settype($post['visits'], 'int');
settype($post['points'], 'int');
if($post['group'] != $group['id']) {
	$gng = true;
	$txt['page_title'] = $config['script_desc'];
} else {
$author = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE id = '".$post['author']."'"));
if(!preg_match('/'.$_SERVER['REMOTE_ADDR'].'(\-|$)/', $post['visits_by'])) {
		$post['visits']++;
		mysql_query("UPDATE `group_posts` SET visits = '".$post['visits']."', visits_by = '".(empty($post['visits_by']) ? '' : '-').mysql_clean($_SERVER['REMOTE_ADDR'])."' WHERE id = '".$post['id']."'");
		mysql_query("INSERT INTO `group_visits` (post, time) VALUES ('".$post['id']."', '".time()."')");
}
$txt['page_title'] =  htmlspecialchars($post['title']);
}// POST NO GROUP
}// PRIVATE!
}//gdie
?>