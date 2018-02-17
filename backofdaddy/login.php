<?php
require_once 'library/config.php';
require_once 'library/functions.php';

$errorMessage = '';

if (isset($_POST['txtUserName'])) {
	$result = doLogin($dbConn);
	
	if ($result != '') {
		$errorMessage = $result;
	}
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Daddy Printers | Admin Panel</title>
		<link href="<?php echo WEB_ROOT_ADMIN;  ?>css/admin.css" rel="stylesheet" type="text/css" /> 
		<script language="JavaScript" type="text/javascript" src="<?php echo WEB_ROOT_ADMIN;?>js/table/table-effect.js"></script>      
	</head>
<body>
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="frmAdmin" id="frmAdmin" onSubmit="return validate(this)">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<table width="30%" border="0" align="center" cellpadding="10" cellspacing="0">
						<tr>
							<td  id="contentBlock">
								<table width="100%" border="0" align="center" cellpadding="10" cellspacing="0">
									<tr>
										<td width="50%" align="left" class="heading1" id="bottomBorder">ADMINSTRATOR LOGIN</td>
									</tr>
									<tr>
										<td height="10" class="noPadding"></td>
									</tr>
									<?php 
									if ($errorMessage != '') { ?>
										<tr>
										  <td align="center" class="errorText"><?php echo $errorMessage;  ?></td>
										</tr>
										<?php 
									} ?>
									<tr>
										<td align="left">
											<span class="label">User Name:</span><br />
											<input type="text" name="txtUserName" id="txtUserName" style="width:400px; height:30px" class="formField" required />
										</td>
									</tr>
									<tr>
										<td align="left">
											<span class="label">Password:</span><br />
											<input type="password" name="txtPassword" id="txtPassword" style="width:400px; height:30px" class="formField" required />
										</td>
									</tr>
									<tr>
										<td align="left">
											<strong>
												<input type="submit" name="btnButton" value="Login" class="btn" /> &nbsp; 
												<input type="reset" name="btnButton2" value="Reset" class="btn" />
											</strong>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td height="30" class="noPadding"></td>
						</tr>
						<tr>
							<td align="center">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>