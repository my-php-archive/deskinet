<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
$txt['page_title'] = ($_GET['post'] ? 'Editar tema' : 'Publicar en la comunidad');
?>