let tablaLocadores = null, tablaEval = null;

$(document).ready(function (){
	if(segmento2 == ''){
		tablaLocadores = $('#tablaLocadores').DataTable({
			ajax: {
				url: base_url + 'locadores/lista',
			},
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']], language: lngDataTable,
			columns:[
				{
					data: null,
					orderable: false,
					render: function(data){
						let hrefEdit = (data.activo === '1' && btnEdit && data.idestado==='1')?'href="'+base_url+'locadores/editar?id='+data.idconvocatoria+'"':'';
						let hrefCan = (data.activo === '1' && btnCan && data.idestado==='1')?'href="'+base_url+'locadores/cancelar?id='+data.idconvocatoria+'"':'';
						let hrefEval = (data.activo === '1' && btnEval && parseInt(data.idestado) < 3 && 
							data.calificado === '0' && data.idestado === '2')?'href="'+base_url+'locadores/evaluar?id='+data.idconvocatoria+'"':'';
						let hrefPub = (data.activo === '1' && btnPub && parseInt(data.idestado) < 3 && parseInt(data.calificado))?
								'href="'+base_url+'locadores/ver?id='+data.idconvocatoria+'"':'';
						let btnAccion =
							'<div class="btn-group">'+
								'<a '+(hrefEdit?'title="Editar Convocatoria" '+hrefEdit:'')+' class="bg-info btnTable">'+
									'<img src="'+base_url+'public/images/edit_ico.png" width="22"></a>'+
								'<a '+(hrefCan?'title="Cancelar Convocatoria" '+hrefCan:'')+' class="bg-danger btnTable '+(hrefCan?'cancelar':'')+'">'+
									'<img src="'+base_url+'public/images/cancel_ico.png" width="22"></a>'+
								'<a '+(hrefEval?'title="Evaluar Postulantes" '+hrefEval:'')+' class="bg-warning btnTable px-1">'+
									'<img src="'+base_url+'public/images/evaluar_ico.png" width="15"></a>'+
								'<a '+(hrefPub?'title="Publicar Resultados" '+hrefPub:'')+' class="bg-light btnTable border border-secondary" target="_blank">'+
									'<img src="'+base_url+'public/images/result_ico.png" width="18"></a>'+
							'</div>';
						return btnAccion;
					}
				},
				{ data: 'idconvocatoria' },{ data: 'dependencia' },{ data: 'denominacion' },{ data: 'estadodesc' },
				{ data: 'fi', render: function(data,type,row,meta){ return data+'<br><span style="color:#0000FF;font-weight:bold">'+row.hinicio+'</span>'; } },
				{ data: 'ff', render: function(data,type,row,meta){ return data+'<br><span style="color:#0000FF;font-weight:bold">'+row.hfin+'</span>'; } },
				{
					data: 'archivo_base',
					render: function(data){
						let href = 'href="'+base_url+'locadores/descargar?file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/pdf_ico.png" width="27"></a>'
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/word_ico.png" width="27"></a>';
						}
						return img;
					}
				},
				{
					data: 'archivo_anexos',
					render: function(data){
						let href = 'href="'+base_url+'locadores/descargar?file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/pdf_ico.png" width="27"></a>'
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/word_ico.png" width="27"></a>';
						}
						return img;
					}
				},{ data: 'fecha_registro' },
			],
			columnDefs:headers, order: [],
		});
	}else if(segmento2 === 'evaluar'){
		tablaEval = $('#tablaEval').DataTable({
			data: postulantes,
			bAutoWidth:false, bDestroy:true, responsive:true, select:false, lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todas']], language: lngDataTable,
			columns:[
				{ data: 'idpostulacion' },{ data: 'numero_documento' },{ data: 'numero_ruc' },{ data: 'nombre' },{ data: 'profesion' },{ data: 'nivel' },
				{
					data: 'anexo_01',
					render: function(data){
						let href = data == ''?'':'href="'+base_url+'locadores/descargarp?file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '';
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/word_ico.png" width="27"></a>';
						}else if(ext === 'pdf'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/pdf_ico.png" width="27"></a>';
						}
						return img;
					}
				},
				{
					data: 'anexo_02',
					render: function(data){
						let href = data == ''?'':'href="'+base_url+'locadores/descargarp?file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '';
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/word_ico.png" width="27"></a>';
						}else if(ext === 'pdf'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/pdf_ico.png" width="27"></a>';
						}
						return img;
					}
				},
				{
					data: 'anexo_03',
					render: function(data){
						let href = data == ''?'':'href="'+base_url+'locadores/descargarp?file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '';
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/word_ico.png" width="27"></a>';
						}else if(ext === 'pdf'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/pdf_ico.png" width="27"></a>';
						}
						return img;
					}
				},
				{
					data: 'anexo_04',
					render: function(data){
						let href = data == ''?'':'href="'+base_url+'locadores/descargarp?file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '';
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/word_ico.png" width="27"></a>';
						}else if(ext === 'pdf'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/pdf_ico.png" width="27"></a>';
						}
						return img;
					}
				},
				{
					data: 'anexo_05',
					render: function(data){
						let href = data == ''?'':'href="'+base_url+'locadores/descargarp?file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '';
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/word_ico.png" width="27"></a>';
						}else if(ext === 'pdf'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/pdf_ico.png" width="27"></a>';
						}
						return img;
					}
				},
				{
					data: 'anexo_06',
					render: function(data){
						let href = data == ''?'':'href="'+base_url+'locadores/descargarp?file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '';
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/word_ico.png" width="27"></a>';
						}else if(ext === 'pdf'){
							img = '<a title="Descargar" '+href+'><img src="'+base_url+'public/images/pdf_ico.png" width="27"></a>';
						}
						return img;
					}
				},
				{
					render: function(data,type,full,meta){
						return '<div class="row"><input type="text" class="form-control form-control-sm puntaje moneda bg-light mx-auto"'
								+' style="width:4em;font-size:0.8rem" value="'+full.puntaje+'" /></div>';
					},
					orderable: false,
				},
				{
					render: function(data,type,full,meta){
						return '<div class="row"><input type="checkbox" class="mx-auto" '+ (full.ganador === '1' ? ' checked' : '') +' /></div>';
					},
					orderable: false,
				},
			],
			columnDefs:[
				{targets: 0,visible: false},{title:'DNI/CE',targets: 1},{title:'RUC',targets: 2},{title:'Postulante',targets: 3},{title:'Profesi&oacute;n',targets: 4},
				{title:'Nivel',targets: 5},{title:'Anexo 1',targets: 6},{title:'Anexo 2',targets: 7},{title:'Anexo 3',targets: 8},{title:'Anexo 4',targets: 9},
				{title:'Anexo 5',targets: 10},{title:'Anexo 6',targets: 11},{title:'Puntaje',targets: 12},{title:'Ganador',targets: 13},
			], order: [],
		});
	}
});
$('.atach').bind('change', function(){
	let file = this.files[0], arr = (this.files[0]!==undefined?file.name.split('.'):[]), ext = $(arr).get(-1);
	
	if(ext === 'pdf' || ext === 'docx' || ext === 'doc'){
		if(this.id === 'customfile'){
			$('.tdr').html(file.name);
			$('.sptdr').html('<span class="text-primary">Archivo Correcto</span>');
			$('#file1').val(file.name);
		}else if(this.id === 'customfile1'){
			$('.anexo').html(file.name);
			$('.spanexo').html('<span class="text-primary">Archivo Correcto</span>');
			$('#file2').val(file.name);
		}
	}else{
		$(file).val('');
		if(this.id === 'customfile'){
			$('.sptdr').html('<span class="text-danger">Archivo inv&aacute;lido</span>');
			$('#file1').val(''), $('.tdr').html('');
		}else if(this.id === 'customfile1'){
			$('.spanexo').html('<span class="text-danger">Archivo inv&aacute;lido</span>');
			$('#file2').val(''), $('.anexo').html('');
		}
	}
});
$('.form').validate({
	errorClass: 'form_error',
	validClass: 'success',
	rules: { 
		finicio: { required: function () { if ($('#finicio').css('display') != 'none') return true; else return false; } },
	},
	messages: {
		finicio: { required: '' },
	},
	errorPlacement: function(error, element){},
	submitHandler: function (form, event){
		if($('#file1').val() !== '' && $('#file2').val() !== ''){
			let boton = $('#btnEnviar');
			$(boton).html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
			$(boton).addClass('disabled'); $('.btn-cancelar').addClass('disabled');
			return true;
		}else{
			event.preventDefault();
			if($('#file1').val() === '') $('.sptdr').html('<span class="text-danger">Debe cargar un archivo</span>');
			if($('#file2').val() === '') $('.spanexo').html('<span class="text-danger">Debe cargar un archivo</span>');
		}
	}
});

