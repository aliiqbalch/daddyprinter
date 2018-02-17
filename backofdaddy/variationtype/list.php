<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	
	$sql =  "SELECT * FROM tbl_variation_type ORDER BY var_type_id DESC";
	$result     = dbQuery($dbConn, $sql);
	
	
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Variation Type</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Variation Type</li>
		</ol>
    </section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			<?php
			if(modPerAdd($dbConn, "3")){ ?>
				<div class="row">
					<div class="col-md-6">
						<div style="margin: 10px 0px 0px 5px;">
							<button type="submit" name="btnButton"  class="butn" onclick="addVarType()"  ><i class="fa fa-plus"></i> Add Variation Type</button>
						</div>
					</div>
				</div>
				<?php
			}?>
			<div class="row" id="alertmsg" style="margin: 10px 0px 0px 5px;" >
				<?php 
				if(isset($_SESSION['errorMessage']) && isset($_SESSION['count'])){
					if($_SESSION['count'] <= 1){
						$_SESSION['count'] +=1; ?>
						<div style="min-height:10px;"></div>
						<div class="alert alert-<?php echo $_SESSION['data'];?>">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<?php echo $_SESSION['errorMessage'];  ?>
						</div> <?php
						unset($_SESSION['errorMessage']);
					}
				} ?>
			</div>
			<div class="row bord-right-space" >
				<div class="table-responsive tbl-respon">
					<table class="table table-bordered table-striped tbl-respon2">
						<thead>
							<tr>
								<th >Sr.No</th>
								<th >Title</th>
								<th >Type</th>
								<th >Description</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (dbNumRows($result) > 0) {
								$i = 1;
								while($row = dbFetchAssoc($result)){
									extract($row);
									 ?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?php echo $var_type_title;?></td>
										<td><?php 
										if($var_type_paper_meterial == 1){
											echo "Paper/Material";
										}
										if($var_type_sheet_depend == 1){
											echo ", Price Dependent on Printed Sheets";
										}else if($var_type_sheet_depend == 2){
											echo "Design";
										}
										if($var_type_is_addon == 1){
											echo ", Is AddON (optional)";
										}
										
										?></td>
										<td><?php echo $var_type_desc;?></td>
										<td>
											<?php if(modPerModify($dbConn,"3")){?>
											<a href="javascript:modifyVarType(<?php echo $var_type_id;?>)">
												<i class="fa fa-edit"></i>&nbsp;
											</a>
										<?php } if(modPerDelete($dbConn,"3")){?>
											<a href="javascript:deleteVarType(<?php echo $var_type_id;?>)">
												<i class="fa fa-trash"></i>
											</a>
										<?php }?>
										</td>
									</tr><?php
								}
							} ?>
							
						</tbody>
					</table>
				</div>
			</div>
				<!--- End Table ---------------->
		</div>
        
		
	</section><!-- /.content -->
		