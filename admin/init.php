<?php
/*
Created by mohamed ramadan
Email:mr319242@gmail.com
Phone:01011642731

*/
include "connect.php";
//include "config.php";
$tem = "include/";
$css = "themes/css/";
$js = "themes/js/";
$fonts = "themes/fonts/";
include $tem . "header.php";
use Google\Client;
use Google\Service\Sheets;
date_default_timezone_set('Asia/Riyadh');
// global functions 
function createSlug($name)
{
    $slug = strtolower($name);
    $slug = preg_replace('/[^a-z0-9\x{0621}-\x{064A}]+/iu', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

// Function to sanitize input
function sanitizeInput($input)
{
    // Use appropriate sanitization or validation techniques based on your requirements
    $sanitizedInput = htmlspecialchars(trim($input));
    return $sanitizedInput;
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
        $statusColumn = 'K';
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