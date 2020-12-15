<?php

//validate input
if (!isset($_POST['user_email'])) {
    sendError(400, 'missing email', __LINE__);
};
if (!isset($_POST['user_password'])) {
    sendError(400, 'missing password', __LINE__);
};
if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
    sendError(400, 'email is not valid', __LINE__);
};
if (strlen($_POST['user_password']) < 2) {
    sendError(400, 'password must be at least 2 characters', __LINE__);
}
if (strlen($_POST['user_password']) > 5) {
    sendError(400, 'password cannot be longer than 5 characters', __LINE__);
}

//connect to db
require_once(__DIR__ . '/../private/db.php');

try {
    $query = $db->prepare('SELECT * FROM users WHERE user_email = :user_email LIMIT 1');
    $query->bindValue(':user_email', $_POST['user_email']);
    $query->execute();
    $jRow = $query->fetch();

    if (password_verify($_POST['user_password'], $jRow->user_password)) {
        //create session
        session_start();
        $_SESSION['user_id'] = $jRow->user_id;
        $_SESSION['user_name'] = $jRow->user_name;
        $_SESSION['user_lastname'] = $jRow->user_lastname;
        $_SESSION['user_username'] = $jRow->user_username;
        $_SESSION['user_email'] = $jRow->user_email;
        $_SESSION['user_profileimage'] = $jRow->user_imagepath;
        header('Content-Type: application/json');
        echo '{"message":"user logged in"}';
        exit();
    }
    sendError(401, 'wrong username or/and password', __LINE__);
} catch (PDOException $ex) {
    sendError(500, 'system under maintainance', __LINE__);
}








##################
##################
##################



function sendError($iResponseCode, $sMessage, $iLine)
{
    http_response_code($iResponseCode);
    header('Content-Type: application/json');
    echo '{"message": "' . $sMessage . '", "error": "' . $iLine . '"}';
    exit();
}
