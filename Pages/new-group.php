<?php
if(!defined($config['define'])) { die; }
if(!isLogged()) { die(error('OOPS!', 'Necesitas estar logeado para entrar aqu&iacute;', 'Comunidades', '/comunidades/')); }

if($currentuser['rank'] == 0) { die(error('OOPS!', 'Los novatos no pueden crear comunidades', 'Ser NFU!', '/agregar/')); }
//if($_GET['group'] && mysql_num_rows($q = mysql_query("SELECT g.id FROM group_members AS m, groups AS g WHERE g.urlname = '".mysql_clean($_GET['group'])."' && m.user = '".$currentuser['id']."' && m.rank = '4' && m.group = g.id"))) {
if($_GET['group'] && mysql_num_rows($q = mysql_query("SELECT * FROM `groups` WHERE urlname = '".mysql_clean($_GET['group'])."'"))) {
	$gedit = mysql_fetch_row($q);
	$gedit = mysql_fetch_assoc(mysql_query("SELECT * FROM `groups` WHERE id = '".$gedit[0]."'"));
} elseif($_GET['group']) { die(error('OOPS!', 'No existe esta comunidad o no tienes permisos para editarla', 'Crear tu comunidad', '/comunidades/crear/')); }

if($gedit && !isAllowedTo('edit_groups') && !mysql_num_rows(mysql_query("SELECT id FROM `group_members` WHERE user = '".$currentuser['id']."' && `group` = '".$gedit['id']."' && rank = '4'"))) { die(error('OOPS!', 'No tienes permisos para editar esta comunidad', 'Ir al &iacute;dice de comunidades', '/comunidades/')); }

$url = ($gedit ? '/comunidades/'.$gedit['urlname'].'/editar/' : '/comunidades/crear/');

if(isAllowedTo('official_group')) { $official = true; }

if($_POST) {
	if(!$_POST['privada']) { $_POST['privada'] = '0'; }
	if(!$_POST['rango_default']) { $_POST['rango_default'] = '0'; }
	if(empty($_POST['nombre']) || !$_POST['nombre']) { die(error('OOPS!', 'No has puesto un nombre', 'Reintentar', $url)); }
	if((empty($_POST['shortname']) || !$_POST['shortname']) && !$gedit) { die(error('OOPS!', 'No has puesto un nombre corto', 'Reintentar', $url)); }
	if(empty($_POST['imagen']) || !$_POST['imagen']) { die(error('OOPS!', 'No has puesto una imagen', 'Reintentar', $url)); }
	if(empty($_POST['descripcion']) || !$_POST['descripcion']) { die(error('OOPS!', 'No has escrito una descripci&oacute;n', 'Reintentar', $url)); }
	if(empty($_POST['tags']) || !$_POST['tags']) { die(error('OOPS!', 'No has puesto tus tags', 'Reintentar', $url)); }
	if(!$_POST['categoria']) { die(error('OOPS!', 'No has seleccionado una categor&iacute;a', 'Reintentar', $url)); }
	if(!$_POST['subcategoria']) { die(error('OOPS!', 'No has seleccionado una subcategor&iacute;a', 'Reintentar', $url)); }
	
	if(strlen($_POST['nombre']) < 1 || strlen($_POST['nombre']) > 32) { die(error('OOPS!', 'El nombre debe tener entre 1 y 32 caracteres', 'Reintentar', $url)); }
	if((strlen($_POST['shortname']) < 5 || strlen($_POST['shortname']) > 32) && !$gedit) { die(error('OOPS!', 'El nombre corto debe tener entre 5 y 32 caracteres', 'Reintentar', $url)); }
	if(!preg_match('/^[a-z0-9]+$/i', $_POST['shortname']) && !$gedit) { die(error('OOPS!', 'El nombre corto solo puede tener letras y n&uacute;meros', 'Reintentar', $url)); }
	if($_POST['pais'] < 0 || ($_POST['pais'] > 262 && $_POST['pais'] != 999)) { die(error('OOPS!', 'El pa&iacute;s no es v&aacute;lido', 'Reintentar', $url)); }
	if($_POST['shortname'] == 'crear' && !$gedit) { die(error('OOPS!', 'Ese nombre corto no es v&aacute;lido', 'Reintentar', $url)); }
	$tags = explode(',', str_replace(',,', ',', $_POST['tags']));
	if(count($tags) < 4) { die(error('OOPS!', 'Debes ingresar al menos 4 tags', 'Reintentar', $url)); }
	foreach($tags as $tag) { if(!preg_match('/^[a-z0-9]+$/i', $tag)) { die(error('OOPS!', 'Los tags solo admiten letras y n&uacute;meros', 'Reintentar', $url)); break; } }
	if(!mysql_num_rows(mysql_query("SELECT * FROM `group_categories` WHERE id = '".mysql_clean($_POST['categoria'])."' && sub = '0'"))) { die(error('OOPS!', 'No existe la categor&iacute;a', 'Reintentar', '/comunidades/crear/')); }
	if(!mysql_num_rows(mysql_query("SELECT * FROM `group_categories` WHERE id = '".mysql_clean($_POST['subcategoria'])."' && sub = '".mysql_clean($_POST['categoria'])."'"))) { die(error('OOPS!', 'La subcategor&iacute;a no es v&aacute;lida')); }
	if($_POST['privada'] != '1' && $_POST['privada'] != '0') { die(error('OOPS!', 'Debes seleccionar quien podr&aacute; entrar a tu comunidad', 'Reintentar', $url)); }
	if($_POST['rango_default'] != '0' && $_POST['rango_default'] != '1' && $_POST['rango_default'] != '2') { die(error('OOPS!', 'Debes seleccionar un rango por defecto', 'Reintentar', $url)); }
	if(!$gedit) {
		mysql_query("INSERT INTO `groups` (name, urlname, cat, subcat, avatar, description, tags, country, private, default_rank, official, creator, time) VALUES ('".mysql_clean($_POST['nombre'])."','".mysql_clean($_POST['shortname'])."','".mysql_clean($_POST['categoria'])."','".mysql_clean($_POST['subcategoria'])."','".mysql_clean($_POST['imagen'])."','".mysql_clean($_POST['descripcion'])."','".mysql_clean($_POST['tags'])."','".($_POST['pais'] ? mysql_clean($_POST['pais']) : '999')."','".mysql_clean($_POST['privada'])."','".mysql_clean($_POST['rango_default'])."','".($official && $_POST['oficial'] == '1' ? '1' : '0')."','".$currentuser['id']."', '".time()."')") or die('Contacta a un administrador indicandole que hay un fallo aqu&iacute;, indica tambien que datos has puesto');
		mysql_query("INSERT INTO `group_members` (user, `group`, time, rank) VALUES ('".$currentuser['id']."', '".mysql_insert_id()."', '".time()."', '4')");
	} else {
		mysql_query("UPDATE `groups` SET name = '".mysql_clean($_POST['nombre'])."', cat = '".mysql_clean($_POST['categoria'])."', subcat = '".mysql_clean($_POST['subcategoria'])."', avatar = '".mysql_clean($_POST['imagen'])."', description = '".mysql_clean($_POST['descripcion'])."', tags = '".mysql_clean($_POST['tags'])."', country = '".($_POST['pais'] ? mysql_clean($_POST['pais']) : '999')."', private = '".mysql_clean($_POST['privada'])."', default_rank = '".mysql_clean($_POST['rango_default'])."', official = '".($official && $_POST['oficial'] == '1' ? '1' : '0')."' WHERE id = '".$gedit['id']."'");
	}
	die(error('YEAH!', ($gedit ? 'La comunidad se ha editado' : 'La comunidad se ha creado correctamente'), 'Ir a tu comunidad', '/comunidades/'.($gedit ? $gedit['urlname'] : $_POST['shortname']).'/'));
}
?>
<div id="cuerpocontainer">
<!-- inicio cuerpocontainer -->
<div class="comunidades">
<div id="derecha" style="float:left;width:375px">
	<div class="box_title"><div class="box_txt">Reglas para tu comunidad</div></div>
	<div class="box_cuerpo">
		Para que tu comunidad sea exitosa te recomendamos tener en cuenta los siguientes puntos:
 
		<p><b>Una comunidad SI puede:</b><br /></p>
		<ul>
			<li><img vspace="2" align="absmiddle" src="/images/icon-good.png" /> Compartir ideas y pensamientos.</li>
			<li><img vspace="2" align="absmiddle" src="/images/icon-good.png" /> Ser interesante para otras personas.</li>
			<li><img vspace="2" align="absmiddle" src="/images/icon-good.png" /> Preguntar y Consultar.</li>
			<li><img vspace="2" align="absmiddle" src="/images/icon-good.png" /> Compartir ideas y pensamientos.</li>
			<li><img vspace="2" align="absmiddle" src="/images/icon-good.png" /> Compartir gustos y experiencias personales.</li>
		<ul>
 
		<p><b>Una comunidad NO puede:</b><br /></p>
		<ul>	
			<li><img vspace="2" align="absmiddle" src="/images/icon-bad.png" /> Compartir enlaces de descarga.</li>
			<li><img vspace="2" align="absmiddle" src="/images/icon-bad.png" /> Generar odio. </li>
			<li><img vspace="2" align="absmiddle" src="/images/icon-bad.png" /> Generar violencia.</li>
			<li><img vspace="2" align="absmiddle" src="/images/icon-bad.png" /> Compartir fotos de personas menores de edad.</li>
			<li><img vspace="2" align="absmiddle" src="/images/icon-bad.png" /> Mostrar muertos, sangre, v&oacute;mitos, etc.</li>
			<li><img vspace="2" align="absmiddle" src="/images/icon-bad.png" /> Tener contenido racista y/o peyorativo.</li>
			<li><img vspace="2" align="absmiddle" src="/images/icon-bad.png" /> Que sus miembros insulten a otros.</li>
			<li><img vspace="2" align="absmiddle" src="/images/icon-bad.png" /> Hacer apolog&iacute;a al delito.</li>
			<li><img vspace="2" align="absmiddle" src="/images/icon-bad.png" /> Contener software spyware, malware, virus o troyanos.</li>
			<li><img vspace="2" align="absmiddle" src="/images/icon-bad.png" /> Hacer Spam.</li>
			
		</ul>
