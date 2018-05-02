<?php
  
  session_set_cookie_params(604800);
  session_start();
  $toppies = getTopBlogs();
  $randies = getRandies($toppies);
?>

<div class="jumbotron">
<h1 class="text-center">
 BloggieMan - Home Page
</h1>
</div>
<div class="row homeRow">
<?php
if($toppies != NULL){
foreach($toppies as $index=>$blog){ ?>
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
<!-- Om in blogDetail.php te weten welke blog we moeten getContent
   zal ik de blogId meegeven als parameter in de queryString -->
<a class="toppies" href="<?php echo "blogDetail.php?id=".$blog->getId(); ?>">
<div class="card homeCard text-white bg-warning mb-3">
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
</div><?php }
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
<div class="row homeRow">
<?php
  if($randies != NULL){
  foreach($randies as $index=>$blog){ ?>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
  <!-- Om in blogDetail.php te weten welke blog we moeten getContent
       zal ik de blogId meegeven als parameter in de queryString -->
  <a class="toppies" href="<?php echo "blogDetail.php?id=".$blog->getId(); ?>">
    <div class="card homeCard text-white bg-light mb-3">
      <?php
       $myImgPath = $blog->getImagePath();
      if(isset($myImgPath) && !empty($myImgPath)){ ?>
        <img src="<? echo $blog->getImagePath(); ?>" class="homeCardImg">
      <?php } ?>
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
    </div>
  </a>
</div><?php }
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
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="height: 100px">
    </div>
    </div>
