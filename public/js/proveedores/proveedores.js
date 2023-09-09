let tabla = null, tablaOp, tablaReg, tablaIngDetalle, tablaValDetalle, tablaVal, tablaCobros, tablapagos, tablaPagosVal;

/*function formateaNumero(value) {
  v = parseFloat(value)
  v = v.toFixed(2);
  return new Intl.NumberFormat('es-PE', { style: 'decimal' }).format(v);
}*/
function muestraEdoCta(val){
	let valor = formatMoneda(val);
	$('#rescta').removeClass('text-danger'); $('#rescta').removeClass('text-success'); $('#rescta').removeClass('text-primary');$('#rescta').val('');
	if(parseFloat(valor) < 0) $('#rescta').addClass('text-danger');
	else if(parseFloat(valor) > 0) $('#rescta').addClass('text-primary');
	else $('#rescta').addClass('text-success');
	$('#rescta').val(valor);
}

$(document).ready(function (){
	if(segmento2 == ''){
		tabla = $('#tablaProveedores').DataTable({
			ajax:{
				url: base_url + 'proveedores/lista',
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']], language: lngDataTable,
			columns:[
				/*{ data: null, orderable: false, className: 'pl-3', render: function(data){ return ''; } },*/
				{
					data: null,
					orderable: false,
					render: function(data){
						let hrefEditar = (data.activo === '1' || btnEdit)?'href="'+base_url+'proveedores/editar?id='+data.idproveedor+'"':'';
						let hrefMov = (data.activo === '1' || btnMov)?'href="'+base_url+'proveedores/transacciones?id='+data.idproveedor+'&name='+data.nombre+'"':'';
						let btnAccion =
						'<div class="btn-group">'+
							'<a title="Editar Proveedor" '+hrefEditar+' class="bg-warning btnTable editar '+((data.activo === '0' || !btnEdit)?'disabled':'')+' ">'+
								'<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'+
							'<a title="Movimientos Proveedor" '+hrefMov+'class="bg-success btnTable '+((data.activo === '0' || !btnMov)?'disabled':'')+' acciones">'+
								'<i class="fa fa-home" aria-hidden="true"></i></a>'+
						'</div>';
						return btnAccion;
					}
				},
				{ data: 'idproveedor' },{ data: 'tipo_documento' },{ data: 'numero_documento' },{ data: 'RUC' },{ data: 'nombre' },{ data: 'domicilio' },{ data: 'zona' },
				{
					data: 'activo',
					render: function(data){
						let var_status = '';
						switch(data){
							case '1': var_status = '<span class="text-success">Activo</span>'; break;
							case '0': var_status = '<span class="text-danger">Anulado</span>'; break;
						}
						return var_status;
					}
				},
			],
			columnDefs:headers, /*dom: botones, buttons:{dom:{container:{tag: 'div',className: 'flexcontent'},buttonLiner:{tag: null}},buttons:[
			'copy','csv','excel','pdf','print']},*/order: [],
		});
	}else if(segmento2 === 'transacciones'){
		/* Tabla de las Transacciones */
		tablaOp = $('#tablaOp').DataTable({
			ajax:{
				url: base_url + 'proveedores/transacciones/lista',
				type: 'POST',
				data: function (d) {
					d.id = id,
					d.sucursal = $('.sucursal').val(),
					d.tipoop = $('.tipoop').val();
				}
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']],
			columns:[
				/*{ data: null, orderable: false, className: 'pl-3', render: function(data){ return ''; } },*/
				{
					data: null,
					orderable: false,
					render: function(data){
						let btnAccion = 
							(data.idtipooperacion !== '6')?
							'<a title="Anular Operaci&oacute;n" '+(btnAnulaOp?'href="'+base_url+'proveedores/transacciones/anular?id='+data.idtransaccion+
								'&op=operaciones"':'')+' class="bg-danger btnTable '+(!btnAnulaOp?'disabled':'')+' anular">'+
								'<i class="fa fa-trash-o" aria-hidden="true"></i></a>':
							'<a title="Anular Operaci&oacute;n" '+(btnAnulaOp?'href="'+base_url+'proveedores/valorizaciones/anular?id='+data.idtransaccion+
								'&op=valorizop"':'')+' class="bg-danger btnTable '+(!btnAnulaOp?'disabled':'')+' anular">'+
								'<i class="fa fa-trash-o" aria-hidden="true"></i></a>';
						btnAccion = '<div class="btn-group">'+btnAccion+
							'<a title="Ver Transacción" href="'+base_url+'proveedores/transacciones/impresion?id='+data.idtransaccion+'&op=impresion"'+
							' class="bg-primary btnTable" target="_blank" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></div>';
						return btnAccion;
					}
				},
				{ data: 'idmovimiento', render: function(data){ return ceros( data, 6 ); } },{ data: 'fecha' },{ data: 'tipo_operacion' },
				{ data: 'sucursal' },{ data: 'nombre' },
				{ 
					data: 'monto_factor_final', className: 'text-right',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); } return number.toLocaleString('es-PE', opt);
					}
				},
				{
					data: 'intereses', className: 'text-right',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); } return number.toLocaleString('es-PE', opt);
					}
				},
				{
					data: 'tasa', className: 'text-right',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); } return number.toLocaleString('es-PE', opt);
					}
				},
				{
					data: 'interes_pagado', className: 'text-right',
					render: function(data,type,row,meta){
						//let number = 0; if(number < 0) number *= -1; return isNaN(number)? '0.00' : formatMoneda(number);
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); if(number < 0) number *= -1 }
						return number.toLocaleString('es-PE', opt);
					}
				},
				/*{ data: 'fecha_movimiento', render: function(data){ let fecha = new Date(data), formato = fecha.toLocaleDateString(); return ceros( formato, 10 ); } },
				{ data: 'usuario' },
				{
					data: 'activo',
					render: function(data){
						let var_status = '';
						switch(data){
							case '1': var_status = '<span class="text-success">Activo</span>'; break;
							case '0': var_status = '<span class="text-danger">Anulado</span>'; break;
						}
						return var_status;
					}
				},*/
			],
			columnDefs:headersOp, order: [],
			language: lngDataTable,
		});
		/* Tabla de los Ingresos */
		tablaReg = $('#tablaIngresos').DataTable({
			ajax:{
				url: base_url + 'proveedores/ingresos/lista',
				type: 'POST',
				data: function (d) {
					d.id = id
				}
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']], language: lngDataTable,
			columns:[
				/*{ data: null, orderable: false, className: 'pl-3', render: function(data){ return ''; } },*/
				{
					data: null,
					orderable: false,
					render: function(data){
						let btnAccion =
						'<div class="btn-group">'+
						/*'<a title="Editar Gu&iacute;a Ingreso" '+((data.activo === '1' || btnEdtGuia || data.anula === '1')?'href="'+base_url+'proveedores/ingresos/editar?id='+data.idguia+'"':'')+
							' class="bg-warning btnTable editarAjax '+((data.activo === '0' || !btnEdtGuia || data.anula === '0')?'disabled':'')+'" data-target="#modalEditIngresos" '+
							'data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'+*/
						'<a title="Anular Gu&iacute;a Ingreso" '+((data.activo === '1' || btnAnulGuia || data.anula === '1')?'href="'+base_url+'proveedores/ingresos/anular?id='+data.idguia+
							'&op=ingresos"':'')+' class="bg-danger btnTable '+((data.activo === '0' || !btnAnulGuia || data.anula === '0')?'disabled':'')+' anular">'+
							'<i class="fa fa-trash-o" aria-hidden="true"></i></a>'+
						/*'<a title="Ver Gu&iacute;a Ingreso" '+((data.activo === '1' || btnPdfGuia)?'href="'+base_url+'proveedores/ingresos/guia_ingreso?id='+data.idguia+
							'&op=guiaing"':'')+' class="bg-primary btnTable '+((data.activo === '0' || !btnPdfGuia)?'disabled':'')+' ver_guia_pdf" target="_blank" >'+
							'<i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>'+*/
						'<a title="Ver Comprobante" '+((data.activo === '1' || btnCompGuia)?'href="'+base_url+'proveedores/ingresos/comprobante?id='+data.idguia+
							'&op=comp"':'')+' class="bg-success btnTable '+((data.activo === '0' || !btnCompGuia)?'disabled':'')+' ver_comp_pdf" target="_blank" >'+
							'<i class="fa fa-file-o" aria-hidden="true"></i></a>'+
						'</div>';
						return btnAccion;
					}
				},
				{ data: 'numero', render: function(data){ return ceros( data, 6 ); } },{ data: 'idguia', render: function(data){ return ceros( data, 6 ); } },
				{ data: 'fecha_guia'},{ data: 'nombre' },{ data: 'sucursal' },
				{
					data: 'cantidad_guia', className: 'text-right',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != '') number = parseFloat(data); return number.toLocaleString('es-PE', opt);
					}
				},
			],
			columnDefs: headersIng,/* dom: botones, buttons:{dom:{container:{tag: 'div',className: 'flexcontent'},buttonLiner:{tag: null}},buttons:[
			'copy','csv','excel','pdf','print']},*/order: [],
		});
		/* Tabla Detalle de los Ingresos */
		tablaIngDetalle = $('#tablaIngDetalle').DataTable({
			data: [],
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, language: lngDataTable, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']],
			columns:[
				{
					data: null, orderable: false,
					render: function(data){
						return '<div class="btn-group"><a title="Eliminar Detalle" href="#" class="bg-warning btnTable eliminarIngdetalle">'+
								'<i class="fa fa-trash-o mx-auto" aria-hidden="true"></i></a></div>';
					}
				},
				{ data: 'articulo' },
				{
					data: 'cantidad', className: 'text-left',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != '') number = parseFloat(data); return number.toLocaleString('es-PE', opt);
					}
				},
				/*{ data: 'sucursal' },*/
				{
					data: 'humedad', className: 'text-left',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != '') number = parseFloat(data); return number.toLocaleString('es-PE', opt);
					}
				},
				{
					data: 'calidad', className: 'text-left',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != '') number = parseFloat(data); return number.toLocaleString('es-PE', opt);
					}
				},
				{ 
					data: 'cantidad_valorizada', className: 'text-left',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != '') number = parseFloat(data); return number.toLocaleString('es-PE', opt);
					}
				},
				{
					data: 'costo', className: 'text-left',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != '') number = parseFloat(data); return number.toLocaleString('es-PE', opt);
					}
				},
				{
					data: 'importe', className: 'text-left',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != '') number = parseFloat(data); return number.toLocaleString('es-PE', opt);
					}
				},
			],
			columnDefs:[
				{ title: 'Acciones', targets: 0 },{ title: 'Producto', targets: 1 },{ title: 'Cantidad Total KG', targets: 2 },/*{ title: 'Sucursal', targets: 3 },*/
				{ title: 'Humedad (%)', targets: 3 },{ title: 'Calidad (%)', targets: 4 },{ title: 'Cantidad Valorizada KG', targets: 5 },{ title: 'Precio', targets: 6 },
				{ title: 'Importe', targets: 7 }
			],
			dom: '<"row"rt>', order: [],
		});
		/* Tabla Detalle de las Valorizaciones */
		tablaValDetalle = $('#tablaValDetalle').DataTable({
			ajax:{
				url: base_url + 'proveedores/valorizaciones/listaDetalle',
				type: 'POST',
				data: function (d) {
					d.id = id,
					d.suc = $('#sucursalVal').val();
				}
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, language: lngDataTable, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']],
			columns:[
				{ data: 'idarticulo' },{ data: 'idguia' },{ data: 'anio_guia' },{ data: 'fecha' },
				{ data: 'numero', render:function(data){ return ceros( data, 6 );} },{ data: 'articulo' },
				{
					data: 'cantidad', className: 'text-right',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); } return number.toLocaleString('es-PE', opt);
					}
				},
				{
					render: function(data,type,full,meta){
						return '<input type="checkbox"'+ (full.checked ? ' checked' : '') +' />';
					},
					orderable: false,
				},
				{
					render: function(data,type,full,meta){
						return '<input type="text" placeholder="0.00" class="form-control form-control-sm input-sm cantidad moneda" style="width:5em" disabled />';
					},
					orderable: false,
				},
				{
					data: 'costo',
					render: function(data,type,full,meta){
						return '<input type="text" placeholder="0.00" id="costo" class="form-control form-control-sm input-sm costo moneda" style="width:5em" value="'+data+'" disabled />';
					},
					orderable: false,
				},
				
			],
			columnDefs:[
				{ title: 'ID Articulo', targets: 0, visible: false },{ title: 'ID Gu&iacute;a', targets: 1, visible: false },{ title: 'A&ntilde;o Gu&iacute;a', targets: 2 },
				{ title: 'Fecha Gu&iacute;a', targets: 3 },{ title: 'Nro. Gu&iacute;a', targets: 4 },{ title: 'Art&iacute;culo', targets: 5 },{ title: 'Saldo', targets: 6 },
				{ title: 'Valorizar', targets: 7 },{ title: 'Cantidad', targets: 8 },{ title: 'Costo', targets: 9 },
			],
			dom: '<"row"rt<"col-12"p>', order: [],
		});
		/* Tabla de las Valorizaciones */
		tablaVal = $('#tablaValorizaciones').DataTable({
			ajax:{
				url: base_url + 'proveedores/valorizaciones/lista',
				type: 'POST',
				data: function (d) {
					d.id = id
				}
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']], language: lngDataTable,
			columns:[
				/*{ data: null, orderable: false, className: 'pl-3', render: function(data){ return ''; } },*/
				{
					data: null,
					orderable: false,
					render: function(data){
						let btnAccion =
						'<div class="btn-group">'+
						'<a title="Anular Valorizaciones" '+((data.activo === '1' || btnAnulValor)?'href="'+base_url+'proveedores/valorizaciones/anular?id='+data.idvalorizacion+
							'&op=valorizaciones"':'')+' class="bg-danger btnTable '+((data.activo === '0' || !btnAnulValor)?'disabled':'')+' anular">'+
							'<i class="fa fa-trash-o" aria-hidden="true"></i></a>'+
						'<a title="Ver Detalle Valorizaci&oacute;n" '+((data.activo === '1' || btnVerValor)?'href="'+base_url+'proveedores/valorizaciones/valoriz_pdf?id='+data.idvalorizacion+
							'&op=valorizdet"':'')+' class="bg-primary btnTable '+((data.activo === '0' || !btnVerValor)?'disabled':'')+' ver_valoriz_pdf" target="_blank" >'+
							'<i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>'+
						'</div>';
						return btnAccion;
					}
				},
				{ data: 'idvalorizacion' },{ data: 'anio_valorizacion' },{ data: 'numero', render: function(data){ return ceros( data, 6 ); }, },{ data: 'fecha_val' },
				{ data: 'nombre' },{ data: 'sucursal' },
				{ 
					data: 'monto',
					className: 'text-right',
					render: function(data,type,row,meta){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != '') number = parseFloat(data);
						switch(row.activo){
							case '1': return number.toLocaleString('es-PE', opt); break;
							case '0': return '<span class="text-danger">'+number.toLocaleString('es-PE', opt)+'</span>'; break;
						}
					}
				},
				{
					data: 'activo',
					render: function(data){
						let var_status = '';
						switch(data){
							case '1': var_status = '<span class="text-success">Activo</span>'; break;
							case '0': var_status = '<span class="text-danger">Anulado</span>'; break;
						}
						return var_status;
					}
				},
			],
			columnDefs: headersVal,/* dom: botones, buttons:{dom:{container:{tag: 'div',className: 'flexcontent'},buttonLiner:{tag: null}},buttons:[
			'copy','csv','excel','pdf','print']},*/order: [],
		});
		/* Tabla para listar las operaciones pendientes por cobrar */
		tablaCobros = $('#tablaCobros').DataTable({
			ajax:{
				url: base_url + 'proveedores/cobros/lista',
				type: 'POST',
				data: function (d) {
					d.id = id,
					d.sucursal = $('.sucursal').val(),
					d.tipoop = $('.tipoop').val();
				}
			},
			columns:[
				{ data: 'tipo_operacion' },
				{
					data: 'monto', className: 'text-right',
					render: function(data){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); } return number.toLocaleString('es-PE', opt);
					}
				},
				{
					data: 'intereses', className: 'text-right',
					render: function(data){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); } return number.toLocaleString('es-PE', opt);
					}
				}
			],
			columnDefs: [
				/*{ orderable: false,className:'select-checkbox',targets:0 },*/
				{ title: 'Tipo Op.', targets: 0 },{ title: 'Monto ', targets: 1 },{ title: 'Intereses', targets: 2 },
			],
			pageLength: 5, dom: 'tp', order: [], language: lngDataTable,
		});
		/* Tabla para listar las operaciones pendientes por pagar */
		tablaPagos = $('#tablaPagos').DataTable({
			ajax:{
				url: base_url + 'proveedores/pagos/lista',
				type: 'POST',
				data: function (d) {
					d.id = id,
					d.sucursal = $('.sucursal').val(),
					d.tipoop = $('.tipoop').val();
				}
			},
			columns:[
				{ data: 'tipo_operacion' },
				{
					data: 'monto', className: 'text-right',
					render: function(data){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); } return number.toLocaleString('es-PE', opt);
					}
				},
				{
					data: 'intereses', className: 'text-right',
					render: function(data){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); } return number.toLocaleString('es-PE', opt);
					}
				}
			],
			columnDefs: [
				/*{ orderable: false,className:'select-checkbox',targets:0 },*/
				{ title: 'Tipo Op.', targets: 0 },{ title: 'Monto ', targets: 1 },{ title: 'Intereses', targets: 2 },
			],
			pageLength: 5, dom: 'tp', order: [], language: lngDataTable,
		});
		
		tablaPagosVal = $('#tablaPagosVal').DataTable({
			ajax:{
				url: base_url + 'proveedores/pagosVal/lista',
				type: 'POST',
				data: function (d) {
					d.id = id,
					d.sucursal = $('.sucursal').val(),
					d.tipoop = $('.tipoop').val();
				}
			},
			columns:[
				{ data: 'tipo_operacion' },
				{
					data: 'monto', className: 'text-right',
					render: function(data){
						let number = 0; if(data && typeof parseFloat(data) === 'number' && data != ''){ number = parseFloat(data); } return number.toLocaleString('es-PE', opt);
					}
				},
			],
			columnDefs: [
				/*{ orderable: false,className:'select-checkbox',targets:0 },*/
				{ title: 'Tipo Op.', targets: 0 },{ title: 'Monto ', targets: 1 },
			],
			pageLength: 5, dom: 'tp', order: [], language: lngDataTable,
		});
		
		/*if(window.innerWidth <= 710){ if(tablaValDetalle.columns(2).visible()[0] === true){ tablaValDetalle.columns([2,3]).visible(false); } }
		else{ if(tablaValDetalle.columns(2).visible()[0] === false){ tablaValDetalle.columns([2,3]).visible(true); } }*/
	}
});

