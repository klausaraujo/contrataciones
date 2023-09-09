<!doctype html>
<html lang="es">
	<head>
		<!-- Loader Header -->
		<?php	require_once('inc/header.php');	date_default_timezone_set('America/Lima');?>
		<title>NARSA</title>
	</head>
	<body>
		<!-- loader Start -->
		<!--<div id="loading">
			<div id="loading-center">

			</div>
		</div>-->
		<!-- loader END -->
		<!-- Wrapper Start -->
		<div class="wrapper bg-narsa">
			<!-- Sidebar  -->
			<?php $this->load->view('inc/nav-template'); ?>
			<!-- Sidebar END -->
			<!-- Page Content  -->
			<div id="content-page" class="content-page">
				<!-- TOP Nav Bar -->
				<?php $this->load->view('inc/nav-top-template'); ?>
				<!-- TOP Nav Bar END -->
				<div class="container-fluid">
					<div class="row mx-1">
					<?php 
						//echo date_default_timezone_get();
						if($this->uri->segment(1) == '') $this->load->view('modulos');
						elseif($this->uri->segment(1) === 'proveedores' && $this->uri->segment(2) == '') $this->load->view('proveedores/proveedores');
						elseif($this->uri->segment(1) === 'proveedores' && $this->uri->segment(2) === 'nuevo') $this->load->view('proveedores/form-new');
						elseif($this->uri->segment(1) === 'proveedores' && $this->uri->segment(2) === 'editar') $this->load->view('proveedores/form-editar');
						elseif($this->uri->segment(1) === 'proveedores' && $this->uri->segment(2) === 'transacciones') $this->load->view('proveedores/transacciones');
						elseif($this->uri->segment(1) === 'servicios' && $this->uri->segment(2) == '') $this->load->view('servicios/servicios');
						elseif($this->uri->segment(1) === 'servicios' && $this->uri->segment(2) === 'nuevo') $this->load->view('servicios/form-new');
						elseif($this->uri->segment(1) === 'servicios' && $this->uri->segment(2) === 'editar') $this->load->view('servicios/form-editar');
						elseif($this->uri->segment(1) === 'certificaciones' && $this->uri->segment(2) == '') $this->load->view('certificaciones/certificaciones');
						elseif($this->uri->segment(1) === 'certificaciones' && $this->uri->segment(2) === 'nuevo') $this->load->view('certificaciones/form-new');
						elseif($this->uri->segment(1) === 'certificaciones' && $this->uri->segment(2) === 'editar') $this->load->view('certificaciones/form-editar');
						elseif($this->uri->segment(1) === 'certificaciones' && $this->uri->segment(2) === 'parametros') $this->load->view('certificaciones/parametros');
						elseif($this->uri->segment(1) === 'ventas' && $this->uri->segment(2) == '') $this->load->view('ventas/clientes');
						elseif($this->uri->segment(1) === 'ventas' && $this->uri->segment(2) === 'cliente' && $this->uri->segment(3) === 'nuevo') $this->load->view('ventas/form-new');
						elseif($this->uri->segment(1) === 'ventas' && $this->uri->segment(2) === 'cliente' && $this->uri->segment(3) === 'editar') $this->load->view('ventas/form-editar');
						elseif($this->uri->segment(1) === 'ventas' && $this->uri->segment(2) === 'ventascliente') $this->load->view('ventas/ventas');
						elseif($this->uri->segment(1) === 'usuarios' && $this->uri->segment(2) == '') $this->load->view('usuarios/usuarios');
						elseif($this->uri->segment(1) === 'usuarios' && $this->uri->segment(2) === 'nuevo') $this->load->view('usuarios/form-new');
						elseif($this->uri->segment(1) === 'usuarios' && $this->uri->segment(2) === 'editar') $this->load->view('usuarios/form-editar');
						elseif($this->uri->segment(2) === 'perfil') $this->load->view('usuario/perfil');//Anular
					?>
						<!--<div class="col-lg-12">
						 <!--<div class="row">
							<div class="col-md-6 col-lg-3">
							   <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
								  <div class="iq-card-body iq-bg-primary rounded">
									 <div class="d-flex align-items-center justify-content-between">
										<div class="rounded-circle iq-card-icon bg-primary"><i class="ri-user-fill"></i></div>
										<div class="text-right">                                 
										   <h2 class="mb-0"><span class="counter">5600</span></h2>
										   <h5 class="">Doctors</h5>
										</div>
									 </div>
								  </div>
							   </div>
							</div>
							<div class="col-md-6 col-lg-3">
							   <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
								  <div class="iq-card-body iq-bg-warning rounded">
									 <div class="d-flex align-items-center justify-content-between">
										<div class="rounded-circle iq-card-icon bg-warning"><i class="ri-women-fill"></i></div>
										<div class="text-right">                                 
										   <h2 class="mb-0"><span class="counter">3450</span></h2>
										   <h5 class="">Nurses</h5>
										</div>
									 </div>
								  </div>
							   </div>
							</div>
							<div class="col-md-6 col-lg-3">
							   <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
								  <div class="iq-card-body iq-bg-danger rounded">
									 <div class="d-flex align-items-center justify-content-between">
										<div class="rounded-circle iq-card-icon bg-danger"><i class="ri-group-fill"></i></div>
										<div class="text-right">                                 
										   <h2 class="mb-0"><span class="counter">3500</span></h2>
										   <h5 class="">Patients</h5>
										</div>
									 </div>
								  </div>
							   </div>
							</div>
							<div class="col-md-6 col-lg-3">
							   <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
								  <div class="iq-card-body iq-bg-info rounded">
									 <div class="d-flex align-items-center justify-content-between">
										<div class="rounded-circle iq-card-icon bg-info"><i class="ri-hospital-line"></i></div>
										<div class="text-right">                                 
										   <h2 class="mb-0"><span class="counter">4500</span></h2>
										   <h5 class="">Pharmacists</h5>
										</div>
									 </div>
								  </div>
							   </div>
							</div>
						 </div>
						</div>-->
					</div>
				</div>
				<!-- Footer -->
				<?php $this->load->view('inc/footer-template'); ?>
				<!-- Footer END -->
			</div>
			<!-- Page Content END -->
		</div>
		<!-- Wrapper END -->
		<?php	require_once('inc/footer.php');	?>
	</body>
</html>
