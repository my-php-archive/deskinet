<?php
if(!defined('account_define')) { header('Location: /index.php'); }
?>
<iframe name="hit" style="display:none;"></iframe>
<a name="mda"></a>
<div style="display:none;" id="mensajes_div"></div>
<form name="af" method="post" onsubmit="return in_validate_data(this);return false;" action="/blank.html" target="hit">
				<table width="100%" cellpadding="4">
				<tr>
					<td width="23%"  align="right" valign="top"><b>Mis intereses:</b></td>
					<td width="40%"><textarea name="mis_intereses" cols="30" rows="5" id="mis_intereses"><?=$currentuser['my_interests'];?></textarea></td>
					<td width="37%" align="right" valign="top">Mostrar a:
						<select id="mis_intereses_mostrar" name="mis_intereses_mostrar">
							<option <?=($currentuser['my_interests_show'] == '0' ? 'selected ' : '');?>value="nadie">Nadie</option>
							<option <?=($currentuser['my_interests_show'] == '1' ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
							<option <?=($currentuser['my_interests_show'] == '2' ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
							<option <?=($currentuser['my_interests_show'] == '3' ? 'selected ' : '');?>value="todos">A todos</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><b>Hobbies:</b></td>
					<td><textarea name="hobbies" cols="30" rows="5" id="hobbies"><?=$currentuser['my_hobbies'];?></textarea></td>
					<td align="right" valign="top">Mostrar a:
						<select id="hobbies_mostrar" name="hobbies_mostrar">
							<option <?=($currentuser['my_hobbies_show'] == '0' ? 'selected ' : '');?>value="nadie">Nadie</option>
							<option <?=($currentuser['my_hobbies_show'] == '1' ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
							<option <?=($currentuser['my_hobbies_show'] == '2' ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
							<option <?=($currentuser['my_hobbies_show'] == '3' ? 'selected ' : '');?>value="todos">A todos</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><b>Series de Tv favoritas:</b></td>
					<td><textarea name="series_tv_favoritas" cols="30" rows="5" id="series_tv_favoritas"><?=$currentuser['tv_shows'];?></textarea></td>
					<td align="right" valign="top">Mostrar a:
						<select id="series_tv_favoritas_mostrar" name="series_tv_favoritas_mostrar">
							<option <?=($currentuser['tv_shows_show'] == '0' ? 'selected ' : '');?>value="nadie">Nadie</option>
							<option <?=($currentuser['tv_shows_show'] == '1' ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
							<option <?=($currentuser['tv_shows_show'] == '2' ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
							<option <?=($currentuser['tv_shows_show'] == '3' ? 'selected ' : '');?>value="todos">A todos</option>
						</select>
					</td>
				</tr>
				<tr>
					<td width="23%" align="right" valign="top"><b>M&uacute;sica favorita:</b></td>
					<td width="40%"><textarea name="musica_favorita" cols="30" rows="5" id="musica_favorita"><?=$currentuser['favorite_music'];?></textarea></td>
					<td width="37%" align="right" valign="top">Mostrar a:
						<select id="musica_favorita_mostrar" name="musica_favorita_mostrar">
							<option <?=($currentuser['favorite_music_show'] == '0' ? 'selected ' : '');?>value="nadie">Nadie</option>
							<option <?=($currentuser['favorite_music_show'] == '1' ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
							<option <?=($currentuser['favorite_music_show'] == '2' ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
							<option <?=($currentuser['favorite_music_show'] == '3' ? 'selected ' : '');?>value="todos">A todos</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><b>Deportes y equipos favoritos:</b></td>
					<td><textarea name="deportes_y_equipos_favoritos" cols="30" rows="5" id="deportes_y_equipos_favoritos"><?=$currentuser['favorite_sports'];?></textarea></td>
					<td align="right" valign="top">Mostrar a:
						<select id="deportes_y_equipos_favoritos_mostrar" name="deportes_y_equipos_favoritos_mostrar">
							<option <?=($currentuser['favorite_sports_show'] == '0' ? 'selected ' : '');?>value="nadie">Nadie</option>
							<option <?=($currentuser['favorite_sports_show'] == '1' ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
							<option <?=($currentuser['favorite_sports_show'] == '2' ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
							<option <?=($currentuser['favorite_sports_show'] == '3' ? 'selected ' : '');?>value="todos">A todos</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><b>Libros Favoritos:</b></td>
					<td><textarea name="libros_favoritos" cols="30" rows="5" id="libros_favoritos"><?=$currentuser['favorite_books'];?></textarea></td>
					<td align="right" valign="top">Mostrar a:
						<select id="libros_favoritos_mostrar" name="libros_favoritos_mostrar">
							<option <?=($currentuser['favorite_books_show'] == '0' ? 'selected ' : '');?>value="nadie">Nadie</option>
							<option <?=($currentuser['favorite_books_show'] == '1' ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
							<option <?=($currentuser['favorite_books_show'] == '2' ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
							<option <?=($currentuser['favorite_books_show'] == '3' ? 'selected ' : '');?>value="todos">A todos</option>
						</select>
					</td>
				</tr>
				<tr>
					<td width="23%"  align="right" valign="top"><b>Pel&iacute;culas favoritas:</b></td>
					<td width="40%"><textarea name="peliculas_favoritas" cols="30" rows="5" id="peliculas_favoritas"><?=$currentuser['favorite_films'];?></textarea></td>
					<td width="37%" align="right" valign="top">Mostrar a:
						<select id="peliculas_favoritas_mostrar" name="peliculas_favoritas_mostrar">
							<option <?=($currentuser['favorite_films_show'] == '0' ? 'selected ' : '');?>value="nadie">Nadie</option>
							<option <?=($currentuser['favorite_films_show'] == '1' ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
							<option <?=($currentuser['favorite_films_show'] == '2' ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
							<option <?=($currentuser['favorite_films_show'] == '3' ? 'selected ' : '');?>value="todos">A todos</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><b>Comida favor&iacute;ta:</b></td>
					<td><textarea name="comida_favorita" cols="30" rows="5" id="comida_favorita"><?=$currentuser['favorite_food'];?></textarea></td>
					<td align="right" valign="top">Mostrar a:
						<select id="comida_favorita_mostrar" name="comida_favorita_mostrar">
							<option <?=($currentuser['favorite_food_show'] == '0' ? 'selected ' : '');?>value="nadie">Nadie</option>
							<option <?=($currentuser['favorite_food_show'] == '1' ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
							<option <?=($currentuser['favorite_food_show'] == '2' ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
							<option <?=($currentuser['favorite_food_show'] == '3' ? 'selected ' : '');?>value="todos">A todos</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><b>Mis h&eacute;roes son:</b></td>
					<td><textarea name="mis_heroes_son" cols="30" rows="5" id="mis_heroes_son"><?=$currentuser['my_heros'];?></textarea></td>
					<td align="right" valign="top">Mostrar a:
						<select id="mis_heroes_son_mostrar" name="mis_heroes_son_mostrar">
							<option <?=($currentuser['my_heros_show'] == '0' ? 'selected ' : '');?>value="nadie">Nadie</option>
							<option <?=($currentuser['my_heros_show'] == '1' ? 'selected ' : '');?>value="amigos">Mis Amigos</option>
							<option <?=($currentuser['my_heros_show'] == '2' ? 'selected ' : '');?>value="registrados">Usuarios Registrados</option>
							<option <?=($currentuser['my_heros_show'] == '3' ? 'selected ' : '');?>value="todos">A todos</option>
						</select>
					</td>
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