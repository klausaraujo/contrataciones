					<? $usuario = json_decode($this->session->userdata('user')); ?>
					<div class="col-12 iq-card my-3">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4><b><?=ucwords(strtolower($this->input->get('name')))?></b> (Transacciones Financieras)</h4></div>
						</div>
						<div class="iq-card-body">
							<!--<div class="row">
								<!-- Nav pills -->
								<div class="nav nav-pills row" id="nav-tab" role="tablist">
									<a class="nav-item nav-link text-center active" data-toggle="tab" href="#pill-operaciones">Registro de Operaciones</a>
									<a class="nav-item nav-link text-center" data-toggle="tab" href="#pill-ingresos">Ingreso de Productos</a>
									<a class="nav-item nav-link text-center" data-toggle="tab" href="#pill-valorizaciones">Valorizaci&oacute;n de Productos</a>
								</div>
							<!--</div>-->
							<!-- Tab panes -->
							<div class="tab-content">
								<div class="tab-pane active mx-auto" id="pill-operaciones">
									<form method="post" id="form_transacciones" action="<?=base_url().$this->uri->segment(1).'/';?>transacciones/operaciones">
										<input type="hidden" name="idproveedor" id="idproveedor" value="<?=$this->input->get('id')?>" />
										<div class="row container mx-auto">
											<div class="col-lg-10 mx-auto">
												<div class="row">
													<div class="col-md-6 mt-4">
														<div class="row">
															<!--1,2,3,5,6,8-->
															<label class="control-label col-md-5 align-self-center mb-0" for="tipoop">Tipo Operaci&oacute;n:</label>
															<div class="col-md-7">
																<select class="form-control form-control-sm tipoop" name="tipoop" id="tipoop">
																	<option value="">--Seleccione--</option>
															<?
															foreach($tipo_op as $row):
																if($row->idtipooperacion !== '4' && $row->idtipooperacion !== '5'):
															?>
																	<option value="<?=$row->idtipooperacion;?>"><?=$row->tipo_operacion;?></option>	
															<?
																endif;
															endforeach;	?>
																</select>
															</div>
														</div>
													</div>
													<div class="col-md-6 mt-4">
														<div class="row">
															<label class="control-label col-md-5 align-self-center mb-0" for="sucursal">&nbsp;&nbsp;Sucursal:</label>
															<div class="col-md-7">
															<select class="form-control form-control-sm sucursal" name="sucursal" id="sucursal">
														<?
														foreach($usuario->sucursales as $row):	?>
																<option value="<?=$row->idsucursal;?>"><?=$row->sucursal;?></option>
													<?	endforeach;	?>
															</select>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<hr class="row col-11 mx-auto">
										<div class="container-fluid d-none" id="opciones_p">
											<input type="hidden" id="tipoop_p" name="tipoop_p" /><input type="hidden" id="idtipoop_p" name="idtipoop_p" />
											<div class="row col-md-11 mt-2 mx-auto d-none" id="pp_pe">
												<div class="col-md-4">
													<div class="row">
														<label class="control-label col-md-5 align-self-center mb-0" for="fechavenc">Fecha Venc.:</label>
														<div class="col-md-7 pl-0">
															<input type="date" class="form-control form-control-sm fechavenc" value="<?=date('Y-m-d')?>" name="fechavenc" id="fechavenc" />
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="row">
														<label class="control-label col-md-5 align-self-center mb-0 pr-0" for="monto">Mto Pr&eacute;stamo:</label>
														<div class="col-md-7">
															<input type="text" class="form-control form-control-sm  monto moneda" name="monto" id="monto" autocomplete="off" />
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<div class="row">
														<label class="control-label col-md-6 align-self-center mb-0 pr-0" for="interes">Tasa Inter&eacute;s:</label>
														<div class="col-md-6">
															<input type="text" class="form-control form-control-sm interes moneda" maxlength="3" name="interes" id="interes" autocomplete="off" />
														</div>
													</div>
												</div>
											</div>
											<div class="row col-md-11 mt-2 mx-auto d-none" id="pagos_p">
												<input type="hidden" id="mtopago" name="mtopago" /><input type="hidden" id="intpago" name="intpago" />
												<input type="hidden" id="idpago" name="idpago" /><input type="hidden" id="tasapago" name="tasapago" />
												<div class="col-md-4 offset-md-1">
													<div class="row">
														<label class="control-label col-md-5 align-self-center mb-0 pr-0" for="montopago">Monto Pago:</label>
														<div class="col-md-7">
															<input type="text" class="form-control form-control-sm monto moneda blur" name="montopago" id="montopago" autocomplete="off" readonly />
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="row">
														<label class="control-label col-md-6 align-self-center mb-0 pr-0" for="interespago">Total Intereses:</label>
														<div class="col-md-6">
															<input type="text" class="form-control form-control-sm interes moneda blur" name="interespago" id="interespago" autocomplete="off" readonly />
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<!--<div class="row"><label for="" class="align-self-center">&nbsp;&nbsp;</label></div>-->
													<div class="custom-control custom-switch pr-0 d-inline ml-2">
														<input type="checkbox" class="custom-control-input" name="checkliquidapago" id="checkliquidapago" disabled />
														<label class="custom-control-label mt-md-1" for="checkliquidapago">Liquidar</label>
													</div>
												</div>
												<div class="col-8 mx-auto mt-3">
													<table id="tablaPagos" class="table table-striped table-hover table-bordered mx-auto" style="width:100%"></table>
												</div>
											</div>
											<div class="row col-md-11 mt-2 mx-auto d-none" id="cobros_p">
												<input type="hidden" id="mtoprestamo" name="mtoprestamo" /><input type="hidden" id="intprestamo" name="intprestamo" />
												<input type="hidden" id="idprestamo" name="idprestamo" /><input type="hidden" id="tasaprestamo" name="tasaprestamo" />
												<div class="col-md-4 offset-md-1">
													<div class="row">
														<label class="control-label col-md-5 align-self-center mb-0 pr-0" for="montocobro">Monto Cobro:</label>
														<div class="col-md-7">
															<input type="text" class="form-control form-control-sm monto moneda blur" name="montocobro" id="montocobro" autocomplete="off" readonly />
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="row">
														<label class="control-label col-md-6 align-self-center mb-0 pr-0" for="interescobro">Total Intereses:</label>
														<div class="col-md-6">
															<input type="text" class="form-control form-control-sm interes moneda blur" name="interescobro" id="interescobro" autocomplete="off" readonly />
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<!--<div class="row"><label for="" class="align-self-center">&nbsp;&nbsp;</label></div>-->
													<div class="custom-control custom-switch pr-0 d-inline ml-2">
														<input type="checkbox" class="custom-control-input" name="checkliquida" id="checkliquida" disabled />
														<label class="custom-control-label mt-md-1" for="checkliquida">Liquidar</label>
													</div>
												</div>
												<div class="col-8 mx-auto mt-3"><!--class="table-responsive" -->
												<!--<div class="col-sm-12 mx-auto" style="overflow-x:scroll"><!--align-items-center text-center-->
													<table id="tablaCobros" class="table table-striped table-hover table-bordered mx-auto" style="width:100%"></table>
												</div>
											</div>
											<div class="row mt-2 mx-auto d-none" id="pagos_val">
												<input type="hidden" id="mtoval" name="mtoval" /><input type="hidden" id="idvalor" name="idvalor" />
												<div class="col-md-11 mx-auto">
													<div class="row mx-auto">
														<div class="col-md-6 offset-md-1">
															<!--<div class="row">
																<label for="montovalor" class="align-self-center">Monto a Pagar:</label>
															</div>-->
															<div class="row">
																<label class="control-label col-md-6 align-self-center mb-0 text-right" for="montovalor">Monto a Pagar:</label>
																<div class="col-md-6">
																	<input type="text" class="form-control form-control-sm montovalor moneda blur" name="montovalor" id="montovalor" autocomplete="off" readonly />
																</div>
															</div>
														</div>
														<div class="col-md-3">
															<!--<div class="row"><label for="" class="align-self-center">&nbsp;&nbsp;</label></div>-->
															<div class="custom-control custom-switch pr-0 d-inline ml-2">
																<input type="checkbox" class="custom-control-input" name="checkliquidaval" id="checkliquidaval" disabled />
																<label class="custom-control-label" for="checkliquidaval">Liquidar</label>
															</div>
														</div>
													</div>
													<div class="row mx-auto">
														<div class="col-7 mt-3 mx-auto"><!--class="table-responsive" -->
														<!--<div class="col-sm-12 mx-auto" style="overflow-x:scroll"><!--align-items-center text-center-->
															<table id="tablaPagosVal" class="table table-striped table-hover table-bordered mx-auto" style="width:100%;font-size:0.7em"></table>
														</div>
													</div>
												</div>
											</div>
											<div class="row col-md-6 mt-2 mx-auto d-none" id="antcta_p">
												<label for="montoanterior" class="control-label col-md-3 offset-md-2 align-self-center mb-0">Monto:</label>
												<div class="col-md-5">
													<input type="text" class="form-control form-control-sm moneda" name="montoanterior" id="montoanterior" autocomplete="off" />
												</div>
											</div>
											<div class="row mt-3">
												<label class="control-label col-md-2 align-self-center mb-0 ml-md-5" for="obstransacciones">Observaciones:</label>
												<div class="col-md-6">
													<input class="form-control form-control-sm mayusc" maxlength="1000" id="obstransacciones" name="obstransacciones" />
												</div>
												<div class="col-md-3"><button type="submit" class="btn btn-narsa col-md-8 offset-md-3">Ejecutar</button></div>
											</div>
											<hr class="row col-11 mx-auto">
										</div>
									</form>
									<div class="col-md-12 text-center resp" style="font-size:1.3em">&nbsp;</div>
									<div class="container-fluid">
										<div class="row">
											<div class="col-md-6 mb-3">
												<a class="btn btn-narsa ml-3" href="<?=base_url()?>proveedores/transacciones/edo_cta?id=<?=$this->input->get('id')?>&op=edocta" 
													target="_blank">Estado de Cuenta</a>
											</div>
											<div class="col-md-6 mb-3">
												<div class="form-group row">
													<label class="control-label col-md-5 align-self-center mb-md-0 ml-md-auto px-0" for="rescta">Estado de Cuenta Actual:</label>
													<div class="col-xs-10 mx-xs-auto col-md-4 mr-md-3">
													<?
														$clase = 'text-success';
														if(floatVal($edocta) > 0) $clase = 'text-primary';
														elseif(floatVal($edocta) < 0) $clase = 'text-danger';
													?>
														<input type="text" class="form-control form-control-sm text-md-right font-weight-bold <?=$clase?>" id="rescta" 
															value="<?=number_format($edocta,2,'.',',');?>" readonly >
													</div>
												</div>
											</div>
											<!--<div style="overflow-x:hidden" class="col-12"><!--class="table-responsive" -->
											<div class="container-fluid">
												<div class="row">
													<div class="col-12 mx-auto" style="overflow-x:auto">
														<table id="tablaOp" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%;font-size:0.7em"></table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade mx-auto" id="pill-ingresos">
									<div class="row container mx-auto">
										<div class="col-md-11 mt-4">
											<!--<label for="btnbuscaIE" class="col-sm-12">&nbsp;</label>-->
											<button type="button" data-toggle="modal" class="btn btn-narsa d-flex ml-auto" id="modalIng" data-target="#modalIngresos">Nuevo Ingreso</button>
										</div>
									</div>
									<div class="col-md-12 text-center resp" style="font-size:1.3em">&nbsp;</div>
									<div class="container-fluid">
										<div class="row">
											<div class="col-12 mx-auto" style="overflow-x:auto">
											<!--<div class="col-sm-12 mx-auto" style="overflow-x:scroll"><!--align-items-center text-center-->
												<!--<table id="tablaIngresos" class="table table-striped dt-responsive table-bordered display nowrap table-hover mb-0 mx-auto"></table>-->
												<table id="tablaIngresos" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="pill-valorizaciones">
									<div class="row container mx-auto">
										<div class="col-md-11 mt-4">
											<!--<label for="btnbuscaIE" class="col-sm-12">&nbsp;</label>-->
											<button type="button" data-toggle="modal" class="btn btn-narsa d-flex ml-auto" id="modalVal" data-target="#modalValorizaciones">Nueva Valorizaci&oacute;n</button>
										</div>
									</div>
									<div class="col-md-12 text-center resp" style="font-size:1.3em">&nbsp;</div>
									<div class="container-fluid">
										<div class="row">
											<div class="col-12 mx-auto" style="overflow-x:auto">
											<!--<div class="col-sm-12 mx-auto" style="overflow-x:scroll"><!--align-items-center text-center-->
												<!--<table id="tablaValorizaciones" class="table table-striped dt-responsive table-bordered display nowrap table-hover mb-0 mx-auto"></table>-->
												<table id="tablaValorizaciones" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			
					<div class="modal fade" id="modalIngresos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-ing" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Ingreso de Productos</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body" style="overflow: hidden;">
									<form method="post" id="form_ingresos">
										<div class="row">
											<div class="col-md-11 mx-auto">
												<div class="row mt-2">
													<div class="col-md-2 centraVert"><label for="proveedorIng" class="col-12">Proveedor:</label></div>
													<div class="col-md-4">
														<input type="text" class="form-control col-12" value="<?=ucwords(strtolower($this->input->get('name')))?>"
															name="proveedorIng" id="proveedorIng" readonly />
													</div>
													<div class="col-md-2 centraVert"><label for="sucursalIng" class="col-12">Sucursal:</label></div>
													<div class="col-md-4">
														<select class="form-control col-12 sucursalIng" name="sucursalIng" id="sucursalIng">
													<?
														foreach($usuario->sucursales as $row):	?>
															<option value="<?=$row->idsucursal;?>"><?=$row->sucursal;?></option>
													<?	endforeach;	?>
														</select>
													</div>
												</div>
												<div class="row my-4">
													<div class="col-md-2 centraVert"><label for="articulo" class="col-12">Observaciones:</label></div>
													<div class="col-md-10">
														<input type="text" class="form-control mayusc" name="obsIng" id="obsIng" autocomplete="off" placeholder="Observaciones" />
													</div>
												</div>
												<div class="row my-4">
													<div class="col-md-2 centraVert"><label for="articulo" class="col-12">Producto:</label></div>
													<div class="col-md-4">
														<select class="form-control col-12 articuloIng" name="articuloIng" id="articuloIng">
															<option value="">--Seleccione--</option>
														<?
														foreach($articulos as $row):	?>
															<option value="<?=$row->idarticulo;?>"><?=$row->articulo;?></option>
														<?	endforeach;	?>
														</select>
													</div>
													<div class="col-md-3 centraVert"><label for="cantidadIng" class="col-md-9 pull-right">Cantidad KG:</label></div>
													<div class="col-md-3">
														<input type="text" class="form-control cantidadIng moneda" name="cantidadIng" id="cantidadIng" autocomplete="off" placeholder="0.00" />
													</div>
												</div>
												<div class="row my-4">
													<div class="col-md-2 centraVert pr-0"><label for="articulo" class="col-12">Humedad (%):</label></div>
													<div class="col-md-4">
														<input type="text" class="form-control col-md-9 moneda" name="humedadIng" id="humedadIng" autocomplete="off" placeholder="0.00" />
													</div>
													<div class="col-md-3 centraVert"><label for="articulo" class="col-12">Calidad RDTO(%):</label></div>
													<div class="col-md-3">
														<input type="text" class="form-control moneda" name="calidadIng" id="calidadIng" autocomplete="off" placeholder="0.00" />
													</div>
												</div>
												<div class="row my-4">
													<div class="col-md-2 centraVert pr-0"><label for="tasaIng" class="col-12">Tasa (Pts.):</label></div>
													<div class="col-md-4">
														<input type="text" class="form-control col-md-9 moneda" name="tasaIng" id="tasaIng" autocomplete="off" placeholder="0.00" />
													</div>
													<!--<div class="col-md-3 centraVert"><label for="articulo" class="col-12">Calidad RDTO(%):</label></div>
													<div class="col-md-3">
														<input type="text" class="form-control moneda" name="calidadIng" id="calidadIng" autocomplete="off" placeholder="0.00" />
													</div>-->
												</div>
												
												<div class="row my-4">
													<div class="col-md-2 centraVert">
														<div class="custom-control custom-switch col-12 pr-0">
															<input type="checkbox" class="custom-control-input" name="valorizaIng" id="valorizaIng">
															<label class="custom-control-label" for="valorizaIng">Valorizar</label>
														</div>
														<!--<div class="col-12 pr-0">
															<label for="valorizaIng" class="my-0">Valorizar&nbsp;&nbsp;&nbsp;</label>
															<input type="checkbox" name="valorizaIng" id="valorizaIng" />
														</div>-->
													</div>
													<div class="col-md-2 centraVert"><label for="cantidadValoriz" class="col-12">Cantidad:</label></div>
													<div class="col-md-3">
														<input type="text" class="form-control col-12 moneda" name="cantidadValoriz" id="cantidadValoriz" autocomplete="off" placeholder="0.00" disabled />
													</div>
													<div class="col-md-2 centraVert"><label for="costoValoriz" class="col-12">Costo:</label></div>
													<div class="col-md-3">
														<input type="text" class="form-control col-12 moneda" name="costoValoriz" id="costoValoriz" placeholder="0.00" autocomplete="off" />
													</div>
												</div>
												<div class="row mt-2">
													<div class="col-md-2">
														<input type="submit" class="btn btn-narsa d-flex ml-auto col-12 justify-content-center" id="btnAgregarIngDetalle" value="Agregar"/>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="container-fluid">
									<div class="row mx-2">
										<div class="col-12" style="overflow-x:auto">
										<!--<div class="table-responsive">
											<table id="tablaIngDetalle" class="table table-striped dt-responsive table-bordered display nowrap table-hover mb-0 mx-auto px-0 col-md-11"></table>
										</div>-->
											<table id="tablaIngDetalle" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
										</div>
									</div>
								</div>
								<!--<div class="clearfix"></div>-->
								<div class="modal-body">
									<form id="formPagoIngreso">
										<div class="row">
											<div class="col-md-11 mx-auto">
												<div class="row my-4">
													<div class="col-md-3 centraVert">
														<div class="custom-control custom-switch col-12 pr-0">
															<input type="checkbox" class="custom-control-input" name="chkPagoValoriz" id="chkPagoValoriz" disabled >
															<label class="custom-control-label" for="chkPagoValoriz">Generar Pago</label>
														</div>
														<!--<div class="col-12">
															<label for="chkPagoValoriz" class="my-0">Generar Pago&nbsp;&nbsp;&nbsp;</label>
															<input type="checkbox" name="chkPagoValoriz" id="chkPagoValoriz" value="1" disabled />
														</div>-->
													</div>
													<div class="col-md-2 centraVert"><label for="pagoValoriz" class="col-12">Cantidad:</label></div>
													<div class="col-md-4">
														<select class="form-control col-md-12 pagoValoriz" name="pagoValoriz" id="pagoValoriz" disabled >
															<option value="2">Pago Total</option>
															<option value="8">Pago Parcial</option>
														</select>
													</div>
												</div>
												<div class="row my-4">
													<div class="col-md-3">
														<label for="saldo" class="col-12 d-none saldo">Saldo en Caja:</label>
														<input type="text" class="form-control form-control-sm col-md-9 text-right d-none saldo" 
															value="<?=number_format($saldo,2,'.',',')?>" id="saldo" readonly />
													</div>
													<div class="col-md-2 centraVert"><label for="subTotalPago" class="col-12">Sub-Total:</label></div>
													<div class="col-md-2">
														<input type="text" class="form-control col-12" name="subTotalPago" id="subTotalPago"
															placeholder="0.00" autocomplete="off" readonly />
													</div>
													<div class="col-md-2 centraVert"><label for="desembolso" class="col-12">Desembolso:</label></div>
													<div class="col-md-3">
														<input type="text" class="form-control col-12 moneda" name="desembolso" id="desembolso" 
															placeholder="0.00" autocomplete="off" disabled />
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<div class="row">
										<div class="col-md-12">
											<button class="btn btn-narsa mr-3" data-dismiss="modal" id="cancelIng">Cancelar Operaci&oacute;n</button>
											<button class="btn btn-narsa" id="generarIng">Generar Ingreso</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="modal fade" id="modalValorizaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Valorizaci&oacute;n de Productos</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body" style="overflow: hidden;">
									<form method="post" id="form_valorizaciones">
										<div class="row mt-2 mb-4">
											<div class="col-md-11 mx-auto">
												<div class="row">
													<div class="col-md-2"><label for="proveedorVal" class="col-12">Proveedor:</label></div>
													<div class="col-md-4 pb-3">
														<input type="text" class="form-control col-12" name="proveedorVal" value="<?=ucwords(strtolower($this->input->get('name')))?>" readonly />
													</div>
													<div class="col-md-2 align-items-center"><label for="sucursalVal" class="col-12">Sucursal:</label></div>
													<div class="col-md-4">
														<select class="form-control col-12 sucursalVal" name="sucursalVal" id="sucursalVal">
													<?
														foreach($usuario->sucursales as $row):	?>
															<option value="<?=$row->idsucursal;?>"><?=$row->sucursal;?></option>
													<?	endforeach;	?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="container-fluid">
									<div class="row mx-2">
										<div class="col-12" style="overflow-x:auto">
											<!--<table id="tablaValDetalle" class="table table-striped dt-responsive table-bordered display nowrap table-hover mb-0 mx-auto px-0 col-11" style="100%"></table>
										</div>-->
											<table id="tablaValDetalle" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
										</div>
									</div>
								</div>
								<!--<div class="clearfix"></div>-->
								<div class="modal-footer">
									<div class="row">
										<div class="col-md-12">
											<button class="btn btn-narsa mr-3" data-dismiss="modal" id="cancelVal">Cancelar</button>
											<button class="btn btn-narsa" id="guardaVal">Valorizar Producto</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Modal de Edicion -->
					<div class="modal fade" id="modalEditIngresos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Edici&oacute;n de Productos</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body" style="overflow: hidden;">
									<form method="post" id="form_editar_ingresos">
										<div class="row mt-2 mb-4">
											<div class="col-md-11 mx-auto">
												<div class="row">
													<div class="col-md-2"><label for="proveedorIng" class="col-12">Proveedor:</label></div>
													<div class="col-md-4 pb-3">
														<input type="text" class="form-control col-12" value="<?=ucwords(strtolower($this->input->get('name')))?>"
															name="proveedorIng" id="proveedorIng" readonly />
													</div>
													<div class="col-md-2 align-items-center"><label for="sucursalIng" class="col-12">Sucursal:</label></div>
													<div class="col-md-4">
														<select class="form-control col-12 sucursalIng" name="sucursalIng" id="sucursalIng">
													<?
														foreach($usuario->sucursales as $row):	?>
															<option value="<?=$row->idsucursal;?>"><?=$row->sucursal;?></option>
													<?	endforeach;	?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="row my-4">
											<div class="col-md-11 mx-auto">
												<div class="row">
													<div class="col-md-2"><label for="articulo" class="col-12">Producto:</label></div>
													<div class="col-md-3">
														<select class="form-control col-12 articuloIng" name="articuloIng" id="articuloIng">
															<option value="">--Seleccione--</option>
														<?
														foreach($articulos as $row):	?>
															<option value="<?=$row->idarticulo;?>"><?=$row->articulo;?></option>
														<?	endforeach;	?>
														</select>
													</div>
													<div class="col-md-2"><label for="cantidadIng" class="col-12">Cantidad KG:</label></div>
													<div class="col-md-3">
														<input type="text" class="form-control col-12 cantidadIng" name="cantidadIng" id="cantidadIng" autocomplete="off" />
														<label id="errCant" class="form_error" for="cantidadIng"></label>
													</div>
													<div class="col-md-2">
														<input type="submit" class="btn btn-narsa d-flex ml-auto col-lg-12 justify-content-center" id="btnEditarAgGuia" value="Agregar"/>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="container-fluid my-2">
									<div class="row mx-2">
										<div class="col-12" style="overflow-x:auto">
											<!--<table id="tablaIngEditarDetalle" class="table table-striped dt-responsive table-bordered display nowrap table-hover mb-0 mx-auto px-0 col-md-9"></table>-->
											<table id="tablaIngEditarDetalle" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
										</div>
									</div>
								</div>
								<!--<div class="clearfix"></div>-->
								<div class="modal-footer">
									<div class="row">
										<div class="col-md-12">
											<button class="btn btn-narsa mr-3" data-dismiss="modal" id="cancelIng">Cancelar Operaci&oacute;n</button>
											<button class="btn btn-narsa" id="editarIng">Generar Ingreso</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>