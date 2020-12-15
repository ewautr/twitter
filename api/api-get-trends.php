<?php
//connect to db
require_once(__DIR__ . '/../private/db.php');


try {
    $query = $db->prepare('SELECT hashtags.hashtag_name, COUNT(hashtags_tweets.hashtag_fk) AS magnitude FROM hashtags INNER JOIN hashtags_tweets ON hashtags_tweets.hashtag_fk = hashtags.hashtag_id GROUP BY hashtags.hashtag_name ORDER BY magnitude DESC LIMIT 3');
    $query->execute();
    $ajRows = $query->fetchAll();

    header('Content-Type: application/json');
    echo json_encode($ajRows);
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
