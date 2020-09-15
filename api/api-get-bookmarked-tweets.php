<?php

try{
    session_start();
    $userId = $_SESSION['userId'];
    $latestBookmarkedTweetId = $_GET['latestBookmarkedTweetId'];
    $aBookmarkedTweetsIds = [];
    $aBookmarkedTweets = [];

    //find tweets bookmarked by the user in his array
    $sUsers = file_get_contents('../private/users.txt');
    $aUsers = json_decode($sUsers);
    foreach($aUsers as $aUser){
        if($aUser->id == $userId){
            $aBookmarkedTweetsIds = $aUser->bookmarkedTweets;
            break;
        }
    }

    //make an array of bookmarked tweets finding them by id
    $sTweets = file_get_contents('../private/tweets.txt');
    $aTweets = json_decode($sTweets);
    foreach($aBookmarkedTweetsIds as $iTweetIndex=>$bookmarketTweetId){
        if($iTweetIndex > $latestBookmarkedTweetId){
            foreach($aTweets as $aTweet){
                if ($aTweet->id == $bookmarketTweetId) {
                    $aTweet->bookmarked = true;
                    array_push($aBookmarkedTweets, $aTweet);
                }
            }  
        }
    }
    
    //send an array of bookmarked tweets
    header('Content-Type: application/json');
    echo json_encode($aBookmarkedTweets); 
}
catch (Exception $ex){
    http_response_code(500);
    header('Content-Type: application/json');
    echo '{"message": "error on line '.__LINE__.'"}';
}