<?php
require_once("../includes/session.php");
//include functions
require_once("../includes/functions.php");
//check and require login for this page
confirm_logged_in();

//get the model name 
$model = $_GET["model"];
//perform removal action, function is predefined in functions.php
remove_from_watchlist($_SESSION["email"], $model);

//add footer
include('../includes/layouts/footer.php');
?>