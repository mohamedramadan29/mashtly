<?php
if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $stmt = $connect->prepare('SELECT * FROM categories_gallary WHERE id= ?');
    $stmt->execute([$category_id]);
    $cat_data = $stmt->fetch(); 
    $stmt = $connect->prepare('DELETE FROM categories_gallary WHERE id=?');
    $stmt->execute([$category_id]);
    if ($stmt) {
        $_SESSION['success_message'] = "تم الحذف بنجاح";
        header('Location:main?dir=product_gallary/categories&page=index');
        exit(); // Terminate the script after redirecting
    }
}
