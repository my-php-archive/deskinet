<?php
if(!defined('account_define')) { header('Location: /index.php'); }
?>
<iframe name="hit" style="display:none;"></iframe>
<a name="mda"></a>
<div style="display:none;" id="mensajes_div"></div>
<form name="af" method="post" onsubmit="return op_validate_data(this);return false;" action="/blank.html" target="hit">
				<table width="100%" cellpadding="4">
					<tr>
						<td width="5%" align="right" valign="top"><input <?=($currentuser['show_status'] != '0' ? 'checked ' : '');?>type="checkbox" name="mostrar_estado_checkbox" id="checkbox"></td>
						<td  align="left" valign="top"><b>Mostrar mi estado cuando navego el sitio</b></td>
						<td width="32%" align="right" valign="top">Mostrar a:
							<select id="mostrar_estado" name="mostrar_estado">
								<option <?=($currentuser['show_status'] == '1' ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['show_status'] == '2' ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['show_status'] == '3' ? 'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><input <?=($currentuser['show_search'] == '1' ? 'checked ' : '');?>type="checkbox" name="participar_busquedas" id="checkbox4"></td>
						<td align="left" valign="top"><b>Permitir que los usuarios encuentren mi perfil en las busquedas de usuarios</b></td>
						<td align="right" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td align="right" valign="top"><input <?=($currentuser['newsletter'] == '1' ? 'checked ' : '');?>type="checkbox" name="recibir_boletin_semanal" id="checkbox5"></td>
						<td align="left" valign="top"><b>Recibir el bolet&iacute;n semanal de novedades de <?=$config['script_name'];?> por e-mail</b></td>
						<td align="right" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td align="right" valign="top"><input <?=($currentuser['newsletter_offers'] == '1' ? 'checked ' : '');?>type="checkbox" name="recibir_promociones" id="checkbox6"></td>
						<td align="left" valign="top"><b>Recibir promociones y descuentos por e-mail</b></td>
						<td align="right" valign="top">&nbsp;</td>
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