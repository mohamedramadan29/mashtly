<?php
ob_start();
session_start();
include "init.php";
require 'admin/vendor/autoload.php';
use Google\Client;
use Google\Service\Sheets;

function addClientToGoogleSheet($clientData)
{
    // تحميل بيانات الاعتماد من ملف JSON
    $client = new Client();
    $client->setAuthConfig('refreshing-glow-438708-b2-b759bbeb40eb.json');
    $client->addScope(Sheets::SPREADSHEETS);
    $service = new Sheets($client);
    // إعدادات الـ Google Sheet
    $spreadsheetId = '1Z8M4FIcK4RbY_9ctBu-DxlX2-0x2qJpnoaLFADgwjPw'; // ضع هنا الـ ID من رابط Google Sheet
    $range = 'Sheet1!A1'; // الورقة والنطاق
    $values = [$clientData]; // بيانات الطلبات
    $body = new Sheets\ValueRange(['values' => $values]);

    // كتابة البيانات في Google Sheet
    $params = ['valueInputOption' => 'RAW'];
    $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);

    return $result;
}
$stmt = $connect->prepare("SELECT * FROM users ORDER BY id ");
$stmt->execute();
$allusers = $stmt->fetchAll();
foreach($allusers as $user){
    addClientToGoogleSheet([
        $user['id'],
        $user['email'],
        $user['user_name'],
        $user['active_status'],
        $user['emails_subscribe'],
        $user['status'],
        $user['created_at'],
    ]);
}
