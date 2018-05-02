<?php

  include_once("../User.php");
  require_once("validationMethods.php");
  require_once("validationErrorMessages.php");
  require_once("../Blog.php");
  require_once("../database/BlogDAO.php");
  session_start();

  /*
    Hier zet ik niet al te veel comments omdat de Error messages die ik   initialiseer de omstandigheden al genoeg verduidelijken.
  */
  $isFormValid = true;
  $title = null;
  $category = null;
  $shortVersion = null;
  $content = null;
  $imagepath = "";


  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $valid_file = true;
    //if they DID upload a file...
    if($_FILES['image']['name'])
    {
      //if no errors...
      if(!$_FILES['image']['error'])
      {
        //now is the time to modify the future file name and validate the file
        $new_file_name = str_replace(' ','',strtolower(time().".".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION))); //rename file

        var_dump($new_file_name);
        if($_FILES['image']['size'] > (1024000)) //can't be larger than 1 MB
        {
          $valid_file = false;
          $message = 'Oops!  Your file\'s size is to large.';
        }

        //if the file has passed the test
        if($valid_file)
        {
          //nu gaan we de image verplaatsen naar de file server
          if(move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$new_file_name)){
            // als dat gelukt is gaan we de path onthouden naar de image
            $imagepath = "uploads/".$new_file_name;
            var_dump($new_file_name);
            var_dump($imagepath);
            ?> <img src="<? echo $imagepath; ?>"> <?
          }
        }
      }
      //if there is an error...
      else
      {
        //set that to be the returned message
        $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['image']['error'];
      }
    } else{
      var_dump($_POST["image"]);
      echo "...";
    }

    echo $message;
    // if(isset($_POST["bTitle"]) && !empty($_POST["bTitle"])){
    //   if(checkString($_POST["bTitle"])){
    //     $title = $_POST["bTitle"];
    //     //echo $title."<br/>";
    //     unset($_SESSION['titleError']);
    //   }else{
    //     $isFormValid = false;
    //     $_SESSION['titleError'] = "This is an invalid title.";
    //   }
    // }
    // else {
    //   $isFormValid = false;
    //   global $requiredFieldError;
    //   $_SESSION['titleError'] = $requiredFieldError;
    // }
    //
    // if(isset($_POST["bCategory"]) && !empty($_POST["bCategory"])){
    //   if(is_numeric($_POST["bCategory"])){
    //     $category = $_POST["bCategory"];
    //     //echo $category."<br/>";
    //     unset($_SESSION['categoryError']);
    //   }else{
    //     $isFormValid = false;
    //     $_SESSION['categoryError'] = "This category (".$_POST["bCategory"].") doesn't exist.";
    //   }
    // }
    // else {
    //   $isFormValid = false;
    //   global $requiredFieldError;
    //   $_SESSION['categoryError'] = $requiredFieldError;
    // }
    //
    // if(isset($_POST["shortVersion"]) && !empty($_POST["shortVersion"])){
    //   if(checkString($_POST["shortVersion"])){
    //     $shortVersion = $_POST["shortVersion"];
    //     //echo $shortVersion."<br/>";
    //     unset($_SESSION['shortVersionError']);
    //   }else{
    //     $isFormValid = false;
    //     $_SESSION['shortVersionError'] = "This is a forbidden summary.";
    //   }
    // }
    // else {
    //   $isFormValid = false;
    //   global $requiredFieldError;
    //   $_SESSION['shortVersionError'] = $requiredFieldError;
    // }
    //
    // if(isset($_POST["bContent"]) && !empty($_POST["bContent"])){
    //   if(checkString($_POST["bContent"])){
    //     $content = $_POST["bContent"];
    //     //echo $content."<br/>";
    //     unset($_SESSION['contentError']);
    //   }else{
    //     $isFormValid = false;
    //     $_SESSION['contentError'] = "This is forbidden content.";
    //   }
    // }
    // else {
    //   $isFormValid = false;
    //   global $requiredFieldError;
    //   $_SESSION['contentError'] = $requiredFieldError;
    // }
    //
    // /*
    //    Als er een image werd geupload moeten we die eerst ook valideren
    //   Sourc van de image verwerking: https://davidwalsh.name/basic-file-uploading-php
    // */
    // $valid_file = true;
    // //if they DID upload a file...
    // if($_FILES['image']['name'])
    // {
    //   //if no errors...
    //   if(!$_FILES['image']['error'])
    //   {
    //     //now is the time to modify the future file name and validate the file
    //     $new_file_name = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_FILENAME).time().".".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)); //rename file
    //
    //     var_dump($new_file_name);
    //     if($_FILES['image']['size'] > (1024000)) //can't be larger than 1 MB
    //     {
    //       $valid_file = false;
    //       $message = 'Oops!  Your file\'s size is to large.';
    //     }
    //
    //     //if the file has passed the test
    //     if($valid_file)
    //     {
    //       //nu gaan we de image verplaatsen naar de file server
    //       if(move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$new_file_name)){
    //         // als dat gelukt is gaan we de path onthouden naar de image
    //         $imagepath = "uploads/".$new_file_name;
    //         var_dump($new_file_name);
    //         var_dump($imagepath);
    //         ?> <img src="<? echo $imagepath; ?>"> <?
    //       }
    //     }
    //   }
    //   //if there is an error...
    //   else
    //   {
    //     //set that to be the returned message
    //     $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['image']['error'];
    //   }
    // } else{
    //   echo "...";
    // }
    //
    // echo $message;
    //
    // if(!$valid_image) {
    //   $isFormValid = false;
    //   var_dump($_FILES['image']);
    // }
    //
    // // Als de validatie niet goed was moeten we hebn opnieuw naar de newBlogForm sturen, waar hij zal te zien krijgen wat er juist fout gelopen is.
    //
    // //echo "imagepath: ".$imagepath."<br/>";
    // if(!$isFormValid){
    //   $GLOBALS["isValidationPage"] = true;
    //   include("../../view/newBlog.php");
    // } else {
    //    $GLOBALS["isValidationPage"] = false;
    //    $user_id = $_SESSION["current_user"]->getId();
    //    $returnBlog = new Blog();
    //    $returnBlog->setUserId($user_id);
    //    $returnBlog->setTitle($title);
    //    $returnBlog->setCategory($category);
    //    $returnBlog->setContent($content);
    //    $returnBlog->setShortVersion($shortVersion);
    //    $returnBlog->setImagePath($imagepath);
    //    //var_dump($returnBlog);
    //    var_dump($_SESSION['imageError']);
    //    // $returnBlog = saveBlog($returnBlog);
    //    //
    //    // if($returnBlog != null){
    //    //   header("location: ../../view/blogDetail.php?id=".$returnBlog->getId());
    //    // } else {
    //    //   echo "returnblog was null<br/>";
    //    //   var_dump($returnBlog);
    //    // }
    // }
  } else {
      $GLOBALS["isValidationPage"] = false;
      header("location: ../../view/index.php");
    }
?>
