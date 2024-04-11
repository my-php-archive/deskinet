<?php
if(!defined('account_define')) { header('Location: /index.php'); }
?>
<iframe name="hit" style="display:none;"></iframe>
<a name="mda"></a>
<div style="display:none;" id="mensajes_div"></div>
<form name="af" method="post" onsubmit="return as_validate_data(this);return false;" action="/blank.html" target="hit">
<table width="100%" cellpadding="4">
					<tr>
						<td width="23%" align="right"><b>Mi altura:</b></td>
						<td width="40%"><input <?=(!empty($currentuser['height']) ? 'value="'.$currentuser['height'].'"' : '');?>name="altura" type="text" id="altura" size="3" maxlength="3" onkeyup="this.value = this.value.replace('[a-zA-Z]', '');" /> centimetros</td>
						<td width="37%" align="right">Mostrar a:
							<select id="altura_mostrar" name="altura_mostrar">
								<option <?=($currentuser['height_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['height_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['height_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['height_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b>Mi peso:</b></td>
						<td><input <?=(!empty($currentuser['weight']) ? 'value="'.$currentuser['weight'].'"' : '');?>name="peso" type="text" id="peso" size="3" maxlength="3" onkeyup="this.value = this.value.replace('[a-zA-Z]', '');" /> kilos</td>
						<td align="right">Mostrar a:
							<select id="peso_mostrar" name="peso_mostrar">
								<option <?=($currentuser['weight_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['weight_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['weight_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['weight_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td width="23%" align="right"><b>Color de pelo:</b></td>
						<td width="40%">
							<select id="pelo_color" name="pelo_color">
								<option <?=($currentuser['hair_color'] == '0' ? 'selected ' : '');?>value="sr">Sin Respuesta</option>
								<option <?=($currentuser['hair_color'] == '1' ? 'selected ' : '');?>value="negro">Negro</option>
								<option <?=($currentuser['hair_color'] == '2' ? 'selected ' : '');?>value="castano_oscuro">Casta&ntilde;o oscuro</option>
								<option <?=($currentuser['hair_color'] == '3' ? 'selected ' : '');?>value="castano_claro">Casta&ntilde;o claro</option>
								<option <?=($currentuser['hair_color'] == '4' ? 'selected ' : '');?>value="rubio">Rubio</option>
								<option <?=($currentuser['hair_color'] == '5' ? 'selected ' : '');?>value="pelirrojo">Pelirrojo</option>
								<option <?=($currentuser['hair_color'] == '6' ? 'selected ' : '');?>value="gris">Gris</option>
								<option <?=($currentuser['hair_color'] == '7' ? 'selected ' : '');?>value="canoso">Canoso</option>
								<option <?=($currentuser['hair_color'] == '8' ? 'selected ' : '');?>value="tenido">Te&ntilde;ido</option>
								<option <?=($currentuser['hair_color'] == '9' ? 'selected ' : '');?>value="rapado">Rapado</option>
								<option <?=($currentuser['hair_color'] == '10' ? 'selected ' : '');?>value="calvo">Calvo</option>
							</select>
						</td>
						<td width="37%" align="right">Mostrar a:
							<select id="pelo_color_mostrar" name="pelo_color_mostrar">
								<option <?=($currentuser['hair_color_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['hair_color_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['hair_color_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['hair_color_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b>Color de ojos:</b></td>
						<td>
							<select id="ojos_color" name="ojos_color">
								<option <?=($currentuser['eyes_color'] == '0' ? 'selected ' : '');?>value="sr">Sin Respuesta</option>
								<option <?=($currentuser['eyes_color'] == '1' ? 'selected ' : '');?>value="negros">Negros</option>
								<option <?=($currentuser['eyes_color'] == '2' ? 'selected ' : '');?>value="marrones">Marrones</option>
								<option <?=($currentuser['eyes_color'] == '3' ? 'selected ' : '');?>value="celestes">Celestes</option>
								<option <?=($currentuser['eyes_color'] == '4' ? 'selected ' : '');?>value="verdes">Verdes</option>
								<option <?=($currentuser['eyes_color'] == '5' ? 'selected ' : '');?>value="grises">Grises</option>
							</select>
						</td>
						<td align="right">Mostrar a:
							<select id="ojos_color_mostrar" name="ojos_color_mostrar">
								<option <?=($currentuser['eyes_color_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['eyes_color_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['eyes_color_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['eyes_color_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b>Complexi&oacute;n:</b></td>
						<td>
							<select id="fisico" name="fisico">
								<option <?=($currentuser['constitution'] == '0' ? 'selected ' : '');?>value="sr">Sin Respuesta</option>
								<option <?=($currentuser['constitution'] == '1' ? 'selected ' : '');?>value="delgado">Delgado/a</option>
								<option <?=($currentuser['constitution'] == '2' ? 'selected ' : '');?>value="atletico">Atl&eacute;tico</option>
								<option <?=($currentuser['constitution'] == '3' ? 'selected ' : '');?>value="normal">Normal</option>
								<option <?=($currentuser['constitution'] == '4' ? 'selected ' : '');?>value="kilos_de_mas">Algunos kilos de m&aacute;s</option>
								<option <?=($currentuser['constitution'] == '5' ? 'selected ' : '');?>value="corpulento">Corpulento/a</option>
							</select>
						</td>
						<td align="right">Mostrar a:
							<select id="fisico_mostrar" name="fisico_mostrar">
								<option <?=($currentuser['constitution_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['constitution_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['constitution_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['constitution_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><b>Mi dieta es:</b></td>
						<td>
							<select id="dieta" name="dieta">
								<option <?=($currentuser['diet'] == '0' ? 'selected ' : '');?>value="sr">Sin Respuesta</option>
								<option <?=($currentuser['diet'] == '1' ? 'selected ' : '');?>value="vegetariana">Vegetariana</option>
								<option <?=($currentuser['diet'] == '2' ? 'selected ' : '');?>value="lacto_vegetariana">Lacto Vegetariana</option>
								<option <?=($currentuser['diet'] == '3' ? 'selected ' : '');?>value="organica">Org&aacute;nica</option>
								<option <?=($currentuser['diet'] == '4' ? 'selected ' : '');?>value="de_todo">De todo</option>
								<option <?=($currentuser['diet'] == '5' ? 'selected ' : '');?>value="comida_basura">Comida basura</option>
							</select>
						</td>
						<td align="right" valign="top">Mostrar a:
							<select id="dieta_mostrar" name="dieta_mostrar">
								<option <?=($currentuser['diet_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['diet_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['diet_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['diet_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><b>Tengo:</b></td>
						<td>
							<table width="100%" border="0">
								<tr><td><input <?=($currentuser['tattos'] == '1' ? 'checked ' : '');?>type="checkbox" name="tengo_tatuajes" id="tengo_tatuajes">Tatuajes</td></tr>
								<tr><td><input <?=($currentuser['piercings'] == '1' ? 'checked ' : '');?>type="checkbox" name="tengo_piercings" id="tengo_piercings">Piercings</td></tr>
							</table>
						</td>
						<td align="right" valign="top">Mostrar a:
							<select id="tengo_tatuajes_piercings_mostrar" name="tengo_tatuajes_piercings_mostrar">
								<option <?=($currentuser['tattos_piercings_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['tattos_piercings_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['tattos_piercings_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['tattos_piercings_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><b>Fumo:</b></td>
						<td>
							<table width="100%" border="0">
								<tr><td><input <?=($currentuser['smoke'] == '0' ? 'checked ' : '');?>type="radio" name="fumo" id="fumo" value="sr">Sin Respuesta</td></tr>
								<tr><td><input <?=($currentuser['smoke'] == '1' ? 'checked ' : '');?>type="radio" name="fumo" id="fumo" value="no">No</td></tr>
								<tr><td><input <?=($currentuser['smoke'] == '2' ? 'checked ' : '');?>type="radio" name="fumo" id="fumo" value="casualmente">Casualmente</td></tr>
								<tr><td><input <?=($currentuser['smoke'] == '3' ? 'checked ' : '');?>type="radio" name="fumo" id="fumo" value="socialmente">Socialmente</td></tr>
								<tr><td><input <?=($currentuser['smoke'] == '4' ? 'checked ' : '');?>type="radio" name="fumo" id="fumo" value="regularmente">Regularmente</td></tr>
								<tr><td><input <?=($currentuser['smoke'] == '5' ? 'checked ' : '');?>type="radio" name="fumo" id="fumo" value="mucho">Mucho</td></tr>
							</table>
						</td>
						<td align="right" valign="top">Mostrar a:
							<select id="fumo_mostrar" name="fumo_mostrar">
								<option <?=($currentuser['smoke_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['smoke_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['smoke_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['smoke_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><b>Tomo alcohol:</b></td>
						<td>
							<table width="100%" border="0">
								<tr><td><input <?=($currentuser['drink'] == '0' ? 'checked ' : '');?>type="radio" name="tomo_alcohol" id="tomo_alcohol" value="sr">Sin Respuesta</td></tr>
								<tr><td><input <?=($currentuser['drink'] == '1' ? 'checked ' : '');?>type="radio" name="tomo_alcohol" id="tomo_alcohol" value="no">No</td></tr>
								<tr><td><input <?=($currentuser['drink'] == '2' ? 'checked ' : '');?>type="radio" name="tomo_alcohol" id="tomo_alcohol" value="casualmente">Casualmente</td></tr>
								<tr><td><input <?=($currentuser['drink'] == '3' ? 'checked ' : '');?>type="radio" name="tomo_alcohol" id="tomo_alcohol" value="socialmente">Socialmente</td></tr>
								<tr><td><input <?=($currentuser['drink'] == '4' ? 'checked ' : '');?>type="radio" name="tomo_alcohol" id="tomo_alcohol" value="regularmente">Regularmente</td></tr>
								<tr><td><input <?=($currentuser['drink'] == '5' ? 'checked ' : '');?>type="radio" name="tomo_alcohol" id="tomo_alcohol" value="mucho">Mucho</td></tr>
							</table>
						</td>
						<td align="right" valign="top">Mostrar a:
							<select id="tomo_alcohol_mostrar" name="tomo_alcohol_mostrar">
								<option <?=($currentuser['drink_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['drink_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['drink_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['drink_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
          <tr>
            <td colspan="3" align="center">
              <input type="submit" class="button" style="font-size:15px" value="Modificar mi perfil" title="Modificar mi perfil" onclick="document.location.hash = '#mda';" />
            </td>
          </tr>
				</table>
                    </form>