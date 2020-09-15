<?php

try{
    session_start();
    $newTweet = $_POST['newTweet'];
    $userId = $_SESSION['userId'];
    $username = $_SESSION['username'];

    //validate form data
    if(!isset($newTweet)){
        http_response_code(400);
        header('Content-Type: application/json');
        echo '{"message": "no tweet was posted"}';
        exit();
    } 
    if(strlen($newTweet) < 2) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo '{"message": "tweet must be at least 2 characters"}';
    }
    if(strlen($newTweet) > 280) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo '{"message": "tweet must be maximum 200 characters"}';
    }
    
    //connect with database and put content into an array
    $sTweets = file_get_contents('../private/tweets.txt');
    $aTweets = json_decode($sTweets);

    //create new tweet array and save data in the database
    $jTweet = new stdClass();
    $jTweet->id = uniqid();
    $jTweet->body = $newTweet;
    $jTweet->userId = $userId;
    $jTweet->username = $username;
    array_push($aTweets, $jTweet);
    $sTweets = json_encode($aTweets);
    file_put_contents('../private/tweets.txt', $sTweets);

    header('Content-Type: application/json');
    echo $jTweet->id;
}
catch(Exception $ex){
    http_response_code(500);
    header('Content-Type: application/json');
    echo '{"message": "error '.__LINE__.'"}';
}