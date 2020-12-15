<?php
if (!isset($_POST['tweet_id'])) {
    sendError(400, 'tweet not set', __LINE__);
};
if (!ctype_digit($_POST['tweet_id'])) {
    sendError(400, 'tweet id inorrect', __LINE__);
};

//connect to db
require_once(__DIR__ . '/../private/db.php');
session_start();

try {
    $query = $db->prepare('DELETE FROM tweets WHERE tweets.tweet_id = :tweet_id AND tweets.user_fk = :user_fk');
    $query->bindValue(':tweet_id', $_POST['tweet_id']);
    $query->bindValue(':user_fk', $_SESSION['user_id']);
    $query->execute();
    if ($query->rowCount() == 0) {
        sendError(500, 'tweet cannot be deleted', __LINE__);
    }

    header("content-type: application/json");
    echo '{"message": "tweet deleted", "id": "' . $_POST['tweet_id'] . '"}';
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
