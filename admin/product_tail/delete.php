<?php
if (isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
    $cat_id = $_GET['cat_id'];

    $stmt = $connect->prepare('DELETE FROM public_tails WHERE id=?');
    $stmt->execute([$cat_id]);
    if ($stmt) {
        $_SESSION['success_message'] = "تم الحذف بنجاح";
        header('Location: main?dir=product_tail&page=report');
        exit(); // Terminate the script after redirecting
    }
}
