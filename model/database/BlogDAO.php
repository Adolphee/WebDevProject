<?php
    require_once("DatabaseSingleton.php");
    // require_once("../Category.php");
    // require_once("../Blog.php");
    // require_once("../User.php");
    session_start();

    /*
      Ik gebruik overal prepared statements om SQL-injection te vermijden
    */

    //Ik moet toegeven dat ik best een CategorieDAO.php had gemaakt,
    // Maar daar heb ik nu helaas geen tijd meer voor, -->uitwerken, implementatie en overal includen zou te lang duren


    // Alle blogs ophalen
    function getAllBlogs(){
      $db = DatabaseSingleton::getInstance();
      $conn = $db->getConnection();

      /* WARNING: GIANT SQL QUERY INCOMING !!!!
         Liever 1 heavy query dan 4 aparte queries, right? :)
      */
      $sql = "SELECT
                  blogs.blog_id AS 'id',
                  blogs.user_id,
                  blogs.short_version AS 'shortVersion',
                  blogs.title,
                  blogs.content,
                  categories.name AS 'category',
                  blogs.timestamp,
                  blogs.imagepath,
                  blogs.is_enabled,
                  COUNT(comments.user_id) AS 'comments'
              FROM
                  blogs
              LEFT JOIN comments ON comments.blog_id = blogs.blog_id
              LEFT JOIN categories ON categories.category_id = blogs.category_id
              WHERE blogs.is_enabled = 1
              GROUP BY
                  blogs.blog_id,
                  blogs.user_id,
                  blogs.short_version,
                  blogs.title,
                  blogs.content,
                  blogs.timestamp,
                  blogs.imagepath,
                  categories.name
              ORDER BY blogs.timestamp DESC";

      $stmt = $conn->prepare($sql);
      //$stmt->bind_param("i", $topLimit);
      $stmt->execute();
      $res = $stmt->get_result();
      // Alle return objects gaan we hierin smijten
      $blogPosts = array();

      while($blog = $res->fetch_object('Blog'))
      {
        $stmt = $conn->prepare("SELECT count(*) AS 'likes' FROM blog_likes WHERE blog_id = ?");
        $stmt->bind_param("i", $blog->getId());
        $stmt->execute();
        $res2 = $stmt->get_result();
        $row = $res2->fetch_assoc();
        $likes = $row['likes'];
        $blog->setLikes($likes);
        // Alle objecten toevoegen aan onze array
        array_push($blogPosts, $blog);
      }
      // Connectie sluiten
      $conn->close();

      // Blog object initialiseren met de zojuist ontvangen gegevens
      // Blog object terugsturen
      return $blogPosts;
    }
    // 1 blog op halen op basis van id
    function getBlog($id){
      $db = DatabaseSingleton::getInstance();
      $conn = $db->getConnection();

      /* WARNING: GIANT SQL QUERY INCOMING !!!!
         Liever 1 heavy query dan 4 aparte queries, right? :)
      */
      $sql = "SELECT
                  blogs.blog_id AS 'id',
                  blogs.user_id,
                  blogs.short_version AS 'shortVersion',
                  blogs.title,
                  blogs.content,
                  categories.name AS 'category',
                  blogs.timestamp,
                  blogs.imagepath,
                  blogs.is_enabled,
                  blogs.category_id,
                  COUNT(blog_likes.user_id) AS 'likes'
              FROM
                  blogs
              LEFT JOIN blog_likes ON blog_likes.blog_id = blogs.blog_id
              LEFT JOIN categories ON categories.category_id = blogs.category_id
              WHERE
                  blogs.blog_id = ?
              AND blogs.is_enabled = 1
              GROUP BY
                  blogs.blog_id,
                  blogs.user_id,
                  blogs.short_version,
                  blogs.title,
                  blogs.content,
                  blogs.timestamp,
                  blogs.imagepath,
                  categories.name";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $res = $stmt->get_result();
      $blog = $res->fetch_object('Blog');

      // Connectie sluiten
      $conn->close();

      // Blog object initialiseren met de zojuist ontvangen gegevens
      // Blog object terugsturen
      return $blog;
    }

    function getUserBlogs($user_id){
        $db = DatabaseSingleton::getInstance();
        $conn = $db->getConnection();

        /* WARNING: GIANT SQL QUERY INCOMING !!!!
           Liever 1 heavy query dan 4 aparte queries, right? :)
        */
        $sql = "SELECT
                    blogs.blog_id AS 'id',
                    blogs.user_id,
                    blogs.short_version AS 'shortVersion',
                    blogs.title,
                    blogs.content,
                    categories.name AS 'category',
                    blogs.timestamp,
                    blogs.imagepath,
                    blogs.is_enabled,
                    COUNT(comments.user_id) AS 'comments'
                FROM
                    blogs
                LEFT JOIN comments ON comments.blog_id = blogs.blog_id
                LEFT JOIN categories ON categories.category_id = blogs.category_id
                WHERE
                    blogs.user_id = ?
                AND blogs.is_enabled = 1
                GROUP BY
                    blogs.blog_id,
                    blogs.user_id,
                    blogs.short_version,
                    blogs.title,
                    blogs.content,
                    blogs.timestamp,
                    blogs.imagepath,
                    categories.name
                ORDER BY blogs.timestamp DESC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $res = $stmt->get_result();
        // Alle return objects gaan we hierin smijten
        $blogPosts = array();

        while($blog = $res->fetch_object('Blog'))
        {
          $stmt = $conn->prepare("SELECT count(*) AS 'likes' FROM blog_likes WHERE blog_id = ?");
          $stmt->bind_param("i", $blog->getId());
          $stmt->execute();
          $res2 = $stmt->get_result();
          $row = $res2->fetch_assoc();
          $likes = $row['likes'];
          $blog->setLikes($likes);
          // Alle objecten toevoegen aan onze array
          array_push($blogPosts, $blog);
        }

        // Connectie sluiten
        $conn->close();

        // Blog object initialiseren met de zojuist ontvangen gegevens
        // Blog object terugsturen
        return $blogPosts;
    }

    /*
      WARNING: Ik ga niet liegen: dit is mijn grootste DAO methode
    */
    //vb: getTopBlogs(X) --> returns top X blogsposts
    function getTopBlogs(){
      $db = DatabaseSingleton::getInstance();
      $conn = $db->getConnection();

      /* WARNING: GIANT SQL QUERY INCOMING !!!!
         Liever 1 heavy query dan 4 aparte queries, right? :)
      */
      $sql = "SELECT
                  blogs.blog_id AS 'id',
                  blogs.user_id,
                  blogs.short_version AS 'shortVersion',
                  blogs.title,
                  blogs.content,
                  categories.name AS 'category',
                  blogs.timestamp,
                  blogs.imagepath,
                  blogs.is_enabled,
                  COUNT(comments.user_id) AS 'comments'
              FROM
                  blogs
              LEFT JOIN comments ON comments.blog_id = blogs.blog_id
              LEFT JOIN categories ON categories.category_id = blogs.category_id
              WHERE blogs.is_enabled = 1
              GROUP BY
                  blogs.blog_id,
                  blogs.user_id,
                  blogs.short_version,
                  blogs.title,
                  blogs.content,
                  blogs.timestamp,
                  blogs.imagepath,
                  categories.name
              ORDER BY
                  comments DESC
              LIMIT 3";

      $stmt = $conn->prepare($sql);
      //$stmt->bind_param("i", $topLimit);
      $stmt->execute();
      $res = $stmt->get_result();
      // Alle return objects gaan we hierin smijten
      $blogPosts = array();

      while($blog = $res->fetch_object('Blog'))
      {
        $stmt = $conn->prepare("SELECT count(*) AS 'likes' FROM blog_likes WHERE blog_id = ?");
        $stmt->bind_param("i", $blog->getId());
        $stmt->execute();
        $res2 = $stmt->get_result();
        $row = $res2->fetch_assoc();
        $likes = $row['likes'];
        $blog->setLikes($likes);
        // Alle objecten toevoegen aan onze array
        array_push($blogPosts, $blog);
      }
      // Connectie sluiten
      $conn->close();

      // Blog object initialiseren met de zojuist ontvangen gegevens
      // Blog object terugsturen
      return $blogPosts;
    }

    // 3 blogs ophalen van een bepaalde category behalve 1 specifieke
    function get3BlogsOfSameCategory($blogToAvoid){
      $db = DatabaseSingleton::getInstance();
      $conn = $db->getConnection();

      /* WARNING: GIANT SQL QUERY INCOMING !!!!
         Liever 1 heavy query dan 4 aparte queries, right? :)
      */
      $sql = "SELECT
                  blogs.blog_id AS 'id',
                  blogs.user_id,
                  blogs.short_version AS 'shortVersion',
                  blogs.title,
                  blogs.content,
                  categories.name AS 'category',
                  blogs.timestamp,
                  blogs.imagepath,
                  blogs.is_enabled,
                  blogs.category_id,
                  COUNT(comments.user_id) AS 'comments'
              FROM
                  blogs
              LEFT JOIN comments ON comments.blog_id = blogs.blog_id
              LEFT JOIN categories ON categories.category_id = blogs.category_id
              WHERE blogs.is_enabled = 1
              AND blogs.category_id = ?
              AND blogs.blog_id <> ?
              GROUP BY
                  blogs.blog_id,
                  blogs.user_id,
                  blogs.short_version,
                  blogs.title,
                  blogs.content,
                  blogs.timestamp,
                  blogs.imagepath,
                  categories.name
              ORDER BY
                  RAND()
              LIMIT 3";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ii", $blogToAvoid->getCategoryId(), $blogToAvoid->getId());
      $stmt->execute();
      $res = $stmt->get_result();
      // Alle return objects gaan we hierin smijten
      $blogPosts = array();

      while($blog = $res->fetch_object('Blog'))
      { // NU ga ik de likes ophalen als cijfer voor onze objecten
        $stmt = $conn->prepare("SELECT count(*) AS 'likes' FROM blog_likes WHERE blog_id = ?");
        $stmt->bind_param("i", $blog->getId());
        $stmt->execute();
        $res2 = $stmt->get_result();
        $row = $res2->fetch_assoc();
        $likes = $row['likes'];
        $blog->setLikes($likes);
        // Elk object toevoegen aan onze array
        array_push($blogPosts, $blog);
      }
      // Connectie sluiten
      $conn->close();

      // Blog object initialiseren met de zojuist ontvangen gegevens
      // Blog object terugsturen
      return $blogPosts;
    }

    // En nu gaan we ze allemaal ophalen van die ene categorie X of Y
    function getAllBlogsOfThisCategory($cat_id){
      $db = DatabaseSingleton::getInstance();
      $conn = $db->getConnection();

      /* WARNING: GIANT SQL QUERY INCOMING !!!!
         Liever 1 heavy query dan 4 aparte queries, right? :)
      */
      $sql = "SELECT
                  blogs.blog_id AS 'id',
                  blogs.user_id,
                  blogs.short_version AS 'shortVersion',
                  blogs.title,
                  blogs.content,
                  categories.name AS 'category',
                  blogs.timestamp,
                  blogs.imagepath,
                  blogs.is_enabled,
                  blogs.category_id,
                  COUNT(comments.user_id) AS 'comments'
              FROM
                  blogs
              LEFT JOIN comments ON comments.blog_id = blogs.blog_id
              LEFT JOIN categories ON categories.category_id = blogs.category_id
              WHERE blogs.is_enabled = 1
              AND blogs.category_id = ?
              GROUP BY
                  blogs.blog_id,
                  blogs.user_id,
                  blogs.short_version,
                  blogs.title,
                  blogs.content,
                  blogs.timestamp,
                  blogs.imagepath,
                  categories.name
              ORDER BY
                  blogs.timestamp DESC";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $cat_id);

      $stmt->execute();
      $res = $stmt->get_result();
      // Alle return objects gaan we hierin smijten
      $blogPosts = array();

      while($blog = $res->fetch_object('Blog'))
      { // NU ga ik de likes ophalen als cijfer voor onze objecten
        $stmt = $conn->prepare("SELECT count(*) AS 'likes' FROM blog_likes WHERE blog_id = ?");
        $stmt->bind_param("i", $blog->getId());
        $stmt->execute();
        $res2 = $stmt->get_result();
        $row = $res2->fetch_assoc();
        $likes = $row['likes'];
        $blog->setLikes($likes);
        // Elk object toevoegen aan onze array
        array_push($blogPosts, $blog);
      }
      // Connectie sluiten
      $conn->close();

      // Blog object initialiseren met de zojuist ontvangen gegevens
      // Blog object terugsturen
      return $blogPosts;
    }

    // Blogs opslaan in DB
    function saveBlog($blog){
      //Deze methode maakt gebruik van de database, dus om multiple connections te vermijden roep ik die eerst op.
      if(!is_numeric($blog->getCategory()))
        $cat_id = getBlogCategoryByName($this->getCategory())->getId();
      else $cat_id = $blog->getCategory();
      // De enige besaande database connection object aanvragen voor gebruik
      $db = DatabaseSingleton::getInstance();
      // Connectie uit dat object extracten
      $conn = $db->getConnection();
      // de parameters klaarzetten voor executie
      $stmt = $conn->prepare("INSERT INTO blogs (user_id, short_version, title, content, category_id, imagepath) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isssis", $_SESSION["current_user"]->getId(), $blog->getShortVersion(), $blog->getTitle(), $blog->getContent(), $cat_id, $blog->getImagePath());
      // echo "Content: ".$blog->getContent()."<br/>";
      // echo "Category: ".$blog->getCategory()."<br/>";
      if($stmt->execute()){
        // Connectie sluiten
        $stmt->close();
        $conn->close();
        $returnBlog = getLatestUserBlog($_SESSION["current_user"]->getId());
      } else {
        $returnBlog = $stmt->error_list;
        // Connectie sluiten
        $stmt->close();
        $conn->close();
        //var_dump($returnBlog);
      }
      //de authenticate methode haalt de ID op van de nieuwe user
      return $returnBlog;
    }

    //De meest recente blog van een bepaalde user, op die manier kan ik de Auto-incrmented ID krijgen en in een GET Request steken
    // Om de user meteen naar de detailpagina van zijn nieuwe blog te sturen
    function getLatestUserBlog($user_id){
      $db = DatabaseSingleton::getInstance();
      $conn = $db->getConnection();

      /* WARNING: GIANT SQL QUERY INCOMING !!!!
         Liever 1 heavy query dan 4 aparte queries, right? :)
      */
      $sql = "SELECT
                  blogs.blog_id AS 'id',
                  blogs.user_id,
                  blogs.short_version AS 'shortVersion',
                  blogs.title,
                  blogs.content,
                  categories.name AS 'category',
                  blogs.timestamp,
                  blogs.imagepath,
                  blogs.is_enabled,
                  COUNT(comments.user_id) AS 'comments'
              FROM
                  blogs
              LEFT JOIN comments ON comments.blog_id = blogs.blog_id
              LEFT JOIN categories ON categories.category_id = blogs.category_id
              WHERE
                  blogs.user_id = ?
              AND blogs.is_enabled = 1
              GROUP BY
                  blogs.blog_id,
                  blogs.user_id,
                  blogs.short_version,
                  blogs.title,
                  blogs.content,
                  blogs.timestamp,
                  blogs.imagepath,
                  categories.name
              ORDER BY blogs.timestamp DESC
              LIMIT 1 ";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $res = $stmt->get_result();
      $blog = $res->fetch_object('Blog');

      $stmt = $conn->prepare("SELECT count(*) AS 'likes' FROM blog_likes WHERE blog_id = ?");
      $stmt->bind_param("i", $blog->getId());
      $stmt->execute();
      $res2 = $stmt->get_result();
      $row = $res2->fetch_assoc();
      $likes = $row['likes'];
      $blog->setLikes($likes);
      // Connectie sluiten en object terugsturen
      $conn->close();
      return $blog;
    }

    // Deze is vanzelfsprekend
    function updateBlog($blog){
      // Category_id ophalen
      $cat_id = $blog->getCategoryId();
      // De enige besaande database connection object aanvragen voor gebruik
      $db = DatabaseSingleton::getInstance();
      // Connectie uit dat object extracten
      $conn = $db->getConnection();
      // Query klaarzetten
      $sql = "UPDATE blogs
              SET
                  short_version = ?,
                  title = ?,
                  content = ?,
                  category_id = ?,
                  imagepath = ?,
                  is_enabled = ?
              WHERE
                  blog_id = ?";
      // de parameters klaarzetten voor executie
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sssisii", $blog->getShortVersion(), $blog->getTitle(), $blog->getContent(), $cat_id, $blog->getImagePath(), $blog->is_enabled(), $blog->getId());
      $stmt->execute();
      // Als er iets fout loopt moeten we dat kunnen weten
      if($stmt->affected_rows < 1) {
        var_dump($stmt->error_list);
      }

      // Connectie sluiten
      $stmt->close();
      $conn->close();

      // Als er niet fout gelopen is sturen we het object gewoon terug want die is up-to-date
      return $blog;
    }

    //De blogcategorie-object ophalen op basis van een naam
    function getBlogCategoryByName($cat_name){
      $db = DatabaseSingleton::getInstance();
      $conn = $db->getConnection();
      $sql = "SELECT * FROM categories WHERE UPPER(name) = ?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", strtoupper($cat_name));
      $stmt->execute();
      $res = $stmt->get_result();
      $cat = $res->fetch_object("Category");
      // Connectie sluiten en object terugsturen
      $conn->close();
      return $cat;
    }

    // Alle blogcategoriën ophalen
    function getAllBlogCategories(){
      $db = DatabaseSingleton::getInstance();
      $conn = $db->getConnection();
      $stmt = $conn->prepare("SELECT * from categories");;
      $stmt->execute();
      $res = $stmt->get_result();

      // Alle return objects gaan we hierin smijten
      $categories = array();

      while($cat = $res->fetch_object('Category'))
      {
        // Alle objecten toevoegen aan onze array
        array_push($categories, $cat);
      }

      // Connectie sluiten
      $conn->close();

      // Blog object initialiseren met de zojuist ontvangen gegevens
      // Blog object terugsturen
      return $categories;
    }

    // 3 random blogs ophalen uit de voorbije 30 dagen
    function getRandies($toppies){

      $db = DatabaseSingleton::getInstance();
      $conn = $db->getConnection();

      /*
        WARNING: Ik ga heb gelogen: dit is mijn grootste DAO methode
      */
      $sql = "SELECT DISTINCT
                  blogs.blog_id AS 'id',
                  blogs.user_id,
                  blogs.short_version AS 'shortVersion',
                  blogs.title,
                  blogs.content,
                  categories.name AS 'category',
                  blogs.timestamp,
                  blogs.imagepath,
                  blogs.is_enabled,
                  COUNT(comments.user_id) AS 'comments'
              FROM
                  blogs
              LEFT JOIN comments ON comments.blog_id = blogs.blog_id
              LEFT JOIN categories ON categories.category_id = blogs.category_id
              WHERE blogs.is_enabled = 1
              AND blogs.timestamp >=(NOW() - INTERVAL 1 MONTH)
              AND blogs.blog_id not in (?,?,?)
              GROUP BY
                  blogs.blog_id,
                  blogs.user_id,
                  blogs.short_version,
                  blogs.title,
                  blogs.content,
                  blogs.timestamp,
                  blogs.imagepath,
                  categories.name
              ORDER BY
                  RAND()
              LIMIT 3";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("iii", $toppies[0]->getId(),$toppies[1]->getId(),$toppies[2]->getId());
      $stmt->execute();
      $res = $stmt->get_result();
      // Alle return objects gaan we hierin smijten
      $blogPosts = array();

      while($blog = $res->fetch_object('Blog'))
      {
        $stmt = $conn->prepare("SELECT count(*) AS 'likes' FROM blog_likes WHERE blog_id = ?");
        $stmt->bind_param("i", $blog->getId());
        $stmt->execute();
        $res2 = $stmt->get_result();
        $row = $res2->fetch_assoc();
        $likes = $row['likes'];
        $blog->setLikes($likes);
        // Alle objecten toevoegen aan onze array
        array_push($blogPosts, $blog);
      }

      // Connectie sluiten
      $conn->close();

      // Blog object initialiseren met de zojuist ontvangen gegevens
      // Blog object terugsturen
      return $blogPosts;
    }


    // +1 like voor een blog
    function bLike($blog_id){
      //Singletom object aanvragen
      $db = DatabaseSingleton::getInstance();
      // Connectie uit dat object extracten
      $conn = $db->getConnection();
      // de parameters klaarzetten voor executie
      $stmt = $conn->prepare("INSERT INTO blog_likes (user_id, blog_id) VALUES (?, ?)");
      $stmt->bind_param("ii", $_SESSION["current_user"]->getId(), $blog_id);
      if($stmt->execute()){
        // Connectie sluiten
        $stmt->close();
        $conn->close();
        return true;
      } else {
        $returnBlog = $stmt->error_list;
        // Connectie sluiten
        $stmt->close();
        $conn->close();
        return false;
      }
    }

    // Om te checken of de user een bepaalde blog al geliked heeft of niet
    function hasLikedThisBlog($blog_id){
      if($_SESSION["current_user"]){
        $db = DatabaseSingleton::getInstance();
        $conn = $db->getConnection();
        $sql = "select count(*) as 'has_liked' from blog_likes where user_id = ? && blog_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii",$_SESSION["current_user"]->getId(), $blog_id);
        $stmt->execute();

        $res = $stmt->get_result();
        $hasLiked = $res->fetch_assoc();
        // Connectie sluiten en object terugsturen
        $conn->close();
        return $hasLiked["has_liked"] > 0;
      }
     }

     function saveCat($cat){
       $db = DatabaseSingleton::getInstance();
       // Connectie uit dat object extracten
       $conn = $db->getConnection();
       // de parameters klaarzetten voor executie
       $stmt = $conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
       $stmt->bind_param("ss", $cat->getName(), $cat->getDescription());
       if($stmt->execute()){
         // Connectie sluiten
         $stmt->close();
         $conn->close();
         return true;
       } else {
         $stmt->close();
         $conn->close();
         return false;
       }
     }

     // $cat = new Category();
     // $cat->setName("Good Stuff");
     // $cat->setDescription("We know you like dat good sh*t !!");
     //
     // var_dump(saveCat($cat));

     // $b1 = getBlog(40);
     //
     // $b = get3BlogsOfSameCategory($b1);
     // //var_dump($b1->getCategoryId());
     // var_dump($b);

     // $b1 = getBlog(40);
     // $b = get3BlogsOfSameCategory($b1);
     //
     // var_dump($b);

    ?>
