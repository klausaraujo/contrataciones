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
}