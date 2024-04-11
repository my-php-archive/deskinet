/*
Todos sabemos que está basado en taringa, no tokes los webos con que quité el "logotipo" ¬¬
*/

body {
  padding:0;
  margin: 10px 0 0 0;
	line-height:1.3em;
	font-family: 'Lucida Grande',Tahoma,Arial,Verdana,Sans-Serif; 
	font-size:11px;	
  background: #f4f4f4;
}

.floatL{
	float:left;
}
input:active {
  outline:0;
}

.floatR{
	float:right;
}

.color_red{
	color:red!important;
}

.color_green{
	color:green!important;
}

.color_blue{
	color:blue;
}

.color_gray, .color_gray a {
	color: gray!important;
}

.clearBoth:after {
	content: ".";
	display: block;
	clear: both;
	visibility: hidden;
	line-height: 0;
	height: 0;
}
 
html[xmlns] .clearBoth {
	display: block;
}
 
* html .clearBoth {
	height: 1%;
}

a img {
	border: 0;
}

/****** TEXTOS ******/

a:link{
	text-decoration:none;
	color:#333;
}

a:visited{
	text-decoration:none;
	color:#333;
}

a:active{
	color:#333;
}

a:hover{
	text-decoration:underline;
	color:#000000;
}


ul{
	margin:0;
	padding:0;
	list-style:none;
  list-style-position:inside;
	list-style-type:disc;
}

h1{
	font-size:11px; 
	font-weight:normal;

}

.size9{
	font-size:9px; 
}

.size10{
	font-size:10px; 
}

.size12{
	font-size:12px; 
}

.size13{
	font-size:13px; 
}

.size14{
	font-size:14px; 
}

.size15{
	font-size:15px; 
}

hr {
	background:#CCC;
	color:#CCC;
	height:1px;
	border:0 none;
}

#logo{
  width: 270px;
  height: 60px;
	float:left;
}

#logoi{
  width: 270px;
  height: 48px;
	background: url('/images/logoBeta.png') no-repeat;
	float:left;
	margin-top: 11px;
}


#logoi:hover {
	background-position: 0 -50px;
}

#br_logoi{
	width: 270px;
	height: 60px;
	background: url('/images/br_logo.gif') no-repeat;
	float:left;
}

#logo img{
  display: none;
}

#maincontainer{
	background: url('/images/maincontainerbg.gif') repeat-x #004a95;
	width:960px;
	height:auto; 
	padding: 0 12px;
	margin:0 auto;
	position:relative;
}
* html #maincontainer{
	margin-top: -1px;
}
#head{
	height:70px; 
}

/* BANNERS */

#banner{
	float:right;
	text-align:top;
	width:468px;
	height:70px; 
}

.banner.728x90{
	text-align:center;
	height:90px;
}

.banner.160x600{
	float:left;
	margin-left:20px;
	width:160px;
}

.box_txt.publicidad_ultimos_comentarios_de{
	width:190px;
}

/*
#menu{
	clear:left;
	width:100%;
	height:30px; 
	background: #CCCCCC url('/images/bg-menu.gif') repeat-x;
	text-align:center;
	line-height:265%;
	color: #999;
	border-bottom: 1px solid #909090;
}

*/

.menu_izq {
	margin: auto;
	width: 380px;
	position: relative;
	float: left;
	height: 30px;
	vertical-align: middle;
	background: url(/images/menu_left_corner.gif) no-repeat top left;
	text-align: left;
	padding-left: 10px;
}
.menu_centro {
	width: 350px;
	float: left;
}

a.logina{
	color: #654006;
	font-weight:bold;
	padding-left: 20px;
	background: url(/images/iconIdentificate.png) no-repeat center left;
	text-shadow: #fbeebc 0 1px 0;
	font-size: 12px;

}

.here a.logina {
  color:#1f1f02;
  text-shadow: #eee 0 1px 0;
	
}
.loginb {
	background: url(/images/loginCorner.gif) no-repeat top right;
	text-align:center;
	padding: 8px 15px 0 15px;
} 
.menu_der {
	width: 217px;
	float: right;
	padding-right: 3px;
	padding-top: 3px;
	background: url(/images/menu_right_corner.gif) no-repeat top right;
}
	
#categoria {
	float:right;
	margin:2px 10px 0 0;
}

#mensaje-top{
	clear:left;
	width:100%!important;
	height:24px; 
	line-height:200%;
	background:#ffe13e url('/images/mensajetopbg.gif') repeat-x bottom left;
	text-align:center;
	border-top:1px solid #ffe970;
	display:block;
}

.msgtxt{
	float:left;
	width:920px;

	line-height:200%;
}

.msgtxt_cerrar{
	float:right;
	width:20px;
	height:20px;
	padding:2px;
}

#post_agregar #mensaje-top{
	width: 675px!important;
}

#post_agregar .box_cuerpo.registrarse{
  width:558px !important;
}

#pie{
	clear:left;
	width:100%;
	padding:6px 0;
	text-align:center;
	color: #e1e1e1;
}

#pie a {
	color: #FFF;
}
#cuerpocontainer{
	background: #FFFFFF repeat-x;
	width:940px; 
	height:auto; 
	padding:10px;
	-moz-border-radius-bottomleft:5px;
	-moz-border-radius-bottomright:5px;
	-webkit-border-bottom-right-radius:5px;
	-webkit-border-bottom-left-radius:5px;
}

#cuerpocontainer.c15 { margin-top: -15px; }

#centro{
	padding:2px;
	padding-left:6px;
	padding-right:6px;
	float:left;
	width:290px;
	height:auto;
	overflow:hidden;
}

.comunidades .home #izquierda{
	padding:0;
	float:left;
	width:160px;
	height:auto;
	overflow:hidden;
}

.comunidades .home #centro{
	padding:0;
	float:left;
	width:514px;
}

.comunidades .home #derecha{
	padding:0;
	float:left;
	width:250px;
	height:auto;
	overflow:hidden;
}

	* html #centro {
		width: 284px;
		margin-right: 6px;
	}
	
#izquierda{
	float:left;
	height:auto;
	padding: 2px;
	width:380px;
	overflow: hidden; 
}


	
	#izquierda .size13 {
		font-weight:bold;
	}
	

	
#derecha {
	padding:2px;
	float:left;
	height:auto;
	width:250px; 
	overflow:visible;
}

	* html #derecha {
		width: 248px;
	}
	
/****** POST  ******/

#post-izquierda, .comunidades #izquierda {
	padding:2px;
	float:left;
	height:auto;
	width:160px;
	overflow:visible;
}

	* html #post-izquierda {
		overflow:hidden;
		width:158px;
	}

#post-centro {
	padding:2px;
	padding-left:6px;
	padding-right:6px;
	float:right;
	width:760px;
	height:auto;
	overflow:hidden;
}

	* html #post-centro .box_title {
		width: 760px;
	}


#post_agregar{
	padding:0 6px;
	float:left;
	width:675px;
	height:auto;
}

#post_agregar .box_title {
	width: 100%!important;
}

#post_agregar .box_cuerpo {
	height:auto !important;
	width:659px !important;
}

#centroComunidad #post_agregar {
  width: 100%!important;
}

#centroComunidad #post_agregar .box_cuerpo {
  width: 744px!important;
}

#post_editar{
	margin-top:6px;
	width:760px;
}

.box_txt.mod_edit_post{
	width:742px;
	height:18px;
	text-align:center;
	font-size:12px
}

#post_editar .box_cuerpo{
	width:744px;
	float:left;
}

.imagen {
	 max-width:740px;
   width: expression(this.width > 740 ? 740: true);
}

.cita {
	padding: 5px!important;
	font-weight:bold;
	height:auto!important;
}

blockquote blockquote {
  margin: 0;
}

blockquote p {
  margin:0;
  padding:0;
}

.citacuerpo{
	border-top:0px solid #F0F0F0;
	border:1px solid #CCC;
	background: #FFF url('/images/bg-box.gif') repeat-x;
	padding: 8px;
	overflow: hidden;
}

#respuestas {
  margin-top:20px;
  clear:both;
}

#respuestas blockquote {
  margin: 0 10px;
}
#respuestas .cita {
  background:none;
  padding:0!important;
  font-weight:none;
  font-weight:normal;
}

#respuestas .citacuerpo {
  background: #e7e7e7  url('/images/quote-start.gif') no-repeat 5px 5px;
  border: 1px solid #dedede;
  padding:8px 8px 8px 35px;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
}

#respuestas .citacuerpo p {
  background: url('/images/quote-end.gif') no-repeat right bottom;
  width:100%;
}


#respuestas blockquote blockquote {
  display:none;
}

.desplegable{
	width:190px;
	float:left;
	text-align:	left;
}

.link.patrocinados{
	color:#3c3c3c;
	font-size:12px;
	font-weight:bold!important;
}

#post-izquierda .box_perfil {
	background-position: -920px bottom;
	padding:18px;
	margin:0 auto;
}

.temaBubble .avatar{
  width: 100px;
  height: 100px;
  border-bottom: 1px solid #FFF;
  display: inline;
} 
.avatar{
	display:block;
	margin: auto;
	width:120px;
	border:none;
}

.txt_post{
	color:#444444;
	font-size:11px;
	font-weight:bold;
	text-align:center;
}

input.login, .button {
	background:#004A95;
	font-weight:bold;
	border-color:#D9DFEA #0E1F5B #0E1F5B #D9DFEA;
	border-style:solid;
	border-width:1px;
	color:#FFFFFF;
	font-family:"lucida grande",tahoma,verdana,arial,sans-serif;
	font-size:11px;
	padding:2px 15px 3px;
	text-align:center;
}

input.button {
	border-style:solid;
	border-color:#CCCCCC;
	border-width:1px;
}

/***** estilos *****/

.txt{
	font-family:Verdana, sans-serif;
	font-size:12px;
	color:#717171;
}

.box_title, .cita {
	background:#dbdbda repeat-x url('/images/box_titlebg.gif');
	padding:0px;
	height:25px;
	-moz-border-radius-topleft: 5px;
	-moz-border-radius-topright: 5px;
	-webkit-border-top-left-radius: 5px;
  	-webkit-border-top-right-radius: 5px;
}

.box_rss {
  /*	background-image:url('/images/cor-der.gif'); */
  float:right;
  padding-right:8px;
  padding-top:4px;
  }

.box_txt, .box_txt_perfil_izq, .box_txt_perfil_der{
	/* background-image:url('/images/cor-izq.gif'); */
	background-repeat:no-repeat;
	text-shadow:0 1px 0 #CCCCCC;
	float:left;
	padding: 5px 0 0 10px;
	font-weight:bold;
	color:#464646;
	font-size: 12px;
}

.box_cuenta{
	background-image:url('/images/bg-box-gris.gif');
	background-repeat:repeat-x;
	background-color:#ebebec;
	padding:0px;
	padding:8px;
	margin:0 auto;
	white-space: normal;
}

.box_cuerpo {
	background:#e7e7e7;
	padding:8px;
	margin:0 auto;
	white-space: normal;
	border-bottom: 1px solid #CCC;
	-moz-border-radius-bottomleft: 5px;
	-moz-border-radius-bottomright: 5px;
	-webkit-border-bottom-right-radius:5px;
	-webkit-border-bottom-left-radius:5px;
}

.box_cuerpo div.filterBy {
  font-weight: bold;
  text-align:right;
  padding: 5px;
  color: #717171;
  background: #CFCFCF;
  border-bottom:1px solid #CCC;
  -webkit-border-radius:0;
  -moz-border-radius:0;
}

div.filterBy input {
  vertical-align: middle;
  margin: 0;
}

.com_populares ol li a {
  width: 100px;
  overflow:hidden;
  height:16px;
}
.box_cuerpo div.filterBy a {
  color:#2F2F2F;
}

.box_cuerpo div.filterBy a.here {
  color:#FFF;
  background:#8c8c8c;
  -moz-border-radius: 8px;
  -webkit-border-radius:7px;
  padding:1px 8px;
  font-weight:bold;
}



.box_cuerpo ol.filterBy {
  position: absolute;
  visibility: hidden;
}
.box_cuerpo ol.filterBy#posts_filterBySemana {
	display: block;
}
.box_cuerpo ol.filterBy#users_filterByMes {
	display: block;
}
.box_cuerpo ol.filterBy#groups_filterBySemana {
	display: block;
}
.box_cuerpo ol {
  padding:0 12px 0 35px;
  margin:5px 0;
}


.box_cuerpo ol li {
  list-style: decimal-leading-zero;
  *list-style:decimal;
}





.listDisc {
  padding-left:20px
}

.listDisc li {
  list-style:disc;
}

ul.numberList  {
  padding:0 8px 0 28px
}

ul.numberList li {
  list-style: decimal-leading-zero;
}


.comentarios_container {
	overflow:hidden;
}
/*
.comentarios_container .comentario {
  border-bottom:1px solid #EEEEEE;
  margin-top:10px;
  padding-bottom:10px;
}

*/

.comentarios_wrapper{
	width:100%;
	float:left;
	margin-top:11px;
}
.agregar_comentario {
  padding-top: 12px;
}
.box_cuerpo.agregar_comm_izq{
	width:505px;
	float:left;
	padding-top:0px;
	padding-bottom:0px!important;
	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;	
}

.box_cuerpo.agregar_comm_der {

	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;	
}

.agregar_comm_izq .markItUpEditor {
  height:75px;
  margin-bottom:10px;
}

.box_cuerpo.agregar_comm_der{
	width:223px;
	float:left;
	text-align:center;
}

#cuerpo1 {
	font-size:13px;
	line-height: 1.4em;
}

	* html #cuerpo1 {
		width:744px;
	}

#cuerpo1 {
  background-position:-1080px bottom;
  background-color:#EEEEEE!important;
  padding-bottom:12px;
}

.iagregar_comentario{
	width:500px;
	height:100px;
}


.container380, .container370, .container940 .box_cuerpo,.container740,.box_perfil_der,.box_perfil_izq   {
  padding-bottom:6px;
}


.box_link{
	font-size:12px;
	padding-left: 25px;
}

.box_link:visited{
	color:#004A95;
	
}

.link{
  width: 360px;
	height:16px;
	padding:3px;
	overflow:hidden;
}


.categoriaPost:hover{
	background-color:#CCC;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
}

.link_titulo{

	float:left;
	height:16px;
	
}

.link_comm{
	color:#717171;
	text-align:right;
	font-size:10px;
	vertical-align:bottom;
}

.link_fav{
	width:460px;
	float:left;
	height:16px;
}

.categoriaPost, .categoriaPost a.privado  {
	background:transparent url('/images/big1v11.png') no-repeat scroll left top;
}

.categoriaPost a {
  display:block;
  height:18px;
}

.categoriaPost a:visited {
	color: #551A8B;
	font-weight:bold;
}

.categoriaPost a.privado {
	padding-left: 17px;
	background-position: -3px 0px;
}

.categoriaPost.juegos,#izquierda  .categoriaPost.jogos {
	background-position: 5px -44px;
}

.categoriaPost.imagenes,#izquierda  .categoriaPost.imagens {
	background-position: 5px -66px;
}

.categoriaPost.links {
	background-position: 5px -86px;
}

.categoriaPost.videos {
	background-position: 5px -110px;
}

.categoriaPost.arte {
	background-position: 5px -132px;
}

.categoriaPost.offtopic {
	background-position: 5px -152px;
}

.categoriaPost.animaciones,#izquierda  .categoriaPost.animacoes {
	background-position: 5px -174px;
}

.categoriaPost.musica {
	background-position: 5px -196px;
}

.categoriaPost.downloads {
	background-position: 5px -220px;
}

.categoriaPost.noticias {
	background-position: 5px -240px;
}

.categoriaPost.info {
	background-position: 5px -284px;
}

.categoriaPost.tv-peliculas-series, .categoriaPost.tv-filmes-e-series {
	background-position: 5px -305px;
}

.categoriaPost.patrocinados {
	background-position: 5px -332px;
}

.categoriaPost.poringueras,#izquierda  .categoriaPost.poringueiras {
	background-position: 5px -418px;
	
}
.categoriaPost.gay {
	background-position: 5px -507px;
}
.categoriaPost.relatos {
	background-position: 5px -528px;
}

.categoriaPost.linux {
	background-position: 5px -551px;
}

.categoriaPost.deportes, .categoriaPost.esportes {
	background-position: 5px -572px;
}

.categoriaPost.celulares {
	background-position: 5px -595px;
}

