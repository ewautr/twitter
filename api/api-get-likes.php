<?php
//connect to db
require_once(__DIR__ . '/../private/db.php');

if (!isset($_GET['tweet_id'])) {
    sendError(400, 'missing id', __LINE__);
}
if (!ctype_digit($_GET['tweet_id'])) {
    sendError(400, 'wrong id type', __LINE__);
}

session_start();

try {
    $query = $db->prepare('SELECT * FROM likes WHERE tweet_fk = :tweet_id AND like_active = 1');
    $query->bindValue(':tweet_id', $_GET['tweet_id']);
    $query->execute();
    $ajRows = $query->fetchAll();
    $likedByCurrentUser = 0;

    foreach ($ajRows as $like) {
        if ($like->user_fk == $_SESSION['user_id']) {
            $likedByCurrentUser = 1;
        }
    }

    header('Content-Type: application/json');
    echo '{"likesNumber":"' . $query->rowCount() . '", "likedByCurrentUser":"' . $likedByCurrentUser . '"}';
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
