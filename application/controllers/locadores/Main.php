<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Main extends CI_Controller
{
	private $usuario;
	
    public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Lima');
		if($this->session->userdata('user')) $this->usuario = json_decode($this->session->userdata('user'));
		else header('location:' .base_url());
	}

    public function index(){}
	
	public function listaLocadores()
	{
		$this->load->model('Locadores_model');
		$locadores = $this->Locadores_model->listaLocadores(); $hoy = time();
		foreach($locadores as $row):
			if((strtotime($row->fecha_fin) - $hoy) < 0){
				$cta = $this->Locadores_model->validaLista(['idconvocatoria' => $row->idconvocatoria]);
				if($cta === 0)
					$this->Locadores_model->actualizar(
						['idestado' => 4],
						['idconvocatoria' => $row->idconvocatoria,'idestado' => 1],
						'convocatoria_locadores'
					);
				elseif($cta > 0)
					$this->Locadores_model->actualizar(
						['idestado' => 2],
						['idconvocatoria' => $row->idconvocatoria,'idestado' => 1],
						'convocatoria_locadores'
					);
			}
		endforeach;
		$listaactualizada = $this->Locadores_model->listaLocadores();
		
		echo json_encode(['data' => $listaactualizada]);
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
		$this->session->set_flashdata('claseMsg', 'alert-danger'); $nombre = ''; $nombre1 = ''; $guardado = false; $data = [];
		$itiempo = date_format(date_create($this->input->post('finicio')),'Y-m-d H:i');
		$ftiempo = date_format(date_create($this->input->post('ffin')),'Y-m-d H:i');
		
		if($this->input->post('file1ant') === $this->input->post('file1') && $this->input->post('tiporegistro') === 'editar'){
			$nombre = $this->input->post('file1ant');
		}
		if($this->input->post('file2ant') === $this->input->post('file2') && $this->input->post('tiporegistro') === 'editar'){
			$nombre1 = $this->input->post('file2ant');
		}
		
		if($nombre === ''){
			$data = $this->cargaanexo($_FILES['customfile'],0,'customfile');
			if($data['status'] === 200) $nombre = $data['nombre'];
			else{
				$this->session->set_flashdata('errorImage', 'Archivos adjuntos no v&aacute;lidos');
				$this->session->set_flashdata('claseImg', 'alert-danger');
				if($this->input->post('tiporegistro') === 'editar') header('location:'.base_url().'locadores/editar?id='.$this->input->post('idconvocatoria'));
				elseif($this->input->post('tiporegistro') === 'registrar') header('location:'.base_url().'locadores/nueva');
			}
		}
		if($nombre1 === ''){
			$data = $this->cargaanexo($_FILES['customfile1'],1,'customfile1');
			if($data['status'] === 200) $nombre1 = $data['nombre'];
			else{
				$this->session->set_flashdata('errorImage', 'Archivos adjuntos no v&aacute;lidos');
				$this->session->set_flashdata('claseImg', 'alert-danger');
				if($this->input->post('tiporegistro') === 'editar') header('location:'.base_url().'locadores/editar?id='.$this->input->post('idconvocatoria'));
				elseif($this->input->post('tiporegistro') === 'registrar') header('location:'.base_url().'locadores/nueva');
			}
		}
		
		if($this->input->post('tiporegistro') === 'registrar'){
			$this->session->set_flashdata('flashMessage', 'No se pudo registrar la <b>Convocatoria</b>');
			$data = array(
				'iddependencia' => $this->input->post('dependencia'),
				'denominacion' => $this->input->post('denominacion'),
				'idestado' => 1,
				'fecha_inicio' => $itiempo,
				'fecha_fin' => $ftiempo,
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
				'fecha_inicio' => $itiempo,
				'fecha_fin' => $ftiempo,
				'monto' => $this->input->post('monto'),
				'archivo_base' => $nombre,
				'archivo_anexos' => $nombre1,
				'idusuario_modificacion' => $this->usuario->idusuario,
				'fecha_modificacion' => date('Y-m-d H:i:s'),
			);
			
			if($this->Locadores_model->actualizar($data, ['idconvocatoria'=>$id], 'convocatoria_locadores')){
				$this->session->set_flashdata('flashMessage', '<b>Convocatoria</b> Actualizada');
				$this->session->set_flashdata('claseMsg', 'alert-primary');
			}
		}
		header('location:'.base_url().'locadores');
	}
	public function cargaanexo($file,$i,$n)
	{
		$path =  $_SERVER['DOCUMENT_ROOT'].'/contrataciones/public/adjuntos/anexos_locadores/'; $status = 500; $nombre = '';
		
		if($file['name'] !== ''){
			$split = explode('.',$file['name']);
			$nombre = (date('YmdHis')+$i).'.'.end($split);
			
			$config['upload_path'] = $path;
			$config['file_name'] = $nombre;
			$config['allowed_types'] = 'docx|doc|pdf';
			$config['max_size'] = 0;
			$config['max_width'] = 0;
			$config['max_height'] = 0;
			$config['overwrite'] = true;
			
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			if($this->upload->do_upload($n)) $status = 200;
		}
		return array('status' => $status, 'nombre' => $nombre);
	}
	public function descargar()
	{
		$path =  $_SERVER['DOCUMENT_ROOT'].'/contrataciones/public/adjuntos/anexos_locadores/';
		$filen = basename($this->input->get('file')); $type = '';
		if(is_file($path.$filen)){
			$size = filesize($path.$filen);
		 
			if(function_exists('mime_content_type')) {
				$type = mime_content_type($path.$filen);
			}else if (function_exists('finfo_file')) {
				$info = finfo_open(FILEINFO_MIME);
				$type = finfo_file($info, $path.$filen);
				finfo_close($info);
			}
		 
			if ($type == '') {
				$type = "application/force-download";
			}
			header('Content-Description: File Transfer');
			header("Content-Type: $type");
			header("Content-Disposition: attachment; filename=$filen");
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header("Content-Length: $size");
			ob_clean();
			flush();
			readfile($path.$filen);
			exit();
		}
	}
	public function descargarp()
	{
		$path =  $_SERVER['DOCUMENT_ROOT'].'/contrataciones/public/adjuntos/anexos_postulantes/';
		$filen = basename($this->input->get('file')); $type = '';
		if(is_file($path.$filen)){
			$size = filesize($path.$filen);
		 
			if(function_exists('mime_content_type')) {
				$type = mime_content_type($path.$filen);
			}else if (function_exists('finfo_file')) {
				$info = finfo_open(FILEINFO_MIME);
				$type = finfo_file($info, $path.$filen);
				finfo_close($info);
			}
		 
			if ($type == '') {
				$type = "application/force-download";
			}
			header('Content-Description: File Transfer');
			header("Content-Type: $type");
			header("Content-Disposition: attachment; filename=$filen");
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header("Content-Length: $size");
			ob_clean();
			flush();
			readfile($path.$filen);
			exit();
		}
	}
	public function cancelar()
	{
		$this->load->model('Locadores_model');
		$id = $this->input->get('id'); $msg = 'No se pudo Cancelar la convocatoria'; $status = 500;
		
		if($this->Locadores_model->actualizar(
			['idestado' => 3,'idusuario_modificacion' => $this->usuario->idusuario,'fecha_modificacion' => date('Y-m-d H:i')],
			['idconvocatoria' => $id],
			'convocatoria_locadores'
		)){
			$status = 200;
			$msg = 'Convocatoria cancelada';
		}
		
		$data = array(
			'status' => $status,
			'msg' => $msg
		);
		
		echo json_encode($data);
	}
	public function evaluar()
	{
		$this->load->model('Locadores_model'); $id = $this->input->get('id');
		$postulantes = $this->Locadores_model->listaPostulantes(['idconvocatoria' => $id]);
		$this->load->view('main', ['data' => $postulantes]);
	}
	public function evaluado()
	{
		$this->load->model('Locadores_model');
		$this->session->set_flashdata('flashMessage', 'No se pudo Evaluar'); $this->session->set_flashdata('claseMsg', 'alert-danger');
		$data = json_decode($_GET['json']);
		foreach($data as $row):
			if($this->Locadores_model->actualizar(['puntaje' => $row->puntaje,'ganador' => $row->ganador],
					['idpostulacion' => $row->idpostulacion],'convocatoria_locadores_postulantes')){
				$this->session->set_flashdata('flashMessage', 'Evaluado con &Eacute;xito');
				$this->session->set_flashdata('claseMsg', 'alert-primary');
			}				
		endforeach;
		header('location:'.base_url().'locadores');
	}
}