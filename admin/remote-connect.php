<?php
ob_start();

$dsn = 'mysql:host=https://196.155.205.240;dbname=mshtly_mashtly';
$username = 'mshtly_mashtly';
$password = 'mshtly_mashtly';
$options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
];

try {
    $connect = new PDO($dsn, $username, $password, $options);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '✅ الاتصال بقاعدة البيانات ناجح!';
} catch (PDOException $e) {
    echo '❌ فشل الاتصال بقاعدة البيانات: ' . $e->getMessage();
}

ob_end_flush();
?>
