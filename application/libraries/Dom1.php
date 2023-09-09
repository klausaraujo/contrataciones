<?php

require_once 'dompdf1/autoload.inc.php';
	// reference the Dompdf namespace
use Dompdf\Dompdf;

class Dom1 {

 public function generate($direccion,$hoja,$html,$nombre){
	 
	 
	// instantiate and use the dompdf class
	$dompdf = new Dompdf();
	$dompdf->set_option('isRemoteEnabled', TRUE);
	
	$dompdf->loadHtml($html);
	
	$dompdf->setPaper($hoja, $direccion);

	// Render the HTML as PDF
	$dompdf->render();
	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename='.time().'.pdf');
	echo $dompdf->output();

	// Output the generated PDF to Browser
	//$dompdf->stream($nombre, array("Attachment" => false));
	//return $pdf;
 
 }
 public function versionDom(){
	$dompdf = new Dompdf();
	return $dompdf->__get('version');
 }

}

?>