<?php
$username = $_POST['username'];
$password = $_POST['password'];

//validate form data
if(! isset($username)) {
    header('Location: login');
    exit();
}
if(! isset($password)) {
    header('Location: login');
    exit();
}
if( strlen($username) < 2 ) {
    header('Location: login');
    exit();
}
if( strlen($username) > 100 ) {
    header('Location: login');
    exit();
}
if( strlen($password) < 2 ) {
    header('Location: login');
    exit();
}
if( strlen($password) > 100 ) {
    header('Location: login');
    exit();
}

//connect with database and put content into an array
$sUsers = file_get_contents('private/users.txt');
$aUsers = json_decode($sUsers);

//check if user email and password match with the database
foreach($aUsers as $aUser){
    if($aUser->username == $username && password_verify($password, $aUser->password)) {
        //create session and pass data
        session_start();
        $_SESSION['username'] = $aUser->username;
        $_SESSION['userId'] = $aUser->id;
        $_SESSION['dateJoined'] = $aUser->dateJoined;
        header('Location: home');
        break;
    } else {
        //take user back to login page
        header('Location: login');
    }
}