<?php
if (isset($_POST['edit_cat'])) {
    $post_id = $_POST['post_id'];
    $cat_id = $_POST['cat_id'];
    $name = $_POST['name'];
    $short_desc = $_POST['short_desc'];
    $description = $_POST['description'];
    $publish = $_POST['publish'];
    $tags = $_POST['tags'];
    // get the  date
    date_default_timezone_set('Asia/Riyadh');
    $date = date('d/m/Y h:i a');
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم المقال';
    }
    // main image
    if (!empty($_FILES['main_image']['name'])) {
        $main_image_name = $_FILES['main_image']['name'];
        $main_image_temp = $_FILES['main_image']['tmp_name'];
        $main_image_type = $_FILES['main_image']['type'];
        $main_image_size = $_FILES['main_image']['size'];
        $main_image_uploaded = time() . '_' . $main_image_name;
        move_uploaded_file(
            $main_image_temp,
            'posts/images/' . $main_image_uploaded
        );
    } else {
        $main_image_uploaded = '';
    }

    $stmt = $connect->prepare("SELECT * FROM posts WHERE name=? AND id !=?");
    $stmt->execute(array($name, $post_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم المقال موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE posts SET cat_id=?,name=?,short_desc=?,description=?,tags=?,date=?,publish=? WHERE id = ? ");
        $stmt->execute(array($cat_id, $name, $short_desc, $description, $tags, $date, $publish, $post_id));
        if (!empty($_FILES['main_image']['name'])) {
            $stmt = $connect->prepare("UPDATE posts SET main_image=? WHERE id = ? ");
            $stmt->execute(array($main_image_uploaded, $post_id));
        }
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=posts&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=posts&page=report');
        exit();
    }
}
