<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
/* Controlador por defecto */
$route['default_controller'] = 'login';

/* Formulario de Login */
$route['login'] = 'login/login';
$route['dologin'] = 'login/doLogin';
$route['logout'] = 'login/logout';

/* Programacion en general */
$route['proveedores'] = 'main/proveedores';
$route['servicios'] = 'main/servicios';
$route['certificaciones'] = 'main/servicios';
$route['ventas'] = 'main/ventas';
$route['tostado'] = 'main/tostado';
$route['usuarios'] = 'main/usuarios';
$route['main/curl'] = 'main/curl';
$route['main/ruccurl'] = 'main/ruccurl';
$route['main/upload'] = 'main/upload';
$route['main/cambiapass'] = 'main/password';
$route['main/provincias'] = 'main/provincias';
$route['main/distritos'] = 'main/distritos';
$route['main/cargarLatLng'] = 'main/cargarLatLng';
/* Cambiar perfil del usuario */
$route['main/perfil'] = 'main/perfil';

/* Ventas */
$route['clientes'] = 'ventas/main/base';
$route['ventas/listaClientes'] = 'ventas/main/listaClientes';
$route['nuevocliente'] = 'ventas/main/nuevo';
$route['ventas/cliente/nuevo'] = 'ventas/main/nuevo';
$route['ventas/cliente/editar'] = 'ventas/main/nuevo';
$route['ventas/cliente/registrar'] = 'ventas/main/registrar';
$route['ventas/ventascliente'] = 'ventas/main/ventas';
$route['ventas/salidas/lista'] = 'ventas/main/listaVentas';
$route['ventas/ventascliente/nuevo'] = 'ventas/main/nuevaSalida';
$route['ventas/ventascliente/editar'] = 'ventas/main/editarSalida';
$route['ventas/ventascliente/anular'] = 'ventas/main/anularVenta';
$route['ventas/ventascliente/pdf'] = 'ventas/main/reporte';

/* Proveedores */
$route['proveedores/edocta'] = 'proveedores/main/edocta';
$route['proveedores/saldoSucursal'] = 'proveedores/main/saldoSucursal';
$route['proveedores/lista'] = 'proveedores/main/listaProveedores';
$route['nuevoproveedor'] = 'proveedores/main/nuevo';
$route['proveedores/nuevo'] = 'proveedores/main/nuevo';
$route['proveedores/editar'] = 'proveedores/main/nuevo';
$route['proveedores/registrar'] = 'proveedores/main/registrar';
$route['proveedores/transacciones'] = 'proveedores/main/transacciones';
$route['proveedores/transacciones/lista'] = 'proveedores/main/listaTransacciones';
$route['proveedores/transacciones/operaciones'] = 'proveedores/main/registraOp';
$route['proveedores/transacciones/impresion'] = 'proveedores/main/informes';
$route['proveedores/transacciones/anular'] = 'proveedores/main/anulaOp';
$route['proveedores/transacciones/edo_cta'] = 'proveedores/main/informes';
$route['proveedores/ingresos/guia_ingreso'] = 'proveedores/main/informes';
$route['proveedores/ingresos/lista'] = 'proveedores/main/listaIngresos';
$route['proveedores/ingresos/nuevo'] = 'proveedores/main/nuevoIngreso';
$route['proveedores/ingresos/anular'] = 'proveedores/main/anulaOp';
$route['proveedores/ingresos/editar'] = 'proveedores/main/editaingreso';
$route['proveedores/valorizaciones/listaDetalle'] = 'proveedores/main/listaValorizacionDetalle';
$route['proveedores/valorizaciones/nuevo'] = 'proveedores/main/registrarValorizacion';
$route['proveedores/valorizaciones/lista'] = 'proveedores/main/listaValorizaciones';
$route['proveedores/valorizaciones/anular'] = 'proveedores/main/anulaOp';
$route['proveedores/valorizaciones/valoriz_pdf'] = 'proveedores/main/informes';
$route['proveedores/ingresos/comprobante'] = 'proveedores/main/informes';
$route['proveedores/cobros/lista'] = 'proveedores/main/listaCobros';
$route['proveedores/pagos/lista'] = 'proveedores/main/listaPagos';
$route['proveedores/pagosVal/lista'] = 'proveedores/main/listaPagosVal';
$route['proveedores/reporte1'] = 'proveedores/reportes/nuevoreporte';
$route['proveedores/reporte2'] = 'proveedores/reportes/nuevoreporte';
$route['proveedores/reporte3'] = 'proveedores/reportes/nuevoreporte';
$route['proveedores/reporte4'] = 'proveedores/reportes/nuevoreporte';
$route['proveedores/reporte5'] = 'proveedores/reportes/nuevoreporte';
$route['proveedores/reporte6'] = 'proveedores/reportes/nuevoreporte';
$route['proveedores/reporte7'] = 'proveedores/reportes/nuevoreporte';
$route['proveedores/reporte8'] = 'proveedores/reportes/nuevoreporte';
$route['proveedores/reporte9'] = 'proveedores/reportes/nuevoreporte';
$route['proveedores/reporte10'] = 'proveedores/reportes/nuevoreporte';
$route['proveedores/tblreporte1'] = 'proveedores/reportes/tblreporte1';
$route['proveedores/pruebas'] = 'proveedores/main/pruebas';
$route['proveedores/reportes/pdf'] = 'proveedores/reportes/pdf';
$route['proveedores/reportes/excel'] = 'proveedores/reportes/excel';

