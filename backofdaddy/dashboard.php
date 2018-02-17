<?php
	require_once 'library/config.php';
	require_once 'library/functions.php';
	echo ('<script type="text/javascript" src="library/customtc.js"></script>');
?>

	<section class="content-header">
		<h1>Dashboard<small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo WEB_ROOT_ADMIN ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Dashboard</li>
		</ol>
    </section>
	<!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box bg-aqua">
					<span class="info-box-icon">
						<img src="<?php echo WEB_ROOT_TEMPLATE; ?>/images/icon/off-set-printing.png" alt="off-set-printing" />
					</span>
					<div class="info-box-content">
						<span class=""><p>Off-set Printing<br>(Id-1)</p></span>
						<span class="info-box-number pull-right"><?php totalOffSetPrinting($dbConn); ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box bg-red">
					<span class="info-box-icon">
						<img src="<?php echo WEB_ROOT_TEMPLATE; ?>/images/icon/digital-printing.png" alt="digital-printing" />
					</span>
					<div class="info-box-content">
						<span class=""><p>Digital Printing<br>(Id-2)</p></span>
						<span class="info-box-number pull-right"><?php totalDigitalPrinting($dbConn);?></span>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box bg-green">
					<span class="info-box-icon">
						<img src="<?php echo WEB_ROOT_TEMPLATE; ?>/images/icon/outdoor-Indoor-branding.png" alt="outdoor-Indoor-branding" />
					</span>
					<div class="info-box-content">
						<span class=""><p>Outdoor & Indoor Branding (Id-3)</p> </span>
						<span class="info-box-number pull-right"><?php totalOutdoorIndoor($dbConn);?></span>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box bg-yellow">
					<span class="info-box-icon">
						<img src="<?php echo WEB_ROOT_TEMPLATE; ?>/images/icon/promotional-giveaways.png" alt="promotional-giveaways" />
					</span>
					<div class="info-box-content">
						<span class=""><p>Promotional Giveaways (Id-4)</p></span>
						<span class="info-box-number pull-right"><?php totalPromotionalGiveaways($dbConn);?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3><?php totalProduct($dbConn); ?></h3>
						<p>Total Product</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<a href="<?php echo WEB_ROOT_ADMIN . "product" ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-red">
					<div class="inner">
						<h3><?php totalClients($dbConn); ?></h3>
						<p>Total Client's</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<a href="<?php echo WEB_ROOT_ADMIN . "client" ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-green">
					<div class="inner">
						<h3><?php totalPipeline($dbConn); ?></h3>
						<p>Current Pipeline</p>
					</div>
					<div class="icon">
						<i class="ion ion-pie-graph"></i>
					</div>
					<a href="<?php echo WEB_ROOT_ADMIN . "pipeline" ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3><?php totalVariationType($dbConn); ?></h3>
						<p>Variation Type</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<a href="<?php echo WEB_ROOT_ADMIN . "variationtype" ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3><?php totalVender($dbConn); ?></h3>
						<p>Total Vender</p>
					</div>
					<div class="icon">
						<i class="fa fa-user"></i>
					</div>
					<a href="<?php echo WEB_ROOT_ADMIN . "vender" ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-red">
					<div class="inner">
						<h3><?php totalBank($dbConn); ?></h3>
						<p>Total Banks</p>
					</div>
					<div class="icon">
						<i class="fa fa-bank"></i>
					</div>
					<a href="<?php echo WEB_ROOT_ADMIN . "bank" ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-green">
					<div class="inner">
						<h3><?php totalTestimonial($dbConn); ?></h3>
						<p>Total Testimonial</p>
					</div>
					<div class="icon">
						<i class="fa fa-user"></i>
					</div>
					<a href="<?php echo WEB_ROOT_ADMIN . "testimonial" ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>


		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6" style="overflow-y: auto; min-height: 10px;max-height: 400px;">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Your Task</h3>
						<?php if(modPerAdd($dbConn,"10")){?>
						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<div class="input-group-btn">
									<button type="button" class="btn btn-default create_task">Create Task</button>
								</div>
							</div>
						</div>
						<?php }?>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tbody>
							<?php
							$userTasks = getTasksByUser($dbConn,$_SESSION['userId']);
							if($userTasks != false) {
							?>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>Task</th>
								<th>Due Date</th>
								<th>Accept</th>
								<th>Done</th>
							</tr>
							<?php
								foreach (@$userTasks as $userTask) {
									extract($userTask)
									?>
									<tr>
										<td><?=$task_id?></td>
										<td><?=$date?></td>
										<?php 
											$taskcolor='';
											
											if($is_accept==0 && $status==0){
												$taskcolor="blue";
											}
											if($due_date < date('Y-m-d H:i:s') ){
												$taskcolor="red";
											}
										?>
										
										<td><font color= <?=$taskcolor?> > <?=$tasks?>  </font></td>

										
										<td><?=$due_date?></td>
									<?php 
										if($is_accept==0)
											$acceptTaskIcon='fa fa-check';
										else if ($is_accept==1)
											$acceptTaskIcon='';
									?>
									<td><a href="<?=WEB_ROOT_ADMIN?>users/processAdmin.php?action=updateTask&taskId=<?=$task_id?>"><span class="<?=$acceptTaskIcon?>"></span></a></td>
									<td><a href="<?=WEB_ROOT_ADMIN?>users/processAdmin.php?action=com&taskId=<?=$task_id?>"><span class="fa fa-check"></span></a></td>
									</tr>
									<?php
								}
							}else{
								echo "<div class='alert alert-danger'>No Task Found</div>";
							}
							?>
							</tbody>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<div class="col-xs-6 col-sm-6 create_task_view hidden">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Create Task</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
						<form method="post" action="<?=WEB_ROOT_ADMIN?>users/processAdmin.php?action=addTask">
							<table class="table table-hover">
							<tbody>
							<tr>
								<th>Users</th>
								<td>
									<select name="userId" class="input-sm">
										<?php
										 $users = getUsers($dbConn);
										foreach($users as $key=>$value){
											?>
											<option value="<?=$key?>"><?=$value?></option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<th>Task</th>
								<td><textarea type="text" font color="blue" class="text input-lg" name="task" required></textarea></td>
							</tr>
							<tr>
								<th>Due Date</th>
								<td> <input style="line-height:15px;" id="due_date" type="datetime-local" name="due_date" required></td>
							</tr>
							<tr>
								<td colspan="2"><input type="submit" class="btn btn-default" value="Add"></td>
							</tr>
							</tbody>
						</table>
						</form>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<?php if(modPerAdd($dbConn,"10")){?>
			<div class="col-xs-6 col-sm-6 all_task_view" style="overflow-y: auto; min-height: 10px;max-height: 400px;">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">All User Task</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tbody>
							<?php
							$tasks = gettasks($dbConn);
							if($tasks != false){
								?>
								<tr>
									<th>No</th>
									<th>User Name</th>
									<th>Date</th>
									<th>Task</th>
									<th>Action</th>
								</tr>
								<?php
								foreach ($tasks as $task){
									extract($task);
									?>
									<tr>
										<td><?=$task_id?></td>
										<td><?=getUserNameById($dbConn,$user_id)?></td>
										<td><?=$date?></td>
										<td><?=$tasks?></td>
										<td><?php if($status == 0){?><a href="<?=WEB_ROOT_ADMIN?>users/processAdmin.php?action=com&taskId=<?=$task_id?>"><span class="fa fa-check"></span></a><?php }else{echo"Done";}?><a href="<?=WEB_ROOT_ADMIN?>users/processAdmin.php?action=del&taskId=<?=$task_id?>"><span class="fa fa-close"></span></a></td>
									</tr>
									<?php
								}
							}else{
								echo "<div class='alert alert-danger'>No Task Found</div>";
							}
							?>
							</tbody>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<?php }?>
		</div>
		<div class="row" style="padding-top:20px;">
			<div class="col-xs-12 col-sm-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title pull-left">Attendance</h3>
						<div class="box-tools">
							<h3 class="box-title pull-right"><?=date("M-Y")?></h3>
							<?php if(modPerAdd($dbConn,"10")){?>
							<div class="dropdown btn btn-default pull-left">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">User Attendance<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<?php
									$users = getUsers($dbConn);
									foreach($users as $key=>$value){
										?>
										<li><a href="<?=WEB_ROOT_ADMIN?>index.php?id=<?=$key?>"><?=$value?></a></li>
										<?php
									}
									?>
								</ul>
							</div>
							<div class="input-group input-group-sm" style="width: 150px;">
								<div class="input-group-btn">
									<button type="button" class="btn btn-default at_mark">Mark Attendance</button>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<?php
						$j = date('d');
						for($i=1; $i<=$j; $i++){
							?>
							<div class="pull-left panel-body">
								<?php
								if(isset($_GET['id'])){
									$id = $_GET['id'];
								}else{
									$id = $_SESSION['userId'];
								}
							echo "$i";
								$atts = getAttByUser($dbConn,$id);
								if($atts != false){
									foreach($atts as $att){
										extract($att);
										if($day == $i){
											echo "<br>$attendance <br> $time";
										}
									}
								}else{
									echo "<br>Not Found";
								}
								?>
							</div>
						<?php
						}
						?>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 mark_at_show hidden">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Mark</h3>
						<h3 class="box-title pull-right"><?=date("d-M-Y")?></h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form method="post" action="<?=WEB_ROOT_ADMIN?>users/processAdmin.php?action=atn">
							<table class="table table-hover">
								<tbody>
								<tr>
									<th>Users</th>
									<td>
										<select name="userId" class="input-sm">
											<?php
											$users = getUsers($dbConn);
											foreach($users as $key=>$value){
												?>
												<option value="<?=$key?>"><?=$value?></option>
												<?php
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<th>Attand</th>
									<td>
										<select name="att" onchange="showHideSpendHours(this)">
											<option value="P">Present</option>
											<option value="L">Leave</option>
											<option value="A">Absent</option>
											<option value="H">Half Leave</option>
											<option value="S" >Spend Hours</option>
										</select>
									</td>
									<th>Spend Hours</th>
									<td>
										<input id="spend_hours" type="number" name="spend_hours" min="0" max="12" />
									</td>
								</tr>
								<tr>
									<td colspan="2"><input type="submit" class="btn btn-default" value="Add"></td>
								</tr>
								</tbody>
							</table>
						</form>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
    </section>
	  <script>
		  $(document).ready(function(){
			  $(".create_task").click(function(){
				  $(".create_task_view").toggleClass("hidden");
			  })

			  $(".at_mark").click(function(){
				  $(".mark_at_show").toggleClass("hidden");
			  })
		  });
	  </script>
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  