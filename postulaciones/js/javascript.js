let tabla = null;
let ojo = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">'+
			'<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>'+
		  '</svg>';

$('.num').bind('input',function(e){
	jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
});
$('.mayusc').bind('input',function(e){
	jQuery(this).val(jQuery(this).val().toUpperCase());
});

$(document).ready(function (){
	setTimeout(function () { $('.msg').hide('slow'); }, 3000);
	$('html, body').animate({ scrollTop: 0 }, 'fast');
	if($('#tablaPostulacion').length > 0){
		tabla = $('#tablaPostulacion').DataTable({
			ajax: {
					url: base+'postulaciones/php/Funciones',
					type: 'POST',
					data: function(d){ d.data = 'listar'; d.dep = $('#dependencia').val() }
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[20, 30, 50, 100, -1], [20, 30, 50, 100, 'Todas']],
			language: language,
			columns:[
				{
					data: null,
					orderable: false,
					render: function(data){
						let href = 'href="php/Funciones?v='+data.idconvocatoria+'"';
						let btnAccion = '<div class="row"><a class="btn btnTable btn-postular mx-auto '+(data.idestado === '1'?'':'disabled')+
										'" '+(data.idestado === '1'?href:'')+'>Postular</a></div>';
						return btnAccion;
					}
				},
				{ data: 'descripcion' },{ data: 'denominacion' },
				{ data: 'estado', render: function(data){ return '<div class="row"><span class="mx-auto">'+data+'</span></div>'; } },
				{ data: 'fecha_inicio', render: function(data,type,row,meta){ return data+'<br><span style="color:#0000FF;font-weight:bold">'+row.hini+'</span>'; } },
				{ data: 'fecha_fin', render: function(data,type,row,meta){ return data+'<br><span style="color:#0000FF;font-weight:bold">'+row.hfin+'</span>'; } },
				{
					data: 'archivo_base',
					render: function(data){
						let href = 'href="'+base+'postulaciones/php/Funciones?act=descargar&file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '<a title="Descargar" class="mx-auto" '+href+'><img src="'+base+'public/images/pdf_ico.png" width="27"></a>'
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" class="mx-auto" '+href+'><img src="'+base+'public/images/word_ico.png" width="27"></a>';
						}
						return '<div class="row">'+img+'</div>';
					}
				},
				{
					data: 'archivo_anexos',
					render: function(data){
						let href = 'href="'+base+'postulaciones/php/Funciones?act=descargar&file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '<a title="Descargar" class="mx-auto" '+href+'><img src="'+base+'public/images/pdf_ico.png" width="27"></a>'
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" class="mx-auto" '+href+'><img src="'+base+'public/images/word_ico.png" width="27"></a>';
						}
						return '<div class="row">'+img+'</div>';
					}
				},
				{
					data: null,
					render: function(data){
						console.log(data.idconvocatoria);
						let hRef = (data.calificado === '1'? 'href="'+base+'postulaciones/php/Funciones?act=ver&res='+data.idconvocatoria+'"' : '');
						return '<div class="row"><a title="Ver Resultados" class="btn btnTable btn-success mx-auto '+
							(data.calificado === '0'?'disabled':'')+' px-1" '+hRef+' target="_blank">'+ojo+'</a></div>';
					}
				},
			],
			columnDefs:[
				{ title:'ACCIONES', targets:0, orderable: false },{ title:'DEPENDENCIA', targets: 1 },{ title:'DENOMINACION', targets: 2 },
				{
					title:'ESTADO', targets: 3,
					createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
						if(cellData === 'EN PROCESO') $(cell).attr('style', 'background-color:#008000;color:#fff');
						else if(cellData === 'FINALIZADO') $(cell).attr('style', 'background-color:#C40C0B;color:#fff');
						else if(cellData === 'CANCELADO') $(cell).attr('style', 'background-color:#6b6d75;color:#fff');
						else if(cellData === 'DESIERTO') $(cell).attr('style', 'background-color:#c77b0e;color:#fff');
					},
				},
				{ title:'FECHA INICIO',targets: 4 },{ title:'FECHA FIN', targets: 5 },{ title:'BASE', targets: 6 },{ title:'ANEXOS', targets: 7 },
				{ title:'RESULTADOS', targets: 8 },
			],dom: '<"row"<"col-2 mr-auto"f>>tp',
		});
	}
});

