<?php
if(!defined('account_define')) { header('Location: /index.php'); }
?>
<iframe name="hit" style="display:none;"></iframe>
<a name="mda"></a>
<div style="display:none;" id="mensajes_div"></div>
<form name="af" method="post" onsubmit="return av_validate_data(this);return false;" action="/blank.html" target="hit">
					<table width="100%" cellpadding="4">
						<tr>
							<td width="25%"  align="right" valign="top"><img src="<?=htmlspecialchars($currentuser['avatar']);?>" width="120" height="120" align="left" vspace="4" hspace="4" id="miAvatar" onerror="error_avatar(this);"></td>
							<td width="75%">Escribe la direcci&oacute;n de tu <i>avatar</i>.<br />Ejemplo: <b><?=$config['script_url2'];?>/images/avatar.gif</b><br /><br />
								<input type="text" size="64" maxlength="255" name="avatar" value="<?=$currentuser['avatar'];?>" /> 
								<input type="button" value="Previsualizar" onclick="document.getElementById('miAvatar').src = document.af.avatar.value;">
							</td>
						</tr>
 
        <tr>
          <td colspan="3" align="center"><hr />Al modificar mi avatar tambi&eacute;n acepto los <a href='/terminos-y-condiciones/' target='_blank'>T&eacute;rminos de uso</a> y la <a href='/privacidad-de-datos/' target='_blank'>pol&iacute;tica de privacidad de datos</a>.</td>
        </tr>
        <tr>
          <td colspan="3" align="center"><input type="submit" class="button" style="font-size:15px" value="Modificar mi perfil" title="Modificar mi perfil" onclick="document.location.hash = '#mda';">
          </td>
        </tr>
					</table>
                    </form>