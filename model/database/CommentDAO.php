<?php
     // require_once('../Comment.php');
     // require_once("../User.php");
     // require_once("UserDAO.php");
    require_once("DatabaseSingleton.php");
    session_start();

    /*
      Ik gebruik overal prepared statements om SQL-injection te vermijden
    */

    function getBlogComments($blog_id){
        $db = DatabaseSingleton::getInstance();
        $conn = $db->getConnection();

        /*
           WARNING: GIANT SQL QUERY INCOMING !!!!
           Liever 1 heavy query dan 4 aparte queries, right? :)
        */
        $sql = "select * FROM comments WHERE blog_id = ? order by timestamp desc";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $blog_id);
        $stmt->execute();

        $res = $stmt->get_result();

        // Alle return objects gaan we hierin smijten
        $comments = array();

        while($comment = $res->fetch_object('Comment'))
        {
          $stmt = $conn->prepare("SELECT count(*) AS 'likes' FROM comment_likes WHERE comment_id = ?");
          $stmt->bind_param("i", $comment->getId());
          $stmt->execute();
          $res2 = $stmt->get_result();
          $row = $res2->fetch_assoc();
          $likes = $row['likes'];
          $comment->setLikes($likes);
          // Alle objecten toevoegen aan onze array
          array_push($comments, $comment);

        }

        // Connectie sluiten
        $conn->close();

        // object initialiseren met de zojuist ontvangen gegevens
        // object terugsturen
        return $comments;
    }


    function saveComment($comment){
      // De enige besaande database connection object aanvragen voor gebruik
      $db = DatabaseSingleton::getInstance();
      // Connectie uit dat object extracten
      $conn = $db->getConnection();
      // de parameters klaarzetten voor executie
      $stmt = $conn->prepare("insert INTO comments (blog_id, user_id, content) VALUES (?,?,?)");
      $stmt->bind_param("iis", $comment->getBlogId(), $id, $comment->getContent());
      $id = $_SESSION["current_user"]->getId();

      if($stmt->execute()){
        //de authenticate methode haalt de ID op van de nieuwe user
        return getLatestUserComment($id);
      } else {
        var_dump($stmt->error_list);
      }
      // Connectie sluiten
      $stmt->close();
      $conn->close();


    }

    function getLatestUserComment($id){
      $db = DatabaseSingleton::getInstance();
      $conn = $db->getConnection();
      $sql = "select * from comments where user_id = ? order by timestamp limit 1";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();

      $res = $stmt->get_result();
      $comment = $res->fetch_object('Comment');
      // Connectie sluiten en object terugsturen
      $conn->close();
      return $comment;
    }
    function cLike($comment){
      //Singletom object aanvragen
      $db = DatabaseSingleton::getInstance();
      // Connectie uit dat object extracten
      $conn = $db->getConnection();
      // de parameters klaarzetten voor executie
      $stmt = $conn->prepare("INSERT INTO comment_likes (user_id, comment_id) VALUES (?, ?)");
      $stmt->bind_param("ii", $_SESSION["current_user"]->getId(), $comment);
      if($stmt->execute()){
        // Connectie sluiten
        $stmt->close();
        $conn->close();
        return true;
      } else {
        $returnComment = $stmt->error_list;
        // Connectie sluiten
        $stmt->close();
        $conn->close();
        return false;
      }
    }

    function hasLikedThisComment($cmt_id){
      if($_SESSION["current_user"]){
        $db = DatabaseSingleton::getInstance();
        $conn = $db->getConnection();
        $sql = "select count(*) as 'has_liked' from comment_likes where user_id = ? && comment_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii",$_SESSION["current_user"]->getId(), $cmt_id);
        $stmt->execute();

        $res = $stmt->get_result();
        $hasLiked = $res->fetch_assoc();
        // Connectie sluiten en object terugsturen
        $conn->close();
        return $hasLiked["has_liked"] > 0;
      }
      return false;
    }

    function updateComment($comment){
      // TODO: implement update method
    }

     //var_dump(getBlogComments(26));

    // $cmt_to_post = new Comment();
    // $cmt_to_post->setUserId(4);
    // $cmt_to_post->setBlogId(1);
    // $cmt_to_post->setContent("I thought you were supposed to speak English...");
    // $cmt_to_post = saveComment($cmt_to_post);
    //
    // var_dump($cmt_to_post);


?>
