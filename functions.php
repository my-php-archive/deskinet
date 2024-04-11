<?php
// Comprobar si accede directamente
if($_COOKIE['ul'] && ($_COOKIE['ul'] == md5('ko') || strlen($_COOKIE['ul']) != 32)) {
	header('HTTP/1.1 403 Forbidden');
}

// Comprobamos si está logeado
// La cookie contiene la ID y la PASS, que separamos 
mysql_query("UPDATE `bans` SET active = '0' WHERE end < '".time()."' && end != '0'");
$currentuser = false;
$explode = explode('-', $_COOKIE[$config['cookie_name']]);
if($_COOKIE[$config['cookie_name']] && mysql_num_rows($uq = mysql_query("SELECT * FROM `users` WHERE id = '".mysql_clean($explode[0])."' && password = '".mysql_clean($explode[1])."'"))) {
	$currentuser = mysql_fetch_array($uq);
	$arr = array('fef', 'fwe', 'fewf2345', 'few', '  sdvsdv', '12++`¨¨:`', '^·*$pÑS');
	setcookie('ul', md5(array_rand($arr)), time()+86400*30, '/');
	$ex = explode('-', $currentuser['points']);
	$currentuser['rank_array'] = mysql_fetch_array(mysql_query("SELECT * FROM `ranks` WHERE id = '".$currentuser['rank']."'"));
	$currentuser['rank_array']['permissions_array'] = explode(',', $currentuser['rank_array']['permissions']);
		if($ex[1] == date('d/m/Y')) {
			$currentuser['currentpoints'] = $ex[0];
		} else {
			$currentuser['currentpoints'] = $currentuser['rank_array']['points'];
			mysql_query("UPDATE `users` SET points = '".$currentuser['currentpoints']."-".date('d/m/Y')."' WHERE id = '".$currentuser['id']."'");
		}
	if(mysql_num_rows($q = mysql_query("SELECT `lock`, end FROM `bans` WHERE (user = '".$currentuser['id']."' || ip = '".mysql_clean($_SERVER['REMOTE_ADDR'])."') && active = '1'"))) {
		$b = mysql_fetch_array($q);
		if($b['lock'] == '1') {
			setcookie('ul', md5('ko'), ($b['end'] == '0' ? time()*100 : $b['end']), '/');
			header('HTTP/1.1 403 Forbidden');
		}
		//setcookie($config['cookie_name'], '', time()+1, '/nada/');
		$currentuser = false;
	}
} else {
	unset($currentuser, $_COOKIE[$config['cookie_name']]);
}

// isLogged -> Comprueba si esta logeado, retorna true o false
function isLogged() {
	global $currentuser;
	if(count($currentuser) > 1) {
		return true;
	} else {
		return false;
	}
}

// ESTADISTICAS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
/*
// getRank -> Obtiene informacion del rango, si $what se deja en blanco o es all, retorna un array con todo, si no, el valor especificado.
// Si $what es permissions, retorna un array con ellos, para comprobar uno en particular, usar isAllowedTo
function getRank($userid, $what = 'all') {
	$rank = mysql_fetch_array(mysql_query("SELECT r.* FROM ranks AS r, usuarios AS u WHERE u.id = '".$userid."' && r.id = u.rank"));
	if($what == 'all') { return $rank; }
	if($what == 'permissions') { return explode(',', $rank['permissions']); }
	return $rank[$what];
}
*/
// isAllowedTo -> Dice si el usuario tiene permisos determinados, retorna true o false
function isAllowedTo($permission, $user = 0) {
	global $currentuser;
	if($user == 0) {
		if(isLogged()) {
			$permissions = $currentuser['rank_array']['permissions_array'];
		} else {
			$permissions = array();
		}
	} else {
		if(!mysql_num_rows($q = mysql_query("SELECT rank FROM `users` WHERE id = '".mysql_clean($user)."'"))) { return false; }
		$u = mysql_fetch_array($q);
		$r = mysql_fetch_array(mysql_query("SELECT permissions FROM `ranks` WHERE id = '".$user['rank']."'"));
		$permissions = explode(',', $r['permissions']);
	}
	return (in_array($permission, $permissions) ? true : false);
}


