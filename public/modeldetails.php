<?php 
require_once("../includes/session.php");
//include functions
require_once("../includes/functions.php");
//get the productname from URL
$modelName = $_REQUEST["model"];
$queryString = "SELECT * FROM products WHERE productName = ?";

//construct a statement object 
$stmt =$db->prepare($queryString);
//tells php to substitute ? with $modelName
$stmt->bind_param("s",$modelName);
//run the actual query
$stmt->execute();
$stmt->bind_result($code,$name,$line,$scale,$vendor,$description,$stock,$price,$msrp);

//include header
include("../includes/layouts/header.php");

//model details
if($stmt->fetch()){
    echo "<h3>$name</h3>\n";
	echo "<ul>";
    echo "<li> Product Code: $code</li>";
    echo "<li> Product Line: $line</li>";
    echo "<li> Product Scale: $scale</li>";
    echo "<li> Product Vendir: $vendor</li>";
    echo "<li> Product Description: $description</li>";
    echo "<li> Quantity in Stock: $stock</li>";
    echo "<li> Buy Price: $price</li>";
    echo "<li> Product MSRP: $msrp</li>";
	echo "</ul>";
}

//free result
$stmt->free_result();

//create add to watchlist button
//check if it's already in the watchlist, if yes, dont display add button
if(@check_exist($_SESSION["email"],$modelName)==false){
echo "<form action=\"addtowatchlist.php\" method=\"post\">\n";
echo "<input type=\"hidden\" name=\"model\" value=\"$name\">\n";
echo "<b>Add to watchlist: </b>\n";
echo "<input type=\"submit\" name=\"add\" value=\"Add\">\n";
echo "</form>";
} else{
    echo "<h3 class=\"sign\"> This model is alreay in your watchlist </h3>";
}
//add footer
include('../includes/layouts/footer.php');
?>