.categoriaPost.apuntes-y-monografias,#izquierda  .categoriaPost.monografias {
	background-position: 5px -614px;
}

.categoriaPost.comics, .categoriaPost.quadrinhos {
	background-position: 5px -637px;
}

.categoriaPost.solidaridad,#izquierda  .categoriaPost.solidariedade {
	background-position: 5px -661px;
}

.categoriaPost.recetas-y-cocina, .categoriaPost.cozinhas-e-receitas {
	background-position: 5px -678px;
}

.categoriaPost.mac {
	background-position: 5px -702px;
}

.categoriaPost.femme, .categoriaPost.mulher {
	background-position: 5px -727px;
}

.categoriaPost.autos-motos,#izquierda  .categoriaPost.carros-e-motos {
	background-position: 5px -747px;
}

.categoriaPost.humor {
	background-position: 5px -767px;
}

.categoriaPost.ebooks-tutoriales, .categoriaPost.ebooks-e-tutoriais {
	background-position: 5px -789px;
}

.categoriaPost.salud-bienestar, .categoriaPost.saude-bem-estar {
	background-position: 5px -808px;
}

.categoriaPost.turinga {
	background-position: 5px -438px;
}

.categoriaPost.economia-negocios {
	background-position: 5px -846px;
}

.categoriaPost.mascotas, .categoriaPost.bichos {
	background-position: 5px -866px;
}

.categoriaPost.turismo {
	background-position: 5px -890px;
}

.categoriaPost.manga-anime {
	background-position: 5px -912px;
}

.categoriaPost img {
	display:none;
}

.box_txt.post_titulo {
	width: 742px;
	padding-top:2px;
	text-align:center;
}
	* html .box_txt.post_titulo {
		width:742px;
	}


.box_txt.post_titulo h1{
	display:inline;
	font-size:13px;
	font-weight:bold;
	margin:0;
	line-height:17px;
}

a.icons.anterior, a.icons.siguiente  {
	background:url('/images/big2v1.png') no-repeat scroll;
	padding: 0 8px;
	
}

a.icons.anterior  {
	background-position: left 0px;
}
a.icons.siguiente {
	background-position: left -23px;

}

.icons.anterior span,.icons.siguiente span {
	display:none;
}


/* ICONOS */

.icons {
	background:url('/images/big2v1.png') no-repeat scroll left top;
	display:inline;
	padding: 2px 7px;
}

a.icons.recomendar_post,a.agregar_favoritos,a.denunciar_post {
	padding-left: 18px;
}

.icons.agregar_favoritos {
	background-position: left -241px;
}

.icons.agregar_favoritos:hover {
	background-position: left -64px;
	color: red;
	text-decoration: none;
}
	
.icons.denunciar_post {
	background-position: left -263px;
}
.icons.denunciar_post:hover {
	background-position: left -834px;

}
.icons.recomendar_post {
	background-position: left -220px;
}
	.icons.recomendar_post:hover {
		background-position: left -854px;

	}
	.txt_post span.icons {
		padding-left: 18px;
		padding-right: 5px;
	}
	
	.icons.puntos_post {
		background-position: left -41px;
	}
	.icons.favoritos_post {
		background-position: left -64px;
	}
	.icons.visitas_post {
		background-position: left -88px;
	}
    .icons.admin_denuncias {
    	background-position: left -834px;
        padding: 0;
    }

/*
.icons {
	background:url('/images/big2v4.gif') no-repeat scroll left top;
	display:inline;
	padding: 2px 7px;

}
.icons img {
	display:none;
}
.icons.anterior {
	background-position: left 1px;
	
}
.icons.siguiente {
	background-position: left -18px;
	
}
.icons.recomendar_post {
	background-position: left -220px;
}
.icons.agregar_favoritos {
	background-position: left -241px;
}

.icons.agregar_favoritos:hover {
	background-position: left -64px;
}
.icons.denunciar_post {
	background-position: left -263px;
}
.icons.agregar_favoritos {
	background-position: left -241px;
}

.icons.puntos_post {
	background-position: left -43px;
}
.icons.favoritos_post {
	background-position: left -64px;
}
.icons.visitas_post {
	background-position: left -88px;
}
*/
.opc_fav {
	width:440px;
	color:#717171;
	font-size:10px;
	float:left;
	text-align:right;
}

.check_fav {
	width:10px;
	text-align:right;
	position:absolute;
  top:10px;
  right:10px;
}

.link_resultado_titulo {
	width:380px;
	float:left;
	height:20px;
}

.link_resultado {
	width:720px;
	height:20px;
	padding:2px;
}

.link_resultado:hover {
	width:720px;
	height:20px;
	background:#CCCCCC;
	padding:2px;
}

.link_resultado_opc {
	width:340px;
	color:#717171;
	float:right;
	text-align:right;
	font-size:10px;
}


.icon {
	vertical-align:top;
}

br.space {
	display:block; margin:3px 0; 
}

*+html br.space {
	line-height: 6px;
}

/****** Mensajes ******/

