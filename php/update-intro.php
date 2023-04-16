<?php
session_start();
if(!isset($_SESSION['bejelentkezve']) || !$_SESSION['bejelentkezve']) {
    header('Location: ../index.php');
    exit;
}

if(isset($_POST['introduction'])){
    if(strlen($_POST['introduction'])>600){
        echo "<script>alert('A bemutatkozó szövet túl hosszú!'); window.location.href = 'profile-edit.php';</script>";
        exit;
    }
    else{
        $_SESSION['user_data']['introduction']=$_POST['introduction'];
        $data_file_path = '../db/users/' .$_SESSION['user_data']['id'] . '/data.txt';
        file_put_contents($data_file_path, serialize($_SESSION['user_data']));
    }
}
header('Location: profile-edit.php');