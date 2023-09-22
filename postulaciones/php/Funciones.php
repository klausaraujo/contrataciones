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
			DATE_FORMAT(fecha_inicio,"%l:%i %p") as hini,DATE_FORMAT(fecha_fin,"%l:%i %p") as hfin FROM convocatoria_locadores cl INNER JOIN dependencia d ON 
			cl.iddependencia=d.iddependencia INNER JOIN estado e ON cl.idestado=e.idestado WHERE cl.activo=1'.$where.' ORDER BY fecha_registro DESC';
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
	public function tipodoc()
	{
		$query = 'SELECT * FROM tipo_documento WHERE activo=1';
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
	public function provincias($where)
	{
		$query = 'SELECT DISTINCT(provincia),cod_pro FROM ubigeo WHERE activo=1 AND cod_dep='.$where;
		$res = $this->db->query($query);
		
		if($res->num_rows > 0) return $res->fetch_all(MYSQLI_ASSOC);
		else return array();
	}
	public function distritos($dep,$pro)
	{
		$query = 'SELECT DISTINCT(distrito),cod_dis FROM ubigeo WHERE activo=1 AND cod_dep='.$dep.' AND cod_pro='.$pro;
		$res = $this->db->query($query);
		
		if($res->num_rows > 0) return $res->fetch_all(MYSQLI_ASSOC);
		else return array();
	}
	public function coordenadas($ubigeo)
	{
		$query = 'SELECT latitud,longitud FROM ubigeo WHERE activo=1 AND ubigeo='.$ubigeo.' limit 1';
		$res = $this->db->query($query);
		
		if($res->num_rows > 0) return $res->fetch_all(MYSQLI_ASSOC);
		else return array();
	}
	public function repetido($id,$nr)
	{
		$query = 'SELECT idpostulacion FROM convocatoria_locadores_postulantes WHERE idconvocatoria='.$id.' AND numero_documento='.$nr;
		$res = $this->db->query($query);
		
		return $res->num_rows;
	}
	public function guardar_postulacion($anexos,$ubigeo)
	{
		$query = "INSERT INTO convocatoria_locadores_postulantes (idconvocatoria,idtipodocumento,numero_documento,numero_ruc,nombre,domicilio,celular,correo,ubigeo,latitud,
			longitud,idprofesion,idnivel,anexo_01,anexo_02,anexo_03,anexo_04,anexo_05,anexo_06,fecha_postulacion) VALUES ('".$_POST['idconvocatoria']."','".$_POST['tipodoc']."','"
			.$_POST['doc']."','".$_POST['ruc']."','".$_POST['nombres']."','".$_POST['direccion']."','".$_POST['celular']."','".$_POST['email']."','".$ubigeo."','".$_POST['lat']."','"
			.$_POST['lng']."','".$_POST['profesion']."','".$_POST['nivel']."','".$anexos."','".date('Y-m-d H:i')."')";
		
		if($this->db->query($query)) return true;
		else return $this->db->error;
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

function curl(){
	//$token_ruc = 'Bearer apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';//10460278975
	$api = 'http://mpi.minsa.gob.pe/api/v1/ciudadano/ver/';
    $token_reniec = 'Bearer d90f5ad5d9c64268a00efaa4bd62a2a0';
    $doc = $_POST['doc']; $tipo = $_POST['ctipo']; $resp = [];
	$token = ($tipo === '05')? $token_ruc : $token_reniec;
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $api.$tipo.'/'.$doc.'/',
		CURLOPT_HEADER => false,
		CURLOPT_MAXREDIRS => 2,
		CURLOPT_HTTPHEADER => array('Authorization: '.$token, 'Content-Type: application/json'),
		CURLOPT_RETURNTRANSFER => true,
	));
				
	$data = curl_exec($curl);
	$resp['data'] = $data;
	
	$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	
	$resp['status'] = $code;
		
    return $resp;
}

if($_POST['data'] === 'listar'){
	$con = new Funciones();
	$lista = $con->listar($_POST['dep']);
	echo json_encode([data => $lista]);
}elseif($_GET['act'] === 'descargar'){
	descargar();
}elseif($_POST['ctipo']){
	echo json_encode(curl());
}elseif($_POST['dep'] === 'departamentos'){
	$con = new Funciones();
	$prov = $con->provincias($_POST['cod_dep']);
	$con->close();
	echo json_encode($prov);
}elseif($_POST['dep'] === 'provincias'){
	$con = new Funciones();
	$dis = $con->distritos($_POST['cod_dep'],$_POST['cod_pro']);
	$con->close();
	echo json_encode($dis);
}elseif($_POST['dep'] === 'distritos'){
	$con = new Funciones();
	$coord = $con->coordenadas($_POST['ubigeo']);
	$con->close();
	echo json_encode($coord);
}elseif(isset($_POST['postular']) && $_POST['postular'] === 'postulaciones'){
	$path = $_SERVER['DOCUMENT_ROOT'].'/contrataciones/public/adjuntos/anexos_postulantes/'; $i = 0;
	$a1='';$a2='';$a3='';$a4='';$a5='';$a6='';
	
	$con = new Funciones();
	$rep = $con->repetido($_POST['idconvocatoria'],$_POST['doc']);
	$ubigeo = $_POST['dep'].$_POST['pro'].$_POST['dis'];
	
	
	if($rep === 0){
		foreach($_FILES as $cab=>$file):
			if(file_exists($file['tmp_name'])){
				$parte = explode('.',$file['name']);
				$ext = end($parte);
				if($ext === 'docx' || $ext === 'doc' || $ext === 'pdf'){
					$nombre = date('dmYHis')+$i;
					$n = basename($nombre.'.'.$ext);
					$i++;
					
					$f = file_get_contents($file['tmp_name']);
					if(file_put_contents($path.$n,$f)){
						if($cab === 'anexo01') $a1 = $n; elseif($cab === 'anexo02') $a2 = $n; elseif($cab === 'anexo03') $a3 = $n;
						elseif($cab === 'anexo04') $a4 = $n; elseif($cab === 'anexo05') $a5 = $n; elseif($cab === 'anexo06') $a6 = $n;
					}else{
						session_start();
						$_SESSION['claseMsg'] = 'alert-danger';
						$_SESSION['mensaje'] = 'No se pudo guardar los adjuntos. Intente de nuevo';
						header('location: formulario');
					}
				}
			}
		endforeach;
		$anexos = $a1."','".$a2."','".$a3."','".$a4."','".$a5."','".$a6;
		
		$resp = $con->guardar_postulacion($anexos,$ubigeo);
		
		if($resp === true){
			session_start();
			$_SESSION['claseMsg'] = 'alert-success';
			$_SESSION['mensaje'] = 'Postulaci&oacute;n exitosa';
		}else{
			session_start();
			$_SESSION['claseMsg'] = 'alert-danger';
			$_SESSION['mensaje'] = $resp;
		}
	}else{
		session_start();
		$_SESSION['claseMsg'] = 'alert-warning';
		$_SESSION['mensaje'] = 'La postulaci&oacute;n indicada ya est&aacute; activa para el usuario';
	}
	header('location: ../');
}

