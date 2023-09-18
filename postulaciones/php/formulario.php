<?php
	include_once(__DIR__.'/Funciones.php');
	date_default_timezone_set('America/Lima');
	
	$con = new Funciones();
	$prof = $con->profesiones();
	$nivel = $con->nivel();
	$dep = $con->departamentos();
	$con->close();
?>
<!doctype html>
<html lang="es">
	<head>
		<title>Postulaciones</title>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="../css/typography.css">
		<style>
			body{ margin: 2rem 1rem }
			//.wrapper{ background-color: #fff; }
			.btn-postular{ background-color: #428bca; border-color: #066ed7; color: #fff; border-color: #428bca; }
		</style>
	</head>
	<body class="wrapper">
	<div class="container-fluid">	
		<div class="col-12 iq-card my-3">
			<div class="iq-card-header d-flex justify-content-between">
				<div class="iq-header-title"><h4>Postulacion</h4></div>
			</div>
			<div class="iq-card-body">
				<form method="post" id="form_postulante" action="">
					<input type="hidden" name="tiporegistro" value="registrar" />
						<div class="form-row">
							<div class="col-12 my-1">
								<div class="row">
									<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="tipodoc">Tipo de Documento:</label>
									<div class="col-md-6 col-lg-3">
										<div class="row">
											<select class="form-control form-control-sm tipodoc" name="tipodoc" id="tipodoc" required="">
												<option value="">--Seleccione--</option>
												<option value="01">D.N.I.</option>
												<option value="03">CARNET ETX.</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row mt-2">
									<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="doc">N&uacute;mero de Documento:</label>
									<div class="col-md-4 col-lg-2">
										<div class="row">
											<input type="text" class="form-control form-control-sm doc borra num numcurl" maxlength="8" minlength="8" name="doc" id="doc" autocomplete="off"
												placeholder="Nro. Documento" required="" />
										</div>
									</div>
									<div class="col-md-2 col-lg-1 px-0 pl-md-3 pl-lg-4 align-self-center mt-0">
										<button type="button" class="btn btn-info btn_curl px-1 py-1">Buscar</button>
									</div>
									<!--<label class="form_error error_curl col-md-4 my-0"></label>-->
								</div>
								<div class="row mt-2">
									<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="ruc">RUC:</label>
									<div class="col-md-4 col-lg-2">
										<div class="row">
											<input type="text" class="form-control form-control-sm ruc borra num" name="ruc" id="ruc" placeholder="RUC" value="" minlength="11" 
												maxlength="11"/>
										</div>
									</div>
								</div>
								<div class="row mt-2">
									<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="nombres">Raz&oacute;n Social:</label>
									<div class="col-md-6 col-lg-4">
										<div class="row">
											<input type="text" class="form-control form-control-sm borra nombres mayusc" name="nombres" id="nombres" placeholder="Raz&oacute;n Social" value="" required="" readonly />
											<div class="invalid-feedback" id="error-razon">Debe indicar una Raz&oacute;n social</div>
										</div>
									</div>
								</div>
								<div class="row mt-2">
									<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="direccion">Domicilio:</label>
									<div class="col-md-6 col-lg-4">
										<div class="row">
											<input type="text" class="form-control form-control-sm borra direccion mayusc" name="direccion" id="direccion" placeholder="Domicilio" value="" required="" />
											<div class="invalid-feedback">Campo requerido</div>
										</div>
									</div>
								</div>
								<div class="row mt-2">
									<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="dep">Departamento:</label>
									<div class="col-md-6 col-lg-3">
										<div class="row">
											<select class="form-control form-control-sm dep" name="dep" id="dep" required="" >
											<?
													foreach($dep as $row):	?>
														<option value="<?=$row['cod_dep'];?>" <?=$row['cod_dep']==='15'?'selected':'';?>><?=$row['departamento'];?></option>
											<?		endforeach;	?>
											</select>
											<div class="invalid-feedback">Debe elegir un Departamento</div>
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
											<div class="invalid-feedback">Debe elegir una Provincia</div>
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
											<div class="invalid-feedback">Debe elegir un Distrito</div>
										</div>
									</div>
								</div>
								<div class="row ajaxMap mt-3 d-none">
									<div class="col-12 px-0">
										<!--<div class="pac-card" id="pac-card">
										  <div id="pac-container" class="place-map">
											<input id="pac-input" type="text" placeholder="Enter a location" />
										  </div>
										</div>
										<div id="infowindow-content">
										  <div id="place-name" class="title"></div>
										  <div id="place-address"></div>
										</div>-->
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
							</div>
						</div>
						<div class="container-fluid row"><hr class="col-sm-12"></div>
						<div class="col-12 mx-auto pb-2">
							<button type="submit" class="btn btn-postular ml-1 mr-4" id="btnEnviar">Guardar</button>
							<button type="reset" class="btn btn-postular">Cancelar</button>
						</div>
					</form>
				</div>
		</div>
	</div>
		<script src="../js/jquery.min.js"></script>
		<script src="../js/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/jquery.validate.min.js"></script>
		<script src="../js/javascript.js"></script>
	</body>
</html>