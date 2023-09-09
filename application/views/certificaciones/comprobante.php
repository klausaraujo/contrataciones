<!doctype html>
<html lang="es">
    <head>
	<title>Comprobante</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            /** Margenes de la pagina en 0 **/
            @page { margin: 0cm 0cm; }
			/** Márgenes reales de cada página en el PDF **/
			body { width:21cm; font-family: Helvetica; font-size: 0.8rem;margin-top:2cm;margin-bottom:1.5cm }
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
			/** Reglas del contenido **/
			/* *{ text-transform: uppercase; }*/
			/**{ font-size: 13px; }*/
			/*.espaciocm{ height:1cm; }
			.espaciomm{ height:5mm; }
			.tablaround{ border-collapse:separate;border-spacing:1; border:solid black 1px; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;}*/
			.acciones td, .acciones th{ text-align:center;border:1px solid #4B4B4B; border-collapse: collapse; font-size: 11px }
			.acciones b{font-size: 11px}
			/*table.datos td{ font-size:10px; overflow:hidden;}*/
			.estudios{ margin-top:5mm;width:8cm }
			.sensorial td, .sensorial th, .sensorial b{ font-size: 10px }
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
        <!-- Etiqueta principal del pdf -->
        <main style="overflow-y: hidden">	
			<table cellspacing="0" cellpadding="1" align="center" width="18cm" class="acciones">
				<tr><th bgcolor="#DDDDDD" colspan="12" style="height:1.4rem;font-size:14px">FICHA T&Eacute;CNICA DE AN&Aacute;LISIS F&Iacute;SICO Y SENSORIAL</th></tr>
				<tr style="font-size:10px">
					<td colspan="3"><b>PRODUCTOR</b></td><td colspan="3"><?=$certificado->nombre?></td><td colspan="3"><b>CODIGO</b></td><td colspan="3"></td>
				</tr>
				<tr style="font-size:10px">
					<td colspan="3"><b>FINCA</b></td><td colspan="3"></td><td colspan="3"><b>FECHA</b></td><td colspan="3"><?=date_format(date_create($certificado->fecha),'d-m-Y')?></td>
				</tr>
				<tr style="font-size:10px">
					<td colspan="3"><b>ALTITUD</b></td><td colspan="3"><?=$certificado->altitud?></td><td colspan="3"><b>H2OVERDE</b></td><td colspan="3"><?=$certificado->h2overde?></td>
				</tr>
				<tr style="font-size:10px">
					<td colspan="3"><b>ZONA</b></td><td colspan="3"><?=$certificado->sucursal?></td><td colspan="3"><b>PROCESO</b></td><td colspan="3"><?=$certificado->proceso?></td>
				</tr>
				<tr style="font-size:10px">
					<td colspan="3"><b>DENSIDAD</b></td><td colspan="3"><?=$certificado->densidad?></td><td style="border:0" colspan="6">&nbsp;</td>
				</tr>
				<tr style="font-size:10px">
					<td colspan="3"><b>VARIEDAD</b></td>
					<td colspan="9" style="text-align:left;padding-left:3mm;padding-right:3mm">
					<?
						$variedad = ($certificado->bourbon? 'BOURBON, ': '').($certificado->tipica? 'TIPICA, ': '').($certificado->caturra? 'CATURRA, ': '').($certificado->pache? 'PACHE, ': '').
						($certificado->catimor? 'CATIMOR, ': '').($certificado->catuai? 'CATUAI, ': '').($certificado->pacamara? 'PACAMARA, ': '').($certificado->gesha? 'GESHA, ': '').
						($certificado->marcellesa? 'MARCELLESA, ': '').($certificado->gran_colombia? 'GRAN COLOMBIA, ': '').($certificado->costa_rica_95? 'COSTA RICA 95, ': '').
						($certificado->tupo? 'TUPO, ': '').($certificado->limani? 'LIMANI, ': '').($certificado->maragogipe? 'MARAGOGIPE, ': '').
						($certificado->otros? $certificado->otros_detalle: '');
						echo strtoupper(trim($variedad, ', '));
					?>
					</td>
				</tr>
			</table>
			
			<table cellspacing="0" cellpadding="1" align="center" width="17cm" class="acciones" style="margin-top:5mm">
				<tr>
					<th colspan="3" bgcolor="#DDDDDD" style="width:5cm">GRANULOMETR&Iacute;A</th>
					<th style="width:0.5cm;border:0px;border-left:1px solid #4B4B4B;border-right:1px solid #4B4B4B;" rowspan="7">&nbsp;</th>
					<th colspan="4" bgcolor="#DDDDDD">COLOR</th>
				</tr>
				<tr>
					<td><b>MALLA</b></td><td><b><?=!empty($detalle)?number_format($detalle->granumelometria_malla_general,2,'.',','):'';?></b></td><td><b>%</b></td>
					<td colspan="4"><?=!empty($detalle)?$detalle->color:'&nbsp;';?></td>
				</tr>
				<tr>
					<td>16 al 20</td>
					<td><?=!empty($detalle)?number_format($detalle->granumelometria_malla_1620_nro,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->granumelometria_malla_1620_por,2,'.',','):'';?></td>
					<th colspan="4"  bgcolor="#DDDDDD"> OLOR</th>
				</tr>
				<tr>
					<td>15</td>
					<td><?=!empty($detalle)?number_format($detalle->granumelometria_malla_15_nro,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->granumelometria_malla_15_por,2,'.',','):'';?></td>
					<td colspan="4"><?=!empty($detalle)? strtoupper($detalle->olor) : '';?></td>
				</tr>
				<tr>
					<td>14</td>
					<td><?=!empty($detalle)?number_format($detalle->granumelometria_malla_14_nro,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->granumelometria_malla_14_por,2,'.',','):'';?></td>
					<th bgcolor="#DDDDDD" colspan="4">AN&Aacute;LISIS F&Iacute;SICO</th>
				</tr>
				<tr>
					<td>BASE</td>
					<td><?=!empty($detalle)?number_format($detalle->granumelometria_malla_base_nro,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->granumelometria_malla_base_por,2,'.',','):'';?></td>
					<td colspan="2"><b>DETALLE</b></td><td><b>PESO</b></td><td><b>%</b></td>
				</tr>
				<?
					$malla = 0; $porcmalla = 0;
					if(!empty($detalle)){
						$malla += floatval($detalle->granumelometria_malla_1620_nro)+floatval($detalle->granumelometria_malla_15_nro)+floatval($detalle->granumelometria_malla_14_nro)+floatval($detalle->granumelometria_malla_base_nro);
						$porcmalla += floatval($detalle->granumelometria_malla_1620_por)+floatval($detalle->granumelometria_malla_15_por)+floatval($detalle->granumelometria_malla_14_por)+floatval($detalle->granumelometria_malla_base_por);
					}
				?>
				<tr>
					<td style="border:0">&nbsp;</td>
					<td><?=!empty($detalle)?number_format($malla,2,'.',','):'';?></td><td><?=!empty($detalle)?number_format($porcmalla,2,'.',','):'';?></td>
					<td style="text-align:left" colspan="2">&nbsp;Caf&eacute; Exportable</td><td><?=!empty($detalle)?number_format($detalle->analisis_cafe_exportable_peso,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->analisis_cafe_exportable_por,2,'.',','):'';?></td>
				</tr>
				<tr>
					<td colspan="3" rowspan="3" style="border:0"></td><td rowspan="3" style="border:0"></td>
					<td style="text-align:left" colspan="2">&nbsp;Sub Producto</td><td><?=!empty($detalle)?number_format($detalle->analisis_sub_procuto_peso,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->analisis_sub_procuto_por,2,'.',','):'';?></td>
				</tr>
				<tr>
					<td style="text-align:left" colspan="2">&nbsp;Descarte</td><td><?=!empty($detalle)?number_format($detalle->analisis_descarte_peso,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->analisis_descarte_por,2,'.',','):'';?></td>
				</tr>
				<?
					$peso = 0; $porcpeso = 0;
					if(!empty($detalle)){
						$peso += floatval($detalle->analisis_cafe_exportable_peso)+floatval($detalle->analisis_sub_procuto_peso)+floatval($detalle->analisis_descarte_peso)+floatval($detalle->analisis_cascara_peso);
						$porcpeso += floatval($detalle->analisis_cafe_exportable_por)+floatval($detalle->analisis_sub_procuto_por)+floatval($detalle->analisis_descarte_por)+floatval($detalle->analisis_cascara_por);
					}
				?>
				<tr>
					<td style="text-align:left" colspan="2">&nbsp;C&aacute;scara</td><td><?=!empty($detalle)?number_format($detalle->analisis_cascara_peso,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->analisis_cascara_por,2,'.',','):'';?></td>
				</tr>
				<tr>
					<th colspan="3" bgcolor="#DDDDDD">DATOS TOSTADO</th><td style="border:0"></td><!--<td colspan="4" style="border:0"></td>-->
					<td colspan="2"><b>TOTAL</b></td><td><?=!empty($detalle)?number_format($peso,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($porcpeso,2,'.',','):'';?></td>
				</tr>
				<tr>
					<td style="text-align:left" colspan="2">&nbsp;Tiempo de Tostado</td><td><?=!empty($detalle)?number_format($detalle->tostado_tiempo,2,'.',','):'';?></td>
					<td colspan="5" style="border:0"></td>
				</tr>
				<tr>
					<td style="text-align:left" colspan="2">&nbsp;Color / agtron</td><td><?=!empty($detalle)?number_format($detalle->tostado_color_agtron,2,'.',','):'';?></td>
					<td rowspan="3" style="border:0"></td><th colspan="4" bgcolor="#DDDDDD">CATEGOR&Iacute;A / TOSTADO</th>
				</tr>
				<tr>
					<td style="text-align:left" colspan="2">&nbsp;% P&eacute;rdida</td><td><?=!empty($detalle)?number_format($detalle->tostado_perdida,2,'.',','):'';?></td>
					<td style="text-align:left" colspan="2">&nbsp;Apariencia</td><td colspan="2"><?=!empty($detalle)?$detalle->apariencia:'&nbsp;';?></td>
				</tr>
				<tr>
					<td style="border:0" colspan="3">&nbsp;</td>
					<td style="text-align:left" colspan="2">&nbsp;QUAKER</td><td colspan="2"><?=!empty($detalle)?$detalle->quaker:'&nbsp;';?></td>
				</tr>
			</table>
			
			<table cellspacing="0" cellpadding="1" align="center" width="18cm" class="acciones sensorial" style="margin-top:5mm">
				<tr bgcolor="#DDDDDD">
					<th bgcolor="#fff" rowspan="2" style="border:0"></th>
					<th colspan="3">CONTEO DE DEFECTOS</th><th colspan="4" rowspan="2">AN&Aacute;LISIS SENSORIAL DEL CAF&Eacute;</th>
				</tr>
				<tr><td><b>DEFECTO</b></td><td><b>N&Uacute;MERO</b></td><td><b>EQUIVALENCIA</b></td></tr>
				<?
					$equi = 0; $ptos = 0; $ptotal = 0;
					if(!empty($detalle)){
						$equi += floatval($detalle->def_pri_negro_completo_equi)+floatval($detalle->def_pri_agrio_completo_equi)+floatval($detalle->def_pri_cereza_seca_equi)+floatval($detalle->def_pri_danado_equi);
						$equi += floatval($detalle->def_pri_danado_severo_equi)+floatval($detalle->def_pri_materia_equi)+floatval($detalle->def_sec_negro_parcial_equi)+floatval($detalle->def_sec_agrio_parcial_equi);
						$equi += floatval($detalle->def_sec_pergamino_equi)+floatval($detalle->def_sec_flotador_equi)+floatval($detalle->def_sec_inmaduro_equi)+floatval($detalle->def_sec_averanado_equi);
						$equi += floatval($detalle->def_sec_concha_equi)+floatval($detalle->def_sec_quebrado_equi)+floatval($detalle->def_sec_cascara_equi)+floatval($detalle->def_sec_insectos_equi);
						$ptos += floatval($detalle->atributos_fragancia_puntos)+floatval($detalle->atributos_sabor_puntos)+floatval($detalle->atributos_residual_puntos)+floatval($detalle->atributos_acidez_puntos);
						$ptos += floatval($detalle->atributos_cuerpo_puntos)+floatval($detalle->atributos_uniformidad_puntos)+floatval($detalle->atributos_balance_puntos)+floatval($detalle->atributos_taza_puntos);
						$ptos += floatval($detalle->atributos_dulzura_puntos)+floatval($detalle->atributos_apreciacion_puntos);
						
						$ptotal = $ptos - floatval($detalle->atributos_defectos_sustraer);
					}
				?>
				<tr>
					<td rowspan="6" bgcolor="#DDDDDD" width="2cm"><b>DEFECTOS PRIMARIOS</b></td>
					<td style="text-align:left">&nbsp;NEGRO COMPLETO</td><td><?=!empty($detalle)?number_format($detalle->def_pri_negro_completo_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_pri_negro_completo_equi,2,'.',','):'';?></td>
					<td><b>ATRIBUTOS</b></td><td><b>PUNTOS</b></td><td colspan="2"><b>CARACTERISTICAS</b></td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;AGRIO COMPLETO</td><td><?=!empty($detalle)?number_format($detalle->def_pri_agrio_completo_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_pri_agrio_completo_equi,2,'.',','):'';?></td>
					<td style="text-align:left">&nbsp;FRAGANCIA/AROMA</td><td><?=!empty($detalle)?number_format($detalle->atributos_fragancia_puntos,2,'.',','):'';?></td>
					<td colspan="2"><?=!empty($detalle)?$detalle->atributos_fragancia_caracteristicas:'&nbsp;';?></td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;CEREZA SECA</td><td><?=!empty($detalle)?number_format($detalle->def_pri_cereza_seca_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_pri_cereza_seca_equi,2,'.',','):'';?></td>
					<td style="text-align:left">&nbsp;SABOR</td><td><?=!empty($detalle)?number_format($detalle->atributos_sabor_puntos,2,'.',','):'';?></td>
					<td colspan="2"><?=!empty($detalle)?$detalle->atributos_sabor_caracteristicas:'&nbsp;';?></td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;DA&Ntilde;ADO POR HONGOS</td><td><?=!empty($detalle)?number_format($detalle->def_pri_danado_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_pri_danado_equi,2,'.',','):'';?></td>
					<td style="text-align:left">&nbsp;SABOR RESIDUAL</td><td><?=!empty($detalle)?number_format($detalle->atributos_residual_puntos,2,'.',','):'';?></td>
					<td colspan="2"><?=!empty($detalle)?$detalle->atributos_residual_caracteristicas:'&nbsp;';?></td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;DA&Ntilde;O SEVERO DE INSECTOS</td><td><?=!empty($detalle)?number_format($detalle->def_pri_danado_severo_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_pri_danado_severo_equi,2,'.',','):'';?></td>
					<td style="text-align:left">&nbsp;ACIDEZ</td><td><?=!empty($detalle)?number_format($detalle->atributos_acidez_puntos,2,'.',','):'';?></td>
					<td colspan="2"><?=!empty($detalle)?$detalle->atributos_acidez_caracteristicas:'&nbsp;';?></td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;MATERIA EXTRA&Ntilde;A</td><td><?=!empty($detalle)?number_format($detalle->def_pri_materia_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_pri_materia_equi,2,'.',','):'';?></td>
					<td style="text-align:left">&nbsp;CUERPO</td><td><?=!empty($detalle)?number_format($detalle->atributos_cuerpo_puntos,2,'.',','):'';?></td>
					<td colspan="2"><?=!empty($detalle)?$detalle->atributos_cuerpo_caracteristicas:'&nbsp;';?></td>
				</tr>
				<tr>
					<td rowspan="10" bgcolor="#DDDDDD" width="2cm"><b>DEFECTOS SECUNDARIOS</b></td>
					<td style="text-align:left">&nbsp;NEGRO PARCIAL</td><td><?=!empty($detalle)?number_format($detalle->def_sec_negro_parcial_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_sec_negro_parcial_equi,2,'.',','):'';?></td>
					<td style="text-align:left">&nbsp;UNIFORMIDAD</td><td><?=!empty($detalle)?number_format($detalle->atributos_uniformidad_puntos,2,'.',','):'';?></td>
					<td colspan="2"><?=!empty($detalle)?$detalle->atributos_uniformidad_caracteristicas:'&nbsp;';?></td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;AGRIO PARCIAL</td><td><?=!empty($detalle)?number_format($detalle->def_sec_agrio_parcial_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_sec_agrio_parcial_equi,2,'.',','):'';?></td>
					<td style="text-align:left">&nbsp;BALANCE</td><td><?=!empty($detalle)?number_format($detalle->atributos_balance_puntos,2,'.',','):'';?></td>
					<td colspan="2"><?=!empty($detalle)?$detalle->atributos_balance_caracteristicas:'&nbsp;';?></td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;PERGAMINO</td><td><?=!empty($detalle)?number_format($detalle->def_sec_pergamino_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_sec_pergamino_equi,2,'.',','):'';?></td>
					<td style="text-align:left">&nbsp;TAZA LIMPIA</td><td><?=!empty($detalle)?number_format($detalle->atributos_taza_puntos,2,'.',','):'';?></td>
					<td colspan="2"><?=!empty($detalle)?$detalle->atributos_taza_caracteristicas:'&nbsp;';?></td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;FLOTADOR</td><td><?=!empty($detalle)?number_format($detalle->def_sec_flotador_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_sec_flotador_equi,2,'.',','):'';?></td>
					<td style="text-align:left">&nbsp;DULZURA</td><td><?=!empty($detalle)?number_format($detalle->atributos_dulzura_puntos,2,'.',','):'';?></td>
					<td colspan="2"><?=!empty($detalle)?$detalle->atributos_dulzura_caracteristicas:'&nbsp;';?></td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;INMADURO</td><td><?=!empty($detalle)?number_format($detalle->def_sec_inmaduro_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_sec_inmaduro_equi,2,'.',','):'';?></td>
					<td style="text-align:left">&nbsp;APRECIACI&Oacute;N GENERAL</td><td><?=!empty($detalle)?number_format($detalle->atributos_apreciacion_puntos,2,'.',','):'';?></td>
					<td colspan="2" rowspan="2"><?=!empty($detalle)?$detalle->atributos_apreciacion_caracteristicas:'&nbsp;';?></td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;AVERANADO</td><td><?=!empty($detalle)?number_format($detalle->def_sec_averanado_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_sec_averanado_equi,2,'.',','):'';?></td>
					<td style="text-align:left">&nbsp;PUNTAJE TOTAL</td><td><?=!empty($detalle)?number_format($ptos,2,'.',','):'';?></td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;CONCHA</td><td><?=!empty($detalle)?number_format($detalle->def_sec_concha_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_sec_concha_equi,2,'.',','):'';?></td>
					<td bgcolor="#DDDDDD"><b>TOTAL CATADORES</b></td><td bgcolor="#DDDDDD"><?=!empty($catadores)?count($catadores):'';?></td>
					<td bgcolor="#DDDDDD">Nº TAZAS</td><td bgcolor="#DDDDDD">x INTENSIDAD</td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;QUEBRADO/CORTADO/MORDIDO</td><td><?=!empty($detalle)?number_format($detalle->def_sec_quebrado_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_sec_quebrado_equi,2,'.',','):'';?></td>
					<td style="text-align:left" bgcolor="#DDDDDD">&nbsp;DEFECTOS A SUSTRAER</td><td><?=!empty($detalle)?number_format($detalle->atributos_defectos_sustraer,0,'.',','):'';?></td>
					<td style="border-bottom:1px solid #4B4B4B"><?=!empty($detalle)?number_format($detalle->atributos_numero_tasas,0,'.',','):'';?></td>
					<td style="border-bottom:1px solid #4B4B4B"><?=!empty($detalle)?number_format($detalle->atributos_numero_intensidad,0,'.',','):'';?></td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;C&Aacute;SCARA / PULPA</td><td><?=!empty($detalle)?number_format($detalle->def_sec_cascara_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_sec_cascara_equi,2,'.',','):'';?></td>
					<td bgcolor="#DDDDDD">&nbsp;PUNTAJE FINAL SCA</td><td bgcolor="#DDDDDD"><?=!empty($detalle)?number_format($ptotal,2,'.',','):'';?></td>
					<td colspan="2" style="border:0"></td>
				</tr>
				<tr>
					<td style="text-align:left">&nbsp;DA&Ntilde;O LIGERO DE INSECTOS</td><td><?=!empty($detalle)?number_format($detalle->def_sec_insectos_num,2,'.',','):'';?></td>
					<td><?=!empty($detalle)?number_format($detalle->def_sec_insectos_equi,2,'.',','):'';?></td>
					<td style="border:0"></td><td style="border:0"></td>
				</tr>
				<tr>
					<td style="border:0"></td>
					<td colspan="2">TOTAL</td><td><?=!empty($detalle)?number_format($equi,2,'.',','):'';?></td><td bgcolor="#DDDDDD">OBSERVACIONES</td><td colspan="3"></td>
				</tr>
			</table>
			<?
				$i = 0; $cta = count($catadores); $cm = ($cta * 4) + ($cta*0.7);
				if(!empty($catadores)){?>
			<table align="center" width="<?=$cm?>cm" style="margin-top:2cm;text-transform:uppercase;">
				<tr>
			<?
					for($i = 0;$i < $cta;$i++){
			?>
				<td style="border-top:1px solid #4B4B4B;font-size:9px;text-align:center;width:3cm"><?=$catadores[$i]->nombres?></td><td style="width:0.7cm"></td>
			<?		}	?>
				</tr>
			</table>
			<?	}
			// Si el grafico esta guardado mostrarlo en la segunda pagina
			if($certificado->ruta_grafico){?>
			<div style="page-break-after:always;"></div>
			<img style="width:12cm;margin-left:4.5cm" src="<?=base_url()?>public/images/graficos/<?=$certificado->ruta_grafico?>" />
			<?}?>
        </main>
    </body>
</html>