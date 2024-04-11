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
/* AJAX ^

/*ADMIN*/

function admin_notes(action, id) {
	if(action != 'edit' && action != 'delete' && action != 'new' && action != 'edit2') { return false; }
	mdiv();
    $.ajax({
      type: 'POST',
      url: '/ajax/admin-notes.php',
      data: 'sa=' + action + '&id=' + encodeURIComponent(id),
      success: function(t) {
        if(t.substring(0,1)=='0') { mdiv('error', t.substring(1)); return false; }
        if(action == 'new') {
            var spl = t.split(':');
            $('<blockquote id="block_'+spl[0]+'" style="display:none;"><div class="cita">'+spl[2]+':'+spl[3]+':'+spl[4]+'<div class="box_rss"><img style="cursor:pointer;" src="/images/borrar.png" onclick="if(confirm(\'&iquest;Seguro que quieres borrar esta nota?\')){admin_notes(\'delete\', '+spl[0]+');}" alt="Borrar" title="Borrar" /> <img style="cursor:pointer;" src="/images/editar.png" onclick="admin_notes(\'edit\', '+spl[0]+');" alt="Editar" title="Editar" /></div></div><div class="citacuerpo" id="cita_cuerpo_'+spl[0]+'"><p>'+spl[1]+'</p></div></blockquote>').insertBefore($('#block_'+first_node));
            if(first_node == 'nn') { $('#block_nn').hide(); }
            $('<br />').insertBefore($('#block_'+first_node));
            first_node = spl[0];
            $('#block_'+spl[0]).slideDown('normal');
            $('#markItUp').val('');
        } else if(action == 'delete') {
		    $('#block_'+id).slideUp('fast');
        } else if(action == 'edit') {
            $('#cita_cuerpo_'+id).html('<textarea name="message" class="agregar cuerpo" style="height:200px;" id="edit_textarea_'+id+'">'+t+'</textarea><br /><input type="button" class="button" style="font-size:11px;" onclick="admin_notes(\'edit2\', \''+id+'\' + \':\' + document.getElementById(\'edit_textarea_'+id+'\').value);" value="Editar nota" />');
        } else if(action == 'edit2') {
            var spl = id.split(':');
           	$('#cita_cuerpo_'+spl[0]).html('<p>'+t+'</p>');
        }
      }
	});
}

var ra;
function admin_rank(form) {
	if(!ra || (ra != 'check' && ra != 'change')) { return false; }
    if(!form.st[0].checked && !form.st[1].checked || form.user.value == '') { return false; }
    mdiv();
    var st = (form.st[0].checked ? 'id' : 'nick');
    var fr = (ra == 'change' ? $(form.rank).val() : '');
    $.ajax({
      type: 'GET',
      url: '/ajax/admin-rank.php',
      data: 'sa=' + ra + '&user=' + form.user.value + '&st=' + st + '&rank=' + fr,
	  success: function(t) {
	    if(t.substring(0, 1) == '0') {
            mdiv('error', t.substring(1));
            return false;
        }
        mdiv('ok', (ra == 'check' ? 'Usuario v&aacute;lido' : 'Rango actualizado'));
        if(ra == 'check') {
            var spl = t.split('SEP');
            $('#form_select').slideUp('normal', function(){$(this).html(spl[1]).delay(1000).slideDown('normal');});
            $('#user_data').html(spl[0]).show();
        }
        return false;
      }
	});
}

function admin_ban(ac, form) {
	if(!ra || (ra != 'check' && ra != 'ban') || !ac || (ac != '1' && ac != '2')) { return false; }
    if(!form.st[0].checked && !form.st[1].checked || form.user.value == '') { alert('Selecciona un usuario'); return false; }
    if(ra == 'ban'  && ac != '2' && form.reason.value == '') { alert('Pon una razon'); return false; }
    mdiv();
   	var st = (form.st[0].checked ? 'id' : 'nick');
    if(ra == 'check' || ac == '2') {
    	var end = 'permanent';
    } else {
    	var end = (!form.permanent.checked ? form.eday.value + '-' + form.emonth.value + '-' + form.eyear.value + '-' + form.ehour.value + '-' + form.eminutes.value : 'permanent');
    }
	if(ra == 'ban' && ac == '1') {
		var ballq = (form.alli.checked ? '1' : '');
		var block = (form.lock.checked ? '1' : '');
	}
    $.ajax({
      type: 'POST',
      url: '/ajax/admin-ban.php',
      data: 'sa=' + ra + '&user=' + form.user.value + '&st=' + st + '&ac=' + ac + '&end=' + end + '&ban=' + form.ban.value + '&reason=' + (ra == 'check' || ac == '2' ? '1' : form.reason.value) + '&all=' + ballq + '&lock=' + block,
	  success: function(t) {
	    if(t.substring(0, 1) == '0') {alert('lets fok!');
            mdiv('error', t.substring(1));
            return false;
        }
        mdiv('ok', (ra == 'check' ? 'Usuario v&aacute;lido' : 'Usuario ' + (ac == '1' ? 'baneado' : 'desbaneado')));
        if(ra == 'check') {
            var spl = t.split('SEP');
            $('#form_select').slideUp('normal', function(){$(this).html(spl[1]).delay(1000).slideDown('normal');});
            $('#user_data').html(spl[0]).show();
        }
        return false;
      }
	});
}

function admin_complaints_action(sa, post) {
	if(!confirm('\xBFSeguro que quieres ' + (sa == 'accept' ? 'aceptar' : (sa == 'validate' ? 'validar' : 'rechazar')) + ' esta denuncia?')) { return false; }
	if(sa != 'accept' && sa != 'reject' && sa != 'validate') { return false; }
    var draft = (sa == 'accept' && confirm('\xBFQuieres enviar el post a borradores?') ? '1' : '0');
    $.ajax({
      type: 'GET',
      url: '/ajax/admin-complaints.php',
      data: 'sa=' + (sa == 'validate' ? 'accept&validate=1' : sa) + '&id=' + post + '&draft=' + draft,
      success: function(t) {
        if(t.substring(0, 1) == '0') { alert(t.substring(1)); return false; }
        $('#post_d_' + post).slideUp('fast', function(){$(this).html('La denuncia ha sido ' + (sa == 'accept' ? 'aceptada' : (sa == 'validate' ? 'validada' : 'rechazada'))).slideDown('slow');});
      }
	});
}

function admin_complaints_show(link, post, n) {
    var s = $(link).attr('href') == '#s';
	if(n == 'all') {
    	if(s) {
        	$('.pc' + post).slideDown('normal');
            $('.link' + post).html('Ver 5 menos').attr('href', '#h');
        } else {
        	$('.pc' + post).slideUp('normal');
            $('.link' + post).html('Ver 5 m&aacute;s').attr('href', '#s');
        }
        $(link).html((s ? 'Ocultar todos' : 'Ver todos')).attr('href', (s ? '#h' : '#s'));
    } else {
        $(link).html((s ? 'Ver 5 menos' : 'Ver 5 m&aacute;s')).attr('href', (s ? '#h' : '#s'));
    	$('.pc' + post + '.nl' + n).slideToggle('normal');
    }
}

function admin_delete_complaint(post, c) {
    $.ajax({
      type: 'GET',
      url: '/ajax/admin-complaints.php',
      data: 'sa=delete&id=' + c + '&post=' + post,
      success: function(t) {
        if(t.substring(0, 1) == '0') { alert(t.substring(1)); return false; }
        post_c_n[post] -= 1;
        if(post_c_n[post] == 0) {
            $('#post_d_' + post).slideUp('fast');
        } else {
            $('.cid' + c).slideUp('fast');
        }
      }
	});
}

setInterval('currentptime++', 1000);
function ban_user(id, action, step) {
	if(action != 1 && action != 2) { return false; }
	if(action == 2 && !step) { step = 1; }
    if(step && action == 1) {
      var m,d,h,r;
      m = $('#ban_months').val();
      d = $('#ban_days').val();
      h = $('#ban_hours').val();
      r = $('#ban_reason').val();
    }
	if(!step) {
		mydialog.show();
		mydialog.title('Banear usuario');
		mydialog.body('Introduce la duraci&oacute;n del baneo:<br />Meses: <input type="text" id="ban_months" size="2" /> D&iacute;as:<input type="text" id="ban_days" size="2" /> Horas: <input type="text" id="ban_hours" size="2" /><br />Introduce la raz&oacute;n del baneo:<br /><input type="text" id="ban_reason" maxlength="50" />');
		mydialog.buttons(true, true, 'SI', 'ban_user(' + id + ', 1, 1)', true, false, true, 'NO', 'close', true, true);
		mydialog.center();
		return;
	} else if(step == 1) {
		mydialog.show();
		mydialog.title((action == 1 ? 'Banear' : 'Desbanear') + ' usuario');
		mydialog.body('&iquest;Seguro que quieres ' + (action == 1 ? 'banear' : 'desbanear') + ' a este usuario?<input type="hidden" id="ban_months" value="' + m + '" /><input type="hidden" id="ban_days" value="' + d + '" /><input type="hidden" id="ban_hours" value="' + h + '" /><input type="hidden" id="ban_reason" value="' + r + '" />');
		mydialog.buttons(true, true, 'SI', 'ban_user(' + id + ', ' + action + ', 2)', true, false, true, 'NO', 'close', true, true);
		mydialog.center();
		return;
	} else {
		if(action == 1) {
			m = (empty(m) ? 0 : parseInt(m));
			d = (empty(d) ? 0 : parseInt(d));
			h = (empty(h) ? 0 : parseInt(h));
			var end = currentptime+h*3600+d*86400+m*2592000;
		} else {
			var end = 'permanent';
			var reason = '1';
		}
        mydialog.procesando_inicio();
        $.ajax({
          type: 'POST',
          url: '/ajax/admin-ban.php',
          data: 'sa=ban&user=' + id + '&st=id&ac=' + action + '&end=' + end + '&reason=' + encodeURIComponent(r),
          complete: function(){mydialog.procesando_fin();},
          success: function(t) {
            if(t.substring(0, 1) == '1') {
                mydialog.alert((action == 1 ? 'Banear' : 'Desbanear') + ' usuario', 'El usuario ha sido ' + (action == 1 ? 'baneado' : 'desbaneado'));
				$('#ban_user_' + action).hide();
				$('#ban_user_' + (action == 1 ? '2' : '1')).show();
            } else {
                mydialog.alert((action == 1 ? 'Banear' : 'Desbanear') + ' usuario', 'Ha ocurrido un error: ' + t.substring(1));
            }
          }
		});
		
	}
}

/*POST*/

