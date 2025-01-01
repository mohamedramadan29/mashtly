<?php
require 'admin/vendor/autoload.php'; // إذا كنت تستخدم Composer
use Google\Client;
use Google\Service\Sheets;
function addOrderToGoogleSheet($orderData)
{
    // تحميل بيانات الاعتماد من ملف JSON
    $client = new Client();
    $client->setAuthConfig('refreshing-glow-438708-b2-b759bbeb40eb.json');
    $client->addScope(Sheets::SPREADSHEETS);
    $service = new Sheets($client);
    // إعدادات الـ Google Sheet
    $spreadsheetId = '1WEngpTklZM1DF6aBMcAZdlAaThBc0VcVf4cUTDHVW7Y'; // ضع هنا الـ ID من رابط Google Sheet
    $range = 'Sheet1!A1'; // الورقة والنطاق
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
    'Order123',          // رقم الطلب
    'mohamed ramadan',          // اسم العميل
    'المنتج الاول ',       // المنتج
    '100 ريال '            // السعر
];

// إضافة البيانات إلى Google Sheet
$result = addOrderToGoogleSheet($orderData);
if ($result) {
    echo "تمت إضافة الطلب إلى Google Sheet بنجاح!";
} else {
    echo "حدث خطأ أثناء إضافة الطلب.";
}
