<?php /*
/* MySQL Connection */
$config['db_server'] = 'localhost'; // Servidor base de datos
$config['db_user'] = 'taringa'; // Usuario base de datos
$config['db_password'] = 'etgEtViT8i2t'; // Contraseña base de datos
$config['db_name'] = 'taringa_db'; //Nombre base de datos

/* Script Configuration */
$config['script_name'] = 'Taringa!'; // Nombre del script
$config['script_name2'] = 'taringa'; // Nombre del script SIN SIGNOS como !, *, etc.
$config['script_sl'] = 'T!';
$config['script_desc'] = 'Inteligencia Colectiva'; //o lo haria mejor un perro'; // Descripción del script
//$config['script_url'] = $_SERVER['HTTP_HOST'];
$config['script_url'] = 'http://taringa.net';
//$config['script_url2'] = $_SERVER['DOCUMENT_ROOT'];
$config['lang'] = 'spanish'; // Idioma del script
$config['cookie_name'] = 'dorantesm'; // Nombre de la cookie
$config['define'] = 'define'; // Nombre para comprobar que pasa por el index
$config['recaptcha_privatekey'] = '6LdVVAoAAAAAAN5TtVSbcQZ5UKXUOP9GnVA_41Zc'; // Key para recaptcha
$config['recaptcha_publickey'] = '6LdVVAoAAAAAAKdNOSaitZBs7Ktgtc0tb2gxd656'; // Key para recaptcha
$config['min_age'] = 18; // Edad minima
$config['noreply_email'] = 'ftp@taringa.net'; // EMail, si no existe puede dar problemas
// MANTENIMIENTO
// = true; Activado
// = false; Desacivado
$config['maintenance'] = true;
$config['maintenance_text'] = '
Estamos actualizando el sistema, volveremos en unos minutos..
<br><br>
<img src="/images/mejorastecnicas.png">
'; // Mensaje a mostrar durante el mantenimiento
// Conexion a la db
$connection = mysql_connect($config['db_server'], $config['db_user'], $config['db_password']);
mysql_select_db($config['db_name'], $connection);
?>