function borrar_post(id, autor, aceptar, draft) {
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
	} else if(aceptar==2 && !autor && cdp){
		  	mydialog.show();
		  	mydialog.title('Borrar Post');
		  	mydialog.body('Introduce una raz&oacute;n:<br /><input size="30" maxlength="30" id="borrar_post_razon_input" /><br /><label><input style="width:auto;" type="checkbox" checked id="send_to_drafts" /> Enviar a borradores</label>');
		  	mydialog.buttons(true, true, 'SI', "if(document.getElementById('send_to_drafts').checked && document.getElementById('borrar_post_razon_input').value == '') { alert('Para enviar el post a borradores necesitas poner una razon'); return false; }borrar_post(" + id + ", document.getElementById('borrar_post_razon_input').value, 2, document.getElementById('send_to_drafts'))", true, false, true, 'NO', 'close', true, true);
		  	mydialog.center();
			document.getElementById('borrar_post_razon_input').focus();
		  	return;
	}
	mydialog.procesando_inicio('Eliminando...', 'Borrar Post');
    $.ajax({
      type: 'GET',
      url: '/ajax/action-post.php',
      data: 'sa=delete&id=' + id + '&r=' + encodeURIComponent(autor) + '&draft=' + (draft && draft.checked ? '1' : '0'),
      complete: function(){mydialog.procesando_fin();},
      success: function(t) {
	    if(t == '1') {
            mydialog.alert('Post borrado', 'El post ha sido borrado correctamente', true);
        } else {
            mydialog.alert('Error', t);
        }
      }
	});
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
    $.ajax({
      type: 'GET',
      url: '/ajax/action-post.php',
      data: 'sa=stick&id=' + id + '&ft=' + (t.charAt(0).toLowerCase() == 'd' ? '2' : '1'),
      complete: function(){mydialog.procesando_fin();},
      success: function(t) {
        if(t == '1') {
            var fod = (t.charAt(0).toLowerCase() == 'f' ? 'fijado' : 'desfijado');
            mydialog.alert('Post ' + fod, 'El post ha sido ' + fod + ' correctamente');
        } else {
           	mydialog.alert('Error', t);
        }
      }
	});
}

/*LOGIN*/

function open_login_box() {
	if(!$('#login_box').is(':visible')){$('#login_box').fadeIn('fast',function(){$('#nickname').focus()});$('#user_options').addClass('here');}else{$('#login_box').fadeOut();$('#user_options').removeClass('here');}
}

function login_ajax(f) {
	var nick = $(f + ' > input[name="nick"]').val();
    var pass = $(f + ' > input[name="pass"]').val();
    if(empty(nick) || empty(pass)) {
    	$(f).siblings('div.login_error').css('display', 'block').html('Introduce un nombre y una contrase&ntilde;a');
       return;
    }
	$(f + ' > input[type="submit"]').enablebutton(false);
    $.ajax({
      type: 'GET',
      url: '/ajax/login.php',
      data: 'nick=' + nick + '&pass=' + pass + '&rememberme=' + ($(f + ' > div > input').is(':checked') ? '1' : '0'),
      success: function(t) {
        if(t == 1) {
            document.location.reload();
        } else {
            $(f).siblings('div.login_error').css('display', 'block').html(t);
		    $(f + ' > input[type="submit"]').enablebutton();
        }
      }
    });
}

/* POST */

function vote_post(num, id) {
	mdiv();
	if((num-1) == 'NaN' || num < 1 || num > 10) {
	    mdiv('error', '&iexcl;&iquest;Cuanto quieres puntuar?!');
  	  	return;
	}
    $.ajax({
      type: 'GET',
      url: '/ajax/vote.php',
      data: 'p=' + num + '&id=' + id,
      success: function(t) {
        $('#dar_puntos').hide();
        mdiv((t.substring(0,3)==' OK' ? 'ok' : 'error'), t.substring(4));
        if(t.substring(0,3)==' OK') { $('#post_points_span').text(parseInt($('#post_points_span').text())+num); }
      }
    });
}

/* COMENTARIOS */
var dlci = 1;

function add_comment(id, message, group) {
	var dn = (group ? 20 : 100);
	if(message == '' || message == null) { return false; }
    var gurl = (group ? 'group-' : '');
	$('#button_add_resp').enablebutton(false);
    $.ajax({
      type: 'POST',
      url: '/ajax/' + gurl + 'add-comment.php',
      data: 'message=' + encodeURIComponent(message) + '&id=' + id + (!gurl ? '' : '&group=' + group),
      success: function(t) {
	    if(t == '1') {
		    $('#button_add_resp').enablebutton();
            $('#body_comm').val('Escribir un comentario');
            $('#comm_num').text((parseInt($('#comm_num').text())+1));
            comm_tcom++;
            if(comm_tcom == 1) { $('#comentarios div:lt(2)').slideUp('fast',function(){$(this).remove();}); }
            if(Math.ceil((comm_tcom+1)/dn) > comm_totalpages && Math.ceil((comm_tcom+1)/dn) != 1) {
                $('#paginador1').show();
                $('#paginador2').show();
                comm_totalpages++;
                var eli1, ea1, etext1, eli2, ea2, etext2;
                $('<li class="numbers"><a id="pc_1_'+comm_totalpages+'" href="#" onclick="comments_goto(\''+comm_currentpage+'\');return false;">'+comm_totalpages+'</a></li>').appendTo($('#comment_ul_1'));
                $('<li class="numbers"><a id="pc_2_'+comm_totalpages+'" href="#" onclick="comments_goto(\''+comm_currentpage+'\');return false;">'+comm_totalpages+'</a></li>').appendTo($('#comment_ul_2'));
           	} else {
           	    $('#div_lastcomment').attr('id', 'div_lastcomment'+dlci++);
                $.ajax({
                  type: 'GET',
                  url: '/ajax/' + (group ? 'group' : 'post') + '-comments.php',
                  data: 'post_id=' + post_id + '&post_private=' + post_private + '&author=' + post_author + '&cpage=1&i=' + (comm_tcom-1) + '&if=1&lc=1' + (group ? '&group=' + group_id : ''),
               	  success: function(t) {
               	    $('#comentarios').html($('#comentarios').html()+t);
                    $('#div_lastcomment').slideDown('normal')
                  }
                });
            }
            if(comm_currentpage != comm_totalpages) { comments_goto(comm_totalpages); }
        } else {
            alert('Ha ocurrido un error inesperado, reintentalo m\xe1s tarde\n' + t);
        }
      }
	});
}

function comments_goto(page, group) {
	if(page < 1 || page > comm_totalpages) { return false; }
    $.ajax({
      type: 'GET',
      url: '/ajax/' + (group ? 'group' : 'post') + '-comments.php',
      data: 'post_id=' + post_id + '&post_private=' + post_private + '&author=' + post_author + '&cpage=' + page + '&if=1&i=' + ((parseInt(page)-1)*(group ? 20 : 100)) + '&dh=' + dh.substring(1) + (group ? '&group=' + group_id : ''),
      success: function(t) {
        if(t != '0') {
            $('#pc_1_' + comm_currentpage).removeClass('here');
            $('#pc_2_' + comm_currentpage).removeClass('here');
            $('#pc_1_' + page).addClass('here');
            $('#pc_2_' + page).addClass('here');
            if(page > 1) {
              $('#comm_b_1').removeClass('desactivado');
              $('#comm_b_2').removeClass('desactivado');
            } else {
              $('#comm_b_1').addClass('desactivado');
              $('#comm_b_2').addClass('desactivado');
            }
            if(page < comm_totalpages) {
              $('#comm_n_1').removeClass('desactivado');
              $('#comm_n_2').removeClass('desactivado');
            } else {
              $('#comm_n_1').addClass('desactivado');
              $('#comm_n_2').addClass('desactivado');
            }
            $('#comentarios').html(t);
            comm_currentpage = page;
        }
      }
    });

}

function update_last_comments(cat, group) {
    $('#ult_comm_loading').show();
	$.ajax({
	  type: 'GET',
      url: '/ajax/'+(group ? 'group-' : '')+'lastcomments.php',
      data: 'gc=' + cat + '&group=' + (group&&group!==true ? group : ''),
	  success: function(t) {
	    $('#ult_comm_loading').hide();
        $('#ult_comm').slideUp('slow').delay(1400).html(t).slideDown('slow');
      }
    });
}

function cite_comment(id, author, group) {
	var bc = $('#body_comm');
    if($(bc).val() == 'Escribir un comentario') { $(bc).val(''); }
    bc.focus();
    $.ajax({
      type: 'GET',
      url: '/ajax/' + (group === true ? 'group-' : '') + 'comment.php',
      data: 'id=' + id,
      success: function(t) {
        if(empty(t)) {
          alert('Error al citar');
        } else {
          $(bc).val($(bc).val()+(empty($(bc).val())?'':"\n")+'[quote='+author+']'+t+"[/quote]\n");
        }
      }
    });
}

function delete_comment(id, group) {
    $.ajax({
      type: 'GET',
      url:  '/ajax/' + (group ? 'group-' : '') + 'delete-comment.php',
      data: 'id=' + id,
      success: function(t) {
        if(t == '1') {
          comm_tcom--;
          $('.cmnt' + id).slideUp('normal',function(){$(this).remove();});
          $('#comm_num').text((parseInt($('#comm_num').text())-1));
          if(comm_tcom == 0) { $('#comentarios').append('<div class="clearfix"></div><div style="font-weight: bold; font-size: 14px;text-align: center;color: #666;margin: 20px 0 20px 175px;display:none;">Este post no tiene comentarios, &iexcl;S&eacute; el primero!</div>'); $('#comentarios div[style]').slideDown('fast'); }
	    } else {
	      alert(t);
        }
      }
    });
}

/*NUEVO POST*/

function np_previsualizar(form, vp, save){
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
    if(save) {
      var p = '';
      $('#npf input[type=checkbox]').each(function() {
        p += '&' + this.name + '=' + encodeURIComponent(this.value);
      });
      if(current_draft != 0) { p += '&id=' + current_draft; }
      $('#borrador-save').enablebutton(false);
      $.ajax({
        type: 'POST',
        url: '/ajax/save-draft.php',
        data: 'title=' + encodeURIComponent(form.title.value) + '&message=' + encodeURIComponent(form.message.value) + '&tags=' + encodeURIComponent(form.tags.value) + '&cat=' + form.category.options[form.category.selectedIndex].value + p,
        success: function(t) {
          $('#borrador-guardado').html(t.substring((t.indexOf('.')+1)));
          if(t.charAt(0) != '.') {
            current_draft = t.substring(0, t.indexOf('.'));
            window.onbeforeunload = null;
          }
        }
      });
      return;
    }

    $.ajax({
      type: 'POST',
      url: '/ajax/preview.php',
      data: 'title=' + encodeURIComponent(form.title.value) + '&message=' + encodeURIComponent(form.message.value),
      success: function(t) {
        $('#preview').html(t);
        $('#previewc').css('display', 'inline');
        scrollUp();
      }
    });
}

/*FAVORITOS*/

function add_to_favorites(postid) {
	mdiv();
    $.ajax({
      type: 'GET',
      url: '/ajax/addfavorites.php',
      data: 'id=' + postid,
      success: function(t) {
        if(t == '1') {
          $('#post_favorites_span').text((parseInt($('#post_favorites_span').text())+1));
          mdiv('ok', '&iexcl;Agregado a favoritos!');
        } else {
          mdiv('error', t);
        }
      }
	});
}

function filtro_favs(f, o, b) {
	if(f != 'categoria' && f != 'orden') { return false; }
    $.ajax({
      type: 'GET',
      url: '/ajax/favorites.php',
      data: 'shortby=' + (f == 'orden' ? o : orden_s) + '&cat=' + (f == 'categoria' ? o : categoria_s),
      success: function(t) {
        $('#resultados').html(t);
        if(f == 'categoria') {
          categoria_s = o;
        } else {
          $('#orden_e_'+orden_s).removeClass('here');
          $('#orden_e_'+o).addClass('here');
          orden_s = o;
        }
	  }
    });
    return;
}

