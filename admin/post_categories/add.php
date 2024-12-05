<?php
if (isset($_POST['add_cat'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $slug = createSlug($name);
    $parent_id = $_POST['parent_id'];
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
            '../uploads/post_categories/' . $main_image_uploaded
        );
    } else {
        $main_image_uploaded = '';
    }

    $stmt = $connect->prepare("SELECT * FROM category_posts WHERE name = ?");
    $stmt->execute(array($name));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم القسم موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO category_posts (name,parent_id,slug,main_image,description)
        VALUES (:zname,:zparent_id,:zslug,:zimage,:zdesc)");
        $stmt->execute(array(
            "zname" => $name,
            "zparent_id" => $parent_id,
            "zslug" => $slug,
            "zimage" => $main_image_uploaded,
            "zdesc" => $description,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=post_categories&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=post_categories&page=report');
        exit();
    }
}
