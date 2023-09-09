<!-- Desactivar cache del navegador 
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">-->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="<?=base_url()?>/public/images/favicon.jpg"/>
<link rel="icon" href="<?=base_url()?>/public/images/favicon.jpg" type="image/x-icon">
<!--<link rel="stylesheet" href="<?=base_url()?>/public/css/bootstrap.min.css">-->
<link rel="stylesheet" href="<?=base_url()?>/public/css/bootstrap.css">
<!--<link rel="stylesheet" href="<?=base_url()?>/public/datatable/datatables.min.css">
<link rel="stylesheet" href="<?=base_url()?>/public/datatable/responsive.dataTables.min.css">-->
<link rel="stylesheet" href="<?=base_url()?>/public/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url()?>/public/css/typography.css">
<link rel="stylesheet" href="<?=base_url()?>/public/css/style.css">
<link rel="stylesheet" href="<?=base_url()?>/public/css/responsive.css">
<link rel="stylesheet" href="<?=base_url()?>/public/css/fontawesome.css">
<link rel="stylesheet" href="<?=base_url()?>/public/assets/css/fontawesome.min.css">
<link rel="stylesheet" href="<?=base_url()?>/public/assets/css/brands.css">
<link rel="stylesheet" href="<?=base_url()?>/public/assets/css/solid.css">
<style>
@media(max-width: 1299px){
	body.sidebar-main .iq-sidebar { width: 260px; left: 0; z-index: 999; background: rgba(221,95,26,1); background: -moz-linear-gradient(left, rgba(173,104,64,1) 0%, rgba(221,95,26,1) 100%); background: -webkit-gradient(left top, right top, color-stop(0%, rgba(173,104,64,1)), color-stop(100%, rgba(221,95,26,1))); background: -webkit-linear-gradient(left, rgba(173,104,64,1) 100%) 0%, rgba(221,95,26,1) 100%); background: -o-linear-gradient(left, rgba(173,104,64,1) 0%, rgba(221,95,26,1) 100%); background: -ms-linear-gradient(left, rgba(173,104,64,1) 0%, rgba(221,95,26,1) 100%); background: linear-gradient(to right, rgba(173,104,64,1) 0%, rgba(221,95,26,1) 100%); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#A0522D', endColorstr='#8B4513', GradientType=1); }
}
@media (max-width: 479px){
	.iq-top-navbar .navbar-toggler, .iq-top-navbar .iq-navbar-custom .iq-menu-bt{ top: 18px; }
	.navbar-collapse{ top: 75px; }
	.content-page, body.sidebar-main .content-page { padding: 95px 0 0; }
}
@media (max-width: 992px){
	.iq-top-navbar .navbar-toggler{ right: 20px; }
	.iq-top-navbar .iq-navbar-custom .iq-menu-bt { right: 80px; }
}
.modal-lg, .modal-xl { max-width: 900px; }
.modal-ing { max-width: 1100px; }
//table.dataTable tr, th, td{font-size: 0.8rem;}
#tablaCobros tr, #tablaCobros th, #tablaCobros td, #tablaPagos tr, #tablaPagos th, #tablaPagos td, #tablaPagosVal tr, #tablaPagosVal th, #tablaPagosVal td{font-size: 0.7rem;}
div.dataTables_wrapper div.dataTables_length .form-control-sm{
	line-height: 1.5;
	background: #fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right 0.75rem center/8px 10px;
}
div.dataTables_wrapper .far, div.dataTables_wrapper .fa, div.dataTables_wrapper .fas {
	line-height: 2;
	font-size: medium;
}
.fallecido {
  font-weight: bold;
  animation-name: parpadeo;
  animation-duration: 1s;
  animation-timing-function: linear;
  animation-iteration-count: infinite;

  -webkit-animation-name:parpadeo;
  -webkit-animation-duration: 1s;
  -webkit-animation-timing-function: linear;
  -webkit-animation-iteration-count: infinite;
}

@-moz-keyframes parpadeo{  
  0% { opacity: 1.0; }
  50% { opacity: 0.0; }
  100% { opacity: 1.0; }
}

@-webkit-keyframes parpadeo {  
  0% { opacity: 1.0; }
  50% { opacity: 0.0; }
   100% { opacity: 1.0; }
}

@keyframes parpadeo {  
  0% { opacity: 1.0; }
   50% { opacity: 0.0; }
  100% { opacity: 1.0; }
}
</style>

<?if(($this->uri->segment(1) === 'proveedores' && ($this->uri->segment(2) === 'nuevo' || $this->uri->segment(2) === 'editar')) || 
		($this->uri->segment(1) === 'ventas' && $this->uri->segment(2) === 'cliente' && ($this->uri->segment(3) === 'nuevo' || $this->uri->segment(3) === 'editar'))){ ?>
<script>
	function initMap(){}
</script>
<!--<script src="https://polyfill.io/v3/polyfill.min.js?features=default" async ></script>-->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=<?='AIzaSyA85CP4w2NVLGUH5VQzjVJMcOWdmsj3-r0'?>&libraries=places&v=weekly" async ></script>-->
<script src="<?='https://maps.googleapis.com/maps/api/js?key=AIzaSyA85CP4w2NVLGUH5VQzjVJMcOWdmsj3-r0&callback=initMap'?>" async ></script>
<?}elseif($this->uri->segment(2) === 'parametros'){?>
<!--<script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?}?>