function action_favs(id, post, time, action) {
	if(action != 1 && action != 2) { return false; }
    $.ajax({
      type: 'GET',
      url: '/ajax/action-favorites.php',
      data: 'id=' + id + '&post=' + post + '&time=' + time + '&action=' + action,
      success: function(t) {
        if(t == '1') {
          $('#action_img_'+id).attr({'src':(action==1 ? '/images/reactivar.png' : '/images/borrar.png'),'alt':(action==1 ? 'Reactivar' : 'Borrar'),'title':(action==1 ? 'Reactivar favorito' : 'Borrar favorito')});
          $('#change_status_'+id+'_1').css('display', (action == 1 ? 'none' : 'block'));
          $('#change_status_'+id+'_2').css('display', (action == 1 ? 'none' : 'block'));
          return false;
        } else {
            alert(t);
        }
      }
	});
    return;
}

/*REGISTRO*/

function registro_load_form(){
	mydialog.mask_close = false;
	mydialog.close_button = true;
    mydialog.class_aux = 'registro';
	mydialog.show(true);
	mydialog.title('Registro');
	mydialog.body('<br /><br />', 305);
	mydialog.buttons(false);
	mydialog.procesando_inicio('Cargando...', 'Registro');
	mydialog.center();

    $.get('/ajax/register-form.php', function(h) { mydialog.body(h, 305); mydialog.center(); });
}

/*MENSAJES*/

function mensajes_check(num) {
	var num = parseInt(num);
    var e = document.mensajes.elements;
	if(num == 1) {
	    $('input[type=checkbox]:not(:checked)', document.mensajes).attr('checked', 'checked');
    } else if(num == 2) {
    	$('input[type=checkbox]:checked', document.mensajes).removeAttr('checked');
    } else if(num == 3) {
        $('input[type=checkbox]').each(function(){if($(this).parent().hasClass('m-opciones')){$(this).attr('checked','checked');}else{$(this).removeAttr('checked');}});
    } else if(num == 4) {
    	$('input[type=checkbox]').each(function(){if($(this).parent().hasClass('m-opciones')){$(this).removeAttr('checked');}else{$(this).attr('checked','checked');}});
    } else if(num == 5) {
    	$('input[type=checkbox]').each(function(){if($(this).is(':checked')){$(this).removeAttr('checked');}else{$(this).attr('checked','checked');}});
    }
}

/*MONITOR*/
function monitor_pages(n) {
	if(n < 1 || n > 5 || n == mpct) { return false; }
    $('#mpli').show();
	$.ajax({
        type: 'GET',
        url: '/ajax/monitor-pages.php',
        data: 't=' + n,
        success: function(t) {
            $('#mpli').hide();
			$('#mpli' + mpct).removeClass('selected');
			$('#mpli' + n).addClass('selected');
			mpct = n;
			$('#mpsr').html(t);
		}
	});
}

/*COMUNIDADES*/

/*NUEVA COMUNIDAD*/
function groups_shortname_check(name) {
    $.ajax({
      type: 'GET',
      url: '/ajax/new-group.php',
      data: 'sa=check' + '&name=' + name,
	  success: function(t) {
	    $('#shortname').hide();
        $('#preview_showtname').removeClass().addClass((t==1 ? 'ok' : 'error'));
        $('#msg_crear_shortname').removeClass().addClas((t==1 ? 'ok' : 'error')).html((t==1 ? 'El nombre est&aacute; libre' : t));
      }
	});
}

function groups_categories(id) {
    $('#subcategoria').css('display', 'inline');
    $('#subcategoria_input').attr('disabled', 'disabled');
    $.ajax({
      type: 'GET',
      url: '/ajax/new-group.php',
      data: 'sa=subcat' + '&id=' + id,
      success: function(t) {
        if(t.substring(0, 1) == '0') { alert(t.substring(1)); return; }
        $('#subcategoria').hide();
        $('#subcategoria_input > option').remove();
        var si = document.getElementById('subcategoria_input');
        var spl = t.split(',');
        for(i=0;i<spl.length;i++) {
            var spl2 = spl[i].split(':');
            si.options[i] = new Option(spl2[0], spl2[1]);
        }
        si.disabled = false;
      }
	});
}
		
/*VISTA COMUNIDAD*/
var cmip = false;
function datos_comunidad_ver() {
    if(cmip) return false;
    cmip = true;
	if($('#cMasInfo').is(':hidden')){
	    $('#aVerMas').html('&laquo; Ver menos');
		$('#cMasInfo').animate({ height: 'toggle', opacity: 1 }, 1000, 0, function(){ cmip=false; });
	} else {
	    $('#aVerMas').html('Ver m&aacute;s &raquo;');
		$('#cMasInfo').animate({ height: 'toggle', opacity: 0 }, 1000, 0, function(){ $('#cMasInfo').hide(); cmip=false; });
	}
}

function participar_comunidad(id, rank, step) {
	if(!step) {
        mydialog.show();
		mydialog.title('Unirme a la comunidad');
		mydialog.body('&iquest;Seguro que quieres unirte a esta comunidad?<br />Tu rango ser&aacute;: <strong>' + rank + '</strong>');
		mydialog.buttons(true, true, 'SI', "participar_comunidad(" + id + ", '" + rank + "', true);", true, false, true, 'NO', 'close', true, true);
		mydialog.center();
    } else {
        mydialog.procesando_inicio('Cargando', 'Unirme a la comunidad');
        $.ajax({
          type: 'GET',
          url: '/ajax/groups-ee.php',
          data: 'sa=participate&id=' + id,
          success: function(t) {
            mydialog.procesando_fin();
        	if(t == '1') {
                mydialog.alert('Unirme a la comunidad', '&iexcl;Te has unido a la comunidad!', true);
            } else {
                mydialog.alert('Unirme a la comunidad', 'Error: '+t);
            }
          }
		});
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
        mydialog.procesando_inicio('Cargando', 'Dejar la comunidad');
        $.ajax({
          type: 'GET',
          url: '/ajax/groups-ee.php',
          data: 'sa=leave&id=' + id,
          success: function(t) {
            mydialog.procesando_fin();
        	if(t == '1') {
                mydialog.alert('Dejar la comunidad', 'Has abandonado a la comunidad', true);
            } else {
                mydialog.alert('Dejar la comunidad', 'Error: '+t);
            }
          }
		});
    }
}

function groups_vote_post(id, a) {
	if(a != -1 && a != 1) { alert('-.-'); return false; }
    $('#actions').html('Votando... ');
    $.ajax({
      type: 'GET',
      url: '/ajax/groups-vote.php',
      data: 'id=' + id + '&a=' + a,
	  success: function(t) {
	    if(t == '1') {
            $('#actions').html('Votado');
            var vt = parseInt($('#votos_total').text())+a;
            if(vt == 0) {
                $('#votos_total').css('visibility', 'hidden');
            } else {
                $('#votos_total').css('visibility', 'visible').removeClass().addClass('color_'+(vt>0 ? 'green' : 'red')).html((vt>0 ? '+' : '-')+vt);
            }
        } else {
            $('#actions').html('Error ');
            mydialog.alert('Error', t);
        }
      }
	});
}

var current_gmli = 1;
function groups_miembros_list(s, g, p) {
	if(!s) { s = group_members_s; }
	document.getElementById('gmli').style.display = 'inline';
	ajax.open("GET", "/ajax/groups-members-list.php?rnd=" + parseInt(Math.random()*99999) + "&i=1&s=" + s + "&group=" + g + "&p=" + p, true);
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
    mydialog.body('', 0, 0);
    mydialog.buttons(false, false);
	mydialog.procesando_inicio('Administrar usuario', 'Administrar usuario');
    mydialog.center();
    if(f.r_admin_user[0].id == 'r_suspender') {
    	var sus = f.r_suspender_dias[0].checked;
    } else {
    	var sus = false;
    }
	ajax.open("GET", "/ajax/groups-admin-user.php?rnd=" + parseInt(Math.random()*99999) + "&send=1&user=" + f.user.value + "&group=" + f.group.value + "&action=" + (f.r_admin_user[0].checked ? (f.r_admin_user[0].id == 'r_suspender' ? '1' : '3') : '2') + "&rank=" + f.s_rango.options[f.s_rango.selectedIndex].value + "&permanent=" + (sus ? '1' : '0') + "&days=" + f.i_suspender_dias.value + "&reason=" + f.causa.value, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
			mydialog.procesando_fin();
			if(ajax.responseText == '1') {
            	if(f.r_admin_user[0].checked) {
                	if(f.r_admin_user[0].id == 'r_suspender') {
                		mydialog.alert('&Eacute;xito', 'Usuario suspendido con &eacute;xito');
    mydialog.center();
                    } else {
                		mydialog.alert('&Eacute;xito', 'Usuario rehabilitado con &eacute;xito');
    mydialog.center();
                    }
                } else {
                	mydialog.alert('&Eacute;xito', 'Usuario cambiado de rango con &eacute;xito');
    mydialog.center();
                }
            } else {
            	mydialog.alert('Error', ajax.responseText);
    mydialog.center();
            }
        }
	};
	ajax.send(null);
}

function groups_adminusers_check(c) {
	if((!document.getElementById('r_suspender').checked && !document.getElementById('r_rehabilitar').checked && !document.getElementById('r_rango').checked) || (document.getElementById('r_suspender').checked && document.getElementById('r_rango').checked)) { return false; }
    var e = (document.getElementById('r_suspender').checked ? document.getElementById('r_suspender') : (document.getElementById('r_rehabilitar').checked ? document.getElementById('r_rehabilitar') : document.getElementById('r_rango')));
    var r = true;
    if(e.id == 'r_suspender') {
    	if(document.getElementById('t_causa').value == '') { r = false; }
        if(!document.getElementById('r_suspender_dias1').checked && !document.getElementById('r_suspender_dias2').checked) { r = false; }
        if(document.getElementById('r_suspender_dias2').checked && (document.getElementById('t_suspender').value == '' || document.getElementById('t_suspender').value.search(/^[0-9]+$/) == -1)) { r = false; }
	} else if(e.id == 'r_rehabilitar') {
    	if(document.getElementById('t_causa').value == '') { r = false; }
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

function groups_delete_post(id, autor, aceptar){
	if(!aceptar){
			mydialog.show();
			mydialog.title('Borrar tema');
			mydialog.body('&iquest;Seguro que deseas borrar este tema?');
			mydialog.buttons(true, true, 'SI', 'groups_delete_post(' + id + ', ' + (autor ? 'true' : 'false') + ', 1)', true, false, true, 'NO', 'close', true, true);
			mydialog.center();
			return;
	}else if(aceptar==1){
			mydialog.show();
			mydialog.title('Borrar tema');
			mydialog.body('Te pregunto de nuevo...<br />&iquest;Seguro que deseas borrar este tema?');
			mydialog.buttons(true, true, 'SI', 'groups_delete_post(' + id + ', ' + (autor ? 'true' : 'false') + ', 2)', true, false, true, 'NO', 'close', true, true);
			mydialog.center();
			return;
	} else if(aceptar==2 && !autor && cdp){
		  	mydialog.show();
		  	mydialog.title('Borrar tema');
		  	mydialog.body('Introduce una raz&oacute;n:<br /><input size="30" maxlength="30" id="borrar_post_razon_input" />');
		  	mydialog.buttons(true, true, 'SI', "groups_delete_post(" + id + ", document.getElementById('borrar_post_razon_input').value, 2)", true, false, true, 'NO', 'close', true, true);
		  	mydialog.center();
			document.getElementById('borrar_post_razon_input').focus();
		  	return;
	}
	mydialog.procesando_inicio('Eliminando...', 'Borrar tema');
    ajax.open("GET", "/ajax/group-action-post.php?rnd=" + parseInt(Math.random()*99999) + "&sa=delete&id=" + id + "&r=" + autor, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	mydialog.procesando_fin();
        	if(ajax.responseText == 1) {
            	mydialog.alert('Tema borrado', 'El tema ha sido borrado correctamente', true);
            } else {
            	mydialog.alert('Error', ajax.responseText);
            }
        }
	};
	ajax.send(null);
}

function groups_fijar_post(id, t, aceptar) {
	if(!aceptar){
			mydialog.show();
			mydialog.title(t);
			mydialog.body('&iquest;' + (t.charAt(0).toLowerCase() == 'd' ? 'Desfijar' : 'Fijar') + ' este tema?');
			mydialog.buttons(true, true, 'SI', 'groups_fijar_post(' + id + ', \'' + t + '\', 1)', true, false, true, 'NO', 'close', true, true);
			mydialog.center();
			return;
    }
	mydialog.procesando_inicio('Eliminando...', t);
    ajax.open("GET", "/ajax/group-action-post.php?rnd=" + parseInt(Math.random()*99999) + "&sa=stick&id=" + id + "&ft=" + (t.charAt(0).toLowerCase() == 'd' ? '2' : '1'), true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	mydialog.procesando_fin();
        	if(ajax.responseText == 1) {
            	var fod = (t.charAt(0).toLowerCase() == 'f' ? 'fijado' : 'desfijado');
            	mydialog.alert('Post ' + fod, 'El tema ha sido ' + fod + ' correctamente');
            } else {
            	mydialog.alert('Error', ajax.responseText);
            }
        }
	};
	ajax.send(null);
}

