<?php
if (isset($_GET['attribute_id']) && is_numeric($_GET['attribute_id'])) {
    $attribute_id = $_GET['attribute_id'];
    $stmt = $connect->prepare("DELETE FROM product_variations WHERE attribute_id = ?");
    $stmt->execute(array($attribute_id));
    $stmt = $connect->prepare('SELECT * FROM product_attribute WHERE id= ?');
    $stmt->execute([$attribute_id]);
    $cat_data = $stmt->fetch(); 
    $stmt = $connect->prepare('DELETE FROM product_attribute WHERE id=?');
    $stmt->execute([$attribute_id]);
    if ($stmt) {
        $_SESSION['success_message'] = "تم الحذف بنجاح";
        header('Location: main?dir=attribute_vartions&page=report');
        exit(); // Terminate the script after redirecting
    }
}
