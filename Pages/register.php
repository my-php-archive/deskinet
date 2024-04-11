<div id="cuerpocontainer" style="margin-top:-15px;">
<style type="text/css">

.reg-login {
	margin-top: 15px;
}
	.registro {
		float: left;
		width: 300px;
	}
	.login-panel {
		float: left;
		border-left: #CCC 1px solid;
		padding-left: 25px;
	}

	.login-panel label {
		font-weight: bold;
		display: block;
		margin: 5px 0;
	}

    .login-panel .mBtn {
        margin-top: 10px;
    }
</style>

<div class="post-deleted post-privado clearbeta">
	<div class="content-splash">
		<h3><?=($_GET['page'] == 'register' ? 'Registrate en '<?$config=['script_name'];?>'!' : ($_GET['page'] == 'post' ? 'Este post es privado' : 'Esta secci&oacute;n es privada').', s&oacute;lo los usuarios registrados de '<?$config=['script_name'];?>' pueden acceder.');?></h3>
		Pero no te preocupes, tambi&eacute;n puedes formar parte de nuestra gran familia.
		<div class="reg-login">
			<div class="registro">
				<h4>&iexcl;Registrarme!</h4>
				<div id="RegistroForm">
	<!-- Paso Uno -->
	<div class="pasoUno">
		<div class="form-line">
			<label for="nick">Nombre de usuario</label>
			<input type="text" id="nick" name="nick" tabindex="1" onblur="registro.blur(this)" onfocus="registro.focus(this)" onkeyup="registro.set_time(this.name)" onkeydown="registro.clear_time(this.name)" autocomplete="off" title="Ingrese un nombre de usuario &uacute;nico" /> <div class="help"><span><em></em></span></div>
		</div>

		<div class="form-line">
			<label for="password">Contrase&ntilde;a deseada</label>
			<input type="password" id="password" name="password" tabindex="2" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese una contrase&ntilde;a segura" /> <div class="help"><span><em></em></span></div>
		</div>

		<div class="form-line">
			<label for="password2">Confirme contrase&ntilde;a</label>
			<input type="password" id="password2" name="password2" tabindex="3" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Vuelva a introducir la contrase&ntilde;a" /> <div class="help"><span><em></em></span></div>
		</div>

		<div class="form-line">
			<label for="email">E-mail</label>
			<input type="text" id="email" name="email" tabindex="4" onblur="registro.blur(this)" onfocus="registro.focus(this)" onkeyup="registro.set_time(this.name)" onkeydown="registro.clear_time(this.name)" autocomplete="off" title="Ingrese su email" /> <div class="help"><span><em></em></span></div>
		</div>

		<div class="form-line">
			<label>Fecha de Nacimiento</label>
			<select id="dia" name="dia" tabindex="5" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese d&iacute;a de nacimiento">
				<option value="">D&iacute;a</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
							<option value="25">25</option>
							<option value="26">26</option>
							<option value="27">27</option>
							<option value="28">28</option>
							<option value="29">29</option>
							<option value="30">30</option>
							<option value="31">31</option>
						</select>
			<select id="mes" name="mes" tabindex="6" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese mes de nacimiento">
				<option value="">Mes</option>
				<option value="1">Enero</option>
				<option value="2">Febrero</option>
				<option value="3">Marzo</option>
				<option value="4">Abril</option>
				<option value="5">Mayo</option>
				<option value="6">Junio</option>
				<option value="7">Julio</option>
				<option value="8">Agosto</option>
				<option value="9">Septiembre</option>
				<option value="10">Octubre</option>
				<option value="11">Noviembre</option>
				<option value="12">Diciembre</option>
			</select>
			<select id="anio" name="anio" tabindex="7" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese a&ntilde;o de nacimiento">
				<option value="">A&ntilde;o</option>
							<?php
                            for($i=date('Y');$i>=(date('Y')-100);$i--) {
                              echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                            ?>
						</select> <div class="help"><span><em></em></span></div>
		</div>
		<div class="clearfix"></div>
	</div>

	<!-- Paso Dos -->
	<div class="pasoDos">

		<div class="form-line">
			<label for="sexo">Sexo</label>
			<input class="radio" type="radio" id="sexo_m" tabindex="8" name="sexo" value="m" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese el sexo" /> <label class="list-label" for="sexo_m">Masculino</label>
			<input class="radio" type="radio" id="sexo_f" tabindex="8" name="sexo" value="f" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese el sexo" /> <label class="list-label" for="sexo_f">Femenino</label>
			<div class="help"><span><em></em></span></div>
		</div>

		<div class="form-line">
			<label for="pais">Pa&iacute;s</label>
			<select id="pais" name="pais" tabindex="9" onblur="registro.blur(this)" onchange="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese su pa&iacute;s">
				<option value="">Pa&iacute;s</option>
							<?php
                                include('../config.php');
                                $query = mysql_query("SELECT id, name FROM `countries` ORDER BY name");
                                while($c = mysql_fetch_assoc($query)) {
                                    echo "<option value=\"".$c['id']."\">".$c['name']."</option>\n";
                                }
                            ?>
						</select> <div class="help"><span><em></em></span></div>
		</div>

		<div class="form-line">
			<label for="provincia">Regi&oacute;n</label>
			<select disabled id="provincia" name="provincia" tabindex="10" onblur="registro.blur(this)" onchange="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese su provincia">
				<option value="">Regi&oacute;n</option>
						</select> <div class="help"><span><em></em></span></div>
		</div>

		<div class="form-line">
			<label for="ciudad">Ciudad</label>
			<input disabled type="text" id="ciudad" name="ciudad" tabindex="11" onblur="registro.blur(this)" onfocus="registro.focus(this)" title="Escriba el nombre de su ciudad" autocomplete="off" disabled="disabled" class="disabled" /> <div class="help"><span><em></em></span></div>
		</div>

		<div class="footerReg">
			<div class="form-line">
				<input type="checkbox" class="checkbox" id="noticias" name="noticias" tabindex="12" checked="checked" onchange="registro.datos['noticias'] = $(this).is(':checked')" title="Enviar noticias por email?" /> <label class="list-label" for="noticias">Enviarme mails con noticias de Taringa!</label>
			</div>
		</div>

		<div class="form-line">
			<label for="recaptcha_response_field">C&oacute;digo de Seguridad:</label>
			<div id="recaptcha_ajax">
				<div id="recaptcha_image"></div>
				<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
			</div> <div class="help recaptcha"><span><em></em></span></div>
		</div>

		<div class="footerReg">
			<div class="form-line">
				<input type="checkbox" class="checkbox" id="terminos" name="terminos" tabindex="14" onblur="registro.blur(this)" onfocus="registro.focus(this)" title="¿Acepta los T&eacute;rminos y Condiciones?" /> <label class="list-label" for="terminos">Acepto los <a href="/terminos-y-condiciones/" target="_blank">T&eacute;rminos de uso</a></label> <div class="help"><span><em></em></span></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
//Load JS
$.getScript("/js/register.js", function(){

	//Genero el autocomplete de la ciudad
	$('#RegistroForm .pasoDos #ciudad').autocomplete('/ajax/locations.php', {
		minChars: 2,
		width: 268
	}).result(function(event, data, formatted){
		registro.datos['ciudad_id'] = (data) ? data[1] : '';
		registro.datos['ciudad_text'] = (data) ? data[0].toLowerCase() : '';
		if(data)
			$('#RegistroForm .pasoDos #terminos').focus();
	});

			registro.dialog = false;
		registro.change_paso(1, true);
	});

//Load recaptcha
$.getScript("http://api.recaptcha.net/js/recaptcha_ajax.js", function(){
	Recaptcha.create('<?=$config['recaptcha_publickey'];?>', 'recaptcha_ajax', {
		theme:'custom', lang:'es', tabindex:'13', custom_theme_widget: 'recaptcha_ajax',
		callback: function(){
			$('#recaptcha_response_field').blur(function(){
				registro.blur(this);
			}).focus(function(){
				registro.focus(this);
			}).attr('title', 'Ingrese el código de la imagen');
		}
	});
});
</script>				<div id="buttons" style="display: inline-block;">
					<input id="sig" type="button" onclick="registro.change_paso(2)" value="Siguiente &raquo;" style="display:inline-block;" class="mBtn btnOk" tabindex="8" />
					<input id="term" type="button" onclick="registro.submit()" value="Terminar" style="display:none;" class="mBtn btnOk btnGreen" tabindex="15" />
				</div>
			</div>
			<div class="login-panel">
				<h4>...O quiz&aacute;s ya tengas usuario</h4>
				<div style="width:210px;font-size:13px;border: 5px solid rgb(195, 0, 20); background: none repeat scroll 0% 0% rgb(247, 228, 221); color: rgb(195, 0, 20); padding: 8px; margin: 10px 0;">
					<strong>&iexcl;Atenci&oacute;n!</strong>
					<br/>Antes de ingresar tus datos asegurate que la URL de esta página pertenece a <strong><?$config=['script_name'];?></strong>
				</div>
				<div class="login_cuerpo">
				  <span class="login_cargando gif_cargando floatR"></span>
				  <div class="login_error"></div>
				    <form method="POST" id="login-registro-logueo" action="javascript:login_ajax('#login-registro-logueo')">
				      <label>Usuario</label>
				      <input maxlength="15" name="nick" class="ilogin" type="text" tabindex="20" />

				      <label>Contrase&ntilde;a</label>
				      <input maxlength="15" name="pass" class="ilogin" type="password" tabindex="21" />
                      <br />
				      <input class="mBtn btnOk" value="Entrar" title="Entrar" type="submit" tabindex="22" />
				      <div class="floatR" style="color: #666; padding:5px;font-weight: normal;margin-top:12px;">
				        <input type="checkbox" name="rememberme" /> &iquest;Recordarme?
				      </div>
				    </form>
				    <div class="login_footer">
				      <a href="/password/" tabindex="23">&iquest;Olvidaste tu contrase&ntilde;a?</a>
				    </div>
				  </div>

			</div>
		</div>
	</div>
</div><div style="clear:both"></div>
</div>