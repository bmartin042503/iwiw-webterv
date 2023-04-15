<?php
session_start();

$posts_directory = "../posts/";
if(!file_exists($posts_directory)) {
    mkdir($posts_directory, 0777, true);
}

if(isset($_POST['submitpost'])) {
    $post_id = uniqid();
    $post_folder = $posts_directory . DIRECTORY_SEPARATOR . $post_id;
    mkdir($post_folder, 0777, true);

    $post_description = $_POST['post-create-description'];
    $post_file = $post_folder . DIRECTORY_SEPARATOR . "data.txt";
    $post_data = [
        'id' => $post_id,
        'userid' => $_SESSION['user_data']['id'],
        'description' => $post_description,
        'likes' => 0,
    ];
    file_put_contents($post_file, $post_description);
}
?>