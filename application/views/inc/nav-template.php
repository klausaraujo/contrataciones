		<? $usuario = json_decode($this->session->userdata('user')); ?>
		<div class="iq-sidebar">
            <div class="iq-sidebar-logo d-flex justify-content-between">
				<a href="<?=base_url()?>"><img src="<?=base_url()?>public/images/logo-white.png" class="img-fluid" alt=""><span>R.P.S.</span></a>
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
						<li class="<?=$this->uri->segment(1) == '' ? 'active main-active': ''; ?>" >
							<a href="<?=base_url()?>" class="iq-waves-effect"><i class="ri-home-8-fill"></i><span>Inicio</span></a>
						</li>
				<? 
						$idmodulo = '';
						if($this->uri->segment(1) == ''){
							foreach($usuario->modulos as $row): ?>
						<li>
				<?				if($row->activo > 0){ ?>
							<a href="<?=base_url().$row->url?>" class="iq-waves-effect"><i class="<?=$row->mini?>" aria-hidden="true"></i><span><?=$row->menu?></span></a>
				<?				}else { ?>
							<span class="disable"><div class="pull-left">
								<i class="<?=$row->mini?> mr-20" aria-hidden="true"></i><span class="right-nav-text"><?=$row->menu?></span></div>
								<div class="clearfix"></div>
							</span>
						
				<?				} ?>
						</li>
				<?			endforeach;
						}else{
						// Area del bucle del menu
							foreach($usuario->modulos as $row): if($row->url === $this->uri->segment(1)) $idmodulo = $row->idmodulo; endforeach;
								
							$permiso = false; $subpermiso = false;
								
							foreach($usuario->menugeneral as $row):
								if($idmodulo === $row->idmodulo){	?>
						<li>
				<?					foreach($usuario->menus as $fila): if($fila->idmenu === $row->idmenu && $fila->activo === '1') $permiso = true; endforeach;
									if($permiso && $row->activo === '1'){
										if($row->nivel === '0'){
				?>
							<a href="<?=base_url().$row->url?>" class="iq-waves-effect"><i class="<?=$row->icono?>"></i><span><?=$row->descripcion?></span></a>
				<?						}else{	?>
						<!-- Area de submenus -->
							<a href="#submenu_<?=$row->idmenu?>" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
								<i class="<?=$row->icono?>"></i><span><?=$row->descripcion?></span><i class="ri-arrow-right-s-line iq-arrow-right"></i>
							</a>
							<ul id="submenu_<?=$row->idmenu?>" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
				<?							foreach($usuario->submenugeneral as $row2):
												if($row2->idmenu === $row->idmenu){	?>
								<li>
				<?									foreach($usuario->submenus as $fila1):
														if($fila1->idmenudetalle === $row2->idmenudetalle && $fila1->activo === '1') $subpermiso = true;
													endforeach;
													if($subpermiso && $row2->activo === '1'){	?>
									<a href="<?=base_url().$this->uri->segment(1).'/'.$row2->url?>" style="color:#117428" ><i class="<?=$row2->icono?>"></i><?=$row2->descripcion?></a>
				<?									}else{	?>
									<span class="disable"><div class="pull-left">
										<i class="<?=$row2->icono?> mr-20" aria-hidden="true"></i><span class="right-nav-text"><?=$row2->descripcion?></span></div>
										<div class="clearfix"></div>
									</span>
									<!--<i class="<?=$row2->icono?>"></i><span><?=$row2->descripcion?></span>-->
				<?									}
												}
												$subpermiso = false;	?>
								</li>
				<?							endforeach;	?>	
							</ul>
						<!-- Fin del Area de submenus -->
				<?							}
									}else{	?>
							<span class="disable"><div class="pull-left">
								<i class="<?=$row->icono?> mr-20" aria-hidden="true"></i><span class="right-nav-text"><?=$row->descripcion?></span></div>
								<div class="clearfix"></div>
							</span>
							<!--<i class="<?=$row->icono?>"></i><span><?=$row->descripcion?></span>-->
				<?					}
								$permiso = false;
								}	?>
						</li>
				<?			endforeach;
						}	?>
						<!-- Fin del area del bucle del menu -->
                    </ul>
				</nav>
				<div class="p-3"></div>
            </div>
        </div>