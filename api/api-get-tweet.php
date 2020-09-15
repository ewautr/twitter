<?php

try{
    $tweetId = $_GET['tweetId'];
    
    //validate received data
    if(! isset($tweetId)) {
        header('Content-Type: application/json');
        echo '{"message": "tweet id not set"}';
        exit();
    }
    if(strlen($tweetId) != 13) {
        header('Content-Type: application/json');
        echo '{"message": "tweet id must be 13 characters"}';
        exit();
    }

     //connect with database and put content into an array
     $sTweets = file_get_contents('../private/tweets.txt');
     $aTweets = json_decode($sTweets);
 
     foreach($aTweets as $aTweet) {
         if($aTweet->id == $tweetId) {
            header('Content-Type: application/json');
            echo json_encode($aTweet);
            exit();
         }
     }

}
catch(Exception $ex){
    http_response_code(500);
    header('Content-Type: application/json');
    echo '{"message": "error on line '.__LINE__.'"}';
}