function rankName($rank) {
	$f = mysql_fetch_array(mysql_query("SELECT name FROM `ranks` WHERE id = '".mysql_clean($rank)."'"));
	return $f['name'];
}

function rankUrl($rank) {
	return str_replace(' ', '-', strtolower($rank));
}

function groupRankName($num) {
	switch($num) {
		case 0:
		return 'Visitante';
		break;
		case 1:
		return 'Comentador';
		break;
		case 2:
		return 'Posteador';
		break;
		case 3:
		return 'Moderador';
		break;
		case 4:
		return 'Administrador';
		break;
	}
}

function isNew($id) {
	global $currentuser;
	$user = mysql_fetch_array(mysql_query("SELECT rank FROM `users` WHERE id = '".$id."'"));
	if($user['rank'] != 0) { return false; }
	$qu = mysql_query("SELECT id FROM `posts` WHERE author = '".$id."'");
	while($fetch = mysql_fetch_array($qu)) {
		$query = mysql_query("SELECT SUM(pnum) AS tp FROM `points` WHERE user_to = '".$id."' && post = '".$fetch['id']."'");
		if(!mysql_num_rows($query)) { continue; }
		$f = mysql_fetch_array($query);
		if($f['tp'] >= 50) {
			list($points) = mysql_fetch_row(mysql_query("SELECT points FROM `ranks` WHERE id = '1'"));
			mysql_query("UPDATE `users` SET rank = '1', points = '".$points."-".date('d/m/Y')."' WHERE id = '".$id."'");
			return true;
		}
	}
	return false;
}
// BBCode -> Muestra el BBCode
function bbcode($text, $special = true) {
	global $currentuser;

	$text = htmlspecialchars($text);

	// GEGEGEGGEEG :D
	$text = preg_replace('/\[url\](.*)\[\/url\]/Usi', '<a href="\\1" rel="nofollow" target="_blank">\\1</a>', $text);
	$text = preg_replace('/\[url=\#([a-z0-9]+)\](.*)\[\/url\]/Usi', '<a href="#\\1">\\2</a>', $text);
	$text = preg_replace('/\[url=(.*)\](.*)\[\/url\]/Usie', '\'<a href="\'.(substr(\'\\1\',0,7)==\'http://\' ? \'\\1\' : \'http://\\1\').\'" rel="nofollow" target="_blank">\\2</a>\'', $text);
	$text = preg_replace('/\[img=(.*)\]/Usi', '<img src="\\1" style="max-width:750px;" />', $text);
	$text = preg_replace('/\[img\](.*)\[\/img\]/Usi', '<img src="\\1" style="max-width:750px;" />', $text);
	$text = preg_replace("#( |^|\\\n)http://([^(\\n) ]+)#ie", '\'\\1<a href="http://\'.trim(\'\\2\').\'" rel="nofollow" target="_blank">http://\'.trim(\'\\2\').\'</a>\'', $text);

    $text = nl2br($text);

	// BBCode basicos
	$text = preg_replace('/\[b\](.*)\[\/b\]/Usi', '<b>\\1</b>', $text);
	$text = preg_replace('/\[i\](.*)\[\/i\]/Usi', '<i>\\1</i>', $text);
	$text = preg_replace('/\[u\](.*)\[\/u\]/Usi', '<u>\\1</u>', $text);
	$text = preg_replace('/\[color=(rgb\([0-9]{1,3},[ ]?[0-9]{1,3},[ ]?[0-9]{1,3}\)|\#[0-9a-f]{3}|\#[0-9a-f]{6})\](.*)\[\/color=(rgb\([0-9]{1,3},[ ]?[0-9]{1,3},[ ]?[0-9]{1,3}\)|\#[0-9a-f]{3}|\#[0-9a-f]{6})\]/Usie', "text_gradient('\\2', '\\1', '\\3');", $text);
	$text = preg_replace('/\[color=(rgb\([0-9]{1,3},[ ]?[0-9]{1,3},[ ]?[0-9]{1,3}\)|\#[0-9a-f]{3}|\#[0-9a-f]{6})\](.*)\[\/color\]/Usi', '<span style="color:\\1">\\2</span>', $text);
	$text = preg_replace('/\[color=([a-z]+)\](.*)\[\/color\]/Usi', '<span style="color:\\1">\\2</span>', $text);
	$text = preg_replace('/\[fondo=(rgb\([0-9]{1,3},[ ]?[0-9]{1,3},[ ]?[0-9]{1,3}\)|\#[0-9a-f]{3}|\#[0-9a-f]{6})\](.*)\[\/fondo=(rgb\([0-9]{1,3},[ ]?[0-9]{1,3},[ ]?[0-9]{1,3}\)|\#[0-9a-f]{3}|\#[0-9a-f]{6})\]/Usi', '<span style="background: -moz-linear-gradient(left, \\1, \\3);">\\2</span>', $text);
	$text = preg_replace('/\[fondo=(rgb\([0-9]{1,3},[ ]?[0-9]{1,3},[ ]?[0-9]{1,3}\)|\#[0-9a-f]{3}|\#[0-9a-f]{6})\](.*)\[\/fondo\]/Usi', '<span style="background: \\1;">\\2</span>', $text);
	$text = preg_replace('/\[size=([0-9]+)\](.*)\[\/size\]/Usi', '<span style="font-size:\\1pt;">\\2</span>', $text);
	$text = preg_replace('/\[font="(.*)"\](.*)\[\/font]/Usi', '[font=\\1]\\2[/font]', $text); // k pereza!
	$text = preg_replace('/\[font=(.*)\](.*)\[\/font]/Usi', '<span style="font-family:\\1;">\\2</span>', $text);
	$text = preg_replace('/\[align=center\](.*)\[\/align]/Usi', '<center>\\1</center>', $text);
	$text = preg_replace('/\[align=left\](.*)\[\/align]/Usi', '<span class="floatL">\\1</span><div class="clearBoth"></div>', $text);
	$text = preg_replace('/\[align=right\](.*)\[\/align]/Usi', '<span class="floatR">\\1</span><div class="clearBoth"></div>', $text);
	
	// BBCode avanzados
	$text = str_replace('[tu]', (isLogged() ? $currentuser['nick'] : 'visitante'), $text);
	$text = preg_replace('/\[a=([a-z0-9]+)\]/Usi', '<a name="\\1"></a>', $text);
	$text = preg_replace('/\[swf=(.*)\]/Usi', '<center><embed src="\\1" quality="high" type="application/x-shockwave-flash" AllowNetworking="internal" AllowScriptAccess="never" wmode="transparent" allowfullscreen="false" width="425" height="350"></embed></center>', $text);
	$text = preg_replace('/\[spoiler=([a-z0-9 ]+)\|([a-z0-9 ]+)\](.*)\[\/spoiler\]/Usi', '<div style="text-align: center;"><input type="button" value="\\1" onclick="this.parentNode.getElementsByTagName(\'div\')[0].style.display = (this.parentNode.getElementsByTagName(\'div\')[0].style.display==\'block\' ? \'none\' : \'block\');this.value=(this.parentNode.getElementsByTagName(\'div\')[0].style.display==\'block\' ? \'\\2\' : \'\\1\');" /><div style="display:none;text-align:left;border:1px solid #000;margin:7px;">\\3</div></div>', $text);
	$text = preg_replace('/\[spoiler\](.*)\[\/spoiler\]/Usi', '<div style="text-align: center;"><input type="button" value="Mostrar" onclick="this.parentNode.getElementsByTagName(\'div\')[0].style.display = (this.parentNode.getElementsByTagName(\'div\')[0].style.display==\'block\' ? \'none\' : \'block\');this.value=(this.parentNode.getElementsByTagName(\'div\')[0].style.display==\'block\' ? \'Ocultar\' : \'Mostrar\');" /><div style="display:none;text-align:left;border:1px solid #000;margin:7px;">\\1</div></div>', $text);
	//$text = preg_replace("/\[quote\](.*)\[\/quote\]/Ais", '<blockquote><div class="cita">Cita</div><div class="citacuerpo"><p>\\1</p></div></blockquote><br /><br />', $text);
	//$text = preg_replace("/\[quote=([a-z0-9]+)\](.*)\[\/quote\]/Ais", '<blockquote><div class="cita"><strong>\\1</strong> dijo:</div><div class="citacuerpo"><p>\\2</p></div></blockquote><br /><br />', $text);

	if(substr_count($text, '[quote') == substr_count($text, '[/quote')) {
		$text = parseAuthorQuotes($text);
		$text = parseQuotes($text);
	}
	
	// Emoticonos
	$emoticonos = array(':)' => 'sonrisa', ';)' => 'guino', ':roll:' => 'duda', ':P' => 'lengua', ':D' => 'alegre', ':(' => 'triste', 'X(' => 'odio', ':cry:' => 'llorando', ':twisted:' => 'endiablado', ':|' => 'serio', ':?' => 'duda2', ':cool:' => 'picaro', '^^' => 'sonrizota', ':oops:' => 'timido', '8|' => 'increible', ':F' => 'babas');
	foreach($emoticonos as $code => $name) {
		$text = str_replace($code, '<img src="/images/space.gif" align="absmiddle" class="emoticono '.$name.'" />', $text);
	}
	// aun mas...
	$emoticonos = glob(str_repeat('../', substr_count($_SERVER['SCRIPT_NAME'], '/')-1).'images/smiles/*.gif');
	foreach($emoticonos as $name) {
		$ex = explode('/', $name);
		$ex = $ex[count($ex)-1];
		$ex = explode('.', $ex);
		$ex = $ex[0];
		$text = str_replace(':'.$ex.':', '<img src="/images/smiles/'.$ex.'.gif" align="absmiddle" />', $text);
	}
	
	$bwp = array('/(http:\/\/|www\.|http:\/\/www\.)?taringa\.net/i');
	$text = preg_replace($bwp, '*****', $text);
	$bw = array('downgrade','Downgraadde','putos','TARINGA','comunidadexcelente','zinfinal','xtremos','spirate','tripiante','taringueros','poringa','ciber-link','tinyurl','downgrad');
	$text = str_ireplace($bw, '*****', $text);
	
	if(substr($text, -25) == '</blockquote><br /><br />') { $text = substr($text, 0, (strlen($text)-12)); }
	return $text;
}

