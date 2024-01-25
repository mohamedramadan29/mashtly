<?php

$stmt = $connect->prepare("SELECT * FROM orders");
$stmt->execute();
$allorders = $stmt->fetchAll();

foreach ($allorders as $order) {
    $order_date = strtotime($order['order_date']);
    echo $order_date;
    $today = time();
    // حساب الفرق بين التاريخين بالثواني
    $difference = $today - $order_date;
    // حساب عدد الساعات المتبقية حتى الموعد
   // echo $hours_remaining;

    $order_status = $order['status_value'];
    if ($order_status == 'لم يبدا ' &&  $difference > (12 * 60 * 60)) {

        $stmt = $connect->prepare("SELECT * FROM order_notification WHERE order_id=?");
        $stmt->execute(array($order['id']));
        $count = $stmt->rowCount();
        if ($count > 0) {
        } else {
            $stmt = $connect->prepare("INSERT INTO order_notification (order_id,order_number,noti_name,noti_desc,noti_date)
            VALUES(:zorder_id,:zorder_number,:znoti_name,:znoti_desc,:znoti_date)
            ");
            $stmt->execute(array(
                "zorder_id" => $order['id'],
                "zorder_number" => $order['order_number'],
                "znoti_name" => 'لم يبدا',
                "znoti_desc" => 'تأخير في بدء الطلب ',
                "znoti_date" =>  date('d/m/Y h:i a')
            ));
        }

    }
}
