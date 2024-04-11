<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
if($groupdie) {
	die(error('OOPS!', 'La comunidad no existe', 'Ir al &iacute;ndice de comunidades', '/comunidades/'));
}
?>
<div id="cuerpocontainer">
<div class="comunidades">
 
<div class="breadcrump">
<ul>
<li class="first"><a href="/comunidades/" title="Comunidades">Comunidades</a></li><li><a href="/comunidades/cat/<?=$cat['urlname'];?>/" title="<?=$cat['name'];?>"><?=$cat['name'];?></a></li><li><?=htmlspecialchars($group['name']);?></li><li class="last"></li>
</ul>
</div>
 
<div class="denunciar"><a href="#" onclick="denuncia_publica();return false;" title="Denunciar">Denunciar</a></div>
	<div style="clear:both"></div>
 
 
<div id="izquierda">
<?php include('./Pages/groups-left.php');?>
 
<div class="ads120-240">
<?=advert('120x240');?>
</div>
</div>
<div id="centro">
 
				<div class="bubbleCont">
			<div id="ComInfo" class="Container">
			  <div class="floatL">
				  <h1 style="*padding: 5px"><?=nl2br(htmlspecialchars($group['name']));?></h1>
        </div>
        <div class="verMas">
  				<a id="aVerMas" href="#" onclick="datos_comunidad_ver();return false;">Ver m&aacute;s &raquo;</a>
  			</div>
				<div class="clearfix"></div>
				<br class="spacer"/>
 
				<div class="dataRow">
					<p class="dataLeft">Descripci&oacute;n</p>
					<p class="dataRight">
						<?=htmlspecialchars($group['description']);?>					</p>
					<div style="clear:both"></div>
				</div>
				<div id="cMasInfo" style="display:none;">
				<div class="dataRow">
					<p class="dataLeft">Categor&iacute;a</p>
					<p class="dataRight">
						<a href="/comunidades/home/<?=$cat['urlname'];?>/" title="<?=$cat['name'];?>"><?=$cat['name'];?></a> > <?=$subcat['name'];?>					</p>
					<div class="clearBoth"></div>
				</div>
 
				<div class="dataRow">
					<p class="dataLeft">Creador</p>
					<p class="dataRight">
						<a title="Ver el perfil de <?=$creator['nick'];?>" href="/perfil/<?=$creator['nick'];?>/"><?=$creator['nick'];?></a>
					</p>
					<div class="clearBoth"></div>
				</div>	
 
 
				<div class="dataRow">
					<p class="dataLeft">Tipo</p>
					<p class="dataRight">
						<?=($group['private'] == '1' ? 'S&oacute;lo los registrados pueden ver la comunidad' : 'Todos pueden ver la comunidad');?>					</p>
					<div class="clearBoth"></div>
				</div>
 
				<div class="dataRow">
					<p class="dataLeft">Tipo de validaci&oacute;n</p>
					<p class="dataRight">
						Los nuevos miembros son aceptados automaticamente<br />Con el rango <b><?=groupRankName($group['default_rank']);?></b>					</p>
					<div class="clearBoth"></div>
				</div>
 
				<div class="dataRow">
					<p class="dataLeft">Creada</p>
					<p class="dataRight" title="<?=udate('d.m.Y', $group['time']);?> a las <?=udate('H:i', $group['time']);?> hs.">
						<?=timeFrom($group['time']);?>					</p>
					<div class="clearBoth"></div>
				</div>
				</div>
			</div>
		
		</div><!-- COMUNIDAD DATA -->
        <?php
		$query = mysql_query("SELECT * FROM `group_posts` WHERE `group` = '".$group['id']."' && sticky != '0' ORDER BY sticky DESC");
		if(mysql_num_rows($query)) {
		?>
        <br class="spacer" />
 
			<div class="bubbleCont">
				<div class="Container">
					<h1>Importantes</h1>
					<table style="clear:both" cellpadding="0" cellspacing="0">
						<tr>
							<td class="thead"></td>
							<td class="thead titulo">Titulo</td>
							<td class="thead" style="text-align:right;width:120px">Creado</td>
							<td class="thead">Respuestas</td>
						</tr>
                    <?php
					$color = 1;
					while($post = mysql_fetch_array($query)) {
						$author = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$post['author']."'"));
						echo '<tr class="temas color'.$color.'">
							<td>
								<img src="/images/page.png" />
							</td>
							<td class="temaTitulo">
								<a href="/comunidades/'.$group['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a><br />
								<span class="small color_gray">Por <a href="/perfil/'.$author['nick'].'">'.$author['nick'].'</a></span>
							</td>
							<td class="datetema" style="text-align:right" title="'.udate('d.m.Y', $post['time']).' a las '.udate('H:i', $post['time']).' hs.">
								'.timefrom($post['time']).'							</td>
							<td class="datetema">
							  '.mysql_num_rows(mysql_query("SELECT id FROM `group_comments` WHERE post = '".$post['id']."'")).'</td>
						</tr>';
						$color = ($color == 1 ? 2 : 1);
					}
					?>
					</table>  
					<div class="clearBoth"></div>
				</div>
		</div>
		<? } /*IMPORANTES ROWS */ ?>
 
