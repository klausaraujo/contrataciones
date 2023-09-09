<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedores_model extends CI_Model
{    
	private $usuario;
	
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('user')) $this->usuario = json_decode($this->session->userdata('user'));
		else header('location:' .base_url());
	}
    
	public function listaProveedores()
    {
        $this->db->select('pr.*,td.tipo_documento');
        $this->db->from('proveedor pr');
		$this->db->join('tipo_documento td','td.idtipodocumento = pr.idtipodocumento');
		$this->db->where('idproveedor >',1);
		$this->db->where('pr.activo',1);
		$this->db->order_by('idproveedor', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function listaProveedor($data)
    {
        $this->db->select('pr.*,td.tipo_documento');
        $this->db->from('proveedor pr');
		$this->db->join('tipo_documento td','td.idtipodocumento = pr.idtipodocumento');
		$this->db->where($data);
		$this->db->order_by('idproveedor', 'ASC');
		$this->db->limit(1);
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
    }
	public function tipodoc()
	{
		$this->db->select('idtipodocumento,codigo_curl,tipo_documento,longitud');
        $this->db->from('tipo_documento');
		$this->db->where('activo',1);
		$this->db->order_by('idtipodocumento', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function factor($data){
		$this->db->select('idfactor');
        $this->db->from('factor');
		$this->db->where($data);
		$this->db->order_by('idfactor', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
	}
	public function registrar($data)
	{
		if ($this->db->insert('proveedor', $data)){
			return $this->db->insert_id();
		}else return 0;
        //else return $error['code'];
		
	}
	public function editar($data,$id)
	{
		$this->db->db_debug = FALSE;
		$this->db->where($id);
		if ($this->db->update('proveedor',$data)) return true;
        else return false;
	}
	public function tipoOperacion($data)
	{
		$this->db->select('idtipooperacion,tipo_operacion');
		$this->db->from('tipo_operacion_proveedor');
		$this->db->where($data);
		$this->db->order_by('idtipooperacion', 'ASC');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function tipoOperacion_caja($data)
	{
		$this->db->select('idtipooperacion');
		$this->db->from('tipo_operacion_caja');
		$this->db->where($data);
		$this->db->order_by('idtipooperacion', 'ASC');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
	}
	public function listaArticulos($data)
	{
		$this->db->select('idarticulo,articulo');
		$this->db->from('articulo');
		$this->db->where($data);
		$this->db->order_by('idarticulo', 'ASC');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function regTransaccion($dataTran,$dataOp,$tipoDet){
		$idtran = 0;
		$this->db->trans_begin();
		$this->db->insert('transacciones', $dataTran);
		
		$idtran = $this->db->insert_id();
		
		$dataOp['idtransaccion'] = $idtran;
		$this->db->insert('movimientos_proveedor', $dataOp);
		
		/* Array para insertar en movimientos caja, eliminamos las columnas no existentes */
		unset($dataOp['idproveedor']);
		unset($dataOp['liquidado']);
		$dataOp['interes'] = $dataOp['interes_total'];
		unset($dataOp['interes_total']);
		$op = $this->tipoOperacion_caja(['tipo_operacion'=> $tipoDet,'activo' => 1]);
		$factor = !empty($op)? $this->factor(['destino'=>2,'idtipooperacion'=>$op->idtipooperacion,'activo'=>1]) : array();
		
		!empty($op)? $dataOp['idtipooperacion'] = $op->idtipooperacion : '';
		!empty($factor)? $dataOp['idfactor'] = $factor->idfactor : '';
		
		$this->db->insert('movimientos_caja', $dataOp);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}else{
			$this->db->trans_commit();
			return $idtran;
		}
	}
	public function listaOperaciones($data)
    {
        $this->db->select('*,DATE_FORMAT(fecha_movimiento,"%d/%m/%Y") as fecha');
        $this->db->from('lista_movimientos_proveedor');
		$this->db->where($data);
		$this->db->order_by('idmovimiento', 'DESC');
		$this->db->order_by('idtransaccion', 'DESC');		
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function listaOperacionesPagos($data)
    {
        $this->db->select('*');
        $this->db->from('lista_movimientos_proveedor');
		$this->db->where($data);
		//$this->db->where('idtipooperacion= 7 OR idtipooperacion= 9');
		$this->db->order_by('idmovimiento', 'DESC');
		$this->db->order_by('idtransaccion', 'DESC');		
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function listaIngresos($data)
    {
        $this->db->select('ge.*,DATE_FORMAT(ge.fecha,"%d/%m/%Y") as fecha_guia,ged.idguia,SUM(cantidad) as cantidad_guia,su.sucursal,pr.nombre');
        $this->db->from('guia_entrada ge');
		$this->db->join('guia_entrada_detalle ged','ged.idguia = ge.idguia');
		$this->db->join('sucursal su','su.idsucursal = ge.idsucursal');
		$this->db->join('proveedor pr','pr.idproveedor = ge.idproveedor');
		$this->db->where($data);
		$this->db->group_by('ge.idguia');
		$this->db->order_by('ge.idguia', 'DESC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function listaValorizaciones($where)
    {
        $this->db->select('va.*,su.sucursal,pr.nombre,monto,DATE_FORMAT(va.fecha,"%d/%m/%Y") as fecha_val');
        $this->db->from('valorizacion va');
		$this->db->join('sucursal su','su.idsucursal = va.idsucursal');
		$this->db->join('proveedor pr','pr.idproveedor = va.idproveedor');
		$this->db->join('transacciones tr','tr.idtransaccion = va.idtransaccion');
		$this->db->where($where);
		$this->db->order_by('va.idvalorizacion', 'DESC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function listaValorizacionDetalle($where)
	{
		$this->db->select('idguia,anio_guia,DATE_FORMAT(fecha,"%d/%m/%Y") as fecha,numero,idarticulo,articulo,cantidad,idsucursal');
        $this->db->from('lista_ingresos_valorizaciones_saldo');
		$this->db->where($where);
		$this->db->order_by('idguia ASC, idarticulo ASC');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function costoValoriz($where)
	{
		$this->db->select('costo');
        $this->db->from('guia_entrada_detalle');
		$this->db->where($where);
		$this->db->limit(1);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function ingresarProductos($data)
	{
		$i = 0; $idguia = ''; $numero = 1;
		
		$this->db->trans_begin();
		
		foreach($data as $row):
			if($i === 0){
				$this->db->select('MAX(numero) numero');
				$this->db->from('guia_entrada');
				$this->db->where(['idsucursal'=>$row->idsucursal,'anio_guia'=>date('Y')]);
				$result = $this->db->get();
				if($result->num_rows() > 0){
					$result = $result->row();
					$numero = floatval( $result->numero ) + 1;
				}
				$guia_entrada = ['anio_guia'=>date('Y'),'numero'=>$numero,'fecha'=>date('Y-m-d'),'idsucursal'=>$row->idsucursal,'idproveedor'=>$row->idproveedor,
								'observaciones'=>$row->observacion,'idusuario_registro'=>$this->usuario->idusuario,'fecha_registro'=>date('Y-m-d'),'activo'=>1];
				//$guia_entrada[] = $tran;
				$this->db->insert('guia_entrada',$guia_entrada);
				$idguia = $this->db->insert_id();
			}
			$rowdet[$i] = ['idguia'=>$idguia,'idarticulo'=>$row->idarticulo,'cantidad'=>$row->cantidad,'valorizado'=>$row->chk_valorizar,
					'cantidad_valorizada'=>$row->cantidad_valorizada,'humedad'=>$row->humedad,'calidad'=>$row->calidad,'tasa'=>$row->tasa,'costo'=>$row->costo,'activo'=>1];
			$i++;
		endforeach;
		/* Insertar array de valores en la base */
		$this->db->insert_batch('guia_entrada_detalle',$rowdet);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}else{
			$this->db->trans_commit();
			return $idguia;
		}
	}
	public function anulaTransaccion($where,$activo,$data){
		$this->db->trans_begin();
		$this->db->db_debug = FALSE;
		
		$this->db->set($activo,TRUE);
		$this->db->where($where);
		$this->db->update('transacciones');
		
		$this->db->set($data,TRUE);
		$this->db->where($where);
		$this->db->update('movimientos_proveedor');
		
		$this->db->set($data,TRUE);
		$this->db->where($where);
		$this->db->update('movimientos_caja');
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	public function anulaIngreso($where,$data){
		$this->db->trans_begin();
		$this->db->db_debug = FALSE;
		$this->db->set($data,TRUE);
		$this->db->where($where);
		$this->db->update('guia_entrada');
		
		$this->db->set($data,TRUE);
		$this->db->where($where);
		$this->db->update('guia_entrada_detalle');
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	public function anulaValorizacion($where,$data,$idtran,$dataTran){
		$this->db->trans_begin();
		$this->db->db_debug = FALSE;
		$this->db->set($data,TRUE);
		$this->db->where($where);
		$this->db->update('valorizacion');
		
		$this->db->set($data,TRUE);
		$this->db->where($where);
		$this->db->update('valorizacion_detalle');
		
		$this->db->set($data,TRUE);
		$this->db->where($where);
		$this->db->update('guia_entrada_detalle_valorizacion');
		
		$this->db->set($data,TRUE);
		$this->db->where($idtran);
		$this->db->update('transacciones');
		
		$this->db->set($dataTran,TRUE);
		$this->db->where($idtran);
		$this->db->update('movimientos_proveedor');
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	public function traeNumVal($where)
	{
		$this->db->select('MAX(numero) numero');
		$this->db->from('valorizacion');
		$this->db->where($where);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$result = $result->row();
			return floatval( $result->numero ) + 1;
		}else return 1;
	}
	public function regValorizacion($data,$guia)
	{
		$numero = 1; $idtran = 0;
		$this->db->trans_begin();
		
		$numero = $this->traeNumVal(['idsucursal'=>$data[0]['idsucursal'],'anio_valorizacion'=>date('Y')]);
		
		foreach($guia as $row):
			$mto = 0; $suc = ''; $prov = ''; $valorizDet = []; $valorizGuiaDet = [];
			for($k =0;$k < count($data);$k++){
				if($data[$k]['idguia'] === $row){
					$mto += floatval($data[$k]['monto']) * floatval($data[$k]['costo']);
					$suc = $data[$k]['idsucursal'];
					$prov = $data[$k]['idproveedor'];
					$valorizDet[$k] = ['idguia'=>$row,'idarticulo'=>$data[$k]['idarticulo'],'cantidad'=>$data[$k]['monto'],'costo'=>$data[$k]['costo'],'activo'=>1];
					$valorizGuiaDet[$k] = ['idguia'=>$row,'idarticulo'=>$data[$k]['idarticulo'],'cantidad'=>$data[$k]['monto'],'costo'=>$data[$k]['costo'],'activo'=>1];
				}
			}
			$tranVal = ['fecha'=>date('Y-m-d H:i:s'),'vencimiento'=>date('Y-m-d'),'monto'=>$mto,'activo'=>1];
			$this->db->insert('transacciones',$tranVal);
			$idtran = $this->db->insert_id();
			
			$tranMovProv = ['idtipooperacion'=>6,'idsucursal'=>$suc,'idproveedor'=>$prov,'idtransaccion'=>$idtran,'monto'=>$mto,'idfactor'=>6,'fecha_vencimiento'=>date('Y-m-d'),
				'fecha_movimiento'=>date('Y-m-d H:i:s'),'idusuario_registro'=>$this->usuario->idusuario,'fecha_registro'=>date('Y-m-d H:i:s'),'activo'=>1];
			$this->db->insert('movimientos_proveedor',$tranMovProv);
			
			$valoriz = ['anio_valorizacion'=>date('Y'),'numero'=>$numero,'fecha'=>date('Y-m-d H:i:s'),'idsucursal'=>$suc,'idproveedor'=>$prov,'idtransaccion'=>$idtran,
						'idusuario_registro'=>$this->usuario->idusuario,'fecha_registro'=>date('Y-m-d H:i:s'),'activo'=>1];
			$this->db->insert('valorizacion',$valoriz);
			$idval = $this->db->insert_id();
			
			for($l = 0;$l < count($valorizDet);$l++){
				$valorizDet[$l]['idvalorizacion'] = $idval;
			}
			$this->db->insert_batch('valorizacion_detalle',$valorizDet);
			for($l = 0;$l < count($valorizGuiaDet);$l++){
				$valorizGuiaDet[$l]['idvalorizacion'] = $idval;
			}
			$this->db->insert_batch('guia_entrada_detalle_valorizacion',$valorizGuiaDet);
		endforeach;
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}else{
			$this->db->trans_commit();
			return $idtran;
		}
	}
	public function traeTranByIdVal($where)
	{
		$this->db->select('idtransaccion');
		$this->db->from('valorizacion');
		$this->db->where($where);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$result = $result->row();
			return $result->idtransaccion;
		}else return 0;
	}
	public function traeValorizByIdTran($where)
	{
		$this->db->select('idvalorizacion');
		$this->db->from('valorizacion');
		$this->db->where($where);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$result = $result->row();
			return $result->idvalorizacion;
		}else return 0;
	}
	public function tieneValorizacion($where)
	{
		$this->db->select('idguia');
		$this->db->from('valorizacion_detalle');
		$this->db->where($where);
		$this->db->limit(1);
		return $this->db->get();
	}
	public function edoctaProv($where)
	{
		$this->db->select('*');
		$this->db->from('lista_movimientos_proveedor');
		$this->db->where($where);
		//$this->db->group_by('idsucursal', 'asc');
		$this->db->order_by('idtransaccion', 'ASC');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function guiaProv($where)
	{
		$this->db->select('*');
		$this->db->from('lista_ingresos_proveedores');
		$this->db->where($where);
		$this->db->order_by('idarticulo', 'ASC');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function valorizProv($where)
	{
		$this->db->select('*');
		$this->db->from('lista_valorizaciones_proveedores');
		$this->db->where($where);
		$this->db->order_by('numero', 'ASC');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function saldoValorizaciones($where)
	{
		$this->db->select('idarticulo,cantidad');
		$this->db->from('lista_ingresos_valorizaciones_saldo');
		$this->db->where($where);
		$this->db->order_by('idarticulo', 'ASC');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function actualizaGuia($idguia,$data)
	{
		$this->db->db_debug = FALSE;
		$this->db->where($idguia);
		if ($this->db->update('guia_entrada',$data)) return true;
        else return false;
	}
	public function traeEdoCta($where){
		$this->db->select('SUM(monto_factor_final) edocta');
		$this->db->from('lista_movimientos_proveedor');
		$this->db->where($where);
		$rs = $this->db->get();
		if($rs->num_rows() > 0){
			$rs = $rs->row();
			return is_null($rs->edocta)? 0 : sprintf("%1.2f",$rs->edocta);
		}else return 0;
	}
	public function traeProvByIdguia($where){
		$this->db->select('idproveedor');
		$this->db->from('guia_entrada');
		$this->db->where($where);
		$this->db->limit(1);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$result = $result->row();
			return $result->idproveedor;
		}else return 0;
	}
	public function traeProvByIdTran($where){
		$this->db->select('idproveedor');
		$this->db->from('movimientos_proveedor');
		$this->db->where($where);
		$this->db->limit(1);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$result = $result->row();
			return $result->idproveedor;
		}else return 0;
	}
	public function guiaComprobante($where)
	{
		$this->db->select('gd.*,ge.*,a.articulo,s.sucursal');
		$this->db->from('guia_entrada_detalle gd');
		$this->db->join('guia_entrada ge','ge.idguia = gd.idguia');
		$this->db->join('articulo a','a.idarticulo = gd.idarticulo');
		$this->db->join('sucursal s','s.idsucursal = ge.idsucursal');
		$this->db->where($where);
		$this->db->order_by('idarticulo', 'ASC');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function departamentos()
    {
		$this->db->distinct();
        $this->db->select('cod_dep,departamento');
        $this->db->from('ubigeo');
		//$this->db->where('idusuario', $this->idUser);
        $this->db->order_by('cod_dep', 'ASC');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function provincias($where)
    {
		$this->db->distinct();
        $this->db->select('cod_pro,provincia');
        $this->db->from('ubigeo');
		//$this->db->where('idusuario', $this->idUser);
		$this->db->where($where);
        $this->db->order_by('cod_pro', 'ASC');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function distritos($where)
    {
		$this->db->distinct();
        $this->db->select('cod_dis,distrito');
        $this->db->from('ubigeo');
		//$this->db->where('idusuario', $this->idUser);
		$this->db->where($where);
        $this->db->order_by('cod_dis', 'ASC');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function latLng($where){
		$this->db->select('latitud,longitud');
        $this->db->from('lista_ubigeo');
		$this->db->where($where);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function listaOperacion($where)
    {
        $this->db->select('lm.*,mp.observaciones');
        $this->db->from('lista_movimientos_proveedor lm');
		$this->db->join('movimientos_proveedor mp','mp.idmovimiento=lm.idmovimiento');
		$this->db->where($where);
		$this->db->limit(1);
		//$this->db->order_by('idmovimiento', 'DESC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
    }
	public function regCaja($dataTran,$dataOp,$tipoDet){
		$idtran = 0;
		$this->db->trans_begin();
		$this->db->insert('transacciones', $dataTran);
		
		$idtran = $this->db->insert_id();
		
		$dataOp['idtransaccion'] = $idtran;
		
		$this->db->insert('movimientos_caja', $dataOp);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}else{
			$this->db->trans_commit();
			return $idtran;
		}
	}
	public function registrarOp($dataOp,$tabla)
	{
		if($this->db->insert($tabla, $dataOp)) return $this->db->insert_id();
		else return false;
	}
	public function actMovProv($where, $data, $tabla){
		$this->db->db_debug = FALSE;
		$this->db->set($data, TRUE);
        $this->db->where($where);
		if($this->db->update($tabla))return true;
		else return false;
	}
	public function datosByIdTran($idtran)
	{
		$this->db->select('idtipooperacion, monto, idfactor');
		$this->db->from('movimientos_proveedor');
		$this->db->where($idtran);
		$this->db->limit(1);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
	}
	public function pruebas($data)
    {
        $this->db->select('ge.*,DATE_FORMAT(ge.fecha,"%d/%m/%Y") as fecha_guia,ged.idguia,SUM(cantidad) as cantidad_guia,su.sucursal,pr.nombre');
        $this->db->from('guia_entrada ge');
		$this->db->join('guia_entrada_detalle ged','ged.idguia = ge.idguia');
		$this->db->join('sucursal su','su.idsucursal = ge.idsucursal');
		$this->db->join('proveedor pr','pr.idproveedor = ge.idproveedor');
		$this->db->where($data);
		$this->db->group_by('ge.idguia');
		$this->db->order_by('ge.idguia', 'DESC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
}