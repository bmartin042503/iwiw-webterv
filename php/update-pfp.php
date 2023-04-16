<?php
session_start();
if(!isset($_SESSION['bejelentkezve']) || !$_SESSION['bejelentkezve']) {
    header('Location: ../index.php');
    exit;
}

$user_dir_path = '../db/users/' . $_SESSION['user_data']['id'];

//if (isset($_FILES)) {
//    foreach ($_FILES as $name => $file) {
//        echo "Name: " . $file['name'] . "<br>";
//        echo "Type: " . $file['type'] . "<br>";
//        echo "Size: " . $file['size'] . " bytes<br>";
//        echo "Temporary location: " . $file['tmp_name'] . "<br>";
//        echo "Error code: " . $file['error'] . "<br>";
//        echo "<br>";
//    }
//}

if(isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] == 0) {
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_name = $_FILES['profile-picture']['name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if(in_array($file_ext, $allowed_extensions)) {
        $profile_picture_path = $user_dir_path . '/profile' . '.' . $file_ext;

        $files = glob($user_dir_path . '/profile.*'); // get all files with the name "profile."

        foreach ($files as $file) {
            unlink($file); // delete the file
        }

        move_uploaded_file($_FILES['profile-picture']['tmp_name'], $profile_picture_path);
    } else {
        echo "<script>alert('Nem megfelelő formátumú a képfájl. Csak JPG, JPEG, PNG és GIF fájlok engedélyezettek.'); window.location.href = 'profile-edit.php';</script>";
        exit;
    }

    header('Location: profile-edit.php');
}
