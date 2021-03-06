<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: home');
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="ie=edge" http-equiv="X-UA-Compatible" />
    <link href="style.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="https://abs.twimg.com/favicons/twitter.ico" />
    <title>Signup / Twitter::Clone</title>
</head>

<body>
    <div id="signup-landingpage">
        <div class="visual"></div>
        <div class="choose-method">
            <div>
                <svg viewbox="0 0 24 24">
                    <path d="M23.643 4.937c-.835.37-1.732.62-2.675.733.962-.576 1.7-1.49 2.048-2.578-.9.534-1.897.922-2.958 1.13-.85-.904-2.06-1.47-3.4-1.47-2.572 0-4.658 2.086-4.658 4.66 0 .364.042.718.12 1.06-3.873-.195-7.304-2.05-9.602-4.868-.4.69-.63 1.49-.63 2.342 0 1.616.823 3.043 2.072 3.878-.764-.025-1.482-.234-2.11-.583v.06c0 2.257 1.605 4.14 3.737 4.568-.392.106-.803.162-1.227.162-.3 0-.593-.028-.877-.082.593 1.85 2.313 3.198 4.352 3.234-1.595 1.25-3.604 1.995-5.786 1.995-.376 0-.747-.022-1.112-.065 2.062 1.323 4.51 2.093 7.14 2.093 8.57 0 13.255-7.098 13.255-13.254 0-.2-.005-.402-.014-.602.91-.658 1.7-1.477 2.323-2.41z"></path>
                </svg>
                <h1 class="primary">See what’s happening in the world right now</h1>
                <h2 class="secondary">Join Twitter today.</h2>
                <button class="btn" onclick="return showSignupModal()">Sign up</button>
                <button class="btn btn-outline">
                    <a href="login">Log in</a>
                </button>
            </div>
            <div class="signup-modal-wrapper">
                <div class="signup-modal">
                    <a href="" onclick="return closeModal()" class="close">
                        <svg viewBox="0 0 24 24">
                            <path d="M13.414 12l5.793-5.793c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0L12 10.586 6.207 4.793c-.39-.39-1.023-.39-1.414 0s-.39 1.023 0 1.414L10.586 12l-5.793 5.793c-.39.39-.39 1.023 0 1.414.195.195.45.293.707.293s.512-.098.707-.293L12 13.414l5.793 5.793c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L13.414 12z"></path>
                        </svg>
                    </a>
                    <svg viewbox="0 0 24 24">
                        <path d="M23.643 4.937c-.835.37-1.732.62-2.675.733.962-.576 1.7-1.49 2.048-2.578-.9.534-1.897.922-2.958 1.13-.85-.904-2.06-1.47-3.4-1.47-2.572 0-4.658 2.086-4.658 4.66 0 .364.042.718.12 1.06-3.873-.195-7.304-2.05-9.602-4.868-.4.69-.63 1.49-.63 2.342 0 1.616.823 3.043 2.072 3.878-.764-.025-1.482-.234-2.11-.583v.06c0 2.257 1.605 4.14 3.737 4.568-.392.106-.803.162-1.227.162-.3 0-.593-.028-.877-.082.593 1.85 2.313 3.198 4.352 3.234-1.595 1.25-3.604 1.995-5.786 1.995-.376 0-.747-.022-1.112-.065 2.062 1.323 4.51 2.093 7.14 2.093 8.57 0 13.255-7.098 13.255-13.254 0-.2-.005-.402-.014-.602.91-.658 1.7-1.477 2.323-2.41z"></path>
                    </svg>
                    <h1 class="primary">Create an account</h1>
                    <form onsubmit="signup(); return false;" class="entry-form">
                        <div id="name-wrapper">
                            <input id="name" name="user_name" type="text" onkeyup="validateInput('name')" value="Ewa">
                            <label>Name</label>
                            <p>Name must be between 2 and 50 characters.</p>
                        </div>
                        <div id="lastname-wrapper">
                            <input id="lastname" name="user_lastname" type="text" onkeyup="validateInput('lastname')" value="Utracka">
                            <label>Last name</label>
                            <p>Last name must be between 2 and 50 characters.</p>
                        </div>
                        <div id="email-wrapper">
                            <input id="email" name="user_email" type="text" onkeyup="validateEmail()" value="ewa@ewa.com">
                            <label>Email</label>
                            <p>Please enter a valid email.</p>
                        </div>
                        <div id="username-wrapper">
                            <input id="username" name="user_username" type="text" onkeyup="validateInput('username')" value="ewa">
                            <label>Username</label>
                            <p>Username must be between 2 and 50 characters.</p>
                        </div>
                        <div id="password-wrapper">
                            <input id="password" name="user_password" type="password" onkeyup="validateInput('password')" value="pass1">
                            <label>Password</label>
                            <p>Password must be between 2 and 50 characters.</p>
                        </div>
                        <div id="repeatedPassword-wrapper">
                            <input id="repeatedPassword" name="user_repeatedPassword" type="password" onkeyup="validateRepeatedPassword()" value="pass1">
                            <label>Repeat password</label>
                            <p>Passwords must match.</p>
                        </div>
                        <div id="image-wrapper">
                            <input id="image" name="user_image" type="text" value="default_user.png">
                            <label>Profile image</label>
                        </div>
                        <button class="btn">Create account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="signup-login.js"></script>
</body>

</html>