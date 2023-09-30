let tablaUser = null;

$(document).ready(function (){
	if(segmento2 == ''){
		tablaUser = $('#tablaUsuarios').DataTable({
			ajax: {
				url: base_url + 'usuarios/lista',
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'Todas']], language: lngDataTable,
			columns:[
				{
					data: null,
					orderable: false,
					render: function(data){
						let style = 'style="padding:1px 4px"';
						let hrefEdit = 'href="'+base_url+'usuarios/editar?id='+data.idusuario+'"';
						let hrefPer = 'href="'+base_url+'usuarios/permisos?id='+data.idusuario+'"';
						let hrefReset = 'href="'+base_url+'usuarios/reset?id='+data.idusuario+'&doc='+data.numero_documento+'&stat='+data.activo+'"';
						let hrefActiva = 'href="'+base_url+'usuarios/habilitar?id='+data.idusuario+'"';
						let btnAccion =
						/* Boton de edicion */
						'<div class="btn-group"><a title="Editar Usuario" '+((data.activo === '1' && btnEditUser)? hrefEdit:'')+' class="bg-warning btnTable '+
							((data.activo === '0' || !btnEditUser)?'disabled':'')+' editar" '+style+'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'+
						/* Boton de permisos */
						'<a title="Permisos" '+((data.activo === '1' && btnPermisos)? hrefPer:'')+' class="bg-secondary btnTable '+
							((data.activo === '0' || !btnPermisos)?'disabled':'')+' permisos" '+style+' data-target="#modalPermisos" data-toggle="modal">'+
							'<i class="fa fa-cogs" aria-hidden="true"></i></a>'+
						/* Boton de Reset Clave */
						'<a title="Resetear Clave" '+((data.activo === '1' && btnClave)? hrefReset:'')+' class="bg-info btnTable '+
							((data.activo === '0' || !btnClave)?'disabled':'')+' resetclave" '+style+'><i class="fa fa-key" aria-hidden="true"></i></a>'+
						/* Boton de activacion */
						'<a title="'+(data.activo === '0'?'Habilitar Usuario':'Deshabilitar Usuario')+'" '+((data.activo === '1' && btnActiva)? hrefActiva:'')+
							' class="bg-light btnTable '+(data.activo === '1'? 'btnDesactivar':'btnActivar')+' '+(!btnActiva?'disabled':'')+' activar" '+style+'>'+
							'<i class="fa '+(data.activo === '1'? 'fa-unlock':'fa-lock')+'" aria-hidden="true"></i></a></div>';
						return btnAccion;
					}
				},
				{ data: 'idusuario' },
				{ data: 'tipo_documento' },
				{ data: 'numero_documento' },
				{ 
					data: 'avatar',
					createdCell: function(td,cellData,rowData,row,col){
						$(td).addClass('p-1');
					},
					render: function(data){
						return '<img src="'+base_url+'public/images/perfil/'+data+'" style="display:block;margin:auto;width:40px" class="img img-fluid" >';
					}
				},
				{ data: 'apellidos' },
				{ data: 'nombres' },
				{ data: 'usuario' },
				{ 
					data: 'idperfil',
					render: function(data){
						let var_perfil = '';
						switch(data){
							case '1': var_perfil = 'ADMINISTRADOR'; break;
							case '2': var_perfil = 'EST&Aacute;NDAR'; break;
						}
						return var_perfil;
					}
				},
				{
					data: 'activo',
					render: function(data){
						let var_status = '';
						switch(data){
							case '1': var_status = '<span class="text-success">Activo</span>'; break;
							case '0': var_status = '<span class="text-danger">Inactivo</span>'; break;
						}
						return var_status;
					}
				},
			],
			columnDefs:headers, order: [],
		});
	}
});

$('#modalPermisos').on('hidden.bs.modal',function(e){
	$('#form_permisos')[0].reset();
	$('#form_permisos input:checkbox').prop('checked',false);
	$('#form_permisos input:checkbox').prop('disabled',false);
	$(this).find('.nav-tabs a:first').tab('show');
	$('body,html').animate({ scrollTop: 0 }, 'fast');
	$('.modulos').removeClass('active'), $('.modulos').addClass('disabled'), $('.tab-pane').removeClass('active');
});