/* Servicios */
$route['servicios/lista'] = 'servicios/main/listaOperaciones';
$route['nuevacaja'] = 'servicios/main/nuevo';
$route['servicios/nuevo'] = 'servicios/main/nuevo';
$route['servicios/editar'] = 'servicios/main/nuevo';
$route['servicios/registrar'] = 'servicios/main/registrar';
$route['cajas'] = 'servicios/main/cajas';
$route['servicios/saldo'] = 'servicios/main/saldoCaja';
$route['servicios/anular'] = 'servicios/main/anular';
$route['servicios/comprobante'] = 'servicios/main/pdf_movCaja';

/* Certificado */
$route['certificaciones/lista'] = 'certificaciones/main/listaCertificaciones';
$route['nuevacertificacion'] = 'certificaciones/main/nuevo';
$route['certificaciones/nuevo'] = 'certificaciones/main/nuevo';
$route['certificaciones/editar'] = 'certificaciones/main/nuevo';
$route['certificaciones/comp_pdf'] = 'certificaciones/main/comprobante';
$route['certificaciones/proveedores'] = 'certificaciones/main/listaProveedores';
$route['certificaciones/registrar'] = 'certificaciones/main/registrarCertificado';
$route['certificaciones/parametros'] = 'certificaciones/main/parametros';
$route['certificaciones/parametros/fisico'] = 'certificaciones/main/fisico';
$route['certificaciones/parametros/conteo'] = 'certificaciones/main/conteo';
$route['certificaciones/parametros/sensorial'] = 'certificaciones/main/sensorial';
$route['certificaciones/anular'] = 'certificaciones/main/anular';//Anular
$route['certificaciones/parametros/listacatadores'] = 'certificaciones/main/listaCatadores';
$route['certificaciones/parametros/catadores'] = 'certificaciones/main/catadores';
$route['certificaciones/parametros/registrarcatador'] = 'certificaciones/main/regcatadores';

/* Tostado */
$route['tostado/lista'] = 'tostado/main/listaTostado';
$route['nuevotostado'] = 'tostado/main/nuevo';
$route['tostado/nuevo'] = 'tostado/main/nuevo';
$route['tostado/editar'] = 'tostado/main/nuevo';
$route['tostado/registrar'] = 'tostado/main/registrar';
$route['tostado/proveedor/registrar'] = 'tostado/main/regProveedor';
$route['tostado/anular'] = 'tostado/main/anular';
$route['tostado/comprobante'] = 'tostado/main/pdfTostado';
$route['tostado/operaciones'] = 'tostado/main/operaciones';
$route['tostado/operaciones/listaoptostado'] = 'tostado/main/listaoptostado';
$route['tostado/operaciones/tostado'] = 'tostado/main/optostado';
$route['tostado/operaciones/trillado'] = 'tostado/main/optrillado';
$route['tostado/operaciones/despacho'] = 'tostado/main/opdespacho';


/* Usuarios */
$route['usuarios/lista'] = 'usuarios/main/listaUsuarios';
$route['nuevousuario'] = 'usuarios/main/nuevo';
$route['usuarios/nuevo'] = 'usuarios/main/nuevo';
$route['usuarios/editar'] = 'usuarios/main/nuevo';
$route['usuarios/registrar'] = 'usuarios/main/registrar';
$route['usuarios/habilitar'] = 'usuarios/main/habilitar';
$route['usuarios/reset'] = 'usuarios/main/resetear';
$route['usuarios/permisos'] = 'usuarios/main/permisosUsuario';
$route['usuarios/permisos/asignar'] = 'usuarios/main/asignarPermisos';
$route['usuarios/sucursales'] = 'usuarios/main/sucursalesUsuario';
$route['usuarios/sucursales/asignar'] = 'usuarios/main/asignarSucursales';

/**/
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
