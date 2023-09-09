<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Main extends CI_Controller
{
	private $usuario;
	
    public function __construct()
	{
		parent::__construct();
		//$this->load->library('User');
		if($this->session->userdata('user')) $this->usuario = json_decode($this->session->userdata('user'));
		else header('location:' .base_url());
	}

    public function index(){}
	
	public function listaUsuarios()
	{
		$this->load->model('Usuarios_model');
		$usuarios = $this->Usuarios_model->listaUsuarios();
		echo json_encode(['data'=>$usuarios]);
	}
	public function nuevo()
	{
		if($this->uri->segment(1) === 'nuevousuario')header('location:' .base_url(). 'usuarios/nuevo');
		else{
			$this->load->model('Usuarios_model');
			$this->load->model('Proveedores_model');
			$tipodoc = $this->Proveedores_model->tipodoc();
			$perfil = $this->Usuarios_model->perfil();
			$data = array( 'tipodoc' => $tipodoc, 'perfil' => $perfil );
			if($this->uri->segment(2) === 'editar'){
				$id = $this->input->get('id');
				$usuario = $this->Usuarios_model->listaUsuario(['idusuario' => $id]);
				$data['usuario'] = $usuario;
			}
			$this->load->view('main',$data);
		}
	}
	public function registrar()
	{
		$this->session->set_flashdata('claseMsg', 'alert-danger');
		$this->load->model('Usuarios_model');
		if($this->input->post('tipodoc') != '' && $this->input->post('doc') != '' && $this->input->post('apellidos') != '' && $this->input->post('nombres') != ''
			&& $this->input->post('usuario') != '' && $this->input->post('perfil') != '' && $this->input->post('tiporegistro') === 'registrar')
		{
			$data = array(
				'idtipodocumento' => $this->input->post('tipodoc'),
				'numero_documento' => $this->input->post('doc'),
				'apellidos' => $this->input->post('apellidos'),
				'nombres' => $this->input->post('nombres'),
				'usuario' => $this->input->post('usuario'),
				'idperfil' => $this->input->post('perfil'),
				'avatar' => 'user.jpg',
				'passwd' => sha1($this->input->post('doc')),
				'activo' => 1,
			);
			$this->session->set_flashdata('flashMessage', 'No se pudo registrar el <b>Usuario</b>');
			if($this->Usuarios_model->registrar($data)){
				$this->session->set_flashdata('claseMsg', 'alert-primary');
				$this->session->set_flashdata('flashMessage', '<b>Usuario</b> Registrado Exitosamente');
			}
		}elseif($this->input->post('perfil') != '' && $this->input->post('tiporegistro') === 'editar'){
			$id = $this->input->post('idusuario');
			$this->session->set_flashdata('flashMessage', 'No se pudo actualizar el <b>Usuario</b>');
			if($this->Usuarios_model->actualizar( ['idperfil' => $this->input->post('perfil')], ['idusuario'=>$id] )){
				$this->session->set_flashdata('flashMessage', '<b>Usuario</b> Actualizado');
				$this->session->set_flashdata('claseMsg', 'alert-primary');
			}
		}else{
			$this->session->set_flashdata('flashMessage', 'No se pudo registrar el Usuario por campos vac&iacute;os');
		}
		
		header('location:'.base_url().'usuarios');
	}
	public function habilitar()
	{
		$id = $this->input->get('id'); $stat = $this->input->get('stat'); $msg = ''; $status = 500;
		$this->load->model('Usuarios_model');
		
		if($stat === '1'){
			$msg = 'No se pudo deshabilitar el Usuario';
			if($this->Usuarios_model->actualizar( ['activo'=> 0], ['idusuario'=>$id] )){
				$status = 200;
				$msg = 'Usuario deshabilitado';
			}
		}else{
			$msg = 'No se pudo habilitar el Usuario';
			if($this->Usuarios_model->actualizar( ['activo'=> 1], ['idusuario'=>$id] )){
				$status = 200;
				$msg = 'Usuario habilitado';
			}
		}
		
		$data = array(
			'status' => $status,
			'msg' => $msg
		);
		
		echo json_encode($data);
		//header('location:'. base_url() .'usuarios');
	}
	public function resetear()
	{
		$id = $this->input->get('id'); $doc = $this->input->get('doc'); $status = 500;
		$this->load->model('Usuarios_model');
		
		if($this->Usuarios_model->actualizar( ['passwd'=> sha1($doc)], ['idusuario'=>$id] )) $status = 200;
		
		echo json_encode(['status'=> $status]);
	}
	public function permisosUsuario()
	{
		$id = $this->input->get('id');
		$this->load->model('Usuarios_model');
		$permisos = $this->Usuarios_model->buscaPermisos(['idusuario'=>$id]);
		$modulos = $this->Usuarios_model->permisosModulos(['u.idusuario'=>$id,'mr.activo' => 1]);
		$menus = $this->Usuarios_model->permisosMenus(['idusuario'=>$id, 'activo' => 1]);
		$submenus = $this->Usuarios_model->permisosMenuDetalle(['idusuario'=>$id, 'activo' => 1]);
		$idperfil = !empty($modulos)? $modulos[0]->idperfil : '';
		$perfil = !empty($modulos)? $modulos[0]->perfil : '';
		
		$data = array(
			'data' => $permisos,
			'idusuario' => $id,
			'modulos' => $modulos,
			'menus' => $menus,
			'submenus' => $submenus,
			'idperfil' => $idperfil,
			'perfil' => $perfil,
		);
		
		echo json_encode($data);
	}
	public function asignarPermisos()
	{
		$this->load->model('Usuarios_model');
		$arrayPer = []; $i = 0; $msg = 'No se pudo asignar los permisos'; $status = 500; $modulos = []; $arrayMenu = []; $arraySubm = [];
		
		$id = (isset($_POST['idusuarioPer'])?$_POST['idusuarioPer'] : '');
		$permisos = (isset($_POST['permisos'])?$_POST['permisos'] : array());
		$menus = (isset($_POST['menus'])?$_POST['menus'] : array());
		$submenus = (isset($_POST['submenus'])?$_POST['submenus'] : array());
		$perMod = (isset($_POST['modPer'])?$_POST['modPer'] : array());
		$idperfil = (isset($_POST['perfilUsuario'])?$_POST['perfilUsuario'] : '');
		
		if(!empty($permisos)){
			foreach($permisos as $row):
				$arrayPer[$i] = ['idpermiso'=>$row,'idusuario'=>$id,'activo'=>1];
				$i++;
			endforeach;
		}
		if(!empty($menus)){
			$i = 0;
			foreach($menus as $row):
				$arrayMenu[$i] = ['idmenu'=>$row,'idusuario'=>$id,'activo'=>1];
				$i++;
			endforeach;
		}
		if(!empty($submenus)){
			$i = 0;
			foreach($submenus as $row):
				$arraySubm[$i] = ['idmenudetalle'=>$row,'idusuario'=>$id,'activo'=>1];
				$i++;
			endforeach;
		}
		$regPer = $this->Usuarios_model->registrarPer(['idusuario'=>$id],$arrayPer,'permisos_opcion');
		$regMenu = $this->Usuarios_model->registrarPer(['idusuario'=>$id],$arrayMenu,'permisos_menu');
		$regSub = $this->Usuarios_model->registrarPer(['idusuario'=>$id],$arraySubm,'permisos_menu_detalle');
		$regMod = $this->Usuarios_model->actualizaModulosUser(['activo' => 1],$perMod,['idperfil' => $idperfil]);
		
		if($regPer || $regMenu || $regSub || $regMod){ $msg = 'Permisos Asignados'; $status = 200; }
		
		echo json_encode(['msg'=>$msg, 'status'=>$status]);
	}
	public function sucursalesUsuario()
	{
		$id = $this->input->get('id');
		$this->load->model('Usuarios_model');
		$sucursales = $this->Usuarios_model->buscaSucursales(['idusuario'=>$id]);
		
		echo json_encode(['data'=>$sucursales,'idusuario'=>$id]);
	}
	public function asignarSucursales()
	{
		$this->load->model('Usuarios_model');
		$perSuc = (isset($_POST['usuariosSuc'])?$_POST['usuariosSuc'] : array()); $id = (isset($_POST['idusuarioSuc'])?$_POST['idusuarioSuc'] : '');
		$dataArray = []; $i = 0; $msg = 'No se pudo asignar los sucursales'; $status = 500;
		
		if(!empty($perSuc)){
			foreach($perSuc as $row):
				$dataArray[$i] = ['idsucursal'=>$row,'idusuario'=>$id,'activo'=>1];
				$i++;
			endforeach;
		}
		
		$regPer = $this->Usuarios_model->registrarPer(['idusuario'=>$id],$dataArray,'usuarios_sucursal');
		
		if($regPer){ $msg = 'Sucursales Asignadas'; $status = 200; }
		
		echo json_encode(['msg'=>$msg, 'status'=>$status,'data'=>$dataArray]);
	}
}