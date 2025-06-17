<?php
//include 'location_currancy.php';
$connect_db = 'admin/connect.php';
$tem = "include/";
$css = "http://localhost/mashtly/themes/css/";
$js = "http://localhost/mashtly/themes/js/";
$uploads = "http://localhost/mashtly/uploads/";
include $tem . "header.php";

include 'admin/connect.php';
include 'global_functions.php';
date_default_timezone_set('Asia/Riyadh');
require 'admin/vendor/autoload.php';
use Google\Client;
use Google\Service\Sheets;
// user Cookies
// تحديد تاريخ انتهاء الصلاحية (هنا: 30 يومًا)
$expiry_date = time() + (86400 * 30);

// التحقق من وجود الكوكيز
if (isset($_COOKIE['user_key'])) {
    // إذا كانت الكوكيز محفوظة، استرجاع قيمتها
    $user_key = $_COOKIE['user_key'];
} else {
    $user_key = uniqid() . time();
    setcookie("user_key", $user_key, $expiry_date, "/");
}
// استخدام قيمة الكوكيز
$cookie_id = $user_key;
$_SESSION['cookie_id'] = $cookie_id;

######################### Add Redirect To This Page 


$request_uri = $_SERVER['REQUEST_URI'];
$stmt = $connect->prepare("SELECT new_url, status_code FROM redirects WHERE old_url = ?");
$stmt->execute([$request_uri]);
$redirect = $stmt->fetch();

if ($redirect) {
    header("Location: " . $redirect['new_url'], true, $redirect['status_code']);
    exit;
}



function updateOrderStatusInGoogleSheet($orderId, $newStatus)
{
    try {
        $client = new Client();
        $client->setAuthConfig('refreshing-glow-438708-b2-a68943cf6319.json');
        $client->addScope(Sheets::SPREADSHEETS);
        $service = new Sheets($client);

        $spreadsheetId = '1Maxt487hN-r0SpUReaRZQ7CONfpaVsEPFdq2PyqplwQ';
        $range = 'orders_old!A:J'; // النطاق ليشمل جميع الأعمدة

        // جلب البيانات من Google Sheet
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        if (empty($values)) {
            error_log("Google Sheet is empty or inaccessible for order ID: $orderId");
            return false;
        }

        // البحث عن الطلب بناءً على order_id (في العمود الأول A)
        $rowIndex = -1;
        foreach ($values as $index => $row) {
            error_log("Checking row " . ($index + 1) . ": " . json_encode($row));
            if (isset($row[0]) && trim($row[0]) == $orderId) {
                $rowIndex = $index + 1; // +1 لأن Google Sheets يبدأ من 1 (A1 هو العنوان)
                error_log("Found order ID $orderId at row $rowIndex");
                break;
            }
        }

        if ($rowIndex == -1) {
            error_log("Order ID $orderId not found in Google Sheet");
            return false;
        }

        // الحالة في العمود J (العمود العاشر)
        $statusColumn = 'J';
        $updateRange = "orders_old!{$statusColumn}{$rowIndex}";

        // التحقق من القيمة الحالية قبل التحديث
        $currentValueResponse = $service->spreadsheets_values->get($spreadsheetId, $updateRange);
        $currentValue = $currentValueResponse->getValues() ? $currentValueResponse->getValues()[0][0] : 'N/A';
        error_log("Current status at $updateRange: $currentValue");

        // تحديث الحالة
        $updateValues = [[$newStatus]];
        $body = new Sheets\ValueRange(['values' => $updateValues]);
        $params = ['valueInputOption' => 'RAW'];

        $result = $service->spreadsheets_values->update($spreadsheetId, $updateRange, $body, $params);
        error_log("Update API response: " . json_encode($result));

        // التحقق من القيمة بعد التحديث
        $newValueResponse = $service->spreadsheets_values->get($spreadsheetId, $updateRange);
        $newValue = $newValueResponse->getValues() ? $newValueResponse->getValues()[0][0] : 'N/A';
        error_log("New status at $updateRange after update: $newValue");

        if ($newValue === $newStatus) {
            error_log("Successfully updated status to '$newStatus' for order ID $orderId at $updateRange");
            return true;
        } else {
            error_log("Update failed: Expected '$newStatus', got '$newValue'");
            return false;
        }

    } catch (\Exception $e) {
        error_log('Error updating Google Sheet: ' . $e->getMessage());
        return false;
    }
}

include $tem . "navbar.php";
