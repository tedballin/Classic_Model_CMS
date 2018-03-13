<?php 
require_once("../includes/session.php");
//include functions
require_once("../includes/functions.php");
//switch to https
require_SSL();
include("../includes/layouts/header.php");


//create an error array
$errors =array();
$email="";

// echo $_SESSION["productName"];

//check if form is submitted 
if(isset($_POST["submit"])){
    //get user's input
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    //validations
    //create a required array
    if(!has_presence($email)) {
        $errors[] = "Email cannot be blank.";
      }
      if(!has_presence($password)) {
        $errors[] = "Password cannot be blank.";
      }


if(empty($errors)){
   //try to login 
   $email=clean($_POST["email"]);
    $password = clean($_POST["password"]);
   //either find the user or rutrn null(false)
 $found_user = attempt_login($email,$password);
    if($found_user){
        //sucess
        //mark user as logged in
        $_SESSION["email"]=$found_user["email"];
        // redirect to callback if one set
        $callback_url = "/yza314/A04/public/showmodels.php";
        if(isset($_SESSION["callback_url"]))
        $callback_url = $_SESSION["callback_url"];
        //switchback to non-secure http
        header("Location: http://".$_SERVER["HTTP_HOST"].$callback_url);
    } else {
        $_SESSION["message"] = "Email/password not found.";
        echo $_SESSION["message"];
    }
 }
}

//login form
echo "<h2>Log In</h2>\n";
// echo form_errors($errors);

echo  "<form action=\"login.php\" method=\"post\">\n";
echo   "Email: <input type=\"text\" name=\"email\" value= \"$email\"/>\n";
echo   "Password: <input type=\"password\" name=\"password\" value=\"\"/>\n";
echo	"<br />\n";
echo    "<input type=\"submit\" name=\"submit\" value=\"Log In\"/>\n";
echo   "<a href=\"register.php\">Not registered yet? Register here.</a>";
echo    "</form>\n";

        

include("../includes/layouts/footer.php");
?>