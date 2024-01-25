<?php
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $stmt = $connect->prepare('SELECT * FROM big_orders WHERE id= ?');
    $stmt->execute(array($order_id));
    $cat_data = $stmt->fetch();
    $cat_image = $cat_data['order_attachments'];
    if (!empty($cat_image)) {
        $cat_image = "big_orders/attachments/" . $cat_image;
        unlink($cat_image);
    }
    $stmt = $connect->prepare('DELETE FROM big_orders WHERE id=?');
    $stmt->execute([$order_id]);
    if ($stmt) {
        $_SESSION['success_message'] = "تم الحذف بنجاح";
        header('Location: main?dir=big_orders&page=report');
        exit(); // Terminate the script after redirecting
    }
}
