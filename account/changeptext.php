<?php
if(!defined('account_define')) { header('Location: /index.php'); }
?>
<iframe name="hit" style="display:none;"></iframe>
<a name="mda"></a>
<div style="display:none;" id="mensajes_div"></div>
<form name="af" method="post" onsubmit="return cpt_validate_data(this);return false;" action="/blank.html" target="hit">
					<table width="100%" cellpadding="4">
						<tr>
							<td width="25%" align="right" valign="middle"><b>Mensaje personal:</b></td>
							<td width="42%"><input type="text" size="40" maxlength="64" name="ptext" value="<?=$currentuser['personal_text'];?>" /></td>
						</tr>
            <tr>
              <td colspan="3" align="center"><hr />Al modificar mi perfil tambi&eacute;n acepto los <a href='/terminos-y-condiciones/' target='_blank'>T&eacute;rminos de uso</a> y la <a href='/privacidad-de-datos/' target='_blank'>pol&iacute;tica de privacidad de datos</a>.</td>
            </tr>
            <tr>
              <td colspan="3" align="center">
    						<input type="submit" class="button" style="font-size:15px" value="Modificar mi perfil" title="Modificar mi perfil" onclick="document.location.hash = '#mda';">
              </td>
            </tr>
 
					</table>
				</form>