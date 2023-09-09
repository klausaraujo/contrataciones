let tablaServ = null, inputSaldo = $('#saldo');

function muestraSaldo(val){
	let valor = formatMoneda(val);
	inputSaldo.removeClass('text-danger'); inputSaldo.removeClass('text-success'); inputSaldo.removeClass('text-primary');
	if(parseFloat(valor) < 0) inputSaldo.addClass('text-danger');
	else if(parseFloat(valor) > 0) inputSaldo.addClass('text-primary');
	else inputSaldo.addClass('text-success');
	inputSaldo.val(valor);
}

jQuery(document).ready(function($){
	if(segmento2 == ''){
		tablaServ = $('#tablaServicios').DataTable({
			ajax:{
				url: base_url + 'servicios/lista',
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
						let nulable = 0; if(data.idtipooperacion === '7' || data.idtipooperacion === '9' || data.idtipooperacion === '11' || data.idtipooperacion === '12' ||
							data.idtipooperacion === '13') nulable = 1;
						let hrefAnular = '';
						if(btnAnular){
							if(nulable) hrefAnular = 'href="'+base_url+'servicios/anular?id='+data.idmovimiento+'&suc='+$('.sucursal').val()+'"';
							else{
								if(data.idtipooperacion !== '6'){
									hrefAnular = 'href="'+base_url+'proveedores/transacciones/anular?id='+data.idtransaccion+'&op=operaciones"';
								}else{
									hrefAnular = 'href="'+base_url+'proveedores/valorizaciones/anular?id='+data.idtransaccion+'&op=valorizop"';
								}
							}
						}
						let hrefEdit = btnEdit && nulable ?  'href="'+base_url+'servicios/editar?id='+data.idmovimiento+'&suc='+$('.sucursal').val()+'"' : '';
						let hrefPdf = btnPdf? 'href="'+base_url+'servicios/comprobante?id='+data.idmovimiento+'&suc='+$('.sucursal').val()+'"' : '';
						//if(! nulable){ hrefPdf = 'href="'+base_url+'proveedores/transacciones/impresion?id='+data.idtransaccion+'&op=impresion"'; }
						let btnAccion =
						'<div class="btn-group">'+
							'<a title="Editar Operacion" '+hrefEdit+' class="bg-warning btnTable editar '+(!btnEdit || !nulable?'disabled':'')+'">'+
								'<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'+
							'<a title="Anular Operaci&oacute;n" '+hrefAnular+' class="bg-danger btnTable anular '+(!btnAnular?'disabled':'')+'">'+
								'<i class="fa fa-trash-o" aria-hidden="true"></i></a>'+
							'<a title="Ver Movimiento" '+hrefPdf+' class="bg-primary btnTable '+(!btnPdf?'disabled':'')+'" target="_blank">'+
								'<i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>'+
						'</div>';
						return btnAccion;
					}
				},
				{ data: 'idtipooperacion' },{ data: 'idtransaccion', render: function(data){ return ceros(data,6); } },{ data: 'sucursal' },{ data: 'tipo_operacion' },
				{
					data: 'monto_factor_final', className: 'text-right',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); } return number.toLocaleString('es-PE', opt);
					}
				},
				{ data: 'fecha_registro' },
			],
			columnDefs:headers,order: [],
		});
	}
});
$('.anio').bind('change', function(){
	tablaServ.ajax.reload();
});
$('.mes').bind('change', function(){
	tablaServ.ajax.reload();
});
$('.sucursal').bind('change', function(){
	let suc = $('.sucursal').prop('selectedIndex');
	if(!$('#form_caja').length) tablaServ.ajax.reload();
	$('#gastos').addClass('d-none');
	
	//if($('#form_caja').length)$('#form_caja')[0].reset();
	$.ajax({
		data: {'sucursal': $('.sucursal').val()},
		url: base_url + 'servicios/saldo',
		method: 'POST',
		dataType: 'JSON',
		beforeSend: function (){ },
		success: function (data){
			if($('#form_caja').length){
				$('#form_caja')[0].reset();
				$('#saldoActual').val(data);
				muestraSaldo(data);
				$('.sucursal').prop('selectedIndex',suc);
			}else muestraSaldo(data);
		}
	});
});
$('.tipoCaja').bind('change', function(e){
	let suc = $('.sucursal').prop('selectedIndex'), tipocaja = $('#tipoCaja').prop('selectedIndex'), inputs = $('#gastos input'), sel = $('#gastos select');
	/*if((parseInt($('#saldoActual').val()) === 0 || parseInt($('#saldoActual').val()) < 0) && this.value !== 7){
		alert('No hay saldo suficiente para la Sucursal elegida');
		$('#form_caja')[0].reset();
		//$(this).prop('selectedIndex',0);
		muestraSaldo($('#saldoActual').val());
		$('.sucursal').prop('selectedIndex',suc);
		//$('.obs').html('');
		val = false;
	}*/
	$.each(inputs,function(i,e){ $(e).val(''); });
	$.each(sel,function(i,e){ $(e).prop('selectedIndex',0); });
	$('#renta').attr('disabled',true);
	$('#form_caja .form_error').removeClass('form_error'), $('#form_caja select').prop('selectedIndex', 0), $('#form_caja .success').removeClass('success');
	$('#form_caja')[0].reset(), $('.sucursal').prop('selectedIndex', suc), $('#tipoCaja').prop('selectedIndex', tipocaja);
	
	if(this.value === '9'){
		if($('#gastos').css('display') == 'none' || $('#gastos').css('opacity') == 0) $('#gastos').removeClass('d-none');
		if(!$('#checkrenta').attr('disabled')){ $('#checkrenta').attr('disabled',true); $('#checkrenta').attr('checked', false); $('#checkigv').removeAttr('disabled'); }
	}else if(this.value !== '9'){
		if(!$('#gastos').css('display') == 'none' || $('#gastos').css('opacity') == 1) $('#gastos').addClass('d-none');
	}
});
$('#btnEnviar').bind('click', function(e){
	/*if(parseFloat($('#monto').val()) > parseFloat($('#saldoActual').val()) && parseInt($('.tipoCaja').val()) > 7){
		alert('El monto a pagar es mayor que el saldo');
		e.preventDefault();
	}*/
	if(parseInt($('#monto').val()) === 0){
		alert('El monto no puede ser igual a cero');
		e.preventDefault();
	}
});

