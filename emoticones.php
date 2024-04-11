<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
	<meta name="robots" content="index,follow" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Emoticones</title>
<style type="text/css"> 
<!--
body,td,th {
	font-size: 11px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
-->
</style>
</head>
<body>
	<table width="120" border="0" cellpadding="3" cellspacing="3">
		<tr align="center">
	    <td width="40"><strong>Emotic&oacute;n:</strong></td>
	    <td width="80"><strong>C&oacute;digo:</strong></td>
	  </tr>
<?php
	$emoticonos = glob('images/smiles/*.gif');
	foreach($emoticonos as $name) {
		$ex = explode('/', $name);
		$ex = $ex[count($ex)-1];
		$ex = explode('.', $ex);
		$ex = $ex[0];
		echo '<tr align="center">
	    <td width="40"><img src="/images/smiles/'.$ex.'.gif" /></td>
	    <td width="80">:'.$ex.':</td>
	  </tr>'."\n";
	}
?>