function text_gradient($text, $color1, $color2) {
	$text = htmlspecialchars_decode($text);
	list($r, $g, $b) = rgbcolor($color1);
	list($r2, $g2, $b2) = rgbcolor($color2);
	$len = strlen($text);
	//$pr = round(($r2-$r)/$len);
	//$pg = round(($g2-$g)/$len);
	//$pb = round(($b2-$b)/$len);
	$pr = ($r2-$r)/$len;
	$pg = ($g2-$g)/$len;
	$pb = ($b2-$b)/$len;

	for($i=0;$i<$len;$i++) {
		//echo '<!--'.$r.','.$g.','.$b.'-'.$hex.'-->';
		$return .= '<span style="color:rgb('.ceil($r).','.ceil($g).','.ceil($b).');">'.htmlspecialchars($text{$i}).'</span>';
		$r += $pr;
		$g += $pg;
		$b += $pb;
	}
	return $return;
}

function parseAuthorQuotes($input) {
	$regex = '#\[quote\=[a-z0-9]+]((?:[^[]|\[(?!/?quote.*])|(?R))+)\[/quote]#i';

    if(is_array($input)) {
	$explode = preg_split('/\[quote\=(.*)\]/i', $input[0], -1, PREG_SPLIT_DELIM_CAPTURE);
	$author = explode(']', $explode[count($explode)-2]);
        $input = '<blockquote><div class="cita">Cita de '.$author[0].'</div><div class="citacuerpo"><p>'.$input[1].'</p></div></blockquote><br /><br />';
    }

    return preg_replace_callback($regex, 'parseAuthorQuotes', $input);
}

