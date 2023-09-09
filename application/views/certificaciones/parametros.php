<? $usuario = json_decode($this->session->userdata('user'));?>
					<div class="col-12 iq-card my-3">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4><b><?=ucwords(strtolower($proveedor->nombre))?></b> (Certificaciones)</h4></div>
						</div>
						<div class="iq-card-body pb-0">
							<!--<div class="row">
								<!-- Nav pills -->
								<div class="nav nav-pills row" id="nav-tab" role="tablist">
									<a class="nav-item nav-link col-lg-3 col-12 col-md-4 text-center active" data-toggle="tab" href="#pill-fisico">Aspecto F&iacute;sico y Tostado</a>
									<a class="nav-item nav-link col-lg-3 col-12 col-md-4 text-center" data-toggle="tab" href="#pill-conteo">Conteo de Defectos</a>
									<a class="nav-item nav-link col-lg-3 col-12 col-md-4 text-center" data-toggle="tab" href="#pill-sensorial">An&aacute;lisis Sensorial</a>
									<a class="nav-item nav-link col-lg-3 col-12 col-md-4 text-center" data-toggle="tab" href="#pill-catadores">Catadores</a>
								</div>
							<!--</div>-->
							<!-- Tab panes -->
							<!--<div id="am-radar-chart" style="height:500px;"></div>-->
							<div class="tab-content">
								<div class="tab-pane container active" id="pill-fisico">
									<div class="col-md-12 text-center pt-2 resp" style="font-size:1.3em">&nbsp;</div>
								
									<form method="post" id="form_fisico" action="<?=base_url().$this->uri->segment(1)?>/parametros/fisico" class="form">
										<input type="hidden" class="idproveedor" name="idproveedor" value="<?=$proveedor->idproveedor?>"/>
										<input type="hidden" name="idcertificado" value="<?=$idcertificado?>"/>
										<div class="form-row container-fluid mt-1">
											<div class="col-md-4">
												<label class="control-label mb-0" for="color">&nbsp;&nbsp;&nbsp;Color:</label>
												<select class="form-control color" name="color" id="color">
												<? foreach($color as $row): ?>
													<option value="<?=$row->idcolor;?>" <?=(!empty($detalle) && $detalle->idcolor === $row->idcolor) ? 'selected' : '';?> ><?=$row->color;?></option>
												<? endforeach;	?>
												</select>
											</div>
											<div class="col-md-6">
												<label class="control-label mb-0" for="olor">&nbsp;&nbsp;&nbsp;Olor:</label>
												<input type="text" class="form-control mayusc" maxlength="200" name="detolor" id="detolor"
													value="<?=(!empty($detalle))? $detalle->olor : '';?>" />
												<select class="form-control olor d-none" name="olor" id="olor">
													<option value="1"> -- Seleccione -- </option>
												<? /*foreach($olor as $row): ?>
													<option value="<?=$row->idolor;?>" <?=(!empty($detalle) && $detalle->idolor === $row->idolor) ? 'selected' : '';?> ><?=$row->olor;?></option>
												<? endforeach;	*/?>
												</select>
											</div>
										</div>
										<hr>
										<div class="form-row container-fluid">
											<div class="card col-md-9 col-lg-6 mr-lg-4 mb-4 mb-lg-0">
												<div class="card-header text-center">
													<div class="row"><h5 class="car-title col-12 font-weight-bold">An&aacute;lisis F&iacute;sico</h5></div>
													<div class="row mt-2">
														<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted">Detalle</h6></div>
														<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted">Peso</h6></div>
														<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted">%</h6></div>
													</div>
												</div>
												<ul class="list-group list-group"><!--list-group-flush-->
													<li class="list-group-item">
														<div class="row">
															<p class="col-4 align-self-center mb-0">Caf&eacute; Exportable</p>
															<div class="col-4">
																<input class="form-control form-control-sm mx-2 moneda text-right blur" type="text" name="pesocafe" id="pesocafe" 
																	value="<?=!empty($detalle)? floatval($detalle->analisis_cafe_exportable_peso) : ''?>" />
															</div>
															<div class="col-4">
																<input class="form-control form-control-sm mx-2 moneda text-right" type="text" name="cafeporc" id="cafeporc"
																	value="<?=!empty($detalle)? floatval($detalle->analisis_cafe_exportable_por) : ''?>" readonly />
															</div>
														</div>
													</li>
													<li class="list-group-item">
														<div class="row">
															<p class="col-4 align-self-center mb-0">Sub Producto</p>
															<div class="col-4">
																<input class="form-control form-control-sm mx-2 moneda text-right blur" type="text" name="pesosub" id="pesosub"
																	value="<?=!empty($detalle)? floatval($detalle->analisis_sub_procuto_peso) : ''?>" />
															</div>
															<div class="col-4">
																<input class="form-control form-control-sm mx-2 moneda text-right" type="text" name="subporc" id="subporc"
																	value="<?=!empty($detalle)? floatval($detalle->analisis_sub_procuto_por) : ''?>" readonly />
															</div>
														</div>
													</li>
													<li class="list-group-item">
														<div class="row">
															<p class="col-4 align-self-center mb-0">Descarte</p>
															<div class="col-4">
																<input class="form-control form-control-sm mx-2 moneda text-right blur" type="text" name="pesodesc" id="pesodesc" 
																	value="<?=!empty($detalle)? floatval($detalle->analisis_descarte_peso) : ''?>" />
															</div>
															<div class="col-4">
																<input class="form-control form-control-sm mx-2 moneda text-right" type="text" name="descporc" id="descporc"
																	value="<?=!empty($detalle)? floatval($detalle->analisis_descarte_por) : ''?>" readonly />
															</div>
														</div>
													</li>
													<li class="list-group-item">
														<div class="row">
															<p class="col-4 align-self-center mb-0">C&aacute;scara</p>
															<div class="col-4">
																<input class="form-control form-control-sm mx-2 moneda text-right blur" type="text" name="pesocasc" id="pesocasc"
																	value="<?=!empty($detalle)? floatval($detalle->analisis_cascara_peso) : ''?>" />
															</div>
															<div class="col-4">
																<input class="form-control form-control-sm mx-2 moneda text-right" type="text" name="cascporc" id="cascporc"
																	value="<?=!empty($detalle)? floatval($detalle->analisis_cascara_por) : ''?>" readonly />
															</div>
														</div>
													</li>
													<?
														$totPeso = 0; $totPesoPor = 0;
														if(!empty($detalle)){
															$totPeso = number_format(floatval($detalle->analisis_cafe_exportable_peso)+floatval($detalle->analisis_sub_procuto_peso)+floatval($detalle->analisis_descarte_peso)+floatval($detalle->analisis_cascara_peso),2,'.',',');
															$totPesoPor = number_format(floatval($detalle->analisis_cafe_exportable_por)+floatval($detalle->analisis_sub_procuto_por)+floatval($detalle->analisis_descarte_por)+floatval($detalle->analisis_cascara_por),2,'.',',');
														}
													?>
													<li class="list-group-item">
														<div class="row">
															<p class="col-4 align-self-center mb-0">Total</p>
															<div class="col-4">
																<input class="form-control form-control-sm mx-2 text-right" type="text" name="pesototal" id="pesototal" value="<?=!empty($detalle)?$totPeso:'';?>" readonly />
															</div>
															<div class="col-4">
																<input class="form-control form-control-sm mx-2 text-right" type="text" name="porctotal" id="porctotal" value="<?=!empty($detalle)?$totPesoPor:'';?>" readonly />
															</div>
														</div>
													</li>
												</ul>
											</div>
											<div class="card col-md-9 col-lg-5">
												<div class="card-header text-center">
													<div class="row"><h5 class="car-title col-12 font-weight-bold">Granulometr&iacute;a</h5></div>
													<div class="row mt-2">
														<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted align-self-center mb-0">Malla</h6></div>
														<div class="col-4">
															<select class="form-control form-control-sm text-center" id="malla_gen" name="malla_gen">
																<option value="350" <?if(!empty($detalle)){echo (intval($detalle->granumelometria_malla_general)=== 350)? 'selected':'';}?>>350</option>
																<option value="500" <?if(!empty($detalle)){echo (intval($detalle->granumelometria_malla_general)=== 500)? 'selected':'';}?>>500</option>
															</select>
														</div>
														<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted align-self-center mb-0">%</h6></div>
													</div>
												</div>
												<ul class="list-group list-group">
													<li class="list-group-item">
														<div class="row">
															<p class="col-4 align-self-center mb-0">16 al 20</p>
															<div class="col-4"><input class="form-control form-control-sm mx-2 moneda text-right blur" type="text" name="malla16" id="malla16"
																value="<?=!empty($detalle)? floatval($detalle->granumelometria_malla_1620_nro) : ''?>" />
															</div>
															<div class="col-4"><input class="form-control form-control-sm mx-2 moneda text-right" type="text" name="mallaporc" id="mallaporc"
																value="<?=!empty($detalle)? floatval($detalle->granumelometria_malla_1620_por) : ''?>" readonly />
															</div>
														</div>
													</li>
													<li class="list-group-item">
														<div class="row">
															<p class="col-4 align-self-center mb-0">15</p>
															<div class="col-4"><input class="form-control form-control-sm mx-2 moneda text-right blur" type="text" name="malla15" id="malla15"
																value="<?=!empty($detalle)? floatval($detalle->granumelometria_malla_15_nro) : ''?>" />
															</div>
															<div class="col-4"><input class="form-control form-control-sm mx-2 moneda text-right" type="text" name="malla15porc" id="malla15porc"
																value="<?=!empty($detalle)? floatval($detalle->granumelometria_malla_15_por) : ''?>" readonly />											
															</div>
														</div>
													</li>
													<li class="list-group-item">
														<div class="row">
															<p class="col-4 align-self-center mb-0">14</p>
															<div class="col-4"><input class="form-control form-control-sm mx-2 moneda text-right blur" type="text" name="malla14" id="malla14"
																value="<?=!empty($detalle)? floatval($detalle->granumelometria_malla_14_nro) : ''?>" />
															</div>
															<div class="col-4"><input class="form-control form-control-sm mx-2 moneda text-right" type="text" name="malla14porc" id="malla14porc"
																value="<?=!empty($detalle)? floatval($detalle->granumelometria_malla_14_por) : ''?>" readonly />
															</div>
														</div>
													</li>
													<li class="list-group-item">
														<div class="row">
															<p class="col-4 align-self-center mb-0">Base</p>
															<div class="col-4"><input class="form-control form-control-sm mx-2 moneda text-right blur" type="text" name="mallabase" id="mallabase"
																value="<?=!empty($detalle)? floatval($detalle->granumelometria_malla_base_nro) : ''?>" />
															</div>
															<div class="col-4"><input class="form-control form-control-sm mx-2 moneda text-right" type="text" name="mallabaseporc" id="mallabaseporc"
																value="<?=!empty($detalle)? floatval($detalle->granumelometria_malla_base_por) : ''?>" readonly />
															</div>
														</div>
													</li>
													<?
														$totMalla = 0; $totMallaPor = 0;
														if(!empty($detalle)){
															$totMalla = number_format(floatval($detalle->granumelometria_malla_1620_nro)+floatval($detalle->granumelometria_malla_15_nro)+floatval($detalle->granumelometria_malla_14_nro)+floatval($detalle->granumelometria_malla_base_nro),2,'.',',');
															$totMallaPor = number_format(floatval($detalle->granumelometria_malla_1620_por)+floatval($detalle->granumelometria_malla_15_por)+floatval($detalle->granumelometria_malla_14_por)+floatval($detalle->granumelometria_malla_base_por),2,'.',',');
														}
													?>
													<li class="list-group-item">
														<div class="row">
															<p class="col-4 align-self-center mb-0">Total</p>
															<div class="col-4">
																<input class="form-control form-control-sm mx-2 text-right" type="text" name="grtotmalla" id="grtotmalla" value="<?=!empty($detalle)?$totMalla:'';?>" readonly />
															</div>
															<div class="col-4">
																<input class="form-control form-control-sm mx-2 text-right" type="text" name="portotmalla" id="portotmalla" value="<?=!empty($detalle)?$totMallaPor:'';?>" readonly />
															</div>
														</div>
													</li>
												</ul>
											</div>
										</div>
										<hr>
										<div class="form-row container-fluid mt-3">
											<div class="col-12 mb-3"><h5 style="text-decoration:underline"><b>Categor&iacute;a / Tostado</b></h5></div>
											<div class="col-md-4">
												<label class="control-label mb-0" for="apariencia">&nbsp;&nbsp;&nbsp;Apariencia:</label>
												<select class="form-control apariencia" name="apariencia" id="apariencia">
												<? foreach($apariencia as $row): ?>
													<option value="<?=$row->idapariencia;?>" <?=(!empty($detalle) && $detalle->idapariencia === $row->idapariencia)? 'selected' : '';?> ><?=$row->apariencia;?></option>
												<? endforeach;	?>
												</select>
												<!--<div class="invalid-feedback">Campo Requerido</div>-->
											</div>
											<div class="col-md-4">
												<label class="control-label mb-0" for="quaker">&nbsp;&nbsp;&nbsp;Quaker:</label>
												<select class="form-control quaker" name="quaker" id="quaker">
												<? foreach($quaker as $row): ?>
													<option value="<?=$row->idquaker;?>" <?=(!empty($detalle) && $detalle->idquaker === $row->idquaker)? 'selected' : '';?> ><?=$row->quaker;?></option>
												<? endforeach;	?>
												</select>
												<!--<div class="invalid-feedback">Campo Requerido</div>-->
											</div>
										</div>
										<hr>
										<div class="form-row container-fluid mb-3">
											<div class="col-12 mb-3"><h5 style="text-decoration:underline"><b>Datos Tostado</b></h5></div>
											<div class="col-md-4 col-lg-3">
												<label class="control-label mb-0" for="tiempoTost">&nbsp;&nbsp;&nbsp;Tiempo de Tostado:</label>
												<input type="text" class="form-control tiempoTost text-right" name="tiempoTost" id="tiempoTost"
													value="<?=!empty($detalle)? $detalle->tostado_tiempo : ''?>" />
												<!--<div class="invalid-feedback">Campo Requerido</div>-->
											</div>
											<div class="col-md-3">
												<label class="control-label mb-0" for="colorAg">&nbsp;&nbsp;&nbsp;Color(agtron):</label>
												<input type="text" class="form-control colorAg moneda text-right" name="colorAg" id="colorAg"
													value="<?=!empty($detalle)? floatval($detalle->tostado_color_agtron) : ''?>" />
												<!--<div class="invalid-feedback">Campo Requerido</div>-->
											</div>
											<div class="col-md-3">
												<label class="control-label mb-0" for="porcPerdida">&nbsp;&nbsp;&nbsp;(%) P&eacute;rdida:</label>
												<input type="text" class="form-control porcPerdida moneda text-right" name="porcPerdida" id="porcPerdida"
													value="<?=!empty($detalle)? floatval($detalle->tostado_perdida) : ''?>" />
												<!--<div class="invalid-feedback">Campo Requerido</div>-->
											</div>
										</div>
										<div class="modal-footer">
											<div class="row">
												<div class="col-md-12">
													<button class="btn btn-narsa" id="guardafisico">Guardar Par&aacute;metro</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="tab-pane container fade" id="pill-conteo">
									<div class="col-12 text-center pt-2 resp" style="font-size:1.3em">&nbsp;</div>
									
									<form method="post" id="form_conteo" action="<?=base_url().$this->uri->segment(1)?>/parametros/conteo" class="form">
										<input type="hidden" class="idproveedor" name="idproveedor" value="<?=$proveedor->idproveedor?>"/>
										<input type="hidden" name="idcertificado" value="<?=$idcertificado?>"/>
										<div class="row container">
											<div class="col-12">
												<div class="form-row">
													<div class="card col-lg-9 mx-auto mt-1">
														<div class="card-header text-center">
															<div class="row"><h5 class="car-title col-12 font-weight-bold">Defectos Primarios</h5></div>
															<div class="row mt-2">
																<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted">Defecto</h6></div>
																<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted">Nro.</h6></div>
																<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted">Equivalencia</h6></div>
															</div>
														</div>
														<ul class="list-group list-group">
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Negro Completo</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nronegro" id="nronegro"
																		value="<?=!empty($detalle)? floatval($detalle->def_pri_negro_completo_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqnegro" id="eqnegro"
																		value="<?=!empty($detalle)? $detalle->def_pri_negro_completo_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Agrio Completo</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nroagrio" id="nroagrio"
																		value="<?=!empty($detalle)? floatval($detalle->def_pri_agrio_completo_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqagrio" id="eqagrio"
																		value="<?=!empty($detalle)? $detalle->def_pri_agrio_completo_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Cereza Seca</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nrocereza" id="nrocereza"
																		value="<?=!empty($detalle)? floatval($detalle->def_pri_cereza_seca_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqcereza" id="eqcereza"
																		value="<?=!empty($detalle)? $detalle->def_pri_cereza_seca_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Da&ntilde;ado por Hongos</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nrohongos" id="nrohongos"
																		value="<?=!empty($detalle)? floatval($detalle->def_pri_danado_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqhongos" id="eqhongos"
																		value="<?=!empty($detalle)? $detalle->def_pri_danado_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Da&ntilde;o Severo de Insectos</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nroinsec" id="nroinsec"
																		value="<?=!empty($detalle)? floatval($detalle->def_pri_danado_severo_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqinsec" id="eqinsec"
																		value="<?=!empty($detalle)? $detalle->def_pri_danado_severo_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item mb-3">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Materia Extraña</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nroextr" id="nroextr"
																		value="<?=!empty($detalle)? floatval($detalle->def_pri_materia_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqextr" id="eqextr"
																		value="<?=!empty($detalle)? $detalle->def_pri_materia_equi : ''?>" readonly /></div>
																</div>
															</li>
														</ul>
													</div>
												</div>
												<div class="form-row">
													<div class="card col-lg-9 mx-auto mt-1">
														<div class="card-header text-center">
															<div class="row"><h5 class="car-title col-12 font-weight-bold">Defectos Secundarios</h5></div>
															<div class="row mt-2">
																<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted">Defecto</h6></div>
																<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted">Nro.</h6></div>
																<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted">Equivalencia</h6></div>
															</div>
														</div>
														<ul class="list-group list-group">
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Negro Parcial</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nronegrop" id="nronegrop"
																		value="<?=!empty($detalle)? floatval($detalle->def_sec_negro_parcial_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqnegrop" id="eqnegrop"
																		value="<?=!empty($detalle)? $detalle->def_sec_negro_parcial_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Agrio Parcial</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nroagriop" id="nroagriop"
																		value="<?=!empty($detalle)? floatval($detalle->def_sec_agrio_parcial_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqagriop" id="eqagriop"
																		value="<?=!empty($detalle)? $detalle->def_sec_agrio_parcial_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Pergamino</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nroperg" id="nroperg"
																		value="<?=!empty($detalle)? floatval($detalle->def_sec_pergamino_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqperg" id="eqperg"
																		value="<?=!empty($detalle)? $detalle->def_sec_pergamino_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Flotador</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nroflot" id="nroflot"
																		value="<?=!empty($detalle)? floatval($detalle->def_sec_flotador_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqflot" id="eqflot"
																		value="<?=!empty($detalle)? $detalle->def_sec_flotador_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Inmaduro</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nroinmad" id="nroinmad"
																		value="<?=!empty($detalle)? floatval($detalle->def_sec_inmaduro_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqinmad" id="eqinmad"
																		value="<?=!empty($detalle)? $detalle->def_sec_inmaduro_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Averanado</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nroavera" id="nroavera"
																		value="<?=!empty($detalle)? floatval($detalle->def_sec_averanado_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqavera" id="eqavera"
																		value="<?=!empty($detalle)? $detalle->def_sec_averanado_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Concha</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nroconc" id="nroconc"
																		value="<?=!empty($detalle)? floatval($detalle->def_sec_concha_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqconc" id="eqconc"
																		value="<?=!empty($detalle)? $detalle->def_sec_concha_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Quebrado/Cortado/Mordido</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nroqueb" id="nroqueb"
																		value="<?=!empty($detalle)? floatval($detalle->def_sec_quebrado_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqqueb" id="eqqueb"
																		value="<?=!empty($detalle)? $detalle->def_sec_quebrado_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">C&aacute;scara/Pulpa</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nropul" id="nropul"
																		value="<?=!empty($detalle)? floatval($detalle->def_sec_cascara_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqpul" id="eqpul"
																		value="<?=!empty($detalle)? $detalle->def_sec_cascara_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Da&ntilde;o Ligero de Insectos</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 num text-right blur" type="text" name="nrolgins" id="nrolgins"
																		value="<?=!empty($detalle)? floatval($detalle->def_sec_insectos_num) : ''?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 eq text-right" type="text" name="eqlgins" id="eqlgins"
																		value="<?=!empty($detalle)? $detalle->def_sec_insectos_equi : ''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item mb-3">
																<div class="row">
																	<p class="col-8 align-self-center mb-0 text-center">Total</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 text-right" type="text" name="totconteo" id="totconteo" readonly /></div>
																</div>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<div class="row">
												<div class="col-md-12">
													<button class="btn btn-narsa" id="guardaConteo">Guardar Par&aacute;metro</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="tab-pane container fade" id="pill-sensorial">
									<div class="col-md-12 text-center pt-2 resp" style="font-size:1.3em">&nbsp;</div>
									<form method="post" id="form_sensorial" action="<?=base_url().$this->uri->segment(1)?>/parametros/sensorial" class="form">
										<input type="hidden" class="idproveedor" name="idproveedor" value="<?=$proveedor->idproveedor?>"/>
										<input type="hidden" name="idcertificado" value="<?=$idcertificado?>"/>
										<input type="hidden" name="grafico" id="grafico" class="form-control row" />
										<div class="row container mt-1">
											<div class="col-12">
												<div class="form-row">
													<div class="card col-lg-10 mx-auto mt-1 mb-3">
														<div class="card-header text-center">
															<div class="row"><h5 class="car-title col-12 font-weight-bold">An&aacute;lisis Sensorial del Caf&eacute;</h5></div>
															<div class="row mt-2">
																<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted">Atributos</h6></div>
																<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted">Puntos</h6></div>
																<div class="col-4"><h6 class="car-subtitle font-weight-bold text-muted">Caracter&iacute;sticas</h6></div>
															</div>
														</div>
														<ul class="list-group list-group">
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Fragancia/Aroma</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 moneda blur text-right" type="text" name="fragptos" id="fragptos"
																		value="<?=!empty($detalle)? floatval($detalle->atributos_fragancia_puntos) : '';?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 mayusc text-right" type="text" name="fragcaract" id="fragcaract"
																		value="<?=!empty($detalle)? $detalle->atributos_fragancia_caracteristicas : '';?>" /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Sabor</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 moneda blur text-right" type="text" name="sabptos" id="sabptos"
																		value="<?=!empty($detalle)? floatval($detalle->atributos_sabor_puntos) : '';?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 mayusc text-right" type="text" name="sabcaract" id="sabcaract"
																		value="<?=!empty($detalle)? $detalle->atributos_sabor_caracteristicas : '';?>" /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Sabor Residual</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 moneda blur text-right" type="text" name="sabreptos" id="sabreptos"
																		value="<?=!empty($detalle)? floatval($detalle->atributos_residual_puntos) : '';?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 mayusc text-right" type="text" name="sabrecaract" id="sabrecaract"
																		value="<?=!empty($detalle)? $detalle->atributos_residual_caracteristicas : '';?>" /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Acidez</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 moneda blur text-right" type="text" name="aciptos" id="aciptos"
																		value="<?=!empty($detalle)? floatval($detalle->atributos_acidez_puntos) : '';?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 mayusc text-right" type="text" name="acicaract" id="acicaract"
																		value="<?=!empty($detalle)? $detalle->atributos_acidez_caracteristicas : '';?>" /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Cuerpo</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 moneda blur text-right" type="text" name="cuerptos" id="cuerptos"
																		value="<?=!empty($detalle)? floatval($detalle->atributos_cuerpo_puntos) : '';?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 mayusc text-right" type="text" name="cuerpocaract" id="cuerpocaract"
																		value="<?=!empty($detalle)? $detalle->atributos_cuerpo_caracteristicas : '';?>" /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Uniformidad</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 moneda blur text-right" type="text" name="uniptos" id="uniptos"
																		value="<?=!empty($detalle)? floatval($detalle->atributos_uniformidad_puntos) : '';?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 mayusc text-right" type="text" name="unicaract" id="unicaract"
																		value="<?=!empty($detalle)? $detalle->atributos_uniformidad_caracteristicas : '';?>" /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Balance</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 moneda blur text-right" type="text" name="balptos" id="balptos"
																		value="<?=!empty($detalle)? floatval($detalle->atributos_balance_puntos) : '';?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 mayusc text-right" type="text" name="balcaract" id="balcaract"
																		value="<?=!empty($detalle)? $detalle->atributos_balance_caracteristicas : '';?>" /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Taza Limpia</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 moneda blur text-right" type="text" name="tazptos" id="tazptos"
																		value="<?=!empty($detalle)? floatval($detalle->atributos_taza_puntos) : '';?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 mayusc text-right" type="text" name="tazcaract" id="tazcaract"
																		value="<?=!empty($detalle)? $detalle->atributos_taza_caracteristicas : '';?>" /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Dulzura</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 moneda blur text-right" type="text" name="dulptos" id="dulptos"
																		value="<?=!empty($detalle)? floatval($detalle->atributos_dulzura_puntos) : '';?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 mayusc text-right" type="text" name="dulcaract" id="dulcaract"
																		value="<?=!empty($detalle)? $detalle->atributos_dulzura_caracteristicas : '';?>" /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Apreciaci&oacute;n General</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 moneda blur text-right" type="text" name="apreptos" id="apreptos"
																		value="<?=!empty($detalle)? floatval($detalle->atributos_apreciacion_puntos) : '';?>" /></div>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 mayusc text-right" type="text" name="aprecaract" id="aprecaract"
																		value="<?=!empty($detalle)? $detalle->atributos_apreciacion_caracteristicas : '';?>" /></div>
																</div>
															</li>
															<?
																$total = 0; $totalmenos = 0;
																if(!empty($detalle)){
																	$total += floatval($detalle->atributos_fragancia_puntos)+floatval($detalle->atributos_sabor_puntos)+floatval($detalle->atributos_residual_puntos)+floatval($detalle->atributos_acidez_puntos);
																	$total += floatval($detalle->atributos_cuerpo_puntos)+floatval($detalle->atributos_uniformidad_puntos)+floatval($detalle->atributos_balance_puntos)+floatval($detalle->atributos_taza_puntos);
																	$total += floatval($detalle->atributos_dulzura_puntos)+floatval($detalle->atributos_apreciacion_puntos);
																	$totalmenos = $total - floatval($detalle->atributos_defectos_sustraer);
																}
															
															?>
															<li class="list-group-item py-0">
																<div class="row card-header">
																	<p class="col-sm-4 align-self-center mb-0">Puntaje Total</p>
																	<div class="col-sm-4"><input class="form-control form-control-sm mx-2 text-right mr-auto" type="text" 
																		id="ptotal" value="<?=!empty($detalle)?number_format($total,2,'.',','):''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-4 align-self-center mb-0">Defectos a Sustraer</p>
																	<div class="col-4"><input class="form-control form-control-sm mx-2 moneda blur text-right" type="text" name="defsustraer" id="defsustraer"
																		value="<?=!empty($detalle)? floatval($detalle->atributos_defectos_sustraer) : '';?>" /></div>
																</div>
															</li>
															<li class="list-group-item py-0">
																<div class="row card-header">
																	<p class="col-sm-4 align-self-center mb-0">Puntaje Final SCA</p>
																	<div class="col-sm-4"><input class="form-control form-control-sm mx-2 text-right mr-auto" type="text" 
																			id="pfinal" value="<?=!empty($detalle)?number_format($totalmenos,2,'.',','):''?>" readonly /></div>
																</div>
															</li>
															<li class="list-group-item">
																<div class="row">
																	<p class="col-sm-3 align-self-center mb-0">Nro. Tazas</p>
																	<div class="col-sm-3"><input class="form-control form-control-sm mx-2 moneda text-right" type="text" name="nrotazas" id="nrotazas"
																		value="<?=!empty($detalle)? floatval($detalle->atributos_numero_tasas) : '';?>" /></div>
																	<p class="col-sm-3 align-self-center mb-0">Nro. Intensidad</p>
																	<div class="col-sm-3"><input class="form-control form-control-sm mx-2 moneda text-right" type="text" name="nrointensidad" id="nrointensidad"
																		value="<?=!empty($detalle)? floatval($detalle->atributos_numero_intensidad) : '';?>" /></div>
																</div>
															</li>
														</ul>
														<!--<div class="row mt-3">
															<label class="control-label col-md-3 align-self-center mb-0" for="productor">&nbsp;&nbsp;Observaciones:</label>
															<input type="text" class="form-control col-md-8 mayusc" name="obs" id="obs" placeholder="Observaciones" />
														</div> Anular-->
													</div>
												</div>
											</div>
											<!--<div style="width:400"><canvas style="width:100%" id="myChart"></canvas></div>-->
											<table align="center" style="width:600px;height:600px"><tr><td><canvas class="my-3" id="grafica"></canvas></td></tr></table>
											<!--<img id="imagengraph" src="imagen.png" />-->
										</div>
										<div class="modal-footer">
											<div class="row">
												<div class="col-md-12">
													<button class="btn btn-narsa" id="guardaSensorial">Guardar Par&aacute;metro</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="tab-pane container fade" id="pill-catadores">
									<div class="col-md-12 text-center pt-4 resp" style="font-size:1.3em">&nbsp;</div>
									<input type="hidden" name="idcertificado" id="idcertificado" value="<?=$idcertificado?>"/>
								
									<!--<form method="post" id="form_sensorial" action="<?=base_url().$this->uri->segment(1)?>/parametros/catadores" class="form">
										<input type="hidden" class="idproveedor" name="idproveedor" value="<?=$proveedor->idproveedor?>"/>
										<input type="hidden" name="idcertificado" value="<?=$idcertificado?>"/>
										<div class="row container mt-1">
											<div class="col-12">
												<div class="form-row">
												</div>
											</div>
										</div>
									</form>-->
									<div class="container mx-auto">
										<div class="row">
											<div class="col-md-11 mt-4 mb-2 mx-auto">
												<!--<label for="btnbuscaIE" class="col-sm-12">&nbsp;</label>-->												
												<button type="button" data-toggle="modal" class="btn btn-narsa pull-right" id="modalCat" data-target="#modalCatadores">Buscar Catador</button>
												<div class="pull-right my-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
												<button type="button" data-toggle="modal" class="btn btn-narsa pull-right" id="modalRegCat" data-target="#modalRegCatador">Agregar Catador</button>
											</div>
										</div>
									</div>
									<div class="container-fluid mt-2 mb-3">
										<div class="row">
											<div style="overflow-x:hidden" class="col-12 col-md-8 mx-auto"> <!--class="table-responsive" -->
											<!--<div class="col-sm-12 mx-auto" style="overflow-x:scroll"><!--align-items-center text-center-->
												<table id="tablaSeleccionCatadores" class="table table-striped dt-responsive table-bordered display nowrap table-hover mb-0 mx-auto"></table>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<div class="row">
											<div class="col-md-12">
												<button class="btn btn-narsa" id="guardaCatadores">Guardar Catador</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr class="mt-0">
						<div class="iq-card-footer mb-3">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-narsa btn-cancelar">Volver</button>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal buscar catadores -->
					<div class="modal fade" id="modalCatadores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Seleccionar Catador</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<div class="container-fluid mt-2">
										<div class="row">
											<div class="col-12 mx-auto" style="overflow-x:auto">
											<!--<div class="col-sm-12 mx-auto" style="overflow-x:scroll"><!--align-items-center text-center-->
												<table id="tablaCatadores" class="table table-striped dt-responsive table-bordered display nowrap table-hover mb-0 mx-auto" style="width:100%">
													<thead><tr><th>ID</th><th>Documento</th><th>Nombres del Catador</th><th>nombres</th></tr></thead>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal buscar catadores -->
					<div class="modal fade" id="modalRegCatador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Registrar Catador</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<div class="container-fluid mt-2">
										<div class="row">
											<div class="col-12 mx-auto" style="overflow-x:auto">
												<div class="iq-card">
													<div class="iq-card-body">
														<form method="post" id="form_catador" action="<?=base_url()?>certificaciones/parametros/registrarcatador" class="needs-validation form-horizontal" novalidate="">
															<div class="form-row">
																<div class="row"><div class="ml-5 h4 text-danger mr-auto fallecido"></div></div>
																<div class="col-12 my-1">
																	<div class="row">
																		<label class="control-label col-md-6 align-self-center mb-0" for="tipodoc">Tipo de Documento:</label>
																		<div class="col-md-6">
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
																		<label class="control-label col-md-6 align-self-center mb-0" for="doc">N&uacute;mero de Documento:</label>
																		<div class="col-md-4">
																			<div class="row">
																				<input type="text" class="form-control doc borra num numcurl" maxlength="8" minlength="8" name="doc" id="doc" autocomplete="off"
																					placeholder="Nro. Documento" required="" />
																				<div class="invalid-feedback" id="error-doc">Documento requerido</div>
																			</div>
																		</div>
																		<div class="col-md-2 col-lg-1 px-0 mt-3 mt-lg-0 align-self-center">
																			<button type="button" class="btn btn-info btn-small btn_curl col-12 align-self-center"><i class="fa fa-search" aria-hidden="true"></i></button>
																		</div>
																		<!--<label class="form_error error_curl col-md-4 my-0"></label>-->
																		<input type="hidden" name="tabla" id="tabla" value="catador" />
																	</div>
																	<div class="row mt-3">
																		<label class="control-label col-md-6 align-self-center mb-0" for="nombres">Nombres:</label>
																		<div class="col-md-6">
																			<div class="row">
																				<input type="text" class="form-control borra nombres" name="nombres" id="nombres" placeholder="Nombres" required="" readonly />
																				<div class="invalid-feedback" id="error-doc">Campo requerido</div>
																			</div>
																		</div>
																	</div>
																	<div class="row mt-3">
																		<label class="control-label col-md-6 align-self-center mb-0" for="apellidos">Apellidos:</label>
																		<div class="col-md-6">
																			<div class="row">
																				<input type="text" class="form-control borra apellidos" name="apellidos" id="apellidos" placeholder="Apellidos" required="" readonly />
																				<div class="invalid-feedback">Campo requerido</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-sm-12 py-2"><button type="submit" class="btn btn-narsa" id="btnEnviar">Registrar</button></div>
																</div>
															</div>
														</form>	
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>