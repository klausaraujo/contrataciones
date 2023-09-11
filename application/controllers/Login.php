<?php
if (! defined("BASEPATH"))
    exit("No direct script access allowed");

class Login extends CI_Controller
{
	private $usuario;
	
    public function __construct(){
		parent::__construct();
		$this->load->library('User');
	}

    public function index(){
		if($this->session->userdata('user'))$this->load->view('main');
		else header('location:'.base_url().'login');
	}
	public function login(){
		$this->load->view('login');
	}
	public function dologin(){
		$this->load->model('Usuario_model');
		$this->load->model('Menu_model');
		$data = ['usuario' => $this->input->post('usuario'), 'passwd' => sha1($this->input->post('pass'))];
		
		$result = $this->Usuario_model->iniciar($data);
		$this->session->set_flashdata('usuarioError', $this->input->post('usuario'));
		
		if($result->num_rows() > 0){
			$usuario = $result->custom_row_object(0,'User');
			
			if($usuario->activo === '0') {
                $this->session->set_flashdata('loginError', 'Usuario deshabilitado');
                header('location:' .base_url(). 'login');
            }else{
				$usuario->modulos = $this->Usuario_model->listaModulo(['idperfil' => $usuario->idperfil]);
				$usuario->menus = $this->Menu_model->listaMenuPermisos(['idusuario' => $usuario->idusuario]);
				$usuario->submenus = $this->Menu_model->listaSubMenuPermisos(['idusuario' => $usuario->idusuario]);
				$usuario->menugeneral = $this->Menu_model->listaMenu();
				$usuario->submenugeneral = $this->Menu_model->listaSubMenu();
				//$userialize = serialize($usuario);
				$this->session->set_userdata('user', json_encode($usuario));
				
				header('location:' .base_url());
			}
		}else {
            $this->session->set_flashdata('loginError', 'Usuario o contrase&ntilde;a incorrectos');
            header('location:' .base_url(). 'login');
        }
	}
	public function logout(){
		$this->session->sess_destroy();
        header('location:' .base_url());
	}
}