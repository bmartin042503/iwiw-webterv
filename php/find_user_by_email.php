<?php
function find_user_by_email($email) {
    $users_dir = '../users/';
    $users_directory = new DirectoryIterator($users_dir);
    foreach($users_directory as $user_directory) {
        if($user_directory->isDir()) {
            $data_file = $user_directory->getPathname() . '/data.txt';
            if(file_exists($data_file)) {
                $user_data = unserialize(file_get_contents($data_file)); {
                    if($user_data['email'] == $email) {
                        $user_data['id'] = basename($user_directory->getPathname());
                        return $user_data;
                    }
                }
            }
        }
    }
    return null;
}