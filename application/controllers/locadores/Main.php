<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Main extends CI_Controller
{
	private $usuario;
	
    public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user')) $this->usuario = json_decode($this->session->userdata('user'));
		else header('location:' .base_url());
	}

    public function index(){}
	
	public function listaLocadores()
	{
		$this->load->model('Locadores_model');
		$locadores = $this->Locadores_model->listaLocadores();
		echo json_encode(['data'=>$locadores]);
	}
	public function nueva()
	{
		if($this->uri->segment(1) === 'nuevaconvocatoria')header('location:' .base_url(). 'locadores/nueva');
		else{
			$this->load->model('Locadores_model');
			$convocatoria = array();
			$dependencia = $this->Locadores_model->dependencia(['activo' => 1]);
			$estado = $this->Locadores_model->estado(['activo' => 1]);
			
			if($this->uri->segment(2) === 'editar'){
				$id = $this->input->get('id');
				$convocatoria = $this->Locadores_model->listaConvocatoria(['idconvocatoria' => $id]);
			}
			$data = array(
				'dependencia' => $dependencia,
				'estado' => $estado,
				'convocatoria' => $convocatoria,
			);
			$this->load->view('main',$data);
		}
	}
	public function registrar()
	{
		$this->load->model('Locadores_model');
		$this->session->set_flashdata('claseMsg', 'alert-danger');
		$path =  $_SERVER['DOCUMENT_ROOT'].'/contrataciones/public/adjuntos/anexos_locadores/'; $nombre = ''; $nombre1 = ''; $guardado = false;
		
		if($_FILES['customfile']['name'] !== '' && $_FILES['customfile']['name'] !== $this->input->post('file1')){
			$split = explode('.',$_FILES['customfile']['name']);
			$nombre = date('YmdHis').'.'.end($split);
			
			$config['upload_path'] = $path;
			$config['file_name'] = $nombre;
			$config['allowed_types'] = 'gif|jpg|png|pdf';
			$config['max_size'] = 0;
			$config['max_width'] = 0;
			$config['max_height'] = 0;
			$config['overwrite'] = true;
			
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			if ($this->upload->do_upload('customfile')){
				if($_FILES['customfile1']['name'] !== '' && $_FILES['customfile1']['name'] !== $this->input->post('file2')){
					$split = explode('.',$_FILES['customfile1']['name']);
					$nombre1 = (date('YmdHis')+1).'.'.end($split);
					
					$config['upload_path'] = $path;
					$config['file_name'] = $nombre1;
					$config['allowed_types'] = 'gif|jpg|png|pdf';
					$config['max_size'] = 0;
					$config['max_width'] = 0;
					$config['max_height'] = 0;
					$config['overwrite'] = true;
					
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					
					if ($this->upload->do_upload('customfile1')){
						$guardado = true;
					}else{
						unlink($path.$nombre);
						$this->session->set_flashdata('errorImage', 'Archivos adjuntos no v&aacute;lidos');
						$this->session->set_flashdata('claseImg', 'alert-danger');
						header('location:'.base_url().'locadores/nueva');
					}
				}else{
					$nombre1 = $this->input->post('file2');
					$guardado = true;
				}
			}else{
				//var_dump($this->upload->display_errors());
				$this->session->set_flashdata('errorImage', 'Archivos adjuntos no v&aacute;lidos');
				$this->session->set_flashdata('claseImg', 'alert-danger');
				header('location:'.base_url().'locadores/nueva');
			}
		}else{
			$nombre = $this->input->post('file1');
			$nombre1 = $this->input->post('file2');
			$guardado = true;
		}
		
        if($guardado){
			if($this->input->post('tiporegistro') === 'registrar'){
				$this->session->set_flashdata('flashMessage', 'No se pudo registrar la <b>Convocatoria</b>');
				$data = array(
					'iddependencia' => $this->input->post('dependencia'),
					'denominacion' => $this->input->post('denominacion'),
					'idestado' => 1,
					'fecha_inicio' => $this->input->post('finicio'),
					'fecha_fin' => $this->input->post('ffin'),
					'monto' => $this->input->post('monto'),
					'archivo_base' => $nombre,
					'archivo_anexos' => $nombre1,
					'idusuario_registro' => $this->usuario->idusuario,
					'fecha_registro' => date('Y-m-d H:i:s'),
					'activo' => 1,
				);
				if($this->Locadores_model->registrar($data)){
					$this->session->set_flashdata('flashMessage', '<b>Convocatoria</b> Registrada');
					$this->session->set_flashdata('claseMsg', 'alert-primary');
				}
			}elseif($this->input->post('tiporegistro') === 'editar'){
				$id = $this->input->post('idconvocatoria');
				$this->session->set_flashdata('flashMessage', 'No se pudo actualizar la <b>Convocatoria</b>');
				
				$data = array(
					'iddependencia' => $this->input->post('dependencia'),
					'denominacion' => $this->input->post('denominacion'),
					'idestado' => $this->input->post('idestado'),
					'fecha_inicio' => $this->input->post('finicio'),
					'fecha_fin' => $this->input->post('ffin'),
					'monto' => $this->input->post('monto'),
					'archivo_base' => $nombre,
					'archivo_anexos' => $nombre1,
					'idusuario_modificacion' => $this->usuario->idusuario,
					'fecha_modificacion' => date('Y-m-d H:i:s'),
				);
				if($this->Locadores_model->actualizar( $data, ['idconvocatoria'=>$id] )){
					$this->session->set_flashdata('flashMessage', '<b>Convocatoria</b> Actualizada');
					$this->session->set_flashdata('claseMsg', 'alert-primary');
				}
			}
			header('location:'.base_url().'locadores');
		}
	}
}