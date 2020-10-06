<?php

//validate input fields
if(! isset($_POST['name'])){ sendError(400, 'missing name', __LINE__); }
if(! isset($_POST['lastname'])){ sendError(400, 'missing lastname', __LINE__); }
if(! isset($_POST['username'])){ sendError(400, 'missing username', __LINE__); }
if(! isset($_POST['email'])){ sendError(400, 'missing email', __LINE__); }
if(! isset($_POST['password'])){ sendError(400, 'missing password', __LINE__); }
if(! isset($_POST['repeatedPassword'])){ sendError(400, 'missing confirm password', __LINE__); }
if(strlen($_POST['name']) < 2){ sendError(400, 'name must be at least 2 characters', __LINE__); }
if(strlen($_POST['name']) > 20){ sendError(400, 'name cannot be longer than 5 characters', __LINE__); }
if(strlen($_POST['lastname']) < 2){ sendError(400, 'lastname must be at least 2 characters', __LINE__); }
if(strlen($_POST['lastname']) > 20){ sendError(400, 'lastname cannot be longer than 5 characters', __LINE__); }
if(strlen($_POST['username']) < 2){ sendError(400, 'username must be at least 2 characters', __LINE__); }
if(strlen($_POST['username']) > 5){ sendError(400, 'username cannot be longer than 5 characters', __LINE__); }
if(! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ sendError(400, 'email is not valid', __LINE__); };
if(strlen($_POST['password']) < 2){ sendError(400, 'password must be at least 2 characters', __LINE__); }
if(strlen($_POST['password']) > 5){ sendError(400, 'password cannot be longer than 5 characters', __LINE__); }
if($_POST['password'] != $_POST['repeatedPassword']){ sendError(400, 'passwords do not match', __LINE__); }

//get the db file
require_once(__DIR__.'/../private/db.php');

try{
    
    //check if the email is already in use
    $query = $db->prepare('SELECT * FROM users WHERE sEmail = :sEmail LIMIT 1');
    $query->bindValue(':sEmail', $_POST['email']);
    $query->execute();
    $aRow = $query->fetch();
    if($aRow){
        sendError(500, 'email already in use', __LINE__);
    }
    

    //prepare insert and execute
    $query = $db->prepare('INSERT INTO users VALUES (:iId, :sName, :sLastName, :sUserName, :sEmail, :sPassword, :bActive, :sVerificationCode, NOW())');
    $query->bindValue(':iId', NULL);
    $query->bindValue(':sName', $_POST['name']);
    $query->bindValue(':sLastName', $_POST['lastname']);
    $query->bindValue(':sUserName', $_POST['username']);
    $query->bindValue(':sEmail', $_POST['email']);
    $query->bindValue(':sPassword', password_hash($_POST['password'], PASSWORD_DEFAULT));
    $query->bindValue(':bActive', 0);
    $query->bindValue(':sVerificationCode', uniqid());
    $query->execute();

    //create session
    session_start();
    $_SESSION['iUserId'] = $db->lastInsertId();
    $_SESSION['sUserName'] = $_POST['name'];
    $_SESSION['sUserLastname'] = $_POST['lastname'];
    $_SESSION['sUserEmail'] = $_POST['email'];
    
    //send positive message
    http_response_code(200);
    header("content-type: application/json");
    echo '{"id": "'.$db->lastInsertId().'"}';

} catch (PDOException $ex) {
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