function formatoFecha(fecha, formato) {
	let m = (fecha.getMonth()+1).toString();
	m = m.length < 2? '0'+m : m;
    const map = {
        Y: fecha.getFullYear(),
		m: m,
		d: fecha.getDate(),
        h: fecha.getHours()+':'+fecha.getMinutes(),
    }
    return formato.replace(/Y|m|d|h/gi, matched => map[matched])
}

$('.blur').on('blur',function(){
	let id = $(this).attr('id');
	if(!isNaN(this)){
		alert('Formato de fecha errado');
		let fecha = formatoFecha(new Date(),'Y-m-d h'); $('#finicio').val(fecha), $('#ffin').val(fecha);
	}else{
		let f2 = new Date($('#ffin').val()), f1 = new Date($('#finicio').val());
		if((f2.getTime()-f1.getTime()) < 0){
			alert('La fecha/hora inicial no puede ser mayor que la fecha/hora final');
			let fecha = formatoFecha(new Date(),'Y-m-d h'); $('#finicio').val(fecha), $('#ffin').val(fecha);
		}
	}
});

$('#tablaLocadores').bind('click','a',function(e){
	let el = e.target, a = $(el).closest('a'), mensaje = '';
	let data = tablaLocadores.row(a).child.isShown()? tablaLocadores.row(a).data() : tablaLocadores.row($(el).parents('tr')).data();
	if($(a).hasClass('cancelar')){
		e.preventDefault();
		mensaje = 'Seguro que desea Cancelar la convocatoria?';
		let confirmacion = confirm(mensaje);
		if(confirmacion){
			$.ajax({
				data: {},
				url: $(a).attr('href'),
				method: 'GET',
				dataType: 'JSON',
				error: function(xhr){},
				beforeSend: function(){},
				success: function(data){
					if(parseInt(data.status) === 200){
						tablaLocadores.ajax.reload();
					}
					$('.resp').html(data.msg);
					setTimeout(function () { $('.resp').html(''); }, 2500);
				}
			});
		}
	}
});

