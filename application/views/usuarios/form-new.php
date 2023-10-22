					<div class="col-12 iq-card my-3">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4>Registro de Usuarios</h4></div><div class="ml-3 h4 text-danger fallecido"></div>
						</div>
						<div class="iq-card-body">
							<form method="post" id="form_usuarios" action="<?=base_url()?>usuarios/registrar" class="needs-validation form-horizontal" novalidate="">
								<input type="hidden" name="tiporegistro" value="registrar" /><input type="hidden" id="tabla" value="usuarios" />
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
											<!--<div class="col-md-2 col-lg-1 px-0 pl-md-3 pl-lg-4 mt-3 mt-lg-0 align-self-center">
												<button type="button" class="btn btn-info btn-small btn_curl col-12"><i class="fa fa-search" aria-hidden="true"></i></button>
											</div>
											<!--<label class="form_error error_curl col-md-4 my-0"></label>-->
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="apellidos">Apellidos:</label>
											<div class="col-md-6 col-lg-4">
												<div class="row">
													<input type="text" class="form-control borra apellidos" name="apellidos" id="apellidos" placeholder="Apellidos" required="" />
													<div class="invalid-feedback">Campo requerido</div>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="nombres">Nombres:</label>
											<div class="col-md-6 col-lg-4">
												<div class="row">
													<input type="text" class="form-control borra nombres" name="nombres" id="nombres" placeholder="Nombres" required="" />
													<div class="invalid-feedback" id="error-doc">Campo requerido</div>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="usuario">Usuario:</label>
											<div class="col-md-6 col-lg-4">
												<div class="row">
													<input type="text" class="form-control borra usuario" name="usuario" id="usuario" placeholder="Usuario" required="" />
													<div class="invalid-feedback">Campo requerido</div>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="perfil">Perfil:</label>
											<div class="col-md-6 col-lg-4">
												<div class="row">
													<select class="form-control perfil" name="perfil" id="perfil"  required="" >
												<?
													foreach($perfil as $row):	?>
														<option value="<?=$row->idperfil;?>" <?if($row->idperfil === '2')echo 'selected';?> ><?=$row->perfil;?></option>
												<?	endforeach;	?>
													</select>
													<div class="invalid-feedback">Campo requerido</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="container-fluid row"><hr class="col-sm-12"></div>
								<div class="col-sm-12 mx-auto pb-2">
									<button type="submit" class="btn btn-sabogal ml-3 mr-4" id="btnEnviar">Guardar registro</button>
									<button type="reset" class="btn btn-cancel btn-cancelar">Cancelar</button>
								</div>
							</form>
						</div>
					</div>
			