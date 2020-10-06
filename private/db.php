<?php

try{
  $var = $vara;
  $dbUserName = 'user_one';
  $dbPassword = '123456'; // root | admin
  $dbConnection = 'mysql:host=localhost; dbname=Twitter; charset=utf8mb4'; 
  // utf8 every character in the world
  // utf8mb4 every character and also emojies
  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // try-catch
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC 
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NUM 
  ];
  $db = new PDO(  $dbConnection, 
                  $dbUserName, 
                  $dbPassword , 
                  $options );
}catch(PDOException $ex){
  http_response_code(500);
  header("content-type: application/json");
  echo '{"message": "Contact the system admin about error: '.__LINE__.'"}';
  exit();
}















