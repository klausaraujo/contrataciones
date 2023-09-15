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
						/*let hrefPer = 'href="'+base_url+'usuarios/permisos?id='+data.idusuario+'"';
						let hrefReset = 'href="'+base_url+'usuarios/reset?id='+data.idusuario+'&doc='+data.numero_documento+'&stat='+data.activo+'"';
						let hrefActiva = 'href="'+base_url+'usuarios/habilitar?id='+data.idusuario+'"';*/
						let btnAccion = 
						/* Boton de edicion */
							'<div class="btn-group"><a title="Editar Convocatoria" '+((data.activo === '1' && btnEdit)? hrefEdit:'')+' class="bg-warning btnTable '+
							((data.activo === '0' || !btnEdit)?'disabled':'')+'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'+
						/* Boton de permisos */
						//'<a title="Permisos" '+((data.activo === '1' && btnPermisos)? hrefPer:'')+' class="bg-secondary btnTable '+
						//	((data.activo === '0' || !btnPermisos)?'disabled':'')+' permisos" data-target="#modalPermisos" data-toggle="modal">'+
						//	'<i class="fa fa-cogs" aria-hidden="true"></i></a>'+
						/* Boton de Reset Clave */
						//'<a title="Resetear Clave" '+((data.activo === '1' && btnClave)? hrefReset:'')+' class="bg-info btnTable '+
						//	((data.activo === '0' || !btnClave)?'disabled':'')+' resetclave"><i class="fa fa-key" aria-hidden="true"></i></a>'+
						/* Boton de activacion */
						//'<a title="'+(data.activo === '0'?'Habilitar Usuario':'Deshabilitar Usuario')+'" '+((data.activo === '1' && btnActiva)? hrefActiva:'')+
						//	' class="bg-light btnTable '+(data.activo === '1'? 'btnDesactivar':'btnActivar')+' '+(!btnActiva?'disabled':'')+' activar" >'+
						//	'<i class="fa '+(data.activo === '1'? 'fa-unlock':'fa-lock')+'" aria-hidden="true"></i></a></div>';
							'</div>';
						return btnAccion;
					}
				},
				{ data: 'idconvocatoria' },{ data: 'dependencia' },{ data: 'denominacion' },{ data: 'estadodesc' },{ data: 'fecha_inicio' },{ data: 'fecha_fin' },
				{
					data: 'archivo_base',
					render: function(data){
						let href = 'href="'+base_url+'locadores/descargar?file='+data+'"';
						let ext = $(data.split('.')).get(-1);
						let img = '<div class="row col-12"><a title="Descargar" '+href+' class="bg-danger btnTable mx-auto"><i class="fa fa-file-pdf-o"'+
							'aria-hidden="true" style="font-size:0.9rem"></i></a></div>'
						if(ext === 'doc' || ext === 'docx'){
							img = '<div class="row col-12"><a title="Descargar" '+href+' class="bg-primary btnTable mx-auto"><i class="fa fa-file-word"'+
								'aria-hidden="true" style="font-size:0.9rem;padding:0;margin:0"></i></a></div>';
						}
						return img;
					}
				},
				{
					data: 'archivo_anexos',
					render: function(data){
						let href = 'href="'+base_url+'locadores/descargar?file='+data+'"';
						let ext = $(data.split('.')).get(-1);
						let img = '<div class="row col-12"><a title="Descargar" '+href+' class="bg-danger btnTable mx-auto"><i class="fa fa-file-pdf-o"'+
							'aria-hidden="true" style="font-size:0.9rem"></i></a></div>'
						if(ext === 'doc' || ext === 'docx'){
							img = '<div class="row col-12"><a title="Descargar" '+href+' class="bg-primary btnTable mx-auto"><i class="fa fa-file-word"'+
								'aria-hidden="true" style="font-size:0.9rem;padding:0;margin:0"></i></a></div>';
						}
						return img;
					}
				},{ data: 'fecha_registro' },
				/*{
					data: 'activo',
					render: function(data){
						let var_status = '';
						switch(data){
							case '1': var_status = '<span class="text-success">Activo</span>'; break;
							case '0': var_status = '<span class="text-danger">Inactivo</span>'; break;
						}
						return var_status;
					}
				},*/
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