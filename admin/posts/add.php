<?php
if (isset($_POST['add_cat'])) {
    $name = $_POST['name'];
    $cat_id = $_POST['cat_id'];
    $slug = createSlug($name);
    $short_desc = $_POST['short_desc'];
    $description = $_POST['description'];
    $publish = $_POST['publish'];
    $tags = $_POST['tags'];
    // get the  date
    date_default_timezone_set('Asia/Riyadh');
    $date = date('d/m/Y h:i a');
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم المقال ';
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

    $stmt = $connect->prepare("SELECT * FROM posts WHERE name = ?");
    $stmt->execute(array($name));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم المقال موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO posts (cat_id,name,slug,main_image,short_desc,description,tags,date,publish)
        VALUES (:zcat_id,:zname,:zslug,:zimage,:zshort_desc,:zdesc,:ztags,:zdate,:zpublish)");
        $stmt->execute(array(
            "zcat_id" => $cat_id,
            "zname" => $name,
            "zslug" => $slug,
            "zimage" => $main_image_uploaded,
            "zshort_desc" => $short_desc,
            "zdesc" => $description,
            "ztags" => $tags,
            "zdate" => $date,
            "zpublish" => $publish,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=posts&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=posts&page=report');
        exit();
    }
}
