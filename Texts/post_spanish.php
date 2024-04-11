<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if(!mysql_num_rows($qpost = mysql_query("SELECT * FROM `posts` WHERE id = '".mysql_clean($_GET['id'])."'"))) {
	$txt['page_title'] = 'Post inexistente';
	$post = false;
} else {
	$post = mysql_fetch_array($qpost);
	$txt['page_title'] = $post['title'];
}
?>