<?php
if (isset($_GET['pro_id']) && is_numeric($_GET['pro_id'])) {
    $pro_id = $_GET['pro_id'];

    $stmt = $connect->prepare('SELECT * FROM products WHERE id= ?');
    $stmt->execute([$pro_id]);
    $pro_data = $stmt->fetch();
    $pro_image = $pro_data['main_image'];
    $more_images = $pro_data['more_images'];

    if (file_exists($pro_image)) {
        $product_image = "product_images/" . $pro_image;

        unlink($product_image);
    }
    // Delete More images 
    if (!empty($more_images)) {
        $image_arr = explode(',', $more_images);
        foreach ($image_arr as $image) {
            $image_file = "product_images/" . $image;
            if (file_exists($image_file)) {
                unlink($image_file);
            }
        }
    }
    $count = $stmt->rowCount();
    if ($count > 0) {

        $stmt = $connect->prepare('DELETE FROM products WHERE id=?');
        $stmt->execute([$pro_id]);
        if ($stmt) {
            $_SESSION['success_message'] = " تم الحذف بنجاح  ";
            header('Location:main?dir=products&page=report');
        }
    }
}
