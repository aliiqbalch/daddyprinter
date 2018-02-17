<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
if(is_string(@$_GET['code'])){
	$rowsPerPage = 20;
	$code = $_GET['code'];
	$sql =  "SELECT * FROM account WHERE code = '$code'";
	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
}else{
	$rowsPerPage = 20;
	$sql =  "SELECT * FROM account ORDER BY id DESC";
	$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
}
$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage);
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Bank Detail</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
			<div class="space"></div>
			<?php if(modPerAdd($dbConn,"23")){?>
			<div class="row">
				<div class="col-md-12">
					<button type="button" id="modal" name="btnButton" data-toggle="modal" data-target="#addAccount"  class="btn btn-danger pull-left" style="margin-left: 5px;"><i class="fa fa-plus"></i> Add Account</button>
					<form action="acountProcess.php?action=codS" method="post">
						<div class="input-group pull-left" style="width: 160px; margin-left:20px;">
							<input type="text" name="code" class="form-control" placeholder="Code" aria-describedby="basic-addon2">
							<span style="margin:0px;padding: 0px;" class="input-group-addon" id="basic-addon2"><button type="submit" style="border-radius:0px; border: none;" class="btn"><i class="fa fa-search"></i></button></span>
						</div>
					</form>
					<a href="index.php?view=jou" class="btn btn-danger pull-right" style="margin-left: 5px; color: #ffffff; ">Journal View</a>
				</div>
			</div>
			<?php }?>
			<div style="margin-top: 10px;">
				<?php 
				if(isset($_SESSION['errorMessage']) && isset($_SESSION['count'])){
					if($_SESSION['count'] <= 1){
						$_SESSION['count'] +=1; ?>
						<p class="alert alert-<?php echo $_SESSION['data'];?>"><?php echo $_SESSION['errorMessage'];  ?></p> <?php
						unset($_SESSION['errorMessage']);
					}
				} ?>
			</div>
			<div class="row bord-right-space" >
				<div class="table-responsive tbl-respon">
					<table class="table table-bordered tbl-respon2">
						<thead>
							<tr>
								<th >Sr.No</th>
								<th >Account Title</th>
								<th >Account Code</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (dbNumRows($result) > 0) {
								$i = 1;
								while($row = dbFetchAssoc($result)){
									extract($row); ?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><a href="index.php?view=led&title=<?=$id?>" title="Ledger View"><?php echo $account_title;?></a></td>
										<td><?php echo $code;?></td>
<!--										<td>-->
<!--											--><?php //if(modPerAdd($dbConn,"23")){?>
<!--											<a href="index.php?view=led" title="Ledger View">Ledger</a>-->
<!--											--><?php //} if(modPerModify($dbConn,"23")){?>
<!--											<a href="#"></a>-->
<!--											--><?php //}?>
<!--										</td>-->
									</tr><?php
								}
							} ?>
							<tr height="20">
								<td align="center" colspan="4" class="pagingStyle"><?php echo $pagingLink;?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!--- End Table ---------------->
			<div style="margin-bottom:20px;" class="row">
				<div class="col-md-12">
					<?php if(@$_GET){?>
					<a href="index.php" name="btnButton"  class="btn btn-danger pull-left" style="margin-left: 5px;color: #ffffff;">Back</a>
					<?php } ?>
					<a href="index.php?view=trail" name="btnButton"  class="btn btn-danger pull-right" style="margin-left: 5px;color: #ffffff;">Trail Balance</a>
					<button type="button" name="btnButton"  class="btn btn-danger pull-right" style="margin-left: 5px;">Balance Sheet</button>
					<button type="button" name="btnButton"  class="btn btn-danger pull-right" style="margin-left: 5px;">Final Statement</button>
				</div>
			</div>
		</div>
		
	</section><!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="addAccount" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style="padding:35px 50px;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>Add Account</h4>
			</div>
			<div class="modal-body" style="padding:40px 50px;">
				<form role="form" action="acountProcess.php?action=addAcc" method="post">
					<div class="form-group">
						<label for="usrname"> Account Title</label>
						<input type="text" name="account_title" class="form-control" id="accountTitle" placeholder="Title">
					</div>
					<button type="submit" class="btn btn-danger btn-block"> Save </button>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="addAccount" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style="padding:35px 50px;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>Add Account</h4>
			</div>
			<div class="modal-body" style="padding:40px 50px;">
				<form role="form" action="acountProcess.php?action=addAcc" method="post">
					<div class="form-group">
						<label for="usrname"> Account Title</label>
						<input type="text" name="account_title" class="form-control" id="accountTitle" placeholder="Title" required >
					</div>
					<button type="submit" class="btn btn-danger btn-block"> Save </button>
				</form>
			</div>
		</div>
	</div>
</div>