function mygroups_show(page, orderby) {
	if(!orderby) { orderby = orderBy; }
	if(page < 1 || page > totalPages || isNaN(page) || (orderby != 'name' && orderby != 'rank' && orderby != 'members' && orderby != 'posts') || (page == currentPage && orderby == orderBy)) { return false; }
    $.ajax({
    	type: 'GET',
        url: '/ajax/my-groups.php',
        data: 'ob=' + orderby + '&p=' + page,
        beforeSend: function() { $('#mygroups_loading').css('display', 'inline'); },
        success: function(t) {
        	$('#mygroups_loading').css('display', 'none');
            var spl = t.split(t.substr((t.indexOf('.')+1), t.substr(0, t.indexOf('.'))));
            $('#showResult').html(spl[4]);
            if(orderby != orderBy) {
            	$('#mgb' + orderBy).removeClass('here');
                $('#mgb' + orderby).addClass('here');
             	orderBy = orderby;
            }
            if(page != currentPage) {
            	$('#dstde').html(spl[1] + ' - ' + spl[2]);
                currentPage = page;
            }
		}
	});
}

function delete_group(id, aceptar){
	if(!aceptar){
			mydialog.show();
			mydialog.title('Borrar comunidad');
			mydialog.body("&iquest;Seguro que deseas borrar la comunidad?<br />Los temas, comentarios y usuarios no podr&aacute;n ser recuperados.");
			mydialog.buttons(true, true, 'SI', 'delete_group(' + id + ', 1)', true, false, true, 'NO', 'close', true, true);
			mydialog.center();
			return;
	}else if(aceptar==1){
			mydialog.show();
			mydialog.title('Borrar comunidad');
			mydialog.body('Te pregunto de nuevo...<br />&iquest;Seguro que deseas borrar la comunidad?');
			mydialog.buttons(true, true, 'SI', 'delete_group(' + id + ', 2)', true, false, true, 'NO', 'close', true, true);
			mydialog.center();
			return;
	}
	mydialog.procesando_inicio('Eliminando...', 'Borrar comunidad');
    ajax.open("GET", "/ajax/delete-group.php?rnd=" + parseInt(Math.random()*99999) + "&id=" + id, true);
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
        	mydialog.procesando_fin();
        	if(ajax.responseText == 1) {
            	mydialog.alert('Comunidad borrada', 'La comunidad ha sido borrada correctamente', true);
            } else {
            	mydialog.alert('Error', ajax.responseText);
            }
        }
	};
	ajax.send(null);
}

function poll_r(b) {
	$('#vote').toggle();
    $('#results').toggle();
	$(b).html(($('#vote').is(':visible') ? 'Ver resultados' : 'Ver opciones'));
}

function poll_vote(o) {
	if(iVj) { mydialog.alert('Error', 'Ya has votado esta encuesta'); return false; }
    if(iVn) { return false; }
    if($('#vote input[type="radio"]:checked').length == 0) {
    	mydialog.alert('Error', 'No has seleccionado ninguna opci&oacute;n');
        return false;
    }
    $.ajax({
    	type: 'GET',
        url: '/ajax/pollv.php',
        data: 'p=' + poll_id + '&o=' + $('#vote input[type="radio"]:checked').val(),
        beforeSend: function() { $(o).addClass('disabled'); $('#vl').show(); iVn = true; },
        success: function(t) {
        	$('#vl').hide();
            if(t == '1') {
            	iVn = false;
                iVj = true;
            	/*mydialog.alert('YEAH!', 'Has votado en la encuesta');*/
            	nvotes[o]++;
           } else {
           		mydialog.alert('Error', t);
           }
		}
	});
}

function poll_add_opt() {
	$('#poll_options').append('<div><br /><input class="c_input" style="width:80%;" maxlength="50" type="text" name="poll_opc' + ++poll_con + '" /><a style="float:right;margin-top:15px;cursor:pointer;" class="dopt"><img src="/images/borrar.png" width="10" height="10" /> Quitar opci&oacute;n</a></div>');
}

/*SEGUIR*/
function follow(what, who, obj, hide, unfollow, disable, inline, uClass) {
	what = what.toString();
    var iwhat = parseInt(what);
    if(iwhat < 1 || iwhat > 4) { return false; }
    $.ajax({
    	type: 'GET',
        url: '/ajax/follow.php',
        data: 'what=' + what + '&who=' + who + '&follow=' + (unfollow ? '2' : '1'),
        beforeSend: function() { $(obj).addClass('spinner'); },
        success: function(t) {
        	$(obj).removeClass('spinner');
            if(t == '1') {
            	switch(what) {
                	case '1':
                    	var ws = 'post';
                    break;
                    case '2':
                    	var ws = 'user';
                    break;
                    case '3':
                    	var ws = 'group';
                    break;
                    case '4':
                    	var ws = 'gpost';
                    break;
                }
            	$(hide).css('display', 'none');
                $((uClass ? '.' + (unfollow ? 'follow' : 'unfollow') + '_' + ws + '_' + who : '#' + (unfollow ? 'follow' : 'unfollow') + '_' + ws)).css('display', (inline ? 'inline' : 'block'));
                if(disable) {
                	if(unfollow) {
                    	$(disable).addClass('disabled');
                    } else {
                    	$(disable).removeClass('disabled');
                    }
                }
                document.getElementById('numf_' + ws).innerHTML = (unfollow ? parseInt(document.getElementById('numf_' + ws).innerHTML)-1 : parseInt(document.getElementById('numf_' + ws).innerHTML)+1);
            } else {
            	mydialog.alert('Error', t);
            }
		}
	});
}

/*NOTIFICACIONES*/
var notifications_are_displayed = false;
function noti_showlast() {
	if(notifications_are_displayed === true) { noti_hidelast(); return false; }
	$('div.alertas').remove();
    if(noti_alert_time) { clearInterval(noti_alert_time); }
	$('a[name=Monitor]').parent('li').addClass('monitor-notificaciones');
	$('div.notificaciones-list').show().focus();
	$('div.notificaciones-list > ul > li > a[title]').tipsy({gravity:'s'});
	notifications_are_displayed = true;
    $.get('/ajax/markasread.php');
}

function noti_hidelast() {
	if(notifications_are_displayed === false) { noti_showlast(); return false; }
	$('a[name=Monitor]').parent('li').removeClass('monitor-notificaciones');
	$('div.notificaciones-list').hide();
	notifications_are_displayed = false;
}

function noti_alert_animate() {
    $('div.alertas').animate({top:'-=3px'},100,null,function(){$('div.alertas').animate({top:'+=6px'},100,null, function(){$('div.alertas').animate({top:'-=5px'},100,null,function(){$('div.alertas').animate({top:'+=4px'},100,null, function(){$('div.alertas').animate({top:'-=4px'},100,null,function(){$('div.alertas').animate({top:'+=2px'},100)})})})})});
}

function noti_update() {
	if(!isLogged || notifications_are_displayed === true) { return false; }
	$.ajax({
    	type: 'GET',
        url: '/ajax/lastnotis.php',
        data: 'last=' + noti_last,
        beforeSend: function() { $('a[name=Monitor] span').addClass('spinner'); },
        success: function(t) {
        	$('a[name=Monitor] span').removeClass('spinner');
            if(t != '0') {
            	var hmn = t.substr(0, t.indexOf(','));
                var text = t.substr(t.indexOf(',')+1);
                if(!$('div.alertas').length) { $('div.userInfoLogin > ul > li.monitor').append('<div class="alertas"><a><span>' + hmn + '</span></a></div>'); } else { $('div.alertas > a > span').text(hmn); }
            	$('div.notificaciones-list ul').html(text);
                noti_alert_animate();
                clearInterval(noti_alert_time);
                var noti_alert_time = setInterval('noti_alert_animate();', 15000);
            }
		}
	});
}

if(isLogged === true) { setInterval('noti_update();', 10000); }

var noti_filter_c = '';
var noti_filter_t = false;
function notis_filter(n, act) {
	if(n === false) {
    	$.ajax({
    		type: 'GET',
        	url: '/ajax/notisw.php',
        	data: 'c=' + noti_filter_c.substring(1),
        	beforeSend: function() { $('#filter_loading').show();$('#post-izquierda input').attr('disabled', 'disabled'); },
        	success: function(t) {
        		$('#filter_loading').hide();
           		if(t == '1') {
					$('#post-izquierda input').removeAttr('disabled');
	            } else {
                	mydialog.alert('Error', t);
                }
			}
		});
        noti_filter_c = '';
        return;
    }
    if(isNaN(n)) { return false; }
    noti_filter_c += ',' + n.toString() + ':' + (act === true ? '1' : '2');
    if(noti_filter_t !== false) { clearTimeout(noti_filter_t); noti_filter_t = false; }
    noti_filter_t = setTimeout("notis_filter(false);", 3000);
}

/*PERFIL*/

function profile_tabs(tab) {
	if(tab < 1 || tab > 7 || tab == profile_current_tab) { return false; }
    $.ajax({
    	type: 'GET',
        url: '/ajax/profile.php',
        data: 'tab=' + tab + '&user=' + profile_current_user,
        beforeSend: function() { $('#perfil_loading').css('display', 'block'); },
        success: function(t) {
        	$('#perfil_loading').css('display', 'none');
            if(t.charAt(0) == '0') {
            	alert('Error: ' + t.substring(1));
            } else {
            	$('div.perfil-main').html(t);
                $('#profile_tab_' + profile_current_tab).removeClass('selected');
                $('#profile_tab_' + tab).addClass('selected');
                profile_current_tab = tab;
            }
		}
	});
}
   
