<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }

switch($_GET['sa']) {
	default:
	case 'posts':
		$currentTop = 'posts';
		$currentTop2 = 'posts';
	break;
	break;
	case 'comunidades':
		$currentTop = 'groups';
		$currentTop2 = 'comunidades';
	break;
	case 'temas':
		$currentTop = 'group_posts';
		$currentTop2 = 'temas';
	break;
	case 'usuarios':
		$currentTop = 'users';
		$currentTop2 = 'usuarios';
	break;
}

$txt['page_title'] = 'TOPs';
?>