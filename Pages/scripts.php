<?php
header('Content-type: text/javascript');
include('config.php');
include('functions.php');
?>

function nuevoAjax()
{ 
	var xmlhttp=false; 
	try 
	{ 
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
}

var ajax = nuevoAjax();
/* AJAX ^*/

<? if(isAllowedTo('showpanel')) { ?>
/*ADMIN*/

function admin_notes(action, id) {
	if(action != 'edit' && action != 'delete' && action != 'new' && action != 'edit2') { return false; }
    ajax.open("POST", "/ajax/admin-notes.php?rnd=" + parseInt(Math.random()*99999), true);
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	ajax.send("sa=" + action + "&id=" + encodeURIComponent(id));
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	$('#mensajes_div').slideUp('normal');
        	if(ajax.responseText.substring(0, 1) == '0') { alert('Error: ' + ajax.responseText.substring(1)); return false; }
            if(action == 'new') {
            	var spl = ajax.responseText.split(':');
            	var block = document.createElement('blockquote');
                block.id = 'block_' + spl[0];
                block.style.display = 'none';
                block.innerHTML = '<div class="cita"><div class="box_rss"><img style="cursor:pointer;" src="/images/borrar.png" onclick="admin_notes(\'delete\', ' + spl[0] + ');" alt="Borrar" title="Borrar" /> <img style="cursor:pointer;" src="/images/editar.png" onclick="if(confirm(\'&iquest;Seguro que quieres borrar esta nota?\')){admin_notes(\'edit\', ' + spl[0] + ');}" alt="Editar" title="Editar" /></div></div><div class="citacuerpo" id="cita_cuerpo_' + spl[0] + '"><p>' + spl[1] + '</p></div>';
               document.getElementById('admin_content').insertBefore(block, document.getElementById('block_' + first_node));
               if(first_node == 'nn') { document.getElementById('block_nn').style.display = 'none'; }
               document.getElementById('admin_content').insertBefore(document.createElement('br'), document.getElementById('block_' + first_node));
               first_node = spl[0];
               $('#block_' + spl[0]).slideDown('normal');
           } else if(action == 'delete') {
				$('#block_' + id).slideUp('fast');
           } else if(action == 'edit') {
        		document.getElementById('cita_cuerpo_' + id).innerHTML = '<textarea name="message" class="agregar cuerpo" style="height:200px;" id="edit_textarea_' + id + '">' + ajax.responseText + '</textarea><br /><input type="button" class="button" style="font-size:11px;" onclick="admin_notes(\'edit2\', \'' + id + '\' + \':\' + document.getElementById(\'edit_textarea_' + id + '\').value);" value="Editar nota" />';
           } else if(action == 'edit2') {
           		var spl = id.split(':');
           		document.getElementById('cita_cuerpo_' + spl[0]).innerHTML = '<p>' + ajax.responseText + '</p>';
           }
        } else {
        	$('#mensajes_div').slideDown('normal');
        }
	};
}

var ra;
function admin_rank(form) {
	if(!ra || (ra != 'check' && ra != 'change')) { return false; }
    if(!form.st[0].checked && !form.st[1].checked || form.user.value == '') { return false; }
    if(ra == 'change' && form.rank.selectedIndex == 0) { return false; }
    if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideUp('normal'); }
    var st = (form.st[0].checked ? 'id' : 'nick');
    var fr = (ra == 'change' ? form.rank.options[form.rank.selectedIndex].value : '');
    ajax.open("GET", "/ajax/admin-rank.php?rnd=" + parseInt(Math.random()*99999) + "&sa=" + ra + "&user=" + form.user.value + "&st=" + st + "&rank=" + fr, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText.substring(0, 1) == '0') {
            	document.getElementById('mensajes_div').className = 'error';
                document.getElementById('mensajes_div').innerHTML = ajax.responseText.substring(1);
                $('#mensajes_div').slideDown('normal');
                return false;
            }
            document.getElementById('mensajes_div').className = 'ok';
            document.getElementById('mensajes_div').innerHTML = (ra == 'check' ? 'Usuario v&aacute;lido' : 'Rango actualizado');
            $('#mensajes_div').slideDown('normal');
            if(ra == 'check') {
            	var spl = ajax.responseText.split('SEP');
            	if(document.getElementById('form_select').style.display = 'block') { $('#form_select').slideUp('normal'); }
                document.getElementById('form_select').innerHTML = spl[1];
                $('#form_select').slideDown('normal');
                document.getElementById('user_data').style.display = 'block';
                document.getElementById('user_data').innerHTML = spl[0];
            }
            return false;
        }
	};
	ajax.send(null);
}

function admin_ban(ac, form) {
	if(!ra || (ra != 'check' && ra != 'ban') || !ac || (ac != '1' && ac != '2')) { return false; }
    	if(!form.st[0].checked && !form.st[1].checked || form.user.value == '') { alert('Selecciona un usuario'); return false; }
    	if(ra == 'ban'  && ac != '2' && form.reason.value == '') { alert('Pon una razon'); return false; }
    	if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideUp('normal'); }
   	var st = (form.st[0].checked ? 'id' : 'nick');
    	if(ra == 'check' || ac == '2') {
    		var end = 'permanent';
    	} else {
    		var end = (!form.permanent.checked ? form.eday.value + '-' + form.emonth.value + '-' + form.eyear.value + '-' + form.ehour.value + '-' + form.eminutes.value : 'permanent');
    	}
	var ballq = (ra == 'ban' && form.all.checked ? '1' : '');
	var block = (ra == 'ban' && form.lock.checked ? '1' : '');
    ajax.open("POST", "/ajax/admin-ban.php?rnd=" + parseInt(Math.random()*99999), true);
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    /*ajax.setRequestHeader("Connection", "close");*/
	ajax.send("sa=" + ra + "&user=" + form.user.value + "&st=" + st + "&ac=" + ac + "&end=" + end + "&ban=" + form.ban.value + "&reason=" + (ra == 'check' || ac == '2' ? '1' : form.reason.value) + "&all=" + ballq + "&lock=" + block);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText.substring(0, 1) == '0') {
            	document.getElementById('mensajes_div').className = 'error';
                document.getElementById('mensajes_div').innerHTML = ajax.responseText.substring(1);
                $('#mensajes_div').slideDown('normal');
                return false;
            }
            document.getElementById('mensajes_div').className = 'ok';
            document.getElementById('mensajes_div').innerHTML = (ra == 'check' ? 'Usuario v&aacute;lido' : 'Usuario ' + (ac == '1' ? 'baneado' : 'desbaneado'));
            $('#mensajes_div').slideDown('normal');
            if(ra == 'check') {
            	var spl = ajax.responseText.split('SEP');
            	if(document.getElementById('form_select').style.display = 'block') { $('#form_select').slideUp('normal'); }
                document.getElementById('form_select').innerHTML = spl[1];
                $('#form_select').slideDown('normal');
                document.getElementById('user_data').style.display = 'block';
                document.getElementById('user_data').innerHTML = spl[0];
            }
            return false;
        }
	};
}

function admin_complaints_action(sa, post) {
	if(!confirm('\xBFSeguro que quieres ' + (sa == 'accept' ? 'aceptar' : 'rechazar') + ' esta denuncia?')) { return false; }
	if(sa != 'accept' && sa != 'reject') { return false; }
    ajax.open("GET", "/ajax/admin-complaints.php?rnd=" + parseInt(Math.random()*99999) + "&sa=" + sa + "&id=" + post, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText.substring(0, 1) == '0') { alert(ajax.responseText.substring(1)); return false; }
            $('#post_d_' + post).slideUp('fast');
            $('#post_d_' + post).html('La denuncia ha sido ' + (sa == 'accept' ? 'aceptada' : 'rechazada'));
            $('#post_d_' + post).slideDown('slow');
        }
	};
	ajax.send(null);
}

function admin_complaints_show(link, post, n) {
	if(n == 'all') {
    	if(link.href.substring(link.href.length-2) == '#s') {
        	$('.pc' + post).slideDown('normal');
            $('.link' + post).html('Ver 5 menos');
            $('.link' + post).attr('href', '#s');
        } else {
        	$('.pc' + post).slideUp('normal');
            $('.link' + post).html('Ver 5 m&aacute;s');
            $('.link' + post).attr('href', '#h');
        }
    	link.innerHTML = (link.href.substring(link.href.length-2) == '#s' ? 'Ocultar todos' : 'Ver todos');
        link.href = (link.href.substring(link.href.length-2) == '#s' ? '#h' : '#s');
    } else {
    	link.innerHTML = (link.href.substring(link.href.length-2) == '#s' ? 'Ver 5 menos' : 'Ver 5 m&aacute;s');
        link.href = (link.href.substring(link.href.length-2) == '#s' ? '#h' : '#s');
    	$('.pc' + post + '.nl' + n).slideToggle('normal');
    }
}

function admin_delete_complaint(post, c) {
    ajax.open("GET", "/ajax/admin-complaints.php?rnd=" + parseInt(Math.random()*99999) + "&sa=delete&id=" + c + "&post=" + post, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText.substring(0, 1) == '0') { alert(ajax.responseText.substring(1)); return false; }
            post_c_n[post] -= 1;
            if(post_c_n[post] == 0) {
            	$('#post_d_' + post).slideUp('fast');
            } else {
            	$('.cid' + c).slideUp('fast');
            }
        }
	};
	ajax.send(null);
}

var currentptime = <?=time();?>;
setInterval('currentptime++', 1000);
function ban_user(id, action, step) {
	if(action != 1 && action != 2) { return false; }
	if(action == 2 && !step) { step = 1; }
	if(!step) {
		mydialog.show();
		mydialog.title('Banear usuario');
		mydialog.body('Introduce la duraci&oacute;n del baneo:<br />Meses: <input type="text" id="ban_months" size="2" /> D&iacute;as:<input type="text" id="ban_days" size="2" /> Horas: <input type="text" id="ban_hours" size="2" /><br />Introduce la raz&oacute;n del baneo:<br /><input type="text" id="ban_reason" maxlength="50" />');
		mydialog.buttons(true, true, 'SI', 'ban_user(' + id + ', 1, 1)', true, false, true, 'NO', 'close', true, true);
		mydialog.center();
		return;
	} else if(step == 1) {
		if(action == 1) {
			var m,d,h,r;
			m = document.getElementById('ban_months').value;
			d = document.getElementById('ban_days').value;
			h = document.getElementById('ban_hours').value;
			r = document.getElementById('ban_reason').value;
		}
		mydialog.show();
		mydialog.title((action == 1 ? 'Banear' : 'Desbanear') + ' usuario');
		mydialog.body('&iquest;Seguro que quieres ' + (action == 1 ? 'banear' : 'desbanear') + ' a este usuario?<input type="hidden" id="ban_months" value="' + m + '" /><input type="hidden" id="ban_days" value="' + d + '" /><input type="hidden" id="ban_hours" value="' + h + '" /><input type="hidden" id="ban_reason" value="' + r + '" />');
		mydialog.buttons(true, true, 'SI', 'ban_user(' + id + ', ' + action + ', 2)', true, false, true, 'NO', 'close', true, true);
		mydialog.center();
		return;
	} else {
		if(action == 1) {
			var m,d,h,end,reason;
			m = document.getElementById('ban_months').value;
			d = document.getElementById('ban_days').value;
			h = document.getElementById('ban_hours').value;
			reason = document.getElementById('ban_reason').value;
			m = (m == '' || m == null ? 0 : parseInt(m));
			d = (d == '' || d == null ? 0 : parseInt(d));
			h = (h == '' || h == null ? 0 : parseInt(h));
			end = currentptime+h*3600+d*86400+m*2592000;
		} else {
			var end = 'permanent';
			var reason = '1';
		}
		ajax.open("POST", "/ajax/admin-ban.php?rnd=" + parseInt(Math.random()*99999), true);
    		ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajax.send('sa=ban&user=' + id + '&st=id&ac=' + action + '&end=' + end + '&reason=' + encodeURIComponent(reason));
		ajax.onreadystatechange = function() {
			if(ajax.readyState == 4) {
            			mydialog.procesando_fin();
        			if(ajax.responseText.substring(0, 1) == '1') {
                			mydialog.alert((action == 1 ? 'Banear' : 'Desbanear') + ' usuario', 'El usuario ha sido ' + (action == 1 ? 'baneado' : 'desbaneado'));
					document.getElementById('ban_user_' + action).style.display = 'none';
					document.getElementById('ban_user_' + (action == 1 ? '2' : '1')).style.display = 'block';
                		} else {
                			mydialog.alert((action == 1 ? 'Banear' : 'Desbanear') + ' usuario', 'Ha ocurrido un error: ' + ajax.responseText.substring(1));
                		}	
        		} else {
        			mydialog.procesando_inicio();
        		}
		};
		
	}
}
<? } ?>

/*POST*/

function borrar_post(id, autor, aceptar){
	if(!aceptar){
			mydialog.show();
			mydialog.title('Borrar Post');
			mydialog.body('&iquest;Seguro que deseas borrar este post?');
			mydialog.buttons(true, true, 'SI', 'borrar_post(' + id + ', ' + (autor ? 'true' : 'false') + ', 1)', true, false, true, 'NO', 'close', true, true);
			mydialog.center();
			return;
	}else if(aceptar==1){
			mydialog.show();
			mydialog.title('Borrar Post');
			mydialog.body('Te pregunto de nuevo...<br />&iquest;Seguro que deseas borrar este post?');
			mydialog.buttons(true, true, 'SI', 'borrar_post(' + id + ', ' + (autor ? 'true' : 'false') + ', 2)', true, false, true, 'NO', 'close', true, true);
			mydialog.center();
			return;
<?php
if(!isAllowedTo('deleteposts')) {
	echo '}';
} elseif(isAllowedTo('deleteposts')) {
	echo '} else if(aceptar==2 && !autor){
		  	mydialog.show();
		  	mydialog.title(\'Borrar Post\');
		  	mydialog.body(\'Introduce una raz&oacute;n:<br /><input size="30" maxlength="30" id="borrar_post_razon_input" />\');
		  	mydialog.buttons(true, true, \'SI\', \'borrar_post(\' + id + \', document.getElementById(\\\'borrar_post_razon_input\\\').value, 2)\', true, false, true, \'NO\', \'close\', true, true);
		  	mydialog.center();
			document.getElementById(\'borrar_post_razon_input\').focus();
		  	return;
	      }';
}
?>
	mydialog.procesando_inicio('Eliminando...', 'Borrar Post');
    ajax.open("GET", "/ajax/action-post.php?rnd=" + parseInt(Math.random()*99999) + "&sa=delete&id=" + id + "&r=" + autor, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	mydialog.procesando_fin();
        	if(ajax.responseText == 1) {
            	mydialog.alert('Post borrado', 'El post ha sido borrado correctamente', true);
            } else {
            	mydialog.alert('Error', ajax.responseText);
            }
        }
	};
	ajax.send(null);
}

function fijar_post(id, t, aceptar){
	if(!aceptar){
			mydialog.show();
			mydialog.title(t);
			mydialog.body('&iquest;' + (t.charAt(0).toLowerCase() == 'd' ? 'Desfijar' : 'Fijar') + ' este post?');
			mydialog.buttons(true, true, 'SI', 'fijar_post(' + id + ', \'' + t + '\', 1)', true, false, true, 'NO', 'close', true, true);
			mydialog.center();
			return;
    }
	mydialog.procesando_inicio('Eliminando...', t);
    ajax.open("GET", "/ajax/action-post.php?rnd=" + parseInt(Math.random()*99999) + "&sa=stick&id=" + id + "&ft=" + (t.charAt(0).toLowerCase() == 'd' ? '2' : '1'), true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	mydialog.procesando_fin();
        	if(ajax.responseText == 1) {
            	var fod = (t.charAt(0).toLowerCase() == 'f' ? 'fijado' : 'desfijado');
            	mydialog.alert('Post ' + fod, 'El post ha sido ' + fod + ' correctamente');
            } else {
            	mydialog.alert('Error', ajax.responseText);
            }
        }
	};
	ajax.send(null);
}

/*LOGIN*/

function open_login_box() {
	document.getElementById('user_options').className = (document.getElementById('login_box').style.display == 'block' ? 'user_options anonymous' : 'user_options anonymous here');
	if(document.getElementById('login_box').style.display == 'block') { $('#login_box').fadeOut('fast'); } else { $('#login_box').fadeIn('fast'); }
}

function login_ajax() {
	var nick = document.getElementById('nickname').value;
    var pass = document.getElementById('password').value;
    if(nick == '' || nick == null || pass == '' || pass == null) {
    	document.getElementById('login_error').style.display = 'block';
        document.getElementById('login_error').innerHTML = 'Introduce un nombre y una contrase&ntilde;a';
       return;
    }
    ajax.open("GET", "/ajax/login.php?rnd=" + parseInt(Math.random()*99999) + "&nick=" + nick + "&pass=" + pass + "&rememberme=" +(document.getElementById('rememberme').checked ? '1' : '0'), true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	document.getElementById('login_loading').style.display = 'none';
			if(ajax.responseText == 1) {
            	document.location.reload();
            } else {
            	document.getElementById('login_error').style.display = 'block';
                document.getElementById('login_error').innerHTML = ajax.responseText;
            }
		} else {
        	document.getElementById('login_loading').style.display = 'block';
        }
	};
	ajax.send(null);
}

/* POST */

function vote_post(num, id) {
	if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideUp('normal'); }
	if((num-1) == 'NaN' || num < 1 || num > 10) {
		document.getElementById('mensajes_div').innerHTML = '&iexcl;&iquest;Cuanto quieres puntuar?!';
        document.getElementById('mensajes_div').className = 'mensajes error';
        document.getElementById('dar_puntos').style.display = 'none';
		$('#mensajes_div').slideDown('normal');
  	  	return;
	}
    ajax.open("GET", "/ajax/vote.php?rnd=" + parseInt(Math.random()*99999) + "&p=" + num + "&id=" + id, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	document.getElementById('mensajes_div').innerHTML = ajax.responseText.substring(4);
        	document.getElementById('mensajes_div').className = 'mensajes ' + (ajax.responseText.substring(0, 4) == ' OK:' ? 'ok' : 'error');
            document.getElementById('dar_puntos').style.display = 'none';
            $('#mensajes_div').slideDown('normal');
            if(ajax.responseText.substring(0, 4) == ' OK:') { document.getElementById('post_points_span').innerHTML = (parseInt(document.getElementById('post_points_span').innerHTML)+parseInt(num)); }
        }
	};
	ajax.send(null);
}

		/* COMENTARIOS */
var dlci = 1;

function add_comment(id, message, group) {
	if(message == '' || message == null) { return false; }
    var gurl = (group ? 'group-' : false);
    ajax.open("POST", "/ajax/" + gurl + "add-comment.php?rnd=" + parseInt(Math.random()*99999), true);
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	ajax.send("message=" + encodeURIComponent(message) + "&id=" + id + (!gurl ? '' : "&group=" + group));
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == '1') {
            	document.getElementById('body_comm').value = 'Escribir un comentario';
                document.getElementById('comm_num').innerHTML = (parseInt(document.getElementById('comm_num').innerHTML)+1);
                comm_tcom++;
                if(Math.ceil((comm_tcom+1)/100) > comm_totalpages && Math.ceil((comm_tcom+1)/100) != 1) {
                	document.getElementById('paginador1').style.display = 'block';
                	document.getElementById('paginador2').style.display = 'block';
                	comm_totalpages++;
                    var eli1, ea1, etext1, eli2, ea2, etext2;
                    eli1 = document.createElement('li');
                    eli1.className = 'numbers';
                    eli2 = document.createElement('li');
                    eli2.className = 'numbers';
                    ea1 = document.createElement('a');
                    ea1.id = 'pc_1_' + comm_totalpages;
                    ea1.href = "#";
                    ea1.onclick = "comments_goto(" + comm_currentpage + ");return false;";
                    ea2 = document.createElement('a');
                    ea2.id = 'pc_2_' + comm_totalpages;
                    ea2.href = "#";
                    ea2.onclick = "comments_goto(" + comm_currentpage + ");return false;";
                    etext1 = document.createTextNode(comm_totalpages);
                    etext2 = document.createTextNode(comm_totalpages);
                    
                    document.getElementById('comm_ul_1').appendChild(eli1);
                    eli1.appendChild(ea1);
                    ea1.appendChild(etext1);
                    document.getElementById('comm_ul_2').appendChild(eli2);
                    eli2.appendChild(ea2);
                    ea2.appendChild(etext2);
           		} else {
                	if(document.getElementById('div_lastcomment')) { document.getElementById('div_lastcomment').id = 'div_lastcomment' + dlci++; }
                	ajax.open("GET", "/ajax/" + gurl + "post-comments.php?rnd=" + parseInt(Math.random()*99999) + "&post_id=" + post_id + "&post_private=" + post_private + "&author=" + post_author + "&cpage=1&i=" + (comm_tcom-1) + "&if=1&lc=1", true);
               		ajax.onreadystatechange = function() {
    					if(ajax.readyState == 4) {
                        	if(comm_tcom > 1) {
           	 					document.getElementById('comentarios').innerHTML = document.getElementById('comentarios').innerHTML + ajax.responseText;
                            } else {
                            	document.getElementById('comentarios').innerHTML = ajax.responseText;
                            }
                            $('#div_lastcomment').slideDown('normal')
                   		}
                	}
                	ajax.send(null);
                }
                if(comm_currentpage != comm_totalpages) { comments_goto(comm_totalpages); }
            } else {
            	alert('Ha ocurrido un error inesperado, reintentalo m\xe1s tarde\n' + ajax.responseText);
            }
        }
	};
}

function comments_goto(page) {
	if(page < 1 || page > comm_totalpages) { return false; }
    	ajax.open("GET", "/ajax/post-comments.php?rnd=" + parseInt(Math.random()*99999) + "&post_id=" + post_id + "&post_private=" + post_private + "&author=" + post_author + "&cpage=" + page + "&if=1&i=" + ((parseInt(page)-1)*100) + "&dh=" + dh.substring(1), true);
	ajax.onreadystatechange = function() {
    		if(ajax.readyState == 4) {
			if(ajax.responseText != 0 && ajax.responseText != '0') {
				if(ajax.responseText.substring(0, 1) != '0') {
					page = ajax.responseText.substring(0, 1);
				}
           	 		document.getElementById('pc_1_' + comm_currentpage).className = '';
            			document.getElementById('pc_2_' + comm_currentpage).className = '';
            			document.getElementById('pc_1_' + page).className = 'here';
            			document.getElementById('pc_2_' + page).className = 'here';
            			document.getElementById('comm_b_1').className = (page > 1 ? '' : 'desactivado');
            			document.getElementById('comm_b_2').className = (page > 1 ? '' : 'desactivado');
            			document.getElementById('comm_n_1').className = (page < comm_totalpages ? '' : 'desactivado');
            			document.getElementById('comm_n_2').className = (page < comm_totalpages ? '' : 'desactivado');
            			document.getElementById('comentarios').innerHTML = ajax.responseText.substring(1);
                		comm_currentpage = page;
				if(dh != '0') { window.location.hash = dh; dh = '0'; }
				
        		}
        	}
	};
	ajax.send(null);
}

