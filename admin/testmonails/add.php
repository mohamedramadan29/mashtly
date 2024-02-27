<?php
if (isset($_POST['add_cat'])) {
    $name = $_POST['name'];
    // $head = $_POST['head'];
    $description = $_POST['description'];
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم العميل ';
    }
    // main image
    // if (!empty($_FILES['main_image']['name'])) {
    //     $main_image_name = $_FILES['main_image']['name'];
    //     $main_image_temp = $_FILES['main_image']['tmp_name'];
    //     $main_image_type = $_FILES['main_image']['type'];
    //     $main_image_size = $_FILES['main_image']['size'];
    //     $main_image_uploaded = time() . '_' . $main_image_name;
    //     move_uploaded_file(
    //         $main_image_temp,
    //         'testmonails/images/' . $main_image_uploaded
    //     );
    // } else {
    //     $main_image_uploaded = '';
    // }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO testmonails (description, name)
        VALUES (:zdesc,:zname)");
        $stmt->execute(array(
            // "zhead" => $head,
            "zdesc" => $description,
            // "zimage" => $main_image_uploaded,
            "zname" => $name,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=testmonails&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=testmonails&page=report');
        exit();
    }
}
