<?php 
require_once("../includes/session.php");
//include functions
require_once("../includes/functions.php");
//check and require login for this page
confirm_logged_in();
include("../includes/layouts/header.php");

//execute add request before logging in automatically after login
if(isset($_SESSION["productName"])){
    //check if it's already in the databse before adding it
    if(@check_exist($_SESSION["email"],$_SESSION["productName"])==false){
add_to_watchlist($_SESSION["email"],$_SESSION["productName"]);
    }
}

//normal add request as logged in
if(isset($_POST["add"])){
//insert new model to watchlist
$model = $_POST["model"];
add_to_watchlist($_SESSION["email"],$model);
}

echo "<h2>Welcome back, ".htmlentities($_SESSION["email"])."</h2>";
//fetch resul of watchlisted items based on user (email account)
$wlist_set = find_all_watchlisted_items($_SESSION["email"]);
//check if the reuslt is empty by counting the rows
if (mysqli_num_rows($wlist_set) > 0){
    //do nothing
}else{
    echo "<h3 class=\"sign\"> Your watchlist is empty.</h3>";
}
echo"
    <table>
        <tr>
            <th style=\"text-align: left; width: 200px;\">Model Name</th>
            <th style=\"text-align: left; width: 200px;\">Action</th>
        </tr>";

    while($wlist_model = $wlist_set->fetch_assoc()){
        echo "<tr><td>";
        format_model_as_link($wlist_model["productName"],$wlist_model["productName"],"modeldetails.php");
        echo "</td>";
        echo "<td><a href=\"removefromwatchlist.php?model=".$wlist_model["productName"]."\" onclick=\"return confirm('Are you sure?');\">Remove</a>";
        echo "</td></tr>";
    }

echo "</table>";


//  echo '<pre>' . print_r($wlist_set) . '</pre>';



include("../includes/layouts/footer.php");
?>