function update_last_comments(cat) {
	ajax.open("GET", "/ajax/lastcomments.php?rnd=" + parseInt(Math.random()*99999) + "&i=1&gc=" + cat, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(document.getElementById('ult_comm_loading')) { document.getElementById('ult_comm_loading').style.display = 'none'; }
        	$('#ult_comm').slideUp('slow');
            setTimeout("document.getElementById('ult_comm').innerHTML = ajax.responseText;$('#ult_comm').slideDown('slow');", 1000);
        } else {
        	if(document.getElementById('ult_comm_loading')) { document.getElementById('ult_comm_loading').style.display = 'block'; }
        }
	};
	ajax.send(null);
}

function cite_comment(id, author, group) {
	var bc = document.getElementById('body_comm');
    	if(bc.value == 'Escribir un comentario') { bc.value = ''; }
    	bc.focus();
	ajax.open("GET", "/ajax/" + (group === true ? 'group-' : '') + "comment.php?rnd=" + parseInt(Math.random()*99999) + "&id=" + id, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
			if(ajax.responseText != null && ajax.status == 200) {
        			bc.value = bc.value + (bc.value != '' ? "\n" : "") + "[quote=" + author + "]" + ajax.responseText + "[/quote]\n";
        		} else {
        			alert('Error al citar');
			}
		}
	};
	ajax.send(null);
}

function delete_comment(id) {
	ajax.open("GET", "/ajax/delete-comment.php?rnd=" + parseInt(Math.random()*99999) + "&id=" + id, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == '1') {
            	$('.cmnt' + id).slideUp('normal');
                document.getElementById('comm_num').innerHTML = (parseInt(document.getElementById('comm_num').innerHTML)-1);
            } else {
            	alert(ajax.responseText);
            }
        }
	};
	ajax.send(null);
}

/*NUEVO POST*/

function np_previsualizar(form, vp){
	if(form.message.value.length>63206){
		alert('El post es demasiado largo. No debe exceder los 65000 caracteres.');
		return false;
	}
 
	if(form.category.selectedIndex == 0){
		alert('Falta la categoria');
		return false;
	}
 
	/*if(cuerpo.indexOf('imageshack.us')>0){
		alert('No se permiten imagenes de IMAGESHACK.');
		return false;
	}*/
 
	if(form.message.value == ''){
		alert('Escribe el post.');
		return false;
	}
 
	if(form.title.value == ''){
		alert('Escribe un t\xedtulo.');
		return false;
	}
 
	if(form.tags.value == ''){
		alert('Escribe 4 o m\xe1s tags');
		return false;
	}
 	
    form.tags.value = form.tags.value.replace(',,',',');
    if(form.tags.value.charAt(0) == ',') { form.tags.value = form.tags.value.substring(1); }
    if(form.tags.value.charAt((form.tags.value.length-1)) == ',') { form.tags.value = form.tags.value.substring(0, (form.tags.value.length-1)); }
    var ttags = form.tags.value.split(",");
 
	if(ttags.length < 4){
        alert('Tienes que ingresar al menos 4 tags separados por coma.\nLos tags son una lista de palabras separadas por comas, que describen el contenido.\nEjemplo: gol, ingleses, Mundial 86, futbol, Maradona, Argentina');
        return false;
    }
    
    if(vp === false) { document.npf.submit(); return true; }
    
    ajax.open("POST", "/ajax/preview.php?rnd=" + parseInt(Math.random()*99999), true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	document.getElementById('preview').innerHTML = ajax.responseText;
            document.getElementById('preview').style.display = 'inline';
            scrollUp();
        }
	};         
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	ajax.send("title=" + form.title.value + "&message=" + encodeURIComponent(form.message.value));

}

/*FAVORITOS*/

function add_to_favorites(postid) {
	if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideToggle('normal'); }
	ajax.open("GET", "/ajax/addfavorites.php?rnd=" + parseInt(Math.random()*99999) + "&id=" + postid, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(parseInt(ajax.responseText) == 1) {
            	document.getElementById('mensajes_div').innerHTML = '&iexcl;Agregado a favoritos!';
                document.getElementById('mensajes_div').className = 'mensajes ok';
                document.getElementById('post_favorites_span').innerHTML = (parseInt(document.getElementById('post_favorites_span').innerHTML)+1);
            } else {
            	document.getElementById('mensajes_div').innerHTML = ajax.responseText;
                document.getElementById('mensajes_div').className = 'mensajes error';
            }
            $('#mensajes_div').slideToggle('normal');
        }
	};
	ajax.send(null);
}

function filtro_favs(f, o, b) {
	if(f != 'categoria' && f != 'orden') { return false; }
	ajax.open("GET", "/ajax/favorites.php?rnd=" + parseInt(Math.random()*99999) + "&i=1&shortby=" + (f == 'orden' ? o : orden_s) + "&cat=" + (f == 'categoria' ? o : categoria_s), true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	document.getElementById('resultados').innerHTML = ajax.responseText;
            if(f == 'categoria') {
            	categoria_s = o;
            } else {
                document.getElementById('orden_e_' + orden_s).className = '';
                orden_s = o;
                document.getElementById('orden_e_' + orden_s).className = 'here';
            }
        }
	};
	ajax.send(null);
    return;
}

function action_favs(id, post, time, action) {
	if(action != 1 && action != 2) { return false; }
    ajax.open("GET", "/ajax/action-favorites.php?rnd=" + parseInt(Math.random()*99999) + "&id=" + id + "&post=" + post + "&time=" + time + "&action=" + action, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == 1) {
            	document.getElementById('action_img_' + id).src = (action == 1 ? '/images/reactivar.png' : '/images/borrar.png');
            	document.getElementById('action_img_' + id).alt = (action == 1 ? 'Reactivar' : 'Borrar');
            	document.getElementById('action_img_' + id).title = (action == 1 ? 'Reactivar favorito' : 'Borrar favorito');
                document.getElementById('change_status_' + id + '_1').style.display = (action == 1 ? 'none' : 'block');
                document.getElementById('change_status_' + id + '_2').style.display = (action == 2 ? 'none' : 'block');
                return false;
            } else {
            	alert(ajax.responseText);
            }
        }
	};
	ajax.send(null);
    return;
}

/*REGISTRO*/

function reg_validate_data(form) {
    ajax.open("GET", "/ajax/nick-email-check.php?rnd=" + parseInt(Math.random()*99999) + "&nick=" + form.nick.value + "&email=" + form.email.value, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText != '1') { alert(ajax.responseText); return false; }
        }
	};
	ajax.send(null);
    if(form.name.value.length < 6 || form.name.value.length > 32) { alert('El nombre y los apellidos deben tener entre los dos de 6 a 32 caracteres'); form.name.value = ''; form.name.focus(); return false; }
    if(!/^[a-zA-Z0-9]+$/.test(form.name.value.replace(' ', ''))) { alert('El nombre y los apellidos solo pueden contener caracteres alfanumericos'); form.name.value = ''; form.name.focus(); return false; }
    if(form.nick.value.length < 6 || form.nick.value.length > 35) { alert('El nick debe tener de 6 a 35 caracteres'); form.nick.value = ''; form.nick.focus(); return false; }
    if(!/^[a-zA-Z0-9]+$/.test(form.nick.value)) { alert('El nick solo puede contener caracteres alfanumericos'); form.nick.value = ''; form.nick.focus(); return false; }
    if(form.pass.value.length < 6 || form.pass.value.length > 32) { alert('La contrase\xf1a debe tener de 6 a 32 caracteres'); form.pass.value = ''; form.pass.focus(); return false; }
    if(!/^[a-zA-Z0-9]+$/.test(form.pass.value)) { alert('La contrase\xf1a solo puede contener caracteres alfanumericos'); form.pass.value = ''; form.pass.focus(); return false; }
    if(form.pass.value != form.pass2.value) { form.pass2.value = ''; form.pass2.focus(); alert('Las contrase\xf1as no coinciden'); return false; }
    if(form.email.value.length > 35) { alert('El EMail no puede tener m\xe1s de 35 caracteres'); form.email.value = ''; form.email.focus(); return false; }
    if(!/^[a-z0-9_\.\-]{1,64}@[a-z0-9_\.\-]{1,255}\.([a-z]{2,3})+$/.test(form.email.value)) { form.email.value = ''; form.email.focus(); alert('El EMail no es v\xe1lido'); return false; }
    if(form.avatar.value.length == 0 || form.avatar.value.length > 255) { alert('Debes indicar un avatar que no sobrepase los 255 caracteres'); form.avatar.value = ''; form.avatar.focus(); return false; }
    if(form.country.options[form.country.selectedIndex].value == -1 || form.country.options[form.country.selectedIndex].value == 28 || form.country.options[form.country.selectedIndex].value > 262 || form.country.options[form.country.selectedIndex].value < 0) { alert('Selecciona tu pa\xeds'); form.country.selectedIndex = 0; form.country.focus(); return false; }
    if(form.city.value.length < 1 || form.city.value.length > 32) { alert('La ciudad no puede pasar los 32 caracteres'); form.city.value = ''; form.city.focus(); return false; }
   	var day, month, year;
    day = parseInt(form.day.value);
    month = parseInt(form.month.value);
    year = parseInt(form.year.value);
    if(!/^[0-9]+$/.test(day) || !/^[0-9]+$/.test(month) || !/^[0-9]+$/.test(year) || day.length > 2 || month.length > 2 || year.length > 4 || day > 31 || month > 12 || year > <?=date('Y');?>) { form.day.value = ''; form.month.value = ''; form.year.value = ''; form.day.focus(); alert('Introduce una fecha de nacimiento v\xe1lida'); return false; }
    if((year-<?=$config['min_age'];?>) > <?=(date('Y')-$config['min_age']);?>) { alert('Debes tener al menos <?=$config['min_age'];?> a\xf1os'); return false; }
    if(!form.terms.checked) { alert('Debes aceptar los terminos y condiciones'); return false; }
}

function reg_idif() {
	document.reg.name.focus();
	var servdate, userdate, dif;
	servdate = new Date(<?=date('Y, m, d, H');?>);
	userdate = new Date();
	if(servdate.getDate() == userdate.getDate()) {
		dif = userdate.getHours()-servdate.getHours();
	} else if(servdate.getDate() > userdate.getDate()) {
		dif = userdate.getHours()-(24+servdate.getHours());
	} else {
		dif = (24+userdate.getHours())-servdate.getHours();
	}
	dif = dif.toString();
	dif = (dif.substring(0, 1) == '-' ? dif : '+' + dif);
	document.getElementById('difh').value = dif;
	reg_checkdif(dif);
	setTimeout('document.reg.name.focus();', 200);
}
<?php $date = date('Y, m, d, H, i, s'); ?>
var startdate = '<?=$date;?>';
var currentdate = startdate;
<? if($_GET['p'] == 'register') { ?>
setInterval('reg_time();', 1000);
function reg_time() {
	var o = currentdate.split(', ');
	for(i=0;i<=5;i++) {
		if(i == 5 && (o[5] == '08' || o[5] == '09')) {
			o[5] = (o[5] == '08' ? 8 : 9);
			break;
		}
		o[i] = parseInt(o[i]);	
	}
	o[5]++;
	if(o[5] >= 60) {
		o[5] = o[5]-60;
		o[4]++;
	}
	if(o[4] >= 60) {
		o[4] = o[4]-60;
		o[3]++;
	}
	if(o[3] >= 24) {
		o[3] = o[3]-24;
		o[2]++;
	}
	var bisiesto = ((o[0]%4 == 0) && ((o[0]%100 != 0) || (o[0]%400 == 0)) ? true : false);
	var day;
	if(o[2] == 2) {
		if(bisiesto === true) {
			day = 29;
		} else {
			day = 28;
		}
	} else if(o[2]%2 == 0) {
		day = 30;
	} else {
		day = 31;
	}
	if(o[2] > day) {
		o[2] = o[2]-day;
		o[1]++;
	}
	if(o[1] > 12) {
		o[1] = o[1]-12;
		o[0]++;
	}
	for(i=0;i<=5;i++) {
		o[i] = o[i].toString();
		if(o[i].length == 1) {
			o[i] = '0' + o[i];
		}
	}
	document.getElementById('difw').innerHTML = o[2] + '/' + o[1] + '/' + o[0] + ' ' + o[3] + ':' + o[4] + ':' + o[5];
	currentdate = o[0] + ', ' + o[1] + ', ' + o[2] + ', ' + o[3] + ', ' + o[4] + ', ' + o[5]
}
<? } ?>
function reg_checkdif(dif) {
	if((dif.substring(0, 1) != '+' && dif.substring(0, 1) != '-') || isNaN(dif.substring(1)) || dif.substring(1) == '' || dif.substring(1) == null || parseInt(dif) > 12 || parseInt(dif) < -12) { return false; }
	dif = parseInt(dif);
	var date = new Date();
	var month, day, hour, minutes, seconds;
	hour = date.getHours()+dif;
	if(hour > 23) {
		hour = hour-24;
		day = date.getDate()+1;
	} else if(hour < 0) {
		hour = hour+24;
		day = date.getDate()-1;
	} else {
		day = date.getDate();
	}
	month = (date.getMonth().toString().length == 1 ? '0' + date.getMonth().toString() : date.getMonth());
	day = (day.toString().length == 1 ? '0' + day.toString() : day);
	hour = (hour.toString().length == 1 ? '0' + hour.toString() : hour);
	minutes = (date.getMinutes().toString().length == 1 ? '0' + date.getMinutes().toString() : date.getMinutes());
	seconds = (date.getSeconds().toString().length == 1 ? '0' + date.getSeconds().toString() : date.getSeconds());
	document.getElementById('dift').innerHTML = '&iquest;En tu pa&iacute;s son las ' + date.getYear() + '/' + month + '/' + day + ' ' + hour + ':' + minutes + ':' + seconds;
}
/*CUENTA*/

function ec_validate_data(form) {
    if(form.nombre.value.length < 6 || form.nombre.value.length > 32) { alert('El nombre y los apellidos deben tener entre los dos de 6 a 32 caracteres'); form.nombre.value = ''; form.nombre.focus(); return false; }
    if(!/^[a-zA-Z0-9]+$/.test(form.nombre.value.replace(' ', ''))) { alert('El nombre y los apellidos solo pueden contener caracteres alfanumericos'); form.nombre.value = ''; form.nombre.focus(); return false; }
    if(form.email.value.length > 35) { alert('El EMail no puede tener m\xe1s de 35 caracteres'); form.email.value = ''; form.email.focus(); return false; }
    if(!/^[a-z0-9_\.\-]{1,64}@[a-z0-9_\.\-]{1,255}\.([a-z]{2,3})+$/.test(form.email.value)) { form.email.value = ''; form.email.focus(); alert('El EMail no es v\xe1lido'); return false; }
	if(form.pais.options[form.pais.selectedIndex].value == -1 || form.pais.options[form.pais.selectedIndex].value == 28 || form.pais.options[form.pais.selectedIndex].value > 262 || form.pais.options[form.pais.selectedIndex].value < 0) { alert('Selecciona tu pa\xeds'); form.pais.selectedIndex = 0; form.pais.focus(); return false; }
    if(form.ciudad.value.length < 1 || form.ciudad.value.length > 32) { alert('La ciudad no puede pasar los 32 caracteres'); form.ciudad.value = ''; form.ciudad.focus(); return false; }
   	var day, month, year;
    day = parseInt(form.dia.value);
    month = parseInt(form.mes.value);
    year = parseInt(form.ano.value);
    if(!/^[0-9]+$/.test(day) || !/^[0-9]+$/.test(month) || !/^[0-9]+$/.test(year) || day.length > 2 || month.length > 2 || year.length > 4 || day > 31 || month > 12 || year > <?=date('Y');?>) { form.dia.value = ''; form.mes.value = ''; form.ano.value = ''; form.dia.focus(); alert('Introduce una fecha de nacimiento v\xe1lida'); return false; }
    if((year-<?=$config['min_age'];?>) > <?=(date('Y')-$config['min_age']);?>) { alert('Debes tener al menos <?=$config['min_age'];?> a\xf1os'); return false; }
	if(form.sitio.length > 60) { form.sitio.value = ''; form.sitio.focus(); alert('El sitio web no puede sobrepasar los 60 caracteres'); return false; }
	if(form.im.length > 64) { form.im.value = ''; form.im.focus(); alert('El mensajero no puede sobrepasar los 64 caracteres'); return false; }
    if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideUp('normal'); }
    ajax.open("GET", "/ajax/account-update.php?rnd=" + parseInt(Math.random()*99999) + "&sa=ec&name=" + form.nombre.value + "&email=" + form.email.value + "&country=" + form.pais.value + "&city=" + form.ciudad.value + "&gender=" + (form.sexo[0].checked ? 'm' : 'f') + "&birth_day=" + form.dia.value + "&birth_month=" + form.mes.value + "&birth_year=" + form.ano.value + "&website=" + form.sitio.value + "&messenger=" + form.im.value + "&messenger_type=" + form.im_tipo.options[form.im_tipo.selectedIndex].value + "&name_show=" + form.nombre_mostrar.options[form.nombre_mostrar.selectedIndex].value + "&email_show=" + form.email_mostrar.options[form.email_mostrar.selectedIndex].value + "&birth_show=" + form.fecha_nacimiento_mostrar.options[form.fecha_nacimiento_mostrar.selectedIndex].value + "&messenger_show=" + form.im_mostrar.options[form.im_mostrar.selectedIndex].value, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == 1) {
            	document.getElementById('mensajes_div').innerHTML = 'El perfil se ha actualizado correctamente';
                document.getElementById('mensajes_div').className = 'ok';
                $('#mensajes_div').slideDown('normal');
            } else {
            	document.getElementById('mensajes_div').innerHTML = ajax.responseText;
                document.getElementById('mensajes_div').className = 'error';
                $('#mensajes_div').slideDown('normal');
            }
            return false;
        }
	};
	ajax.send(null);
}

function cp_validate_data(form) {
	if(form.password.value.length < 6 || form.password.value.length > 32) { form.password.value = ''; form.password.focus(); alert('Tu contrase\xf1a debe tener entre 6 y 32 caracteres'); return false; }
    if(!/^[A-Za-z0-9]+$/.test(form.password.value)) { form.password.value = ''; form.password.focus(); alert('La contrase\xf1a actual no es v\xe1lida'); return false; }
	if(form.password1.value.length < 6 || form.password1.value.length > 32) { form.password1.value = ''; form.password1.focus(); alert('Tu contrase\xf1a debe tener entre 6 y 32 caracteres'); return false; }
    if(!/^[A-Za-z0-9]+$/.test(form.password1.value)) { form.password1.value = ''; form.password1.focus(); alert('La nueva contrase\xf1a no es v\xe1lida'); return false; }
    if(form.password1.value != form.password2.value) { form.password1.value = ''; form.password2.value = ''; form.password1.focus(); alert('Las contrase\xf1as no coincen'); return false; }
    if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideUp('normal'); }
    ajax.open("GET", "/ajax/account-update.php?rnd=" + parseInt(Math.random()*99999) + "&sa=cp&cp=" + form.password.value + "&np=" + form.password1.value, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == 1) {
            	document.getElementById('mensajes_div').innerHTML = 'La contrase&ntilde;a se ha actualizado correctamente';
                document.getElementById('mensajes_div').className = 'ok';
                $('#mensajes_div').slideDown('normal');
            } else {
            	document.getElementById('mensajes_div').innerHTML = ajax.responseText;
                document.getElementById('mensajes_div').className = 'error';
                $('#mensajes_div').slideDown('normal');
            }
            return false;
        }
	};
	ajax.send(null);
}

function cpt_validate_data(form) {
	if(form.ptext.value.length < 1 || form.ptext.value.length > 64) { form.ptext.value = ''; form.ptext.focus(); alert('Introduce un mensaje personal con menos de 64 caracteres'); return false; }
    if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideUp('normal'); }
    ajax.open("GET", "/ajax/account-update.php?rnd=" + parseInt(Math.random()*99999) + "&sa=cpt&pt=" + form.ptext.value, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == 1) {
            	document.getElementById('mensajes_div').innerHTML = 'El mensaje personal se ha actualizado correctamente';
                document.getElementById('mensajes_div').className = 'ok';
                $('#mensajes_div').slideDown('normal');
            } else {
            	document.getElementById('mensajes_div').innerHTML = ajax.responseText;
                document.getElementById('mensajes_div').className = 'error';
                $('#mensajes_div').slideDown('normal');
            }
            return false;
        }
	};
	ajax.send(null);
}

function up_validate_data(form, ct) {
	if(!ct || (ct != 1 && ct != 2)) { ct = 1; }
    ct = 1;
	for(i=0;i<form.elements.length;i++) {
    	if(form.elements[i].value == 'Eliminar' || form.elements[i].value == 'Agregar una imagen' || form.elements[i].value == 'Modificar mi perfil') { continue; }
    	if(form.elements[i].value.indexOf('*@') != -1) { form.elements[i].value = ''; form.elements[i].focus(); alert('No puedes usar *@ en las URL de las imagenes'); return false; }
        if(ct == 1) {
        /*alert('La URL debe ser una imagen, y por tanto debe tener una extensi\xf3n de imagen\nSi quieres, puedes usar la comprobaci\xf3n AJAX para usar imagenes din\xe1micas');*/
      		if(!/[.gif|.png|.jpg|.jpeg|.bmp|.ico|.psd|.GIF|.PNG|.JPG|.JPEG|.BMP|.ICO|.PSD]$/.test(form.elements[i].value)) { form.elements[i].value = ''; form.elements[i].focus();  alert('La URL debe ser una imagen, y debe tener extensi\xf3n gif, png, jpg, jpeg, bmp, ico o psd'); return false; }
        } else {
        	ajax.open("GET", form.elements[i].value + (form.elements[i].value.substring(-1) == '?' ? '&' : '?') + "rnd=" + parseInt(Math.random()*99999), true);
			ajax.onreadystatechange = function() {
				if(ajax.readyState == 4) {
        			if(ajax.status == 404) {
                    	form.elements[i].value = '';
                        form.elements[i].focus();
                        alert('La imagen no existe');
                        return false;
                    } else if(ajax.status != 200) {
                    	form.elements[i].focus();
                        alert('No se pudo completar la petici\xf3n, pero el archivo existe, reintentalo m\xe1s tarde');
                        return false;
                    } else {
                    	if(ajax.getResponseHeader('Content-type').substring(0, 5) != 'image') {
                        	form.elements[i].value = '';
                            form.elements[i].focus();
                            alert('\xA1Esto no es una imagen!');
                            return false;
                        }
                    }
        		}
			};
        }
    }
    var qs;
    for(i=0;i<form.elements.length;i++) {
    	if(form.elements[i].name.substring(0, 5) == 'image') {
   			qs += '&' + form.elements[i].name + '=' + form.elements[i].value;
        }
    }
    if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideUp('normal'); }
    ajax.open("GET", "/ajax/account-update.php?rnd=" + parseInt(Math.random()*99999) + "&sa=up&ct=" + ct + qs, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == 1) {
            	document.getElementById('mensajes_div').innerHTML = 'Tu tabl\xf3n se ha actualizado correctamente';
                document.getElementById('mensajes_div').className = 'ok';
                $('#mensajes_div').slideDown('normal');
            } else {
            	document.getElementById('mensajes_div').innerHTML = ajax.responseText;
                document.getElementById('mensajes_div').className = 'error';
                $('#mensajes_div').slideDown('normal');
            }
            return false;
        }
	};
	ajax.send(null);
}