.m-top { width:700px;height:25px;font-size:12px; padding:0px; margin:0px;}
.m-bottom { width:700px;height:55px;font-size:12px;padding: 0px; padding-top:8px; text-align: center; border-style: solid none none none; border-color:#999; border-width: 1px;}
.m-menu { font-size:12px; font-weight: bold; line-height: 1.8; color:#242424;}
.m-box {padding:0px;}

.m-seleccionar { width:680px;height:25px;float:left;padding-left:15px;text-align:left;vertical-align:middle;}
a.m-seleccionar-text {color:blue;}
a.m-seleccionar-text:hover {font-weight:bold;} 
.m-borrar { width:500px;height:30px;float:left; padding-left:5px;text-align:middle;vertical-align:middle;}

/* Columnas */

.m-col1m { width:74px;float:left; font-weight: bold;  font-size:12px; padding: 0px; } 
.m-col2m { width:676px;float:left;padding:5px; font-size:12px; } 
.m-col2m a { color:#053E78;}
.m-col1 { width:74px; float:left;padding:0px; padding-top:5px;font-weight: bold; font-size:12px; }
.m-col2 { width:600px;float:left;padding:5px;  font-size:12px; }
.m-col2e{ width:558px;float:left;padding:5px; font-size:12px; }

/* Mensajes */

.m-mensaje-ok{ border:2px solid green;background:#E6E6E6;text-align:center;padding-top:6px;margin-bottom:5px;font-weight:bold;color:green; }
.m-mensaje-error{ border:2px solid red;background:#E6E6E6;text-align:center;padding-top:6px;margin-bottom:5px;font-weight:bold;color:red; }

.m-linea-mensaje {      vertical-align: middle; width:701px;height:25px;background: none repeat scroll 0%; font-size:12px;border-style: solid none none none; border-color:#999; border-width:1px; padding:0px; font-weight:bold; background-color:#FDFBE7;}
.m-linea-mensaje-open { vertical-align: middle; width:701px;height:25px;background: none repeat scroll 0%; font-size:12px;border-style: solid none none none; border-color:#999; border-width:1px; padding:0px;}

.m-opciones {      vertical-align: middle; width:45px;height:25px;float:left; border-style: none ;}
.m-opciones-open { vertical-align: middle; width:45px;height:25px;float:left; border-style: none ;}

.m-remitente {      width:100px;height:25px;float:left;border-style: none none none solid; border-color:#999; border-width: 1px; padding-left:5px; font-weight:bold; }
.m-remitente-open { width:100px;height:25px;float:left;border-style: none none none solid; border-color:#999; border-width: 1px; padding-left:5px; }

.m-destinatario {      width:100px;height:25px;float:left;border-style: none none none solid; border-color:#999; border-width: 1px; padding-left:5px; font-weight: bold;}
.m-destinatario-open { width:100px;height:25px;float:left;border-style: none none none solid; border-color:#999; border-width: 1px; padding-left:5px; }

.m-asunto {      width:399px;height:25px;float:left;border-style: none none none solid; border-color:#999; border-width: 1px; padding-left:5px; font-weight:bold;}
.m-asunto A {text-decoration: underline; color: blue;}
.m-asunto-open { width:399px;height:25px;float:left;border-style: none none none solid; border-color:#999; border-width: 1px; padding-left:5px; }

.m-asunto-carpetas {       width:293px;height:25px;float:left;border-style: none none none solid; border-color:#999; border-width: 1px; padding-left:5px; font-weight:bold;}
.m-asunto-carpetas A {text-decoration: underline; color: blue;}
.m-asunto-carpetas-open  { width:293px;height:25px;float:left;border-style: none none none solid; border-color:#999; border-width: 1px; padding-left:5px; }

.m-fecha {      width:138px;height:25px;float:left; border-style: none none none solid; border-color:#999; border-width: 1px; padding-left:5px; font-weight:bold;}
.m-fecha-open { width:138px;height:25px;float:left; border-style: none none none solid; border-color:#999; border-width: 1px; padding-left:5px; }

/****** Fotos ******/

.galeria-foto-marco { 
	float:left;
	height:100px;
	padding:10px 12px;
	text-align:center;
	width:110px;
}

.galeria-foto-box { 
	overflow: hidden; 
	width: 102px; 
	height: 102px;
}

.galeria-foto-img { 
	border: 1px solid rgb(204, 204, 204);
}

/****** Perfil ******/

.box_perfil_der {
	padding:12px;
	margin:0 ;
	overflow:hidden;
}

.box_perfil_izq {
	padding:12px;
	margin:0 ;
}

* html .box_perfil_izq {
	width: 500px;
	padding:0!important;
	overflow:hidden;
}
.box_txt_perfil_izq {
	background-repeat:no-repeat;
	color:#444444;
	float:left;
	font-weight:bold;
	padding-left:3px;
	width:489px;
	text-align:center;
	font-size:12px
}

* html .box_txt_perfil_izq {
	float:left;
	padding-left:0;
}

.box_txt_perfil_izq.rss{
	width:475px;
}

* html .box_txt_perfil_izq.rss{
	width:454px!important;
}

* html box_rrs {
	width: 16px;
	height: 16px;
	display: block
}
.box_txt_perfil_der {
	background-repeat:no-repeat;
	color:#444444;
	float:left;
	font-weight:bold;
	padding-left:3px;
	width:389px;
	text-align:center;
	font-size:12px
}

.perfil_izq {
	float:left;
	width:500px;
	padding-left:5px;
}
* html .perfil_izq {
	float:left;
	width:500px;
	padding: 0;
}

.perfil_der {
	float:left;
	width:400px;
	padding-left:20px;
}
* html .perfil_der {
	float:left;
	width:400px;
	padding-left:20px;
	overflow: hidden	
}

.box_txt.ultimos_comentarios_de{
	width:702px;
}

.perfil_comentario{
	padding-left:20px;
	width:650px;
	overflow:hidden;
}

li, ol li {
list-style-image:none;
list-style-position:outside;
list-style-type:none;
}

.menu_cuenta li{
	list-style:none;
	list-style-position:inside;
	list-style-type:disc;
}

.extrainfo li {
	float:left;
	margin:0pt;
	padding:0pt 0pt 3px;
}

.extrainfo strong {
	float:left;
	width:110px;
}

.extrainfo span {
	float:right;
	width:250px;
}

.perfil_avatar {
	float:left;
	width:135px;
	margin:0pt;
}

.statsinfo {
	float:left;
	width:340px;
	margin:0pt;
}

.statsinfo li {
	float:left;
	margin:0pt;
	padding:0pt 0pt 3px;
}

.statsinfo strong {
	width:120px;
	margin:0pt;
	float:left;
}

.statsinfo span {
	width:220px;
	float:right;
}

.photo_small{
	margin:6px;
	padding:2px;
	text-align:center;
	float:left;
	background:#FFFFFF none repeat scroll 0%;
	border:1px solid #000000;
	width:77px;
	height:77px;
}

/****** Buscador ******/

.bbox 
	{
	margin-top:5px;
	padding-left:5px;
	padding-bottom:1px;
	padding-right:3px;
	width:99%;
	text-decoration:none;
}
	
	.bbox h2 {
		font-size:10px;
		color:#5F5F5F;
		float:right;
		margin-right:10px;
		text-decoration:none;
	}

	.linkpat{ 
	color: #0000DE;
	text-decoration:none;
	font-size:115%;
	font-style:normal;
	}
	.linkpat:hover{ 
	color: #0000DE;
	text-decoration:underline;
	font-size:115%;
	font-style:normal;
	}
	
	.spns {
	margin-bottom:13px;
	width:100%;
	padding-top:15px;
	text-decoration:none;
	font-size:110%;
	font-size-adjust:none;
	font-style:normal;
	font-variant:normal;
	font-weight:normal;
	line-height:1.40em;
	}
	
	.spns em{
		color: #757575;
		font-style:normal;
	}
	
	.spns a:hover { 
		text-decoration:none;
	}
	
	.spns ul li { 
	cursor:pointer;
	line-height:1.50em;
	list-style-type:none;
	margin:5px 0pt 10px -1px;
	text-decoration:none;
	padding-left:0pt;
	}
	
	.spns ul li:hover { 
		text-decoration:none;
	}


	.bbox_s
	{
	background:#FFFFFF;
	width:100%;
	text-decoration:none;
	}
	

	.linkpat_s{ 
	font-size:110%;
	color: #0000DE;
	text-decoration:none;
	}
	.linkpat_s:hover{ 
	font-size:110%;
	color: #0000DE;
	text-decoration:underline;
	}
	
	.spns_s {
	width:100%;
	text-decoration:none;
	font-size:100%;
	text-align: left;
	font-size-adjust:none;
	font-style:normal;
	font-variant:normal;
	font-weight:normal;
	line-height:1.21em;
	}
	
	.spns_s a:hover { 
		text-decoration:none;
	}
	
	
	.spns_s ul li { 
	cursor:pointer;
	line-height:1.23em;
	list-style-type:none;
	margin:0px 0pt 10px -1px;
	text-decoration:none;
	padding-left:0pt;
	}
	
	.spns_s ul li:hover { 
		text-decoration:none;
	}

/****** Busqueda Perfiles ******/

.box_txt_busqueda_perfiles{
	background-image:url('/images/cor-izq.gif');
	background-repeat:no-repeat;
	float:left;
	padding-left:3px;
	font-weight:bold;
	color:#444444;
	width:732px;
	height:22px;
	text-align:center;
	font-size:12px
}

/****** Bordes Redondos ******/

.rtop,.rbott {
	width:984px;
	display:block;
	margin:0 auto;
	background: url('/images/rtopbg.gif') no-repeat left top;
	height: 13px;
}

.rtop_content{
	padding:0px 5px;
	background:#0a67e6;
}

.rbott
{
	background-position: bottom left!important;
}

.rbott *, .rbott * {
	display:block;
	height:1px;
	overflow:hidden;
	background:#0069d4;
	display:none;
}

.rbott_content{
	padding:0px 5px;
	background:#0a67e6;
}


/***** login box *****/
/* login noscript */
.menu_centro input.ilogin{
	font-size: 10px;
	width: 65px;
}

#login_box {
	position:absolute;
  right:12px;
  top:87px;
  width:240px;
  z-index:1;
  display:none;
}
/*
#login_box .login_header{
	left: 230px;
	width: 30px;
	height: 14px;
	z-index: 2;
	position: absolute;
	background: url('/images/logindia.png') no-repeat left bottom;
}


*/
#login_box .login_content label {
  font-size: 12px;
  text-transform: uppercase;
  text-shadow: 0 1px 0 #FFF;
}   

#login_box .login_content{
  -moz-border-radius-bottomleft:10px;
  -moz-border-radius-bottomright:10px;
  background:#FFFFCC;
  color:#272727;
  margin-top:13px;
  padding:15px 20px;
  text-align:left;
  white-space:normal;
  *margin-top:-1px;
}   

.login_content #login_error{
	display:none;
	font-weight:bold;
	text-align:center;
	font-size:13px;
	color:red;
}

.login_content .izq{
	float:left;
	width:115px;
	height:22px;
	text-align:right;
}

* html .login_content .izq{
	clear:both;
}

.login_content .der{
	float:left;
	height:25px;
	padding-left:5px;
	padding-top:2px;
}

.login_content input.ilogin{
	width: 180px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border:1px solid #999 ;
  background:#FFF;
  margin: 0 0 10px 0;
  padding: 8px;
}

.login_content input.login{
	margin-left: 132px;
	width: 132px;
	font-size: 10px;
}

.login_content form{
	font-weight:bold;
	margin: 0px;
}

.login_cerrar{
	position:absolute;
  left:88px;
  top:13px;
  width:16px;
  height:16px;
  cursor:pointer;
  border:0px;
}

.login_content #login_loading{
  display:none;
	position:absolute;
	width:16px;
  height:16px;
  right:20px;
  top:20px;
  border:0px;
}

#login_box .login_footer{
	text-align:left;
  margin-top:15px;
  font-weight: normal;
}
#login_box .login_footer hr {
  background: #CCC;
}

/* some inputs */

textarea, input {
	background:#f9f9f9 url('/images/inputbg.gif') repeat-x top left;
	border: solid 1px #CCC;
	padding:4px 2px;
	font-family: 'Lucida Grande',Tahoma,Arial,Verdana,Sans-Serif; 
	
	color:#333;
	font-size:12px;
	font-family: ;
}
input.checkbox, input.radio, input[type="checkbox"], input[type="radio"] {
	background: none!important;
	border: none!important;
	padding: 0!important;
}


 .box_cuerpo .ibuscador {
	background: url('/images/bgInputS_2.gif') repeat-x;
	border: none;
	width: 189px;
	height:  13px;
	float: left;
	padding: 8px 4px;
}

#derecha .ibuscador {
  width:149px;
  *width: 140px;
}


  .leftIbuscador {
	display: inline;
	float: left;
}


* html input.ibuscador, *+html input.ibuscador {
	width: 145px
}

.box_cuerpo input.bbuscador {
  background: url('/images/buscar_2.gif') no-repeat top left;
  outline: none;
  width: 63px;
  margin: 0 0 0 0;
  padding: 0;
  height: 29px;
  font-size: 16px;
	border:none;
   cursor: pointer;
}

.box_cuerpo input.bbuscador:active {
  background-position: 0 -30px;
  outline: 0;

}

.searchBy input{
	padding-top: 7px;
	vertical-align:top;
}

input:focus{outline:0;}

#ult_comm li {
  height:16px;
  overflow:hidden;
}

 #ult_resp li {
   height:16px;
   overflow:hidden;
 }

.usuarios_online{
	color:#BB0000!important;
}

.usuarios_jugando{
	color:#148558!important;
}

.tags_cloud{
	line-height: 200%;
	text-align: justify;
}

.tags_cloud a {
	float: left;
}

.box_cuerpo .tags_cloud_2{
	line-height: 300%;
	text-align: justify;
}

.agregar.cuerpo,.agregar.tags {
	width: 650px;
}
.agregar.cuerpo{
	height: 380px;
}
.agregar.titulo {
	width:335px;
}

/* Lang */
.geoT {
	width: 250px;
	height: 35px;
	background: url(/images/geoTbg.gif) no-repeat top left;
}
.geoT.porTa {
	background: url(/images/geoTbg.gif) no-repeat bottom left;
}

.spaT, .porT {
	margin-top: 10px;
	text-align: center;
	width: 124px;
}

.geoT.porTa .porT {
	font-weight: bold;
}

.geoT.porTa .spaT {
	font-weight: normal;
}

.geoT .spaT {
	font-weight: bold;
}
.geoT input {
	margin:0;
	vertical-align: middle;
}
.spaT {
	float: left;
}
.porT {
	float: right;
}



#el_msgbox {
	background: #FFF;
}

/* Paginas del footer */

.box_txt.anuncie{
	width:592px;
	height:22px;
	text-align:left;
	font-size:12px;
}

.enlazanos_imagen{
	width:120px;
	height:50px;
	float:left;
}

.mapa_del_sitio{
	float:left;
	height:auto;
	padding:2px 6px;
	width:301px;
}

.mapa_del_sitio .box_txt{
	width:283px;
}
/* Containers */

.container170{
	width: 170px;
}

.container208{
	width: 208px;
}

.container228{
	width: 228px;
}

.container230{
	width: 230px;
}

.container250 {
	width: 250px;
}
* html .container250 {
	width: 250px;
	overflow:hidden;
}

.container278 {
	width: 278px;
}

.container370 {
	width: 370px;
}
* html .container370 {
	width: 370px;
	overflow:hidden;
}

.container300 {
	width: 300px!important;
}

.container340 {
	width: 340px!important;
}

.container380 {
	width: 380px;
}
* html .container380 {
	width: 380px;
	overflow:hidden;
}

.container400{
	width: 400px;
}

.container520{
	width: 520px;
}

.container600{
	width: 600px;
}

.container620{
	width: 620px;
}

.container630{
	width: 630px;
}

.container652{
	width: 652px;
}

.container702{
	width: 702px;
}

.container720{
	width: 720px;
}

.container740{
	width: 740px;
}

.container940 {
	width:940px;
}

input .button.rechazar {
  background: #009500;
  border-color: #135b0e #1b5b0e #1b5b0e #135b0e;    
  color:#FFFFFF!important
}

input .button.aceptar {
background: #950000;
  border-color: #5b0e0e #ead9d9 #ead9d9 #5b0e0e;
  color:#FFFFFF!important
}

input .button.omitir {
  background: #4a4a4a;
  border-color: #e1e1e1 #4a4a4a #4a4a4a #e1e1e1;
  color:#FFFFFF!important
}

.gif_loading{
	background:transparent url('/images/loading.gif') no-repeat scroll left top; /* /images/cargando.gif !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */
	display:none;
	height:16px;
	width:16px;
	top:4px;
	position:relative;
}

#gif_cargando_add_comment{
	margin-left: 740px;
	margin-top: 28px;
	position: absolute!important;
}

.msg_add_comment{
	display: none;
	margin-top: 5px;
	text-align: center;
	font-weight: bold;
	color: #AD1010;
}

.login.darkred{
	background-color: #AD1010;
}


/* New CSS */

  .categoriaPost {
		clear:both;
    font-size:12px;
    height:16px;
    margin-bottom:5px;
    padding:3px 3px 3px 28px;
	}


	#izquierda li a.categoriaPost {  /* El de arriba esta comentado, este es un style beta para categoria */
		height: 18px;
		display: block;
	}
	  
	.sticky  {}
	li a.comunidad {
		float: left;
		padding-right: 4px;
	}
	
	li a.tema {
		float: left;
	}


	#izquierda  li.categoriaPost.sticky{background-position:5px -21px; padding: 3px 3px 3px 20px;}
	#izquierda  li.categoriaPost.sticky{background-position:5px -21px; padding: 3px 3px 3px 20px;}	
	#izquierda  li.categoriaPost.patrocinado{background-color:#FFFFCC; -moz-border-radius: 5px;-webkit-border-radius: 5px;}	
	#izquierda  li.categoriaPost.sticky.patrocinado .categoriaPost:hover {background-color: transparent;}	
	#izquierda  li.categoriaPost.sticky.patrocinado .categoriaPost {height: 16px;}	
	
	
	#izquierda  li.sticky a {
	  margin:-2px 0 0 0;
	  padding:0 0 0 28px;
	}
	
	#izquierda  li.sticky a:hover {
	  background-color:none;
	}
	
	
	.categoriaPost.sticky .categoriaPost.juegos{background-position:5px -44px;}
	.categoriaPost.sticky .categoriaPost.imagenes{background-position:5px -63px;}
	.categoriaPost.sticky .categoriaPost.links{background-position:5px -86px;}
	.categoriaPost.sticky .categoriaPost.videos{background-position:5px -110px;}
	.categoriaPost.sticky .categoriaPost.arte{background-position:5px -130px;}
	.categoriaPost.sticky .categoriaPost.offtopic{background-position:5px -152px;}
	.categoriaPost.sticky .categoriaPost.animaciones{background-position:5px -174px;}
	.categoriaPost.sticky .categoriaPost.musica{background-position:5px -196px;}
	.categoriaPost.sticky .categoriaPost.downloads{background-position:5px -218px;}
	.categoriaPost.sticky .categoriaPost.noticias{background-position:5px -240px;}
	.categoriaPost.sticky .categoriaPost.info{background-position:5px -284px;}
	.categoriaPost.sticky .categoriaPost.tv-peliculas-series{background-position:5px -305px;}
	.categoriaPost.sticky .categoriaPost.patrocinados{background-position:5px -332px;}
	.categoriaPost.sticky .categoriaPost.linux{background-position:5px -551px;}
	.categoriaPost.sticky .categoriaPost.deportes{background-position:5px -572px;}
	.categoriaPost.sticky .categoriaPost.celulares{background-position:5px -595px;}
	.categoriaPost.sticky .categoriaPost.apuntes-y-monografias{background-position:5px -614px;}
	.categoriaPost.sticky .categoriaPost.comics{background-position:5px -637px;}
	.categoriaPost.sticky .categoriaPost.solidaridad{background-position:5px -660px;}
	.categoriaPost.sticky .categoriaPost.recetas-y-cocina{background-position:5px -678px;}
	.categoriaPost.sticky .categoriaPost.mac{background-position:5px -702px;}
	.categoriaPost.sticky .categoriaPost.femme{background-position:5px -727px;}
	.categoriaPost.sticky .categoriaPost.autos-motos{background-position:5px -744px;}
	.categoriaPost.sticky .categoriaPost.humor{background-position:5px -767px;}
	.categoriaPost.sticky .categoriaPost.ebooks-tutoriales{background-position:5px -789px;}
	
	
	#menu{ /* al igual que el anterior, menu esta comentado arriba, de aplicar el siguiente estilo borrar el de arriba */
		clear:left;
		width:100%;
		background: #CCCCCC url('/images/bg-menu-2.gif') repeat-x;
		text-align:center;
		color: #999;
		height: 30px;
	}
	
	.menuTabs {
		float:left;
		background: transparent url('/images/menu_left_corner_2.gif') no-repeat scroll left top;
	}
	.menuTabs li {
		float:left;
    font-size: 14px;
	  font-weight: bold;
	  padding: 0 2px 0 0;
	  background: transparent url('/images/divider.gif') no-repeat scroll right top;
	}
	
	.menuTabs li a {
		color: #1a1818;
		text-shadow: #fff 0 1px 0;
		display:block;
    padding: 8px 15px 8px 15px;
    text-decoration: none;
    _padding: 7px 15px 6px 15px;
	}
	
	.menuTabs li a:hover {
		color: #555;
	}
	
	.menuTabs li a img, .userInfoLogin img  {
		vertical-align:middle;
		margin-top: -2px;
        cursor: pointer;
	}
	
	.userInfoLogin .usernameMenu a {
	  padding: 9px 10px 5px;
	}

ul.menuTabs .tabbed.here a:hover {
	background:  none;
}

	#menu ul.menuTabs li.here {
	 	background: transparent url('/images/bgTabbedHere.png') repeat-x scroll left top;
	}
	
	.menuTabs li.tabbed.here a {
		color: #FFF;
		text-shadow: #000 0 1px 0;
	}
	
	.menuTabs #tabbedPosts.here a {
	  	background: url(/images/menu_left_corner_here.gif) no-repeat top left;
}
		.menuTabs li.gT {
	  	background: none;
}
		.menuTabs li#tabbedPosts.here {
	 	background: transparent url('/images/bgTabbedHere.png') repeat-x scroll left top;
}
	/*
	.menuTabs li.here a {
		color: #fff;
	}
	
	.menuTabs li a {
		font-weight:bold;
		font-size: 13px;
	}
	*/

	.user_options {
		float:right;
	  text-align: right;
	  height: 30px;
		background: transparent url('/images/bgLogged.gif') repeat-x scroll right top;
	  border-left:  1px solid #7b7b7b;
	}
	
	.user_options.anonymous {
		background: transparent url('/images/bgAnon.gif') repeat-x scroll right top;
	}
	
	#menu .user_options.anonymous.here {
		background: #FFFFCC;
	}
	
  .userInfoLogin {
  	background: url(/images/loginCorner.gif) no-repeat top right;
  	font-weight:bold;
}

  .userInfoLogin.here {
  	background: none;
}

  .userInfoLogin a:hover {
    text-decoration: none;
  }
  
  .userInfoLogin .monitorAlert {
    position:relative;
  }
  
  .userInfoLogin .monitorAlert .alertD{
    position:absolute;
    right:-7px;
    top:-4px;
    z-index:10;
  }


.anonymous .loginb {
	background: url(/images/anonCorner.gif) no-repeat top right;

}

.anonymous.here .loginb {
	background: none;

}

  .userInfoLogin ul {
    margin: 0;
    padding: 0;
  }
  
  .userInfoLogin ul li {
    float: left;
    border-right: 1px solid #717171;
    border-left: 1px solid #dcdcdc;
  }
  
  .userInfoLogin ul li.logout {
    border-right: none;
    border-left: 1px solid #dcdcdc;
    padding: 7px 10px;
  }
  .userInfoLogin ul li.logout:hover {
    background:none;
  } 
  
  .userInfoLogin .logout a {
    padding: 0;
  }

  
  .userInfoLogin a {
	  color: #222;
	  text-shadow: #EEE 0 1px 0;
	  padding: 8px 10px 5px;
    display:block;
}

  .userInfoLogin li:hover {
    background: #CCC;
  }

	.username {
		font-weight:bold;
	}
	.subMenuContent {
		height: 30px;
	}

	
	.subMenuContent .clearBoth {
	  display:none;
	}
	.subMenuContent.hide {
		display: none;
	}
	.subMenu {
		background:  url('/images/shadowSubMenu.png') #007394 repeat-x scroll left top;
    border-left:1px solid #04396F;
    border-right:1px solid #04396F;
		clear:both;
		width: 944px;
		position: absolute;
		font-size: 12px;
		font-weight: bold;
		color: #CCC;
		padding: 6px 5px 0 10px;
		display: none;
	}
	.subMenuContent .subMenu.here {
		display: block;
	}
	
	.subMenu select {
	  float:right;
	  margin:2px 0 0 0;
	  width:200px;
	}
	#subMenuGroups.subMenu {
		background: url('/images/shadowSubMenu.png') #009B45 repeat-x scroll left top;
    border: none;
    border-left: 1px solid #0a6f04;
    border-right: 1px solid #0a6f04;
}

	#subMenuGroups.subMenu ul.tabsMenu li {
		background: #48b167;

}

	#subMenuGroups.subMenu ul.tabsMenu li:hover {
		background: #62ca81;

}


	.subMenu ul.tabsMenu {
}
.subMenu .filterCat {
  width:330px
}
.subMenu .filterCat span {
  color:#a8ecff;
  font-size:11px;
  display:block;
  float:left;
  margin: 3px 10px 0 0;
  font-weight: normal;
  text-shadow: 0 1px 0 #07485b;
}

#subMenuGroups.subMenu .filterCat span {
  color:#bfffab;
  text-align:right;
  text-shadow: 0 1px 0 #09730b;
}



	.subMenu ul.tabsMenu li {
		float:left;
		margin-right: 10px;
		background: #3b8bac;
		-moz-border-radius-topleft:2px;
		-moz-border-radius-topright:2px;
	}

#preview_shortname {
	font-weight:bold;
}
#msg_crear_shortname.ok, #preview_shortname.ok {
	color: green;
	font-weight:bold;
}
#msg_crear_shortname.error, #preview_shortname.error {
	color: red;
	font-weight:bold;
}

