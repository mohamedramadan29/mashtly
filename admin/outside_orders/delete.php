<?php
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $stmt = $connect->prepare('SELECT * FROM orders WHERE id= ?');
    $stmt->execute([$order_id]);
    $order_data = $stmt->fetch();
    $stmt = $connect->prepare("DELETE FROM order_details WHERE order_id = ?");
    $stmt->execute(array($order_id));
    $stmt = $connect->prepare('DELETE FROM orders WHERE id=?');
    $stmt->execute([$order_id]);
    if ($stmt) {
        $_SESSION['success_message'] = " تم الحذف بنجاح  ";
        header('Location:main?dir=orders&page=report');
    }
}
