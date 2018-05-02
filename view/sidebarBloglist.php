<li class="subMenuItem">
    <a id="#homeSubmenu1Toggle" class="collapsed subMenuLink subMenuDD2" href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">
      <?php if($_SESSION["current_page"] != "blogDetail") echo "Trending (Top 3)"; else echo $blogToShow->getCategory(); ?>
    </a>
    <ul class="collapse list-unstyled" id="homeSubmenu">
      <!--
        Vanaf hier ga ik de 3 populairste blogs 1 voor 1
        inserten in de sidebar
      -->
      <?php
        if($topBlogs != NULL){
        foreach($topBlogs as $index=>$blog)
        { ?>
        <!-- Om in blogDetail.php te weten welke blog we moeten getContent
             zal ik de blogId meegeven als parameter in de queryString -->
        <li><a class="" href="<?php echo "blogDetail.php?id=".$blog->getId(); ?>">
          <div class="card sideCard text-white <?php
          //Ik wil dat elk topBlog kaartje een ander kleur heeft uit de volgeende 3
            $i = $index%3;
            switch($i){
              case 0: echo "bg-primary"; break;
              case 1: echo "bg-info"; break;
              case 2: echo "bg-success"; break;
              default: echo "bg-info"; break;
            }
           ?> mb-3" style="max-width: 18rem;">
            <div class="card-header">
              <!-- Hier tonen we de aantal likes van de blog in kwestie -->
              <? echo $blog->getNumberOfComments(); ?> cmts</div>
            <div class="card-body">
              <h6 class="card-title">
                <!-- Hier tonen we de titel -->
                <? echo $blog->getTitle(); ?></h6>
            </div>
          </div>
        </a></li> <?php }
          // Als er iets fout loopt melden we dat...
        }
        else { ?>
            <li>
              <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">ERROR</div>
                <div class="card-body">
                  <h5 class="card-title">No Blogs Found</h5>
                </div>
              </div></li>
          <?php } ?>
    </ul>
</li>
<?php if($_SESSION["current_page"] == "blogOverview"){ ?>
  <li class="subMenuItem">
      <a id="#homeSubmenu2Toggle" class="collapsed subMenuLink subMenuDD2" href="#homeSubmenu2" data-toggle="collapse" aria-expanded="false">
        Categories
      </a>
      <ul class="collapse list-unstyled" id="homeSubmenu2">
        <!--
          Vanaf hier ga ik de 3 populairste blogs 1 voor 1
          inserten in de sidebar
        -->
        <?php
          if($allCategories != NULL){
          foreach($allCategories as $index=>$cat)
          { ?>
          <!-- Om in blogDetail.php te weten welke blog we moeten getContent
               zal ik de blogId meegeven als parameter in de queryString -->
          <li>
            <a class="nav-link" href="blogOverview.php?id=<?php echo $cat->getId(); ?>"> <?php echo $cat->getName();  ?>  </a>
          </li>
        <?php }
            // Als er iets fout loopt melden we dat...
          }
          else { ?>
              <li>
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                  <div class="card-header">ERROR</div>
                  <div class="card-body">
                    <h5 class="card-title">No Blogs Found</h5>
                  </div>
                </div></li>
            <?php } ?>
      </ul>
  </li>


 <?php } ?>
