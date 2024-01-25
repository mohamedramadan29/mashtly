<?php
if (isset($_POST['edit_cat'])) {
    $prop_id = $_POST['prop_id'];
    $name = $_POST['name'];
    $options = $_POST['options'];
    $options = explode(',', $options);
    $formerror = [];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE plant_properties SET properity_name=? WHERE id = ? ");
        $stmt->execute(array($name, $prop_id));
        // delete all old options 
        $stmt = $connect->prepare("DELETE FROM plant_properity_options WHERE properity_id =?");
        $stmt->execute(array($prop_id));
        // Insert New options 
        foreach ($options as $option) {
            $stmt = $connect->prepare("INSERT INTO plant_properity_options (properity_id,name)
            VALUES(:zprop_id,:zname)
            ");
            $stmt->execute(array(
                "zprop_id" => $prop_id,
                "zname" => $option
            ));
        }
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=product_branches&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=product_branches&page=report');
        exit();
    }
}
