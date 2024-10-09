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
$per_page = 100;  // عدد العملاء في كل طلب
$page = 85;       // بدء من الصفحة المطلوبة

do {
    // استرجاع بيانات العملاء من الصفحة الحالية
    $customers = $woocommerce->get('customers', ['per_page' => $per_page, 'page' => $page]);

    if (!empty($customers) && is_array($customers)) {
        foreach ($customers as $customer) {
            // جلب بيانات العميل
            $customer_id = $customer->id;
            $first_name = $customer->billing->first_name;
            $email = $customer->email;
            $phone = $customer->billing->phone;
            $created_at = $customer->date_created;
            $username = $customer->username;

            // تحويل صيغة التاريخ
            $date = new DateTime($created_at);
            $formatted_date = $date->format('n/j/Y g:i A');

            // استرجاع الطلبات الخاصة بالعميل
            $orders = $woocommerce->get('orders', ['customer' => $customer_id]);
            $order_count = count($orders);

            // تحقق مما إذا كان العميل موجودًا مسبقًا
            $stmt_check = $connect->prepare("SELECT COUNT(*) FROM users WHERE id = :zid");
            $stmt_check->execute(['zid' => $customer_id]);
            $customer_exists = $stmt_check->fetchColumn();

            if ($customer_exists) {
                echo "Customer with ID: $customer_id already exists. Skipping...<br>";
                continue; // تخطي هذا العميل والانتقال إلى العميل التالي
            }

            // إدخال البيانات في قاعدة البيانات إذا لم يكن العميل موجودًا
            try {
                $stmt = $connect->prepare("INSERT INTO users (id, name, user_name, email, phone, created_at, orders_number)
                    VALUES(:zid, :zname, :zusername, :zemail, :zphone, :zcreated, :zorder_number)");

                $stmt->execute(array(
                    'zid' => $customer_id,
                    'zname' => $first_name,
                    'zusername' => $username,
                    'zemail' => $email,
                    'zphone' => $phone,
                    'zcreated' => $formatted_date,
                    'zorder_number' => $order_count,
                ));

                echo "Customer with ID: $customer_id inserted successfully.<br>";
            } catch (PDOException $e) {
                echo "Error inserting customer with ID: $customer_id - " . $e->getMessage() . "<br>";
            }
        }

        // تحديث الصفحة للحصول على العملاء التاليين
        $page++;
        echo "Moving to next page: $page<br>";

    } else {
        echo "No more customers found.<br>";
        break; // الخروج من الحلقة إذا لم يكن هناك عملاء
    }
} while (count($customers) == $per_page); // استمر حتى تنتهي الصفحات

echo "Finished processing customers.<br>";
