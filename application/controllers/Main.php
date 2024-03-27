<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Main extends CI_Controller
{
	private $usuario;
	private $absolutePath;
	private $modulo = false;
	
    public function __construct(){
		parent::__construct();
		date_default_timezone_set('America/Lima');
		if($this->session->userdata('user')){
			$this->usuario = json_decode($this->session->userdata('user'));
			$this->absolutePath = $_SERVER['DOCUMENT_ROOT'].'/contrataciones/';
			$seg = $this->uri->segment(1);
			foreach($this->usuario->modulos as $mod):
				if($mod->url === $seg){
					if($mod->activo) $this->modulo = true;
				}
			endforeach;
			
			if($seg === 'main') $this->modulo = true;
			
			if(!$this->modulo) header('location:' .base_url());
			
		}else header('location:' .base_url());
	}

    public function index(){}
	
	public function usuarios()
	{
		$this->load->model('Usuarios_model');
		$idmodulo = '';
		foreach($this->usuario->modulos as $valor):
			if($valor->url === $this->uri->segment(1)){
				$idmodulo = $valor->idmodulo; break;
			}
		endforeach;
		$bot = $this->Usuarios_model->buscaPerByModByUser(['idusuario' => $this->usuario->idusuario,'idmodulo' => $idmodulo,'po.activo' => 1]);
		$this->session->set_userdata('perUser', json_encode($bot));
		$permisos = $this->Usuarios_model->permisosOpciones();
		$modulos = $this->Usuarios_model->buscaModulos();
		
		$headers = array(
			'0'=>['title' => 'Acciones', 'targets' => 0],'1'=>['title' => 'ID', 'targets' => 1],'2'=>['title' => 'Documento', 'targets' => 2],
			'3'=>['title' => 'N&uacute;mero', 'targets' => 3],'4'=>['title' => 'Avatar', 'targets' => 4],'5'=>['title' => 'Apellidos', 'targets' => 5],
			'6'=>['title' => 'nombres', 'targets' => 6],'7'=>['title' => 'Usuario', 'targets' => 7],'8'=>['title' => 'Perfil', 'targets' => 8],
			'9'=>['title' => 'Estado', 'targets' => 9],'10'=>['targets' => 'no-sort', 'orderable' => false],'11'=>['targets' => 1, 'visible' => false],
		);
		$data = array(
			'permisos' => $permisos,
			'headers' => $headers,
			'modulos' => $modulos,
		);
		$this->load->view('main',$data);
	}
	public function locadores()
	{
		$this->load->model('Locadores_model');
		$this->load->model('Usuarios_model');
		foreach($this->usuario->modulos as $valor):
			if($valor->url === $this->uri->segment(1)){
				$idmodulo = $valor->idmodulo; break;
			}
		endforeach;
		$bot = $this->Usuarios_model->buscaPerByModByUser(['idusuario' => $this->usuario->idusuario,'idmodulo' => $idmodulo,'po.activo' => 1]);
		$this->session->set_userdata('perLocadores', json_encode($bot));
		
		$headers = array(
			'0'=>['title' => 'Acciones', 'targets' => 0],'1'=>['title' => 'ID', 'targets' => 1],'2'=>['title' => 'Dependencia', 'targets' => 2],
			'3'=>['title' => 'Denominaci&oacute;n', 'targets' => 3],'4'=>['title' => 'Estado', 'targets' => 4],'5'=>['title' => 'F.Inicio', 'targets' => 5],
			'6'=>['title' => 'F.Fin', 'targets' => 6],'7'=>['title' => 'Base', 'targets' => 7],'8'=>['title' => 'Anexos', 'targets' => 8],
			'9'=>['title' => 'F.Registro', 'targets' => 9],'10'=>['targets' => 'no-sort', 'orderable' => false],'11'=>['targets' => 1, 'visible' => false],
			
		);
		$data = array(
			'headers' => $headers,
		);
		$this->load->view('main',$data);
	}
	public function curl(){
		$token_ruc = 'Bearer apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';//10460278975
		$api = 'http://mpi.minsa.gob.pe/api/v1/ciudadano/ver/';
        $token_reniec = 'Bearer d90f5ad5d9c64268a00efaa4bd62a2a0';
        $doc = $this->input->post('doc'); $tipo = $this->input->post('tipo'); $tabla = $this->input->post('tabla');
		$token = ($tipo === '05')? $token_ruc : $token_reniec;
		$data = [];
		
		$repetido = $this->buscaDoc($doc,$tabla);
		
		if($repetido){
			$data = ['data' => array(), 'valida' => $repetido];
		}else{
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $api.$tipo.'/'.$doc.'/',
				CURLOPT_HEADER => false,
				CURLOPT_MAXREDIRS => 2,
				CURLOPT_HTTPHEADER => array('Authorization: '.$token, 'Content-Type: application/json'),
				CURLOPT_RETURNTRANSFER => true,
			));		
			$data = curl_exec($curl);
			$data = ['data' => $data, 'valida' => $repetido];
			//$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			curl_close($curl);
		}

        echo json_encode($data);
	}
	public function buscaDoc($doc,$tabla)
	{
		$this->load->model('Usuario_model');
		return $this->Usuario_model->validaDoc($tabla,['numero_documento' => $doc]);
	}
	public function perfil(){ $this->load->view('main'); }
	
	public function upload(){
		$path = $this->absolutePath.'public/images/perfil/';
		$nombre = $_FILES['perfil']['name'];
		$size = $_FILES['perfil']['size'];
		
        $config['upload_path'] = $path;
        $config['file_name'] = $nombre;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 0;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
		$config['overwrite'] = true;
		
		$this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('perfil')) {
            $data = array('error' => $this->upload->display_errors());
			//$this->load->view('upload_form', $error);
        }else{
			$resp = (object)$this->upload->data();
			$error_resize = 0; $avatar = 0;
			if($resp->image_width > 460){
				$config['image_library'] = 'gd2';
				$config['source_image'] = $path.$nombre;
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 400;
				//$config['height'] = 320;
				//$error_resize = 'Entro en resize';
				$this->load->library('image_lib', $config);
				if(! $this->image_lib->resize()) $error_resize = $this->image_lib->display_errors();
			}
			$this->load->model('Usuario_model');
			$this->Usuario_model->setAvatar($nombre);
			$avatar = $this->Usuario_model->avatar(['idusuario' => $this->usuario->idusuario]);
			if($avatar === 1){ $this->usuario->avatar = $nombre; $this->session->set_userdata('user', json_encode($this->usuario)); }
			
			$data = array('upload_data' => $resp, 'resize' => $error_resize, 'avatar' => $this->usuario->avatar);
		}
		echo json_encode($data);
	}
	public function password()
    {
        $this->load->model('Usuario_model');
        
        $actual = $this->input->post('old_password');
        $password = $this->input->post('password');
        $id = $this->input->post('cod_usuario');
		$status = 500;
        $message = 'Contrase&ntilde;a actual no coincide';
		
		$this->Usuario_model->setPassword($actual);
		$validacion = $this->Usuario_model->validar_password(['idusuario' => $this->usuario->idusuario]);
		
		if($validacion === 1){
			$message = 'No se pudo actualizar la contrase&ntilde;a';
			$this->Usuario_model->setPassword($password);            
            if ($this->Usuario_model->password(['idusuario' => $id]) === 1){
                $message = 'La contrase&ntilde;a ha sido actualizada';
                $status = 200;
            }
        }
        echo json_encode(array('status'=>$status,'message'=>$message));
    }
	/*
	public function provincias(){
		$this->load->model('Proveedores_model');
		
		$listaProv = $this->Proveedores_model->provincias(['cod_dep'=>$this->input->post('cod_dep')]);
		
        echo json_encode($listaProv);
	}
	public function distritos(){
		$this->load->model('Proveedores_model');
		
		$listaDis = $this->Proveedores_model->distritos(['cod_dep'=>$this->input->post('cod_dep'),'cod_pro'=>$this->input->post('cod_pro')]);
		
        echo json_encode($listaDis);
	}
	public function cargarLatLng(){
		$this->load->model('Proveedores_model');
		$ubigeo = $this->input->post('cod_dep').$this->input->post('cod_pro').$this->input->post('cod_dis');
		$latLng = $listaDis = $this->Proveedores_model->latLng(['ubigeo'=>$ubigeo]);
		echo json_encode($latLng);
	}
	public function ruccurl()
	{
		$url = 'https://api.apis.net.pe/v1/ruc?numero='.$this->input->post('ruc');

		$curl = curl_init();
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => trim($url),
			CURLOPT_MAXREDIRS => 5,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_HEADER => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		));
		
		$result = curl_exec($curl);
		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		
		echo json_encode(array('data' => json_decode($result),'status' => $code));
	}*/
}