<?php
//place all the basic functions here

/**
 * 
 * @param type $username
 * @return type
 */
function generate_salt($username){
  
  $salt = hash("whirlpool", rand(0,100).$username.microtime());
  $salt = substr($salt,rand(0,10),10);
  return $salt;
}

/**
 * 
 * @param type $password
 * @param type $salt
 * @return type
 */
function generate_hashed_password($password, $salt){
  $company_name = "widget_corp";
  
  $hpassword = $salt.$password.$company_name;
  $hashed_password = hash("whirlpool", $hpassword);
  return $hashed_password;
  
}

/**
 * 
 * @global type $dbh
 * @param type $username
 * @return type
 */
function get_salt_by_username($username){
  global $dbh;  
  

  $SQL = "SELECT salt FROM users WHERE username=?";
  $stmt = $dbh->prepare($SQL);
  $stmt->bindParam(1, $username);
  $stmt->execute();
  
  $salts = $stmt->fetch();
  
 if (count($salts)!=0) {
      $salt = $salts['salt'];  
      return $salt;
}

  
}

/**
 * 
 * @global type $dbh
 * @param type $username
 * @return type
 */
function search_username($username) {
  global $dbh;
      $SQL = "select * from users where username = ?";
      $stmtp = $dbh->prepare($SQL);
      $stmtp->bindParam(1,$username);
      $stmtp->execute();
      
      $found_username = $stmtp->fetchAll();
    
   return $found_username;
}


?>