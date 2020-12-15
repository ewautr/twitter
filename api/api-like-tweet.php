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
    //check if the like is already there
    $q = $db->prepare('SELECT * FROM likes WHERE user_fk = :user_id AND tweet_fk = :tweet_id LIMIT 1');
    $q->bindValue(':tweet_id', $_POST['tweet_id']);
    $q->bindValue(':user_id', $_SESSION['user_id']);
    $q->execute();
    $aRow = $q->fetch();
    if ($aRow) {
        //set the like to active again
        $q = $db->prepare('UPDATE likes SET like_active = :like_active WHERE user_fk = :user_id AND tweet_fk = :tweet_id');
        $q->bindValue(':tweet_id', $_POST['tweet_id']);
        $q->bindValue(':user_id', $_SESSION['user_id']);
        $q->bindValue(':like_active', 1);
        $q->execute();
    } else {
        //create a new like
        $q = $db->prepare('INSERT INTO likes VALUES (:user_id, :tweet_id, CURRENT_TIMESTAMP, :like_active);');
        $q->bindValue(':tweet_id', $_POST['tweet_id']);
        $q->bindValue(':user_id', $_SESSION['user_id']);
        $q->bindValue(':like_active', 1);
        $q->execute();
    }

    header('Content-Type: application/json');
    echo '{"message":"tweet liked"}';
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