.onblur_effect{
	color:#777777;
}


	.subMenu ul.tabsMenu li.here a {
		color: #000;
		}

	.subMenu ul.tabsMenu li.here {
		float:left;
		margin-right: 10px;
    background: #FFF!important;
	}
	
	.subMenu ul.tabsMenu li a {
		color: #FFF;
    padding: 5px 15px;
    display: block;
		}
		
			.subMenu ul.tabsMenu li:hover {
		background: #6ccff7;
	}
	
				.subMenu ul.tabsMenu li:hover a {
		color: #222;
	}
	

	.subMenu .verCategoria a {
    color: #021821;
}


	.sel_categoria { /* Comentado el de arriba*/
		float:right;
	}

	
		.comunidades .box_txt.ultimos_posts {
		width:388px !important;
		}
		
	.comunidades #derecha {
		width: 211px;
	}
	
		
	.usuarios_online { /*modificado del original */
			color:#005ca5!important;
			font-weight:bold;
		}

	.usuarios_jugando{
			color:#148558!important;
			font-weight:bold;
		}
	
	.dateFilter, .verMas {
		margin:0 0 5px 0;
		float: right;
		text-align: right;
		font-weight:bold;
		color: #666;
		font-size: 10px;
	}
	
	.dateFilter a,.verMas a {
		color: #0060a7;
	}
	
	.dateFilter a.here,.verMas a.here  {
		color: #000;
	}
	
	.comunidades #centro {
		width: 530px;
		margin:0 8px;
		float:left;
	}
	
	.comunidades #centroDerecha {
	  width:760px;
	  float:right;
	}
	li.categoriaCom {
		padding: 5px;
		border-bottom:1px solid #CCC;
		border-top: 1px solid #FFF;
		margin: 0;
		height: 32px;
		font-size: 10px;
		position:relative;
	}
	
	.comunidades .home #centro .box_cuerpo li:first-child {
	  border-top: none;
	}
	
	.comunidades .home #centro .box_cuerpo li:hover {
	  background: #EEE;
	}
	
	.comunidades .home #centro .box_cuerpo li a.titletema:visited {
	  color: #561067;
	}
	
	.linksList a.titlePost:visited {
	  color:#561067;
	}
	
	
	.comunidades .home #centro .box_cuerpo li.oficial a.titletema {
	  padding-left: 22px;
	}
	
	/* 
	  Comunidades iconos de categorias
	*/
	
	.comunidades .home #centro .box_cuerpo li img {
	  position:absolute;
	  right: 5px;
	  top:6px;
	}
	
	
  li.categoriaCom .titletema {
	  background-image: url('/images/big5v1.png');
	  background-repeat: no-repeat;
	  padding-left:24px;
	  display:block;
	  height:16px!important;
	  margin-bottom:2px;
	  overflow:hidden;
	  width:420px;
	  color: #1F7C46;
	  font-size:12px;
	  font-weight: bold;
	}
	
	.deportes .titletema {background-position: 0 -18px;}
	.diversion-esparcimiento .titletema {background-position: 0 -38px;}
	.economia-negocios .titletema {background-position: 0 -56px;}
	.entretenimiento-medios .titletema {background-position:0 -72px;  }
	.grupos-organizaciones .titletema {background-position: 0 -90px;}
	.interes-general .titletema {background-position: 0 -109px;}
  .internet-tecnologia .titletema {background-position: 0 -127px;}
  .musica-bandas .titletema {background-position: 0 -146px;}
  .regiones .titletema {background-position: 0 -164px;}
	
	span.oficial {
	  color:#FF6600;
	  font-weight:bold;
	  text-transform: uppercase;
	}

	.comunidades .home #showResult {
	  width: 100%;
	}
	
	.divider {
		color: #ccc;

		border-top:1px solid #ccc;
		border-bottom:1px solid #fff;
	}
	

	
	#post-izquierda .box_cuerpo h2, #izquierda .box_cuerpo h2 {
		font-size:14px;
		color: #333;
	}
	

	.denunciar {
		float:right;
		padding-left: 12px;
		color: #333;
		background: url('/images/dflag.gif') left top no-repeat;
		font-size: 10px;
		line-height: 1em;
	}
	/* TABLAS */
	
	.thead {
		font-size: 11px;
		color: #666;
		border-bottom: 1px solid #ccc!important;
		padding:4px;
	}
	
	.thead.titulo {
		width: 380px;
	}

	tr.temas td {
		padding: 4px;
		border-bottom: 1px solid #CCC;
	}
	
	.temas .temaTitulo a {
		font-weight: bold;
	}
	
	.temas .datetema {
	  font-size: 11px;
	  text-align: center;
	}

	.small {
		font-size:11px;
	}
	
	.color1 {
		background: #EEE;
	}
	
	.color2 {
		
	}
	
	.comunidadData.oficial {
	  position: relative;
	}
	
	.comunidadData.oficial .riboon{
	  position: absolute;
	  top: -8px;
	  right: -7px;
	}
	
	.oficial .box_title {
	  background:#94c3ee repeat-x url(/images/box_titlebg_oficial.gif) top left;
	  
	}
	
	.oficial .box_rss {
	  background: no-repeat url(/images/cor-der-oficial.gif) top right;
	}
	
	.oficial .box_txt {
	  background: no-repeat url(/images/cor-izq-oficial.gif) top left;
	  color:#0a3868;
	  
	}
	
	.oficial .box_cuerpo {
	  background:#b3dbff;
	}
	
	
	
	.comunidadData.oficial .box_cuerpo hr.divider  {
	  border-bottom:1px solid #FFFFFF;
    border-top:1px solid #1984e5;
    color:#1984e5;
	}
	
	.avaComunidad {
	  width:126px;
	  height: 134px;
	  margin:0 auto;
	  position: relative;
	  background:transparent url(/images/shadowAva.png) no-repeat scroll center 125px;
	}
	/*
	.comunidadData.oficial .box_cuerpo {
	  background:#CEEBFB;
	  border: #e8f6fe 1px solid;
	  border-top: none;
	}
	
	.comunidadData.oficial .box_cuerpo .divider {
	  border-bottom:1px solid #FFFFFF;
    border-top:1px solid #bae6ff;
	}  
	*/
 .avaComunidad .avatar {
	  width:120px;
	  height: 120px;
	  border: solid #CCC 1px;
	  padding: 2px;
	  background:#FFF;
	}

  
	.ultimo_post {
		text-align: right;
	}
	
	.ultimo_post a {
		font-weight:bold;
	}
	
	.pages {
		text-align:right;
		padding-top: 10px;
		font-size:11px;
		color: #CCC;
	}
	
	.pages a {
		font-weight: bold;
		color: #333;
	}
	
	.pages a.here {

		color: #ccc;
	}
	
	.pages .btnPagi {
	  background:#383838 none repeat scroll 0 0;
    color:#FFFFFF;
    display:block;
    font-weight:bold;
    padding:5px 10px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    
	}
	a.nuevotemaBtn {
	  padding: 5px 10px;
	  background: #006699;
    margin-top: 10px;
    color: #FFF; 
    -moz-border-radius: 3px;
    font-weight: normal;
    -webkit-border-radius: 3px;
    font-size:11px;
	}
	
	a.nuevotemaBtn:hover {
    background: #0085c7;
	}
	.emptyData {
    background: #FFFFCC;
    border-top:1px solid #c8c82d;
    border-bottom:1px solid #c8c82d;
    padding:12px;
    font-weight:bold;
    text-align:center;
  }
  
  .warningData {
    background: #ff8484;
    border-top:1px solid #d62727;
    border-bottom:1px solid #d62727;
    padding:12px;
    font-weight:bold;
    text-align:center;
    margin-bottom: 10px;
  }
  
  .emptyData a,.warningData a{
    color:#004a95;
  }
	.suspendido_data {
    background: #FFFFCC;
    border-top:1px solid #c8c82d;
    border-bottom:1px solid #c8c82d;
    padding:12px;
    text-align:center;
    margin-bottom:10px;
  }
  
  .suspendido_data #ver_mas{
  	display: none;
		text-align:left;
		margin-top:10px;
	}

	.dataRow {
		margin-bottom: 5px;
	}
	.box_Corner {
		background-image: url('/images/corner.gif');
		background-repeat:no-repeat;
	}
	
	.box_Corner.corner_top_right {
		background-position: right top;
		padding-top:5px;
	}
	
	.box_Corner.corner_bottom_left {
		background-position: left bottom;
	}
	.box_Corner.corner_bottom_right {
		background-position: right bottom;
		padding-bottom: 5px;
	}
	
	.box_cuerpo li .comunidad {
		width: auto;
	}
	.linea {
		background: transparent url('/images/line.gif') repeat-y scroll 0 0
	}
	
	.linea_left {
		background-position: left;
	}
	
	.linea_right {
		background-position: right;
	}
	
	.Container {
		font-size:12px;
		color: #333;
		position: relative;	    
	}

	.Container table {
		width: 100%;
		margin:5px 0;
	}
	
	.Container h1 {
		margin: 0;
		font-size: 21px;
		padding:3px;
	}
	
	.Container p {
	  font-size:12px;
	  line-height: 1.7em;
	  color:#111;

	}
	.Container img.dialogBox {
    left:-10px;
    position:absolute;
    top:6px;
	}
	
	.agregar_comentario .Container img.dialogBox {
  left:-10px;
  position:absolute;
  top:10px;
  }
  
  
	* html .Container img.dialogBox {
    display:none;
	}
	.dataLeft, .dataRight {
		float:left;
		font-size:12px;
		line-height:17px;
		margin-right:2%;
		text-align:right;
		
	}
	.dataLeft {
		font-weight:bold;
		width:120px;
		margin:0;
	}
	
	.dataRight {
		text-align:left;
		width:350px;
		margin:0;
		margin-left: 2%;
	}
	
	.breadcrump {
	  width: 875px;
	  height:30px;
	  overflow:hidden;
	  float:left;
	  margin-bottom:10px;
	}
  .breadcrump ul, .breadcrump ul li,.breadcrump ul li.first,.breadcrump ul li.last    {
	  background-image: url('/images/bgBread.gif');
	  background-repeat: no-repeat;   
   }
	 .breadcrump ul {
	   margin-bottom:10px;
	   float:left;
	   font-weight:bold;
	   background-position: left -62px;
     background-repeat: repeat-x;
     text-shadow: 0 1px 0 #fff;
	 }
	 .breadcrump ul li {
     float:left;
     padding:8px 5px 8px 22px;
     height:14px;
     background-position: left 0px;
 	 }
	 .breadcrump ul li.first {
	   padding:8px 0 8px 8px;
	   background-position: left -31px;
	 }
	 .breadcrump ul li.last {
 	   padding:8px;
 	   background-position: left -93px;
 	 }
	 .breadcrump ul li a  {
     color:#165a9e;
 	 }

	#temaComunidad  {
		float:left;
	}
	#temaComunidad img {
	  max-width: 600px;
	     width: expression(this.width > 600 ? 600: true);
	}
	h1.titulopost {
		font-size: 15px;
		float:left;
		line-height:18px;
    width:460px;
	}
	
	.temaContainer {
		float: left;
		margin-left: 12px;
		color: #333;
	}
	
	.temaBubble {
		float:left;
		width: 760px;
	}
	
	.temaCont {
	  float:right;
	}
	
	
	.bubbleCont {
	  background:#f7f7f7;
	  border: 1px solid #CCC;
	  -moz-border-radius: 5px;
	  -webkit-border-radius: 5px;
	  padding:12px;
	overflow:hidden;
	}
	
	.comentarioContainer {
	  background:#f7f7f7;
	  border-bottom: 1px solid #CCC;
	  border-left: 1px solid #CCC;
	  border-right: 1px solid #CCC; 
	} 
	
	.titulorespuestas {
	  margin:0;
		font-size: 14px;
		margin-bottom:0;
	}
	
	
	
	.mostrarAnteriores {
	  text-align:center;
	  float:right;
    margin-bottom:10px;
    width:626px;
	}
	.mostrarAnteriores a {
	  padding: 10px;
	  color:#1b1b1b;
	  font-weight:bold;
	  display:block;
	  background:#f7f7f7;
	  border: 1px solid #CCC;
	  -moz-border-radius: 5px;
	  -webkit-border-radius: 5px;
	}
	
	.mostrarAnteriores a:hover {
	  background:#CCC;
	  border:1px solid #EEE;
	}
	/*
	#respuestas {
		width: 630px;
	}
	*/
	.respuesta, .miRespuesta {
		margin-top: 10px;
		clear:both;
	}

	#respuestas .respuesta.here {
	  background: #FFFFCC;
	  font-weight:bold;
	}
	
	.respuesta img.imagen {
	  max-width: 600px;
	     width: expression(this.width > 400 ? 400: true);
	     *width:300px;
	}
	
	
	.answerInfo, .comentarioInfo {
		float: left;
		width: 122px;
		text-align:right;
		padding-right: 10px;
	}
		.answerInfo h3, .comentarioInfo h3 {
			margin: 6px 2px 0 0;
			font-size: 11px;
		}
		
	.answerTxt,.comentarioTxt {
		float: left;
		width: 628px;
	}
	
	.primero .comentarioContainer  {
	  border-top:1px solid #CCCCCC;
	}
	
	.primero .comentarioTxt .Container {
	  border-top: none;
	}
	
	.primero .comentarioContainer {
	  -moz-border-radius-topleft:5px;
    -moz-border-radius-topright:5px;
    -webkit-border-radius-top-left:5px;
    -webkit-border-radius-top-right:5px;
	}
	
	.ultimo .comentarioContainer {
	  -moz-border-radius-bottomleft:5px;
    -moz-border-radius-bottomright:5px;
    -webkit-border-radius-bottom-left:5px;
    -webkit-border-radius-bottom-right:5px;
	}
	
	
	
	
	
	.answerTxt .Container {
    -webkit-border-radius:5px;
    -moz-border-radius:5px;
    background:#F7F7F7 none repeat scroll 0 0;
    border:1px solid #CCCCCC;
    padding:12px;
	}
	
	.agregar_comentario .answerTxt .Container {
	  background:#ffffcc none repeat scroll 0 0;
    border:1px solid #dbdba8;
	}
	
	.textA, .comentarioTxt p {
		margin:8px;
	}
	.answerTxt .Container,.comentarioTxt .Container {
	  color:#111111!important;
    font-size:12px;
    line-height:20px;
    padding: 12px;
	}
	
	#respuestas .answerTxt .Container {
	  padding:0;
	}
	.comentarioTxt .Container {
	  border-top:1px solid #FFF;
	}
	.answerRate {
		float: right;
	}
	.goodAnswer .badAnswer {
		
	}
	
	.ipMonitor {
	  font-size:11px;
	  text-align:right;
	  color:#666;
	}
	
	.commentDelete {
	  padding: 12px;
	  background: #FFAEAE;
	  text-align:center;
	  margin-top:5px;
	  color:#000;
	  width: 602px;
	  margin-left:132px;
	}	
	.autorPost .comentarioContainer {
	  background:#EEF9FE none repeat scroll 0 0;
    border:1px solid #7ED3F7;
	}
	
	
	.goodAnswer a , .badAnswer a {
		font-weight: bold;
		font-size: 11px;
		margin-top: 3px;
		display:block;
		padding: 2px 23px 5px 5px;
	}
	.goodAnswer a {
		background: url('/images/bgGood.gif') no-repeat left top;
	}
	
	.badAnswer a {
		margin-left: 5px;
		background: url('/images/bgBad.gif') no-repeat left top;
	}
	
	.modBar {
	  margin-top: 10px;
	}
	
	#buttons.modBar input.mBtn {
	  font-size:12px;
	  padding: 3px 5px;
	}

/* Comunidades */

.c_input{
	width: 400px;
}

.c_input_desc{
	width:200px;
	height:380px;
}

