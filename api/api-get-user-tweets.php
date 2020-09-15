<?php

try{
    session_start();
    $userId = $_SESSION['userId'];
    $latestTweetId = $_GET['latestReceivedTweetId'];
    $aUserTweets = [];
    $aLatestTweets = [];

    //validate received data
    if( !isset($latestTweetId)) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo '{"message": "tweet not set"}';
        exit();
    }

    //connect with database and put content into an array
    $sTweets = file_get_contents('../private/tweets.txt');
    $aTweets = json_decode($sTweets);

    //making an array with tweets that belong to the logged in user
    foreach($aTweets as $aTweet){
        if($aTweet->userId == $userId){
            array_push($aUserTweets, $aTweet);
        }
    }

    //checking if the tweet is bookmarked by the user
    $sUsers = file_get_contents('../private/users.txt');
    $aUsers = json_decode($sUsers);
    $aBookmarkedTweetsIds = [];
    foreach($aUsers as $aUser){
        if($aUser->id == $userId){
            $aBookmarkedTweetsIds = $aUser->bookmarkedTweets;
            break;
        }
    }
   foreach($aBookmarkedTweetsIds as $iTweetIndex=>$bookmarketTweetId){
       foreach($aUserTweets as $aUserTweet){
            if ($aUserTweet->id == $bookmarketTweetId) {
                $aUserTweet->bookmarked = true;
            }
        }
   }

   //push latest tweets to an array
    foreach($aUserTweets as $iTweetIndex=>$aUserTweet){
            if($iTweetIndex > $latestTweetId){
                array_push($aLatestTweets, $aUserTweet);
            }
    }

    //send an array of latest tweets
    header('Content-Type: application/json');
    echo json_encode($aLatestTweets);
}
catch (Exception $ex){
    http_response_code(500);
    header('Content-Type: application/json');
    echo '{"message": "error on line '.__LINE__.'"}';
}