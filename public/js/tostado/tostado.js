let tablaTos = null, tablaProv = null, tablaOp = null;

jQuery(document).ready(function($){
	if(segmento2 == ''){
		tablaTos = $('#tablaTostado').DataTable({
			ajax:{
				url: base_url + 'tostado/lista',
				type: 'POST',
				data: function (d) {
					d.anio = $('.anio').val(),
					d.mes = $('.mes').val(),
					d.sucursal = $('.sucursal').val();
				}
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']], language: lngDataTable,
			columns:[
				{
					data: null, orderable: false,
					render: function(data){
						let hrefAnular = btnAnular ? 'href="'+base_url+'tostado/anular?id='+data.idtostado+'"' : '';
						let hrefEdit = btnEdit ?  'href="'+base_url+'tostado/editar?id='+data.idtostado+'"' : '';
						let hrefPdf = btnPdf ? 'href="'+base_url+'tostado/comprobante?id='+data.idtostado+'"' : '';
						let hrefOp = btnOp ? 'href="'+base_url+'tostado/operaciones?id='+data.idtostado+'"' : '';
						let btnAccion =
						'<div class="btn-group">'+
							'<a title="Editar Tostado" '+hrefEdit+' class="bg-warning btnTable '+(!btnEdit?'disabled':'')+'">'+
								'<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'+
							'<a title="Anular Proceso" '+hrefAnular+' class="bg-danger btnTable anular '+(!btnAnular?'disabled':'')+'">'+
								'<i class="fa fa-trash-o" aria-hidden="true"></i></a>'+
							'<a title="Emitir PDF" '+hrefPdf+' class="bg-primary btnTable '+(!btnPdf?'disabled':'')+'" target="_blank">'+
								'<i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>'+
							'<a title="Operaciones Tostado" '+hrefOp+' class="bg-success btnTable '+(!btnOp?'disabled':'')+'">'+
								'<i class="fa fa-home" aria-hidden="true"></i></a>'+
						'</div>';
						return btnAccion;
					}
				},
				{ data: 'idtostado' },{ data: 'numero', render: function(data){ return ceros(data,6); } },{ data: 'fecha_registro' },{ data: 'sucursal' },{ data: 'nombre' },
				{ data: 'articulo' },
				{
					data: 'cantidad', className: 'text-right',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); } return number.toLocaleString('es-PE', opt);
					}
				},
				{
					data: 'precio_total', className: 'text-right',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); } return number.toLocaleString('es-PE', opt);
					}
				}
			],
			columnDefs:headers,order: [],
		});
	}else if(segmento2 === 'nuevo' || segmento2 === 'editar'){
		tablaProv = $('#tablaProveedores').DataTable({
			processing: true,
			serverSide: true,
			ajax:{
				url: base_url + 'certificaciones/proveedores',
				type: 'GET',
				error: function(){
					$("#post_list_processing").css('display','none');
				}
			},
			columns:[
				{ data: 0 },{ data: 1 },{ data: 2, visible: false },{ data: 3, visible: false },{ data: 4, visible: false },
			],
			dom: '<"row"<"mx-auto"l><"mx-auto"f>>rtp',
			colReorder: { order: [ 4, 3, 2, 1, 0 ] }, language: lngDataTable,
		});
	}else if(segmento2 === 'operaciones'){
		tablaOp = $('#opmaquina').DataTable({
			ajax: {
				url: base_url + 'tostado/operaciones/listaoptostado',
				type: 'POST',
				data: function (d) {
					d.idtostado = $('#idtostado').val();
				}
			},
			bDestroy:true, responsive:true, select:false, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']], language: lngDataTable,
			columns:[
				{
					data: null, orderable: false,
					render: function(data){
						let btnAccion =
						'<div class="btn-group">'+
							'<a title="Anular" href="#" class="bg-danger btnTable remover"><i class="fa fa-trash-o" aria-hidden="true"></i></a>'+
						'</div>';
						return btnAccion;
					}
				},
				{ data: 'maquina', render: function(data,type,row,meta){ return row.idmaquina === '1'? 'Maquina 01': 'Maquina 02'; } },
				{
					data: 'tipo',
					render: function(data,type,row,meta){
						let tipo = '';
						switch(row.idtipo){
							case '1': tipo = 'Claro'; break;
							case '2': tipo = 'Medio'; break;
							case '3': tipo = 'Oscuro'; break;
						}
						return tipo;
					}
				},
				{
					data: 'cantidad',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); } return number.toLocaleString('es-PE', opt);
					}
				},{ data: 'codigo' },
			],
			columnDefs:[
				{ title: 'Acciones', targets: 0 },{ title: 'Máquina', targets: 1 },{ title: 'Tipo', targets: 2 },{ title: 'Cantidad', targets: 3 },{ title: 'Código', targets: 4 },
			],order: [],
			
		});
	}
});