$('#tablaUsuarios').bind('click','a',function(e){
	let el = e.target, a = $(el).closest('a'), mensaje = '';
	let data = (tablaUser.row(a).child.isShown())? tablaUser.row(a).data() : tablaUser.row($(el).parents('tr')).data();
	
	if($(a).hasClass('activar')){
		e.preventDefault();
		mensaje = data.activo === '1'? 'Está seguro que desea deshabilitar el Usuario?' : 'Está seguro que desea habilitar el Usuario?';
		let confirmacion = confirm(mensaje);
		if(confirmacion){
			a.addClass('disabled');
			a.html('<i class="fa fa-spin fa-cog fa-1x"></i>');
			$.ajax({
				data: {},
				url: $(a).attr('href'),
				method: 'GET',
				dataType: 'JSON',
				error: function(xhr){ a.removeClass('disabled'); a.html('<i class="fa fa-lock" aria-hidden="true"></i>'); },
				beforeSend: function(){},
				success: function(data){
					if(parseInt(data.status) === 200){
						tablaUser.ajax.reload();
						alert(data.msg);
					}else{
						alert(data.msg);
						a.removeClass('disabled');
						a.html('<i class="fa fa-lock" aria-hidden="true"></i>');
					}
				}
			});
		}
	}else if($(a).hasClass('resetclave')){
		e.preventDefault();
		let confirmacion = confirm('Deseas resetear la clave del usuario?');
		if(confirmacion){
			a.addClass('disabled');
			a.html('<i class="fa fa-spin fa-cog fa-1x"></i>');
			$.ajax({
				url: $(a).attr('href'),
				type: 'GET',
				dataType: 'JSON',
				data: {},
				error: function(xhr){ a.removeClass('disabled'); a.html('<i class="fa fa-key" aria-hidden="true"></i>'); },
				beforeSend: function(){},
				success: function(data){
					a.removeClass('disabled');
					a.html('<i class="fa fa-key" aria-hidden="true"></i>');
					if(parseInt(data.status) === 200) alert('Se reseteó la clave del usuario exitosamente');
					else alert('No se pudo resetear la clave del usuario');
				}
			});
		}
	}else if($(a).hasClass('permisos')){
		e.preventDefault();
		$.ajax({
			url: $(a).attr('href'),
			type: 'GET',
			dataType: 'JSON',
			data: {},
			error: function(xhr){ /*a.removeClass('disabled'); a.html('<i class="far fa-cog" aria-hidden="true"></i>');*/ },
			//beforeSend: function(){},
			success: function(data){
				$('#idusuarioPer').val(data.idusuario);
				$.each(data.data,function(i,e){
					$('.permisos').each(function(){
						if(e.idpermiso === this.value) $(this).prop('checked',true);
					});
				});
				$.each(data.menus,function(i,e){
					$('.menus').each(function(){
						if(e.idmenu === this.value) $(this).prop('checked',true);
					});
				});
				$.each(data.submenus,function(i,e){
					$('.submenu').each(function(){
						if(e.idmenudetalle === this.value) $(this).prop('checked',true);
					});
				});
				j = 0;
				$.each($('.modulos'),function(i,e){
					let a = e;
					$.each(data.modulos,function(ind,ele){
						if($(a).attr('data-mod') === ele.idmodulo){
							if(j == 0) $(a).addClass('active'), $(a).attr('aria-selected',true), j++, $('#'+ele.url).addClass('active');
							$(a).removeClass('disabled');
						}
					});
				});
			}
		});
	}
});

$('#form_usuarios').validate({
	errorClass: 'form_error',
	rules: {
		doc: { required: function () { if ($('.tipodoc').css('display') != 'none') return true; else return false; }, minlength: 8 },
		nombres: { required: function () { if ($('.nombres').css('display') != 'none') return true; else return false; } },
	},
	messages: {
		doc: { required : '&nbsp;&nbsp;Documento Requerido', minlength: '&nbsp;&nbsp;Debe ingresar mínimo 8 caracteres' },
		nombres: { required : '&nbsp;&nbsp;Campo Requerido' },
	},
	errorPlacement: function(error, element) {
		if(element.attr('name') === 'doc') $('#error-doc').html(error.html());
		if(element.attr('name') === 'nombres') $('#error-nombres').html(error.html());
	},
	submitHandler: function (form, event) {
		$('#form_usuarios button[type=submit]').html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
		$('#form_usuarios button[type=submit]').addClass('disabled');
		btnCancelar.addClass('disabled');
		return true;
	}
});

$('#asignarPer').bind('click', function(e){
	e.preventDefault();
	$.ajax({
		data: $('#form_permisos').serialize(),
		url: base_url + 'usuarios/permisos/asignar',
		method: 'POST',
		dataType: 'JSON',
		error: function(xhr){},
		beforeSend: function(){},
		success: function(data){
			$('.resp').html(data.msg);
			setTimeout(function () { $('.resp').html('&nbsp;'); }, 2500);
		}
	}); 
});

/*$('input:checkbox').bind('change', function(e){
	if($(this).hasClass('menus')){
		if($(this).attr('data-nivel') === '1' && !this.checked)
			$('.submenu[data-submenu="'+$(this).attr('data-menu')+'"]').prop('checked',false);
	}else if($(this).hasClass('submenu')){
		let sub = $('.submenu[data-submenu="'+$(this).attr('data-submenu')+'"]:checked');
		if(sub.length > 0)
			$('.menus[data-menu="'+$(this).attr('data-submenu')+'"]').prop('checked',true);
		else
			$('.menus[data-menu="'+$(this).attr('data-submenu')+'"]').prop('checked',false);
	}else if($(this).hasClass('modulos')){
		if(!this.checked) $('#'+$(this).attr('data-modulo')+' input:checkbox').prop('checked', false);
		$('#'+$(this).attr('data-modulo')+' *').prop('disabled', !this.checked);
	}
});*/