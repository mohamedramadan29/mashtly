<?php
if (isset($_POST['add_cat'])) {
    $name = $_POST['name'];
    $slug = createSlug($name);
    $parent = $_POST['parent_id'];
    if($parent == 0){
        $parent =null;
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
        $stmt = $connect->prepare("INSERT INTO categories (parent_id , name, slug)
        VALUES (:zparent,:zname,:zslug)");
        $stmt->execute(array(
            "zparent" => $parent,
            "zname" => $name,
            "zslug" => $slug,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=categories&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=categories&page=report');
        exit();
    }
}
