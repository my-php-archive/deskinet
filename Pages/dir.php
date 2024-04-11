<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
if(!isLogged()) { die(error('OOPS!', 'Logeate para ver esta secci&oacute;n', array('Registrarme', 'Logearme'), array('/registro/', 'javascript:open_login_box();document.location.hash = "#";'))); }

$countries = array(0 => 'Argentina', 1 => 'Bolivia', 2 => 'Brasil', 3 => 'Chile', 4 => 'Colombia', 5 => 'Costa Rica', 6 => 'Cuba', 7 => 'República Checa', 8 => 'Ecuador', 9 => 'El Salvador', 10 => 'España', 11 => 'Guatemala', 12 => 'Guinea Ecuatorial', 13 => 'Honduras', 14 => 'Israel', 15 => 'Italia', 16 => 'Japón', 17 => 'México', 18 => 'Nicaragua', 19 => 'Panamá', 20 => 'Paraguay', 21 => 'Perú', 22 => 'Portugal', 23 => 'Puerto Rico', 24 => 'República Dominicana', 25 => 'Estados Unidos', 26 => 'Uruguay', 27 => 'Venezuela', 28 => '----', 29 => 'Afghanistán', 30 => 'Albania', 31 => 'Argelia', 32 => 'Samoa Americana', 33 => 'Andorra', 34 => 'Angola', 35 => 'Anguila', 36 => 'Antártida', 37 => 'Antigua y Barbuda', 38 => 'Armenia', 39 => 'Aruba', 40 => 'Islas Ashmore y Cartier', 41 => 'Australia', 42 => 'Austria', 43 => 'Azerbaiyán', 44 => 'Las Bahamas', 45 => 'Bahréin', 46 => 'Isla Baker', 47 => 'Bangladesh', 48 => 'Barbados', 49 => 'Bassas da India', 50 => 'Bielorrusia', 51 => 'Bélgica', 52 => 'Belice', 53 => 'Benín', 54 => 'Bermuda', 55 => 'Bután', 56 => 'Bosnia y Herzegovina', 57 => 'Botsuana', 58 => 'Isla Bouvet', 59 => 'Territorio Británico del Océano índico', 60 => 'Islas Vírgenes Británicas', 61 => 'Brunéi', 62 => 'Bulgaria', 63 => 'Burkina Faso', 64 => 'Birmania', 65 => 'Burundi', 66 => 'Camboya', 67 => 'Camerún', 68 => 'Canadá', 69 => 'Cabo Verde', 70 => 'Islas Caimán', 71 => 'República Centroafricana', 72 => 'Chad', 73 => 'China', 74 => 'Isla de Navidad', 75 => 'Isla de la Pasión', 76 => 'Islas Cocos', 77 => 'Comoros', 78 => 'República Democrática del Congo', 79 => 'República del Congo', 80 => ' Islas Cook', 81 => 'Coral Sea Islands', 82 => 'Costa de Marfil', 83 => 'Croacia', 84 => 'Chipre', 85 => 'Dinamarca', 86 => 'Yibuti', 87 => 'Dominica', 88 => 'Timor Oriental', 89 => 'Egipto', 90 => 'Eritrea', 91 => 'Estonia', 92 => 'Etiopía', 93 => 'Isla Europa', 94 => 'Islas Malvinas', 95 => 'Islas Feroe', 96 => 'Fiyi', 97 => 'Finlandia', 98 => 'Francia', 99 => 'Guayana Francesa', 100 => 'Polinesia Francesa', 101 => 'Tierras australes y antárticas francesas', 102 => 'Gabón', 103 => 'Gambia', 104 => 'Georgia', 105 => 'Alemania', 106 => 'Ghana', 107 => 'Gibraltar', 108 => 'Islas Gloriosas', 109 => 'Grecia', 110 => 'Groenlandia', 111 => 'Granada', 112 => 'Guadalupe', 113 => 'Guam', 114 => 'Guernsey', 115 => 'Guinea', 116 => 'Guinea-Bissau', 117 => 'Guyana', 118 => 'Haití', 119 => 'Islas Heard y McDonald Islas', 120 => 'Ciudad del Vaticano', 121 => 'Hong Kong', 122 => 'Howland Island', 123 => 'Hungría', 124 => 'Islandia', 125 => 'India', 126 => 'Indonesia', 127 => 'Iran', 128 => 'Iraq', 129 => 'Irlanda', 130 => 'Jamaica', 131 => 'Isla Jan Mayen', 132 => 'Isla Jarvis', 133 => 'Bailiazgo de Jersey', 134 => 'Atolón Johnston', 135 => 'Jordan', 136 => 'Isla Juan de Nova', 137 => 'Kazajistán', 138 => 'Kenia', 139 => 'Arrecife Kingman', 140 => 'Kiribati', 141 => 'Corea del Norte', 142 => 'Corea del Sur', 143 => 'Kuwait', 144 => 'Kirguistán', 145 => 'Laos', 146 => 'Letonia', 147 => 'Líbano', 148 => 'Lesoto', 149 => 'Liberia', 150 => 'Libia', 151 => 'Liechtenstein', 152 => 'Lituania', 153 => 'Luxemburgo', 154 => 'Macao', 155 => 'Macedonia', 156 => 'Madagascar', 157 => 'Malaui', 158 => 'Malasia', 159 => 'Maldivas', 160 => 'Mali', 161 => 'Malta', 162 => 'Isla de Man', 163 => 'Islas Marshall', 164 => 'Martinica', 165 => 'Mauritania', 166 => 'Mauricio', 167 => 'Mayotte', 168 => 'Estados Federados de Micronesia', 169 => 'Islas Midway', 170 => 'República de Moldavia', 171 => 'Mónaco', 172 => 'Mongolia', 173 => 'Montenegro', 174 => 'Montserrat', 175 => 'Marruecos', 176 => 'Mozambique', 177 => 'Namibia', 178 => 'Naurú', 179 => 'Navassa Island', 180 => 'Nepal', 181 => 'Holanda', 182 => 'Antillas Neerlandesas', 183 => 'Neutral Zone', 184 => 'Nueva Caledonia', 185 => 'Nueva Zelanda', 186 => 'Níger', 187 => 'Nigeria', 188 => 'Niue', 189 => 'Isla Norfolk', 190 => 'Islas Marianas del Norte', 191 => 'Noruega', 192 => 'Omán', 193 => 'Pakistán', 194 => 'Palau', 195 => 'Atolón Palmyra', 196 => 'Papúa Nueva Guinea', 197 => 'Islas Paracel', 198 => 'Filipinas', 199 => 'Islas Pitcairn', 200 => 'Polonia', 201 => 'Qatar', 202 => 'Reunión', 203 => 'Rumania', 204 => 'Rusia', 205 => 'Ruanda', 206 => 'Santa Helena', 207 => 'San Cristóbal y Nieves', 208 => 'Santa Lucía', 209 => 'San Pedro y Miguelón', 210 => 'San Vicente y las Granadinas', 211 => 'Samoa', 212 => 'San Marino', 213 => 'Santo Tomé y Príncipe', 214 => 'Arabia Saudita', 215 => 'Senegal', 216 => 'Serbia', 217 => 'Seychelles', 218 => 'Sierra Leone', 219 => 'Singapur', 220 => 'Eslovaquia', 221 => 'Eslovenia', 222 => 'Islas Salomón', 223 => 'Somalia', 224 => 'Sudáfrica', 225 => 'Georgia del Sur e Islas Sandwich del Sur', 226 => 'Islas Spratly', 227 => 'Sri Lanka', 228 => 'Sudán', 229 => 'Surinam', 230 => 'Svalbard', 231 => 'Swazilandia', 232 => 'Suecia', 233 => 'Suiza', 234 => 'República árabe Siria', 235 => 'Taiwán', 236 => 'Tayikistán', 237 => 'República Unida de Tanzania', 238 => 'Tailandia', 239 => 'Togo', 240 => 'Tokelau', 241 => 'Tonga', 242 => 'Trinidad y Tobago', 243 => 'Isla Tromelin', 244 => 'Túnez', 245 => 'Turquía', 246 => 'Turkmenistán', 247 => 'Islas Turcas y Caicos', 248 => 'Tuvalu', 249 => 'Uganda', 250 => 'Ucrania', 251 => 'Emigratos árabes Unidos', 252 => 'Reino Unido', 253 => 'Uzbekistán', 254 => 'Vanuatu', 255 => 'Vietnam', 256 => 'Islas Vírgenes', 257 => 'Wake Island', 258 => 'Wallis y Futuna', 259 => 'Sáhara Occidental', 260 => 'Yemen', 261 => 'Zambia', 262 => 'Zimbabwe', 999 => 'Internacional');

