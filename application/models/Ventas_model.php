<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Ventas_model extends CI_Model
{    
	private $usuario;
	
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('user')) $this->usuario = json_decode($this->session->userdata('user'));
		else header('location:' .base_url());
	}
    
	public function listaClientes()
    {
        $this->db->select('cl.*,td.tipo_documento');
        $this->db->from('cliente cl');
		$this->db->join('tipo_documento td','td.idtipodocumento = cl.idtipodocumento');
		$this->db->where('cl.idcliente >',1);
		$this->db->where('cl.activo',1);
		$this->db->order_by('idcliente', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function listaCliente($where)
    {
        $this->db->select('cl.*,td.tipo_documento');
        $this->db->from('cliente cl');
		$this->db->join('tipo_documento td','td.idtipodocumento = cl.idtipodocumento');
		$this->db->where($where);
		//$this->db->order_by('idcliente', 'ASC');
		$this->db->limit(1);
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
    }
	public function registrar($data)
	{
		if ($this->db->insert('cliente', $data))return true;
        //else return $error['code'];
		else return false;
	}
	public function editar($data,$id)
	{
		$this->db->db_debug = FALSE;
		$this->db->where($id);
		if ($this->db->update('cliente',$data)) return true;
        else return false;
	}
	public function listaVentas($data)
    {
        $this->db->select('gs.*,tp.tipo_operacion,mp.medio_pago,su.sucursal,cl.nombre,DATE_FORMAT(fecha_movimiento,"%d/%m/%Y") as fecha');
        $this->db->from('movimientos_cliente gs');
		$this->db->join('tipo_operacion_cliente tp','tp.idtipooperacion = gs.idtipooperacion');
		$this->db->join('medio_pago mp','mp.idmediopago = gs.idmediopago');
		$this->db->join('sucursal su','su.idsucursal = gs.idsucursal');
		$this->db->join('cliente cl','cl.idcliente = gs.idcliente');
		$this->db->where($data);
		$this->db->order_by('gs.idmovimiento', 'DESC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function listaVenta($where)
    {
        $this->db->select('mc.*,gs.observaciones,gs.idguia,gsd.*,ar.articulo');
        $this->db->from('movimientos_cliente mc');
		$this->db->join('guia_salida gs','gs.idtransaccion = mc.idtransaccion');
		$this->db->join('guia_salida_detalle gsd','gsd.idguia = gs.idguia');
		$this->db->join('articulo ar','ar.idarticulo = gsd.idarticulo');
		/*$this->db->join('medio_pago mp','mp.idmediopago = gs.idmediopago');
		$this->db->join('sucursal su','su.idsucursal = gs.idsucursal');
		$this->db->join('cliente cl','cl.idcliente = gs.idcliente');*/
		$this->db->where($where);
		$this->db->limit(1);
		//$this->db->order_by('gs.idmovimiento', 'DESC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
    }
	public function medioPago($where)
	{
		$this->db->select('idmediopago,medio_pago');
        $this->db->from('medio_pago');
		$this->db->where($where);
		$this->db->order_by('idmediopago', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function tipoOp($where)
	{
		$this->db->select('idtipooperacion,tipo_operacion');
        $this->db->from('tipo_operacion_cliente');
		$this->db->where($where);
		$this->db->order_by('idtipooperacion', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function ingresaVenta($data,$pago,$idtran)
	{
		$i = 0; $idguia = ''; $numero = 1;
		
		$this->db->trans_begin();
		
		foreach($data as $row):
			if($i === 0){
				$this->db->select('MAX(numero) numero');
				$this->db->from('guia_salida');
				$this->db->where(['idsucursal'=>$pago->idsucursal,'anio_guia'=>date('Y')]);
				$result = $this->db->get();
				if($result->num_rows() > 0){
					$result = $result->row();
					$numero = floatval( $result->numero ) + 1;
				}
				$guia_salida = ['anio_guia'=>date('Y'),'numero'=>$numero,'fecha'=>date('Y-m-d H:i:s'),'idsucursal'=>$pago->idsucursal,'idcliente'=>$pago->idcliente,
							'idtransaccion'=>$idtran,'monto_valor'=>$pago->total_vta,'monto_pagado'=>$pago->total_vta,'observaciones'=>$pago->obs,
							'idusuario_registro'=>$this->usuario->idusuario,'fecha_registro'=>date('Y-m-d H:i:s'),'activo'=>1];
				//$guia_entrada[] = $tran;
				$this->db->insert('guia_salida',$guia_salida);
				$idguia = $this->db->insert_id();
			}
			$rowdet[$i] = ['idguia'=>$idguia,'idarticulo'=>$row->idarticulo,'cantidad'=>$row->cantidad,'humedad'=>$row->humedad,'calidad'=>$row->calidad,
						'costo'=>$row->costo,'tasa'=>$row->tasa,'costo'=>$row->costo,'activo'=>1];
			$i++;
		endforeach;
		
		/* Insertar array de valores en la base */
		$this->db->insert_batch('guia_salida_detalle',$rowdet);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}else{
			$this->db->trans_commit();
			return $idguia;
		}
	}
	public function transaccionVta($data)
	{
		if($this->db->insert('transacciones', $data))return $this->db->insert_id();
		else return 0;
	}
	public function regMovCliente($data,$tp,$f,$pago)
	{
		$this->db->trans_begin();
		
		/* Insertar en la tabla movimientos proveedor */
		$this->db->insert('movimientos_cliente', $data);
		
		unset($data['idmediopago']);
		unset($data['idcliente']);
		$data['idtipooperacion'] = $tp;
		$data['idfactor'] = $f;
		$data['fecha_vencimiento'] = date('Y-m-d H:i:s');
		$data['observaciones'] = $pago->obs;
		$data['check_igv'] = $pago->check;
		
		/* Insertar en la tabla movimientos caja */
		$this->db->insert('movimientos_caja', $data);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}else{
			$this->db->trans_commit();
			return 1;
		}
	}
	public function validaRuc($data,$tabla)
	{
		$query = $this->db->query('SELECT RUC FROM '.$tabla.' WHERE idcliente = '.$data.' LIMIT 1');
		if($query->num_rows() > 0) return $query->row();
		else return array();
	}
	public function articulosVta($where)
	{
		$this->db->select('gs.idarticulo,gs.cantidad,gs.humedad,gs.calidad,gs.costo,gs.tasa,ar.articulo');
        $this->db->from('guia_salida_detalle gs');
		$this->db->join('articulo ar','ar.idarticulo = gs.idarticulo');
		$this->db->where($where);
		$this->db->order_by('ar.idarticulo', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function editaTransaccion($data,$where)
	{
		$this->db->db_debug = FALSE;
		$this->db->where($where);
		if ($this->db->update('transacciones',$data)) return true;
        else return false;
	}
	public function editaVenta($data,$pago)
	{
		$this->db->trans_begin();
		$this->db->db_debug = FALSE;
		$i = 0;
		
		foreach($data as $row):
			if($i === 0){
				$guia_salida = ['idsucursal'=>$pago->idsucursal,'monto_valor'=>$pago->total_vta,'monto_pagado'=>$pago->total_vta,'observaciones'=>$pago->obs,
					'idusuario_modificacion'=>$this->usuario->idusuario,'fecha_modificacion'=>date('Y-m-d H:i:s')];
				$this->db->where(['idtransaccion' => $pago->idtrans]);
				$this->db->update('guia_salida',$guia_salida);
				$this->db->where('idguia', $pago->guia_vta);
				$this->db->delete('guia_salida_detalle');
			}
			$rowdet[$i] = ['idguia'=>$pago->guia_vta,'idarticulo'=>$row->idarticulo,'cantidad'=>$row->cantidad,'humedad'=>$row->humedad,'calidad'=>$row->calidad,
						'costo'=>$row->costo,'tasa'=>$row->tasa,'costo'=>$row->costo,'activo'=>1];
			$i++;
		endforeach;
		
		/* Insertar array de valores en la base */
		$this->db->insert_batch('guia_salida_detalle',$rowdet);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}else{
			$this->db->trans_commit();
			return $pago->guia_vta;
		}
	}
	public function editaMovCliente($data,$tp,$f,$pago)
	{
		$this->db->trans_begin();
		$this->db->db_debug = FALSE;
		
		/* Actualizar la tabla movimientos caja */
		$this->db->where(['idtransaccion' => $pago->idtrans]);
		$this->db->update('movimientos_cliente',$data);
		
		unset($data['idmediopago']);
		unset($data['idcliente']);
		$data['idtipooperacion'] = $tp;
		$data['idfactor'] = $f;
		$data['observaciones'] = $pago->obs;
		$data['check_igv'] = $pago->check;
		
		/* Actualizar la tabla movimientos caja */
		$this->db->where(['idtransaccion' => $pago->idtrans]);
		$this->db->update('movimientos_caja',$data);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}else{
			$this->db->trans_commit();
			return 1;
		}
	}
	public function anularVenta($tabla,$where,$data)
	{
		$this->db->db_debug = FALSE;
		
		/* Actualizar el campo activo de las tablas involucradas */
		$this->db->where($where);
		if($this->db->update($tabla,$data)) return true;
		else return false;
	}
	public function guiaVenta($tabla,$id)
	{
		$query = $this->db->query('SELECT idguia FROM '.$tabla.' WHERE idtransaccion = '.$id.' LIMIT 1');
		if($query->num_rows() > 0) return $query->row();
		else return array();
	}
	public function pdfVenta($where)
	{
		$this->db->select('mc.*,gs.*,mp.medio_pago,su.sucursal,gsd.*,ar.articulo');
        $this->db->from('movimientos_cliente mc');
		$this->db->join('guia_salida gs','gs.idtransaccion = mc.idtransaccion');
		$this->db->join('medio_pago mp','mp.idmediopago = mc.idmediopago');
		$this->db->join('sucursal su','su.idsucursal = mc.idsucursal');
		$this->db->join('guia_salida_detalle gsd','gsd.idguia = gs.idguia');
		$this->db->join('articulo ar','ar.idarticulo = gsd.idarticulo');
		$this->db->where($where);
		//$this->db->limit(1);
		$this->db->order_by('gsd.idarticulo', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
}