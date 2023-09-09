					<? $usuario = json_decode($this->session->userdata('user')); ?>
					<div class="col-12 iq-card my-3">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4>Edici&oacute;n de Movimientos de Caja de Sucursales</h4></div>
						</div>
						<div class="iq-card-body">
							<input type="hidden" id="saldoActual" value="<?=$saldo?>" />
							<form method="post" id="form_caja" action="<?=base_url()?>servicios/registrar" class="needs-validation form-horizontal" novalidate="">
								<input type="hidden" name="tiporegistro" value="editar" />
								<input type="hidden" name="idmov" value="<?=$servicio->idmovimiento?>" />
								<input type="hidden" name="idtran" value="<?=$servicio->idtransaccion?>" />
								<div class="form-row">
									<div class="col-12 my-1">
										<div class="row">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="saldo">&nbsp;&nbsp;Saldo en caja:</label>
											<?
												$clase = 'text-success';
												if(floatVal($saldo) > 0) $clase = 'text-primary';
												elseif(floatVal($saldo) < 0) $clase = 'text-danger';
											?>
											<div class="col-md-6 col-lg-4 pl-0">
												<input type="text" class="form-control form-control-sm saldo col-md-6 mr-auto text-right font-weight-bold <?=$clase?>"
														value="<?=number_format($saldo,2,'.',',');?>" name="saldo" id="saldo" readonly />
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="sucursalCaja">&nbsp;&nbsp;Sucursal:</label>
											<div class="col-md-6 col-lg-4">
												<div class="row">
													<select class="form-control sucursalCaja" name="sucursalCaja" id="sucursalCaja" required="" disabled >
													<? foreach($usuario->sucursales as $row): ?>
														<option value="<?=$row->idsucursal;?>" <?=$servicio->idsucursal === $row->idsucursal? 'selected':'';?> ><?=$row->sucursal;?></option>	
													<? endforeach;	?>
													</select>
													<div class="invalid-feedback">Debe elegir una sucursal</div>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="tipoCaja">&nbsp;&nbsp;Tipo Operaci&oacute;n:</label>
											<div class="col-md-6 col-lg-4">
												<div class="row">
													<select class="form-control tipoCaja" name="tipoCaja" id="tipoCaja" required="" disabled >
													<? foreach($tipo as $row): ?>
														<option value="<?=$row->idtipooperacion;?>" <?=$servicio->idtipooperacion === $row->idtipooperacion? 'selected':'';?> >
															<?=$row->tipo_operacion;?></option>	
													<? endforeach;	?>
													</select>
													<div class="invalid-feedback">Debe elegir un tipo de operacion</div>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="monto">&nbsp;&nbsp;Monto:</label>
											<div class="col-md-6 col-lg-5">
												<div class="row">
													<input type="text" class="form-control col-md-7 monto moneda" value="<?=$servicio->monto?>" name="monto" id="monto" 
															autocomplete="off" required="" />
													<div class="invalid-feedback">Debe indicar un Monto</div>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="fecha">&nbsp;&nbsp;Fecha:</label>
											<div class="col-md-6 col-lg-5">
												<div class="row">
													<input type="date" class="form-control col-md-7 fecha" value="<?=date_format(date_create($servicio->fecha_movimiento),'Y-m-d')?>" 
															name="fecha" id="fecha" required="" />
													<div class="invalid-feedback">Debe elegir la fecha</div>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<label class="control-label col-md-6 col-lg-3 align-self-center mb-0" for="obs">&nbsp;&nbsp;Observaciones:</label>
											<div class="col-md-6 col-lg-4">
												<div class="row">
													<textarea type="text" class="form-control obs mayusc" name="obs" id="obs"
														placeholder="Observaciones" maxlength="1000" ><?=$servicio->observaciones?></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="container-fluid row"><hr class="col-sm-12"></div>
								<div class="col-12 mx-auto pb-2">
									<button type="submit" class="btn btn-narsa ml-1 mr-4" id="btnEnviar">Guardar Registro</button>
									<button type="reset" class="btn btn-narsa btn-cancelar">Cancelar</button>
								</div>
							</form>
						</div>
					</div>