<?php
session_start();
  if($_SESSION["current_user"] != null){
    unset($_SESSION["current_user"]);
    unset($_SESSION["isAdmin"]);
    session_unset();
    session_destroy();
  }
  header("location: ../view/index.php");
?>
