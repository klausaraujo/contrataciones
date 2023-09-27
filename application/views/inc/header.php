<!-- Desactivar cache del navegador 
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">-->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="<?=base_url()?>/public/images/favicon.jpg"/>
<link rel="icon" href="<?=base_url()?>/public/images/favicon.jpg" type="image/x-icon">
<link rel="stylesheet" href="<?=base_url()?>/public/css/bootstrap.css">
<link rel="stylesheet" href="<?=base_url()?>/public/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url()?>/public/css/typography.css">
<link rel="stylesheet" href="<?=base_url()?>/public/css/style.css">
<link rel="stylesheet" href="<?=base_url()?>/public/css/responsive.css">
<link rel="stylesheet" href="<?=base_url()?>/public/css/fontawesome.css">
<link rel="stylesheet" href="<?=base_url()?>/public/assets/css/fontawesome.min.css">
<link rel="stylesheet" href="<?=base_url()?>/public/assets/css/brands.css">
<link rel="stylesheet" href="<?=base_url()?>/public/assets/css/solid.css">
<style>
/*@media(max-width: 1299px){
	body.sidebar-main .iq-sidebar { width: 260px; left: 0; z-index: 999; background: rgba(221,95,26,1); background: -moz-linear-gradient(left, rgba(173,104,64,1) 0%, rgba(221,95,26,1) 100%); background: -webkit-gradient(left top, right top, color-stop(0%, rgba(173,104,64,1)), color-stop(100%, rgba(221,95,26,1))); background: -webkit-linear-gradient(left, rgba(173,104,64,1) 100%) 0%, rgba(221,95,26,1) 100%); background: -o-linear-gradient(left, rgba(173,104,64,1) 0%, rgba(221,95,26,1) 100%); background: -ms-linear-gradient(left, rgba(173,104,64,1) 0%, rgba(221,95,26,1) 100%); background: linear-gradient(to right, rgba(173,104,64,1) 0%, rgba(221,95,26,1) 100%); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#A0522D', endColorstr='#8B4513', GradientType=1); }
	 }
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
.dashboard__title{ font-size: 1.07em; margin-right: 0.5rem; margin-left: 0.5rem }*/

.sign-in-from { bottom: 30%; }

