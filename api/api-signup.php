<?php

//validate input fields
if (!isset($_POST['user_name'])) {
    sendError(400, 'missing name', __LINE__);
}
if (!isset($_POST['user_lastname'])) {
    sendError(400, 'missing lastname', __LINE__);
}
if (!isset($_POST['user_username'])) {
    sendError(400, 'missing username', __LINE__);
}
if (!isset($_POST['user_email'])) {
    sendError(400, 'missing email', __LINE__);
}
if (!isset($_POST['user_password'])) {
    sendError(400, 'missing password', __LINE__);
}
if (!isset($_POST['user_repeatedPassword'])) {
    sendError(400, 'missing confirm password', __LINE__);
}
if (strlen($_POST['user_name']) < 2) {
    sendError(400, 'name must be at least 2 characters', __LINE__);
}
if (strlen($_POST['user_name']) > 50) {
    sendError(400, 'name cannot be longer than 5 characters', __LINE__);
}
if (strlen($_POST['user_lastname']) < 2) {
    sendError(400, 'lastname must be at least 2 characters', __LINE__);
}
if (strlen($_POST['user_lastname']) > 50) {
    sendError(400, 'lastname cannot be longer than 5 characters', __LINE__);
}
if (strlen($_POST['user_username']) < 2) {
    sendError(400, 'username must be at least 2 characters', __LINE__);
}
if (strlen($_POST['user_username']) > 50) {
    sendError(400, 'username cannot be longer than 5 characters', __LINE__);
}
if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
    sendError(400, 'email is not valid', __LINE__);
};
if (strlen($_POST['user_password']) < 2) {
    sendError(400, 'password must be at least 2 characters', __LINE__);
}
if (strlen($_POST['user_password']) > 50) {
    sendError(400, 'password cannot be longer than 5 characters', __LINE__);
}
if ($_POST['user_password'] != $_POST['user_repeatedPassword']) {
    sendError(400, 'passwords do not match', __LINE__);
}
if (strlen($_POST['user_image']) == 0) {
    $_POST['user_image'] = '/default_user.img';
}
if (strlen($_POST['user_phonenumber']) == 0) {
    $_POST['user_phonenumber'] = NULL;
}

//get the db file
require_once(__DIR__ . '/../private/db.php');

try {

    //check if the email is already in use
    $query = $db->prepare('SELECT * FROM users WHERE user_email = :user_email LIMIT 1');
    $query->bindValue(':user_email', $_POST['user_email']);
    $query->execute();
    $aRow = $query->fetch();
    if ($aRow) {
        sendError(500, 'email already in use', __LINE__);
    }


    //prepare insert and execute
    $query = $db->prepare('INSERT INTO users VALUES (:user_id, :user_name, :user_lastname, :user_username, :user_email, :user_phonenumber, :user_password, CURRENT_TIMESTAMP, :user_image, :user_follows, :user_followers, :user_active)');
    $query->bindValue(':user_id', NULL);
    $query->bindValue(':user_name', $_POST['user_name']);
    $query->bindValue(':user_lastname', $_POST['user_lastname']);
    $query->bindValue(':user_username', $_POST['user_username']);
    $query->bindValue(':user_email', $_POST['user_email']);
    $query->bindValue(':user_phonenumber', $_POST['user_phonenumber']);
    $query->bindValue(':user_password', password_hash($_POST['user_password'], PASSWORD_DEFAULT));
    $query->bindValue(':user_image', $_POST['user_image']);
    $query->bindValue(':user_follows', 0);
    $query->bindValue(':user_followers', 0);
    $query->bindValue(':user_active', 1);
    $query->execute();

    //create session
    session_start();
    $_SESSION['user_id'] = $db->lastInsertId();
    $_SESSION['user_name'] = $_POST['user_name'];
    $_SESSION['user_lastname'] = $_POST['user_lastname'];
    $_SESSION['user_username'] = $_POST['user_username'];
    $_SESSION['user_email'] = $_POST['user_email'];
    $_SESSION['user_profileimage'] = $_POST['user_image'];

    //send positive message
    http_response_code(200);
    header("content-type: application/json");
    echo '{"id": "' . $db->lastInsertId() . '"}';
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
