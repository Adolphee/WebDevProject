<?php


  include_once("../model/User.php");
  require_once("../model/Blog.php");
  require_once("../model/database/BlogDAO.php");
  session_start();

  if(isset($_GET["id"]) && isset($_SESSION["isAdmin"])){
    $blog_id = $_GET["id"];
    $blogToRemove = getBlog($blog_id);
    $blogToRemove->setEnabled(false);
    $blogToRemove = updateBlog($blogToRemove);
    header("location: ../view/settings.php");
  }
 ?>
