<?php
if (isset($_POST['edit_cat'])) {
    $banner_id = $_POST['banner_id'];
    $head_name = $_POST['head_name'];
    $description = $_POST['description'];
    $formerror = [];

    // main image
    if (!empty($_FILES['main_image']['name'])) {
        $main_image_name = $_FILES['main_image']['name'];
        $main_image_temp = $_FILES['main_image']['tmp_name'];
        $main_image_type = $_FILES['main_image']['type'];
        $main_image_size = $_FILES['main_image']['size'];
        $main_image_uploaded = time() . '_' . $main_image_name;
        move_uploaded_file(
            $main_image_temp,
            'banners/images/' . $main_image_uploaded
        );
    } else {
        $main_image_uploaded = '';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE banners SET head_name=?,description=? WHERE id = ? ");
        $stmt->execute(array($head_name, $description, $banner_id));
        if (!empty($_FILES['main_image']['name'])) {
            $stmt = $connect->prepare("UPDATE banners SET image=? WHERE id = ? ");
            $stmt->execute(array($main_image_uploaded, $banner_id));
        }
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=banners&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=banners&page=report');
        exit();
    }
}
