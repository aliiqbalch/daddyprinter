<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	
?>	
	<script>
	function pricedouble(){
		var txtCostP = document.getElementById("txtCostP").value;
		var twntyfive = 25 / 100 * txtCostP;
		var sevntyfive = 75 / 100 * txtCostP;
		var wholesale = +txtCostP + +twntyfive;
		var retailp = +txtCostP + +sevntyfive;
		document.frmAddMainNav.txtWholesaleP.value = wholesale;
		document.frmAddMainNav.txtRetailp.value= retailp;
	}
	</script>
	<script>
	function showVarType(VarTypeId) {
		if (VarTypeId == "") {
			document.getElementById("txtsubvar").innerHTML = "";
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("txtsubvar").innerHTML = this.responseText;
				}
			};
			xmlhttp.open("GET","getsubvar.php?VarTypeId="+VarTypeId,true);
			xmlhttp.send();
		}
	}
	</script>
		
	<!-- Content Header (Page header) -->
	<section class="content-header top_heading">
		<h1>Add Sub Variation</h1>
	</section>
	<!-- Main content -->
	<section class="content" >
		<!-- start any work here. -->
		<form name="frmAddMainNav" id="frmAddMainNav" method="post" action="processvarsub.php?action=add"  enctype="multipart/form-data" onsubmit="return validate(this)">
			
			<div class="container-fluid container_block">
				<div class="row inner_heading">
					<h1>Add Sub Variation Details</h1><hr>
				</div>
				<div class="row" id="alertmsg" style="margin: 10px 0px 0px 5px;">
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
				<div class="row">
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>Variation:</label></br>
						<select name="txtFlagType" class="form-control" >
							<?php flagvariationtype($dbConn); ?>
						</select>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>Variation Type:</label></br>
						<select name="txtsubVarType" class="form-control" onchange="showVarType(this.value)">
							<option value="0">----</option>
							<?php variationtype($dbConn); ?>
						</select>
					</div>
					<div class="col-md-4 col-sm-4" style="margin-bottom:20px;">
						<label>Sub Variation :</label></br>
						<select name="txtsubvar" id="txtsubvar" class="form-control" >
							<option>----</option>
						</select>
					</div>
                    
				</div>
				<div style="min-height: 20px;"></div>
			</div>
			<div class="row">
				<div class="col-md-offset-5 col-xs-offset-3 col-sm-offset-5">
					<input type="submit" name="btnButton" value="Save" class="butn" /> &nbsp;
					<input type="button" name="btnCanlce" value="Back" class="butn" onclick="window.location.href='index.php'"/>
				</div>
			</div>
		</form>
	</section><!-- /.content -->
		