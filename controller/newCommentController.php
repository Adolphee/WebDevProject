<?php
  require_once("../model/Blog.php");
  require_once("../model/User.php");
  require_once("../model/Comment.php");
  require_once("../model/database/UserDAO.php");
  require_once("../model/database/BlogDAO.php");
  require_once("../model/database/CommentDAO.php");
  session_start();
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Als het een POST is werd er zojuist een comment gepost
    if(isset($_POST["content"]) && !empty($_POST["content"])){
      $cmt_to_post = new Comment();
      $cmt_to_post->setBlogId((integer)$_POST["blog_id"]);
      $cmt_to_post->setUserId((integer)$_POST["user_id"]);
      $cmt_to_post->setContent($_POST["content"]);
      $cmt_to_post = saveComment($cmt_to_post);
      // als het een POST is halen we de blog uit de hidden form field
    }
  }
  header("location: ../view/blogDetail.php?id=".$_SESSION["blog_id"]);

?>
