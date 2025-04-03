<?php
if (isset($_POST['edit_cat'])) {
    try {

        $product_id = $_POST['product_id'];
        $name = $_POST['name'];
        $image_alt = $_POST['image_alt'];
        $desc = $_POST['desc'];
        $status = $_POST['status'];
        $product_url = $_POST['product_url'];
        $category_id = $_POST['category_id'];

        ######### Insert Image To Gallary
        if (!empty($_FILES['main_image']['name'])) {
            $main_image_name = str_replace(' ', '-', $_FILES['main_image']['name']);
            $new_image_name = time() . '-' . $main_image_name; // إضافة timestamp إلى الاسم
            $main_image_temp = $_FILES['main_image']['tmp_name'];
            $upload_path = '../uploads/gallary/' . $new_image_name;

            // حفظ ملف الصورة
            if (move_uploaded_file($main_image_temp, $upload_path)) {
                $uploaded_image_name = $new_image_name; // حفظ الاسم الجديد بعد رفعه
            } else {
                $uploaded_image_name = null;
            }
        }
        $formerror = [];
        if (empty($formerror)) {
            $stmt = $connect->prepare("UPDATE product_categories_gallary SET name=?,image_alt=?,product_desc=?,product_url=?,status=? WHERE id = ? ");
            $stmt->execute(array($name, $image_alt, $desc,$product_url, $status, $product_id));
            ###### If the image is uploaded
            if (!empty($_FILES['main_image']['name'])) {
                $stmt = $connect->prepare("UPDATE product_categories_gallary SET image=? WHERE id = ? ");
                $stmt->execute(array($uploaded_image_name, $product_id));
            }
            if ($stmt) {
                $_SESSION['success_message'] = "تم التعديل بنجاح ";
                header('Location:main?dir=product_gallary/products&page=index&category_id='.$category_id);
                exit();
            }
        } else {
            $_SESSION['error_messages'] = $formerror;
            header('Location:main?dir=product_gallary/products&page=index&category_id='.$category_id);
            exit();
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }

}
