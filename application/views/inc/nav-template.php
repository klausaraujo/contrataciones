		<? $usuario = json_decode($this->session->userdata('user')); ?>
		<div class="iq-sidebar">
            <div class="iq-sidebar-logo d-flex justify-content-between">
				<a href="<?=base_url()?>"><img src="<?=base_url()?>public/images/logo-white.png" class="img-fluid" alt=""><span>NARSA</span></a>
				<div class="iq-menu-bt-sidebar">
                    <div class="iq-menu-bt align-self-center">
                        <div class="wrapper-menu">
							<div class="main-circle"><i class="ri-more-fill"></i></div>
							<div class="hover-circle"><i class="ri-more-2-fill"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sidebar-scrollbar">
				<nav class="iq-sidebar-menu">
					<ul id="iq-sidebar-toggle" class="iq-menu">
						<li class="iq-menu-title"><i class="ri-subtract-line"></i><span>Panel de Navegaci&oacute;n</span></li>
						<li class="<?php echo $this->uri->segment(1) == '' ? 'active main-active': ''; ?>" >
							<a href="<?=base_url()?>" class="iq-waves-effect"><i class="ri-home-8-fill"></i><span>Inicio</span></a>
						</li>
						<?php 
							if($this->uri->segment(1) == '') {
								$listaModulos = $usuario->modulos;
								foreach($listaModulos as $row): ?>
							<li>
							<?php	if($row->activo > 0 && ! empty($usuario->sucursales)){ ?>
							<a href="<?=base_url().$row->url?>" class="iq-waves-effect">
								<i class="<?=$row->mini?>" aria-hidden="true"></i>
								<span><?=$row->menu?></span>
							</a>
							<?php 	}else { ?>
								<span class="disable">
									<div class="pull-left">
										<i class="<?=$row->mini?> mr-20" aria-hidden="true"></i>
										<span class="right-nav-text"><?=$row->menu?></span>
									</div>
									<div class="clearfix"></div>
								</span>
							<?php 	} ?>
							</li>
						<?php 	endforeach;
							}else{
						
							$lMenu = $usuario->menus;
							$lMod = $usuario->modulos;
							$submenu = $usuario->submenus;
							
							$idModulo = ""; $i = 0;
							foreach($lMod as $row): if($row->url === $this->uri->segment(1)) $idModulo = $row->idmodulo; endforeach;
							if(!empty($lMenu)){
								foreach($lMenu as $row):
									if($row->idmodulo === $idModulo){
								?>
								<li id="menu<?=$row->idmenu?>">
								<?  if($row->nivel === '0'){
										if($row->activo === '1'){ ?>
									<a href="<?=base_url().$row->url?>" id="linkAjax">
										<div class="pull-left">
											<i class="<?=$row->icono?> mr-20"></i>
											<span class="right-nav-text"><?=$row->descripcion?></span>
										</div>
										<!--<div class="clearfix"></div>-->
									</a>
									<?php 	}else{ ?>	
									<span class="disable">
										<div class="pull-left">
											<i class="<?=$row->icono?> mr-20"></i>
											<span class="right-nav-text"><?=$row->descripcion?></span>
										</div>
										<!--<div class="clearfix"></div>-->
									</span>
									<?php }							
									}else{ ?>
									<a href="javascript:void(0);" data-toggle="collapse" data-target="#sub_<?=$row->idmenu?>">
										<div class="pull-left">
											<i class="<?=$row->icono?>  mr-20"></i>
											<span class="right-nav-text"><?=$row->descripcion?></span>
										</div>
										<!--<div class="clearfix"></div>-->
									</a>
									<?//if($row->nivel === '1'){?>
										<div class="submenu-1">
											<ul id="sub_<?=$row->idmenu?>" class="collapse collapse-level-1 pb-1 pl-1">
											<?  foreach($submenu as $srow):
													if($row->idmenu === $srow->idmenu){ ?>
												<li><a href="<?=$srow->url?>" rel=""><i class="<?=$srow->icono?> mr-20"></i><?=$srow->descripcion?></a></li>
													<?}
												endforeach; ?> 
											</ul>
										</div>
									<?  } ?>
								</li>
								<?php
									}
								endforeach;
							}
							}
					  ?>
						<!--<li>
							<a href="#" class="iq-waves-effect"><i class="ri-hospital-fill"></i><span>Doctor Dashboard</span></a>
						</li>
						<li>
							<a href="#" class="iq-waves-effect"><i class="ri-home-8-fill"></i><span>Hospital Dashboard 1 </span></a>
						</li>
						<li>
							<a href="#" class="iq-waves-effect"><i class="ri-briefcase-4-fill"></i><span>Hospital Dashboard 2</span></a>
						</li>
						<li class="iq-menu-title"><i class="ri-subtract-line"></i><span>Components</span></li>
						<li>
							<a href="#ui-elements" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-apps-fill"></i><span>UI Elements</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
							<ul id="ui-elements" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
								<li><a href="ui-colors.html"><i class="ri-font-color"></i>colors</a></li>
							</ul>
						</li>-->
                    </ul>
				</nav>
				<div class="p-3"></div>
            </div>
        </div>