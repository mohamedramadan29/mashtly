<?php
if (isset($_POST['edit_cat'])) {
    $cat_id = $_POST['cat_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم  ';
    }
    $stmt = $connect->prepare("SELECT * FROM public_tails WHERE name = ? AND id != ?");
    $stmt->execute(array($name, $cat_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم   موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE public_tails SET name=? , price=? WHERE id = ? ");
        $stmt->execute(array($name, $price, $cat_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=product_tail&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=product_tail&page=report');
        exit();
    }
}
