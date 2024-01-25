<?php
if (isset($_POST['edit_cat'])) {
    $land_id = $_POST['land_id'];
    $name = $_POST['name'];
    $slug = createSlug($name);
    $tags = $_POST['tags'];
    $description = $_POST['description'];
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم التنسق';
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


    $stmt = $connect->prepare("SELECT * FROM landscap WHERE slug = ? AND id !=?");
    $stmt->execute(array($slug, $land_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم التنسيق  موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE landscap SET name=?,slug=?,description=?,tags=? WHERE id = ? ");
        $stmt->execute(array($name, $slug, $description, $tags, $land_id));
        if (!empty($_FILES['main_image']['name'])) {
            $stmt = $connect->prepare("UPDATE landscap SET image=? WHERE id = ? ");
            $stmt->execute(array($main_image_uploaded, $land_id));
        }
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
           header('Location:main?dir=landscap&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
       header('Location:main?dir=landscap&page=report');
        exit();
    }
}