function limpiaForm(f) {
	$('#'+f+' .form_error').prop('aria-invalid',false);
	$('#'+f).removeClass('was-validated');
	$('#'+f+' .form_error').removeClass('form_error');
	$('#'+f+' .success').removeClass('success');
	$('#'+f+' .errores').html('');
}

$('.anio').bind('change', function(){
	tablaTos.ajax.reload();
});
$('.mes').bind('change', function(){
	tablaTos.ajax.reload();
});
$('.sucursal').bind('change', function(){
	tablaTos.ajax.reload();
});
$('#tablaProveedores').on('dblclick','tr',function(){
	let data = tablaProv.row( this ).data();
	$('#docu').val(data[2]), $('#productor').val(data[1]), $('#modalProveedores').modal('hide'), $('#idproveedor').val(data[0]);
});
$('.resetea').bind('click', function(){ $('#docu').val(''), $('#productor').val(''), $('#idproveedor').val(''); });
$('.opcion').bind('click', function(){
	if(this.value === 'propio'){
		$('#docu').val($('#nroHidden').val()), $('#productor').val($('#nmbHidden').val()), $('.resetea').addClass('disabled');
		$('#idproveedor').val($('#idnarsa').val());
	}else{
		$('#docu').val(''), $('#productor').val(''), $('#idproveedor').val('');
		$('.resetea').removeClass('disabled');
	}
});
$('.precio').bind('blur', function(){
	if(parseFloat($('#preciot').val()) > 0 && parseFloat($('#preciot').val()) !== ''){
		$('#acuenta').prop('readonly', false);
		if(parseFloat($('#acuenta').val()) > parseFloat($('#preciot').val())){
			alert('El pago no puede ser mayor al precio Total'); $('#acuenta').val(0), $('#acuenta').focus();
		}else{
			if($('#acuenta').val() === '') $('#acuenta').val(0);
			$('#saldo').val(parseFloat($('#preciot').val()) - parseFloat($('#acuenta').val()));
		}
	}else{
		$('#acuenta').prop('readonly', true);
		$('#acuenta').val('');
		$('#saldo').val('');
		$('#preciot').val('');
	}

});
$('.precio').focus(function(){ this.select(); });

$('#sucursalTos').bind('change', function(){ $('#sucursal').val(this.value); });

$('.cancel').bind('click', function(){ $('#modalRegProveedor').modal('hide'); });
$('#buscar').bind('click', function(){ limpiaForm('form_tostado'); });

$('#modalRegProveedor').on('hidden.bs.modal',function(e){
	limpiaForm('form_proveedor');
	$('#form_proveedor')[0].reset();
	$('#form_proveedor select').prop('selectedIndex',0);
	$('.ajaxMap').addClass('d-none');
	$('#btnEnviar').removeClass('disabled'), $('.cancel').removeClass('disabled');
	$('body,html').animate({ scrollTop: 0 }, 'fast');
});
$('#tablaTostado').bind('click','a',function(e){
	let el = e.target, a = $(el).closest('a');
	let fila = tablaTos.row($(a).parents('tr')).data();
	
	if(a.hasClass('anular')){
		e.preventDefault();
		let confirmacion = confirm('Está seguro que desea anular la Transacción?');
		
		if(confirmacion){
			a.html('<i class="fa fa-spinner fa-pulse fa-1x"></i>');
			$.ajax({
				data: {},
				url: base_url + 'tostado/anular?id=' + fila.idtostado,
				method: 'GET',
				dataType: 'JSON',
				beforeSend: function () { a.addClass('disabled'); },
				success: function (data) {
					if (parseInt(data.status) === 200){
						tablaTos.ajax.reload();
					}else{
						a.removeClass('disabled');
						a.html('<i class="fa fa-trash" aria-hidden="true"></i>');
					}
					$('html, body').animate({ scrollTop: 0 }, 'fast');
					$('.resp').html(data.message);
					setTimeout(function () { $('.resp').html('&nbsp;'); }, 2500);
				}
			});
		}
	}
});

