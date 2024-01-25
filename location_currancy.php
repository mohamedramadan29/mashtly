<?php
// Show User Country 
$ip = $_SERVER['REMOTE_ADDR'];
$url = "http://ip-api.com/json/{$ip}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

$country = $data['country'];
$countryCode = $data['countryCode'];


if ($country === 'Egypt') {
    $country =  'Egypt';
} elseif ($country === 'Saudi Arabia') {
    $country =  'Saudi Arabia';
} else {
    $country = 'Saudi Arabia';
}
echo $country;

// get the currancy code 

// تعيين العملة بناءً على الدولة 
if ($countryCode === 'EG') {
    $currency = 'EGP'; // العملة المصرية
} elseif ($countryCode === 'SA') {
    $currency = 'SAR'; // العملة السعودية
} else {
    $currency = 'SAR';
}
echo $currency;
