<?php
try{ 
    session_start();
    $userId = $_SESSION['userId'];
    $bookmarkedTweetId = $_GET['bookmarkedTweetId'];

    //validate received data
    if(! isset($bookmarkedTweetId)){
        http_response_code(400);
        header('Content-Type: application/json');
        echo '{"message": "tweet to bookmark was not set"}';
        exit();
    }
    if(strlen($bookmarkedTweetId) != 13){
        http_response_code(400);
        header('Content-Type: application/json');
        echo '{"message": "tweet id must be 13 characters"}';
        exit();
    }

    // checking if the tweet is already in the bookmarkedTweets array
    $sUsers = file_get_contents('../private/users.txt');
    $aUsers = json_decode($sUsers);
    foreach($aUsers as $aUser){
        if($userId == $aUser->id){
            foreach($aUser->bookmarkedTweets as $iIndex=>$alreadyBookmarkedTweet){
                if($bookmarkedTweetId == $alreadyBookmarkedTweet){
                    //deleting the tweet from the array
                    array_splice($aUser->bookmarkedTweets, $iIndex, 1 );
                    header('Content-Type: application/json');
                    echo '{"message": "tweet has been deleted from bookmarks"}';
                    $sUsers = json_encode($aUsers);
                    file_put_contents('../private/users.txt', $sUsers);
                    exit();
                }
            }
            //adding the bookmarket tweet id to the bookmarkedTweets array
            array_push($aUser->bookmarkedTweets, $bookmarkedTweetId);
            header('Content-Type: application/json');
            echo '{"message": "tweet has been added to bookmarks"}';
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