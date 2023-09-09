<!doctype html>
<html lang="es">
    <head>
	<title>Movimiento Nro. <?=sprintf("%'05s",$movimiento->idmovimiento)?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            /** Margenes de la pagina en 0 **/
            @page { margin: 0cm 0cm; }
			/** Márgenes reales de cada página en el PDF **/
			body { width:21cm; font-family: Helvetica; font-size: 0.8rem;margin-top:2cm;margin-bottom:2.6cm }
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
			#footer{font-size: 8px;height: 1.3cm;border-top:0.5px solid #AAA;width:20.5cm;line-height:1em}
			
			/** Reglas del contenido **/
			/* *{ text-transform: uppercase; }*/
			*{ font-size: 13px; }
			.espaciocm{ height:1cm; }
			.espaciomm{ height:6mm; }
			.tablaround{ border-collapse:separate;border-spacing:3; border:solid black 1px; border-radius: 7px; -moz-border-radius: 7px; -webkit-border-radius: 7px;}
			.acciones td{border:1px solid #4B4B4B; border-collapse: collapse; font-size: 12px; padding:0 1.2cm 0 2mm}
			.acciones th{border:1px solid #4B4B4B; border-collapse: collapse; font-size: 12px;}
			table.datos td{ font-size:0.87em; overflow:hidden;}
        </style>
    </head>
    <body>
        <!-- Defina bloques de encabezado y pie de página antes de su contenido -->
        <header>
            
			<table id="header" style="width:100%;solid #0000ff;background-color:#BEBEBE" cellspacing="1" >
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
        </header>

        <footer>
			<table id="footer" style="width:100%;solid #0000ff;background-color:#BEBEBE"  >
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

        <!-- Etiqueta principal del pdf -->
        <main>
            <table cellspacing="0" cellpadding="1" align="center" style="text-align:center;" width="18cm">
				<tr><td><b>MOVIMIENTO DE CAJA NRO. <?=sprintf("%'05s",$movimiento->idmovimiento)?></b></td></tr>
			</table>
			<div class="espaciomm"></div>
			<table cellspacing="0" cellpadding="1" align="center">
				<tr>
					<td style="font-weight:bold;width:2cm">Sucursal</td>
					<td><table class="tablaround" style="width:100%;padding:0 1cm"><tr><td><?=$movimiento->sucursal?></td></tr></table></td>
				</tr>
			</table>
			<div class="espaciocm"></div>
			<table cellspacing="0" cellpadding="1" align="center" style="line-height:2" class="acciones">
				<tr><th bgcolor="#B5B2B2" colspan="2">DETALLE DE MOVIMIENTO DE CAJA</th></tr>		
				<tr><td>Tipo Operaci&oacute;n</td><td><?=$movimiento->tipo_operacion?></td></tr>
				<tr><td>Nro. Operaci&oacute;n</td><td><?=sprintf("%'05s",$movimiento->idtransaccion)?></td></tr>
				<tr><td>Fecha</td><td><?=date_format(date_create($movimiento->fecha_movimiento),'d-m-Y')?></td></tr>
				<tr><td>Monto</td><td><?=number_format((floatval($movimiento->monto)*floatval($movimiento->factor)),2,'.',',')?></td></tr>
				<tr><td>Observaciones</td><td><?=$movimiento->observaciones?></td></tr>
				<tr><td>Proveedor</td><td><?=$movimiento->razon_social_proveedor?></td></tr>
				<tr><td>RUC Proveedor</td><td><?=$movimiento->ruc_proveedor?></td></tr>
				<tr><td>Tipo Comprobante</td><td><?=$movimiento->tipo_comprobante?></td></tr>
				<tr><td>Serie Comprobante</td><td><?=$movimiento->serie_comprobante?></td></tr>
				<tr><td>N&uacute;mero Comprobante</td><td><?=$movimiento->numero_comprobante?></td></tr>
				<tr><td>Base Imponible</td><td><?=number_format(floatval($movimiento->base_imponible),2,'.',',')?></td></tr>
				<tr><td>IGV</td><td><?=number_format(floatval($movimiento->impuesto_igv),2,'.',',')?></td></tr>
				<tr><td>Renta</td><td><?=number_format(floatval($movimiento->impuesto_renta),2,'.',',')?></td></tr>
				<tr><td>Detalle Comprobante</td><td><?=$movimiento->detalle_comprobante?></td></tr>
			</table>
		</main>
    </body>
</html>