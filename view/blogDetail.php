<?php

require_once("../model/Blog.php");
require_once("../model/User.php");
require_once("../model/Comment.php");
require_once("../model/database/UserDAO.php");
require_once("../model/database/BlogDAO.php");
require_once("../model/database/CommentDAO.php");
session_set_cookie_params(604800);
session_start();
$_SESSION["current_page"] = "blogDetail";

// blog_id terug uit de session halen want nu is ie niet meer nodig
unset($_SESSION["blog_id"]);
if(!isset($_GET["id"])) {
    // Als de id in de QueryString niet set is ==> index
    header("location: index.php");
  } //Is het een GET, dan halen we onze blog uit de queryString
  else $blogToShow = getBlog($_GET["id"]);
  /* Ik maak me zorgen dat een user handmatig id's gaat proberen in te geven
     in de querystring... indien het een id is van een onbestaande blog zal
     mySQL esxceptions smijten..
    om awekward foutmeldingen te vermijden,
    stuur ik de user gewoon naar de index als de blog niet bestaat
  */
  if($blogToShow == null) header("location: index.php");
  include("htmlHeadingIndex.php");
  include("sidebar.php");
?>
 <div id="content" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
   <?    ?>
     <div class="container" id="contentContainer1">
       <?php include("blogDetailById.php"); ?>
     </div>
 </div>

 <?php
  //unset($_GET['id']);
 include("footer.html");
?>
