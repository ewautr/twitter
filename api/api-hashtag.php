<?php
//connect to db
require_once(__DIR__ . '/../private/db.php');

if (!isset($_POST['hashtag'])) {
    sendError(400, 'missing hashtag', __LINE__);
}
if (!isset($_POST['tweet_id'])) {
    sendError(400, 'missing id', __LINE__);
}
if (!ctype_digit($_POST['tweet_id'])) {
    sendError(400, 'wrong id type', __LINE__);
}

session_start();

try {
    $db->beginTransaction();
    $query = $db->prepare('SELECT * FROM hashtags WHERE hashtag_name = :hashtag LIMIT 1');
    $query->bindValue(':hashtag', $_POST['hashtag']);
    $query->execute();
    $ajRow = $query->fetch();

    if (!$query->rowCount()) {
        //create hashtag and get hashtag id
        $query = $db->prepare('INSERT INTO hashtags VALUES (NULL, :hashtag, CURRENT_TIMESTAMP);');
        $query->bindValue(':hashtag', $_POST['hashtag']);
        $query->execute();
        if (!$query->rowCount()) {
            $db->rollback();
            sendError(400, 'something went wrong', __LINE__);
        }
        $hashtag_id = $db->lastInsertId();
    } else {
        //get hashtag id
        $hashtag_id = $ajRow->hashtag_id;
    }
    $q = $db->prepare('INSERT INTO hashtags_tweets VALUES (:hashtag_id, :tweet_id);');
    $q->bindValue(':hashtag_id', $hashtag_id);
    $q->bindValue(':tweet_id', $_POST['tweet_id']);
    $q->execute();
    if (!$query->rowCount()) {
        $db->rollback();
        sendError(400, 'something went wrong', __LINE__);
    }
    $db->commit();
    header('Content-Type: application/json');
    echo '{"message":"hashtag added"}';
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
