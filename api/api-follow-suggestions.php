<?php
//connect to db
require_once(__DIR__ . '/../private/db.php');

session_start();
try {
    $query = $db->prepare('SELECT * FROM active_users WHERE user_id NOT IN (SELECT follow_followee FROM follows WHERE follow_follower = :user_id) AND NOT user_id = :user_id LIMIT 10');
    $query->bindValue(':user_id', $_SESSION['user_id']);
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
