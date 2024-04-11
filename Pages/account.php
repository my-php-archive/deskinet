<?php
// Comprobar si accede directamente
define('account_define', true);
if(!defined($config['define'])) { header('Location: /index.php'); }
if(!isLogged()) {
	include('./Pages/register.php');
    include('./footer.php');
    die;
}
// 360 303 303
?>
<div id="cuerpocontainer">
<!-- inicio cuerpocontainer -->
<script src="/js/account.js?<?=time();?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
<?php
  $query = mysql_query("SELECT name FROM `cities` WHERE id = '".$currentuser['city']."'");
  $c = mysql_fetch_row($query);
?>
	avatar.current = '/avatares/120/<?=$currentuser['avatar'];?>';
	cuenta.ciudad_id = '<?=$currentuser['city'];?>';
	cuenta.ciudad_text = "<?=$c[0];?>";
	});
</script>
<div class="tabbed-d">
<div class="floatL">
	<ul class="menu-tab">
		<li class="active"><a onclick="cuenta.chgtab(this)">Cuenta</a></li>
		<li><a onclick="cuenta.chgtab(this)">Perfil</a></li>
		<li><a onclick="cuenta.chgtab(this)">Opciones</a></li>
		<li><a onclick="cuenta.chgtab(this)">Mis Fotos</a></li>
		<li><a onclick="cuenta.chgtab(this)">Bloqueados</a></li>
		<li><a onclick="cuenta.chgtab(this)">Cambiar Clave</a></li>
		<li class="privacy"><a onclick="cuenta.chgtab(this)">Privacidad</a></li>
	</ul>
	<a name="alert-cuenta"></a>
	<form name="editarcuenta" class="horizontal" action="" method="post">
		<div class="content-tabs cuenta">
			<div class="alert-cuenta cuenta-1">
			</div>
			<fieldset>
				<div class="field">
					<label for="nombre">Nombre:</label>
					<input type="text" class="text cuenta-save-1" id="nombre" name="nombre" maxlength="32" value="<?=htmlspecialchars($currentuser['name']);?>" />
				</div>
				<div class="field">
					<label for="email">E-Mail:</label>
					<div class="input-fake input-hide-email">
						<?=$currentuser['email'];?> (<a onclick="input_fake('email')">Cambiar</a>)
					</div>
					<input type="text" class="text cuenta-save-1 input-hidden-email" id="email" name="email" maxlength="35" value="<?=$currentuser['email'];?>" style="display: none" />
				</div>
				<div class="field">
					<label for="pais">Pa&iacute;s:</label>
					<select id="pais" name="pais" class="cuenta-save-1" onchange="cuenta.chgpais()">
						<option value="">Pa&iacute;s</option>
							<?php
                                $query = mysql_query("SELECT id, name FROM `countries` ORDER BY name ASC");
                                while($co = mysql_fetch_assoc($query)) {
                                    echo "<option".($currentuser['country']==$co['id'] ? ' selected' : '')." value=\"".$co['id']."\">".$co['name']."</option>\n";
                                }
                            ?>
										</select>
				</div>
 
				<div class="field">
					<label for="provincia">Regi&oacute;n:</label>
					<select id="provincia" name="provincia" class="cuenta-save-1" onchange="cuenta.chgprovincia()">
						<option value="">Regi&oacute;n</option>
                            <?php
                                $query = mysql_query("SELECT id, name FROM `provinces` WHERE country = '".$currentuser['country']."'");
                                while($pr = mysql_fetch_assoc($query)) {
                                    echo "<option".($currentuser['province']==$pr['id'] ? ' selected' : '')." value=\"".$pr['id']."\">".$pr['name']."</option>\n";
                                }
                            ?>
										</select>
				</div>
				<div class="field">
					<label for="ciudad">Ciudad:</label>
					<input type="text" id="ciudad" name="ciudad" value="<?=$c[0];?>" />
				</div>
				<div class="field">
					<label>Sexo</label>
					<ul class="fields">
						<li>
							<label><input type="radio" class="radio cuenta-save-1" name="sexo" value="m"<?=($currentuser['gender']==1 ? ' checked' : '');?> />Masculino</label>
						</li>
						<li>
							<label><input type="radio" class="radio cuenta-save-1" name="sexo" value="f" />Femenino</label>
						</li>
					</ul>
				</div>
				<div class="field">
										<label>Nacimiento:</label>
					<select name="dia" class="cuenta-save-1">
										<?php
                                        for($i=1;$i<32;$i++) {
                                          echo '<option'.($currentuser['birth_day']==$i ? ' selected' : '').' value="'.$i.'">'.$i.'</option>';
                                        }
                                        ?>
										</select>
					<select name="mes" class="cuenta-save-1">
                        <?php
                        $m = array(1=>'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
						foreach($m as $n=>$m) {
						  echo '<option'.($currentuser['birth_month']==$n ? ' selected' : '').' value="'.$n.'">'.$m.'</option>';
                        }
                        ?>
											</select>
					<select name="ano" class="cuenta-save-1">
                            <?php
                            for($i=date('Y');$i>=(date('Y')-100);$i--) {
                              echo '<option'.($currentuser['birth_year']==$i ? ' selected' : '').' value="'.$i.'">'.$i.'</option>';
                            }
                            ?>
											</select>
				</div>
			</fieldset>
			<div class="buttons">
				<input type="button" class="mBtn btnOk" onclick="cuenta.save(1)" value="Guardar" />
				<input type="button" class="mBtn btnOk" onclick="cuenta.save(1, true)" value="Siguiente" />
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="content-tabs perfil" style="display: none">
			<h3 onclick="cuenta.chgsec(this)" class="active">1. M&aacute;s sobre mi</h3>
			<fieldset>
				<div class="alert-cuenta cuenta-2">
				</div>
				<div class="field">
					<label for="sitio">Mensaje Personal</label>
					<textarea class="cuenta-save-2" id="mensaje" name="mensaje" maxlength="60"><?=htmlspecialchars($currentuser['personal_text']);?></textarea>
				</div>
				
				<div class="field">
					<label for="sitio">Sitio Web</label>
					<input style="width:230px" type="text" class="text cuenta-save-2" id="sitio" name="sitio" maxlength="60" value="<?=(empty($currentuser['website']) ? 'http://' : htmlspecialchars($currentuser['website']));?>" />
				</div>
				<div class="field">
										<label for="im">Mensajero</label>
					<select name="im_tipo" class="cuenta-save-2">
						<option<?=($currentuser['messenger_type']=='msn' ? ' selected' : '');?> value="msn">MSN</option>
						<option<?=($currentuser['messenger_type']=='gtalk' ? ' selected' : '');?> value="gtalk">GTalk</option>
						<option<?=($currentuser['messenger_type']=='icq' ? ' selected' : '');?> value="icq">ICQ</option>
						<option<?=($currentuser['messenger_type']=='aim' ? ' selected' : '');?> value="aim">AIM</option>
						<option<?=($currentuser['messenger_type']=='twitter' ? ' selected' : '');?> value="twitter">Twitter</option>
					</select>
					<input type="text" class="text cuenta-save-2" id="im" name="im" maxlength="64" value="<?=htmlspecialchars($currentuser['messenger']);?>" />
				</div>
				<div class="field">
					<label>Me gustar&iacute;a</label>
					<div class="input-fake">
						<ul>
							<li><input <?=($currentuser['make_friends'] == '1' ? 'checked ' : '');?>type="checkbox" class="cuenta-save-2" name="me_gustaria_amigos" />Hacer amigos</li>
							<li><input <?=($currentuser['meet_interests'] == '1' ? 'checked ' : '');?>type="checkbox" class="cuenta-save-2" name="me_gustaria_conocer_gente" />Conocer gente con mis intereses</li>
							<li><input <?=($currentuser['meet_business'] == '1' ? 'checked ' : '');?>type="checkbox" class="cuenta-save-2" name="me_gustaria_conocer_gente_negocios" />Conocer gente para negocios</li>
							<li><input <?=($currentuser['find_mate'] == '1' ? 'checked ' : '');?>type="checkbox" class="cuenta-save-2" name="me_gustaria_encontrar_pareja" />Encontrar pareja</li>
							<li><input <?=($currentuser['find_all'] == '1' ? 'checked ' : '');?>type="checkbox" class="cuenta-save-2" name="me_gustaria_de_todo" />De todo</li>
						</ul>
					</div>
				</div>
				<div class="field">
					<label for="estado">Estado Civil</label>
					<div class="input-fake">
						<select id="estado" name="estado" class="cuenta-save-2">
							<option <?=($currentuser['love_state'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
							<option <?=($currentuser['love_state'] == '1' ? 'selected ' : '');?>value="1">Soltero/a</option>
							<option <?=($currentuser['love_state'] == '2' ? 'selected ' : '');?>value="2">De novio/a</option>
							<option <?=($currentuser['love_state'] == '3' ? 'selected ' : '');?>value="3">Casado/a</option>
							<option <?=($currentuser['love_state'] == '4' ? 'selected ' : '');?>value="4">Divorciado/a</option>
							<option <?=($currentuser['love_state'] == '5' ? 'selected ' : '');?>value="5">Viudo/a</option>
							<option <?=($currentuser['love_state'] == '6' ? 'selected ' : '');?>value="6">En algo...</option>
						</select>
					</div>
				</div>
				<div class="field">
					<label for="hijos">Hijos</label>
					<div class="input-fake">
						<select id="hijos" name="hijos" class="cuenta-save-2">
							<option <?=($currentuser['children'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
							<option <?=($currentuser['children'] == '1' ? 'selected ' : '');?>value="1">No tengo</option>
							<option <?=($currentuser['children'] == '2' ? 'selected ' : '');?>value="2">Alg&uacute;n d&iacute;a</option>
							<option <?=($currentuser['children'] == '3' ? 'selected ' : '');?>value="3">No son lo m&iacute;o</option>
							<option <?=($currentuser['children'] == '4' ? 'selected ' : '');?>value="4">Tengo, vivo con ellos</option>
							<option <?=($currentuser['children'] == '5' ? 'selected ' : '');?>value="5">Tengo, no vivo con ellos</option>
						</select>
					</div>
				</div>
				<div class="field">
					<label for="vivo">Vivo con</label>
					<div class="input-fake">
						<select id="vivo" name="vivo" class="cuenta-save-2">
							<option <?=($currentuser['live_with'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
							<option <?=($currentuser['live_with'] == '1' ? 'selected ' : '');?>value="1">S&oacute;lo</option>
							<option <?=($currentuser['live_with'] == '2' ? 'selected ' : '');?>value="2">Con mis padres</option>
							<option <?=($currentuser['live_with'] == '3' ? 'selected ' : '');?>value="3">Con mi pareja</option>
							<option <?=($currentuser['live_with'] == '4' ? 'selected ' : '');?>value="4">Con amigos</option>
							<option <?=($currentuser['live_with'] == '5' ? 'selected ' : '');?>value="5">Otro</option>
						</select>
					</div>
				</div>
				<div class="buttons">
					<input type="button" class="mBtn btnOk" onclick="cuenta.save(2, true)" value="Guardar y seguir" />
				</div>
			</fieldset>
			<h3 onclick="cuenta.chgsec(this)">2. Como soy</h3>
			<fieldset style="display: none">
				<div class="alert-cuenta cuenta-3">
				</div>
				<div class="field">
					<label for="altura">Mi altura</label>
					<div class="input-fake">
						<input type="text" class="text cuenta-save-3" id="altura" name="altura" maxlength="3" value="<?=htmlspecialchars($currentuser['height']);?>" /> cent&iacute;metros
					</div>
				</div>
				<div class="field">
					<label for="peso">Mi peso</label>
					<div class="input-fake">
						<input type="text" class="text cuenta-save-3" id="peso" name="peso" maxlength="3" value="<?=htmlspecialchars($currentuser['weight']);?>" /> kilogramos
					</div>
				</div>
				<div class="field">
					<label for="pelo_color">Color de pelo</label>
					<div class="input-fake">
						<select id="pelo_color" name="pelo_color" class="cuenta-save-3">
							<option <?=($currentuser['hair_color'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
							<option <?=($currentuser['hair_color'] == '1' ? 'selected ' : '');?>value="1">Negro</option>
							<option <?=($currentuser['hair_color'] == '2' ? 'selected ' : '');?>value="2">Casta&ntilde;o oscuro</option>
							<option <?=($currentuser['hair_color'] == '3' ? 'selected ' : '');?>value="3">Casta&ntilde;o claro</option>
							<option <?=($currentuser['hair_color'] == '4' ? 'selected ' : '');?>value="4">Rubio</option>
							<option <?=($currentuser['hair_color'] == '5' ? 'selected ' : '');?>value="5">Pelirrojo</option>
							<option <?=($currentuser['hair_color'] == '6' ? 'selected ' : '');?>value="6">Gris</option>
							<option <?=($currentuser['hair_color'] == '7' ? 'selected ' : '');?>value="7">Canoso</option>
							<option <?=($currentuser['hair_color'] == '8' ? 'selected ' : '');?>value="8">Te&ntilde;ido</option>
							<option <?=($currentuser['hair_color'] == '9' ? 'selected ' : '');?>value="9">Rapado</option>
							<option <?=($currentuser['hair_color'] == '10' ? 'selected ' : '');?>value="10">Calvo</option>
						</select>
					</div>
				</div>
				<div class="field">
					<label for="ojos_color">Color de ojos</label>
					<div class="input-fake">
						<select id="ojos_color" name="ojos_color" class="cuenta-save-3">
							<option <?=($currentuser['eyes_color'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
							<option <?=($currentuser['eyes_color'] == '1' ? 'selected ' : '');?>value="1">Negros</option>
							<option <?=($currentuser['eyes_color'] == '2' ? 'selected ' : '');?>value="2">Marrones</option>
							<option <?=($currentuser['eyes_color'] == '3' ? 'selected ' : '');?>value="3">Celestes</option>
							<option <?=($currentuser['eyes_color'] == '4' ? 'selected ' : '');?>value="4">Verdes</option>
							<option <?=($currentuser['eyes_color'] == '5' ? 'selected ' : '');?>value="5">Grises</option>
						</select>
					</div>
				</div>
				<div class="field">
					<label for="fisico">Complexi&oacute;n</label>
					<div class="input-fake">
						<select id="fisico" name="fisico" class="cuenta-save-3">
							<option <?=($currentuser['constitution'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
							<option <?=($currentuser['constitution'] == '1' ? 'selected ' : '');?>value="1">Delgado/a</option>
							<option <?=($currentuser['constitution'] == '2' ? 'selected ' : '');?>value="2">Atl&eacute;tico</option>
							<option <?=($currentuser['constitution'] == '3' ? 'selected ' : '');?>value="3">Normal</option>
							<option <?=($currentuser['constitution'] == '4' ? 'selected ' : '');?>value="4">Algunos kilos de m&aacute;s</option>
							<option <?=($currentuser['constitution'] == '5' ? 'selected ' : '');?>value="5">Corpulento/a</option>
						</select>
					</div>
				</div>
				<div class="field">
					<label for="dieta">Mi dieta es</label>
					<div class="input-fake">
						<select id="dieta" name="dieta" class="cuenta-save-3">
							<option <?=($currentuser['diet'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
							<option <?=($currentuser['diet'] == '1' ? 'selected ' : '');?>value="1">Vegetariana</option>
							<option <?=($currentuser['diet'] == '2' ? 'selected ' : '');?>value="2">Lacto Vegetariana</option>
							<option <?=($currentuser['diet'] == '3' ? 'selected ' : '');?>value="3">Org&aacute;nica</option>
							<option <?=($currentuser['diet'] == '4' ? 'selected ' : '');?>value="4">De todo</option>
							<option <?=($currentuser['diet'] == '5' ? 'selected ' : '');?>value="5">Comida basura</option>
						</select>
					</div>
				</div>
				<div class="field">
					<label>Tengo</label>
					<div class="input-fake">
						<ul>
							<li><input <?=($currentuser['tattos'] == '1' ? 'checked ' : '');?>type="checkbox" class="cuenta-save-3" name="tengo_tatuajes" value="1" />Tatuajes</li>
							<li><input <?=($currentuser['piercings'] == '1' ? 'checked ' : '');?>type="checkbox" class="cuenta-save-3" name="tengo_piercings" value="1" />Piercings</li>
						</ul>
					</div>
				</div>
				<div class="field">
					<label for="fumo">Fumo</label>
					<div class="input-fake">
						<select id="fumo" name="fumo" class="cuenta-save-3">
							<option <?=($currentuser['smoke'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
							<option <?=($currentuser['smoke'] == '1' ? 'selected ' : '');?>value="1">No</option>
							<option <?=($currentuser['smoke'] == '2' ? 'selected ' : '');?>value="2">Casualmente</option>
							<option <?=($currentuser['smoke'] == '3' ? 'selected ' : '');?>value="3">Socialmente</option>
							<option <?=($currentuser['smoke'] == '4' ? 'selected ' : '');?>value="4">Regularmente</option>
							<option <?=($currentuser['smoke'] == '5' ? 'selected ' : '');?>value="5">Mucho</option>
						</select>
					</div>
				</div>
				<div class="field">
					<label for="tomo_alcohol">Tomo alcohol</label>
					<div class="input-fake">
						<select id="tomo_alcohol" name="tomo_alcohol" class="cuenta-save-3">
							<option <?=($currentuser['drink'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
							<option <?=($currentuser['drink'] == '1' ? 'selected ' : '');?>value="1">No</option>
							<option <?=($currentuser['drink'] == '2' ? 'selected ' : '');?>value="2">Casualmente</option>
							<option <?=($currentuser['drink'] == '3' ? 'selected ' : '');?>value="3">Socialmente</option>
							<option <?=($currentuser['drink'] == '4' ? 'selected ' : '');?>value="4">Regularmente</option>
							<option <?=($currentuser['drink'] == '5' ? 'selected ' : '');?>value="5">Mucho</option>
						</select>
					</div>
				</div>
				<div class="buttons">
					<input type="button" class="mBtn btnOk" onclick="cuenta.save(3, true)" value="Guardar y seguir" />
				</div>
			</fieldset>
			<h3 onclick="cuenta.chgsec(this)">3. Formaci&oacute;n y trabajo</h3>
			<fieldset style="display: none">
				<div class="alert-cuenta cuenta-4">
				</div>
				<div class="field">
					<label for="estudios">Estudios</label>
					<div class="input-fake">
						<select id="estudios" name="estudios" class="cuenta-save-4">
							<option <?=($currentuser['studies'] == '0' ?  'selected ' : '');?>value="0">Sin Respuesta</option>
							<option <?=($currentuser['studies'] == '1' ?  'selected ' : '');?>value="1">Sin Estudios</option>
							<option <?=($currentuser['studies'] == '2' ?  'selected ' : '');?>value="2">Primario completo</option>
							<option <?=($currentuser['studies'] == '3' ?  'selected ' : '');?>value="3">Secundario en curso</option>
							<option <?=($currentuser['studies'] == '4' ?  'selected ' : '');?>value="4">Secundario completo</option>
							<option <?=($currentuser['studies'] == '5' ?  'selected ' : '');?>value="5">Terciario en curso</option>
							<option <?=($currentuser['studies'] == '6' ?  'selected ' : '');?>value="6">Terciario completo</option>
							<option <?=($currentuser['studies'] == '7' ?  'selected ' : '');?>value="7">Universitario en curso</option>
							<option <?=($currentuser['studies'] == '8' ?  'selected ' : '');?>value="8">Universitario completo</option>
							<option <?=($currentuser['studies'] == '9' ?  'selected ' : '');?>value="9">Post-grado en curso</option>
							<option <?=($currentuser['studies'] == '10' ?  'selected ' : '');?>value="10">Post-grado completo</option>
						</select>
					</div>
				</div>
				<div class="field">
					<label>Idiomas</label>
					<div class="input-fake">
						<ul>
							<li>
								<span class="label-id">Castellano</span>
								<select name="idioma_castellano" class="cuenta-save-4">
									<option <?=($currentuser['language_spanish'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
									<option <?=($currentuser['language_spanish'] == '1' ? 'selected ' : '');?>value="1">Sin conocimiento</option>
									<option <?=($currentuser['language_spanish'] == '2' ? 'selected ' : '');?>value="2">B&aacute;sico</option>
									<option <?=($currentuser['language_spanish'] == '3' ? 'selected ' : '');?>value="3">Intermedio</option>
									<option <?=($currentuser['language_spanish'] == '4' ? 'selected ' : '');?>value="4">Fluido</option>
									<option <?=($currentuser['language_spanish'] == '5' ? 'selected ' : '');?>value="5">Nativo</option>
								</select>
							</li>
							<li>
								<span class="label-id">Ingl&eacute;s</span>
								<select name="idioma_ingles" class="cuenta-save-4">
									<option <?=($currentuser['language_english'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
									<option <?=($currentuser['language_english'] == '1' ? 'selected ' : '');?>value="1">Sin conocimiento</option>
									<option <?=($currentuser['language_english'] == '2' ? 'selected ' : '');?>value="2">B&aacute;sico</option>
									<option <?=($currentuser['language_english'] == '3' ? 'selected ' : '');?>value="3">Intermedio</option>
									<option <?=($currentuser['language_english'] == '4' ? 'selected ' : '');?>value="4">Fluido</option>
									<option <?=($currentuser['language_english'] == '5' ? 'selected ' : '');?>value="5">Nativo</option>
								</select>
							</li>
							<li>
								<span class="label-id">Portugu&eacute;s</span>
								<select name="idioma_portugues" class="cuenta-save-4">
									<option <?=($currentuser['language_portuguese'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
									<option <?=($currentuser['language_portuguese'] == '1' ? 'selected ' : '');?>value="1">Sin conocimiento</option>
									<option <?=($currentuser['language_portuguese'] == '2' ? 'selected ' : '');?>value="2">B&aacute;sico</option>
									<option <?=($currentuser['language_portuguese'] == '3' ? 'selected ' : '');?>value="3">Intermedio</option>
									<option <?=($currentuser['language_portuguese'] == '4' ? 'selected ' : '');?>value="4">Fluido</option>
									<option <?=($currentuser['language_portuguese'] == '5' ? 'selected ' : '');?>value="5">Nativo</option>
								</select>
							</li>
							<li>
								<span class="label-id">Franc&eacute;s</span>
								<select name="idioma_frances" class="cuenta-save-4">
									<option <?=($currentuser['language_french'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
									<option <?=($currentuser['language_french'] == '1' ? 'selected ' : '');?>value="1">Sin conocimiento</option>
									<option <?=($currentuser['language_french'] == '2' ? 'selected ' : '');?>value="2">B&aacute;sico</option>
									<option <?=($currentuser['language_french'] == '3' ? 'selected ' : '');?>value="3">Intermedio</option>
									<option <?=($currentuser['language_french'] == '4' ? 'selected ' : '');?>value="4">Fluido</option>
									<option <?=($currentuser['language_french'] == '5' ? 'selected ' : '');?>value="5">Nativo</option>
								</select>
							</li>
							<li>
								<span class="label-id">Italiano</span>
								<select name="idioma_italiano" class="cuenta-save-4">
									<option <?=($currentuser['language_italian'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
									<option <?=($currentuser['language_italian'] == '1' ? 'selected ' : '');?>value="1">Sin conocimiento</option>
									<option <?=($currentuser['language_italian'] == '2' ? 'selected ' : '');?>value="2">B&aacute;sico</option>
									<option <?=($currentuser['language_italian'] == '3' ? 'selected ' : '');?>value="3">Intermedio</option>
									<option <?=($currentuser['language_italian'] == '4' ? 'selected ' : '');?>value="4">Fluido</option>
									<option <?=($currentuser['language_italian'] == '5' ? 'selected ' : '');?>value="5">Nativo</option>
								</select>
							</li>
							<li>
								<span class="label-id">Alem&aacute;n</span>
								<select name="idioma_aleman" class="cuenta-save-4">
									<option <?=($currentuser['language_german'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
									<option <?=($currentuser['language_german'] == '1' ? 'selected ' : '');?>value="1">Sin conocimiento</option>
									<option <?=($currentuser['language_german'] == '2' ? 'selected ' : '');?>value="2">B&aacute;sico</option>
									<option <?=($currentuser['language_german'] == '3' ? 'selected ' : '');?>value="3">Intermedio</option>
									<option <?=($currentuser['language_german'] == '4' ? 'selected ' : '');?>value="4">Fluido</option>
									<option <?=($currentuser['language_german'] == '5' ? 'selected ' : '');?>value="5">Nativo</option>
								</select>
							</li>
							<li>
								<span class="label-id">Otro</span>
								<select name="idioma_otro" class="cuenta-save-4">
									<option <?=($currentuser['language_other'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
									<option <?=($currentuser['language_other'] == '1' ? 'selected ' : '');?>value="1">Sin conocimiento</option>
									<option <?=($currentuser['language_other'] == '2' ? 'selected ' : '');?>value="2">B&aacute;sico</option>
									<option <?=($currentuser['language_other'] == '3' ? 'selected ' : '');?>value="3">Intermedio</option>
									<option <?=($currentuser['language_other'] == '4' ? 'selected ' : '');?>value="4">Fluido</option>
									<option <?=($currentuser['language_other'] == '5' ? 'selected ' : '');?>value="5">Nativo</option>
								</select>
							</li>
						</ul>
					</div>
				</div> 
				<div class="field">
					<label for="profesion">Profesi&oacute;n</label>
					<input value="<?=htmlspecialchars($currentuser['work']);?>" id="profesion" name="profesion" maxlength="32" class="text cuenta-save-4"/>
				</div>
				<div class="field">
					<label for="empresa">Empresa</label>
					<input value="<?=htmlspecialchars($currentuser['company']);?>" id="empresa" name="empresa" maxlength="32" class="text cuenta-save-4"/>
				</div>
				<div class="field">
					<label for="sector">Sector</label>
					<div class="input-fake">
						<select id="sector" name="sector" class="cuenta-save-4">
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
					</div>
				</div>
				<div class="field">
					<label for="ingresos">Nivel de ingresos</label>
					<div class="input-fake">
						<select id="ingresos" name="ingresos" class="cuenta-save-4">
							<option <?=($currentuser['income'] == '0' ? 'selected ' : '');?>value="0">Sin Respuesta</option>
							<option <?=($currentuser['income'] == '1' ? 'selected ' : '');?>value="1">Sin ingresos</option>
							<option <?=($currentuser['income'] == '2' ? 'selected ' : '');?>value="2">Bajos</option>
							<option <?=($currentuser['income'] == '3' ? 'selected ' : '');?>value="3">Intermedios</option>
							<option <?=($currentuser['income'] == '4' ? 'selected ' : '');?>value="4">Altos</option>
						</select>
					</div>
				</div>
				<div class="field">
					<label for="intereses_profesionales">Intereses Profesionales</label>
					<div class="input-fake">
						<textarea id="intereses_profesionales" name="intereses_profesionales" class="cuenta-save-4"><?=$currentuser['work_interests'];?></textarea>
					</div>
				</div>
				<div class="field">
					<label for="habilidades_profesionales">Habilidades Profesionales</label>
					<div class="input-fake">
						<textarea id="habilidades_profesionales" name="habilidades_profesionales" class="cuenta-save-4"><?=$currentuser['work_skills'];?></textarea>
					</div>
				</div>
				<div class="buttons">
					<input type="button" class="mBtn btnOk" onclick="cuenta.save(4, true)" value="Guardar y seguir" />
				</div>
			</fieldset>
			<h3 onclick="cuenta.chgsec(this)">4. Intereses y preferencias</h3>
			<fieldset style="display: none">
				<div class="alert-cuenta cuenta-5">
				</div>
				<div class="field">
					<label for="mis_intereses">Mis intereses</label>
					<div class="input-fake">
						<textarea id="mis_intereses" name="mis_intereses" class="cuenta-save-5"><?=$currentuser['my_interests'];?></textarea>
					</div>
				</div>
				<div class="field">
					<label for="hobbies">Hobbies</label>
					<div class="input-fake">
						<textarea id="hobbies" name="hobbies" class="cuenta-save-5"><?=$currentuser['my_hobbies'];?></textarea>
					</div>
				</div>
				<div class="field">
					<label for="series_tv_favoritas">Series de TV favoritas:</label>
					<div class="input-fake">
						<textarea id="series_tv_favoritas" name="series_tv_favoritas" class="cuenta-save-5"><?=$currentuser['tv_shows'];?></textarea>
					</div>
				</div>
				<div class="field">
					<label for="musica_favorita">M&uacute;sica favorita</label>
					<div class="input-fake">
						<textarea id="musica_favorita" name="musica_favorita" class="cuenta-save-5"><?=$currentuser['favorite_music'];?></textarea>
					</div>
				</div>
				<div class="field">
					<label for="deportes_y_equipos_favoritos">Deportes y equipos favoritos</label>
					<div class="input-fake">
						<textarea id="deportes_y_equipos_favoritos" name="deportes_y_equipos_favoritos" class="cuenta-save-5"><?=$currentuser['favorite_sports'];?></textarea>
					</div>
				</div>
				<div class="field">
					<label for="libros_favoritos">Libros favoritos</label>
					<div class="input-fake">
						<textarea id="libros_favoritos" name="libros_favoritos" class="cuenta-save-5"><?=$currentuser['favorite_books'];?></textarea>
					</div>
				</div>
				<div class="field">
					<label for="peliculas_favoritas">Peliculas favoritas</label>
					<div class="input-fake">
						<textarea id="peliculas_favoritas" name="peliculas_favoritas" class="cuenta-save-5"><?=$currentuser['favorite_films'];?></textarea>
					</div>
				</div>
				<div class="field">
					<label for="comida_favorita">Comida favorita</label>
					<div class="input-fake">
						<textarea id="comida_favorita" name="comida_favorita" class="cuenta-save-5"><?=$currentuser['favorite_food'];?></textarea>
					</div>
				</div> 
				 <div class="field">
					 <label for="mis_heroes_son">Mis h&eacute;roes son</label>
					 <div class="input-fake">
						 <textarea id="mis_heroes_son" name="mis_heroes_son" class="cuenta-save-5"><?=$currentuser['my_heros'];?></textarea>
					 </div>
				 </div>
				<div class="buttons">
					<input type="button" class="mBtn btnOk" onclick="cuenta.save(5)" value="Guardar" />
				</div>
			</fieldset>
			<div class="clearfix"></div>
		</div>
		<div class="content-tabs opciones" style="display: none">
			<fieldset>
				<div class="alert-cuenta cuenta-6">
				</div>
				<div class="field">
					<div class="input-fake">
						<ul>
							<li><input<?=($currentuser['show_status']=='1' ? ' checked' : '');?> type="checkbox" name="mostrar_estado" class="cuenta-save-6" checked="checked" /> Mostrar mi estado cuando navego el sitio</li>
							<li><input<?=($currentuser['show_search']=='1' ? ' checked' : '');?> type="checkbox" name="participar_busquedas" class="cuenta-save-6" /> Permitir que los usuarios encuentren mi perfil en las busquedas de usuarios</li>
							<li><input<?=($currentuser['newsletter']=='1' ? ' checked' : '');?> type="checkbox" name="recibir_boletin" class="cuenta-save-6" /> Recibir el bolet&iacute;n de novedades de Turinga! por e-mail</li>
                            <li><input<?=($currentuser['autofollow']=='1' ? ' checked' : '');?> type="checkbox" name="autoseguir" class="cuenta-save-6" /> Seguir automaticamente post y temas donde comento</li>
						</ul>
					</div>
				</div>
			</fieldset>
			<div class="buttons">
				<input type="button" class="mBtn btnOk" onclick="cuenta.save(6)" value="Guardar" />
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="content-tabs mis-fotos" style="display: none">
			<fieldset>
				<div class="alert-cuenta cuenta-7"></div>
                    <?php
                    $query = mysql_query("SELECT * FROM `photos` WHERE user = '".$currentuser['id']."' ORDER BY time ASC");
                    while($photo = mysql_fetch_assoc($query)) {
                       echo '<div class="field">
                            <div class="input-fake">
                                <label>Imagen</label>
						        <div class="floatL">
							        <img src="'.htmlspecialchars($photo['url']).'" class="imagen-preview" />
						        </div>
						        <div class="floatL">
							        <input style="width:300px" value="'.htmlspecialchars($photo['url']).'" type="text" class="text" />
							        <textarea class="imagen-desc" style="margin-top:5px;width:300px;">'.htmlspecialchars($photo['desc']).'</textarea>
							        <a onclick="cuenta.imagen.del(this, '.$photo['id'].')" class="misfotos-del">Eliminar</a>
                                </div>
						        <div class="clearfix clearBoth"></div>
					        </div>
                        </div>';
                    }
                    ?>
				 <div class="field">
				    <label>Imagen</label>
					<div class="input-fake">
                        <div class="floatL">
						    <input style="width:300px;" type="text" class="text" value="http://" />
						    <textarea class="imagen-desc" style="margin-top:5px;width:300px;">Descripci&oacute;n de la foto</textarea>
						    <a onclick="cuenta.imagen.add(this)" class="misfotos-add">Agregar</a>
                        </div>
                        <div class="clearfix clearBoth"></div>
					</div>
				</div>				
			</fieldset>
			<div class="clearfix"></div>
		</div>
 
		<div class="content-tabs bloqueados" style="display: none">
			<fieldset>
				<div class="field">
						<ul class="bloqueadosList">
                            <?php
                            $currentuser['blocked_array'] = (empty($currentuser['blocked']) ? array() : explode(',', $currentuser['blocked']));
			                foreach($currentuser['blocked_array'] as $user) {
				                $u = mysql_fetch_assoc(mysql_query("SELECT nick FROM `users` WHERE id = '".$user."'"));
				                echo '<li><a href="/perfil/'.$u['nick'].'">'.$u['nick'].'</a><span><a id="buser_2_'.$user.'" class="desbloqueadosU" href="#" onclick="buser('.$user.', false);return false;" title="Desbloquear usuario">Desbloquear</a><a id="buser_1_'.$user.'" style="display:none;" class="bloqueadosU" href="#" onclick="buser('.$user.', true)" title="Bloquear usuario">Bloquear</a></span></li>';
			                }
                            ?>
							</ul>
							</div>
			</fieldset>
			<div class="clearfix"></div>
		</div>
		<div class="content-tabs cambiar-clave" style="display: none">		
			<fieldset>
				<div class="alert-cuenta cuenta-9">
				</div>
				<div class="field">
					<label for="new_passwd">Contrase&ntilde;a actual:</label>
					<input type="password" class="text cuenta-save-9" id="passwd" name="passwd" maxlength="15" value="" />
				</div>
				<div class="field">
					<label for="passwd">Contrase&ntilde;a nueva:</label>
					<input type="password" class="text cuenta-save-9" id="new_passwd" name="new_passwd" maxlength="15" value="" />
				</div>
				<div class="field">
					<label for="confirm_passwd">Repetir Contrase&ntilde;a:</label>
					<input type="password" class="text cuenta-save-9" id="confirm_passwd" name="confirm_passwd" maxlength="15" value="" />
				</div>
			</fieldset>
			<div class="buttons">
				<input type="button" class="mBtn btnOk" onclick="cuenta.save(9)" value="Guardar" />
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="content-tabs privacidad" style="display: none">
			<fieldset>
				<div class="alert-cuenta cuenta-8"></div>
                <?php
                $shows = array('name' => 'Nombre', 'email' => 'E-Mail', 'birth' => 'Nacimiento', 'messenger' => 'Mensajero', 'meet' => 'Me gustar&iacute;a', 'love' => 'Estado Civil', 'children' => 'Hijos', 'live' => 'Vivo con', 'height' => 'Mi altura', 'weight' => 'Mi peso', 'hair_color' => 'Color de pelo', 'eyes_color' => 'Color de ojos', 'constitution' => 'Complexi&oacute;n', 'diet' => 'Mi dieta', 'tattos_piercings' => 'Tattos/Piercings', 'smoke' => 'Fumo', 'drink' => 'Tomo alcohol', 'studies' => 'Estudios', 'languages' => 'Idiomas', 'work' => 'Profesi&oacute;n', 'company' => 'Empresa', 'work_sector' => 'Sector', 'income' => 'Nivel de ingresos', 'work_interests' => 'Intereses Profesionales', 'work_skills' => 'Habilidades Profesionales', 'my_interests' => 'Mis intereses', 'my_hobbies' => 'Hobbies', 'favorite_music' => 'M&uacute;sica favorita', 'favorite_sports' => 'Deportes y equipos favoritos', 'favorite_books' => 'Libros favoritos', 'favorite_food' => 'Comida favorita', 'favorite_films' => 'Pel&iacute;culas favoritas', 'my_heros' => 'Mis h&eacute;roes');
                foreach($shows as $sh=>$wh) {
                    echo '<div class="field">
                        <label>'.$wh.'</label>
  					    <div class="input-fake">
					        <select class="cuenta-save-8" name="'.$sh.'_mostrar">
					            <option'.($currentuser[$sh.'_show']=='0' ? ' selected' : '').' value="0">Nadie</option>
							    <option'.($currentuser[$sh.'_show']=='1' ? ' selected' : '').' value="1">Mis amigos</option>
						        <option'.($currentuser[$sh.'_show']=='2' ? ' selected' : '').' value="2">Usuarios registrados</option>
						        <option'.($currentuser[$sh.'_show']=='3' ? ' selected' : '').' value="3">Todos</option>
					        </select>
			   	        </div>
                    </div>';
               }
               ?>
			</fieldset>
			<div class="buttons">
				<input type="button" class="mBtn btnOk" onclick="cuenta.save(8)" value="Guardar" />
			</div>
			<div class="clearfix"></div>
		</div>
 
	</form>
</div>
<div class="floatR">
 
	<div class="sidebar-tabs clearbeta">
		<h3>Mi Avatar</h3>
		<div class="avatar-big-cont">
			<div class="avatar-loading" style="display: none"></div>
			<img class="avatar-big" src="/avatares/120/<?=$currentuser['avatar'];?>" alt="" width="120" height="120" />
		</div>
		<div class="webcam-capture" style="display: none; margin: 0 0 0 10px">
			<div class="avatar-loading"></div>
			<!--<!--[if !IE]> -- >
			<object type="application/x-shockwave-flash" data="/capture.swf" width="225" height="140" wmode="transparent">
			<!-- <![endif]-- >
			<!--[if IE]>
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="225" height="140">
			<param name="movie" value="/capture.swf" />
			<!-- >
			<param name="loop" value="true" />
			<param name="menu" value="false" />
			<param name="wmode" value="transparent" />
			<param name="flashvars" value="id=3943721&s=3&crc=b24ad7d135b07f462f555af8adad327213ba3747&texto=Tomar+foto&host=hh.taringa.net/upload.php" />
			<p>Tu navegador no soporta flash</p>
			</object>
			<!-- <![endif]-->
		</div>
		<div class="clearfix"></div>
		<ul class="change-avatar" style="display: none">
			<li class="local-file">
				<span><a onclick="avatar.chgtab(this)">Local</a></span>
				<div class="mini-modal" style="text-align:center;">
					<div class="dialog-m"></div>
					<span>Subir Archivo</span>
                    <input class="browse" size="15" type="file" accept="image/gif,png,jpg,jpeg" id="file-avatar" name="file-avatar" style="width:100%;" /><!--style="position:absolute;top:-1500px;left:-1500px;" onchange="$('#fake-filei').val($(this).val());" />-->
                    <!--<p><input type="text" id="fake-filei" class="text" disabled /><b class="btn_g" id="fake-file" onclick="$('#file-avatar').click();"><span>Examinar...</span></b></p>--><button style="margin-top:3px;" class="avatar-next local mBtn btnOk" onclick="avatar.upload(this)">Subir</button>
				</div>
			</li>
			<li class="webcam-file">
				<span><a onclick="avatar.chgtab(this)">Webcam</a></span>
			</li>
		</ul>
		<div class="clearfix"></div>
		<a class="edit" onclick="avatar.edit(this)">Editar</a>
	</div>
	<div class="clearfix"></div>
	<h3 id="porc-completado-label" style="margin: 25px 0 0; padding: 0">Perfil completo al <?=round($currentuser['percent']);?>%</h3>
	<div id="porc-completado" style="margin-top:5px;text-align:center;font-size:13px;margin-bottom:10px;color:#FFF;text-shadow: 0 1px 0px #000">
		<div style="background: #CCC;padding:2px;line-height:17px">
			<div id="porc-completado-barra" style="width: <?=round($currentuser['percent']);?>%; height:17px;border-right:1px solid #004b8d; border-left: 1px solid #004b8d;background: url('/images/barra.gif') top left repeat-x;">
			</div>
		</div>
	</div>
</div>
</div>
<div style="clear:both"></div>
</div>