var borradores = {
	counts: new Array(),

	filtro: 'todos',
	categoria: 'todas',
	orden: 'fecha',

	filtro_anterior: 'todos',
	categoria_anterior: 'todas',
	orden_anterior: 'fecha',
	
	orden_f: new Array(),
	orden_t: new Array(),
	orden_c: new Array(),

	printCounts: function(cat){
		//Filtros
		$('#borradores-filtros #todos span.count').html(this.counts['todos']);
		$('#borradores-filtros #borradores span.count').html(this.counts['borradores']);
		$('#borradores-filtros #eliminados span.count').html(this.counts['eliminados']);

		//Categorias
		$('#borradores-categorias #todas span.count').html(this.counts['todos']);
		$('#borradores-categorias #' + cat + ' span.count').html(borradores.counts['categorias'][cat]['count']);
	},

	orden_html: '',
	
	query: function(){
		//para que tanta vuelta....
		if(this.filtro != this.filtro_anterior) {
			if(this.filtro != 'todos') {
		        $('#resultados-borradores > li').removeClass('filtro-show');
				$('#resultados-borradores a[title].' + this.filtro).parent().addClass('filtro-show');
			} else {
			    $('#resultados-borradores > li').addClass('filtro-show');
            }
			this.filtro_anterior = this.filtro;
		} else if(this.categoria != this.categoria_anterior) {
			if(this.categoria != 'todas') {
		        $('#resultados-borradores > li').removeClass('cat-show');
				$('#resultados-borradores a[title].' + this.categoria).parent().addClass('cat-show');
			} else {
			    $('#resultados-borradores > li').addClass('cat-show');
            }
			this.categoria_anterior = this.categoria;
		} else if(this.orden != this.orden_anterior) {
			var a = (this.orden == 'fecha' ? this.orden_f : (this.orden == 'titulo' ? this.orden_t : this.orden_c));
            var orden_html = '';
			for(i=0;i<a.length;i++) {
				orden_html += $('#borrador_id_' + a[i]).outerHTML();
			}
			$('#resultados-borradores').html(orden_html);
			this.orden_anterior = this.orden;
		} else if(this.search_q != this.search_q_anterior) {
		    $('#resultados-borradores > li').removeClass('search-show');
			if(this.search_q != '') {
			    $('#resultados-borradores > li').removeClass('search-show');
				$('#resultados-borradores a[title]').each(function() {
					if(this.innerHTML.indexOf(borradores.search_q) != -1) {
						$(this).parent().addClass('search-show');
					}
				});
			} else {
			    $('#resultados-borradores > li').addClass('search-show');
            }
			this.search_q_anterior = this.search_q;
		}
        $('#resultados-borradores > li').each(function() {
          if($(this).hasClass('filtro-show') && $(this).hasClass('cat-show') && $(this).hasClass('search-show')) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
	},

	//Buscador
	search_q: '',
	search_q_anterior: '',
	search: function(q, event){
		tecla = (document.all) ? event.keyCode:event.which;
		if(tecla==27){ //Escape, limpio input
			q = '';
			$('#borradores-search').val('');
		}
		if(q == this.search_q)
			return;
		//Calcula por la busqueda anterior si tiene que hacer una busqueda parcial
		this.search_q = q;
		this.query();
	},
	search_focus: function(){
		$('label[for="borradores-search"]').hide();
	},
	search_blur: function(){
		if(empty($('#borradores-search').val()))
			$('label[for="borradores-search"]').show();
	},

	active: function(e){
		$(e).parent().parent().parent().children('li').removeClass('active');
		$(e).parent().parent().addClass('active');
	},

	eliminar: function(id, dialog){
		mydialog.close();
		if(dialog){
			mydialog.show();
			mydialog.title('Eliminar Borrador');
			mydialog.body('&iquest;Seguro que deseas eliminar este borrador?');
			mydialog.buttons(true, true, 'SI', 'borradores.eliminar(' + id + ', false)', true, false, true, 'NO', 'close', true, true);
			mydialog.center();
		}else{
			$.ajax({
				type: 'GET',
				url: '/ajax/delete-draft.php',
				data: 'id=' + id,
				success: function(h){
					if(h != '1') {
					    mydialog.alert('Error', h);
					} else {
					    $('#borrador_id_' + id).fadeOut('normal', function(){ $(this).remove(); });
						//Quedaba solo un borrador
						if(borradores_data.length==1)
						    $('#res').html('<div class="emptyData">No tienes ning&uacute;n borrador ni post eliminado</div>');

						//Lo elimino de borradores_data
						for(var i=0; i<borradores_data.length; i++){
						    if(borradores_data[i]['id']!=id){continue;}
						    //Hago los descuentos de contadores
						    borradores.counts['todos']--;
						    borradores.counts[borradores_data[i]['tipo']]--;
						    borradores.counts['categorias'][borradores_data[i]['categoria']]['count']--;
                            if(borradores.counts['categorias'][borradores_data[i]['categoria']]['count'] == 0) {
                              $('#'+borradores_data[i]['categoria']).slideUp('slow', function() { $(this).remove(); });
                            }
						    borradores.printCounts(borradores_data[i]['categoria']);
						    borradores_data.splice(i, 1);
						    break;
						}
					}
				},
				error: function(){	
					mydialog.alert('Error', 'Hubo un error al intentar procesar lo solicitado');
				}
			});
		}
	},

	show_eliminado: function(id){
		mydialog.show();
		mydialog.title('Cargando Post');
		mydialog.body('Cargando Post...', 200);
		mydialog.buttons(true, true, 'Aceptar', 'close', true, true, false);
		mydialog.center();
		mydialog.procesando_inicio();
		$.ajax({
			type: 'GET',
			url: '/ajax/show-draft.php',
			data: 'id=' + id,
			success: function(h){
				switch(h.charAt(0)){
					case '0': //Error
						mydialog.alert('Error', h.substring(1));
						break;
					case '1':
						mydialog.title('Post');
						mydialog.body(h.substring(1), 540);
						mydialog.buttons(true, true, 'Aceptar', 'close', true, true, false);
						mydialog.center();
						break;
				}
			},
			error: function(){	
				mydialog.alert('Error', 'Hubo un error al intentar procesar lo solicitado');
			},
			complete: function(){
				mydialog.procesando_fin();
			}
		});
	}
}