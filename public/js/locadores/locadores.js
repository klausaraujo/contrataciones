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
						let hrefEdit = 'href="'+base_url+'locadores/editar?id='+data.idconvocatoria+'"';
						let hrefCan = 'href="'+base_url+'locadores/cancelar?id='+data.idconvocatoria+'"';
						let hrefEval = 'href="'+base_url+'locadores/evaluar?id='+data.idconvocatoria+'"';
						let hrefPub = 'href="'+base_url+'locadores/publicar?id='+data.idconvocatoria+'"';
						let btnAccion =
							'<div class="btn-group">'+
								'<a title="Editar Convocatoria" '+((data.activo === '1' && btnEdit)? hrefEdit:'')+' class="bg-info btnTable">'+
									'<img src="'+base_url+'public/images/edit_ico.png" width="22"></a>'+
								'<a title="Cancelar Convocatoria" '+((data.activo === '1' && btnCan)? hrefCan:'')+' class="bg-danger btnTable">'+
									'<img src="'+base_url+'public/images/cancel_ico.png" width="22"></a>'+
								'<a title="Evaluar Postulantes" '+((data.activo === '1' && btnEval)? hrefEval:'')+' class="bg-warning btnTable px-1">'+
									'<img src="'+base_url+'public/images/evaluar_ico.png" width="15"></a>'+
								'<a title="Publicar Resultados" '+((data.activo === '1' && btnPub)? hrefPub:'')+' class="bg-light btnTable border '+
									'border-secondary"><img src="'+base_url+'public/images/result_ico.png" width="18"></a>'+
							'</div>';
						return btnAccion;
					}
				},
				{ data: 'idconvocatoria' },{ data: 'dependencia' },{ data: 'denominacion' },{ data: 'estadodesc' },
				{ data: 'fecha_inicio', render: function(data,type,row,meta){ return data+'<br><span style="color:#0000FF;font-weight:bold">'+row.hinicio+'</span>'; } },
				{ data: 'fecha_fin', render: function(data,type,row,meta){ return data+'<br><span style="color:#0000FF;font-weight:bold">'+row.hfin+'</span>'; } },
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