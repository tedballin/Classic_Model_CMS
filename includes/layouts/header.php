<?php
require_once("../includes/session.php");
//include functions
require_once("../includes/functions.php");
	if (!isset($layout_context)) {
		$layout_context = "guest";
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A04: Classicmodels <?php if ($layout_context == "user") { echo "User"; } ?></title>
    <link rel="stylesheet" href="css/main.css">
</head>
	<body>
    <div id="header">
      <h1>Classic Models <?php if ($layout_context == "user") { echo "User"; } ?></h1>
      <nav>
        <ul>
         <li><a href="showmodels.php">All Models</a></li>
         <li><a id="wList" href="addtowatchlist.php">Watchlist</a></li>
         <li><?php if(logged_in()){
             echo "<a id=\"logInOut\" href=\"logout.php\">".htmlentities($_SESSION["email"])." Logout</a>";
         }else{
            echo "<a id=\"logInOut\" href=\"login.php\">Login</a>";
         }
             ?></li>
         </ul>
        </nav>
    </div>