		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="<?=base_url()?>/public/js/jquery.min.js"></script>
		<!--<script src="<?=base_url()?>/public/js/jquery-3.5.1.js"></script>-->
		<script src="<?=base_url()?>/public/js/popper.min.js"></script>
		<script src="<?=base_url()?>/public/js/bootstrap.min.js"></script>
		  <!-- Appear JavaScript -->
		  <!--<script src="js/jquery.appear.js"></script>
		  <!-- Countdown JavaScript -->
		  <!--<script src="js/countdown.min.js"></script>
		<!-- Counterup JavaScript -->
		<script src="<?=base_url()?>/public/js/waypoints.min.js"></script>
		<script src="<?=base_url()?>/public/js/jquery.counterup.min.js"></script>
		<!-- Wow JavaScript -->
		<script src="<?=base_url()?>/public/js/wow.min.js"></script>
		<!-- Apexcharts JavaScript -->
		<script src="<?=base_url()?>/public/js/apexcharts.js"></script>
		  <!-- Slick JavaScript -->
		<script src="<?=base_url()?>/public/js/slick.min.js"></script>
		<!-- Select2 JavaScript -->
		<script src="<?=base_url()?>/public/js/select2.min.js"></script>
		  <!-- Owl Carousel JavaScript -->
		  <!--<script src="js/owl.carousel.min.js"></script>
		<!-- Magnific Popup JavaScript -->
		<script src="<?=base_url()?>/public/js/jquery.magnific-popup.min.js"></script>
		<!-- Smooth Scrollbar JavaScript -->
		<script src="<?=base_url()?>/public/js/smooth-scrollbar.js"></script>
		  <!-- lottie JavaScript -->
		  <!--<script src="js/lottie.js"></script>
		<!-- am core JavaScript -->
		<script src="<?=base_url()?>/public/js/core.js"></script>
		  <!-- am charts JavaScript -->
		<script src="<?=base_url()?>/public/js/charts.js"></script>
		  <!-- am animated JavaScript -->
		<script src="<?=base_url()?>/public/js/animated.js"></script>
		  <!-- am kelly JavaScript -->
		  <!--<script src="js/kelly.js"></script>
		  <!-- Flatpicker Js -->
		  <!--<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
		<!-- Chart Custom JavaScript -->
		<script src="<?=base_url()?>/public/js/chart-custom.js"></script>
		<!-- Custom JavaScript -->
		<script src="<?=base_url()?>/public/js/custom.js"></script>
		<!--<script src="<?=base_url()?>/public/datatable/datatables.min.js"></script>
		<script src="<?=base_url()?>/public/datatable/dataTables.responsive.min.js"></script>-->
		<script src="<?=base_url()?>/public/datatable/jquery.dataTables.min.js"></script>
		<script src="<?=base_url()?>/public/datatable/dataTables.bootstrap4.min.js"></script>
		<script src="<?=base_url()?>public/js/jquery.validate.min.js"></script>
		<script src="<?=base_url()?>/public/js/general.js"></script>
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
		<?php if($this->uri->segment(1) === 'proveedores'){ ?>
		<script src="<?=base_url()?>/public/js/proveedores/proveedores.js"></script>
		<script>
			let botonesProv = JSON.parse('<?=$this->session->userdata('perProv')?>');
			<?if($this->uri->segment(2) == ''){?>
			let btnEdit = false, btnMov = false;
			
			$.each(botonesProv,function(i,e){
				if(e.idpermiso === '1') btnEdit = true;
				else if(e.idpermiso === '2') btnMov = true;
			});
			<?}?>
		</script>
		<?}else if($this->uri->segment(1) === 'usuarios'){ ?>
		<script src="<?=base_url()?>/public/js/usuarios/usuarios.js"></script>
		<script>
			let botonesUser = JSON.parse('<?=$this->session->userdata('perUser')?>');
			<?if($this->uri->segment(2) == ''){?>
			let btnEditUser = false, btnSucur = false, btnPermisos = false, btnClave = false, btnActiva = false;
			
			$.each(botonesUser,function(i,e){
				if(e.idpermiso === '10') btnEditUser = true;
				else if(e.idpermiso === '11') btnSucur = true;
				else if(e.idpermiso === '12') btnPermisos = true;
				else if(e.idpermiso === '13') btnClave = true;
				else if(e.idpermiso === '14') btnActiva = true;
			});
			<?}?>
		</script>
		<?}else if($this->uri->segment(1) === 'servicios'){ ?>
		<script src="<?=base_url()?>public/js/servicios/servicios.js"></script>
		<script>
			let botonesServ = JSON.parse('<?=$this->session->userdata('perServ')?>');
			<?if($this->uri->segment(2) == ''){?>
			let btnEdit = false, btnAnular = false, btnPdf = false;;
			
			$.each(botonesServ,function(i,e){
				if(e.idpermiso === '19') btnEdit = true;
				else if(e.idpermiso === '20') btnAnular = true;
				else if(e.idpermiso === '21') btnPdf = true;
			});
			<?}?>
		</script>
		<?}else if($this->uri->segment(1) === 'certificaciones'){ ?>
		<script src="<?=base_url()?>public/js/certificaciones/certificaciones.js"></script>
		<script>
			let botonesCert = JSON.parse('<?=$this->session->userdata('perServ')?>');
			<?if($this->uri->segment(2) == ''){?>
			let btnEdit = false, btnParam = false, btnAnular = false, btnPdf = false;
			
			$.each(botonesCert,function(i,e){
				if(e.idpermiso === '15') btnEdit = true;
				else if(e.idpermiso === '16') btnParam = true;
				else if(e.idpermiso === '17') btnAnular = true;
				else if(e.idpermiso === '18') btnPdf = true;
			});
			<?}?>
		</script>
		<?}else if($this->uri->segment(1) === 'ventas'){ ?>
		<script src="<?=base_url()?>public/js/ventas/ventas.js"></script>
		<script>
			let botonesVtas = JSON.parse('<?=$this->session->userdata('perVent')?>');
			<?if($this->uri->segment(2) == ''){?>
			let btnEdit = false, btnVta = false;
			
			$.each(botonesVtas,function(i,e){
				if(e.idpermiso === '22') btnEdit = true;
				else if(e.idpermiso === '23') btnVta = true;
			});
			<?}?>
		</script>
		<?}?>
		<?if(($this->uri->segment(1) === 'proveedores' || $this->uri->segment(1) === 'usuarios' || $this->uri->segment(1) === 'servicios' || 
				$this->uri->segment(1) === 'certificaciones' || $this->uri->segment(1) === 'ventas') && $this->uri->segment(2) == ''){ ?>
		<script>
			const headers = JSON.parse('<?=json_encode($headers)?>');
		</script>
		<?}
		/*Rutinas para los segmentos 2*/
		if($this->uri->segment(1) === 'proveedores' && $this->uri->segment(2) === 'transacciones'){ ?>
		<script>
			const headersOp = JSON.parse('<?=json_encode($headersOp)?>');
			const headersIng = JSON.parse('<?=json_encode($headersIng)?>');
			const headersVal = JSON.parse('<?=json_encode($headersVal)?>');
			const id = <?=$this->input->get('id')?>;
			let btnAnulaOp = false, btnEdtGuia = false, btnAnulGuia = false, btnPdfGuia = false, btnCompGuia = false, btnAnulValor = false, btnVerValor = false;
			
			$.each(botonesProv,function(i,e){
				if(e.idpermiso === '3') btnAnulaOp = true;
				else if(e.idpermiso === '4') btnEdtGuia = true;
				else if(e.idpermiso === '5') btnAnulGuia = true;
				else if(e.idpermiso === '6') btnPdfGuia = true;
				else if(e.idpermiso === '7') btnCompGuia = true;
				else if(e.idpermiso === '8') btnAnulValor = true;
				else if(e.idpermiso === '9') btnVerValor = true;
			});
		</script>
		<?}else if(($this->uri->segment(1) === 'proveedores' && ($this->uri->segment(2) === 'nuevo' || $this->uri->segment(2) === 'editar')) || 
			($this->uri->segment(1) === 'ventas' && $this->uri->segment(2) === 'cliente' && ($this->uri->segment(3) === 'nuevo' || $this->uri->segment(3) === 'editar'))){ ?>
		<script src="<?=base_url()?>public/js/mapa/map.js"></script>
		<script>
			let map = null;
			window.onload = function(){
				var opt = {lat: parseFloat(<?=$lat?>), lng: parseFloat(<?=$lng?>),zoom: 16};
				<?/*if($this->uri->segment(2) === 'editar' || $this->uri->segment(3) === 'editar'){?> $('.ajaxMap').removeClass('d-none');<?}*/?>
				map = mapa(opt);
			}
		</script>
		<?}else if($this->uri->segment(2) === 'parametros'){?>
		<script>
			let catadores = JSON.parse('<?=json_encode($catadores)?>');
			
			 // Obtener una referencia al elemento canvas del DOM
			const $grafica = document.querySelector("#grafica");
			// Podemos tener varios conjuntos de datos. Comencemos con uno
			const $data = {
				labels: ['FRAGANCIA/AROMA', 'SABOR', 'SABOR RESIDUAL', 'ACIDEZ', 'CUERPO', 'UNIFORMIDAD', 'BALANCE', 'TAZA LIMPIA', 'DULZURA', 'APRECIACIÓN GENERAL'],
				datasets: [{
					label: '',
					data: [$('#fragptos').val(),$('#sabptos').val(),$('#sabreptos').val(),$('#aciptos').val(),$('#cuerptos').val(),
							$('#uniptos').val(),$('#balptos').val(),$('#tazptos').val(),$('#dulptos').val(),$('#apreptos').val()],
					//fill: true,
					backgroundColor: 'rgba(255, 99, 132, 0)',
					borderColor: 'rgb(255, 99, 132)',
					pointBackgroundColor: 'rgb(255, 99, 132)',
					pointBorderColor: '#fff',
					pointHoverBackgroundColor: '#fff',
					pointHoverBorderColor: 'rgb(255, 99, 132)'
				}]
			};
			let optGrafico = {
				responsive: true,
				//elements: { line: { borderWidth: 3 } },
				plugins: {
					legend: { display: false, labels: { color: 'rgb(255, 99, 132)' } },
					title: { display: true, text: 'PERFIL SENSORIAL' }
				},
				scales:{
					r:{ grid:{ circular: true }, beginAtZero: true }
				},
				animation: {
					onComplete: function(){
						$('#grafico').val(document.getElementById('grafica').toDataURL('image/png'));
						//$('#imagengraph').attr('src',$('#grafico').val());
					}
				}
			};
			window.radarChart = new Chart($grafica, {
				type: 'radar',// Tipo de gráfica
				data: $data,
				options: optGrafico
			});
			
			
			
			
//if (jQuery('#am-radar-chart').length) {
	/*window.onload = function(){
    am4core.ready(function(){

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance 
        chart = am4core.create('am-radar-chart', am4charts.RadarChart);
        chart.colors.list = [am4core.color("#089bab")];
		let title = chart.titles.create();
		title.text = 'ANALISIS SENSORIAL';
		title.fontSize = 20;

        // Add data 
        chart.data = [
			{'sensoriales': "SABOR", 'litres': 20, 'units': 20},
			{'sensoriales': 'OLOR', 'litres': 15, 'units': 15},
			{'sensoriales': 'DISQUE', 'litres': 10, 'units': 10},
			{'sensoriales': 'TACTO', 'litres': 7, 'units': 7},
			{'sensoriales': 'OLFATO','litres': 4, 'units': 4}
		];

        // Create axes 
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = 'sensoriales';

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.renderer.axisFills.template.fill = chart.colors.getIndex(1);
        valueAxis.renderer.axisFills.template.fillOpacity = 0.05;

        // Create and configure series 
        var series = chart.series.push(new am4charts.RadarSeries());
        series.dataFields.valueY = 'litres';
        series.dataFields.categoryX = 'sensoriales';
        series.name = 'Aromas';
        series.strokeWidth = 2;
		series.zIndex = 2;
	
		let series2 = chart.series.push(new am4charts.RadarColumnSeries());
		series2.dataFields.valueY = 'units';
		series2.dataFields.categoryX = 'sensoriales';
		series2.name = 'Units';
		series2.strokeWidth = 0;
		series2.columns.template.fill = am4core.color("#CDA2AB");
		series2.columns.template.tooltipText = "Series: {name}\nCategory: {categoryX}\nValue: {valueY}";
		
		/*chart.xAxes.rangeChangeAnimation.once('animationended', (ev) => {
			console.log('Listo');
			setTimeout(function(){
				let svg = document.querySelector('svg');

				let svgURL = new XMLSerializer().serializeToString(svg);
				//let encoded = btoa(svgURL);
				let encoded = btoa(unescape(encodeURIComponent(svgURL)));
				//console.log(encoded);
				//console.log(encodeURIComponent(svgURL));
				$('#imagen').attr('src', 'data:image/svg+xml;base64,' + encoded);
				
			}, 500);
		});*/
		//console.log(chart);
		
		/*chart.events.on('frameended', (ev) => {
			setTimeout(function(){
				let svg = document.querySelector('svg');

				let svgURL = new XMLSerializer().serializeToString(svg);
				//let encoded = btoa(svgURL);
				let encoded = btoa(unescape(encodeURIComponent(svgURL)));
				//console.log(encoded);
				//console.log(encodeURIComponent(svgURL));
				$('#imagen').attr('src', 'data:image/svg+xml;base64,' + encoded);
				
			}, 500);
		});*/
		/*chart.events.on('beforedatavalidated', function(ev) {
			setTimeout(function(){
				let svg = document.querySelector('svg');

				let svgURL = new XMLSerializer().serializeToString(svg);
				//let encoded = btoa(svgURL);
				let encoded = btoa(unescape(encodeURIComponent(svgURL)));
				//console.log(encoded);
				//console.log(encodeURIComponent(svgURL));
				$('#imagen').attr('src', 'data:image/svg+xml;base64,' + encoded);
				
			}, 1000);
		});*/
		/*chart.events.on('extremeschanged',function(){
			let svg = document.querySelector('svg');

			let svgURL = new XMLSerializer().serializeToString(svg);
			//let encoded = btoa(svgURL);
			let encoded = btoa(unescape(encodeURIComponent(svgURL)));
			//console.log(encoded);
			//console.log(encodeURIComponent(svgURL));
			$('#imagen').attr('src', 'data:image/svg+xml;base64,' + encoded);
		});*/
	//}); // end am4core.ready()
//}
//}
			
			
			
			
			
			
			
		</script>
		<?}elseif($this->uri->segment(1) === 'ventas' && $this->uri->segment(2) === 'ventascliente'){ ?>
		<script>
			const id = <?=$this->input->get('id')?>;
			const headersSal = JSON.parse('<?=json_encode($headersSal)?>');
			let btnEdit = false, btnAnular = false, btnGuia = false, btnComp = false;
			$.each(botonesVtas,function(i,e){
				if(e.idpermiso === '24') btnAnular = true;
				else if(e.idpermiso === '25') btnEdit = true;
				else if(e.idpermiso === '26') btnGuia = true;
				else if(e.idpermiso === '27') btnComp = true;
			});
		</script>
		<?}?>