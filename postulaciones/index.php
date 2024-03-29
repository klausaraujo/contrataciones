<?php
	include_once(__DIR__.'/php/Funciones.php');
	date_default_timezone_set('America/Lima');
	session_start();
	
	$con = new Funciones();
	$dep = $con->dependencias();
?>
<!doctype html>
<html lang="es">
	<head>
		<title>Postulaciones</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/typography.css">
		<link rel="stylesheet" href="datatable/dataTables.bootstrap4.min.css">
		<style>
			body{ margin: 5rem 2rem }
			.wrapper{ background-color: #fff; }
			.table thead th{
				color: #fff;
				background-color: #5a5c69;
				border-color: #6c6e7e;
				font-size: 0.7rem;
			}
			table td{ font-size: 0.7rem; }
			div.dataTables_wrapper div.dataTables_length .form-control-sm{
				line-height: 1.5;
				background: #fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right 0.75rem center/8px 10px;
			}
			div.dataTables_wrapper .far, div.dataTables_wrapper .fa, div.dataTables_wrapper .fas {
				line-height: 2;
			}
			.page-link{ margin-left: 0; border-color: #428bca; padding: 0.3rem 0.75rem; line-height: 1; }
			.page-item.active .page-link { background-color: #428bca; }
			.paginate_button.page-item.previous, .paginate_button.page-item.next{ display: none }
			.btn-postular{ background-color: #428bca; border-color: #066ed7; color: #fff; border-color: #428bca; }
			.btnTable{ -webkit-transition-duration: 0.4s;transition-duration: 0.4s;margin-right:5px;padding:1.5px;border-radius:5px;box-shadow:3px 3px 2px 0 rgb(1 0 2 / 50%); color: #fff; }
			.btnTable:hover{ color: #000 }
		</style>
	</head>
	<body class="wrapper">
		<div class="container-fluid">
			<div class="row justify-content-center">
				<?
				if($_SESSION['claseMsg']){?><div class="alert <?=$_SESSION['claseMsg']?> py-0 px-5 msg fade show" role="alert">
					<div class="iq-alert-text"><?=$_SESSION['mensaje']?></div>
					</div><?session_destroy();}?>
			</div>
			<div class="row my-4">
				<label class="ml-3">Seleccionar Dependencia:</label>
				<select class="form-control form-control-sm col-md-3 ml-3" id="dependencia" name="dependencia">
					<option value="">--Seleccione--</option>
				<?
					foreach($dep as $row):?>
					<option value="<?=$row['iddependencia']?>"><?=$row['descripcion']?></option>
				<?	endforeach; ?>
				</select>
			</div>
			<div class="row">
				<div class="col-12 mx-auto" style="overflow:auto">
					<table id="tablaPostulacion" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
				</div>
			</div>
		</div>
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="js/jquery.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="datatable/jquery.dataTables.min.js"></script>
		<script src="datatable/dataTables.bootstrap4.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/javascript.js"></script>
		<script>
			const base = '<?=$_SERVER['HOSTNAME'].'/contrataciones/'?>';
			const language = {
				"processing": "Procesando...",
				"lengthMenu": "Mostrar _MENU_ registros",
				"zeroRecords": "No se encontraron resultados",
				"emptyTable": "Ningún dato disponible en esta tabla",
				"infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
				"infoFiltered": "(filtrado de un total de _MAX_ registros)",
				"search": "Buscar:",
				"infoThousands": ",",
				"loadingRecords": "Cargando...",
			};
		</script>
	</body>
</html>