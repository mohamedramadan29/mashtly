<?php

if (isset($_GET['faq_id']) && is_numeric($_GET['faq_id'])) {
    $faq_id = $_GET['faq_id'];
    $stmt = $connect->prepare('SELECT * FROM product_faqs WHERE id= ?');
    $stmt->execute([$faq_id]);
    
    $cat_data = $stmt->fetch();
    $product_id = $cat_data['product_id'];
    $stmt = $connect->prepare('DELETE FROM product_faqs WHERE id=?');
    $stmt->execute([$faq_id]);
    if ($stmt) {
        $_SESSION['success_message'] = "تم الحذف بنجاح";
        header('Location:main?dir=products/faqs&page=report&pro_id=' . $product_id);
        exit(); // Terminate the script after redirecting
    }
}
