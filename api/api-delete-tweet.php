<?php
try{
    session_start();
    $tweetId = $_GET['tweetId'];
    $userId = $_SESSION['userId'];

    //validate received data
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

    //connect with database and put content into an array
    $sTweets = file_get_contents('../private/tweets.txt');
    $aTweets = json_decode($sTweets);

    //finding the tweet by id and deleting it from the database
    for($i = 0; $i < count($aTweets); $i++) {
        if($tweetId == $aTweets[$i]->id && $userId ==$aTweets[$i]->userId) {
            array_splice($aTweets, $i, 1);
            $sTweets = json_encode($aTweets);
            file_put_contents('../private/tweets.txt', $sTweets);
            header('Content-Type: application/json');
            echo '{"message":"tweet deleted"}';
            exit();
        }
    }
}
catch(Exception $ex){
    http_response_code(500);
    header('Content-Type: application/json');
    echo '{"message": "error on line '.__LINE__.'"}';
}
