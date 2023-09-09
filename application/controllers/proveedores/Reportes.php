<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Reportes extends CI_Controller
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
	
	public function nuevoreporte()
	{
		$this->load->model('Reportes_model');
		$anio = $this->Reportes_model->anio();
		$material = $this->Reportes_model->articulos();
		
		$data = array(
			'anio' => $anio,
			'articulo' => $material
		);
		
		$this->load->view('main',$data);
	}
	public function tblreporte1()
	{
		$this->load->model('Reportes_model');
		if($this->input->post('sucursal') && $this->input->post('sucursal') != '') $this->Reportes_model->setSucursal($this->input->post('sucursal'));
		if($this->input->post('anio') && $this->input->post('anio') != '') $this->Reportes_model->setAnio($this->input->post('anio'));
		if($this->input->post('articulo') && $this->input->post('articulo') != '') $this->Reportes_model->setArticulo($this->input->post('articulo'));
		if($this->input->post('productor') && $this->input->post('productor') != '') $this->Reportes_model->setProductor($this->input->post('productor'));
		if($this->input->post('productor') && $this->input->post('productor') != '') $this->Reportes_model->setNombre($this->input->post('productor'));
		
		$segmento = $this->input->post('segmento'); $reporte = [];
		
		if($segmento === 'reporte1') $reporte = $this->Reportes_model->repArticulos();
		elseif($segmento === 'reporte2') $reporte = $this->Reportes_model->repValorizados();
		elseif($segmento === 'reporte3') $reporte = $this->Reportes_model->repXValorizar();
		elseif($segmento === 'reporte4') $reporte = $this->Reportes_model->repCobrar();
		elseif($segmento === 'reporte5') $reporte = $this->Reportes_model->repPagar();
		elseif($segmento === 'reporte6') $reporte = $this->Reportes_model->repMovProv();
		
		echo json_encode(['data' => $reporte]);
	}
	public function pdf()
	{
		$this->load->model('Reportes_model');
		$versionphp = 7; $a5 = 'A4'; $direccion = 'portrait'; $reporte = null;
		
		/*$data = json_decode($_POST['data']);*/
		
		if($this->input->get('s') != '') $this->Reportes_model->setSucursal($this->input->get('s'));
		if($this->input->get('prod') != ''){
			$this->Reportes_model->setProductor($this->input->get('prod'));
			$this->Reportes_model->setNombre($this->input->get('prod'));
			$this->Reportes_model->setProductor($this->input->get('prod'));
		}
		
		if($this->input->get('rep') === 'reporte1' || $this->input->get('rep') === 'reporte2' || $this->input->get('rep') === 'reporte3'){
			if($this->input->get('a') != '') $this->Reportes_model->setAnio($this->input->get('a'));
			if($this->input->get('art') != '') $this->Reportes_model->setArticulo($this->input->get('art'));
		}
		
		if($this->input->get('rep') === 'reporte1') $reporte = $this->Reportes_model->repArticulos();
		elseif($this->input->get('rep') === 'reporte2') $reporte = $this->Reportes_model->repValorizados();
		elseif($this->input->get('rep') === 'reporte3') $reporte = $this->Reportes_model->repXValorizar();
		elseif($this->input->get('rep') === 'reporte4') $reporte = $this->Reportes_model->repCobrar();
		elseif($this->input->get('rep') === 'reporte5') $reporte = $this->Reportes_model->repPagar();
		elseif($this->input->get('rep') === 'reporte6') $reporte = $this->Reportes_model->repMovProv();
		
		if(!empty($reporte)){
			$data = ['reporte' => $reporte];
			
			if(count($reporte) > 500){
				$data['font'] = '11px';
				$data['tamano'] = '80%';
				$data['body'] = '100%';
				$data['title'] = 'Reporte HTML';
				$this->load->view('proveedores/reporte-pdf', $data);
			}else{
				$data['font'] = '9px';
				$data['body'] = '21cm';
				$data['tamano'] = '18cm';
				$data['title'] = 'Reporte PDF';
				$html = $this->load->view('proveedores/reporte-pdf', $data, true);
				
				if(floatval(phpversion()) < $versionphp){
					$this->load->library('dom');
					$this->dom->generate($direccion, $a5, $html, $this->input->get('rep'));
				}else{
					$this->load->library('dom1');
					$this->dom1->generate($direccion, $a5, $html, $this->input->get('rep'));
				}
			}
		}else{ echo '<div class="bg-warning"><h2>No hay registros</h2></div>'; }
	}
	public function excel()
	{
		$this->load->model('Reportes_model');
		$reporte = null;
		
		/*$data = json_decode($_POST['data']);*/
		
		if($this->input->get('s') != '') $this->Reportes_model->setSucursal($this->input->get('s'));
		if($this->input->get('prod') != ''){
			$this->Reportes_model->setProductor($this->input->get('prod'));
			$this->Reportes_model->setNombre($this->input->get('prod'));
			$this->Reportes_model->setProductor($this->input->get('prod'));
		}
		
		if($this->input->get('rep') === 'reporte1' || $this->input->get('rep') === 'reporte2' || $this->input->get('rep') === 'reporte3'){
			if($this->input->get('a') != '') $this->Reportes_model->setAnio($this->input->get('a'));
			if($this->input->get('art') != '') $this->Reportes_model->setArticulo($this->input->get('art'));
		}
		
		if($this->input->get('rep') === 'reporte1') $reporte = $this->Reportes_model->repArticulos();
		elseif($this->input->get('rep') === 'reporte2') $reporte = $this->Reportes_model->repValorizados();
		elseif($this->input->get('rep') === 'reporte3') $reporte = $this->Reportes_model->repXValorizar();
		elseif($this->input->get('rep') === 'reporte4') $reporte = $this->Reportes_model->repCobrar();
		elseif($this->input->get('rep') === 'reporte5') $reporte = $this->Reportes_model->repPagar();
		elseif($this->input->get('rep') === 'reporte6') $reporte = $this->Reportes_model->repMovProv();
		
		if(!empty($reporte)){
			//$cabecera = json_decode(json_encode($reporte[0]), true);
			
			$filename = 'reporte.csv';
			$fp = fopen('php://output', 'w');
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename);
			fputcsv($fp,array_keys((array)$reporte[0]),';');
			
			foreach($reporte as $row):
				fputcsv($fp,array_values((array)$row),';');
			endforeach;
			
			fclose($fp);
			exit;
		}
	}
}