/*CHAT*/

function chat_send() {
	var input = document.getElementById('cm');
	if(input.value.length == 0) { alert('Escribe un mensaje'); }
	ajax.open("POST", "/ajax/chat.php?rnd=" + parseInt(Math.random()*99999) + "&sa=send", true);
	ajax.send("m=" + encodeURIComponent(input.value));
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
			if(ajax.responseText == '1') {
				$('#chat_bc').append($('<div></div>').attr('id','m'+spl[0]).addClass('chat_m_'+(++chat_m_n)).css('display','none').slideDown('normal'));
				/*var div = document.createElement('div');
				div.id = 'm' + spl[0];
				div.class = 'chat_m_' + (++chat_m_n);
				div.style.display
				document.getElementById('chat_bc').appendChild(div);*/
			} else { alert("Error al enviar el mensaje\n" + ajax.responseText); }
        	}
	};
}

function chat_delete(id) {

}

/*OTROS*/

function comment_vote(id, a, obj) {
	$.get('/ajax/comment-vote.php', 'id=' + id + '&a=' + a, function(r) { if(r.substring(0, 1) == '0') { mydialog.alert('Error', r.substring(1)); } else { $(obj).parent().parent().children('span.votos_total').css('color', (r >= 0 ? 'green' : 'red')).html((r > 0 ? '+' : '') + r); }}, 'html');
}

function comment_bury(id) {
	$.get('/ajax/comment-bury.php', 'id=' + id, function(r) { mydialog.alert('Denuncia', r); }, 'html');
}

function comment_c(id, a) {
	if(!a) {
		mydialog.mask_close = false;
		mydialog.close_button = true;
		mydialog.show(true);
		mydialog.title('Denuncias');
		mydialog.body('&iquest;Quieres aceptar las denuncias??', 305);
		mydialog.buttons(true, true, 'Aceptar', 'comment_c(' + id + ', \'a\');', true, false, true, 'Rechazar', 'comment_c(' + id + ', \'r\');', true, false, 'btnGreen', 'btnDelete');
		mydialog.center();
    } else {
    	mydialog.body('');
        mydialog.buttons(false);
        mydialog.procesando_inicio();
        mydialog.center();
        $.get('/ajax/comment-complaints.php', 'id=' + id + '&a=' + a, function(r) { mydialog.procesando_fin(); if(r == '1') { mydialog.close(); if(a == 'a') { $('#div_cmnt_' + id).slideUp('fast'); } else { $('#div_cmnt_' + id).removeClass('especial2 especial3').find('a.dcomentarios').remove(); } } else { mydialog.alert('Denuncias', r); } }, 'html');
    }
}

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
function TopsTabs(parent, tab) {
		if($('.box_cuerpo ol.filterBy#filterBy'+tab).is(':visible')) return;
		$('#'+parent+' > .box_cuerpo div.filterBy a').removeClass('here');
		$('.box_cuerpo div.filterBy a#'+tab).addClass('here');
		$('#'+parent+' > .box_cuerpo ol.filterBy').fadeOut();
		$('.box_cuerpo ol.filterBy#filterBy'+tab).fadeIn();
}

function scrollUp() {
	var cs = (document.documentElement && document.documentElement.scrollTop)? document.documentElement : document.body;
	var step = Math.ceil(cs.scrollTop / 10);
	scrollBy(0, (step-(step*2)));
	if(cs.scrollTop>0) {
    	setTimeout('scrollUp()', 40);
	}
}

var mDs = '0';

function recommend_post(id, s) {
	if(!s) {
    	mydialog.show();
    	mydialog.title('Recomendar post');
        mydialog.body('&iquest;Quieres recomendar este post a tus seguidores?');
        mydialog.buttons(true, true, 'Recomendar', "recommend_post('" + id + "', true);", true, false, true, 'Cancelar', 'close', true, false);
        mydialog.show();
        mydialog.center();
        return;
    }
    mydialog.procesando_inicio();
	$.ajax({
    	type: 'GET',
        url: '/ajax/recommend.php',
        data: 'p=' + id,
        success: function(t) {
        	mydialog.procesando_fin();
        	if(t == '1') {
            	mydialog.close();
            } else {
            	mydialog.alert('Error', t);
            }
		}
	});
}

/*FT*/

/*outerHTML*/
(function($){$.fn.outerHTML=function(s){return (s) ? this.before(s).remove() : $("<p>").append(this.eq(0).clone()).html();}})(jQuery);

/*Desactivar boton ^^)*/
(function($){$.fn.enablebutton=function(a){if(a!==false){$(this).removeClass('disabled').removeAttr('disabled');}else{$(this).addClass('disabled').attr('disabled','disabled');}}})(jQuery);

/*tipsy*/
(function($){$.fn.tipsy=function(d){d=$.extend({fade:false,gravity:'n'},d||{});var e=null,cancelHide=false;this.hover(function(){$.data(this,'cancel.tipsy',true);var a=$.data(this,'active.tipsy');if(!a){a=$('<div class="tipsy"><div class="tipsy-inner">'+$(this).attr('title')+'</div></div>');a.css({position:'absolute',zIndex:100000});$(this).attr('title','');$.data(this,'active.tipsy',a)}var b=$.extend({},$(this).offset(),{width:this.offsetWidth,height:this.offsetHeight});a.remove().css({top:0,left:0,visibility:'hidden',display:'block'}).appendTo(document.body);var c=a[0].offsetWidth,actualHeight=a[0].offsetHeight;switch(d.gravity.charAt(0)){case'n':a.css({top:b.top+b.height,left:b.left+b.width/2-c/2}).addClass('tipsy-north');break;case's':a.css({top:b.top-actualHeight,left:b.left+b.width/2-c/2}).addClass('tipsy-south');break;case'e':a.css({top:b.top+b.height/2-actualHeight/2,left:b.left-c}).addClass('tipsy-east');break;case'w':a.css({top:b.top+b.height/2-actualHeight/2,left:b.left+b.width}).addClass('tipsy-west');break}if(d.fade){a.css({opacity:0,display:'block',visibility:'visible'}).animate({opacity:1})}else{a.css({visibility:'visible'})}},function(){$.data(this,'cancel.tipsy',false);var a=this;if($.data(this,'cancel.tipsy'))return;var b=$.data(a,'active.tipsy');if(d.fade){b.stop().fadeOut(function(){$(this).remove()})}else{b.remove()}})}})(jQuery);

/* MARITUP */

