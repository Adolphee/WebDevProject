
<?php
  require_once("../model/Blog.php");
  require_once("../model/User.php");
  require_once("../model/Comment.php");
  require_once("../model/database/UserDAO.php");
  require_once("../model/database/BlogDAO.php");
  require_once("../model/database/CommentDAO.php");
  session_set_cookie_params(604800);
  session_start();
  $_SESSION["current_page"] = "settings";
  /*
    User niet ingelogd? dan kan hij deze pagina niet zien...
  */
  if(!isset($_SESSION["current_user"])) header("location: index.php");
  // Begin output
  include("htmlHeadingIndex.php");
  include("sidebar.php");
?>
<div id="content" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="container" id="adminContainer">
      <div class="jumbotron">
         <h1 class="text-center"> Admin panel for:
           <?php echo $_SESSION["current_user"]->getFirstname(); ?>
         </h1>
      </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center" id="blogOverzicht">
        <nav>
        <ul class="list-unstyled">
        <?php
          $allBlogs = getAllBlogs();
          if($allBlogs != NULL){
          foreach($allBlogs as $index=>$blog)
          { ?>
          <!-- Om in blogDetail.php te weten welke blog we moeten getContent
               zal ik de blogId meegeven als parameter in de queryString -->
          <li class="AdminPanel-bloglist">
            <div class="row">
              <a class="nav-link col-8" href="blogDetail.php?id=<?php echo $blog->getId(); ?>"> <?php echo $blog->getTitle();  ?></a>
              <a class="nav-link col-4 btn btn-danger" href="../controller/deleteBlogController.php?id=<?php echo $blog->getId(); ?>">Remove</a>
            </div>
          </li>
        <?php } } ?>
          </ul>
        </nav>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="addCategoryForm">
        <form action="../model/validation/newCategoryValidation.php" method="post">
            <div class="form-group">
              <label for="name">Category name: </label>
              <input type="text" name="name" required>
            </div>
            <div class="form-group">
              <label for="name">Description: </label>
              <textarea type="text" name="description" required placeholder="Describe this category..."></textarea>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include("footer.html"); ?>
