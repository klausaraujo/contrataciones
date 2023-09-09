<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Main extends CI_Controller
{
	private $usuario;
	
    public function __construct()
	{
		parent::__construct();
		//$this->load->library('User');
		if($this->session->userdata('user')) $this->usuario = json_decode($this->session->userdata('user'));
		else header('location:' .base_url());
	}

    public function index(){}
	
	public function cajas(){
		header('location:'.base_url().'servicios');
	}
	public function listaOperaciones()
	{
		$anio = $this->input->post('anio'); $mes = $this->input->post('mes'); $sucursal = $this->input->post('sucursal');
		$this->load->model('Servicios_model'); $operaciones = [];
		$operaciones = $this->Servicios_model->listaOperacionesCaja(['idsucursal' => $sucursal,'SUBSTRING(fecha_movimiento,1,4)' => $anio,
				'SUBSTRING(fecha_movimiento,6,2)' => sprintf("%'02s",$mes)]);
		echo json_encode(['data' => $operaciones]);
	}
	public function nuevo()
	{
		if($this->uri->segment(1) === 'nuevacaja')header('location:' .base_url(). 'servicios/nuevo');
		else{
			$this->load->model('Servicios_model');
			$tipo = $this->Servicios_model->tipoOperacion(['combo_movimientos' => 1, 'activo' => 1]);
			$saldo = $this->Servicios_model->traeSaldo(['idsucursal' => ($this->input->get('suc')? $this->input->get('suc') : $this->usuario->sucursales[0]->idsucursal)]);
			$data = array('tipo' => $tipo,'saldo' => $saldo);
			
			if($this->uri->segment(2) === 'editar'){
				$id = $this->input->get('id');
				$serv = $this->Servicios_model->listaServicio(['lmc.idmovimiento' => $id]);
				$data['servicio'] = $serv;
			}
			$this->load->view('main',$data);
		}
	}
	public function registrar()
	{
		$this->session->set_flashdata('claseMsg', 'alert-danger');
		$this->load->model('Servicios_model'); $this->load->model('Proveedores_model');
		$tipo = $this->input->post('tipoCaja'); $mto = $this->input->post('monto'); $fecha = $this->input->post('fecha'); $suc = $this->input->post('sucursalCaja');
		$obs = $this->input->post('obs');$ruc = $this->input->post('rucvalor'); $razon = $this->input->post('razonSoc'); $tc = $this->input->post('tipoComp');
		$sc = $this->input->post('serie'); $nc = $this->input->post('num'); $bi = $this->input->post('base_imponible'); $igv = $this->input->post('imp_igv');
		$ir = $this->input->post('imp_renta'); $det = $this->input->post('detalle');
		
		/* Los checks recibidos */
		$checkrenta = $this->input->post('checkrenta')!== null? 1 : 0; $checkigv = $this->input->post('checkigv') !== null? 1 : 0;
		
		$factor = $this->Proveedores_model->factor(['destino' => 2,'idtipooperacion' => $tipo,'activo' => 1]);
		if($this->input->post('tiporegistro') === 'registrar'){
			$this->session->set_flashdata('flashMessage', 'No se pudo registrar la <b>Operaci&oacute;n</b>');
			$dataTran = array(
				'fecha' => $fecha,
				'vencimiento' => $fecha,
				'monto' => $mto,
				'activo' => 1,
			);
			$dataOp = array(
				'idtipooperacion' => $tipo,
				'idsucursal' => $suc,
				'monto' => $mto,
				'interes' => 0,
				'idfactor' => (!empty($factor)? $factor->idfactor : 1),
				'fecha_vencimiento' => $fecha,
				'fecha_movimiento' => $fecha,
				'idusuario_registro' => $this->usuario->idusuario,
				'fecha_registro' => $fecha,
				'observaciones' => $obs,
				'ruc_proveedor' => $ruc,
				'razon_social_proveedor' => $razon,
				'tipo_comprobante' => $tc,
				'serie_comprobante' => $sc,
				'numero_comprobante' => $nc,
				'base_imponible' => $bi,
				'impuesto_igv' => $igv,
				'check_igv' => $checkigv,
				'detalle_comprobante' => $det,
				'impuesto_renta' => $ir,
				'check_renta' => $checkrenta,
				'activo' => 1,
			);
			if($this->Servicios_model->movCaja($dataTran,$dataOp) > 0){
				$this->session->set_flashdata('flashMessage', '<b>Operaci&oacute;n</b> Registrada Exitosamente');
				$this->session->set_flashdata('claseMsg', 'alert-primary');
			}
		}elseif($this->input->post('tiporegistro') === 'editar'){
			
			$this->session->set_flashdata('flashMessage', 'No se pudo actualizar la <b>Operaci&oacute;n</b>');
			$dataTran = array('monto' => $mto);
			$dataOp = array(
				/*'idtipooperacion' => $tipo,
				'idsucursal' => $suc,*/
				'monto' => $mto,
				/*'idfactor' => (!empty($factor)? $factor->idfactor : 1),*/
				'fecha_movimiento' => $fecha,
				'idusuario_modificacion' => $this->usuario->idusuario,
				'observaciones' => $obs,
				'fecha_modificacion' => date('Y-m-d H:i:s'),
			);
			if($this->Servicios_model->editar($dataTran,$dataOp,['idtransaccion'=>$this->input->post('idtran')],['idmovimiento'=>$this->input->post('idmov')])){
				$this->session->set_flashdata('flashMessage', '<b>Operaci&oacute;n</b> Actualizada');
				$this->session->set_flashdata('claseMsg', 'alert-primary');
			}
		}
		
		header('location:'.base_url().'servicios');
	}
	public function anular()
	{
		$this->load->model('Servicios_model');
		$idmov = $this->input->get('id'); $status = 500; $msg = 'No se pudo anular la transacci&oacute;n'; $saldo = ''; $suc = $this->input->get('suc');
		
		$idtran = $this->Servicios_model->idTransaccion(['idmovimiento' => $idmov]);
		$anula = $this->Servicios_model->anular(['idmovimiento' => $idmov],['idtransaccion' => $idtran]);
		if($anula){
			$status = 200;
			$msg = 'Transacci&oacute;n anulada';
			$saldo = $this->Servicios_model->traeSaldo(['idsucursal' => $suc]);
		}
		$data = [
			'status' => $status,
			'message' => $msg,
			'saldo' => $saldo,
		];
		
		echo json_encode($data);
	}
	public function saldoCaja()
	{
		$this->load->model('Servicios_model');
		$suc = $this->input->post('sucursal');
		$saldo = $this->Servicios_model->traeSaldo(['idsucursal' => $suc]);
		
		echo floatval($saldo);
	}
	public function pdf_movCaja()
	{
		$this->load->model('Servicios_model');
		$versionphp = 7; $id = $this->input->get('id'); $a5 = 'A4'; $direccion = 'portrait';
		
		$mov = $this->Servicios_model->pdf(['idmovimiento' => $id]);
		$data = ['movimiento' => $mov];
		$html = $this->load->view('servicios/mov_caja-pdf', $data, true);
				
		if(floatval(phpversion()) < $versionphp){
			$this->load->library('dom');
			$this->dom->generate($direccion, $a5, $html, 'Comprobante');
		}else{
			$this->load->library('dom1');
			$this->dom1->generate($direccion, $a5, $html, 'Comprobante');
		}
	}
}