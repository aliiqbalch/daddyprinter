<head>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="zabuto_calendar.min.css">
	<style>
		.grade-1 {
			background-color: #FA2601;
		}
		.grade-2 {
			background-color: #90EE90;
		}
		.grade-3 {
			background-color: #FFEB00;
		}
		.grade-4 {
			background-color: #27AB00;
		}
		.purple {
			background-color: #FFA500;
		}
	</style>
</head>
<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$rowsPerPage = 10;
	if(isset($_GET['user_search']) && !empty($_GET['user_search'])){
		$serach_param = $_GET['user_search'];
		$sql		=	"select DISTINCT at.user_id, us.user_name ,spend_hours, SUM(spend_hours) spend_hoursSum, attendance, count(attendance) attendanceCount 
							from attendance at right join tbl_user us 
		ON at.user_id= us.user_id
		where month= MONTH( CURRENT_DATE()) AND at.user_id=$serach_param
		group by attendance";
				// echo $sql;
				$result     = dbQuery($dbConn, getPagingQuery($sql, $rowsPerPage));
				$url_query = "order_search=$serach_param&order_search_btn=Search";
				$pagingLink = getPagingLink($dbConn, $sql, $rowsPerPage, $url_query);
		
	}else{
		$result     = 0;
		$pagingLink = null;
	}
?>
	<?php include(THEME_PATH . '/tb_link.php');?>
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Attendence/Salary Details</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid container_block">
		<div class="row">
				<form action="" method='GET'>
				<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
					<select name ='user_search' id='user_search' class='formField' style="margin-top: 26px;">
						<option value="">Select User</option>
						<?php
                    
					$sql1 = "SELECT * FROM tbl_user";
					$result1 = dbQuery($dbConn,$sql1);
					//print_r($result1);
					
                    //loop
					
                    foreach ($result1 as $row){
						if($_GET['user_search']==$row["user_id"]) 
							$selectedFlag='selected';
						else
							$selectedFlag='';
                ?>		
                    <option <?php echo $selectedFlag;?> value="<?php echo $row["user_id"];?>"><?php echo $row["user_name"];
					?></option>
						
                <?php
                    $userid=$row["user_id"];

					}
                ?>
						
					</select>
				</div>
				<div class="col-md-8 col-sm-8" style="margin-bottom: 30px;">
					<label>&nbsp;</label></br>
					<span style="padding-right:15px;"><strong>Enter Pay</strong></span>
					<input type="number" id="user_pay" name="user_pay" value="" class="formField" style=" width: 180px; height:32px;">
					<label>&nbsp;&nbsp;</label>
					<input type="submit" id="user_search_btn" name="user_search_btn" value="Search" class="butn" />
					
				
				</form>
			</div>

			<div>
				<?php 							
				if(isset($_SESSION['errorMessage']) && isset($_SESSION['count'])){
					if($_SESSION['count'] <= 1){
						$_SESSION['count'] +=1; ?>
						<div class="space"></div>
						<p class="alert alert-success"><?php echo $_SESSION['errorMessage'];  ?></p> <?php
						unset($_SESSION['errorMessage']);
					}
				} ?>
			</div>
			<div class="row bord-right-space" >
				<div class="table-responsive tbl-respon">
					<table class="table table-bordered tbl-respon2">
						<thead>
							<tr>
								<th>Sr.No</th>
								<th>Status</th>
								<th>Total</th>
								<th>Total Hours</th>

							</tr>
						</thead>
						<tbody>
							<?php
							if (!empty(dbNumRows($result)) && dbNumRows($result) > 0){
								$i = 1;
								$grandTotal=0;
								while($row = dbFetchAssoc($result)) {
								extract($row);
							//	echo '<pre>';
							//	print_r($rowUserDetails);
									if ($attendance=="P") {
										$hoursDefault= 8;
										$totalOf=$attendanceCount*$hoursDefault;
									} elseif ($attendance=="A") {
										$hoursDefault= 0;
										$totalOf=$attendanceCount*$hoursDefault;
									} elseif ($attendance=="L") {
										$hoursDefault= 0;
										$totalOf=$attendanceCount*$hoursDefault;
									}elseif ($attendance=="H") {
										$hoursDefault=4 ;
										$totalOf=$attendanceCount*$hoursDefault;
									} elseif ($attendance=="S") {
										$totalOf=$row['spend_hoursSum'];
									}   
									$grandTotal+=$totalOf;
									
								 ?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?=$row['attendance'] ?></td>
										<td><?=$row['attendanceCount']  ?></td>
										<td><?php echo $totalOf?></td>
							
						<?php  } ?>
									</tr>
									<?php }  ?>
							<tr height="20">
								<td align="right" colspan="3" ><strong> <?php echo $user_name; ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; Total </strong> <?php echo $pagingLink;?></td>
								<td> <?php echo $grandTotal?> </td>		
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<?php
			$TotalPay=0;
			if ( isset($_GET['user_pay']) && !empty($_GET['user_pay']) )
				$TotalPay = $_GET['user_pay']/240 * $grandTotal;
			
			?>
				<input readonly type="text" id="text"  name="total_pay" value=<?php echo $TotalPay ?> style="float:right">
				<span style="float:right" ><strong>  Total Pay of This Month&nbsp; &nbsp; </strong></span>
				<!--- End Table ---------------->
			<!-- container -->
			<div class="container example">
				<h1>Attandance Calendar</h1>
				<div class="row">
					<div class="col-xs-10">
						<div id="my-calendar"></div>
						<script type="application/javascript">
							$(document).ready(function () {
								showCalender();
							});
							function showCalender(){
								selectedUser=$('#user_search').val();
								$("#my-calendar").zabuto_calendar({
									legend: [
										{type: "block", label: "Absent", classname: 'grade-1'},
										{type: "block", label: "Present", classname: 'grade-4'},
										{type: "block", label: "Half Leave", classname: 'grade-2'},
										{type: "block", label: "Leave", classname: 'grade-3'},
										{type: "block", label: "Spend Hours", classname: 'purple'},
									],
									ajax: {
										url: "show_data.php?grade=1&user_id="+selectedUser
									}
								});

							}
						</script>
					</div>
				</div>
			</div>
			<!-- /container -->
		</div>
	</section>