<?php
  require_once("validationMethods.php");
  require_once("validationErrorMessages.php");
  require_once("../User.php");

  $email = null;
  $username = null;
  $password = null;
  $passwordConfirm = null;
  $isFormValid = true;
  $user = null;

  if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("location: ../../view/index.html");
  } else {

    if(isset($_POST["email"])){
      if(checkEmail($_POST["email"])){
        $email = $_POST["email"];
      } else {
        $isFormValid = false;
        global $emailError;
        $emailError = "This is not a valid email address.";
      }
    } else {
      $isFormValid = false;
      global $emailError;
      global $requiredFieldError;
      $emailError = $requiredFieldError;
    }

    if(isset($_POST["username"])){
      if(checkString($_POST["username"])){
        $username = $_POST["username"];
      } else {
        $isFormValid = false;
        global $usernameError;
        $usernameError = "This is not a valid username.";
      }
    } else {
      $isFormValid = false;
      global $usernameError;
      global $requiredFieldError;
      $usernameError = $requiredFieldError;
    }

    if(isset($_POST["password"])){
      if(checkString($_POST["password"])){
        $password = $_POST["password"];
      } else {
        $isFormValid = false;
        global $passwordError;
        $passwordError = "This is not a valid password.";
      }
    } else {
      $isFormValid = false;
      global $passwordError;
      global $requiredFieldError;
      $passwordError = $requiredFieldError;
    }

    if(isset($_POST["passwordConfirm"])){
      if(checkString($_POST["passwordConfirm"])){
        if($_POST["passwordConfirm"] == $_POST["password"]){
          $passwordConfirm = $_POST["passwordConfirm"];
        } else {
          $isFormValid = false;
          global $passwordConfirmationError;
          $passwordConfirmationError = "This password does not match the one given above.";
        }
      } else {
        $isFormValid = false;
        global $passwordConfirmationError;
        $passwordConfirmationError = $requiredFieldError;
      }
    } else {
      $isFormValid = false;
      global $passwordConfirmationError;
      global $requiredFieldError;
      $passwordConfirmationError = $requiredFieldError;
    }



    if(!$isFormValid){
      $_SESSION["current_user"] = null;
      header("location: ../../view/index.html");
    } else {
      // public function __construct($id=NULL, $username="nvt", $firstname, $lastname, $email, $password, $birthdate, $is_enabled=true, $is_admin=false)
      //$user = new User(null, )



      // global $registrationJumbotron;
      // $registrationJumbotron = "Your registration was successful.\n You can now login using the sidebare to your left! :)";
    }

  }
?>
