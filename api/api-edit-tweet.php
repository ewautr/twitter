<?php
if (!isset($_POST['newTweetBody'])) {
    sendError(400, 'tweet not set', __LINE__);
};
if (!isset($_POST['newTweetId'])) {
    sendError(400, 'tweet not set', __LINE__);
};
if (strlen($_POST['newTweetBody']) < 2) {
    sendError(400, 'tweet must have at least 2 characters', __LINE__);
};
if (strlen($_POST['newTweetBody']) > 280) {
    sendError(400, 'tweet must have maximum 280 characters', __LINE__);
};
if (!ctype_digit($_POST['newTweetId'])) {
    sendError(400, 'tweet id inorrect', __LINE__);
};
//connect to db
require_once(__DIR__ . '/../private/db.php');
session_start();

try {
    $query = $db->prepare('UPDATE tweets SET tweet_body = :tweet_body WHERE tweets.tweet_id = :tweet_id AND tweets.user_fk = :user_fk');
    $query->bindValue(':tweet_body', $_POST['newTweetBody']);
    $query->bindValue(':tweet_id', $_POST['newTweetId']);
    $query->bindValue(':user_fk', $_SESSION['user_id']);
    $query->execute();
    if ($query->rowCount() == 0) {
        sendError(500, 'tweet cannot be updated', __LINE__);
    }

    header("content-type: application/json");
    echo '{"message": "tweet updated", "id": "' . $_POST['newTweetId'] . '"}';
    exit();
} catch (PDOException $ex) {
    sendError(500, 'system under maintenance', __LINE__);
}



// ##########################################################################
// ##########################################################################
// ##########################################################################

function sendError($iError_code, $sMessage, $iLine)
{
    http_response_code($iError_code);
    header("content-type: application/json");
    echo '{"message": "' . $sMessage . '", "error": "' . $iLine . '"}';
    exit();
}
