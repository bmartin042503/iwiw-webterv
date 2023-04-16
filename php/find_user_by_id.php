<?php
function find_user_by_id($user_id) {
    $users_dir = '../db/users/';

    if(!file_exists($users_dir)) {
        mkdir($users_dir, 0777, true);
        return null;
    }

    $user_directory_path = $users_dir . $user_id;

    if(file_exists($user_directory_path)) {
        $data_file = $user_directory_path . '/data.txt';
        if(file_exists($data_file)) {
            $user_data = unserialize(file_get_contents($data_file));
            return $user_data;
        }
    }

    return null;
}
?>