<?php
if (isset($_POST['add_cat'])) {
    $head_name = $_POST['head_name'];
    $description = $_POST['description'];
    $formerror = [];
    if (empty($head_name)) {
        $formerror[] = 'من فضلك ادخل العنوان  ';
    }
    // main image
    if (!empty($_FILES['main_image']['name'])) {
        $main_image_name = $_FILES['main_image']['name'];
        $main_image_temp = $_FILES['main_image']['tmp_name'];
        $main_image_type = $_FILES['main_image']['type'];
        $main_image_size = $_FILES['main_image']['size'];
        $main_image_uploaded = time() . '_' . $main_image_name;
        $upload_path  = 'banners/images/' . $main_image_uploaded;
        move_uploaded_file($main_image_temp, $upload_path);
        // Check the image type and convert it to WebP if it's supported
        if (exif_imagetype($upload_path) === IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($upload_path);
        } elseif (exif_imagetype($upload_path) === IMAGETYPE_PNG) {
            $image = imagecreatefrompng($upload_path);
        }
        if ($image !== false) {
            $webp_path = 'banners/images/' . pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';
            // Save the image as WebP
            imagewebp($image, $webp_path);
            // Clean up memory
            imagedestroy($image);
            // Update the uploaded image path to the WebP version
            $main_image_uploaded = pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';
        }
    } else {
        $main_image_uploaded = '';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO banners (head_name , description,image)
        VALUES (:zname,:zdesc,:zimage)");
        $stmt->execute(array(
            "zname" => $head_name,
            "zdesc" => $description,
            "zimage" => $main_image_uploaded,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=banners&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=banners&page=report');
        exit();
    }
}
