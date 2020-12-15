<?php

if (!isset($_POST['user_id'])) {
    sendError(400, 'missing id', __LINE__);
}
if (!ctype_digit($_POST['user_id'])) {
    sendError(400, 'wrong id type', __LINE__);
}

//connect to db
session_start();
require_once(__DIR__ . '/../private/db.php');

try {
    $q = $db->prepare('INSERT INTO follows VALUES (:follower_fk, :followee_fk, "1", CURRENT_TIMESTAMP);');
    $q->bindValue(':followee_fk', $_POST['user_id']);
    $q->bindValue(':follower_fk', $_SESSION['user_id']);
    $q->execute();

    header('Content-Type: application/json');
    echo '{"message":"user followed"}';
    exit();
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
