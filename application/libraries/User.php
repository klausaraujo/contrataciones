<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User implements Serializable{
	public $idusuario;
	public $idtipodocumento;
	public $tipo_documento;
	public $numero_documento;
	public $avatar;
	public $apellidos;
	public $nombres;
	public $usuario;
	public $passwd;
	public $idperfil;
	public $activo;
	public $sucursales;
	public $modulos;
	public $menus;
	public $submenus;
	
	public function __construct(){
		//parent::__construct();
	}
	public function jsonSerialize(){
		return get_object_vars($this);
	}
	public function serialize() {
        return serialize($this->datos);
    }
    public function unserialize($datos) {
        $this->datos = unserialize($datos);
    }
}