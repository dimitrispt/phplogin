<?php
require_once("includes/functions.inc.php");
require_once("includes/db.inc.php");

  if ((isset($_POST['username'])) && (isset($_POST['password']))   ) {

         $username = $_POST['username'];
         $password = $_POST['password'];
         $salt = get_salt_by_username($username);
         $hashed_password = generate_hashed_password($password, $salt);

        try {  
//Using PDO api for database access
             $dbh->beginTransaction();
             
             $SQL = "INSERT INTO users (username, hashed_password) VALUES (?,?)";
             $stmt = $dbh->prepare($SQL);
             $stmt->bindParam(1,$username);
             $stmt->bindParam(2,$hashed_password);
             $stmt->execute();

             $last_id = $dbh->lastInsertId();

             $_SESSION['user_id'] = $last_id;
             $_SESSION['username'] = $username;  
             echo "Successful Registration ( ID: $last_id ) <br/>";
             echo " <a href=\"login.php\"> Check your credentials</a>";
             exit();
             

        } catch (PDOException $e){
            $error = $e->getMessage();
            echo "Registration Failed: $error";
            error_log($error,0);
          }

    }
?>

   <form method="POST" ACTION="new_user.php">

    user:<INPUT type="text" name="username"><br />
    password:<INPUT type="password" name="password"><br />

    <input type="submit" value="SUBMIT">

    </form>