.desform {
  color:#999;
}
  #modalBody .data {padding: 0.25em 0;margin-top: 5px; clear:both;}
  
  .titleHighlight {
    background:#FFFFCC;
    border: 1px solid #e9e94f;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    font-weight: bold;
    color:#45450e;
    font-size:16px;
    padding: 8px;
  }
  
	/* Form styles */
	
	div.form-container { padding: 0 10px;}

	p.legend { margin-bottom: 1em; }
	p.legend em { color: #C00; font-style: normal; }

	div.errors { margin: 0 0 10px 0; padding: 5px 10px; border: #FC6 1px solid; background-color: #FFC; }
	div.errors p { margin: 0; }
	div.errors p em { color: #C00; font-style: normal; font-weight: bold; }

	div.form-container form p { margin: 0; }
	div.form-container form p.note { margin-left: 170px; font-size: 90%; color: #333; }
	div.form-container form legend { font-weight: bold; color: #666; }
	div.form-container form  div.data { clear:both; padding: 0.25em 0;margin-top: 5px; clear:both;}
	div.form-container form  div.dataL { padding: 0.25em 0;margin-top: 5px; width: 48%;float:left;}
	div.form-container form  div.dataR { padding: 0.25em 0;margin-top: 5px; width: 48%;float:right;}
	
	.c_input, .c_input_desc { margin-top: 5px;padding:8px; width: 95%; background: #FFF;}
  div.form-container select { margin-top:5px; }
	div.form-container form  div.postLabel { padding: 5px 0 0 0; display:block; }
	
	div.form-container label, div.form-container span.label { font-weight: bold;margin-right: 10px; font-size: 12px;padding-right: 10px; display: block;  text-align: left; position: relative; }
	div.form-container label.error, 
	div.form-container span.error { color: #C00; }
	div.form-container label em, 
	div.form-container span.label em { position: absolute; right: 0; font-size: 120%; font-style: normal; color: #C00; }
	div.form-container input.error { border-color: #C00; background-color: #FEF; }
	div.form-container input:focus,
	div.form-container input.error:focus, 
	div.form-container textarea:focus {	background: #FFC; border-color: #FC6; }
	div.form-container div.controlset label, 
	div.form-container div.controlset input { display: inline; float: none; }
	div.form-container div.controlset div { margin-left: 170px; }
	div.form-container div.buttonrow { margin-left: 180px; }
	.buttonAction {padding-left:170px;}
	
	div.postLabel label {
	  display: inline;
	  margin:0;
	  padding:0;
	}
	
	#ComInfo{
		overflow:hidden;
	}
	
	/* form2 */
	
	div.form2 input.c_input, div.form2 textarea.c_input_desc, .box_cuenta input{
	  padding:5px;
	  border: 1px solid #b1b1b1;
	  -moz-border-radius: 3px;
	  -webkit-border-radius: 3px;
    
	}
	div.form2 .dataR select, div.form2 .dataL select {
	  margin:10px 0 0 0;
	  width: 98%;
	}
	
	div.form2 .dataRadio {
	  font-weight: bold;
	}
	
	div.form2 .dataRadio input {
	  margin-right: 5px;
	}
  
	
	div.form2 .dataRadio .descRadio {
	  color:#666666;
    font-size:11px;
    font-weight:normal;
    margin:0 0 5px 24px;
	}
	
/* Fin Comunidades */





/* MAS OPORTUNIDADES */
#mas_oportunidades .mo_box {
	margin-bottom:10px;
	margin-left: 5px;
}

#mas_oportunidades .box_title {
	background:#aa0001 url(/images/anunciantes/mo/mo_box_titlebg.gif) repeat-x scroll 0 0;
}
#mas_oportunidades .box_txt {
	color: #FFF;
	font-weight:bold;
	background-image:url(/images/anunciantes/mo/mo_cor-izq.gif);
}

#mas_oportunidades .box_rss {
	background-image:url(/images/anunciantes/mo/mo_cor-der.gif);
}

#mas_oportunidades .input_izq, #ml .input_izq{
	background: #fbfbfc url(/images/anunciantes/mo/mo_input_izq.gif) no-repeat top left;
	border: none;
	float:left;
	width: 19px;
	height: 21px;
}
#mas_oportunidades input.buscador, #ml input.buscador {
	background: #fbfbfc url(/images/anunciantes/mo/mo_input_bg.gif) repeat-x top left;
	border: none;
	float:left;
	font-size: 11px;
	width: 150px;
	padding: 4px;
	height: 13px;
	margin: 0 -1px;
}

#mas_oportunidades .input_der, #ml .input_der {
	background: #fbfbfc url(/images/anunciantes/mo/mo_input_der.gif) no-repeat top left;
	border: none;
	float:left;
	width: 11px;
	height: 21px;
}
#mas_oportunidades input.mo_buscar {
	border: none;
	float:right;
	padding:0;
	background: none;
	margin-top: -1px;
}

#mas_oportunidades a.mo_linkTo {
	color: #0d62a8;
	padding-top: 10px;
	height: 1%;
}

#mas_oportunidades a img {
	border: 0;
}

/* MercadoLibre */
#ml .ml_box {
	margin-bottom:10px;
	margin-left: 5px;
}

#ml .box_title {
	background:#FCBC00 url(/images/anunciantes/ml/ml_box_titlebg.gif) repeat-x scroll 0 0;
}
#ml .box_txt {
	color: #FFF;
	font-weight:bold;
	background-image:url(/images/anunciantes/ml/ml_cor-izq.gif);
}

#ml .box_rss {
	background-image:url(/images/anunciantes/ml/ml_cor-der.gif);
}
#ml input.ml_buscar {
	border: none;
	float:right;
	padding:0;
	background: none;
	margin-top: -1px;
}

#ml a.ml_linkTo {
	color: #0d62a8;
	padding-top: 10px;
	height: 1%;
}

#ml a img {
	border: 0;
}

*:focus {outline: 0;}

.status_error{
	color:red;
}

/* Fix IE 6 */
* html #centro .box_cuerpo{
	width: 290px;
}

* html .comunidades #centro .box_cuerpo{
	width: 498px;
}


* html .comentarios_container .box_cuerpo{
	width: 740px;
}
* html .container350 .box_title{
	width: 350px!important;
}
* html .container350 .box_txt.registro_aclaracion{
	width: 324px!important;
}
* html .container350 .box_cuerpo{
	width: 334px!important;
}
* html #post_agregar .box_txt.registro{
	width: 548px!important;
}
* html  #post_agregar .box_rss{
	padding: 0;
	width: 0;
}

/* FIN - Fix IE 6 */

/* CSS markItUp */
.markItUp * {
	margin:0px; padding:0px;
	outline:none;
}
.markItUp a:link,
.markItUp a:visited {
	color:#000;
	text-decoration:none;
}
.markItUp  {
	margin:0;
}
.markItUpContainer  {
	font:11px Verdana, Arial, Helvetica, sans-serif;
}
.markItUpEditor {
	padding:5px;
	clear:both; display:block;
	line-height:18px;
	overflow:auto;
	margin-top:;
}
.markItUpHeader {
  padding-bottom:5px;
}
.markItUpFooter {
	width:100%;
}
.markItUpResizeHandle {
	overflow:hidden;
	width:22px; height:5px;
	margin-left:auto;
	margin-right:auto;
	background-image:url(/images/markit-handle.png);
	cursor:n-resize;
}
/* first row of buttons */
.markItUpHeader ul li	{
	list-style:none;
	float:left;
	position:relative;
	width:22px;
	height:22px;
	margin-right:2px;
}

.markItUpHeader ul li ul li	{
	width: auto;
}


.markItUpHeader ul li ul li:hover	{
	background: none;
}

.markItUpHeader ul li:hover {
	background-image:url(/images/bbcodeshover.png);
	
}

.markItUpHeader ul li:hover > ul{
	display:block;
}
.markItUpHeader ul .markItUpDropMenu {
	background:transparent url(/images/markit-menu.png) no-repeat 115% 50%;
	margin-right:5px;
	z-index:1;
}
.markItUpHeader ul .markItUpDropMenu li {
	margin-right:0px;
}
/* next rows of buttons */
.markItUpHeader ul ul {
	display:none;
	position:absolute;
	top:16px; left:0px;	
	background:#FFF;
	border:1px solid #CCC;
}
.markItUpHeader ul ul li {
	float:none;
	border-bottom:1px solid #CCC;
}
.markItUpHeader ul ul .markItUpDropMenu {
	background: #FFF url(/images/markit-submenu.png) no-repeat 100% 50%;
}
.markItUpHeader ul .markItUpSeparator {
	margin:0 10px;
	width:1px;
	height:16px;
	overflow:hidden;
	background-color:#CCC;
}
.markItUpHeader ul ul .markItUpSeparator {
	width:auto; height:1px;
	margin:0px;
}
/* next rows of buttons */
.markItUpHeader ul ul ul {
	position:absolute;
	top:-1px; left:150px; 
}
.markItUpHeader ul ul ul li {
	float:none;
}

.markItUpHeader ul ul li a {
	background:#FFF;
}

.markItUpHeader ul a {
  background-repeat:no-repeat;
  display:block;
  height:16px !important;
  margin:3px;
  text-indent:-10000px;
  width:16px;
}


.markItUpHeader ul ul a {
	display:block;
	padding-left:0px;
	text-indent:0;
	width:120px; 
	padding:2px 5px 1px 25px;
	background-position:2px 50%;
}
.markItUpHeader ul ul a:hover  {
	color:#FFF;
	background-color:#3B8BAC;
}


/* Botones */
.markItUp .markItUpButton1 a {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -48px;
	height: 10px;
}
.markItUp .markItUpButton2 a {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -64px;
	height: 10px;
}
.markItUp .markItUpButton3 a {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -189px;
	height: 10px;
}
.markItUp .markItUpButton4 a {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -0px;
	height: 10px;
}
.markItUp .markItUpButton5 a {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -16px;
	height: 10px;
}
.markItUp .markItUpButton6 a {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -32px;
	height: 10px;
}
.markItUp .markItUpButton7 a {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -208px;
	height: 10px;
}
	/* Seleccionar Color */
	.markItUpButton .markItUpButton7-1 a{
		color:darkred;
	}
	.markItUpButton .markItUpButton7-2 a{
		color:red;
	}
	.markItUpButton .markItUpButton7-3 a{
		color:orange;
	}
	.markItUpButton .markItUpButton7-4 a{
		color:brown;
	}
	.markItUpButton .markItUpButton7-5 a{
		color:yellow;
	}
	.markItUpButton .markItUpButton7-6 a{
		color:green;
	}
	.markItUpButton .markItUpButton7-7 a{
		color:olive;
	}
	.markItUpButton .markItUpButton7-8 a{
		color:cyan;
	}
	.markItUpButton .markItUpButton7-9 a{
		color:blue;
	}
	.markItUpButton .markItUpButton7-10 a{
		color:darkblue;
	}
	.markItUpButton .markItUpButton7-11 a{
		color:indigo;
	}
	.markItUpButton .markItUpButton7-12 a{
		color:violet;
	}
	.markItUpButton .markItUpButton7-13 a{
		color:black;
	}
.markItUp .markItUpButton8 a {
	background: url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -224px;
	height: 10px;
}
	/* Seleccionar Fuente */
.markItUp .markItUpButton9 a {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -174px;
	height: 10px;
}
	.markItUpButton .markItUpButton9-1 a{
		font-family: 'Arial';
	}
	.markItUpButton .markItUpButton9-2 a{
		font-family: 'Courier New';
	}
	.markItUpButton .markItUpButton9-3 a{
		font-family: 'Georgia';
	}
	.markItUpButton .markItUpButton9-4 a{
		font-family: 'Times New Roman';
	}
	.markItUpButton .markItUpButton9-5 a{
		font-family: 'Verdana';
	}
	.markItUpButton .markItUpButton9-6 a{
		font-family: 'Trebuchet MS';
	}
	.markItUpButton .markItUpButton9-7 a{
		font-family: 'Lucida Sans';
	}
	.markItUpButton .markItUpButton9-8 a{
		font-family: 'Comic Sans';
	}
.markItUp .markItUpButton10 a, .markitcomment .markItUp .markItUpButton4 a {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -80px;
	height: 10px;
}
.markItUp .markItUpButton11 a {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -96px;
	height: 10px;
}
.markItUp .markItUpButton12 a, .markitcomment .markItUp .markItUpButton6 a {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -112px;
	height: 10px;
}
.markItUp .markItUpButton13 a, .markitcomment .markItUp .markItUpButton5 a, .miRespuesta .markItUp .markItUpButton5 a  {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -128px;
	height: 10px;
}
.markItUp .markItUpButton14 a, .markitcomment .markItUp .markItUpButton6 a,.miRespuesta .markItUp .markItUpButton6 a  {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -144px;
	height: 10px;
}
.markItUp .markItUpButton15 a, .markitcomment .markItUp .markItUpButton7 a, .miRespuesta .markItUp .markItUpButton7  a, .citarAnswer  {
	background:transparent url('/images/bbcodes.png') no-repeat scroll left top;
	background-position: left -160px;
	height: 10px;
}
/* FIN - CSS markItUp */

#mask {
	position:absolute;
	z-index:100;
	left:0px;
	top:0px;
}
/* DIALOGO NUEVO HIPER BETA */

#modalBody {
  text-align:center;
  font-size:13px;
  padding: 20px 5px;
}



.modalForm {
  text-align: left;
  background: #EEE;
  border: 1px solid #b9b9b9;
  margin-bottom: 10px;
  padding: 5px;
  font-size:11px;
  font-weight:normal;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
}

#modalBody input[type="radio"] {
	width: auto;
    margin-right: 10px;
    vertical-align: baseline;
}

#modalBody .modalForm.here {
  background: #ffffcc;
  border: 1px solid #bebe33;
}

#modalBody input {
  margin: 0 0 0 0;
  vertical-align: middle;
}
#modalBody input#icausa_status {
  width: 300px;
}

.mTitle {
  font-weight: bold;
  font-size: 13px;
  padding-left: 5px;
}

.mColLeft {
  float:left;
  text-align: right;
  width: 35%;
}

.mColRight {
  float: right;
  width: 60%;
}

#cuerpo input.iTxt {
  border: 1px solid #CCC;
  background: #FFF;
  width: 160px;
  font-size: 11px;
  padding: 3px;
}

#modalBody input.mDate {
  width: 35px;
}

li.mBlock {
  margin-bottom: 10px;
  clear:both;
}

li.cleaner {
  clear:both;
}

.orange {
  color: #ff6600;
}

.buttons,#buttons {
  text-align: center;
  clear:both;
}

.comunidadData .buttons .mBtn.btnCancel {
  *width: 130px;
}

.mBtn {
  color: #FFF;
  font-size: 12px;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  padding: 5px 15px;
  font-weight:bold;
  cursor:pointer;
  width: 100%;
  padding: 5px 10px;
}

.mBtn.disabled {
	filter: alpha(opacity=20);
    opacity: 0.2;
}

.mBtn:active {
  background:#9a9a9a url(/images/btnRainbow.gif) repeat-x scroll left -265px!important;
  border:1px solid #666666!important;
  color:#FFFFFF!important;
  text-shadow:0 -1px 0 #111111!important;
}
#body_resp {
  margin-bottom: 10px;
}
.mBtn.bigF {
  font-size: 14px;
  padding: 5px 15px;
}

 .mBtn.btnOk {
  border: 1px solid #1c6bc6;
  background:#2e8af5 url('/images/btnRainbow.gif') top left repeat-x;
  color: #032342;
  text-shadow: 0 1px 0 #91c6f9;
  width: auto;
}

.mBtn.btnDelete {
  background:#b30100 url('/images/btnRainbow.gif') left -205px repeat-x;
  border: 1px solid #7f0908;
  color: #290202;
  text-shadow: 0 1px 0 #fb6d6d;
  width: auto;
}

.mBtn.btnCancel {
  border: 1px solid #848484;
  background:#bdbdbd url('/images/btnRainbow.gif') left -105px repeat-x;
  color: #656262;
  text-shadow: 0 1px 0 #EEE;
  width: auto;
}

.mBtn.btnGreen {
  border: 1px solid #06611d;
  background:#3ed32e url('/images/btnRainbow.gif') left -55px repeat-x;
  color:#043410;
  text-shadow:0 1px 0 #51E575;
}

.mBtn.btnYellow {
  border: 1px solid #f9ad1b;
  background:#ffc74b url('/images/btnRainbow.gif') left -155px repeat-x;
  color:#642514;
  text-shadow:0 1px 0 #fde088;
}

.nuevoTema {
  width:100px;
}

.mBtn.btnYellow {
  padding: 3px 10px;
}


/* mydialog OLD */ 


#mydialog #cuerpo {
	position: relative;
}

#mydialog #procesando {
	display: none;
	background: white;
	opacity: 0.9;
    filter: alpha(opacity=90);
	z-index:102;
	position:absolute;
	height: 100%;
	width: 100%;
}
#mydialog #procesando #mensaje {
	color:#222;
	position:relative;
	height: 100%;
}

#mydialog #procesando #mensaje img {
	left:44%;
	margin-right:10px;
	position:absolute;
	top:29%;
	vertical-align:middle;
	width:25px;
}

#mydialog #procesando #mensaje div {
  font-size:20px;
  font-weight:bold;
  margin-left:-25px;
  margin-top:25px;
  text-align:center;
}


#mydialog #buttons {
  margin-bottom: 5px;
  text-align: center;
	width: 100%;
}

#mydialog .guardarBtn {
  background: #b0de27;
  border: #607f08 1px solid;
  padding: 5px 15px;
  font-weight: normal;
  font-size: 14px;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  
  cursor: pointer;
  color: #222222;
}
#mydialog .guardarBtn.disabled{
opacity: 0.2;
background: #CCC;
border: 1px solid #333;
}

#mydialog .cancelarBtn {
  background: #d8d8d8;
  border: #c4c4c4 1px solid;
  padding: 5px 15px;
  font-size: 14px;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  
  cursor: pointer;
  color: #222222;
}


