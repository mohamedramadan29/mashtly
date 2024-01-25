<?php
if (isset($_POST['edit_cat'])) {
    $formerror = [];
    $gift_id = $_POST['gift_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    if (!empty($_FILES['main_image']['name'])) {
        $main_image_name = $_FILES['main_image']['name'];
        $main_image_name = str_replace(' ', '-', $main_image_name);
        $main_image_temp = $_FILES['main_image']['tmp_name'];
        $main_image_type = $_FILES['main_image']['type'];
        $main_image_size = $_FILES['main_image']['size'];
        // حصل على امتداد الصورة من اسم الملف المرفوع
        $main_image_uploaded = $main_image_name;
        $upload_path = 'gifts/images/' . $main_image_uploaded;
        move_uploaded_file($main_image_temp, $upload_path);
        // Check the image type and convert it to WebP if it's supported
        if (exif_imagetype($upload_path) === IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($upload_path);
        } elseif (exif_imagetype($upload_path) === IMAGETYPE_PNG) {
            $image = imagecreatefrompng($upload_path);
        }
        if ($image !== false) {
            $webp_path = 'gifts/images/' . pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';
            // Save the image as WebP
            imagewebp($image, $webp_path);
            // Clean up memory
            imagedestroy($image);
            // Update the uploaded image path to the WebP version
            $main_image_uploaded = pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';
        }
    }
    if (empty($price)) {
        $formerror[] = 'من فضلك ادخل سعر الهدية';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE gifts SET name=? ,price=? WHERE id = ? ");
        $stmt->execute(array($name, $price, $gift_id));

        if (!empty($_FILES['main_image']['name'])) {
            $stmt = $connect->prepare("UPDATE gifts SET image=? WHERE id=?");
            $stmt->execute(array(
                $main_image_uploaded, $gift_id
            ));
        }
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=gifts&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=gifts&page=report');
        exit();
    }
}