$('#dependencia').bind('change',function(){
	tabla.ajax.reload();
});
$('#tipodoc').bind('change',function(){
	if(this.value === '1') $('.doc').prop('maxlength',8);
	else if(this.value === '2') $('.doc').prop('maxlength',9);
	$.each($('.form-control'),function(i,e){
		if(this.type !== 'select-one')
		this.value = '';
	});
	$('.doc').focus();
});
$('.btn_curl').bind('click',function(e){
	let doc = $('#doc').val(), tipo = '';
	$.each($('.form-control'),function(i,e){
		if(this.type !== 'select-one')
		this.value = '';
	});
	$('#doc').val(doc);
	if($('#tipodoc').val() === '1') tipo = '01';
	else if($('#tipodoc').val() === '2') tipo = '03';
	
	$.ajax({
		data: { ctipo: tipo, doc: doc },
		url: 'Funciones',
		method: 'POST',
		dataType: 'json',
		error: function (xhr) { $('.btn_curl').removeAttr('disabled'); $('.btn_curl').html('<i class="fa fa-search" aria-hidden="true"></i>'); },
		beforeSend: function () { $('.btn_curl').html('<i class="fa fa-spinner fa-pulse"></i>'); $('.btn_curl').attr('disabled', 'disabled'); },
		success: function (data){
			$('.btn_curl').removeAttr('disabled'); $('.btn_curl').html('<i class="fa fa-search" aria-hidden="true"></i>');
			if(data.status === 200){
				let resp = JSON.parse(data.data);
				$('#ruc').val('00000000000');
				$('#nombres').val(resp.data.attributes.apellido_paterno+' '+resp.data.attributes.apellido_materno+' '+resp.data.attributes.nombres);
				$('#direccion').val(resp.data.attributes.domicilio_direccion);
			}else{
				alert('Datos no encontrados');
			}
		}
	});
});
$('.dep').bind('change', function(){
	let cod = this.value, html = '<option value="">-- Seleccione --</option>';
	$.ajax({
		data: { cod_dep: cod, dep: 'departamentos' },
		url: 'Funciones',
		method: 'POST',
		dataType: 'JSON',
		beforeSend: function () {
			$('.dis').html('<option>-- Seleccione --</option>'); $('.pro').html('<option> Cargando...</option>');
		},
		success: function (data){
			$.each(data, function (i, e){ html += '<option value="' + e.cod_pro + '">' + e.provincia + '</option>'; });
			$('.pro').html(html);
		}
	});
});
$('.pro').bind('change', function(){
	let cod = this.value, html = '<option value="">-- Seleccione --</option>';
	$.ajax({
		data: { cod_dep: $('.dep').val(), cod_pro: cod, dep: 'provincias' },
		url: 'Funciones',
		method: 'POST',
		dataType: 'JSON',
		beforeSend: function () {
			$('.dis').html('<option> Cargando...</option>');
		},
		success: function (data) {
			$.each(data, function (i, e){ html += '<option value="' + e.cod_dis + '">' + e.distrito + '</option>'; });
			$('.dis').html(html);
		}
	});
});
$('.dis').change(function(){
	let id = this.value, dpto = $('.dep').val(), prov = $('.pro').val();
	let ubigeo = dpto+prov+id;
	
	$.ajax({
		data: { ubigeo: ubigeo, dep: 'distritos' },
		url: 'Funciones',
		method: 'POST',
		dataType: 'JSON',
		beforeSend: function(){},
		success: function (data){
			var opt = {lat: parseFloat(data[0].latitud), lng: parseFloat(data[0].longitud), zoom: 16};
			//console.log(map.getZoom());
			//console.log(opt);
			map.setCenter(opt);
			//if($('.ajaxMap').css('display') == 'none' || $('.ajaxMap').css('opacity') == 0) $('.ajaxMap').show();
			$('.ajaxMap').removeClass('d-none');
			/*$.ajax({
				data: {lat: parseFloat(ubigeo[0].latitud), lng: parseFloat(ubigeo[0].longitud), zoom: 16},
				url: 'urlCurl',
				method: "POST",
				dataType: "json",
				beforeSend: function () {},
				success: function (data) {
					console.log(data);
				}
			});*/
		}
	});
});
$('.atach').bind('change', function(){
	let file = this.files[0], arr = (this.files[0]!==undefined?file.name.split('.'):[]), ext = $(arr).get(-1);
	
	if(ext === 'pdf' || ext === 'docx' || ext === 'doc'){
		if(this.id === 'anexo01'){
			$('.anexo01').html(file.name);
			$('.spanexo01').html('<span class="text-primary">Archivo Correcto</span>');
		}else if(this.id === 'anexo02'){
			$('.anexo02').html(file.name);
			$('.spanexo02').html('<span class="text-primary">Archivo Correcto</span>');
		}else if(this.id === 'anexo03'){
			$('.anexo03').html(file.name);
			$('.spanexo03').html('<span class="text-primary">Archivo Correcto</span>');
		}else if(this.id === 'anexo04'){
			$('.anexo04').html(file.name);
			$('.spanexo04').html('<span class="text-primary">Archivo Correcto</span>');
		}else if(this.id === 'anexo05'){
			$('.anexo05').html(file.name);
			$('.spanexo05').html('<span class="text-primary">Archivo Correcto</span>');
		}else if(this.id === 'anexo06'){
			$('.anexo06').html(file.name);
			$('.spanexo06').html('<span class="text-primary">Archivo Correcto</span>');
		}
	}else{
		$(file).val(null);
		if(this.id === 'anexo01'){
			$('.spanexo01').html('<span class="text-danger">Archivo inv&aacute;lido</span>'), $('.anexo01').html('');
		}else if(this.id === 'anexo02'){
			$('.spanexo02').html('<span class="text-danger">Archivo inv&aacute;lido</span>'), $('.anexo02').html('');
		}else if(this.id === 'anexo03'){
			$('.spanexo03').html('<span class="text-danger">Archivo inv&aacute;lido</span>'), $('.anexo03').html('');
		}else if(this.id === 'anexo04'){
			$('.spanexo04').html('<span class="text-danger">Archivo inv&aacute;lido</span>'), $('.anexo04').html('');
		}else if(this.id === 'anexo05'){
			$('.spanexo05').html('<span class="text-danger">Archivo inv&aacute;lido</span>'), $('.anexo05').html('');
		}else if(this.id === 'anexo06'){
			$('.spanexo06').html('<span class="text-danger">Archivo inv&aacute;lido</span>'), $('.anexo06').html('');
		}
	}
});