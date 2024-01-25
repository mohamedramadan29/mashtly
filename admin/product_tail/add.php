<?php
if (isset($_POST['add_cat'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم  ';
    }


    $stmt = $connect->prepare("SELECT * FROM public_tails WHERE name = ?");
    $stmt->execute(array($slug));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم   موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO public_tails (name, price)
        VALUES (:zname,:zprice)");
        $stmt->execute(array(
            "zname" => $name,
            "zprice" => $price
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=product_tail&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=product_tail&page=report');
        exit();
    }
}
