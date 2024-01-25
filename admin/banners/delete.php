<?php
if (isset($_GET['banner_id']) && is_numeric($_GET['banner_id'])) {
    $banner_id = $_GET['banner_id'];
    $stmt = $connect->prepare('SELECT * FROM banners WHERE id= ?');
    $stmt->execute(array($banner_id));
    $cat_data = $stmt->fetch();
    $cat_image = $cat_data['image'];
    if (!empty($cat_image)) {
        $cat_image = "banners/images/" . $cat_image;
        echo $cat_image;
        unlink($cat_image);
    }
    $stmt = $connect->prepare('DELETE FROM banners WHERE id=?');
    $stmt->execute([$banner_id]);
    if ($stmt) {
        $_SESSION['success_message'] = "تم الحذف بنجاح";
        header('Location: main?dir=banners&page=report');
        exit(); // Terminate the script after redirecting
    }
}
