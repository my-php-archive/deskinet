<?php
if(!defined('account_define')) { header('Location: /index.php'); }
?>
<iframe name="hit" style="display:none;"></iframe>
<a name="mda"></a>
<div style="display:none;" id="mensajes_div"></div>
<form name="af" method="post" onsubmit="return up_validate_data(this, ctv);return false;" action="/blank.html" target="hit">
					<table width="100%" cellpadding="4">
						<tr>
						  <td colspan="3" align="center">
						    <br /><b>&iexcl;Puedes completar tu perfil agregando fotos para que los demas usuarios puedan verlas!</b>
						  </td>
						</tr>
						<tr>
							<td width="100%" align="center" valign="top">
                <br />
 
											<span id="mis_imagenes">
                                            <?php
											$photos = explode('*@', $currentuser['images']);
											$count = count($photos);
											if($count != 0) {
												for($i=0;$i<$count;$i++) {
                                           			echo '<input type="text" size="30" maxlength="64" value="'.$photos[$i].'" id="ii'.$i.'" name="image'.$i.'" /> <input name="db'.$i.'" type="button" id="db'.$i.'" value="Eliminar" onclick="delete_image('.$i.');" /><br id="br'.$i.'" />';
												}
											}
											echo '<script type="text/javascript">var photos_index = '.$count.';var ctv = 1;</script>';
											?>
											</span>
											<br />
											<input name="submit" class="button" type="button" value="Agregar una imagen" onclick="add_image();" />
							</td>
						</tr>
            <tr>
              <td colspan="3" align="center"><hr />Al modificar mis im&aacute;genes tambi&eacute;n acepto los <a href='/terminos-y-condiciones/' target='_blank'>T&eacute;rminos de uso</a> y la <a href='/privacidad-de-datos/' target='_blank'>pol&iacute;tica de privacidad de datos</a>.</td>
            </tr>
            <tr>
              <td colspan="3" align="center">
                <input type="submit" class="button"  onclick="ctv = 1;document.location.hash = '#mda';" style="font-size:15px" value="Modificar mi perfil" title="Modificar mi perfil">
                <!--<br />
				<input type="submit" class="button" onclick="ctv = 2;" style="font-size:15px" value="Actualizar fotos con AJAX" title="Actualizar fotos con AJAX" />-->
              </td>
            </tr>
					</table>

				</form>