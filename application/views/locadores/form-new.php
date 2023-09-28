					<div class="col-12 iq-card my-3">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4>Registro de Convocatorias</h4></div>
						</div>
						<div class="iq-card-body">
							<form method="post" id="form_locadores" enctype="multipart/form-data" action="<?=base_url()?>locadores/registrar" class="form">
								<input type="hidden" name="tiporegistro" value="registrar" />
								<input type="hidden" id="file1" name="file1" />
								<input type="hidden"  id="file2" name="file2" />
								<div class="form-row">
									<div class="col-12 my-1">
										<div class="row justify-content-center">
											<?if($this->session->flashdata('errorImage')){?><div class="alert <?=$this->session->flashdata('claseImg')?> py-1 px-5 msg fade show" role="alert">
												<div class="iq-alert-text"><?=$this->session->flashdata('errorImage')?></div>
											</div><?}?>
										</div>
										<div class="row">
											<label class="control-label col-md-3 col-lg-2 align-self-center mb-0" for="dependencia">Dependencia:</label>
											<div class="col-md-6 col-lg-4">
												<div class="row">
													<select class="form-control" name="dependencia" id="dependencia" required="">
													<?
															foreach($dependencia as $row):	?>
																<option value="<?=$row->iddependencia;?>"><?=$row->descripcion;?></option>
													<?		endforeach;	?>
													</select>
													<div class="invalid-feedback">Debe elegir una dependencia</div>
												</div>
											</div>
										</div>
										<div class="row mt-2">
											<label class="control-label col-md-3 col-lg-2 align-self-center mb-0" for="denominacion">Denominaci&oacute;n:</label>
											<div class="col-md-8 col-lg-8">
												<div class="row">
													<textarea class="form-control mayusc" name="denominacion" required=""></textarea>
													<div class="invalid-feedback">Campo requerido</div>
												</div>
											</div>
										</div>
										<div class="row mt-2">
											<label class="control-label col-md-3 col-lg-2 align-self-center mb-0" for="finicio">Fecha/Hora Inicio:</label>
											<div class="col-md-2">
												<div class="row form-inline">
													<input type="datetime-local" class="form-control blur col-12" value="<?=date('Y-m-d H:i')?>"
														min="<?=date('Y-m-d H:i')?>" name="finicio" id="finicio" />
												</div>
											</div>
											<label class="control-label col-md-3 col-lg-2 align-self-center mb-0 text-md-right offset-md-1" for="ffin">Fecha/Hora Fin:</label>
											<div class="col-md-2">
												<div class="row form-inline">
													<input type="datetime-local" class="form-control blur col-12" value="<?=date('Y-m-d H:i')?>"
														min="<?=date('Y-m-d H:i')?>" name="ffin" id="ffin" />
												</div>
											</div>
										</div>
										<div class="row mt-2">
											<label class="control-label col-md-3 col-lg-2 align-self-center mb-0 pr-0" for="monto">Monto Estimado:</label>
											<div class="col-md-4 col-lg-3">
												<div class="row">
													<input type="text" class="form-control moneda" name="monto" id="monto" autocomplete="off" required="" />
													<div class="invalid-feedback">Monto requerido</div>
												</div>
											</div>
										</div>
										<div class="row mt-2">
											<label class="control-label col-md-3 col-lg-2 align-self-center mb-0 pr-0">Archivo TDR (PDF):</label>
											<div class="col-md-5 col-lg-4">
												<div class="row">
													<div class="custom-file">
														<label class="custom-file-label tdr" for="customfile">Cargar Archivo TDR</label>
														<input type="file" class="custom-file-input atach" id="customfile" name="customfile">
													</div>
												</div>
											</div>
											<div class="col-md-4 col-lg-2 align-self-center mb-0 pr-0 sptdr"></div>
										</div>
										<div class="row my-2">
											<label class="control-label col-md-3 col-lg-2 align-self-center mb-0 pr-0">Archivos Anexos:</label>
											<div class="col-md-5 col-lg-4">
												<div class="row">
													<div class="custom-file">
														<label class="custom-file-label anexo" for="customfile1">Cargar Archivos Anexos</label>
														<input type="file" class="custom-file-input atach" id="customfile1" name="customfile1">
													</div>
												</div>
											</div>
											<div class="col-md-4 col-lg-2 align-self-center mb-0 pr-0 spanexo"></div>
										</div>
									</div>
								</div>
								<div class="container-fluid row"><hr class="col-sm-12"></div>
								<div class="col-sm-12 mx-auto pb-2">
									<button type="submit" class="btn btn-sabogal ml-3 mr-4" id="btnEnviar">Guardar Convocatoria</button>
									<button type="reset" class="btn btn-cancel btn-cancelar">Cancelar</button>
								</div>
							</form>
						</div>
					</div>
			