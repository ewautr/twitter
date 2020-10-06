<?php

//validate input
if (! isset($_POST['email'])){ sendError(400, 'missing email', __LINE__); };
if (! isset($_POST['password'])){ sendError(400, 'missing password', __LINE__); };
if(! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ sendError(400, 'email is not valid', __LINE__); };
if(strlen($_POST['password']) < 2){ sendError(400, 'password must be at least 2 characters', __LINE__); }
if(strlen($_POST['password']) > 5){ sendError(400, 'password cannot be longer than 5 characters', __LINE__); }

//connect to db
require_once(__DIR__.'/../private/db.php');

try {
    $query = $db->prepare('SELECT * FROM users WHERE sEmail = :sEmail LIMIT 1');
    $query->bindValue(':sEmail', $_POST['email']);
    $query->execute();
    $aRow = $query->fetch();
    
    if(password_verify($_POST['password'], $aRow[5])){
        session_start();
        $_SESSION['iUserId'] = $aRow[0];
        $_SESSION['sUserName'] = $aRow[3];
        $_SESSION['sUserLastname'] = $aRow[2];
        $_SESSION['sUserEmail'] = $aRow[4];
        header('Content-Type: application/json');
        echo '{"message":"user logged in"}';
        exit();
    }

   sendError(401, 'wrong username or/and password', __LINE__);

}catch (PDOException $ex) {
    sendError(500, 'system under maintainance', __LINE__);
}








##################
##################
##################



function sendError($iResponseCode, $sMessage, $iLine){
    http_response_code($iResponseCode);
    header('Content-Type: application/json');
    echo '{"message": "'.$sMessage.'", "error": "'.$iLine.'"}';
    exit();
}