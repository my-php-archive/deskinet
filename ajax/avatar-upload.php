<?php
session_start();
include('../config.php');
include('../functions.php');
function jerror($e){die('{"error":"'.$e.'"}');}
if(!isLogged()) { jerror('Debes logearte'); }
if($_GET['save']) {
  if(!$_SESSION['avurl']) { jerror('No has subido ning&uacute;n avatar'); }
  $ex = explode('.', $_SESSION['avurl']);
  switch($ex[(count($ex)-1)]) {
    case 'gif':
        $im = imagecreatefromgif($_SESSION['avurl']);
    break;
    case 'png':
        $im = imagecreatefrompng($_SESSION['avurl']);
    break;
    case 'jpg':
    case 'jpeg':
        $im = imagecreatefromjpeg($_SESSION['avurl']);
    break;
  }
  list($fx, $fy, $sx, $sy) = explode(',', $_GET['coords']);
  if(!ctype_digit($fx) || $fx > imagesx($im)) { jerror('Las coordenadas no son correctas'); }
  if(!ctype_digit($fy) || $fy > imagesy($im)) { jerror('Las coordenadas no son correctas'); }
  if(!ctype_digit($sx) || $sx > imagesx($im)) { jerror('Las coordenadas no son correctas'); }
  if(!ctype_digit($sy) || $sy > imagesy($im)) { jerror('Las coordenadas no son correctas'); }
  if($fx > $sx) { $c = $fx; $fx = $sx; $sx = $c; unset($c); }
  if($fy > $sy) { $c = $fy; $fy = $sy; $sy = $c; unset($c); }
  $w = $sx-$fx;
  $h = $sy-$fy;
  $img = imagecreatetruecolor($w, $h);
  imagecopyresampled($img, $im, 0, 0, $fx, $fy, $w, $h, $w, $h);
  if(mysql_num_rows($q = mysql_query("SELECT id, url FROM `avatares` WHERE user = '".$currentuser['id']."'"))) {
    $a = mysql_fetch_row($q);
    unlink($a[1]);
    mysql_query("DELETE FROM `avatares` WHERE id = '".$a[0]."'");
    mysql_query("UPDATE `users` SET avatar = '0.gif', percent = percent-2.5 WHERE id = '".$currentuser['id']."'");
  }
  mysql_query("INSERT INTO `avatares` (user) VALUES ('".$currentuser['id']."')");
  unlink($_SESSION['avurl']);
  switch($ex[(count($ex)-1)]) {
    case 'gif':
        $i = mysql_insert_id().'.gif';
        $url = '../avatares/120/'.$i;
        imagegif($img, $url);
    break;
    case 'png':
        $i = mysql_insert_id().'.png';
        $url = '../avatares/120/'.$i;
        imagepng($img, $url);
    break;
    case 'jpg':
    case 'jpeg':
        $i = mysql_insert_id().'.jpg';
        $url = '../avatares/120/'.$i;
        imagejpeg($img, $url);
    break;
  }
  mysql_query("UPDATE `avatares` SET url = '".$url."', img = '".$i."' WHERE id = '".mysql_insert_id()."'");
  mysql_query("UPDATE `users` SET avatar = '".$i."', percent = percent+2.5 WHERE id = '".$currentuser['id']."'");
  imagedestroy($im);
  imagedestroy($img);
} elseif($_POST['del']) {
  if(!$_SESSION['avurl']) { jerror('No has subido ning&uacute;n avatar'); }
  unlink($_SESSION['avurl']);
  $q = mysql_query("SELECT img FROM `avatares` WHERE user = '".$currentuser['id']."'");
  if(!mysql_num_rows($q)) {
    die('/avatares/120/0.gif');
  } else {
    $a = mysql_fetch_row($q);
    die('/avatares/120/'.$a[0]);
  }
} else {
  if(!$_FILES['file-avatar']) { jerror('No has enviado datos'); }
  if(!$_POST['maxw'] || !$_POST['maxh'] || !ctype_digit($_POST['maxw']) || !ctype_digit($_POST['maxh'])) { jerror('Datos incompletos o incorrectos'); }
  $maxw = $_POST['maxw']-300;
  $maxh = $_POST['maxh']-120;
  $maxsize = 2097152;
  $allowed = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg');
  if($_FILES['file-avatar']['size'] > $maxsize) { jerror('El archivo es demasiado pesado >'.$_FILES['file-avatar']['size']); }
  if(!in_array($_FILES['file-avatar']['type'], $allowed)) { jerror('El archivo no es una imagen v&aacute;lida'); }
  $dest = '../avatares/tmp/'.sha1_file($_FILES['file-avatar']['tmp_name']).strtolower(substr($_FILES['file-avatar']['name'], strrpos($_FILES['file-avatar']['name'], '.')));
  list($width, $height) = getimagesize($_FILES['file-avatar']['tmp_name']);
  if(!move_uploaded_file($_FILES['file-avatar']['tmp_name'], $dest)) {
    jerror('No se pudo subir el archivo');
  } else {
    $orurl = substr($dest, 2);
    $dest = $_SERVER['DOCUMENT_ROOT'].substr($dest, 2);
    $_SESSION['avurl'] = $dest;
    if($width > $maxw || $height > $maxh) {
        if(($width-$maxw) > ($height-$maxh)) {//jerror("$maxw<$maxh<1");
            $minusw = ($width-$maxw);
            $percent = ($minusw/$width)*100;
            $minush = $height/100*$percent;
        } elseif(($width-$maxw) < ($height-$maxh)) {  //jerror("$maxw<$maxh<2");
            $minush = ($height-$maxh);
            $percent = ($minush/$height)*100;
            $minusw = $width/100*$percent;
        } else {                       //jerror("$maxw<$maxh<3");
            $minusw = $minush = $width-$maxw;
        }
        $nwidth = $width-$minusw;
        $nheight = $height-$minush;
        $ex = explode('.', $dest);
        switch($ex[(count($ex)-1)]) {
            case 'gif':
                $im = imagecreatefromgif($dest);
            break;
            case 'png':
                $im = imagecreatefrompng($dest);
            break;
            case 'jpg':
            case 'jpeg':
                $im = imagecreatefromjpeg($dest);
            break;
        }
        $img = imagecreatetruecolor($nwidth, $nheight);
        imagecopyresampled($img, $im, 0, 0, 0, 0, $nwidth, $nheight, imagesx($im), imagesy($im));
        switch($ex[(count($ex)-1)]) {
            case 'gif':
                imagegif($img, $dest);
            break;
            case 'png':
                imagepng($img, $dest);
            break;
            case 'jpg':
            case 'jpeg':
                imagejpeg($img, $dest);
            break;
        }
        imagedestroy($im);
        imagedestroy($img);
    }
    die('{"msg":"'.$orurl.'"}');
  }
}
?>