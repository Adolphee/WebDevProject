<?php
  define("DB_SERVER", "localhost");
  define("DB_USER", "18WDA021");
  define("DB_PASS", "64235879");
  define("DB_NAME", "18WDA021");

  /*
    Met de Singleton design pattern kan ik mezelf garanderen dat er nooit meer dan 1 actieve connectie zal gelegd worden met de database
  */

  class DatabaseSingleton
  {
    private static $dbStingleton = null;

    private function __construct(){
    }

    public static function getInstance(){
      if(self::$dbStingleton == null){
        self::$dbStingleton = new DatabaseSingleton();
      }
      return self::$dbStingleton;
    }

    public function getConnection(){
       $conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if($conn->connect_error)
        return null;
        else return $conn;
    }
  }

 ?>
