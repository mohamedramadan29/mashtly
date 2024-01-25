<?php
if (isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
    $cat_id = $_GET['cat_id'];
    $stmt = $connect->prepare('SELECT * FROM landscap_request WHERE id= ?');
    $stmt->execute([$cat_id]);
    $cat_data = $stmt->fetch();
    $cat_image = $cat_data['attachment'];
    if (!empty($cat_image)) {
        $cat_image = "landscap_orders/attachments/" . $cat_image;
        unlink($cat_image);
    }
    $stmt = $connect->prepare('DELETE FROM landscap_request WHERE id=?');
    $stmt->execute([$cat_id]);
    if ($stmt) {
        $_SESSION['success_message'] = "تم الحذف بنجاح";
        header('Location: main?dir=landscap_orders&page=report');
        exit(); // Terminate the script after redirecting
    }
}
