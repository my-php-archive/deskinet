<?php
include("../header.php");
$titulo	=	$descripcion;
cabecera_normal();
?><div id="cuerpocontainer">
<!-- inicio cuerpocontainer -->
<script type="text/javascript">
var buscador = {
	section: 'Posts',
	change_section: function(section){
		if(section==this.section)
			return;

		var google_aux1 = (section=='Posts' && this.posts.tipo=='google') ? '2' : '';
		var google_aux2 = (this.section=='Posts' && this.posts.tipo=='google') ? '2' : '';
		$('#Select'+section+'2 input[name="q'+google_aux1+'"]').val( $('#Select'+this.section+'2 input[name="q'+google_aux2+'"]').val() );

		$('#s'+this.section).removeClass('selected');
		$('#s'+section).addClass('selected');

		$('#Select'+this.section+'1').hide();
		$('#Select'+section+'1').show();

		$('#Select'+this.section+'2').hide();
		$('#Select'+section+'2').show();

		$('#Tops'+section).fadeIn();
		$('#Tops'+this.section).fadeOut();

		$('#Select'+section+'2 input[name="q'+((section=='Posts' && this.posts.tipo=='google') ? '2' : '')+'"]').focus();

		this.section = section;
	},

	/*** Section Posts ***/
	posts: {

	tipo: 'google',
	onsubmit: function(){
		if(this.tipo=='google')
			$('#SelectPosts2 input[name="q"]').val($('#SelectPosts2 input[name="q2"]').val());
	},
	select: function(tipo){
		if(this.tipo==tipo)
			return;

		//Cambio de action form
		$('#SelectPosts2 form[name="buscador"]').attr('action', '/posts/buscador/'+tipo+'/');

		//Cambio here en <a />
		$('#SelectPosts1 a#select_' + this.tipo).removeClass('here');
		$('#SelectPosts1 a#select_' + tipo).addClass('here');

		//Cambio de logo
		$('#SelectPosts1 img#buscador-logo-'+this.tipo).css('display', 'none');
		$('#SelectPosts1 img#buscador-logo-'+tipo).css('display', 'inline');

		//Muestro/oculto los input google
		if(tipo=='google'){ //Ahora es google
			$('#SelectPosts2 input[name="q"]').attr('name', 'q2');
			$('#SelectPosts2 form[name="buscador"]').append('<input type="hidden" name="q" value="" /><input type="hidden" name="cx" value="partner-pub-5717128494977839:armknb-nql0" /><input type="hidden" name="cof" value="FORID:10" /><input type="hidden" name="ie" value="ISO-8859-1" />');
		}else if(this.tipo=='google'){ //El anterior fue google
			$('#SelectPosts2 input[name="q"]').remove();
			$('#SelectPosts2 input[name="cx"]').remove();
			$('#SelectPosts2 input[name="cof"]').remove();
			$('#SelectPosts2 input[name="ie"]').remove();
			$('#SelectPosts2 input[name="q2"]').attr('name', 'q');
		}

		this.tipo = tipo;
		//Foco en input query
		if(this.tipo=='google')
			$('#SelectPosts2 input[name="q2"]').focus();
		else
			$('#SelectPosts2 input[name="q"]').focus();
	}
	},
	/*** FIN - Section Posts ***/

	/*** Section Comunidades ***/
	comunidades: {

	tipo: 'comunidades',
	onsubmit: function(){
	},
	select: function(tipo){
		if(this.tipo==tipo)
			return;

		//Cambio de action form
		$('#SelectComunidades2 form[name="buscador"]').attr('action', '/comunidades/buscador/'+tipo+'/');

		//Cambio here en <a />
		$('#SelectComunidades1 a#select_' + this.tipo).removeClass('here');
		$('#SelectComunidades1 a#select_' + tipo).addClass('here');

		this.tipo = tipo;
		//Foco en input query
		$('#SelectComunidades2 input[name="q"]').focus();
	}
	}
	/*** FIN - Section Comunidades ***/
}
</script>

