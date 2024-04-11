<?php
if(!defined('account_define')) { header('Location: /index.php'); }
?>
<iframe name="hit" style="display:none;"></iframe>
<a name="mda"></a>
<div style="display:none;" id="mensajes_div"></div>
<form name="af" method="post" onsubmit="return cp_validate_data(this);return false;" action="/blank.html" target="hit">
					<table width="100%" cellpadding="4">
						<tr>
							<td width="25%" align="right" valign="middle"><b>Contrase&ntilde;a Actual:</b></td>
							<td width="42%"><input type="password" size="30" maxlength="32" name="password" /></td>
						</tr>
						<tr>
							<td width="25%" align="right" valign="middle"><b>Nueva contrase&ntilde;a:</b></td>
							<td width="42%"><input type="password" size="30" maxlength="32" name="password1" /></td>
						</tr>
						<tr>
							<td width="25%" align="right" valign="middle"><b>Confirmaci&oacute;n de nueva contrase&ntilde;a:</b></td>
							<td width="42%"><input type="password" size="30" maxlength="32" name="password2" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td class="color_red">* Todos los campos son obligatorios</td>
						</tr>
            <tr>
              <td colspan="3" align="center"><hr />Al modificar mi contrase&ntilde;a tambi&eacute;n acepto los <a href='/terminos-y-condiciones/' target='_blank'>T&eacute;rminos de uso</a> y la <a href='/privacidad-de-datos/' target='_blank'>pol&iacute;tica de privacidad de datos</a>.</td>
            </tr>
            <tr>
              <td colspan="3" align="center">
    						<input type="submit" class="button" style="font-size:15px" value="Cambiar mi contrase&ntilde;a" title="Cambiar mi contrase&ntilde;a" onclick="document.location.hash = '#mda';">
              </td>
            </tr>
 
					</table>
				</form>