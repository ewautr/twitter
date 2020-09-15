<?php
try{
    session_start();
    $userId = $_SESSION['userId'];
    $likedTweetId = $_GET['likedTweetId'];
    if(! isset($likedTweetId)){
        http_response_code(400);
        header('Content-Type: application/json');
        echo '{"message": "tweet to like was not set"}';
        exit();
    }
    if(strlen($likedTweetId) != 13){
        http_response_code(400);
        header('Content-Type: application/json');
        echo '{"message": "tweet id must be 13 characters"}';
        exit();
    }


    $sUsers = file_get_contents('../private/users.txt');
    $aUsers = json_decode($sUsers);
    foreach($aUsers as $aUser){
        if($userId == $aUser->id){
            // checking if the tweet is already in the likedTweets array
            foreach($aUser->likedTweets as $iIndex=>$alreadyLikedTweet){
                if($likedTweetId == $alreadyLikedTweet){
                    //deleting  the tweet from the array
                    array_splice($aUser->likedTweets, $iIndex, 1 );
                    header('Content-Type: application/json');
                    echo '{"message": "tweet has been deleted from likes"}';
                    $sUsers = json_encode($aUsers);
                    file_put_contents('../private/users.txt', $sUsers);
                    exit();
                }
            }
            //adding the bookmarket tweet id to the likedTweets array
            array_push($aUser->likedTweets, $likedTweetId);
            header('Content-Type: application/json');
            echo '{"message": "tweet has been added to likes"}';
            $sUsers = json_encode($aUsers);
            file_put_contents('../private/users.txt', $sUsers);
        }
    }
}
catch(Exception $ex){
    http_response_code(500);
    header('Content-Type: application/json');
    echo '{"message": "error '.__LINE__.'"}';
}