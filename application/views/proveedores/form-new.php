					<div class="col-12 iq-card my-3">
					<? if($this->uri->segment(1) === 'proveedores'){
							$action = base_url().'proveedores/registrar';
							$btncancelar = 'btn-cancelar';
					?>
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4>Registro de Proveedor</h4></div><div class="ml-5 h4 text-danger mr-auto fallecido"></div>
						</div>
					<?}else{
						$action = '';
						$btncancelar = 'cancel';
					}?>
						<div class="iq-card-body">
						<form method="post" id="form_proveedor" action="<?=$action?>" class="needs-validation form-horizontal" novalidate="">
							<input type="hidden" name="tiporegistro" value="registrar" /><input type="hidden" id="tabla" value="proveedor" />
							<div class="form-row">
								<div class="col-12 my-1">
									<div class="row">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="tipodoc">Tipo de Documento:</label>
										<div class="col-md-6 col-lg-3">
											<div class="row">
												<select class="form-control tipodoc" name="tipodoc" id="tipodoc" required="">
												<?
														foreach($tipodoc as $row):	?>
															<option value="<?=$row->idtipodocumento;?>"><?=$row->tipo_documento;?></option>
												<?		endforeach;	?>
												</select>
												<div class="invalid-feedback">Debe elegir un tipo de documento</div>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="doc">N&uacute;mero de Documento:</label>
										<div class="col-md-4 col-lg-2">
											<div class="row">
												<input type="text" class="form-control doc borra num numcurl" maxlength="8" minlength="8" name="doc" id="doc" autocomplete="off"
													placeholder="Nro. Documento" required="" />
												<div class="invalid-feedback" id="error-doc">Documento requerido</div>
											</div>
										</div>
										<div class="col-md-2 col-lg-1 px-0 pl-md-3 pl-lg-4 mt-3 mt-lg-0 align-self-center">
											<button type="button" class="btn btn-info btn-small btn_curl col-12 align-self-center"><i class="fa fa-search" aria-hidden="true"></i></button>
										</div>
										<!--<label class="form_error error_curl col-md-4 my-0"></label>-->
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="ruc">RUC:</label>
										<div class="col-md-4 col-lg-2">
											<div class="row">
												<input type="text" class="form-control ruc borra num" name="ruc" id="ruc" placeholder="RUC" value="" minlength="11" 
													maxlength="11" required=""/>
												<div class="invalid-feedback" id="error-doc">Documento requerido</div>
											</div>
										</div>
										<div class="col-md-2 col-lg-1 px-0 pl-md-3 pl-lg-4 mt-3 mt-lg-0 align-self-center">
											<button type="button" class="btn btn-info btn-small col-12 align-self-center btn_ruc" id="busca_ruc"><i class="fa fa-search" aria-hidden="true"></i></button>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="nombres">Raz&oacute;n Social:</label>
										<div class="col-md-6 col-lg-4">
											<div class="row">
												<input type="text" class="form-control borra nombres mayusc" name="nombres" id="nombres" placeholder="Raz&oacute;n Social" value="" required="" readonly />
												<div class="invalid-feedback" id="error-razon">Debe indicar una Raz&oacute;n social</div>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="direccion">Domicilio:</label>
										<div class="col-md-6 col-lg-4">
											<div class="row">
												<input type="text" class="form-control borra direccion mayusc" name="direccion" id="direccion" placeholder="Domicilio" value="" required="" />
												<div class="invalid-feedback">Campo requerido</div>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="celular">Celular:</label>
										<input type="text" class="form-control col-md-6 col-lg-4 borra celular num" name="celular" id="celular" placeholder="N&uacute;mero Celular" value="" />
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="email">Email:</label>
										<div class="col-md-6 col-lg-4">
											<div class="row">
												<input type="email" class="form-control borra correo" name="email" id="email" placeholder="Correo Electr&oacute;nico" value="" />
												<div class="invalid-feedback">La direcci&oacute;n de email debe contener 1 @ y servidor de correo</div>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="dep">Departamento:</label>
										<div class="col-md-6 col-lg-3">
											<div class="row">
												<select class="form-control dep" name="dep" id="dep" required="" >
													<option value="">-- Seleccione --</option>
												<?
														foreach($dep as $row):	?>
															<option value="<?=$row->cod_dep;?>"><?=$row->departamento;?></option>
												<?		endforeach;	?>
												</select>
												<div class="invalid-feedback">Debe elegir un Departamento</div>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="pro">Provincia:</label>
										<div class="col-md-6 col-lg-3">
											<div class="row">
												<select class="form-control pro" name="pro" id="pro" required="" >
													<option value="">-- Seleccione --</option>
												</select>
												<div class="invalid-feedback">Debe elegir una Provincia</div>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="dis">Distrito:</label>
										<div class="col-md-6 col-lg-3">
											<div class="row">
												<select class="form-control dis" name="dis" id="dis" required="">
													<option value="">-- Seleccione --</option>
												</select>
												<div class="invalid-feedback">Debe elegir un Distrito</div>
											</div>
										</div>
									</div>
									<div class="row ajaxMap mt-3 d-none">
										<div class="col-12 px-0">
											<!--<div class="pac-card" id="pac-card">
											  <div id="pac-container" class="place-map">
												<input id="pac-input" type="text" placeholder="Enter a location" />
											  </div>
											</div>
											<div id="infowindow-content">
											  <div id="place-name" class="title"></div>
											  <div id="place-address"></div>
											</div>-->
											<input type="hidden" name="lat" id="lat" /><input type="hidden" name="lng" id="lng" />
											<div id="map" style="min-height:350px;width:100%;margin:auto"></div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="zona">Zona:</label>
										<div class="col-md-6 col-lg-4">
											<div class="row">
												<input type="text" class="form-control borra zona mayusc" name="zona" id="zona" placeholder="Zona" value="" required="" />
												<label class="invalid-feedback">Campo requerido</label>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="finca">Finca:</label>
										<div class="col-md-6 col-lg-4">
											<div class="row">
												<input type="text" class="form-control borra finca mayusc" name="finca" id="finca" placeholder="Finca" value="" required="" />
												<label class="invalid-feedback">Campo requerido</label>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="altitud">Altitud:</label>
										<div class="col-md-6 col-lg-4">
											<div class="row">
												<input type="text" class="form-control borra altitud num" name="altitud" id="altitud" placeholder="Altitud (msnm)" value="" required="" />
												<label class="invalid-feedback">Campo requerido</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="container-fluid row"><hr class="col-sm-12"></div>
							<div class="col-12 mx-auto pb-2">
								<button type="submit" class="btn btn-narsa ml-1 mr-4" id="btnEnviar">Guardar Registro</button>
								<button type="reset" class="btn btn-narsa <?=$btncancelar?>">Cancelar</button>
							</div>
						</form>
						</div>
					</div>