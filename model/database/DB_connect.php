
<?php
define("DB_SERVER", "localhost");
define("DB_USER", "18WDA021");
define("DB_PASS", "64235879");
define("DB_NAME", "18WDA021");

$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
} else {
    echo 'Success... <br/>';
     $mysqli->close();
       }





?>