.selectCategorie {
	position:absolute;
	right:0;
	top:26px;
	display:none;
	z-index:101;
}

  .selectCategorie .selectCategorieHeader {
    background: url(/images/bgHeaderCat.png) -1px top  no-repeat;
	  width: 205px;
	  height: 10px;
	  text-align: center;
}

  .selectCategorie .selectCategorieFooter {
    background: url(/images/bgFooterCat.png) -1px top  no-repeat;
	  width: 205px;
	  height: 20px;
	  text-align: center;
}

	.selectCategorie ul {
	  background: url(/images/selectCatBody.png) top left repeat-y;
	  padding: 10px 10px;
	  overflow: hidden;
  }
	.selectCategorie li {
	  overflow: hidden;
  }

/****************************************************************************************************************************************************/
.scrollable {
	position:relative;
	overflow:hidden;	
	height: 275px;
	width: 205px;
}

.scrollable .items {
	position:absolute;
	width: 205px;
	top: 0px;
}

/****************************************************************************************************************************************************/

  .selectCategorie ul li  {
	  height: 20px;
	  margin: 2px 0;
	  display: block;
	  padding: 3px 0 0 0;
  }

 .selectCategorie  span {
		  padding: 0 0 0 20px;
      margin-left: 5px;
}
  .selectCategorie ul li:hover {
	  background: url(/images/hoverLi.gif) no-repeat top left;
  }
  
  .selectCategorie ul li:hover a {
  	color: #FFF;
  	font-weight: bold;
  	width: 400px;
  }


	.selectCategorie ul li span.categoria {
	  float: none;
	  width: 100%;
  }

.infoPost {
  width: 715px;
  margin-top:10px;
	padding: 10px;
	background: #E1E1E1;
	border: 1px solid #CCC;
	clear:both;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

.infoPost strong.title {
	margin-bottom: 3px;
	display: block;
}

.infoPost .shareBox , .infoPost .rateBox , .infoPost .tagsBox , .infoPost .metaBox, .infoPost .ageBox {
	width: 20%;
	float: left;
}

.infoPost .tagsBox {
  width:40%;
}


.infoPost .socialIcons,.container370 .socialIcons {
  background: url('/images/socialIcons.png') no-repeat;
  float: left;
  margin-right: 5px;
  display: block;
  width: 16px;
  height: 16px;
}
.infoPost .socialIcons.delicious,.container370 .socialIcons.delicious {background-position: 0 0;}
.infoPost .socialIcons.facebook,.container370 .socialIcons.facebook  {background-position: 0 -16px;}
.infoPost .socialIcons.digg,.container370 .socialIcons.digg  {background-position: 0 -32px;}
.infoPost .socialIcons.twitter,.container370 .socialIcons.twitter  {background-position: 0 -48px;}
.infoPost .socialIcons.email,.container370 .socialIcons.email {background-position: 0 -64px;}





.infoPost .rateBox {
	font-weight: bold;
}
.thumbs {
  background: url('/images/thumbs.png') no-repeat;
  display: block;
  float: left;
  width: 16px;
  height: 16px;
  margin-right: 3px;
}

.thumbs.thumbsUp {
  background-position: 0 0;
}

.thumbs.thumbsDown {
  background-position: 0 -16px;
}

.thumbs.thumbsUp:hover {
  background-position: 0 -32px;
}

.thumbs.thumbsDown:hover {
  background-position: 0 -48px;
}

.infoPost .tagsBox ul li {
	display: inline;
	font-size: 11px;
}

.infoPost .metaBox {
	text-align: right;
}

div.filterBy, .paginatorBar {
  background: #f3f3f3;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  padding: 8px;
}

.paginatorBar a, .paginator a {
  font-weight:bold;
  padding: 5px 10px;
  color: #FFF;
  background: #383838;
 	-moz-border-radius: 3px;
 	-webkit-border-radius: 3px;
 	display:block;
}

.paginadorCom .next a, .paginadorCom .before a {
  font-weight:bold;
  padding: 5px 10px;
  color: #FFF;
  background: #383838;
 	-moz-border-radius: 3px;
 	-webkit-border-radius: 3px;
}
div.filterBy a {
	color:#2f2f2f
}
div.filterBy ul {
  float: right;
}


div.filterBy ul li {
  float: left;
  margin-left: 10px;
  color: #383838;
  font-weight:bold;
  background:#999;
 	-moz-border-radius: 3px;
 	-webkit-border-radius: 3px;
 	border-bottom:1px solid #FFF;
}

div.filterBy ul li a  {
  color: #FFF;
  font-weight:bold;
  padding: 5px 10px;
  display: block;
}

div.filterBy ul li:hover {
  background:#002561

}

div.filterBy ul li:hover a  {
  color: #FFF;

}

div.filterBy ul li.here {
  background: none;
  font-weight: bold;
  color: #FFF;
  background: #34569d;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
}

div.filterBy ul li.here a {
  color: #FFF;
}


div.filterBy ul li select {
  margin: 3px 0 0 5px;
}
.orderTxt {
  border-bottom: none!important;
  padding-top:5px;
  background:none!important;
}

.memberInfo {
	width: 33%;
	float: left;
}

.memberInfo a {
	font-size: 12px;
	font-weight: bold;
	color: #053e78;
}
.memberInfo img {
  width: 60px;
  height: 60px;
  display: block;
	padding: 1px;
	border: 1px solid #C1C1C1;
  margin-top: 5px;
}

a.btnNegative,a.btnPositive, a.btnNeutral {
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  color:#FFF;
  display:block;
  margin:10px 0 0;
  padding:5px;
}

a.btnPositive {background:#00992d;}
a.btnNegative {background:#990200;}
a.btnNeutral {background:#999;}

.Container textarea {
  border:medium none;
  background: #FFF;
  font-size:13px;
  height:50px;
  margin:0;
  padding:0;
  min-height: 50px;
  max-height: 500px;
  vertical-align:bottom;
  width: 98%;
  border: 1px solid #CCC;
  padding: 5px;
  margin-top:5px;
  clear:both;
  float:left;
}
* html .Container textarea {
  float: none;
}

.postBy {
  border: 1px solid rgb(204, 204, 204);
  padding: 8px; 
  background: rgb(238, 238, 238) none repeat scroll 0% 0%; 
  -moz-border-radius: 4px; 
  -webkit-border-radius: 4px;
  
  font-size: 11px; 
  width: 100px;
  float:left;
}

a.btnActions {
   color:#333;
   font-weight: bold;
   font-size:11px;
  -moz-border-radius: 4px; 
  -webkit-border-radius: 4px;
  background: #CCC;
  padding: 3px 5px;
  margin-left: 5px;
}

/* test boton */

.clear { /* generic container (i.e. div) for floating buttons */
    overflow: hidden;
    width: 100%;
}

a.buttontema.suscribirme, a.buttontema.desuscribirme {
  float:none;
}
a.buttontema {
    background: transparent url('/images/btnComu.png') no-repeat scroll top right;
    color: #444;
    display: block;
    float: left;
    font: normal 12px arial, sans-serif;
    height: 25px;
    padding-right: 18px; /* sliding doors padding */
    text-decoration: none;
}

a.buttontema:active,a.buttontema.blue:active  {
    color:#FFF;
   background: transparent url('/images/btnComu.png') no-repeat scroll right -26px;
}

a.buttontema:active span, a.buttontema.blue:active span {
   background: transparent url('/images/btnComu.png') no-repeat scroll left -26px;
}
a.buttontema span {
    background: transparent url('/images/btnComu.png') no-repeat;
    display: block;
    line-height: 21px;
    padding: 1px 0 4px 18px;
    font-weight:bold;
}




a.buttontema.yellow {
    color:#994800;
    text-align:center;
    width:91%;
    height: 31px;
    background: transparent url('/images/btnComu.png') no-repeat scroll right -80px;
}


a.buttontema.yellow span {
   background: transparent url('/images/btnComu.png') no-repeat scroll left -80px;
   text-shadow: #FFF 0 1px 0;
   padding: 5px 0 5px 18px;
}

a.buttontema.blue, a.buttontema.suscribirme {
    margin-top:8px;
    color:#051f45;
    text-align:center;
    background: transparent url('/images/btnComu.png') no-repeat scroll right -52px;
    text-shadow: #8bbbf1 0 1px 0;
    
}

a.buttontema.blue span, a.buttontema.suscribirme span {
   background: transparent url('/images/btnComu.png') no-repeat scroll left -52px;
}

.searchBtn {
   background: transparent url('/images/btnComu.png') no-repeat scroll right -112px;
   border: none;
   color: #FFF;
   font-weight:bold;
   float:left;
}

.searchBtn a {
   padding: 4px 10px ;
   display: block;
   padding: 8px 15px;
   font-size: 13px;
   color: #004051;
   text-shadow: 0 1px 0 #82d4f2;
}

.searchBtn a:hover {
   color: #00617b;
   text-decoration:none;
}

/* Buscador */

#buscador.alone {
  margin: 50px auto;
}

#buscador {
  margin: 0 auto 15px auto;
  text-align:center;
  width: 480px;
}

#buscador h2 {
  color:#FF6600;
  font-size:16px
}
#buscador .boxSearch {
  margin: 0 auto;
  text-align:center;
  margin-bottom: 15px;
}

#buscador img, #buscador input {
  vertical-align: middle;
}

.searchBar {
  padding: 7px 0 0 7px;
  -moz-border-radius-topleft: 3px;
  -moz-border-radius-bottomleft: 3px;
  height: 21px;
  border:1px solid #AFAFAF;
  width: 406px;
  float:left;
}
#buscador div.filterBy ul {
  float:none;
  margin:0 auto;
  width:190px;
}
.xResults {
  font-size:14px;
  line-height: 23px;
}
.xResults strong {
  color:#004a95;
}

#resultados #showResult {
}

#showResult ul li.resultBox {
  float:left;
  width: 48%;
  margin: 5px;
  height: 125px;
}

#showResult ul li h4 {
  margin: 5px 0;
}

#showResult ul li h4 a {
  color:#053e78;
  font-size: 14px;
}

#showResult .avatarBox {
  width: 85px;
  position:relative;
  background:transparent url(/images/shadowAvaS.gif) no-repeat scroll left bottom;
  height:85px;
}

#showResult .avatarBox .riboon {
  position: absolute;
  display:none;
  border:none;
  background:none;
}

#showResult .resultBox.oficial .avatarBox .riboon {
  display:block;
  left:-9px;
  top:30px;
}

#showResult .infoBox {
  width: 230px;
}

#centro #showResult .infoBox {
  width: 145px;
}


#showResult ul li img {
  padding: 2px;
  background: #FFF;
  border: 1px solid #CCC;
  float:left;
}

#showResult ul li ul {
  margin-left: 5px;
  float:left;
  color:#222;
  width:100%;
  margin-right: 15px;
}

#showResult ul li ul li {
  border-top: 1px solid #CCC;
  padding: 3px 4px;
  width:100%;
}


#showResult ul li ul strong {
  color: #000;
}

#resultados {
  width:100%;
  float: left;
}
#resultados .filterBy, #resultados .paginatorBar {
  width: 750px;
}

.betaMsg {
  background: #FFFFCC;
  border-bottom: 1px solid #d0d00d;
  padding:8px;
  text-align:center;
  margin-bottom: 10px;
}


/* Monitor nuevo */

.commentBoxM {
  margin-top: 5px;
}
#monitor .hTitleM {
  border-bottom:1px solid #999;
  -moz-border-radius-topleft:5px;
  -moz-border-radius-topright:5px;
  background-color: #C3C3C3;
  margin:0;
}



.hTitleM .postTitleM {
  color:#444;
  font-size:13px;
  font-weight:bold;
  float:left;
}

.hTitleM span.pointsPost {
  color:#333;
  display:block;
  float:right;
  font-weight:bold;
  margin-right:5px;
}

.commentBoxM .monitor_comentario {
  border-bottom:1px dashed #CCC;
  background: #EEE;
  padding: 3px 8px;
}

.commentBoxM .monitor_comentario span {
  color:#666;
}

.commentBoxM .monitor_comentario a {
  font-weight:bold;
  color:#FF6600;
}
.commentBoxM .mDate {
  color:gray;
  font-size:10px;
  font-weight:normal;
  vertical-align:middle;
}

ul.points_user {
  background: #EEE;
}

ul.points_user li {
  padding:5px;
  font-size:13px;
  font-weight:bold;
  border-bottom: 1px dashed #CCC;
}

ul.points_user li a {
  vertical-align:middle;
  font-size:11px;
}

ul.points_user li span.mBtn {
  width: auto;
  float:right;
}

/*  System Icons */

.userIcons {
  margin-top:5px;
}

.userIcons li {
  float:left;
  margin-right:5px;
}
.systemicons {
  width: 16px;
  height: 16px;
  background-image: url(/images/big2v1.png);
  background-repeat: no-repeat;
  display:block;
}


.systemicons.rango0 {background-position: 0 -638px;} /* Novato */
.systemicons.rango1 {background-position: -1px -660px;} /* NFU */
.systemicons.rango2 {background-position: 0 -110px;} /* Full User */
.systemicons.rango3 {background-position: 0 -682px;} /* Great User */
.systemicons.rango4 {background-position: 0 -748px;} /* Silver User */
.systemicons.rango5 {background-position: 0 -770px;} /* Gold User */
.systemicons.rango6 {background-position: 0 -705px;} /* Moderador */
.systemicons.rango7 {background-position: 0 -945px;} /* Patrocinador */
.systemicons.rango8 { background-image: url(/images/big2v4.gif);  background-position: 0 -43px;} /* Admin */

.systemicons.sexoM {background-position: -2px -132px}
.systemicons.sexoF {background-position: 0 -153px}
.systemicons.messages {background-position:0 -221px; float:left;}
.systemicons.messages2 {background-position:0 -855px;}
.systemicons.messagesNew {background-position:0 -910px;}
.systemicons.historyMod { background-position: 0 -1252px; }
.systemicons.myaccount { background-position: 0 -874px; }
.systemicons.favorites { background-position: 0 -946px; }
.systemicons.eye { background-position: 0 -929px; }
.systemicons.actualizar { background-position: 0 -1000px; cursor:pointer; }
.systemicons.logout { background-position: 0 -964px; }
.systemicons.logout:hover { background-position: 0 -982px; }
.systemicons.sRss { background-position: 0 -1018px; cursor:pointer;}
.systemicons.fecha { background-position: 0 -1275px; }
.systemicons.respuestas { background-position: 0 -1298px; }
.systemicons.cerrada {background-position:0 -1326px; display:inline;width:auto;height:auto;padding-left: 12px;}


.tipsy {
	padding: 5px;
	font-size: 10px;
	background-repeat: no-repeat;
}
.tipsy-inner { padding: 4px 5px;
	background-color: black;
	color: white;
	max-width: 200px;
	text-align: center;
	font-weight: bold;
}
  .tipsy-north { background-image: url(/images/tipsy-north.gif); background-position: top center; }
  .tipsy-south { background-image: url(/images/tipsy-south.gif); background-position: bottom center; }
  .tipsy-east { background-image: url(/images/tipsy-east.gif); background-position: right center; }
  .tipsy-west { background-image: url(/images/tipsy-west.gif); background-position: left center; }
  
.paginadorCom {
  background: #F7F7F7;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  width:617px;
  padding: 5px;
  margin:10px 0;
  float:right;
}

.paginadorCom ul {
  padding:2px;
  text-align: center    ;
}

.paginadorCom ul li.numbers {
  /* border:1px solid #CCC; */
  font-weight: bold;
  padding:0;
}

.paginadorCom ul li.numbers a {
  padding: 2px 5px;
  color:#000;
  text-decoration:underline;
}
.paginadorCom ul li.numbers a.here {
  background:#0067CD;
  color:#FFF;
  text-decoration: none;
}

.paginadorCom ul li.numbers a:hover {
  background:#CCC;
  color:#0067CD;
}

.paginadorCom ul li {
  border: none;
  background: none;
  display:inline;
  margin-right: 5px;
  padding: 3px 0;
  font-size:13px;
}
.paginadorCom ul li a {
  color: black;
  padding:0;
}

a.pagiLink {
  -moz-border-radius: 3px;
  background:#383838 none repeat scroll 0 0;
  color:#FFFFFF;
  display:block;
  font-weight:bold;
  padding:5px 10px;
}

.linksList {
  width: 100%;
  border-spacing:0px;
}

.linksList thead {
  background:#F3F3F3;
}
.linksList thead a {
  padding:5px 10px;
  background:#999999!important;
  color:#FFF;
  -moz-border-radius: 3px;
  -webkit-border-radius:3px;
}

