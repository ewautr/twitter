<?php

try{
    session_start();
    $userId = $_SESSION['userId'];

    //connect with database and put content into an array
    $sUsers = file_get_contents('../private/users.txt');
    $aUsers = json_decode($sUsers);

    //delete the currently loggedin user from the array
    foreach($aUsers as $iIndex => $aUser){
        if($aUser->id == $userId){
            array_splice($aUsers, $iIndex, 1);
            break;
        }
    }

    //send the filtered array of all users
    $sUsers = json_encode($aUsers);
    header('Content-Type: application/json');
    echo $sUsers;
}
catch(Exception $ex){
    http_response_code(500);
    header('Content-Type: application/json');
    echo '{"message": "error on line '.__LINE__.'"}';
}