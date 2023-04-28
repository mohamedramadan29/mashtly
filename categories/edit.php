<?php
if (isset($_POST['edit_cat'])) {
    $cat_id = $_POST['cat_id'];
    $name = $_POST['name'];
    $parent = $_POST['parent_id'];
    if ($parent == 0) {
        $parent = null;
    }
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم القسم';
    }
    $stmt = $connect->prepare("SELECT * FROM categories WHERE slug = ?");
    $stmt->execute(array($slug));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم القسم موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE categories SET parent_id=?,name=? WHERE id = ? ");
        $stmt->execute(array($parent, $name, $cat_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=categories&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=categories&page=report');
        exit();
    }
}