$('#tablaServicios').bind('click','a',function(e){
	let evt = e.target, a = $(evt).closest('a');
	
	if(a.hasClass('anular')){
		e.preventDefault();
		let confirmacion = confirm('Está seguro que desea anular la Transacción?');
		if(confirmacion){
			a.html('<i class="fas fa-spinner fa-pulse fa-1x"></i>');
			$.ajax({
				data: {},
				url: a.attr('href'),
				method: 'GET',
				dataType: 'JSON',
				beforeSend: function () { a.addClass('disabled'); },
				success: function (data) {
					if (parseInt(data.status) === 200){
						tablaServ.ajax.reload();
					}else{
						a.removeClass('disabled');
						a.html('<i class="far fa-trash" aria-hidden="true"></i>');
					}
					muestraSaldo(data.saldo);
					//$('#rescta').val(formatMoneda(data.edocta));
					$('html, body').animate({ scrollTop: 0 }, 'fast');
					$('.resp').html(data.message);
					setTimeout(function () { $('.resp').html('&nbsp;'); }, 2500);
				}
			});
		}
		return false;
	}
});
$('#tipoComp').bind('change', function(){
	if(this.value === '02'){ 
		if($('#checkrenta').attr('disabled')){ $('#checkrenta').removeAttr('disabled'); $('#checkigv').attr('disabled', true); $('#checkigv').attr('checked', false); }
		$('#igv').val(''); $('#imp_igv').val('');
	}else{
		if(!$('#checkrenta').attr('disabled')){ $('#checkrenta').attr('disabled',true); $('#checkrenta').attr('checked', false); $('#checkigv').removeAttr('disabled'); }
		$('#renta').val(''); $('#imp_renta').val('');
	}
	if($('#monto').val() !== '' && $('#monto').val() > 0){ $('#baseImp').val($('#monto').val()); $('#base_imponible').val($('#monto').val()); }
	else{ $('#baseImp').val(''); $('#base_imponible').val(''); }
});
$('#checkigv').bind('click',function(e){
	let mto = $('#monto').val();
	if($(this).prop('checked')){
		if(mto !== '' && parseFloat(mto) > 0){
			let base = parseFloat(mto) / 1.18, imp = parseFloat(mto) - base; $('#igv').val(formatMoneda(imp)); $('#baseImp').val(formatMoneda(base));
			$('#base_imponible').val(base), $('#imp_igv').val(imp);
		}else{ $('#baseImp').val(''); $('#base_imponible').val(''); }
	}else{
		$('#igv').val('');
		$('#imp_igv').val('');
		if(mto !== '' && parseFloat(mto) > 0){ $('#baseImp').val(mto); $('#base_imponible').val(mto); }
		else{ $('#baseImp').val(''); $('#base_imponible').val(''); }
	}
});
$('#checkrenta').bind('click',function(e){
	let mto = $('#monto').val();
	if($(this).prop('checked')){
		if(mto !== '' && parseFloat(mto) > 0){
			let imp = parseFloat(mto) * 0.08, base = parseFloat(mto) - imp; $('#renta').val(formatMoneda(imp)), $('#baseImp').val(formatMoneda(base));
			$('#base_imponible').val(base), $('#imp_renta').val(imp);
		}else{ $('#baseImp').val(''); $('#base_imponible').val(''); }
	}else{
		$('#renta').val('');
		$('#imp_renta').val('');
		if(mto !== '' && parseFloat(mto) > 0){ $('#baseImp').val(mto); $('#base_imponible').val(mto); }
		else{ $('#baseImp').val(''); $('#base_imponible').val(''); }
	}
});