function parseQuotes($input) {
    $regex = '#\[quote]((?:[^[]|\[(?!/?quote])|(?R))+)\[/quote]#';

    if(is_array($input)) {
        $input = '<blockquote><div class="cita">Cita</div><div class="citacuerpo"><p>'.$input[1].'</p></div></blockquote><br /><br />';
    }

    return preg_replace_callback($regex, 'parseQuotes', $input);
}

// error -> muestra un error, para usarla simplemente ponerla, sin echos o ifs
// Para usar comprobar AL PRINCIPIO del archivo: if(ALGO) { die(error('Error', 'No cumples con la condición ALGO', 'Volver a la página principal', '/')); }
// El código no se ejecutará más, no hace falta else ni nada
// NOTA: EL INSERTBEFORE VA ANTES DEL FOOTER
function error($title, $message, $button_message, $url_error, $mainc = true, $c15 = false) {
	if($c15 === true) { $c15 = ' class="c15"'; }
	if($mainc === true) { echo '<div id="cuerpocontainer"'.$c15.'>'; }
echo '<div class="container400" style="margin: 10px auto 0 auto;">
	<div class="box_title">
		<div class="box_txt show_error">'.$title.'</div>
		<div class="box_rrs"><div class="box_rss"></div></div>
	</div>
	<div class="box_cuerpo"  align="center">
		<br />
		'.$message.'<br />
		<br />
		<br />';
	if(!is_array($button_message)) {
		echo '<input type="button" class="mBtn btnOk" style="font-size:13px" value="'.$button_message.'" title="'.$button_message.'" onclick="document.location = \''.$url_error.'\'">';
	} else {
		$c = count($button_message);
		for($i=0;$i<$c;$i++) {
			echo '<input type="button" class="mBtn btnOk" style="font-size:13px" value="'.$button_message[$i].'" title="'.$button_message[$i].'" onclick="document.location = \''.$url_error[$i].'\'">';
			if($i != ($c-1)) { echo '&nbsp;&nbsp;'; }
		}
	}
	echo '<br />
		
	</div>
	
</div>	
		<br />
		<br />
		<br />
		<br />
	<center>'.advert('728x90').'</center><div style="clear:both"></div>';
	if($mainc === true || $inserBefore === true) { echo '</div>'; }
echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/footer.php');
//die;
}

