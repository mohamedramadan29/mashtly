<?php
if (isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
    $cat_id = $_GET['cat_id'];

    $stmt = $connect->prepare('SELECT * FROM categories WHERE id= ?');
    $stmt->execute([$cat_id]);
    $count = $stmt->rowCount();
    if ($count > 0) {
        $stmt = $connect->prepare('DELETE FROM categories WHERE id=?');
        $stmt->execute([$cat_id]);
        if ($stmt) {
            $_SESSION['success_message'] = " تم الحذف بنجاح  ";
            header('Location:main?dir=categories&page=report');
        }
    }
}
