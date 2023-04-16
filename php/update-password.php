<?php
session_start();
if(!isset($_SESSION['bejelentkezve']) || !$_SESSION['bejelentkezve']) {
    header('Location: ../index.php');
    exit;
}

if(isset($_POST['oldpswd'])&&isset($_POST['newpswd'])&&isset($_POST['newpswdre'])){
    if(password_verify($_POST['oldpswd'], $_SESSION['user_data']['password'])){
        if($_POST['newpswd']==$_POST['newpswdre']){
            if(preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[a-z]).{8,}$/',$_POST['newpswd'])){
                $_SESSION['user_data']['password']=password_hash($_POST['newpswd'],PASSWORD_DEFAULT);

                $data_file_path = '../db/users/' .$_SESSION['user_data']['id'] . '/data.txt';
                file_put_contents($data_file_path, serialize($_SESSION['user_data']));

                echo "<script>alert('Jelszó sikeresen frissitve!'); window.location.href = 'profile-edit.php';</script>";
                exit();
            }
            else {
                echo "<script>alert('Az új jelszó nem felel meg a feltételeknek!'); window.location.href = 'profile-edit.php';</script>";
                exit();//kliens oldalon ellenőrizve volt
            }
        }
        else{
            echo "<script>alert('Helytelenül megerősitett jelszo!'); window.location.href = 'profile-edit.php';</script>";
            exit();//kliens oldalon ellenőrizve volt
        }
    }
    else{
        echo "<script>alert('Helytelen a régi jelszó!'); window.location.href = 'profile-edit.php';</script>";
        exit();
    }
}
header('Location: profile-edit.php');