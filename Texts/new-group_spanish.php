<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
$txt['page_title'] = ($_GET['group'] ? 'Editar comunidad' : 'Crear comunidad');

?>