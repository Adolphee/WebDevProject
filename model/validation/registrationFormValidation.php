<?php
  session_start();
  require_once("validationMethods.php");
  include("../../model/validation/validationErrorMessages.php");
  require_once("../../model/database/UserDAO.php");

  /*
    Oorspronkelijk had ik een registratiepagina, die perfect gevalideerd werd maar ik ben dit uit het oog verloren
    Waardoor het doorheen de development conflicten kreeg met de rest van de website, zonder dat ik het door had.
    OP de laatste dag pas heb ik dat gemerkt en had ik geen tijd meer om dit in orde te brengen.
    Ik zag dat het niet in de vereisten vermeld stond dus sluit ik voorlopig uit.
    Hier zet ik niet al te veel comments omdat de Error messages die ik   initialiseer de omstandigheden al genoeg verduidelijken.
  */

  $email = null;
  $firstname = null;
  $lastname = null;
  $username = null;
  $password = null;
  $passwordConfirm = null;
  $isFormValid = true;

    $GLOBALS["isValidationPage"] = true;

  if($_SERVER["REQUEST_METHOD"] != "POST"){
   header("location: ../../view/index.php");
  } else {
    $_SESSION["current_user"] = null;
    if(isset($_POST["firstname"]) && !empty($_POST["firstname"])){
      if(checkString($_POST["firstname"])){
        $firstname = $_POST["firstname"];
      } else {
        $isFormValid = false;
        $GLOBALS["firstnameError"] = "This is not a valid firstname.";
      }
    } else {
      $isFormValid = false;
      global $requiredFieldError;
      $GLOBALS["firstnameError"] = $requiredFieldError;
    }

    if(isset($_POST["lastname"]) && !empty($_POST["lastname"])){
      if(checkString($_POST["lastname"])){
        $lastname = $_POST["lastname"];
      } else {
        $isFormValid = false;
        $GLOBALS["lastnameError"] = "This is not a valid lastname.";
      }
    } else {
      $isFormValid = false;
      global $requiredFieldError;
      $GLOBALS["lastnameError"] = $requiredFieldError;
    }


    if(isset($_POST["email"]) && !empty($_POST["email"])){
      if(checkEmail($_POST["email"])){
        $email = $_POST["email"];
      } else {
        $isFormValid = false;
        $GLOBALS["emailError"] = "This is not a valid email address.";
      }
    } else {
      $isFormValid = false;
      global $requiredFieldError;
      $GLOBALS["emailError"] = $requiredFieldError;
    }

    if(isset($_POST["username"]) && !empty($_POST["username"])){
      if(checkString($_POST["username"])){
        $username = $_POST["username"];
      } else {
        $isFormValid = false;
        $GLOBALS["usernameError"] = !is_numeric($_POST["username"])? "A username cannot start with a number." : "This is not a valid username.";
      }
    } else {
      $isFormValid = false;
      global $requiredFieldError;
      $GLOBALS["usernameError"] = $requiredFieldError;
    }

    if(isset($_POST["password"]) && !empty($_POST["password"])){
      if(checkString($_POST["password"])){
        $password = $_POST["password"];
      } else {
        $isFormValid = false;
        $GLOBALS["passwordError"] = "This is not a valid password.";
      }
    } else {
      $isFormValid = false;
      global $requiredFieldError;
      $GLOBALS["passwordError"] = $requiredFieldError;
    }

    if(isset($_POST["passwordConfirm"]) && !empty($_POST["passwordConfirm"])){
      if(checkString($_POST["passwordConfirm"])){
        if($_POST["passwordConfirm"] == $_POST["password"]){
          $passwordConfirm = $_POST["passwordConfirm"];
        } else {
          $isFormValid = false; $GLOBALS["passwordConfirmationError"] = "This password does not match the one given above.";
        }
      } else {
        $isFormValid = false;
        global $requiredFieldError;
        $GLOBALS["passwordConfirmationError"] = $requiredFieldError;
      }
    } else {
      $isFormValid = false;
      global $requiredFieldError;
      $GLOBALS["passwordConfirmationError"] = $requiredFieldError;
    }

    if(!$isFormValid){
      $_SESSION["current_user"] = null;
      include("../../view/index.php");
    } else {
      $current_user = saveUser(new User(null, $username, $firstname, $lastname, $email, $password));
      if($current_user != null) $_SESSION["current_user"] = $current_user;
       $GLOBALS["registrationJumbotron"] = "Your registration was successful.";
         header("location: ../../view/index.php");
    }

  }
?>
