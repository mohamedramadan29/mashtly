<?php
require 'vendor/autoload.php';

use Google\Client;
use Google\Service\AnalyticsData;

// إعداد بيانات الاعتماد
$client = new Client();
$client->setAuthConfig('/home/mshtly/public_html/admin/credentials.json');
$client->addScope('https://www.googleapis.com/auth/analytics.readonly');

// إعداد خدمة Analytics Data
$analytics = new AnalyticsData($client);

// إنشاء الطلب
$request = new Google_Service_AnalyticsData_RunReportRequest([
    'dateRanges' => [
        [
            'startDate' => '30daysAgo',
            'endDate' => 'today'
        ]
    ],
    'dimensions' => [
        ['name' => 'sourceMedium']
    ],
    'metrics' => [
        ['name' => 'sessions']
    ]
]);

$response = $analytics->properties->runReport('properties/321013352', $request);

// عرض النتائج
foreach ($response->getRows() as $row) {
    $dimensions = $row->getDimensionValues();
    $metrics = $row->getMetricValues();

    echo 'Source/Medium: ' . $dimensions[0]->getValue() . "\n";
    echo 'Sessions: ' . $metrics[0]->getValue() . "\n";
}

