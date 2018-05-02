<?php
  $blogCreator = getUser($blogToShow->getUserId());
  /*
    id in session steken om te gebruiken in de validatie page wanner we de user terugsturen naar de blogDetail pagina (dient als parameter in de QueryString)
    $_SESSION["blog_id"] = $blogToShow->getId();
  */
  $_SESSION["blog_id"] = $blogToShow->getId();
 ?>

 <div class="jumbotron text-white text-center" id="blogDetailJumbotron"
  style="background-image: url(<?php echo $blogToShow->getImagePath(); ?>)">
  <h1><?php echo $blogToShow->getTitle(); ?></h1>
</div>

<div class="row">
  <div class="col-md-6 text-white">
    <div class="row">
      <h3> <?php echo $blogToShow->getLikes(); ?> Likes</h3>
    <div class="col-md-2"></div>
    <?php
    //Als de user ingelogd is gaan we mogelijkheid geven om de blog te like'n
    if(isset($_SESSION["current_user"])){
       if(!hasLikedThisBlog($blogToShow->getId())) {?>
          <!-- Like button -->
         <form class="form-inline col-4 cmt-like" method="post" action="../controller/newBlogLikeController.php">
           <div class="form-group">
             <input type="hidden" name="user_id" value="<?php $_SESSION["current_user"]->getId();?>">
             <input type="hidden" name="blog_id" value="<?php echo $blogToShow->getId();?>">
             <input type="submit" class="btn btn-primary" value="Like"></input>
           </div>
         </form>
    <? } }?>
  </div>
</div>
  <div class="col-md-6 text-right text-white">
    <h6><? echo $blogToShow->getCategory(); ?> -by <?php echo $blogCreator->getFirstname()." ".$blogCreator->getLastname(); ?></h6>
  </div>
<div class="blogOverflow">
<div class="row">
  <div class="col-md-2 col-sm-0"></div>
  <div class="content pragraph col-md-8 col-sm-12">
    <?php $contentToShow = explode(PHP_EOL,$blogToShow->getContent());
      foreach ($contentToShow as $key => $value) { ?>
        <p> <?php echo $value ?> </p>
      <? } ?>
      <br/><br/><br/><br/><br/><br/><br/><br/>
  </div>
  <div class="col-md-2 col-sm-0"></div>
</div>
</div>
<div class="row" id="commentSection">
  <div class="col-md-2 col-sm-0"></div>
  <div class="col-md-8 col-sm-0">
    <ul class="list-unstyled" id="commentSection">
      <?php
      if(isset($_SESSION["current_user"])){
        $cuser = $_SESSION["current_user"];
      ?>
      <li>
        <div id="BottomCommentCard" class="card text-white bg-success mb-3" style="max-width: 100%;">
          <div class="card-header"><?php echo $cuser->getUsername(); ?></div>
          <div class="card-body">
            <form class="form-inline" method="post" action="../controller/newCommentController.php">
              <div class="form-group">
                <input type="hidden" name="user_id" value="<?php echo $cuser->getId();?>">
                <input type="hidden" name="blog_id" value="<?php echo $blogToShow->getId();?>">
                <input type="text" name="content" placeholder="Tell them what you think!">
              </div>
            </form>
          </div>
        </div>
      </li> <? } ?>
      <!--
        Vanaf hier ga ik de commentlist inserten
      -->
      <?php
        $cmtList = getBlogComments($blogToShow->getId());
        if($cmtList != NULL){
        foreach($cmtList as $index=>$cmt){
            //De user ophalen die de comment achterliet..
            $cmter = getUser($cmt->getUserId());
          ?>
        <!-- Elke comment is een list item uiteraard -->
        <li>
          <div class="card commentCard text-white bg-primary <?php
          //Ik wil dat elk volgende topBlog kaartje een ander kleur heeft uit de volgeende 3
          // $cardColor = $index%4;
          // switch($cardColor){
          //   case 0: echo "bg-primary"; break;
          //   case 1: echo "bg-info"; break;
          //   case 2: echo "bg-success"; break;
          //   case 3: echo "bg-danger"; break;
          //   default: echo "bg-info"; break;
          // }
           ?> mb-3" style="max-width: 100%;">
            <div class="card-header">
              <!-- Hier tonen we de username van de user in kwestie -->
              <div class="row">
                  <div class="col-md-4 col-sm-12 col-xs-12">
                    <? echo $cmter->getUsername(); ?>
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12 text-center">
                    <small><?php
                      $date = getdate(strtotime($cmt->getTimestamp()));
                      echo $date["day"]." ".$date["month"]." ".$date["mday"].", ".$date["year"];
                    ?></small>
                  </div>
                  <div class="col-md-5 col-sm-12 col-xs-12 text-right">
                    <div class="row">
                      <div class="col-md-10 col-sm-10 col-xs-10 text-center">
                        <h6><? echo 0 + $cmt->getLikes(); ?> likes</h6>
                      </div>
                      <div class="col-md-2 col-sm-2 col-xs-2 cmt-like">
                      <?
                      if(isset($_SESSION["current_user"])){
                       if(!hasLikedThisComment($cmt->getId())){ ?>
                        <form action="../controller/newCommentLikeController.php" method="post">
                          <input type="hidden" class="" name="comment_id" value="<?php echo $cmt->getId(); ?>">
                          <input type="submit" class="btn btn-light text-white" value="Like">
                        </form>
                    <?  } } ?>
                      </div
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h6 class="card-title">
                <!-- Hier tonen we de comment -->
                <? echo $cmt->getContent(); ?></h6>
            </div>
          </div></li> <?php }
          // Daarna willen we de user aanmoedigen een comment na te laten...
        }
        ?>
    </ul>
  </div>
  <div class="col-md-2 col-sm-0"></div>
</div>
</div><br/><br/><br/><br/><br/><br/><br/><br/>
