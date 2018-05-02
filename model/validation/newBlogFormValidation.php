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
    if(isset($_POST["bTitle"]) && !empty($_POST["bTitle"])){
      if(checkString($_POST["bTitle"])){
        $title = $_POST["bTitle"];
        //echo $title."<br/>";
        unset($_SESSION['titleError']);
      }else{
        $isFormValid = false;
        $_SESSION['titleError'] = "This is an invalid title.";
      }
    }
    else {
      $isFormValid = false;
      global $requiredFieldError;
      $_SESSION['titleError'] = $requiredFieldError;
    }

    if(isset($_POST["bCategory"]) && !empty($_POST["bCategory"])){
      if(is_numeric($_POST["bCategory"])){
        $category = $_POST["bCategory"];
        //echo $category."<br/>";
        unset($_SESSION['categoryError']);
      }else{
        $isFormValid = false;
        $_SESSION['categoryError'] = "This category (".$_POST["bCategory"].") doesn't exist.";
      }
    }
    else {
      $isFormValid = false;
      global $requiredFieldError;
      $_SESSION['categoryError'] = $requiredFieldError;
    }

    if(isset($_POST["shortVersion"]) && !empty($_POST["shortVersion"])){
      if(checkString($_POST["shortVersion"])){
        $shortVersion = $_POST["shortVersion"];
        //echo $shortVersion."<br/>";
        unset($_SESSION['shortVersionError']);
      }else{
        $isFormValid = false;
        $_SESSION['shortVersionError'] = "This is a forbidden summary.";
      }
    }
    else {
      $isFormValid = false;
      global $requiredFieldError;
      $_SESSION['shortVersionError'] = $requiredFieldError;
    }

    if(isset($_POST["bContent"]) && !empty($_POST["bContent"])){
      if(checkString($_POST["bContent"])){
        $content = $_POST["bContent"];
        //echo $content."<br/>";
        unset($_SESSION['contentError']);
      }else{
        $isFormValid = false;
        $_SESSION['contentError'] = "This is forbidden content.";
      }
    }
    else {
      $isFormValid = false;
      global $requiredFieldError;
      $_SESSION['contentError'] = $requiredFieldError;
    }

    /*
       Als er een image werd geupload moeten we die eerst ook valideren
      Sourc van de image verwerking: https://davidwalsh.name/basic-file-uploading-php
    */
    $valid_image = true;
    //ALS ze de een image voorzien hebben...
    if($_FILES['image']['name']){
      //Zijn er fouten opgetreden?...
      if(!$_FILES['image']['error'])
      {
        /*
          nu zal ik dit exacte instant concateneren aan de filename
          om duplicate filenames te vermijden
        */
        $new_file_name = str_replace(' ','',strtolower(time().".".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)));
        /*
          Ik ga de filesize limiteren op 1MB zodat de loading times niet te lang worden voor users met trager internet
        */
        if($_FILES['image']['size'] > (1024000))
        {
          $valid_image = false;
          $isFormValid = false;
          $_SESSION['imageError'] = "Whoa, this image is huge! Max size: 1MB";
        }

        //Als de file geldig is...
        if($valid_image)
        {
          //nu gaan we de image verplaatsen naar de file server
          if(move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$new_file_name)){
            // als dat gelukt is gaan we de path onthouden naar de image
            $imagepath = "../model/validation/uploads/".$new_file_name;
          } else {
            $isFormValid = false;
            $_SESSION['imageError'] = "Image upload failure, please try again.";
          }
        }
      }
      //Als er dan nog een error heeft plaatsgevonden...
      else
      {
        //Dan gaan we de errormessage klaarzetten
        $_SESSION["imageError"] = $_FILES['image']['error'];
      }

      // $_FILES['field_name']['name']
      // $_FILES['field_name']['size']
      // $_FILES['field_name']['type']
      // $_FILES['field_name']['tmp_name']
    }

    if(!$valid_image) $isFormValid = false;

    // Als de validatie niet goed was moeten we hebn opnieuw naar de newBlogForm sturen, waar hij zal te zien krijgen wat er juist fout gelopen is.
    if(!$isFormValid){
      $GLOBALS["isValidationPage"] = true;
      include("../../view/newBlog.php");
    } else {
       $GLOBALS["isValidationPage"] = false;
       /* READ THIS TO UNDERSTAND THE FOLLOWING 2 LINES !!!
        Ik heb gemerkt dat $category een string is.
        Ik moet die echter als int in de database steken
        en casten naar een int lijkt niet te werken.
        Dus heb ik mijn eigen manier gevonden om
        PHP die toch als een int te laten zien.
        Het is een beetje silly,
        maar het werkt en ik heb geen tijd voor
        een betere oplossing te zoeken.
       */
       $category = $category + 1;
       $category = $category - 1;
       $user_id = $_SESSION["current_user"]->getId();
       $returnBlog = new Blog();
       $returnBlog->setUserId($user_id);
       $returnBlog->setTitle($title);
       $returnBlog->setCategory($category);
       $returnBlog->setContent($content);
       $returnBlog->setShortVersion($shortVersion);
       $returnBlog->setImagePath($imagepath);
       $returnBlog = saveBlog($returnBlog);

       if($returnBlog != null){
         header("location: ../../view/blogDetail.php?id=".$returnBlog->getId());
       } else {
         header("location: ../../view/index.php");
       }
    }
  } else {
      $GLOBALS["isValidationPage"] = false;
      header("location: ../../view/index.php");
    }
?>
