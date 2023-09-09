<?					
					$usuario = json_decode($this->session->userdata('user'));
					$titulo = '';
					if($this->uri->segment(2) === 'reporte1') $titulo = 'Reporte de Art&iacute;culos Ingresados';
					if($this->uri->segment(2) === 'reporte2') $titulo = 'Reporte de Art&iacute;culos Valorizados';
					if($this->uri->segment(2) === 'reporte3') $titulo = 'Reporte de Art&iacute;culos por Valorizar';
					if($this->uri->segment(2) === 'reporte4') $titulo = 'Reporte de Cuentas por Cobrar';
					if($this->uri->segment(2) === 'reporte5') $titulo = 'Reporte de Cuentas por Pagar';
?>
					<div class="col-12 card px-0 my-3">
						<input type="hidden" id="segmento" value="<?=$this->uri->segment(2)?>" />
						<div class="card-body">
							<h4 class=""><?=$titulo?></h4>
							<input id="reportename" type="hidden" value="<?=$this->uri->segment(2)?>" />
							<hr>
					<?	if($this->uri->segment(2) === 'reporte1' || $this->uri->segment(2) === 'reporte2' || $this->uri->segment(2) === 'reporte3'){	?>
							<div class="row reporte1">
								<div class="col-md-11 mx-auto">
									<div class="row">
										<div class="col-md-4">
											<div class="row">
												<label class="control-label col-md-4 align-self-center mb-0 text-left" for="sucursal">&nbsp;&nbsp;&nbsp;Sucursal:</label>
												<div class="col-md-8">
													<select class="form-control form-control-sm sucursal" name="sucursal" id="sucursal">
													<? foreach($usuario->sucursales as $row): ?>
														<option value="<?=$row->idsucursal;?>"><?=$row->sucursal;?></option>	
													<? endforeach;	?>
													</select>
												</div>
											</div>
										</div>									
										<div class="col-md-3">
											<div class="row">
												<label class="control-label col-md-4 align-self-center mb-0" for="anio">A&ntilde;o:</label>
												<div class="col-md-8">
													<select class="form-control form-control-sm anio" name="anio" id="anio">
												<? foreach($anio as $row): ?>
														<option value="<?=$row->anio?>" <?=date('Y') === $row->anio? 'selected' : '';?> ><?=$row->anio;?></option>	
												<? endforeach;	?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="row">
												<label class="control-label col-md-4 align-self-center mb-0" for="articulo">&nbsp;&nbsp;&nbsp;Art&iacute;culo:</label>
												<div class="col-md-8">
													<select class="form-control form-control-sm articulo" name="articulo" id="articulo">
														<option value=""> -- Todos -- </option>	
													<? foreach($articulo as $row): ?>
														<option value="<?=$row->articulo?>" ><?=$row->articulo;?></option>	
													<? endforeach;	?>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-md-2">
											<label class="control-label align-self-center mb-0 text-left" for="productor">&nbsp;&nbsp;&nbsp;Productor:</label>
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm productor" name="productor" id="productor" placeholder="Productor" readonly />
										</div>
										<div class="col-md-2 pr-0">
											<a type="button" class="btn btn-small bg-success align-self-center text-small text-white" data-toggle="modal" 
														data-target="#modalProveedores" id="buscar">Buscar</a>
										</div>
										<div class="col-md-3 px-0">
											<a type="button" class="btn btn-narsa align-self-center text-white" id="generar">Generar Reporte</a>
										</div>
									</div>
								</div>
							</div>
					<?	}else{	?>
							<div class="row">
								<div class="col-md-12 mx-auto">
									<div class="row">
										<div class="col-md-4">
											<div class="row">
												<label class="control-label col-md-4 align-self-center mb-0 text-left" for="sucursal">&nbsp;&nbsp;&nbsp;Sucursal:</label>
												<div class="col-md-8">
													<select class="form-control form-control-sm sucursal" name="sucursal" id="sucursal">
													<? foreach($usuario->sucursales as $row): ?>
														<option value="<?=$row->idsucursal;?>"><?=$row->sucursal;?></option>	
													<? endforeach;	?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="row">
												<label class="control-label col-md-4 align-self-center mb-0" for="productor">&nbsp;&nbsp;&nbsp;Productor:</label>
												<div class="col-md-8">
													<input type="text" class="form-control form-control-sm productor" name="productor" id="productor" placeholder="Productor" readonly />
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="row">
												<div class="col-md-4">
													<a type="button" class="btn btn-small bg-success align-self-center text-small" data-toggle="modal" 
														data-target="#modalProveedores" id="buscar">Buscar</a>
												</div>
												<div class="col-md-8">
													<a type="button" class="btn btn-narsa align-self-center text-white" id="generar">Generar Reporte</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
				<?	}	?>
							<hr>
							<div class="container-fluid">
								<div class="row"> <!--class="table-responsive" -->
									<a href="#" class="btn btn-danger align-self-center ml-3 exportar" id="pdf" target="_blank" title="Exportar a PDF" >
										<i class="fa fa-file-pdf-o mr-0" aria-hidden="true" style="font-size:1.2em"></i>
									</a>
									<a href="#" class="btn btn-success align-self-center ml-1 exportar" id="excel" title="Exportar a EXCEL" >
										<i class="fa fa-file-excel-o mr-0" aria-hidden="true" style="font-size:1.2em"></i>
									</a>
									<div class="col-12 mx-auto mt-md-2" style="overflow-x:auto">
									<?	if($this->uri->segment(2) === 'reporte1' || $this->uri->segment(2) === 'reporte2' || $this->uri->segment(2) === 'reporte3'){	?>
										<table id="tablaReporte1" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
									<?	}elseif($this->uri->segment(2) === 'reporte4' || $this->uri->segment(2) === 'reporte5'){	?>
										<table id="tablaReporte2" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
									<?	}elseif($this->uri->segment(2) === 'reporte6'){	?>
										<table id="tablaReporte3" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
									<?	} ?>
									</div>
								</div>
							</div>
						</div>
						<!--</div>-->
					</div>
						
					<!-- Modal proveedores -->
					<div class="modal fade" id="modalProveedores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Elegir Productor</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<div class="container-fluid">
										<div class="row">
											<div class="col-12 mx-auto" style="overflow-x:auto">
												<table id="tablaProveedores" class="table table-striped dt-responsive table-bordered display nowrap table-hover mb-0 mx-0" style="width:100%">
													<thead><tr><th>Item</th><th>Nombre del Productor</th><th>nro doc</th><th>finca</th><th>altitud</th></tr></thead>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>