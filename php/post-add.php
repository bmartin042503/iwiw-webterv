<?php
session_start();

$posts_directory = "../posts/";
if(!file_exists($posts_directory)) {
    mkdir($posts_directory, 0777, true);
}

if(isset($_POST['submitpost'])) {
    $post_description = trim($_POST['post-create-description']);
    $user_id = $_SESSION['user_data']['id'];
    $post_id = uniqid();
    $post_date = date('Y-m-d H:i:s');

    $has_image = !empty($_FILES['photoadd']['tmp_name']);

    $post_directory = "../db/posts/{$post_id}/";

    if(strlen($post_description) >= 1 || $has_image) {

        if(!file_exists($post_directory)) {
            mkdir($post_directory, 0777, true);
        }
    
        $data_file = $post_directory . 'data.txt';
        $post_data = [
            'id' => $post_id,
            'user_id' => $user_id,
            'date' => $post_date,
            'description' => $post_description,
            'likes' => 0,
            'shares' => 0
        ];
    
        file_put_contents($data_file, serialize($post_data));
    
        // $comments_file = $post_directory . 'comments.txt';
        // touch($comments_file);

        if($has_image) {
            $image_type = strtolower(pathinfo($_FILES['photoadd']['name'], PATHINFO_EXTENSION));
            if(in_array($image_type, ['png', 'jpg', 'jpeg', 'gif'])) {
                $image_file = $post_directory . 'post-img.' . $image_type;
                move_uploaded_file($_FILES['photoadd']['tmp_name'], $image_file);
            } else {
                $_SESSION['post-error'] = 'Nem megfelelő fájlformátum. Csak PNG, JPG, JPEG és GIF engedélyezett.';
                header("Location: home.php");
                exit();
            }
        }

    } else {
        $_SESSION['post-error'] = 'A bejegyzésnek tartalmaznia kell legalább egy karaktert vagy egy képet.';
        header("Location: home.php");
        exit();
    }

    header("Location: home.php");
    exit();
}
?>