<?php
  require_once("../model/Blog.php");
  require_once("../model/User.php");
  require_once("../model/Comment.php");
  require_once("../model/database/UserDAO.php");
  require_once("../model/database/BlogDAO.php");
  require_once("../model/database/CommentDAO.php");
  session_set_cookie_params(604800);
  session_start();
  $_SESSION["current_page"] = "myBlogs";
  /*
    User niet ingelogd? dan kan hij deze pagina niet zien...
  */
  if(!isset($_SESSION["current_user"])) header("location: index.php");
  $myBlogs = getUserBlogs($_SESSION["current_user"]->getId());
  // Begin output
  include("htmlHeadingIndex.php");
  include("sidebar.php");
?>
<div id="content" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="container" id="contentContainer1">
      <?php include("myBlogList.php"); ?>
    </div>
</div>

<?php include("footer.html"); ?>
