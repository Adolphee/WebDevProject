<?php

  require_once("validationMethods.php");
  require_once("validationErrorMessages.php");
  require_once("../User.php");
  require_once("../database/UserDAO.php");
  session_set_cookie_params(604800);
  session_start();

  /*
    Hier zet ik niet al te veel comments omdat de Error messages die ik   initialiseer de omstandigheden al genoeg verduidelijken.
  */

  $isFormValid = true;
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["username"]) && !empty($_POST["username"])){
      if(checkString($_POST["username"])){
        $username = $_POST["username"];
      } else {
        $isFormValid = false;
        $_SESSION["registrationJumbotron"] = "An invalid username was given.";
      }
    } else {
      $isFormValid = false;
      global $requiredFieldError;
      $_SESSION["registrationJumbotron"] = "Username: ".$requiredFieldError;
    }

    if(isset($_POST["password"]) && !empty($_POST["password"])){
      if(checkString($_POST["password"])){
        $password = $_POST["password"];
      } else {
        $isFormValid = false;
        $_SESSION["registrationJumbotron"] += "<br/>No password was given.";
      }
    } else {
      global $requiredFieldError;
      if(!$isFormValid){
        $_SESSION["registrationJumbotron"] += "<br/>Password: ".$requiredFieldError;
      } else {
        $_SESSION["registrationJumbotron"] = "<br/>Password: ".$requiredFieldError;
      }
      $isFormValid = false;

    }

    // authenticate methode in database folder
    if($isFormValid){
      $_SESSION["current_user"] = authenticate($username, $password);
      if($_SESSION["current_user"] != NULL){
        if($_SESSION["current_user"]->isAdmin()) $_SESSION["isAdmin"] = $_SESSION["current_user"]->isAdmin();
      }
    }

  }

  header("location: ../../view/index.php");
?>
