<?php
$timestart = microtime(true);
$memstart = round(memory_get_usage() / 1024,1);
include('config.php');

define($config['define'], true);
include('functions.php');
include('online.php'); // mira si esta online y ace $pstats
// PAGE
if(!$_GET['page'] || !file_exists('./Pages/'.$_GET['page'].'.php') || $_GET['page'] == 'index') {
	$_GET['page'] = 'default';
}
	
// Texts
include('Texts/'.$_GET['page'].'_'.$config['lang'].'.php');
include('Texts/header-footer_'.$config['lang'].'.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="turinga,linksharing,descargas,noticias,juegos,noticias" />
<meta name="description" content="Turinga - En Turinga puedes encontrar muchos contenidos totalmente gratis. Programas, juegos, noticias..." />
<meta name="robots" content="INDEX,NOFOLLOW" />
<title><?=$config['script_name'];?> - <?=$txt['page_title'];?></title>
<script type="text/javascript">
var cdp = <?=(isAllowedTo('deleteposts') ? 'true' : 'false');?>;
var gyear = <?=date('Y');?>;
var min_age = <?=$config['min_age'];?>;
var currentptime = <?=time();?>;
var isLogged = <?=(isLogged ? 'true' : 'false');?>;
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/scripts.js?2.0.2"></script>
<link rel="stylesheet" href="/styles.css?2.0.2" type="text/css" />
<link rel="shortcut icon" href="/favicon.ico" />
</head>
<body>
<div id="mask"></div>
<div id="mydialog"></div>
<div class="tipsy" id="tipsy" style="z-index: 100000; position: absolute; display: block; visibility: visible; top: 786px; left: 925px; display: none;">
<div class="tipsy-inner" id="tipsy-inner"></div>
</div>
<div class="rtop" id="rtop"></div>
<div id="maincontainer">
<div id="head">
<div id="logo">
<a href="/" title="<?=$config['script_name'];?>" id="logoi"><img src="/images/space.gif" border="0" alt="<?=$config['script_name'];?>" title="<?=$config['script_name'];?>" align="top" /></a>
</div>
<div id="banner">
<?php
if($config['maintenance'] === true && isAllowedTo('maintenance')) {
	echo '<strong>ATENCI&Oacute;N: La web est&aacute; en mantenimiento, puedes acceder porque eres administrador.</strong>';
} else {
	echo advert('468x60');
}
?>
</div>
</div>
<?php 
include('header.php');
if($config['maintenance'] === true && !isAllowedTo('maintenance')) {
	echo '<div id="cuerpocontainer"><center>'.$config['maintenance_text'].'<br /><br /><img src="/images/mantenimiento.png" /></center></div>';
} else {
	include('./Pages/'.$_GET['page'].'.php');
}
include('footer.php');
if($currentuser['rank'] == '8') {
  echo '<br /><center>Memoria usada: '.(round(memory_get_usage() / 1024,1)-$memstart).' - Tiempo de ejecucion: '.(microtime(true)-$timestart).'</center>';
}
?>
</div>
</body>
</html>