<?php
session_start();
require_once("../../model/database/BlogDAO.php");
require_once("../../model/validation/validationErrorMessages.php");

if(isset($_POST["image"]) && !empty($_POST["image"])){
  //Source: StackOverflow
      //Foto werd met succes geupload, nu wegschrijven
      $hierbenik = getcwd();
      $userFolder = $hierbenik."/uploads/user123";
      // checken of de directory van deze user al bestaat
      if(!file_exists($userFolder)){
        // als niet bestaat de directory aanmaken
        if(mkdir($userFolder)){
          // De image naar die directory wegschrijven
          move_uploaded_file( $_POST['image']['tmp_name'], $userFolder);
        } else {
          // image kon niet worden weggeschreven
          $isFormValid = false;
          $GLOBALS["imageError"] = "Somehow... the file could not be uploaded.";
        }
      }
      // De directory bestaat dus...
      // De image naar die directory wegschrijven
      else move_uploaded_file($_POST['image']['tmp_name'], $userFolder);
}

echo "page loaded...<br/>";
var_dump($GLOBALS["imageError"]);
var_dump($_POST["image"]);
?>
