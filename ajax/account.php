<?php
include('../config.php');
include('../functions.php');
function jerror($e,$f=false){die('{"error":"'.$e.'"'.($f ? ',"field":"'.$f.'"' : '').'}');}
function check($v,$i,$e=0){if($e==0){$e=$i;$i=0;}return $v >= $i && $v <= $e;}
if(!isLogged()) { jerror('Debes logearte'); }
if(!$_POST['save']) { jerror('Faltan datos'); }   //jerror(str_replace('"','\"',print_r($_POST, true)));
$array = array('nombre' => 'name', 'email' => 'email', 'pais' => 'country', 'provincia' => 'province', 'ciudad' => 'city', 'ciudadt' => 'city_text', 'sexo' => 'gender', 'dia' => 'birth_day', 'mes' => 'birth_month', 'ano' => 'birth_year', 'mensaje' => 'personal_text', 'sitio' => 'website', 'im_tipo' => 'messenger_type', 'im' => 'messenger', 'me_gustaria_amigos' => 'make_friends', 'me_gustaria_conocer_gente' => 'meet_interests', 'me_gustaria_conocer_gente_negocios' => 'meet_business', 'me_gustaria_encontrar_pareja' => 'find_mate', 'me_gustaria_de_todo' => 'find_all', 'estado' => 'love_state', 'hijos' => 'children', 'vivo' => 'live_with', 'altura' => 'height', 'peso' => 'weight', 'pelo_color' => 'hair_color', 'ojos_color' => 'eyes_color', 'fisico' => 'constitution', 'dieta' => 'diet', 'tengo_tatuajes' => 'tattos', 'tengo_piercings' => 'piercings', 'fumo' => 'smoke', 'tomo_alcohol' => 'drink', 'estudios' => 'studies', 'idioma_castellano' => 'language_spanish', 'idioma_ingles' => 'language_english', 'idioma_portugues' => 'language_portuguese', 'idioma_frances' => 'language_french', 'idioma_italiano' => 'language_italian', 'idioma_aleman' => 'language_german', 'idioma_otro' => 'language_other', 'profesion' => 'work', 'empresa' => 'company', 'sector' => 'work_sector', 'ingresos' => 'income', 'intereses_profesionales' => 'work_interests', 'habilidades_profesionales' => 'work_skills', 'mis_intereses' => 'my_interests', 'hobbies' => 'my_hobbies', 'series_tv_favoritas' => 'tv_shows', 'musica_favorita' => 'favorite_music', 'deportes_y_equipos_favoritos' => 'favorite_sports', 'libros_favoritos' => 'favorite_books', 'peliculas_favoritas' => 'favorite_films', 'comida_favorita' => 'favorite_food', 'mis_heroes_son' => 'my_heros', 'mostrar_estado' => 'show_status', 'participar_busquedas' => 'show_search', 'recibir_boletin' => 'newsletter', 'autoseguir' => 'autofollow', 'name_mostrar' => 'name_show', 'email_mostrar' => 'email_show', 'birth_mostrar' => 'birth_show', 'messenger_mostrar' => 'messenger_show', 'meet_mostrar' => 'meet_show', 'love_mostrar' => 'love_show', 'children_mostrar' => 'children_show', 'live_mostrar' => 'live_show', 'height_mostrar' => 'height_show', 'weight_mostrar' => 'weight_show', 'hair_color_mostrar' => 'hair_color_show', 'eyes_color_mostrar' => 'eyes_color_show', 'constitution_mostrar' => 'constitution_show', 'diet_mostrar' => 'diet_show', 'tattos_piercings_mostrar' => 'tattos_piercings_show', 'smoke_mostrar' => 'smoke_show', 'drink_mostrar' => 'drink_show', 'studies_mostrar' => 'studies_show', 'languages_mostrar' => 'languages_show', 'work_mostrar' => 'work_show', 'company_mostrar' => 'company_show', 'work_sector_mostrar' => 'work_sector_show', 'income_mostrar' => 'income_show', 'work_interests_mostrar' => 'work_interests_show', 'work_skills_mostrar' => 'work_skills_show', 'my_interests_mostrar' => 'my_interests_show', 'my_hobbies_mostrar' => 'my_hobbies_show', 'favorite_music_mostrar' => 'favorite_music_show', 'favorite_sports_mostrar' => 'favorite_sports_show', 'favorite_books_mostrar' => 'favorite_books_show', 'favorite_food_mostrar' => 'favorite_food_show', 'favorite_films_mostrar' => 'favorite_films_show', 'my_heros_mostrar' => 'my_heros_show');
$req = array('1' => array('nombre', 'email', 'pais', 'provincia', 'sexo', 'dia', 'mes', 'ano', 'sexo'), '2' => array('mensaje', 'sitio', 'im_tipo', 'im', 'estado', 'hijos', 'vivo'), '3' => array('altura', 'peso', 'pelo_color', 'ojos_color', 'fisico', 'dieta', 'fumo', 'tomo_alcohol'), '4' => array('estudios', 'idioma_castellano', 'idioma_ingles', 'idioma_italiano', 'idioma_frances', 'idioma_aleman', 'idioma_otro', 'idioma_portugues', 'idioma_otro', 'profesion', 'empresa', 'sector', 'ingresos', 'intereses_profesionales', 'habilidades_profesionales'), '5' => array('mis_intereses', 'hobbies', 'series_tv_favoritas', 'musica_favorita', 'deportes_y_equipos_favoritos', 'libros_favoritos', 'comida_favorita', 'peliculas_favoritas', 'mis_heroes_son'), '8' => array('name_mostrar', 'email_mostrar', 'birth_mostrar', 'messenger_mostrar', 'meet_mostrar', 'love_mostrar', 'children_mostrar', 'live_mostrar', 'height_mostrar', 'weight_mostrar', 'hair_color_mostrar', 'eyes_color_mostrar', 'constitution_mostrar', 'diet_mostrar', 'tattos_piercings_mostrar', 'smoke_mostrar', 'drink_mostrar', 'studies_mostrar', 'languages_mostrar', 'work_mostrar', 'company_mostrar', 'work_sector_mostrar', 'income_mostrar', 'work_interests_mostrar', 'work_skills_mostrar', 'my_interests_mostrar', 'my_hobbies_mostrar', 'favorite_music_mostrar', 'favorite_sports_mostrar', 'favorite_books_mostrar', 'favorite_food_mostrar', 'favorite_films_mostrar', 'my_heros_mostrar'), '9' => array('passwd', 'new_passwd', 'confirm_passwd'));
if($req[$_POST['save']]) {
    foreach($req[$_POST['save']] as $r) {
        if($_POST['save'] == '1' || $_POST['save'] == '9') {
            if(!$_POST[$r]) {
                jerror('Completa todos los campos', $r);
            }
        } else {
            if(!isset($_POST[$r])) {
                jerror('Completa todos los campos', $r);
            }
        }
    }
}

