<?php
require_once("../includes/session.php");
//include functions
require_once("../includes/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A04: Classicmodels</title>
    <link rel="stylesheet" href="css/main.css">
</head>
	<body>
    <div id="header">
      <h1>Classic Models</h1>
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