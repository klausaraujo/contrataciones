<?
	$usuario = json_decode($this->session->userdata('user'));
	$trillado = $trillado;
	$despacho = $despacho;
?>
					<div class="col-12 iq-card my-3">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4><b><?=ucwords(strtolower($proveedor->nombre))?></b> (Operaciones Tostado)</h4></div>
						</div>
						<div class="iq-card-body pb-0">
							<!--<div class="row">
								<!-- Nav pills -->
								<div class="nav nav-pills row" id="nav-tab" role="tablist">
									<a class="nav-item nav-link col-lg-3 col-12 col-md-4 text-center active" data-toggle="tab" href="#pill-trillado">Proceso de Trillado</a>
									<a class="nav-item nav-link col-lg-3 col-12 col-md-4 text-center" data-toggle="tab" href="#pill-tostado">Tostado en M&aacute;quina</a>
									<a class="nav-item nav-link col-lg-3 col-12 col-md-4 text-center" data-toggle="tab" href="#pill-despacho">Empaquetado y Despacho</a>
								</div>
							<!--</div>-->
							<!-- Tab panes -->
							<!--<div id="am-radar-chart" style="height:500px;"></div>-->
							<div class="tab-content">
								<div class="tab-pane container active" id="pill-trillado">
									<div class="col-md-12 text-center mt-2 resp" style="font-size:1.07em"></div>
									<form method="post" id="form_trillado" action="<?=base_url().$this->uri->segment(1)?>/operaciones/trillado" class="form">
										<input type="hidden" class="idproveedor" name="idproveedor" value="<?=$proveedor->idproveedor?>"/>
										<input type="hidden" name="idtostado" value="<?=$tostado->idtostado?>"/>
										<div class="form-row container-fluid mt-3">
											<div class="col-md-4">
												<div class="row">
													<label class="control-label col-md-5 align-self-center mb-0" for="cantidad">Cantidad a Trillar:</label>
													<div class="col-md-6">
														<div class="row">
															<input type="text" class="form-control form-control-sm col-md-8 moneda text-right blur"
																name="cantidad" id="cantidad" value="<?=!empty($trillado)? $trillado->cantidad: '';?>" />
															<label class="control-label align-self-center mb-0 col-md-4 text-left">Kg. </label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-row container-fluid mt-3">
											<div class="col-md-4">
												<div class="row">
													<label class="control-label col-md-5 align-self-center mb-0">Zaranda</label>
													<div class="col-md-6">
														<div class="row">
															<label class="control-label align-self-center mb-0">Malla 15-17</label>
														</div>
														<div class="row">
															<input type="text" class="form-control form-control-sm col-md-8 moneda text-right blur"
																name="malla1517" id="malla1517" value="<?=!empty($trillado)? $trillado->zaranda_15_17: '';?>" />
															<label class="control-label align-self-center mb-0 col-md-4 text-left">Kg. </label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="row">
													<label class="control-label align-self-center mb-0">Malla 13-14</label>
												</div>
												<div class="row">
													<input type="text" class="form-control form-control-sm col-md-8 moneda text-right blur"
														name="malla1314" id="malla1314" value="<?=!empty($trillado)? $trillado->zaranda_13_14: '';?>" />
													<label class="control-label align-self-center mb-0 col-md-4 text-left">Kg. </label>
												</div>
											</div>
											<div class="col-md-2">
												<div class="row">
													<label class="control-label align-self-center mb-0">Descarte</label>
												</div>
												<div class="row">
													<input type="text" class="form-control form-control-sm col-md-8 moneda text-right blur"
														name="descarte" id="descarte" value="<?=!empty($trillado)? $trillado->zaranda_descarte: '';?>" />
													<label class="control-label align-self-center mb-0 col-md-4 text-left">Kg. </label>
												</div>
											</div>
										</div>
										<div class="form-row container-fluid mt-3 mb-4">
											<div class="col-md-4">
												<div class="row">
													<label class="control-label col-md-5 align-self-center mb-0">Pesos </label>
													<div class="col-md-6">
														<div class="row">
															<label class="control-label align-self-center mb-0">Gra</label>
														</div>
														<div class="row">
															<input type="text" class="form-control form-control-sm col-md-8 moneda text-right blur"
																name="gra" id="gra" value="<?=!empty($trillado)? $trillado->pesos_gra: '';?>" />
															<label class="control-label align-self-center mb-0 col-md-4 text-left">Kg. </label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="row">
													<label class="control-label align-self-center mb-0">Segunda</label>
												</div>
												<div class="row">
													<input type="text" class="form-control form-control-sm col-md-8 moneda text-right blur"
														name="segunda" id="segunda" value="<?=!empty($trillado)? $trillado->pesos_segunda: '';?>" />
													<label class="control-label align-self-center mb-0 col-md-4 text-left">Kg. </label>
												</div>
											</div>
											<div class="col-md-2">
												<div class="row">
													<label class="control-label align-self-center mb-0">Cascarilla</label>
												</div>
												<div class="row">
													<input type="text" class="form-control form-control-sm col-md-8 moneda text-right blur"
														name="cascarilla" id="cascarilla" value="<?=!empty($trillado)? $trillado->pesos_cascarilla: '';?>" />
													<label class="control-label align-self-center mb-0 col-md-4 text-left">Kg. </label>
												</div>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-md-4 ml-md-auto">
												<button class="btn btn-narsa btn-operaciones" id="guardatrillado" type="submit">Guardar Operaci&oacute;n</button>
											</div>
										</div>
									</form>
								</div>
								<div class="tab-pane container fade" id="pill-tostado">
									<div class="col-md-12 text-center resp mt-2" style="font-size:1.07em"></div>
									<form id="form_optostado" class="form" action="<?=base_url().$this->uri->segment(1)?>/operaciones/tostado" method="post" >
										<input type="hidden" class="idproveedor" name="idproveedor" value="<?=$proveedor->idproveedor?>"/>
										<input type="hidden" id="idtostado" name="idtostado" value="<?=$tostado->idtostado?>"/>
										<div class="form-row container-fluid my-4 datamaquina">
											<label class="control-label align-self-center mb-0 mr-md-1 ml-md-2">M&aacute;quina:</label>
											<select class="form-control form-control-sm col-md-2" id="maquina" name="maquina">
												<option value="1">Maquina 01</option>
												<option value="2">Maquina 02</option>
											</select>
											<label class="control-label align-self-center mb-0 mr-md-1 ml-md-2">Tipo:</label>
											<select class="form-control form-control-sm col-md-2" id="tipo" name="tipo">
												<option value="1">Claro</option>
												<option value="2">Medio</option>
												<option value="3">Oscuro</option>
											</select>
											<label class="control-label align-self-center mb-0 mr-md-1 ml-md-2">Cantidad Kg.:</label>
											<input class="form-control form-control-sm col-md-1 mx-md-0 moneda" id="cantidadtostado" name="cantidadtostado" />
											<label class="control-label align-self-center mb-0 mr-md-1 ml-md-2">C&oacute;d. Tostado:</label>
											<input class="form-control form-control-sm col-md-1 mx-md-0 mayusc" id="cod" name="cod" />
											<a class="btn btn-primary ml-md-2" id="agregar">Agregar</a>
										</div>
										<hr>
										<div class="form-row container-fluid">
											<div class="col-12" style="overflow-x:auto">
												<table id="opmaquina" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
											</div>
										</div>
										<div class="form-row container-fluid my-4">
											<label class="control-label align-self-center mb-0 col-md-2">Resultado Tostado (Kg):</label>
											<input class="form-control form-control-sm col-md-1 moneda" id="kg" name="kg" />
											<label class="control-label align-self-center mb-0 col-md-2 text-md-right">Merma (Kg):</label>
											<input class="form-control form-control-sm col-md-1 moneda" id="merma" name="merma" />
										</div>
										<div class="row my-4">
											<div class="col-md-3 ml-md-auto">
												<button class="btn btn-narsa btn-operaciones col-md-11" id="guardatostado" type="submit">Guardar Operaci&oacute;n</button>
											</div>
										</div>
									</form>
								</div>
								<div class="tab-pane container fade" id="pill-despacho">
									<div class="col-12 text-center mt-2 resp" style="font-size:1.07em"></div>
									<form method="post" id="form_despacho" action="<?=base_url().$this->uri->segment(1)?>/operaciones/despacho" class="form">
										<input type="hidden" class="idproveedor" name="idproveedor" value="<?=$proveedor->idproveedor?>"/>
										<input type="hidden" name="idtostado" value="<?=$tostado->idtostado?>"/>
										<div class="row mt-3">Empaquetado</div>
										<div class="form-row container-fluid mt-1">
											<div class="col-md-4">
												<div class="row">
													<label class="control-label col-md-5 align-self-center mb-0">Nro. de Bolsas:</label>
													<div class="col-md-6">
														<div class="row">
															<label class="control-label align-self-center mb-0">250g</label>
														</div>
														<div class="row">
															<input type="text" class="form-control form-control-sm col-md-8 moneda text-right blur"
																name="250g" id="250g" required="" value="<?=!empty($despacho)? $despacho->empaque_250: '';?>" />
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="row">
													<label class="control-label align-self-center mb-0">500g</label>
												</div>
												<div class="row">
													<input type="text" class="form-control form-control-sm col-md-8 moneda text-right blur"
														name="500g" id="500g" required="" value="<?=!empty($despacho)? $despacho->empaque_500: '';?>" />
												</div>
											</div>
											<div class="col-md-2">
												<div class="row">
													<label class="control-label align-self-center mb-0">1000g</label>
												</div>
												<div class="row">
													<input type="text" class="form-control form-control-sm col-md-8 moneda text-right blur"
														name="1000g" id="1000g" required="" value="<?=!empty($despacho)? $despacho->empaque_1000: '';?>" />
												</div>
											</div>
										</div>
										<div class="row mt-3">Despacho</div>
										<div class="row">
											<div class="col-md-4 mt-md-2">
												<div class="custom-control custom-radio custom-radio-color-checked custom-control-inline">
													<input type="radio" id="almnarsa" name="almnarsa" class="custom-control-input bg-primary opcion" value="narsa" required="" />
													<label class="custom-control-label" for="almnarsa">Almac&eacute;n Narsa</label>
												</div>
												<div class="custom-control custom-radio custom-radio-color-checked custom-control-inline">
													<input type="radio" id="courier" name="almnarsa" class="custom-control-input bg-success opcion" value="courier" required="" >
													<label class="custom-control-label" for="courier">V&iacute;a Courier</label>
												</div>
											</div>
										</div>
										<div class="form-row">
											<input type="hidden" id="tabla" value="proveedor" />
											<div class="col-12 my-3">
												<div class="row">
													<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="tipodoc">Tipo de Documento:</label>
													<div class="col-md-6 col-lg-3">
														<div class="row">
															<select class="form-control form-control-sm tipodoc" name="tipodoc" id="tipodoc" required="">
																<option value="1">D.N.I.</option>
																<option value="2">CARNET ETX.</option>
																<option value="3">NO ESPECIFICO</option>
															</select>
															<div class="invalid-feedback">Debe elegir un tipo de documento</div>
														</div>
													</div>
												</div>
												<div class="row mt-3">
													<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="doc">N&uacute;mero de Documento:</label>
													<div class="col-md-4 col-lg-2">
														<div class="row">
															<input type="text" class="form-control form-control-sm doc borra num numcurl" maxlength="8" minlength="8" name="doc" id="doc" autocomplete="off"
																placeholder="Nro. Documento" required="" />
															<div class="invalid-feedback" id="error-doc">Documento requerido</div>
														</div>
													</div>
													<div class="col-md-2 col-lg-1 px-0 pl-md-3 pl-lg-4 mt-3 mt-lg-0 align-self-center">
														<button type="button" class="btn btn-primary btn-small btn_curl col-12 align-self-center"><i class="fa fa-search" aria-hidden="true"></i></button>
													</div>
													<!--<label class="form_error error_curl col-md-4 my-0"></label>-->
												</div>
												<div class="row mt-3">
													<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="ruc">RUC:</label>
													<div class="col-md-4 col-lg-2">
														<div class="row">
															<input type="text" class="form-control form-control-sm ruc borra num" name="ruc" id="ruc" placeholder="RUC" value="" minlength="11" 
																maxlength="11" required=""/>
															<div class="invalid-feedback" id="error-doc">Documento requerido</div>
														</div>
													</div>
													<div class="col-md-2 col-lg-1 px-0 pl-md-3 pl-lg-4 mt-3 mt-lg-0 align-self-center">
														<button type="button" class="btn btn-primary btn-small col-12 align-self-center btn_ruc" id="busca_ruc"><i class="fa fa-search" aria-hidden="true"></i></button>
													</div>
												</div>
												<div class="row mt-3">
													<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="nombres">Raz&oacute;n Social:</label>
													<div class="col-md-6 col-lg-4">
														<div class="row">
															<input type="text" class="form-control form-control-sm borra nombres mayusc" name="nombres" id="nombres" placeholder="Raz&oacute;n Social" value="" required="" readonly />
															<div class="invalid-feedback" id="error-razon">Debe indicar una Raz&oacute;n social</div>
														</div>
													</div>
												</div>
												<div class="row mt-3">
													<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="direccion">Domicilio:</label>
													<div class="col-md-6 col-lg-4">
														<div class="row">
															<input type="text" class="form-control form-control-sm borra direccion mayusc" name="direccion" id="direccion" placeholder="Domicilio" value="" required="" />
															<div class="invalid-feedback">Campo requerido</div>
														</div>
													</div>
												</div>
												<div class="row mt-3">
													<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="zona">Zona:</label>
													<div class="col-md-6 col-lg-4">
														<div class="row">
															<input type="text" class="form-control form-control-sm borra zona mayusc" name="zona" id="zona" placeholder="Zona" />
															<label class="invalid-feedback">Campo requerido</label>
														</div>
													</div>
												</div>
												<div class="row mt-3">
													<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="tcajas">Nro. Total de Cajas:</label>
													<div class="col-md-3 col-lg-1">
														<div class="row">
															<input type="text" class="form-control form-control-sm borra tcajas mayusc" name="tcajas" id="tcajas" />
														</div>
													</div>
													<div class="col-md-3 col-lg-3">
														<div class="row">
															<label class="control-label col-md-6 col-lg-6 align-self-center mb-0" for="tcajas">Agencia:</label>
															<input type="text" class="form-control form-control-sm col-md-6 borra tcajas mayusc" name="tcajas" id="tcajas" />
														</div>
													</div>
												</div>
												<div class="row mt-3">
													<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="cdestino">Ciudad de Destino:</label>
													<div class="col-md-6 col-lg-4">
														<div class="row">
															<input type="text" class="form-control form-control-sm borra cdestino mayusc" name="cdestino" id="cdestino" placeholder="Ciudad de Destino" value="" required="" />
															<label class="invalid-feedback">Campo requerido</label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-md-4 ml-md-auto">
												<button class="btn btn-narsa btn-operaciones" id="guardadespacho" type="submit">Guardar Operaci&oacute;n</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<hr class="mt-0">
						<div class="iq-card-footer mb-3">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-primary btn-cancelar text-white ml-md-3">Volver</button>
								</div>
							</div>
						</div>
					</div>