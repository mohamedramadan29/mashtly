<?php
// تفعيل عرض الأخطاء للتصحيح
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// تحميل مكتبة Google API Client
require_once 'vendor/autoload.php';

function addOrderToGoogleSheet($orderData) {
    try {
        $client = new Google_Client(); // تصحيح: استخدام Google_Client
        $client->setAuthConfig('refreshing-glow-438708-b2-0caa04234fff.json');
        $client->addScope(Google_Service_Sheets::SPREADSHEETS);
        $service = new Google_Service_Sheets($client);

        $spreadsheetId = '1Maxt487hN-r0SpUReaRZQ7CONfpaVsEPFdq2PyqplwQ';
        $range = 'orders_old!A1';

        $values = [$orderData];
        $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
        $params = ['valueInputOption' => 'RAW'];

        $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
        error_log("Order added successfully to Google Sheet: " . json_encode($result));
        return true; // إرجاع true في حالة النجاح
    } catch (Exception $e) {
        error_log("Failed to add order to Google Sheet: " . $e->getMessage());
        return false; // إرجاع false في حالة الفشل
    }
}

// إعداد الاستجابة
$response = ['success' => false, 'message' => ''];

// التحقق من وجود order_id
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;
if (!$order_id) {
    $response['message'] = 'Order ID is missing.';
    echo json_encode($response);
    exit;
}

// جلب بيانات الطلب من قاعدة البيانات
  $stmt = $connect->prepare("SELECT * FROM outside_orders WHERE id = ?");
  $stmt->execute(array($order_id));
  $order = $stmt->fetch();

  $order_status = $order['status_value'];
  if($order_status == 'pending'){
    $status_value = 'دفع الكتروني لم يكتمل';
  }else{
    $status_value = $order_status;
  }

if (!$order) {
    $response['message'] = 'Order not found.';
    echo json_encode($response);
    exit;
}

// إعداد بيانات الطلب
$order_date = date('Y-m-d H:i:s', strtotime($order['order_date']));
$google_order_date = (strtotime($order_date) / 86400) + 25569;

$OrderData = array_map(function ($value) {
    return $value ?? '';
}, [
    $order['id'],
    (float) $order['order_number'],
    $order['user_id'] ?? '',
    $order['name'],
    $order['email'],
    $order['phone'],
    $order['area'],
    $order['city'],
    (float) $order['ship_price'],
    $google_order_date,
    $status_value,
    $order['farm_service'] ?? 0,
    (float) $order['total_price'],
    $order['payment_method'],
    (float) 1,
    $order['discount_value'] ?? 'NULL',
    'طلب خارجي',
]);

// استدعاء دالة إضافة الطلب
if (addOrderToGoogleSheet($OrderData)) {
    $stmt = $connect->prepare("UPDATE outside_orders SET add_to_sheet = '1' WHERE id = ?");
    $stmt->execute(array($order_id));
    $_SESSION['success_message'] = " تم إضافة الطلب بنجاح  ";
    $redirect_page = 'main?dir=outside_orders&page=report'; 
   
 header('Location:'.$redirect_page);
} else {
    $_SESSION['error_message'] = 'فشل إضافة الطلب إلى Google Sheet.';
} 
?>