switch($_POST['save']) {
  default: jerror('Acci&oacute;n desconocida'); break;
  case '1':
    if(!preg_match('/^[a-z ]+$/i', strtr($_POST['nombre'], 'áéíóúñÁÉÍÓÚÑäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ', 'aeiounAEIOUNaeiouAEIOUaeiouAEIOU'))) { jerror('Tu nombre solo debe contener letras y espacios', 'nombre'); }
    if(!preg_match('/^[a-z0-9_\.\-]{1,64}@[a-z0-9_\.\-]{1,255}\.([a-z]{2,3})+$/i', $_POST['email']) || strlen($_POST['email']) > 35) { jerror('El email no es v&aacute;lido', 'email'); }
    if(!mysql_num_rows(mysql_query("SELECT id FROM `countries` WHERE id = '".mysql_clean($_POST['pais'])."'"))) { jerror('El pais no es v&aacute;lido', 'pais'); }
    if(!mysql_num_rows(mysql_query("SELECT id FROM `provinces` WHERE id = '".mysql_clean($_POST['provincia'])."' && country = '".mysql_clean($_POST['pais'])."'"))) { jerror('La provincia no es v&aacute;lida', 'provincia'); }
    if($_POST['ciudad']) {
        if(!mysql_num_rows($q=mysql_query("SELECT name FROM `cities` WHERE id = '".mysql_clean($_POST['ciudad'])."' && province = '".mysql_clean($_POST['provincia'])."'"))) { jerror('La ciudad no es v&aacute;lida', 'ciudad'); }
        $f = mysql_fetch_row($q);
        $_POST['ciudadt'] = $f[0];
    } else {
        if(!mysql_num_rows(mysql_query("SELECT id FROM `cities` WHERE province = '".mysql_clean($_POST['provincia'])."'"))) {
          $_POST['ciudad'] = '0';
          $_POST['ciudadt'] = 'Indefinido';
        } else {
          jerror('Elige una ciudad', 'ciudad');
        }
    }
    if($_POST['sexo'] != 'm' && $_POST['sexo'] != 'f') { jerror('... &iquest;No tienes sexo?', 'sexo'); }
    if(!checkdate($_POST['mes'], $_POST['dia'], $_POST['ano'])) { jerror('Escribe una fecha de nacimiento v&aacute;lida', 'dia'); }
    $_POST['sexo'] = ($_POST['sexo'] == 'm' ? '1' : '2');
  break;
  case '2':
  case '2':
    if($_POST['im_tipo'] != 'msn' && $_POST['im_tipo'] != 'gtalk' && $_POST['im_tipo'] != 'aim' && $_POST['im_tipo'] != 'icq' && $_POST['im_tipo'] != 'twitter') { jerror('Elige un tipo de mensajero v&aacute;lido', 'im_tipo'); }
    if(!check($_POST['estado'], 6)) { jerror('Elige un estado v&aacute;lido', 'estado'); }
    if(!check($_POST['hijos'], 5)) { jerror('Elige una opci&oacute;n v&aacute;lida' , 'hijos'); }
    if(!check($_POST['vivo'], 5)) { jerror('Elige una opci&oacute;n v&aacute;lida', 'vivo'); }
    if(substr($_POST['sitio'], 0, 7) != 'http://') { $_POST['sitio'] = 'http://'.$_POST['sitio']; }
    if($_POST['sitio'] == 'http://') { $_POST['sitio'] = ''; }
  break;
  case '3':
    if(!check($_POST['pelo_color'], 10)) { jerror('Elige un color de pelo v&aacute;lido', 'pelo_color'); }
    if(!check($_POST['ojos_color'], 5)) { jerror('Elige un color de ojos v&aacute;lido', 'ojos_color'); }
    if(!check($_POST['fisico'], 5)) { jerror('Elige un tipo de f&iacute;sico v&aacute;lido', 'fisico'); }
    if(!check($_POST['dieta'], 5)) { jerror('Elige un tipo de dieta v&aacute;lido', 'dieta'); }
    if(!check($_POST['tomo_alcohol'], 5)) { jerror('Elige una opci&oacute;n v&aacute;lida', 'tomo_alcohol'); }
  break;
  case '4':
    if(!check($_POST['estudios'], 10)) { jerror('Elige un nivel de estudios v&aacute;lido', 'estudios'); }
    if(!check($_POST['idioma_castellano'], 5)) { jerror('Elige un nivel de conocimiento del idioma v&aacute;lido', 'idioma_castellano'); }
    if(!check($_POST['idioma_ingles'], 5)) { jerror('Elige un nivel de conocimiento del idioma v&aacute;lido', 'idioma_ingles'); }
    if(!check($_POST['idioma_portugues'], 5)) { jerror('Elige un nivel de conocimiento del idioma v&aacute;lido', 'idioma_portugues'); }
    if(!check($_POST['idioma_frances'], 5)) { jerror('Elige un nivel de conocimiento del idioma v&aacute;lido', 'idioma_frances'); }
    if(!check($_POST['idioma_italiano'], 5)) { jerror('Elige un nivel de conocimiento del idioma v&aacute;lido', 'idioma_italiano'); }
    if(!check($_POST['idioma_aleman'], 5)) { jerror('Elige un nivel de conocimiento del idioma v&aacute;lido', 'idioma_aleman'); }
    if(!check($_POST['idioma_otro'], 5)) { jerror('Elige un nivel de conocimiento del idioma v&aacute;lido', 'idioma_otro'); }
    if(!check($_POST['sector'], 1, 61)) { jerror('Elige un sector v&aacute;lido', 'sector'); }
    if(!check($_POST['ingresos'], 4)) { jerror('Elige un nivel de ingresos v&aacute;lido', 'ingresos'); }
  break;
  case '7':
    if(!$_POST['action'] || ($_POST['action'] != 'add' && $_POST['action'] != 'del')) { jerror('Acci&oacute;n desconocida'); }
    if($_POST['action'] == 'add') {
      if(!$_POST['url']) { jerror('Escribe la direcci&oacute;n de la imagen'); }
      if(!isset($_POST['caption'])) { jerror('Falta la descripci&oacute;n'); }
      mysql_query("INSERT INTO `photos` (url, `desc`, user, time) VALUES ('".(substr($_POST['url'], 0, 7) != 'http://' ? 'http://' : '').mysql_clean($_POST['url'])."', '".mysql_clean(trim($_POST['caption']))."', '".$currentuser['id']."', '".time()."')") or jerror(mysql_error());
      die('{"id":"'.mysql_insert_id().'"}');
    } else {
      if(!$_POST['id']) { jerror('Faltan datos'); }
      if(!mysql_num_rows($q=mysql_query("SELECT user FROM `photos` WHERE id = '".mysql_clean($_POST['id'])."'"))) { jerror('No existe la imagen'); }
      $i = mysql_fetch_row($q);
      if($q[0] == $currentuser['id']) { jerror('La imagen no es tuya'); }
      mysql_query("DELETE FROM `photos` WHERE id = '".mysql_clean($_POST['id'])."'");
      die('{"ok":"ok"}');
    }
  break;
  case '8':
    $shows = array('name', 'email', 'birth', 'messenger', 'meet', 'love', 'children', 'live', 'height', 'weight', 'hair_color', 'eyes_color', 'constitution', 'diet', 'tattos_piercings', 'smoke', 'drink', 'studies', 'languages', 'work', 'company', 'work_sector', 'income', 'work_interests', 'work_skills', 'my_interests', 'my_hobbies', 'favorite_music', 'favorite_sports', 'favorite_books', 'favorite_food', 'favorite_films', 'my_heros');
    foreach($shows as $s) {
      if(!check($_POST[$s.'_mostrar'], 3)) { jerror('Falta alguna opci&oacute;n', $s.'_mostrar'); }
    }
  break;
  case '9':
    if(md5($_POST['passwd']) != $currentuser['password']) { jerror('La contrase&ntilde;a no es correcta', 'passwd'); }
    if($_POST['new_passwd'] != $_POST['confirm_passwd']) { jerror('Las contrase&ntilde;as no coinciden', 'new_passwd'); }
    if(strlen($_POST['new_passwd']) < 6 || strlen($_POST['new_passwd']) > 15) { jerror('La contrase&ntilde;a debe tener entre 6 y 15 caracteres', 'new_passwd'); }
    mysql_query("UPDATE `users` SET password = '".md5($_POST['new_passwd'])."' WHERE id = '".$currentuser['id']."'");
    setcookie($config['cookie_name'], $currentuser['id'].'-'.md5($_POST['new_passwd']), 0, '/');
    die('{"porc":"'.round($currentuser['percent']).'"}');
  break;
  case '5':
  case '6':
  case '10':
  break;
}
 $update = '';
