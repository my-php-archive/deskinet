<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('0Logeate'); }
if(!$_POST['sa'] || !$_POST['id']) { die('0Faltan datos'); }
if(!isAllowedTo('notes')) { die('0A donde vas mangas verdes...'); }
if($_POST['sa'] != 'new' && $_POST['sa'] != 'delete' && $_POST['sa'] != 'edit' && $_POST['sa'] != 'edit2') { die('0Accion incorrecta'); }
$sa = $_POST['sa'];
if($sa == 'new') {
	$q = mysql_query("SELECT u.id FROM users AS u, ranks AS r WHERE r.permissions REGEXP '(^|,)showpanel($|,)' && r.permissions REGEXP '(^|,)notes($|,)' && u.id != '".$currentuser['id']."' && u.rank = r.id") or die(mysql_error());
	while(list($id) = mysql_fetch_row($q)) {
		$read .= ','.$id;
	}
	$read = substr($read, 1);
    $time = time();
	mysql_query("INSERT INTO `admin_notes` (author, message, time, `read`) VALUES ('".$currentuser['id']."', '".mysql_clean($_POST['id'])."', '".$time."', '".$read."')") or die('-->'.mysql_error().'-.-');
	die(mysql_insert_id().':'.bbcode($_POST['id']).':'.$currentuser['nick'].' ('.date('d/m/Y H:i:s', $time).')');
} elseif($sa == 'delete') {
	if(!mysql_num_rows($q = mysql_query("SELECT author FROM `admin_notes` WHERE id = '".mysql_clean($_POST['id'])."'"))) { die('0Post no valido'); }
	$note = mysql_fetch_array($q);
	if($note['author'] != $currentuser['id'] && $currentuser['rank'] != 8) { die('0No es tu nota'); }
	mysql_query("DELETE FROM `admin_notes` WHERE id = '".mysql_clean($_POST['id'])."'");
	die('1');
} elseif($sa == 'edit') {
	if(!mysql_num_rows($q = mysql_query("SELECT author, message FROM `admin_notes` WHERE id = '".mysql_clean($_POST['id'])."'"))) { die('0Post no valido'); }
	$note = mysql_fetch_array($q);
	if($note['author'] != $currentuser['id'] && !isAllowedTo('editnotes')) { die('0No puedes editar la nota'); }
	die($note['message']);
} elseif($sa == 'edit2') {
	if(!preg_match('/[0-9]+:.*/', $_POST['id'])) { die('0Post no valido'); }
	$ex = explode(':', $_POST['id']);
	$id = mysql_clean($ex[0]);
	$message = mysql_clean($ex[1]);
	unset($ex);
	if(!mysql_num_rows($q = mysql_query("SELECT author, `read`, `edit` FROM `admin_notes` WHERE id = '".$id."'"))) { die('0Post no valido'); }
	$note = mysql_fetch_array($q);
	if($note['author'] != $currentuser['id'] && !isAllowedTo('editnotes')) { die('0No es tu nota'); }
	$uq = mysql_query("SELECT u.id FROM users AS u, ranks AS r WHERE r.permissions REGEXP '(^|,)showpanel($|,)' && r.permissions REGEXP '(^|,)notes($|,)' && u.id != '".$currentuser['id']."' && u.rank = r.id") or die(mysql_error());
	while(list($u) = mysql_fetch_row($uq)) {
		if(preg_match('/(^|,)'.$currentuser['id'].'($|,)/', $note['read']) || preg_match('/(^|,)'.$currentuser['id'].'($|,)/', $note['read'])) { continue; }
		$edit .= ','.$u;
	}
	$edit = substr($edit, 1);
	mysql_query("UPDATE `admin_notes` SET message = '".$message."', `edit` = '".$edit."' WHERE id = '".$id."'") or die('->'.mysql_error());
	die(bbcode($message));
}
?>