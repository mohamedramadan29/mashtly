<?php
if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $stmt = $connect->prepare('SELECT * FROM product_categories_gallary WHERE id= ?');
    $stmt->execute([$product_id]);
    $cat_data = $stmt->fetch();
    $stmt = $connect->prepare('DELETE FROM product_categories_gallary WHERE id=?');
    $stmt->execute([$product_id]);
    $category_id = $cat_data['category_id'];
    if ($stmt) {
        $_SESSION['success_message'] = "تم الحذف بنجاح";
        header('Location:main?dir=product_gallary/products&page=index&category_id=' . $category_id);
        exit(); // Terminate the script after redirecting
    }
}
