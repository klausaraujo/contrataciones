<!doctype html>
<html lang="es">
    <head>
	<title>Comprobante Nro <?=(!empty($tostado))?sprintf("%'05s",$tostado->numero).'-'.$tostado->anio_tostado:'';?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            /** Margenes de la pagina en 0 **/
            @page { margin: 0cm 0cm; }
			/** Márgenes reales de cada página en el PDF **/
			body { width:21cm; font-family: Helvetica; font-size: 0.8rem;margin-top:5.2cm;margin-bottom:1.5cm }
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
			#main2{ position:fixed;top:20cm; }
			.firmas{ position:fixed; top:12cm; text-transform:uppercase; width:11cm; }
			.firmas2{ position:fixed; top:26.8cm; text-transform:uppercase; width:11cm; }
        </style>
    </head>
    <body>
        <header>
			<table style="width:100%;solid #0000ff;background-color:#BEBEBE" cellspacing="1" >
				<tr>
					<td style="aling:center;color:#600000;text-align:center;" >
						<span style="font-size:15;font-weight:bold;"> NEGOCIACIONES AGROINDUSTRIAL AREVALO S.A. - NARSA </span>
					</td>
				</tr>
				<tr>
					<td style="aling:center;color:#600000;text-align:center;font-weight:bold" >
					<span style="font-size:10;font-weight:bold;">Av. Fray Jerónimo Jiménez 1601-1603 San Carlos Chanchamayo Junín </td>
				</tr>
				<tr>
					<td style="aling:center;color:#600000;text-align:center;font-weight:bold" >
					<span style="font-size:10;font-weight:bold;">Cel. 963628072 / 963618606 </td>
				</tr>
			</table>
			<table cellspacing="0" cellpadding="1" align="center" style="text-align:center;margin-top:3mm" width="18cm">
				<tr><td>
					<b>ORDEN NRO  <span style="color:blue"><? if(!empty($tostado)) echo sprintf("%'05s",$tostado->numero).'-'.$tostado->anio_tostado; ?></span></b>
				</td></tr>
			</table>
			<table cellspacing="0" cellpadding="1" align="center" class="datos" width="15cm" style="text-align:center;margin-top:3mm">
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Fecha Orden:</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=!empty($tostado)? date_format(date_create($tostado->fecha),'d-m-Y') : '&nbsp;';?></td></tr></table>
					</td>
					<td colspan="1" style="width:1.5cm"></td>
					<td colspan="3" style="text-align:left;font-weight:bold;">Sucursal:</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=!empty($tostado)?$tostado->sucursal : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Tipo Documento</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($tostado->tipo_documento) > 0?$tostado->tipo_documento : '&nbsp;';?></td></tr></table>
					</td>
					<td colspan="1" style="width:1.5cm"></td>
					<td colspan="3" style="text-align:left;font-weight:bold;">Nro. Documento</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($tostado->numero_documento) > 0?$tostado->numero_documento : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Nombre/Raz&oacute;n Social</td>
					<td colspan="9" style="text-align:left;">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($tostado->nombre) > 0?$tostado->nombre : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr style="margin-bottom:0.4mm">
					<td colspan="3" style="text-align:left;font-weight:bold;">Domicilio</td>
					<td colspan="9" style="text-align:left;">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($tostado->domicilio) > 0?$tostado->domicilio : '&nbsp;';?></td></tr></table>
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
					<span style="font-size:10;font-weight:bold;">Av. Fray Jerónimo Jiménez 1601-1603 San Carlos Chanchamayo Junín </td>
				</tr>
				<tr>
					<td style="aling:center;color:#600000;text-align:center;font-weight:bold" >
					<span style="font-size:10;font-weight:bold;">Cel. 963628072 / 963618606 </td>
				</tr>
			</table>
			<table cellspacing="0" cellpadding="1" align="center" style="text-align:center;margin-top:3mm" width="18cm">
				<tr><td>
					<b>ORDEN NRO  <span style="color:blue"><? if(!empty($tostado)) echo sprintf("%'05s",$tostado->numero).'-'.$tostado->anio_tostado; ?></span></b>
				</td></tr>
			</table>
			<table cellspacing="0" cellpadding="1" align="center" class="datos" width="15cm" style="text-align:center;margin-top:3mm">
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Fecha Orden:</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=!empty($tostado)? date_format(date_create($tostado->fecha),'d-m-Y') : '&nbsp;';?></td></tr></table>
					</td>
					<td colspan="1" style="width:1.5cm"></td>
					<td colspan="3" style="text-align:left;font-weight:bold;">Sucursal:</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=!empty($tostado)?$tostado->sucursal : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Tipo Documento</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($tostado->tipo_documento) > 0?$tostado->tipo_documento : '&nbsp;';?></td></tr></table>
					</td>
					<td colspan="1" style="width:1.5cm"></td>
					<td colspan="3" style="text-align:left;font-weight:bold;">Nro. Documento</td>
					<td colspan="2" style="text-align:left;width:3cm">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($tostado->numero_documento) > 0?$tostado->numero_documento : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Nombre/Raz&oacute;n Social</td>
					<td colspan="9" style="text-align:left;">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($tostado->nombre) > 0?$tostado->nombre : '&nbsp;';?></td></tr></table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:left;font-weight:bold;">Domicilio</td>
					<td colspan="9" style="text-align:left;">
						<table class="tablaround" style="width:100%"><tr><td><?=strlen($tostado->domicilio) > 0?$tostado->domicilio : '&nbsp;';?></td></tr></table>
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
				<tr><th bgcolor="#B5B2B2" colspan="12">DETALLE ORDEN DE TOSTADO</th></tr>
				<tr>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Art&iacute;culo</td><td colspan="2"><?=$tostado->articulo?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">
						Cantidad</td><td colspan="2" style="text-align:right"><?=number_format($tostado->cantidad,2,'.',',')?></td>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Densidad</td><td colspan="2"><?=$tostado->densidad?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">H2O</td>
					<td colspan="2"><?=$tostado->h2o?></td>
				</tr>
				<tr>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Seleccionado</td><td colspan="2"><?=$tostado->seleccionado === '1'?'SI':'NO';?></td>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Precio Total</td><td colspan="2" style="text-align:right"><?=number_format($tostado->precio_total,2,'.',',')?></td>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">A Cuenta</td><td colspan="2" style="text-align:right"><?=number_format($tostado->a_cuenta,2,'.',',')?></td>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Saldo</td><td colspan="2" style="text-align:right"><?=number_format($tostado->saldo,2,'.',',')?></td>
				</tr>
				<tr>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Claro</td><td colspan="2"><?=$tostado->tipo_tostado_claro?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">
					Medio</td><td colspan="2"><?=$tostado->tipo_tostado_medio?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">Oscuro</td><td colspan="2">
					<?=$tostado->tipo_tostado_oscuro?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">Molienda Media</td><td colspan="2"><?=$tostado->tipo_molienda_media?></td>
				</tr>
				<tr>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Media Fina</td><td colspan="2"><?=$tostado->tipo_molienda_media_fina?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">
					Media Gruesa</td><td colspan="2"><?=$tostado->tipo_molienda_media_gruesa?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">Embolsado 250</td><td colspan="2">
					<?=$tostado->tipo_embolsado_250?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">Embolsado 500</td><td colspan="2"><?=$tostado->tipo_embolsado_500?></td>
				</tr>
				<tr>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Embolsado 1000</td><td colspan="2"><?=$tostado->tipo_embolsado_1000?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">
					Observaciones</td><td colspan="8"><?=$tostado->observaciones?></td>
				</tr>
			</table>
		</main>
		<!-- Segundo Main -->
		<main id="main2">
			<table cellspacing="0" cellpadding="1" class="acciones" style="position:relative;left:1.5cm">
				<tr><th bgcolor="#B5B2B2" colspan="12">DETALLE ORDEN DE TOSTADO</th></tr>
				<tr>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Art&iacute;culo</td><td colspan="2"><?=$tostado->articulo?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">
						Cantidad</td><td colspan="2" style="text-align:right"><?=number_format($tostado->cantidad,2,'.',',')?></td>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Densidad</td><td colspan="2"><?=$tostado->densidad?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">H2O</td>
					<td colspan="2"><?=$tostado->h2o?></td>
				</tr>
				<tr>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Seleccionado</td><td colspan="2"><?=$tostado->seleccionado === '1'?'SI':'NO';?></td>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Precio Total</td><td colspan="2" style="text-align:right"><?=number_format($tostado->precio_total,2,'.',',')?></td>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">A Cuenta</td><td colspan="2" style="text-align:right"><?=number_format($tostado->a_cuenta,2,'.',',')?></td>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Saldo</td><td colspan="2" style="text-align:right"><?=number_format($tostado->saldo,2,'.',',')?></td>
				</tr>
				<tr>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Claro</td><td colspan="2"><?=$tostado->tipo_tostado_claro?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">
					Medio</td><td colspan="2"><?=$tostado->tipo_tostado_medio?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">Oscuro</td><td colspan="2">
					<?=$tostado->tipo_tostado_oscuro?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">Molienda Media</td><td colspan="2"><?=$tostado->tipo_molienda_media?></td>
				</tr>
				<tr>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Media Fina</td><td colspan="2"><?=$tostado->tipo_molienda_media_fina?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">
					Media Gruesa</td><td colspan="2"><?=$tostado->tipo_molienda_media_gruesa?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">Embolsado 250</td><td colspan="2">
					<?=$tostado->tipo_embolsado_250?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">Embolsado 500</td><td colspan="2"><?=$tostado->tipo_embolsado_500?></td>
				</tr>
				<tr>
					<td bgcolor="#dfdfdf" style="font-weight:bold;">Embolsado 1000</td><td colspan="2"><?=$tostado->tipo_embolsado_1000?></td><td bgcolor="#dfdfdf" style="font-weight:bold;">
					Observaciones</td><td colspan="8"><?=$tostado->observaciones?></td>
				</tr>
			</table>
		</main>
		
		
		
		<!-- Firmas -->
		<table align="center" class="firmas">
			<tr>
				<td style="border-top:1px solid #4B4B4B;font-size:9px;text-align:center;width:4cm">vºbº NARSA</td><td style="width:2cm">&nbsp;</td>
				<td style="border-top:1px solid #4B4B4B;font-size:9px;text-align:center;width:4cm"><?=!empty($tostado)?$tostado->nombre:'';?></td>
			</tr>
			<tr>
				<td>&nbsp;</td><td style="width:2cm"></td>
				<td style="font-size:9px;text-align:center;width:4cm"><?=!empty($tostado)?$tostado->tipo_documento.': '.$tostado->numero_documento:'';?></td>
			</tr>
		</table>
		<table align="center" class="firmas2">
			<tr>
				<td style="border-top:1px solid #4B4B4B;font-size:9px;text-align:center;width:4cm">vºbº NARSA</td><td style="width:2cm">&nbsp;</td>
				<td style="border-top:1px solid #4B4B4B;font-size:9px;text-align:center;width:4cm"><?=!empty($tostado)?$tostado->nombre:'';?></td>
			</tr>
			<tr>
				<td>&nbsp;</td><td style="width:2cm"></td>
				<td style="font-size:9px;text-align:center;width:4cm"><?=!empty($tostado)?$tostado->tipo_documento.': '.$tostado->numero_documento:'';?></td>
			</tr>
		</table>
    </body>
</html>