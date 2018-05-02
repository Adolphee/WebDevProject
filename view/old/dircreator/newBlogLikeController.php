
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
    if(!hasLikedThisBlog($_POST["blog_id"])){
      bLike($_POST["blog_id"]);
    }
  }
  header("location: ../view/blogDetail.php?id=".$_SESSION["blog_id"]);

?>