<div class="post-deleted notFound">
	<div class="content-splash">
	<h3>Oops, lo que estas buscando no esta por aqui!</h3>
	Pero no te escapes, aun podes seguir buscandolo..

	<div class="searchFil">
		<div style="margin-bottom: 5px;">
				<div class="tabs404">
					<ul>
						<li class="selected" id="sPosts"><a href="javascript:buscador.change_section('Posts')">Posts</a></li>
						<li id="sComunidades"><a href="javascript:buscador.change_section('Comunidades')">Comunidades</a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<style>
				.tabs404 {
					border-bottom:1px solid #CCC;
					margin-bottom:12px;
				}

				.tabs404 li {
					float:left;
					margin-right: 10px;
					margin-bottom:-1px;
				}

				.tabs404 li a {
					display: block;
					padding: 7px 14px;
					border-right: 1px solid #CCC;
					border-left: 1px solid #CCC;
					border-top: 1px solid #CCC;
					border-bottom: 1px solid #CCC;

					font-size: 14px;
					background: #EEE;
					font-weight: bold;
					color:#004a95;
				}

				.tabs404 li.selected a {
					background: #FFF;
					color:#000;
					border-bottom: 1px solid #FFF;
				}
				
				#TopsPosts, #TopsComunidades {
					position: absolute;
				}
				#TopsComunidades {
					display: none;
				}
				</style>

			<div id="SelectPosts1">
				<div class="logoMotorSearch">
					<img id="buscador-logo-google" src="http://www.google.com/images/poweredby_transparent/poweredby_FFFFFF.gif" alt="google-search-engine" />
					<img id="buscador-logo-taringa" src="/images/taringaFFF.gif" alt="downgrade-search-engine" style="display:none" />
					<img id="buscador-logo-tags" src="/images/taringaFFF.gif" alt="tags-search-engine" style="display:none" />
				</div>
				<label class="searchWith">
											<a id="select_google" class="here" href="javascript:buscador.posts.select('google')">Google</a><span class="sep">|</span>
										<a id="select_taringa" href="javascript:buscador.posts.select('taringa')">Downgrade!</a><span class="sep">|</span>
					<a id="select_tags" href="javascript:buscador.posts.select('tags')">Tags</a>
				</label>
			</div>
			<div id="SelectComunidades1" style="display:none">
				<div class="logoMotorSearch">
					<img id="buscador-logo-taringa" src="/images/taringaFFF.gif" alt="downgrade-search-engine" />
				</div>
				<label class="searchWith">
					<a id="select_comunidades" class="here" href="javascript:buscador.comunidades.select('comunidades')">Comunidades</a><span class="sep">|</span>
					<a id="select_temas" href="javascript:buscador.comunidades.select('temas')">Temas</a>
				</label>
			</div>

			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>

		<div class="boxBox">
			<div class="searchEngine">
				<div id="SelectPosts2">
					<form style="padding:0;margin:0" name="buscador" method="GET" action="/posts/buscador/google/" onsubmit="window.buscador.posts.onsubmit();">
						<input type="text" name="q2" size="25" class="searchBar" value="" />
						<input type="submit" class="mBtn btnOk" value="Buscar" title="Buscar" />
						<input type="hidden" name="q" value="" /><input type="hidden" name="cx" value="partner-pub-5717128494977839:h5hvec-zeyh" /><input type="hidden" name="cof" value="FORID:10" /><input type="hidden" name="ie" value="ISO-8859-1" />
					</form>
				</div>
				<div id="SelectComunidades2" style="display:none">
					<form style="padding:0;margin:0" name="buscador" method="GET" action="/comunidades/buscador/comunidades/" onsubmit="window.buscador.comunidades.onsubmit();">
						<input type="text" name="q" size="25" class="searchBar" value="" />
						<input type="submit" class="mBtn btnOk" value="Buscar" title="Buscar" />
					</form>
				</div>
				<div class="clearfix"></div>
			</div>
			<!-- End Filter -->

			<!-- End SearchFill -->
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>

	<h4>..o visitar el mejor contenido de la semana:</h4>
	<ul id="TopsPosts">
<?php
			  	$sql = "SELECT p.titulo, p.puntos, p.categoria, p.id, p.fecha, c.id_categoria, c.nom_categoria, c.link_categoria ";
				$sql.= "FROM (posts AS p, categorias AS c) WHERE p.categoria=c.id_categoria AND p.elim=0 ORDER BY p.puntos DESC LIMIT 15 ";
				$rs = mysql_query($sql, $con);
while($row = mysql_fetch_array($rs))
{
$id = $row['id'];
$link_categoria = $row['link_categoria'];
$titulop	=	$row['titulo'];
$fecha	=	$row['fecha'];
$puntos = $row['puntos'];
$cant = strlen($titu);
if($cant > 41)
{
$titulo2=substr(stripslashes($titulop), 0, 38);
$tit=1;
}
else
{
$titulo2=$titulop;
$tit=0;
}
?>

<li class="categoriaPost clearfix <?php echo $link_categoria; ?>">
 <a href='/posts/<?php echo $link_categoria; ?>/<?php echo $id; ?>/<?php echo corregir($titulop); ?>.html' alt = '<?php echo $titulop; ?> - <?php echo $fecha; ?>' title = '<?php echo $titulop; ?> - <?php echo $fecha; ?>' ><?echo $titulo2; if ($tit==1) echo"...";?></a></li>
<?php
}
?>
		</ul>

	<ul id="TopsComunidades">
<?php 
$sqldult=$db->query("SELECT t.*,co.*,us.nick,ca.* FROM c_temas t LEFT JOIN c_comunidades co ON co.idco=t.idcomunid LEFT JOIN usuarios us ON us.id=t.id_autor LEFT JOIN c_categorias ca ON ca.id_categoria=co.categoria WHERE 1=1 {$cat_condition} ORDER BY t.visitaste DESC LIMIT 15");
$existec=$db->num_rows($sqldult);
if($existec==0){
echo "<div class='emptyData'>Nada Por Aqu&iacute;...</div>";
}
else{
while($temas=$db->fetch_array($sqldult))
{
	echo'
	<li class="clearfix categoriaCom '.$temas['link_categoria'].'">
				<a title="'.$temas['link_categoria'].' | '.$temas['titulo'].'" class="titletema" href="/comunidades/'.$temas['shortname'].'/'.$temas['idte'].'/'.corregir($temas['titulo']).'.html">'.$temas['titulo'].'</a>
			</li>';
}}
$db->free_result($sqldulc);
?>
		</ul>
</div>
</div>

<style type="text/css" media="screen">
	.content-splash {
		width: 530px;
		height: 600px;
	}
	.searchFil {
		margin-top: 20px;
	}
	
	.content-splash li.categoriaCom {
		height: 16px;
		border: none;
	}
	
	.content-splash li .titletema{
				font-size:14px;
	}
</style><div style="clear:both"></div>
<!-- fin cuerpocontainer -->
<?php
pie();
?>