						<? $usuario = json_decode($this->session->userdata('user')); ?>
						<div class="col-12 card px-0 my-3">
							<div class="card-body">
								<h4 class="">Listado General de Usuarios del Sistema</h4>
								<hr>
								<div class="row justify-content-center">
									<?if($this->session->flashdata('claseMsg')){?><div class="alert <?=$this->session->flashdata('claseMsg')?> py-1 px-5 msg fade show" role="alert">
										<div class="iq-alert-text"><?=$this->session->flashdata('flashMessage')?></div>
									</div><?}?>
									<div class="col-md-12 text-center resp" style="font-size:1.3em">&nbsp;</div>
								</div>
								<div class="container-fluid">
									<div class="row">
										<div class="col-12 mx-auto" style="overflow-x:auto">
											<table id="tablaUsuarios" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
										</div>
									</div>
								</div>
							</div>
						</div><!--Anular-->
						<!-- Modal Permisos -->
						<div class="modal fade" id="modalPermisos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="myModalLabel">Asignar Permisos</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									</div>
									<form method="POST" id="form_permisos">
										<input type="hidden" id="idusuarioPer" name="idusuarioPer" value="" />
										<div class="modal-body" style="overflow: hidden;">
											<div class="row col-sm-12">
												<div class="container">
													<div class="row">
														<div class="col-sm-12">
															<ul class="nav nav-tabs" role="tablist">
																<li class="nav-item"><a class="nav-link active" role="tab" data-toggle="tab" href="#usuarios">Usuarios</a></li>
																<li class="nav-item"><a class="nav-link" role="tab" data-toggle="tab" href="#locadores">Locadores</a></li>
															</ul>
															<div class="tab-content mt-3">
																<div id="usuarios" class="tab-pane fade in active show">
																	<!--<div class="clearfix"></div>-->
																	<div class="row my-2">
																		<div class="col-md-4">
																			<h5 class="my-2 ml-3 font-weight-bold">Permisos Men&uacute;s</h5>
																		<?php 
																				$i = 1; $subnivel = []; $j = 0;
																				foreach($usuario->menugeneral as $row):
																					if($row->idmodulo === '1'){
																						if($row->nivel === '1'){ $subnivel[$j] = $row->idmenu; $j++; }
																			?>
																			<div class="custom-control custom-switch col-12 ml-3">
																				<input type="checkbox" class="custom-control-input menus" name="menus[]" data-nivel="<?=$row->nivel?>"
																					value="<?=$row->idmenu?>" id="checkMenusUser<?=$i?>" data-menu="<?=$row->idmenu?>" >
																				<label class="custom-control-label" for="checkMenusUser<?=$i?>">&nbsp;&nbsp;<?=$row->descripcion?></label>
																			</div>
																		<?php
																						$i++;
																					}
																				endforeach;?>
																		</div>
																		<div class="col-md-4">
																			<h5 class="my-2 ml-3 font-weight-bold">Permisos Submen&uacute;s</h5>
																		<?php 
																				$i = 1; $submenu = false;
																				foreach($usuario->submenugeneral as $row):
																					for($k = 0;$k < count($subnivel);$k++){ if($subnivel[$k] === $row->idmenu && $row->activo === '1') $submenu = true; }
																					if($submenu){
																			?>
																			<div class="custom-control custom-switch col-12 ml-3">
																				<input type="checkbox" class="custom-control-input submenu" name="submenus[]"
																					value="<?=$row->idmenudetalle?>" id="checkSubMenusUser<?=$i?>" data-submenu="<?=$row->idmenu?>">
																				<label class="custom-control-label" for="checkSubMenusUser<?=$i?>">&nbsp;&nbsp;<?=$row->descripcion?></label>
																			</div>
																		<?php
																						$i++;
																					}
																				endforeach;?>
																		</div>
																		<div class="col-md-4">
																			<h5 class="my-2 ml-3 font-weight-bold">Permisos Acciones</h5>
																		<?php 
																				$i = 1;
																				foreach($permisos as $row):
																					if($row->idmodulo === '1'){
																			?>
																			<div class="custom-control custom-switch col-12 ml-3">
																				<input type="checkbox" class="custom-control-input permisos" name="permisos[]" value="<?=$row->idpermiso?>" id="checkPermisosUser<?=$i?>">
																				<label class="custom-control-label" for="checkPermisosUser<?=$i?>">&nbsp;&nbsp;<?=$row->descripcion?></label>
																			</div>
																		<?php
																						$i++;
																					}
																				endforeach;?>
																		</div>
																	</div>
																</div>
																<div id="locadores" class="tab-pane fade in">
																	<div class="row my-2">
																		<div class="col-md-4">
																			<h5 class="my-2 ml-3 font-weight-bold">Permisos Men&uacute;s</h5>
																		<?php 
																				$i = 1; $subnivel = []; $j = 0;
																				foreach($usuario->menugeneral as $row):
																					if($row->idmodulo === '2'){
																						if($row->nivel === '1'){ $subnivel[$j] = $row->idmenu; $j++; }
																			?>
																			<div class="custom-control custom-switch col-12 ml-3">
																				<input type="checkbox" class="custom-control-input menus" name="menus[]" data-nivel="<?=$row->nivel?>"
																					value="<?=$row->idmenu?>" id="checkMenuslocadores<?=$i?>" data-menu="<?=$row->idmenu?>" >
																				<label class="custom-control-label" for="checkMenuslocadores<?=$i?>">&nbsp;&nbsp;<?=$row->descripcion?></label>
																			</div>
																		<?php
																						$i++;
																					}
																				endforeach;?>
																		</div>
																		<div class="col-md-4">
																			<h5 class="my-2 ml-3 font-weight-bold">Permisos Submen&uacute;s</h5>
																		<?php 
																				$i = 1; $submenu = false;
																				foreach($usuario->submenugeneral as $row):
																					for($k = 0;$k < count($subnivel);$k++){ if($subnivel[$k] === $row->idmenu && $row->activo === '1') $submenu = true; }
																					if($submenu){
																			?>
																			<div class="custom-control custom-switch col-12 ml-3">
																				<input type="checkbox" class="custom-control-input submenu" name="submenus[]"
																					value="<?=$row->idmenudetalle?>" id="checkSubMenuslocadores<?=$i?>" data-submenu="<?=$row->idmenu?>">
																				<label class="custom-control-label" for="checkSubMenuslocadores<?=$i?>">&nbsp;&nbsp;<?=$row->descripcion?></label>
																			</div>
																		<?php
																						$i++;
																					}
																				endforeach;?>
																		</div>
																		<div class="col-md-4">
																			<h5 class="my-2 ml-3 font-weight-bold">Permisos Acciones</h5>
																		  <?php
																				$i = 1;
																				foreach($permisos as $row):
																					if($row->idmodulo === '2'){
																			?>
																			<div class="custom-control custom-switch col-12 ml-3">
																				<input type="checkbox" class="custom-control-input permisos" name="permisos[]" value="<?=$row->idpermiso?>" id="checkAccioneslocadores<?=$i?>">
																				<label class="custom-control-label" for="checkAccioneslocadores<?=$i?>">&nbsp;&nbsp;<?=$row->descripcion?></label>
																			</div>
																			<?php
																						$i++;
																					}
																				endforeach;?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<div class="row">
												<div class="col-md-12">
													<button class="btn btn-narsa mr-3" data-dismiss="modal" id="cancelPer">Cancelar</button>
													<button type="submit" class="btn btn-narsa" data-dismiss="modal" id="asignarPer">Asignar Permisos</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>