		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="<?=base_url()?>public/js/jquery.min.js"></script>
		<!--<script src="<?=base_url()?>/public/js/jquery-3.5.1.js"></script>-->
		<script src="<?=base_url()?>public/js/popper.min.js"></script>
		<script src="<?=base_url()?>public/js/bootstrap.min.js"></script>
		  <!-- Appear JavaScript -->
		  <!--<script src="js/jquery.appear.js"></script>
		  <!-- Countdown JavaScript -->
		  <!--<script src="js/countdown.min.js"></script>
		<!-- Counterup JavaScript -->
		<script src="<?=base_url()?>public/js/waypoints.min.js"></script>
		<script src="<?=base_url()?>public/js/jquery.counterup.min.js"></script>
		<!-- Wow JavaScript -->
		<script src="<?=base_url()?>public/js/wow.min.js"></script>
		<!-- Apexcharts JavaScript -->
		<script src="<?=base_url()?>public/js/apexcharts.js"></script>
		  <!-- Slick JavaScript -->
		<script src="<?=base_url()?>public/js/slick.min.js"></script>
		<!-- Select2 JavaScript -->
		<script src="<?=base_url()?>public/js/select2.min.js"></script>
		  <!-- Owl Carousel JavaScript -->
		  <!--<script src="js/owl.carousel.min.js"></script>
		<!-- Magnific Popup JavaScript -->
		<script src="<?=base_url()?>public/js/jquery.magnific-popup.min.js"></script>
		<!-- Smooth Scrollbar JavaScript -->
		<script src="<?=base_url()?>public/js/smooth-scrollbar.js"></script>
		  <!-- lottie JavaScript -->
		  <!--<script src="js/lottie.js"></script>
		<!-- am core JavaScript -->
		<script src="<?=base_url()?>public/js/core.js"></script>
		  <!-- am charts JavaScript -->
		<script src="<?=base_url()?>public/js/charts.js"></script>
		  <!-- am animated JavaScript -->
		<script src="<?=base_url()?>public/js/animated.js"></script>
		  <!-- am kelly JavaScript -->
		  <!--<script src="js/kelly.js"></script>
		  <!-- Flatpicker Js -->
		  <!--<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
		<!-- Chart Custom JavaScript -->
		<script src="<?=base_url()?>public/js/chart-custom.js"></script>
		<!-- Custom JavaScript -->
		<script src="<?=base_url()?>public/js/custom.js"></script>
		<!--<script src="<?=base_url()?>/public/datatable/datatables.min.js"></script>
		<script src="<?=base_url()?>/public/datatable/dataTables.responsive.min.js"></script>-->
		<script src="<?=base_url()?>public/datatable/jquery.dataTables.min.js"></script>
		<script src="<?=base_url()?>public/datatable/dataTables.bootstrap4.min.js"></script>
		<script src="<?=base_url()?>public/js/jquery.validate.min.js"></script>
		<script src="<?=base_url()?>public/js/general.js"></script>
		<script>
			let botones = '<"row"<"col-sm-12 mt-2 mb-4"B><"col-sm-6 float-left my-2"l><"col-sm-6 float-right my-2"f>rt>ip';
			const base_url = '<?=base_url()?>', segmento = '<?=$this->uri->segment(1)?>', segmento2 = '<?=$this->uri->segment(2)?>';
			const opt = { style:'decimal', minimumFractionDigits: 2 };
			const lngDataTable = {
				"decimal": "",
				"emptyTable": "No se encontraron registros",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
				"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
				"infoFiltered": "(Filtrado de _MAX_ total entradas)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ Entradas",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar:",
				"zeroRecords": "No hay resultados",
				"paginate": {
					"first": "Primero",
					"last": "Ultimo",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			}
			function mayus(e){e.value = e.value.toUpperCase();}
		</script>
		<!-- Rutinas Javascript por cada uno de los segmentos 1 -->
		<?php if($this->uri->segment(1) === 'usuarios'){ ?>
		<script src="<?=base_url()?>public/js/usuarios/usuarios.js"></script>
		<script>
			let botonesUser = JSON.parse('<?=$this->session->userdata('perUser')?>');
			<?if($this->uri->segment(2) == ''){?>
			let btnEditUser = false, btnPermisos = false, btnClave = false, btnActiva = false;
			
			$.each(botonesUser,function(i,e){
				if(e.idpermiso === '1') btnEditUser = true;
				else if(e.idpermiso === '2') btnPermisos = true;
				else if(e.idpermiso === '3') btnClave = true;
				else if(e.idpermiso === '4') btnActiva = true;
			});
			<?}?>
		</script>
		<?}elseif($this->uri->segment(1) === 'locadores'){ ?>
		<script src="<?=base_url()?>public/js/locadores/locadores.js"></script>
		<script>
			let botonesLoc = JSON.parse('<?=$this->session->userdata('perLocadores')?>');
			<?if($this->uri->segment(2) == ''){?>
			let btnEdit = false, btnCan = false, btnEval = false, btnPub = false;
			
			$.each(botonesLoc,function(i,e){
				if(e.idpermiso === '5') btnEdit = true;
				else if(e.idpermiso === '6') btnCan = true;
				else if(e.idpermiso === '7') btnEval = true;
				else if(e.idpermiso === '8') btnPub = true;
			});
			<?}elseif($this->uri->segment(2) === 'evaluar'){?>
				const postulantes = JSON.parse('<?=json_encode($data)?>');
			<?}?>
		</script>
		<?}
		if(($this->uri->segment(1) === 'usuarios' || $this->uri->segment(1) === 'locadores') && $this->uri->segment(2) == ''){ ?>
		<script>
			const headers = JSON.parse('<?=json_encode($headers)?>');
		</script>
		<?}?>