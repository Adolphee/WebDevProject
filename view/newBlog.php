
<?php
session_set_cookie_params(604800);
session_start();
$_SESSION["current_page"] = "newBlog";
  if($GLOBALS["isValidationPage"] == true){
    require_once("../User.php");
    require_once("../Category.php");
    require_once("../Blog.php");
    require_once("../database/BlogDAO.php");
    include("htmlHeadingValidation.php");
  } else{
    require("../model/validation/validationErrorMessages.php");
    resetErrorMessages();
    require_once("../model/Category.php");
    require_once("../model/User.php");
    require_once("../model/Blog.php");
    require_once("../model/database/BlogDAO.php");
    include("htmlHeadingIndex.php");
  }
  include("sidebar.php");

?>

<div id="content" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="container" id="contentContainer1">
      <?php
        //ALS de session geset is dan is de user ingelogd
        if(isset($_SESSION["current_user"])){
          include("forms/newBlogForm.php");
        } else { // Anders stuur ik hem door naar de registratiepagina.
          // Daar kan hij ook nog inloggen via de sidebar.
          include("forms/registrationForm.php");
        }
      ?>
    </div>
</div>

 <?php if($GLOBALS["isValidationPage"] == false){
    include("footer.html");
  } else {
    include("validationfooter.php");
}

?>
