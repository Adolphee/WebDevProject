<?php
  require_once("../model/Blog.php");
  require_once("../model/User.php");
  require_once("../model/Comment.php");
  require_once("../model/database/UserDAO.php");
  require_once("../model/database/BlogDAO.php");
  require_once("../model/database/CommentDAO.php");
  session_set_cookie_params(604800);
  session_start();
  $_SESSION["current_page"] = "blogOverview";
  if(isset($_GET["id"])){
    $allBlogs = getAllBlogsOfThisCategory($_GET["id"]);
  } else $allBlogs = getAllBlogs();
  include("htmlHeadingIndex.php");
  include("sidebar.php");
?>

<div id="content" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="container" id="contentContainer1">

      <div class="jumbotron">
        <h1 class="text-center">
          BloggieMan - Blogs
        </h1>
      </div>
      <div class="row blogOverflow">
      <?php
      if($allBlogs != NULL){
      foreach($allBlogs as $index=>$blog){ ?>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <!-- Om in blogDetail.php te weten welke blog we moeten getContent
           zal ik de blogId meegeven als parameter in de queryString -->
        <a class="toppies" href="<?php echo "blogDetail.php?id=".$blog->getId(); ?>">
        <div class="card text-white bg-light mb-3">
          <div class="card-header">
            <div class="row">
              <div class="col-12 text-left">
                <!-- Hier tonen we de titel -->
                <h6><? echo $blog->getTitle(); ?></h6>
              </div>
            </div>
          </div>
          <div class="card-body text-left">
            <h6 class="card-title">
              <!-- Hier tonen we de titel -->
              <? echo $blog->getShortVersion(); ?></h6>
          </div>
          <div class="card-footer text-white text-left">
            <div class="row">
              <div class="col-7 text-left">
                <!-- Hier tonen we de titel -->
                <h6><? echo $blog->getNumberOfComments(); ?> Comments</h6>
              </div>
              <div class="col-5 text-right">
              <!-- Hier tonen we de aantal likes van de blog in kwestie -->
              <h6><? echo $blog->getLikes(); ?> Likes</h6>
              </div>
            </div>
          </div>
          <?php
           $myImgPath = $blog->getImagePath();
          if(isset($myImgPath) && !empty($myImgPath)){ ?>
            <img src="<? echo $blog->getImagePath(); ?>" class="homeCardImg">
          <?php } ?>
        </div>
        </a>
        </div>
        <?
       }
      // Als er iets fout loopt melden we dat...
      } else { ?><a class="toppies nav-link" href="/~adolphe.m/WDA/Blog/view/newBlog.php">
          <div class="card text-white bg-danger mb-3" style="max-width: 100%;">
            <div class="card-header">An error occurred while loading Toppies...</div>
            <div class="card-body">
              <h5 class="card-title">Please refresh the page to continue.</h5>
            </div>
          </div>
        </a>
      <?php }?>
      </div>
    </div>
</div>

    <? include("footer.html"); ?>