function add_image() {
	var mii = '';
    for(i=0;i<photos_index;i++) {
    	mii += '<input value="' + document.getElementById('ii' + i).value + '" type="text" size="30" maxlength="64" id="ii' + i + '" name="image' + i + '" /> <input name="db' + i + '" type="button" id="db' + i + '" value="Eliminar" onclick="delete_image(' + i + ');" /><br id="br' + i + '" />';
    }
	document.getElementById('mis_imagenes').innerHTML = mii + '<input type="text" size="30" maxlength="64" id="ii' + photos_index + '" name="image' + photos_index + '" /> <input name="db' + photos_index + '" type="button" id="db' + photos_index + '" value="Eliminar" onclick="delete_image(' + photos_index + ');" /><br id="br' + photos_index + '" />';
    photos_index++;
}

function delete_image(inum) {
	document.getElementById('ii' + inum).parentNode.removeChild(document.getElementById('ii' + inum));
    document.getElementById('db' + inum).parentNode.removeChild(document.getElementById('db' + inum));
    document.getElementById('br' + inum).parentNode.removeChild(document.getElementById('br' + inum));
}

function av_validate_data(form) {
	if(form.avatar.value.length > 255) { form.avatar.value = ''; form.avatar.focus(); alert('El avatar no pude exceder los 255 caracteres'); return false; }
    if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideUp('normal'); }
    ajax.open("GET", "/ajax/account-update.php?rnd=" + parseInt(Math.random()*99999) + "&sa=av&av=" + form.avatar.value, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == 1) {
            	document.getElementById('mensajes_div').innerHTML = 'El avatar se ha cambiado correctamente';
                document.getElementById('mensajes_div').className = 'ok';
                $('#mensajes_div').slideDown('normal');
            } else {
            	document.getElementById('mensajes_div').innerHTML = ajax.responseText;
                document.getElementById('mensajes_div').className = 'error';
                $('#mensajes_div').slideDown('normal');
            }
            return false;
        }
	};
	ajax.send(null);
}

function op_validate_data(form) {
	if(form.mostrar_estado.options[form.mostrar_estado.selectedIndex].value != 'amigos' && form.mostrar_estado.options[form.mostrar_estado.selectedIndex].value != 'registrados' && form.mostrar_estado.options[form.mostrar_estado.selectedIndex].value != 'todos') { alert('&iquest;A quien quieres mostrar tu estado?'); return false; }
    if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideUp('normal'); }
    var me = (form.mostrar_estado_checkbox.checked === false ? 'nadie' : form.mostrar_estado.options[form.mostrar_estado.selectedIndex].value);
    ajax.open("GET", "/ajax/account-update.php?rnd=" + parseInt(Math.random()*99999) + "&sa=op&me=" + me + "&ss=" + form.participar_busquedas.checked + "&nw=" + form.recibir_boletin_semanal.checked + "&np=" + form.recibir_promociones.checked, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == 1) {
            	document.getElementById('mensajes_div').innerHTML = 'Las opciones se han cambiado correctamente';
                document.getElementById('mensajes_div').className = 'ok';
                $('#mensajes_div').slideDown('normal');
            } else {
            	document.getElementById('mensajes_div').innerHTML = ajax.responseText;
                document.getElementById('mensajes_div').className = 'error';
                $('#mensajes_div').slideDown('normal');
            }
            return false;
        }
	};
	ajax.send(null);
}

function am_validate_data(form) {
    if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideUp('normal'); }
    var ls, ch, lw;
    for(i=0;i<form.estado.length;i++) {
    	if(form.estado[i].checked) { ls = form.estado[i].value; break; }
    }
    for(i=0;i<form.hijos.length;i++) {
    	if(form.hijos[i].checked) { ch = form.hijos[i].value; break; }
    }
    for(i=0;i<form.vivo.length;i++) {
    	if(form.vivo[i].checked) { lw = form.vivo[i].value; break; }
    }
    ajax.open("GET", "/ajax/account-update.php?rnd=" + parseInt(Math.random()*99999) + "&sa=am&mf=" + form.me_gustaria_amigos.checked + "&mi=" + form.me_gustaria_conocer_gente.checked + "&mb=" + form.me_gustaria_conocer_gente_negocios.checked + "&fm=" + form.me_gustaria_encontrar_pareja.checked + "&fa=" + form.me_gustaria_de_todo.checked + "&ms=" + form.me_gustaria_mostrar.options[form.me_gustaria_mostrar.selectedIndex].value + "&ls=" + ls + "&lm=" + form.estado_mostrar.options[form.estado_mostrar.selectedIndex].value + "&ch=" + ch + "&cs=" + form.hijos_mostrar.options[form.hijos_mostrar.selectedIndex].value + "&lw=" + lw + "&wl=" + form.vivo_mostrar.options[form.vivo_mostrar.selectedIndex].value, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == 1) {
            	document.getElementById('mensajes_div').innerHTML = 'Tu perfil se ha cambiado correctamente';
                document.getElementById('mensajes_div').className = 'ok';
                $('#mensajes_div').slideDown('normal');
            } else {
            	document.getElementById('mensajes_div').innerHTML = ajax.responseText;
                document.getElementById('mensajes_div').className = 'error';
                $('#mensajes_div').slideDown('normal');
            }
            return false;
        }
	};
	ajax.send(null);
}

function in_validate_data(form) {
    if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideUp('normal'); }
    ajax.open("GET", "/ajax/account-update.php?rnd=" + parseInt(Math.random()*99999) + "&sa=in&mi=" + form.mis_intereses.value + "&ho=" + form.hobbies.value + "&ts=" + form.series_tv_favoritas.value + "&fm=" + form.musica_favorita.value + "&fs=" + form.deportes_y_equipos_favoritos.value + "&fb=" + form.libros_favoritos.value + "&ff=" + form.peliculas_favoritas.value + "&fo=" + form.comida_favorita.value + "&mh=" + form.mis_heroes_son.value + "&mis=" + form.mis_intereses_mostrar.options[form.mis_intereses_mostrar.selectedIndex].value + "&hos=" + form.hobbies_mostrar.options[form.hobbies_mostrar.selectedIndex].value + "&tss=" + form.series_tv_favoritas_mostrar.options[form.series_tv_favoritas_mostrar.selectedIndex].value + "&fms=" + form.musica_favorita_mostrar.options[form.musica_favorita_mostrar.selectedIndex].value + "&fss=" + form.deportes_y_equipos_favoritos_mostrar.options[form.deportes_y_equipos_favoritos_mostrar.selectedIndex].value + "&fbs=" + form.libros_favoritos_mostrar.options[form.libros_favoritos_mostrar.selectedIndex].value + "&ffs=" + form.peliculas_favoritas_mostrar.options[form.peliculas_favoritas_mostrar.selectedIndex].value + "&fos=" + form.comida_favorita_mostrar.options[form.comida_favorita_mostrar.selectedIndex].value + "&mhs=" + form.mis_heroes_son_mostrar.options[form.mis_heroes_son_mostrar.selectedIndex].value, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == 1) {
            	document.getElementById('mensajes_div').innerHTML = 'Tu perfil se ha cambiado correctamente';
                document.getElementById('mensajes_div').className = 'ok';
                $('#mensajes_div').slideDown('normal');
            } else {
            	document.getElementById('mensajes_div').innerHTML = ajax.responseText;
                document.getElementById('mensajes_div').className = 'error';
                $('#mensajes_div').slideDown('normal');
            }
            return false;
        }
	};
	ajax.send(null);
}

function kn_validate_data(form) {
    if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideUp('normal'); }
    ajax.open("GET", "/ajax/account-update.php?rnd=" + parseInt(Math.random()*99999) + "&sa=kn&st=" + form.estudios.options[form.estudios.selectedIndex].value + "&language_spanish=" + form.idioma_castellano.options[form.idioma_castellano.selectedIndex] + "&language_english=" + form.idioma_ingles.options[form.idioma_ingles.selectedIndex].value + "&language_portuguese=" + form.idioma_portugues.options[form.idioma_portugues.selectedIndex].value + "&language_french=" + form.idioma_frances.options[form.idioma_frances.selectedIndex].value + "&language_italian=" + form.idioma_italiano.options[form.idioma_italiano.selectedIndex].value + "&language_german=" + form.idioma_aleman.options[form.idioma_aleman.selectedIndex].value + "&language_other=" + form.idioma_otro.options[form.idioma_otro.selectedIndex].value + "&wo=" + form.profesion.value + "&co=" + form.empresa.value + "&se=" + form.sector.options[form.sector.selectedIndex].value + "&in=" + form.ingresos.options[form.ingresos.selectedIndex].value + "&wi=" + form.intereses_profesionales.value + "&ws=" + form.habilidades_profesionales.value + "&sts=" + form.estudios_mostrar.options[form.estudios_mostrar.selectedIndex].value + "&las=" + form.idioma_mostrar.options[form.idioma_mostrar.selectedIndex].value + "&wos=" + form.profesion_mostrar.options[form.profesion_mostrar.selectedIndex].value + "&cos=" + form.empresa_mostrar.options[form.empresa_mostrar.selectedIndex].value + "&ses=" + form.sector_mostrar.options[form.sector_mostrar.selectedIndex].value + "&ins=" + form.ingresos_mostrar.options[form.ingresos_mostrar.selectedIndex].value + "&wis=" + form.intereses_profesionales_mostrar.options[form.intereses_profesionales_mostrar.selectedIndex].value + "&wss=" + form.habilidades_profesionales_mostrar.options[form.habilidades_profesionales_mostrar.selectedIndex].value, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == 1) {
            	document.getElementById('mensajes_div').innerHTML = 'Tu perfil se ha cambiado correctamente';
                document.getElementById('mensajes_div').className = 'ok';
                $('#mensajes_div').slideDown('normal');
            } else {
            	document.getElementById('mensajes_div').innerHTML = ajax.responseText;
                document.getElementById('mensajes_div').className = 'error';
                $('#mensajes_div').slideDown('normal');
            }
            return false;
        }
	};
	ajax.send(null);
}

function as_validate_data(form) {
	for(i=0;i<form.fumo.length;i++) {
    	if(form.fumo[i].checked) { var sm = form.fumo[i].value; break; }
    }
	for(i=0;i<form.tomo_alcohol.length;i++) {
    	if(form.tomo_alcohol[i].checked) { var dr = form.tomo_alcohol[i].value; break; }
    }
    if(document.getElementById('mensajes_div').style.display == 'block') { $('#mensajes_div').slideUp('normal'); }
    ajax.open("GET", "/ajax/account-update.php?rnd=" + parseInt(Math.random()*99999) + "&sa=as&he=" + form.altura.value + "&we=" + form.peso.value + "&hc=" + form.pelo_color.options[form.pelo_color.selectedIndex].value + "&ec=" + form.ojos_color.options[form.ojos_color.selectedIndex].value + "&co=" + form.fisico.options[form.fisico.selectedIndex].value + "&di=" + form.dieta.options[form.dieta.selectedIndex].value + "&ta=" + form.tengo_tatuajes.checked + "&pi=" + form.tengo_piercings.checked + "&sm=" + sm + "&dr=" + dr + "&hes=" + form.altura_mostrar.options[form.altura_mostrar.selectedIndex].value + "&wes=" + form.peso_mostrar.options[form.peso_mostrar.selectedIndex].value + "&hcs=" + form.pelo_color_mostrar.options[form.pelo_color_mostrar.selectedIndex].value + "&ecs=" + form.ojos_color_mostrar.options[form.ojos_color_mostrar.selectedIndex].value + "&cos=" + form.fisico_mostrar.options[form.fisico_mostrar.selectedIndex].value + "&dis=" + form.dieta_mostrar.options[form.dieta_mostrar.selectedIndex].value + "&tps=" + form.tengo_tatuajes_piercings_mostrar.options[form.tengo_tatuajes_piercings_mostrar.selectedIndex].value + "&sms=" + form.fumo_mostrar.options[form.fumo_mostrar.selectedIndex].value + "&drs=" + form.tomo_alcohol_mostrar.options[form.tomo_alcohol_mostrar.selectedIndex].value, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == 1) {
            	document.getElementById('mensajes_div').innerHTML = 'Tu perfil se ha cambiado correctamente';
                document.getElementById('mensajes_div').className = 'ok';
                $('#mensajes_div').slideDown('normal');
            } else {
            	document.getElementById('mensajes_div').innerHTML = ajax.responseText;
                document.getElementById('mensajes_div').className = 'error';
                $('#mensajes_div').slideDown('normal');
            }
            return false;
        }
	};
	ajax.send(null);
}

/*MENSAJES*/

function mensajes_check(num) {
	var num = parseInt(num);
    var e = document.mensajes.elements;
	if(num == 1) {
    	for(i=0;i<e.length;e++) {
        	if(e[i].name.substring(0, 4) != 'm_o_') { continue; }
            e[i].checked = true;
        }
    } else if(num == 2) {
    	for(i=0;i<e.length;e++) {
        	if(e[i].name.substring(0, 4) != 'm_o_') { continue; }
            e[i].checked = false;
        }
    } else if(num == 3) {
    	var enc = false;
    	for(i=0;i<e.length;e++) {
        	if(e[i].name.substring(0, 4) != 'm_o_') { continue; }
            for(a=0;a<men_leidos.length;a++) {
               	if(men_leidos[a] == e[i].name) { enc = true; break; }
            }
            e[i].checked = (enc ? true : false);
            enc = false;
        }
    } else if(num == 4) {
    	var enc = false;
    	for(i=0;i<e.length;e++) {
        	if(e[i].name.substring(0, 4) != 'm_o_') { continue; }
            for(a=0;a<men_leidos.length;a++) {
               	if(men_leidos[a] == e[i].name) { enc = true; break; }
            }
            e[i].checked = (enc ? false : true);
            enc = false;
        }
    } else if(num == 5) {
    	for(i=0;i<e.length;e++) {
        	e[i].checked = (e[i].checked ? false : true);
        }
    }
}

/*MONITOR*/
var current_monitor = 0;
function monitor_sections(num) {
	if(num != 1 && num != 2 && num != 3) { return false; }
    if(num == current_monitor) { return false; }
    ajax.open("GET", "/ajax/monitor.php?rnd=" + parseInt(Math.random()*99999) + "&sa=" + num, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	document.getElementById('monitor_loading').style.display = 'none';
            document.getElementById('showResult').innerHTML = ajax.responseText;
            if(current_monitor != 0) {
            	document.getElementById('ms_' + current_monitor).className = '';
            	document.getElementById('ms_' + num).className = 'here';
            }
            current_monitor = num;
        } else {
        	document.getElementById('monitor_loading').style.display = 'inline';
        }
	};
	ajax.send(null);
}

/*COMUNIDADES*/

/*NUEVA COMUNIDAD*/
function groups_shortname_check(name) {
    ajax.open("GET", "/ajax/new-group.php?rnd=" + parseInt(Math.random()*99999) + "&sa=check" + "&name=" + name, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	document.getElementById('shortname').style.display = 'none';
            document.getElementById('preview_shortname').className = (ajax.responseText == 1 ? 'ok' : 'error');
        	document.getElementById('msg_crear_shortname').innerHTML = (ajax.responseText == 1 ? 'El nombre est\xe1 libre' : ajax.responseText);
            document.getElementById('msg_crear_shortname').className = (ajax.responseText == 1 ? 'ok' : 'error');
        } else {
        	document.getElementById('shortname').style.display = 'inline';
        }
	};
	ajax.send(null);
}

function groups_categories(id) {
    ajax.open("GET", "/ajax/new-group.php?rnd=" + parseInt(Math.random()*99999) + "&sa=subcat" + "&id=" + id, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText.substring(0, 1) == '0') { alert(ajax.responseText.substring(1)); return; }
        	var si = document.getElementById('subcategoria_input');
        	document.getElementById('subcategoria').style.display = 'none';
            for(i=1;i<si.options.length;i++) {
            	si.options[i] = null;
            }
            var spl = ajax.responseText.split(',');
            for(i=0;i<spl.length;i++) {
            	var spl2 = spl[i].split(':');
            	si.options[(i+1)] = new Option (spl2[0], spl2[1]);
            }
            si.disabled = false;
        } else {
        	document.getElementById('subcategoria').style.display = 'inline';
            document.getElementById('subcategoria_input').disabled = true;
        }
	};
	ajax.send(null);
}
		
/*VISTA COMUNIDAD*/
var show = '0';
function datos_comunidad_ver(link) {
	$('#cMasInfo').slideToggle(3000);
    link.innerHTML = (show == '0' ? '&laquo; Ver menos' : 'Ver m&aacute;s &raquo;');
    show = (show == '0' ? '1' : '0');
}

function participar_comunidad(id, rank, step) {
	if(!step) {
        mydialog.show();
		mydialog.title('Unirme a la comunidad');
		mydialog.body('&iquest;Seguro que quieres unirte a esta comunidad?<br />Tu rango ser&aacute;: <strong>' + rank + '</strong>');
		mydialog.buttons(true, true, 'SI', "participar_comunidad(" + id + ", '" + rank + "', true);", true, false, true, 'NO', 'close', true, true);
		mydialog.center();
    } else {
   	 	ajax.open("GET", "/ajax/groups-ee.php?rnd=" + parseInt(Math.random()*99999) + "&sa=participate&id=" + id, true);
		ajax.onreadystatechange = function() {
			if(ajax.readyState == 4) {
            	mydialog.procesando_fin();
        		if(ajax.responseText == '1') {
                	mydialog.alert('Unirme a la comunidad', '&iexcl;Te has unido a la comunidad!', true);
                } else {
                	mydialog.alert('Unirme a la comunidad', 'Error: ' + ajax.responseText);
                }
        	} else {
        		mydialog.procesando_inicio('Cargando', 'Unirme a la comunidad');
        	}
		};
		ajax.send(null);
    }
}

function dejar_comunidad(id, step) {
	if(!step) {
        mydialog.show();
		mydialog.title('Dejar la comunidad');
		mydialog.body('&iquest;Seguro que quieres abandonar esta comunidad?<br />Si eres el &uacute;ltimo miembro en ella, esta ser&aacute; borrada.');
		mydialog.buttons(true, true, 'SI', "dejar_comunidad(" + id + ", true);", true, false, true, 'NO', 'close', true, true);
		mydialog.center();
    } else {
   	 	ajax.open("GET", "/ajax/groups-ee.php?rnd=" + parseInt(Math.random()*99999) + "&sa=leave&id=" + id, true);
		ajax.onreadystatechange = function() {
			if(ajax.readyState == 4) {
            	mydialog.procesando_fin();
        		if(ajax.responseText == '1') {
                	mydialog.alert('Dejar la comunidad', 'Has abandonado la comunidad', true);
                } else {
                	mydialog.alert('Dejar la comunidad', 'Error: ' + ajax.responseText);
                }
        	} else {
        		mydialog.procesando_inicio('Cargando', 'Dejar la comunidad');
        	}
		};
		ajax.send(null);
    }
}

function groups_update_last_comments(cat, group) {
	ajax.open("GET", "/ajax/group-lastcomments.php?rnd=" + parseInt(Math.random()*99999) + "&i=1&cat=" + cat + "&group=" + group, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(document.getElementById('ult_comm_loading')) { document.getElementById('ult_comm_loading').style.display = 'none'; }
        	$('#ult_comm').slideUp('slow');
            setTimeout("document.getElementById('ult_comm').innerHTML = ajax.responseText;$('#ult_comm').slideDown('slow');", 1000);
        } else {
        	if(document.getElementById('ult_comm_loading')) { document.getElementById('ult_comm_loading').style.display = 'block'; }
        }
	};
	ajax.send(null);
}

function groups_vote_post(id, a) {
	if(a != -1 && a != 1) { alert('-.-'); return false; }
    document.getElementById('actions').innerHTML = 'Votando... ';
	ajax.open("GET", "/ajax/groups-vote.php?rnd=" + parseInt(Math.random()*99999) + "&id=" + id + "&a=" + a, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	if(ajax.responseText == '1') {
            	document.getElementById('actions').innerHTML = 'Votado';
                var vt = parseInt(document.getElementById('votos_total').innerHTML)+a;
                if(vt == 0) {
                	document.getElementById('votos_total').style.visibility = 'hidden';
                } else {
                	document.getElementById('votos_total').style.visibility = 'visible';
                	document.getElementById('votos_total').className = 'color_' + (vt > 0 ? 'green' : 'red');
                	document.getElementById('votos_total').innerHTML = (vt > 0 ? '+' : '') + vt;
                }
            } else {
            	document.getElementById('actions').innerHTML = 'Error ';
                mydialog.alert('Error', ajax.responseText);
            }
        }
	};
	ajax.send(null);
}

var current_gmli = 1;
function groups_miembros_list(s, g) {
	document.getElementById('gmli').style.display = 'inline';
	ajax.open("GET", "/ajax/groups-members-list.php?rnd=" + parseInt(Math.random()*99999) + "&i=1&s=" + s + "&group=" + g, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        		document.getElementById('gmli').style.display = 'none';
            		$('#gml' + current_gmli).removeClass('here');
            		$('#gml' + (isNaN(parseInt(s)) ? '1' : s)).addClass('here');
            		current_gmli = s;
        		document.getElementById('showResult').innerHTML = ajax.responseText;
       		}
	};
	ajax.send(null);
}

function groups_admin_user(u, g) {
	mydialog.procesando_inicio('Cargando', 'Cargando');
	ajax.open("GET", "/ajax/groups-admin-user.php?rnd=" + parseInt(Math.random()*99999) + "&id=" + u + "&group=" + g, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
			mydialog.procesando_fin();
			if(ajax.responseText.indexOf('<') == -1) {
				mydialog.alert('Error', ajax.responseText);
			} else {
				mydialog.show();
				mydialog.title('Administrar usuario');
				mydialog.body(ajax.responseText, 400);
				mydialog.buttons(true, true, 'Aceptar', "document.getElementById('gauf').submit();", false, false, true, 'Cancelar', 'close', true, false);
				mydialog.center();
			}
        }
	};
	ajax.send(null);
}

function groups_adminusers_submit() {
	f = document.getElementById('gauf');
	if(!groups_adminusers_check(true)) { return false; }
    mydialog.close();
	mydialog.procesando_inicio('Administrar usuario', 'Administrar usuario');
	ajax.open("GET", "/ajax/groups-admin-user.php?rnd=" + parseInt(Math.random()*99999) + "&send=1&user=" + f.user.value + "&group=" + f.group.value + "&action=" + (f.r_admin_user[0].checked ? '1' : '2') + "&rank=" + f.s_rango.options[f.s_rango.selectedIndex].value + "&permanent=" + (f.r_suspender_dias[0].checked == '1' ? '1' : '0') + "&days=" + f.i_suspender_dias.value + "&reason=" + f.causa.value, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
			mydialog.procesando_fin();
			if(ajax.responseText == '1') {
            	if(f.r_admin_user[0].checked) {
                	mydialog.alert('&Eacute;xito', 'Usuario suspendido con &eacute;xito');
                } else {
                	mydialog.alert('&Eacute;xito', 'Usuario cambiado de rango con &eacute;xito');
                }
            } else {
            	mydialog.alert('Error', ajax.responseText);
            }
        }
	};
	ajax.send(null);
}

