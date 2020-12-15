<?php
//connect to db
require_once(__DIR__ . '/../private/db.php');

session_start();

try {
    $query = $db->prepare('SELECT * FROM active_users WHERE user_id = :user_id LIMIT 1');
    $query->bindValue(':user_id', $_POST['user_id']);
    $query->execute();
    $ajRow = $query->fetch();
    header('Content-Type: application/json');
    echo json_encode($ajRow);
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
