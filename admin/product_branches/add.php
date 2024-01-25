<?php
if (isset($_POST['add_cat'])) {
    $name = $_POST['name'];
    $options = $_POST['options'];
    $options = explode(',', $options);

    $formerror = [];
    if (empty($name)) {
        $formerror[] = ' من فضلك ادخل اسم الخاصية  ';
    } elseif (empty($options)) {
        $formerror[] = ' من فضلك ادخل الاختيارات  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO  plant_properties (properity_name)
        VALUES (:zname)");
        $stmt->execute(array(
            "zname" => $name
        ));
        $stmt = $connect->prepare("SELECT * FROM plant_properties ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $last_data = $stmt->fetch();
        $last_id = $last_data['id'];
        foreach ($options as $option) {
            $stmt = $connect->prepare("INSERT INTO plant_properity_options (properity_id,name)
            VALUES(:zprop_id,:zname)
            ");
            $stmt->execute(array(
                "zprop_id" => $last_id,
                "zname" => $option
            ));
        }
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=product_branches&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=product_branches&page=report');
        exit();
    }
}
