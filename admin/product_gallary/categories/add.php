<?php
if (isset($_POST['add_cat'])) {
    try{
        $name = $_POST['name'];
        $slug = createSlug($name);
        $image_alt = $_POST['image_alt'];
        $desc = $_POST['desc'];
        $status = $_POST['status'];
    
        ######### Insert Image To Gallary
        if (!empty($_FILES['main_image']['name'])) {
            $main_image_name = $_FILES['main_image']['name'];
            $main_image_name = str_replace(' ', '-', $main_image_name);
            $main_image_temp = $_FILES['main_image']['tmp_name'];
            $upload_path = '../uploads/gallary/' . $main_image_name;
            // حفظ ملف الصورة المرفوع
            $main_image_uploaded = move_uploaded_file($main_image_temp, $upload_path);
            $uploaded_image_name = $main_image_uploaded ? $main_image_name : null;
    
        }
        $formerror = [];
        if (empty($name)) {
            $formerror[] = ' من فضلك ادخل اسم    ';
        } elseif (empty($image_alt)) {
            $formerror[] = ' من فضلك ادخل  اسم الصورة  ';
        }
        if (empty($formerror)) {
            $stmt = $connect->prepare("INSERT INTO categories_gallary (name,slug,image,image_alt,cat_desc,status)
            VALUES (:zname,:zslug,:zimage,:zimage_alt,:zcat_desc,:zstatus)");
            $stmt->execute(array(
                "zname" => $name,
                "zslug" => $slug,
                "zimage" => $uploaded_image_name,
                "zimage_alt" => $image_alt,
                "zcat_desc" => $desc,
                "zstatus" => $status
            ));
            if ($stmt) {
                $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
                header('Location:main?dir=product_gallary/categories&page=index');
            }
        } else {
            $_SESSION['error_messages'] = $formerror;
            header('Location:main?dir=product_gallary/categories&page=index');
            exit();
        }
    }catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
    
}
