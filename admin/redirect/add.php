<?php
if (isset($_POST['add_cat'])) {
    $formerror = [];
    $old_url = $_POST['old_url'];
    $new_url = $_POST['new_url'];
    $status_code = $_POST['status_code'];
    if (empty($old_url)) {
        $formerror[] = 'من فضلك ادخل الرابط القديم   ';
    }
    if (empty($new_url)) {
        $formerror[] = 'من فضلك ادخل الرابط الحديث   ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO redirects (old_url,new_url,status_code)
        VALUES (:zold_url,:znew_url,:zstatus_code)");
        $stmt->execute(array(
            "znew_url" => $new_url,
            "zold_url" => $old_url,
            "zstatus_code" => $status_code,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=redirect&page=index');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=redirect&page=index');
        exit();
    }
}
