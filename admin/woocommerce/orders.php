<?php

ob_start();

// تشغيل عرض الأخطاء
error_reporting(E_ALL); // عرض جميع الأخطاء
ini_set('display_errors', 1); // عرض الأخطاء على الشاشة

$dsn = 'mysql:host=localhost;dbname=old_wordpressdb';
$username = 'root';
$password = '';
$option = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];

try {
    $connect = new PDO($dsn, $username, $password, $option);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connected to database successfully.<br>';
} catch (PDOException $e) {
    echo 'Failed to connect: ' . $e->getMessage();
}

ob_end_flush();

require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

$woocommerce = new Client(
    'https://allfutureai.com/mshtly_mo/',
    'ck_b3d2345565fcb561254a0e66265128226895b69e',
    'cs_68d801b926796748c062bdaade33121b91779449',
    [
        'wp_api' => true,
        'version' => 'wc/v3',
        'query_string_auth' => true // Force Basic Authentication as query string true and using under HTTPS
    ]
);

// إعدادات الطلب
$per_page = 100;  // عدد الطلبات في كل طلب
$page = 85;       // بدء من الصفحة المطلوبة

do {
    // استرجاع بيانات الطلبات من الصفحة الحالية
    $orders = $woocommerce->get('orders', ['per_page' => $per_page, 'page' => $page]);
    // $orders = $woocommerce->get('orders', ['per_page' => 10,]);


    if (!empty($orders) && is_array($orders)) {
        foreach ($orders as $order) {
            // جلب بيانات الطلب
            $order_id = $order->id; // معرف الطلب
            $order_number = $order->number; // رقم الطلب
            $customer_id = $order->customer_id; // معرف العميل
            $name = $order->billing->first_name . '' . $order->billing->last_name; // الاسم الأول للعميل من بيانات الفوترة
            $email = $order->billing->email; // البريد الإلكتروني للعميل من بيانات الفوترة
            $phone = $order->billing->phone; // رقم الهاتف من بيانات الفوترة
            $area = $order->shipping->state; // المنطقة من بيانات الشحن
            $city = $order->shipping->city; // المدينة من بيانات الشحن
            $address = $order->shipping->address_1 . ' ' . $order->shipping->address_2; // العنوان الكامل من بيانات الشحن
            $ship_price = $order->shipping_total; // تكلفة الشحن

            $status_value = $order->status; // حالة الطلب
            $total_price = $order->total; // إجمالي السعر
            $payment_method = $order->payment_method; // طريقة الدفع
            // تحديد نوع الدفع بناءً على طريقة الدفع
            if ($payment_method == 'cod') {
                $payment_type = 'دفع عند الاستلام';
            } elseif ($payment_method == 'tap') {
                $payment_type = 'دفع إلكتروني';
            } else {
                $payment_type = 'طريقة دفع غير معروفة'; // يمكنك تحديد قيمة افتراضية هنا
            }
            // للحصول على الكوبون والخصم، يجب التأكد من أن الحقول موجودة
            $coupon_code = isset($order->coupon_lines[0]) ? $order->coupon_lines[0]->code : null; // كود الكوبون (إذا كان موجودًا)
            $discount_value = isset($order->discount_total) ? $order->discount_total : 0; // قيمة الخصم (إذا كان موجودًا)

            $created_at = $order->date_created; // تاريخ إنشاء الطلب
            // تحويل صيغة التاريخ لتكون: 3/6/2024 12:25 AM
            $date = new DateTime($created_at);
            $formatted_date = $date->format('j/n/Y g:i A');

            // تحقق مما إذا كان الطلب موجودًا مسبقًا
            $stmt_check = $connect->prepare("SELECT COUNT(*) FROM orders WHERE id = :zid");
            $stmt_check->execute(['zid' => $order_id]);
            $order_exists = $stmt_check->fetchColumn();

            if ($order_exists) {
                echo "Order with ID: $order_id already exists. Skipping...<br>";
                continue; // تخطي هذا الطلب والانتقال إلى الطلب التالي
            }

            // إدخال البيانات في قاعدة البيانات إذا لم يكن الطلب موجودًا
            try {
                $stmt = $connect->prepare("INSERT INTO orders (id,order_number, user_id,name,
                email,phone,area,city,address,ship_price,order_date,
                status_value,total_price,payment_method,coupon_code,discount_value)
                    VALUES(:zid,:zorder_number, :zuser_id,:zname,
                :zemail,:zphone,:zarea,:zcity,:zaddress,:zship_price,:zorder_date,
                :zstatus_value,:ztotal_price,:zpayment_method,:zcoupon_code,:zdiscount_value)");

                $stmt->execute(array(
                    'zid' => $order_id,
                    'zorder_number' => $order_number,
                    'zuser_id' => $customer_id,
                    'zname' => $name,
                    'zemail' => $email,
                    'zphone' => $phone,
                    'zarea' => $area,
                    'zcity' => $city,
                    'zaddress' => $address,
                    'zship_price' => $ship_price,
                    'zorder_date' => $formatted_date,
                    // 'zstatus' => $formatted_date,
                    'zstatus_value' => $status_value,
                    'ztotal_price' => $total_price,
                    'zpayment_method' => $payment_type,
                    'zcoupon_code' => $coupon_code,
                    'zdiscount_value' => $discount_value,
                ));

                echo "Order with ID: $order_id inserted successfully.<br>";
            } catch (PDOException $e) {
                echo "Error inserting order with ID: $order_id - " . $e->getMessage() . "<br>";
            }
        }

        // تحديث الصفحة للحصول على الطلبات التالية
        $page++;
        echo "Moving to next page: $page<br>";
    } else {
        echo "No more orders found.<br>";
        break; // الخروج من الحلقة إذا لم يكن هناك طلبات
    }
} while (count($orders) == $per_page); // استمر حتى تنتهي الصفحات

echo "Finished processing orders.<br>";