// pais
$_GET['country'] = str_replace(array('%C3%B1', '%C3%A1', '%C3%A9', '%C3%AD', '%C3%B3', '%C3%BA', '+'), array('ñ', 'á', 'é', 'í', 'ó', 'ú', ' '), urlencode($_GET['country']));

if(!$_GET['country']) $_GET['country'] = 'Internacional';

list($country) = array_keys($countries, $_GET['country']);

if($_GET['cat'] && mysql_num_rows($query = mysql_query("SELECT * FROM `group_categories` WHERE urlname = '".mysql_clean($_GET['cat'])."' && sub = '0'"))) { $cat = mysql_fetch_assoc($query); }
if($_GET['subcat'] && $cat && mysql_num_rows($query = mysql_query("SELECT * FROM `group_categories` WHERE urlname = '".mysql_clean($_GET['subcat'])."' && sub = '".$cat['id']."'"))) {
	$subcat = mysql_fetch_assoc($query);
	$pages = ceil(mysql_num_rows(mysql_query("SELECT id FROM `groups` WHERE subcat = '".$subcat['id']."'"))/20);
	if($pages == 0) {
		$lS = 0;
		$lE = 1;
	} else {
		settype($_GET['p'], 'int');
		if(!$_GET['p'] || $_GET['p'] < 1) { $_GET['p'] = 1; }
		if($_GET['p'] > $pages) { $_GET['p'] = $pages; }
		$lS = $_GET['p']-1;
		$lE = $lS+20;
	}
}
?>
<div id="cuerpocontainer">
<div class="comunidades">
<div class="directorio-c">
<h1>Directorio de Comunidades</h1>
<div class="search-c">
	<div class="box-search">
	<form action="/comunidades/buscador/" method="GET">
		<input class="lst value" type="text" title="Search" value="Buscar en comunidades" maxlength="2048" size="41" name="q" autocomplete="off" onfocus="if(this.value=='Buscar en comunidades'){this.value='';}" onblur="if(this.value==''){this.value='Buscar en comunidades';}" />&nbsp;&nbsp;&nbsp;<input class="mBtn btnOk" type="submit" value="Buscar" />
    </form>
	</div>
