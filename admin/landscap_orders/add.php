<?php
if (isset($_POST['add_cat'])) {
    $name = $_POST['name'];
    $slug = createSlug($name);
    $description = $_POST['description'];
    $tags = $_POST['tags'];

    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم التنسيق';
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
            'landscap/images/' . $main_image_uploaded
        );
    } else {
        $main_image_uploaded = '';
    }

    $stmt = $connect->prepare("SELECT * FROM landscap WHERE slug = ?");
    $stmt->execute(array($slug));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم القسم موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO landscap (name, slug,description,image,tags)
        VALUES (:zname,:zslug,:zdesc,:zimage,:ztags)");
        $stmt->execute(array(
            "zname" => $name,
            "zslug" => $slug,
            "zimage" => $main_image_uploaded,
            "zdesc" => $description,
            "ztags" => $tags,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=landscap&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=landscap&page=report');
        exit();
    }
}
