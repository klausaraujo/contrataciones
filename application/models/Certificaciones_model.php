<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Certificaciones_model extends CI_Model
{    
	private $usuario;
	
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('user')) $this->usuario = json_decode($this->session->userdata('user'));
		else header('location:' .base_url());
	}
	
	public function listaCertificaciones($where)
    {
        $this->db->select('c.*,DATE_FORMAT(fecha,"%d/%m/%Y") as fecha_registro,nombre,sucursal');
        $this->db->from('certificado c');
		$this->db->join('sucursal s','s.idsucursal=c.idsucursal');
		$this->db->join('proveedor p','p.idproveedor=c.idproveedor');
		$this->db->where($where);
		$this->db->order_by('idcertificado', 'DESC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function listaCertificacion($where)
    {
        $this->db->select('lmc.*,mc.observaciones');
        $this->db->from('lista_movimientos_caja lmc');
		$this->db->join('movimientos_caja mc','mc.idtransaccion = lmc.idtransaccion');
		$this->db->where($where);
		$this->db->limit(1);
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
    }
	public function variedad()
	{
		$this->db->select('*');
        $this->db->from('variedad');
		$this->db->where('activo', 1);
		$this->db->order_by('idvariedad', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function proceso()
	{
		$this->db->select('*');
        $this->db->from('proceso');
		$this->db->where('activo', 1);
		$this->db->order_by('idproceso', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function proveedores()
	{
		$this->db->select('idproveedor,nombre');
        $this->db->from('proveedor');
		$this->db->where('idproveedor >', 1);
		$this->db->where('activo', 1);
		$this->db->order_by('idproveedor', 'ASC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function numeroCert($where)
	{
		$this->db->select('MAX(numero) numero');
		$this->db->from('certificado');
		$this->db->where($where);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$result = $result->row();
			return floatval( $result->numero ) + 1;
		}else
			return 1;
	}
	public function guardaCert($data)
	{
		if($this->db->insert('certificado',$data)) return true;
		else return false;
	}
	public function actualizaCert($id,$data)
	{
		$this->db->db_debug = FALSE;
		$this->db->where($id);
		if ($this->db->update('certificado',$data)) return true;
        else return false;
	}
	public function traeDatosProv($where)
	{
		$this->db->select('c.idproveedor,p.nombre');
        $this->db->from('certificado c');
		$this->db->join('proveedor p','p.idproveedor = c.idproveedor');
		$this->db->where($where);
		$this->db->limit(1);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
	}
	public function color()
	{
		$this->db->select('*');
        $this->db->from('color');
		$this->db->where('activo',1);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function olor()
	{
		$this->db->select('*');
        $this->db->from('olor');
		$this->db->where('activo',1);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function apariencia()
	{
		$this->db->select('*');
        $this->db->from('apariencia');
		$this->db->where('activo',1);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function quaker()
	{
		$this->db->select('*');
        $this->db->from('quaker');
		$this->db->where('activo',1);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function hayCertificado($where)
	{
		$this->db->select('COUNT(iddetalle) cuenta');
		$this->db->from('certificado_detalle');
		$this->db->where($where);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$result = $result->row();
			return intval($result->cuenta);
		}else
			return 0;
	}
	public function guardaParametros($data)
	{
		if($this->db->insert('certificado_detalle',$data)) return true;
		else return false;
	}
	public function actualizaParametros($id,$data)
	{
		$this->db->db_debug = FALSE;
		$this->db->where($id);
		if ($this->db->update('certificado_detalle',$data)) return true;
        else return false;
	}
	public function certificadoDetalle($where)
	{
		$this->db->select('*');
        $this->db->from('certificado_detalle');
		$this->db->where($where);
		$this->db->limit(1);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
	}
	public function certificado($where)
	{
		$this->db->select('c.*,p.nombre,p.finca,p.altitud');
        $this->db->from('certificado c');
		$this->db->join('proveedor p','p.idproveedor=c.idproveedor');
		$this->db->where($where);
		$this->db->limit(1);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
	}
	public function anular($where,$data)
	{
		$this->db->trans_begin();
		$this->db->db_debug = FALSE;
		
		$this->db->set($data,TRUE);
		$this->db->where($where);
		$this->db->update('certificado');
		
		$this->db->set($data,TRUE);
		$this->db->where($where);
		$this->db->update('certificado_detalle');
				
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	public function guardaCatadores($data)
	{
		$this->db->trans_begin();
		$this->db->db_debug = FALSE;
		
		$this->db->delete('certificado_catador', array('idcertificado' => $data[0]->idcertificado));
		$this->db->insert_batch('certificado_catador',$data);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	public function registraCatadores($data)
	{
		if($resp = $this->db->insert('catador',$data)) return $this->db->insert_id();
		else return false;
	}
	public function traeCatadores($where)
	{
		$this->db->select('cc.idcatador,numero_documento as documento,CONCAT(apellidos," ",nombres) as nombres');
        $this->db->from('certificado_catador cc');
		$this->db->join('catador c','c.idcatador = cc.idcatador');
		$this->db->where($where);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function certificadopdf($where)
	{
		$this->db->select('c.*,p.nombre,pr.proceso,v.variedad,s.sucursal');
        $this->db->from('certificado c');
		$this->db->join('proveedor p','p.idproveedor=c.idproveedor');
		$this->db->join('proceso pr','pr.idproceso=c.idproceso');
		$this->db->join('variedad v','v.idvariedad=c.idvariedad');
		$this->db->join('sucursal s','s.idsucursal=c.idsucursal');
		$this->db->where($where);
		$this->db->limit(1);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
	}
	public function detallePdf($where)
	{
		$this->db->select('cd.*,c.color,a.apariencia,q.quaker');
        $this->db->from('certificado_detalle cd');
		$this->db->join('color c','c.idcolor = cd.idcolor');
		$this->db->join('apariencia a','a.idapariencia = cd.idapariencia');
		$this->db->join('quaker q','q.idquaker = cd.idquaker');
		$this->db->where($where);
		$this->db->limit(1);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
	}
	public function traeRutaGrafico($where)
	{
		$this->db->select('CONCAT(idcertificado,anio_certificado) as nombre');
		$this->db->from('certificado');
		$this->db->where($where);
		$this->db->limit(1);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
	}
	public function saveNombreGraph($id,$data)
	{
		$this->db->db_debug = FALSE;
		$this->db->where($id);
		if ($this->db->update('certificado',$data)) return true;
        else return false;
	}
}