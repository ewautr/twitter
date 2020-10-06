<?php

if( !isset($_POST['tweet'])){ sendError(400, 'tweet not set', __LINE__); };
if( strlen($_POST['tweet']) < 2){ sendError(400, 'tweet must have at least 2 characters', __LINE__); };
if( strlen($_POST['tweet']) > 280){ sendError(400, 'tweet must have maximum 280 characters', __LINE__); };

require_once(__DIR__.'/../private/db.php');
session_start();

try{
    //INSERT INTO `tweets` (`iId`, `iUserFk`, `sMessage`, `bActive`, `dCreated`) VALUES (NULL, '10', 'Hi', '1', CURRENT_TIMESTAMP);
    $query = $db->prepare('INSERT INTO tweets VALUES (NULL, :iUserFk, :sMessage, 1, NOW())');
    $query->bindValue(':iUserFk', $_SESSION['iUserId']);
    $query->bindValue(':sMessage', $_POST['tweet']);
    $query->execute();

    header('Content-Type: application/json');
    echo '{"iTweetId": '.$db->lastInsertId().'}';

} catch (PDOException $ex) {
    sendError(500, 'system under maintainance', __LINE__);
}








##################
##################
##################



function sendError($iResponseCode, $sMessage, $iLine){
    http_response_code($iResponseCode);
    header('Content-Type: application/json');
    echo '{"message": "'.$sMessage.'", "error": "'.$iLine.'"}';
    exit();
}