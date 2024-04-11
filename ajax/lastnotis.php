<?php
if($_GET['_']) {
	if(!$_GET['last'] || !preg_match('/^[0-9]+$/', $_GET['last'])) { die('0'); }
	include('../config.php');
	include('../functions.php');
}

if(!$_GET['_']) {
	$fq = mysql_query("SELECT id FROM `notifications` WHERE user = '".$currentuser['id']."' && readed = '1' ORDER BY time DESC LIMIT 1");
	list($id) = mysql_fetch_row($fq);
	$query = mysql_query("SELECT `text`, link, img, readed, who, displayuser FROM `notifications` WHERE user = '".$currentuser['id']."' && readed = '0' && id > '".$id."' ORDER BY time DESC");
	if(mysql_num_rows($query) < 5) {
		$query = mysql_query("SELECT `text`, link, img, readed, who, displayuser FROM `notifications` WHERE user = '".$currentuser['id']."' ORDER BY time DESC LIMIT 5");
	}
	$notirows = mysql_num_rows(mysql_query("SELECT id, `text` FROM `notifications` WHERE user = '".$currentuser['id']."' && readed = '0'"));
	echo '<script type="text/javascript">var noti_last = \''.($notirows ? $id : '0').'\';var noti_alert_time = setInterval(\'noti_alert_animate();\', 10000);</script>';
} else {
	$query = mysql_query("SELECT `text`, link, img, readed, who, displayuser FROM `notifications` WHERE user = '".$currentuser['id']."' && readed = '0' && id > '".mysql_clean($_GET['last'])."' ORDER BY time DESC");
	if(!mysql_num_rows($query)) { die('0'); }
	if(mysql_num_rows($query) < 5) {
		$query = mysql_query("SELECT `text`, link, img, readed, who, displayuser FROM `notifications` WHERE user = '".$currentuser['id']."' ORDER BY time DESC LIMIT 5");
	}
		echo mysql_num_rows(mysql_query("SELECT id FROM `notifications` WHERE user = '".$currentuser['id']."' && readed = '0'")).',';
}
if(mysql_num_rows($query)) {
	while($noti = mysql_fetch_assoc($query)) {
		list($n) = mysql_fetch_row(mysql_query("SELECT nick FROM `users` WHERE id = '".$noti['who']."'"));
		echo '<li'.($noti['readed'] == '0' ? ' class="unread"' : '').' onclick="document.location=\''.$noti['link'].'\';"><span class="icon-'.($noti['who'] == '0' ? 'medallas' : 'noti').' '.$noti['img'].'"></span>'.($noti['displayuser'] == '1' ? '<a href="/perfil/'.$n.'/" class="ndt">'.$n.'</a> ' : '').$noti['text'].'</li>';
	}
}
?>