<?php
session_start();

function find_user_by_email($email) {
    $users_dir = '../users/';
    $users_directory = new DirectoryIterator($users_dir);
    foreach($users_directory as $user_directory) {
        if($user_directory->isDir()) {
            $data_file = $user_directory->getPathname() . '/data.txt';
            if(file_exists($data_file)) {
                $user_data = unserialize(file_get_contents($data_file)); {
                    if($user_data['email'] == $email) {
                        return $user_data;
                    }
                }
            }
        }
    }
    return null;
}

if(isset($_POST['login_submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_data = find_user_by_email($email);

    if($user_data) {
        if(password_verify($password, $user_data['password'])) {
            $_SESSION['user_data'] = $user_data;
            header('Location: ../pages/home.html');
        } else {
            echo "<script>alert('Helytelen jelszó!'); window.location.href = '../index.html';</script>";
        }
    } else {
        echo "<script>alert('Nincs ilyen fiók!'); window.location.href = '../index.html';</script>";
    }
}

?>