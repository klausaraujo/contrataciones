					<div class="col-12 iq-card my-3">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4>Editar Proveedor</h4></div>
						</div>
						<div class="iq-card-body">
						<form method="post" id="form_proveedor" action="<?=base_url()?>proveedores/registrar" class="needs-validation form-horizontal" novalidate="">
							<input type="hidden" name="tiporegistro" value="editar" />
							<input type="hidden" name="idproveedor" value="<?=$proveedor->idproveedor;?>" />
							<div class="form-row">
								<div class="col-sm-12 my-1">
									<div class="row">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="tipodoc">Tipo de Documento:</label>
										<div class="col-md-6 col-lg-3">
											<div class="row">
												<select class="form-control tipodoc" name="tipodoc" id="tipodoc" disabled >
												<?
														foreach($tipodoc as $row):	?>
															<option value="<?=$row->idtipodocumento;?>" <?=($row->idtipodocumento === $proveedor->idtipodocumento)?'selected':'';?>>
																<?=$row->tipo_documento;?></option>
												<?		endforeach;	?>
												</select>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="doc">N&uacute;mero de Documento:</label>
										<div class="col-md-4 col-lg-2">
											<div class="row">
												<input type="text" class="form-control doc" name="doc" id="doc"
													autocomplete="off" value="<?=$proveedor->numero_documento;?>" disabled />
											</div>
										<!--<button type="button" class="btn btn-info btn_curl"><i class="fa fa-search" aria-hidden="true"></i></button>-->
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="ruc">RUC:</label>
										<input type="text" class="form-control col-md-6 col-lg-4 ruc num" name="ruc" id="ruc" placeholder="RUC" value="<?=$proveedor->RUC;?>" minlength="11" /> 
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="nombres">Raz&oacute;n Social:</label>
										<div class="col-md-6 col-lg-4">
											<div class="row">
												<input type="text" class="form-control nombres" name="nombres" id="nombres" placeholder="Raz&oacute;n Social"
													value="<?=$proveedor->nombre;?>" disabled />
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="direccion">Domicilio:</label>
										<div class="col-md-6 col-lg-4">
											<div class="row">
												<input type="text" class="form-control direccion mayusc" name="direccion" id="direccion" placeholder="Domicilio" 
													value="<?=$proveedor->domicilio;?>" />
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="celular">Celular:</label>
										<input type="text" class="form-control col-md-6 col-lg-4 celular num" name="celular" id="celular" placeholder="N&uacute;mero Celular" 
											value="<?=$proveedor->celular;?>" />
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="email">Email:</label>
										<div class="col-md-6 col-lg-4">
											<div class="row">
												<input type="email" class="form-control correo" name="email" id="email" placeholder="Correo Electr&oacute;nico"
													value="<?=$proveedor->correo;?>"/>
												<div class="invalid-feedback">La direcci&oacute;n de email debe contener 1 @ y servidor de correo</div>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="dep">Departamento:</label>
										<div class="col-md-6 col-lg-3">
											<div class="row">
												<select class="form-control dep" name="dep" id="dep" required="">
												<?
														foreach($dep as $row):	?>
															<option value="<?=$row->cod_dep;?>" <?=($row->cod_dep === substr($proveedor->ubigeo,0,2)? 'selected' : '')?> >
																<?=$row->departamento;?>
															</option>
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
												<select class="form-control pro" name="pro" id="pro" required="">
													<?
														foreach($pro as $row):	?>
															<option value="<?=$row->cod_pro;?>" <?=($row->cod_pro === substr($proveedor->ubigeo,2,2)? 'selected' : '')?> >
																<?=$row->provincia;?>
															</option>
													<?		endforeach;	?>
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
													<?
														foreach($dis as $row):	?>
															<option value="<?=$row->cod_dis;?>" <?=($row->cod_dis === substr($proveedor->ubigeo,4,2)? 'selected' : '')?> >
																<?=$row->distrito;?>
															</option>
													<?		endforeach;	?>
												</select>
												<div class="invalid-feedback">Debe elegir un Distrito</div>
											</div>
										</div>
									</div>
									<div class="row ajaxMap mt-3">
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
												<input type="text" class="form-control zona mayusc" name="zona" id="zona" placeholder="Zona" value="<?=$proveedor->zona;?>" required="" />
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="finca">Finca:</label>
										<div class="col-md-6 col-lg-4">
											<div class="row">
												<input type="text" class="form-control borra finca mayusc" name="finca" id="finca" placeholder="Finca" value="<?=$proveedor->finca;?>"
													required="" />
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="altitud">Altitud:</label>
										<div class="col-md-6 col-lg-4">
											<div class="row">
												<input type="text" class="form-control borra altitud mayusc" name="altitud" id="altitud" placeholder="Altitud (msnm)"
													value="<?=$proveedor->altitud;?>" required="" />
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="container-fluid row"><hr class="col-sm-12"></div>
							<div class="col-12 mx-auto pb-2">
								<button type="submit" class="btn btn-narsa ml-1 mr-4" id="btnEnviar">Editar Registro</button>
								<button type="reset" class="btn btn-narsa btn-cancelar">Cancelar</button>
							</div>
						</form>
						</div>
					</div>
			