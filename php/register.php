<?php
session_start();
function generate_unique_id() {
    return uniqid('', true);
}

function check_password($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[a-z]).{8,}$/',$password);
//    return strlen($password) >= 8 &&
//        preg_match('/[A-Z]/', $password) &&
//        preg_match('/\d/', $password);
}

function validate_form_data() {
    if($_POST['password'] != $_POST['confirm_password']) {
        return 'A jelszavak nem egyeznek!';
    }

    if(!check_password($_POST['password'])) {
        return 'A jelszónak legalább 8 karakterből kell állnia, tartalmaznia kell egy nagybetűt és egy számot.';
    }

    return null;
}

function email_exists($email) {
    $users_dir = '../db/users/';

    if (!file_exists($users_dir)) {
        mkdir($users_dir, 0777, true);
    }

    $users_directory = new DirectoryIterator($users_dir);
    foreach($users_directory as $user_directory) {
        if($user_directory->isDir()) {
            $data_file = $user_directory->getPathname() . '/data.txt';
            if(file_exists($data_file)) {
                $user_data = unserialize(file_get_contents($data_file));
                if($user_data['email'] == $email) {
                    return true;
                }
            }
        }
    }
    return false;
}

if(isset($_POST['register'])) {
    $error_message = validate_form_data();
    if($error_message) {
        echo "<script>alert('$error_message'); window.location.href = '../pages/register.html';</script>";
        exit;
    }

    if(email_exists($_POST['email'])) {
        echo "<script>alert('Az e-mail cím már regisztrálva van!'); window.location.href = '../pages/register.html';</script>";
        exit;
    }

    $user_unique_id = generate_unique_id();
    $user_dir_path = '../db/users/' . $user_unique_id;
    mkdir($user_dir_path);

    $data_file_path = $user_dir_path . '/data.txt';
    $user_data = [
        'id' => $user_unique_id,
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'year_of_birth' => $_POST['year-of-birth'],
        'year_of_registration' => date("Y-m-d"),
        'gender' => $_POST['gender'] == 'male' ? 1 : 0,
        'introduction' => $_POST['introduction'],
        'residence' => $_POST['residence'],
        'workplace' => $_POST['workplace'],
        'studies' => $_POST['studies'],
        'height' => $_POST['height'],
        'weight' => $_POST['weight'],
        'acquaintances' => rand(0,600),
        'iwiwplus' => 0
    ];
    file_put_contents($data_file_path, serialize($user_data));

    if(isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] == 0) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_name = $_FILES['profile-picture']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if(in_array($file_ext, $allowed_extensions)) {
            $profile_picture_path = $user_dir_path . '/profile' . '.' . $file_ext;
            move_uploaded_file($_FILES['profile-picture']['tmp_name'], $profile_picture_path);
        } else {
            echo "<script>alert('Nem megfelelő formátumú a képfájl. Csak JPG, JPEG, PNG és GIF fájlok engedélyezettek.'); window.location.href = '../pages/register.html';</script>";
            exit;
        }
    }
    $_SESSION['user_data'] = $user_data;
    $_SESSION['bejelentkezve'] = true;
    echo "<script>alert('Sikeres regisztráció!');</script>";
    header('Location: ../php/home.php');
}

?>