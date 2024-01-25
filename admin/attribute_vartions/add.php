<?php
if (isset($_POST['add_cat'])) {
    $name = $_POST['name'];
    $attribute_slug = createSlug($name);
    $options = $_POST['options'];
    $options = explode(',', $options);

    $formerror = [];
    if (empty($name)) {
        $formerror[] = ' من فضلك ادخل اسم الخاصية  ';
    } elseif (empty($options)) {
        $formerror[] = ' من فضلك ادخل الاختيارات  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO  product_attribute (name,slug)
        VALUES (:zname,:zslug)");
        $stmt->execute(array(
            "zname" => $name,
            "zslug" =>$attribute_slug
        ));
        $stmt = $connect->prepare("SELECT * FROM product_attribute ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $last_data = $stmt->fetch();
        $last_id = $last_data['id'];
        foreach ($options as $option) {
            $stmt = $connect->prepare("INSERT INTO product_variations (attribute_id ,name ,slug)
            VALUES(:zattribute_id,:zname,:zslug)
            ");
            $stmt->execute(array(
                "zattribute_id" => $last_id,
                "zname" => $option,
                "zslug" => createSlug($option),
            ));
        }
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=attribute_vartions&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=attribute_vartions&page=report');
        exit();
    }
}
