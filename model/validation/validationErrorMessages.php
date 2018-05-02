<?php

//Dit is eigenlijk bijna overbodig omdat ik nu ook $GLOBALS gebruik maar...
//Ik gebruik dit al van dag 1 en als ik die nu nog verwijder krijg ik issues
//Met mijn backend validation messages
$emailError = "";
$usernameError = "";
$passwordError = "";
$passwordConfirmationError = "";
$requiredFieldError = "This field is required.";
$isValidationPage = false;
$imageError = "...";
$titleError = "";
$categoryError = "";
$shortVersionError = "";
$contentError = "";



function resetErrorMessages(){
  unset($_SESSION['titleError']);
  unset($_SESSION['categoryError']);
  unset($_SESSION['shortVersionError']);
  unset($_SESSION['contentError']);
  unset($_SESSION['imageError']);
}
?>
