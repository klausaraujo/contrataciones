var tabla1 = null, tabla2 = null, tabla3 = null, tablaProv = null;

jQuery(document).ready(function($){
	$('html, body').animate({ scrollTop: 0 }, 'fast');
	
	if(segmento2 == 'reporte1' || segmento2 == 'reporte2' || segmento2 == 'reporte3'){
		tabla1 = $('#tablaReporte1').DataTable({
			ajax:{
				url: base_url + 'proveedores/tblreporte1',
				type: 'POST',
				data: function (d) {
					d.sucursal = $('.sucursal').val();
					d.anio = $('.anio').val();
					d.articulo = $('.articulo').val();
					d.productor = $('.productor').val();
					d.segmento = $('#segmento').val();
				}
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']], language: lngDataTable,order: [],
			columns:[
				/*{ data: 'anio' },{ data: 'tipo_documento' },*/
				{ data: 'nro_op', render: function(data){ return ceros( data, 6 ); } },{ data: 'numero_documento'},{ data: 'productor' },
				{ data: 'guia', render: function(data){ return ceros( data, 6 ); } },{ data: 'fecha' },{ data: 'articulo' },{ data: 'cantidad' },{ data: 'costo' }
			],
			columnDefs:[
				/*{ title: 'A&ntilde;o', targets: 0 },{ title: 'Tipo Doc.', targets: 1 },*/
				{ title: 'Nro.Op.', targets: 0 },{ title: 'Doc.', targets: 1 },{ title: 'Productor', targets: 2 },{ title: 'Nro. Gu&iacute;a', targets: 3 },
				{ title: 'Fecha Gu&iacute;a', targets: 4 },{ title: 'Art&iacute;culo', targets: 5 },{ title: 'Cantidad', targets: 6 },{ title: 'Costo', targets: 7 },
			]/*, dom: botones,
			buttons: {
				dom: { container: { tag: 'div', className: 'flexcontent' }, buttonLiner: { tag: null } },
				buttons: [
					{ extend: 'copy', className: 'rounded-pill' },
					{ extend: 'excel', className: 'rounded-pill' },
					{ extend: 'pdf', className: 'rounded-pill' },
					{ extend: 'print', className: 'rounded-pill' }
				]
			}*/
		});
	}else if(segmento2 == 'reporte4' || segmento2 == 'reporte5'){
		tabla2 = $('#tablaReporte2').DataTable({
			ajax:{
				url: base_url + 'proveedores/tblreporte1',
				type: 'POST',
				data: function (d) {
					d.sucursal = $('.sucursal').val();
					d.productor = $('.productor').val();
					d.segmento = $('#segmento').val();
				}
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']], language: lngDataTable, order: [],
			columns:[
				{ data: 'nro_op', render: function(data){ return ceros( data, 6 ); } },{ data: 'tipo_operacion'},{ data: 'sucursal' },{ data: 'nombre' },
				{ data: 'monto' },
			],
			columnDefs:[
				{ title: 'Nro.Op.', targets: 0 },{ title: 'Tipo Op.', targets: 1 },{ title: 'Sucursal', targets: 2 },{ title: 'Productor', targets: 3 },
				{ title: 'Monto', targets: 4 },
			]/*, dom: botones,
			buttons: {
				dom: { container: { tag: 'div', className: 'flexcontent' }, buttonLiner: { tag: null } },
				buttons: [
					{ extend: 'copy', className: 'rounded-pill' },
					{ extend: 'excel', className: 'rounded-pill' },
					{ extend: 'pdf', className: 'rounded-pill' },
					{ extend: 'print', className: 'rounded-pill' }
				]
			}*/
		});
	}else if(segmento2 == 'reporte6'){
		tabla3 = $('#tablaReporte3').DataTable({
			ajax:{
				url: base_url + 'proveedores/tblreporte1',
				type: 'POST',
				data: function (d) {
					d.sucursal = $('.sucursal').val();
					d.productor = $('.productor').val();
					d.segmento = $('#segmento').val();
				}
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']], language: lngDataTable,order: [],
			columns:[
				{ data: 'nro_op', render: function(data){ return ceros( data, 6 ); } },{ data: 'tipo_operacion'},{ data: 'sucursal' },{ data: 'nombre' },
				{ data: 'monto' },{ data: 'tasa' },{ data: 'fecha' }
			],
			columnDefs:[
				{ title: 'Nro.Op.', targets: 0 },{ title: 'Tipo Op.', targets: 1 },{ title: 'Sucursal', targets: 2 },{ title: 'Productor', targets: 3 },
				{ title: 'Monto', targets: 4 },{ title: 'Tasa', targets: 5 },{ title: 'Fecha Movimiento', targets: 6 },
			]
		});
	}
	
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
			{ data: 0 },{ data: 1 },{ data: 2, visible: false },{ data: 3, visible: false },{ data: 4, visible: false }
		],
		dom: '<"row"<"mx-auto"l><"mx-auto"f>>rtp',
		colReorder: { order: [ 4, 3, 2, 1, 0 ] }, language: lngDataTable,
	});
});

$('#buscar').bind('click',function(e){
	let prod = $('#productor').val();
	$('#productor').val('');
	$('#tablaProveedores_processing').css('opacity',0);
	$('input[type="search"]').val(prod); tablaProv.search(prod).draw();
});
$('#tablaProveedores').on('dblclick','tr',function(){
	let data = tablaProv.row( this ).data();
	$('#productor').val(data[1]);
	$('#modalProveedores').modal('hide');
});
$('#generar').bind('click',function(e){
	let btn = $(this), tabla =null;
	if(segmento2 === 'reporte1' || segmento2 ==='reporte2' || segmento2 ==='reporte3') tabla = tabla1;
	if(segmento2 === 'reporte4' || segmento2 ==='reporte5') tabla = tabla2;
	if(segmento2 === 'reporte6') tabla = tabla3;
	
	btn.html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
	btn.addClass('disabled');
	
	tabla.ajax.reload(function(){
		btn.html('Generar Reporte');
		btn.removeClass('disabled');
	});
});
$('.exportar').bind('click', function(){
	let data = {}, url = '';
	
	if(segmento2 === 'reporte1' || segmento2 === 'reporte2' || segmento2 === 'reporte3')
		url = 's='+$('#sucursal').val()+'&a='+$('#anio').val()+'&art='+$('#articulo').val()+'&prod='+$('#productor').val()+'&rep='+$('#reportename').val();
	if(segmento2 === 'reporte4' || segmento2 === 'reporte5' || segmento2 === 'reporte6')
		url = 's='+$('#sucursal').val()+'&prod='+$('#productor').val()+'&rep='+$('#reportename').val();

	if(this.id === 'pdf'){
		$(this).attr('href', base_url + 'proveedores/reportes/pdf?' + url);
	}else if(this.id === 'excel'){
		$(this).attr('href', base_url + 'proveedores/reportes/excel?' + url);
	}
	//$(this).attr('target','_blank');
	/*
	$.ajax({
		data: { data : JSON.stringify(data) },
		url: base_url + 'proveedores/reportes/pdf',
		method: 'POST',
		dataType: 'JSON',
		beforeSend: function (){ },
		success: function (data){
			console.log(data);
		}
	});*/
});