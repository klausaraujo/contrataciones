					<? $usuario = json_decode($this->session->userdata('user')); ?>
					<div class="col-12 iq-card my-3">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4><b><?=ucwords(strtolower($this->input->get('name')))?></b> (Ventas)</h4></div>
						</div>
						<div class="iq-card-body">
							<!--<div class="row">-->
								<!-- Nav pills -->
								<div class="nav nav-pills row" id="nav-tab" role="tablist">
									<a class="nav-item nav-link col-lg-3 col-12 col-md-4 text-center active" data-toggle="tab" href="#pill-salidas">Gesti&oacute;n de Ventas</a>
								</div>
							<!--</div>-->
							<!-- Tab panes -->
							<div class="tab-content">
								<div class="tab-pane active mx-auto" id="pill-salidas">
									<div class="row container mx-auto">
										<div class="col-md-11 mt-4">
											<button type="button" data-toggle="modal" class="btn btn-narsa d-flex ml-auto" id="modalVtas" data-target="#modalVentas">Nueva Venta</button>
										</div>
									</div>
									<div class="col-md-12 text-center pt-2 resp" style="font-size:1.3em">&nbsp;</div>
									<div class="container-fluid my-2">
										<div class="row">
											<div class="col-12 mx-auto" style="overflow-x:auto">
												<table id="tablaVentas" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			
					<div class="modal fade" id="modalVentas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-ing" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Salida de Productos</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body" style="overflow:auto;">
									<form method="post" id="form_salidas">
										<div class="row">
											<div class="col-md-11 mx-auto">
												<div class="row mt-2">
													<label for="clienteSalida" class="col-md-2 align-self-center mb-0">Cliente:</label>
													<div class="col-md-4">
														<input type="text" class="form-control" value="<?=ucwords(strtolower($this->input->get('name')))?>"
															name="clienteSalida" id="clienteSalida" readonly />
													</div>
													<label for="sucursalSal" class="col-md-2 align-self-center mb-0">Sucursal:</label>
													<div class="col-md-4">
														<select class="form-control" name="sucursalSal" id="sucursalSal">
													<?
														foreach($usuario->sucursales as $row):	?>
															<option value="<?=$row->idsucursal;?>"><?=$row->sucursal;?></option>
													<?	endforeach;	?>
														</select>
													</div>
												</div>
												<div class="detalleSal">
													<div class="row my-4">
														<label for="obsSal" class="col-md-2 align-self-center mb-0">Observaciones:</label>
														<div class="col-md-10">
															<input type="text" class="form-control mayusc" name="obsSal" id="obsSal" autocomplete="off" placeholder="Observaciones" />
														</div>
													</div>
													<div class="row my-4">
														<label for="articuloSal" class="col-md-2 align-self-center mb-0">Producto:</label>
														<div class="col-md-4">
															<select class="form-control" name="articuloSal" id="articuloSal">
																<option value="">--Seleccione--</option>
															<?
															foreach($articulos as $row):	?>
																<option value="<?=$row->idarticulo;?>"><?=$row->articulo;?></option>
															<?	endforeach;	?>
															</select>
														</div>
														<label for="calidadSal" class="col-md-2 align-self-center mb-0">Calidad RDTO(%):</label>
														<div class="col-md-4">
															<input type="text" class="form-control prod moneda" name="calidadSal" id="calidadSal" autocomplete="off" placeholder="0.00" />
														</div>
													</div>
													<div class="row my-4">
														<label for="humedadSal" class="col-md-2 align-self-center mb-0">Humedad (%):</label>
														<div class="col-md-4">
															<input type="text" class="form-control prod moneda" name="humedadSal" id="humedadSal" autocomplete="off" placeholder="0.00" />
														</div>
														<label for="tasaSal" class="col-md-2 align-self-center mb-0">Tasa (Pts.):</label>
														<div class="col-md-4">
															<input type="text" class="form-control prod moneda" name="tasaSal" id="tasaSal" autocomplete="off" placeholder="0.00" />
														</div>
													</div>
													<div class="row my-4">
														<label for="cantidadSal" class="col-md-2 align-self-center mb-0">Cantidad KG:</label>
														<div class="col-md-4">
															<input type="text" class="form-control prod moneda" name="cantidadSal" id="cantidadSal" autocomplete="off" placeholder="0.00" />
														</div>
														<label for="costoSal" class="col-md-2 align-self-center mb-0">Costo:</label>
														<div class="col-md-4">
															<input type="text" class="form-control prod moneda" name="costoSal" id="costoSal" placeholder="0.00" autocomplete="off" />
														</div>
													</div>
												</div>
												<div class="row my-2">
													<div class="col-md-2">
														<input type="submit" class="btn btn-narsa d-flex ml-auto col-12 justify-content-center" id="btnAgregarSalDetalle" value="Agregar"/>
													</div>
												</div>
											</div>
										</div>
									</form>
									<div class="container-fluid">
										<div class="row mx-2">
											<div class="col-12" style="overflow-x:auto">
												<table id="tablaSalDetalle" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
											</div>
										</div>
									</div>
									<form method="post" id="form_pago_venta">
										<input type="hidden" value="" id="tipo_registro" name="tipo_registro" />
										<input type="hidden" value="" id="guia_vta" name="guia_vta" />
										<input type="hidden" value="" id="idtrans" name="idtrans" />
										<div class="row">
											<div class="col-md-11 mx-auto">
												<div class="row my-4">
													<label for="tipoPagoVta" class="col-md-2 align-self-center mb-0">Tipo Pago:</label>
													<div class="col-md-4">
														<select class="form-control" name="tipoPagoVta" id="tipoPagoVta">
														<?
															foreach($tipopago as $row):	?>
															<option value="<?=$row->idtipooperacion;?>"><?=$row->tipo_operacion;?></option>
														<?	endforeach;	?>
														</select>
													</div>
													<label for="medioPagoVta" class="col-md-2 align-self-center mb-0">Medio Pago:</label>
													<div class="col-md-4">
														<select class="form-control" name="medioPagoVta" id="medioPagoVta">
														<?
															foreach($mediopago as $row):	?>
															<option value="<?=$row->idmediopago;?>"><?=$row->medio_pago;?></option>
														<?	endforeach;	?>
														</select>
													</div>
												</div>
												<div class="row mt-3">
													<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="tipoComp">Tipo de Comprobante:</label>
													<div class="col-md-6 col-lg-6">
														<div class="row">
															<select class="form-control" name="tipoComp" id="tipoComp">
																<option value="01">FACTURA</option>
																<option value="03">BOLETA DE VENTA</option>
															</select>
														</div>
													</div>
												</div>
												<div class="row mt-3">
													<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="serie">Serie del Comprobante:</label>
													<div class="col-md-6 col-lg-2">
														<div class="row">
															<input type="text" class="form-control mayusc" name="serie" id="serie" maxlength="5" />
														</div>
													</div>
													<label class="control-label col-md-6 col-lg-2 align-self-center mb-0 mt-3 mt-lg-0" for="num">N&uacute;mero:</label>
													<div class="col-md-6 col-lg-2">
														<div class="row">
															<input type="text" class="form-control mt-3 mt-lg-0 mayusc" name="num" id="num" maxlength="8" />
														</div>
													</div>
												</div>
												<div class="row mt-3">
													<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="baseImp">Base Imponible:</label>
													<div class="col-md-6 col-lg-2">
														<div class="row">
															<input type="text" class="form-control" name="baseImp" id="baseImp" placeholder="0.00" readonly />
														</div>
													</div>
													<div class="col-md-6 col-lg-2 align-self-center">
														<label class="control-label align-self-center mb-0 mt-3 mt-lg-0" for="igv">I.G.V:</label>
														<div class="custom-control custom-switch pr-0 d-inline ml-2">
															<input type="checkbox" class="custom-control-input" name="checkigv" id="checkigv" />
															<label class="custom-control-label mt-3 mt-lg-0" for="checkigv"></label>
														</div>
													</div>
													<div class="col-md-6 col-lg-2">
														<div class="row">
															<input type="text" class="form-control mt-0 mt-md-3 mt-lg-0" name="igv" id="igv" placeholder="0.00" readonly />
														</div>
													</div>
												</div>
												<div class="row my-3">
													<label class="control-label col-md-6 col-lg-3 align-self-center mb-0 mt-3 mt-lg-0" for="total">Total:</label>
													<div class="col-md-6 col-lg-2">
														<div class="row">
															<input type="text" class="form-control" name="totalvta" id="totalvta" placeholder="0.00" readonly />
														</div>
													</div>
												</div>
												<input type="hidden" name="base_imponible" id="base_imponible" />
												<input type="hidden" name="imp_igv" id="imp_igv" />
												<input type="hidden" name="total_vta" id="total_vta" />
											</div>
										</div>
										<div class="modal-footer">
											<div class="row">
												<div class="col-md-12">
													<button class="btn btn-narsa mr-3" data-dismiss="modal" id="cancelSal">Cancelar Operaci&oacute;n</button>
													<button type="submit" class="btn btn-narsa" id="generarSal">Generar Venta</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>