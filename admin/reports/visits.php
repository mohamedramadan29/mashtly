<?php
session_start();
require 'config.php';

// إذا لم يكن هناك رمز، توجه إلى صفحة تسجيل الدخول
if (!isset($_GET['code'])) {
    $auth_url = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query([
        'response_type' => 'code',
        'client_id' => CLIENT_ID,
        'redirect_uri' => REDIRECT_URI,
        'scope' => 'https://www.googleapis.com/auth/webmasters.readonly',
        'access_type' => 'offline', // للحصول على رمز التحديث
    ]);

    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit;
}
