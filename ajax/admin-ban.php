<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('0Logeate'); }
if(!isAllowedTo('ban')) { die('0No tienes permisos'); }
if(ctype_digit($_POST['end'])) { $_POST['end'] = date('d-m-Y-H-i', $_POST['end']); }
if(!$_POST['sa'] || !$_POST['user'] || !$_POST['ac'] || !$_POST['st'] || !$_POST['end'] || !$_POST['reason']) { die('0Faltan datos'); }
if(($_POST['sa'] != 'check' && $_POST['sa'] != 'ban') || ($_POST['st'] != 'id' && $_POST['st'] != 'nick') || ($_POST['ac'] != '1' && $_POST['ac'] != '2') || ($_POST['end'] != 'permanent' && !preg_match('/^[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}$/', $_POST['end']))) { die('0Datos incorrectos'); }
if($_POST['sa'] == 'check') {
	if(!mysql_num_rows($query = mysql_query("SELECT id, nick FROM `users` WHERE ".mysql_clean($_POST['st'])." = '".mysql_clean($_POST['user'])."'"))) { die('0El usuario no es correcto'); }
	$u = mysql_fetch_array($query);
	if($_POST['ac'] == '1') {
		$select = '<br />Fin de baneo (dd/mm/aaaa hh:mm):<br /><input type="text" size="2" maxlength="2" name="eday" onkeyup="if(this.value.length == 2 && this.value > 31) { this.value = 31; } else if(this.value.length == 2 && this.value < 1) { this.value = 1; }" value="'.date('d').'" /> / <input type="text" size="2" maxlength="2" name="emonth" onkeyup="if(this.value.length == 2 && this.value > 12) { this.value = 12; } else if(this.value.length == 2 && this.value < 1) { this.value = 1; }" value="'.date('m').'" /> / <input type="text" size="4" maxlength="4" name="eyear" onkeyup="if(this.value.length == 4 && this.value < '.date('Y').') { this.value = '.date('Y').'; }" value="'.date('Y').'" /> <input type="text" size="2" maxlength="2" name="ehour" onkeyup="if(this.value.length == 2 && this.value > 23) { this.value = 23; } else if(this.value.length == 2 && this.value < 0) { this.value = 0; }" value="'.date('H').'" /> : <input type="text" size="2" maxlength="2" name="eminutes" onkeyup="if(this.value.length == 2 && this.value > 59) { this.value = 59; } else if(this.value.length == 2 && this.value < 1) { this.value = 1; }" value="'.date('i').'" />&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="permanent" /> Permanente</label>';
		if(isAllowedTo('ban_all')) {
			$ba = '<label><input type="checkbox" name="alli" onclick="if(this.checked){return confirm(\\\'¿Seguro que quieres usar el baneo total?\\\');}" /> Baneo total</label>';
			$aTa = true;
		} else {
			$ba = '<input type="hidden" name="alli" />';
		}
		if(isAllowedTo('ban_lock')) {
			$bl = '<label><input type="checkbox" name="lock" onclick="if(this.checked){return confirm(\\\'¿Seguro que quieres usar el bloqueo?\\\');}" /> Bloqueo</label>';
			$aTl = true;
		} else {
			$bl = '<input type="hidden" name="lock" />';
		}
		if(isset($aTa) && isset($aTl)) {
			$select .= '<br />';
		}
		$select .= $ba;
		if(isset($aTa) && isset($aTl)) {
			$select .= '&nbsp;&nbsp;';
		}
		$select .= $bl;
		$select .= '<br />Raz&oacute;n:<br /><input type="text" name="reason" size="30" maxlength="50" />';
	} else {
		$bq = mysql_query("SELECT reason, end FROM `bans` WHERE user = '".$u['id']."' && active = '1'");
		if(mysql_num_rows($bq)) {
			$ban = mysql_fetch_array($bq);
			$select = '<br />Fin de baneo: '.date('d/m/Y H:i', $ban['end']).'<br />Raz&oacute;n: '.$ban['reason'];
		} else {
			$select = 'El usuario no est&aacute; baneado.';
		}
	}
	$select .= '<br /><input type="submit" class="button" style="font-size:11px;" value="'.($_POST['ac'] == '1' ? 'Banear' : 'Desbanear').'" onclick="ra = \'ban\';" />';
	die(($_POST['st'] == 'id' ? 'Nick: '.$u['nick'] : 'ID: '.$u['id']).'SEP'.$select);
} else { //ac
	if($_POST['ac'] == '1') {
		if(!mysql_num_rows($uq = mysql_query("SELECT id, rank, currentip FROM `users` WHERE ".mysql_clean($_POST['st'])." = '".mysql_clean($_POST['user'])."'"))) { die('No existe el usuario'); }
		$user = mysql_fetch_array($uq);
		if(mysql_num_rows(mysql_query("SELECT id FROM `bans` WHERE user = '".$user['id']."' && active = '1'"))) { die('0Ya ha sido baneado'); }
		if(!isAllowedTo('banadmins') && $user['rank'] == 8) { die('Los moderadores no pueden banear a otros moderadores o administradores'); }
		if($_POST['end'] == 'permanent') {
			$end = '0';
		} else {
			$ex = explode('-', $_POST['end']);//strtotime('Y-m-d H:i')
			if($ex[0] < 1) { $ex[0] = 1; }
			if($ex[1] > 12) { $ex[1] = 12; } elseif($ex[1] < 1) { $ex[1] = 1; }
			if($ex[2] < date('Y')) { $ex[2] = date('Y'); }
			if($ex[1]%2 == 0) {
				if($ex[1] == 2) {
					if(($ex[2]%4 == 0) && (($ex[2]%100 != 0) || ($ex[2]%400 == 0))) {
						if($ex[0] > 29) { $ex[0] = 29; }
					} else {
						if($ex[0] > 28) { $ex[0] = 28; }
					}
				} else {
					if($ex[0] > 30) { $ex[0] = 30; }
				}
			} else {
				if($ex[0] > 31) { $ex[0] = 31; }
			}
			if($ex[3] > 23) { $ex[3] = 23; } elseif($ex[3] < 0) { $ex[3] = 0; }
			if($ex[4] > 59) { $ex[3] = 59; } elseif($ex[4] < 0) { $ex[4] = 0; }
			$end = strtotime($ex[2].'-'.$ex[1].'-'.$ex[0].' '.$ex[3].':'.$ex[4]);
		}
		mysql_query("INSERT INTO `bans` (user, ip, `mod`, end, `lock`, time, reason) VALUES ('".$user['id']."', '".$user['currentip']."', '".$currentuser['id']."', '".$end."', '".($_POST['lock'] && isAllowedTo('ban_lock') ? '1' : '0')."', '".time()."', '".mysql_clean($_POST['reason'])."')") or die('0'.mysql_error());
		//if($_POST['all'] && $currentuser['rank'] == 8) {
		if($_POST['all'] && isAllowedTo('ban_all')) {
			mysql_query("DELETE FROM `comments` WHERE author = '".$user['id']."'");
			$qdp = mysql_query("SELECT id FROM `posts` WHERE author = '".$user['id']."'");
			while($fdp = mysql_fetch_array($qdp)) {
				$q = mysql_query("SELECT id FROM `comments` WHERE post = '".$fdp['id']."'");
				while($c = mysql_fetch_assoc($q)) {
					mysql_query("DELETE FROM `comment_complaints` WHERE comment = '".$c['id']."'");
					mysql_query("DELETE FROM `comment_votes` WHERE comment = '".$c['id']."'");
				}
				mysql_query("DELETE FROM `comments` WHERE post = '".$fdp['id']."'");
				mysql_query("DELETE FROM `complaints` WHERE post = '".$fdp['id']."'");
				mysql_query("DELETE FROM `favorites` WHERE post = '".$fdp['id']."'");
				mysql_query("DELETE FROM `follows` WHERE what = '1' && who = '".$fdp['id']."'");
				mysql_query("DELETE FROM `notifications` WHERE link REGEXP '/posts/.*/".$fdp['id']."(\..+)?/.*\.html'");
				mysql_query("DELETE FROM `visits` WHERE post = '".$fdp['id']."'");
			}
			mysql_query("DELETE FROM `posts` WHERE author = '".$user['id']."'");
		}
		die('1');
	} else if($_POST['ac'] == '2') {
		if($_POST['ban']) {
			if(!mysql_num_rows(mysql_query("SELECT * FROM `bans` WHERE id = '".mysql_clean($_POST['ban'])."' && active = '1'"))) { die('0No existe el que quieres desbanear o ya ha sido desbaneado'); }
			mysql_query("UPDATE `bans` SET active = '0', unban_time = '".time()."', unban_mod = '".$currentuser['id']."' WHERE id = '".mysql_clean($_POST['ban'])."'");
			die('1');
		} else {
			if(!mysql_num_rows($uq = mysql_query("SELECT id FROM `users` WHERE ".mysql_clean($_POST['st'])." = '".mysql_clean($_POST['user'])."'"))) { die('0No existe el usuario'); }
			$user = mysql_fetch_array($uq);
			if(!mysql_num_rows($b = mysql_query("SELECT id FROM `bans` WHERE user = '".$user['id']."' && active = '1'"))) { die('No existe el que quieres desbanear o ya ha sido desbaneado'); }
			$ban = mysql_fetch_array($b);
			mysql_query("UPDATE `bans` SET active = '0', unban_time = '".time()."', unban_mod = '".$currentuser['id']."' WHERE id = '".$ban['id']."'");
			die('1');
		}
	}
}
?>