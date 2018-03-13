<?php
//use constant values
define("DB_SERVER", "localhost");
define("DB_USER", "c_user");
define("DB_PASS", "c_password");
define("DB_Name", "classicmodels");

//1. create a database connection
$db = connectToDB(DB_SERVER,DB_USER,DB_PASS,DB_Name);
function connectToDB($dbhost, $dbuser, $dbpass, $dbname) {
    //create the handle (mysqli object)
    $connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
//check connection
if(mysqli_connect_errno()){
    //quit and display error and error number
    die("Database connection failed:" .
    mysqli_connect_error() .
    " (" . mysqli_connect_errno() . ")"
);
}
   return $connection;
}
//convert html predefined characters
function hts($string="") {
    return htmlspecialchars($string);
  }

//check presence
function has_presence($value) {
    return isset($value) && $value !== "";
  }


  //displaying errors
  function display_errors($errors=array()) {
    $output = '';
    if(!empty($errors)) {
      $output .= "<div class=\"errors\">";
      $output .= "Please fix the following errors:";
      $output .= "<ul>";
      foreach($errors as $error) {
        $output .= "<li>" . hts($error) . "</li>";
      }
      $output .= "</ul>";
      $output .= "</div>";
    }
    return $output;
  }

 // check if theres a query error, and if the query actually changes something
function confirm_query($result,$db){
    if($result&&mysqli_affected_rows($db)>0){
        //nothing
}else{
    die("Database query failed.".mysqli_error($db));
    }
}
//cleaing input string
function clean($string) {
    global $db;
    
    $escaped_string = mysqli_real_escape_string($db, $string);
    return $escaped_string;
  }
//redirect
function redirect_to($location) {
    header("Location: " . $location);
    exit;
  }

//********* showmodels **********
//function to create the model list
function format_model_as_link($id,$model,$page){
    echo "<a href=\"$page?model=$id\">$model</a>";
}

//********* addtowatchlist **********
function check_exist($userEmail, $model){
    global $db;
    $query = "SELECT * FROM watchlist WHERE productName='$model' AND email='$userEmail'";
    $result = $db -> query($query);
    return mysqli_num_rows($result) > 0;
}

//perform insert query, add models to the watchlist
function add_to_watchlist($userEmail, $model){
    global $db;
    $query  = "INSERT INTO watchlist ";
    $query .= "(email, productName) ";
    $query .= "VALUES ";
    $query .= "('{$userEmail}','{$model}') ";
    $result = $db->query($query);
    confirm_query($result,$db);
    
    //check register result
    if ($result) {
        // Success
        $_SESSION["message"] = "Added to watchlist.";
      } else {
        // Fail
        $_SESSION["message"] = "Try again.";
      }
}
//perform delete query, remove models from the watchlist
function remove_from_watchlist($userEmail, $model){
    global $db;
    $query  = "DELETE FROM watchlist WHERE email ='$userEmail' ";
    $query .= "AND productName='$model'";
    $result = $db->query($query);
    confirm_query($result,$db);

    if ($result) {
        // Success
        $_SESSION["message"] = "Item removed.";
        redirect_to("addtowatchlist.php");
      } else {
        // Failure
        $_SESSION["message"] = "Item removal failed.";
        redirect_to("addtowatchlist.php");
      }
    }

function find_all_watchlisted_items($userEmail){
    global $db;
    $query = "SELECT * ";
    $query .= "FROM watchlist ";
    $query .= "WHERE email = '$userEmail' ";
    $query .= "ORDER BY productName DESC";
    $wlist_result = $db ->query($query);
    // confirm_query($wlist_result,$db);
    return $wlist_result;
    
}   

//********* login **********
//try login,check if db has this user info
 
function find_user_by_email($email){
    global $db;
    $safe_email = mysqli_real_escape_string($db,$email);
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE email = '$safe_email' ";
    $query .= "LIMIT 1";
    $email_result= $db->query($query);
    if($email = $email_result->fetch_assoc()){
        return $email;
    }else{
        return null;
    }
}

function attempt_login($email,$password) {
    $user = find_user_by_email($email);
    if($user){
        //found email, now check password
    if(password_verify($password,$user["hashedPassword"])){
        //pasword matches
        return $user;
}else{
    //pass does not match
    return false;
}
    }else{
    //email not found
    return false;
}
} 
// check log in status, simple check
function logged_in(){
    //retrun bool value true or false
    return isset($_SESSION["email"]);
}
//reinforcement for pages where login is required
function confirm_logged_in(){
    if(!logged_in()){
        if(isset($_POST["add"])){
                //store callback url and add request into session for later use (after user log in)
                $_SESSION["callback_url"] = "/yza314/A04/public/addtowatchlist.php";
                $_SESSION["productName"] =$_POST["model"];
            }
        //if not loged in redirect
        redirect_to("login.php");
    }
}

//************ Security  ***************/
//switch to https
function require_SSL(){
if($_SERVER["HTTPS"] != "on")
    {
    header("Location: https://".$_SERVER["HTTP_HOST"]
    .$_SERVER["REQUEST_URI"]);
    exit();
    }
}


?>