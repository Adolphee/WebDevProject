<?php
    //include('../User.php');
    require_once("DatabaseSingleton.php");

    /*
      Ik gebruik overal prepared statements om SQL-injection te vermijden
    */

    function getUser($id){
        $db = DatabaseSingleton::getInstance();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("select * from users where user_id = ?");
        $stmt->bind_param("i", $identifier);

        $identifier = $id;
        $stmt->execute();
        $res = $stmt->get_result();

        $stmt->close();
        $conn->close();
        return $res->fetch_object("User");
    }

    function authenticate($username, $pwd){
      // De enige besaande database connection object aanvragen voor gebruik
      $db = DatabaseSingleton::getInstance();
      // Connectie uit dat object extracten
      $conn = $db->getConnection();
      //
      $stmt = $conn->prepare("select
                                    user_id,
                                    username,
                                    firstname,
                                    lastname,
                                    email,
                                    password,
                                    is_enabled,
                                    is_admin
                            FROM users
                            WHERE username = ?
                            && password = ?
                            && is_enabled = 1");
      $stmt->bind_param("ss", $user, $pass);

      // de parameters klaarzetten voor executie
      $user = $username;
      $pass = $pwd;
      $stmt->execute();
      $res = $stmt->get_result();

      $stmt->close();
      $conn->close();
      //var_dump($res->fetch_object("User"));
      return $res->fetch_object("User");
    }

    function saveUser($user){
      // De enige besaande database connection object aanvragen voor gebruik
      $db = DatabaseSingleton::getInstance();
      // Connectie uit dat object extracten
      $conn = $db->getConnection();
      // de parameters klaarzetten voor executie
      $stmt = $conn->prepare("insert into users (username, firstname, lastname, email, password, is_enabled, is_admin) values (?,?,?,?,?,?,?)");
      $stmt->bind_param("sssssii", $user->getUsername(), $user->getFirstname(), $user->getLastname(), $user->getEmail(), $user->getPassword(), $user->isEnabled(), $user->isAdmin());
      $stmt->execute();

      // Connectie sluiten
      $stmt->close();
      $conn->close();

      //de authenticate methode haalt de ID op van de nieuwe user
      return authenticate($user->getUsername(), $user->getPassword());
    }

    function updateUser($user){
      if(checkId($user->getId())){
        // De enige besaande database connection object aanvragen voor gebruik
        $db = DatabaseSingleton::getInstance();
        // Connectie uit dat object extracten
        $conn = $db->getConnection();
        // de parameters klaarzetten voor executie
        $stmt = $conn->prepare("update users set username = ?, firstname = ?, lastname = ?, email = ?, password = ?, is_enabled = ?, is_admin = ? where user_id = ?");
        $stmt->bind_param("sssssiii", $user->getUsername(), $user->getFirstname(), $user->getLastname(), $user->getEmail(), $user->getPassword(), $user->isEnabled(), $user->isAdmin(), $user->getId());
        $stmt->execute();

        if($stmt->affected_rows < 1){
          $user = null;
        }

        // Connectie sluiten
        $stmt->close();
        $conn->close();

        //de authenticate methode haalt de ID op van de nieuwe user
        return $user;
      } else return null;
    }



?>
