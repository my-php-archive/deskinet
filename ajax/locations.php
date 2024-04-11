<?php
if(!$_GET['_'] || !$_GET['type']) { die('0Error de usuario'); }
include('../config.php');
include('../functions.php');
$die = '';
switch($_GET['type']) {
  default: $die = '0Acci&oacute;n desconocida ('.$_GET['type'].')'; break;
  case 'provinces':
    if(!$_GET['country']) { die('0No has elegido un pa&iacute;s'); }
    if(!mysql_num_rows(mysql_query("SELECT id FROM `countries` WHERE id = '".mysql_clean($_GET['country'])."'"))) { die('0El pa&iacute;s no existe'); }
    if(!mysql_num_rows($q = mysql_query("SELECT id, name FROM `provinces` WHERE country = '".mysql_clean($_GET['country'])."' ORDER BY name ASC"))) { die('2'); }
    $die = '1';
    while($p = mysql_fetch_assoc($q)) {
      $die .= '<option value="'.$p['id'].'">'.$p['name'].'</option>';
    }
  break;
  case 'hasCities':
    if(!$_GET['province']) { die('0No has seleccionado una provincia'); }
    if(!mysql_num_rows(mysql_query("SELECT id FROM `provinces` WHERE id = '".mysql_clean($_GET['province'])."'"))) { die('0No existe la provincia'); }
    if(!mysql_num_rows(mysql_query("SELECT id FROM `cities` WHERE province = '".mysql_clean($_GET['province'])."'"))) { die('2'); }
    $die = '1';
  break;
  case 'cities':
    if(!$_GET['province'] || !$_GET['q']) { die('0Faltan datos'); }
    if(!mysql_num_rows(mysql_query("SELECT id FROM `provinces` WHERE id = '".mysql_clean($_GET['province'])."'"))) { die('0No existe la provincia'); }
    $c = array();
    $query = mysql_query("SELECT id, name FROM `cities` WHERE province = '".mysql_clean($_GET['province'])."' && name LIKE '%".mysql_clean($_GET['q'])."%' ORDER BY name ASC");
    while($city = mysql_fetch_assoc($query)) {
      $c[] = $city['name'].'|'.$city['id'];
    }
    $die = implode("\n", $c);
  break;
  case 'check':
    if(!$_GET['province'] || !$_GET['city']) { die('0Faltan datos'); }
    if(!mysql_num_rows(mysql_query("SELECT id FROM `provinces` WHERE id = '".mysql_clean($_GET['province'])."'"))) { die('0No existe la provincia'); }
    if(!mysql_num_rows(mysql_query("SELECT id FROM `cities` WHERE id = '".mysql_clean($_GET['city'])."' && province = '".mysql_clean($_GET['province'])."'"))) { die('0La ciudad es incorrecta'); }
    die('1');
  break;
  case 'countries':
    $query = mysql_query("SELECT id, name FROM `countries` ORDER BY name");
    while($c = mysql_fetch_assoc($query)) {
      $die .= "<option value=\"".$c['id']."\">".$c['name']."</option>\n";
    }
  break;
}
die($die);
?>