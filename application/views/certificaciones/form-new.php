					<? $usuario = json_decode($this->session->userdata('user')); ?>
					
					<div class="col-12 iq-card my-3">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4>Registro Certificado</h4></div>
						</div>
						<div class="iq-card-body"><!--Anular-->
							<form method="post" id="form_certificado" action="<?=base_url()?>certificaciones/registrar" class="needs-validation" novalidate="">
								<input type="hidden" name="tiporegistro" value="registrar" />
								<input type="hidden" name="idproveedor" id="idproveedor" />
								<div class="form-row">
									<div class="col-12 my-1">
										<div class="row">
											<label class="control-label col-sm-6 col-lg-2 align-self-center mb-0" for="productor">&nbsp;&nbsp;Productor:</label>
											<div class="col-sm-6 col-lg-3">
												<div class="row">
													<input type="text" class="form-control productor col-8" id="productor" name="productor" readonly required="">
													<a type="button" class="btn btn-small btn-narsa align-self-center text-small ml-1 text-white" data-toggle="modal" 
															data-target="#modalProveedores" id="buscar">Buscar</a>
												</div>
											</div>
											<label class="control-label col-sm-6 col-lg-2 align-self-center mb-0 mt-sm-3 mt-lg-0 ml-lg-3" for="sucursalCert">&nbsp;&nbsp;Sucursal:</label>
											<div class="col-sm-6 col-lg-3 mt-sm-3 mt-lg-0">
												<div class="row">
													<select class="form-control sucursalCert" name="sucursalCert" id="sucursalCert" required="">
													<? foreach($usuario->sucursales as $row): ?>
														<option value="<?=$row->idsucursal;?>" ><?=$row->sucursal;?></option>
													<? endforeach;	?>
													</select>
													<div class="invalid-feedback">Debe elegir una Sucursal</div>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-sm-6 col-lg-2 align-self-center mb-0" for="fecha">&nbsp;&nbsp;Fecha:</label>
											<div class="col-sm-6 col-lg-3">
												<div class="row">
													<input type="date" class="form-control fecha" value="<?=date('Y-m-d')?>" name="fecha" id="fecha" required="" />
													<div class="invalid-feedback">Debe elegir la fecha</div>
												</div>
											</div>
											<label class="control-label col-sm-6 col-lg-2 align-self-center mb-0 mt-sm-3 mt-lg-0 ml-lg-3" for="h2o">&nbsp;&nbsp;H2O verde (ISO):</label>
											<div class="col-sm-6 col-lg-3 mt-sm-3 mt-lg-0">
												<div class="row">
													<input type="text" class="form-control h2o moneda" name="h2o" id="h2o" required="" autocomplete="off" />
													<div class="invalid-feedback">Campo Requerido</div>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-sm-6 col-lg-2 align-self-center mb-0" for="altitud">&nbsp;&nbsp;Altitud:</label>
											<div class="col-sm-6 col-lg-3">
												<div class="row">
													<input type="text" class="form-control altitud num" name="altitud" id="altitud" readonly />
												</div>
											</div>
											<label class="control-label col-sm-6 col-lg-2 align-self-center mb-0 mt-sm-3 mt-lg-0 ml-lg-3" for="proceso">&nbsp;&nbsp;Proceso:</label>
											<div class="col-sm-6 col-lg-3 mt-sm-3 mt-lg-0">
												<div class="row">
													<select class="form-control proceso" name="proceso" id="proceso" required="">
													<? foreach($proceso as $row): ?>
														<option value="<?=$row->idproceso;?>" ><?=$row->proceso;?></option>
													<? endforeach;	?>
													</select>
													<div class="invalid-feedback">Debe elegir un Proceso</div>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-sm-6 col-lg-2 align-self-center mb-0" for="densidad">&nbsp;&nbsp;Densidad:</label>
											<div class="col-sm-6 col-lg-3">
												<div class="row">
													<input type="text" class="form-control densidad moneda" name="densidad" id="densidad" autocomplete="off" />
												</div>
											</div>
											<label class="control-label col-sm-6 col-lg-2 align-self-center mb-0 mt-sm-3 mt-lg-0 ml-lg-3" for="finca">&nbsp;&nbsp;Finca:</label>
											<div class="col-sm-6 col-lg-3 mt-sm-3 mt-lg-0">
												<div class="row">
													<input type="text" class="form-control mayusc" name="finca" id="finca" readonly />
												</div>
											</div>
											<div class="col-sm-6 col-lg-3 mt-sm-3 mt-lg-0 d-none">
												<div class="row">
													<select class="form-control variedad" name="variedad" id="variedad">
														<option value="1" >BLEND</option>
													</select>
												</div>
											</div>
										</div>
										<!--<div class="row mt-3">
											<label class="control-label col-sm-6 col-lg-2 align-self-center mb-0" for="finca">&nbsp;&nbsp;Finca:</label>
											<div class="col-sm-6 col-lg-3">
												<div class="row">
													<input type="text" class="form-control mayusc" name="finca" id="finca" readonly />
												</div>
											</div>
										</div>-->
										<div class="row mt-3">
											<label class="control-label col-sm-6 col-lg-2 align-self-center mb-0" for="obs">&nbsp;&nbsp;Observaciones:</label>
											<div class="col-sm-6 col-lg-8">
												<div class="row">
													<input type="text" class="form-control mayusc" name="obs" id="obs" placeholder="Observaciones" autocomplete="off" />
												</div>
											</div>
										</div>
										<hr>
										<div class="row my-3">
											<div class="col-sm-4 col-md-3 col-lg-2">
												<div class="custom-control custom-switch pr-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checkbourbon" id="checkbourbon" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checkbourbon">Bourbon</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-3 col-lg-2">
												<div class="custom-control custom-switch pr-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checktipica" id="checktipica" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checktipica">Tipica</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-3 col-lg-2">
												<div class="custom-control custom-switch pr-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checkcaturra" id="checkcaturra" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checkcaturra">Caturra</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-3 col-lg-2">
												<div class="custom-control custom-switch pr-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checkpache" id="checkpache" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checkpache">Pache</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-3 col-lg-2">
												<div class="custom-control custom-switch pr-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checkcatimor" id="checkcatimor" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checkcatimor">Catimor</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-3 col-lg-2">
												<div class="custom-control custom-switch pr-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checkcatuai" id="checkcatuai" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checkcatuai">Catuai</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-3 col-lg-2 my-lg-4">
												<div class="custom-control custom-switch pr-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checkpacamara" id="checkpacamara" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checkpacamara">Pacamara</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-3 col-lg-2 my-lg-4">
												<div class="custom-control custom-switch pr-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checkgesha" id="checkgesha" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checkgesha">Gesha</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-3 col-lg-2 my-lg-4">
												<div class="custom-control custom-switch pr-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checkmarcellesa" id="checkmarcellesa" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checkmarcellesa">Marcellesa</label>
												</div>
											</div>
											<div class="col-sm-6 col-md-3 col-lg-2 pr-lg-0 my-lg-4">
												<div class="custom-control custom-switch px-lg-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checkcolombia" id="checkcolombia" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checkcolombia">Gran Colombia</label>
												</div>
											</div>
											<div class="col-sm-6 col-md-3 col-lg-2 my-lg-4">
												<div class="custom-control custom-switch pr-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checkcosta" id="checkcosta" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checkcosta">Costa Rica</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-3 col-lg-2 my-lg-4">
												<div class="custom-control custom-switch pr-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checktupo" id="checktupo" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checktupo">Tupo</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-3 col-lg-2">
												<div class="custom-control custom-switch pr-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checklimani" id="checklimani" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checklimani">Limani</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-3 col-lg-2">
												<div class="custom-control custom-switch px-lg-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checkmaragogipe" id="checkmaragogipe" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checkmaragogipe">Maragogipe</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-3 col-lg-2">
												<div class="custom-control custom-switch pr-0 d-inline ml-2">
													<input type="checkbox" class="custom-control-input" name="checkotros" id="checkotros" />
													<label class="custom-control-label mt-3 mt-lg-0" for="checkotros">Otros</label>
												</div>
											</div>
											<div class="col-sm-8 col-md-3 col-lg-6">
												<input type="text" name="detalle_otros" id="detalle_otros" class="form-control mayusc" autocomplete="off" required="" disabled />
												<div class="invalid-feedback">Debe indicar el detalle</div>
											</div>
										</div>
									</div>
								</div>
								<div class="container-fluid row"><hr class="col-sm-12"></div>
								<div class="col-12 mx-auto pb-2">
									<button type="submit" class="btn btn-narsa ml-1 mr-4" id="btnRegistrar">Guardar Registro</button>
									<button type="reset" class="btn btn-narsa btn-cancelar">Cancelar</button>
								</div>
							</form>
						</div>
					</div>
					<!-- Modal proveedores -->
					<div class="modal fade" id="modalProveedores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Elegir Productor</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<div class="container-fluid">
										<div class="row">
											<div class="col-12 mx-auto" style="overflow-x:auto">
												<table id="tablaProveedores" class="table table-striped dt-responsive table-bordered display nowrap table-hover mb-0 mx-0" style="width:100%">
													<thead><tr><th>Item</th><th>Nombre del Productor</th><th>nro doc</th><th>finca</th><th>altitud</th></tr></thead>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>