function groups_adminusers_check(c) {
	if((!document.getElementById('r_suspender').checked && !document.getElementById('r_rango').checked) || (document.getElementById('r_suspender').checked && document.getElementById('r_rango').checked)) { return false; }
    var e = (document.getElementById('r_suspender').checked ? document.getElementById('r_suspender') : document.getElementById('r_rango'));
    var r = true;
    if(e.id == 'r_suspender') {
    	if(document.getElementById('t_causa').value == '') { r = false; }
        if(!document.getElementById('r_suspender_dias1').checked && !document.getElementById('r_suspender_dias2').checked) { r = false; }
        if(document.getElementById('r_suspender_dias2').checked && (document.getElementById('t_suspender').value == '' || document.getElementById('t_suspender').value.search(/^[0-9]+$/) == -1)) { r = false; }
	} else {
    	if(rango_actual == document.getElementById('s_rango').options[document.getElementById('s_rango').selectedIndex].value) { r = false; }
    }
    if(r === true) {
    	mydialog.buttons_enabled(true, true);
    } else {
    	mydialog.buttons_enabled(false, true);
    }
    if(c) { return r; }
}
/*CHAT*/

/*function chat_send() {
	var input = document.getElementById('cm');
	ajax.open("POST", "/ajax/chat.php?rnd=" + parseInt(Math.random()*99999) + "&sa=send", true);
	ajax.send("m=" + encodeURIComponent(input.value));
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
			var spl = ajax.responseText.split('-');
			if(spl[0] != '0') {
				var div = document.createElement('div');
				div.id = 'm' + spl[0];
				div.class = 'chat_m_' + (++chat_m_n);
				document.getElementById('chat_bc').appendChild(div);
			} else { alert("Error al enviar el mensaje\n" + spl[1]); }
        	}
	};
}

function chat_delete(id) {

}*/

/*OTROS*/

function error_avatar(img) {
	img.src = '/images/avatar.gif';
}

function buser(id, action, ok) {
    var act = (action ? '1' : '2');
	if(!ok) {
    	mydialog.show();
		mydialog.title((act == '1' ? 'Bloquear' : 'Desbloquear') + ' usuario');
		mydialog.body('&iquest;Seguro que deseas ' + (act == '1' ? 'bloquear' : 'desbloquear') + ' este usuario?');
		mydialog.buttons(true, true, 'SI', 'buser(' + id + ', ' + (act == '1' ? 'true' : 'false') + ', 1);', true, false, true, 'NO', 'close', true, true);
		mydialog.center();
        return false;
    } else {
    	mydialog.procesando_inicio((act == '1' ? 'Bloqueando' : 'Desbloqueando') + '...', (act == '1' ? 'Bloquear' : 'Desbloquear') + ' usuario');
    	ajax.open("GET", "/ajax/buser.php?rnd=" + parseInt(Math.random()*99999) + "&sa=" + act + "&id=" + id, true);
		ajax.onreadystatechange = function() {
			if(ajax.readyState == 4) {
     	   		mydialog.procesando_fin();
        		if(ajax.responseText == '1') {
            		mydialog.alert('Usuario ' + (act == '1' ? 'bloqueado' : 'desbloqueado'), 'El usuario ha sido ' + (act == '1' ? 'bloqueado' : 'desbloqueado') + ' correctamente');
                    document.getElementById('buser_1_' + id).style.display = (act == '1' ? 'none' : 'block');
                    document.getElementById('buser_2_' + id).style.display = (act == '2' ? 'none' : 'block');
            	} else {
            		mydialog.alert('Error', ajax.responseText);
            	}
        	}
		};
		ajax.send(null);
    }
}

var topstabs_current = new Array(3);
topstabs_current[1] = 'Semana';
topstabs_current[2] = 'Mes';
topstabs_current[3] = 'Semana';
function TopsTabs(pref, filter) {
	var pn = (pref == 'posts_' ? 1 : (pref == 'users_' ? 2 : 3));
	if(filter == topstabs_current[pn]) { return false; }
	$('#filter_' + pn + '_' + topstabs_current[pn]).removeClass('here');
	$('#filter_' + pn + '_' + filter).addClass('here');
    $('#' + pref + 'filterBy' + topstabs_current[pn]).fadeOut(500);
    $('#' + pref + 'filterBy' + filter).fadeIn(500);
    topstabs_current[pn] = filter;
    if(pref == 'posts_') {
    	if(t_posts[pn] < t_posts[t_posts_selected]) {
            document.getElementById('box_c_posts').style.height = parseInt(t_posts_box_dh+t_posts[pn]+5) + 'px';
        	t_posts_selected = pn;
        } else {
        	if(filter == 'Semana') {
        		setTimeout("document.getElementById('box_c_posts').style.height = parseInt(t_posts_box_dh+t_posts[1]) + 'px';", 400);
    			t_posts_selected = 1;
            } else if(filter == 'Mes') {
        		setTimeout("document.getElementById('box_c_posts').style.height = parseInt(t_posts_box_dh+t_posts[2]) + 'px';", 400);
    			t_posts_selected = 2;
            } else {
        		setTimeout("document.getElementById('box_c_posts').style.height = parseInt(t_posts_box_dh+t_posts[3]) + 'px';", 400);
    			t_posts_selected = 3;
            }
        }
    } else if(pref == 'users_') {
    	if(t_users[pn] < t_posts[t_users_selected]) {
        	document.getElementById('box_c_users').style.height = parseInt(document.getElementById('box_c_users').offsetHeight+t_users[pn]+5) + 'px';
        } else {
        	if(filter == 'Semana') {
        		setTimeout("document.getElementById('box_c_users').style.height = parseInt(t_users_box_dh+t_users[1]) + 'px';", 400);
    			t_users_selected = 1;
            } else if(filter == 'Mes') {
        		setTimeout("document.getElementById('box_c_users').style.height = parseInt(t_users_box_dh+t_users[2]) + 'px';", 400);
    			t_users_selected = 2;
            } else {
        		setTimeout("document.getElementById('box_c_users').style.height = parseInt(t_users_box_dh+t_users[3]) + 'px';", 400);
    			t_users_selected = 3;
            }
        }
    } else {
    	if(t_groups[pn] < t_groups[t_users_selected]) {
        	document.getElementById('box_c_groups').style.height = parseInt(document.getElementById('box_c_users').offsetHeight+t_groups[pn]+5) + 'px';
        } else {
        	if(filter == 'Semana') {
        		setTimeout("document.getElementById('box_c_groups').style.height = parseInt(t_groups_box_dh+t_groups[1]) + 'px';", 400);
    			t_groups_selected = 1;
            } else if(filter == 'Mes') {
        		setTimeout("document.getElementById('box_c_groups').style.height = parseInt(t_groups_box_dh+t_groups[2]) + 'px';", 400);
    			t_groups_selected = 2;
            } else {
        		setTimeout("document.getElementById('box_c_groups').style.height = parseInt(t_groups_box_dh+t_groups[3]) + 'px';", 400);
    			t_groups_selected = 3;
            }
        }
    }
}
 
function scrollUp() {
	var cs = (document.documentElement && document.documentElement.scrollTop)? document.documentElement : document.body;
	var step = Math.ceil(cs.scrollTop / 10);
	scrollBy(0, (step-(step*2)));
	if(cs.scrollTop>0) {
    	setTimeout('scrollUp()', 40);
	}
}

<?php if(!isLogged()) { ?>
function getDif() {
	var servdate, userdate, dif;
	servdate = new Date(<?=date('Y, m, d, H');?>);
	userdate = new Date();
	if(servdate.getDate() == userdate.getDate()) {
		dif = userdate.getHours()-servdate.getHours();
	} else if(servdate.getDate() > userdate.getDate()) {
		dif = userdate.getHours()-(24+servdate.getHours());
	} else {
		dif = (24+userdate.getHours())-servdate.getHours();
	}
	dif = dif.toString();
	dif = (dif.substring(0, 1) == '-' ? dif : '+' + dif);
	document.cookie = 'difh=' + dif + ';expires=<?=date('r', time()+365*86400);?>;path=/';
}
<? } ?>

var mDs = '0';

/*FT*/

var clientPC = navigator.userAgent.toLowerCase();
var clientVer = parseInt(navigator.appVersion);

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1) && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1) && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);
var is_moz = 0;

/* LANG */

if(!lang)
	var lang = Array();
/* Editor */
lang['Negrita'] = "Negrita";
lang['Cursiva'] = "Cursiva";
lang['Subrayado'] = "Subrayado";
lang['Alinear a la izquierda'] = "Alinear a la izquierda";
lang['Centrar'] = "Centrar";
lang['Alinear a la derecha'] = "Alinear a la derecha";
lang['Color'] = "Color";
lang['Rojo oscuro'] = "Rojo oscuro";
lang['Rojo'] = "Rojo";
lang['Naranja'] = "Naranja";
lang['Marron'] = "Marr&oacute;n";
lang['Amarillo'] = "Amarillo";
lang['Verde'] = "Verde";
lang['Oliva'] = "Oliva";
lang['Cyan'] = "Cyan";
lang['Azul'] = "Azul";
lang['Azul oscuro'] = "Azul oscuro";
lang['Indigo'] = "Indigo";
lang['Violeta'] = "Violeta";
lang['Negro'] = "Negro";
lang['Tamano'] = "Tama&ntilde;o";
lang['Miniatura'] = "Miniatura";
lang['Pequena'] = "Peque&ntilde;a";
lang['Normal'] = "Normal";
lang['Grande'] = "Grande";
lang['Enorme'] = "Enorme";
lang['Insertar video de YouTube'] = "Insertar video de YouTube";
lang['Insertar video de Google Video'] = "Insertar video de Google Video";
lang['Insertar archivo SWF'] = "Insertar archivo SWF";
lang['Insertar Imagen'] = "Insertar Imagen";
lang['Insertar Link'] = "Insertar Link";
lang['Citar'] = "Citar";
lang['Ingrese la URL que desea postear'] = "Ingrese la URL que desea postear";
lang['Fuente'] = "Fuente";
lang['ingrese el id de yt'] = "Ingrese el ID del video de YouTube:\n\nEjemplo:\nSi la URL de su video es:\nhttp://www.youtube.com/watch?v=CACqDFLQIXI\nEl ID es: CACqDFLQIXI";
lang['ingrese el id de yt IE'] = "Ingrese el ID del video de YouTube:\nPor ejemplo: CACqDFLQIXI";
lang['ingrese el id de gv'] = "Ingrese el ID del video de Google:\n\nEjemplo:\nSi la URL de su video es:\nhttp://video.google.com/videoplay?docid=-5331378923498461236\nEl ID es: -5331378923498461236";
lang['ingrese el id de gv IE'] = "Ingrese el ID del video de Google:\nPor ejemplo: -5331378923498461236";
lang['ingrese la url de swf'] = "Ingrese la URL del archivo swf";
lang['ingrese la url de img'] = "Ingrese la URL de la imagen";
lang['ingrese la url de url'] = "Ingrese la URL que desea postear";
lang['ingrese el txt a citar'] = "Ingrese el texto a citar";
lang['ingrese solo el id de yt'] = "Ingrese solo el ID de YouTube";
lang['ingrese solo el id de gv'] = "Ingrese solo el ID de GoogleVideo";

/* JQUERY */

/*
 * jQuery JavaScript Library v1.3.2
 * http://jquery.com/
 *
 * Copyright (c) 2009 John Resig
 * Dual licensed under the MIT and GPL licenses.
 * http://docs.jquery.com/License
 *
 * Date: 2009-02-19 17:34:21 -0500 (Thu, 19 Feb 2009)
 * Revision: 6246
 */
