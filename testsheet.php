<?php
require 'admin/vendor/autoload.php';
use Google\Client;
use Google\Service\Sheets;

function addTestDataToGoogleSheet()
{
    try {
        $client = new Client();
        $client->setAuthConfig('refreshing-glow-438708-b2-a68943cf6319.json');
        $client->addScope(Sheets::SPREADSHEETS);

        $service = new Sheets($client);
        $spreadsheetId = '1Maxt487hN-r0SpUReaRZQ7CONfpaVsEPFdq2PyqplwQ';
        $range = 'mshtly orders';
        $values = [
            ['Test Order ID', '12345', 'Test User', 'test@example.com']
        ];

        $body = new Sheets\ValueRange(['values' => $values]);
        $params = ['valueInputOption' => 'RAW'];
        
        $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
        var_dump($result);

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// تشغيل الدالة
addTestDataToGoogleSheet();
?>
