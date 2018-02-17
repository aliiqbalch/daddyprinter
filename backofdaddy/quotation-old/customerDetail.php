<?php
require_once "../library/config.php";
require_once "../library/functions.php";

if(isset($_POST['companyID'])){
    ?>

    <div class="text-center text-bold"><?= clientName($dbConn,$_POST['companyID']);?></div>
    <div class="text-center text-bold"><?= clienNumber($dbConn,$_POST['companyID']);?></div>
    <input type="hidden" name="clientName" value="<?= clientName($dbConn,$_POST['companyID']);?>">
    <input type="hidden" name="clientNumber" value="<?= clienNumber($dbConn,$_POST['companyID']);?>">
    <?php
}else{
    redirect("index.php");
}

?>