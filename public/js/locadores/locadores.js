let tablaLocadores = null;

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
						let hrefEval = (data.activo === '1' && btnEval && parseInt(data.idestado) < 3)?'href="'+base_url+'locadores/evaluar?id='+data.idconvocatoria+'"':'';
						let hrefPub = (data.activo === '1' && btnPub && parseInt(data.idestado) < 3)?'href="'+base_url+'locadores/publicar?id='+data.idconvocatoria+'"':'';
						let btnAccion =
							'<div class="btn-group">'+
								'<a '+(hrefEdit?'title="Editar Convocatoria" '+hrefEdit:'')+' class="bg-info btnTable">'+
									'<img src="'+base_url+'public/images/edit_ico.png" width="22"></a>'+
								'<a '+(hrefCan?'title="Cancelar Convocatoria" '+hrefCan:'')+' class="bg-danger btnTable cancelar">'+
									'<img src="'+base_url+'public/images/cancel_ico.png" width="22"></a>'+
								'<a '+(hrefEval?'title="Evaluar Postulantes" '+hrefEval:'')+' class="bg-warning btnTable px-1">'+
									'<img src="'+base_url+'public/images/evaluar_ico.png" width="15"></a>'+
								'<a '+(hrefPub?'title="Publicar Resultados" '+hrefPub:'')+' class="bg-light btnTable border border-secondary">'+
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
		//console.log((new Date($('#ffin').val()).getTime())-(new Date($('#finicio').val()).getTime()));
		let f2 = new Date($('#ffin').val()), f1 = new Date($('#finicio').val());
		if((f2.getTime()-f1.getTime()) < 0){
			alert('La fecha/hora inicial no puede ser mayor que la fecha/hora final');
			let fecha = formatoFecha(new Date(),'Y-m-d h'); $('#finicio').val(fecha), $('#ffin').val(fecha);
			//$('#finicio').val($('#ffin').val());
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