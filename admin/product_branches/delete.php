<?php
if (isset($_GET['prop_id']) && is_numeric($_GET['prop_id'])) {
    $prop_id = $_GET['prop_id'];
    $stmt = $connect->prepare('SELECT * FROM plant_properties WHERE id= ?');
    $stmt->execute([$prop_id]);
    $cat_data = $stmt->fetch(); 
    $stmt = $connect->prepare('DELETE FROM plant_properties WHERE id=?');
    $stmt->execute([$prop_id]);
    if ($stmt) {
        $_SESSION['success_message'] = "تم الحذف بنجاح";
        header('Location: main?dir=product_branches&page=report');
        exit(); // Terminate the script after redirecting
    }
}
