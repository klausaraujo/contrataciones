let tabla = null;

$(document).ready(function (){
	if($('#tablaPostulacion').length > 0){
	tabla = $('#tablaPostulacion').DataTable({
		ajax: {
				url: 'php/Funciones.php',
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
						let href = 'href="php/formulario?id='+data.idconvocatoria+'"';
						let btnAccion = '<div class="row"><a class="btn btn-postular mx-auto" '+href+'>Postular</a></div>';
						return btnAccion;
					}
				},
				{ data: 'idconvocatoria' },{ data: 'descripcion' },{ data: 'denominacion' },
				{
					data: 'estado',
					/*render: function(data){
						return '<div style="margin:0;background-color:#00ff00;">'+data+'</div>';
					}*/
				},
				{ data: 'fecha_inicio', render: function(data,type,row,meta){ return data+'<br><span style="color:#0000FF;font-weight:bold">'+row.hini+'</span>'; } },
				{ data: 'fecha_fin', render: function(data,type,row,meta){ return data+'<br><span style="color:#0000FF;font-weight:bold">'+row.hfin+'</span>'; } },
				{
					data: 'archivo_base',
					render: function(data){
						let href = 'href="php/Funciones?act=descargar&file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '<a title="Descargar" '+href+'><img src="img/pdf_ico.png" width="27"></a>'
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" '+href+'><img src="img/word_ico.png" width="27"></a>';
						}
						return img;
					}
				},
				{
					data: 'archivo_anexos',
					render: function(data){
						let href = 'href="php/Funciones?act=descargar&file='+data+'"', ext = $(data.split('.')).get(-1);
						let img = '<a title="Descargar" '+href+'><img src="img/pdf_ico.png" width="27"></a>'
						if(ext === 'doc' || ext === 'docx'){
							img = '<a title="Descargar" '+href+'><img src="img/word_ico.png" width="27"></a>';
						}
						return img;
					}
				},{ data: null, render: function(){ return ''; } },
			],
			columnDefs:[
				{ title:'ACCIONES',targets:0,orderable: false },{ title:'ID',targets:1 },{ title:'DEPENDENCIA',targets:2 },{ title:'DENOMINACION',targets:3 },
				{
					title:'ESTADO',targets:4,
					createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
						if(cellData === 'EN PROCESO') $(cell).attr('style', 'background-color:#008000;color:#fff');
						else if(cellData === 'FINALIZADO') $(cell).attr('style', 'background-color:#C40C0B;color:#fff');
						else if(cellData === 'CANCELADO') $(cell).attr('style', 'background-color:#6b6d75;color:#fff');
						else if(cellData === 'DESIERTO') $(cell).attr('style', 'background-color:#c77b0e;color:#fff');
					},
				},
				{ title:'INICIO',targets:5 },{ title:'FIN',targets:6 },{ title:'BASE',targets:7 },{ title:'ANEXOS',targets:8 },{ title:'RESULTADOS',targets:9 }
			],dom: '<"row"<"col-2 mr-auto"f>>tp',
	});
	}
});

$('#dependencia').bind('change',function(){
	tabla.ajax.reload();
});