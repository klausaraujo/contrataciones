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
	
	public function listaProveedores()
	{
		$this->load->model('Proveedores_model');
		$proveedores = $this->Proveedores_model->listaProveedores();
		echo json_encode(['data'=>$proveedores]);
	}
	public function nuevo()
	{
		if($this->uri->segment(1) === 'nuevoproveedor')header('location:' .base_url(). 'proveedores/nuevo');
		else{
			$this->load->model('Proveedores_model');
			$tipodoc = $this->Proveedores_model->tipodoc();
			$dep = $this->Proveedores_model->departamentos();
			$pro = null; $dis = null; $proveedor = [];
			$data = array( 'tipodoc' => $tipodoc, 'dep' => $dep );
			
			if($this->uri->segment(2) === 'editar'){
				$id = $this->input->get('id');
				$proveedor = $this->Proveedores_model->listaProveedor(['idproveedor' => $id]);
				$pro = !empty($proveedor)? $this->Proveedores_model->provincias(['cod_dep'=>substr($proveedor->ubigeo,0,2)]) : array();
				$dis = !empty($proveedor)? $this->Proveedores_model->distritos(['cod_dep'=>substr($proveedor->ubigeo,0,2),'cod_pro'=>substr($proveedor->ubigeo,2,2)]) : array();
				$data['proveedor'] = $proveedor;
				$data['pro'] = $pro;
				$data['dis'] = $dis;
			}
			
			$data['lat'] = !empty($proveedor)? $proveedor->latitud : 42.1382114;
			$data['lng'] = !empty($proveedor)? $proveedor->longitud : -71.5212585;
			//echo substr($proveedor->ubigeo,0,2).'  '.substr($proveedor->ubigeo,2,2).'  '.substr($proveedor->ubigeo,4,2);
			
			$this->load->view('main',$data);
		}
	}
	public function registrar()
	{
		$this->session->set_flashdata('claseMsg', 'alert-danger');
		$this->load->model('Proveedores_model');
		$ubigeo = $this->input->post('dep').$this->input->post('pro').$this->input->post('dis');
		$lat = $this->input->post('lat'); $lng = $this->input->post('lng');
		
		if($this->input->post('tiporegistro') === 'registrar'){
			//if($this->input->post('tipodoc') != '' && $this->input->post('doc') != '' && $this->input->post('nombres') != '' && $this->input->post('direccion') != ''){
			$this->session->set_flashdata('flashMessage', 'No se pudo registrar el <b>Proveedor</b>');
			$data = array(
				'idtipodocumento' => $this->input->post('tipodoc'),
				'numero_documento' => $this->input->post('doc'),
				'RUC' => $this->input->post('ruc'),
				'nombre' => $this->input->post('nombres'),
				'domicilio' => $this->input->post('direccion'),
				'celular' => $this->input->post('celular'),
				'correo' => $this->input->post('email'),
				'ubigeo' => $ubigeo,
				'latitud' => $lat,
				'longitud' => $lng,
				'zona' => $this->input->post('zona'),
				'finca' => $this->input->post('finca'),
				'altitud' => $this->input->post('altitud'),
				'activo' => 1,
			);
			if($this->Proveedores_model->registrar($data)){
				$this->session->set_flashdata('flashMessage', '<b>Proveedor</b> Registrado Exitosamente');
				$this->session->set_flashdata('claseMsg', 'alert-primary');
			}
			//}else{ $this->session->set_flashdata('flashMessage', 'Campos Vac&iacute;os'); }
				
		}elseif($this->input->post('tiporegistro') === 'editar'){
			$id = $this->input->post('idproveedor');
			$this->session->set_flashdata('flashMessage', 'No se pudo actualizar el <b>Proveedor</b>');
			
			$data = array(
				'RUC' => $this->input->post('ruc'),
				'domicilio' => $this->input->post('direccion'),
				'celular' => $this->input->post('celular'),
				'correo' => $this->input->post('email'),
				'ubigeo' => $ubigeo,
				'latitud' => $lat,
				'longitud' => $lng,
				'zona' => $this->input->post('zona'),
				'finca' => $this->input->post('finca'),
				'altitud' => $this->input->post('altitud'),
			);
			
			if($this->Proveedores_model->editar( $data, ['idproveedor'=>$id] )){
				$this->session->set_flashdata('flashMessage', '<b>Proveedor</b> Actualizado');
				$this->session->set_flashdata('claseMsg', 'alert-primary');
			}
		}
		header('location:'.base_url().'proveedores');
	}
	public function transacciones()
	{
		$this->load->model('Proveedores_model');
		$id = $this->input->get('id');
		$hOperaciones = array(
			'0'=>['title' => 'Acciones', 'targets' => 0],'1'=>['title' => 'Oper.', 'targets' => 1],'2'=>['title' => 'Fecha', 'targets' => 2],
			'3'=>['title' => 'Tipo Operaci&oacute;n', 'targets' => 3],'4'=>['title' => 'Sucursal', 'targets' => 4],'5'=>['title' => 'Productor', 'targets' => 5],
			'6'=>['title' => 'Monto', 'targets' => 6],'7'=>['title' => 'Inter&eacute;s', 'targets' => 7],'8'=>['title' => 'Tasa(%)', 'targets' => 8],
			'9'=>['title' => 'Inter&eacute;s Pagado', 'targets' => 9],'10'=>['targets' => 4, 'visible' => false],
			/*'9'=>['title' => 'Inter&eacute;s Pagado', 'targets' => 9],'10'=>['targets' => 'no-sort', 'orderable' => false],*/
		);
		$hIngresos = array(
			'0'=>['title' => 'Acciones', 'targets' => 0],'1'=>['title' => 'Oper.', 'targets' => 1],'2'=>['title' => 'Nro. Gu&iacute;a', 'targets' => 2],
			'3'=>['title' => 'Fecha Gu&iacute;a', 'targets' => 3],'4'=>['title' => 'Productor', 'targets' => 4],'5'=>['title' => 'Sucursal', 'targets' => 5],
			'6'=>['title' => 'Cantidad', 'targets' => 6],'7'=>['targets' => 'no-sort', 'orderable' => false]
			
		);
		$hValorizaciones = array(
			'0'=>['title' => 'Acciones', 'targets' => 0],'1'=>['title' => 'ID', 'targets' => 1],'2'=>['title' => 'A&ntilde;o', 'targets' => 2],
			'3'=>['title' => 'Oper.', 'targets' => 3],'4'=>['title' => 'Fecha', 'targets' => 4],'5'=>['title' => 'Proveedor', 'targets' => 5],
			'6'=>['title' => 'Sucursal', 'targets' => 6],'7'=>['title' => 'Monto', 'targets' => 7],'8'=>['title' => 'Estado', 'targets' => 8],
			'9'=>['targets' => 'no-sort', 'orderable' => false],'10'=>['targets' => 1, 'visible' => false],'11'=>['targets' => 2, 'visible' => false],
			'12'=>['targets' => 8, 'visible' => false],
		);
		$tipo = $this->Proveedores_model->tipoOperacion(['combo_movimientos'=> 1,'activo' => 1]);
		$articulos = $this->Proveedores_model->listaArticulos(['activo' => 1]);
		$edocta = $this->Proveedores_model->traeEdoCta(['idproveedor'=>$id, 'idsucursal' => $this->usuario->sucursales[0]->idsucursal]);
		$saldo = $this->saldoCaja($this->usuario->sucursales[0]->idsucursal);
		
		$data = array(
			'tipo_op' => $tipo,
			'articulos' => $articulos,
			'headersOp' => $hOperaciones,
			'headersIng' => $hIngresos,
			'headersVal' => $hValorizaciones,
			'edocta' => $edocta,
			'saldo' => $saldo,
		);
		$this->load->view('main',$data);
	}
	public function listaTransacciones()
	{
		$this->load->model('Proveedores_model');
		
		$id = $this->input->post('id'); $suc = $this->input->post('sucursal'); $tipo = $this->input->post('tipoop') !== null? $this->input->post('tipoop') : '';
		$data = [];
		
		if($tipo === '' || $tipo === '9') $data = [ 'idproveedor' => $id, 'idsucursal' => $suc ];
		else $data = [ 'idproveedor' => $id, 'idsucursal' => $suc, 'idtipooperacion' => $tipo ];
		
		$lista = $this->Proveedores_model->listaOperaciones($data);
		/*$filtro = []; $i = 0;
			
		foreach($this->usuario->sucursales as $sucursal):
			foreach($lista as $row):
				if($row->idsucursal === $sucursal->idsucursal){
					$filtro[$i] = $row;
					$i++;
				}
			endforeach;			
		endforeach;*/
		
		echo json_encode(['data' => $lista]);
	}
	public function listaIngresos()
	{
		$this->load->model('Proveedores_model');
		
		$id = $this->input->post('id');
		$lista = $this->Proveedores_model->listaIngresos(['ge.idproveedor' => $id,'ge.activo' => 1]);
		$filtro = []; $i = 0;
		
		foreach($this->usuario->sucursales as $sucursal):
			foreach($lista as $row):
				if($row->idsucursal === $sucursal->idsucursal){
					$filtro[$i] = $row;
					$valoriz = $this->Proveedores_model->tieneValorizacion(['idguia' => $row->idguia,'activo' => '1']);
					if($valoriz->num_rows() > 0) $filtro[$i]->anula = '0';
					else $filtro[$i]->anula = '1';
					$i++;
				}
			endforeach;			
		endforeach;
		
		echo json_encode(['data' => $filtro]);
	}
	public function listaValorizaciones()
	{
		$this->load->model('Proveedores_model');
		
		$id = $this->input->post('id');
		$lista = $this->Proveedores_model->listaValorizaciones(['va.idproveedor' => $id,'va.activo' => 1]);
		$filtro = []; $i = 0;
		
		foreach($this->usuario->sucursales as $sucursal):
			foreach($lista as $row):
				if($row->idsucursal === $sucursal->idsucursal){
					$filtro[$i] = $row;
					$i++;
				}
			endforeach;			
		endforeach;
		
		echo json_encode(['data' => $filtro]);
	}
	public function listaValorizacionDetalle()
	{
		$this->load->model('Proveedores_model');
		
		$id = $this->input->post('id'); $suc = $this->input->post('suc');
		$lista = $this->Proveedores_model->listaValorizacionDetalle(['idproveedor' => $id, 'idsucursal' => $suc,'cantidad >' => 0]);
		$filtro = []; $i = 0;
		
		foreach($lista as $row):
			//if($row->idsucursal === $suc){
			$costo = $this->Proveedores_model->costoValoriz(['idguia'=>$row->idguia,'idarticulo'=>$row->idarticulo]);
			$filtro[$i] = $row;
			$filtro[$i]->costo = !empty($costo)? $costo[0]->costo : 0;
			$i++;
			//}		
		endforeach;
		
		echo json_encode(['data' => $filtro]);
	}
	public function listaCobros()
	{
		$this->load->model('Proveedores_model');
		
		$id = $this->input->post('id'); $suc = $this->input->post('sucursal'); $tipo = $this->input->post('tipoop') !== null? $this->input->post('tipoop') : '';
		
		if($tipo !== ''){
			$lista = $this->Proveedores_model->listaOperaciones(['idproveedor' => $id, 'idsucursal' => $suc, 'idtipooperacion' => 1, 'liquidado' => 0]);
			echo json_encode(['data' => $lista]);
		}else{
			echo json_encode(['data'=>array()]);
		}
	}
	public function listaPagos()
	{
		$this->load->model('Proveedores_model');
		
		$id = $this->input->post('id'); $suc = $this->input->post('sucursal'); $tipo = $this->input->post('tipoop') !== null? $this->input->post('tipoop') : '';
		
		if($tipo !== ''){
			$data = 'idproveedor ='.$id.' AND idsucursal='.$suc.' AND liquidado=0 AND (idtipooperacion=7 OR idtipooperacion=9)';
			$lista = $this->Proveedores_model->listaOperacionesPagos($data);
			echo json_encode(['data' => $lista]);
		}else{
			echo json_encode(['data'=>array()]);
		}
	}
	public function listaPagosVal()
	{
		$this->load->model('Proveedores_model');
		
		$id = $this->input->post('id'); $suc = $this->input->post('sucursal'); $tipo = $this->input->post('tipoop') !== null? $this->input->post('tipoop') : '';
		
		if($tipo !== ''){
			$lista = $this->Proveedores_model->listaOperaciones(['idproveedor' => $id, 'idsucursal' => $suc, 'idtipooperacion' => 6, 'liquidado' => 0]);
			echo json_encode(['data' => $lista]);
		}else{
			echo json_encode(['data'=>array()]);
		}
	}
	public function edocta()
	{
		$this->load->model('Proveedores_model');
		$id = $this->input->post('id'); $suc = $this->input->post('sucursal');
		$edocta = $this->Proveedores_model->traeEdoCta(['idproveedor'=>$id, 'idsucursal' => $suc]);
		
		echo floatVal($edocta);
	}
	public function saldoCaja($suc)
	{
		$this->load->model('Servicios_model');
		$saldo = $this->Servicios_model->traeSaldo(['idsucursal' => $suc]);
		
		return floatval($saldo);
	}
	public function saldoSucursal()
	{
		echo $this->saldoCaja($this->input->post('idsucursal'));
	}
	public function registraOp()
	{
		$this->load->model('Proveedores_model');
		// Mensajes devueltos por el servidor
		$status = 500; $message = 'No se pudo registrar la Transacci&oacute;n';
		// Variables generales de los 3 modulos
		$idproveedor = $this->input->post('idproveedor'); $suc = $this->input->post('sucursal'); $tipoop = $this->input->post('tipoop');
		$detalletipo = $this->input->post('tipodetalle'); $obs = $this->input->post('obstransacciones'); $fecha = date('Y-m-d H:i:s'); $check = 0; $inttotal = 0;
		
		// Campos del modulo prestamos
		$vence = date('Y-m-d'); $monto = 0; $interes = 0;
		// Variables de los modulos pagos
		$prestamo = 0;
		
		if($tipoop === '1' || $tipoop === '7'){
			$monto = $this->input->post('monto'); $vence = $this->input->post('fechavenc');
			$interes = $this->input->post('interes') !== null && floatval($this->input->post('interes')) > 0? floatval($this->input->post('interes')) : 0;
		}elseif($tipoop === '2'){
			$prestamo = $this->input->post('mtopago'); $monto = $this->input->post('montopago'); $check = $this->input->post('checkliquidapago')!== null? 1 : 0;
			$inttotal = is_numeric(floatval($this->input->post('interespago')))? floatval($this->input->post('interespago')) : 0;
		}elseif($tipoop === '3'){
			$prestamo = $this->input->post('mtoprestamo'); $monto = $this->input->post('montocobro'); $check = $this->input->post('checkliquida')!== null? 1 : 0;
			$inttotal = is_numeric(floatval($this->input->post('interescobro')))? floatval($this->input->post('interescobro')) : 0;
		}elseif($tipoop === '9'){
			$monto = $this->input->post('montoanterior'); $detalletipo = 'ESTADO DE CUENTA ANTERIOR PROVEEDOR';
		}elseif($tipoop === '10'){
			$prestamo = $this->input->post('mtoval');
			$monto = $this->input->post('montovalor'); $detalletipo = 'PAGO DE VALORIZACIONES A PROVEEDORES'; $check = $this->input->post('checkliquidaval')!== null? 1 : 0;
		}
		
		// Obtener el factor del tipo de operacion de proveedor
		$factor = $this->Proveedores_model->factor(['destino' => 1,'idtipooperacion'=>$tipoop,'activo' => 1]);
		// Array del registro de la transaccion en la base
		$dataTransaccion = array(
			'fecha' => $fecha,
			'vencimiento' => $vence,
			'monto' => floatval($monto) + floatval($inttotal),
			'activo' => 1,
		);
		// Array del registro del movimiento del proveedor en la base
		$dataOp = array(
			'idtipooperacion' => $tipoop,
			'idsucursal' => $suc,
			'idproveedor' => $idproveedor,
			'monto' => $monto,
			'interes' => $interes,
			'liquidado' => $check,
			'interes_total' => $inttotal,
			'observaciones' => $obs,
			'idfactor' => (!empty($factor)? $factor->idfactor : 1),
			'fecha_vencimiento' => $vence,
			'fecha_movimiento' => $fecha,
			'idusuario_registro' => $this->usuario->idusuario,
			'fecha_registro' => $fecha,
			'activo' => 1,
		);
		
		if($tipoop === '1' || $tipoop === '7'){
			if($idtran = $this->Proveedores_model->registrarOp($dataTransaccion,'transacciones')){
				$dataOp['idtransaccion'] = $idtran;
				if($this->Proveedores_model->registrarOp($dataOp,'movimientos_proveedor')){
					$dataOp = $this->dataMovCaja($dataOp, $detalletipo);
					if($this->Proveedores_model->registrarOp($dataOp,'movimientos_caja')){ $status = 200; $message = 'Transacci&oacute;n registrada exitosamente'; }
				}
			}
		}elseif($tipoop === '2' || $tipoop === '3' || $tipoop === '10'){
			if($tipoop === '2'){
				// ID de la transaccion a actualizar
				$trans = $this->input->post('idpago'); $interes = $this->input->post('tasapago');
			}elseif($tipoop === '3'){
				// ID de la transaccion a actualizar
				$trans = $this->input->post('idprestamo'); $interes = $this->input->post('tasaprestamo');
			}elseif($tipoop === '10'){
				// ID de la transaccion a actualizar
				$trans = $this->input->post('idvalor');
			}
			
			if($check > 0){
				if($idtran = $this->Proveedores_model->registrarOp($dataTransaccion, 'transacciones')){
					$dataOp['idtransaccion'] = $idtran;
					if($this->Proveedores_model->registrarOp($dataOp, 'movimientos_proveedor')){
						$dataOp['monto'] = floatval($monto) + floatval($inttotal);
						$dataOp = $this->dataMovCaja($dataOp, $detalletipo);
						if($this->Proveedores_model->registrarOp($dataOp, 'movimientos_caja')){
							// Variables para actualizar el movimiento anterior
							$campos = [
								'liquidado' => 1, 'interes_total' => $inttotal, 'fecha_movimiento' => date('Y-m-d H:i:s'),
								'idusuario_modificacion' => $this->usuario->idusuario, 'fecha_modificacion' => date('Y-m-d H:i:s')
							];
							if($this->Proveedores_model->actMovProv(['idtransaccion' => $trans], $campos, 'movimientos_proveedor')){
								unset($campos['interes_total']); unset($campos['liquidado']);
								if($this->Proveedores_model->actMovProv(['idtransaccion' => $trans], $campos, 'movimientos_caja')){
									$status = 200; $message = 'Transacci&oacute;n registrada exitosamente';
								}
							}
						}
					}
				}
			}else{
				$guardado = false;
				if(floatval($monto) > 0){
					if($idtran = $this->Proveedores_model->registrarOp($dataTransaccion, 'transacciones')){
						$dataOp['idtransaccion'] = $idtran;
						if($this->Proveedores_model->registrarOp($dataOp, 'movimientos_proveedor')){
							$dataOp['monto'] = floatval($monto) + floatval($inttotal);
							$dataOp = $this->dataMovCaja($dataOp, $detalletipo);
							if($this->Proveedores_model->registrarOp($dataOp, 'movimientos_caja')){ $guardado = true; }
						}
					}
					if($guardado){
						// Se actualizan las tablas con los montos parciales si no es una valorizacion
						if($this->Proveedores_model->actMovProv(['idtransaccion' => $trans], ['monto' => $monto], 'transacciones')){
							$campos = [
								'monto' => $monto, 'liquidado' => 1, 'interes_total' => $inttotal, 'fecha_movimiento' => date('Y-m-d H:i:s'),
								'idusuario_modificacion' => $this->usuario->idusuario, 'fecha_modificacion' => date('Y-m-d H:i:s')
							];
							if($this->Proveedores_model->actMovProv(['idtransaccion' => $trans], $campos, 'movimientos_proveedor')){
								if($tipoop === '2' || $tipoop === '3'){
									unset($campos['interes_total']); unset($campos['liquidado']);
									$this->Proveedores_model->actMovProv(['idtransaccion' => $trans], $campos, 'movimientos_caja');
								}
							}
						}
						// Variables para el registro de una nueva op por el monto restante
						$tipoop = $this->input->post('idtipoop_p'); $detalletipo = $tipoop === '9'? 'ESTADO DE CUENTA ANTERIOR PROVEEDOR' : $this->input->post('tipoop_p');
						// Factor para registrar la nueva operacion anterior parcial
						$factor = $this->Proveedores_model->factor(['destino'=>1,'idtipooperacion'=>$tipoop,'activo'=>1]);
						// Setear valores para la nueva op parcial
						$dataOp['idfactor'] = !empty($factor)? $factor->idfactor : 1; $dataOp['idtipooperacion'] = $tipoop;
						$monto = floatval($prestamo) - floatval($monto); $dataOp['interes_total'] = 0; $dataTransaccion['monto'] = $monto; $dataOp['monto'] = $monto;
						$dataOp['interes'] = $interes; $dataOp['idproveedor'] = $idproveedor; $dataOp['liquidado'] = 0;
						
						// Registra la nueva operacion parcial si no es un pago de valorizacion
						if($idtran = $this->Proveedores_model->registrarOp($dataTransaccion, 'transacciones')){
							$dataOp['idtransaccion'] = $idtran;
							if($this->Proveedores_model->registrarOp($dataOp, 'movimientos_proveedor')){
								if($tipoop === '2' || $tipoop === '3'){
									$dataOp = $this->dataMovCaja($dataOp, $detalletipo);
									if($this->Proveedores_model->registrarOp($dataOp, 'movimientos_caja')){
										$status = 200; $message = 'Transacci&oacute;n registrada exitosamente';
									}
								}else{
									$status = 200; $message = 'Transacci&oacute;n registrada exitosamente';
								}
							}
						}
					}
				}else{
					if(floatval($inttotal > 0)){
						if($idtran = $this->Proveedores_model->registrarOp($dataTransaccion, 'transacciones')){
							$dataOp['idtransaccion'] = $idtran; $dataOp['interes_total'] = $inttotal; $dataOp['monto'] = 0;
							if($this->Proveedores_model->registrarOp($dataOp, 'movimientos_proveedor')){
								$dataOp['monto'] = $inttotal;
								$dataOp = $this->dataMovCaja($dataOp, $detalletipo);
								if($this->Proveedores_model->registrarOp($dataOp, 'movimientos_caja')){ $guardado = true; }
							}
						}
						if($guardado){
							$campos = [
								'interes_total' => $inttotal, 'fecha_movimiento' => date('Y-m-d H:i:s'), 'idusuario_modificacion' => $this->usuario->idusuario,
								'fecha_modificacion' => date('Y-m-d H:i:s')
							];
							if($this->Proveedores_model->actMovProv(['idtransaccion' => $trans], $campos, 'movimientos_proveedor')){
								unset($campos['interes_total']);
								if($this->Proveedores_model->actMovProv(['idtransaccion' => $trans], $campos, 'movimientos_caja')){
									$status = 200; $message = 'Transacci&oacute;n registrada exitosamente';
								}
							}
							
						}
					}
				}
			}
		}elseif($tipoop === '9'){
			if($idtran = $this->Proveedores_model->registrarOp($dataTransaccion,'transacciones')){
				$dataOp['idtransaccion'] = $idtran;
				if($this->Proveedores_model->registrarOp($dataOp,'movimientos_proveedor')){
					$dataOp = $this->dataMovCaja($dataOp, $detalletipo);
					if($this->Proveedores_model->registrarOp($dataOp,'movimientos_caja')){ $status = 200; $message = 'Transacci&oacute;n registrada exitosamente'; }
				}
			}
		}
		
		$edocta = $this->Proveedores_model->traeEdoCta(['idproveedor' => $idproveedor, 'idsucursal' => $suc]);
		
		$data = array(
			'status' => $status,
			'message' => $message,
			'edocta' => $edocta,
		);
		
		echo json_encode($data);
	}
	public function dataMovCaja($dataOp,$desc)
	{
		/* Array para insertar en movimientos caja, eliminamos las columnas no existentes */
		unset($dataOp['idproveedor']);
		unset($dataOp['liquidado']);
		unset($dataOp['interes_total']);
		
		$op = $this->Proveedores_model->tipoOperacion_caja(['tipo_operacion'=> $desc,'activo' => 1]);
		$factor = !empty($op)? $this->Proveedores_model->factor(['destino' => 2, 'idtipooperacion' => $op->idtipooperacion, 'activo' => 1]) : array();
		
		!empty($op)? $dataOp['idtipooperacion'] = $op->idtipooperacion : '';
		!empty($factor)? $dataOp['idfactor'] = $factor->idfactor : '';
		
		return $dataOp;
	}
	public function anulaOp()
	{
		$this->load->model('Proveedores_model');
		$status = 500; $message = 'No se pudo anular';
		$id = $this->input->get('id'); $op = $this->input->get('op'); $fecha = date('Y-m-d H:i:s'); $idprov = '';
		$suc = $this->input->get('suc');
		
		if($op === 'operaciones'){
			$idprov = $this->Proveedores_model->traeProvByIdTran(['idtransaccion'=>$id]);
			
			$anula = $this->Proveedores_model->anulaTransaccion(['idtransaccion'=>$id],['activo'=>0],['idusuario_anulacion'=>$this->usuario->idusuario,
																	'fecha_anulacion'=>date('Y-m-d H:i:s'),'activo'=>0]);
			if($anula){
				$message = 'Transacci&oacute;n anulada';
				$status = 200;
			}
		}else if($op === 'ingresos'){
			$idprov = $this->Proveedores_model->traeProvByIdguia(['idguia'=>$id]);
			
			$anula = $this->Proveedores_model->anulaIngreso(['idguia'=>$id],['activo'=>0]);
			if($anula){
				$message = 'Gu&iacute;a Anulada';
				$status = 200;
			}
		}else if($op === 'valorizaciones' || $op === 'valorizop'){
			$idtran = null;
			if($op === 'valorizop'){
				$idtran = $id;
				$id = $this->Proveedores_model->traeValorizByIdTran(['idtransaccion'=>$idtran]);
			}else{
				$idtran = $this->Proveedores_model->traeTranByIdVal(['idvalorizacion'=>$id]);
			}
			
			$anula = $this->Proveedores_model->anulaValorizacion(['idvalorizacion'=>$id],['activo'=>0],['idtransaccion'=>$idtran],
																	['idusuario_anulacion'=>$this->usuario->idusuario,'fecha_anulacion'=>date('Y-m-d H:i:s'),'activo'=>0]);
			
			$idprov = $this->Proveedores_model->traeProvByIdTran(['idtransaccion'=>$idtran]);
			
			if($anula){
				$message = 'Valorizaci&oacute;n Anulada';
				$status = 200;
			}
		}
		
		$edocta = $this->Proveedores_model->traeEdoCta(['idproveedor'=>$idprov,'idsucursal' => $suc]);
		
		$data = array(
			'status' => $status,
			'message' => $message,
			'edocta' => $edocta,
		);
		
		echo json_encode($data);
	}
	public function nuevoIngreso()
	{
		$this->load->model('Proveedores_model');
		$status = 500; $message = 'No se pudo registrar la Gu&iacute;a'; $i = 0; $j = 0; $k = 0; $dataVal = []; $guiaArray = []; $dataTransaccion = []; $dataOp = []; $guia = 0;
		$idtranVal = 0; $valorizar = false; $pagar = false;  $tipoop = ''; $montopag = 0; $tipoOpPago = 0; $pago = 0; $mtoValor = 0; $rs = 0; $idtranPago = 0; //$saldo = true;
		// Takes raw data from the request
		$json = file_get_contents('php://input');
		// Converts it into a PHP object
		$data = json_decode($json);
		
		/*if($data[0]->chk_pago === 1){
			$mto = $data[0]->tipo_op === '8'? floatval($data[0]->desembolso) : floatval($data[0]->subtotal);
			$s = $this->saldoCaja($data[0]->idsucursal);
			if($s < $mto){ $saldo = false; $status = 100; $message = 'El saldo en Caja para la sucursal elegida no es suficiente'; }
		}*/
		
		//if($saldo){
			$guia = $this->Proveedores_model->ingresarProductos($data);
			
			if($guia > 0){
				foreach($data as $row):
					if($j === 0){ $guiaArray[$i] = $guia; $j++; }
					if($row->chk_valorizar === 1){
						$valorizar = true;
						$dataVal[$i] = [ 'idguia' => $guia,'idarticulo' => $row->idarticulo,'monto' => $row->cantidad_valorizada,'costo' => $row->costo,
										'idsucursal' => $row->idsucursal,'idproveedor' => $row->idproveedor ];
						$i++;
					}
				endforeach;
			}
			if($valorizar && $guia) $idtranVal = $this->Proveedores_model->regValorizacion($dataVal,$guiaArray);
			if($idtranVal > 0){
				if($data[0]->chk_pago === 1){
					$pagar = true;
					$montopag = $data[0]->tipo_op === '8'? floatval($data[0]->desembolso) : floatval($data[0]->subtotal); // 8 = pago parcial
					
					// Trae datos de la valorizacion creada
					$datosval = $this->Proveedores_model->datosByIdTran(['idtransaccion' => $idtranVal]);
					$montoant = !empty($datosval)? floatval($datosval->monto) : 0;
					
					// Validar si el monto pagado es menor al monto de la valorizacion para setear el tipo de op que se registrará
					$tipopago = $montopag < $montoant? '8' : '2';
					
					//$f = $this->Proveedores_model->factor([ 'destino' => 1,'idtipooperacion' => $data[0]->tipo_op,'activo' => 1 ]);
					$f = $this->Proveedores_model->factor([ 'destino' => 1,'idtipooperacion' => $tipopago,'activo' => 1 ]);
					$factor = (!empty($f)? $f->idfactor : 1);
								
					$dataTransaccion = [
						'fecha' => date('Y-m-d H:i:s'),
						'vencimiento' => date('Y-m-d'),
						'monto' => $montopag,
						'activo' => 1
					];
					$dataOp = [
						'idtipooperacion' => $tipopago,
						'idsucursal' => $data[0]->idsucursal,
						'idproveedor' => $data[0]->idproveedor,
						'monto' => $montopag,
						'interes' => 0,
						'liquidado' => 0,
						'interes_total' => 0,
						'idfactor' => $factor,
						'fecha_vencimiento' => date('Y-m-d H:i:s'),
						'fecha_movimiento' => date('Y-m-d H:i:s'),
						'idusuario_registro' => $this->usuario->idusuario,
						'fecha_registro' => date('Y-m-d H:i:s'),
						'activo' => 1,
					];
					
					$tipoop = $montopag < $montoant? 'ADELANTOS A PROVEEDORES' : 'PAGOS A PROVEEDORES';
					$tipoOpPago = $data[0]->tipo_op === '8'? 2 : 1;
					$pago = 1;
					$mtoValor = $data[0]->subtotal;

					# Guardar la transaccion, mov proveedor y mov caja 
					$idtranPago = $this->Proveedores_model->regTransaccion($dataTransaccion,$dataOp,$tipoop);
					
					//var_dump($tipo);
					
					// Variables para actualizar el movimiento anterior
					$campos = [
						'liquidado' => 1, 'fecha_movimiento' => date('Y-m-d H:i:s'), 'idusuario_modificacion' => $this->usuario->idusuario, 'fecha_modificacion' => date('Y-m-d H:i:s')
					];
					if($montopag < $montoant){ $campos['monto'] = $montopag; }
					// Actualiza la tabla transacciones y movimientos proveedor
					$this->Proveedores_model->actMovProv(['idtransaccion' => $idtranVal], $campos, 'movimientos_proveedor');
					
					// Crea la nueva transaccion de valorizacion por el restante del monto valorizado anteriormente
					if($montopag < $montoant){
						$this->Proveedores_model->actMovProv(['idtransaccion' => $idtranVal], ['monto' => $montopag], 'transacciones');
						$montoparcial = $montoant - $montopag;
						$tipoopval = $datosval->idtipooperacion;
						$factorval = $datosval->idfactor;
						if($montoparcial > 0){
							$dataTransaccion['monto'] = $montoparcial; $dataOp['monto'] = $montoparcial; $dataOp['idtipooperacion'] = $tipoopval; $dataOp['idfactor'] = $factorval;
							if($idtran = $this->Proveedores_model->registrarOp($dataTransaccion, 'transacciones')){
								$dataOp['idtransaccion'] = $idtran;
								$this->Proveedores_model->registrarOp($dataOp, 'movimientos_proveedor');
							}
						}
					}
				}
			}
			
			if($guia || $pagar){
				$this->Proveedores_model->actualizaGuia(['idguia'=>$guia],['pago'=>$pago,'tipo_pago'=>$tipoOpPago,'idtransaccion_valorizacion'=>$idtranVal,
						'idtransaccion_pago'=>$idtranPago,'monto_valor'=>$mtoValor,'monto_pagado'=>$montopag]);
			}
			
			if($guia && ($idtranVal || !$valorizar) && ($idtranPago || !$pagar)){
				$message = 'Gu&iacute;a registrada exitosamente'; $status = 200;
			}
		//}
		
		$edocta = $this->Proveedores_model->traeEdoCta(['idproveedor'=>$data[0]->idproveedor,'idsucursal' => $data[0]->idsucursal]);
		
		$data = array(
			'status' => $status,
			'message' => $message,
			'edocta' => $edocta,
			'guia' => $guia,
		);
		
		echo json_encode($data);
	}
	public function informes(){
		$versionphp = 7; $filtro = []; $i = 0; $id = $this->input->get('id'); $html = null; $j = 0;	$suc = []; $a5 = 'A4'; $direccion = 'portrait';
		$this->load->model('Proveedores_model');
		
		if($this->input->get('op') === 'guiaing'){
			//$lista = $this->Proveedores_model->guiaProv(['idguia' => $id]);
			$guia = $this->Proveedores_model->guiaComprobante(['gd.idguia' => $id]);
			$idprov = $guia[0]->idproveedor;
			$datosProv = $this->Proveedores_model->listaProveedor(['idproveedor' => $idprov]);
			
			$html = $this->load->view('proveedores/guia-pdf', ['guia' => $guia,'datos'=>$datosProv], true);
			//$html = $this->load->view('proveedores/guia-pdf', null, true);
			//var_dump($lista);
		}elseif($this->input->get('op') === 'edocta'){
			$lista = $this->Proveedores_model->edoctaProv(['idproveedor' => $id]);
			$datosProv = $this->Proveedores_model->listaProveedor(['idproveedor' => $id]);
			foreach($this->usuario->sucursales as $sucursal):
				foreach($lista as $row):
					if($row->idsucursal === $sucursal->idsucursal){
						$filtro[$i] = $row;
						$i++;
					}
				endforeach;
				$suc[$j] = $sucursal->idsucursal;
				$j++;
			endforeach;
			//var_dump($datosProv);
			$html = $this->load->view('proveedores/edo-cta', ['lista' => $filtro,'sucursales'=>$suc,'datos'=>$datosProv], true);
			$a5 = 'A4'; $direccion = 'portrait';
			
		}elseif($this->input->get('op') === 'valorizdet'){
			$lista = $this->Proveedores_model->valorizProv(['idvalorizacion' => $id]);
			
			foreach($lista as $row):
				$saldos = $this->Proveedores_model->saldoValorizaciones(['idguia'=>$row->idguia,'idarticulo'=>$row->idarticulo]);
				$row->saldo = !empty($saldos)? $saldos[$i]->cantidad : 0;
			endforeach;
			$html = $this->load->view('proveedores/valorizacion-pdf', ['lista' => $lista], true);
			//var_dump($lista);
		}elseif($this->input->get('op') === 'comp'){
			$guia = $this->Proveedores_model->guiaComprobante(['gd.idguia' => $id]);
			$valor = $this->Proveedores_model->valorizProv(['idtransaccion' => $guia[0]->idtransaccion_valorizacion]);
			
			foreach($valor as $row):
				$saldos = $this->Proveedores_model->saldoValorizaciones(['idguia'=>$row->idguia,'idarticulo'=>$row->idarticulo]);
				$row->saldo = !empty($saldos)? $saldos[$i]->cantidad : 0;
			endforeach;
			
			$idprov = $guia[0]->idproveedor;
			$datosProv = $this->Proveedores_model->listaProveedor(['idproveedor' => $idprov]);
			
			$movValor = $this->Proveedores_model->edoctaProv(['idtransaccion' => $guia[0]->idtransaccion_valorizacion]);
			$movPago = $this->Proveedores_model->edoctaProv(['idtransaccion' => $guia[0]->idtransaccion_pago]);
			$edocta = [];
			foreach($movValor as $row): $edocta[$i] = $row; $i++; endforeach;
			foreach($movPago as $row): $edocta[$i] = $row; $i++; endforeach;
			
			/* var_dump($edocta); var_dump($valor); echo nl2br("\n"); var_dump($guia); */
			
			$html = $this->load->view('proveedores/comprobante-pdf', ['guia' => $guia,'valoriz' => $valor,'datos' => $datosProv,'edocta' => $edocta], true);
		}elseif($this->input->get('op') === 'impresion'){
			$operacion = $this->Proveedores_model->listaOperacion(['lm.idtransaccion' => $id]);
			$data = ['movimiento' => $operacion];
			$html = $this->load->view('proveedores/transaccion-pdf', $data, true);
		}
		
		if(floatval(phpversion()) < $versionphp){
			$this->load->library('dom');
			$this->dom->generate($direccion, $a5, $html, 'Informe');
		}else{
			$this->load->library('dom1');
			$this->dom1->generate($direccion, $a5, $html, 'Informe');
		}
	}
	public function registrarValorizacion()
	{
		$status = 500; $message = 'No se pudo registrar la Valorizaci&oacute;n'; $guia = ''; /*$filasTran = []; $filaVal = []; $i = 0; $j = 0; $mto = 0; $mult = 0; $num = 0;
		$filaValDet = []; $filaValGuia = []; $fin = false;*/$guiaArray = []; $i = 0; $j = 0; $dataVal = [];
		
		$this->load->model('Proveedores_model');
		
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		
		foreach($data as $row):
			if($row->idguia !== $guia){ $guia = $row->idguia; $guiaArray[$j] = $row->idguia; $j++; }
			$dataVal[$i] = ['idguia' => $row->idguia,'idarticulo' => $row->idarticulo,'monto' => $row->cantidad,'costo'=>$row->costo,'idsucursal'=>$row->idsucursal,
							'idproveedor'=>$row->idproveedor];
			$i++;
		endforeach;
		
		
		$rs = $this->Proveedores_model->regValorizacion($dataVal,$guiaArray);
		if($rs > 0){
			$message = 'Productos Valorizados';
			$status = 200;
		}
		
		$edocta = $this->Proveedores_model->traeEdoCta(['idproveedor'=>$data[0]->idproveedor]);
		
		$data = array(
			'status' => $status,
			'msg' => $message,
			'edocta' => $edocta,
		);
		
		echo json_encode($data);
	}
	public function pruebas()
	{
		$this->load->model('Proveedores_model');
		$prueba = $this->Proveedores_model->pruebas(['ge.idproveedor' => 2,'ge.activo' => 1]);
		echo '<table class="table table-striped table-hover table-bordered mb-0 mx-auto">';
		foreach($prueba as $row):
			echo '<tr><td>'.$row->numero.'</td><td>'.$row->idguia.'</td><td>'.$row->fecha_guia.'</td><td>'.$row->nombre.'</td><td>'.$row->sucursal.'</td>'.
				 '<td>'.$row->cantidad_guia.'</td></tr>';
		endforeach;
		echo '</table>';
		//var_dump($prueba);
	}
}