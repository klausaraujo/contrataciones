<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Tostado_model extends CI_Model
{    
	private $usuario;
	
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('user')) $this->usuario = json_decode($this->session->userdata('user'));
		else header('location:' .base_url());
	}
	
	public function listaTostados($where)
    {
        $this->db->select('t.*,DATE_FORMAT(fecha,"%d/%m/%Y") as fecha_registro,nombre,sucursal,articulo');
        $this->db->from('tostado t');
		$this->db->join('sucursal s','s.idsucursal=t.idsucursal');
		$this->db->join('proveedor p','p.idproveedor=t.idproveedor');
		$this->db->join('articulo a','a.idarticulo=t.idarticulo');
		$this->db->where($where);
		$this->db->order_by('idtostado', 'DESC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function listaTostado($where)
    {
        $this->db->select('t.*,numero_documento,nombre,domicilio,sucursal,tipo_documento,articulo');
        $this->db->from('tostado t');
		$this->db->join('proveedor p','t.idproveedor=p.idproveedor');
		$this->db->join('sucursal s','t.idsucursal=s.idsucursal');
		$this->db->join('articulo a','a.idarticulo=t.idarticulo');
		$this->db->join('tipo_documento td','p.idtipodocumento=td.idtipodocumento');
		$this->db->where($where);
		$this->db->limit(1);
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
    }
	public function articulos()
	{
		$this->db->select('*');
        $this->db->from('articulo');
		$this->db->where('activo', 1);
		$this->db->order_by('idarticulo', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function numeroTost($where)
	{
		$this->db->select('MAX(numero) numero');
		$this->db->from('tostado');
		$this->db->where($where);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$result = $result->row();
			return floatval( $result->numero ) + 1;
		}else
			return 1;
	}
	public function guardaTost($data)
	{
		if($this->db->insert('tostado',$data)) return true;
		else return false;
	}
	public function actualizaTost($id,$data)
	{
		$this->db->db_debug = FALSE;
		$this->db->where($id);
		if ($this->db->update('tostado',$data)) return true;
        else return false;
	}
	public function anular($id,$data)
	{
		$this->db->db_debug = FALSE;
		$this->db->where($id);
		if ($this->db->update('tostado',$data)) return true;
        else return false;
	}
	public function regtostado($data,$where,$tabla)
	{
		$cuenta = $this->db->where($where)->from($tabla)->count_all_results();
		$this->db->trans_begin();
		$this->db->db_debug = FALSE;
		
		if($cuenta > 0){
			$this->db->where($where)->from($tabla)->delete();
			$this->db->insert_batch($tabla,$data);
		}else{
			$this->db->insert_batch($tabla,$data);
		}
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}else{
			$this->db->trans_commit();
			return 1;
		}
	}
	public function regtridesp($data,$where,$tabla)
	{
		$cuenta = $this->db->where($where)->from($tabla)->count_all_results();
		$this->db->trans_begin();
		$this->db->db_debug = FALSE;
		
		if($cuenta > 0){
			//$this->db->where($where)->from($tabla)->delete();
			//$this->db->insert($tabla,$data);
			$this->db->update($tabla,$data,$where);
		}else{
			$this->db->insert($tabla,$data);
		}
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 0;
		}else{
			$this->db->trans_commit();
			return 1;
		}
	}
	public function listaoptostado($where)
	{
		$this->db->select('*');
        $this->db->from('tostado_maquina');
		$this->db->where($where);
		$this->db->order_by('idmaquina', 'DESC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function traeOpTostado($tabla, $where)
	{
		$result= $this->db->get_where($tabla, $where, 1);
		return ($result->num_rows() > 0)? $result->row() : array();
	}
}