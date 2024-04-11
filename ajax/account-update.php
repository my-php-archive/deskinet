<?php
include('../config.php');
include('../functions.php');
if(!isLogged() || !$_GET['sa']) { die('ERROR PROVOCADO POR EL USUARIO'); }
if($_GET['sa'] == 'ec') {
	if(!$_GET['name'] || strlen($_GET['name']) < 6 || strlen($_GET['name']) > 32 || !eregi('^[a-z0-9]+$', str_replace(' ', '', $_GET['name']))) { die('El nombre no es v&aacute;lido'); }
	if(!$_GET['email'] || strlen($_GET['email']) > 35 || !eregi('^[a-z0-9_\.\-]{1,64}@[a-z0-9_\.\-]{1,255}\.([a-z]{2,3})+$', $_GET['email'])) { die('El EMail no es v&aacute;lido'); }
	if(!eregi('^[0-9]+$', $_GET['country']) || $_GET['country'] == 28 || $_GET['country'] == -1 || $_GET['country'] > 262) { die('El pa&iacute;s no es v&aacute;lido'); }
	if(!$_GET['city'] || strlen($_GET['city']) > 32) { die('La ciudad no es v&aacute;lida'); }
	if(!$_GET['gender'] || ($_GET['gender'] != 'm' && $_GET['gender'] != 'f')) { die('El sexo no es v&aacute;lido'); }
	$_GET['birth_day'] = (int) $_GET['birth_day'];
	$_GET['birth_month'] = (int) $_GET['birth_month'];
	$_GET['birth_year'] = (int) $_GET['birth_year'];
	if((($_GET['birth_month'] == 2 && $_GET['birth_day'] > 29) || (($_GET['birth_month']%2) == 0 && $_GET['birth_day'] > 30) || (($_GET['birth_month']%2) != '0' && $_GET['birth_day'] > 31)) || $_GET['birth_month'] > 12 || $_GET['birth_year'] > date('Y')) { die('La fecha de nacimiento no es v&aacute;lida'); }
	if($_GET['birth_year'] > (date('Y')-$config['min_age'])) { die('Necesitas tener al menos '.$config['min_age'].' a&ntilde;os'); }
	if(strlen($_GET['website']) > 60) { die('El sitio web no puede sobrepasar los 60 caracteres'); }
	if(strlen($_GET['messenger']) > 64) { die('El mensajero no puede sobrepasar los 64 caracteres'); }
	
	$_GET['messenger_type'] = strtolower($_GET['messenger_type']);
	if(!$_GET['messenger_type'] || ($_GET['messenger_type'] != 'msn' && $_GET['messenger_type'] != 'gtalk' && $_GET['messenger_type'] != 'icq' && $_GET['messenger_type'] != 'aim')) { $_GET['messenger_type'] = 'msn'; }
	
	if($_GET['name_show'] == 'amigos') {
		$_GET['name_show'] = '1';
	} elseif($_GET['name_show'] == 'registrados') {
		$_GET['name_show'] = '2';
	} elseif($_GET['name_show'] == 'todos') {
		$_GET['name_show'] = '3';
	} else {
		$_GET['name_show'] = '0';
	}
	if($_GET['email_show'] == 'amigos') {
		$_GET['email_show'] = '1';
	} elseif($_GET['email_show'] == 'registrados') {
		$_GET['email_show'] = '2';
	} elseif($_GET['email_show'] == 'todos') {
		$_GET['email_show'] = '3';
	} else {
		$_GET['email_show'] = '0';
	}
	if($_GET['birth_show'] == 'amigos') {
		$_GET['email_show'] = '1';
	} elseif($_GET['birth_show'] == 'registrados') {
		$_GET['birth_show'] = '2';
	} elseif($_GET['birth_show'] == 'todos') {
		$_GET['birth_show'] = '3';
	} else {
		$_GET['birth_show'] = '0';
	}
	if($_GET['messenger_show'] == 'amigos') {
		$_GET['messenger_show'] = '1';
	} elseif($_GET['messenger_show'] == 'registrados') {
		$_GET['messenger_show'] = '2';
	} elseif($_GET['messenger_show'] == 'todos') {
		$_GET['messenger_show'] = '3';
	} else {
		$_GET['messenger_show'] = '0';
	}
	if(!@mysql_query("UPDATE `users` SET name = '".mysql_clean($_GET['name'])."', email = '".mysql_clean($_GET['email'])."', country = '".mysql_clean($_GET['country'])."', city = '".mysql_clean($_GET['city'])."', gender = '".($_GET['gender'] == 'm' ? '1' : '2')."', birth_day = '".(strlen($_GET['birth_day']) == 1 ? '0'.$_GET['birth_day'] : $_GET['birth_day'])."', birth_month = '".(strlen($_GET['birth_month']) == 1 ? '0'.$_GET['birth_month'] : $_GET['birth_month'])."', birth_year = '".(strlen($_GET['birth_year']) == 1 ? '0'.$_GET['birth_year'] : $_GET['birth_year'])."', website = '".mysql_clean($_GET['website'])."', messenger = '".mysql_clean($_GET['messenger'])."', messenger_type = '".$_GET['messenger_type']."', name_show = '".$_GET['name_show']."', email_show = '".$_GET['email_show']."', birth_show = '".$_GET['birth_show']."', messenger_show = '".$_GET['messenger_show']."' WHERE id = '".$currentuser['id']."'")) { die('Ocurri&oacute; un error inesperado'); }
	die('1');			
} elseif($_GET['sa'] == 'cp') { // $sa
	if(!$_GET['cp'] || strlen($_GET['cp']) < 6 || strlen($_GET['cp']) > 32 || !eregi('^[a-z0-9]+$', $_GET['np'])) { die('La contrase&ntilde;a actual no es v&aacute;lida'); }
	if(md5($_GET['cp']) != $currentuser['password']) { die('La contrase&ntilde;a actual no es correcta'); }
	if(!$_GET['np'] || strlen($_GET['np']) < 6 || strlen($_GET['np']) > 32 || !eregi('^[a-z0-9]+$', $_GET['np'])) { die('La nueva contrase&ntilde;a no es v&aacute;lida'); }
	mysql_query("UPDATE `users` SET password = '".md5($_GET['np'])."' WHERE id = '".$currentuser['id']."'");
	setcookie($config['cookie_name'], $currentuser['id'].'-'.md5($_GET['np']), 0, '/');
	die('1');
} elseif($_GET['sa'] == 'cpt') {
	if(!$_GET['pt'] || strlen($_GET['pt']) > 64) { die('Introduce un mensaje personal con menos de 64 caracteres'); }
	mysql_query("UPDATE `users` SET personal_text = '".mysql_clean($_GET['pt'])."' WHERE id = '".$currentuser['id']."'");
	die('1');
} elseif($_GET['sa'] == 'up') {
	if(!$_GET['ct'] || ($_GET['ct'] != 1 && $_GET['ct'] != 2)) { $ct = 1; } else { $ct = $_GET['ct']; }
	//$ct = 1; // TEMPORAL....
	unset($_GET['rnd'], $_GET['sa'], $_GET['ct']);
	if($ct == 2 && ini_get('allow_url_fopen') != 1 || !function_exists('get_headers')) { $ct = 1; }
	foreach($_GET as $photo) {
		if($ct == 1) {
			if(!eregi('[.gif|.png|.jpg|.jpeg|.bmp|.ico|.psd]$', $photo)) { die('Alguna foto no tiene extensi&oacute;n permitida ('.$photo.')'); }
		} else {
			if(!$headers = @get_headers($photo, 1)) { die('Alg&uacute;n dominio de las fotos no existe ('.$photo.')'); }
			if(ereg('404', $headers[0])) { die('Alguna foto no existe ('.$photo.')'); }
			//if(!ereg('200', $headers[0])) { die('Alguna foto no se pudo abrir, reintentalo m&aacute;s tarde ('.$photo.')'); }
			if(substr($headers['Content-Type'], 0, 5) != 'image' || is_array($headers['Content-type'])) { die('&iexcl;Esto no es una imagen! ('.$photo.')'); }
		}
	}
	if(!@mysql_query("UPDATE `users` SET images = '".mysql_clean(implode('*@', $_GET))."' WHERE id = '".$currentuser['id']."'")) { die('Ocurri&oacute; un error inesperado'); }
	die('1');
} elseif($_GET['sa'] == 'av') {
	if(!$_GET['av']) { die('No has enviado una URL para el avatar'); }
	if(strlen($_GET['av']) > 255) { die('La URL del avatar no puede sobrepasar los 255 caracteres'); }
	if(!@mysql_query("UPDATE `users` SET avatar = '".mysql_clean($_GET['av'])."' WHERE id = '".$currentuser['id']."'")) { die('Ocurri&oacute; un error inesperado'); }
	die('1');
} elseif($_GET['sa'] == 'op') {
	switch($_GET['me']) {
		case 'nadie':
			$me = '0';
			break;
		case 'amigos':
			$me = '1';
			break;
		case 'registrados':
			$me = '2';
			break;
		case 'todos':
			$me = '3';
			break;
		default:
			$me = '3';
			break;
	}
	$ss = ($_GET['ss'] == 'true' ? '1' : '0');
	$nw = ($_GET['nw'] == 'true' ? '1' : '0');
	$np = ($_GET['np'] == 'true' ? '1' : '0');
	mysql_query("UPDATE `users` SET show_status = '".$me."', show_search = '".$ss."', newsletter = '".$nw."', newsletter_offers = '".$np."' WHERE id = '".$currentuser['id']."'");
	die('1');
} elseif($_GET['sa'] == 'am') {
	$mf = ($_GET['mf'] == 'true' ? '1' : '0');
	$mi = ($_GET['mi'] == 'true' ? '1' : '0');
	$mb = ($_GET['mb'] == 'true' ? '1' : '0');
	$fm = ($_GET['fm'] == 'true' ? '1' : '0');
	$fa = ($_GET['fa'] == 'true' ? '1' : '0');
	
	switch($_GET['ls']) {
		case 'sr': $ls = '0'; break;
		case 'soltero': $ls = '1'; break;
		case 'novio': $ls = '2'; break;
		case 'casado': $ls = '3'; break;
		case 'divorciado': $ls = '4'; break;
		case 'viudo': $ls = '5'; break;
		case 'algo': $ls = '6'; break;
		default: $ls = '0'; break;
	}
	switch($_GET['ch']) {
		case 'sr': $ch = '0'; break;
		case 'no': $ch = '1'; break;
		case 'algun_dia': $ch = '2'; break;
		case 'no_quiero': $ch = '3'; break;
		case 'viven_conmigo': $ch = '4'; break;
		case 'no_viven_conmigo': $ch = '5'; break;
		default: $ch = '0'; break;
	}
	switch($_GET['lw']) {
		case 'sr': $lw = '0'; break;
		case 'solo': $lw = '1'; break;
		case 'padres': $lw = '2'; break;
		case 'pareja': $lw = '3'; break;
		case 'amigos': $lw = '4'; break;
		case 'otro': $lw = '5'; break;
		default: $lw = '0'; break;
	}
	
	switch($_GET['ms']) {
		case 'nadie': $ms = '0'; break;
		case 'amigos': $ms = '1'; break;
		case 'registrados': $ms = '2'; break;
		case 'todos': $ms = '3'; break;
		default: $ms = '3'; break;
	}
	switch($_GET['lm']) {
		case 'nadie': $lm = '0'; break;
		case 'amigos': $lm = '1'; break;
		case 'registrados': $lm = '2'; break;
		case 'todos': $lm = '3'; break;
		default: $lm = '3'; break;
	}
	switch($_GET['cs']) {
		case 'nadie': $cs = '0'; break;
		case 'amigos': $cs = '1'; break;
		case 'registrados': $cs = '2'; break;
		case 'todos': $cs = '3'; break;
		default: $cs = '3'; break;
	}
	switch($_GET['wl']) {
		case 'nadie': $wl = '0'; break;
		case 'amigos': $wl = '1'; break;
		case 'registrados': $wl = '2'; break;
		case 'todos': $wl = '3'; break;
		default: $wl = '3'; break;
	}
	if(!@mysql_query("UPDATE `users` SET make_friends = '".$mf."', meet_interests = '".$mi."', meet_business = '".$mb."', find_mate = '".$fm."', find_all = '".$fa."', love_state = '".$ls."', children = '".$ch."', live_with = '".$lw."', meet_show = '".$ms."', love_show = '".$lm."', children_show = '".$cs."', live_show = '".$wl."' WHERE id = '".$currentuser['id']."'")) { die('Ocurri&oacute; un error inesperado'); }
	die('1');
} elseif($_GET['sa'] == 'in') {
	foreach($_GET as $key => $value) {
		if(strlen($key) != 3) {
			$$key = mysql_clean($value);
		} else {
			switch($value) {
				case 'nadie': $$key = '0'; break;
				case 'amigos': $$key = '1'; break;
				case 'registrados': $$key = '2'; break;
				case 'todos': $$key = '3'; break;
				default: $$key = '3'; break;
			}
		}
	}
	if(!@mysql_query("UPDATE `users` SET my_interests = '".$mi."', my_hobbies = '".$ho."', tv_shows = '".$ts."', favorite_music = '".$fm."', favorite_sports = '".$fs."', favorite_books = '".$fb."', favorite_films = '".$ff."', favorite_food = '".$fo."', my_heros = '".$mh."', my_interests_show = '".$mis."', my_hobbies_show = '".$hos."', tv_shows_show = '".$tss."', favorite_music_show = '".$fms."', favorite_sports_show = '".$fss."', favorite_books_show = '".$fbs."', favorite_films_show = '".$fms."', favorite_food_show = '".$ffs."', my_heros_show = '".$mhs."' WHERE id = '".$currentuser['id']."'")) {
		die('Ocurri&oacute; un error inesperado');
	}
	die('1');
} elseif($_GET['sa'] == 'kn') {
	foreach($_GET as $key => $value) {
		if($key == 'se') {
			if(!ereg('^[0-9]+$', $value) || (int) $value < 0 || (int) $value > 61) { $sector = '0'; }
		} elseif($key == 'income') {
			switch($value) {
				case 'sr': $income = '0'; break;
				case 'sin': $income = '1'; break;
				case 'bajos': $income = '2'; break;
				case 'intermedios': $income = '3'; break;
				case 'altos': $income = '4'; break;
				default: $income = '0'; break;
			}
		} elseif(substr($key, 0, 8) == 'language') {
			$kn = 'lang_'.substr($key, 9, 2);
			switch($value) {
				case 'sr': $$kn = '0'; break;
				case 'basico': $$kn = '1'; break;
				case 'intermedio': $$kn = '2'; break;
				case 'fluido': $$kn = '3'; break;
				case 'nativo': $$kn = '4'; break;
				default: $$kn = '0'; break;
			}
		} elseif(strlen($key) == 3) {
			switch($value) {
				case 'nadie': $$key = '0'; break;
				case 'amigos': $$key = '1'; break;
				case 'registrados': $$key = '2'; break;
				case 'todos': $$key = '3'; break;
				default: $$key = '3'; break;
			}
		} else {
			$$key = mysql_clean($value);
		}
	}
	if(!isset($wi)) { $wi = ''; }
	if(!isset($ws)) { $ws = ''; }
	if(!@mysql_query("UPDATE `users` SET studies = '".$st."', language_spanish = '".$lang_sp."', language_english = '".$lang_en."', language_portuguese = '".$lang_po."', language_french = '".$lang_fr."', language_italian = '".$lang_it."', language_german = '".$lang_ge."', language_other = '".$lang_ot."', work = '".$wo."', company = '".$co."', work_sector = '".$sector."', income = '".$income."', work_interests = '".$wi."', work_skills = '".$ws."', studies_show = '".$sts."', languages_show = '".$las."', work_show = '".$wos."', company_show = '".$cos."', work_sector_show = '".$ses."', income_show = '".$ins."', work_skills_show = '".$wss."', work_interests_show = '".$wis."' WHERE id = '".$currentuser['id']."'")) { die('Ocurri&oacute; un error inesperado'); }
	die('1');
} elseif($_GET['sa'] == 'as') {
	if(!$_GET['he'] || !ereg('^[0-9]+$', $_GET['he']) || strlen($_GET['he']) > 3) { $he = ''; } else { $he = mysql_clean($_GET['he']); }
	if(!$_GET['we'] || !ereg('^[0-9]+$', $_GET['we']) || strlen($_GET['we']) > 3) { $we = ''; } else { $we = mysql_clean($_GET['we']); }
	switch($_GET['hc']) {
		case 'sr': $hc = '0'; break;
		case 'negro': $hc = '1'; break;
		case 'castano_oscuro': $hc = '2'; break;
		case 'castano_claro': $hc = '3'; break;
		case 'rubio': $hc = '4'; break;
		case 'pelirrojo': $hc = '5'; break;
		case 'gris': $hc = '6'; break;
		case 'canoso': $hc = '7'; break;
		case 'tenido': $hc = '8'; break;
		case 'rapado': $hc = '9'; break;
		case 'calvo': $hc = '10'; break;
		default: $hc = '0'; break;
	}
	switch($_GET['ec']) {
		case 'sr': $ec = '0'; break;
		case 'negros': $ec = '1'; break;
		case 'marrones': $ec = '2'; break;
		case 'celestes': $ec = '3'; break;
		case 'verdes': $ec = '4'; break;
		case 'grises': $ec = '5'; break;
		default: $ec = '0'; break;
	}
	switch($_GET['co']) {
		case 'sr': $co = '0'; break;
		case 'delgado': $co = '1'; break;
		case 'atletico': $co = '2'; break;
		case 'normal': $co = '3'; break;
		case 'kilos_de_mas': $co = '4'; break;
		case 'corpulento': $co = '5'; break;
		default: $co = '0'; break;
	}
	switch($_GET['di']) {
		case 'sr': $di = '0'; break;
		case 'vegetariana': $di = '1'; break;
		case 'lacto_vegetariana': $di = '2'; break;
		case 'organica': $di = '3'; break;
		case 'de_todo': $di = '4'; break;
		case 'comida_basura': $di = '5'; break;
		default: $di = '0'; break;
	}
	if($_GET['ta'] == 'true') { $ta = '1'; } else { $ta = '0'; }
	if($_GET['pi'] == 'true') { $pi = '1'; } else { $pi = '0'; }
	switch($_GET['sm']) {
		case 'sr': $sm = '0'; break;
		case 'no': $sm = '1'; break;
		case 'casualmente': $sm = '2'; break;
		case 'socialmente': $sm = '3'; break;
		case 'regularmente': $sm = '4'; break;
		case 'mucho': $sm = '5'; break;
		default: $sm = '0'; break;
	}
	switch($_GET['dr']) {
		case 'sr': $dr = '0'; break;
		case 'no': $dr = '1'; break;
		case 'casualmente': $dr = '2'; break;
		case 'socialmente': $dr = '3'; break;
		case 'regularmente': $dr = '4'; break;
		case 'mucho': $dr = '5'; break;
		default: $dr = '0'; break;
	}
	foreach($_GET as $key => $value) {
		if(strlen($key) != 3) { continue; }
		switch($value) {
			case 'nadie': $$key = '0'; break;
			case 'amigos': $$key = '1'; break;
			case 'registrados': $$key = '2'; break;
			case 'todos': $$key = '3'; break;
			default: $$key = '3'; break;
		}
	}
	if(!@mysql_query("UPDATE `users` SET height = '".$he."', weight = '".$we."', hair_color = '".$hc."', eyes_color = '".$ec."', constitution = '".$co."', diet = '".$di."', tattos = '".$ta."', piercings = '".$pi."', smoke = '".$sm."', drink = '".$dr."', height_show = '".$hes."', weight_show = '".$wes."', hair_color_show = '".$hcs."', eyes_color_show = '".$ecs."', constitution_show = '".$cos."', diet_show = '".$dis."', tattos_piercings_show = '".$tps."', smoke_show = '".$sms."', drink_show = '".$drs."' WHERE id = '".$currentuser['id']."'")) { die('Ocurri&oacute; un error inesperado'); }
	die('1');
} else { die('ERROR DE USUARIO'); } // $sa
?>