.linksList thead a.here {
  -moz-border-radius: 3px;
  -webkit-border0radius:3px;
  background:#34569d!important;
  color:#FFFFFF!important;
  cursor: pointer;
  font-weight:bold;
  display:block;
  font-weight:bold;
  padding:5px 10px;
  border-bottom:1px solid #FFF;
}
.linksList thead a.here:hover {
  cursor:default;
  text-decoration: none;
}


.linksList thead a:hover {
  -moz-border-radius: 3px;
  background:#002561;
  color:#FFF;
  padding:5px 10px;
}


.linksList thead th strong {
  color:#004A95;
}
.linksList thead th  {
  text-align:center;
  border: none;
  color:#383838;
  padding: 8px;
  font-size:13px;
}

.linksList tbody tr:hover {
  background:#EEE;
}
.linksList tbody td {
  padding: 5px;
  border-bottom: 1px dashed #CCC;
  text-align:center;
  color:#666;
}

.linksList .categoriaPost {
  display:block;
  height:20px;
  margin-left:-5px;
  padding:0;
  width:21px;
}

.linksList .categoriaPost:hover {
  background-color:transparent;
}

.linksList span {
  color: #666;
}

.linksList .titlePost {
  font-size:13px;
  color: #007394;
  font-weight:bold;
}

.categoriaList {
  -moz-border-radius:10px;
  background:#EAEAEA;
}

.categoriaList ul {
  padding-bottom:10px;
}

.categoriaList li {
  position:relative;
  font-size:12px;
  line-height:16px;
  padding:2.5px 0 2.5px 8px;
}

.column {
  width: 55px;
  margin:0 5px;
}

.columnBig {
  width: 100px;
  margin:0 5px;
}

.answerOptions {
  background:#EEE;
  font-size:11px;
  height:20px;
  padding:3px;
  color:#666;
}

.answerOptions .metaDataA {
  margin-left: 4px;
}
.answerOptions ul li {
  float: left;
  display:block;
  background: url('/images/d-opt.gif') no-repeat 0px 7px;
  padding:2px 5px 0 10px;
}

.answerOptions ul li.answerCitar {
  background: none;
}

.answerOptions ul li.deleteAnswer a img  {
  margin: 2px;
}
.answerOptions .systemicons {
  margin-top:1px;
}

.citarAnswer {
  display:block;
  height:16px;
  width:16px;
}

.relevancia {
  margin:0 auto;
  height:14px;
  width: 68px;
  background:top left url('/images/relevanciabg.gif') no-repeat;
}
.porcentajeRel {
  background:top left url('/images/relevanciaBars.gif') no-repeat;
  height:14px;
}

.paginadorBuscador {
  background: #F7F7F7;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  width:930px;
  padding: 5px;
  margin-top: 10px;   
  float:right;
  position:relative;
}

.paginadorBuscador .pagesCant {
  width:100%;
}
.paginadorBuscador ul {
  padding:4px;
  text-align: center;
}

.paginadorBuscador ul li.numbers {
  /* border:1px solid #CCC; */
  font-weight: bold;
  padding:0;
}

.paginadorBuscador ul li.numbers a {
  padding: 2px 5px;
  color:#000;
  text-decoration:underline;
}
.paginadorBuscador ul li.numbers a.here {
  background:#0067CD;
  color:#FFF;
  text-decoration: none;
}

.paginadorBuscador ul li.numbers a:hover {
  background:#CCC;
  color:#0067CD;
}

.paginadorBuscador ul li {
  border: none;
  background: none;
  display:inline;
  margin-right: 5px;
  padding: 3px 0;
  font-size:13px;
}
.paginadorBuscador ul li a {
  color: black;
  padding:0;
}

.paginadorBuscador .next a, .paginadorBuscador .before a {
  font-weight:bold;
  padding: 5px 10px;
  color: #FFF;
  background: #383838;
 	-moz-border-radius: 3px;
 	-webkit-border-radius: 3px;
 	display:block;
}

.paginadorBuscador .next, .paginadorBuscador .before {
  position:absolute;
  top:5px;
}

.paginadorBuscador .next {
  right: 5px;
}

.paginadorBuscador .before {
  left: 5px;
}


/* buscador rapido */

.searchFil {
	color: #666;
}
.searchWith {
	font-weight:bold;
	color: #000;
	font-size: 13px;
	float:left;float:left;
}
.searchWith a {
	color:#004a95!important;
}

.searchWith a.here {
  color: #000!important;
}
span.sep {
	font-weight: normal;
	color:#EEE;
	margin:0 5px;
}
.searchTabs {
	bottom:-1px;
  margin-bottom:-1px;
  position:relative;
  *bottom:0px;
}
.searchTabs li {
	border:1px solid #CCC;
	float:left;
	background: #EEE;
	margin-right: 5px;
	font-weight: bold;
	font-size:13px;
	position:relative;
	z-index:10;
}

.searchTabs li  a {
	color: #004a95;
	padding:5px 15px;
	display:block;
}
.searchTabs li.here a {
	color: #000;
	padding:5px 15px;
	display:block;
}
.searchTabs li:hover {
	background: #CCC;
}
.searchTabs li.here {
	background: white;
	border-bottom:1px solid #FFF;
}

.searchTabs li.clearfix {
  border:none;
  padding:0;
  margin:0;
  background:none;
}


#buscadorBig {
	position:relative;
	width:555px;
	margin: 45px auto;
}
.searchCont {
	margin-top: -1px;
	padding:12px;
	*padding-top: 6px;
	border: 1px solid #CCC; 
	clear:both;
	background: url('/images/gradientSearch.gif') bottom left repeat-x;
	-moz-border-radius-bottomleft:5px;
  -moz-border-radius-bottomright:5px;
  -moz-border-radius-topright:5px;
}

.logoMotorSearch {
  *margin-right:12px;
  float:right;
}
.searchBar {
	-moz-border-radius:3px;
	margin-right: 10px;
	font-size:18px;
	padding:7px 0 8px 7px;
	*width: 370px;
}
.boxBox {
	-moz-border-radius: 5px;
	background: #E1E1E1;
}
#buscadorLite .boxBox {
  *height:60px;
}
.inputTxt {
	border: 2px solid #E1E1E1;
	-moz-border-radius: 5px;
	background: #FFF;
	width: 100px;
}
.filterSearch {
	padding: 8px ;
	-moz-border-radius-bottomleft: 5px;
	-moz-border-radius-bottomright: 5px;
	border-top: 1px dashed #CCC  ;
}
.filterSearch strong {
	display: block;
	float:left;
	color:#000;
	margin: 2px 20px 2px 0;
}
.searchEngine {
	padding:8px;
}

.searchEngine .mBtn {
  padding:6px 10px;
  font-size:17px;
  *padding: 6px 2px;
}

.whereSearch {
  border-right: 1px solid #CCC; 
  padding-right: 20px;
  float:left;
}

.byCatSearch {
  border-left: 1px solid #FFF; 
  padding-left: 20px;
  float:left;
}

.byCatSearch label {
  *margin-top:-5px;
}

.byCatSearch select {
  margin-top:2px;
  width: 200px;
  height:20px
}
/* Lite  */
#buscadorLite {
	margin-bottom:15px;
}
#buscadorLite .searchEngine{
	float:left;
}
#buscadorLite .filterSearch{
	float:left;
	border:none;
}
#buscadorLite .filterSearch strong {
	margin:0 15px 0 0;
}
#buscadorLite .searchTabs li {
  font-size:12px;
} 
#buscadorLite .searchWith {
	float:left;
}


.clearfix:after{clear:both;content:".";display:block;font-size:0;height:0;line-height:0;visibility:hidden}
.clearfix{display:block; *zoom:1;_zoom:1}


/* slightly enhanced, universal clearfix hack */
.clearfix:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0;
 }

.clearfix {
        display: inline-block;
 }

/* start commented backslash hack \*/

* html .clearfix {
        height: 1%;
 }

.clearfix {
        display: block;
}
/* close commented backslash hack */


#cuerpocontainer .tops {
  padding:0 5px 0 0;
  width:308px !important;
}

.filterFull {
  width: 100%;
}
.resultadosFull .resultFull {
  float:left!important;
  width:730px!important;
}

.resultadosFull {
  float:none!important;
  width:100%!important;
}

.resultadosFull .filterBy {
  width:925px!important;
}

.resultadosFull .paginadorBuscador {
  width:720px;
  float:left;
}

.ads120-240 {

  background: #E7E7E7;
  padding:0 20px;
}

.ads120-240 #ads {
  margin: 0 auto!important;
}

.yahooAds {
    background:#F3F3F3;
    padding:2px 4px 0px 6px;
    margin-bottom:15px;
  }
  .yahooAds h2 {
    margin:0;
  }
  
  .yahooAds .spns {
    margin:0;
  }
/* deleted post */

.post-deleted .categoriaPost a, .post-denunciado .categoriaPost a {
	color:#007394;
	font-size: 14px;
	font-weight: bold;
}



.post-deleted h4, .post-denunciado h4 {
	color:#FF6600;
	font-size: 16px;
	margin-bottom: 5px;
}

.post-deleted h3, .post-denunciado h3 {
	font-size: 18px;
	color: #CE0101;
	margin: 0 0 5px 0;
}

.post-deleted, .post-denunciado {
	margin: 25px 25px;
	min-height: 325px;
	_height: 325px
}
.post-denunciado {
	background: url(/images/denunciado_post.gif) no-repeat bottom right; 
}
.post-deleted {
	background: url(/images/deleted-post.gif) no-repeat bottom right; 
}

.post-deleted ul,.post-denunciado ul  {
	width: 480px;
}

#post-centro .box_cuerpo a:visited {
	color:#551A8B!important;
	font-weight: bold;
}



/* CSS NUEVO POST */


	.avatarBox {
		width: 120px;
		height: 120px;
		overflow: hidden;
		margin: 0 auto 10px auto;
	}
	.metadata-usuario {
		font-weight: bold;
		text-transform: uppercase;
		color: #000;
	}
	.metadata-usuario .nData {
		color:#FF6600;
		display:block;
		font-size:15px;
		margin-top:8px;
	}
	
	.post-autor .box_cuerpo {
		overflow: hidden;
}
	.post-autor a .given-name  {
		font-size: 14px;
		color:#004a95;
		font-weight: bold;
	}
	.post-autor .rango {
		color:#666666;
	}
	.post-title .icons.anterior {
		position: absolute;
		left: 8px;
		top: 9px;
		padding: 0;
		width: 16px;
		height: 16px;
		display:block;
	}
	.post-title .icons.siguiente {
		position: absolute;
		right: 8px;
		top: 9px;
		padding: 0;
		width: 16px;
		height: 16px;
		display:block;
	}
	.comentarios-title .paginadorCom .before,	.comentarios-title .paginadorCom .next {
		display:block;
		margin: 0;
		padding: 0;
	}

	.comentarios-title .paginadorCom .desactivado {
		background: #EEE!important;
		color: #FFF!important;
	}

	.comentarios-title .paginadorCom .desactivado:hover {
		text-decoration: none;
	}


	.comentarios-title .paginadorCom .before a, .comentarios-title .paginadorCom .next a {
		background: url('/images/bg_before_next.gif') bottom left repeat-x #d2d2d2; 
		padding: 12px 20px;
		font-size:13px;
		color: #383838;
		text-shadow: 0 1px 0 #FFF;
	}


	.title-tags {
		font-size: 14px;
		font-weight: bold;
	}
	.post-relacionados h4 {
		margin: 8px;
		font-size: 14px;
	}

	.post-relacionados ul {
		margin: 0 10px 10px 10px;
		overflow:hidden;
	}



	.post-relacionados ul li.categoriaPost  {
		margin-bottom:0;
	}

	.post-relacionados ul li.categoriaPost  a {
		height:16px;
		overflow:hidden;
	}





	.post-relacionados ul li.categoriaPost:hover  {
		background-color: none;
	}

	#post-comentarios {
		margin-top: 15px;
		float: left;
	}

	#post-comentarios .miComentario .answerInfo {
		width: 162px;
	}


	#post-comentarios .miComentario .answerTxt {
		width: 768px;
		width: 760px!important;
	}


	#post-comentarios .paginadorCom {
		float: none;
		width: 765px;
		padding: 0;
	}

	#post-comentarios .paginadorCom li {
		display:-moz-inline-stack;
		display:inline-block;
		zoom:1;
		*display:inline;
	}
	#post-comentarios .paginadorCom .next a, #post-comentarios .paginadorCom .before a { 
		display: block;
	}

	#post-comentarios .paginadorCom ul {
		padding: 0;
	}

	#post-comentarios .paginadorCom ul li.numbers a  {
		padding: 12px 8px;
		display: block;
		color: #004a95;
		text-decoration: none;
	}

	#post-comentarios .paginadorCom ul li.numbers a.here  {
		color: #000;
		text-shadow: 0 1px 0 #e5e5e5;
		border-right: 1px solid #c4cacf;
		border-left: 1px solid #c4cacf;	
		background: #e3e3e3;
	}


	#post-comentarios .paginadorCom .numbers {
		font-size: 16px;
	}

	#post-comentarios .comentarios-title {
		width: 765px;
		margin-left: 175px;
	}
	.comentario-post {
		margin-bottom: 10px;
	}
	.comentario-post .avatarspace {
	float:left;
		width:160px!important;
		height: 30px;
		text-align: right;
	}

	.comentario-post .avatarspace a {
		font-weight: bold;
		color:#004a95;
		font-size: 12px;
	}


	.comentario-post .commenttext p {
		margin: 12px;
		font-size:12px;
		line-height:20px;
	}
.comentario-post, .miComentario {
	width: 940px
}
	.comentario-post .commenttext {
		background:#F7F7F7 none repeat scroll 0 0;
		border:1px solid #CCCCCC;
		-moz-border-radius: 5px;
		float: right;
		_width:755px;
		width: 765px
	}
	.banner-300 {
		width: 300px;
		height: 250px;
		background:#EEE;
		float:right;
		margin-right: 4px;
	}
	.post-relacionados {
		background: #EEE;
		width: 438px;
		margin-right: 22px;
		marg\in: 0px;
		border:1px solid #cfcfcf;
		float:left;
		-moz-border-radius: 5px;
	}
	.post-estadisticas .icons.puntos_post {
		background-position: right -40px;
	}

	.post-estadisticas .icons.favoritos_post {
		background-position: right -64px;
	}

	.post-estadisticas .icons.visitas_post {
		background-position: right -87px;
	}

	.post-estadisticas .icons {
		padding-right: 20px;
	}

	.post-metadata hr {
		margin: 5px 0;
		_margin: 0;
		padding: 0;
	}

	.tags-block {
		float: left;
		width:485px;
	}

	.tags-block span.tags_title {
		display:block;
		font-weight: bold;
		font-size: 13px;
		color:#333333;
		padding-left: 22px;
		background-position: left -1343px;
		margin-bottom: 3px;
	}

	.tags-block a {
		font-size:11px;
		font-weight:bold;
		color: #004A95;
	}
	.post-cat-date {
		float: right;
		text-align: right;
		font-size: 13px;
		line-height:1.8em;
		width: 250px;
	}
	.post-estadisticas li span {
		color: #000000;
		font-size:  13px;
	}
	.post-acciones {
		color: #383838;
		float: left;
		font-size: 12px;
	}

	.dar-puntos {
		color:#999999;
		font-weight:normal;
		margin:5px;
		text-align:center;
	}
	.dar-puntos span {
		color:#000000;
		font-size:12px;
		font-weight:bold;
	}

	.dar-puntos a {
		color: #005ACB;
		font-weight: bold;
		font-size: 12px;

	} 
	.post-acciones ul {
		margin-top: 8px;
		font-weight: bold;
	}



	.post-estadisticas {
		font-size: 14px;
		text-transform: uppercase;
		float: right;
		font-weight: bold;
		color: #666666;
		text-shadow: 0 1px 0 #f6f6f6;
		text-align: right;
	}

	.post-estadisticas li {
		float: right;
		margin-left: 20px;
		font-size: 11px;
	}

	.post-acciones li {
		float:left;
		margin-right: 10px;
	}
	.post-metadata {
		width: 100%;
		background: url('/images/bg_meta.gif') repeat-x top left #e6e6e6 ;

	}
	.post-wrapper .post-autor {
		padding:2px;
		width:160px;
		float:left;
		height:auto;
		overflow:visible;
	}

	.post-contenedor {
		width: 760px;
		margin-left: 10px;
		background: #EEE;
		border: 1px solid #cfcfcf;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		float: left;
		margin-bottom: 10px;
		position:relative;
	}

	.post-title  {
		border-bottom: 1px solid #CCC;
		text-align: center;
		padding: 10px 0;
		background:#CCC;
	}

	.post-title h1 {
		font-size: 14px;
		color: #333333;
		font-weight: bold;
		text-shadow: 0 1px 0 #f5f5f5;
		margin: 0;
	}

	.post-contenido {
		padding: 12px;
		border-top:1px solid #f6f6f6;
		font-size: 13px;
		line-height: 1.5em;
		overflow: hidden;
	}

	#post-comentarios #body_comm  {
		margin-bottom: 10px;
	}


	#post-comentarios .buttons *,#post-comentarios  .buttons {
		_height:1%;
	}

	#post-comentarios .commenttext {
		font-size: 13px;
	}

	.post-metadata .mensajes.ok {
		background:#C4E19B none repeat scroll 0 0;
		color:#333333;
		font-weight:bold;
		margin-bottom:10px;
		padding:10px;
		text-align: center;
	}

	.post-metadata .mensajes.error {
		background:#FFFFCC none repeat scroll 0 0;
		color:#333333;
		font-weight:bold;
		margin-bottom:10px;
		padding:10px;
		text-align: center;
	}
	
	.post-compartir {
		margin-top: 5px;
	}
	
	.post-compartir li {
		display: inline;
	}
	
	.cuerpo_comm {
	padding: 3px 10px 10px 10px;
	margin: 0!important;
	overflow: hidden;
}

