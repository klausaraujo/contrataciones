						<? $usuario = json_decode($this->session->userdata('user')); ?>
						<div class="col-12 card px-0 my-3">
							<div class="card-body">
								<h4 class="">Listado General de Movimientos de Caja</h4>
								<hr>
								<div class="row">
									<div class="col-md-11 mx-auto">
										<div class="row">
											<div class="col-md-3">
												<label class="control-label align-self-center mb-0 text-left" for="anio">&nbsp;&nbsp;&nbsp;A&ntilde;o:</label>
												<select class="form-control form-control-sm anio" name="anio" id="anio">
												<? foreach($anio as $row): ?>
													<option value="<?=$row->anio?>" <?=date('Y') === $row->anio? 'selected' : '';?> ><?=$row->anio;?></option>	
												<? endforeach;	?>
												</select>
											</div>
											<div class="col-md-3">
												<label class="control-label align-self-center mb-0 text-left" for="mes">&nbsp;&nbsp;&nbsp;Mes:</label>
												<select class="form-control form-control-sm mes" name="mes" id="mes">
												<? foreach($mes as $row): ?>
													<option value="<?=$row->idmes;?>" <?=date('n') === $row->idmes? 'selected' : '';?> ><?=$row->mes;?></option>
												<? endforeach;	?>
												</select>
											</div>
											<div class="col-md-3">
												<label class="control-label align-self-center mb-0 text-left" for="sucursal">&nbsp;&nbsp;&nbsp;Sucursal:</label>
												<select class="form-control form-control-sm sucursal" name="sucursal" id="sucursal">
												<? foreach($usuario->sucursales as $row): ?>
													<option value="<?=$row->idsucursal;?>"><?=$row->sucursal;?></option>	
												<? endforeach;	?>
												</select>
											</div>
											<div class="col-md-3">
												<label class="control-label align-self-center mb-0 col-12 text-left text-md-right" for="saldo">Saldo Final:</label>
												<?
													$clase = 'text-success';
													if(floatVal($saldo) > 0) $clase = 'text-primary';
													elseif(floatVal($saldo) < 0) $clase = 'text-danger';
												?>
												<input type="text" class="form-control form-control-sm saldo col-md-8 ml-auto text-md-right font-weight-bold <?=$clase?>"
														value="<?=number_format($saldo,2,'.',',');?>" name="saldo" id="saldo" readonly />
											</div>
										</div>
									</div>
								</div>
								<hr>
								<?if($this->session->flashdata('claseMsg')){?><div class="row justify-content-center py-2">
									<div class="alert <?=$this->session->flashdata('claseMsg')?> py-1 px-5 msg fade show" role="alert">
										<div class="iq-alert-text"><?=$this->session->flashdata('flashMessage')?></div>
									</div>
								</div><?}?>
								<div class="col-md-12 text-center pt-2 resp" style="font-size:1.3em">&nbsp;</div>
								<div class="container-fluid mt-2">
									<div class="row">
										<div style="overflow-x:hidden" class="col-12"> <!--class="table-responsive" -->
										<!--<div class="col-sm-12 mx-auto" style="overflow-x:scroll"><!--align-items-center text-center-->
											<table id="tablaServicios" class="table table-striped dt-responsive table-bordered display nowrap table-hover mb-0 mx-auto"></table>
										</div>
									</div>
								</div>
							</div>
						</div>