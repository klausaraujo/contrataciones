<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Locadores_model extends CI_Model
{    
	public function __construct(){ parent::__construct(); }
    
	public function listaLocadores()
    {
        $this->db->select('lc.*,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_inicio,DATE_FORMAT(fecha_fin,"%d/%m/%Y") as fecha_fin,
				d.descripcion as dependencia,e.descripcion estadodesc');
        $this->db->from('convocatoria_locadores lc');
		$this->db->join('dependencia d','d.iddependencia = lc.iddependencia');
		$this->db->join('estado e','e.idestado = lc.idestado');
		$this->db->order_by('idconvocatoria', 'asc');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function registrar($data)
	{
		if($this->db->insert('convocatoria_locadores', $data))return true;
        //else return $error['code'];
		else return false;
	}
	public function actualizar($data,$id)
	{
		$this->db->db_debug = FALSE;
		$this->db->where($id);
		if($this->db->update('convocatoria_locadores',$data)) return true;
        else return false;
	}
	public function registrarBatch($where,$data,$tabla)
	{
		$this->db->trans_begin();
		
		$this->db->where($where);
		$this->db->delete($tabla);
		if(!empty($data))
			$this->db->insert_batch($tabla, $data);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
}