$fc = array('2' => array('me_gustaria_amigos', 'me_gustaria_conocer_gente', 'me_gustaria_conocer_gente_negocios', 'me_gustaria_encontrar_pareja', 'me_gustaria_de_todo'), '3' => array('tengo_tatuajes', 'tengo_piercings'), '6' => array('mostrar_estado', 'participar_busquedas', 'recibir_boletin', 'autoseguir'));
if($fc[$_POST['save']]) {
    foreach($fc[$_POST['save']] as $k) {
      $update .= ", ".$array[$k]." = '".($_POST[$k] ? '1' : '0')."'";
      unset($_POST[$k]);
    }
}
unset($_POST['save']);
foreach($_POST as $key => $val) {
  if(!isset($array[$key])) { continue; }
  $update .= ", ".$array[$key]." = '".mysql_clean(trim($val))."'";
}
$update = substr($update, 2);
//jerror(str_replace('"','\"',$update.'+'));
mysql_query("UPDATE `users` SET ".$update." WHERE id = '".$currentuser['id']."'");

$val = 2.5;
$percent = 0;
$vals = array('name', 'avatar', 'email', 'personal_text', 'website', 'messenger', 'love_state', 'children', 'live_with', 'height', 'weight', 'hair_color', 'eyes_color', 'constitution', 'diet', 'drink', 'smoke', 'studies', 'language_spanish', 'language_english', 'language_french', 'language_portuguese', 'language_italian', 'language_german', 'language_other', 'work', 'company', 'work_sector', 'income', 'work_interests', 'work_skills', 'my_interests', 'my_hobbies', 'tv_shows', 'favorite_music', 'favorite_sports', 'favorite_books', 'favorite_food', 'favorite_films', 'my_heros');
$defs = array('name' => '', 'avatar' => '0.gif?'.$currentuser['id'], 'email' => '', 'personal_text' => '', 'website' => '', 'messenger' => '', 'love_state' => '0', 'children' => '0', 'live_with' => '0', 'height' => '', 'weight' => '', 'hair_color' => '0', 'eyes_color' => '0', 'constitution' => '0', 'diet' => '0', 'drink' => '0', 'smoke' => '0', 'studies' => '0', 'language_spanish' => '0', 'language_english' => '0', 'language_french' => '0', 'language_portuguese' => '0', 'language_italian' => '0', 'language_german' => '0', 'language_other' => '0', 'work' => '', 'company' => '', 'work_sector' => '0', 'income' => '0', 'work_interests' => '', 'work_skills' => '', 'my_interests' => '', 'my_hobbies' => '', 'tv_shows' => '', 'favorite_music' => '', 'favorite_sports' => '', 'favorite_books' => '', 'favorite_food' => '', 'favorite_films' => '', 'my_heros' => '');
$get = mysql_fetch_assoc(mysql_query("SELECT ".implode(', ', $vals)." FROM `users` WHERE id = '".$currentuser['id']."'"));
foreach($get as $key=>$value) {
  if($value != $defs[$key]) $percent += $val;
}
settype($percent, 'string');
mysql_query("UPDATE `users` SET `percent` = '".$percent."' WHERE id = '".$currentuser['id']."'");
if($percent == '100' && !mysql_num_rows(mysql_query("SELECT id FROM `medals` WHERE user = '".$currentuser['id']."' && medal = '6'"))) {
  mysql_query("INSERT INTO `medals` (user, medal, time) VALUES('".$currentuser['id']."', '6', '".time()."')");
} elseif($percent != '100' && mysql_num_rows($q=mysql_query("SELECT id FROM `medals` WHERE user = '".$currentuser['id']."' && medal = '6'"))) {
  mysql_query("DELETE FROM `medals` WHERE user = '".$currentuser['id']."' && medal = '6'");
}

die('{"porc":"'.round($percent).'"}');
?>