</div>
<div style="margin-bottom:20px">
<div class="breadcrump">
<ul>
<li class="first"><a title="Comunidades" href="/comunidades/">Comunidades</a></li><li><a title="Comunidades" href="/comunidades/dir/">Directorio</a></li><li><?=($cat ? '<a title="'.$_GET['country'].'" href="/comunidades/'.$_GET['country'].'/">'.$_GET['country'].'</a>' : $_GET['country']);?></li><? if($cat) { echo '<li>'.($subcat ? '<a title="'.$cat['name'].'" href="/comunidades/'.$_GET['country'].'/'.$cat['urlname'].'/">'.$cat['name'].'</a>' : $cat['name']).'</li>'; } if($subcat) { echo '<li><a title="'.$subcat['name'].'" href="/comunidades/'.$_GET['country'].'/'.$cat['urlname'].'/'.$subcat['urlname'].'/">'.$subcat['name'].'</a></li>'; if($pages != 0) { echo '<li>P&aacute;gina '.$_GET['p'].'</li>'; } } ?><li class="last"></li>
</ul>
</div>
<div class="floatL content-box">
<?php
if(!$cat) {
	$query = mysql_query("SELECT * FROM `group_categories` WHERE sub = '0' ORDER BY name ASC");
	while($cat = mysql_fetch_assoc($query)) {
		echo '<div style="float:left; width:45%; margin-right:10px">
<h3><a href="/comunidades/dir/'.$_GET['country'].'/'.$cat['urlname'].'/">'.$cat['name'].'</a> <span style="font-size:18px;">('.mysql_num_rows(mysql_query("SELECT id FROM groups WHERE".($country != '999' ? " country = '".$country."' &&" : '')." cat = '".$cat['id']."'")).')</span></h3>';
		$q = mysql_query("SELECT c.* FROM group_categories AS c, groups AS g WHERE c.sub = '".$cat['id']."' && g.subcat = c.id GROUP BY c.id ORDER BY COUNT(g.id) DESC LIMIT 3") or die(mysql_error());
		$sc = '';
		while($subcat = mysql_fetch_assoc($q)) {
			$sc .= ', <a href="/comunidades/dir/'.$_GET['country'].'/'.$cat['urlname'].'/'.$subcat['urlname'].'">'.$subcat['name'].'</a>';
		}
		echo substr($sc, 2).'</div>';
	}
} elseif(!$subcat) {
	$query = mysql_query("SELECT * FROM `group_categories` WHERE sub = '".$cat['id']."' ORDER BY name ASC");
	while($subcat = mysql_fetch_assoc($query)) {
		echo '<div style="float:left; width:45%; margin-right:10px">
<h3><a href="/comunidades/dir/'.$_GET['country'].'/'.$cat['urlname'].'/'.$subcat['urlname'].'">'.$subcat['name'].'</a> <span style="font-size:18px;">('.mysql_num_rows(mysql_query("SELECT id FROM groups WHERE".($country != '999' ? " g.country = '".$country."' &&" : '')." subcat = '".$subcat['id']."'")).')</span></h3></div>';
	}
} else {
	$query = mysql_query("SELECT * FROM `groups` WHERE subcat = '".$subcat['id']."' ORDER BY time ASC LIMIT ".$lS.",".$lE) or die(mysql_error());
	if(mysql_num_rows($query)) {
		while($group = mysql_fetch_assoc($query)) {
			echo '<div class="list-com-dir">
	<img src="'.$group['avatar'].'" width="75" height="75" onerror="error_avatar(this);" />
	<div class="data-list-com">
		<h3><a href="/comunidades/'.$group['urlname'].'/">'.htmlspecialchars($group['name']).'</a> (Miembros: '.$group['members'].' - Temas: '.$group['posts'].')</h3>
		<p>'.$group['description'].'</p>
	</div>
	<div class="clearfix"></div>
</div>';
		}
		if($pages > 1) {
			echo '<div class="dir-pag">';
  			if($_GET['p'] != 1) { echo '<a class="floatL" href="/comunidades/dir/'.$_GET['country'].'/'.$cat['urlname'].'/'.$subcat['urlname'].'/'.($_GET['p']-1).'">&laquo; Anterior</a>'; }
   	 		if($_GET['p'] != $pages) { echo '<a class="floatR" href="/comunidades/dir/'.$_GET['country'].'/'.$cat['urlname'].'/'.$subcat['urlname'].'/'.($_GET['p']+1).'">Siguiente &raquo;</a>'; }
			echo '<div class="clearfix"></div>
            		</div>';
		}
	} else {
		echo '<div class="emptyData">No hay comunidades en esta categoria</div>';
	}
}
?>
                        </div>
                        <script type="text/javascript">
						$(document).ready(function() {
							var location_box_more = false;
    						$('a.location-box-more').click(function(){
       		 					if(location_box_more) {
            						$('div.location-box ul').css('height', '170px');
            						$(this).html("Ver m&aacute;s");
            						location_box_more = false;
       							} else {
            						$('div.location-box ul').css('height', '170%');
            						$(this).html("Ver menos");
            						location_box_more = true;
        						}
    						});
						});
						</script>
            <div class="floatR location-box">
        <h2><span>Comunidades por pa&iacute;s</span></h2>
        <ul>
                <li class="first-child"><a href="/comunidades/dir/Internacional/">Todos los pa&iacute;ses</a></li>
            <?php
				$query = mysql_query("SELECT DISTINCT country, COUNT(country) AS count FROM `groups` GROUP BY country ORDER BY count DESC");
				while(list($country, $count) = mysql_fetch_row($query)) {
					echo '<li><a href="/comunidades/dir/'.$countries[((int) $country)].'/">'.utf8_encode($countries[((int) $country)]).'</a><span>'.$count.'</span></li>';
				}
			?>
        </ul>
               	 <a class="location-box-more">Ver m&aacute;s</a>
       	     </div>
    <div class="clearfix"></div>
</div>
</div>
 
 
</div>
<div style="clear:both"></div>
</div>