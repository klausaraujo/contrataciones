let tablaUser = null;/**/

$(document).ready(function (){
	if(segmento2 == ''){
		tablaUser = $('#tablaUsuarios').DataTable({
			ajax: {
				url: base_url + 'usuarios/lista',
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'Todas']], language: lngDataTable,
			columns:[
				/*{ data: null, orderable: false, className: 'pl-3', render: function(data){ return ''; } },*/
				{
					data: null,
					orderable: false,
					render: function(data){
						let btnAccion =
						/* Boton de edicion */
						'<div class="btn-group"><a title="Editar Usuario" '+((data.activo === '1' || btnEditUser)?'href="'+base_url+'usuarios/editar?id='+data.idusuario+'"':'')+
							' class="bg-warning btnTable '+((data.activo === '0' || !btnEditUser)?'disabled':'')+' editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'+
						/* Boton de Asignar Sucursales */
						'<a title="Asignar Sucursales" '+((data.activo === '1' || btnSucur)?'href="'+base_url+'usuarios/sucursales?id='+data.idusuario+'"':'')+
							' class="bg-narsa btnTable '+((data.activo === '0' || !btnSucur)?'disabled':'')+' sucursales" data-target="#modalSucursales" data-toggle="modal">'+
							'<i class="fa fa-building-o" aria-hidden="true"></i></a>'+
						/* Boton de permisos */
						'<a title="Permisos" '+((data.activo === '1' || btnPermisos)?'href="'+base_url+'usuarios/permisos?id='+data.idusuario+'"':'')+
							' class="bg-secondary btnTable '+((data.activo === '0' || !btnPermisos)?'disabled':'')+' permisos" data-target="#modalPermisos" data-toggle="modal">'+
							'<i class="fa fa-cogs" aria-hidden="true"></i></a>'+
						/* Boton de Reset Clave */
						'<a title="Resetear Clave" '+((data.activo === '1' || btnClave)?'href="'+base_url+'usuarios/reset?id='+data.idusuario+'&doc='+data.numero_documento+'"':'')+
							' class="bg-info btnTable '+((data.activo === '0' || !btnClave)?'disabled':'')+' resetclave"><i class="fa fa-key" aria-hidden="true"></i></a>'+
						/* Boton de activacion */
						'<a title="'+(data.activo === '0'?'Habilitar Usuario':'Deshabilitar Usuario')+'" '+((data.activo === '1' || btnActiva)?'href="'+base_url+'usuarios/habilitar?id='+data.idusuario+
							'&stat='+data.activo+'"':'')+' class="bg-light btnTable '+(data.activo === '1'? 'btnDesactivar':'btnActivar')+' '+(!btnActiva?'disabled':'')+' activar" >'+
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
			columnDefs:headers,/* dom: botones, buttons:{dom:{container:{tag: 'div',className: 'flexcontent'},buttonLiner:{tag: null}},buttons:[
			'copy','csv','excel','pdf','print']},*/ order: [],
		});
	}
});

$('#modalPermisos').on('hidden.bs.modal',function(e){
	$('#form_permisos')[0].reset();
	$('#form_permisos input:checkbox').prop('checked',false);
	$('#form_permisos input:checkbox').prop('disabled',false);
	//$(' input[type=checkbox]')
	/*tablaIngDetalle.clear().draw();
	$('#sucursalIng').removeAttr('disabled');
	$('#form_ingresos select').prop('selectedIndex',0);*/
	$(this).find('.nav-tabs a:first').tab('show');
	$('body,html').animate({ scrollTop: 0 }, 'fast');
	//setTimeout(function () { if(!$('.mesg').css('display') == 'none' || $('.mesg').css('opacity') == 1) $('.mesg').hide('slow'); }, 3000);
});
$('#modalSucursales').on('hidden.bs.modal',function(e){
	$('#form_sucursales')[0].reset();
	$('#form_sucursales input:checkbox').prop('checked',false);
	$('body,html').animate({ scrollTop: 0 }, 'fast');
});

$('#tablaUsuarios').bind('click','a',function(e){
	let el = e.target, a = $(el).closest('a'), mensaje = '';
	let data = (tablaUser.row(a).child.isShown())? tablaUser.row(a).data() : tablaUser.row($(el).parents('tr')).data();
	
	if($(a).hasClass('activar')){
		e.preventDefault();
		//console.log(data.activo);
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
					//console.log(data);
					if(parseInt(data.status) === 200){
						tablaUser.ajax.reload();
						//tablaUser.clear();
						//tablaUser.rows.add(data.lista).draw();
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
				//a.removeClass('disabled');
				//a.html('<i class="far far fa-cog" aria-hidden="true"></i>');
				$('#idusuarioPer').val(data.idusuario);
				$('#perfilUsuario').val(data.idperfil);
				$('#perfilU').html(data.perfil);
				/*if(parseInt(data.status) === 200) alert('Se reseteó la clave del usuario exitosamente');
				else alert('No se pudo resetear la clave del usuario');*/
				//console.log(data);
				$.each(data.data,function(i,e){
					$('.permisos').each(function(){
						if(e.idpermiso === this.value) $(this).prop('checked',true);
					});
				});
				$.each(data.menus,function(i,e){
					$('.menus').each(function(){
						if(e.idmenu === this.value) $(this).prop('checked',true);
					});
					/*
					$('#form_permisos input:checkbox').each(function(){
						if($(this).attr('name') === 'proveedoresMenu[]' && e.idmenu === $(this).val()){
							$(this).prop('checked',true);
						}else if($(this).attr('name') === 'usuariosMenu[]' && e.idmenu === $(this).val()){
							$(this).prop('checked',true);
						}else if($(this).attr('name') === 'cajasMenu[]' && e.idmenu === $(this).val()){
							$(this).prop('checked',true);
						}else if($(this).attr('name') === 'certMenu[]' && e.idmenu === $(this).val()){
							$(this).prop('checked',true);
						}else if($(this).attr('name') === 'vtaMenu[]' && e.idmenu === $(this).val()){
							$(this).prop('checked',true);
						}else if($(this).attr('name') === 'tosMenu[]' && e.idmenu === $(this).val()){
							$(this).prop('checked',true);
						}
					});*/
				});
				$.each(data.submenus,function(i,e){
					$('.submenu').each(function(){
						if(e.idmenudetalle === this.value) $(this).prop('checked',true);
					});
				});
				$.each(data.modulos,function(i,e){
					$('.modulos').each(function(){
						if(e.idmodulo === this.value) $(this).prop('checked',true);
					});
				});
				$.each($('.modulos'),function(i,e){
					let c = $(e), modulo = c.attr('data-modulo');
					if(c.prop('checked') === false) $('#'+modulo+' *').prop('disabled', true);
				});
			}
		});
	}else if($(a).hasClass('sucursales')){
		e.preventDefault();
		$.ajax({
			url: $(a).attr('href'),
			type: 'GET',
			dataType: 'JSON',
			data: {},
			error: function(xhr){ /*a.removeClass('disabled'); a.html('<i class="far fa-cog" aria-hidden="true"></i>');*/ },
			//beforeSend: function(){},
			success: function(data){
				$('#idusuarioSuc').val(data.idusuario);
				//console.log(data);
				$.each(data.data,function(i,e){
					$('#form_sucursales input:checkbox').each(function(){
						if($(this).attr('name') === 'usuariosSuc[]' && e.idsucursal === $(this).val()){
							$(this).prop('checked',true);
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
		//tipodoc: { required: function () { if ($('.tipodoc').css('display') != 'none') return true; else return false; } },
		doc: { required: function () { if ($('.tipodoc').css('display') != 'none') return true; else return false; }, minlength: 8 },
		//ruc: { required: function () { if ($('.ruc').css('display') != 'none') return true; else return false; }, minlength: 11 },
		nombres: { required: function () { if ($('.nombres').css('display') != 'none') return true; else return false; } },
		//direccion: { required: function () { if ($('.direccion').css('display') != 'none') return true; else return false; } },
		//zona: { required: function () { if ($('.zona').css('display') != 'none') return true; else return false; } },
	},
	messages: {
		//tipodoc: { required : '&nbsp;&nbsp;Campo Requerido' },
		doc: { required : '&nbsp;&nbsp;Documento Requerido', minlength: '&nbsp;&nbsp;Debe ingresar mínimo 8 caracteres' },
		//ruc: { required : '&nbsp;&nbsp;Campo Requerido', minlength: '&nbsp;&nbsp;Debe ingresar mínimo 11 caracteres' },
		nombres: { required : '&nbsp;&nbsp;Campo Requerido' },
		//direccion: { required : '&nbsp;&nbsp;Campo Requerido' },
		//zona: { required : '&nbsp;&nbsp;Campo Requerido' },
	},
	errorPlacement: function(error, element) {
		if(element.attr('name') === 'doc') $('#error-doc').html(error.html());
		if(element.attr('name') === 'nombres') $('#error-nombres').html(error.html());
	},
	submitHandler: function (form, event) {
		//alert('Enviando');
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
			//console.log(data);
			//$('#mdalPermisos').modal('hide');
			$('.resp').html(data.msg);
			setTimeout(function () { $('.resp').html('&nbsp;'); }, 2500);
		}
	}); 
});

$('#asignarSuc').bind('click', function(e){
	e.preventDefault();
	$.ajax({
		data: $('#form_sucursales').serialize(),
		url: base_url + 'usuarios/sucursales/asignar',
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
/*$('#form_permisos').bind('click', function(e){
	let targ = e.target, sub = $('.submenu:checked'), men = $('.menus[data-nivel="1"]');
	
	if($(targ).hasClass('submenu')){
		if(sub.length > 0){
			let submenu = false;
			$.each(men, function(i,e){
				let data = $(e).attr('data-menu');
				$.each(sub,function(i,e){ if($(e).attr('data-submenu') === data) submenu = true; });
				if(submenu) $(e).prop('checked', true);
				else $(e).prop('checked', false);
				submenu = false;
			});
		}else{
			men.prop('checked', false);
		}
	}/*else if($(targ).hasClass('menus')){
		if($(targ).attr('data-nivel') === '1'){
			if($(targ).prop('checked') === false){
				$('.submenu[data-submenu="'+$(targ).attr('data-menu')+'"]').prop('checked',false);
			}
		}
	}else if($(targ).hasClass('modulos')){
		if($(targ).prop('checked') === false) $('#'+$(targ).attr('data-modulo')+' input:checkbox').prop('checked', false);
		$('#'+$(targ).attr('data-modulo')+' *').prop('disabled', ! $(targ).prop('checked'));
	}
});*/

$('input:checkbox').bind('change', function(e){
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
});