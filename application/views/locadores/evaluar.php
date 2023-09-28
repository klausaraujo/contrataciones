						<? $usuario = json_decode($this->session->userdata('user')); ?>
						<div class="col-12 card px-0 my-3">
							<div class="card-body">
								<h4 class="">Evaluaci&oacute;n de Postulaciones</h4>
								<hr>
								<div class="row justify-content-center">
									<div class="col-md-12 text-center resp" style="font-size:1.3em"></div>
								</div>
								<div class="container-fluid">
									<div class="row">
										<div class="col-12 mx-auto" style="overflow-x:auto">
											<table id="tablaEval" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
										</div>
									</div>
									<div class="container-fluid row"><hr class="col-sm-12"></div>
									<div class="row">
										<button type="reset" class="btn btn-cancel btn-cancelar ml-auto mr-3">Cancelar</button>
										<input type="button" class="btn btn-sabogal" id="evaluar" value="Guardar y Cerrar" />
									</div>
								</div>
							</div>
						</div>