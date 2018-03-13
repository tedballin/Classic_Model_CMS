<?php
require_once("../includes/session.php");
//include functions
require_once("../includes/functions.php");


//simple logout
//session_start()
// $_SEEION["email"]=null;
// redirect_to("login.php");
unset($_SESSION["email"]);
session_destroy();
redirect_to("login.php");
?>