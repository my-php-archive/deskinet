<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
$txt['page_title'] = ($_GET['edit'] ? 'Editar post' : 'Agregar nuevo post');
?>