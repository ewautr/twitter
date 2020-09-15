<?php

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$repeatedPassword = $_POST['repeatedPassword'];

//form data validation
if(! isset($email)) {
    echo 'email not set';
    header('Location: signup');
    exit();
}
if(! isset($username)) {
    echo 'username not set';
    header('Location: signup');
    exit();
}
if(! isset($password)) {
    echo 'password not set';
    header('Location: signup');
    exit();
}
if( filter_var($email, _FILTER_VALIDATE_EMAIL) ) {
    echo 'email not valid';
    header('Location: signup');
    exit();
}

if( strlen($username) < 2 ) {
    echo 'username too short';
    header('Location: signup');
    exit();
}
if( strlen($username) > 100 ) {
    echo 'username too long';
    header('Location: signup');
    exit();
}
if( strlen($password) < 2 ) {
    echo 'password too short';
    header('Location: signup');
    exit();
}
if( strlen($password) > 100 ) {
    echo 'password too long';
    header('Location: signup');
    exit();
}
if( $password != $repeatedPassword ) {
    echo 'passwords not match';
    header('Location: signup');
    exit();
}

//connect with database and put content into an array
$sUsers = file_get_contents('private/users.txt');
$aUsers = json_decode($sUsers);

//check if user with given email or username already exists
foreach($aUsers as $aUser){
    if($aUser->email == $email || $aUser->username == $username) {
        header('Location: signup');
        exit();
    }
}

//create a new user array and put it in the database
$newUser = new stdClass();
$newUser->id = uniqid();
$newUser->email = $email;
$newUser->username = $username;
$newUser->password = password_hash($password, PASSWORD_DEFAULT);
$newUser->dateJoined = getdate()['month'].' '.getdate()['year'];
$newUser->bookmarkedTweets = [];
$newUser->likedTweets = [];

array_push($aUsers, $newUser);
$sUsers = json_encode($aUsers);
file_put_contents('private/users.txt', $sUsers);

header('Location: login');