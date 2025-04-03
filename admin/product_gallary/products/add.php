<?php
if (isset($_POST['add_cat'])) {
    try {
        $name = $_POST['name'];
        $image_alt = $_POST['image_alt'];
        $desc = $_POST['product_desc'];
        $status = $_POST['status'];
        $category_id = $_POST['category_id'];
        $product_url = $_POST['product_url'];
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
        if (empty($name)) {
            $formerror[] = ' من فضلك ادخل اسم    ';
        } elseif (empty($image_alt)) {
            $formerror[] = ' من فضلك ادخل  اسم الصورة  ';
        } elseif (empty($product_url)) {
            $formerror[] = ' من فضلك ادخل رابط المنتج ';
        }
        if (empty($formerror)) {
            $stmt = $connect->prepare("INSERT INTO product_categories_gallary (category_id,name,image,image_alt,product_desc,product_url,status)
            VALUES (:zcategory_id,:zname,:zimage,:zimage_alt,:zproduct_desc,:zproduct_url,:zstatus)");
            $stmt->execute(array(
                "zcategory_id" => $category_id,
                "zname" => $name,
                "zimage" => $uploaded_image_name,
                "zimage_alt" => $image_alt,
                "zproduct_desc" => $desc,
                "zproduct_url" => $product_url,
                "zstatus" => $status
            ));
            if ($stmt) {
                $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
                header('Location:main?dir=product_gallary/products&page=index&category_id='.$category_id);
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
