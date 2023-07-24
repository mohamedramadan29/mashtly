<?php
if (isset($_GET['post_id']) && is_numeric($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $stmt = $connect->prepare('SELECT * FROM posts WHERE id= ?');
    $stmt->execute([$post_id]);
    $cat_data = $stmt->fetch();
    $cat_image = $cat_data['main_image'];
    if (file_exists($cat_image)) {
        $cat_image = "posts/images/" . $cat_image;
        unlink($cat_image);
    }
    $stmt = $connect->prepare('DELETE FROM posts WHERE id=?');
    $stmt->execute([$post_id]);
    if ($stmt) {
        $_SESSION['success_message'] = "تم الحذف بنجاح";
        header('Location: main?dir=posts&page=report');
        exit(); // Terminate the script after redirecting
    }
}