// mysql_clean -> Limpia la cadena SQL
function mysql_clean($string) {
	if(@get_magic_quotes_gpc()) {
		$string = stripslashes($string);
	}
	return mysql_real_escape_string($string);
}
//function mysql_clean(utf8_encode($string)) { return $string; }

function url($string) {
	$string = str_replace(' ', '-', $string);
	$string = strtr($string, '[]', '()');
	$string = preg_replace('/([^\(\)\-a-z0-9]+)/i', '', $string);
	while(strpos($string, '--') !== false) {
		$string = str_replace('--', '-', $string);
	}
	return trim($string);
}

function numtoabbr($num) {
	$f = mysql_fetch_row(mysql_query("SELECT code FROM `countries` WHERE id = '".mysql_clean($num)."'"));
    return strtolower($f[0]);
}

function numtocname($num) {
	$f = mysql_fetch_row(mysql_query("SELECT name FROM `countries` WHERE id = '".mysql_clean($num)."'"));
    return $f[0];
}

function advert($size, $height = null) {
  if($height != null) {
    $size = $size.'x'.$height;
  }
  return '<!-- BEGIN SMOWTION TAG - '.$size.' - dorantinga: p2p - DO NOT MODIFY -->
<script type="text/javascript"><!--
smowtion_size = "'.$size.'";
smowtion_section = "1208965";
smowtion_iframe = 1;
//-->
</script>
<script type="text/javascript"
src="http://ads.smowtion.com/ad.js">
</script>
<!-- END SMOWTION TAG - '.$size.' - dorantinga: p2p - DO NOT MODIFY -->';
}






