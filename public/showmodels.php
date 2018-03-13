<?php
require_once("../includes/session.php");
//include functions
require_once("../includes/functions.php");
//include header
include("../includes/layouts/header.php");

//column productName, table products
//2. create and perform a database query
$query1 = "SELECT productName FROM products ";
$query1 .= "ORDER BY productName DESC";
$model_result = $db->query($query1);
//check query
confirm_query($model_result,$db);


echo "<h2>Models</h2>";
echo "<ul>";
//3. use returned data, fetch_assoc returns a associative array
while($row=$model_result->fetch_assoc()){
    //create model list with link, function is predefiend in functions.php
    echo "<li>"; 
    format_model_as_link($row["productName"],$row["productName"],"modeldetails.php");
    echo "</li>";
    // echo '<pre>' . print($row, true) . '</pre>';
}
echo "</ul>";
$model_result->free_result();

include('../includes/layouts/footer.php');
?>