//Botones posts
mySettings = {
	nameSpace: 'markItUp',
	markupSet: [
		{name:'Negrita', key:'B', openWith:'[b]', closeWith:'[/b]'},
		{name:'Cursiva', key:'I', openWith:'[i]', closeWith:'[/i]'},
		{name:'Subrayado', key:'U', openWith:'[u]', closeWith:'[/u]'},
		{separator:'-' },
		{name:'Alinear a la izquierda', key:'', openWith:'[align=left]', closeWith:'[/align]'},
		{name:'Centrar', key:'', openWith:'[align=center]', closeWith:'[/align]'},
		{name:'Alinear a la derecha', key:'', openWith:'[align=right]', closeWith:'[/align]'},
		{separator:'-' },
		{name:'Color', dropMenu: [
			{name:'Rojo oscuro', openWith:'[color=darkred]', closeWith:'[/color]' },
			{name:'Rojo', openWith:'[color=red]', closeWith:'[/color]' },
			{name:'Naranja', openWith:'[color=orange]', closeWith:'[/color]' },
			{name:'Marron', openWith:'[color=brown]', closeWith:'[/color]' },
			{name:'Amarillo', openWith:'[color=yellow]', closeWith:'[/color]' },
			{name:'Verde', openWith:'[color=green]', closeWith:'[/color]' },
			{name:'Oliva', openWith:'[color=olive]', closeWith:'[/color]' },
			{name:'Cyan', openWith:'[color=cyan]', closeWith:'[/color]' },
			{name:'Azul', openWith:'[color=blue]', closeWith:'[/color]' },
			{name:'Azul oscuro', openWith:'[color=darkblue]', closeWith:'[/color]' },
			{name:'Indigo', openWith:'[color=indigo]', closeWith:'[/color]' },
			{name:'Violeta', openWith:'[color=violet]', closeWith:'[/color]' },
			{name:'Negro', openWith:'[color=black]', closeWith:'[/color]' }
		]},
		{name:'Tamaño', dropMenu :[
			{name:'Pequeña', openWith:'[size=9]', closeWith:'[/size]' },
			{name:'Normal', openWith:'[size=12]', closeWith:'[/size]' },
			{name:'Grande', openWith:'[size=18]', closeWith:'[/size]' },
			{name:'Enorme', openWith:'[size=24]', closeWith:'[/size]' }
		]},
		{name:'Fuente', dropMenu :[
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
		{name:'Insertar video de YouTube', beforeInsert:function(h){ markit_yt(h); }},
		{name:'Insertar video de Google Video', beforeInsert:function(h){ markit_gv(h); }},
		{name:'Insertar archivo SWF', beforeInsert:function(h){ markit_swf(h); }},
		{name:'Insertar Imagen', beforeInsert:function(h){ markit_img(h); }},
		{name:'Insertar Link', beforeInsert:function(h){ markit_url(h); }},
		{name:'Citar', beforeInsert:function(h){ markit_quote(h); }}
	]
};

//Botones comentarios
mySettings_cmt = {
	nameSpace: 'markitcomment',
	resizeHandle: false,
	markupSet: [
		{name:'Negrita', key:'B', openWith:'[b]', closeWith:'[/b]'},
		{name:'Cursiva', key:'I', openWith:'[i]', closeWith:'[/i]'},
		{name:'Subrayado', key:'U', openWith:'[u]', closeWith:'[/u]'},
		{name:'Insertar video de YouTube', beforeInsert:function(h){ markit_yt(h); }},
		{name:'Insertar Imagen', beforeInsert:function(h){ markit_img(h); }},
		{name:'Insertar Link', beforeInsert:function(h){ markit_url(h); }},
		{name:'Citar', beforeInsert:function(h){ markit_quote(h); }}
	]
};

//Funciones botones especiales
function markit_yt(h){
	var msg = prompt("Ingrese el ID del video de YouTube:\nPor ejemplo: CACqDFLQIXI", 'Ingrese solo el ID de YouTube');
	if(msg != null){
		h.replaceWith = '[swf=http://www.youtube.com/v/' + msg + ']\nlink: [url]http://www.youtube.com/?watch=' + msg + '[/url]\n';
		h.openWith = '';
		h.closeWith = '';
	}else{
		h.replaceWith = '';
		h.openWith = '';
		h.closeWith = '';
	}
}
function markit_gv(h){
	var msg = prompt("Ingrese el ID del video de Google:\nPor ejemplo: -5331378923498461236", 'Ingrese solo el ID de Google Video');
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
		var msg = prompt('Ingrese la URL del archivo SWF', 'http://');
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
		var msg = prompt('Ingrese la URL de la imagen', 'http://');
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
		var msg = prompt('Ingrese la URL que desea postear', 'http://');
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
		var msg = prompt('Ingrese la URL que desea postear', 'http://');
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

/*AUTOGROW*/
(function(b){var c=null;b.fn.autogrow=function(o){return this.each(function(){new b.autogrow(this,o)})};b.autogrow=function(e,o){this.options=o||{};this.dummy=null;this.interval=null;this.line_height=this.options.lineHeight||parseInt(b(e).css('line-height'));this.min_height=this.options.minHeight||parseInt(b(e).css('min-height'));this.max_height=this.options.maxHeight||parseInt(b(e).css('max-height'));this.textarea=b(e);if(this.line_height==NaN)this.line_height=0;this.init()};b.autogrow.fn=b.autogrow.prototype={autogrow:'1.2.2'};b.autogrow.fn.extend=b.autogrow.extend=b.extend;b.autogrow.fn.extend({init:function(){var a=this;this.textarea.css({overflow:'hidden',display:'block'});this.textarea.bind('focus',function(){a.startExpand()}).bind('blur',function(){a.stopExpand()});this.checkExpand()},startExpand:function(){var a=this;this.interval=window.setInterval(function(){a.checkExpand()},400)},stopExpand:function(){clearInterval(this.interval)},checkExpand:function(){if(this.dummy==null){this.dummy=b('<div></div>');this.dummy.css({'font-size':this.textarea.css('font-size'),'font-family':this.textarea.css('font-family'),'width':this.textarea.css('width'),'padding':this.textarea.css('padding'),'line-height':this.line_height+'px','overflow-x':'hidden','position':'absolute','top':0,'left':-9999}).appendTo('body')}var a=this.textarea.val().replace(/(<|>)/g,'');if($.browser.msie){a=a.replace(/\n/g,'<BR>new')}else{a=a.replace(/\n/g,'<br>new')}if(this.dummy.html()!=a){this.dummy.html(a);if(this.max_height>0&&(this.dummy.height()+this.line_height>this.max_height)){this.textarea.css('overflow-y','auto')}else{this.textarea.css('overflow-y','hidden');if(this.textarea.height()<this.dummy.height()+this.line_height||(this.dummy.height()<this.textarea.height())){this.textarea.animate({height:(this.dummy.height()+this.line_height)+'px'},100)}}}}})})(jQuery);

/*MYDIALOG*/

var mydialog = {

is_show: false,
class_aux: '',
mask_close: true,
close_button: false,
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
	if(this.mask_close)
		$('#mask').click(function(){ mydialog.close() });
	else
		$('#mask').unbind('click');

	if(this.close_button)
		$('#mydialog #dialog').append('<img class="close_dialog" src="/images/close.gif" onclick="mydialog.close()" />');
	else
		$('#mydialog #dialog .close_dialog').remove();

	$('#mask').click(function(){ mydialog.close() }).css({'width':$(document).width(),'height':$(document).height(),'display':'block'});

	if(jQuery.browser.msie && jQuery.browser.version<7) //Fix IE<7 <- fack you
		$('#mydialog #dialog').css('position', 'absolute');
	else
		$('#mydialog #dialog').css('position', 'fixed');
	$('#mydialog #dialog').fadeIn('fast');
},
close: function(){
	//Vuelve todos los parametros por default
	this.class_aux = '';
	this.mask_close = true;
	this.close_button = false;

	this.is_show = false;
	$('#mask').css('display', 'none');
	$('#mydialog #dialog').fadeOut('fast', function(){ $(this).remove() });
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
	if(!width && jQuery.browser.opera) // IE6 FUCK YOU
		width = '400px';
	$('#mydialog #dialog').width(width?width:'').height(height?height:'');
	$('#mydialog #modalBody').html(body);
},
buttons: function(display_all, btn1_display, btn1_val, btn1_action, btn1_enabled, btn1_focus, btn2_display, btn2_val, btn2_action, btn2_enabled, btn2_focus, btn1_class, btn2_class){
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
		html += '<input type="button" class="mBtn ' + (btn1_class ? btn1_class :'btnOk') +(btn1_enabled?'':' disabled')+'" style="display:'+(btn1_display?'inline-block':'none')+'"'+(btn1_display?' value="'+btn1_val+'"':'')+(btn1_display?' onclick="'+btn1_action+'"':'')+(btn1_enabled?'':' disabled')+' />';
	if(btn2_display)
		html += ' <input type="button" class="mBtn ' + (btn2_class ? btn2_class :'btnCancel') + (btn2_enabled?'':' disabled')+'" style="display:'+(btn2_display?'inline-block':'none')+'"'+(btn2_display?' value="'+btn2_val+'"':'')+(btn2_display?' onclick="'+btn2_action+'"':'')+(btn2_enabled?'':' disabled')+' />';
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
	this.buttons(true, true, 'Aceptar', (reload ? 'location.reload();' : 'close'), true, true, false);
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

eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(3($){$.24.T=3(f,g){E k,v,A,F;v=A=F=7;k={C:\'\',12:\'\',U:\'\',1j:\'\',1A:8,25:\'26\',1k:\'~/2Q/1B.1C\',1b:\'\',27:\'28\',1l:8,1D:\'\',1E:\'\',1F:{},1G:{},1H:{},1I:{},29:[{}]};$.V(k,f,g);2(!k.U){$(\'2R\').1c(3(a,b){1J=$(b).14(0).2S.2T(/(.*)2U\\.2V(\\.2W)?\\.2X$/);2(1J!==2a){k.U=1J[1]}})}4 G.1c(3(){E d,u,15,16,p,H,L,P,17,1m,w,1n,M,18;d=$(G);u=G;15=[];18=7;16=p=0;H=-1;k.1b=1d(k.1b);k.1k=1d(k.1k);3 1d(a,b){2(b){4 a.W(/("|\')~\\//g,"$1"+k.U)}4 a.W(/^~\\//,k.U)}3 2b(){C=\'\';12=\'\';2(k.C){C=\'C="\'+k.C+\'"\'}l 2(d.1K("C")){C=\'C="T\'+(d.1K("C").2c(0,1).2Y())+(d.1K("C").2c(1))+\'"\'}2(k.12){12=\'N="\'+k.12+\'"\'}d.1L(\'<z \'+12+\'></z>\');d.1L(\'<z \'+C+\' N="T"></z>\');d.1L(\'<z N="2Z"></z>\');d.2d("2e");17=$(\'<z N="30"></z>\').2f(d);$(1M(k.29)).1N(17);1m=$(\'<z N="31"></z>\').1O(d);2(k.1l===8&&$.X.32!==8){1l=$(\'<z N="33"></z>\').1O(d).1e("34",3(e){E h=d.2g(),y=e.2h,1o,1p;1o=3(e){d.2i("2g",35.36(20,e.2h+h-y)+"37");4 7};1p=3(e){$("1C").1P("2j",1o).1P("1q",1p);4 7};$("1C").1e("2j",1o).1e("1q",1p)});1m.2k(1l)}d.2l(1Q).38(1Q);d.1e("1R",3(e,a){2(a.1r!==7){14()}2(u===$.T.2m){Y(a)}});d.1f(3(){$.T.2m=G})}3 1M(b){E c=$(\'<Z></Z>\'),i=0;$(\'B:2n > Z\',c).2i(\'39\',\'q\');$.1c(b,3(){E a=G,t=\'\',1s,B,j;1s=(a.19)?(a.1S||\'\')+\' [3a+\'+a.19+\']\':(a.1S||\'\');19=(a.19)?\'2o="\'+a.19+\'"\':\'\';2(a.2p){B=$(\'<B N="3b">\'+(a.2p||\'\')+\'</B>\').1N(c)}l{i++;2q(j=15.6-1;j>=0;j--){t+=15[j]+"-"}B=$(\'<B N="2r 2r\'+t+(i)+\' \'+(a.3c||\'\')+\'"><a 3d="" \'+19+\' 1s="\'+1s+\'">\'+(a.1S||\'\')+\'</a></B>\').1e("3e",3(){4 7}).2s(3(){4 7}).1q(3(){2(a.2t){3f(a.2t)()}Y(a);4 7}).2n(3(){$(\'> Z\',G).3g();$(D).3h(\'2s\',3(){$(\'Z Z\',17).2u()})},3(){$(\'> Z\',G).2u()}).1N(c);2(a.2v){15.3i(i);$(B).2d(\'3j\').2k(1M(a.2v))}}});15.3k();4 c}3 2w(c){2(c){c=c.3l();c=c.W(/\\(\\!\\(([\\s\\S]*?)\\)\\!\\)/g,3(x,a){E b=a.1T(\'|!|\');2(F===8){4(b[1]!==2x)?b[1]:b[0]}l{4(b[1]===2x)?"":b[0]}});c=c.W(/\\[\\!\\[([\\s\\S]*?)\\]\\!\\]/g,3(x,a){E b=a.1T(\':!:\');2(18===8){4 7}1U=3m(b[0],(b[1])?b[1]:\'\');2(1U===2a){18=8}4 1U});4 c}4""}3 I(a){2($.3n(a)){a=a(P)}4 2w(a)}3 1g(a){J=I(L.J);1a=I(L.1a);Q=I(L.Q);O=I(L.O);2(Q!==""){q=J+Q+O}l 2(m===\'\'&&1a!==\'\'){q=J+1a+O}l{q=J+(a||m)+O}4{q:q,J:J,Q:Q,1a:1a,O:O}}3 Y(a){E b,j,n,i;P=L=a;14();$.V(P,{1t:"",U:k.U,u:u,m:(m||\'\'),p:p,v:v,A:A,F:F});I(k.1D);I(L.1D);2(v===8&&A===8){I(L.3o)}$.V(P,{1t:1});2(v===8&&A===8){R=m.1T(/\\r?\\n/);2q(j=0,n=R.6,i=0;i<n;i++){2($.3p(R[i])!==\'\'){$.V(P,{1t:++j,m:R[i]});R[i]=1g(R[i]).q}l{R[i]=""}}o={q:R.3q(\'\\n\')};11=p;b=o.q.6+(($.X.1V)?n:0)}l 2(v===8){o=1g(m);11=p+o.J.6;b=o.q.6-o.J.6-o.O.6;b-=1u(o.q)}l 2(A===8){o=1g(m);11=p;b=o.q.6;b-=1u(o.q)}l{o=1g(m);11=p+o.q.6;b=0;11-=1u(o.q)}2((m===\'\'&&o.Q===\'\')){H+=1W(o.q);11=p+o.J.6;b=o.q.6-o.J.6-o.O.6;H=d.K().1h(p,d.K().6).6;H-=1W(d.K().1h(0,p))}$.V(P,{p:p,16:16});2(o.q!==m&&18===7){2y(o.q);1X(11,b)}l{H=-1}14();$.V(P,{1t:\'\',m:m});2(v===8&&A===8){I(L.3r)}I(L.1E);I(k.1E);2(w&&k.1A){1Y()}A=F=v=18=7}3 1W(a){2($.X.1V){4 a.6-a.W(/\\n*/g,\'\').6}4 0}3 1u(a){2($.X.2z){4 a.6-a.W(/\\r*/g,\'\').6}4 0}3 2y(a){2(D.m){E b=D.m.1Z();b.2A=a}l{d.K(d.K().1h(0,p)+a+d.K().1h(p+m.6,d.K().6))}}3 1X(a,b){2(u.2B){2($.X.1V&&$.X.3s>=9.5&&b==0){4 7}1i=u.2B();1i.3t(8);1i.2C(\'21\',a);1i.3u(\'21\',b);1i.3v()}l 2(u.2D){u.2D(a,a+b)}u.1v=16;u.1f()}3 14(){u.1f();16=u.1v;2(D.m){m=D.m.1Z().2A;2($.X.2z){E a=D.m.1Z(),1w=a.3w();1w.3x(u);p=-1;3y(1w.3z(a)){1w.2C(\'21\');p++}}l{p=u.2E}}l{p=u.2E;m=d.K().1h(p,u.3A)}4 m}3 1B(){2(!w||w.3B){2(k.1j){w=3C.2F(\'\',\'1B\',k.1j)}l{M=$(\'<2G N="3D"></2G>\');2(k.25==\'26\'){M.1O(1m)}l{M.2f(17)}w=M[M.6-1].3E||3F[M.6-1]}}l 2(F===8){2(M){M.3G()}w.2H();w=M=7}2(!k.1A){1Y()}}3 1Y(){2(w.D){3H{22=w.D.2I.1v}3I(e){22=0}w.D.2F();w.D.3J(2J());w.D.2H();w.D.2I.1v=22}2(k.1j){w.1f()}}3 2J(){2(k.1b!==\'\'){$.2K({2L:\'3K\',2M:7,2N:k.1b,28:k.27+\'=\'+3L(d.K()),2O:3(a){23=1d(a,1)}})}l{2(!1n){$.2K({2M:7,2N:k.1k,2O:3(a){1n=1d(a,1)}})}23=1n.W(/<!-- 3M -->/g,d.K())}4 23}3 1Q(e){A=e.A;F=e.F;v=(!(e.F&&e.v))?e.v:7;2(e.2L===\'2l\'){2(v===8){B=$("a[2o="+3N.3O(e.1x)+"]",17).1y(\'B\');2(B.6!==0){v=7;B.3P(\'1q\');4 7}}2(e.1x===13||e.1x===10){2(v===8){v=7;Y(k.1H);4 k.1H.1z}l 2(A===8){A=7;Y(k.1G);4 k.1G.1z}l{Y(k.1F);4 k.1F.1z}}2(e.1x===9){2(A==8||v==8||F==8){4 7}2(H!==-1){14();H=d.K().6-H;1X(H,0);H=-1;4 7}l{Y(k.1I);4 k.1I.1z}}}}2b()})};$.24.3Q=3(){4 G.1c(3(){$$=$(G).1P().3R(\'2e\');$$.1y(\'z\').1y(\'z.T\').1y(\'z\').Q($$)})};$.T=3(a){E b={1r:7};$.V(b,a);2(b.1r){4 $(b.1r).1c(3(){$(G).1f();$(G).2P(\'1R\',[b])})}l{$(\'u\').2P(\'1R\',[b])}}})(3S);',62,241,'||if|function|return||length|false|true|||||||||||||else|selection||string|caretPosition|block||||textarea|ctrlKey|previewWindow|||div|shiftKey|li|id|document|var|altKey|this|caretOffset|prepare|openWith|val|clicked|iFrame|class|closeWith|hash|replaceWith|lines||markItUp|root|extend|replace|browser|markup|ul||start|nameSpace||get|levels|scrollPosition|header|abort|key|placeHolder|previewParserPath|each|localize|bind|focus|build|substring|range|previewInWindow|previewTemplatePath|resizeHandle|footer|template|mouseMove|mouseUp|mouseup|target|title|line|fixIeBug|scrollTop|rangeCopy|keyCode|parent|keepDefault|previewAutoRefresh|preview|html|beforeInsert|afterInsert|onEnter|onShiftEnter|onCtrlEnter|onTab|miuScript|attr|wrap|dropMenus|appendTo|insertAfter|unbind|keyPressed|insertion|name|split|value|opera|fixOperaBug|set|refreshPreview|createRange||character|sp|phtml|fn|previewPosition|after|previewParserVar|data|markupSet|null|init|substr|addClass|markItUpEditor|insertBefore|height|clientY|css|mousemove|append|keydown|focused|hover|accesskey|separator|for|markItUpButton|click|call|hide|dropMenu|magicMarkups|undefined|insert|msie|text|createTextRange|moveStart|setSelectionRange|selectionStart|open|iframe|close|documentElement|renderPreview|ajax|type|async|url|success|trigger|templates|script|src|match|jquery|markitup|pack|js|toUpperCase|markItUpContainer|markItUpHeader|markItUpFooter|safari|markItUpResizeHandle|mousedown|Math|max|px|keyup|display|Ctrl|markItUpSeparator|className|href|contextmenu|eval|show|one|push|markItUpDropMenu|pop|toString|prompt|isFunction|beforeMultiInsert|trim|join|afterMultiInsert|version|collapse|moveEnd|select|duplicate|moveToElementText|while|inRange|selectionEnd|closed|window|markItUpPreviewFrame|contentWindow|frame|remove|try|catch|write|POST|encodeURIComponent|content|String|fromCharCode|triggerHandler|markItUpRemove|removeClass|jQuery'.split('|'),0,{}));

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

/* Autocomplete 1.1 */
(function($){$.fn.extend({autocomplete:function(urlOrData,options){var isUrl=typeof urlOrData=="string";options=$.extend({},$.Autocompleter.defaults,{url:isUrl?urlOrData:null,data:isUrl?null:urlOrData,delay:isUrl?$.Autocompleter.defaults.delay:10,max:options&&!options.scroll?10:150},options);options.highlight=options.highlight||function(value){return value;};options.formatMatch=options.formatMatch||options.formatItem;return this.each(function(){new $.Autocompleter(this,options);});},result:function(handler){return this.bind("result",handler);},search:function(handler){return this.trigger("search",[handler]);},flushCache:function(){return this.trigger("flushCache");},setOptions:function(options){return this.trigger("setOptions",[options]);},unautocomplete:function(){return this.trigger("unautocomplete");}});$.Autocompleter=function(input,options){var KEY={UP:38,DOWN:40,DEL:46,TAB:9,RETURN:13,ESC:27,COMMA:188,PAGEUP:33,PAGEDOWN:34,BACKSPACE:8};var $input=$(input).attr("autocomplete","off").addClass(options.inputClass);var timeout;var previousValue="";var cache=$.Autocompleter.Cache(options);var hasFocus=0;var lastKeyPressCode;var config={mouseDownOnSelect:false};var select=$.Autocompleter.Select(options,input,selectCurrent,config);var blockSubmit;$.browser.opera&&$(input.form).bind("submit.autocomplete",function(){if(blockSubmit){blockSubmit=false;return false;}});$input.bind(($.browser.opera?"keypress":"keydown")+".autocomplete",function(event){hasFocus=1;lastKeyPressCode=event.keyCode;switch(event.keyCode){case KEY.UP:event.preventDefault();if(select.visible()){select.prev();}else{onChange(0,true);}break;case KEY.DOWN:event.preventDefault();if(select.visible()){select.next();}else{onChange(0,true);}break;case KEY.PAGEUP:event.preventDefault();if(select.visible()){select.pageUp();}else{onChange(0,true);}break;case KEY.PAGEDOWN:event.preventDefault();if(select.visible()){select.pageDown();}else{onChange(0,true);}break;case options.multiple&&$.trim(options.multipleSeparator)==","&&KEY.COMMA:case KEY.TAB:case KEY.RETURN:if(selectCurrent()){event.preventDefault();blockSubmit=true;return false;}break;case KEY.ESC:select.hide();break;default:clearTimeout(timeout);timeout=setTimeout(onChange,options.delay);break;}}).focus(function(){hasFocus++;}).blur(function(){hasFocus=0;if(!config.mouseDownOnSelect){hideResults();}}).click(function(){if(hasFocus++>1&&!select.visible()){onChange(0,true);}}).bind("search",function(){var fn=(arguments.length>1)?arguments[1]:null;function findValueCallback(q,data){var result;if(data&&data.length){for(var i=0;i<data.length;i++){if(data[i].result.toLowerCase()==q.toLowerCase()){result=data[i];break;}}}if(typeof fn=="function")fn(result);else $input.trigger("result",result&&[result.data,result.value]);}$.each(trimWords($input.val()),function(i,value){request(value,findValueCallback,findValueCallback);});}).bind("flushCache",function(){cache.flush();}).bind("setOptions",function(){$.extend(options,arguments[1]);if("data"in arguments[1])cache.populate();}).bind("unautocomplete",function(){select.unbind();$input.unbind();$(input.form).unbind(".autocomplete");});function selectCurrent(){var selected=select.selected();if(!selected)return false;var v=selected.result;previousValue=v;if(options.multiple){var words=trimWords($input.val());if(words.length>1){var seperator=options.multipleSeparator.length;var cursorAt=$(input).selection().start;var wordAt,progress=0;$.each(words,function(i,word){progress+=word.length;if(cursorAt<=progress){wordAt=i;return false;}progress+=seperator;});words[wordAt]=v;v=words.join(options.multipleSeparator);}v+=options.multipleSeparator;}$input.val(v);hideResultsNow();$input.trigger("result",[selected.data,selected.value]);return true;}function onChange(crap,skipPrevCheck){if(lastKeyPressCode==KEY.DEL){select.hide();return;}var currentValue=$input.val();if(!skipPrevCheck&&currentValue==previousValue)return;previousValue=currentValue;currentValue=lastWord(currentValue);if(currentValue.length>=options.minChars){$input.addClass(options.loadingClass);if(!options.matchCase)currentValue=currentValue.toLowerCase();request(currentValue,receiveData,hideResultsNow);}else{stopLoading();select.hide();}};function trimWords(value){if(!value)return[""];if(!options.multiple)return[$.trim(value)];return $.map(value.split(options.multipleSeparator),function(word){return $.trim(value).length?$.trim(word):null;});}function lastWord(value){if(!options.multiple)return value;var words=trimWords(value);if(words.length==1)return words[0];var cursorAt=$(input).selection().start;if(cursorAt==value.length){words=trimWords(value)}else{words=trimWords(value.replace(value.substring(cursorAt),""));}return words[words.length-1];}function autoFill(q,sValue){if(options.autoFill&&(lastWord($input.val()).toLowerCase()==q.toLowerCase())&&lastKeyPressCode!=KEY.BACKSPACE){$input.val($input.val()+sValue.substring(lastWord(previousValue).length));$(input).selection(previousValue.length,previousValue.length+sValue.length);}};function hideResults(){clearTimeout(timeout);timeout=setTimeout(hideResultsNow,200);};function hideResultsNow(){var wasVisible=select.visible();select.hide();clearTimeout(timeout);stopLoading();if(options.mustMatch){$input.search(function(result){if(!result){if(options.multiple){var words=trimWords($input.val()).slice(0,-1);$input.val(words.join(options.multipleSeparator)+(words.length?options.multipleSeparator:""));}else{$input.val("");$input.trigger("result",null);}}});}};function receiveData(q,data){if(data&&data.length&&hasFocus){stopLoading();select.display(data,q);autoFill(q,data[0].value);select.show();}else{hideResultsNow();}};function request(term,success,failure){if(!options.matchCase)term=term.toLowerCase();var data=cache.load(term);if(data&&data.length){success(term,data);}else if((typeof options.url=="string")&&(options.url.length>0)){var extraParams={timestamp:+new Date()};$.each(options.extraParams,function(key,param){extraParams[key]=typeof param=="function"?param():param;});$.ajax({mode:"abort",port:"autocomplete"+input.name,dataType:options.dataType,url:options.url,data:$.extend({q:lastWord(term),limit:options.max},extraParams),success:function(data){var parsed=options.parse&&options.parse(data)||parse(data);cache.add(term,parsed);success(term,parsed);}});}else{select.emptyList();failure(term);}};function parse(data){var parsed=[];var rows=data.split("\n");for(var i=0;i<rows.length;i++){var row=$.trim(rows[i]);if(row){row=row.split("|");parsed[parsed.length]={data:row,value:row[0],result:options.formatResult&&options.formatResult(row,row[0])||row[0]};}}return parsed;};function stopLoading(){$input.removeClass(options.loadingClass);};};$.Autocompleter.defaults={inputClass:"ac_input",resultsClass:"ac_results",loadingClass:"ac_loading",minChars:1,delay:400,matchCase:false,matchSubset:true,matchContains:false,cacheLength:10,max:100,mustMatch:false,extraParams:{},selectFirst:true,formatItem:function(row){return row[0];},formatMatch:null,autoFill:false,width:0,multiple:false,multipleSeparator:", ",highlight:function(value,term){return value.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)("+term.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi,"\\$1")+")(?![^<>]*>)(?![^&;]+;)","gi"),"<strong>$1</strong>");},scroll:true,scrollHeight:180};$.Autocompleter.Cache=function(options){var data={};var length=0;function matchSubset(s,sub){if(!options.matchCase)s=s.toLowerCase();var i=s.indexOf(sub);if(options.matchContains=="word"){i=s.toLowerCase().search("\\b"+sub.toLowerCase());}if(i==-1)return false;return i==0||options.matchContains;};function add(q,value){if(length>options.cacheLength){flush();}if(!data[q]){length++;}data[q]=value;}function populate(){if(!options.data)return false;var stMatchSets={},nullData=0;if(!options.url)options.cacheLength=1;stMatchSets[""]=[];for(var i=0,ol=options.data.length;i<ol;i++){var rawValue=options.data[i];rawValue=(typeof rawValue=="string")?[rawValue]:rawValue;var value=options.formatMatch(rawValue,i+1,options.data.length);if(value===false)continue;var firstChar=value.charAt(0).toLowerCase();if(!stMatchSets[firstChar])stMatchSets[firstChar]=[];var row={value:value,data:rawValue,result:options.formatResult&&options.formatResult(rawValue)||value};stMatchSets[firstChar].push(row);if(nullData++<options.max){stMatchSets[""].push(row);}};$.each(stMatchSets,function(i,value){options.cacheLength++;add(i,value);});}setTimeout(populate,25);function flush(){data={};length=0;}return{flush:flush,add:add,populate:populate,load:function(q){if(!options.cacheLength||!length)return null;if(!options.url&&options.matchContains){var csub=[];for(var k in data){if(k.length>0){var c=data[k];$.each(c,function(i,x){if(matchSubset(x.value,q)){csub.push(x);}});}}return csub;}else if(data[q]){return data[q];}else if(options.matchSubset){for(var i=q.length-1;i>=options.minChars;i--){var c=data[q.substr(0,i)];if(c){var csub=[];$.each(c,function(i,x){if(matchSubset(x.value,q)){csub[csub.length]=x;}});return csub;}}}return null;}};};$.Autocompleter.Select=function(options,input,select,config){var CLASSES={ACTIVE:"ac_over"};var listItems,active=-1,data,term="",needsInit=true,element,list;function init(){if(!needsInit)return;element=$("<div/>").hide().addClass(options.resultsClass).css("position","absolute").appendTo(document.body);list=$("<ul/>").appendTo(element).mouseover(function(event){if(target(event).nodeName&&target(event).nodeName.toUpperCase()=='LI'){active=$("li",list).removeClass(CLASSES.ACTIVE).index(target(event));$(target(event)).addClass(CLASSES.ACTIVE);}}).click(function(event){$(target(event)).addClass(CLASSES.ACTIVE);select();input.focus();return false;}).mousedown(function(){config.mouseDownOnSelect=true;}).mouseup(function(){config.mouseDownOnSelect=false;});if(options.width>0)element.css("width",options.width);needsInit=false;}function target(event){var element=event.target;while(element&&element.tagName!="LI")element=element.parentNode;if(!element)return[];return element;}function moveSelect(step){listItems.slice(active,active+1).removeClass(CLASSES.ACTIVE);movePosition(step);var activeItem=listItems.slice(active,active+1).addClass(CLASSES.ACTIVE);if(options.scroll){var offset=0;listItems.slice(0,active).each(function(){offset+=this.offsetHeight;});if((offset+activeItem[0].offsetHeight-list.scrollTop())>list[0].clientHeight){list.scrollTop(offset+activeItem[0].offsetHeight-list.innerHeight());}else if(offset<list.scrollTop()){list.scrollTop(offset);}}};function movePosition(step){active+=step;if(active<0){active=listItems.size()-1;}else if(active>=listItems.size()){active=0;}}function limitNumberOfItems(available){return options.max&&options.max<available?options.max:available;}function fillList(){list.empty();var max=limitNumberOfItems(data.length);for(var i=0;i<max;i++){if(!data[i])continue;var formatted=options.formatItem(data[i].data,i+1,max,data[i].value,term);if(formatted===false)continue;var li=$("<li/>").html(options.highlight(formatted,term)).addClass(i%2==0?"ac_even":"ac_odd").appendTo(list)[0];$.data(li,"ac_data",data[i]);}listItems=list.find("li");if(options.selectFirst){listItems.slice(0,1).addClass(CLASSES.ACTIVE);active=0;}if($.fn.bgiframe)list.bgiframe();}return{display:function(d,q){init();data=d;term=q;fillList();},next:function(){moveSelect(1);},prev:function(){moveSelect(-1);},pageUp:function(){if(active!=0&&active-8<0){moveSelect(-active);}else{moveSelect(-8);}},pageDown:function(){if(active!=listItems.size()-1&&active+8>listItems.size()){moveSelect(listItems.size()-1-active);}else{moveSelect(8);}},hide:function(){element&&element.hide();listItems&&listItems.removeClass(CLASSES.ACTIVE);active=-1;},visible:function(){return element&&element.is(":visible");},current:function(){return this.visible()&&(listItems.filter("."+CLASSES.ACTIVE)[0]||options.selectFirst&&listItems[0]);},show:function(){var offset=$(input).offset();element.css({width:typeof options.width=="string"||options.width>0?options.width:$(input).width(),top:offset.top+input.offsetHeight,left:offset.left}).show();if(options.scroll){list.scrollTop(0);list.css({maxHeight:options.scrollHeight,overflow:'auto'});if($.browser.msie&&typeof document.body.style.maxHeight==="undefined"){var listHeight=0;listItems.each(function(){listHeight+=this.offsetHeight;});var scrollbarsVisible=listHeight>options.scrollHeight;list.css('height',scrollbarsVisible?options.scrollHeight:listHeight);if(!scrollbarsVisible){listItems.width(list.width()-parseInt(listItems.css("padding-left"))-parseInt(listItems.css("padding-right")));}}}},selected:function(){var selected=listItems&&listItems.filter("."+CLASSES.ACTIVE).removeClass(CLASSES.ACTIVE);return selected&&selected.length&&$.data(selected[0],"ac_data");},emptyList:function(){list&&list.empty();},unbind:function(){element&&element.remove();}};};$.fn.selection=function(start,end){if(start!==undefined){return this.each(function(){if(this.createTextRange){var selRange=this.createTextRange();if(end===undefined||start==end){selRange.move("character",start);selRange.select();}else{selRange.collapse(true);selRange.moveStart("character",start);selRange.moveEnd("character",end);selRange.select();}}else if(this.setSelectionRange){this.setSelectionRange(start,end);}else if(this.selectionStart){this.selectionStart=start;this.selectionEnd=end;}});}var field=this[0];if(field.createTextRange){var range=document.selection.createRange(),orig=field.value,teststring="<->",textLength=range.text.length;range.text=teststring;var caretAt=field.value.indexOf(teststring);field.value=orig;this.selection(caretAt,caretAt+textLength);return{start:caretAt,end:caretAt+textLength}}else if(field.selectionStart!==undefined){return{start:field.selectionStart,end:field.selectionEnd}}};})(jQuery);

/* empty, strpos & checkdate php.js */
function empty(a){var b;if(a===""||a===0||a==="0"||a===null||a===false||typeof a==="undefined")return true;if(typeof a=="object"){for(b in a)return false;return true}return false};
function strpos(a,c,b){a=(a+"").indexOf(c,b?b:0);return a===-1?false:a};
function checkdate(a,c,b){return a>0&&a<13&&b>0&&b<32768&&c>0&&c<=(new Date(b,a,0)).getDate()};

function edad(mes, dia, anio){now = new Date();born = new Date(anio, mes*1-1, dia);years = Math.floor((now.getTime() - born.getTime()) / (365.25 * 24 * 60 * 60 * 1000));return years;}

function mdiv(c,t){if(!c){$('#mensajes_div').slideUp('normal');}else{$('#mensajes_div').removeClass('error ok').addClass(c).html(t).slideDown('normal');}}

<!--ASCDT-->
$(document).ready(function(){
	print_editor();
	$('.autogrow').css('max-height', '500px').autogrow();
	$('.userInfoLogin a:not(.ndt)').tipsy({gravity: 's'});
	for(i=1; i<=15; i++)
		$('.markItUpButton'+i+' > a:first-child').tipsy({gravity: 's'});
	$('.comOfi').tipsy({gravity: 's'});
	$('.post-compartir img').tipsy({gravity: 's'});
	$('div.avatar-box').mouseenter(function(){ $(this).children('ul').show(); }).mouseleave(function(){ $(this).children('ul').hide() });
	var zIndexNumber = 99;
	$('div.avatar-box').each(function(){
		$(this).css('zIndex', zIndexNumber);
		zIndexNumber -= 1;
	});
    $('body').click(function(e){ if ($('div.notificaciones-list').is(':visible') && $(e.target).closest('div.notificaciones-list').length == 0 && $(e.target).closest('a[name=Monitor]').length == 0) noti_hidelast(); });

	$('div.new-search > div.bar-options > ul > li').click(function(){var t=$(this).children().html().toLowerCase();$('div.new-search').removeClass('posts temas comunidades').addClass(t);$(this).parent().children('li.selected').removeClass('selected');$(this).addClass('selected');});
	$('form[name=search]').bind('submit', function(){document.location='/'+$('div.new-search > div.bar-options > ul > li.selected').children().html().toLowerCase()+'/buscador/?q='+$('#new-search-input-q').val()+'&sw=turinga&cat=-1&autor=&cx=partner-pub-2386891485107482%3Argdob4iv945&cof=FORID%3A10&ie=ISO-8859-1';return false;});
    /*POLL T*/
    $('#vote > label:not(.disabled)').click(function(){$('#vote > label.myVote').removeClass('myVote');$(this).addClass('myVote');});
    $('#polllabel').click(function(){$('#addpoll').slideToggle('fast');});
    $('#poll_options a.dopt').live('click', function(){$(this).parent('div').slideUp('normal', function(){$(this).remove();})});
});

$.ajaxSetup({cache: false,dataType:'html'});