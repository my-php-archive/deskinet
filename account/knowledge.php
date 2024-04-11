<?php
if(!defined('account_define')) { header('Location: /index.php'); }
?>
<iframe name="hit" style="display:none;"></iframe>
<a name="mda"></a>
<div style="display:none;" id="mensajes_div"></div>
<form name="af" method="post" onsubmit="return kn_validate_data(this);return false;" action="/blank.html" target="hit">
				<table width="100%" cellpadding="4">
					<tr>
						<td width="23%"  align="right"><b>Estudios:</b></td>
						<td width="40%">
							<select id="estudios" name="estudios">
								<option <?=($currentuser['studies'] == '0' ?  'selected ' : '');?>value="sr">Sin Respuesta</option>
								<option <?=($currentuser['studies'] == '1' ?  'selected ' : '');?>value="sin">Sin Estudios</option>
								<option <?=($currentuser['studies'] == '2' ?  'selected ' : '');?>value="pri">Primario completo</option>
								<option <?=($currentuser['studies'] == '3' ?  'selected ' : '');?>value="sec_curso">Secundario en curso</option>
								<option <?=($currentuser['studies'] == '4' ?  'selected ' : '');?>value="sec_completo">Secundario completo</option>
								<option <?=($currentuser['studies'] == '5' ?  'selected ' : '');?>value="ter_curso">Terciario en curso</option>
								<option <?=($currentuser['studies'] == '6' ?  'selected ' : '');?>value="ter_completo">Terciario completo</option>
								<option <?=($currentuser['studies'] == '7' ?  'selected ' : '');?>value="univ_curso">Universitario en curso</option>
								<option <?=($currentuser['studies'] == '8' ?  'selected ' : '');?>value="univ_completo">Universitario completo</option>
								<option <?=($currentuser['studies'] == '9' ?  'selected ' : '');?>value="post_curso">Post-grado en curso</option>
								<option <?=($currentuser['studies'] == '10' ?  'selected ' : '');?>value="post_completo">Post-grado completo</option>
							</select>
						</td>
						<td width="37%" align="right">Mostrar a:
							<select id="estudios_mostrar" name="estudios_mostrar">
								<option <?=($currentuser['studies_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['studies_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['studies_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['studies_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><b>Idiomas:</b></td>
						<td>
							<table width="100%" border="0">
								<tr>
									<td>Castellano</td>
									<td>
										<select name="idioma_castellano" id="idioma_castellano">
											<option <?=($currentuser['language_spanish'] == '0' ? 'selected ' : '');?>value="sr">Sin Respuesta</option>
											<option <?=($currentuser['language_spanish'] == '1' ? 'selected ' : '');?>value="basico">B&aacute;sico</option>
											<option <?=($currentuser['language_spanish'] == '2' ? 'selected ' : '');?>value="intermedio">Intermedio</option>
											<option <?=($currentuser['language_spanish'] == '3' ? 'selected ' : '');?>value="fluido">Fluido</option>
											<option <?=($currentuser['language_spanish'] == '4' ? 'selected ' : '');?>value="nativo">Nativo</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Ingl&eacute;s</td>
									<td>
										<select name="idioma_ingles" id="idioma_ingles">
											<option <?=($currentuser['language_english'] == '0' ? 'selected ' : '');?>value="sr">Sin Respuesta</option>
											<option <?=($currentuser['language_english'] == '1' ? 'selected ' : '');?>value="basico">B&aacute;sico</option>
											<option <?=($currentuser['language_english'] == '2' ? 'selected ' : '');?>value="intermedio">Intermedio</option>
											<option <?=($currentuser['language_english'] == '3' ? 'selected ' : '');?>value="fluido">Fluido</option>
											<option <?=($currentuser['language_english'] == '4' ? 'selected ' : '');?>value="nativo">Nativo</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Portugu&eacute;s</td>
									<td>
										<select name="idioma_portugues" id="idioma_portugues">
											<option <?=($currentuser['language_portuguese'] == '0' ? 'selected ' : '');?>value="sr">Sin Respuesta</option>
											<option <?=($currentuser['language_portuguese'] == '1' ? 'selected ' : '');?>value="basico">B&aacute;sico</option>
											<option <?=($currentuser['language_portuguese'] == '2' ? 'selected ' : '');?>value="intermedio">Intermedio</option>
											<option <?=($currentuser['language_portuguese'] == '3' ? 'selected ' : '');?>value="fluido">Fluido</option>
											<option <?=($currentuser['language_portuguese'] == '4' ? 'selected ' : '');?>value="nativo">Nativo</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Franc&eacute;s</td>
									<td>
										<select name="idioma_frances" id="idioma_frances">
											<option <?=($currentuser['language_french'] == '0' ? 'selected ' : '');?>value="sr">Sin Respuesta</option>
											<option <?=($currentuser['language_french'] == '1' ? 'selected ' : '');?>value="basico">B&aacute;sico</option>
											<option <?=($currentuser['language_french'] == '2' ? 'selected ' : '');?>value="intermedio">Intermedio</option>
											<option <?=($currentuser['language_french'] == '3' ? 'selected ' : '');?>value="fluido">Fluido</option>
											<option <?=($currentuser['language_french'] == '4' ? 'selected ' : '');?>value="nativo">Nativo</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Italiano</td>
									<td>
										<select name="idioma_italiano" id="idioma_italiano">
											<option <?=($currentuser['language_italian'] == '0' ? 'selected ' : '');?>value="sr">Sin Respuesta</option>
											<option <?=($currentuser['language_italian'] == '1' ? 'selected ' : '');?>value="basico">B&aacute;sico</option>
											<option <?=($currentuser['language_italian'] == '2' ? 'selected ' : '');?>value="intermedio">Intermedio</option>
											<option <?=($currentuser['language_italian'] == '3' ? 'selected ' : '');?>value="fluido">Fluido</option>
											<option <?=($currentuser['language_italian'] == '4' ? 'selected ' : '');?>value="nativo">Nativo</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Alem&aacute;n</td>
									<td>
										<select name="idioma_aleman" id="idioma_aleman">
											<option <?=($currentuser['language_german'] == '0' ? 'selected ' : '');?>value="sr">Sin Respuesta</option>
											<option <?=($currentuser['language_german'] == '1' ? 'selected ' : '');?>value="basico">B&aacute;sico</option>
											<option <?=($currentuser['language_german'] == '2' ? 'selected ' : '');?>value="intermedio">Intermedio</option>
											<option <?=($currentuser['language_german'] == '3' ? 'selected ' : '');?>value="fluido">Fluido</option>
											<option <?=($currentuser['language_german'] == '4' ? 'selected ' : '');?>value="nativo">Nativo</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Otro</td>
									<td>
										<select name="idioma_otro" id="idioma_otro">
											<option <?=($currentuser['language_other'] == '0' ? 'selected ' : '');?>value="sr">Sin Respuesta</option>
											<option <?=($currentuser['language_other'] == '1' ? 'selected ' : '');?>value="basico">B&aacute;sico</option>
											<option <?=($currentuser['language_other'] == '2' ? 'selected ' : '');?>value="intermedio">Intermedio</option>
											<option <?=($currentuser['language_other'] == '3' ? 'selected ' : '');?>value="fluido">Fluido</option>
											<option <?=($currentuser['language_other'] == '4' ? 'selected ' : '');?>value="nativo">Nativo</option>
										</select>
									</td>
								</tr>
							</table>
						</td>
						<td align="right" valign="top">Mostrar a:
							<select id="idiomas_mostrar" name="idioma_mostrar">
								<option <?=($currentuser['languages_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['languages_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['languages_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['languages_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td width="23%" align="right"><b>Profesi&oacute;n:</b></td>
						<td width="40%"><input type="text" size="30" maxlength="32" name="profesion" id="profesion"<?=(!empty($currentuser['work']) ? 'value="'.$currentuser['work'].'"' : '');?> /></td>
						<td width="37%" align="right">Mostrar a:
							<select id="profesion_mostrar" name="profesion_mostrar">
								<option <?=($currentuser['work_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['work_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['work_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['work_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b>Empresa:</b></td>
						<td><input type="text" size="30" maxlength="32" name="empresa" id="empresa"<?=(!empty($currentuser['company']) ? 'value="'.$currentuser['company'].'"' : '');?> /></td>
						<td align="right">Mostrar a:
							<select id="empresa_mostrar" name="empresa_mostrar">
								<option <?=($currentuser['company_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['company_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['company_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['company_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b>Sector:</b></td>
						<td>
							<select id="sector" name="sector">
								<?=str_replace('<option value="'.$currentuser['work_sector'].'">', '<option selected value="'.$currentuser['work_sector'].'">', '<option value="0">Sin Respuesta</option>
								<option value="1">Abastecimiento</option>
								<option value="2">Administraci&oacute;n</option>
								<option value="3">Apoderado Aduanal</option>
								<option value="4">Asesor&iacute;a en Comercio Exterior</option>
								<option value="5">Asesor&iacute;a Legal Internacional</option>
								<option value="6">Asistente de Tr&aacute;fico</option>
								<option value="7">Auditor&iacute;a</option>
								<option value="8">Calidad</option>
								<option value="9">Call Center</option>
								<option value="10">Capacitaci&oacute;n Comercio Exterior</option>
								<option value="11">Comercial</option>
								<option value="12">Comercio Exterior</option>
								<option value="13">Compras</option>
								<option value="14">Compras Internacionales/Importaci&oacute;n</option>
								<option value="15">Comunicaci&oacute;n Social</option>
								<option value="16">Comunicaciones Externas</option>
								<option value="17">Comunicaciones Internas</option>
								<option value="18">Consultor&iacute;a</option>
								<option value="19">Consultor&iacute;as Comercio Exterior</option>
								<option value="20">Contabilidad</option>
								<option value="21">Control de Gesti&oacute;n</option>
								<option value="22">Creatividad</option>
								<option value="23">Dise&ntilde;o</option>
								<option value="24">Distribuci&oacute;n</option>
								<option value="25">E-commerce</option>
								<option value="26">Educaci&oacute;n</option>
								<option value="27">Finanzas</option>
								<option value="28">Finanzas Internacionales</option>
								<option value="29">Gerencia / Direcci&oacute;n General</option>
								<option value="30">Impuestos</option>
								<option value="31">Ingenier&iacute;a</option>
								<option value="32">Internet</option>
								<option value="33">Investigaci&oacute;n y Desarrollo</option>
								<option value="34">J&oacute;venes Profesionales</option>
								<option value="35">Legal</option>
								<option value="36">Log&iacute;stica</option>
								<option value="37">Mantenimiento</option>
								<option value="38">Marketing</option>
								<option value="39">Medio Ambiente</option>
								<option value="40">Mercadotecnia Internacional</option>
								<option value="41">Multimedia</option>
								<option value="42">Otra</option>
								<option value="43">Pasant&iacute;as</option>
								<option value="44">Periodismo</option>
								<option value="45">Planeamiento</option>
								<option value="46">Producci&oacute;n</option>
								<option value="47">Producci&oacute;n e Ingenier&iacute;a</option>
								<option value="48">Recursos Humanos</option>
								<option value="49">Relaciones Institucionales / P&uacute;blicas</option>
								<option value="50">Salud</option>
								<option value="51">Seguridad Industrial</option>
								<option value="52">Servicios</option>
								<option value="53">Soporte T&eacute;cnico</option>
								<option value="54">Tecnolog&iacute;a</option>
								<option value="55">Tecnolog&iacute;as de la Informaci&oacute;n</option>
								<option value="56">Telecomunicaciones</option>
								<option value="57">Telemarketing</option>
								<option value="58">Traducci&oacute;n</option>
								<option value="59">Transporte</option>
								<option value="60">Ventas</option>
								<option value="61">Ventas Internacionales/Exportaci&oacute;n</option>');?>
							</select>
						</td>
						<td align="right">Mostrar a:
							<select id="sector_mostrar" name="sector_mostrar">
								<option <?=($currentuser['work_sector_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['work_sector_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['work_sector_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['work_sector_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><b>Nivel de ingresos:</b></td>
						<td>
							<select id="ingresos" name="ingresos">
								<option <?=($currentuser['income'] == '0' ? 'selected ' : '');?>value="sr">Sin Respuesta</option>
								<option <?=($currentuser['income'] == '1' ? 'selected ' : '');?>value="sin">Sin ingresos</option>
								<option <?=($currentuser['income'] == '2' ? 'selected ' : '');?>value="bajos">Bajos</option>
								<option <?=($currentuser['income'] == '3' ? 'selected ' : '');?>value="intermedios">Intermedios</option>
								<option <?=($currentuser['income'] == '4' ? 'selected ' : '');?>value="altos">Altos</option>
							</select>
						</td>
						<td align="right">Mostrar a:
							<select id="ingresos_mostrar" name="ingresos_mostrar">
								<option <?=($currentuser['income_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['income_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['income_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['income_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><b>Intereses Profesionales:</b></td>
						<td><textarea name="intereses_profesionales" cols="30" rows="5" id="intereses_profesionales"><?=$currentuser['work_interests'];?></textarea></td>
						<td align="right" valign="top">Mostrar a:
							<select id="intereses_profesionales_mostrar" name="intereses_profesionales_mostrar">
								<option <?=($currentuser['work_interests_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['work_interests_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['work_interests_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['work_interests_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><b>Habilidades Profesionales:</b></td>
						<td><textarea name="habilidades_profesionales" cols="30" rows="5" id="habilidades_profesionales"><?=$currentuser['work_skills'];?></textarea></td>
						<td align="right" valign="top">Mostrar a:
							<select id="habilidades_profesionales_mostrar" name="habilidades_profesionales_mostrar">
								<option <?=($currentuser['work_skills_show'] == '0' ?  'selected ' : '');?>value="nadie">Nadie</option>
								<option <?=($currentuser['work_skills_show'] == '1' ?  'selected ' : '');?>value="amigos">Mis Amigos</option>
								<option <?=($currentuser['work_skills_show'] == '2' ?  'selected ' : '');?>value="registrados">Usuarios Registrados</option>
								<option <?=($currentuser['work_skills_show'] == '3' ?  'selected ' : '');?>value="todos">A todos</option>
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