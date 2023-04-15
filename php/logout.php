<?php
session_start();

$_SESSION = array();

session_destroy();

if(isset($_COOKIE['email'])){
    unset($_COOKIE['email']);
    setcookie('email', null, -1, '/');
}
if(isset($_COOKIE['password'])){
    unset($_COOKIE['password']);
    setcookie('password', null, -1, '/');
}

header('Location: ../index.php');
exit;
?>