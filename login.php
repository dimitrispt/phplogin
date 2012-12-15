<?php
require_once("includes/functions.inc.php");
require_once("includes/db.inc.php");

session_start();

//Check if user has already logged in
if (isset($_SESSION['user_id'])){
    echo "Hello {$_SESSION['username']} ";
    exit();
} 
else {?>

<!-- HTML login form -->    
    <form method="POST" ACTION="login.php">

    user:<INPUT type="text" name="username"><br />
    password:<INPUT type="password" name="password"><br />

    <input type="submit" value="SUBMIT">

    </form>
<p><a href="new_user.php">Register new user</a></p>  

<?php    
//If user submitted credentials, check them on the database
    if ((isset($_POST['username'])) && (isset($_POST['password']))   ) {

         $username = $_POST['username'];
         $password = $_POST['password'];
         $salt = get_salt_by_username($username);
         $hashed_password = generate_hashed_password($password, $salt);

        try {  

//Using PDO api for database access
             $SQL = "SELECT id,username FROM users WHERE username = ? 
                 AND hashed_password = ?";
             $stmt = $dbh->prepare($SQL);
             $stmt->bindParam(1,$username);
             $stmt->bindParam(2,$hashed_password);
             $stmt->execute();

             $found_user = $stmt->fetch();
             $row_Count = $stmt->rowCount();

              if ($row_Count == 1) { //if correct user/pwd
                $_SESSION['user_id'] = $found_user['id'];
                $_SESSION['username'] = $found_user['username'];  
                exit();
              } else echo "Login Failed: Wrong Username or Password" ;


        } catch (PDOException $e){
            $error = $e->getMessage();
            echo "Login Failed: $error";
            error_log($error,0);
          }

    }

}

?>

