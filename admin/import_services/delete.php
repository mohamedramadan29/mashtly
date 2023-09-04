<?php
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $stmt = $connect->prepare('SELECT * FROM import_services WHERE id= ?');
    $stmt->execute(array($order_id));
    $cat_data = $stmt->fetch();

    $stmt = $connect->prepare('DELETE FROM import_services WHERE id=?');
    $stmt->execute([$order_id]);
    if ($stmt) {
        $_SESSION['success_message'] = "تم الحذف بنجاح";
        header('Location: main?dir=import_services&page=report');
        exit(); // Terminate the script after redirecting
    }
}
