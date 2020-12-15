<?php

if (!isset($_GET['userProfileName'])) {
    sendError(400, 'missing user profile name', __LINE__);
}
if (strlen($_GET['userProfileName']) < 1) {
    sendError(400, 'user profile name too short', __LINE__);
}
if (strlen($_GET['userProfileName']) > 50) {
    sendError(400, 'user profile name too long', __LINE__);
}

require_once(__DIR__ . '/../private/db.php');

try {
    $query = $db->prepare('SELECT user_id, user_name, user_lastname, user_username, user_imagepath 
                           FROM users 
                           WHERE user_username 
                           LIKE :searchFor');
    $query->bindValue(':searchFor', $_GET['userProfileName'] . '%');
    $query->execute();
    $ajData = $query->fetchAll();
    header('Content-Type: application/json');
    echo json_encode($ajData);
} catch (Exception $ex) {
    sendError(500, 'system under maintatance', __LINE__);
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
