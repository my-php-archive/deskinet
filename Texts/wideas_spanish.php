<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
switch($_GET['s']) {
	default: $currentIdea = 'last'; $txt['page_title'] = '&Uacute;ltimas ideas'; break;
	case 'mejores': $currentIdea = 'best'; $txt['page_title'] = 'Mejores ideas'; break;
	case 'aceptadas': $currentIdea = 'accepted'; $txt['page_title'] = 'Ideas aceptadas'; break;
	case 'rechazadas': $currentIdea = 'rejected'; $txt['page_title'] = 'Ideas rechazadas'; break;
	case 'nueva': $currentIdea = 'new'; $txt['page_title'] = 'Nueva idea'; break;
}
?>