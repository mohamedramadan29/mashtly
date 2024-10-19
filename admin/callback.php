<?php
session_start();
require 'config.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // إرسال طلب للحصول على access_token
    $token_url = 'https://oauth2.googleapis.com/token';
    $data = [
        'code' => $code,
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'redirect_uri' => REDIRECT_URI,
        'grant_type' => 'authorization_code',
    ];

    $ch = curl_init($token_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $response = curl_exec($ch);
    curl_close($ch);

    $token_data = json_decode($response, true);
    $_SESSION['access_token'] = $token_data['access_token']; // تخزين access_token في الجلسة

    // إعادة توجيه المستخدم إلى صفحة الإحصائيات
    header('Location: main?dir=reports&page=state'); 
   // header('Location:main?dir=area_city&page=report');
    exit;
}
