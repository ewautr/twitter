<?php
//connect to db
require_once(__DIR__ . '/../private/db.php');


$latestTweetId = $_GET['latestTweetId'] ?? 0;
session_start();

try {
    $query = $db->prepare('SELECT tweets.*, users.user_name, users.user_lastname, users.user_username, users.user_imagepath 
                           FROM tweets 
                           JOIN users 
                           ON tweets.user_fk = users.user_id 
                           WHERE tweets.tweet_id > :latestTweetId 
                           ORDER BY tweets.tweet_id 
                           LIMIT 25');
    $query->bindValue(':latestTweetId', $latestTweetId);
    $query->execute();
    $ajRows = $query->fetchAll();

    //format timestamps like Twitter  
    foreach ($ajRows as $row) {
        $row->tweet_created = timeago($row->tweet_created);
    }
    echo json_encode($ajRows);
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
function timeago($datetime, $full = false)
{
    date_default_timezone_set('Europe/Copenhagen');
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'yr',
        'm' => 'mon',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hr',
        'i' => 'min',
        's' => 'sec',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) {
        $string = array_slice($string, 0, 1);
    }

    return $string ? implode(', ', $string) . '' : 'just now';
}
