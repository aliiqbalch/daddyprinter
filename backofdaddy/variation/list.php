<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$rowsPerPage = 30;
	$sql =  "SELECT * FROM tbl_variation ORDER BY var_id DESC";
	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
	$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Variation</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Variation</li>
		</ol>
    </section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			<?php
			if(modPerAdd($dbConn, "5")){ ?>
				<div class="row">
					<div class="col-md-6">
						<div style="margin: 10px 0px 0px 5px;">
							<button type="submit" name="btnButton"  class="butn" onclick="addVar()"  ><i class="fa fa-plus"></i> Add Variation</button>
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
					<table class="table table-bordered table-striped table-hover tbl-respon2">
						<thead>
							<tr>
								<th >Sr.No</th>
								<th >Variation Type</th>
								<th >Title</th>
								<th >Image</th>
								<th >Description</th>
								<th >Sub Variation</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (dbNumRows($result) > 0) {
								if(isset($_GET['page'])){
									$page = $_GET['page'] - 1;
									$i = $rowsPerPage * $page +1;
								}else{
									$i = 1;
								}
								while($row = dbFetchAssoc($result)){
									extract($row);
									 ?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?php variationtypeName($dbConn, $var_type_id);?></td>
										<td><?php echo $var_title;?></td>
										<td>
											<?php  
												if ($var_img != '') { ?>
													<img src="<?php echo WEB_ROOT."upload/variation/". $row['var_img']; ?>"  width="70px" height="70px"/>
													<?php 
												}else{ 
													echo "";
												}
											?>
										</td>
										<td><?php echo $var_desc;?></td>
										<td><?php 
										if($var_flag == 0){
											echo "No";
										}else{
											echo "Yes";
										}
										?></td>
										<td>
											<?php if(modPerModify($dbConn,"5")){?>
											<a href="javascript:modifyVar(<?php echo $var_id;?>)">
												<i class="fa fa-edit"></i>&nbsp;
											</a>
										<?php } if(modPerDelete($dbConn,"5")){?>
											<a href="javascript:deleteVar(<?php echo $var_id;?>)">
												<i class="fa fa-trash"></i>
											</a>
										<?php }?>
										</td>
									</tr><?php
								}
							} ?>
							<tr height="20">
								<td align="center" colspan="9" class="pagingStyle"><?php echo $pagingLink;?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
				<!--- End Table ---------------->
		</div>
        
		
	</section><!-- /.content -->
		