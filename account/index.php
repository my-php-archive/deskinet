<?php
if(!defined('account_define')) { header('Location: /index.php'); }
$currentuser['name_show'] = (int) $currentuser['name_show'];
$currentuser['email_show'] = (int) $currentuser['email_show'];
$currentuser['birth_show'] = (int) $currentuser['birth_show'];
$currentuser['messenger_show'] = (int) $currentuser['messenger_show'];
?>
<iframe name="hit" style="display:none;"></iframe>
<a name="mda"></a>
<div style="display:none;" id="mensajes_div"></div>
<form name="af" method="post" onsubmit="return ec_validate_data(this);return false;" action="/blank.html" target="hit">
					<table width="100%" cellpadding="4">
						<tr>
							<td width="25%" align="right"><b>Nick:</b></td>
							<td width="42%"><?=$currentuser['nick'];?></td>
							<td width="33%">&nbsp;</td>
						</tr>
						<tr>
							<td width="25%" align="right"><b>Nombre y Apellido:</b></td>
							<td width="42%"><input type="text" size="30" maxlength="32" name="nombre" value="<?=$currentuser['name'];?>" /></td>
							<td width="33%">Mostrar a:
								<select id="nombre_mostrar" name="nombre_mostrar">
									<option <?=($currentuser['name_show'] == 0 ? 'selected ' : '');?>value="nadie">Nadie</option>
									<option <?=($currentuser['name_show'] == 1 ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
									<option <?=($currentuser['name_show'] == 2 ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
									<option <?=($currentuser['name_show'] == 3 ? 'selected ' : '');?>value="todos">A todos</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right"><b>E-mail:</b></td>
							<td><input type="text" size="30" maxlength="35" name="email" value="<?=$currentuser['email'];?>"/></td>
							<td>Mostrar a:
								<select id="email_mostrar" name="email_mostrar">
									<option <?=($currentuser['email_show'] == 0 ? 'selected ' : '');?>value="nadie">Nadie</option>
									<option <?=($currentuser['email_show'] == 1 ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
									<option <?=($currentuser['email_show'] == 2 ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
									<option <?=($currentuser['email_show'] == 3 ? 'selected ' : '');?>value="todos">A todos</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right"><b> Pa&iacute;s:</b></td>
							<td>
								<select id="pais" name="pais" style="width:205px;">
						<?=str_replace('value="'.$currentuser['country'].'"', 'selected value="'.$currentuser['country'].'"', '<option value="0">Argentina</option>
<option value="1">Bolivia</option>
<option value="2">Brasil</option>
<option value="3">Chile</option>
<option value="4">Colombia</option>
<option value="5">Costa Rica</option>
<option value="6">Cuba</option>
<option value="7">Rep&uacute;blica Checa</option>
<option value="8">Ecuador</option>
<option value="9">El Salvador</option>
<option value="10">Espa&ntilde;a</option>
<option value="11">Guatemala</option>
<option value="12">Guinea Ecuatorial</option>
<option value="13">Honduras</option>
<option value="14">Israel</option>
<option value="15">Italia</option>
<option value="16">Jap&oacute;n</option>
<option value="17">M&eacute;xico</option>
<option value="18">Nicaragua</option>
<option value="19">Panam&aacute;</option>
<option value="20">Paraguay</option>
<option value="21">Per&uacute;</option>
<option value="22">Portugal</option>
<option value="23">Puerto Rico</option>
<option value="24">Rep&uacute;blica Dominicana</option>
<option value="25">Estados Unidos</option>
<option value="26">Uruguay</option>
<option value="27">Venezuela</option>
<option value="28">----</option>
<option value="29">Afghanist&aacute;n</option>
<option value="30">Albania</option>
<option value="31">Argelia</option>
<option value="32">Samoa Americana</option>
<option value="33">Andorra</option>
<option value="34">Angola</option>
<option value="35">Anguila</option>
<option value="36">Ant&aacute;rtida</option>
<option value="37">Antigua y Barbuda</option>
<option value="38">Armenia</option>
<option value="39">Aruba</option>
<option value="40">Islas Ashmore y Cartier</option>
<option value="41">Australia</option>
<option value="42">Austria</option>
<option value="43">Azerbaiy&aacute;n</option>
<option value="44">Las Bahamas</option>
<option value="45">Bahr&eacute;in</option>
<option value="46">Isla Baker</option>
<option value="47">Bangladesh</option>
<option value="48">Barbados</option>
<option value="49">Bassas da India</option>
<option value="50">Bielorrusia</option>
<option value="51">B&eacute;lgica</option>
<option value="52">Belice</option>
<option value="53">Ben&iacute;n</option>
<option value="54">Bermuda</option>
<option value="55">But&aacute;n</option>
<option value="56">Bosnia y Herzegovina</option>
<option value="57">Botsuana</option>
<option value="58">Isla Bouvet</option>
<option value="59">Territorio Brit&aacute;nico del Oc&eacute;ano &iacute;ndico</option>
<option value="60">Islas V&iacute;rgenes Brit&aacute;nicas</option>
<option value="61">Brun&eacute;i</option>
<option value="62">Bulgaria</option>
<option value="63">Burkina Faso</option>
<option value="64">Birmania</option>
<option value="65">Burundi</option>
<option value="66">Camboya</option>
<option value="67">Camer&uacute;n</option>
<option value="68">Canad&aacute;</option>
<option value="69">Cabo Verde</option>
<option value="70">Islas Caim&aacute;n</option>
<option value="71">Rep&uacute;blica Centroafricana</option>
<option value="72">Chad</option>
<option value="73">China</option>
<option value="74">Isla de Navidad</option>
<option value="75">Isla de la Pasi&oacute;n</option>
<option value="76">Islas Cocos</option>
<option value="77">Comoros</option>
<option value="78">Rep&uacute;blica Democr&aacute;tica del Congo</option>
<option value="79">Rep&uacute;blica del Congo</option>
<option value="80"> Islas Cook</option>
<option value="81">Coral Sea Islands</option>
<option value="82">Costa de Marfil</option>
<option value="83">Croacia</option>
<option value="84">Chipre</option>
<option value="85">Dinamarca</option>
<option value="86">Yibuti</option>
<option value="87">Dominica</option>
<option value="88">Timor Oriental</option>
<option value="89">Egipto</option>
<option value="90">Eritrea</option>
<option value="91">Estonia</option>
<option value="92">Etiop&iacute;a</option>
<option value="93">Isla Europa</option>
<option value="94">Islas Malvinas</option>
<option value="95">Islas Feroe</option>
<option value="96">Fiyi</option>
<option value="97">Finlandia</option>
<option value="98">Francia</option>
<option value="99">Guayana Francesa</option>
<option value="100">Polinesia Francesa</option>
<option value="101">Tierras australes y ant&aacute;rticas francesas</option>
<option value="102">Gab&oacute;n</option>
<option value="103">Gambia</option>
<option value="104">Georgia</option>
<option value="105">Alemania</option>
<option value="106">Ghana</option>
<option value="107">Gibraltar</option>
<option value="108">Islas Gloriosas</option>
<option value="109">Grecia</option>
<option value="110">Groenlandia</option>
<option value="111">Granada</option>
<option value="112">Guadalupe</option>
<option value="113">Guam</option>
<option value="114">Guernsey</option>
<option value="115">Guinea</option>
<option value="116">Guinea-Bissau</option>
<option value="117">Guyana</option>
<option value="118">Hait&iacute;</option>
<option value="119">Islas Heard y McDonald Islas</option>
<option value="120">Ciudad del Vaticano</option>
<option value="121">Hong Kong</option>
<option value="122">Howland Island</option>
<option value="123">Hungr&iacute;a</option>
<option value="124">Islandia</option>
<option value="125">India</option>
<option value="126">Indonesia</option>
<option value="127">Iran</option>
<option value="128">Iraq</option>
<option value="129">Irlanda</option>
<option value="130">Jamaica</option>
<option value="131">Isla Jan Mayen</option>
<option value="132">Isla Jarvis</option>
<option value="133">Bailiazgo de Jersey</option>
<option value="134">Atol&oacute;n Johnston</option>
<option value="135">Jordan</option>
<option value="136">Isla Juan de Nova</option>
<option value="137">Kazajist&aacute;n</option>
<option value="138">Kenia</option>
<option value="139">Arrecife Kingman</option>
<option value="140">Kiribati</option>
<option value="141">Corea del Norte</option>
<option value="142">Corea del Sur</option>
<option value="143">Kuwait</option>
<option value="144">Kirguist&aacute;n</option>
<option value="145">Laos</option>
<option value="146">Letonia</option>
<option value="147">L&iacute;bano</option>
<option value="148">Lesoto</option>
<option value="149">Liberia</option>
<option value="150">Libia</option>
<option value="151">Liechtenstein</option>
<option value="152">Lituania</option>
<option value="153">Luxemburgo</option>
<option value="154">Macao</option>
<option value="155">Macedonia</option>
<option value="156">Madagascar</option>
<option value="157">Malaui</option>
<option value="158">Malasia</option>
<option value="159">Maldivas</option>
<option value="160">Mali</option>
<option value="161">Malta</option>
<option value="162">Isla de Man</option>
<option value="163">Islas Marshall</option>
<option value="164">Martinica</option>
<option value="165">Mauritania</option>
<option value="166">Mauricio</option>
<option value="167">Mayotte</option>
<option value="168">Estados Federados de Micronesia</option>
<option value="169">Islas Midway</option>
<option value="170">Rep&uacute;blica de Moldavia</option>
<option value="171">M&oacute;naco</option>
<option value="172">Mongolia</option>
<option value="173">Montenegro</option>
<option value="174">Montserrat</option>
<option value="175">Marruecos</option>
<option value="176">Mozambique</option>
<option value="177">Namibia</option>
<option value="178">Naur&uacute;</option>
<option value="179">Navassa Island</option>
<option value="180">Nepal</option>
<option value="181">Holanda</option>
<option value="182">Antillas Neerlandesas</option>
<option value="183">Neutral Zone</option>
<option value="184">Nueva Caledonia</option>
<option value="185">Nueva Zelanda</option>
<option value="186">N&iacute;ger</option>
<option value="187">Nigeria</option>
<option value="188">Niue</option>
<option value="189">Isla Norfolk</option>
<option value="190">Islas Marianas del Norte</option>
<option value="191">Noruega</option>
<option value="192">Om&aacute;n</option>
<option value="193">Pakist&aacute;n</option>
<option value="194">Palau</option>
<option value="195">Atol&oacute;n Palmyra</option>
<option value="196">Pap&uacute;a Nueva Guinea</option>
<option value="197">Islas Paracel</option>
<option value="198">Filipinas</option>
<option value="199">Islas Pitcairn</option>
<option value="200">Polonia</option>
<option value="201">Qatar</option>
<option value="202">Reuni&oacute;n</option>
<option value="203">Rumania</option>
<option value="204">Rusia</option>
<option value="205">Ruanda</option>
<option value="206">Santa Helena</option>
<option value="207">San Crist&oacute;bal y Nieves</option>
<option value="208">Santa Luc&iacute;a</option>
<option value="209">San Pedro y Miguel&oacute;n</option>
<option value="210">San Vicente y las Granadinas</option>
<option value="211">Samoa</option>
<option value="212">San Marino</option>
<option value="213">Santo Tom&eacute; y Pr&iacute;ncipe</option>
<option value="214">Arabia Saudita</option>
<option value="215">Senegal</option>
<option value="216">Serbia</option>
<option value="217">Seychelles</option>
<option value="218">Sierra Leone</option>
<option value="219">Singapur</option>
<option value="220">Eslovaquia</option>
<option value="221">Eslovenia</option>
<option value="222">Islas Salom&oacute;n</option>
<option value="223">Somalia</option>
<option value="224">Sud&aacute;frica</option>
<option value="225">Georgia del Sur e Islas Sandwich del Sur</option>
<option value="226">Islas Spratly</option>
<option value="227">Sri Lanka</option>
<option value="228">Sud&aacute;n</option>
<option value="229">Surinam</option>
<option value="230">Svalbard</option>
<option value="231">Swazilandia</option>
<option value="232">Suecia</option>
<option value="233">Suiza</option>
<option value="234">Rep&uacute;blica &aacute;rabe Siria</option>
<option value="235">Taiw&aacute;n</option>
<option value="236">Tayikist&aacute;n</option>
<option value="237">Rep&uacute;blica Unida de Tanzania</option>
<option value="238">Tailandia</option>
<option value="239">Togo</option>
<option value="240">Tokelau</option>
<option value="241">Tonga</option>
<option value="242">Trinidad y Tobago</option>
<option value="243">Isla Tromelin</option>
<option value="244">T&uacute;nez</option>
<option value="245">Turqu&iacute;a</option>
<option value="246">Turkmenist&aacute;n</option>
<option value="247">Islas Turcas y Caicos</option>
<option value="248">Tuvalu</option>
<option value="249">Uganda</option>
<option value="250">Ucrania</option>
<option value="251">Emigratos &aacute;rabes Unidos</option>
<option value="252">Reino Unido</option>
<option value="253">Uzbekist&aacute;n</option>
<option value="254">Vanuatu</option>
<option value="255">Vietnam</option>
<option value="256">Islas V&iacute;rgenes</option>
<option value="257">Wake Island</option>
<option value="258">Wallis y Futuna</option>
<option value="259">S&aacute;hara Occidental</option>
<option value="260">Yemen</option>
<option value="261">Zambia</option>
<option value="262">Zimbabwe</option>');?>
								</select>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="right"><b>Ciudad:</b></td>
							<td><input type="text" size="30" maxlength="32" name="ciudad" value="<?=$currentuser['city'];?>"/></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="right"><b>Sexo:</b></td>
							<td>
								<input name="sexo" type="radio" value="m"<?=($currentuser['gender'] == 1 ? ' checked' : '');?>> Masculino&nbsp;
								<input name="sexo" type="radio" value="f"<?=($currentuser['gender'] == 2 ? ' checked' : '');?>>Femenino							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="right"><b>Fecha de Nacimiento</b><br />(d&iacute;a/mes/a&ntilde;o):</b></td>
							<td>
								<input type="text" size="2" maxlength="2" name="dia" value="<?=$currentuser['birth_day'];?>" />&nbsp;
								<input type="text" size="2" maxlength="2" name="mes" value="<?=$currentuser['birth_month'];?>" />&nbsp;
								<input type="text" size="4" maxlength="4" name="ano" value="<?=$currentuser['birth_year'];?>" />
							</td>
							<td>Mostrar a:
								<select id="fecha_nacimiento_mostrar" name="fecha_nacimiento_mostrar">
									<option <?=($currentuser['birth_show'] == 0 ? 'selected ' : '');?>value="nadie">Nadie</option>
									<option <?=($currentuser['birth_show'] == 1 ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
									<option <?=($currentuser['birth_show'] == 2 ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
									<option <?=($currentuser['birth_show'] == 3 ? 'selected ' : '');?>value="todos">A todos</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right"><b>Sitio Web / Blog:</b></td>
							<td><input type="text" size="30" maxlength="60" name="sitio" value="<?=$currentuser['website'];?>" /></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="right"><b>Mensajero:</b> <br />(Tipo de mensajero)</td>
							<td><input type="text" size="20" maxlength="64" name="im" value="<?=$currentuser['messenger'];?>" />
								<select id="im_tip" name="im_tipo">
									<option <?=($currentuser['messenger_type'] == 'msn' ? 'selected ' : '');?>value="msn">MSN</option>
									<option <?=($currentuser['messenger_type'] == 'gtalk' ? 'selected ' : '');?>value="gtalk">GTalk</option>
									<option <?=($currentuser['messenger_type'] == 'icq' ? 'selected ' : '');?>value="icq">ICQ</option>
									<option <?=($currentuser['messenger_type'] == 'aim' ? 'selected ' : '');?>value="aim">AIM</option>
								</select>
							</td>
							<td>Mostrar a:
								<select id="im_mostrar" name="im_mostrar">
									<option <?=($currentuser['messenger_show'] == 0 ? 'selected ' : '');?>value="nadie">Nadie</option>
									<option <?=($currentuser['messenger_show'] == 1 ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
									<option <?=($currentuser['messenger_show'] == 2 ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
									<option <?=($currentuser['messenger_show'] == 3 ? 'selected ' : '');?>value="todos">A todos</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td class="color_red">* Todos los campos son obligatorios</td>
							<td>&nbsp;</td>
						</tr>
  	        <tr>
              <td colspan="3" align="center"><hr />Al modificar mi perfil tambi&eacute;n acepto los <a href="/terminos-y-condiciones/" target="_blank">T&eacute;rminos de uso</a> y la <a href="/privacidad-de-datos/" target="_blank">pol&iacute;tica de privacidad de datos</a>.</td>
            </tr>
            <tr>
              <td colspan="3" align="center">
								<input type="submit" class="button" style="font-size:15px" value="Modificar mi perfil" title="Modificar mi perfil" onclick="document.location.hash = '#mda';">
              </td>
            </tr>
					</table>
				</form>