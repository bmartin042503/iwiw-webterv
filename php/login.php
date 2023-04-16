<?php
session_start();

require_once('find_user_by_email.php');

if(isset($_POST['login_submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_data = find_user_by_email($email);

    if($user_data) {
        if(password_verify($password, $user_data['password'])) {
            $_SESSION['user_data'] = $user_data;
            $_SESSION['bejelentkezve'] = true;

            if(isset($_POST['remember'])){
                setcookie('email',$email , time() + (86400 * 30), "/");
                setcookie('password',$password , time() + (86400 * 30), "/");
            }

            header('Location: ../php/home.php');
        } else {
            echo "<script>alert('Helytelen jelszó!'); window.location.href = '../index.php';</script>";
        }
    } else {
        echo "<script>alert('Nincs ilyen fiók!'); window.location.href = '../index.php';</script>";
    }
}

?>