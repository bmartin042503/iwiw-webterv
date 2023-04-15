<?php

require_once('find_user_by_email.php');

if(isset($_COOKIE['email'])){
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];
    $user_data = find_user_by_email($email);

    if($user_data) {
        if (password_verify($password, $user_data['password'])) {
            session_start();
            $_SESSION['user_data'] = $user_data;
            $_SESSION['bejelentkezve'] = true;
        }
    }
}