$('#tablaCobros').on('click','tr',function(){
	//alert('click');
	if($('.tipoop').val() === '3'){
		//alert('Cobros');
		if(tablaCobros.rows().count() > 0){
			let fila = tablaCobros.row(this).data(), valid = $('#form_transacciones').validate(); valid.resetForm();
			$('#form_transacciones .error').removeClass('error');
						
			if($(this).hasClass('selected')) {
				//$(this).removeClass('selected');
			}else{
				$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			if($('tr.selected').length > 0){
				//Valores de los input hidden
				$('#tipoop_p').val(fila.tipo_operacion), $('#idtipoop_p').val(fila.idtipooperacion), $('#mtoprestamo').val(parseFloat(fila.monto));
				if(parseFloat(fila.intereses) < 0)
					$('#intprestamo').val((parseFloat(fila.intereses) * -1).toFixed(2)), $('#interescobro').val((parseFloat(fila.intereses) * -1).toFixed(2));
				else $('#intprestamo').val(parseFloat(fila.intereses)), $('#interescobro').val(parseFloat(fila.intereses).toFixed(2));
				
				$('#idprestamo').val(fila.idtransaccion), $('#tasaprestamo').val(fila.tasa);
								
				$('#montocobro').val(parseFloat(fila.monto).toFixed(2)), $('#checkliquida').prop('checked', true);
				$('#montocobro').removeAttr('readonly'), $('#interescobro').removeAttr('readonly'), $('#checkliquida').removeAttr('disabled');
			}else{
				let tipo = $('.tipoop').prop('selectedIndex'), suc = $('#sucursal').prop('selectedIndex');
				$('#form_transacciones')[0].reset();
				$('#montocobro').attr('readonly', true);
				$('#interescobro').attr('readonly', true);
				$('#checkliquida').attr('disabled', true);
				$('.tipoop').prop('selectedIndex',tipo), $('#sucursal').prop('selectedIndex',suc);
			}
			
		}
	}
});
$('#tablaPagos').on('click','tr',function(){
	//alert('click');
	if($('.tipoop').val() === '2'){
		//alert('Cobros');
		if(tablaPagos.rows().count() > 0){
			let fila = tablaPagos.row(this).data(), valid = $('#form_transacciones').validate(); valid.resetForm();
			$('#form_transacciones .error').removeClass('error');
						
			if($(this).hasClass('selected')) {
				//$(this).removeClass('selected');
			}else{
				$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			if($('tr.selected').length > 0){
				//Valores de los input hidden
				$('#tipoop_p').val(fila.tipo_operacion), $('#idtipoop_p').val(fila.idtipooperacion), $('#mtopago').val(parseFloat(fila.monto));
				if(parseFloat(fila.intereses) < 0)
					$('#intpago').val((parseFloat(fila.intereses) * -1).toFixed(2)), $('#interespago').val((parseFloat(fila.intereses) * -1).toFixed(2));
				else $('#intpago').val(parseFloat(fila.intereses)), $('#interespago').val(parseFloat(fila.intereses).toFixed(2));
				
				$('#idpago').val(fila.idtransaccion), $('#tasapago').val(fila.tasa);
				
				$('#montopago').val(parseFloat(fila.monto).toFixed(2)), $('#checkliquidapago').prop('checked', true);
				$('#montopago').removeAttr('readonly'), $('#interespago').removeAttr('readonly'), $('#checkliquidapago').removeAttr('disabled');
				
				if(fila.idtipooperacion === '9'){ $('#interespago').attr('readonly', true); }
			}else{
				let tipo = $('.tipoop').prop('selectedIndex'), suc = $('#sucursal').prop('selectedIndex');
				$('#form_transacciones')[0].reset();
				$('#montopago').attr('readonly', true);
				$('#interespago').attr('readonly', true);
				$('#checkliquidapago').attr('disabled', true);
				$('.tipoop').prop('selectedIndex',tipo), $('#sucursal').prop('selectedIndex',suc);
			}
			
		}
	}
});
$('#tablaPagosVal').on('click','tr',function(){
	//alert('click');
	if($('.tipoop').val() === '10'){
		//alert('Cobros');
		if(tablaPagosVal.rows().count() > 0){
			let fila = tablaPagosVal.row(this).data(), valid = $('#form_transacciones').validate(); valid.resetForm();
			$('#form_transacciones .error').removeClass('error');
						
			if($(this).hasClass('selected')) {
				//$(this).removeClass('selected');
			}else{
				$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			if($('tr.selected').length > 0){
				//Valores de los input hidden
				$('#tipoop_p').val(fila.tipo_operacion), $('#idtipoop_p').val(fila.idtipooperacion), $('#mtoval').val(parseFloat(fila.monto));
				$('#idvalor').val(fila.idtransaccion), $('#montovalor').val(parseFloat(fila.monto).toFixed(2));
				$('#checkliquidaval').prop('checked', true), $('#montovalor').removeAttr('readonly'), $('#checkliquidaval').removeAttr('disabled');
				
				if(fila.idtipooperacion === '9'){ $('#interespago').attr('readonly', true); }
			}else{
				let tipo = $('.tipoop').prop('selectedIndex'), suc = $('#sucursal').prop('selectedIndex');
				$('#form_transacciones')[0].reset();
				$('#montovalor').attr('readonly', true);
				$('#checkliquidaval').attr('disabled', true);
				$('.tipoop').prop('selectedIndex',tipo), $('#sucursal').prop('selectedIndex',suc);
			}
			
		}
	}
});

/*window.onresize = function(){
	//console.log(window.innerWidth);
	//console.log(tablaValDetalle.columns(2).visible()[0]);
	if(segmento2 === 'transacciones'){
		if(window.innerWidth <= 710){ if(tablaValDetalle.columns(2).visible()[0] === true){ tablaValDetalle.columns([2,3]).visible(false); } }
		else{ if(tablaValDetalle.columns(2).visible()[0] === false){ tablaValDetalle.columns([2,3]).visible(true); } }
	}
}*/

$('#modalIngresos').on('hidden.bs.modal',function(e){
	$('#form_ingresos')[0].reset();
	$('#form_ingresos select').prop('selectedIndex',0);
	$('#cantidadValoriz').attr('disabled','disabled');
	
	$('#formPagoIngreso')[0].reset();
	$('#formPagoIngreso select').prop('selectedIndex',0);
	$('#desembolso').attr('disabled',true);
	$('.pagoValoriz').attr('disabled',true);
	$('#chkPagoValoriz').attr('disabled',true);
	//$('.saldo').addClass('d-none');
	
	tablaIngDetalle.clear().draw();
	$('#sucursalIng').removeAttr('disabled');
	if(!$('#chkPagoValoriz').prop('checked')) $('#chkPagoValoriz').prop('checked', false);
	if(!$('#chkPagoValoriz').attr('disabled')) $('#chkPagoValoriz').attr('disabled', true);
	
	/*let a = document.createElement("a");
    a.setAttribute('href', 'http://www.google.es');
	a.setAttribute('target', '_blank');
	a.setAttribute('id', 'imprimir');
	//a.setAttribute('class', 'd-none');
	a.textContent = "soy un div creado con javascript";
	document.body.appendChild(a);
	console.log($('#imprimir'));*/
	
	$('body,html').animate({ scrollTop: 0 }, 'fast');
	//setTimeout(function () { if(!$('.mesg').css('display') == 'none' || $('.mesg').css('opacity') == 1) $('.mesg').hide('slow'); }, 3000);
});

$('#modalValorizaciones').on('hidden.bs.modal',function(e){
	$('#form_valorizaciones')[0].reset();
	tablaValDetalle.clear().draw();
	$('#form_valorizaciones select').prop('selectedIndex',0);
	$('body,html').animate({ scrollTop: 0 }, 'fast');
});

$('#form_proveedor').validate({
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
		if(element.attr('name') === 'nombres') $('#error-razon').html(error.html());
	},
	submitHandler: function (form, event) {
		//alert('Enviando');
		$('#form_proveedor button[type=submit]').html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
		$('#form_proveedor button[type=submit]').addClass('disabled');
		btnCancelar.addClass('disabled');
		//return true;
		form.submit();
	}
});
$('#form_transacciones').validate({
	errorClass: 'form_error',
	rules: {
		tipoop: { required: function () { if ($('.tipoop').css('display') != 'none') return true; else return false; } },
		sucursal: { required: function () { if ($('.sucursal').css('display') != 'none') return true; else return false; } },
		fechavenc: { required: function () { if ($('#fechavenc').css('display') != 'none') return true; else return false; } },
		monto: { required: function () { if ($('#monto').css('display') != 'none') return true; else return false; } },
		interes: { required: function () { if ($('#interes').css('display') != 'none') return true; else return false; } },
		montopago: { required: function () { if ($('#montopago').css('display') != 'none') return true; else return false; } },
		interespago: { required: function () { if ($('#interespago').css('display') != 'none') return true; else return false; } },
		montocobro: { required: function () { if ($('#montocobro').css('display') != 'none') return true; else return false; } },
		interescobro: { required: function () { if ($('#interescobro').css('display') != 'none') return true; else return false; } },
		montoanterior: { required: function () { if ($('#montoanterior').css('display') != 'none') return true; else return false; } },
		montovalor: { required: function () { if ($('#montovalor').css('display') != 'none') return true; else return false; } },
	},
	messages: {
		tipoop: { required: '&nbsp;&nbsp;Debe elegir una Transacci&oacute;n' },
		sucursal: { required: '&nbsp;&nbsp;Debe elegir la Sucursal' },
		fechavenc: { required: '&nbsp;&nbsp;Debe elegir una fecha' },
		monto: { required: '&nbsp;&nbsp;Monto Requerido' },
		interes: { required: '&nbsp;&nbsp;Inter&eacute;s Requerido' },
		montopago: { required: '&nbsp;&nbsp;Monto Requerido' },
		interespago: { required: '&nbsp;&nbsp;Inter&eacute;s Requerido' },
		montocobro: { required: '&nbsp;&nbsp;Monto Requerido' },
		interescobro: { required: '&nbsp;&nbsp;Inter&eacute;s Requerido' },
		montovalor: { required: '&nbsp;&nbsp;Monto Requerido' },
	},
	errorPlacement: function(error, element){
		error.insertAfter(element);
	},
	submitHandler: function (form, event){
		event.preventDefault();
		let tipoop = $('#tipoop').val(), intp = parseFloat($('#intpago').val());/*let mayor = false;*/
		if(tipoop === '3'){
			if(parseFloat($('#montocobro').val()) === parseFloat($('#mtoprestamo').val()) && !$('#checkliquida').prop('checked')) $('#checkliquida').prop('checked', true);
			else if(parseFloat($('#montocobro').val()) < parseFloat($('#mtoprestamo').val()) && $('#checkliquida').prop('checked')) $('#checkliquida').prop('checked', false);
		}else if(tipoop === '2'){
			if(parseFloat($('#montopago').val()) === parseFloat($('#mtopago').val()) && !$('#checkliquidapago').prop('checked')) $('#checkliquidapago').prop('checked', true);
			else if(parseFloat($('#montopago').val()) < parseFloat($('#mtopago').val()) && $('#checkliquidapago').prop('checked')) $('#checkliquidapago').prop('checked', false);
		}else if(tipoop === '10'){
			if(parseFloat($('#montovalor').val()) === parseFloat($('#mtoval').val()) && !$('#checkliquidaval').prop('checked')) $('#checkliquidaval').prop('checked', true);
			else if(parseFloat($('#montovalor').val()) < parseFloat($('#mtoval').val()) && $('#checkliquidaval').prop('checked')) $('#checkliquidaval').prop('checked', false);
		}
		
		if(parseFloat($('#interespago').val()) > intp){
			$('#interespago').val(''); alert('El pago de intereses no puede ser mayor a los intereses generados');
			$('#interespago').focus(); return 0;
		}
		if(parseInt($('#montovalor').val()) === 0){
			alert('El monto no puede ser '+$('#montovalor').val()), $('#montovalor').val(''), $('#montovalor').focus(); return 0;
		}
		/*if(tipoop === '2'){
			let mto = $('#rescta').val(); mto = mto.replace(/\,/g,''), monto = $('#monto').val();
			if(parseFloat(monto) > parseFloat(mto)){ alert('No se puede pagar un monto mayor a la deuda'), mayor = true; return false; }
		}
		if(!mayor){*/
		let formData = new FormData(document.getElementById('form_transacciones'));
		formData.set('tipodetalle',$('#tipoop').find(':selected').text());
		//console.log(parseFloat($('#monto').val()));
			$.ajax({
				data: new URLSearchParams(formData).toString(),
				url: base_url + segmento + '/transacciones/operaciones',
				method: 'POST',
				dataType: 'JSON',
				beforeSend: function(){
					//$('.resp').html('<i class="fas fa-spinner fa-pulse fa-2x"></i>');
					$('#form_transacciones button[type=submit]').html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
					$('#form_transacciones button[type=submit]').addClass('disabled');
				},
				success: function (data) {
					//$('.resp').html('');
					$('#form_transacciones button[type=submit]').html('Ejecutar');
					$('#form_transacciones button[type=submit]').removeClass('disabled');
					//console.log(data);
					if(parseInt(data.status) === 100) alert(data.message);
					else{
						//if(!$('.interesAjax').css('display') == 'none' || $('.interesAjax').css('opacity') == 1) $('.interesAjax').hide();
						let suc = $('#sucursal').prop('selectedIndex');
						$('#opciones_p').addClass('d-none');
						$('#form_transacciones')[0].reset();
						$('#sucursal').prop('selectedIndex',suc);
						$('.resp').html(data.message);
						setTimeout(function () { $('.resp').html('&nbsp;'); }, 1500);
					}
					
					if(parseInt(data.status) === 200){
						//$('html, body').animate({ scrollTop: 0 }, 'fast');
						//let op = $('#tipoop :selected').val(), suc = $('#sucursal :selected').val(); mto = $('#monto').val();
						tablaOp.ajax.reload();
					}
					
					muestraEdoCta(data.edocta);
				}
			});
		//}
	}
});

$('#form_ingresos').validate({
	errorClass: 'form_error',
	rules: {
		proveedorIng: { required: true },
		sucursalIng: { required: true },
		articuloIng: { required: true },
		cantidadIng: { required: true },
		cantidadValoriz: { required: function(){ if($('#valorizaIng').prop('checked')) return true; else return false; } },
		costoValoriz: { required: function(){ if($('#valorizaIng').prop('checked')) return true; else return false; } },
	},
	messages: {
		proveedorIng: { required: '&nbsp;&nbsp;Campo Proveedor no puede estar Vac&iacute;o' },
		sucursalIng: { required: '&nbsp;&nbsp;Debe elegir la Sucursal' },
		articuloIng: { required: '&nbsp;&nbsp;Debe elegir un Art&iacute;culo' },
		cantidadIng: { required: '&nbsp;&nbsp;Cantidad Requerida' },
		cantidadValoriz: { required: '&nbsp;&nbsp;Cantidad a valorizar' },
		costoValoriz: { required: '&nbsp;&nbsp;Costo requerido' },
	},
	errorPlacement: function(error, element) {
		error.insertAfter(element);
	},
	submitHandler: function (form, event) {
		event.preventDefault();
		let kg = $('#cantidadIng').val(), kgValor = isNaN($('#cantidadValoriz').val() || $('#cantidadValoriz').val() == '')? 0 : parseFloat($('#cantidadValoriz').val());
		let costoValor = isNaN($('#costoValoriz').val() || $('#costoValoriz').val() == '')? 0 : parseFloat($('#costoValoriz').val()), ids = $('#sucursalIng').val();
		let importe = (isNaN(kgValor) || isNaN(costoValor) || costoValor == '' || kgValor == '')? 0 : kgValor * costoValor, obs = $('#obsIng').val(), valor = false;
		
		
		//console.log(parseFloat(costoValor) + "   " + parseFloat(kgValor));
		if(parseFloat(kgValor) == 0 && $('#valorizaIng').prop('checked') === true){ alert('Debe indicar la cantidad a Valorizar'); return false; }
		if(parseFloat(kg) < parseFloat(kgValor) && $('#valorizaIng').prop('checked') === true){ alert('La cantidad a valorizar no puede ser mayor que el monto'); return false; }
		if(parseFloat(costoValor) == 0 && $('#valorizaIng').prop('checked') === true){ alert('Debe indicar el costo'); return false; }
		
		
		if(tablaIngDetalle.rows().count() === 0){
			$('#sucursalIng').attr('disabled','disabled');
			//$('#sucursalIng option[value='+$('#articuloIng').val()+']').attr('selected', true);
		}else{
			tablaIngDetalle.rows().data().each(function (value){
				if(value['idarticulo'] == $('#articuloIng').val())
					valor = true;
			});
		}
		if(!valor){
			if($('#valorizaIng').prop('checked') === true){
				let precio = kgValor * costoValor;
				if($('#chkPagoValoriz').prop('checked')){
					if(tablaIngDetalle.rows().count() > 0){
						tablaIngDetalle.rows().data().each(function (value){
							precio += parseFloat(value['importe']);
						});
					}
					$('#subTotalPago').val(precio.toFixed(2));
				}
				if($('#chkPagoValoriz').prop('disabled') && precio > 0)$('#chkPagoValoriz').prop('disabled', false);
			}
			
			var json = [{ 'idarticulo':$('#articuloIng').val(),'articulo':$('#articuloIng :selected').text(),'cantidad':kg,'idsucursal':$('#sucursalIng').val(),
					'sucursal':$('#sucursalIng :selected').text(),'humedad':$('#humedadIng').val(),'calidad':$('#calidadIng').val(),'cantidad_valorizada':kgValor,
					'costo':$('#costoValoriz').val(),'chk_valorizar':($('#valorizaIng').prop('checked')? 1 : 0),'importe':importe, 'tasa': $('#tasaIng').val(),
			}];
			
			tablaIngDetalle.rows.add(json).draw();
		}
		
		$('#form_ingresos')[0].reset();
		$('#cantidadValoriz').attr('disabled','disabled');
		$('#sucursalIng option[value='+ids+']').attr('selected', true);
		//$('#form_ingresos select').prop('selectedIndex',0);
		$('#obsIng').val(obs);
	}
});


$('body').bind('click','a',function(e){
	let el = e.target, a = $(el).closest('a'), row;
	if(a.hasClass('anular')){
		e.preventDefault();
		
		let confirmacion = confirm('Está seguro que desea anular la Transacción?');
		if(confirmacion){
			a.html('<i class="fa fa-spinner fa-pulse fa-1x"></i>');
			$.ajax({
				data: {},
				url: a.attr('href')+'&suc='+ $('#sucursal').val(),
				method: 'GET',
				dataType: 'JSON',
				beforeSend: function () { a.addClass('disabled'); },
				success: function (data) {
					if (parseInt(data.status) === 200){
						tablaReg.ajax.reload(); tablaOp.ajax.reload(); tablaVal.ajax.reload(); tablaCobros.ajax.reload();
					}else{
						a.removeClass('disabled');
						a.html('<i class="fa fa-trash" aria-hidden="true"></i>');
					}
					muestraEdoCta(data.edocta);
					//$('#rescta').val(formatMoneda(data.edocta));
					$('html, body').animate({ scrollTop: 0 }, 'fast');
					$('.resp').html(data.message);
					setTimeout(function () { $('.resp').html('&nbsp;'); }, 2500);
				}
			});
		}
	}else if(a.hasClass('eliminarIngdetalle')){
		let precio = 0;
		if(tablaIngDetalle.row(a).child.isShown()){
			let fila = tablaIngDetalle.row(a).data();
			tablaIngDetalle.row(a).remove().draw();
		}else{
			let fila = tablaIngDetalle.row($(a).parents('tr')).data();
			tablaIngDetalle.row($(a).parents('tr')).remove().draw();
		}
		
		if(tablaIngDetalle.rows().count() > 0){
			tablaIngDetalle.rows().data().each(function (value){
				precio += parseFloat(value['importe']);
			});
		}else{
			$('#form_ingresos')[0].reset();
			$('#formPagoIngreso')[0].reset();
			$('#formPagoIngreso select').prop('selectedIndex',0);
			$('#form_ingresos select').prop('selectedIndex',0);
			$('#sucursalIng').removeAttr('disabled');
			$('.saldo').addClass('d-none');
		}
		
		if(parseInt(precio) === 0){
			let saldo = $('#saldo').val();
			$('#formPagoIngreso')[0].reset();
			$('#formPagoIngreso select').prop('selectedIndex',0);
			if(!$('#chkPagoValoriz').prop('checked')) $('#chkPagoValoriz').prop('checked', false);
			if(!$('#chkPagoValoriz').attr('disabled')) $('#chkPagoValoriz').attr('disabled', true);
			$('#desembolso').attr('disabled',true);
			$('.pagoValoriz').attr('disabled',true);
			$('#saldo').val(saldo);
			$('.saldo').addClass('d-none');
		}else{
			if($('#chkPagoValoriz').prop('checked')){ $('#subTotalPago').val(precio.toFixed(2)); }
		}
	}
});

$('#generarIng').bind('click',function(){
	//alert('Generar ingresos');
	//console.log(tablaIngDetalle.rows().data());
	if(tablaIngDetalle.rows().count() > 0){
		let json = [], i = 0;
		
		if($('#chkPagoValoriz').prop('checked') && $('#pagoValoriz').val() === '8' && (isNaN($('#desembolso').val()) || $('#desembolso').val() === '')){
			alert('Debe indicar el monto en el campo desembolso');
			return false;
		}
		if(parseFloat($('#desembolso').val()) > parseFloat($('#subTotalPago').val())){
			alert('El monto a pagar no debe ser mayor que el monto total');
			return false;
		}
		
		tablaIngDetalle.rows().data().each(function(row){
			json[i] = { 'idarticulo':row.idarticulo, 'idsucursal': row.idsucursal, 'cantidad': row.cantidad, 'idproveedor': $('#idproveedor').val(),
						'cantidad_valorizada': row.cantidad_valorizada, 'costo': row.costo, 'chk_valorizar': row.chk_valorizar, 'tipo_op': $('#pagoValoriz').val(),
						'chk_pago': ($('#chkPagoValoriz').prop('checked')? 1 : 0), 'subtotal': $('#subTotalPago').val(), 'desembolso': $('#desembolso').val(),
						'humedad': row.humedad, 'calidad': row.calidad,'observacion':$('#obsIng').val(),'tasa': row.tasa,
					};
			i++;
		});
		
		//console.log(tablaIngDetalle.rows());
		$.ajax({
			data: JSON.stringify(json),
			url: base_url + 'proveedores/ingresos/nuevo',
			method: 'POST',
			dataType: 'JSON',
			beforeSend: function () { 
				//$('#generarIng').html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
				//$('#generarIng').addClass('disabled');
				//$('#cancelIng').addClass('disabled');
			},
			success: function (data) {
				//console.log(data);
				$('#generarIng').html('Generar Ingreso');
				$('#generarIng').removeClass('disabled');
				$('#cancelIng').removeClass('disabled');
				if(parseInt(data.status) === 200){
					//if(tablaOp.rows().count() > 0)tablaOp.ajax.reload();
					tablaReg.ajax.reload(); tablaOp.ajax.reload(); tablaVal.ajax.reload();
					/*if(tablaReg.rows().count() === 0) tablaReg.clear().draw(); 
					if(tablaOp.rows().count() === 0) tablaOp.clear().draw();
					if(tablaVal.rows().count() === 0) tablaVal.clear().draw();*/
					$('#modalIngresos').modal('hide');
					$('html, body').animate({ scrollTop: 0 }, 'fast');
					/* Muestra la guia para imprimir */
					window.open(base_url + 'proveedores/ingresos/guia_ingreso?id='+data.guia+'&op=comp', '_blank');
					//$('#formPagoIngreso')[0].reset();
					//$('#formPagoIngreso select').prop('selectedIndex',0);
				}
				if(parseInt(data.status) === 100) alert(data.message);
				else{
					$('.resp').html(data.message);
					setTimeout(function () { $('.resp').html('&nbsp;'); }, 2500);
				}
				muestraEdoCta(data.edocta);
			}
		});
	}else{ alert('No hay registros en el detalle'); }
});

$('#tablaValDetalle').bind('click','input',function(e){
	let evt = e.target, inputs = $(evt).closest('tr').find('input'), i = 0;
	//console.log(inputs);
	if($(evt).attr('type') === 'checkbox'){
		if($(evt).prop('checked') === true){
			$(evt).closest('tr').find('.moneda').removeAttr('disabled');
			$(evt).closest('tr').find('.cantidad').focus();
		}else
			$(evt).closest('tr').find('.moneda').attr('disabled','disabled');
	}
});
$('#tablaValDetalle').bind('input',function(e){
	let el = e.target;
	if($(el).attr('type') === 'text'){
		jQuery(el).val(jQuery(el).val().replace(/([^0-9\.]+)/g, ''));
		jQuery(el).val(jQuery(el).val().replace(/^[\.]/,''));
		jQuery(el).val(jQuery(el).val().replace(/[\.][\.]/g,''));
		jQuery(el).val(jQuery(el).val().replace(/\.(\d)(\d)(\d)/g,'.$1$2'));
		jQuery(el).val(jQuery(el).val().replace(/\.(\d{1,2})\./g,'.$1'));
	}
});

$('#guardaVal').bind('click',function(){
	let jsonDetalle = [], jsonTransaccion = [], i = 0, j = 0, guia = '', mto = 0, mult = 0, salta = true;
	if(! tablaValDetalle.rows().count() > 0) return false;
	
	$('#tablaValDetalle tbody input[type=checkbox]:checked').each(function(i, e){
		let data = tablaValDetalle.row($(e).parents('tr')).data();
		let inputCant = $(e).closest('tr').find('input.cantidad'), inputCosto = $(e).closest('tr').find('input.costo');
		if(inputCant.val() != '' && parseFloat(inputCant.val()) <= parseFloat(data.cantidad) && inputCosto.val() != '' && parseFloat(inputCosto.val()) > 0){
			jsonDetalle[i] = { 'idproveedor':id, 'idsucursal': data.idsucursal, 'idguia': data.idguia, 'idarticulo': data.idarticulo, 'cantidad': inputCant.val(),
				'costo': inputCosto.val() };
			
			i++;
			salta = false;
		}else{
			if(inputCant.val() == ''){ alert('Cantidad requerida'); inputCant.focus() }
			else if(parseFloat(inputCant.val()) > parseFloat(data.cantidad)){ alert('La cantidad a valorizar no puede ser mayor que el saldo'); inputCant.focus(); }
			else if(inputCosto.val() == ''){ alert('El costo es Requerido'); inputCosto.focus(); }
			else if(!parseFloat(inputCosto.val()) > 0){ alert('El costo es Requerido'); inputCosto.focus(); }
			salta = true;
			return false;
		}
	});
	if(! salta){
		$.ajax({
			data: JSON.stringify(jsonDetalle),
			url: base_url + 'proveedores/valorizaciones/nuevo',
			method: 'POST',
			dataType: 'JSON',
			beforeSend: function () { 
				$('#guardaVal').html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
				$('#guardaVal').addClass('disabled');
				$('#cancelVal').addClass('disabled');
			},
			success: function (data) {
				//console.log(data);
				$('#guardaVal').html('Valorizar Producto');
				$('#guardaVal').removeClass('disabled');
				$('#cancelVal').removeClass('disabled');
				if (parseInt(data.status) === 200){
					//if(tablaOp.rows().count() > 0)tablaOp.ajax.reload();
					//tablaReg.ajax.reload();
					tablaVal.ajax.reload();
					tablaReg.ajax.reload();
					tablaOp.ajax.reload();
					$('#modalValorizaciones').modal('hide');
					$('.resp').html(data.msg);
					setTimeout(function () { $('.resp').html('&nbsp;'); }, 2500);
				}else{ alert(data.msg); }
				
				muestraEdoCta(data.edocta)
				//$('#rescta').val(formatMoneda(data.edocta));
			}
		});
	}
});

$('#sucursalVal').bind('change', function(){
	tablaValDetalle.ajax.reload();
});
$('#sucursal').bind('change', function(){
	let suc = $(this).prop('selectedIndex');
	if(!$('.interesAjax').css('display') == 'none' || $('.interesAjax').css('opacity') == 1) $('.interesAjax').hide();
	$('#form_transacciones')[0].reset();
	$('#sucursal').prop('selectedIndex',suc);
	$('#opciones_p').addClass('d-none');
	tablaOp.ajax.reload();
	$.ajax({
		data: {'sucursal': $('#sucursal').val(), id: id },
		url: base_url + 'proveedores/edocta',
		method: 'POST',
		dataType: 'JSON',
		beforeSend: function (){ },
		success: function (data){
			//precioVal = data;
			muestraEdoCta(data);
			//$('#rescta').val(formatMoneda(precioVal));
		}
	});
});
$('#modalVal').bind('click', function(){
	tablaValDetalle.ajax.reload();
});
$('.tipoop').bind('change', function(){
	let tipo = $(this).prop('selectedIndex'), suc = $('#sucursal').prop('selectedIndex'), valid = $('#form_transacciones').validate();
	valid.resetForm(); $('#form_transacciones .error').removeClass('error');
	$('#form_transacciones')[0].reset();
	$(this).prop('selectedIndex',tipo), $('#sucursal').prop('selectedIndex',suc), $('#tipoop_p').val('');;
	
	if(parseInt($('.tipoop').val()) > 0) $('#opciones_p').removeClass('d-none');
	else $('#opciones_p').addClass('d-none');
	
	tablaOp.ajax.reload();
	
	$('#montocobro').attr('readonly', true);
	$('#interescobro').attr('readonly', true);
	$('#checkliquida').attr('disabled', true);
	tablaCobros.clear().draw();
	
	$('#montopago').attr('readonly', true);
	$('#interespago').attr('readonly', true);
	$('#checkliquidapago').attr('disabled', true);
	tablaPagos.clear().draw();

	$('#montovalor').attr('readonly', true);
	$('#checkliquidaval').attr('disabled', true);
	tablaPagosVal.clear().draw();
	
	//tablaValDetalle.ajax.reload();
	if($('.tipoop').val() === '1' || $('.tipoop').val() === '7'){
		if($('#pp_pe').css('display') == 'none' || $('#pp_pe').css('opacity') == 0) $('#pp_pe').removeClass('d-none');
		$('#pagos_p').addClass('d-none'), $('#cobros_p').addClass('d-none'), $('#antcta_p').addClass('d-none'), $('#pagos_val').addClass('d-none');
	}else if($('.tipoop').val() === '2'){
		if($('#pagos_p').css('display') == 'none' || $('#pagos_p').css('opacity') == 0) $('#pagos_p').removeClass('d-none');
		$('#pp_pe').addClass('d-none'), $('#cobros_p').addClass('d-none'), $('#antcta_p').addClass('d-none'), $('#pagos_val').addClass('d-none');
		tablaPagos.ajax.reload();
	}else if($('.tipoop').val() === '3'){
		if($('#cobros_p').css('display') == 'none' || $('#cobros_p').css('opacity') == 0) $('#cobros_p').removeClass('d-none');
		$('#pp_pe').addClass('d-none'), $('#pagos_p').addClass('d-none'), $('#antcta_p').addClass('d-none'), $('#pagos_val').addClass('d-none');
		tablaCobros.ajax.reload();
	}else if($('.tipoop').val() === '9'){
		if($('#antcta_p').css('display') == 'none' || $('#antcta_p').css('opacity') == 0) $('#antcta_p').removeClass('d-none');
		$('#pp_pe').addClass('d-none'), $('#pagos_p').addClass('d-none'), $('#cobros_p').addClass('d-none'), $('#pagos_val').addClass('d-none');
	}else if($('.tipoop').val() === '10'){
		if($('#pagos_val').css('display') == 'none' || $('#pagos_val').css('opacity') == 0) $('#pagos_val').removeClass('d-none');
		$('#antcta_p').addClass('d-none'), $('#pp_pe').addClass('d-none'), $('#pagos_p').addClass('d-none'), $('#cobros_p').addClass('d-none');
		tablaPagosVal.ajax.reload();
	}
});
$('#valorizaIng').bind('click',function(e){
	if($(this).prop('checked'))
		$('#cantidadValoriz').attr('disabled',false);
	else $('#cantidadValoriz').attr('disabled',true);
});
$('#chkPagoValoriz').bind('click',function(e){
	let precio = 0, saldo = $('#saldo').val();
	if($(this).prop('checked')){
		if(tablaIngDetalle.rows().count() > 0){
			tablaIngDetalle.rows().data().each(function (value){
				precio += parseFloat(value['importe']);
			});
		}
		$('#formPagoIngreso')[0].reset();
		$('#formPagoIngreso select').prop('selectedIndex',0);
		$(this).prop('checked', true);
		$('#saldo').val(saldo);
		$('#subTotalPago').val(precio.toFixed(2));
		$('.pagoValoriz').attr('disabled',false);
		$('.saldo').removeClass('d-none');
	}else{
		$('#formPagoIngreso')[0].reset();
		$('#formPagoIngreso select').prop('selectedIndex',0);
		$('#saldo').val(saldo);
		//$('#formPagoIngreso select').prop('selectedIndex',0);
		$('#desembolso').attr('disabled',true);
		$('.pagoValoriz').attr('disabled',true);
		$('.saldo').addClass('d-none');
	}
});
$('#pagoValoriz').bind('change',function(e){
	if($(this).val() === '8')
		$('#desembolso').attr('disabled',false);
	else $('#desembolso').attr('disabled',true);
});
$('#sucursalIng').bind('change',function(e){
	//console.log(this.value);
	$.ajax({
		data: {'idsucursal': this.value },
		url: base_url + 'proveedores/saldoSucursal',
		method: 'POST',
		dataType: 'JSON',
		beforeSend: function (){ },
		success: function (data){
			//console.log(data);
			$('#saldo').val(formatMoneda(data));
		}
	});
});