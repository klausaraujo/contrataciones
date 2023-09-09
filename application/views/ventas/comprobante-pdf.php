<!doctype html>
<html lang="es">
    <head>
	<title>Comprobante Nro <?=(!empty($guia))?sprintf("%'05s",$guia[0]->numero).'-'.$guia[0]->anio_guia:'';?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            /** Margenes de la pagina en 0 **/
            @page { margin: 0cm 0cm; }
			/** Márgenes reales de cada página en el PDF **/
			body { width:21cm; font-family: Helvetica; font-size: 0.8rem;margin-top:6.6cm;margin-bottom:1.5cm }
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
			table.footer{font-size: 8px;height: 1.3cm;border-top:0.5px solid #AAA;width:20.5cm;line-height:1em}
			
			.header2 {
                position: fixed;
                top: 148mm;
                left: 0cm;
                right: 0cm;
				width: 100%;
            }

            /** Reglas del pie de página **/
            .footer2 {
                position: fixed; 
                bottom: 148mm; 
                left: 0cm; 
                right: 0cm;
                height: 1.3cm;
				width: 100%;
            }
			
			/** Reglas del contenido **/
			/* *{ text-transform: uppercase; }*/
			*{ font-size: 13px; }
			.tablaround{ border-collapse:separate;border-spacing:1; border:solid black 1px; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;}
			.acciones{ width:18cm; text-align:center; }
			.acciones td, .acciones th{border:1px solid #4B4B4B; border-collapse: collapse; font-size: 10px;}
			.acciones b{ font-size: 10px; }
			table.datos td{ font-size:10px; overflow:hidden;}
			#main2{ position:fixed;top:21.4cm; }
			.firmas{ position:fixed; top:12cm; text-transform:uppercase; width:11cm; }
			.firmas2{ position:fixed; top:26.8cm; text-transform:uppercase; width:11cm; }
        </style>
    </head>
    <body>
        <!-- Defina bloques de encabezado y pie de página antes de su contenido -->
        <header>
			<table style="width:100%;solid #0000ff;background-color:#BEBEBE" cellspacing="1" >
				<tr>
					<td style="aling:center;color:#600000;text-align:center;" >
						<span style="font-size:15;font-weight:bold;"> NEGOCIACIONES AGROINDUSTRIAL AREVALO S.A. - NARSA </span>
					</td>
				</tr>
				<tr>
					<td style="aling:center;color:#600000;text-align:center;font-weight:bold" >
					<span style="font-size:10;font-weight:bold;">Sistema Integrado de Gestión Financiera y Administrativa Versión 3.0 </td>
				</tr>
			</table>
			<table cellspacing="0" cellpadding="1" align="center" style="text-align:center;margin-top:3mm" width="18cm">
				<tr><td><b>COMPROBANTE DE SALIDA DE PRODUCTOS</b></td></tr>
				<tr><td>
					<b>GU&Iacute;A DE SALIDA NRO  <span style="color:blue"><? if(!empty($guia)) echo sprintf("%'05s",$guia[0]->numero).'-'.$guia[0]->anio_guia; ?></span></b>
				</td></tr>
			</table>
			<table cellspacing="0" cellpadding="1" align="center" class="datos" width="15cm" style="text-align:center;margin-top:3mm">
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Fecha Emisi&oacute;n Gu&iacute;a:</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=!empty($guia)? date_format(date_create($guia[0]->fecha),'d-m-Y') : '&nbsp;';?></td></tr></table>
					</td>
					<td colspan="1" style="width:1.5cm"></td>
					<td colspan="3" style="text-align:left;font-weight:bold;">Sucursal:</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=!empty($guia)?$guia[0]->sucursal : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Tipo Documento</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->tipo_documento) > 0?$datos->tipo_documento : '&nbsp;';?></td></tr></table>
					</td>
					<td colspan="1" style="width:1.5cm"></td>
					<td colspan="3" style="text-align:left;font-weight:bold;">Nro. Documento</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->numero_documento) > 0?$datos->numero_documento : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Celular</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->celular) > 0?$datos->celular : '&nbsp;';?></td></tr></table>
					</td>
					<td colspan="1" style="width:1.5cm"></td>
					<td colspan="3" style="text-align:left;font-weight:bold;">Correo Electr&oacute;nico</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->correo) > 0?$datos->correo : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Nombre/Raz&oacute;n Social</td>
					<td colspan="9" style="text-align:left;">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->nombre) > 0?$datos->nombre : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Domicilio</td>
					<td colspan="9" style="text-align:left;">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->domicilio) > 0?$datos->domicilio : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Zona</td>
					<td colspan="9" style="text-align:left;">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->zona) > 0?$datos->zona : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
			</table>
        </header>
        <footer>
			<table class="footer" style="width:100%;solid #0000ff;background-color:#BEBEBE"  >
				<tr>
					<td style="aling:center;color:#600000;text-align:center;" >
						<span style="display:flex;font-size:10;font-weight:bold;padding-top:3mm"> Copyright © 2022 - NARSA S.A. </span>
					</td>
				</tr>
				<tr>
					<td style="aling:center;color:#600000;text-align:center;font-weight:bold" >
					<span style="font-size:10;font-weight:bold;">Usuario: <? if($usuario = json_decode($this->session->userdata('user'))); echo $usuario->usuario;?></td>
				</tr>
			</table>
        </footer>
		<div class="header2">
			<table style="width:100%;solid #0000ff;background-color:#BEBEBE" cellspacing="1" >
				<tr>
					<td style="aling:center;color:#600000;text-align:center;" >
						<span style="font-size:15;font-weight:bold;"> NEGOCIACIONES AGROINDUSTRIAL AREVALO S.A. - NARSA </span>
					</td>
				</tr>
				<tr>
					<td style="aling:center;color:#600000;text-align:center;font-weight:bold" >
					<span style="font-size:10;font-weight:bold;">Sistema Integrado de Gestión Financiera y Administrativa Versión 3.0 </td>
				</tr>
			</table>
			<table cellspacing="0" cellpadding="1" align="center" style="text-align:center;margin-top:3mm" width="18cm">
				<tr><td><b>COMPROBANTE DE SALIDA DE PRODUCTOS</b></td></tr>
				<tr><td>
					<b>GU&Iacute;A DE SALIDA NRO  <span style="color:blue"><? if(!empty($guia)) echo sprintf("%'05s",$guia[0]->numero).'-'.$guia[0]->anio_guia; ?></span></b>
				</td></tr>
			</table>
			<table cellspacing="0" cellpadding="1" align="center" class="datos" width="15cm" style="text-align:center;margin-top:3mm">
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Fecha Emisi&oacute;n Gu&iacute;a:</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=!empty($guia)? date_format(date_create($guia[0]->fecha),'d-m-Y') : '&nbsp;';?></td></tr></table>
					</td>
					<td colspan="1" style="width:1.5cm"></td>
					<td colspan="3" style="text-align:left;font-weight:bold;">Sucursal:</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=!empty($guia)?$guia[0]->sucursal : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Tipo Documento</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->tipo_documento) > 0?$datos->tipo_documento : '&nbsp;';?></td></tr></table>
					</td>
					<td colspan="1" style="width:1.5cm"></td>
					<td colspan="3" style="text-align:left;font-weight:bold;">Nro. Documento</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->numero_documento) > 0?$datos->numero_documento : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Celular</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->celular) > 0?$datos->celular : '&nbsp;';?></td></tr></table>
					</td>
					<td colspan="1" style="width:1.5cm"></td>
					<td colspan="3" style="text-align:left;font-weight:bold;">Correo Electr&oacute;nico</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->correo) > 0?$datos->correo : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Nombre/Raz&oacute;n Social</td>
					<td colspan="9" style="text-align:left;">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->nombre) > 0?$datos->nombre : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Domicilio</td>
					<td colspan="9" style="text-align:left;">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->domicilio) > 0?$datos->domicilio : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Zona</td>
					<td colspan="9" style="text-align:left;">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($datos->zona) > 0?$datos->zona : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
			</table>
		</div>
		<div class="footer2">
			<table class="footer" style="width:100%;solid #0000ff;background-color:#BEBEBE"  >
				<tr>
					<td style="aling:center;color:#600000;text-align:center;" >
						<span style="display:flex;font-size:10;font-weight:bold;padding-top:3mm"> Copyright © 2022 - NARSA S.A. </span>
					</td>
				</tr>
				<tr>
					<td style="aling:center;color:#600000;text-align:center;font-weight:bold" >
					<span style="font-size:10;font-weight:bold;">Usuario: <? if($usuario = json_decode($this->session->userdata('user'))); echo $usuario->usuario;?></td>
				</tr>
			</table>
		</div>

        <!-- Etiqueta principal del pdf -->
        <main style="overflow-y:hidden">
			<table cellspacing="0" cellpadding="1" align="center" class="acciones">
				<tr><th bgcolor="#B5B2B2" colspan="12">DETALLE DE PRODUCTOS VENDIDOS</th></tr>
				<tr style="font-weight:bold;" bgcolor="#B5B2B2">
					<td>&Iacute;tem</td><td colspan="2">Cod. Art&iacute;culo</td><td colspan="3">Producto</td><td>Humedad (%)</td><td>Calidad (%)</td>
					<td>Cantidad Total (KG)</td><td>Precio (S/)</td><td colspan="2">Importe (S/)</td>
				</tr>
	<?
			$i = 1; $total = 0;
			foreach($guia as $row):
				$total += $row->cantidad * $row->costo;
				$importe = $row->cantidad * $row->costo;
	?>
				<tr>
					<td><?=$i?></td><td colspan="2"><?=sprintf("%'06s",$row->idarticulo)?></td><td colspan="3" style="text-align:left">&nbsp;<?=$row->articulo?></td>
					<td style="text-align:right">&nbsp;<?=number_format($row->humedad,2,'.',',')?></td>
					<td style="text-align:right">&nbsp;<?=number_format($row->calidad,2,'.',',')?></td>
					<td style="text-align:right"><?=number_format($row->cantidad,2,'.',',')?></td>
					<td style="text-align:right"><?=number_format($row->costo,2,'.',',');?></td>
					<td style="text-align:right" colspan="2"><?=number_format($importe,2,'.',',');?></td>
				</tr>
	<?
				$i++;
			endforeach;
	?>
				<tr>
					<td colspan="10" align="right" style="font-weight:bold">TOTAL (S/):&nbsp;</td>
					<td colspan="2" style="font-weight:bold;text-align:right"><?=number_format($total,2,'.',',');?></td>
				</tr>
			</table>
			<div style="height:1mm"></div>
			<table cellspacing="0" cellpadding="1" align="center" style="text-align:center;" width="18cm" class="acciones">
				<tr style="text-align:left">
					<td>&nbsp;<b>OBSERVACIONES:</b>&nbsp;&nbsp;<?if($guia[0]->observaciones) echo $guia[0]->observaciones; else echo '&nbsp;';?></td>
				</tr>
			</table>
        </main>
		<main id="main2">
			<table cellspacing="0" cellpadding="1" class="acciones" style="position:relative;left:1.5cm">
				<tr><th bgcolor="#B5B2B2" colspan="12">DETALLE DE PRODUCTOS VENDIDOS</th></tr>
				<tr style="font-weight:bold;" bgcolor="#B5B2B2">
					<td>&Iacute;tem</td><td colspan="2">Cod. Art&iacute;culo</td><td colspan="3">Producto</td><td>Humedad (%)</td><td>Calidad (%)</td>
					<td>Cantidad Total (KG)</td><td>Precio (S/)</td><td colspan="2">Importe (S/)</td>
				</tr>
	<?
			$i = 1; $total = 0;
			foreach($guia as $row):
				$total += $row->cantidad * $row->costo;
				$importe = $row->cantidad * $row->costo;
	?>
				<tr>
					<td><?=$i?></td><td colspan="2"><?=sprintf("%'06s",$row->idarticulo)?></td><td colspan="3" style="text-align:left">&nbsp;<?=$row->articulo?></td>
					<td style="text-align:right">&nbsp;<?=number_format($row->humedad,2,'.',',')?></td>
					<td style="text-align:right">&nbsp;<?=number_format($row->calidad,2,'.',',')?></td>
					<td style="text-align:right"><?=number_format($row->cantidad,2,'.',',')?></td>
					<td style="text-align:right"><?=number_format($row->costo,2,'.',',');?></td>
					<td style="text-align:right" colspan="2"><?=number_format($importe,2,'.',',');?></td>
				</tr>
	<?
				$i++;
			endforeach;
	?>
				<tr>
					<td colspan="10" align="right" style="font-weight:bold">TOTAL (S/):&nbsp;</td>
					<td colspan="2" style="font-weight:bold;text-align:right"><?=number_format($total,2,'.',',');?></td>
				</tr>
			</table>
			<div style="height:1mm"></div>
			<table cellspacing="0" cellpadding="1" class="acciones" style="position:relative;left:1.5cm">
				<tr style="text-align:left">
					<td>&nbsp;<b>OBSERVACIONES:</b>&nbsp;&nbsp;<?if($guia[0]->observaciones) echo $guia[0]->observaciones; else echo '&nbsp;';?></td>
				</tr>
			</table>
        </main>
		<!-- Firmas -->
		<table align="center" class="firmas">
			<tr>
				<td style="border-top:1px solid #4B4B4B;font-size:9px;text-align:center;width:4cm">vºbº NARSA</td><td style="width:2cm">&nbsp;</td>
				<td style="border-top:1px solid #4B4B4B;font-size:9px;text-align:center;width:4cm"><?=$datos->nombre?></td>
			</tr>
			<tr>
				<td>&nbsp;</td><td style="width:2cm"></td>
				<td style="font-size:9px;text-align:center;width:4cm"><?=$datos->tipo_documento.': '.$datos->numero_documento?></td>
			</tr>
		</table>
		<table align="center" class="firmas2">
			<tr>
				<td style="border-top:1px solid #4B4B4B;font-size:9px;text-align:center;width:4cm">vºbº NARSA</td><td style="width:2cm">&nbsp;</td>
				<td style="border-top:1px solid #4B4B4B;font-size:9px;text-align:center;width:4cm"><?=$datos->nombre?></td>
			</tr>
			<tr>
				<td>&nbsp;</td><td style="width:2cm"></td>
				<td style="font-size:9px;text-align:center;width:4cm"><?=$datos->tipo_documento.': '.$datos->numero_documento?></td>
			</tr>
		</table>
    </body>
</html>