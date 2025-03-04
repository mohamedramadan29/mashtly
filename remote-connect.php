<?php
ob_start();

$dsn = 'mysql:host=209.182.205.141;dbname=mshtly_mashtly;port=3306';
$username = 'mshtly_mashtly';
$password = 'mshtly_mashtly';
$options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];
try {
    $connect = new PDO($dsn, $username, $password, $options);
    echo '✅ الاتصال بقاعدة البيانات ناجح!';
} catch (PDOException $e) {
    echo '❌ فشل الاتصال بقاعدة البيانات: ' . $e->getMessage();
}
$stmt = $connect->prepare("SELECT * FROM orders LIMIT 4");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();
foreach( $result as $row ) {
    echo "". $row["total_price"];
}
ob_end_flush();
?>