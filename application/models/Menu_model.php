<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
class Menu_model extends CI_Model
{    
	public function __construct(){ parent::__construct(); }
    
	public function listaMenuPermisos($data)
    {
        $this->db->select('idmenu,activo');
        $this->db->from('permisos_menu');
		$this->db->where($data);
		$this->db->order_by('idmenu', 'asc');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function listaSubMenuPermisos($data)
    {
        $this->db->select('idmenudetalle,activo');
        $this->db->from('permisos_menu_detalle');
        $this->db->where($data);
		$this->db->order_by('idmenudetalle', 'asc');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function listaMenu()
	{
		$this->db->select('*');
		$this->db->from('menu');
		$this->db->order_by('idmodulo', 'asc');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function listaSubMenu()
	{
		$this->db->select('*');
		$this->db->from('menu_detalle');
		$this->db->order_by('idmenu', 'asc');
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
}