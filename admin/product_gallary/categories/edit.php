<?php
if (isset($_POST['edit_cat'])) {
    try {
        $category_id = $_POST['category_id'];
        $name = $_POST['name'];
        $slug = createSlug($name);
        $image_alt = $_POST['image_alt'];
        $desc = $_POST['desc'];
        $status = $_POST['status'];
        $product_url = $_POST['product_url'];

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
        if (empty($formerror)) {
            $stmt = $connect->prepare("UPDATE categories_gallary SET name=?,slug=?,image_alt=?,cat_desc=?,status=? WHERE id = ? ");
            $stmt->execute(array($name,$slug, $image_alt, $desc, $status, $category_id));
            ###### If the image is uploaded
            if (!empty($_FILES['main_image']['name'])) {
                $stmt = $connect->prepare("UPDATE categories_gallary SET image=? WHERE id = ? ");
                $stmt->execute(array($uploaded_image_name, $category_id));
            }
            if ($stmt) {
                $_SESSION['success_message'] = "تم التعديل بنجاح ";
                header('Location:main?dir=product_gallary/categories&page=index');
                exit();
            }
        } else {
            $_SESSION['error_messages'] = $formerror;
            header('Location:main?dir=product_gallary/categories&page=index');
            exit();
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }

}
