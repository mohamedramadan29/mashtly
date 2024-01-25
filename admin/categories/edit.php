<?php
if (isset($_POST['edit_cat'])) {
    $cat_id = $_POST['cat_id'];
    $name = $_POST['name'];
    $tags = $_POST['tags'];
    $parent = $_POST['parent_id'];
    $main_category = $_POST['main_category'];
    if ($parent == 0) {
        $parent = null;
    }
    $description = $_POST['description'];
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم القسم';
    }
    // main image
    if (!empty($_FILES['main_image']['name'])) {
        $main_image_name = $_FILES['main_image']['name'];
        $main_image_name = str_replace(' ', '-', $main_image_name);
        $main_image_temp = $_FILES['main_image']['tmp_name'];
        $main_image_type = $_FILES['main_image']['type'];
        $main_image_size = $_FILES['main_image']['size'];
        $main_image_uploaded = time() . '_' . $main_image_name;
        $upload_path = 'category_images/' . $main_image_uploaded;
        move_uploaded_file($main_image_temp, $upload_path);
        // Check the image type and convert it to WebP if it's supported
        if (exif_imagetype($upload_path) === IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($upload_path);
        } elseif (exif_imagetype($upload_path) === IMAGETYPE_PNG) {
            $image = imagecreatefrompng($upload_path);
        }
        if ($image !== false) {
            $webp_path = 'category_images/' . pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';
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

    $stmt = $connect->prepare("SELECT * FROM categories WHERE slug = ?");
    $stmt->execute(array($slug));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم القسم موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE categories SET parent_id=?,name=?,description=?,tags=?,main_category=? WHERE id = ? ");
        $stmt->execute(array($parent, $name, $description, $tags, $main_category, $cat_id));
        if (!empty($_FILES['main_image']['name'])) {
            $stmt = $connect->prepare("UPDATE categories SET image=? WHERE id = ? ");
            $stmt->execute(array($main_image_uploaded, $cat_id));
        }
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=categories&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=categories&page=report');
        exit();
    }
}
