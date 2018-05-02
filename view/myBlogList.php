<div class="jumbotron">
   <h1 class="text-center">
     <?php echo $_SESSION["current_user"]->getFirstname()."'s blogs" ?>
   </h1>
</div>
<ul class="list-unstyled">
<?php
  if($myBlogs != NULL){
  foreach($myBlogs as $index=>$blog){ ?>
  <!-- Om in blogDetail.php te weten welke blog we moeten getContent
       zal ik de blogId meegeven als parameter in de queryString -->
  <li><a class="" href="<?php echo "blogDetail.php?id=".$blog->getId(); ?>">
    <div class="card commentCard text-white
     <?php
    //Ik wil dat elk topBlog kaartje een ander kleur heeft uit de volgeende 3
      $i = $index%3;
      switch($i){
        case 0: echo "bg-primary"; break;
        case 1: echo "bg-info"; break;
        case 2: echo "bg-success"; break;
        default: echo "bg-info"; break;
      }
     ?> mb-3" style="max-width: 100%;">
      <div class="card-header">
        <div class="row">
          <div class="col-10">
            <!-- Hier tonen we de titel -->
            <? echo $blog->getTitle(); ?></h6>
          </div>
          <div class="col-2 text-center">
          <!-- Hier tonen we de aantal likes van de blog in kwestie -->
          <? echo $blog->getLikes(); ?> likes
          </div>
        </div>
      </div>

      <div class="card-body">
        <h6 class="card-title">
          <!-- Hier tonen we de titel -->
          <? echo $blog->getShortVersion(); ?></h6>
      </div>
    </div>
  </a></li> <?php } ?>
  <a href="/~adolphe.m/WDA/Blog/view/newBlog.php">
    <div class="jumbotron bg-success">
       <h1 class="text-center">
         Another one!
       </h1>
    </div>
  </a> <?php
    // Als er iets fout loopt melden we dat...
  } else { ?>
      <li><a class="" href="/~adolphe.m/WDA/Blog/view/newBlog.php">
        <div class="card text-white bg-success mb-3" style="max-width: 100%;">
          <div class="card-header">You haven't written any blogs yet!</div>
          <div class="card-body">
            <h5 class="card-title">Get started today!</h5>
          </div>
        </div>
      </a></li>
    <?php } ?>
</ul>
