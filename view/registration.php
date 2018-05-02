

<?php
  session_set_cookie_params(604800);
  session_start();
  $_SESSION["current_page"] = "Registration";
  if($GLOBALS["isValidationPage"] == false){
  require("../model/validation/validationErrorMessages.php");
      include("htmlHeadingIndex.php");
  } else{
      include("htmlHeadingValidation.php");
  }
if(isset($_COOKIE["user_id"])) $_SESSION["current_user"] = getUser($_COOKIE("user_id"));
include("sidebar.php");
?>

<div id="content" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="container" id="contentContainer1">
      <?php include("forms/registrationForm.php"); ?>
    </div>
</div>

 <?php if($GLOBALS["isValidationPage"] == false){
     include("footer.html");
  } else {
    include("validationfooter.php");
}

?>
