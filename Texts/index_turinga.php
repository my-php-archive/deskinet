<?php
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
</script>
<script type="text/javascript" src="/scripts.js">
</script>
<link rel="stylesheet" href="/styles.css" type="text/css" />
<link rel="shortcut icon" href="/favicon.ico" />
</head>
<? if($_GET['page'] == 'new-post') { $bobu = ' onbeforeunload="return confirm(\'¿De verdad quieres salir?\');"'; } ?>
<body<?=$bobu;?>>
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
	echo '<!-- BEGIN SMOWTION TAG - 468x60 - turinga: p2p - DO NOT MODIFY -->
<script type="text/javascript"><!--
smowtion_size = "468x60";
smowtion_section = "832735";
smowtion_iframe = 1;
//-->
</script>
<script type="text/javascript"
src="http://ads.smowtion.com/ad.js"> 
</script>
<!-- END SMOWTION TAG - 160x600 - turinga: p2p - DO NOT MODIFY -->';
}
?>
</div>
</div>
<?php
include('header.php');
if($config['maintenance'] === true && $currentuser['rank'] != 8) {
	echo '<div id="cuerpocontainer"><center>Estamos realizando mejoras en '.$config['script_name'].', y tenemos que cerrar por poquito tiempo, &iexcl;Dentro de nada estamos de vuelta!<br /><br /><img src="/images/mantenimiento.png" /></center></div>';
} else {
	include('./Pages/'.$_GET['page'].'.php');
}
include('footer.php');
?>
</div>
</body>
</html>