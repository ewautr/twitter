<?php
try {
    
    session_start();
    $tweetId = $_POST['newTweetId'];
    $tweetBody = $_POST['newTweetBody'];
    $userId = $_SESSION['userId'];

    //validate form data
    if(! isset($tweetId)) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo '{"error":"missing id"}';
        exit();
    }
    if(strlen($tweetId) != 13) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo '{"error":"id must be 13 characters"}';
        exit();
    }
    if(! isset($tweetBody)) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo '{"error":"tweet not set"}';
        exit();
    }
    if(strlen($tweetBody) < 2) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo '{"error":"tweet must be minimum 2 characters"}';
        exit();
    }
    if(strlen($tweetBody) > 280) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo '{"error":"tweet must be maximum 200 characters"}';
        exit();
    } 

    //connect with database and put content into an array
    $sTweets = file_get_contents('../private/tweets.txt');
    $aTweets = json_decode($sTweets);

    //finding the tweet by id and updating it in the database
    for($i = 0; $i < count($aTweets); $i++) {
        if($tweetId == $aTweets[$i]->id && $tweetBody != $aTweets[$i]->body && $userId == $aTweets[$i]->userId) {
            $aTweets[$i]->body = $tweetBody;
            $sTweets = json_encode($aTweets);
            file_put_contents('../private/tweets.txt', $sTweets);
            header('Content-Type: application/json');
            echo '{"message":"tweet updated"}';
            exit();
        }
    }

    //message displayed if no match was found
    header('Content-Type: application/json');
    echo '{"message":"no match between the tweet id and the existing tweets"}';
}
catch (Exception $ex) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo '{"message": "error '.__LINE__.'"}';
}