/* MOD BARRA NUEVA */


.moderacion_del_post {
	background: #171f2b url('/images/bg_mods.gif') repeat-x top left;
	width: 100%;
	z-index: 100;
	left: 0;
	bottom:0;
	position:fixed;
	-moz-box-shadow: 0 -5px 5px rgba(0, 0, 0, 0.2);
}

.moderacion_del_post .gifCargando {
position:absolute;
right:15px;
top:11px;
}


.moderacion_del_post ul li {
	list-style: none;
	display: inline-block;
	padding: 0 0 0 5px;
}

.moderacion_del_post ul li a {
	color: #FFF;
	text-shadow: 0 1px 1px #000;
	font-weight: bold;
	font-size:  11px;
	text-decoration: none;
	padding: 7px 10px 7px 20px;
	display: inline-block;
}

.moderacion_del_post ul li a {
	color: #FFF;
	text-shadow: 0 1px 1px #000;
	font-weight: bold;
	font-size:  11px;
	text-decoration: none;
	padding: 7px 10px 7px 20px;
	display: inline-block;
}

.moderacion_del_post ul li select {
	color: #FFF;
	text-shadow: 0 1px 1px #000;
	font-weight: bold;
	font-size:  11px;
	text-decoration: none;
	padding: 6px 10px 7px 20px;
	display: inline-block;
	border: none;
	-moz-appearance: none!important;
	max-width:120px;
}

.moderacion_del_post ul li option {
	background: #1b2332;
}


.moderacion_del_post ul li a:active,.moderacion_del_post ul li.push a {
	color: #181e28;
	text-shadow: 0 1px 0 #778398;
}


.moderacion_del_post ul li span {
	display: block;
}

.moderacion_del_post ul li {
	background: url('/images/btn_bg.gif') no-repeat top left;
}

.moderacion_del_post ul li span {
	background: url('/images/btn_border.gif') no-repeat top right;
}

.moderacion_del_post ul li.push {
	background: url('/images/btn_bg_push.gif') no-repeat top left;
}

.moderacion_del_post ul li.push a {
	background: url('/images/mod-icon.png') 0 7px no-repeat;
	
}

.moderacion_del_post ul li.push span {
	background: url('/images/btn_border_push.gif') no-repeat top right;
}

/* Icons */

.mod_container {
	width: 960px;
	margin: 0 auto;
}

.mod_container * {
	outline: none;
}

.mod_container ul li.historial {
	background: none;
}


.mod_container ul li.historial a {
	padding: 0;
}

.mod_container ul li.historial img {
	vertical-align: middle;
}

.moderacion_del_post ul li a.sticky_mod {background: url('/images/icons_mod.png') 0 -23px no-repeat;}
.moderacion_del_post ul li.push a.sticky_mod {background: url('/images/icons_mod.png') 0 7px no-repeat;}

.moderacion_del_post ul li a.lock_mod {background: url('/images/icons_mod.png') 0 -83px no-repeat;}
.moderacion_del_post ul li.push a.lock_mod {background: url('/images/icons_mod.png') 0 -53px no-repeat;}

.moderacion_del_post ul li a.adsense_mod {background: url('/images/icons_mod.png') 0 -141px no-repeat;color: red!important}
.moderacion_del_post ul li.push a.adsense_mod {background: url('/images/icons_mod.png') 0 -112px no-repeat;color: #00FF18!important;text-shadow:0 1px 1px #000000;}

.moderacion_del_post ul li a.edit_mod {background: url('/images/icons_mod.png') 0 -256px no-repeat;}
.moderacion_del_post ul li.push a.edit_mod {background: url('/images/icons_mod.png') 0 -226px no-repeat;}

.moderacion_del_post ul li a.trash_mod {background: url('/images/icons_mod.png') 0 -201px no-repeat;}
.moderacion_del_post ul li.push a.trash_mod {background: url('/images/icons_mod.png') 0 -171px no-repeat;}

.moderacion_del_post ul li select.categoria_mod {background: transparent url('/images/icons_mod.png') 0 -364px no-repeat;}
.moderacion_del_post ul li.push a.categoria_mod {background: url('/images/icons_mod.png') 0 -338px no-repeat;  }


.moderacion_del_post #descargas { color: }

.moderacion_del_post ul#mod-acciones-pushed  {
	margin: 2px 0 0 0;
	float: right;
	padding: 0;
}


.moderacion_del_post ul#mod-acciones-click  {
	margin: 2px 0 0 0;
	float: left;
	padding: 0;
}
/**/
.uSuspendido { color:red!important}
.especial1 .answerOptions { background: #cfeaff; }
.especial2 .answerOptions { background: #ffcbcb; }
	#mask  {
		background: #111;
		opacity: 0.6;
	}
	#mydialog #dialog {
		text-align: left;
		border: 3px solid #b5af9f;
		display:none;
		z-index:101;
	  -moz-box-shadow: #333 0px 0px 25px; 
	  -webkit-box-shadow: #333 0px 0px 25px;
	}

	#mydialog #cuerpo {
		background: #f4f1e9;
	}
	
	
	#mydialog #dialog #title {
		text-align: left;
		text-shadow: 0 1px 0 #003851;
		border-bottom: 1px solid #003A74;
		border-right: 0;
		border-left: 0;
		border-top:0;
  	color: #FFF;
 	  font-size: 14px;
 	  font-weight: bold;
  	padding: 8px;
 	  border: 1px solid #003a74;
	  background:#2e8af5 url('/images/btnRainbow.gif') top left repeat-x;
}
	}
	#modalBody label {
		display: block;
		font-weight: bold;
		margin-bottom: 5px;
	}
	
	#modalBody input {
		margin-bottom: 10px;
		border: 1px solid #c4c2b9;
		background: #FFF;
		width: 195px;
		padding:6px 4px;
		-moz-border-radius: 5px;
	}
	
	#modalBody input.checkbox {
		margin: none;
		border: none;
		background: #FFF;
		width: auto;
		padding: 0;
		-moz-border-radius: 0;
	}
	
	.registro #modalBody .footerReg {
		font-size:11px;
		letter-spacing: -1px;
		margin: 15px 0 5px 0;
	}

/* Autocomplete */
.ac_results {
	padding: 0px;
	border: 1px solid black;
	background-color: white;
	overflow: hidden;
	z-index: 99999;
}
.ac_results ul {
	width: 100%;
	list-style-position: outside;
	list-style: none;
	padding: 0;
	margin: 0;
}
.ac_results li {
	margin: 0px;
	padding: 2px 5px;
	cursor: default;
	display: block;
	/* 
	if width will be 100% horizontal scrollbar will apear 
	when scroll mode will be used
	*/
	/*width: 100%;*/
	font: menu;
	font-size: 12px;
	/* 
	it is very important, if line-height not setted or setted 
	in relative units scroll will be broken in firefox
	*/
	line-height: 16px;
	overflow: hidden;
}
.ac_loading {
	background: white url('/images/loading.gif') right center no-repeat;
}
.ac_odd {
	background-color: #eee;
}
.ac_over {
	background-color: #0A246A;
	color: white;
}
/* FIN - Autocomplete */


.kodak-yt {
	width: 640px;
	margin: 0 auto;
	text-align: center;
	overflow: hidden;
	border: 3px solid #f2b41b;
	background: #000;
	font-family: Helvetica,Arial;
	margin-top:30px;
	-moz-box-shadow: 0 0 15px #666;
	-webkit-box-shadow: 0 0 15px #666;
}

.kodak-banner a {
  display: block;
  text-align: right;
	color: #f2b41b!important;
	font-size: 14px;
	padding: 5px;
	text-decoration: none;
	background: url('/images/kodak_bg.gif') no-repeat 5px 2px;
}

.kodak-banner a:visited {
	color: #f2b41b!important;
}
.comunidades .kodak-yt {
	width: 600px;
} 

.notFound {
	background: url('/images/404_oso.gif') no-repeat right bottom!important;
}

.pag-vid {
	width:930px!important;
}

.pag-vid .before a,.pag-vid .next a{
	display:block!important;
}

/* AÑADIDO PERFIL EN VEZ DE A: P */
#perfil {
		padding-top:12px;
		position:relative;
	}
	#perfil .izquierda {
		width: 600px;
		float:left;
	}
	#perfil .derecha {
		width: 300px;
		float:left;
		margin-left:30px;
 
	}
  #perfil h1 {
    font-size:30px;
    font-weight:bold;
		margin:0;
		letter-spacing:-2px;
  }
  #perfil h1 span{
     color:#666;
     font-weight:normal;
  }
  #perfil h1 a {
    color:#000;
  }
	#perfil h3 {
		color:#666;
		font-size:14px;
		font-weight:normal;
		margin:10px 0 0 0;
	}
	#perfil .contenido {
		margin:10px 0 0 0;
		width: 100%;
	}
	#perfil .dataUser {
		padding: 8px;
		background:#f7f7f7;
		-moz-border-radius:5px;
		position:relative;
	}
	
	#perfil .dataUser img {
		float:left;
	}
	
	#perfil .dataUser ul.basicData {
		width:420px;
		font-size:13px;
		line-height:1.6em;
		margin-left:150px;
	}
	
	#perfil .activityData {
		margin-top:15px;
		background: #e8ffe9;
		font-family: Helvetica, Arial;
	}
	
	#perfil .activityData li {
		padding: 8px;
		float:left;
		text-align: right;
		width:67px;
		display: block;
		background: #E8FFE9;
	}
	#perfil .activityData li.rango{
		text-align:left;
		width:185px;
	}
	
	#perfil .activityData li.tRank{
		background:#ffffe8;
		float:right;
		width:100px;
	}
	
	#perfil .activityData li.tRank span{
		color:#972b0e;
	}
	
	
	#perfil .activityData li.comentarios{
		width:100px;
	}
	
	#perfil .activityData span {
		color:#6c9840;
		font-weight:bold;
		display:block;
		font-size:25px;
		padding:5px 0;
	}
	#perfil .activityData span a {
		color:#6c9840;
	}
    /*
    #perfil .activityData span a:hover, #perfil .activityData span a:active {
    	text-decoration: none;
        border-spacing: 2px;
        border-bottom: solid 1px #6C9840;
    }*/
 
	#perfil .activityData strong {
		font-size: 14px;
	}
	#perfil .activityData strong a {
		color:#000;
	}
	#perfil li.categoriaCom {
		border:0;
		padding:5px;
	}
	#perfil li a.titletema,#perfil .categoriaPost a,.misComunidades a {
		color:#004A95;
		font-weight:bold;
	}
	#perfil .photo_small {
		border: 1px solid #CCC;
	}
	#perfil .photo_small img{
		width: 77px;
		height: 77px;
	}
	#perfil .bloquearU {
		position:absolute;right:18px;	top:12px;background:#d5122d; -moz-border-radius: 3px; color:#FFF; display:block;padding:3px 5px;float:right;
	}
	
	#perfil .desbloquearU {
		position:absolute;right:18px;	top:12px;background:#209c4f; -moz-border-radius: 3px; color:#FFF; display:block;padding:3px 5px;float:right;
	}
	#perfil .avaPerfil {
		width: 130px;
		float: left;
		text-align:center;
	}
	#perfil .sendMsg {
		-moz-border-radius:5px;
		padding:5px;
		font-weight:bold;
		margin-left: 5px;
	}
	
	#perfil .seeMore {
		position:absolute;
		bottom: 5px;
		right: 5px;
		color: #004a95;
	}
	
	#perfil .moreData {
		margin-bottom: 25px;
	}
/* 2A */
#perfil h2 {
					color:#FF6600;
					font-size:14px;
					font-weight:bold;
					padding-bottom:5px;
					margin-bottom:5px;
					margin-top: 5px;
					border-bottom:1px solid #CCC;
				}
				
				#perfil hr {
					margin:2px 0!important;
				}
				#perfil .categoriaPost {
					position:relative;
				}
				
				
				#perfil .categoriaPost:hover {
					background-color: #EEE!important;
				}
				
				
				#perfil .categoriaPost span {
					position:absolute;
					right: 5px;
					top: 2px;
					color: #666;
				}
				.lastPostsData, .lastTopicsData, .misComunidades {
					position:relative;
					clear:both;
				}
				.rssP {
					display:block;
					position: absolute;
					top:0px;
					right: 5px;
				}
                
                .verTodos {
						background:#e8f6ff;
						-moz-border-radius: 5px;
						-webkit-border-radius: 5px;
						text-align: center;
					}
					
					.verTodos a {
						font-weight: bold;
						display:block;
						color:#164764;
						padding: 5px;
					}

/*ABM*/

/*CUENTA*/

	.box_cuenta #mensajes_div.ok {
		background:#C4E19B none repeat scroll 0 0;
		color:#333333;
		font-weight:bold;
		margin-bottom:10px;
		padding:10px;
		text-align: center;
	}

	.box_cuenta #mensajes_div.error {
		background:#FFFFCC none repeat scroll 0 0;
		color:#333333;
		font-weight:bold;
		margin-bottom:10px;
		padding:10px;
		text-align: center;
	}
    
/*ADM*/

	#admin_content #mensajes_div.ok {
		background:#C4E19B none repeat scroll 0 0;
		color:#333333;
		font-weight:bold;
		margin-bottom:10px;
		padding:10px;
		text-align: center;
	}

	#admin_content #mensajes_div.error {
		background:#FFFFCC none repeat scroll 0 0;
		color:#333333;
		font-weight:bold;
		margin-bottom:10px;
		padding:10px;
		text-align: center;
	}
    
/* EMOTICONOS */

	.emoticono {
    	width: 16px;
        height: 16px;
        background-image: url(/images/big2v5.gif);
    }
    .emoticono.sonrisa { background-position: 0 -287px; }
    .emoticono.guino { background-position: 0 -309px; }
    .emoticono.duda { background-position: 0 -331px; }
    .emoticono.lengua { background-position: 0 -353px; }
    .emoticono.alegre { background-position: 0 -375px; }
    .emoticono.triste { background-position: 0 -397px; }
    .emoticono.odio { background-position: 0 -419px; }
    .emoticono.llorando { background-position: 0 -441px; }
    .emoticono.endiablado { background-position: 0 -463px; }
    .emoticono.serio { background-position: 0 -485px; }
    .emoticono.duda2 { background-position: 0 -507px; }
    .emoticono.picaro { background-position: 0 -529px; }
    .emoticono.timido { background-position: 0 -551px; }
    .emoticono.sonrizota { background-position: 0 -573px; }
    .emoticono.increible { background-position: 0 -595px; }
    .emoticono.babas { background-position: 0 -617px; }

/*PMYR*/

#pmyr_div {
-x-system-font:none;
background-color:#FFFFFF;
border:1px solid #333333;
font-family:arial;
font-size:15px;
font-size-adjust:none;
font-stretch:normal;
font-style:normal;
font-variant:normal;
font-weight:normal;
height:100%;
left:0;
line-height:normal;
padding-left:20px;
padding-right:20px;
position:fixed;
text-align:center;
top:0;
width:100%;
z-index:100;
}