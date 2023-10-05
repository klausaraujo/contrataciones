<!doctype html>
<html lang="es">
    <head>
	<title>Resultados</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            /** Margenes de la pagina en 0 **/
            @page { margin: 0cm 0cm; }
			/** Márgenes reales de cada página en el PDF **/
			body{ width:21cm;font-family:Helvetica;margin-top:3cm;margin-bottom:2cm }
			/** Reglas del encabezado **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
				width: 100%;
            }

            /** Reglas del pie de página **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 1.3cm;
				width: 100%;
            }
			table.footer{font-size:8px;height:2cm;border-top:0.5px solid #AAA;width:20.5cm;line-height:1em}
			
			/** Reglas del contenido **/
			/* *{ text-transform: uppercase; }*/
			*{ font-size: 13px; }
			.acciones td, .acciones th{border:1px solid #b9b9b9; border-collapse: collapse; font-size: 12px;}
			.acc td{border:1px solid #ababab;}
			.stroke { text-shadow: -1.5px 1px 1px #85C1E9, 1.5px 1px 1px #85C1E9, -1.5px 1px 1px #85C1E9, 1.5px 1px 1px #85C1E9 }
        </style>
    </head>
    <body>
        <!-- Defina bloques de encabezado y pie de página antes de su contenido -->
        <header>
			<table style="width:16cm;margin-top:5mm" cellspacing="1" align="center">
				<tr>
					<td width="10"><img src="<?=base_url().'/public/images/logo-white.png'?>" style="height:70px" /></td>
					<td><span style="font-size:2rem;font-weight:bold;margin-left:5mm;color:#3f9cd4" class="stroke">Red Prestacional Sabogal</span></td>
				</tr>
			</table>
        </header>
        <footer>
			<!--<table class="footer" style="width:100%">
				<tr>
					<td style="aling:center;color:#600000;text-align:center;" >
						<span style="display:flex;font-size:10;font-weight:bold;padding-top:3mm"> Copyright © 2022 - NARSA S.A. </span>
					</td>
				</tr>
				<tr>
					<td style="aling:center;color:#600000;text-align:center;font-weight:bold" >
					<span style="font-size:10;font-weight:bold;"></td>
				</tr>
			</table>-->
        </footer>
        <!-- Etiqueta principal del pdf -->
        <main style="width:100%">
			<div style="text-align:center;font-weight:bold;margin:5mm;font-size:14px">PROCESO DE CONVOCATORIA PARA LOCADORES DE SERVICIO</div>
			<table cellspacing="0" style="width:14cm" cellpadding="1" align="center" bgcolor="dcdcdc" class="acciones">
				<tr>
					<td style="width:5cm;padding-left:3mm;font-weight:bold">DEPENDENCIA</td><td style="width:3mm;text-align:center">:</td>
					<td style="padding-left:3mm;font-weight:bold">OFICINA DE SOPORTE INFORM&Aacute;TICO</td>
				</tr>
				<tr bgcolor="#eeeeee">
					<td style="width:5cm;padding-left:3mm;font-weight:bold">FECHA CONVOCATORIA</td><td style="width:3mm;text-align:center">:</td>
					<td style="padding-left:3mm">OFICINA DE SOPORTE INFORM&Aacute;TICO</td>
				</tr>
				<tr>
					<td style="width:5cm;padding-left:3mm;font-weight:bold">DENOMINACI&Oacute;N</td><td style="width:3mm;text-align:center">:</td>
					<td style="padding-left:3mm">OFICINA DE SOPORTE INFORM&Aacute;TICO</td>
				</tr>
				<tr bgcolor="#eeeeee">
					<td style="width:5cm;padding-left:3mm;font-weight:bold">ESTADO CONVOCATORIA</td><td style="width:3mm;text-align:center">:</td>
					<td style="padding-left:3mm">FINALIZADO</td>
				</tr>
			</table>
			<div style="text-align:center;font-weight:bold;margin:5mm 0;font-size:14px">RESULTADOS</div>
			<table cellspacing="0" style="width:14cm" cellpadding="1" align="center" bgcolor="dcdcdc" class="acciones acc">
				<tr bgcolor="#000" style="color:#fff"><th>DNI/CE</th><th>POSTULANTE</th><th>PUNTAJE</th><th>GANADOR</th></tr>
				<tr bgcolor="#ccc"><td colspan="3" style="text-align:right;padding-right:3mm">TOTAL POSTULANTES</td><td></td></tr>
			</table>
        </main>
    </body>
</html>