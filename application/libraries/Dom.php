<?php

require_once 'dompdf/autoload.inc.php';
	// reference the Dompdf namespace
use Dompdf\Dompdf;

class Dom {

 public function generate($direccion,$hoja,$html,$nombre){
	 
	 
	// instantiate and use the dompdf class
	$dompdf = new Dompdf();
	$dompdf->set_option('isRemoteEnabled', TRUE);
	
	$dompdf->loadHtml($html);
	
	$dompdf->setPaper($hoja, $direccion);

	// Render the HTML as PDF
	$dompdf->render();
	
	//$pdf = $dompdf->output();

	// Output the generated PDF to Browser
	//echo $html;
	$dompdf->stream($nombre, array("Attachment" => false));
	//return $pdf;
 } 

}

?>