$('#form_caja').validate({
	errorClass: 'form_error',
	validClass: 'success',
	rules: {
		monto: { required: function () { if ($('#monto').css('display') != 'none') return true; else return false; } },
		rucvalor: { required: function () { if ($('#rucvalor').css('display') != 'none') return true; else return false; } },
		razonSoc: { required: function () { if ($('#razonSoc').css('display') != 'none') return true; else return false; } },
		tipoComp: { required: function () { if ($('#tipoComp').css('display') != 'none') return true; else return false; } },
		serie: { required: function () { if ($('#serie').css('display') != 'none') return true; else return false; } },
		num: { required: function () { if ($('#num').css('display') != 'none') return true; else return false; } },
		renta: { required: function () { if(!$('#renta').attr('disabled') && $('#renta').css('display') != 'none') return true; else return false; } },
		baseImp: { required: function () { if ($('#baseImp').css('display') != 'none') return true; else return false; } },
	},
	messages: {
		monto: { required: '&nbsp;&nbsp;Monto Requerido' },
		rucvalor: { required: '&nbsp;&nbsp;Campo Requerido' },
		razonSoc: { required: '&nbsp;&nbsp;Campo Requerido' },
		tipoComp: { required: '&nbsp;&nbsp;Campo Requerido' },
		serie: { required: '&nbsp;&nbsp;Campo Requerido' },
		num: { required: '&nbsp;&nbsp;Campo Requerido' },
		renta: { required: '&nbsp;&nbsp;Campo Requerido' },
		baseImp: { required: '&nbsp;&nbsp;Campo Requerido' },
	},
	errorPlacement: function(error, element) {
		let boton = $('#buscaRuc');
		
		if (element.attr('name') == 'rucvalor') error.insertAfter(boton);
		else error.insertAfter(element);
	},
	submitHandler: function (form, event) {
		$('#btnEnviar').html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
		$('#btnEnviar').addClass('disabled');
		$('.btn-cancelar').addClass('disabled');
		form.submit();
	}
});