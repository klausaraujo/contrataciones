<!doctype html>
<html lang="es">
	<head>
		<!-- Loader Header -->
		<?php	require_once('inc/header.php');?>
		<title>CONTRATACIONES</title>
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
						elseif($this->uri->segment(1) === 'usuarios' && $this->uri->segment(2) == '') $this->load->view('usuarios/usuarios');
						elseif($this->uri->segment(1) === 'usuarios' && $this->uri->segment(2) === 'nuevo') $this->load->view('usuarios/form-new');
						elseif($this->uri->segment(1) === 'usuarios' && $this->uri->segment(2) === 'editar') $this->load->view('usuarios/form-editar');
						elseif($this->uri->segment(2) === 'perfil') $this->load->view('usuario/perfil');
						elseif($this->uri->segment(1) === 'locadores' && $this->uri->segment(2) == '') $this->load->view('locadores/locadores');
						elseif($this->uri->segment(1) === 'locadores' && $this->uri->segment(2) == 'nueva') $this->load->view('locadores/form-new');
						elseif($this->uri->segment(1) === 'locadores' && $this->uri->segment(2) == 'editar') $this->load->view('locadores/form-editar');
						elseif($this->uri->segment(1) === 'locadores' && $this->uri->segment(2) == 'evaluar') $this->load->view('locadores/evaluar');
					?>
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
