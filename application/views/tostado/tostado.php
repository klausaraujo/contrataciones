						<? $usuario = json_decode($this->session->userdata('user')); ?>
						<div class="col-12 card px-0 my-3">
							<div class="card-body">
								<h4 class="">Listado General del Proceso de Tostado</h4>
								<hr>
								<div class="row">
									<div class="col-md-11">
										<div class="row">
											<div class="col-md-3">
												<div class="row">
													<label class="control-label col-md-4 align-self-center mb-0" for="anio">&nbsp;&nbsp;&nbsp;A&ntilde;o:</label>
													<div class="col-md-8">
														<select class="form-control form-control-sm anio" name="anio" id="anio">
														<? foreach($anio as $row): ?>
															<option value="<?=$row->anio?>" <?=date('Y') === $row->anio? 'selected' : '';?> ><?=$row->anio;?></option>	
														<? endforeach;	?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="row">
													<label class="control-label col-md-4 align-self-center mb-0" for="mes">&nbsp;&nbsp;&nbsp;Mes:</label>
													<div class="col-md-8">
														<select class="form-control form-control-sm mes" name="mes" id="mes">
														<? foreach($mes as $row): ?>
															<option value="<?=$row->idmes;?>" <?=date('n') === $row->idmes? 'selected' : '';?> ><?=$row->mes;?></option>
														<? endforeach;	?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="row">
													<label class="control-label col-md-5 align-self-center mb-0" for="sucursal">&nbsp;&nbsp;&nbsp;Sucursal:</label>
													<div class="col-md-7">
														<select class="form-control form-control-sm sucursal" name="sucursal" id="sucursal">
														<? foreach($usuario->sucursales as $row): ?>
															<option value="<?=$row->idsucursal;?>"><?=$row->sucursal;?></option>	
														<? endforeach;	?>
														</select>
													</div>
												</div>
											</div><!--Anular-->
										</div>
									</div>
								</div>
								<hr class="mb-md-0">
								<?if($this->session->flashdata('claseMsg')){?><div class="row justify-content-center py-2">
									<div class="alert <?=$this->session->flashdata('claseMsg')?> py-1 px-5 msg fade show" role="alert">
										<div class="iq-alert-text"><?=$this->session->flashdata('flashMessage')?></div>
									</div>
								</div><?}?>
								<div class="col-md-12 text-center resp" style="font-size:1.3em">&nbsp;</div>
								<div class="container-fluid">
									<div class="row">
										<div class="col-12 mx-auto" style="overflow-x:auto">
											<table id="tablaTostado" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
										</div>
									</div>
								</div>
							</div>
						</div>