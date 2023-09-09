<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Servicios_model extends CI_Model
{    
	private $usuario;
	
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('user')) $this->usuario = json_decode($this->session->userdata('user'));
		else header('location:' .base_url());
	}
	
	public function anio()
	{
		$this->db->select('*');
        $this->db->from('anio');
		$this->db->where('activo', 1);
		$this->db->order_by('idanio', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function mes()
	{
		$this->db->select('*');
        $this->db->from('mes');
		$this->db->where('activo', 1);
		$this->db->order_by('idmes', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function listaOperacionesCaja($where)
    {
        $this->db->select('*,DATE_FORMAT(fecha_movimiento,"%d/%m/%Y") as fecha_registro');
        $this->db->from('lista_movimientos_caja');
		$this->db->where($where);
		$this->db->order_by('idmovimiento', 'DESC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function listaServicio($where)
    {
        $this->db->select('lmc.*,mc.observaciones');
        $this->db->from('lista_movimientos_caja lmc');
		$this->db->join('movimientos_caja mc','mc.idtransaccion = lmc.idtransaccion');
		$this->db->where($where);
		$this->db->limit(1);
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
    }
	public function tipoOperacion($where)
	{
		$this->db->select('*');
        $this->db->from('tipo_operacion_caja');
		$this->db->where($where);
		$this->db->order_by('idtipooperacion', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function movCaja($dataTran,$dataOp){
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
	public function editar($trans,$movcaja,$whereTran,$whereMov)
	{
		$this->db->trans_begin();
		
		$this->db->db_debug = FALSE;
		$this->db->where($whereTran);
		$this->db->update('transacciones',$trans);

		$this->db->where($whereMov);
		$this->db->update('movimientos_caja',$movcaja);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}else{
			$this->db->trans_commit();
			return 1;
		}
	}
	public function anular($whereMov,$whereTran)
	{
		$this->db->trans_begin();
		
		$this->db->db_debug = FALSE;
		$this->db->where($whereMov);
		$this->db->update('movimientos_caja',['activo' => 0]);
		
		$this->db->where($whereTran);
		$this->db->update('transacciones',['activo' => 0]);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}else{
			$this->db->trans_commit();
			return 1;
		}
	}
	public function idTransaccion($where)
	{
		$this->db->select('idtransaccion');
		$this->db->from('movimientos_caja');
		$this->db->where($where);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$result = $result->row();
			return $result->idtransaccion;
		}else return 0;
	}
	public function traeSaldo($where)
	{
		$this->db->select('saldo');
		$this->db->from('saldos_caja');
		$this->db->where($where);
		$rs = $this->db->get();
		if($rs->num_rows() > 0){
			$rs = $rs->row();
			return is_null($rs->saldo)? 0 : sprintf("%1.2f",$rs->saldo);
		}else return 0;
	}
	public function pdf($where)
	{
		$this->db->select('c.*,s.sucursal,t.tipo_operacion,f.factor');
        $this->db->from('movimientos_caja c');
		$this->db->join('sucursal s','s.idsucursal=c.idsucursal');
		$this->db->join('tipo_operacion_caja t','t.idtipooperacion=c.idtipooperacion');
		$this->db->join('factor f','f.idfactor=c.idfactor');
		$this->db->where($where);
		$this->db->limit(1);
		//$this->db->order_by('idtipooperacion', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
	}
}