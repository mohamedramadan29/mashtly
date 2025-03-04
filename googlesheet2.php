<?php
require 'admin/vendor/autoload.php'; // إذا كنت تستخدم Composer
use Google\Client;
use Google\Service\Sheets;
function addOrderToGoogleSheet($orderData)
{
    // تحميل بيانات الاعتماد من ملف JSON
    $client = new Client();
    $client->setAuthConfig('refreshing-glow-438708-b2-a68943cf6319.json');
    $client->addScope(Sheets::SPREADSHEETS);
    $service = new Sheets($client);
    // إعدادات الـ Google Sheet
    $spreadsheetId = '1Maxt487hN-r0SpUReaRZQ7CONfpaVsEPFdq2PyqplwQ'; // ضع هنا الـ ID من رابط Google Sheet
    $range = 'orders_old!A1'; // الورقة والنطاق
    $values = [$orderData]; // بيانات الطلبات
    $body = new Sheets\ValueRange(['values' => $values]);

    // كتابة البيانات في Google Sheet
    $params = ['valueInputOption' => 'RAW'];
    $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);

    return $result;
}

// بيانات الطلب الجديد
$orderData = [
    date('Y-m-d H:i:s'), // تاريخ الطلب
    'Order12355444',          // رقم الطلب
    'mohamed ramadan',          // اسم العميل
    'المنتج الاول ',       // المنتج
    '100 ريال ',           // السعر
    '100 ريال ',           // السعر
    '100 ريال ',           // السعر
    '100 ريال ',           // السعر
    '100 ريال ',           // السعر
    '100 ريال ',           // السعر
    '100 ريال ',           // السعر
    '100 ريال ',           // السعر
    '100 ريال ',           // السعر
    '100 ريال ',           // السعر
    '100 ريال ',           // السعر
    '',           // السعر
];
try {
    $result = addOrderToGoogleSheet($orderData);
    if ($result) {
        echo "تمت إضافة الطلب إلى Google Sheet بنجاح!";
    } else {
        echo "حدث خطأ أثناء إضافة الطلب.";
    }

} catch (Exception $e) {
    echo 'Error:' . $e->getMessage() . '';
}
// إضافة البيانات إلى Google Sheet