<br /><br />
 
<strong>Por favor lea el protocolo para evitar sanciones o que tu comunidad sea eliminada haciendo <a href="/protocolo/" target="_blank">click aqu&iacute;</a></strong>
 
	</div>
</div>
 
 
 
<div id="centro">
	<div style="background: #f7f7f7">
		<div class="titleHighlight">
			Crear nueva comunidad		</div>
		<div class="form-container form2">
			<form name="add_comunidad" method="post" action="<?=$url;?>" onsubmit="return groups_new_check(this);">
				<div class="dataL">
					<label for="uname">Nombre de la comunidad</label>
					<input class="c_input" type="text" value="<?=$gedit['name'];?>" name="nombre" tabindex="1" datatype="text" dataname="Nombre" />
				</div>
				<div class="dataR">
					<span class="gif_loading floatR" id="shortname" style="top:0px"></span>
					<label for="uname">Nombre corto</label>
					<input class="c_input" type="text" value="<?=$gedit['urlname'];?>" name="shortname" tabindex="2" onkeyup="if(this.value.length > 0) {document.getElementById('preview_shortname').innerHTML = this.value;groups_shortname_check(this.value);}" onblur="groups_shortname_check(this.value);" datatype="text" dataname="Nombre corto"<?=($gedit ? ' disabled' : '');?> />
					<div class="desform">URL de la comunidad: <br /><strong><? /*=$config['script_url'];*/ echo 'web'; ?>/comunidades/<span id="preview_shortname"><?=$gedit['urlname'];?></span></strong></div>
					<span id="msg_crear_shortname"></span>
				</div>
				<div class="clearBoth"></div>
 
				<div class="dataL">
					<label for="uname">Imagen</label>
					<input class="c_input" type="text" value="<?=($gedit ? $gedit['avatar'] : 'http://');?>" name="imagen" tabindex="3" datatype="url" dataname="Imagen" />
				</div>
				<div class="dataR">
					<label for="fname">Pa&iacute;s</label>
					<select id="pais" name="pais" tabindex="4" datatype="select" default="-1" dataname="Pais">
						<option value="-1" selected>Seleccionar Pa&iacute;s</option>
							<option value="-2">---</option>
							<option value="999"<?=($gedit && $gedit['country'] == '999' ? ' selected' : '');?>>Internacional</option>
							<option value="-2">---</option>
													<option value="0"<?=($gedit['country'] == '0' ? ' selected' : '');?>>Argentina</option>
													<option value="1"<?=($gedit['country'] == '1' ? ' selected' : '');?>>Bolivia</option>
													<option value="2"<?=($gedit['country'] == '2' ? ' selected' : '');?>>Brasil</option>
													<option value="3"<?=($gedit['country'] == '3' ? ' selected' : '');?>>Chile</option>
													<option value="4"<?=($gedit['country'] == '4' ? ' selected' : '');?>>Colombia</option>
													<option value="5"<?=($gedit['country'] == '5' ? ' selected' : '');?>>Costa Rica</option>
													<option value="6"<?=($gedit['country'] == '6' ? ' selected' : '');?>>Cuba</option>
													<option value="7"<?=($gedit['country'] == '7' ? ' selected' : '');?>>Rep&uacute;blica Checa</option>
													<option value="8"<?=($gedit['country'] == '8' ? ' selected' : '');?>>Ecuador</option>
													<option value="9"<?=($gedit['country'] == '9' ? ' selected' : '');?>>El Salvador</option>
													<option value="10"<?=($gedit['country'] == '10' ? ' selected' : '');?>>Espa&ntilde;a</option>
													<option value="11"<?=($gedit['country'] == '11' ? ' selected' : '');?>>Guatemala</option>
													<option value="12"<?=($gedit['country'] == '12' ? ' selected' : '');?>>Guinea Ecuatorial</option>
													<option value="13"<?=($gedit['country'] == '13' ? ' selected' : '');?>>Honduras</option>
													<option value="14"<?=($gedit['country'] == '14' ? ' selected' : '');?>>Israel</option>
													<option value="15"<?=($gedit['country'] == '15' ? ' selected' : '');?>>Italia</option>
													<option value="16"<?=($gedit['country'] == '16' ? ' selected' : '');?>>Jap&oacute;n</option>
													<option value="17"<?=($gedit['country'] == '17' ? ' selected' : '');?>>M&eacute;xico</option>
													<option value="18"<?=($gedit['country'] == '18' ? ' selected' : '');?>>Nicaragua</option>
													<option value="19"<?=($gedit['country'] == '19' ? ' selected' : '');?>>Panam&aacute;</option>
													<option value="20"<?=($gedit['country'] == '20' ? ' selected' : '');?>>Paraguay</option>
													<option value="21"<?=($gedit['country'] == '21' ? ' selected' : '');?>>Per&uacute;</option>
													<option value="22"<?=($gedit['country'] == '22' ? ' selected' : '');?>>Portugal</option>
													<option value="23"<?=($gedit['country'] == '23' ? ' selected' : '');?>>Puerto Rico</option>
													<option value="24"<?=($gedit['country'] == '24' ? ' selected' : '');?>>Rep&uacute;blica Dominicana</option>
													<option value="25"<?=($gedit['country'] == '25' ? ' selected' : '');?>>Estados Unidos</option>
													<option value="26"<?=($gedit['country'] == '26' ? ' selected' : '');?>>Uruguay</option>
													<option value="27"<?=($gedit['country'] == '27' ? ' selected' : '');?>>Venezuela</option>
													<option value="28"<?=($gedit['country'] == '28' ? ' selected' : '');?>>----</option>
													<option value="29"<?=($gedit['country'] == '29' ? ' selected' : '');?>>Afghanist&aacute;n</option>
													<option value="30"<?=($gedit['country'] == '30' ? ' selected' : '');?>>Albania</option>
													<option value="31"<?=($gedit['country'] == '31' ? ' selected' : '');?>>Argelia</option>
													<option value="32"<?=($gedit['country'] == '32' ? ' selected' : '');?>>Samoa Americana</option>
													<option value="33"<?=($gedit['country'] == '33' ? ' selected' : '');?>>Andorra</option>
													<option value="34"<?=($gedit['country'] == '34' ? ' selected' : '');?>>Angola</option>
													<option value="35"<?=($gedit['country'] == '35' ? ' selected' : '');?>>Anguila</option>
													<option value="36"<?=($gedit['country'] == '36' ? ' selected' : '');?>>Ant&aacute;rtida</option>
													<option value="37"<?=($gedit['country'] == '37' ? ' selected' : '');?>>Antigua y Barbuda</option>
													<option value="38"<?=($gedit['country'] == '38' ? ' selected' : '');?>>Armenia</option>
													<option value="39"<?=($gedit['country'] == '39' ? ' selected' : '');?>>Aruba</option>
													<option value="40"<?=($gedit['country'] == '40' ? ' selected' : '');?>>Islas Ashmore y Cartier</option>
													<option value="41"<?=($gedit['country'] == '41' ? ' selected' : '');?>>Australia</option>
													<option value="42"<?=($gedit['country'] == '42' ? ' selected' : '');?>>Austria</option>
													<option value="43"<?=($gedit['country'] == '43' ? ' selected' : '');?>>Azerbaiy&aacute;n</option>
													<option value="44"<?=($gedit['country'] == '44' ? ' selected' : '');?>>Las Bahamas</option>
													<option value="45"<?=($gedit['country'] == '45' ? ' selected' : '');?>>Bahr&eacute;in</option>
													<option value="46"<?=($gedit['country'] == '46' ? ' selected' : '');?>>Isla Baker</option>
													<option value="47"<?=($gedit['country'] == '47' ? ' selected' : '');?>>Bangladesh</option>
													<option value="48"<?=($gedit['country'] == '48' ? ' selected' : '');?>>Barbados</option>
													<option value="49"<?=($gedit['country'] == '49' ? ' selected' : '');?>>Bassas da India</option>
													<option value="50"<?=($gedit['country'] == '50' ? ' selected' : '');?>>Bielorrusia</option>
													<option value="51"<?=($gedit['country'] == '51' ? ' selected' : '');?>>B&eacute;lgica</option>
													<option value="52"<?=($gedit['country'] == '52' ? ' selected' : '');?>>Belice</option>
													<option value="53"<?=($gedit['country'] == '53' ? ' selected' : '');?>>Ben&iacute;n</option>
													<option value="54"<?=($gedit['country'] == '54' ? ' selected' : '');?>>Bermuda</option>
													<option value="55"<?=($gedit['country'] == '55' ? ' selected' : '');?>>But&aacute;n</option>
													<option value="56"<?=($gedit['country'] == '56' ? ' selected' : '');?>>Bosnia y Herzegovina</option>
													<option value="57"<?=($gedit['country'] == '57' ? ' selected' : '');?>>Botsuana</option>
													<option value="58"<?=($gedit['country'] == '58' ? ' selected' : '');?>>Isla Bouvet</option>
													<option value="59"<?=($gedit['country'] == '59' ? ' selected' : '');?>>Territorio Brit&aacute;nico del Oc&eacute;ano &iacute;ndico</option>
													<option value="60"<?=($gedit['country'] == '60' ? ' selected' : '');?>>Islas V&iacute;rgenes Brit&aacute;nicas</option>
													<option value="61"<?=($gedit['country'] == '61' ? ' selected' : '');?>>Brun&eacute;i</option>
													<option value="62"<?=($gedit['country'] == '62' ? ' selected' : '');?>>Bulgaria</option>
													<option value="63"<?=($gedit['country'] == '63' ? ' selected' : '');?>>Burkina Faso</option>
													<option value="64"<?=($gedit['country'] == '64' ? ' selected' : '');?>>Birmania</option>
													<option value="65"<?=($gedit['country'] == '65' ? ' selected' : '');?>>Burundi</option>
													<option value="66"<?=($gedit['country'] == '66' ? ' selected' : '');?>>Camboya</option>
													<option value="67"<?=($gedit['country'] == '67' ? ' selected' : '');?>>Camer&uacute;n</option>
													<option value="68"<?=($gedit['country'] == '68' ? ' selected' : '');?>>Canad&aacute;</option>
													<option value="69"<?=($gedit['country'] == '69' ? ' selected' : '');?>>Cabo Verde</option>
													<option value="70"<?=($gedit['country'] == '70' ? ' selected' : '');?>>Islas Caim&aacute;n</option>
													<option value="71"<?=($gedit['country'] == '71' ? ' selected' : '');?>>Rep&uacute;blica Centroafricana</option>
													<option value="72"<?=($gedit['country'] == '72' ? ' selected' : '');?>>Chad</option>
													<option value="73"<?=($gedit['country'] == '73' ? ' selected' : '');?>>China</option>
													<option value="74"<?=($gedit['country'] == '74' ? ' selected' : '');?>>Isla de Navidad</option>
													<option value="75"<?=($gedit['country'] == '75' ? ' selected' : '');?>>Isla de la Pasi&oacute;n</option>
													<option value="76"<?=($gedit['country'] == '76' ? ' selected' : '');?>>Islas Cocos</option>
													<option value="77"<?=($gedit['country'] == '77' ? ' selected' : '');?>>Comoros</option>
													<option value="78"<?=($gedit['country'] == '78' ? ' selected' : '');?>>Rep&uacute;blica Democr&aacute;tica del Congo</option>
													<option value="79"<?=($gedit['country'] == '79' ? ' selected' : '');?>>Rep&uacute;blica del Congo</option>
													<option value="80"<?=($gedit['country'] == '80' ? ' selected' : '');?>> Islas Cook</option>
													<option value="81"<?=($gedit['country'] == '81' ? ' selected' : '');?>>Coral Sea Islands</option>
													<option value="82"<?=($gedit['country'] == '82' ? ' selected' : '');?>>Costa de Marfil</option>
													<option value="83"<?=($gedit['country'] == '83' ? ' selected' : '');?>>Croacia</option>
													<option value="84"<?=($gedit['country'] == '84' ? ' selected' : '');?>>Chipre</option>
													<option value="85"<?=($gedit['country'] == '85' ? ' selected' : '');?>>Dinamarca</option>
													<option value="86"<?=($gedit['country'] == '86' ? ' selected' : '');?>>Yibuti</option>
													<option value="87"<?=($gedit['country'] == '87' ? ' selected' : '');?>>Dominica</option>
													<option value="88"<?=($gedit['country'] == '88' ? ' selected' : '');?>>Timor Oriental</option>
													<option value="89"<?=($gedit['country'] == '89' ? ' selected' : '');?>>Egipto</option>
													<option value="90"<?=($gedit['country'] == '90' ? ' selected' : '');?>>Eritrea</option>
													<option value="91"<?=($gedit['country'] == '91' ? ' selected' : '');?>>Estonia</option>
													<option value="92"<?=($gedit['country'] == '92' ? ' selected' : '');?>>Etiop&iacute;a</option>
													<option value="93"<?=($gedit['country'] == '93' ? ' selected' : '');?>>Isla Europa</option>
													<option value="94"<?=($gedit['country'] == '94' ? ' selected' : '');?>>Islas Malvinas</option>
													<option value="95"<?=($gedit['country'] == '95' ? ' selected' : '');?>>Islas Feroe</option>
													<option value="96"<?=($gedit['country'] == '96' ? ' selected' : '');?>>Fiyi</option>
													<option value="97"<?=($gedit['country'] == '97' ? ' selected' : '');?>>Finlandia</option>
													<option value="98"<?=($gedit['country'] == '98' ? ' selected' : '');?>>Francia</option>
													<option value="99"<?=($gedit['country'] == '99' ? ' selected' : '');?>>Guayana Francesa</option>
													<option value="100"<?=($gedit['country'] == '100' ? ' selected' : '');?>>Polinesia Francesa</option>
													<option value="101"<?=($gedit['country'] == '101' ? ' selected' : '');?>>Tierras australes y ant&aacute;rticas francesas</option>
													<option value="102"<?=($gedit['country'] == '102' ? ' selected' : '');?>>Gab&oacute;n</option>
													<option value="103"<?=($gedit['country'] == '103' ? ' selected' : '');?>>Gambia</option>
													<option value="104"<?=($gedit['country'] == '104' ? ' selected' : '');?>>Georgia</option>
													<option value="105"<?=($gedit['country'] == '105' ? ' selected' : '');?>>Alemania</option>
													<option value="106"<?=($gedit['country'] == '106' ? ' selected' : '');?>>Ghana</option>
													<option value="107"<?=($gedit['country'] == '107' ? ' selected' : '');?>>Gibraltar</option>
													<option value="108"<?=($gedit['country'] == '108' ? ' selected' : '');?>>Islas Gloriosas</option>
													<option value="109"<?=($gedit['country'] == '109' ? ' selected' : '');?>>Grecia</option>
													<option value="110"<?=($gedit['country'] == '110' ? ' selected' : '');?>>Groenlandia</option>
													<option value="111"<?=($gedit['country'] == '111' ? ' selected' : '');?>>Granada</option>
													<option value="112"<?=($gedit['country'] == '112' ? ' selected' : '');?>>Guadalupe</option>
													<option value="113"<?=($gedit['country'] == '113' ? ' selected' : '');?>>Guam</option>
													<option value="114"<?=($gedit['country'] == '114' ? ' selected' : '');?>>Guernsey</option>
													<option value="115"<?=($gedit['country'] == '115' ? ' selected' : '');?>>Guinea</option>
													<option value="116"<?=($gedit['country'] == '116' ? ' selected' : '');?>>Guinea-Bissau</option>
													<option value="117"<?=($gedit['country'] == '117' ? ' selected' : '');?>>Guyana</option>
													<option value="118"<?=($gedit['country'] == '118' ? ' selected' : '');?>>Hait&iacute;</option>
													<option value="119"<?=($gedit['country'] == '119' ? ' selected' : '');?>>Islas Heard y McDonald Islas</option>
													<option value="120"<?=($gedit['country'] == '120' ? ' selected' : '');?>>Ciudad del Vaticano</option>
													<option value="121"<?=($gedit['country'] == '121' ? ' selected' : '');?>>Hong Kong</option>
													<option value="122"<?=($gedit['country'] == '122' ? ' selected' : '');?>>Howland Island</option>
													<option value="123"<?=($gedit['country'] == '123' ? ' selected' : '');?>>Hungr&iacute;a</option>
													<option value="124"<?=($gedit['country'] == '124' ? ' selected' : '');?>>Islandia</option>
													<option value="125"<?=($gedit['country'] == '125' ? ' selected' : '');?>>India</option>
													<option value="126"<?=($gedit['country'] == '126' ? ' selected' : '');?>>Indonesia</option>
													<option value="127"<?=($gedit['country'] == '127' ? ' selected' : '');?>>Iran</option>
													<option value="128"<?=($gedit['country'] == '128' ? ' selected' : '');?>>Iraq</option>
													<option value="129"<?=($gedit['country'] == '129' ? ' selected' : '');?>>Irlanda</option>
													<option value="130"<?=($gedit['country'] == '130' ? ' selected' : '');?>>Jamaica</option>
													<option value="131"<?=($gedit['country'] == '131' ? ' selected' : '');?>>Isla Jan Mayen</option>
													<option value="132"<?=($gedit['country'] == '132' ? ' selected' : '');?>>Isla Jarvis</option>
													<option value="133"<?=($gedit['country'] == '133' ? ' selected' : '');?>>Bailiazgo de Jersey</option>
													<option value="134"<?=($gedit['country'] == '134' ? ' selected' : '');?>>Atol&oacute;n Johnston</option>
													<option value="135"<?=($gedit['country'] == '135' ? ' selected' : '');?>>Jordan</option>
													<option value="136"<?=($gedit['country'] == '136' ? ' selected' : '');?>>Isla Juan de Nova</option>
													<option value="137"<?=($gedit['country'] == '137' ? ' selected' : '');?>>Kazajist&aacute;n</option>
													<option value="138"<?=($gedit['country'] == '138' ? ' selected' : '');?>>Kenia</option>
													<option value="139"<?=($gedit['country'] == '139' ? ' selected' : '');?>>Arrecife Kingman</option>
													<option value="140"<?=($gedit['country'] == '140' ? ' selected' : '');?>>Kiribati</option>
													<option value="141"<?=($gedit['country'] == '141' ? ' selected' : '');?>>Corea del Norte</option>
													<option value="142"<?=($gedit['country'] == '142' ? ' selected' : '');?>>Corea del Sur</option>
													<option value="143"<?=($gedit['country'] == '143' ? ' selected' : '');?>>Kuwait</option>
													<option value="144"<?=($gedit['country'] == '144' ? ' selected' : '');?>>Kirguist&aacute;n</option>
													<option value="145"<?=($gedit['country'] == '145' ? ' selected' : '');?>>Laos</option>
													<option value="146"<?=($gedit['country'] == '146' ? ' selected' : '');?>>Letonia</option>
													<option value="147"<?=($gedit['country'] == '147' ? ' selected' : '');?>>L&iacute;bano</option>
													<option value="148"<?=($gedit['country'] == '148' ? ' selected' : '');?>>Lesoto</option>
													<option value="149"<?=($gedit['country'] == '149' ? ' selected' : '');?>>Liberia</option>
													<option value="150"<?=($gedit['country'] == '150' ? ' selected' : '');?>>Libia</option>
													<option value="151"<?=($gedit['country'] == '151' ? ' selected' : '');?>>Liechtenstein</option>
													<option value="152"<?=($gedit['country'] == '152' ? ' selected' : '');?>>Lituania</option>
													<option value="153"<?=($gedit['country'] == '153' ? ' selected' : '');?>>Luxemburgo</option>
													<option value="154"<?=($gedit['country'] == '154' ? ' selected' : '');?>>Macao</option>
													<option value="155"<?=($gedit['country'] == '155' ? ' selected' : '');?>>Macedonia</option>
													<option value="156"<?=($gedit['country'] == '156' ? ' selected' : '');?>>Madagascar</option>
													<option value="157"<?=($gedit['country'] == '157' ? ' selected' : '');?>>Malaui</option>
													<option value="158"<?=($gedit['country'] == '158' ? ' selected' : '');?>>Malasia</option>
													<option value="159"<?=($gedit['country'] == '159' ? ' selected' : '');?>>Maldivas</option>
													<option value="160"<?=($gedit['country'] == '160' ? ' selected' : '');?>>Mali</option>
													<option value="161"<?=($gedit['country'] == '161' ? ' selected' : '');?>>Malta</option>
													<option value="162"<?=($gedit['country'] == '162' ? ' selected' : '');?>>Isla de Man</option>
													<option value="163"<?=($gedit['country'] == '163' ? ' selected' : '');?>>Islas Marshall</option>
													<option value="164"<?=($gedit['country'] == '164' ? ' selected' : '');?>>Martinica</option>
													<option value="165"<?=($gedit['country'] == '165' ? ' selected' : '');?>>Mauritania</option>
													<option value="166"<?=($gedit['country'] == '166' ? ' selected' : '');?>>Mauricio</option>
													<option value="167"<?=($gedit['country'] == '167' ? ' selected' : '');?>>Mayotte</option>
													<option value="168"<?=($gedit['country'] == '168' ? ' selected' : '');?>>Estados Federados de Micronesia</option>
													<option value="169"<?=($gedit['country'] == '169' ? ' selected' : '');?>>Islas Midway</option>
													<option value="170"<?=($gedit['country'] == '170' ? ' selected' : '');?>>Rep&uacute;blica de Moldavia</option>
													<option value="171"<?=($gedit['country'] == '171' ? ' selected' : '');?>>M&oacute;naco</option>
													<option value="172"<?=($gedit['country'] == '172' ? ' selected' : '');?>>Mongolia</option>
													<option value="173"<?=($gedit['country'] == '173' ? ' selected' : '');?>>Montenegro</option>
													<option value="174"<?=($gedit['country'] == '174' ? ' selected' : '');?>>Montserrat</option>
													<option value="175"<?=($gedit['country'] == '175' ? ' selected' : '');?>>Marruecos</option>
													<option value="176"<?=($gedit['country'] == '176' ? ' selected' : '');?>>Mozambique</option>
													<option value="177"<?=($gedit['country'] == '177' ? ' selected' : '');?>>Namibia</option>
													<option value="178"<?=($gedit['country'] == '178' ? ' selected' : '');?>>Naur&uacute;</option>
													<option value="179"<?=($gedit['country'] == '179' ? ' selected' : '');?>>Navassa Island</option>
													<option value="180"<?=($gedit['country'] == '180' ? ' selected' : '');?>>Nepal</option>
													<option value="181"<?=($gedit['country'] == '181' ? ' selected' : '');?>>Holanda</option>
													<option value="182"<?=($gedit['country'] == '182' ? ' selected' : '');?>>Antillas Neerlandesas</option>
													<option value="183"<?=($gedit['country'] == '183' ? ' selected' : '');?>>Neutral Zone</option>
													<option value="184"<?=($gedit['country'] == '184' ? ' selected' : '');?>>Nueva Caledonia</option>
													<option value="185"<?=($gedit['country'] == '185' ? ' selected' : '');?>>Nueva Zelanda</option>
													<option value="186"<?=($gedit['country'] == '186' ? ' selected' : '');?>>N&iacute;ger</option>
													<option value="187"<?=($gedit['country'] == '187' ? ' selected' : '');?>>Nigeria</option>
													<option value="188"<?=($gedit['country'] == '188' ? ' selected' : '');?>>Niue</option>
													<option value="189"<?=($gedit['country'] == '189' ? ' selected' : '');?>>Isla Norfolk</option>
													<option value="190"<?=($gedit['country'] == '190' ? ' selected' : '');?>>Islas Marianas del Norte</option>
													<option value="191"<?=($gedit['country'] == '191' ? ' selected' : '');?>>Noruega</option>
													<option value="192"<?=($gedit['country'] == '192' ? ' selected' : '');?>>Om&aacute;n</option>
													<option value="193"<?=($gedit['country'] == '193' ? ' selected' : '');?>>Pakist&aacute;n</option>
													<option value="194"<?=($gedit['country'] == '194' ? ' selected' : '');?>>Palau</option>
													<option value="195"<?=($gedit['country'] == '195' ? ' selected' : '');?>>Atol&oacute;n Palmyra</option>
													<option value="196"<?=($gedit['country'] == '196' ? ' selected' : '');?>>Pap&uacute;a Nueva Guinea</option>
													<option value="197"<?=($gedit['country'] == '197' ? ' selected' : '');?>>Islas Paracel</option>
													<option value="198"<?=($gedit['country'] == '198' ? ' selected' : '');?>>Filipinas</option>
													<option value="199"<?=($gedit['country'] == '199' ? ' selected' : '');?>>Islas Pitcairn</option>
													<option value="200"<?=($gedit['country'] == '200' ? ' selected' : '');?>>Polonia</option>
													<option value="201"<?=($gedit['country'] == '201' ? ' selected' : '');?>>Qatar</option>
													<option value="202"<?=($gedit['country'] == '202' ? ' selected' : '');?>>Reuni&oacute;n</option>
													<option value="203"<?=($gedit['country'] == '203' ? ' selected' : '');?>>Rumania</option>
													<option value="204"<?=($gedit['country'] == '204' ? ' selected' : '');?>>Rusia</option>
													<option value="205"<?=($gedit['country'] == '205' ? ' selected' : '');?>>Ruanda</option>
													<option value="206"<?=($gedit['country'] == '206' ? ' selected' : '');?>>Santa Helena</option>
													<option value="207"<?=($gedit['country'] == '207' ? ' selected' : '');?>>San Crist&oacute;bal y Nieves</option>
													<option value="208"<?=($gedit['country'] == '208' ? ' selected' : '');?>>Santa Luc&iacute;a</option>
													<option value="209"<?=($gedit['country'] == '209' ? ' selected' : '');?>>San Pedro y Miguel&oacute;n</option>
													<option value="210"<?=($gedit['country'] == '210' ? ' selected' : '');?>>San Vicente y las Granadinas</option>
													<option value="211"<?=($gedit['country'] == '211' ? ' selected' : '');?>>Samoa</option>
													<option value="212"<?=($gedit['country'] == '212' ? ' selected' : '');?>>San Marino</option>
													<option value="213"<?=($gedit['country'] == '213' ? ' selected' : '');?>>Santo Tom&eacute; y Pr&iacute;ncipe</option>
													<option value="214"<?=($gedit['country'] == '214' ? ' selected' : '');?>>Arabia Saudita</option>
													<option value="215"<?=($gedit['country'] == '215' ? ' selected' : '');?>>Senegal</option>
													<option value="216"<?=($gedit['country'] == '216' ? ' selected' : '');?>>Serbia</option>
													<option value="217"<?=($gedit['country'] == '217' ? ' selected' : '');?>>Seychelles</option>
													<option value="218"<?=($gedit['country'] == '218' ? ' selected' : '');?>>Sierra Leone</option>
													<option value="219"<?=($gedit['country'] == '219' ? ' selected' : '');?>>Singapur</option>
													<option value="220"<?=($gedit['country'] == '220' ? ' selected' : '');?>>Eslovaquia</option>
													<option value="221"<?=($gedit['country'] == '221' ? ' selected' : '');?>>Eslovenia</option>
													<option value="222"<?=($gedit['country'] == '222' ? ' selected' : '');?>>Islas Salom&oacute;n</option>
													<option value="223"<?=($gedit['country'] == '223' ? ' selected' : '');?>>Somalia</option>
													<option value="224"<?=($gedit['country'] == '224' ? ' selected' : '');?>>Sud&aacute;frica</option>
													<option value="225"<?=($gedit['country'] == '225' ? ' selected' : '');?>>Georgia del Sur e Islas Sandwich del Sur</option>
													<option value="226"<?=($gedit['country'] == '226' ? ' selected' : '');?>>Islas Spratly</option>
													<option value="227"<?=($gedit['country'] == '227' ? ' selected' : '');?>>Sri Lanka</option>
													<option value="228"<?=($gedit['country'] == '228' ? ' selected' : '');?>>Sud&aacute;n</option>
													<option value="229"<?=($gedit['country'] == '229' ? ' selected' : '');?>>Surinam</option>
													<option value="230"<?=($gedit['country'] == '230' ? ' selected' : '');?>>Svalbard</option>
													<option value="231"<?=($gedit['country'] == '231' ? ' selected' : '');?>>Swazilandia</option>
													<option value="232"<?=($gedit['country'] == '232' ? ' selected' : '');?>>Suecia</option>
													<option value="233"<?=($gedit['country'] == '233' ? ' selected' : '');?>>Suiza</option>
													<option value="234"<?=($gedit['country'] == '234' ? ' selected' : '');?>>Rep&uacute;blica &aacute;rabe Siria</option>
													<option value="235"<?=($gedit['country'] == '235' ? ' selected' : '');?>>Taiw&aacute;n</option>
													<option value="236"<?=($gedit['country'] == '236' ? ' selected' : '');?>>Tayikist&aacute;n</option>
													<option value="237"<?=($gedit['country'] == '237' ? ' selected' : '');?>>Rep&uacute;blica Unida de Tanzania</option>
													<option value="238"<?=($gedit['country'] == '238' ? ' selected' : '');?>>Tailandia</option>
													<option value="239"<?=($gedit['country'] == '239' ? ' selected' : '');?>>Togo</option>
													<option value="240"<?=($gedit['country'] == '240' ? ' selected' : '');?>>Tokelau</option>
													<option value="241"<?=($gedit['country'] == '241' ? ' selected' : '');?>>Tonga</option>
													<option value="242"<?=($gedit['country'] == '242' ? ' selected' : '');?>>Trinidad y Tobago</option>
													<option value="243"<?=($gedit['country'] == '243' ? ' selected' : '');?>>Isla Tromelin</option>
													<option value="244"<?=($gedit['country'] == '244' ? ' selected' : '');?>>T&uacute;nez</option>
													<option value="245"<?=($gedit['country'] == '245' ? ' selected' : '');?>>Turqu&iacute;a</option>
													<option value="246"<?=($gedit['country'] == '246' ? ' selected' : '');?>>Turkmenist&aacute;n</option>
													<option value="247"<?=($gedit['country'] == '247' ? ' selected' : '');?>>Islas Turcas y Caicos</option>
													<option value="248"<?=($gedit['country'] == '248' ? ' selected' : '');?>>Tuvalu</option>
													<option value="249"<?=($gedit['country'] == '249' ? ' selected' : '');?>>Uganda</option>
													<option value="250"<?=($gedit['country'] == '250' ? ' selected' : '');?>>Ucrania</option>
													<option value="251"<?=($gedit['country'] == '251' ? ' selected' : '');?>>Emigratos &aacute;rabes Unidos</option>
													<option value="252"<?=($gedit['country'] == '252' ? ' selected' : '');?>>Reino Unido</option>
													<option value="253"<?=($gedit['country'] == '253' ? ' selected' : '');?>>Uzbekist&aacute;n</option>
													<option value="254"<?=($gedit['country'] == '254' ? ' selected' : '');?>>Vanuatu</option>
													<option value="255"<?=($gedit['country'] == '255' ? ' selected' : '');?>>Vietnam</option>
													<option value="256"<?=($gedit['country'] == '256' ? ' selected' : '');?>>Islas V&iacute;rgenes</option>
													<option value="257"<?=($gedit['country'] == '257' ? ' selected' : '');?>>Wake Island</option>
													<option value="258"<?=($gedit['country'] == '258' ? ' selected' : '');?>>Wallis y Futuna</option>
													<option value="259"<?=($gedit['country'] == '259' ? ' selected' : '');?>>S&aacute;hara Occidental</option>
													<option value="260"<?=($gedit['country'] == '260' ? ' selected' : '');?>>Yemen</option>
													<option value="261"<?=($gedit['country'] == '261' ? ' selected' : '');?>>Zambia</option>
													<option value="262"<?=($gedit['country'] == '262' ? ' selected' : '');?>>Zimbabwe</option>
											</select>
				</div>
				<div class="clearBoth"></div>
 
				<div class="dataL">
					<label for="fname">Categoria</label>
					<select class="agregar_categoria" name="categoria" tabindex="5" datatype="select" default="0" dataname="Categoria" onchange="if(this.selectedIndex != 0){groups_categories(this.options[this.selectedIndex].value);}">
                    							<option value="0" selected>Elegir una categor&iacute;a</option>
												<?php
												$query = mysql_query("SELECT id, name FROM `group_categories` WHERE sub = '0' ORDER BY name ASC");
												while($cat = mysql_fetch_array($query)) {
													echo '<option value="'.$cat['id'].'"'.($gedit['cat'] == $cat['id'] ? ' selected' : '').'>'.$cat['name'].'</option>';
												}
												?>
											</select>
				</div>
				<div class="dataR">
					<span class="gif_loading floatR" id="subcategoria" style="top:0px"></span>
					<label for="fname">Sub-Categoria</label>
					<select class="agregar_subcategoria" name="subcategoria" id="subcategoria_input" tabindex="6" datatype="select" default="0" dataname="Subcategoria"<?=(!$gedit ? ' disabled' : '');?>>
						<option value="0" selected>Elegir una subcategor&iacute;a</option>
												<?php
											if($gedit) {
												$query = mysql_query("SELECT id, name FROM `group_categories` WHERE sub = '".$gedit['cat']."' ORDER BY name ASC");
												while($cat = mysql_fetch_array($query)) {
													echo '<option value="'.$cat['id'].'"'.($gedit['subcat'] == $cat['id'] ? ' selected' : '').'>'.$cat['name'].'</option>';
												}
											}
												?>
									</select>
				</div>
				<div class="clearBoth"></div>
 
				<div class="data">
					<label for="uname">Descripcion</label>
					<textarea class="c_input_desc autogrow" style="resize: none;" name="descripcion" tabindex="7" datatype="text" dataname="Descripcion"><?=$gedit['description'];?></textarea>
				</div>
				<div class="data">
					<label for="uname">Tags</label>
					<input class="c_input" name="tags" type="text" value="<?=$gedit['tags'];?>" tabindex="8" datatype="tags" dataname="Tags" />
					<div class="desform">
						Ej: gol, ingleses, Mundial 86, futbol, Maradona, Argentina
					</div>
				</div>
 
				<hr style="clear:both;margin-bottom:15px;margin-top:20px;" class="divider"/>
				
 
				<div class="dataL dataRadio">
					<label for="lname">Acceso</label>
					<div class="postLabel">
						<input name="privada" id="privada_1" type="radio" value="0"<?=($gedit && $gedit['private'] == '0' ? ' checked' : ($gedit ? '' : ' checked'));?> tabindex="9" /><label for="privada_1">Todos</label><br />
						<p class="descRadio">
              Todas las personas que visitan <?=$config['script_name'];?> podr&aacute;n acceder a tu comunidad. (Recomendado)
						</p>
						<input name="privada" id="privada_2" type="radio" value="1"<?=($gedit['private'] == '1' ? ' checked' : '');?> /><label for="privada_2">S&oacute;lo usuarios registrados</label><br />	
            		<p class="descRadio">
                  El acceso a tu comunidad estar&aacute; restringido &uacute;nicamente a los usuarios que no se han registrado en <?=ucfirst($config['script_name2']);?>
    						</p>            
            					</div>
                                <?php if($official) { ?>
                     <label for="wtf">Oficial</label>
					<div class="postLabel">
						<input name="oficial" id="oficial_1" type="radio" value="1"<?=($gedit && $gedit['official'] == '1' ? ' checked' : '');?> tabindex="9" /><label for="oficial_1">Oficial</label><br /><br />
						<input name="oficial" id="oficial_2" type="radio" value="0"<?=($gedit['official'] == '0' || !$gedit ? ' checked' : '');?> /><label for="oficial_2">Normal</label> 
				</div>       
            			<? } ?>
                	</div>
 
 
				<div class="data" style="display:none">
					<label for="lname">Tipo de validaci&oacute;n</label>
					<div class="postLabel">
						<input name="tipo_val" type="radio" value="1" checked /> Autom&aacute;tica<br />
						<input name="tipo_val" type="radio" value="2" tabindex="10" /> Manual
					</div>
				</div>
 
				<div class="dataR dataRadio" id="rango_default">
					<label for="fname">Permisos</label>			
					<div class="postLabel">
						<input name="rango_default" id="permisos_1" type="radio" value="2"<?=($gedit['default_rank'] == '2' || !$gedit ? ' checked' : '');?> tabindex="11" /><label for="permisos_1">Posteador</label><br />
						<p class="descRadio">
              Los usuarios al ingresar en tu comunidad podr&aacute;n comentar y crear temas.
						</p>
						<input name="rango_default" id="permisos_2" type="radio" value="1"<?=($gedit['default_rank'] == '1' ? ' checked' : '');?> /><label for="permisos_2">Comentador</label><br />
						<p class="descRadio">
						 Los usuarios al participar en tu  comunidad s&oacute;lo podr&aacute;n comentar pero no estar&aacute;n habilitados para crear nuevos temas.
						</p>
						<input name="rango_default" id="permisos_3" type="radio" value="0"<?=($gedit['default_rank'] == '0' && $gedit ? ' checked' : '');?> /><label for="permisos_3">Visitante</label><br />
						<p class="descRadio">
              Los usuarios al participar en tu comunidad no podr&aacute;n comentar ni tampoco crear temas.
						</p>
					</div>
					<div style="color:#666;font-weight:normal;margin:5px 0">
					  <strong>Nota:</strong>
					  La opci&oacute;n seleccionada le asignar&aacute; autom&aacute;ticamente el mismo rango a todos los usuarios que ingresan a tu comunidad, sin embargo, podr&aacute;s posteriormente modificarlo para cada uno de los participantes.
          </div>
				</div>
 
				<hr style="clear:both;margin-bottom:15px;margin-top:20px;" class="divider"/>
 
								<div id="buttons">
					<input class="mBtn btnOk" type="submit" tabindex="14" title="<?=($gedit ? 'Editar comunidad' : 'Crear comunidad');?>" value="<?=($gedit ? 'Editar comunidad' : 'Crear comunidad');?>" class="button" name="Enviar" />
								</div>
			</form>
		</div>
	</div>
</div>

 
 
 
</div><div style="clear:both"></div>
<!--fin cuerpocontainer-->
</div>