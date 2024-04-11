<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
switch($_GET['p']) {
	case 'seguidores':
		$monitor_t = '1';
	break;
	case 'siguiendo':
		$monitor_t = '2';
	break;
	case 'posts':
		$monitor_t = '3';
	break;
	case 'comunidades':
		$monitor_t = '4';
	break;
	case 'temas':
		$monitor_t = '5';
	break;
}
$txt['page_title'] = 'Monitor de usuario';
if(!$monitor_t) {
	include('./Texts/monitor_spanish.php');
	$_GET['page'] = 'monitor';
}
?>