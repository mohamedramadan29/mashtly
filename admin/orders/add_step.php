<?php
if (isset($_POST['add_cat'])) {
    $order_id = $_POST['order_id'];
    $order_number = $_POST['order_number'];
    $username = $_POST['username'];
    $step_name = $_POST['step_name'];
    // get the  date
    date_default_timezone_set('Asia/Riyadh'); // تحديد المنطقة الزمنية
    $date = date('d/m/Y h:i a'); // تنسيق التاريخ والوقت
    $formerror = [];
    if (empty($username)) {
        $formerror[] = 'من فضلك ادخل اسم المستخدم ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username , date , step_name)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name)");
        $stmt->execute(array(
            "zorder_id" => $order_id,
            "zorder_number" => $order_number,
            "zusername" => $username,
            "zdate" => $date,
            "zstep_name" => $step_name,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main.php?dir=orders&page=order_details&order_id='.$order_id);
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main.php?dir=orders&page=order_details&order_id='.$order_id);
        exit();
    }
}