(function(){var l=this,g,y=l.jQuery,p=l.$,o=l.jQuery=l.$=function(E,F){return new o.fn.init(E,F)},D=/^[^<]*(<(.|\s)+>)[^>]*$|^#([\w-]+)$/,f=/^.[^:#\[\.,]*$/;o.fn=o.prototype={init:function(E,H){E=E||document;if(E.nodeType){this[0]=E;this.length=1;this.context=E;return this}if(typeof E==="string"){var G=D.exec(E);if(G&&(G[1]||!H)){if(G[1]){E=o.clean([G[1]],H)}else{var I=document.getElementById(G[3]);if(I&&I.id!=G[3]){return o().find(E)}var F=o(I||[]);F.context=document;F.selector=E;return F}}else{return o(H).find(E)}}else{if(o.isFunction(E)){return o(document).ready(E)}}if(E.selector&&E.context){this.selector=E.selector;this.context=E.context}return this.setArray(o.isArray(E)?E:o.makeArray(E))},selector:"",jquery:"1.3.2",size:function(){return this.length},get:function(E){return E===g?Array.prototype.slice.call(this):this[E]},pushStack:function(F,H,E){var G=o(F);G.prevObject=this;G.context=this.context;if(H==="find"){G.selector=this.selector+(this.selector?" ":"")+E}else{if(H){G.selector=this.selector+"."+H+"("+E+")"}}return G},setArray:function(E){this.length=0;Array.prototype.push.apply(this,E);return this},each:function(F,E){return o.each(this,F,E)},index:function(E){return o.inArray(E&&E.jquery?E[0]:E,this)},attr:function(F,H,G){var E=F;if(typeof F==="string"){if(H===g){return this[0]&&o[G||"attr"](this[0],F)}else{E={};E[F]=H}}return this.each(function(I){for(F in E){o.attr(G?this.style:this,F,o.prop(this,E[F],G,I,F))}})},css:function(E,F){if((E=="width"||E=="height")&&parseFloat(F)<0){F=g}return this.attr(E,F,"curCSS")},text:function(F){if(typeof F!=="object"&&F!=null){return this.empty().append((this[0]&&this[0].ownerDocument||document).createTextNode(F))}var E="";o.each(F||this,function(){o.each(this.childNodes,function(){if(this.nodeType!=8){E+=this.nodeType!=1?this.nodeValue:o.fn.text([this])}})});return E},wrapAll:function(E){if(this[0]){var F=o(E,this[0].ownerDocument).clone();if(this[0].parentNode){F.insertBefore(this[0])}F.map(function(){var G=this;while(G.firstChild){G=G.firstChild}return G}).append(this)}return this},wrapInner:function(E){return this.each(function(){o(this).contents().wrapAll(E)})},wrap:function(E){return this.each(function(){o(this).wrapAll(E)})},append:function(){return this.domManip(arguments,true,function(E){if(this.nodeType==1){this.appendChild(E)}})},prepend:function(){return this.domManip(arguments,true,function(E){if(this.nodeType==1){this.insertBefore(E,this.firstChild)}})},before:function(){return this.domManip(arguments,false,function(E){this.parentNode.insertBefore(E,this)})},after:function(){return this.domManip(arguments,false,function(E){this.parentNode.insertBefore(E,this.nextSibling)})},end:function(){return this.prevObject||o([])},push:[].push,sort:[].sort,splice:[].splice,find:function(E){if(this.length===1){var F=this.pushStack([],"find",E);F.length=0;o.find(E,this[0],F);return F}else{return this.pushStack(o.unique(o.map(this,function(G){return o.find(E,G)})),"find",E)}},clone:function(G){var E=this.map(function(){if(!o.support.noCloneEvent&&!o.isXMLDoc(this)){var I=this.outerHTML;if(!I){var J=this.ownerDocument.createElement("div");J.appendChild(this.cloneNode(true));I=J.innerHTML}return o.clean([I.replace(/ jQuery\d+="(?:\d+|null)"/g,"").replace(/^\s*/,"")])[0]}else{return this.cloneNode(true)}});if(G===true){var H=this.find("*").andSelf(),F=0;E.find("*").andSelf().each(function(){if(this.nodeName!==H[F].nodeName){return}var I=o.data(H[F],"events");for(var K in I){for(var J in I[K]){o.event.add(this,K,I[K][J],I[K][J].data)}}F++})}return E},filter:function(E){return this.pushStack(o.isFunction(E)&&o.grep(this,function(G,F){return E.call(G,F)})||o.multiFilter(E,o.grep(this,function(F){return F.nodeType===1})),"filter",E)},closest:function(E){var G=o.expr.match.POS.test(E)?o(E):null,F=0;return this.map(function(){var H=this;while(H&&H.ownerDocument){if(G?G.index(H)>-1:o(H).is(E)){o.data(H,"closest",F);return H}H=H.parentNode;F++}})},not:function(E){if(typeof E==="string"){if(f.test(E)){return this.pushStack(o.multiFilter(E,this,true),"not",E)}else{E=o.multiFilter(E,this)}}var F=E.length&&E[E.length-1]!==g&&!E.nodeType;return this.filter(function(){return F?o.inArray(this,E)<0:this!=E})},add:function(E){return this.pushStack(o.unique(o.merge(this.get(),typeof E==="string"?o(E):o.makeArray(E))))},is:function(E){return !!E&&o.multiFilter(E,this).length>0},hasClass:function(E){return !!E&&this.is("."+E)},val:function(K){if(K===g){var E=this[0];if(E){if(o.nodeName(E,"option")){return(E.attributes.value||{}).specified?E.value:E.text}if(o.nodeName(E,"select")){var I=E.selectedIndex,L=[],M=E.options,H=E.type=="select-one";if(I<0){return null}for(var F=H?I:0,J=H?I+1:M.length;F<J;F++){var G=M[F];if(G.selected){K=o(G).val();if(H){return K}L.push(K)}}return L}return(E.value||"").replace(/\r/g,"")}return g}if(typeof K==="number"){K+=""}return this.each(function(){if(this.nodeType!=1){return}if(o.isArray(K)&&/radio|checkbox/.test(this.type)){this.checked=(o.inArray(this.value,K)>=0||o.inArray(this.name,K)>=0)}else{if(o.nodeName(this,"select")){var N=o.makeArray(K);o("option",this).each(function(){this.selected=(o.inArray(this.value,N)>=0||o.inArray(this.text,N)>=0)});if(!N.length){this.selectedIndex=-1}}else{this.value=K}}})},html:function(E){return E===g?(this[0]?this[0].innerHTML.replace(/ jQuery\d+="(?:\d+|null)"/g,""):null):this.empty().append(E)},replaceWith:function(E){return this.after(E).remove()},eq:function(E){return this.slice(E,+E+1)},slice:function(){return this.pushStack(Array.prototype.slice.apply(this,arguments),"slice",Array.prototype.slice.call(arguments).join(","))},map:function(E){return this.pushStack(o.map(this,function(G,F){return E.call(G,F,G)}))},andSelf:function(){return this.add(this.prevObject)},domManip:function(J,M,L){if(this[0]){var I=(this[0].ownerDocument||this[0]).createDocumentFragment(),F=o.clean(J,(this[0].ownerDocument||this[0]),I),H=I.firstChild;if(H){for(var G=0,E=this.length;G<E;G++){L.call(K(this[G],H),this.length>1||G>0?I.cloneNode(true):I)}}if(F){o.each(F,z)}}return this;function K(N,O){return M&&o.nodeName(N,"table")&&o.nodeName(O,"tr")?(N.getElementsByTagName("tbody")[0]||N.appendChild(N.ownerDocument.createElement("tbody"))):N}}};o.fn.init.prototype=o.fn;function z(E,F){if(F.src){o.ajax({url:F.src,async:false,dataType:"script"})}else{o.globalEval(F.text||F.textContent||F.innerHTML||"")}if(F.parentNode){F.parentNode.removeChild(F)}}function e(){return +new Date}o.extend=o.fn.extend=function(){var J=arguments[0]||{},H=1,I=arguments.length,E=false,G;if(typeof J==="boolean"){E=J;J=arguments[1]||{};H=2}if(typeof J!=="object"&&!o.isFunction(J)){J={}}if(I==H){J=this;--H}for(;H<I;H++){if((G=arguments[H])!=null){for(var F in G){var K=J[F],L=G[F];if(J===L){continue}if(E&&L&&typeof L==="object"&&!L.nodeType){J[F]=o.extend(E,K||(L.length!=null?[]:{}),L)}else{if(L!==g){J[F]=L}}}}}return J};var b=/z-?index|font-?weight|opacity|zoom|line-?height/i,q=document.defaultView||{},s=Object.prototype.toString;o.extend({noConflict:function(E){l.$=p;if(E){l.jQuery=y}return o},isFunction:function(E){return s.call(E)==="[object Function]"},isArray:function(E){return s.call(E)==="[object Array]"},isXMLDoc:function(E){return E.nodeType===9&&E.documentElement.nodeName!=="HTML"||!!E.ownerDocument&&o.isXMLDoc(E.ownerDocument)},globalEval:function(G){if(G&&/\S/.test(G)){var F=document.getElementsByTagName("head")[0]||document.documentElement,E=document.createElement("script");E.type="text/javascript";if(o.support.scriptEval){E.appendChild(document.createTextNode(G))}else{E.text=G}F.insertBefore(E,F.firstChild);F.removeChild(E)}},nodeName:function(F,E){return F.nodeName&&F.nodeName.toUpperCase()==E.toUpperCase()},each:function(G,K,F){var E,H=0,I=G.length;if(F){if(I===g){for(E in G){if(K.apply(G[E],F)===false){break}}}else{for(;H<I;){if(K.apply(G[H++],F)===false){break}}}}else{if(I===g){for(E in G){if(K.call(G[E],E,G[E])===false){break}}}else{for(var J=G[0];H<I&&K.call(J,H,J)!==false;J=G[++H]){}}}return G},prop:function(H,I,G,F,E){if(o.isFunction(I)){I=I.call(H,F)}return typeof I==="number"&&G=="curCSS"&&!b.test(E)?I+"px":I},className:{add:function(E,F){o.each((F||"").split(/\s+/),function(G,H){if(E.nodeType==1&&!o.className.has(E.className,H)){E.className+=(E.className?" ":"")+H}})},remove:function(E,F){if(E.nodeType==1){E.className=F!==g?o.grep(E.className.split(/\s+/),function(G){return !o.className.has(F,G)}).join(" "):""}},has:function(F,E){return F&&o.inArray(E,(F.className||F).toString().split(/\s+/))>-1}},swap:function(H,G,I){var E={};for(var F in G){E[F]=H.style[F];H.style[F]=G[F]}I.call(H);for(var F in G){H.style[F]=E[F]}},css:function(H,F,J,E){if(F=="width"||F=="height"){var L,G={position:"absolute",visibility:"hidden",display:"block"},K=F=="width"?["Left","Right"]:["Top","Bottom"];function I(){L=F=="width"?H.offsetWidth:H.offsetHeight;if(E==="border"){return}o.each(K,function(){if(!E){L-=parseFloat(o.curCSS(H,"padding"+this,true))||0}if(E==="margin"){L+=parseFloat(o.curCSS(H,"margin"+this,true))||0}else{L-=parseFloat(o.curCSS(H,"border"+this+"Width",true))||0}})}if(H.offsetWidth!==0){I()}else{o.swap(H,G,I)}return Math.max(0,Math.round(L))}return o.curCSS(H,F,J)},curCSS:function(I,F,G){var L,E=I.style;if(F=="opacity"&&!o.support.opacity){L=o.attr(E,"opacity");return L==""?"1":L}if(F.match(/float/i)){F=w}if(!G&&E&&E[F]){L=E[F]}else{if(q.getComputedStyle){if(F.match(/float/i)){F="float"}F=F.replace(/([A-Z])/g,"-$1").toLowerCase();var M=q.getComputedStyle(I,null);if(M){L=M.getPropertyValue(F)}if(F=="opacity"&&L==""){L="1"}}else{if(I.currentStyle){var J=F.replace(/\-(\w)/g,function(N,O){return O.toUpperCase()});L=I.currentStyle[F]||I.currentStyle[J];if(!/^\d+(px)?$/i.test(L)&&/^\d/.test(L)){var H=E.left,K=I.runtimeStyle.left;I.runtimeStyle.left=I.currentStyle.left;E.left=L||0;L=E.pixelLeft+"px";E.left=H;I.runtimeStyle.left=K}}}}return L},clean:function(F,K,I){K=K||document;if(typeof K.createElement==="undefined"){K=K.ownerDocument||K[0]&&K[0].ownerDocument||document}if(!I&&F.length===1&&typeof F[0]==="string"){var H=/^<(\w+)\s*\/?>$/.exec(F[0]);if(H){return[K.createElement(H[1])]}}var G=[],E=[],L=K.createElement("div");o.each(F,function(P,S){if(typeof S==="number"){S+=""}if(!S){return}if(typeof S==="string"){S=S.replace(/(<(\w+)[^>]*?)\/>/g,function(U,V,T){return T.match(/^(abbr|br|col|img|input|link|meta|param|hr|area|embed)$/i)?U:V+"></"+T+">"});var O=S.replace(/^\s+/,"").substring(0,10).toLowerCase();var Q=!O.indexOf("<opt")&&[1,"<select multiple='multiple'>","</select>"]||!O.indexOf("<leg")&&[1,"<fieldset>","</fieldset>"]||O.match(/^<(thead|tbody|tfoot|colg|cap)/)&&[1,"<table>","</table>"]||!O.indexOf("<tr")&&[2,"<table><tbody>","</tbody></table>"]||(!O.indexOf("<td")||!O.indexOf("<th"))&&[3,"<table><tbody><tr>","</tr></tbody></table>"]||!O.indexOf("<col")&&[2,"<table><tbody></tbody><colgroup>","</colgroup></table>"]||!o.support.htmlSerialize&&[1,"div<div>","</div>"]||[0,"",""];L.innerHTML=Q[1]+S+Q[2];while(Q[0]--){L=L.lastChild}if(!o.support.tbody){var R=/<tbody/i.test(S),N=!O.indexOf("<table")&&!R?L.firstChild&&L.firstChild.childNodes:Q[1]=="<table>"&&!R?L.childNodes:[];for(var M=N.length-1;M>=0;--M){if(o.nodeName(N[M],"tbody")&&!N[M].childNodes.length){N[M].parentNode.removeChild(N[M])}}}if(!o.support.leadingWhitespace&&/^\s/.test(S)){L.insertBefore(K.createTextNode(S.match(/^\s*/)[0]),L.firstChild)}S=o.makeArray(L.childNodes)}if(S.nodeType){G.push(S)}else{G=o.merge(G,S)}});if(I){for(var J=0;G[J];J++){if(o.nodeName(G[J],"script")&&(!G[J].type||G[J].type.toLowerCase()==="text/javascript")){E.push(G[J].parentNode?G[J].parentNode.removeChild(G[J]):G[J])}else{if(G[J].nodeType===1){G.splice.apply(G,[J+1,0].concat(o.makeArray(G[J].getElementsByTagName("script"))))}I.appendChild(G[J])}}return E}return G},attr:function(J,G,K){if(!J||J.nodeType==3||J.nodeType==8){return g}var H=!o.isXMLDoc(J),L=K!==g;G=H&&o.props[G]||G;if(J.tagName){var F=/href|src|style/.test(G);if(G=="selected"&&J.parentNode){J.parentNode.selectedIndex}if(G in J&&H&&!F){if(L){if(G=="type"&&o.nodeName(J,"input")&&J.parentNode){throw"type property can't be changed"}J[G]=K}if(o.nodeName(J,"form")&&J.getAttributeNode(G)){return J.getAttributeNode(G).nodeValue}if(G=="tabIndex"){var I=J.getAttributeNode("tabIndex");return I&&I.specified?I.value:J.nodeName.match(/(button|input|object|select|textarea)/i)?0:J.nodeName.match(/^(a|area)$/i)&&J.href?0:g}return J[G]}if(!o.support.style&&H&&G=="style"){return o.attr(J.style,"cssText",K)}if(L){J.setAttribute(G,""+K)}var E=!o.support.hrefNormalized&&H&&F?J.getAttribute(G,2):J.getAttribute(G);return E===null?g:E}if(!o.support.opacity&&G=="opacity"){if(L){J.zoom=1;J.filter=(J.filter||"").replace(/alpha\([^)]*\)/,"")+(parseInt(K)+""=="NaN"?"":"alpha(opacity="+K*100+")")}return J.filter&&J.filter.indexOf("opacity=")>=0?(parseFloat(J.filter.match(/opacity=([^)]*)/)[1])/100)+"":""}G=G.replace(/-([a-z])/ig,function(M,N){return N.toUpperCase()});if(L){J[G]=K}return J[G]},trim:function(E){return(E||"").replace(/^\s+|\s+$/g,"")},makeArray:function(G){var E=[];if(G!=null){var F=G.length;if(F==null||typeof G==="string"||o.isFunction(G)||G.setInterval){E[0]=G}else{while(F){E[--F]=G[F]}}}return E},inArray:function(G,H){for(var E=0,F=H.length;E<F;E++){if(H[E]===G){return E}}return -1},merge:function(H,E){var F=0,G,I=H.length;if(!o.support.getAll){while((G=E[F++])!=null){if(G.nodeType!=8){H[I++]=G}}}else{while((G=E[F++])!=null){H[I++]=G}}return H},unique:function(K){var F=[],E={};try{for(var G=0,H=K.length;G<H;G++){var J=o.data(K[G]);if(!E[J]){E[J]=true;F.push(K[G])}}}catch(I){F=K}return F},grep:function(F,J,E){var G=[];for(var H=0,I=F.length;H<I;H++){if(!E!=!J(F[H],H)){G.push(F[H])}}return G},map:function(E,J){var F=[];for(var G=0,H=E.length;G<H;G++){var I=J(E[G],G);if(I!=null){F[F.length]=I}}return F.concat.apply([],F)}});var C=navigator.userAgent.toLowerCase();o.browser={version:(C.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/)||[0,"0"])[1],safari:/webkit/.test(C),opera:/opera/.test(C),msie:/msie/.test(C)&&!/opera/.test(C),mozilla:/mozilla/.test(C)&&!/(compatible|webkit)/.test(C)};o.each({parent:function(E){return E.parentNode},parents:function(E){return o.dir(E,"parentNode")},next:function(E){return o.nth(E,2,"nextSibling")},prev:function(E){return o.nth(E,2,"previousSibling")},nextAll:function(E){return o.dir(E,"nextSibling")},prevAll:function(E){return o.dir(E,"previousSibling")},siblings:function(E){return o.sibling(E.parentNode.firstChild,E)},children:function(E){return o.sibling(E.firstChild)},contents:function(E){return o.nodeName(E,"iframe")?E.contentDocument||E.contentWindow.document:o.makeArray(E.childNodes)}},function(E,F){o.fn[E]=function(G){var H=o.map(this,F);if(G&&typeof G=="string"){H=o.multiFilter(G,H)}return this.pushStack(o.unique(H),E,G)}});o.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(E,F){o.fn[E]=function(G){var J=[],L=o(G);for(var K=0,H=L.length;K<H;K++){var I=(K>0?this.clone(true):this).get();o.fn[F].apply(o(L[K]),I);J=J.concat(I)}return this.pushStack(J,E,G)}});o.each({removeAttr:function(E){o.attr(this,E,"");if(this.nodeType==1){this.removeAttribute(E)}},addClass:function(E){o.className.add(this,E)},removeClass:function(E){o.className.remove(this,E)},toggleClass:function(F,E){if(typeof E!=="boolean"){E=!o.className.has(this,F)}o.className[E?"add":"remove"](this,F)},remove:function(E){if(!E||o.filter(E,[this]).length){o("*",this).add([this]).each(function(){o.event.remove(this);o.removeData(this)});if(this.parentNode){this.parentNode.removeChild(this)}}},empty:function(){o(this).children().remove();while(this.firstChild){this.removeChild(this.firstChild)}}},function(E,F){o.fn[E]=function(){return this.each(F,arguments)}});function j(E,F){return E[0]&&parseInt(o.curCSS(E[0],F,true),10)||0}var h="jQuery"+e(),v=0,A={};o.extend({cache:{},data:function(F,E,G){F=F==l?A:F;var H=F[h];if(!H){H=F[h]=++v}if(E&&!o.cache[H]){o.cache[H]={}}if(G!==g){o.cache[H][E]=G}return E?o.cache[H][E]:H},removeData:function(F,E){F=F==l?A:F;var H=F[h];if(E){if(o.cache[H]){delete o.cache[H][E];E="";for(E in o.cache[H]){break}if(!E){o.removeData(F)}}}else{try{delete F[h]}catch(G){if(F.removeAttribute){F.removeAttribute(h)}}delete o.cache[H]}},queue:function(F,E,H){if(F){E=(E||"fx")+"queue";var G=o.data(F,E);if(!G||o.isArray(H)){G=o.data(F,E,o.makeArray(H))}else{if(H){G.push(H)}}}return G},dequeue:function(H,G){var E=o.queue(H,G),F=E.shift();if(!G||G==="fx"){F=E[0]}if(F!==g){F.call(H)}}});o.fn.extend({data:function(E,G){var H=E.split(".");H[1]=H[1]?"."+H[1]:"";if(G===g){var F=this.triggerHandler("getData"+H[1]+"!",[H[0]]);if(F===g&&this.length){F=o.data(this[0],E)}return F===g&&H[1]?this.data(H[0]):F}else{return this.trigger("setData"+H[1]+"!",[H[0],G]).each(function(){o.data(this,E,G)})}},removeData:function(E){return this.each(function(){o.removeData(this,E)})},queue:function(E,F){if(typeof E!=="string"){F=E;E="fx"}if(F===g){return o.queue(this[0],E)}return this.each(function(){var G=o.queue(this,E,F);if(E=="fx"&&G.length==1){G[0].call(this)}})},dequeue:function(E){return this.each(function(){o.dequeue(this,E)})}});
/*
 * Sizzle CSS Selector Engine - v0.9.3
 *  Copyright 2009, The Dojo Foundation
 *  Released under the MIT, BSD, and GPL Licenses.
 *  More information: http://sizzlejs.com/
 */
(function(){var R=/((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^[\]]*\]|['"][^'"]*['"]|[^[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?/g,L=0,H=Object.prototype.toString;var F=function(Y,U,ab,ac){ab=ab||[];U=U||document;if(U.nodeType!==1&&U.nodeType!==9){return[]}if(!Y||typeof Y!=="string"){return ab}var Z=[],W,af,ai,T,ad,V,X=true;R.lastIndex=0;while((W=R.exec(Y))!==null){Z.push(W[1]);if(W[2]){V=RegExp.rightContext;break}}if(Z.length>1&&M.exec(Y)){if(Z.length===2&&I.relative[Z[0]]){af=J(Z[0]+Z[1],U)}else{af=I.relative[Z[0]]?[U]:F(Z.shift(),U);while(Z.length){Y=Z.shift();if(I.relative[Y]){Y+=Z.shift()}af=J(Y,af)}}}else{var ae=ac?{expr:Z.pop(),set:E(ac)}:F.find(Z.pop(),Z.length===1&&U.parentNode?U.parentNode:U,Q(U));af=F.filter(ae.expr,ae.set);if(Z.length>0){ai=E(af)}else{X=false}while(Z.length){var ah=Z.pop(),ag=ah;if(!I.relative[ah]){ah=""}else{ag=Z.pop()}if(ag==null){ag=U}I.relative[ah](ai,ag,Q(U))}}if(!ai){ai=af}if(!ai){throw"Syntax error, unrecognized expression: "+(ah||Y)}if(H.call(ai)==="[object Array]"){if(!X){ab.push.apply(ab,ai)}else{if(U.nodeType===1){for(var aa=0;ai[aa]!=null;aa++){if(ai[aa]&&(ai[aa]===true||ai[aa].nodeType===1&&K(U,ai[aa]))){ab.push(af[aa])}}}else{for(var aa=0;ai[aa]!=null;aa++){if(ai[aa]&&ai[aa].nodeType===1){ab.push(af[aa])}}}}}else{E(ai,ab)}if(V){F(V,U,ab,ac);if(G){hasDuplicate=false;ab.sort(G);if(hasDuplicate){for(var aa=1;aa<ab.length;aa++){if(ab[aa]===ab[aa-1]){ab.splice(aa--,1)}}}}}return ab};F.matches=function(T,U){return F(T,null,null,U)};F.find=function(aa,T,ab){var Z,X;if(!aa){return[]}for(var W=0,V=I.order.length;W<V;W++){var Y=I.order[W],X;if((X=I.match[Y].exec(aa))){var U=RegExp.leftContext;if(U.substr(U.length-1)!=="\\"){X[1]=(X[1]||"").replace(/\\/g,"");Z=I.find[Y](X,T,ab);if(Z!=null){aa=aa.replace(I.match[Y],"");break}}}}if(!Z){Z=T.getElementsByTagName("*")}return{set:Z,expr:aa}};F.filter=function(ad,ac,ag,W){var V=ad,ai=[],aa=ac,Y,T,Z=ac&&ac[0]&&Q(ac[0]);while(ad&&ac.length){for(var ab in I.filter){if((Y=I.match[ab].exec(ad))!=null){var U=I.filter[ab],ah,af;T=false;if(aa==ai){ai=[]}if(I.preFilter[ab]){Y=I.preFilter[ab](Y,aa,ag,ai,W,Z);if(!Y){T=ah=true}else{if(Y===true){continue}}}if(Y){for(var X=0;(af=aa[X])!=null;X++){if(af){ah=U(af,Y,X,aa);var ae=W^!!ah;if(ag&&ah!=null){if(ae){T=true}else{aa[X]=false}}else{if(ae){ai.push(af);T=true}}}}}if(ah!==g){if(!ag){aa=ai}ad=ad.replace(I.match[ab],"");if(!T){return[]}break}}}if(ad==V){if(T==null){throw"Syntax error, unrecognized expression: "+ad}else{break}}V=ad}return aa};var I=F.selectors={order:["ID","NAME","TAG"],match:{ID:/#((?:[\w\u00c0-\uFFFF_-]|\\.)+)/,CLASS:/\.((?:[\w\u00c0-\uFFFF_-]|\\.)+)/,NAME:/\[name=['"]*((?:[\w\u00c0-\uFFFF_-]|\\.)+)['"]*\]/,ATTR:/\[\s*((?:[\w\u00c0-\uFFFF_-]|\\.)+)\s*(?:(\S?=)\s*(['"]*)(.*?)\3|)\s*\]/,TAG:/^((?:[\w\u00c0-\uFFFF\*_-]|\\.)+)/,CHILD:/:(only|nth|last|first)-child(?:\((even|odd|[\dn+-]*)\))?/,POS:/:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^-]|$)/,PSEUDO:/:((?:[\w\u00c0-\uFFFF_-]|\\.)+)(?:\((['"]*)((?:\([^\)]+\)|[^\2\(\)]*)+)\2\))?/},attrMap:{"class":"className","for":"htmlFor"},attrHandle:{href:function(T){return T.getAttribute("href")}},relative:{"+":function(aa,T,Z){var X=typeof T==="string",ab=X&&!/\W/.test(T),Y=X&&!ab;if(ab&&!Z){T=T.toUpperCase()}for(var W=0,V=aa.length,U;W<V;W++){if((U=aa[W])){while((U=U.previousSibling)&&U.nodeType!==1){}aa[W]=Y||U&&U.nodeName===T?U||false:U===T}}if(Y){F.filter(T,aa,true)}},">":function(Z,U,aa){var X=typeof U==="string";if(X&&!/\W/.test(U)){U=aa?U:U.toUpperCase();for(var V=0,T=Z.length;V<T;V++){var Y=Z[V];if(Y){var W=Y.parentNode;Z[V]=W.nodeName===U?W:false}}}else{for(var V=0,T=Z.length;V<T;V++){var Y=Z[V];if(Y){Z[V]=X?Y.parentNode:Y.parentNode===U}}if(X){F.filter(U,Z,true)}}},"":function(W,U,Y){var V=L++,T=S;if(!U.match(/\W/)){var X=U=Y?U:U.toUpperCase();T=P}T("parentNode",U,V,W,X,Y)},"~":function(W,U,Y){var V=L++,T=S;if(typeof U==="string"&&!U.match(/\W/)){var X=U=Y?U:U.toUpperCase();T=P}T("previousSibling",U,V,W,X,Y)}},find:{ID:function(U,V,W){if(typeof V.getElementById!=="undefined"&&!W){var T=V.getElementById(U[1]);return T?[T]:[]}},NAME:function(V,Y,Z){if(typeof Y.getElementsByName!=="undefined"){var U=[],X=Y.getElementsByName(V[1]);for(var W=0,T=X.length;W<T;W++){if(X[W].getAttribute("name")===V[1]){U.push(X[W])}}return U.length===0?null:U}},TAG:function(T,U){return U.getElementsByTagName(T[1])}},preFilter:{CLASS:function(W,U,V,T,Z,aa){W=" "+W[1].replace(/\\/g,"")+" ";if(aa){return W}for(var X=0,Y;(Y=U[X])!=null;X++){if(Y){if(Z^(Y.className&&(" "+Y.className+" ").indexOf(W)>=0)){if(!V){T.push(Y)}}else{if(V){U[X]=false}}}}return false},ID:function(T){return T[1].replace(/\\/g,"")},TAG:function(U,T){for(var V=0;T[V]===false;V++){}return T[V]&&Q(T[V])?U[1]:U[1].toUpperCase()},CHILD:function(T){if(T[1]=="nth"){var U=/(-?)(\d*)n((?:\+|-)?\d*)/.exec(T[2]=="even"&&"2n"||T[2]=="odd"&&"2n+1"||!/\D/.test(T[2])&&"0n+"+T[2]||T[2]);T[2]=(U[1]+(U[2]||1))-0;T[3]=U[3]-0}T[0]=L++;return T},ATTR:function(X,U,V,T,Y,Z){var W=X[1].replace(/\\/g,"");if(!Z&&I.attrMap[W]){X[1]=I.attrMap[W]}if(X[2]==="~="){X[4]=" "+X[4]+" "}return X},PSEUDO:function(X,U,V,T,Y){if(X[1]==="not"){if(X[3].match(R).length>1||/^\w/.test(X[3])){X[3]=F(X[3],null,null,U)}else{var W=F.filter(X[3],U,V,true^Y);if(!V){T.push.apply(T,W)}return false}}else{if(I.match.POS.test(X[0])||I.match.CHILD.test(X[0])){return true}}return X},POS:function(T){T.unshift(true);return T}},filters:{enabled:function(T){return T.disabled===false&&T.type!=="hidden"},disabled:function(T){return T.disabled===true},checked:function(T){return T.checked===true},selected:function(T){T.parentNode.selectedIndex;return T.selected===true},parent:function(T){return !!T.firstChild},empty:function(T){return !T.firstChild},has:function(V,U,T){return !!F(T[3],V).length},header:function(T){return/h\d/i.test(T.nodeName)},text:function(T){return"text"===T.type},radio:function(T){return"radio"===T.type},checkbox:function(T){return"checkbox"===T.type},file:function(T){return"file"===T.type},password:function(T){return"password"===T.type},submit:function(T){return"submit"===T.type},image:function(T){return"image"===T.type},reset:function(T){return"reset"===T.type},button:function(T){return"button"===T.type||T.nodeName.toUpperCase()==="BUTTON"},input:function(T){return/input|select|textarea|button/i.test(T.nodeName)}},setFilters:{first:function(U,T){return T===0},last:function(V,U,T,W){return U===W.length-1},even:function(U,T){return T%2===0},odd:function(U,T){return T%2===1},lt:function(V,U,T){return U<T[3]-0},gt:function(V,U,T){return U>T[3]-0},nth:function(V,U,T){return T[3]-0==U},eq:function(V,U,T){return T[3]-0==U}},filter:{PSEUDO:function(Z,V,W,aa){var U=V[1],X=I.filters[U];if(X){return X(Z,W,V,aa)}else{if(U==="contains"){return(Z.textContent||Z.innerText||"").indexOf(V[3])>=0}else{if(U==="not"){var Y=V[3];for(var W=0,T=Y.length;W<T;W++){if(Y[W]===Z){return false}}return true}}}},CHILD:function(T,W){var Z=W[1],U=T;switch(Z){case"only":case"first":while(U=U.previousSibling){if(U.nodeType===1){return false}}if(Z=="first"){return true}U=T;case"last":while(U=U.nextSibling){if(U.nodeType===1){return false}}return true;case"nth":var V=W[2],ac=W[3];if(V==1&&ac==0){return true}var Y=W[0],ab=T.parentNode;if(ab&&(ab.sizcache!==Y||!T.nodeIndex)){var X=0;for(U=ab.firstChild;U;U=U.nextSibling){if(U.nodeType===1){U.nodeIndex=++X}}ab.sizcache=Y}var aa=T.nodeIndex-ac;if(V==0){return aa==0}else{return(aa%V==0&&aa/V>=0)}}},ID:function(U,T){return U.nodeType===1&&U.getAttribute("id")===T},TAG:function(U,T){return(T==="*"&&U.nodeType===1)||U.nodeName===T},CLASS:function(U,T){return(" "+(U.className||U.getAttribute("class"))+" ").indexOf(T)>-1},ATTR:function(Y,W){var V=W[1],T=I.attrHandle[V]?I.attrHandle[V](Y):Y[V]!=null?Y[V]:Y.getAttribute(V),Z=T+"",X=W[2],U=W[4];return T==null?X==="!=":X==="="?Z===U:X==="*="?Z.indexOf(U)>=0:X==="~="?(" "+Z+" ").indexOf(U)>=0:!U?Z&&T!==false:X==="!="?Z!=U:X==="^="?Z.indexOf(U)===0:X==="$="?Z.substr(Z.length-U.length)===U:X==="|="?Z===U||Z.substr(0,U.length+1)===U+"-":false},POS:function(X,U,V,Y){var T=U[2],W=I.setFilters[T];if(W){return W(X,V,U,Y)}}}};var M=I.match.POS;for(var O in I.match){I.match[O]=RegExp(I.match[O].source+/(?![^\[]*\])(?![^\(]*\))/.source)}var E=function(U,T){U=Array.prototype.slice.call(U);if(T){T.push.apply(T,U);return T}return U};try{Array.prototype.slice.call(document.documentElement.childNodes)}catch(N){E=function(X,W){var U=W||[];if(H.call(X)==="[object Array]"){Array.prototype.push.apply(U,X)}else{if(typeof X.length==="number"){for(var V=0,T=X.length;V<T;V++){U.push(X[V])}}else{for(var V=0;X[V];V++){U.push(X[V])}}}return U}}var G;if(document.documentElement.compareDocumentPosition){G=function(U,T){var V=U.compareDocumentPosition(T)&4?-1:U===T?0:1;if(V===0){hasDuplicate=true}return V}}else{if("sourceIndex" in document.documentElement){G=function(U,T){var V=U.sourceIndex-T.sourceIndex;if(V===0){hasDuplicate=true}return V}}else{if(document.createRange){G=function(W,U){var V=W.ownerDocument.createRange(),T=U.ownerDocument.createRange();V.selectNode(W);V.collapse(true);T.selectNode(U);T.collapse(true);var X=V.compareBoundaryPoints(Range.START_TO_END,T);if(X===0){hasDuplicate=true}return X}}}}(function(){var U=document.createElement("form"),V="script"+(new Date).getTime();U.innerHTML="<input name='"+V+"'/>";var T=document.documentElement;T.insertBefore(U,T.firstChild);if(!!document.getElementById(V)){I.find.ID=function(X,Y,Z){if(typeof Y.getElementById!=="undefined"&&!Z){var W=Y.getElementById(X[1]);return W?W.id===X[1]||typeof W.getAttributeNode!=="undefined"&&W.getAttributeNode("id").nodeValue===X[1]?[W]:g:[]}};I.filter.ID=function(Y,W){var X=typeof Y.getAttributeNode!=="undefined"&&Y.getAttributeNode("id");return Y.nodeType===1&&X&&X.nodeValue===W}}T.removeChild(U)})();(function(){var T=document.createElement("div");T.appendChild(document.createComment(""));if(T.getElementsByTagName("*").length>0){I.find.TAG=function(U,Y){var X=Y.getElementsByTagName(U[1]);if(U[1]==="*"){var W=[];for(var V=0;X[V];V++){if(X[V].nodeType===1){W.push(X[V])}}X=W}return X}}T.innerHTML="<a href='#'></a>";if(T.firstChild&&typeof T.firstChild.getAttribute!=="undefined"&&T.firstChild.getAttribute("href")!=="#"){I.attrHandle.href=function(U){return U.getAttribute("href",2)}}})();if(document.querySelectorAll){(function(){var T=F,U=document.createElement("div");U.innerHTML="<p class='TEST'></p>";if(U.querySelectorAll&&U.querySelectorAll(".TEST").length===0){return}F=function(Y,X,V,W){X=X||document;if(!W&&X.nodeType===9&&!Q(X)){try{return E(X.querySelectorAll(Y),V)}catch(Z){}}return T(Y,X,V,W)};F.find=T.find;F.filter=T.filter;F.selectors=T.selectors;F.matches=T.matches})()}if(document.getElementsByClassName&&document.documentElement.getElementsByClassName){(function(){var T=document.createElement("div");T.innerHTML="<div class='test e'></div><div class='test'></div>";if(T.getElementsByClassName("e").length===0){return}T.lastChild.className="e";if(T.getElementsByClassName("e").length===1){return}I.order.splice(1,0,"CLASS");I.find.CLASS=function(U,V,W){if(typeof V.getElementsByClassName!=="undefined"&&!W){return V.getElementsByClassName(U[1])}}})()}function P(U,Z,Y,ad,aa,ac){var ab=U=="previousSibling"&&!ac;for(var W=0,V=ad.length;W<V;W++){var T=ad[W];if(T){if(ab&&T.nodeType===1){T.sizcache=Y;T.sizset=W}T=T[U];var X=false;while(T){if(T.sizcache===Y){X=ad[T.sizset];break}if(T.nodeType===1&&!ac){T.sizcache=Y;T.sizset=W}if(T.nodeName===Z){X=T;break}T=T[U]}ad[W]=X}}}function S(U,Z,Y,ad,aa,ac){var ab=U=="previousSibling"&&!ac;for(var W=0,V=ad.length;W<V;W++){var T=ad[W];if(T){if(ab&&T.nodeType===1){T.sizcache=Y;T.sizset=W}T=T[U];var X=false;while(T){if(T.sizcache===Y){X=ad[T.sizset];break}if(T.nodeType===1){if(!ac){T.sizcache=Y;T.sizset=W}if(typeof Z!=="string"){if(T===Z){X=true;break}}else{if(F.filter(Z,[T]).length>0){X=T;break}}}T=T[U]}ad[W]=X}}}var K=document.compareDocumentPosition?function(U,T){return U.compareDocumentPosition(T)&16}:function(U,T){return U!==T&&(U.contains?U.contains(T):true)};var Q=function(T){return T.nodeType===9&&T.documentElement.nodeName!=="HTML"||!!T.ownerDocument&&Q(T.ownerDocument)};var J=function(T,aa){var W=[],X="",Y,V=aa.nodeType?[aa]:aa;while((Y=I.match.PSEUDO.exec(T))){X+=Y[0];T=T.replace(I.match.PSEUDO,"")}T=I.relative[T]?T+"*":T;for(var Z=0,U=V.length;Z<U;Z++){F(T,V[Z],W)}return F.filter(X,W)};o.find=F;o.filter=F.filter;o.expr=F.selectors;o.expr[":"]=o.expr.filters;F.selectors.filters.hidden=function(T){return T.offsetWidth===0||T.offsetHeight===0};F.selectors.filters.visible=function(T){return T.offsetWidth>0||T.offsetHeight>0};F.selectors.filters.animated=function(T){return o.grep(o.timers,function(U){return T===U.elem}).length};o.multiFilter=function(V,T,U){if(U){V=":not("+V+")"}return F.matches(V,T)};o.dir=function(V,U){var T=[],W=V[U];while(W&&W!=document){if(W.nodeType==1){T.push(W)}W=W[U]}return T};o.nth=function(X,T,V,W){T=T||1;var U=0;for(;X;X=X[V]){if(X.nodeType==1&&++U==T){break}}return X};o.sibling=function(V,U){var T=[];for(;V;V=V.nextSibling){if(V.nodeType==1&&V!=U){T.push(V)}}return T};return;l.Sizzle=F})();o.event={add:function(I,F,H,K){if(I.nodeType==3||I.nodeType==8){return}if(I.setInterval&&I!=l){I=l}if(!H.guid){H.guid=this.guid++}if(K!==g){var G=H;H=this.proxy(G);H.data=K}var E=o.data(I,"events")||o.data(I,"events",{}),J=o.data(I,"handle")||o.data(I,"handle",function(){return typeof o!=="undefined"&&!o.event.triggered?o.event.handle.apply(arguments.callee.elem,arguments):g});J.elem=I;o.each(F.split(/\s+/),function(M,N){var O=N.split(".");N=O.shift();H.type=O.slice().sort().join(".");var L=E[N];if(o.event.specialAll[N]){o.event.specialAll[N].setup.call(I,K,O)}if(!L){L=E[N]={};if(!o.event.special[N]||o.event.special[N].setup.call(I,K,O)===false){if(I.addEventListener){I.addEventListener(N,J,false)}else{if(I.attachEvent){I.attachEvent("on"+N,J)}}}}L[H.guid]=H;o.event.global[N]=true});I=null},guid:1,global:{},remove:function(K,H,J){if(K.nodeType==3||K.nodeType==8){return}var G=o.data(K,"events"),F,E;if(G){if(H===g||(typeof H==="string"&&H.charAt(0)==".")){for(var I in G){this.remove(K,I+(H||""))}}else{if(H.type){J=H.handler;H=H.type}o.each(H.split(/\s+/),function(M,O){var Q=O.split(".");O=Q.shift();var N=RegExp("(^|\\.)"+Q.slice().sort().join(".*\\.")+"(\\.|$)");if(G[O]){if(J){delete G[O][J.guid]}else{for(var P in G[O]){if(N.test(G[O][P].type)){delete G[O][P]}}}if(o.event.specialAll[O]){o.event.specialAll[O].teardown.call(K,Q)}for(F in G[O]){break}if(!F){if(!o.event.special[O]||o.event.special[O].teardown.call(K,Q)===false){if(K.removeEventListener){K.removeEventListener(O,o.data(K,"handle"),false)}else{if(K.detachEvent){K.detachEvent("on"+O,o.data(K,"handle"))}}}F=null;delete G[O]}}})}for(F in G){break}if(!F){var L=o.data(K,"handle");if(L){L.elem=null}o.removeData(K,"events");o.removeData(K,"handle")}}},trigger:function(I,K,H,E){var G=I.type||I;if(!E){I=typeof I==="object"?I[h]?I:o.extend(o.Event(G),I):o.Event(G);if(G.indexOf("!")>=0){I.type=G=G.slice(0,-1);I.exclusive=true}if(!H){I.stopPropagation();if(this.global[G]){o.each(o.cache,function(){if(this.events&&this.events[G]){o.event.trigger(I,K,this.handle.elem)}})}}if(!H||H.nodeType==3||H.nodeType==8){return g}I.result=g;I.target=H;K=o.makeArray(K);K.unshift(I)}I.currentTarget=H;var J=o.data(H,"handle");if(J){J.apply(H,K)}if((!H[G]||(o.nodeName(H,"a")&&G=="click"))&&H["on"+G]&&H["on"+G].apply(H,K)===false){I.result=false}if(!E&&H[G]&&!I.isDefaultPrevented()&&!(o.nodeName(H,"a")&&G=="click")){this.triggered=true;try{H[G]()}catch(L){}}this.triggered=false;if(!I.isPropagationStopped()){var F=H.parentNode||H.ownerDocument;if(F){o.event.trigger(I,K,F,true)}}},handle:function(K){var J,E;K=arguments[0]=o.event.fix(K||l.event);K.currentTarget=this;var L=K.type.split(".");K.type=L.shift();J=!L.length&&!K.exclusive;var I=RegExp("(^|\\.)"+L.slice().sort().join(".*\\.")+"(\\.|$)");E=(o.data(this,"events")||{})[K.type];for(var G in E){var H=E[G];if(J||I.test(H.type)){K.handler=H;K.data=H.data;var F=H.apply(this,arguments);if(F!==g){K.result=F;if(F===false){K.preventDefault();K.stopPropagation()}}if(K.isImmediatePropagationStopped()){break}}}},props:"altKey attrChange attrName bubbles button cancelable charCode clientX clientY ctrlKey currentTarget data detail eventPhase fromElement handler keyCode metaKey newValue originalTarget pageX pageY prevValue relatedNode relatedTarget screenX screenY shiftKey srcElement target toElement view wheelDelta which".split(" "),fix:function(H){if(H[h]){return H}var F=H;H=o.Event(F);for(var G=this.props.length,J;G;){J=this.props[--G];H[J]=F[J]}if(!H.target){H.target=H.srcElement||document}if(H.target.nodeType==3){H.target=H.target.parentNode}if(!H.relatedTarget&&H.fromElement){H.relatedTarget=H.fromElement==H.target?H.toElement:H.fromElement}if(H.pageX==null&&H.clientX!=null){var I=document.documentElement,E=document.body;H.pageX=H.clientX+(I&&I.scrollLeft||E&&E.scrollLeft||0)-(I.clientLeft||0);H.pageY=H.clientY+(I&&I.scrollTop||E&&E.scrollTop||0)-(I.clientTop||0)}if(!H.which&&((H.charCode||H.charCode===0)?H.charCode:H.keyCode)){H.which=H.charCode||H.keyCode}if(!H.metaKey&&H.ctrlKey){H.metaKey=H.ctrlKey}if(!H.which&&H.button){H.which=(H.button&1?1:(H.button&2?3:(H.button&4?2:0)))}return H},proxy:function(F,E){E=E||function(){return F.apply(this,arguments)};E.guid=F.guid=F.guid||E.guid||this.guid++;return E},special:{ready:{setup:B,teardown:function(){}}},specialAll:{live:{setup:function(E,F){o.event.add(this,F[0],c)},teardown:function(G){if(G.length){var E=0,F=RegExp("(^|\\.)"+G[0]+"(\\.|$)");o.each((o.data(this,"events").live||{}),function(){if(F.test(this.type)){E++}});if(E<1){o.event.remove(this,G[0],c)}}}}}};o.Event=function(E){if(!this.preventDefault){return new o.Event(E)}if(E&&E.type){this.originalEvent=E;this.type=E.type}else{this.type=E}this.timeStamp=e();this[h]=true};function k(){return false}function u(){return true}o.Event.prototype={preventDefault:function(){this.isDefaultPrevented=u;var E=this.originalEvent;if(!E){return}if(E.preventDefault){E.preventDefault()}E.returnValue=false},stopPropagation:function(){this.isPropagationStopped=u;var E=this.originalEvent;if(!E){return}if(E.stopPropagation){E.stopPropagation()}E.cancelBubble=true},stopImmediatePropagation:function(){this.isImmediatePropagationStopped=u;this.stopPropagation()},isDefaultPrevented:k,isPropagationStopped:k,isImmediatePropagationStopped:k};var a=function(F){var E=F.relatedTarget;while(E&&E!=this){try{E=E.parentNode}catch(G){E=this}}if(E!=this){F.type=F.data;o.event.handle.apply(this,arguments)}};o.each({mouseover:"mouseenter",mouseout:"mouseleave"},function(F,E){o.event.special[E]={setup:function(){o.event.add(this,F,a,E)},teardown:function(){o.event.remove(this,F,a)}}});o.fn.extend({bind:function(F,G,E){return F=="unload"?this.one(F,G,E):this.each(function(){o.event.add(this,F,E||G,E&&G)})},one:function(G,H,F){var E=o.event.proxy(F||H,function(I){o(this).unbind(I,E);return(F||H).apply(this,arguments)});return this.each(function(){o.event.add(this,G,E,F&&H)})},unbind:function(F,E){return this.each(function(){o.event.remove(this,F,E)})},trigger:function(E,F){return this.each(function(){o.event.trigger(E,F,this)})},triggerHandler:function(E,G){if(this[0]){var F=o.Event(E);F.preventDefault();F.stopPropagation();o.event.trigger(F,G,this[0]);return F.result}},toggle:function(G){var E=arguments,F=1;while(F<E.length){o.event.proxy(G,E[F++])}return this.click(o.event.proxy(G,function(H){this.lastToggle=(this.lastToggle||0)%F;H.preventDefault();return E[this.lastToggle++].apply(this,arguments)||false}))},hover:function(E,F){return this.mouseenter(E).mouseleave(F)},ready:function(E){B();if(o.isReady){E.call(document,o)}else{o.readyList.push(E)}return this},live:function(G,F){var E=o.event.proxy(F);E.guid+=this.selector+G;o(document).bind(i(G,this.selector),this.selector,E);return this},die:function(F,E){o(document).unbind(i(F,this.selector),E?{guid:E.guid+this.selector+F}:null);return this}});function c(H){var E=RegExp("(^|\\.)"+H.type+"(\\.|$)"),G=true,F=[];o.each(o.data(this,"events").live||[],function(I,J){if(E.test(J.type)){var K=o(H.target).closest(J.data)[0];if(K){F.push({elem:K,fn:J})}}});F.sort(function(J,I){return o.data(J.elem,"closest")-o.data(I.elem,"closest")});o.each(F,function(){if(this.fn.call(this.elem,H,this.fn.data)===false){return(G=false)}});return G}function i(F,E){return["live",F,E.replace(/\./g,"`").replace(/ /g,"|")].join(".")}o.extend({isReady:false,readyList:[],ready:function(){if(!o.isReady){o.isReady=true;if(o.readyList){o.each(o.readyList,function(){this.call(document,o)});o.readyList=null}o(document).triggerHandler("ready")}}});var x=false;function B(){if(x){return}x=true;if(document.addEventListener){document.addEventListener("DOMContentLoaded",function(){document.removeEventListener("DOMContentLoaded",arguments.callee,false);o.ready()},false)}else{if(document.attachEvent){document.attachEvent("onreadystatechange",function(){if(document.readyState==="complete"){document.detachEvent("onreadystatechange",arguments.callee);o.ready()}});if(document.documentElement.doScroll&&l==l.top){(function(){if(o.isReady){return}try{document.documentElement.doScroll("left")}catch(E){setTimeout(arguments.callee,0);return}o.ready()})()}}}o.event.add(l,"load",o.ready)}o.each(("blur,focus,load,resize,scroll,unload,click,dblclick,mousedown,mouseup,mousemove,mouseover,mouseout,mouseenter,mouseleave,change,select,submit,keydown,keypress,keyup,error").split(","),function(F,E){o.fn[E]=function(G){return G?this.bind(E,G):this.trigger(E)}});o(l).bind("unload",function(){for(var E in o.cache){if(E!=1&&o.cache[E].handle){o.event.remove(o.cache[E].handle.elem)}}});(function(){o.support={};var F=document.documentElement,G=document.createElement("script"),K=document.createElement("div"),J="script"+(new Date).getTime();K.style.display="none";K.innerHTML='   <link/><table></table><a href="/a" style="color:red;float:left;opacity:.5;">a</a><select><option>text</option></select><object><param/></object>';var H=K.getElementsByTagName("*"),E=K.getElementsByTagName("a")[0];if(!H||!H.length||!E){return}o.support={leadingWhitespace:K.firstChild.nodeType==3,tbody:!K.getElementsByTagName("tbody").length,objectAll:!!K.getElementsByTagName("object")[0].getElementsByTagName("*").length,htmlSerialize:!!K.getElementsByTagName("link").length,style:/red/.test(E.getAttribute("style")),hrefNormalized:E.getAttribute("href")==="/a",opacity:E.style.opacity==="0.5",cssFloat:!!E.style.cssFloat,scriptEval:false,noCloneEvent:true,boxModel:null};G.type="text/javascript";try{G.appendChild(document.createTextNode("window."+J+"=1;"))}catch(I){}F.insertBefore(G,F.firstChild);if(l[J]){o.support.scriptEval=true;delete l[J]}F.removeChild(G);if(K.attachEvent&&K.fireEvent){K.attachEvent("onclick",function(){o.support.noCloneEvent=false;K.detachEvent("onclick",arguments.callee)});K.cloneNode(true).fireEvent("onclick")}o(function(){var L=document.createElement("div");L.style.width=L.style.paddingLeft="1px";document.body.appendChild(L);o.boxModel=o.support.boxModel=L.offsetWidth===2;document.body.removeChild(L).style.display="none"})})();var w=o.support.cssFloat?"cssFloat":"styleFloat";o.props={"for":"htmlFor","class":"className","float":w,cssFloat:w,styleFloat:w,readonly:"readOnly",maxlength:"maxLength",cellspacing:"cellSpacing",rowspan:"rowSpan",tabindex:"tabIndex"};o.fn.extend({_load:o.fn.load,load:function(G,J,K){if(typeof G!=="string"){return this._load(G)}var I=G.indexOf(" ");if(I>=0){var E=G.slice(I,G.length);G=G.slice(0,I)}var H="GET";if(J){if(o.isFunction(J)){K=J;J=null}else{if(typeof J==="object"){J=o.param(J);H="POST"}}}var F=this;o.ajax({url:G,type:H,dataType:"html",data:J,complete:function(M,L){if(L=="success"||L=="notmodified"){F.html(E?o("<div/>").append(M.responseText.replace(/<script(.|\s)*?\/script>/g,"")).find(E):M.responseText)}if(K){F.each(K,[M.responseText,L,M])}}});return this},serialize:function(){return o.param(this.serializeArray())},serializeArray:function(){return this.map(function(){return this.elements?o.makeArray(this.elements):this}).filter(function(){return this.name&&!this.disabled&&(this.checked||/select|textarea/i.test(this.nodeName)||/text|hidden|password|search/i.test(this.type))}).map(function(E,F){var G=o(this).val();return G==null?null:o.isArray(G)?o.map(G,function(I,H){return{name:F.name,value:I}}):{name:F.name,value:G}}).get()}});o.each("ajaxStart,ajaxStop,ajaxComplete,ajaxError,ajaxSuccess,ajaxSend".split(","),function(E,F){o.fn[F]=function(G){return this.bind(F,G)}});var r=e();o.extend({get:function(E,G,H,F){if(o.isFunction(G)){H=G;G=null}return o.ajax({type:"GET",url:E,data:G,success:H,dataType:F})},getScript:function(E,F){return o.get(E,null,F,"script")},getJSON:function(E,F,G){return o.get(E,F,G,"json")},post:function(E,G,H,F){if(o.isFunction(G)){H=G;G={}}return o.ajax({type:"POST",url:E,data:G,success:H,dataType:F})},ajaxSetup:function(E){o.extend(o.ajaxSettings,E)},ajaxSettings:{url:location.href,global:true,type:"GET",contentType:"application/x-www-form-urlencoded",processData:true,async:true,xhr:function(){return l.ActiveXObject?new ActiveXObject("Microsoft.XMLHTTP"):new XMLHttpRequest()},accepts:{xml:"application/xml, text/xml",html:"text/html",script:"text/javascript, application/javascript",json:"application/json, text/javascript",text:"text/plain",_default:"*/*"}},lastModified:{},ajax:function(M){M=o.extend(true,M,o.extend(true,{},o.ajaxSettings,M));var W,F=/=\?(&|$)/g,R,V,G=M.type.toUpperCase();if(M.data&&M.processData&&typeof M.data!=="string"){M.data=o.param(M.data)}if(M.dataType=="jsonp"){if(G=="GET"){if(!M.url.match(F)){M.url+=(M.url.match(/\?/)?"&":"?")+(M.jsonp||"callback")+"=?"}}else{if(!M.data||!M.data.match(F)){M.data=(M.data?M.data+"&":"")+(M.jsonp||"callback")+"=?"}}M.dataType="json"}if(M.dataType=="json"&&(M.data&&M.data.match(F)||M.url.match(F))){W="jsonp"+r++;if(M.data){M.data=(M.data+"").replace(F,"="+W+"$1")}M.url=M.url.replace(F,"="+W+"$1");M.dataType="script";l[W]=function(X){V=X;I();L();l[W]=g;try{delete l[W]}catch(Y){}if(H){H.removeChild(T)}}}if(M.dataType=="script"&&M.cache==null){M.cache=false}if(M.cache===false&&G=="GET"){var E=e();var U=M.url.replace(/(\?|&)_=.*?(&|$)/,"$1_="+E+"$2");M.url=U+((U==M.url)?(M.url.match(/\?/)?"&":"?")+"_="+E:"")}if(M.data&&G=="GET"){M.url+=(M.url.match(/\?/)?"&":"?")+M.data;M.data=null}if(M.global&&!o.active++){o.event.trigger("ajaxStart")}var Q=/^(\w+:)?\/\/([^\/?#]+)/.exec(M.url);if(M.dataType=="script"&&G=="GET"&&Q&&(Q[1]&&Q[1]!=location.protocol||Q[2]!=location.host)){var H=document.getElementsByTagName("head")[0];var T=document.createElement("script");T.src=M.url;if(M.scriptCharset){T.charset=M.scriptCharset}if(!W){var O=false;T.onload=T.onreadystatechange=function(){if(!O&&(!this.readyState||this.readyState=="loaded"||this.readyState=="complete")){O=true;I();L();T.onload=T.onreadystatechange=null;H.removeChild(T)}}}H.appendChild(T);return g}var K=false;var J=M.xhr();if(M.username){J.open(G,M.url,M.async,M.username,M.password)}else{J.open(G,M.url,M.async)}try{if(M.data){J.setRequestHeader("Content-Type",M.contentType)}if(M.ifModified){J.setRequestHeader("If-Modified-Since",o.lastModified[M.url]||"Thu, 01 Jan 1970 00:00:00 GMT")}J.setRequestHeader("X-Requested-With","XMLHttpRequest");J.setRequestHeader("Accept",M.dataType&&M.accepts[M.dataType]?M.accepts[M.dataType]+", */*":M.accepts._default)}catch(S){}if(M.beforeSend&&M.beforeSend(J,M)===false){if(M.global&&!--o.active){o.event.trigger("ajaxStop")}J.abort();return false}if(M.global){o.event.trigger("ajaxSend",[J,M])}var N=function(X){if(J.readyState==0){if(P){clearInterval(P);P=null;if(M.global&&!--o.active){o.event.trigger("ajaxStop")}}}else{if(!K&&J&&(J.readyState==4||X=="timeout")){K=true;if(P){clearInterval(P);P=null}R=X=="timeout"?"timeout":!o.httpSuccess(J)?"error":M.ifModified&&o.httpNotModified(J,M.url)?"notmodified":"success";if(R=="success"){try{V=o.httpData(J,M.dataType,M)}catch(Z){R="parsererror"}}if(R=="success"){var Y;try{Y=J.getResponseHeader("Last-Modified")}catch(Z){}if(M.ifModified&&Y){o.lastModified[M.url]=Y}if(!W){I()}}else{o.handleError(M,J,R)}L();if(X){J.abort()}if(M.async){J=null}}}};if(M.async){var P=setInterval(N,13);if(M.timeout>0){setTimeout(function(){if(J&&!K){N("timeout")}},M.timeout)}}try{J.send(M.data)}catch(S){o.handleError(M,J,null,S)}if(!M.async){N()}function I(){if(M.success){M.success(V,R)}if(M.global){o.event.trigger("ajaxSuccess",[J,M])}}function L(){if(M.complete){M.complete(J,R)}if(M.global){o.event.trigger("ajaxComplete",[J,M])}if(M.global&&!--o.active){o.event.trigger("ajaxStop")}}return J},handleError:function(F,H,E,G){if(F.error){F.error(H,E,G)}if(F.global){o.event.trigger("ajaxError",[H,F,G])}},active:0,httpSuccess:function(F){try{return !F.status&&location.protocol=="file:"||(F.status>=200&&F.status<300)||F.status==304||F.status==1223}catch(E){}return false},httpNotModified:function(G,E){try{var H=G.getResponseHeader("Last-Modified");return G.status==304||H==o.lastModified[E]}catch(F){}return false},httpData:function(J,H,G){var F=J.getResponseHeader("content-type"),E=H=="xml"||!H&&F&&F.indexOf("xml")>=0,I=E?J.responseXML:J.responseText;if(E&&I.documentElement.tagName=="parsererror"){throw"parsererror"}if(G&&G.dataFilter){I=G.dataFilter(I,H)}if(typeof I==="string"){if(H=="script"){o.globalEval(I)}if(H=="json"){I=l["eval"]("("+I+")")}}return I},param:function(E){var G=[];function H(I,J){G[G.length]=encodeURIComponent(I)+"="+encodeURIComponent(J)}if(o.isArray(E)||E.jquery){o.each(E,function(){H(this.name,this.value)})}else{for(var F in E){if(o.isArray(E[F])){o.each(E[F],function(){H(F,this)})}else{H(F,o.isFunction(E[F])?E[F]():E[F])}}}return G.join("&").replace(/%20/g,"+")}});var m={},n,d=[["height","marginTop","marginBottom","paddingTop","paddingBottom"],["width","marginLeft","marginRight","paddingLeft","paddingRight"],["opacity"]];function t(F,E){var G={};o.each(d.concat.apply([],d.slice(0,E)),function(){G[this]=F});return G}o.fn.extend({show:function(J,L){if(J){return this.animate(t("show",3),J,L)}else{for(var H=0,F=this.length;H<F;H++){var E=o.data(this[H],"olddisplay");this[H].style.display=E||"";if(o.css(this[H],"display")==="none"){var G=this[H].tagName,K;if(m[G]){K=m[G]}else{var I=o("<"+G+" />").appendTo("body");K=I.css("display");if(K==="none"){K="block"}I.remove();m[G]=K}o.data(this[H],"olddisplay",K)}}for(var H=0,F=this.length;H<F;H++){this[H].style.display=o.data(this[H],"olddisplay")||""}return this}},hide:function(H,I){if(H){return this.animate(t("hide",3),H,I)}else{for(var G=0,F=this.length;G<F;G++){var E=o.data(this[G],"olddisplay");if(!E&&E!=="none"){o.data(this[G],"olddisplay",o.css(this[G],"display"))}}for(var G=0,F=this.length;G<F;G++){this[G].style.display="none"}return this}},_toggle:o.fn.toggle,toggle:function(G,F){var E=typeof G==="boolean";return o.isFunction(G)&&o.isFunction(F)?this._toggle.apply(this,arguments):G==null||E?this.each(function(){var H=E?G:o(this).is(":hidden");o(this)[H?"show":"hide"]()}):this.animate(t("toggle",3),G,F)},fadeTo:function(E,G,F){return this.animate({opacity:G},E,F)},animate:function(I,F,H,G){var E=o.speed(F,H,G);return this[E.queue===false?"each":"queue"](function(){var K=o.extend({},E),M,L=this.nodeType==1&&o(this).is(":hidden"),J=this;for(M in I){if(I[M]=="hide"&&L||I[M]=="show"&&!L){return K.complete.call(this)}if((M=="height"||M=="width")&&this.style){K.display=o.css(this,"display");K.overflow=this.style.overflow}}if(K.overflow!=null){this.style.overflow="hidden"}K.curAnim=o.extend({},I);o.each(I,function(O,S){var R=new o.fx(J,K,O);if(/toggle|show|hide/.test(S)){R[S=="toggle"?L?"show":"hide":S](I)}else{var Q=S.toString().match(/^([+-]=)?([\d+-.]+)(.*)$/),T=R.cur(true)||0;if(Q){var N=parseFloat(Q[2]),P=Q[3]||"px";if(P!="px"){J.style[O]=(N||1)+P;T=((N||1)/R.cur(true))*T;J.style[O]=T+P}if(Q[1]){N=((Q[1]=="-="?-1:1)*N)+T}R.custom(T,N,P)}else{R.custom(T,S,"")}}});return true})},stop:function(F,E){var G=o.timers;if(F){this.queue([])}this.each(function(){for(var H=G.length-1;H>=0;H--){if(G[H].elem==this){if(E){G[H](true)}G.splice(H,1)}}});if(!E){this.dequeue()}return this}});o.each({slideDown:t("show",1),slideUp:t("hide",1),slideToggle:t("toggle",1),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"}},function(E,F){o.fn[E]=function(G,H){return this.animate(F,G,H)}});o.extend({speed:function(G,H,F){var E=typeof G==="object"?G:{complete:F||!F&&H||o.isFunction(G)&&G,duration:G,easing:F&&H||H&&!o.isFunction(H)&&H};E.duration=o.fx.off?0:typeof E.duration==="number"?E.duration:o.fx.speeds[E.duration]||o.fx.speeds._default;E.old=E.complete;E.complete=function(){if(E.queue!==false){o(this).dequeue()}if(o.isFunction(E.old)){E.old.call(this)}};return E},easing:{linear:function(G,H,E,F){return E+F*G},swing:function(G,H,E,F){return((-Math.cos(G*Math.PI)/2)+0.5)*F+E}},timers:[],fx:function(F,E,G){this.options=E;this.elem=F;this.prop=G;if(!E.orig){E.orig={}}}});o.fx.prototype={update:function(){if(this.options.step){this.options.step.call(this.elem,this.now,this)}(o.fx.step[this.prop]||o.fx.step._default)(this);if((this.prop=="height"||this.prop=="width")&&this.elem.style){this.elem.style.display="block"}},cur:function(F){if(this.elem[this.prop]!=null&&(!this.elem.style||this.elem.style[this.prop]==null)){return this.elem[this.prop]}var E=parseFloat(o.css(this.elem,this.prop,F));return E&&E>-10000?E:parseFloat(o.curCSS(this.elem,this.prop))||0},custom:function(I,H,G){this.startTime=e();this.start=I;this.end=H;this.unit=G||this.unit||"px";this.now=this.start;this.pos=this.state=0;var E=this;function F(J){return E.step(J)}F.elem=this.elem;if(F()&&o.timers.push(F)&&!n){n=setInterval(function(){var K=o.timers;for(var J=0;J<K.length;J++){if(!K[J]()){K.splice(J--,1)}}if(!K.length){clearInterval(n);n=g}},13)}},show:function(){this.options.orig[this.prop]=o.attr(this.elem.style,this.prop);this.options.show=true;this.custom(this.prop=="width"||this.prop=="height"?1:0,this.cur());o(this.elem).show()},hide:function(){this.options.orig[this.prop]=o.attr(this.elem.style,this.prop);this.options.hide=true;this.custom(this.cur(),0)},step:function(H){var G=e();if(H||G>=this.options.duration+this.startTime){this.now=this.end;this.pos=this.state=1;this.update();this.options.curAnim[this.prop]=true;var E=true;for(var F in this.options.curAnim){if(this.options.curAnim[F]!==true){E=false}}if(E){if(this.options.display!=null){this.elem.style.overflow=this.options.overflow;this.elem.style.display=this.options.display;if(o.css(this.elem,"display")=="none"){this.elem.style.display="block"}}if(this.options.hide){o(this.elem).hide()}if(this.options.hide||this.options.show){for(var I in this.options.curAnim){o.attr(this.elem.style,I,this.options.orig[I])}}this.options.complete.call(this.elem)}return false}else{var J=G-this.startTime;this.state=J/this.options.duration;this.pos=o.easing[this.options.easing||(o.easing.swing?"swing":"linear")](this.state,J,0,1,this.options.duration);this.now=this.start+((this.end-this.start)*this.pos);this.update()}return true}};o.extend(o.fx,{speeds:{slow:600,fast:200,_default:400},step:{opacity:function(E){o.attr(E.elem.style,"opacity",E.now)},_default:function(E){if(E.elem.style&&E.elem.style[E.prop]!=null){E.elem.style[E.prop]=E.now+E.unit}else{E.elem[E.prop]=E.now}}}});if(document.documentElement.getBoundingClientRect){o.fn.offset=function(){if(!this[0]){return{top:0,left:0}}if(this[0]===this[0].ownerDocument.body){return o.offset.bodyOffset(this[0])}var G=this[0].getBoundingClientRect(),J=this[0].ownerDocument,F=J.body,E=J.documentElement,L=E.clientTop||F.clientTop||0,K=E.clientLeft||F.clientLeft||0,I=G.top+(self.pageYOffset||o.boxModel&&E.scrollTop||F.scrollTop)-L,H=G.left+(self.pageXOffset||o.boxModel&&E.scrollLeft||F.scrollLeft)-K;return{top:I,left:H}}}else{o.fn.offset=function(){if(!this[0]){return{top:0,left:0}}if(this[0]===this[0].ownerDocument.body){return o.offset.bodyOffset(this[0])}o.offset.initialized||o.offset.initialize();var J=this[0],G=J.offsetParent,F=J,O=J.ownerDocument,M,H=O.documentElement,K=O.body,L=O.defaultView,E=L.getComputedStyle(J,null),N=J.offsetTop,I=J.offsetLeft;while((J=J.parentNode)&&J!==K&&J!==H){M=L.getComputedStyle(J,null);N-=J.scrollTop,I-=J.scrollLeft;if(J===G){N+=J.offsetTop,I+=J.offsetLeft;if(o.offset.doesNotAddBorder&&!(o.offset.doesAddBorderForTableAndCells&&/^t(able|d|h)$/i.test(J.tagName))){N+=parseInt(M.borderTopWidth,10)||0,I+=parseInt(M.borderLeftWidth,10)||0}F=G,G=J.offsetParent}if(o.offset.subtractsBorderForOverflowNotVisible&&M.overflow!=="visible"){N+=parseInt(M.borderTopWidth,10)||0,I+=parseInt(M.borderLeftWidth,10)||0}E=M}if(E.position==="relative"||E.position==="static"){N+=K.offsetTop,I+=K.offsetLeft}if(E.position==="fixed"){N+=Math.max(H.scrollTop,K.scrollTop),I+=Math.max(H.scrollLeft,K.scrollLeft)}return{top:N,left:I}}}o.offset={initialize:function(){if(this.initialized){return}var L=document.body,F=document.createElement("div"),H,G,N,I,M,E,J=L.style.marginTop,K='<div style="position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;"><div></div></div><table style="position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;" cellpadding="0" cellspacing="0"><tr><td></td></tr></table>';M={position:"absolute",top:0,left:0,margin:0,border:0,width:"1px",height:"1px",visibility:"hidden"};for(E in M){F.style[E]=M[E]}F.innerHTML=K;L.insertBefore(F,L.firstChild);H=F.firstChild,G=H.firstChild,I=H.nextSibling.firstChild.firstChild;this.doesNotAddBorder=(G.offsetTop!==5);this.doesAddBorderForTableAndCells=(I.offsetTop===5);H.style.overflow="hidden",H.style.position="relative";this.subtractsBorderForOverflowNotVisible=(G.offsetTop===-5);L.style.marginTop="1px";this.doesNotIncludeMarginInBodyOffset=(L.offsetTop===0);L.style.marginTop=J;L.removeChild(F);this.initialized=true},bodyOffset:function(E){o.offset.initialized||o.offset.initialize();var G=E.offsetTop,F=E.offsetLeft;if(o.offset.doesNotIncludeMarginInBodyOffset){G+=parseInt(o.curCSS(E,"marginTop",true),10)||0,F+=parseInt(o.curCSS(E,"marginLeft",true),10)||0}return{top:G,left:F}}};o.fn.extend({position:function(){var I=0,H=0,F;if(this[0]){var G=this.offsetParent(),J=this.offset(),E=/^body|html$/i.test(G[0].tagName)?{top:0,left:0}:G.offset();J.top-=j(this,"marginTop");J.left-=j(this,"marginLeft");E.top+=j(G,"borderTopWidth");E.left+=j(G,"borderLeftWidth");F={top:J.top-E.top,left:J.left-E.left}}return F},offsetParent:function(){var E=this[0].offsetParent||document.body;while(E&&(!/^body|html$/i.test(E.tagName)&&o.css(E,"position")=="static")){E=E.offsetParent}return o(E)}});o.each(["Left","Top"],function(F,E){var G="scroll"+E;o.fn[G]=function(H){if(!this[0]){return null}return H!==g?this.each(function(){this==l||this==document?l.scrollTo(!F?H:o(l).scrollLeft(),F?H:o(l).scrollTop()):this[G]=H}):this[0]==l||this[0]==document?self[F?"pageYOffset":"pageXOffset"]||o.boxModel&&document.documentElement[G]||document.body[G]:this[0][G]}});o.each(["Height","Width"],function(I,G){var E=I?"Left":"Top",H=I?"Right":"Bottom",F=G.toLowerCase();o.fn["inner"+G]=function(){return this[0]?o.css(this[0],F,false,"padding"):null};o.fn["outer"+G]=function(K){return this[0]?o.css(this[0],F,false,K?"margin":"border"):null};var J=G.toLowerCase();o.fn[J]=function(K){return this[0]==l?document.compatMode=="CSS1Compat"&&document.documentElement["client"+G]||document.body["client"+G]:this[0]==document?Math.max(document.documentElement["client"+G],document.body["scroll"+G],document.documentElement["scroll"+G],document.body["offset"+G],document.documentElement["offset"+G]):K===g?(this.length?o.css(this[0],J):null):this.css(J,typeof K==="string"?K:K+"px")}})})();

/*Desactivar boton ^^)*/
(function($){$.fn.enablebutton=function(a){if(a){$(this).removeClass('disabled').removeAttr('disabled');}else{$(this).addClass('disabled').attr('disabled','disabled');}}})(jQuery);

/*tipsy*/
(function($){$.fn.tipsy=function(d){d=$.extend({fade:false,gravity:'n'},d||{});var e=null,cancelHide=false;this.hover(function(){$.data(this,'cancel.tipsy',true);var a=$.data(this,'active.tipsy');if(!a){a=$('<div class="tipsy"><div class="tipsy-inner">'+$(this).attr('title')+'</div></div>');a.css({position:'absolute',zIndex:100000});$(this).attr('title','');$.data(this,'active.tipsy',a)}var b=$.extend({},$(this).offset(),{width:this.offsetWidth,height:this.offsetHeight});a.remove().css({top:0,left:0,visibility:'hidden',display:'block'}).appendTo(document.body);var c=a[0].offsetWidth,actualHeight=a[0].offsetHeight;switch(d.gravity.charAt(0)){case'n':a.css({top:b.top+b.height,left:b.left+b.width/2-c/2}).addClass('tipsy-north');break;case's':a.css({top:b.top-actualHeight,left:b.left+b.width/2-c/2}).addClass('tipsy-south');break;case'e':a.css({top:b.top+b.height/2-actualHeight/2,left:b.left-c}).addClass('tipsy-east');break;case'w':a.css({top:b.top+b.height/2-actualHeight/2,left:b.left+b.width}).addClass('tipsy-west');break}if(d.fade){a.css({opacity:0,display:'block',visibility:'visible'}).animate({opacity:1})}else{a.css({visibility:'visible'})}},function(){$.data(this,'cancel.tipsy',false);var a=this;if($.data(this,'cancel.tipsy'))return;var b=$.data(a,'active.tipsy');if(d.fade){b.stop().fadeOut(function(){$(this).remove()})}else{b.remove()}})}})(jQuery);

/* MARITUP */

//Botones posts
mySettings = {
	nameSpace: 'markItUp',
	markupSet: [
		{name:lang['Negrita'], key:'B', openWith:'[b]', closeWith:'[/b]'},
		{name:lang['Cursiva'], key:'I', openWith:'[i]', closeWith:'[/i]'},
		{name:lang['Subrayado'], key:'U', openWith:'[u]', closeWith:'[/u]'},
		{separator:'-' },
		{name:lang['Alinear a la izquierda'], key:'', openWith:'[align=left]', closeWith:'[/align]'},
		{name:lang['Centrar'], key:'', openWith:'[align=center]', closeWith:'[/align]'},
		{name:lang['Alinear a la derecha'], key:'', openWith:'[align=right]', closeWith:'[/align]'},
		{separator:'-' },
		{name:lang['Color'], dropMenu: [
			{name:lang['Rojo oscuro'], openWith:'[color=darkred]', closeWith:'[/color]' },
			{name:lang['Rojo'], openWith:'[color=red]', closeWith:'[/color]' },
			{name:lang['Naranja'], openWith:'[color=orange]', closeWith:'[/color]' },
			{name:lang['Marron'], openWith:'[color=brown]', closeWith:'[/color]' },
			{name:lang['Amarillo'], openWith:'[color=yellow]', closeWith:'[/color]' },
			{name:lang['Verde'], openWith:'[color=green]', closeWith:'[/color]' },
			{name:lang['Oliva'], openWith:'[color=olive]', closeWith:'[/color]' },
			{name:lang['Cyan'], openWith:'[color=cyan]', closeWith:'[/color]' },
			{name:lang['Azul'], openWith:'[color=blue]', closeWith:'[/color]' },
			{name:lang['Azul oscuro'], openWith:'[color=darkblue]', closeWith:'[/color]' },
			{name:lang['Indigo'], openWith:'[color=indigo]', closeWith:'[/color]' },
			{name:lang['Violeta'], openWith:'[color=violet]', closeWith:'[/color]' },
			{name:lang['Negro'], openWith:'[color=black]', closeWith:'[/color]' }
		]},
		{name:lang['Tamano'], dropMenu :[
			{name:lang['Pequena'], openWith:'[size=9]', closeWith:'[/size]' },
			{name:lang['Normal'], openWith:'[size=12]', closeWith:'[/size]' },
			{name:lang['Grande'], openWith:'[size=18]', closeWith:'[/size]' },
			{name:lang['Enorme'], openWith:'[size=24]', closeWith:'[/size]' }
		]},
		{name:lang['Fuente'], dropMenu :[
			{name:'Arial', openWith:'[font=Arial]', closeWith:'[/font]' },
			{name:'Courier New', openWith:'[font="Courier New"]', closeWith:'[/font]' },
			{name:'Georgia', openWith:'[font=Georgia]', closeWith:'[/font]' },
			{name:'Times New Roman', openWith:'[font="Times New Roman"]', closeWith:'[/font]' },
			{name:'Verdana', openWith:'[font=Verdana]', closeWith:'[/font]' },
			{name:'Trebuchet MS', openWith:'[font="Trebuchet MS"]', closeWith:'[/font]' },
			{name:'Lucida Sans', openWith:'[font="Lucida Sans"]', closeWith:'[/font]' },
			{name:'Comic Sans', openWith:'[font="Comic Sans"]', closeWith:'[/font]' }
		]},
		{separator:'-' },
		{name:lang['Insertar video de YouTube'], beforeInsert:function(h){ markit_yt(h); }},
		{name:lang['Insertar video de Google Video'], beforeInsert:function(h){ markit_gv(h); }},
		{name:lang['Insertar archivo SWF'], beforeInsert:function(h){ markit_swf(h); }},
		{name:lang['Insertar Imagen'], beforeInsert:function(h){ markit_img(h); }},
		{name:lang['Insertar Link'], beforeInsert:function(h){ markit_url(h); }},
		{name:lang['Citar'], beforeInsert:function(h){ markit_quote(h); }}
	]
};

//Botones comentarios
mySettings_cmt = {
	nameSpace: 'markitcomment',
	resizeHandle: false,
	markupSet: [
		{name:lang['Negrita'], key:'B', openWith:'[b]', closeWith:'[/b]'},
		{name:lang['Cursiva'], key:'I', openWith:'[i]', closeWith:'[/i]'},
		{name:lang['Subrayado'], key:'U', openWith:'[u]', closeWith:'[/u]'},
		{name:lang['Insertar video de YouTube'], beforeInsert:function(h){ markit_yt(h); }},
		{name:lang['Insertar Imagen'], beforeInsert:function(h){ markit_img(h); }},
		{name:lang['Insertar Link'], beforeInsert:function(h){ markit_url(h); }},
		{name:lang['Citar'], beforeInsert:function(h){ markit_quote(h); }}
	]
};

//Funciones botones especiales
function markit_yt(h){
	var msg = prompt(lang['ingrese el id de yt'+(is_ie?' IE':'')], lang['ingrese solo el id de yt']);
	if(msg != null){
		h.replaceWith = '[swf=http://www.youtube.com/v/' + msg + ']\nlink: [url]http://www.videos-star.com/watch.php?video=' + msg + '[/url]\n';
		h.openWith = '';
		h.closeWith = '';
	}else{
		h.replaceWith = '';
		h.openWith = '';
		h.closeWith = '';
	}
}
function markit_gv(h){
	var msg = prompt(lang['ingrese el id de gv'+(is_ie?' IE':'')], lang['ingrese solo el id de gv']);
	if(msg != null){
		h.replaceWith = '[swf=http://video.google.com/googleplayer.swf?docId=' + msg + ']\nlink: [url]http://video.google.com/videoplay?docid=' + msg + '[/url]\n';
		h.openWith = '';
		h.closeWith = '';
	}else{
		h.replaceWith = '';
		h.openWith = '';
		h.closeWith = '';
	}
}
function markit_swf(h){
	if(h.selection!='' && h.selection.substring(0,7)=='http://'){
		h.replaceWith = '[swf=' + h.selection + ']\nlink: [url]' + h.selection + '[/url]\n';
		h.openWith = '';
		h.closeWith = '';
	}else{
		var msg = prompt(lang['ingrese la url de swf'], 'http://');
		if(msg != null){
			h.replaceWith = '[swf=' + msg + ']\nlink: [url]' + msg + '[/url]\n';
			h.openWith = '';
			h.closeWith = '';
		}else{
			h.replaceWith = '';
			h.openWith = '';
			h.closeWith = '';
		}
	}
}
function markit_img(h){
	if(h.selection!='' && h.selection.substring(0,7)=='http://'){
		h.replaceWith = '';
		h.openWith = '[img=';
		h.closeWith = ']';				
	}else{
		var msg = prompt(lang['ingrese la url de img'], 'http://');
		if(msg != null){
			h.replaceWith = '[img=' + msg + ']';
			h.openWith = '';
			h.closeWith = '';
		}else{
			h.replaceWith = '';
			h.openWith = '';
			h.closeWith = '';
		}
	}
}
function markit_url(h){
	if(h.selection==''){
		var msg = prompt(lang['Ingrese la URL que desea postear'], 'http://');
		if(msg != null){
			h.replaceWith = '[url]' + msg + '[/url]';
			h.openWith = '';
			h.closeWith = '';
		}else{
			h.replaceWith = '';
			h.openWith = '';
			h.closeWith = '';
		}
	}else if(h.selection.substring(0,7)=='http://' || h.selection.substring(0,8)=='https://' || h.selection.substring(0,6)=='ftp://'){
		h.replaceWith = '';
		h.openWith='[url]';
		h.closeWith='[/url]';
	}else{
		var msg = prompt(lang['Ingrese la URL que desea postear'], 'http://');
		if(msg != null){
			h.replaceWith = '';
			h.openWith='[url=' + msg + ']';
			h.closeWith='[/url]';
		}else{
			h.replaceWith = '';
			h.openWith = '';
			h.closeWith = '';
		}
	}
}

function markit_quote(h){
	if(h.selection==''){
		var msg = prompt('Ingrese el texto a citar', '');
		if(msg != null){
			h.replaceWith = '[quote]' + msg + '[/quote]';
			h.openWith = '';
			h.closeWith = '';
		}else{
			h.replaceWith = '';
			h.openWith = '';
			h.closeWith = '';
		}
	}else{
		h.replaceWith = '';
		h.openWith='[quote]';
		h.closeWith='[/quote]';
	}
}

eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(3($){$.24.T=3(f,g){E k,v,A,F;v=A=F=7;k={C:\'\',12:\'\',U:\'\',1j:\'\',1A:8,25:\'26\',1k:\'~/2Q/1B.1C\',1b:\'\',27:\'28\',1l:8,1D:\'\',1E:\'\',1F:{},1G:{},1H:{},1I:{},29:[{}]};$.V(k,f,g);2(!k.U){$(\'2R\').1c(3(a,b){1J=$(b).14(0).2S.2T(/(.*)2U\\.2V(\\.2W)?\\.2X$/);2(1J!==2a){k.U=1J[1]}})}4 G.1c(3(){E d,u,15,16,p,H,L,P,17,1m,w,1n,M,18;d=$(G);u=G;15=[];18=7;16=p=0;H=-1;k.1b=1d(k.1b);k.1k=1d(k.1k);3 1d(a,b){2(b){4 a.W(/("|\')~\\//g,"$1"+k.U)}4 a.W(/^~\\//,k.U)}3 2b(){C=\'\';12=\'\';2(k.C){C=\'C="\'+k.C+\'"\'}l 2(d.1K("C")){C=\'C="T\'+(d.1K("C").2c(0,1).2Y())+(d.1K("C").2c(1))+\'"\'}2(k.12){12=\'N="\'+k.12+\'"\'}d.1L(\'<z \'+12+\'></z>\');d.1L(\'<z \'+C+\' N="T"></z>\');d.1L(\'<z N="2Z"></z>\');d.2d("2e");17=$(\'<z N="30"></z>\').2f(d);$(1M(k.29)).1N(17);1m=$(\'<z N="31"></z>\').1O(d);2(k.1l===8&&$.X.32!==8){1l=$(\'<z N="33"></z>\').1O(d).1e("34",3(e){E h=d.2g(),y=e.2h,1o,1p;1o=3(e){d.2i("2g",35.36(20,e.2h+h-y)+"37");4 7};1p=3(e){$("1C").1P("2j",1o).1P("1q",1p);4 7};$("1C").1e("2j",1o).1e("1q",1p)});1m.2k(1l)}d.2l(1Q).38(1Q);d.1e("1R",3(e,a){2(a.1r!==7){14()}2(u===$.T.2m){Y(a)}});d.1f(3(){$.T.2m=G})}3 1M(b){E c=$(\'<Z></Z>\'),i=0;$(\'B:2n > Z\',c).2i(\'39\',\'q\');$.1c(b,3(){E a=G,t=\'\',1s,B,j;1s=(a.19)?(a.1S||\'\')+\' [3a+\'+a.19+\']\':(a.1S||\'\');19=(a.19)?\'2o="\'+a.19+\'"\':\'\';2(a.2p){B=$(\'<B N="3b">\'+(a.2p||\'\')+\'</B>\').1N(c)}l{i++;2q(j=15.6-1;j>=0;j--){t+=15[j]+"-"}B=$(\'<B N="2r 2r\'+t+(i)+\' \'+(a.3c||\'\')+\'"><a 3d="" \'+19+\' 1s="\'+1s+\'">\'+(a.1S||\'\')+\'</a></B>\').1e("3e",3(){4 7}).2s(3(){4 7}).1q(3(){2(a.2t){3f(a.2t)()}Y(a);4 7}).2n(3(){$(\'> Z\',G).3g();$(D).3h(\'2s\',3(){$(\'Z Z\',17).2u()})},3(){$(\'> Z\',G).2u()}).1N(c);2(a.2v){15.3i(i);$(B).2d(\'3j\').2k(1M(a.2v))}}});15.3k();4 c}3 2w(c){2(c){c=c.3l();c=c.W(/\\(\\!\\(([\\s\\S]*?)\\)\\!\\)/g,3(x,a){E b=a.1T(\'|!|\');2(F===8){4(b[1]!==2x)?b[1]:b[0]}l{4(b[1]===2x)?"":b[0]}});c=c.W(/\\[\\!\\[([\\s\\S]*?)\\]\\!\\]/g,3(x,a){E b=a.1T(\':!:\');2(18===8){4 7}1U=3m(b[0],(b[1])?b[1]:\'\');2(1U===2a){18=8}4 1U});4 c}4""}3 I(a){2($.3n(a)){a=a(P)}4 2w(a)}3 1g(a){J=I(L.J);1a=I(L.1a);Q=I(L.Q);O=I(L.O);2(Q!==""){q=J+Q+O}l 2(m===\'\'&&1a!==\'\'){q=J+1a+O}l{q=J+(a||m)+O}4{q:q,J:J,Q:Q,1a:1a,O:O}}3 Y(a){E b,j,n,i;P=L=a;14();$.V(P,{1t:"",U:k.U,u:u,m:(m||\'\'),p:p,v:v,A:A,F:F});I(k.1D);I(L.1D);2(v===8&&A===8){I(L.3o)}$.V(P,{1t:1});2(v===8&&A===8){R=m.1T(/\\r?\\n/);2q(j=0,n=R.6,i=0;i<n;i++){2($.3p(R[i])!==\'\'){$.V(P,{1t:++j,m:R[i]});R[i]=1g(R[i]).q}l{R[i]=""}}o={q:R.3q(\'\\n\')};11=p;b=o.q.6+(($.X.1V)?n:0)}l 2(v===8){o=1g(m);11=p+o.J.6;b=o.q.6-o.J.6-o.O.6;b-=1u(o.q)}l 2(A===8){o=1g(m);11=p;b=o.q.6;b-=1u(o.q)}l{o=1g(m);11=p+o.q.6;b=0;11-=1u(o.q)}2((m===\'\'&&o.Q===\'\')){H+=1W(o.q);11=p+o.J.6;b=o.q.6-o.J.6-o.O.6;H=d.K().1h(p,d.K().6).6;H-=1W(d.K().1h(0,p))}$.V(P,{p:p,16:16});2(o.q!==m&&18===7){2y(o.q);1X(11,b)}l{H=-1}14();$.V(P,{1t:\'\',m:m});2(v===8&&A===8){I(L.3r)}I(L.1E);I(k.1E);2(w&&k.1A){1Y()}A=F=v=18=7}3 1W(a){2($.X.1V){4 a.6-a.W(/\\n*/g,\'\').6}4 0}3 1u(a){2($.X.2z){4 a.6-a.W(/\\r*/g,\'\').6}4 0}3 2y(a){2(D.m){E b=D.m.1Z();b.2A=a}l{d.K(d.K().1h(0,p)+a+d.K().1h(p+m.6,d.K().6))}}3 1X(a,b){2(u.2B){2($.X.1V&&$.X.3s>=9.5&&b==0){4 7}1i=u.2B();1i.3t(8);1i.2C(\'21\',a);1i.3u(\'21\',b);1i.3v()}l 2(u.2D){u.2D(a,a+b)}u.1v=16;u.1f()}3 14(){u.1f();16=u.1v;2(D.m){m=D.m.1Z().2A;2($.X.2z){E a=D.m.1Z(),1w=a.3w();1w.3x(u);p=-1;3y(1w.3z(a)){1w.2C(\'21\');p++}}l{p=u.2E}}l{p=u.2E;m=d.K().1h(p,u.3A)}4 m}3 1B(){2(!w||w.3B){2(k.1j){w=3C.2F(\'\',\'1B\',k.1j)}l{M=$(\'<2G N="3D"></2G>\');2(k.25==\'26\'){M.1O(1m)}l{M.2f(17)}w=M[M.6-1].3E||3F[M.6-1]}}l 2(F===8){2(M){M.3G()}w.2H();w=M=7}2(!k.1A){1Y()}}3 1Y(){2(w.D){3H{22=w.D.2I.1v}3I(e){22=0}w.D.2F();w.D.3J(2J());w.D.2H();w.D.2I.1v=22}2(k.1j){w.1f()}}3 2J(){2(k.1b!==\'\'){$.2K({2L:\'3K\',2M:7,2N:k.1b,28:k.27+\'=\'+3L(d.K()),2O:3(a){23=1d(a,1)}})}l{2(!1n){$.2K({2M:7,2N:k.1k,2O:3(a){1n=1d(a,1)}})}23=1n.W(/<!-- 3M -->/g,d.K())}4 23}3 1Q(e){A=e.A;F=e.F;v=(!(e.F&&e.v))?e.v:7;2(e.2L===\'2l\'){2(v===8){B=$("a[2o="+3N.3O(e.1x)+"]",17).1y(\'B\');2(B.6!==0){v=7;B.3P(\'1q\');4 7}}2(e.1x===13||e.1x===10){2(v===8){v=7;Y(k.1H);4 k.1H.1z}l 2(A===8){A=7;Y(k.1G);4 k.1G.1z}l{Y(k.1F);4 k.1F.1z}}2(e.1x===9){2(A==8||v==8||F==8){4 7}2(H!==-1){14();H=d.K().6-H;1X(H,0);H=-1;4 7}l{Y(k.1I);4 k.1I.1z}}}}2b()})};$.24.3Q=3(){4 G.1c(3(){$$=$(G).1P().3R(\'2e\');$$.1y(\'z\').1y(\'z.T\').1y(\'z\').Q($$)})};$.T=3(a){E b={1r:7};$.V(b,a);2(b.1r){4 $(b.1r).1c(3(){$(G).1f();$(G).2P(\'1R\',[b])})}l{$(\'u\').2P(\'1R\',[b])}}})(3S);',62,241,'||if|function|return||length|false|true|||||||||||||else|selection||string|caretPosition|block||||textarea|ctrlKey|previewWindow|||div|shiftKey|li|id|document|var|altKey|this|caretOffset|prepare|openWith|val|clicked|iFrame|class|closeWith|hash|replaceWith|lines||markItUp|root|extend|replace|browser|markup|ul||start|nameSpace||get|levels|scrollPosition|header|abort|key|placeHolder|previewParserPath|each|localize|bind|focus|build|substring|range|previewInWindow|previewTemplatePath|resizeHandle|footer|template|mouseMove|mouseUp|mouseup|target|title|line|fixIeBug|scrollTop|rangeCopy|keyCode|parent|keepDefault|previewAutoRefresh|preview|html|beforeInsert|afterInsert|onEnter|onShiftEnter|onCtrlEnter|onTab|miuScript|attr|wrap|dropMenus|appendTo|insertAfter|unbind|keyPressed|insertion|name|split|value|opera|fixOperaBug|set|refreshPreview|createRange||character|sp|phtml|fn|previewPosition|after|previewParserVar|data|markupSet|null|init|substr|addClass|markItUpEditor|insertBefore|height|clientY|css|mousemove|append|keydown|focused|hover|accesskey|separator|for|markItUpButton|click|call|hide|dropMenu|magicMarkups|undefined|insert|msie|text|createTextRange|moveStart|setSelectionRange|selectionStart|open|iframe|close|documentElement|renderPreview|ajax|type|async|url|success|trigger|templates|script|src|match|jquery|markitup|pack|js|toUpperCase|markItUpContainer|markItUpHeader|markItUpFooter|safari|markItUpResizeHandle|mousedown|Math|max|px|keyup|display|Ctrl|markItUpSeparator|className|href|contextmenu|eval|show|one|push|markItUpDropMenu|pop|toString|prompt|isFunction|beforeMultiInsert|trim|join|afterMultiInsert|version|collapse|moveEnd|select|duplicate|moveToElementText|while|inRange|selectionEnd|closed|window|markItUpPreviewFrame|contentWindow|frame|remove|try|catch|write|POST|encodeURIComponent|content|String|fromCharCode|triggerHandler|markItUpRemove|removeClass|jQuery'.split('|'),0,{}));

/*AUTOGROW*/
(function(b){var c=null;b.fn.autogrow=function(o){return this.each(function(){new b.autogrow(this,o)})};b.autogrow=function(e,o){this.options=o||{};this.dummy=null;this.interval=null;this.line_height=this.options.lineHeight||parseInt(b(e).css('line-height'));this.min_height=this.options.minHeight||parseInt(b(e).css('min-height'));this.max_height=this.options.maxHeight||parseInt(b(e).css('max-height'));this.textarea=b(e);if(this.line_height==NaN)this.line_height=0;this.init()};b.autogrow.fn=b.autogrow.prototype={autogrow:'1.2.2'};b.autogrow.fn.extend=b.autogrow.extend=b.extend;b.autogrow.fn.extend({init:function(){var a=this;this.textarea.css({overflow:'hidden',display:'block'});this.textarea.bind('focus',function(){a.startExpand()}).bind('blur',function(){a.stopExpand()});this.checkExpand()},startExpand:function(){var a=this;this.interval=window.setInterval(function(){a.checkExpand()},400)},stopExpand:function(){clearInterval(this.interval)},checkExpand:function(){if(this.dummy==null){this.dummy=b('<div></div>');this.dummy.css({'font-size':this.textarea.css('font-size'),'font-family':this.textarea.css('font-family'),'width':this.textarea.css('width'),'padding':this.textarea.css('padding'),'line-height':this.line_height+'px','overflow-x':'hidden','position':'absolute','top':0,'left':-9999}).appendTo('body')}var a=this.textarea.val().replace(/(<|>)/g,'');if($.browser.msie){a=a.replace(/\n/g,'<BR>new')}else{a=a.replace(/\n/g,'<br>new')}if(this.dummy.html()!=a){this.dummy.html(a);if(this.max_height>0&&(this.dummy.height()+this.line_height>this.max_height)){this.textarea.css('overflow-y','auto')}else{this.textarea.css('overflow-y','hidden');if(this.textarea.height()<this.dummy.height()+this.line_height||(this.dummy.height()<this.textarea.height())){this.textarea.animate({height:(this.dummy.height()+this.line_height)+'px'},100)}}}}})})(jQuery);

/*MYDIALOG*/

/* MyDialog */
var mydialog = {

is_show: false,
class_aux: '',
show: function(class_aux){
	if(this.is_show)
		return;
	else
		this.is_show = true;
	if($('#mydialog').html()=='') //Primera vez
		$('#mydialog').html('<div id="dialog"><div id="title"></div><div id="cuerpo"><div id="procesando"><div id="mensaje"></div></div><div id="modalBody"></div><div id="buttons"></div></div></div>');

	if(class_aux==true)
		$('#mydialog').addClass(this.class_aux);
	else if(this.class_aux != ''){
		$('#mydialog').removeClass(this.class_aux);
		this.class_aux = '';
	}

	$('#mask').click(function(){ mydialog.close() }).css({'width':$(document).width(),'height':$(document).height(),'display':'block'});

	if(jQuery.browser.msie && jQuery.browser.version<7) //Fix IE<7 <- fack you
		$('#mydialog #dialog').css('position', 'absolute');
	else
		$('#mydialog #dialog').css('position', 'fixed');
	$('#mydialog #dialog').fadeIn('fast');
},
close: function(){
	this.is_show = false;
	$('#mask').css('display', 'none');
	$('#mydialog #dialog').fadeOut('fast');
	this.procesando_fin();
},
center: function(){
	if($('#mydialog #dialog').height() > $(window).height()-60)
		$('#mydialog #dialog').css({'position':'absolute', 'top':20});
	else
		$('#mydialog #dialog').css('top', $(window).height()/2-$('#mydialog #dialog').height()/2);
	$('#mydialog #dialog').css('left', $(window).width()/2-$('#mydialog #dialog').width()/2);
},

title: function(title){
	$('#mydialog #title').html(title);
},
body: function(body, width, height){
	if(!width && (jQuery.browser.opera || (jQuery.browser.msie && jQuery.browser.version<7)))
		width = '400px';
	$('#mydialog #dialog').width(width?width:'').height(height?height:'');
	$('#mydialog #modalBody').html(body);
},
buttons: function(display_all, btn1_display, btn1_val, btn1_action, btn1_enabled, btn1_focus, btn2_display, btn2_val, btn2_action, btn2_enabled, btn2_focus){
	if(!display_all){
		$('#mydialog #buttons').css('display', 'none').html('');
		return;
	}

	if(btn1_action=='close')
		btn1_action='mydialog.close()';
	if(btn2_action=='close' || !btn2_val)
		btn2_action='mydialog.close()';
	if(!btn2_val){
		btn2_val = 'Cancelar';
		btn2_enabled = true;
	}

	var html = '';
	if(btn1_display)
		html += '<input type="button" class="mBtn btnOk'+(btn1_enabled?'':' disabled')+'" style="display:'+(btn1_display?'inline-block':'none')+'"'+(btn1_display?' value="'+btn1_val+'"':'')+(btn1_display?' onclick="'+btn1_action+'"':'')+(btn1_enabled?'':' disabled')+' />';
	if(btn2_display)
		html += ' <input type="button" class="mBtn btnCancel'+(btn2_enabled?'':' disabled')+'" style="display:'+(btn2_display?'inline-block':'none')+'"'+(btn2_display?' value="'+btn2_val+'"':'')+(btn2_display?' onclick="'+btn2_action+'"':'')+(btn2_enabled?'':' disabled')+' />';
	$('#mydialog #buttons').html(html).css('display', 'inline-block');

	if(btn1_focus)
		$('#mydialog #buttons .mBtn.btnOk').focus();
	else if(btn2_focus)
		$('#mydialog #buttons .mBtn.btnCancel').focus();
},
buttons_enabled: function(btn1_enabled, btn2_enabled){
	if($('#mydialog #buttons .mBtn.btnOk'))
		if(btn1_enabled)
			$('#mydialog #buttons .mBtn.btnOk').removeClass('disabled').removeAttr('disabled');
		else
			$('#mydialog #buttons .mBtn.btnOk').addClass('disabled').attr('disabled', 'disabled');

	if($('#mydialog #buttons .mBtn.btnCancel'))
		if(btn2_enabled)
			$('#mydialog #buttons .mBtn.btnCancel').removeClass('disabled').removeAttr('disabled');
		else
			$('#mydialog #buttons .mBtn.btnCancel').addClass('disabled').attr('disabled', 'disabled');
},
alert: function(title, body, reload){
	this.show();
	this.title(title);
	this.body(body);
	this.buttons(true, true, 'Aceptar', 'mydialog.close();' + (reload ? 'location.reload();' : 'close'), true, true, false);
	this.center();
},
error_500: function(fun_reintentar){
	mydialog.procesando_fin();
	this.show();
	this.title('Error');
	this.body(lang['error procesar']);
	this.buttons(true, true, 'Reintentar', 'mydialog.close();'+fun_reintentar, true, true, true, 'Cancelar', 'close', true, false);
	this.center();
},
procesando_inicio: function(value, title){
	if(!this.is_show){
		this.show();
		this.title(title);
		this.body('');
		this.buttons(false, false);
		this.center();
	}
	$('#mydialog #procesando #mensaje').html('<img src="/images/loadingbig.gif" />');
	$('#mydialog #procesando').fadeIn('fast');
},
procesando_fin: function(){
	$('#mydialog #procesando').fadeOut('fast');
}

};

/*OF*/

function print_editor(){
	//Editor de posts
	if($('#markItUp') && !$('#markItUpMarkItUp').length){
		$('#markItUp').markItUp(mySettings);
		$('#emoticons a').click(function(){
        	var f = (document.getElementById('markItUp') ? document.getElementById('markItUp') : document.getElementById('body_comm'));
            f.focus();
            if(f.value == 'Escribir un comentario') { f.value = ''; }
			emoticon = ' ' + $(this).attr("smile") + ' ';
			$.markItUp({ replaceWith:emoticon });
			return false;
		});
	}
	//Editor de posts comentarios
	if($('#body_comm') && !$('#markItUpbody_comm').length){
		$('#body_comm').markItUp(mySettings_cmt);
	}

	//Editor de respuestas comunidades
	if($('#body_resp') && !$('#markItUpbody_resp').length){
		$('#body_resp').markItUp(mySettings_cmt);
	}
}

<!--ASCDT-->
$(function(){
	print_editor();
	$('.autogrow').css('max-height', '500px').autogrow();
	$('.userInfoLogin a').tipsy({gravity: 's'});
	for(i=1; i<=15; i++)
		$('.markItUpButton'+i+' > a:first-child').tipsy({gravity: 's'});	
	$('.comOfi').tipsy({gravity: 's'});
	$('.post-compartir img').tipsy({gravity: 's'});
	
});