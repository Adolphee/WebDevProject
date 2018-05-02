<?php


  include_once("../../model/User.php");
  require_once("../../model/Category.php");
  require_once("../../model/database/BlogDAO.php");
  session_start();

  $name = null;
  $desc = null;
  $validCat = null;
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $validCat = true;

    if(isset($_POST["name"])){
      if(checkString($_POST["name"])){
        $name = $_POST["name"];
      }else $validCat = false;
    }

    if(isset($_POST["name"])){
      if(checkString($_POST["name"])){
        $desc = $_POST["description"];
      } else $validCat = false;
    }


    if($validCat){
      $cat = new Category();
      $cat->setName($name);
      $cat->setDescription($desc);
      if(saveCat($cat)){
        header("location: ../../view/settings.php");
      }

    }

  }


 ?>
