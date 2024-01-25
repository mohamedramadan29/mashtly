<?php
if (isset($_POST['edit_cat'])) {
    $attribute_id = $_POST['attribute_id'];
    $name = $_POST['name'];
    $options = $_POST['options'];
    $options = explode(',', $options);
    $formerror = [];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE product_attribute SET name=? WHERE id = ? ");
        $stmt->execute(array($name, $attribute_id));
        // delete all old options 
        $stmt = $connect->prepare("DELETE FROM product_variations WHERE attribute_id =?");
        $stmt->execute(array($attribute_id));
        // Insert New options 
        foreach ($options as $option) {
            $stmt = $connect->prepare("INSERT INTO product_variations (attribute_id,name,slug)
            VALUES(:zattribute_id,:zname,:zslug)
            ");
            $stmt->execute(array(
                "zattribute_id" => $attribute_id,
                "zname" => $option,
                "zslug"=>createSlug($option),
            ));
        }
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=attribute_vartions&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=attribute_vartions&page=report');
        exit();
    }
}