<br class="spacer" />
<? if(!$currentuser['isMember']) { ?>
<div class="emptyData">
  Para poder participar en esta comunidad necesitas ser parte de la misma.<br />Para eso tienes que <a href="#" onclick="participar_comunidad(<?=$group['id'];?>, '<?=groupRankName($group['default_rank']);?>');return false;">unirte</a>
</div>
<br class="spacer" />
<? } ?>
	<div class="bubbleCont">
	<div id="ComInfo" class="Container">
	<a href="/rss/comunidades/<?=$group['urlname'];?>/" style="display:block; float:left; margin-top:4px" title="&Uacute;ltimos Temas"><span class="systemicons sRss" style="position: relative; z-index: 87;"></span></a>
	  <h1 class="floatL">Temas</h1>
        <?php
		if($currentuser['isMember'] && $currentuser['group']['rank'] > 0) {
			?>
        <div class="floatR">
      <input type="button" class="mBtn btnYellow nuevoTema" onclick="location.href='/comunidades/<?=$group['urlname'];?>/agregar/'" value="Nuevo Tema"/>	
    </div>
    <? } ?>
            		<div class="clearBoth"></div>
 
						<div class="clearBoth"></div>
                        <br class="clear" />
                        <?php
		$query = mysql_query("SELECT * FROM `group_posts` WHERE `group` = '".$group['id']."' ORDER BY time DESC");
		if(mysql_num_rows($query)) {
			echo '<table style="clear:both" cellpadding="0" cellspacing="0">
						<tr>
							<td class="thead"></td>
							<td class="thead titulo">Titulo</td>
							<td class="thead" style="text-align:right;width:120px">Creado</td>
							<td class="thead">Respuestas</td>
						</tr>';
					$color = 1;
					while($post = mysql_fetch_array($query)) {
						$author = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$post['author']."'"));
						echo '<tr class="temas color'.$color.'">
							<td>
								<img src="/images/page.png" />
							</td>
							<td class="temaTitulo">
								<a href="/comunidades/'.$group['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a><br />
								<span class="small color_gray">Por <a href="/perfil/'.$author['nick'].'">'.$author['nick'].'</a></span>
							</td>
							<td class="datetema" style="text-align:right" title="'.udate('d.m.Y', $post['time']).' a las '.udate('H:i', $post['time']).' hs.">
								'.timeFrom($post['time']).'							</td>
							<td class="datetema">
							  '.mysql_num_rows(mysql_query("SELECT id FROM `group_comments` WHERE post = '".$post['id']."'")).'</td>
						</tr>';
						$color = ($color == 1 ? 2 : 1);
					}
					?>
					</table>  
					<div class="clearBoth"></div>
<!--				</div>
		</div>-->
		<? } else { ?>
				<div class="emptyData">
		No hay m&aacute;s temas				</div>
        <? } ?>
		
		<div class="pages"><!-- Paginado -->
				<div class="clearBoth"></div>
		</div>
	</div>
</div>
 
</div>
<div id="derecha">
    <div class="ult_respuestas">
		<div class="box_title">
			<div class="box_txt ultimos_comentarios">&Uacute;ltimas respuestas</div>
			<div class="box_rss">
				<a href="#" onclick="update_last_comments('<?=$cat['id'];?>', '<?=$group['id'];?>');return false;">
					<span class="systemicons actualizar"></span>
				</a>
			</div>
		</div>
		<div class="box_cuerpo" id="ult_comm">
						<?php
						include('./ajax/group-lastcomments.php');
						?>
		</div>
	</div>
	<br class="space">
	<div class="box_title">
		<div class="box_txt">&Uacute;ltimos Miembros</div>
		<div class="box_rrs"><div class="box_rss"></div></div>
	</div>
	<div class="box_cuerpo">
		<?php include('./ajax/group-lastmembers.php'); ?>
		<p class="verMas"><a href="/comunidades/<?=$group['urlname'];?>/miembros/">Ver m&aacute;s &raquo;</a></p>
		<div class="clearBoth"></div>
	</div>
</div>
</div><div style="clear:both"></div>
</div> <!-- cuerpocontainer -->