/** Formulario de registro de tostado */
$('#form_tostado').validate({
	errorClass: 'form_error',
	validClass: 'success',
	rules: { 
		propter: { required: function () { if ($('#propter').css('display') != 'none') return true; else return false; } },
	},
	messages: {
		propter: { required: 'Debe Elegir una Opción' },
	},
	errorPlacement: function(error, element) {
		//let boton = $('#buscar');
		//if (element.attr('name') == 'propter') error.insertAfter(boton);
		//if (element.attr('name') == 'detalle_otros') error.insertAfter(element);
		//error.insertAfter(element);
		if (element.attr('id') == 'propio') $('#errorcheck').addClass('form_error'), $('#errorcheck').html('Debe Elegir una Opción');
		
	},
	submitHandler: function (form, event) {
		let boton = $('#btnRegistrar');
		$(boton).html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
		$(boton).addClass('disabled'); $('.btn-cancelar').addClass('disabled');
		return true;
	}
});
/* Formulario de registro de productores desde el modulo tostado */
$('#form_proveedor').validate({
	errorClass: 'form_error',
	validClass: 'success',
	rules: {
		tipodoc: { required: function(){ if ($('#tipodoc').css('display') != 'none') return true; else return false; } },
	},
	messages: {
		tipodoc: { required: 'Debe Seleccionar una Opción' },
	},
	errorPlacement: function(error, element){
		/*if (element.attr('id') == 'propio') $('#errorcheck').html('Debe Elegir una Opción');*/
	},
	submitHandler: function (form, event) {
		event.preventDefault();
		let boton = $('#btnEnviar');
		let formData = new FormData(document.getElementById('form_proveedor'));
		//formData.set('tipodetalle',$('#tipoop').find(':selected').text());
		$(boton).html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
		$(boton).addClass('disabled'), $('.cancel').addClass('disabled');
		$.ajax({
			data: new URLSearchParams(formData).toString(),
			url: base_url + 'tostado/proveedor/registrar',
			method: 'POST',
			dataType: 'JSON',
			beforeSend: function(){ },
			success: function(data){
				//console.log(data);
				if(data.id > 0) $('#idproveedor').val(data.id), $('#productor').val($('#nombres').val()), $('#docu').val($('#doc').val()), limpiaForm('form_tostado');
				else $('#idproveedor').val(''), $('#productor').val(''), $('#docu').val('');
				
				$('.reg').html(data.msg), $(boton).html('Guardar Registro'), $('#modalRegProveedor').modal('hide');
				setTimeout(function () { $('.reg').html(''); }, 2500);
			}
		});
		
	}
});

$('#agregar').bind('click', function(){
	let input = $('.datamaquina input, .datamaquina select'), vacio = false;
	$.each(input,function(){
		if(this.value === ''){
			alert('Los campos no pueden estar vacios');
			$(this).focus();
			vacio = true;
			return false;
		}
	});
	if(!vacio){
		let json = [{'maquina':$('#maquina').find(':selected').text(),'tipo':$('#tipo').find(':selected').text(),'cantidad':$('#cantidadtostado').val(),
			'codigo':$('#cod').val(),'activo':1,'idmaquina':$('#maquina').val(),'idtipo':$('#tipo').val()}];
		tablaOp.rows.add(json).draw(), $('#cantidadtostado').val(''), $('#cod').val(''), $('#maquina').prop('selectedIndex',0), $('#tipo').prop('selectedIndex',0);
	}
	//console.log($('#cantidad').val());
});
$('#opmaquina').on('click','a', function(){
	if($(this).hasClass('remover')){ tablaOp.row($(this).parents('tr')).remove().draw(); }
});
$('.form').bind('submit',function(e){
	e.preventDefault();
	let btn = $(this).find('.btn-operaciones'), idbtn = btn.attr('id'), formData = null, validar = false, data = null, url = $(this).prop('action');
	
	if(idbtn === 'guardadespacho'){
		validar = true;
		f = new FormData(document.getElementById('form_despacho'));
		data = new URLSearchParams(f).toString();
	}else if(idbtn === 'guardatrillado'){
		validar = true;
		f = new FormData(document.getElementById('form_trillado'));
		data = new URLSearchParams(f).toString();
	}else if(idbtn === 'guardatostado'){
		data = tablaOp.rows().data().toArray();
		if(data.length > 0){
			validar = true;
			f = new FormData(document.getElementById('form_optostado'));
			formu = new URLSearchParams(f).toString();
			data = { data: JSON.stringify(tablaOp.rows().data().toArray()), f: formu };
		}
	}
	if(validar){
		$.ajax({
			data: data,
			url: url,
			method: 'POST',
			dataType: 'JSON',
			beforeSend: function(){
				btn.addClass('disabled'); btn.html('<i class="fa fa-spinner fa-pulse fa-1x"></i> Cargando');
			},
			success: function(data){
				btn.html('Guardar Operaci&oacute;n'), btn.removeClass('disabled');
				$('.resp').html(data.msg);
				setTimeout(function () { $('.resp').html(''); }, 1500);
			}
		});
	}
});