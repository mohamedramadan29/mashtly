<?php
if (isset($_POST['edit_cat'])) {
    $cat_id = $_POST['cat_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم القسم';
    }
    // main image
    if (!empty($_FILES['main_image']['name'])) {
        $main_image_name = $_FILES['main_image']['name'];
        $main_image_name = str_replace(' ', '', $main_image_name);
        $main_image_temp = $_FILES['main_image']['tmp_name'];
        $main_image_type = $_FILES['main_image']['type'];
        $main_image_size = $_FILES['main_image']['size'];
        $main_image_uploaded = time() . '_' . $main_image_name;
        move_uploaded_file(
            $main_image_temp,
            'post_categories/images/' . $main_image_uploaded
        );
    } else {
        $main_image_uploaded = '';
    }

    $stmt = $connect->prepare("SELECT * FROM category_posts WHERE name=? AND id !=?");
    $stmt->execute(array($name, $cat_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم القسم موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE category_posts SET name=?,description=? WHERE id = ? ");
        $stmt->execute(array($name, $description, $cat_id));
        if (!empty($_FILES['main_image']['name'])) {
            $stmt = $connect->prepare("UPDATE category_posts SET main_image=? WHERE id = ? ");
            $stmt->execute(array($main_image_uploaded, $cat_id));
        }
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=post_categories&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=post_categories&page=report');
        exit();
    }
}
