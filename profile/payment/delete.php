<?php
include "../../admin/connect.php";
if (isset($_POST['delete_card'])) {
    $card_id = $_POST['card_id'];
    $stmt = $connect->prepare("SELECT * FROM user_payments WHERE id = ?");
    $stmt->execute(array($card_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $stmt = $connect->prepare('DELETE FROM user_payments WHERE id=?');
        $stmt->execute([$card_id]);
        if ($stmt) {
            $_SESSION['success'] = " تم حذف الكارت بنجاح  ";
            header('Location:index');
            exit(); // Terminate the script after redirecting
        }
    } else {
        header("Location:index");
    }
}
