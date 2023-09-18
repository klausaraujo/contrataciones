<?php
Class Funciones{
	private $host = 'localhost';
	private $user = 'root';
	private $pass = '12345678';
	private $database = 'contrataciones';
	private $db;
	
	function __construct()
	{
		$this->db = new mysqli($this->host, $this->user, $this->pass, $this->database);
		if($this->db->errno) die($this->db->error);
	}
	public function listar($dep)
	{
		$where = '';
		if($dep !== '') $where = ' AND cl.iddependencia='.$dep;
		
		$query = 'SELECT cl.*,d.descripcion,e.descripcion as estado,DATE_FORMAT(fecha_inicio,"%d/%m/%Y") as fecha_inicio,DATE_FORMAT(fecha_fin,"%d/%m/%Y") as fecha_fin,
			DATE_FORMAT(fecha_inicio,"%l:%i %p") as hini,DATE_FORMAT(fecha_fin,"%l:%i %p") as hfin
			FROM convocatoria_locadores cl INNER JOIN dependencia d ON cl.iddependencia=d.iddependencia INNER JOIN estado e ON cl.idestado=e.idestado WHERE cl.activo=1'.$where;
		$res = $this->db->query($query);
		$this->db->close();
		
		if($res->num_rows > 0) return $res->fetch_all(MYSQLI_ASSOC);
		else return array();
	}
	public function dependencias()
	{
		$query = 'SELECT * FROM dependencia WHERE activo=1';
		$res = $this->db->query($query);
		$this->db->close();
		
		if($res->num_rows > 0) return $res->fetch_all(MYSQLI_ASSOC);
		else return array();
	}
	public function profesiones()
	{
		$query = 'SELECT * FROM profesion WHERE activo=1';
		$res = $this->db->query($query);
		
		if($res->num_rows > 0) return $res->fetch_all(MYSQLI_ASSOC);
		else return array();
	}
	public function nivel()
	{
		$query = 'SELECT * FROM nivel WHERE activo=1';
		$res = $this->db->query($query);
		
		if($res->num_rows > 0) return $res->fetch_all(MYSQLI_ASSOC);
		else return array();
	}
	public function departamentos()
	{
		$query = 'SELECT DISTINCT(departamento),cod_dep FROM ubigeo WHERE activo=1';
		$res = $this->db->query($query);
		
		if($res->num_rows > 0) return $res->fetch_all(MYSQLI_ASSOC);
		else return array();
	}
	public function close()
	{
		$this->db->close();
	}
}

function descargar()
{
	$path =  $_SERVER['DOCUMENT_ROOT'].'/contrataciones/public/adjuntos/anexos_locadores/';
	$filen = basename($_GET['file']); $type = '';
	if(is_file($path.$filen)){
		$size = filesize($path.$filen);
	 
		if(function_exists('mime_content_type')) {
			$type = mime_content_type($path.$filen);
		}else if (function_exists('finfo_file')) {
			$info = finfo_open(FILEINFO_MIME);
			$type = finfo_file($info, $path.$filen);
			finfo_close($info);
		}
	 
		if ($type == '') $type = "application/force-download";
		
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

if($_POST['data'] === 'listar'){
	$con = new Funciones(); $lista = [];
	$lista = $con->listar($_POST['dep']);
	echo json_encode([data => $lista]);
}elseif($_GET['act'] === 'descargar'){
	descargar();
}

