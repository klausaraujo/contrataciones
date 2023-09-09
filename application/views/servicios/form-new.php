					<?
						$usuario = json_decode($this->session->userdata('user'));
					?>
					<div class="col-12 iq-card my-3">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4>Registro de Movimientos de Caja de Sucursales</h4></div>
						</div>
						<div class="iq-card-body">
							<input type="hidden" id="saldoActual" value="<?=$saldo?>" />
							<form method="post" id="form_caja" action="<?=base_url()?>servicios/registrar" ><!-- class="needs-validation form-horizontal"-->
								<input type="hidden" name="tiporegistro" value="registrar" />								
								<div class="form-row">
									<div class="col-12 my-1">
										<div class="row">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="saldo">&nbsp;&nbsp;Saldo en caja:</label>
											<?
												$clase = 'text-success';
												if(floatVal($saldo) > 0) $clase = 'text-primary';
												elseif(floatVal($saldo) < 0) $clase = 'text-danger';
											?>
											<div class="col-md-6 col-lg-4 pl-0">
												<input type="text" class="form-control form-control-sm saldo col-md-6 mr-auto text-right font-weight-bold <?=$clase?>"
														value="<?=number_format($saldo,2,'.',',');?>" name="saldo" id="saldo" readonly />
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="sucursalCaja">&nbsp;&nbsp;Sucursal:</label>
											<div class="col-md-6 col-lg-4">
												<div class="row">
													<select class="form-control sucursal" name="sucursalCaja" id="sucursalCaja">
													<? foreach($usuario->sucursales as $row): ?>
														<option value="<?=$row->idsucursal;?>" ><?=$row->sucursal;?></option>
													<? endforeach;	?>
													</select>
													<div class="invalid-feedback">Debe elegir una sucursal</div>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="tipoCaja">&nbsp;&nbsp;Tipo Operaci&oacute;n:</label>
											<div class="col-md-6 col-lg-4">
												<div class="row">
													<select class="form-control tipoCaja" name="tipoCaja" id="tipoCaja">
													<? foreach($tipo as $row): ?>
														<option value="<?=$row->idtipooperacion;?>" ><?=$row->tipo_operacion;?></option>
													<? endforeach;	?>
													</select>
													<div class="invalid-feedback">Debe elegir un tipo de operacion</div>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="monto">&nbsp;&nbsp;Monto:</label>
											<div class="col-md-6 col-lg-5">
												<div class="row">
													<input type="text" class="form-control col-md-7 moneda blur" name="monto" id="monto" autocomplete="off" />
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="fecha">&nbsp;&nbsp;Fecha:</label>
											<div class="col-md-6 col-lg-5">
												<div class="row">
													<input type="date" class="form-control col-md-7" value="<?=date('Y-m-d')?>" name="fecha" id="fecha" />
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="obs">&nbsp;&nbsp;Observaciones:</label>
											<div class="col-md-6 col-lg-4">
												<div class="row">
													<textarea type="text" class="form-control mayusc" name="obs" id="obs" placeholder="Observaciones" maxlength="1000" ></textarea>
												</div>
											</div>
										</div>
										<div id="gastos" class="d-none">
											<div class="row mt-3">
												<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="rucvalor">&nbsp;&nbsp;Ruc Proveedor:</label>
												<div class="col-md-6 col-lg-4">
													<div class="row">
														<input type="text" id="rucvalor" name="rucvalor" minlength="11" maxlength="11" class="form-control col-md-7 col-lg-9 num" />
														<button id="buscaRuc" type="button" class="btn btn-small btn-narsa col-md-3 col-lg-2 ml-md-2 mt-3 mt-md-0 align-self-center">
															<i class="fa fa-search aria-hidden="true"></i>
														</button>
													</div>
												</div>
											</div>
											<div class="row mt-3">
												<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="razonSoc">&nbsp;&nbsp;Raz&oacute;n Social:</label>
												<div class="col-md-6 col-lg-4">
													<div class="row">
														<input type="text" class="form-control" name="razonSoc" id="razonSoc" placeholder="Raz&oacute;n Social" readonly />
													</div>
												</div>
											</div>
											<div class="row mt-3">
												<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="tipoComp">&nbsp;&nbsp;Tipo de Comprobante:</label>
												<div class="col-md-6 col-lg-4">
													<div class="row">
														<select class="form-control" name="tipoComp" id="tipoComp">
															<option value="00">OTROS</option>
															<option value="01">FACTURA</option>
															<option value="02">RECIBO POR HONORARIOS</option>
															<option value="03">BOLETA DE VENTA</option>
															<option value="04">LIQUIDACIÓN DE COMPRA</option>
															<option value="05">BOLETA TRANSPORTE AEREO</option>
															<option value="06">CARTA DE PORTE AEREO</option>
															<option value="07">NOTA DE CRÉDITO</option>
															<option value="08">NOTA DE DÉBITO</option>
															<option value="09">GUÍA DE REMISIÓN - REMITENTE</option>
															<option value="10">RECIBO POR ARRENDAMIENTO</option>
															<option value="11">PÓLIZA EMITIDA POR LAS BOLSAS DE VALORES</option>
															<option value="12">TICKET O CINTA EMITIDO POR MÁQUINA REGISTRADORA</option>
															<option value="13">DOCUMENTO BANCARIO</option>
															<option value="14">RECIBO POR SERVICIOS PÚBLICOS</option>
														</select>
													</div>
												</div>
											</div>
											<div class="row mt-3">
												<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="serie">&nbsp;&nbsp;Serie del Comprobante:</label>
												<div class="col-md-6 col-lg-1">
													<div class="row">
														<input type="text" class="form-control mayusc" name="serie" id="serie" maxlength="5" />
													</div>
												</div>
												<label class="control-label col-md-6 col-lg-2 align-self-center mb-0 mt-3 mt-lg-0" for="num">&nbsp;&nbsp;N&uacute;mero:</label>
												<div class="col-md-6 col-lg-1">
													<div class="row">
														<input type="text" class="form-control mt-3 mt-lg-0 mayusc" name="num" id="num" maxlength="8" />
													</div>
												</div>
											</div>
											<div class="row mt-3">
												<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="baseImp">&nbsp;&nbsp;Base Imponible:</label>
												<div class="col-md-6 col-lg-1">
													<div class="row">
														<input type="text" class="form-control moneda" name="baseImp" id="baseImp" placeholder="0.00" readonly />
													</div>
												</div>
												<div class="col-md-6 col-lg-2 align-self-center">
													<label class="control-label align-self-center mb-0 mt-3 mt-lg-0" for="igv">&nbsp;&nbsp;I.G.V:</label>
													<div class="custom-control custom-switch pr-0 d-inline ml-2">
														<input type="checkbox" class="custom-control-input" name="checkigv" id="checkigv" />
														<label class="custom-control-label mt-3 mt-lg-0" for="checkigv"></label>
													</div>
												</div>
												<div class="col-md-6 col-lg-1">
													<div class="row">
														<input type="text" class="form-control mt-0 mt-md-3 mt-lg-0 moneda" name="igv" id="igv" placeholder="0.00" readonly />
													</div>
												</div>
											</div>
											<div class="row mt-3">
												<div class="col-md-6 col-lg-3">
													<label class="control-label align-self-center mb-0 mt-3 mt-lg-0" for="renta">&nbsp;&nbsp;Renta:</label>
													<div class="custom-control custom-switch pr-0 d-inline ml-2">
														<input type="checkbox" class="custom-control-input" name="checkrenta" id="checkrenta" disabled />
														<label class="custom-control-label mt-3 mt-lg-0" for="checkrenta"></label>
													</div>
												</div>
												<div class="col-md-6 col-lg-1">
													<div class="row">
														<input type="text" class="form-control moneda" name="renta" id="renta" placeholder="0.00" readonly />
													</div>
												</div>
											</div>
											<input type="hidden" name="base_imponible" id="base_imponible" />
											<input type="hidden" name="imp_igv" id="imp_igv" />
											<input type="hidden" name="imp_renta" id="imp_renta" />
											<div class="row mt-3">
												<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="detalle">&nbsp;&nbsp;Detalle Comprobante:</label>
												<div class="col-md-6 col-lg-4">
													<div class="row">
														<textarea class="form-control mayusc" name="detalle" id="detalle" placeholder="Detalle Comprobante" maxlength="500"></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="container-fluid row"><hr class="col-sm-12"></div>
								<div class="col-12 mx-auto pb-2">
									<button type="submit" class="btn btn-narsa ml-1 mr-4" id="btnEnviar">Guardar Registro</button>
									<button type="reset" class="btn btn-narsa btn-cancelar">Cancelar</button>
								</div>
							</form>
						</div>
					</div>