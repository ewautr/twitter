<?php

try{
    session_start();
    $userId = $_SESSION['userId'];
    $latestTweetId = $_GET['latestReceivedTweetId'];
    $aLatestTweets = [];

    //connect with database and put content into an array
    $sTweets = file_get_contents('../private/tweets.txt');
    $aTweets = json_decode($sTweets);

    //checking if user can edit the tweet
    foreach($aTweets as $aTweet){
        if($aTweet->userId == $userId){
            $bTweetEditable = true;
        }else{
            $bTweetEditable = false;
        }
        array_push($aTweet, $aTweet->editable = $bTweetEditable);
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
       foreach($aTweets as $aTweet){
            if ($aTweet->id == $bookmarketTweetId) {
                $aTweet->bookmarked = true;
            }
        }
   }

   //push latest tweets to an array
    foreach($aTweets as $iTweetIndex=>$aTweet){
        if($iTweetIndex > $latestTweetId){
            array_push($aLatestTweets, $aTweet);
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