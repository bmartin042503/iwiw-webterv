<?php
session_start();

if(isset($_POST['submit-comment'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_data']['id'];
    $comment_id = uniqid();
    $comment_description = trim($_POST['comment-create-description']);
    $comment_date = date('Y-m-d H:i:s');

    if(strlen($comment_description) >= 1) {
        $comments_file = "../db/posts/$post_id/comments.txt";
        
        $comment_data = [
            'id' => $comment_id,
            'user_id' => $user_id,
            'post_id' => $post_id,
            'date' => $comment_date,
            'description' => $comment_description
        ];

        $comments = [];

        if(file_exists($comments_file)) {
            $comments = unserialize(file_get_contents($comments_file));
        }

        $comments[] = $comment_data;
        file_put_contents($comments_file, serialize($comments));
    }

    header("Location: home.php");
    exit();
}
?>