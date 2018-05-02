
<!-- in deze file zit zowel sidebar als headerbalk -->


<nav id="sidebar" style="margin-left: 0px;">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <h3>BloggieMan™ </h3>
    </div>

    <!-- Sidebar Links -->
    <ul class="list-unstyled components">
          <?php
          //vooralleer we php gebruiken, de nodige files includen
          if(!$GLOBALS['isValidationPage']){
            require_once("../model/Blog.php");
            require_once("../model/database/BlogDAO.php");
            require_once("../model/Category.php");
          } else {
            require_once("../Blog.php");
            require_once("../database/BlogDAO.php");
            require_once("../Category.php");
          }
          // Op de blogDetail page tonen we andere blogs dan ergens anders
          if($_SESSION["current_page"] == "blogDetail"){
            $topBlogs = get3BlogsOfSameCategory($blogToShow);
          } else  $topBlogs = getTopBlogs();
          if($_SESSION["current_page"] == "blogOverview") $allCategories = getAllBlogCategories();
          // Het is zinloos om de sidebar te tonen als de user niet ingelogd is
          // omdat hij daar toch niets mee kan doen, we tonen een loginform
          if(!isset($_SESSION["current_user"])){
            include("forms/loginForm.php");
            include("sidebarBloglist.php");
          } else {

          ?>
        <li class="subMenuItem"><a class="subMenuLink" href="index.php">Home</a></li>
        </li>
        <!-- <li class="subMenuItem">
        <a class="subMenuLink" href="">My profile</a>
        </li> -->
        <?php
          include("sidebarBloglist.php");
         if(isset($_SESSION["isAdmin"])){ ?>
        <li class="subMenuItem"><a class="subMenuLink" href="/~adolphe.m/WDA/Blog/view/settings.php">Settings</a></li>
      <?php } if(isset($_SESSION["current_user"])){ ?>
          <li>
            <a class="" id="logout_btn" href="../controller/logoutController.php">Log Out</a>
          </li>
        <?php } } ?>
    </ul>
</nav>

  <div id="topBar">
      <span>

          <nav class="myNavBar navbar navbar-expand-lg navbar-light bg-light">
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">Show Menu</button>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link" href="/~adolphe.m/WDA/Blog/view/index.php#Dashboard">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/~adolphe.m/WDA/Blog/view/blogOverview.php#Blogs">Blogs</a>
                </li>
  <?php if(isset($_SESSION["current_user"])) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="/~adolphe.m/WDA/Blog/view/myBlogs.php#My-Blogs">My blogs</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/~adolphe.m/WDA/Blog/view/newBlog.php#Create-Blog">Create Blog</a>
                </li>
              </ul>
              <!-- <form id="searchbar" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form> -->
            </div>
            <?php
          } ?>
          </nav>
      </span>
  </div>
