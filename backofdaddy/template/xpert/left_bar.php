	<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- Sidebar user panel -->
				<div class="user-panel">
					<div class="pull-left image">
						<img src="<?php echo WEB_ROOT_TEMPLATE;?>/dist/img/no_image.jpg" class="img-circle" alt="User Image" />
					</div>
					<div class="pull-left info">
						<p>Daddy Printers</p>
						<a href="#"><i class="fa fa-phone text-success"></i> 0321-8460888</a>
					</div>
				</div>
          
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu">
					<li class="header">MAIN NAVIGATION</li>
					<li class="active treeview">
						<a href="<?php echo WEB_ROOT_ADMIN ?>"><i class="fa fa-tachometer"></i> <span>DashBoard</span></a>
					</li>
					<?php
					if(modPerView($dbConn, "1")){ ?>
					<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "category" ?>">
								<i class="fa fa-list"></i>
								<span>Category</span>
								<span class="pull-right-container pull-right">
									<small class="label bg-aqua"><?php totalCategory($dbConn); ?></small>
								</span>
							</a>
						</li>
						<?php
					}
					if(modPerView($dbConn, "2")){ ?>
						<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "subcategory" ?>"><i class="fa fa-sitemap"></i> <span>Sub-Category</span></a>
						</li>
						<?php
					} 
					if(modPerView($dbConn, "3")){ ?>
						<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "variationtype" ?>">
								<i class="fa fa-bars"></i>
								<span>Variation Type</span>
								<span class="pull-right-container pull-right">
									<small class="label bg-red"><?php totalVariationType($dbConn); ?></small>
								</span>
							</a>
						</li> <?php
					} 
					if(modPerView($dbConn, "5")){ ?>
						<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "variation" ?>"><i class="fa fa-bars"></i> <span>Variation</span></a>
						</li>
						<?php
					} 
					if(modPerView($dbConn, "6")){ ?>
						<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "subvariation" ?>"><i class="fa fa-bars"></i> <span>Sub Variation</span></a>
						</li>
						<?php
					} 
					if(modPerView($dbConn, "7")){ ?>
						<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "product" ?>">
								<i class="fa fa-bars"></i>
								<span>Product</span>
								<span class="pull-right-container pull-right">
									<small class="label bg-green"><?php totalProduct($dbConn); ?></small>
								</span>
							</a>
						</li> <?php
					} 
					if(modPerView($dbConn, "8")){ ?>
						<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "quotation" ?>"><i class="fa fa-bars"></i> <span>Quotation</span></a>
						</li>
						<?php } if(modPerView($dbConn,"24")) {?>
					<li class="treeview">
						<a href="<?php echo WEB_ROOT_ADMIN . "order" ?>">
							<i class="fa fa-bars"></i>
							<span>Order Que Management</span></i>
						</a>
					</li>
					<?php } if(modPerView($dbConn,"18")) { ?>
						<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "order" ?>">
								<i class="fa fa-bars"></i>
								<span>Order</span><i class="fa fa-angle-left pull-right"></i>
							</a>
													<ul class="treeview-menu">
														<?php if(modPerView($dbConn,"19")){?>
														<li>
															<a href="<?php echo WEB_ROOT_ADMIN . "pending" ?>">
																<i class="fa fa-bars"></i>Inactive Quotation
															</a>
														</li>
														<?php } if(modPerView($dbConn,"20")){?>
<!--														<li>-->
<!--															<a href="--><?php //echo WEB_ROOT_ADMIN . "pipeline" ?><!--">-->
<!--																<i class="fa fa-bars"></i>Current Pipeline-->
<!--															</a>-->
<!--														</li>-->
														<?php } if(modPerView($dbConn, "21")){?>
														<li>
															<a href="<?php echo WEB_ROOT_ADMIN . "delivered" ?>">
																<i class="fa fa-bars"></i>Deliverd
															</a>
														</li>
														<?php }?>
													</ul>
						</li>
					<?php } if(modPerView($dbConn,"25")){?>
						<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "job" ?>"><i class="fa fa-bars"></i> <span>Job Order</span></a>
						</li>
					<?php } if(modPerView($dbConn,"26")){?>
						<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "bill" ?>"><i class="fa fa-bars"></i> <span>Bill</span></a>
						</li>
				<?php }	if(modPerView($dbConn,"13")){?>
					<li class="treeview">
						<a href="#">
							<i class="fa fa-users"></i>
							<span>User Management</span><i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<?php
							if(modPerView($dbConn, "9")){ ?>
								<li><a href="<?php echo WEB_ROOT_ADMIN . "webmodule"?>"><i class="fa fa-bars"></i>Modules</a></li>
								<?php
							} 
							if(modPerView($dbConn, "11")){ ?>
								<li><a href="<?php echo WEB_ROOT_ADMIN . "designation"?>"><i class="fa fa-bars"></i>Designation</a></li>
								<?php
							} 
							if(modPerView($dbConn, "12")){ ?>
								<li><a href="<?php echo WEB_ROOT_ADMIN . "role"?>"><i class="fa fa-bars"></i>Roles</a></li>
								<?php
							} ?>
						</ul>
					</li>
					<?php }
					if(modPerView($dbConn,"14")){ ?>
					<li class="treeview">
						<a href="<?php echo WEB_ROOT_ADMIN . "client" ?>">
							<i class="fa fa-user"></i>
							<span>Clients</span>
							<span class="pull-right-container pull-right">
								<small class="label bg-red"><?php totalClients($dbConn); ?></small>
							</span>
						</a>
					</li>
					<?php }
					if(modPerView($dbConn,"27")){ ?>
						<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "accounting" ?>">
								<i class="fa fa-bank"></i>
								<span>Accounting</span>
							</a>
						</li>
					<?php }
					if(modPerView($dbConn,"15")){?>
					<li class="treeview">
						<a href="#">
							<i class="fa fa-dollar"></i>
							<span>Accounts</span><i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<?php if(modPerView($dbConn,"22")){?>
							<li>
								<a href="<?php echo WEB_ROOT_ADMIN . "vender"?>">
									<i class="fa fa-circle"></i>
									Venders
									<span class="pull-right-container pull-right">
										<small class="label bg-blue"><?php totalVender($dbConn); ?></small>
									</span>
								</a>
							</li>
							<?php } if(modPerView($dbConn,"23")){?>
							<li>
								<a href="<?php echo WEB_ROOT_ADMIN . "bank"?>">
									<i class="fa fa-bank"></i>
									<span>Bank Detail</span>
									<span class="pull-right-container pull-right">
										<small class="label bg-red"><?php totalBank($dbConn); ?></small>
									</span>
								</a>
							</li>
							<?php } ?>
						</ul>
					</li>
					<?php }
					if(modPerView($dbConn,"16")) { ?>
						<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "testimonial" ?>">
								<i class="fa fa-user"></i>
								<span>Testimonial</span>
							<span class="pull-right-container pull-right">
								<small class="label bg-green"><?php totalTestimonial($dbConn); ?></small>
							</span>
							</a>
						</li>
						<?php
					}
					if(modPerView($dbConn, "10")){ ?>
						<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "users" ?>"><i class="fa fa-user-md"></i><span>USERS</span></a>
						</li>
						<?php
					}?>
					<?php
					if(modPerView($dbConn, "10")){ ?>
						<li class="treeview">
							<a href="<?php echo WEB_ROOT_ADMIN . "salary" ?>"><i class="fa fa-money"></i><span>Salary</span></a>
						</li>
				<?php
				
					}
					?>
				</ul>
			</section>
			<!-- /.sidebar -->
		</aside>
