<?php
	session_start();
	if(!isset($_SESSION['convocatoria'])) header('location: ../');
	include_once(__DIR__.'/Funciones.php');
	date_default_timezone_set('America/Lima');
	
	$con = new Funciones();
	$prof = $con->profesiones();
	$nivel = $con->nivel();
	$dep = $con->departamentos();
	$tipo = $con->tipodoc();
	$con->close();
	$convocatoria = $_SESSION['convocatoria'];
	unset($_SESSION['convocatoria']);
	session_destroy();
?>
<!doctype html>
<html lang="es">
	<head>
		<title>Postulaciones</title>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="../css/typography.css">
		<link rel="stylesheet" href="<?=$_SERVER['HOSTNAME'].'/contrataciones/'?>public/css/fontawesome.css">
		<style>
			body{ margin: 2rem 1rem }
			//.wrapper{ background-color: #fff; }
			.btn-postular{ background-color: #428bca; border-color: #066ed7; color: #fff; border-color: #428bca; }
		</style>
		<script src="https://maps.googleapis.com/maps/api/js?key=<?='AIzaSyA85CP4w2NVLGUH5VQzjVJMcOWdmsj3-r0'?>&libraries=places&v=weekly" async ></script>
	</head>
	<body class="wrapper">
	<div class="container-fluid">	
		<div class="col-12 iq-card my-3">
			<div class="iq-card-header d-flex justify-content-between">
				<div class="iq-header-title"><h4>Postulacion</h4></div>
			</div>
			<div class="iq-card-body pt-0">
				<form method="post" enctype="multipart/form-data" id="form_postulante" action="Funciones">
					<input type="hidden" name="postular" value="postulaciones" /><input type="hidden" name="idconvocatoria" value="<?=$convocatoria?>" />
					<div class="form-row">
						<div class="col-12 my-1">
							<div class="row">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="tipodoc">Tipo de Documento:</label>
								<div class="col-md-6 col-lg-2">
									<div class="row">
										<select class="form-control form-control-sm tipodoc" name="tipodoc" id="tipodoc" required="">
										<?
												foreach($tipo as $row):	?>
													<option value="<?=$row['idtipodocumento'];?>" <?if($row['idtipodocumento']==='1') echo 'select';?>>
														<?=$row['tipo_documento'];?></option>
										<?		endforeach;	?>
										</select>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="doc">N&uacute;mero de Documento:</label>
								<div class="col-md-4 col-lg-3">
									<div class="row">
										<input type="text" class="form-control form-control-sm num doc" maxlength="8" minlength="8" name="doc" id="doc" autocomplete="off"
											placeholder="Nro. Documento" required="" />
									</div>
								</div>
								<!--<div class="col-md-2 col-lg-1 px-0 pl-md-3 pl-lg-4 align-self-center mt-0">
									<button type="button" class="btn btn-postular btn_curl px-1 pl-2 py-1"><i class="fa fa-search" aria-hidden="true"></i></button>
								</div>
								<!--<label class="form_error error_curl col-md-4 my-0"></label>-->
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="ruc">RUC:</label>
								<div class="col-md-4 col-lg-4">
									<div class="row">
										<input type="text" class="form-control form-control-sm num" name="ruc" id="ruc" placeholder="RUC" minlength="11" 
											maxlength="11"/>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="nombres">Raz&oacute;n Social:</label>
								<div class="col-md-6 col-lg-4">
									<div class="row">
										<input type="text" class="form-control form-control-sm mayusc" name="nombres" id="nombres" placeholder="Raz&oacute;n Social" required="" />
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="direccion">Domicilio:</label>
								<div class="col-md-6 col-lg-4">
									<div class="row">
										<input type="text" class="form-control form-control-sm mayusc" name="direccion" id="direccion" placeholder="Domicilio" required="" />
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="celular">Celular:</label>
								<div class="col-md-6 col-lg-4">
									<div class="row">
										<input type="text" class="form-control form-control-sm num" name="celular" id="celular" placeholder="Nro. Celular" />
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="email">Email:</label>
								<div class="col-md-6 col-lg-4">
									<div class="row">
										<input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Direcci&oacute;n de Correo" required="" />
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="dep">Departamento:</label>
								<div class="col-md-6 col-lg-3">
									<div class="row">
										<select class="form-control form-control-sm dep" name="dep" id="dep" required="" >
											<option value="">-- Seleccione --</option>
										<?
												foreach($dep as $row):	?>
													<option value="<?=$row['cod_dep'];?>"><?=$row['departamento'];?></option>
										<?		endforeach;	?>
										</select>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="pro">Provincia:</label>
								<div class="col-md-6 col-lg-3">
									<div class="row">
										<select class="form-control form-control-sm pro" name="pro" id="pro" required="" >
											<option value="">-- Seleccione --</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="dis">Distrito:</label>
								<div class="col-md-6 col-lg-3">
									<div class="row">
										<select class="form-control form-control-sm dis" name="dis" id="dis" required="">
											<option value="">-- Seleccione --</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row ajaxMap mt-1 d-none">
								<div class="col-12 px-0">
									<div class="pac-card pull-right px-2 py-2" id="pac-card" style="border:1px dotted #cdcdcd;background-color:#d6d6d6">
									  <div id="pac-container" class="place-map">
										<input id="pac-input" type="text" class="form-control form-control-sm" 
											style="width:250px;border:2px solid #CDCDCD;background-color:#fff" placeholder="Buscar direcciones" />
									  </div>
									</div>
									<div id="infowindow-content">
									  <div id="place-name" class="title"></div>
									  <div id="place-address"></div>
									</div>
									<input type="hidden" name="lat" id="lat" /><input type="hidden" name="lng" id="lng" />
									<div id="map" style="min-height:350px;width:100%;margin:auto"></div>
								</div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="profesion">Profesi&oacute;n:</label>
								<div class="col-md-6 col-lg-3">
									<div class="row">
										<select class="form-control form-control-sm" name="profesion" id="profesion">
										<?
											foreach($prof as $row):	?>
											<option value="<?=$row['idprofesion']?>"><?=$row['profesion']?></option>
											<?		endforeach;	?>
										</select>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="nivel">Nivel:</label>
								<div class="col-md-6 col-lg-3">
									<div class="row">
										<select class="form-control form-control-sm" name="nivel" id="nivel">
								<?
										foreach($nivel as $row):	?>
											<option value="<?=$row['idnivel']?>"><?=$row['nivel']?></option>
								<?		endforeach;	?>
										</select>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0 pr-0">Anexo 01:</label>
								<div class="col-md-6 col-lg-4">
									<div class="row">
										<div class="custom-file">
											<label class="custom-file-label anexo01" for="anexo01">Cargar Anexo 01</label>
											<input type="file" class="custom-file-input atach" id="anexo01" name="anexo01">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-lg-2 align-self-center mb-0 pr-0 spanexo01"></div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0 pr-0">Anexo 02:</label>
								<div class="col-md-6 col-lg-4">
									<div class="row">
										<div class="custom-file">
											<label class="custom-file-label anexo02" for="anexo02">Cargar Anexo 02</label>
											<input type="file" class="custom-file-input atach" id="anexo02" name="anexo02">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-lg-2 align-self-center mb-0 pr-0 spanexo02"></div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0 pr-0">Anexo 03:</label>
								<div class="col-md-6 col-lg-4">
									<div class="row">
										<div class="custom-file">
											<label class="custom-file-label anexo03" for="anexo03">Cargar Anexo 03</label>
											<input type="file" class="custom-file-input atach" id="anexo03" name="anexo03">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-lg-2 align-self-center mb-0 pr-0 spanexo03"></div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0 pr-0">Anexo 04:</label>
								<div class="col-md-6 col-lg-4">
									<div class="row">
										<div class="custom-file">
											<label class="custom-file-label anexo04" for="anexo04">Cargar Anexo 04</label>
											<input type="file" class="custom-file-input atach" id="anexo04" name="anexo04">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-lg-2 align-self-center mb-0 pr-0 spanexo04"></div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0 pr-0">Anexo 05:</label>
								<div class="col-md-6 col-lg-4">
									<div class="row">
										<div class="custom-file">
											<label class="custom-file-label anexo05" for="anexo05">Cargar Anexo 05</label>
											<input type="file" class="custom-file-input atach" id="anexo05" name="anexo05">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-lg-2 align-self-center mb-0 pr-0 spanexo05"></div>
							</div>
							<div class="row mt-2">
								<label class="control-label col-md-6 col-lg-3 align-self-center mb-0 pr-0">Anexo 06:</label>
								<div class="col-md-6 col-lg-4">
									<div class="row">
										<div class="custom-file">
											<label class="custom-file-label anexo06" for="anexo06">Cargar Anexo 06</label>
											<input type="file" class="custom-file-input atach" id="anexo06" name="anexo06">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-lg-2 align-self-center mb-0 pr-0 spanexo06"></div>
							</div>
						</div>
					</div>
					<div class="container-fluid row"><hr class="col-sm-12"></div>
					<div class="col-12 mx-auto pb-2">
						<button type="submit" class="btn btn-postular ml-1 mr-4" id="btnPostular">Postular</button>
						<a type="reset" class="btn btn-postular btn_canc" href="<?='../'?>">Cancelar</a>
					</div>
				</form>
			</div>
		</div>
	</div>
		<script src="../js/jquery.min.js"></script>
		<script src="../js/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/jquery.validate.min.js"></script>
		<script src="../js/map.js"></script>
		<script src="../js/javascript.js"></script>
		<script>
			function initMap(){}
		</script>
		<!--<script src="<?='https://maps.googleapis.com/maps/api/js?key=AIzaSyA85CP4w2NVLGUH5VQzjVJMcOWdmsj3-r0&callback=initMap'?>" async ></script>-->
		<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA85CP4w2NVLGUH5VQzjVJMcOWdmsj3-r0&libraries=places">-->
		<script>
			const base = '<?=$_SERVER['HOSTNAME'].'/contrataciones/'?>';
			let map = null;
			window.onload = function(){
				var opt = {lat: -12.0467, lng: -77.0322,zoom: 16};
				map = mapa(opt);
			}
		</script>
	</body>
</html>