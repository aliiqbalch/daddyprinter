<?php
require_once 'library/config.php';
require_once 'library/functions.php';

checkUser();

$content = 'dashboard.php';

$pageTitle = 'Dashboard';
$icon  = '<img src="images/admin.jpg" alt="Admin">';
$script = array();

require_once  THEME_PATH . '/template.php';

?>