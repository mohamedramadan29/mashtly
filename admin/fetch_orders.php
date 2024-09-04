<?php
// fetch_orders.php

header('Content-Type: application/json');

// تأكد من تضمين ملف الاتصال بقاعدة البيانات
include 'connect.php'; // تأكد من أن مسار الملف صحيح

// التحقق من استقبال المعطيات بشكل صحيح
if (!isset($_GET['period'])) {
    echo json_encode(['error' => 'لم يتم تحديد الفترة الزمنية']);
    exit;
}

$period = $_GET['period'];
$labels = [];
$data = [];

try {
    if ($period === 'current_year') {
        $stmt = $connect->prepare("SELECT MONTH(STR_TO_DATE(order_date, '%c/%e/%Y %r')) AS period, COUNT(*) AS count 
                                   FROM orders 
                                   WHERE YEAR(STR_TO_DATE(order_date, '%c/%e/%Y %r')) = YEAR(CURDATE()) 
                                   GROUP BY MONTH(STR_TO_DATE(order_date, '%c/%e/%Y %r'))");
    } elseif ($period === 'previous_month') {
        $stmt = $connect->prepare("SELECT DAY(STR_TO_DATE(order_date, '%c/%e/%Y %r')) AS period, COUNT(*) AS count 
                                   FROM orders 
                                   WHERE MONTH(STR_TO_DATE(order_date, '%c/%e/%Y %r')) = MONTH(CURDATE()) - 1 
                                   AND YEAR(STR_TO_DATE(order_date, '%c/%e/%Y %r')) = YEAR(CURDATE()) 
                                   GROUP BY DAY(STR_TO_DATE(order_date, '%c/%e/%Y %r'))");
    } elseif ($period === 'current_month') {
        $stmt = $connect->prepare("SELECT DAY(STR_TO_DATE(order_date, '%c/%e/%Y %r')) AS period, COUNT(*) AS count 
                                   FROM orders 
                                   WHERE MONTH(STR_TO_DATE(order_date, '%c/%e/%Y %r')) = MONTH(CURDATE()) 
                                   AND YEAR(STR_TO_DATE(order_date, '%c/%e/%Y %r')) = YEAR(CURDATE()) 
                                   GROUP BY DAY(STR_TO_DATE(order_date, '%c/%e/%Y %r'))");
    } elseif ($period === 'last_7_days') {
        $stmt = $connect->prepare("SELECT DATE(STR_TO_DATE(order_date, '%c/%e/%Y %r')) AS period, COUNT(*) AS count 
                                   FROM orders 
                                   WHERE STR_TO_DATE(order_date, '%c/%e/%Y %r') >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
                                   GROUP BY DATE(STR_TO_DATE(order_date, '%c/%e/%Y %r'))");
    } elseif ($period === 'custom') {
        if (!isset($_GET['start_date']) || !isset($_GET['end_date'])) {
            echo json_encode(['error' => 'لم يتم تحديد تواريخ الفترة المخصصة']);
            exit;
        }
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        // تحقق من صحة التواريخ
        if (empty($start_date) || empty($end_date)) {
            echo json_encode(['error' => 'تواريخ غير صالحة']);
            exit;
        }
        $stmt = $connect->prepare("SELECT DATE(STR_TO_DATE(order_date, '%c/%e/%Y %r')) AS period, COUNT(*) AS count 
                                   FROM orders 
                                   WHERE STR_TO_DATE(order_date, '%c/%e/%Y %r') BETWEEN ? AND ? 
                                   GROUP BY DATE(STR_TO_DATE(order_date, '%c/%e/%Y %r'))");
        $stmt->execute([$start_date, $end_date]);
    } else {
        echo json_encode(['error' => 'فترة زمنية غير معروفة']);
        exit;
    }

    // تنفيذ الاستعلام إذا لم يكن 'custom'
    if ($period !== 'custom') {
        $stmt->execute();
    }

    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($orders as $order) {
        // استخدم 'period' كالتسمية
        $labels[] = $order['period'];
        $data[] = $order['count'];
    }

    echo json_encode(['labels' => $labels, 'data' => $data]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
