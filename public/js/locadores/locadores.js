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
				{ data: 'archivo_base' },{ data: 'archivo_anexos' },{ data: 'fecha_registro' },
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

$('#customfile').bind('change', function(){
	let file = this.files[0];
	$('.tdr').html(file.name);
});
$('#customfile1').bind('change', function(){
	let file = this.files[0];
	$('.anexo').html(file.name);
});