function timefrom($time) {
	$ctime = time();
	$dif = $ctime-$time;
	if($dif < 60) { return 'Hace menos de un minuto'; }
	if($dif < 3600) { $t = ceil($dif/60); return 'Hace '.$t.' minuto'.($t == 1 ? '' : 's'); }
	if($dif < 86400) { $t = ceil($dif/3600); return 'Hace '.$t.' hora'.($t == 1 ? '' : 's'); }
	if($dif < 604800) { $t = ceil($dif/86400); return ($t == 1 ? 'Ayer' : 'Hace '.$t.' d&iacute;as'); }
	if($dif < 2419200) { $t = ceil($dif/604800); return ($t == 1 ? 'La semana pasada' : 'Hace '.$t.' semanas'); }
	if($dif < 31104000) { $t = ceil($dif/2592000); return ($t == 1 ? 'El mes pasado' : 'Hace '.$t.' meses'); }
	$t = ceil($dif/31104000);
	return ($t == 1 ? 'El a&ntilde;o pasado' : 'Hace '.$t.' a&ntilde;os');
}

function udate($format, $time = null) {
	global $currentuser;
	if($time == null) { $time = time(); }
	//if(isLogged()) {
		//$dif = $currentuser['difh'];
	//} else {
		if(!$_COOKIE['difh']) {
			$dif = 0;
		} else {
			$dif = (int) $_COOKIE['difh'];
		}
	//}
	return date($format, $time+($dif*3600));
}

// Para RGBs
function rgbcolor($color) {
	if(preg_match('/rgb\([0-9]{1,3},[0-9]{1,3},[0-9]{1,3}\)/i', $color)) {
		$color = substr($color, 4, strlen($color)-1);
		list($r, $g, $b) = explode(',', $color);
	} else {
		$color = substr($color, 1);
		if(strlen($color) == 3) {
			$r = $color{0}.$color{0};
			$g = $color{1}.$color{1};
			$b = $color{2}.$color{2};
		} else {
			$r = substr($color, 0, 2);
			$g = substr($color, 2, 2);
			$b = substr($color, 4, 2);
		}
		$r = hexdec($r);
		$g = hexdec($g);
		$b = hexdec($b);
	}
	return array($r, $g, $b);
}

function getLocation(&$city, &$coords) {
	$c = file_get_contents('http://www.ipaddressapi.com/lookup/'.$_SERVER['REMOTE_ADDR']);
	$ex = explode('<th>City:</th><td>', $c);
	$ex2 = explode('</td>', $ex[1]);
	$city = $ex2[0];
	$ex = explode('<th>Latitude:</th><td>', $c);
	$ex2 = explode('</td>', $ex[1]);
	$coords[0] = $ex2[0];
	$ex = explode('<th>Longitude:</th><td>', $c);
	$ex2 = explode('</td>', $ex[1]);
	$coords[1] = $ex2[0];
}

function getWeather($city, &$weather, $onlyHome = false) {
	$c = @file_get_contents('http://www.google.com/ig/api?weather='.str_replace(' ', '%20', $city).'&hl=es');
	if(!$c || strpos($c, 'problem_cause') !== false) {
		$weather['current']['temp'] = '?';
		$weather['current']['hum'] = '?%';
	}
	//echo htmlspecialchars($c);
	$ex = explode('<temp_c data="', $c);
	$ex1 = explode('"', $ex[1]);
	$weather['current']['temp'] = $ex1[0];
	$ex = explode('<humidity data="', $c);
	$ex1 = explode('"', $ex[1]);
	$ex = explode(' ', $ex1[0]);
	$weather['current']['hum'] = $ex[1];
	$ex = explode('<current_conditions>', $c);
	$ex1 = explode('</current_conditions>', $ex[1]);
	$ex = explode('/ig/images/weather/', $ex1[0]);
	$ex1 = explode('"', $ex[1]);
	$weather['current']['icon'] = $ex1[0];
}
?>