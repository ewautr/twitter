<?php

if (!isset($_POST['tweet_body'])) {
    sendError(400, 'tweet not set', __LINE__);
};
if (strlen($_POST['tweet_body']) < 2) {
    sendError(400, 'tweet must have at least 2 characters', __LINE__);
};
if (strlen($_POST['tweet_body']) > 280) {
    sendError(400, 'tweet must have maximum 280 characters', __LINE__);
};

require_once(__DIR__ . '/../private/db.php');
session_start();

try {
    $query = $db->prepare('INSERT INTO tweets VALUES (:tweet_id, :user_fk, :tweet_body, CURRENT_TIMESTAMP, :tweet_total_likes, :tweet_total_comments, :tweet_active)');
    $query->bindValue(':tweet_id', NULL);
    $query->bindValue(':user_fk', $_SESSION['user_id']);
    $query->bindValue(':tweet_body', $_POST['tweet_body']);
    $query->bindValue(':tweet_total_likes', 0);
    $query->bindValue(':tweet_total_comments', 0);
    $query->bindValue(':tweet_active', 1);
    $query->execute();

    header('Content-Type: application/json');
    echo '{"tweet_id": ' . $db->lastInsertId() . '}';
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
