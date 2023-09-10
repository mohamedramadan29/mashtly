<?php
if (isset($_POST['edit_cat'])) {
    $cat_id = $_POST['cat_id'];
    $name = $_POST['name'];
    $head = $_POST['head'];
    $description = $_POST['description'];
    $formerror = [];
    if (empty($name)) {
        $formerror[] = ' من فضلك ادخل العنوان  ';
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
            'testmonails/images/' . $main_image_uploaded
        );
    } else {
        $main_image_uploaded = '';
    }
 
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE testmonails SET head=?,description=?, name=? WHERE id = ? ");
        $stmt->execute(array($head, $description, $name, $cat_id));
        if (!empty($_FILES['main_image']['name'])) {
            $stmt = $connect->prepare("UPDATE testmonails SET image=? WHERE id = ? ");
            $stmt->execute(array($main_image_uploaded, $cat_id));
        }
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=testmonails&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=testmonails&page=report');
        exit();
    }
}
