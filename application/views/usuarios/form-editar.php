					<div class="col-12 iq-card my-3">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4>Editar Usuario</h4></div>
						</div>
						<div class="iq-card-body">
							<form method="post" id="form_usuarios" action="<?=base_url()?>usuarios/registrar">
								<input type="hidden" name="tiporegistro" value="editar" />
								<input type="hidden" name="idusuario" value="<?=$usuario->idusuario;?>" />
								<div class="row">
									<div class="col-sm-12 my-1">
										<div class="row">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="tipodoc">Tipo de Documento:</label>
											<div class="col-md-6 col-lg-3">
												<div class="row">
													<select class="form-control tipodoc" name="tipodoc" id="tipodoc" disabled >
													<?
															foreach($tipodoc as $row):	?>
																<option value="<?=$row->idtipodocumento;?>" <?=($row->idtipodocumento === $usuario->idtipodocumento)?'selected':'';?>>
																	<?=$row->tipo_documento;?></option>
													<?		endforeach;	?>
													</select>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="doc">N&uacute;mero de Documento:</label>
											<input type="text" class="form-control col-md-6 col-lg-3 doc" name="doc" id="doc" autocomplete="off"
												value="<?=$usuario->numero_documento;?>" disabled />
											<!--<button type="button" class="btn btn-info btn_curl"><i class="fa fa-search" aria-hidden="true"></i></button>-->
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="apellidos">Apellidos:</label>
											<input type="text" class="form-control col-md-6 col-lg-4 apellidos" name="apellidos" id="apellidos" placeholder="Apellidos"
												value="<?=$usuario->apellidos;?>" disabled />
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="nombres">Nombres:</label>
											<input type="text" class="form-control col-md-6 col-lg-4 nombres" name="nombres" id="nombres" placeholder="Nombres"
												value="<?=$usuario->nombres;?>" disabled />
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="usuario">Usuario:</label>
											<input type="text" class="form-control col-md-6 col-lg-4 usuario" name="usuario" id="usuario" placeholder="Usuario"
												value="<?=$usuario->usuario;?>" disabled />
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="perfil">Perfil:</label>
											<div class="col-md-6 col-lg-4">
												<div class="row">
													<select class="form-control perfil" name="perfil" id="perfil"  required="" >
												<?
													foreach($perfil as $row):	?>
														<option value="<?=$row->idperfil;?>" <?if($row->idperfil === $usuario->idperfil)echo 'selected';?> ><?=$row->perfil;?></option>
												<?	endforeach;	?>
													</select>
													<div class="invalid-feedback">Campo requerido</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row"><hr class="col-sm-11"></div>
								<div class="col-sm-12 mx-auto pb-2">
									<button type="submit" class="btn btn-sabogal ml-3 mr-4" id="btnEnviar">Editar registro</button>
									<button type="reset" class="btn btn-cancel btn-cancelar">Cancelar</button>
								</div>
							</form>
						</div>
					</div>
			