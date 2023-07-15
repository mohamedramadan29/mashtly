<?php
if (isset($_POST['add_cat'])) {
    $formerror = [];
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
        move_uploaded_file(
            $main_image_temp,
            'gifts/images/' . $main_image_uploaded
        );
    } else {
        $formerror[] = ' من فضلك ادخل صورة  المنتج   ';
    }
    if (empty($price)) {
        $formerror[] = 'من فضلك ادخل سعر الهدية';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO gifts (name,price,image)
        VALUES (:zname,:zprice,:zimage)");
        $stmt->execute(array(
            "zname" => $name,
            "zprice" => $price,
            "zimage" => $main_image_uploaded,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=gifts&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=gifts&page=report');
        exit();
    }
}
