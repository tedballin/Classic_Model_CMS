<?php 
require_once("../includes/session.php");
//include functions
require_once("../includes/functions.php");
//switch to https
require_SSL();
include("../includes/layouts/header.php");


//create an error array
$errors =array();
$message ="";

// Process the form
if (isset($_POST['submit'])) {
    $fname=clean($_POST["firstname"]);
    $lname=clean($_POST["lastname"]);
    $email=clean($_POST["email"]);
    $password = clean($_POST["password"]);
    $confirm_password = clean($_POST["confirm_passowrd"]);

    if($password == $confirm_password){
      $hashed_passowrd = password_hash($password, PASSWORD_BCRYPT);
    } else{
        $errors[] = "Password does not match the confirm password.";
    }
  // Validations
  if(!has_presence($fname)) {
    $errors[] = "First name cannot be blank.";
  }
  if(!has_presence($lname)) {
    $errors[] = "Last name cannot be blank.";
  }
  if(!has_presence($email)) {
    $errors[] = "Email cannot be blank.";
  }
  if(!has_presence($password)) {
    $errors[] = "Password cannot be blank.";
  }
  if(!has_presence($confirm_password)) {
    $errors[] = "Confirm passsword cannot be blank.";
  }

if(empty($errors)){

    $query  = "INSERT INTO users ";
    $query .= "(firstName, lastName, email, hashedPassword) ";
    $query .= "VALUES ";
    $query .= "('{$fname}', '{$lname}', '{$email}', '{$hashed_passowrd}')";
    $result = $db->query($query);
    confirm_query($query,$db);

    $_SESSION["email"] = $email;
    //check register result
    if ($result) {
        echo "<h3>success!</h3>";
        // Success
        $_SESSION["message"] = "Account created.";
        redirect_to("addtowatchlist.php");
      } else {
        // Fail
        $_SESSION["message"] = "Account creation failed.";
      }
    }
}
 
echo "<h2>Register</h2>\n";
//this allows me to write html code without quote
print <<< FORM
    <form action="register.php" method="post">
    First name:
    <input type="text" name="firstname" value="">
    Last name:
    <input type="text" name="lastname" value=""><br>
    Email:
    <input type="email" name="email" value=""><br>
    Password:
    <input type="password" name="password" value="">
    Confirm Password:
    <input type="password" name="confirm_passowrd" value="">
    <br><br>
    <input type="submit" name=submit value="Register">
    <a href="showmodels.php">Cancel</a>
    </form>
    <br />
FORM;

echo display_errors($errors);

include("../includes/layouts/footer.php");
?>