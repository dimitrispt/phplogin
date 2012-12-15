<?php
///////using PDO API for Database access\\\\\\\\\

//Database connection
$user = "user";
$pass ="password";
$db   = "phplogin";
$host = "localhost";


    try {
          $dbh = new PDO("mysql: host= $host;dbname=$db", $user, $pass);
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
           $error = $e->getMessage();
           echo "Can't connect to database. Error: $error";
           error_log($error, 0);
           exit;      
    }
    
//Database functions
//...
?>