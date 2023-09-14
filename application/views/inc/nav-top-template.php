		<? $usuario = json_decode($this->session->userdata('user')); ?>
		<div class="iq-top-navbar">
            <div class="iq-navbar-custom">
				<nav class="navbar navbar-expand-lg navbar-light p-0">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<i class="ri-menu-3-line font-sabogal"></i>
					</button>
					<div class="iq-menu-bt align-self-center">
						<div class="wrapper-menu">
							<div class="main-circle"><i class="ri-more-fill"></i></div>
							<div class="hover-circle"><i class="ri-more-2-fill"></i></div>
						</div>
					</div>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto navbar-list">
							<li class="nav-item iq-full-screen">
							   <a href="#" class="iq-waves-effect" id="btnFullscreen"><i class="ri-fullscreen-line font-sabogal"></i></a>
							</li>
							<li class="nav-item">
								<ul class="navbar-list">
									<li>
										<a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
											<img src="<?=base_url()?>public/images/perfil/<?=$usuario->avatar;?>" class="img-fluid rounded mr-3 top-avatar" alt="user">
											<div class="caption">
												<h6 class="mb-0 line-height font-size-14"><?=$usuario->nombres." ".$usuario->apellidos?></h6>
												<span class="font-size-12 font-sabogal">Disponible</span>
											</div>
										</a>
										<div class="iq-sub-dropdown iq-user-dropdown">
											<div class="iq-card shadow-none m-0">
												<div class="iq-card-body p-0 ">
													<div class="wrapper p-3">
														<h5 class="mb-0 text-white line-height"><?=$usuario->nombres." ".$usuario->apellidos?></h5>
														<span class="text-white font-size-12">Disponible</span>
													</div>
													<a href="<?=base_url();?>main/perfil" class="iq-sub-card sabogal-bg-primary-hover">
														<div class="media align-items-center">
															<div class="rounded iq-card-icon sabogal-bg-primary">
																<i class="ri-file-user-line"></i>
															</div>
															<div class="media-body ml-3">
																<h6 class="mb-0">Mi Perfil de Usuario</h6>
																<p class="mb-0" style="font-size:0.75rem">Cambiar mi clave y/o Foto de Perfil</p>
															</div>
														</div>
													</a>
													<div class="d-inline-block w-100 text-center p-3">
														<a class="btn btn-sabogal" href="<?=base_url()?>logout" role="button">Cerrar Sesi&oacute;n<i class="ri-login-box-line ml-2"></i></a>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</div>