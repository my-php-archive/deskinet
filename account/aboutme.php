<?php
if(!defined('account_define')) { header('Location: /index.php'); }
?>
<iframe name="hit" style="display:none;"></iframe>
<a name="mda"></a>
<div style="display:none;" id="mensajes_div"></div>
<form name="af" method="post" onsubmit="return am_validate_data(this);return false;" action="/blank.html" target="hit">
				<table width="100%" cellpadding="4">
					<tr>
						<td width="23%"  align="right" valign="top"><b>Me gustar&iacute;a:</b></td>
						<td width="40%">
							<table width="100%" border="0">
								<tr><td><input <?=($currentuser['make_friends'] == '1' ? 'checked ' : '');?>type="checkbox" name="me_gustaria_amigos" id="me_gustaria_1">Hacer Amigos</td></tr>
								<tr><td><input <?=($currentuser['meet_interests'] == '1' ? 'checked ' : '');?>type="checkbox" name="me_gustaria_conocer_gente" id="me_gustaria_2">Conocer gente con mis intereses</td></tr>
								<tr><td><input <?=($currentuser['meet_business'] == '1' ? 'checked ' : '');?>type="checkbox" name="me_gustaria_conocer_gente_negocios" id="me_gustaria_3">Conocer gente para hacer negocios</td></tr>
								<tr><td><input <?=($currentuser['find_mate'] == '1' ? 'checked ' : '');?>type="checkbox" name="me_gustaria_encontrar_pareja" id="me_gustaria_4">Encontrar pareja</td></tr>
								<tr><td><input <?=($currentuser['meet_all'] == '1' ? 'checked ' : '');?>type="checkbox" name="me_gustaria_de_todo" id="me_gustaria_5">De todo</td></tr>
							</table>
						</td>
						<td width="37%" align="right" valign="top">Mostrar a:
							<select id="me_gustaria_mostrar" name="me_gustaria_mostrar">
								<option <?=($currentuser['meet_show'] == '0' ? 'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['meet_show'] == '1' ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['meet_show'] == '2' ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['meet_show'] == '3' ? 'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><b>En el amor estoy:</b></td>
						<td>
							<table width="100%" border="0">
								<tr><td><input <?=($currentuser['love_state'] == '0' ? 'checked ' : '');?>type="radio" name="estado" id="estado" value="sr">Sin Respuesta</td></tr>
								<tr><td><input <?=($currentuser['love_state'] == '1' ? 'checked ' : '');?>type="radio" name="estado" id="estado" value="soltero">Soltero/a</td></tr>
								<tr><td><input <?=($currentuser['love_state'] == '2' ? 'checked ' : '');?>type="radio" name="estado" id="estado" value="novio">De novio/a</td></tr>
								<tr><td><input <?=($currentuser['love_state'] == '3' ? 'checked ' : '');?>type="radio" name="estado" id="estado" value="casado">Casado/a</td></tr>
								<tr><td><input <?=($currentuser['love_state'] == '4' ? 'checked ' : '');?>type="radio" name="estado" id="estado" value="divorciado">Divorciado/a</td></tr>
								<tr><td><input <?=($currentuser['love_state'] == '5' ? 'checked ' : '');?>type="radio" name="estado" id="estado" value="viudo">Viudo/a</td></tr>
								<tr><td><input <?=($currentuser['love_state'] == '6' ? 'checked ' : '');?>type="radio" name="estado" id="estado" value="algo">En algo...</td></tr>
							</table>
						</td>
						<td align="right" valign="top">Mostrar a:
							<select id="estado_mostrar" name="estado_mostrar">
								<option <?=($currentuser['love_show'] == '0' ? 'checked ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['love_show'] == '1' ? 'checked ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['love_show'] == '2' ? 'checked ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['love_show'] == '3' ? 'checked ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td width="23%" align="right" valign="top"><b>Hijos:</b></td>
						<td width="40%">
							<table width="100%" border="0">
								<tr><td><input <?=($currentuser['children'] == '0' ? 'checked ' : '');?>type="radio" name="hijos" id="hijos" value="sr">Sin Respuesta</td></tr>
								<tr><td><input <?=($currentuser['children'] == '1' ? 'checked ' : '');?>type="radio" name="hijos" id="hijos" value="no">No tengo</td></tr>
								<tr><td><input <?=($currentuser['children'] == '2' ? 'checked ' : '');?>type="radio" name="hijos" id="hijos" value="algun_dia">Alg&uacute;n d&iacute;a</td></tr>
								<tr><td><input <?=($currentuser['children'] == '3' ? 'checked ' : '');?>type="radio" name="hijos" id="hijos" value="no_quiero">No son lo m&iacute;o</td></tr>
								<tr><td><input <?=($currentuser['children'] == '4' ? 'checked ' : '');?>type="radio" name="hijos" id="hijos" value="viven_conmigo">Tengo, vivo con ellos</td></tr>
								<tr><td><input <?=($currentuser['children'] == '5' ? 'checked ' : '');?>type="radio" name="hijos" id="hijos" value="no_viven_conmigo">Tengo, no vivo con ellos</td></tr>
							</table>
						</td>
						<td width="37%" align="right" valign="top">Mostrar a:
							<select id="hijos_mostrar" name="hijos_mostrar">
								<option <?=($currentuser['children_show'] == '0' ? 'checked ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['children_show'] == '1' ? 'checked ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['children_show'] == '2' ? 'checked ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['children_show'] == '3' ? 'checked ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><b>Vivo con:</b></td>
						<td>
							<table width="100%" border="0">
								<tr><td><input <?=($currentuser['live_with'] == '0' ? 'checked ' : '');?>type="radio" name="vivo" id="vivo" value="sr">Sin Respuesta</td></tr>
								<tr><td><input <?=($currentuser['live_with'] == '1' ? 'checked ' : '');?>type="radio" name="vivo" id="vivo" value="solo">S&oacute;lo</td></tr>
								<tr><td><input <?=($currentuser['live_with'] == '2' ? 'checked ' : '');?>type="radio" name="vivo" id="vivo" value="padres">Con mis padres</td></tr>
								<tr><td><input <?=($currentuser['live_with'] == '3' ? 'checked ' : '');?>type="radio" name="vivo" id="vivo" value="pareja">Con mi pareja</td></tr>
								<tr><td><input <?=($currentuser['live_with'] == '4' ? 'checked ' : '');?>type="radio" name="vivo" id="vivo" value="amigos">Con amigos</td></tr>
								<tr><td><input <?=($currentuser['live_with'] == '5' ? 'checked ' : '');?>type="radio" name="vivo" id="vivo" value="otro">Otro</td></tr>
							</table>
						</td>
						<td align="right" valign="top">Mostrar a:
							<select id="vivo_mostrar" name="vivo_mostrar">
								<option <?=($currentuser['live_show'] == '0' ? 'checked ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['live_show'] == '1' ? 'checked ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['live_show'] == '2' ? 'checked ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['live_show'] == '3' ? 'checked ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
        <tr>
          <td colspan="3" align="center"><hr />Al modificar mi perfil tambi&eacute;n acepto los <a href='/terminos-y-condiciones/' target='_blank'>T&eacute;rminos de uso</a> y la <a href='/privacidad-de-datos/' target='_blank'>pol&iacute;tica de privacidad de datos</a>.</td>
        </tr>
        <tr>
          <td colspan="3" align="center">
            <input type="submit" class="button" style="font-size:15px" value="Modificar mi perfil" title="Modificar mi perfil" onclick="document.location.hash = '#mda';" />
          </td>
        </tr>
			</table>
                    </form>