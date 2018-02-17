<?php
	if (!defined('WEB_ROOT')) {
		exit;
	}
	$self = WEB_ROOT . 'index.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include('linker.php');?>
		<?php include(THEME_PATH . '/tb_link.php');?>
	</head>
	<body class="skin-red sidebar-mini">
		<div class="wrapper">
			<?php include(THEME_PATH . '/header.php');?>
			<?php include(THEME_PATH . '/left_bar.php');?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				
				<!-- Main content -->
				<section class="content">
					<!-- start any work here. -->
					<?php require_once $content; ?>
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->
		
			<?php include(THEME_PATH . '/footer.php');?>
			<?php include(THEME_PATH . '/right_bar.php');?>
		</div><!-- ./wrapper -->
		<?php include(THEME_PATH . '/script_link.php');?>
	</body>
</html>