/* Colores personalizados*/
.wrapper, .sidebar-scrollbar, .sign-in-page .sign-in-page-bg::after, .bg-sabogal, .btn-sabogal, .iq-card-body-elements {
	background: rgba(0,150,210,1);
	background: -moz-linear-gradient(left, rgba(0,150,210,1) 0%, rgba(81,209,246,1) 100%);
	background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,150,210,1)), color-stop(100%, rgba(81,209,246,1)));
	background: -webkit-linear-gradient(left, rgba(0,150,210,1) 100%) 0%, rgba(81,209,246,1) 100%);
	background: -o-linear-gradient(left, rgba(0,150,210,1) 0%, rgba(81,209,246,1) 100%);
	background: -ms-linear-gradient(left, rgba(0,150,210,1) 0%, rgba(81,209,246,1) 100%);
	background: linear-gradient(to right, rgba(0,150,210,1) 0%, rgba(81,209,246,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0096d2', endColorstr='#51d1f6', GradientType=1);
}
.font-sabogal { color: rgba(18,167,240,1) }
.btn-cancel{ background-color: #b5b7c3; color: #545366; }
.sabogal-bg-primary{ background: rgba(0,150,210,0.5); color: #fff; }
.sabogal-bg-primary-hover:hover{ background: rgba(81,209,246,0.3); color: rgba(139,69,19,1); }
.btn-sabogal{ color: #ffffff; }
.wrapper-menu{ color: rgba(18,167,240,1); }
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{ color: rgba(18,167,240,1); }

.modal-lg, .modal-xl { max-width: 900px; }
.modal-ing { max-width: 1100px; }

/* Estilos de los datatables */
div.dataTables_wrapper div.dataTables_length .form-control-sm{
	line-height: 1.5;
	background: #fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right 0.75rem center/8px 10px;
}
div.dataTables_wrapper .far, div.dataTables_wrapper .fa, div.dataTables_wrapper .fas {
	line-height: 2;
}
table.dataTable tr, table.dataTable th, table.dataTable td{ font-size: 0.8rem }
.dataTables_wrapper .mt-5{ margin-top:0 !important; }

.iq-card-body-elements{ height : 230px; border-radius:20px; padding-top: 15px; text-align: center!important; }
.content-page{ padding: 96px 15px 0; } .no-sort::after{ display: none!important; } .no-sort{ pointer-events: none!important; cursor: default!important; }
.form_error{ color: #dc3545; display: block; margin-top: 0.25rem; font-size: 80%; width: 100%; }
.tab-perfil{ border-radius: 20px; }
.btnTable{ -webkit-transition-duration: 0.4s;transition-duration: 0.4s;margin-right:5px;padding:1.5px;border-radius:5px;box-shadow:3px 3px 2px 0 rgb(1 0 2 / 50%); color: #fff; }
.btnTable:hover{ color: #000 }
.ripple{ width: 0; height: 0; border-radius: 50%; background: rgba(62,26,6,0.1); transform: scale(0); position: absolute; opacity: 1; }
.disable{ white-space: nowrap; display: block; color: #AAAAAA/*9C9C9C*/; position: relative; padding: 15px 0 15px 15px; line-height: 17px; display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-align: center; -ms-flex-align: center; align-items: center; overflow: hidden; border-radius: 15px; text-transform: capitalize; }
.disable i{ font-size: 16px; margin-right: 10px; vertical-align: middle; width: 20px; display: inline-block; float: left; }
.disable span{ white-space: nowrap; padding: 0; display: inline-block; float: left; -webkit-transition: all 0.3s ease-out 0s; -moz-transition: all 0.3s ease-out 0s; -ms-transition: all 0.3s ease-out 0s; -o-transition: all 0.3s ease-out 0s; transition: all 0.3s ease-out 0s; transition: none; }
.btnDesactivar{ color: green; /*border: 1px solid darkgrey*/ } .btnDesactivar:hover{ color: red; /*border: 1px solid darkgreen*/ }
.btnActivar{ color: red; /*border: 1px solid darkgrey*/ } .btnActivar:hover{ color: green; /*border: 1px solid darkred*/ }
.btn-small { padding: 0.3rem 0.4rem; font-size: .875rem; line-height: 1.5; border-radius: 0.3rem; height: 30px; }
.text-small { font-size: 0.75rem }
.centraVert{ display:flex; align-items:center;/* justify-content: center;*/ }
.custom-control-input:checked~.custom-control-label::before { border-color: rgba(0,150,210,1); background-color: rgba(0,150,210,1); }
.custom-control-input:focus:not(:checked)~.custom-control-label::before { border-color: #adb5bd; }
.success { border: 1px solid #27b345; color: #000; }
#tablaEval th, #tablaEval tr, #tablaEval td{ font-size: 0.7rem }

@media(max-width: 1299px){
	body.sidebar-main .iq-sidebar {
		width: 260px; left: 0; z-index: 999;
		background: rgba(0,150,210,1);
		background: -moz-linear-gradient(left, rgba(0,150,210,1) 0%, rgba(81,209,246,1) 100%);
		background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,150,210,1)), color-stop(100%, rgba(81,209,246,1)));
		background: -webkit-linear-gradient(left, rgba(0,150,210,1) 100%) 0%, rgba(81,209,246,1) 100%);
		background: -o-linear-gradient(left, rgba(0,150,210,1) 0%, rgba(81,209,246,1) 100%);
		background: -ms-linear-gradient(left, rgba(0,150,210,1) 0%, rgba(81,209,246,1) 100%);
		background: linear-gradient(to right, rgba(0,150,210,1) 0%, rgba(81,209,246,1) 100%);
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0096d2', endColorstr='#51d1f6', GradientType=1);
	}
	.wrapper-menu{ color: rgba(18,167,240,1);
	*::-moz-selection { background: rgba(0,150,210,0.8); color: #fff; text-shadow: none; }
	::-moz-selection { background: rgba(0,150,210,0.8); color: #fff; text-shadow: none; }
	::selection { background: rgba(0,150,210,0.8); color: #fff; text-shadow: none; }
}
*::-moz-selection { background: rgba(0,150,210,0.8); color: #fff; text-shadow: none; }
::-moz-selection { background: rgba(0,150,210,0.8); color: #fff; text-shadow: none; }
::selection { background: rgba(0,150,210,0.8); color: #fff; text-shadow: none; }
</style>