$('#tablaEval').bind('input',function(e){
	let el = e.target;
	if($(el).attr('type') === 'text'){
		jQuery(el).val(jQuery(el).val().replace(/([^0-9\.]+)/g, ''));
		jQuery(el).val(jQuery(el).val().replace(/^[\.]/,''));
		jQuery(el).val(jQuery(el).val().replace(/[\.][\.]/g,''));
		jQuery(el).val(jQuery(el).val().replace(/\.(\d)(\d)(\d)/g,'.$1$2'));
		jQuery(el).val(jQuery(el).val().replace(/\.(\d{1,2})\./g,'.$1'));
	}
});
$('#tablaEval').bind('click',function(e){
	let el = e.target;
	if($(el).attr('type') === 'text') $(el).select();
});
$('#evaluar').bind('click',function(e){
	//let arr = tablaEval.rows().data().toArray();
	let data = [], row = null, dni = '', valor = '', ganador = '', id = '', idpost = '';
	
	$('#tablaEval tbody tr').each(function(i, e){
		dni = $(e).children(':first').html();
		$('#tablaEval tbody input').each(function(ind, el){
			row = tablaEval.row($(el).parents('tr')).data();
			if(dni === row.numero_documento){
				id = row.idpostulacion, idpost = row.idconvocatoria;
				if(el.type === 'text'){
					valor = el.value;
				}else if(el.type === 'checkbox' && $(el).prop('checked')){
					ganador = 1;
				}if(el.type === 'checkbox' && !$(el).prop('checked')){
					ganador = 0;
				}
			}
		});
		data.push({
			'idconvocatoria' : idpost,
			'idpostulacion' : id,
			'puntaje' : valor,
			'ganador' : ganador
		});
	});
	$(location).attr('href',base_url+segmento+'/evaluado?json='+JSON.stringify(data));
	//console.log(JSON.stringify(data));
});