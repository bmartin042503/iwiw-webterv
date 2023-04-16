<?php
session_start();
if(!isset($_SESSION['bejelentkezve']) || !$_SESSION['bejelentkezve']) {
    header('Location: ../index.php');
    exit;
}

if(isset($_POST['uid'])){
    $dir_path = '../db/users/' . $_POST['uid'];

    if (is_dir($dir_path)) {
        // Törölje a mappát és annak tartalmát
        $files = array_diff(scandir($dir_path), array('.', '..')); // szűrjük ki a . és .. mappákat
        foreach ($files as $file) {
            (is_dir("$dir_path/$file")) ? deleteFolder("$dir_path/$file") : unlink("$dir_path/$file");
        }
        rmdir($dir_path);
    }

    if($_POST['uid']==$_SESSION['user_data']['id']){
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
        echo "<script>alert('Fiokod sikeresen törölve'); window.location.href = '../index.php';</script>";
    }
    else{
        echo "<script>alert('A felhasználó sikeresen törölve'); window.location.href = 'home.php';</script>";
    }
}