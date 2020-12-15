<?php

if (!isset($_POST['tweet_id'])) {
    sendError(400, 'missing id', __LINE__);
}
if (!ctype_digit($_POST['tweet_id'])) {
    sendError(400, 'wrong id type', __LINE__);
}

//connect to db
session_start();
require_once(__DIR__ . '/../private/db.php');

try {
    $q = $db->prepare('UPDATE likes SET like_active = 0 WHERE tweet_fk = :tweet_id AND user_fk = :user_id');
    $q->bindValue(':tweet_id', $_POST['tweet_id']);
    $q->bindValue(':user_id', $_SESSION['user_id']);
    $q->execute();

    header('Content-Type: application/json');
    echo '{"message":"tweet disliked"}';
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
