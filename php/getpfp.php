<?php
function get_profile_picture($user_data) {
    $user_dir = '../db/users/' . $user_data['id'];
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    foreach ($allowed_extensions as $ext) {
        $profile_picture_path = $user_dir . '/profile.' . $ext;
        if(file_exists($profile_picture_path)) {
            return $profile_picture_path;
        }
    }
    return '../img/static/default-profile.png';
}

function get_profile_picture_userdir($user_dir)
{
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    foreach ($allowed_extensions as $ext) {
        $profile_picture_path = $user_dir . '/profile.' . $ext;
        if (file_exists($profile_picture_path)) {
            return $profile_picture_path;
        }
    }
    return '../img/static/default-profile.png';
}
?>