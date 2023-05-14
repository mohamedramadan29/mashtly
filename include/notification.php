<?php

$stmt = $connect->prepare("SELECT * FROM orders");
$stmt->execute();
$allorders = $stmt->fetchAll();

foreach ($allorders as $order) {
    $order_date = $order['order_date'];
    $date_format = 'd/m/Y h:i a';
    $date_object = DateTime::createFromFormat($date_format, $order_date);
    if ($date_object !== false) {
        $date_object->add(new DateInterval('PT12H'));
        $new_date_time = $date_object->format($date_format);
    } else {
        echo "Failed to create DateTime object from '$order_date' with format '$date_format'";
    }
    $order_status = $order['status_value'];
    if ($order_status == 'لم يبدا ' && $new_date_time) {
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
                "znoti_date" => strtotime(date('d/m/Y h:i a'))
            ));
        }
    }
}
