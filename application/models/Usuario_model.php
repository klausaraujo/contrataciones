<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_Model
{
	private $pass;
	private $avatar;
	
	public function setPassword($data){ $this->pass = $this->db->escape_str($data); }
	public function setAvatar($data){ $this->avatar = $this->db->escape_str($data); }
	
    public function __construct() { parent::__construct(); }
	
    public function iniciar($data)
    {
        $this->db->select('u.*,td.tipo_documento');
        $this->db->from('usuarios u');
		$this->db->join('tipo_documento td','u.idtipodocumento = td.idtipodocumento');
        $this->db->where($data);
		$this->db->limit(1);
        return $this->db->get();
    }
    public function listaModulo($data)
    {
        $this->db->select('modulo.idmodulo,descripcion,menu,icono,url,modulo_rol.activo,imagen,mini');
        $this->db->from('modulo');
        $this->db->join('modulo_rol', 'modulo_rol.idmodulo = modulo.idmodulo');
        $this->db->where($data);
        $this->db->order_by('orden', 'asc');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function validar_password($data)
    {
        $this->db->select('passwd');
        $this->db->from('usuarios');
        $this->db->where($data);
        $pass = $this->db->get();
        $pass = $pass->row();
        if(sha1($this->pass) == $pass->passwd) return 1;
        else return 0;
    }
	public function password($data)
    {
        $this->db->db_debug = FALSE;
        $this->db->set('passwd', sha1($this->pass), TRUE);
        $this->db->where($data);
        $error = array();
        if ($this->db->update('usuarios')) return 1;
        else { $error = $this->db->error(); return $error['code']; }
    }
	public function avatar($data)
    {
        $this->db->db_debug = FALSE;
        $this->db->set('avatar', $this->avatar, TRUE);
        $this->db->where($data);
        $error = array();
        if ($this->db->update('usuarios')) return 1;
        else { $error = $this->db->error(); return $error['code']; }
    }
	public function validaDoc($tabla,$where)
	{
		/*$this->db->select('COUNT(numero_documento) as cantidad');
		$this->db->from($tabla);
		$this->db->where($where);*/
		return $this->db->where($where)->from($tabla)->count_all_results();
	}
}