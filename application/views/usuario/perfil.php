	<?php 
		$usuario = json_decode($this->session->userdata('user'));
		$imagen = $usuario->avatar;
	?>
	<div class="container-fluid my-3">
        <div class="row">
            <div class="card tab-perfil bg-sabogal">
				<div class="card-body"><h4 class="text-white">Modificar Perfil</h4></div>
			</div>
            <div class="col-lg-12">
                <div class="iq-edit-list-data">
                    <div class="tab-content">
						<div class="tab-pane fade active show" id="chang-pwd" role="tabpanel">
							<div class="iq-card-body">
								<div class="form-group row align-items-center">
									<div class="col-md-12">
										<div class="profile-img-edit">
                                       <?php if(strlen($imagen)>0){ ?>
											<img class="profile-pic" src="<?=base_url()?>public/images/perfil/<?=$imagen?>" alt="profile-pic">
                                       <?php }else{ ?>
											<img class="profile-pic" src="<?=base_url()?>public/images/perfil/user.jpg" alt="profile-pic">
                                       <?php } ?>
											<div class="p-image bg-sabogal">
												<i class="ri-pencil-line upload-button"></i>
												<form class="uploadFileAjax" enctype="multipart/form-data" method="post">
													<input name="perfil" class="file-upload" type="file" accept="image/*" />
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="iq-card">
								<div class="iq-card-header d-flex justify-content-between">
									<div class="iq-header-title"><h4 class="card-title">Cambiar Contraseña</h4></div>
								</div>
								<div class="iq-card-body">
									<form id="formPassword" name="formPassword" action="pass" method="POST">
										<input type="hidden" name="cod_usuario" value="<?=$usuario->idusuario?>" />
										<div class="col-sm-12 mt-3">
											<div class="row my-1">
												<span class="col-sm-3" style="display:flex;align-items:center"><label for="old_password">Contrase&ntilde;a Actual:</label></span>
												<input type="password" class="form-control col-sm-4 old_pass" name="old_password" id="old_password" autocomplete="off" />
											</div>
										</div>
										<div class="col-sm-12 mt-3">
											<div class="row my-1">
												<span class="col-sm-3" style="display:flex;align-items:center"><label for="password">Nueva Contrase&ntilde;a:</label></span>
												<input type="password" class="form-control col-sm-4 pass" name="password" id="password" autocomplete="off" />
											</div>
										</div>
										<div class="col-sm-12 mt-3">
											<div class="row my-1">
												<span class="col-sm-3" style="display:flex;align-items:center"><label for="re_password">Repetir Contrase&ntilde;a:</label></span>
												<input type="password" class="form-control col-sm-4 re_pass" name="re_password" id="re_password" autocomplete="off" />
											</div>
										</div>
										<div class="col-md-12 text-center pt-3 resp" style="font-size:1.3em">&nbsp;</div>
										<div class="row"><hr class="col-sm-11 mx-auto"></div>
										<button type="submit" class="btn btn-sabogal mr-2">Realizar Cambio</button>
									</form>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>