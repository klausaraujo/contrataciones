<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Main extends CI_Controller
{
	private $usuario;
	private $absolutePath;
	
    public function __construct()
	{
		parent::__construct();
		//$this->load->library('User');
		if($this->session->userdata('user')){
			$this->usuario = json_decode($this->session->userdata('user'));
			$this->absolutePath = $_SERVER['DOCUMENT_ROOT'].'/narsa/';
		}else header('location:' .base_url());
		//$this->output->enable_profiler(TRUE);
	}

    public function index(){}
	
	public function listaCertificaciones()
	{
		$this->load->model('Certificaciones_model');
		$anio = $this->input->post('anio'); $mes = $this->input->post('mes'); $sucursal = $this->input->post('sucursal'); $certificaciones = [];
		
		$certificaciones = $this->Certificaciones_model->listaCertificaciones(['c.idsucursal' => $sucursal,'SUBSTRING(fecha,1,4)' => $anio,
				'SUBSTRING(fecha,6,2)' => sprintf("%'02s",$mes), 'c.activo' => 1]);
		echo json_encode(['data' => $certificaciones]);
	}
	public function listaProveedores()
	{
		$this->load->library('datatables_server_side', array(
			'table' => 'proveedor',
			'primary_key' => 'idproveedor',
			'columns' => array('idproveedor', 'nombre', 'numero_documento','finca', 'altitud'),
			'where' => array('activo' => 1),
		));

		$this->datatables_server_side->process();
	}
	public function listaCatadores()
	{
		$this->load->library('datatables_server_side', array(
			'table' => 'catador',
			'primary_key' => 'idcatador',
			'columns' => array('idcatador','numero_documento','apellidos','nombres'),
			'where' => array('activo' => 1),
		));

		$this->datatables_server_side->process();
	}
	public function nuevo()
	{
		if($this->uri->segment(1) === 'nuevacertificacion')header('location:' .base_url(). 'certificaciones/nuevo');
		else{
			$this->load->model('Certificaciones_model');
			$id = ''; $certificado = null;
			$proveedores = $this->Certificaciones_model->proveedores();
			$proceso = $this->Certificaciones_model->proceso();
			$variedad = $this->Certificaciones_model->variedad();
						
			if($this->uri->segment(2) === 'editar'){
				$id = $this->input->get('id');
				$certificado = $this->Certificaciones_model->certificado(['idcertificado' => $id, 'c.activo' => 1]);
			}
			$data = array(
				'proveedores' => $proveedores,
				'proceso' => $proceso,
				'variedad' => $variedad,
				'id' => $id,
				'certificado' => $certificado,
			);
			$this->load->view('main',$data);
		}
	}
	public function registrarCertificado()
	{
		$this->load->model('Certificaciones_model');
		$status = 500; $message = 'No se pudo registrar el Certificado';
		$fecha = $this->input->post('fecha'); $anio = substr($fecha,0,4); $suc = $this->input->post('sucursalCert');
		
		$dataCert = array(
			'anio_certificado' => $anio,
			'fecha' => $fecha,
			'idsucursal' => $suc,
			'idproveedor' => $this->input->post('idproveedor'),
			'altitud' => $this->input->post('altitud'),
			'h2overde' => $this->input->post('h2o'),
			'idproceso' => $this->input->post('proceso'),
			'idvariedad' => $this->input->post('variedad'),
			'bourbon' => ($this->input->post('checkbourbon')? 1 : 0),
			'tipica' => ($this->input->post('checktipica')? 1 : 0),
			'caturra' => ($this->input->post('checkcaturra')? 1 : 0),
			'pache' => ($this->input->post('checkpache')? 1 : 0),
			'catimor' => ($this->input->post('checkcatimor')? 1 : 0),
			'catuai' => ($this->input->post('checkcatuai')? 1 : 0),
			'pacamara' => ($this->input->post('checkpacamara')? 1 : 0),
			'gesha' => ($this->input->post('checkgesha')? 1 : 0),
			'marcellesa' => ($this->input->post('checkmarcellesa')? 1 : 0),
			'gran_colombia' => ($this->input->post('checkcolombia')? 1 : 0),
			'costa_rica_95' => ($this->input->post('checkcosta')? 1 : 0),
			'tupo' => ($this->input->post('checktupo')? 1 : 0),
			'limani' => ($this->input->post('checklimani')? 1 : 0),
			'maragogipe' => ($this->input->post('checkmaragogipe')? 1 : 0),
			'otros' => ($this->input->post('checkotros')? 1 : 0),
			'otros_detalle' => ($this->input->post('checkotros')? $this->input->post('detalle_otros') : ''),
			'densidad' => $this->input->post('densidad'),
			'observaciones' => $this->input->post('obs'),
		);
		
		if($this->input->post('tiporegistro') === 'registrar'){
			$numero = $this->Certificaciones_model->numeroCert(['idsucursal'=>$suc,'anio_certificado'=>date('Y')]);
			$dataCert['numero'] = $numero;
			$dataCert['idusuario_registro'] = $this->usuario->idusuario;
			$dataCert['fecha_registro'] = date('Y-m-d H:i:s');
			$dataCert['activo'] = 1;

			if($this->Certificaciones_model->guardaCert($dataCert)){
				$this->session->set_flashdata('flashMessage', '<b>Certificado</b> Registrado Exitosamente');
				$this->session->set_flashdata('claseMsg', 'alert-primary');
			}
		}elseif($this->input->post('tiporegistro') === 'editar'){
			$dataCert['idusuario_modificacion'] = $this->usuario->idusuario;
			$dataCert['fecha_modificacion'] = date('Y-m-d H:i:s');
			
			if($this->Certificaciones_model->actualizaCert(['idcertificado' => $this->input->post('idcertificado')],$dataCert)){
				$this->session->set_flashdata('flashMessage', '<b>Certificado</b> Actualizado');
				$this->session->set_flashdata('claseMsg', 'alert-primary');
			}
		}
		
		header('location:'.base_url().'certificaciones');
	}
	public function parametros()
	{
		$this->load->model('Certificaciones_model');
		$this->load->model('Proveedores_model');
		$id = $this->input->get('id');
		$color = $this->Certificaciones_model->color();
		$olor = $this->Certificaciones_model->olor();
		$apariencia = $this->Certificaciones_model->apariencia();
		$quaker = $this->Certificaciones_model->quaker();
		$proveedor = $this->Certificaciones_model->traeDatosProv(['idcertificado' => $id]);
		$detalle = $this->Certificaciones_model->certificadoDetalle(['idcertificado' => $id, 'activo' => 1]);
		$catadores = $this->Certificaciones_model->traeCatadores(['idcertificado' => $id, 'cc.activo' => 1]);
		$tipodoc = $this->Proveedores_model->tipodoc();
				
		$data = array(
			'proveedor' => $proveedor,
			'color' => $color,
			'olor' => $olor,
			'apariencia' => $apariencia,
			'quaker' => $quaker,
			'idcertificado' => $id,
			'detalle' => $detalle,
			'catadores' => $catadores,
			'tipodoc' => $tipodoc
		);
		
		$this->load->view('main',$data);
	}
	public function fisico()
	{
		$this->load->model('Certificaciones_model');
		$id = $this->input->post('idcertificado'); $resp = 'No se pudo guardar';
		$hay = $this->Certificaciones_model->hayCertificado(['idcertificado' => $id]);
		
		if(!$hay){
			$data = array(
				'idcertificado' => $id,
				'idcolor' => $this->input->post('color'),
				'idolor' => $this->input->post('olor'),
				'olor' => $this->input->post('detolor'),
				'granumelometria_malla_general' => $this->input->post('malla_gen'),
				'granumelometria_malla_1620_nro' => $this->input->post('malla16'),
				'granumelometria_malla_1620_por' => $this->input->post('mallaporc'),
				'granumelometria_malla_15_nro' => $this->input->post('malla15'),
				'granumelometria_malla_15_por' => $this->input->post('malla15porc'),
				'granumelometria_malla_14_nro' => $this->input->post('malla14'),
				'granumelometria_malla_14_por' => $this->input->post('malla14porc'),
				'granumelometria_malla_base_nro' => $this->input->post('mallabase'),
				'granumelometria_malla_base_por' => $this->input->post('mallabaseporc'),
				'analisis_cafe_exportable_peso' => $this->input->post('pesocafe'),
				'analisis_cafe_exportable_por' => $this->input->post('cafeporc'),
				'analisis_sub_procuto_peso' => $this->input->post('pesosub'),
				'analisis_sub_procuto_por' => $this->input->post('subporc'),
				'analisis_descarte_peso' => $this->input->post('pesodesc'),
				'analisis_descarte_por' => $this->input->post('descporc'),
				'analisis_cascara_peso' => $this->input->post('pesocasc'),
				'analisis_cascara_por' => $this->input->post('cascporc'),
				'tostado_tiempo' => $this->input->post('tiempoTost'),
				'tostado_color_agtron' => $this->input->post('colorAg'),
				'tostado_perdida' => $this->input->post('porcPerdida'),
				'idapariencia' => $this->input->post('apariencia'),
				'idquaker' => $this->input->post('quaker'),
				'activo' => 1,
			);
			
			if($this->Certificaciones_model->guardaParametros($data)){
				$resp = 'Guardado exitosamente';
			}
		}else{
			$data = array(
				'idcolor' => $this->input->post('color'),
				'idolor' => $this->input->post('olor'),
				'olor' => $this->input->post('detolor'),
				'granumelometria_malla_general' => $this->input->post('malla_gen'),
				'granumelometria_malla_1620_nro' => $this->input->post('malla16'),
				'granumelometria_malla_1620_por' => $this->input->post('mallaporc'),
				'granumelometria_malla_15_nro' => $this->input->post('malla15'),
				'granumelometria_malla_15_por' => $this->input->post('malla15porc'),
				'granumelometria_malla_14_nro' => $this->input->post('malla14'),
				'granumelometria_malla_14_por' => $this->input->post('malla14porc'),
				'granumelometria_malla_base_nro' => $this->input->post('mallabase'),
				'granumelometria_malla_base_por' => $this->input->post('mallabaseporc'),
				'analisis_cafe_exportable_peso' => $this->input->post('pesocafe'),
				'analisis_cafe_exportable_por' => $this->input->post('cafeporc'),
				'analisis_sub_procuto_peso' => $this->input->post('pesosub'),
				'analisis_sub_procuto_por' => $this->input->post('subporc'),
				'analisis_descarte_peso' => $this->input->post('pesodesc'),
				'analisis_descarte_por' => $this->input->post('descporc'),
				'analisis_cascara_peso' => $this->input->post('pesocasc'),
				'analisis_cascara_por' => $this->input->post('cascporc'),
				'tostado_tiempo' => $this->input->post('tiempoTost'),
				'tostado_color_agtron' => $this->input->post('colorAg'),
				'tostado_perdida' => $this->input->post('porcPerdida'),
				'idapariencia' => $this->input->post('apariencia'),
				'idquaker' => $this->input->post('quaker'),
			);
			
			if($this->Certificaciones_model->actualizaParametros(['idcertificado' => $id],$data)){
				$resp = 'Guardado exitosamente';
			}
		}
		$data = array(
			'message' => $resp,
		);
		echo json_encode($data);
	}
	public function conteo()
	{
		$this->load->model('Certificaciones_model');
		$id = $this->input->post('idcertificado'); $resp = 'No se pudo guardar';
		$hay = $this->Certificaciones_model->hayCertificado(['idcertificado' => $id]);
		
		if(!$hay){
			$data = array(
				'idcertificado' => $id,
				'idcolor' => 1,
				'idolor' => 1,
				'idapariencia' => 1,
				'idquaker' => 1,
				'def_pri_negro_completo_num' => $this->input->post('nronegro'),
				'def_pri_negro_completo_equi' => $this->input->post('eqnegro'),
				'def_pri_agrio_completo_num' => $this->input->post('nroagrio'),
				'def_pri_agrio_completo_equi' => $this->input->post('eqagrio'),
				'def_pri_cereza_seca_num' => $this->input->post('nrocereza'),
				'def_pri_cereza_seca_equi' => $this->input->post('eqcereza'),
				'def_pri_danado_num' => $this->input->post('nrohongos'),
				'def_pri_danado_equi' => $this->input->post('eqhongos'),
				'def_pri_danado_severo_num' => $this->input->post('nroinsec'),
				'def_pri_danado_severo_equi' => $this->input->post('eqinsec'),
				'def_pri_materia_num' => $this->input->post('nroextr'),
				'def_pri_materia_equi' => $this->input->post('eqextr'),
				'def_sec_negro_parcial_num' => $this->input->post('nronegrop'),
				'def_sec_negro_parcial_equi' => $this->input->post('eqnegrop'),
				'def_sec_agrio_parcial_num' => $this->input->post('nroagriop'),
				'def_sec_agrio_parcial_equi' => $this->input->post('eqagriop'),
				'def_sec_pergamino_num' => $this->input->post('nroperg'),
				'def_sec_pergamino_equi' => $this->input->post('eqperg'),
				'def_sec_flotador_num' => $this->input->post('nroflot'),
				'def_sec_flotador_equi' => $this->input->post('eqflot'),
				'def_sec_inmaduro_num' => $this->input->post('nroinmad'),
				'def_sec_inmaduro_equi' => $this->input->post('eqinmad'),
				'def_sec_averanado_num' => $this->input->post('nroavera'),
				'def_sec_averanado_equi' => $this->input->post('eqavera'),
				'def_sec_concha_num' => $this->input->post('nroconc'),
				'def_sec_concha_equi' => $this->input->post('eqconc'),
				'def_sec_quebrado_num' => $this->input->post('nroqueb'),
				'def_sec_quebrado_equi' => $this->input->post('eqqueb'),
				'def_sec_cascara_num' => $this->input->post('nropul'),
				'def_sec_cascara_equi' => $this->input->post('eqpul'),
				'def_sec_insectos_num' => $this->input->post('nrolgins'),
				'def_sec_insectos_equi' => $this->input->post('eqlgins'),
				'activo' => 1,
			);
			
			if($this->Certificaciones_model->guardaParametros($data)){
				$resp = 'Guardado exitosamente';
			}
		}else{
			$data = array(
				'def_pri_negro_completo_num' => $this->input->post('nronegro'),
				'def_pri_negro_completo_equi' => $this->input->post('eqnegro'),
				'def_pri_agrio_completo_num' => $this->input->post('nroagrio'),
				'def_pri_agrio_completo_equi' => $this->input->post('eqagrio'),
				'def_pri_cereza_seca_num' => $this->input->post('nrocereza'),
				'def_pri_cereza_seca_equi' => $this->input->post('eqcereza'),
				'def_pri_danado_num' => $this->input->post('nrohongos'),
				'def_pri_danado_equi' => $this->input->post('eqhongos'),
				'def_pri_danado_severo_num' => $this->input->post('nroinsec'),
				'def_pri_danado_severo_equi' => $this->input->post('eqinsec'),
				'def_pri_materia_num' => $this->input->post('nroextr'),
				'def_pri_materia_equi' => $this->input->post('eqextr'),
				'def_sec_negro_parcial_num' => $this->input->post('nronegrop'),
				'def_sec_negro_parcial_equi' => $this->input->post('eqnegrop'),
				'def_sec_agrio_parcial_num' => $this->input->post('nroagriop'),
				'def_sec_agrio_parcial_equi' => $this->input->post('eqagriop'),
				'def_sec_pergamino_num' => $this->input->post('nroperg'),
				'def_sec_pergamino_equi' => $this->input->post('eqperg'),
				'def_sec_flotador_num' => $this->input->post('nroflot'),
				'def_sec_flotador_equi' => $this->input->post('eqflot'),
				'def_sec_inmaduro_num' => $this->input->post('nroinmad'),
				'def_sec_inmaduro_equi' => $this->input->post('eqinmad'),
				'def_sec_averanado_num' => $this->input->post('nroavera'),
				'def_sec_averanado_equi' => $this->input->post('eqavera'),
				'def_sec_concha_num' => $this->input->post('nroconc'),
				'def_sec_concha_equi' => $this->input->post('eqconc'),
				'def_sec_quebrado_num' => $this->input->post('nroqueb'),
				'def_sec_quebrado_equi' => $this->input->post('eqqueb'),
				'def_sec_cascara_num' => $this->input->post('nropul'),
				'def_sec_cascara_equi' => $this->input->post('eqpul'),
				'def_sec_insectos_num' => $this->input->post('nrolgins'),
				'def_sec_insectos_equi' => $this->input->post('eqlgins'),
			);
			
			if($this->Certificaciones_model->actualizaParametros(['idcertificado' => $id],$data)){
				$resp = 'Guardado exitosamente';
			}
		}
		$data = array(
			'message' => $resp,
		);
		echo json_encode($data);
	}
	public function sensorial()
	{
		$this->load->model('Certificaciones_model');
		$id = $this->input->post('idcertificado'); $resp = 'No se pudo guardar';
		$hay = $this->Certificaciones_model->hayCertificado(['idcertificado' => $id]);
			
		if(!$hay){
			$data = array(
				'idcertificado' => $id,
				'idcolor' => 1,
				'idolor' => 1,
				'idapariencia' => 1,
				'idquaker' => 1,
				'atributos_fragancia_puntos' => $this->input->post('fragptos'),
				'atributos_fragancia_caracteristicas' => $this->input->post('fragcaract'),
				'atributos_sabor_puntos' => $this->input->post('sabptos'),
				'atributos_sabor_caracteristicas' => $this->input->post('sabcaract'),
				'atributos_residual_puntos' => $this->input->post('sabreptos'),
				'atributos_residual_caracteristicas' => $this->input->post('sabrecaract'),
				'atributos_acidez_puntos' => $this->input->post('aciptos'),
				'atributos_acidez_caracteristicas' => $this->input->post('acicaract'),
				'atributos_cuerpo_puntos' => $this->input->post('cuerptos'),
				'atributos_cuerpo_caracteristicas' => $this->input->post('cuerpocaract'),
				'atributos_uniformidad_puntos' => $this->input->post('uniptos'),
				'atributos_uniformidad_caracteristicas' => $this->input->post('unicaract'),
				'atributos_balance_puntos' => $this->input->post('balptos'),
				'atributos_balance_caracteristicas' => $this->input->post('balcaract'),
				'atributos_taza_puntos' => $this->input->post('tazptos'),
				'atributos_taza_caracteristicas' => $this->input->post('tazcaract'),
				'atributos_dulzura_puntos' => $this->input->post('dulptos'),
				'atributos_dulzura_caracteristicas' => $this->input->post('dulcaract'),
				'atributos_apreciacion_puntos' => $this->input->post('apreptos'),
				'atributos_apreciacion_caracteristicas' => $this->input->post('aprecaract'),
				'atributos_numero_tasas' => $this->input->post('nrotazas'),
				'atributos_numero_intensidad' => $this->input->post('nrointensidad'),
				'atributos_defectos_sustraer' => $this->input->post('defsustraer'),
				'activo' => 1,
			);
			
			if($this->Certificaciones_model->guardaParametros($data)){
				$resp = 'Guardado exitosamente';
			}
		}else{
			$data = array(
				'atributos_fragancia_puntos' => $this->input->post('fragptos'),
				'atributos_fragancia_caracteristicas' => $this->input->post('fragcaract'),
				'atributos_sabor_puntos' => $this->input->post('sabptos'),
				'atributos_sabor_caracteristicas' => $this->input->post('sabcaract'),
				'atributos_residual_puntos' => $this->input->post('sabreptos'),
				'atributos_residual_caracteristicas' => $this->input->post('sabrecaract'),
				'atributos_acidez_puntos' => $this->input->post('aciptos'),
				'atributos_acidez_caracteristicas' => $this->input->post('acicaract'),
				'atributos_cuerpo_puntos' => $this->input->post('cuerptos'),
				'atributos_cuerpo_caracteristicas' => $this->input->post('cuerpocaract'),
				'atributos_uniformidad_puntos' => $this->input->post('uniptos'),
				'atributos_uniformidad_caracteristicas' => $this->input->post('unicaract'),
				'atributos_balance_puntos' => $this->input->post('balptos'),
				'atributos_balance_caracteristicas' => $this->input->post('balcaract'),
				'atributos_taza_puntos' => $this->input->post('tazptos'),
				'atributos_taza_caracteristicas' => $this->input->post('tazcaract'),
				'atributos_dulzura_puntos' => $this->input->post('dulptos'),
				'atributos_dulzura_caracteristicas' => $this->input->post('dulcaract'),
				'atributos_apreciacion_puntos' => $this->input->post('apreptos'),
				'atributos_apreciacion_caracteristicas' => $this->input->post('aprecaract'),
				'atributos_numero_tasas' => $this->input->post('nrotazas'),
				'atributos_numero_intensidad' => $this->input->post('nrointensidad'),
				'atributos_defectos_sustraer' => $this->input->post('defsustraer'),
			);
			
			if($this->Certificaciones_model->actualizaParametros(['idcertificado' => $id],$data)){
				$resp = 'Guardado exitosamente';
			}
		}
		
		//$graph = str_replace("data:image/png;base64,","", $graph);
		$ruta = $this->Certificaciones_model->traeRutaGrafico(['idcertificado' => $id]);
		$nombImg = $this->uploadGraph($ruta->nombre);
		
		$data = array(
			'message' => $resp,
			'grafico' => $nombImg,
		);
		echo json_encode($data);
	}
	public function catadores()
	{
		$this->load->model('Certificaciones_model');
		$resp = 'No se pudo guardar';
		
		$json = file_get_contents('php://input');
		// Converts it into a PHP object
		$data = json_decode($json);
		
		if($this->Certificaciones_model->guardaCatadores($data)){
			$resp = 'Guardado exitosamente';
		}
		
		$data = array( 'message' => $resp );
		
		echo json_encode($data);
	}
	public function regcatadores()
	{
		$this->load->model('Certificaciones_model');
		$resp = 'No se pudo registrar el catador'; $id = 0; $status = 500;
		
		$data = array(
			'idtipodocumento' => $this->input->post('tipodoc'),
			'numero_documento' => $this->input->post('doc'),
			'apellidos' => $this->input->post('apellidos'),
			'nombres' => $this->input->post('nombres'),
			'activo' => 1,
		);
		
		if($id = $this->Certificaciones_model->registraCatadores($data)){
			$resp = 'Catador registrado Exitosamente';
			$status = 200;
		}
		
		$data = array( 'message' => $resp, 'id' => $id, 'status' => $status );
		
		echo json_encode($data);
	}
	public function comprobante()
	{
		$this->load->model('Certificaciones_model');
		$id = $this->input->get('id'); $versionphp = 7;
		$detalle = $this->Certificaciones_model->detallePdf(['idcertificado' => $id, 'cd.activo' => 1]);
		$catadores = $this->Certificaciones_model->traeCatadores(['idcertificado' => $id, 'cc.activo' => 1]);
		$certificado = $this->Certificaciones_model->certificadopdf(['idcertificado' => $id, 'c.activo' => 1]);
		
		$data = array(
			'certificado' => $certificado,
			'detalle' => $detalle,
			'catadores' => $catadores,
		);
		$html = $this->load->view('certificaciones/comprobante',$data, true);
		if(floatval(phpversion()) < $versionphp){
			$this->load->library('dom');
			$this->dom->generate('portrait', 'A4', $html, 'Certificado');
		}else{
			$this->load->library('dom1');
			$this->dom1->generate('portrait', 'A4', $html, 'Certificado');
		}
	}
	public function anular()
	{
		$this->load->model('Certificaciones_model');
		$id = $this->input->get('id'); $resp = 'No se pudo Anular'; $status = 500;
		
		if($this->Certificaciones_model->anular(['idcertificado' => $id],['activo' => 0])){
			$resp = 'Se Anul&oacute; exitosamente';
			$status = 200;
		}
		
		$data = array(
			'message' => $resp,
			'status' => $status,
		);
		
		echo json_encode($data);
	}
	public function uploadGraph($nom)
	{
		$this->load->model('Certificaciones_model');
		$id = $this->input->post('idcertificado'); $graph = $this->input->post('grafico');
		
		$path = $this->absolutePath.'public/images/graficos/';
		$nom = 'graph'.$nom.'.png';
		
		$op = fopen($path.$nom, 'wb');
		$data = explode(',', $graph);
		fwrite($op, base64_decode($data[1]));
		fclose($op);
		
		/*$error_resize = 0;
		$config['image_library'] = 'gd2';
		$config['source_image'] = $path.$nom;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 350;
		$this->load->library('image_lib', $config);
		if(! $this->image_lib->resize()) $error_resize = $this->image_lib->display_errors();*/
		
		$ruta = $this->Certificaciones_model->saveNombreGraph(['idcertificado' => $id],['ruta_grafico' => $nom]);
		if($ruta) return $path.$nom;
		else return 'No se pudo guardar';
	}
}