<?php
ob_start();
session_start();
include "init.php";
require 'admin/vendor/autoload.php';

use Google\Client;
use Google\Service\Oauth2;
use Google\Service\Sheets;

// إعداد عميل Google
$client = new Client();
$client->setClientId('97629819536-q1o4om4q3onf2iskp0iglo65o6ici4bv.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://www.mshtly.com/googlecallback.php');

// وظيفة لإضافة بيانات إلى Google Sheet
function addClientToGoogleSheet($clientData)
{
    $client = new Client();
    $client->setAuthConfig('refreshing-glow-438708-b2-b759bbeb40eb.json');
    $client->addScope(Sheets::SPREADSHEETS);
    $service = new Sheets($client);

    $spreadsheetId = '1Z8M4FIcK4RbY_9ctBu-DxlX2-0x2qJpnoaLFADgwjPw';
    $range = 'Sheet1!A1';
    $values = [$clientData];
    $body = new Sheets\ValueRange(['values' => $values]);
    $params = ['valueInputOption' => 'RAW'];

    return $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
}

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    $oauth2 = new Oauth2($client);
    $userInfo = $oauth2->userinfo->get();

    $email = $userInfo->email;
    $name = $userInfo->name;

    $stmt = $connect->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // المستخدم موجود
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['user_id'] = $user['id'];

        $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ?");
        $stmt->execute([$cookie_id]);
        $count_pro_in_cart = $stmt->rowCount();

        if ($count_pro_in_cart > 0) {
            $stmt = $connect->prepare("UPDATE cart SET user_id = ? WHERE cookie_id = ?");
            $stmt->execute([$_SESSION['user_id'], $cookie_id]);
            header("Location: cart");
            exit;
        } else {
            header("Location: https://www.mshtly.com/profile");
            exit;
        }
    } else {
        // المستخدم غير موجود
        $active_status_code = rand(1, 55555);

        try {
            $stmt = $connect->prepare("INSERT INTO users(user_name, email, password, active_status, active_status_code, created_at) VALUES 
                (:zuser_name, :zemail, :zpassword, :zactive_status, :zactive_status_code, :zcreated_at)");
            $stmt->execute([
                "zuser_name" => $name,
                "zemail" => $email,
                "zpassword" => '',
                'zactive_status' => 1,
                "zactive_status_code" => $active_status_code,
                'zcreated_at' => date("n/j/Y g:i A"),
            ]);

            $stmt = $connect->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $newUser = $stmt->fetch();

            addClientToGoogleSheet([
                $newUser['id'],
                $name,
                $email,
                1,
                0,
                1,
                date("n/j/Y g:i A"),
            ]);

            $_SESSION['user_name'] = $newUser['user_name'];
            $_SESSION['user_id'] = $newUser['id'];

            $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ?");
            $stmt->execute([$cookie_id]);
            $count_pro_in_cart = $stmt->rowCount();

            if ($count_pro_in_cart > 0) {
                $stmt = $connect->prepare("UPDATE cart SET user_id = ? WHERE cookie_id = ?");
                $stmt->execute([$_SESSION['user_id'], $cookie_id]);
                header("Location: cart");
                exit;
            } else {
                header("Location: https://www.mshtly.com/profile");
                exit;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
} else {
    header("Location: https://www.mshtly.com/login");
    exit;
}
