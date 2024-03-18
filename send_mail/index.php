<?php
session_start();
include "../admin/connect.php";
// get all products from the user's cart
$user_id = $_SESSION['user_id'];
$stmt = $connect->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->execute(array($user_id));
$count = $stmt->rowCount();
$allitemscart = $stmt->fetchAll();
require_once 'vendor/autoload.php';
$transport = (new Swift_SmtpTransport('smtp.entiqa.co', 587))
    ->setUsername('support@entiqa.co')
    ->setPassword('mohamedramadan2930');
$mailer = new Swift_Mailer($transport);
$body_message = "
<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>فاتورة الطلب</title>
</head>

<body style='text-align:right;' dir='rtl'>
    <div class='profile_page' style='background-color:#F0F5F0;'>
        <div class='container'>
            <div class='data'>
                <div class='print_order' style='background-color: #fff;padding: 50px;border-radius: 30px;max-width: 75%;margin: auto;margin-top: 80px; margin-bottom:80px;'>
                    <div class='print printable-content' id='print'>
                        <div class='print_head'>
                            <div class='logo' style='text-align: center;padding: 20px;'>
                                <img src='https://www.mshtly.com/logo.png' alt=''>
                            </div>
                            <div class='person_data'>
                                <h2 style='color: #1B1B1B; font-size: 25px; font-weight: bold; margin-bottom: 16px;'>$name</h2>
                                <p style='color: #585858; font-size: 17px; line-height: 1.8;font-family: cairo;'>شكرا لطلبك، من مشتلي تم تأكيد طلبك وسوف يصلك في الوقت المحدد لإلغاء الطلب أو تعديله يرجي زيارة الموقع قسم <span style='color: #5c8e00;'>مشترياتي</span></p>
                                <p style='color: #585858; font-size: 17px; line-height: 1.8;font-family: cairo;'>يوجد أدناه فاتورة برقم الطلب وتفاصيله</p>
                            </div>
                            <p style='color: #585858; font-size: 17px; line-height: 1.8;font-family: cairo;'>مدة الشحن المتوقعة 2-7 ايام</p>
                            <table cellpadding='0' cellspacing='0' border='1' style='border-collapse: collapse; border: 1px solid #a2a2a2;width:100%'>
                                <tr>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'><span>رقم الطلب:</span></th>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'>#$order_number</th>
                                </tr>
                                <tr>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'><span>تاريخ الطلب:</span></th>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'>$order_date</th>
                                </tr>
                                <tr>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'><span>الاسم:</span></th>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'>$name</th>
                                </tr>
                                <tr>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'><span>البريد الألكتروني:</span></th>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'>$email</th>
                                </tr>
                                <tr>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'><span>رقم الجوال:</span></th>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'>$phone</th>
                                </tr>
                                <tr>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'><span>وسية الدفع:</span></th>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'>$payment_method</th>
                                </tr>
                                <tr>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'><span>العنوان:</span></th>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'>$address</th>
                                </tr>
                                <tr>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'><span>ملاحظات اضافية:</span></th>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'>$order_details</th>
                                </tr>
                            </table>
                        </div>
                        <div class='order_details' style='padding-top: 20px;'>
                            <h4 style='color: #1B1B1B; font-size: 20px;'>تفاصيل الطلب</h4>
                            <br>
                            <table cellpadding='0' cellspacing='0' border='1' style='border-collapse: collapse; border: 1px solid #a2a2a2;width:100%'>
                                <tr>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'>المنتج</th>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'>تفاصيل اضافية</th>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'>الكمية</th>
                                    <th style='padding: 7px;font-size: 17px;font-family: cairo;'>إجمالي السعر</th>
                                </tr> ";
foreach ($allitemscart as $item) {
    $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE id = ?");
    $stmt->execute(array($item['vartion_name']));
    $more_details_data = $stmt->fetch();
    $more_detail_name = $more_details_data['vartions_name'];
    if ($item['farm_service'] == null) {
        $farm_service2 = 'لا';
    } else {
        $farm_service2 = 'نعم';
    }
    $body_message .= "
                                        <tr>
                                            <td style='padding: 7px;font-size: 17px;font-family: cairo;'>{$item['product_name']}</td>
                                            <td style='padding: 7px;font-size: 17px;font-family: cairo;'>{$more_detail_name} || امكانية الزراعة :: {$farm_service2}</td>
                                            <td style='padding: 7px;font-size: 17px;font-family: cairo;'>{$item['quantity']}</td>
                                            <td style='padding: 7px;font-size: 17px;font-family: cairo;'>{$item['price']} ريال </td>
                                        </tr>";
}
$body_message .= "
                            </table>   
                        </div>
                        <div class='order_totals'>
                            <div class='price_sections' style='background-color: #E5F1E5; padding: 5px; border-radius: 10px; margin-top: 30px;'>
                                <div class='first' style='display: flex; justify-content: space-between; align-items: center; padding: 10px;'>
                                    <div>
                                        <h3 style='font-weight: bold;font-family: cairo; font-size: 18px; color:#5c8e00;width:250px;'>تكلفة الإضافات:</h3>
                                        <p style='color: #A0B2B1;font-size: 15px;font-family: cairo; width:250px'>تكلفة الزراعة  </p>
                                    </div>
                                    <div>
                                        <h2 class='total' style='color:#21522b;font-family: cairo;'> $farm_service ريال </h2>
                                    </div>
                                </div>
                                <div class='first' style='display: flex; justify-content: space-between; align-items: center; padding: 10px;'>
                                    <div>
                                        <h3 style='font-weight: bold; font-size: 18px; color:#5c8e00;width:250px;font-family: cairo;'>الشحن والتسليم:</h3>
                                        <p style='color: #A0B2B1;font-size: 15px;width:250px;font-family: cairo;'>يحدد سعر الشحن حسب الموقع</p>
                                    </div>
                                    <div>
                                        <h2 class='total' style='color:#21522b;font-family: cairo;'>$ship_price ريال </h2>
                                    </div>
                                </div>
                                <hr>
                                <div class='first' style='display: flex; justify-content: space-between; align-items: center; padding: 10px;'>
                                    <div>
                                        <h3 style='font-weight: bold; font-size: 18px; color:#5c8e00;width:250px;font-family: cairo;'>إجمالي المبلغ:</h3>
                                        <p style='color: #A0B2B1;font-size: 14px;width:250px;font-family: cairo;'>المبلغ المطلوب دفعه</p>
                                    </div>
                                    <div>
                                        <h2 class='total' style='color:#21522b;font-family: cairo;'>$grand_total ريال </h2>
                                    </div>
                                </div>
                            </div>
                            <p class='thanks' style='margin-top: 25px;color: #1b1b1b; font-size:18px;font-family: cairo;'>شكرا لتسوقكم من <a href='https://www.mshtly.com/' style='text-decoration: none; color:#5c8e00;'>مشتلي</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>";
$title = 'طلب شراء';

// Create a message
$message = (new Swift_Message('New Order'))
    ->setFrom(['support@entiqa.co' => 'Mshtly'])
    ->setTo($email)
    ->setBody($body_message, 'text/html');
$result = $mailer->send($message);
// if ($result) {
//     echo "Message sent successfully!";
// } else {
//     echo "Failed to send message.";
// }
