<?php
//connect to db
require_once(__DIR__ . '/../private/db.php');


$user_id = $_POST['user_id'];
session_start();

try {
    $query = $db->prepare('SELECT * FROM user_tweets WHERE user_fk = :user_id ORDER BY tweet_created ASC LIMIT 25');
    $query->bindValue(':user_id', $user_id);
    $query->execute();
    $ajRows = $query->fetchAll();
    if ($ajRows) {
        //format timestamps like Twitter  
        foreach ($ajRows as $row) {
            $row->tweet_created = timeago($row->tweet_created);
        }
        echo json_encode($ajRows);
        exit();
    }
    http_response_code(404);
    echo '{"message": "Nothing here yet."}';
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
