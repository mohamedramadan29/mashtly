<?php
require_once 'vendor/autoload.php';
$transport = (new Swift_SmtpTransport('smtp.entiqa.co', 587))
    ->setUsername('support@entiqa.co')
    ->setPassword('mohamedramadan2930');
$mailer = new Swift_Mailer($transport);
$body_message = '
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> فاتوره الطلب </title>
 
</head>

<body style="text-align:right;" dir="rtl">
    <div class="profile_page" style="background-color:#F0F5F0;">
        <div class="container">
            <div class="data">
                <div class="print_order" style="background-color: #fff;padding: 50px;border-radius: 30px;max-width: 75%;margin: auto;margin-top: 80px; margin-bottom:80px;">
                    <div class="print printable-content" id="print">
                        <div class="print_head">
                            <div class="logo" style="text-align: center;
                            padding: 20px;">
                                <img src="https://kuwait-developer.com/send_mail/logo.png" alt="">
                            </div>
                            <div class="person_data">
                                <h2 style=" color: #1B1B1B; font-size: 25px; font-weight: bold; margin-bottom: 16px;">
                                    ' . $name . '
                                </h2>
                                <p style="color: #585858;  font-size: 17px;  line-height: 1.8;"> شكرا لطلبك، من مشتلي تم تأكيد طلبك وسوف يصلك في الوقت المحدد لإلغاء الطلب أو تعديله
                                    يرجي زيارة الموقع قسم <span style="color: #5c8e00;"> مشترياتي </span>
                                </p>
                                <p style="color: #585858;  font-size: 17px;  line-height: 1.8;"> يوجد أدناه فاتورة برقم الطلب وتفاصيله </p>
                            </div>
                            <div class="ul_div" style="border-bottom: 1px solid #cbcaca; padding-bottom: 40px; display:flex; text-align:right">
                            <ul class="list-unstyled" style="margin-top: 50px; list-style: none; text-align:right;">
                            <li style="display: flex; justify-content: flex-start; margin-top: 10px !important; margin-bottom: 15px !important; color: #1B1B1B;"> <span style="color: #585858;margin-left: 25px !important;font-size: 18px;">  رقم الطلب : </span> </li>
                            <li style="display: flex; justify-content: flex-start; margin-top: 10px !important; margin-bottom: 15px !important; color: #1B1B1B;"> <span style="color: #585858;margin-left: 25px !important;font-size: 18px;">  تاريخ الطلب : </span> </li>
                            <li style="display: flex; justify-content: flex-start; margin-top: 10px !important; margin-bottom: 15px !important; color: #1B1B1B;"> <span style="color: #585858;margin-left: 25px !important;font-size: 18px;">  الاسم  : </span> </li>
                            <li style="display: flex; justify-content: flex-start; margin-top: 10px !important; margin-bottom: 15px !important; color: #1B1B1B;"> <span style="color: #585858;margin-left: 25px !important;font-size: 18px;">  البريد الألكتروني :  </span> </li>
                            <li style="display: flex; justify-content: flex-start; margin-top: 10px !important; margin-bottom: 15px !important; color: #1B1B1B;"> <span style="color: #585858;margin-left: 25px !important;font-size: 18px;">  رقم الجوال :  </span> </li>
                        </ul>
                                <ul class="list-unstyled" style="margin-top: 50px; list-style: none; text-align:right;">
                                    <li style="font-size: 18px; display: flex; justify-content: flex-start; margin-top: 10px !important; margin-bottom: 15px !important; color: #1B1B1B; text-align:right;"> #
                                        ' . $order_number . '
                                    </li>
                                    <li style="font-size: 18px; display: flex; justify-content: flex-start; margin-top: 10px !important; margin-bottom: 15px !important; color: #1B1B1B;">
                                    ' . $order_date . '
                                    </li>
                                    <li style="font-size: 18px; display: flex; justify-content: flex-start; margin-top: 10px !important; margin-bottom: 15px !important; color: #1B1B1B;">
                                        ' . $name . '
                                    </li>
                                    <li style="font-size: 18px; display: flex; justify-content: flex-start; margin-top: 10px !important; margin-bottom: 15px !important; color: #1B1B1B;">
                                       ' . $email . '
                                    </li>
                                    <li style="font-size: 18px; display: flex; justify-content: flex-start; margin-top: 10px !important; margin-bottom: 15px !important; color: #1B1B1B;">
                                        ' . $phone . '
                                    </li>
                                </ul>

                             
                            </div>
                        </div>
                        <div class="order_details" style="padding-top: 20px;">
                            <h4 style="color: #1B1B1B; font-size: 20px;"> تفاصيل الطلب </h4>
                            <div class="order" style="display: flex;justify-content: space-between; padding-bottom: 20px; padding-top: 20px; align-items: center;border-bottom: 1px dashed #ccc;">
                                <div>
                                    <h6 style="color: #585858; font-size: 18px; margin-top: 20px;margin-bottom: 20px;width: 300px "> المنتج </h6>
                                </div>
                                <div style="display: flex;justify-content: space-between;">
                                    <div>
                                        <h6 style="color: #585858; font-size: 18px; margin-top: 20px;margin-bottom: 20px;width: 150px "> الكمية </h6>
                                    </div>
                                    <div>
                                        <h6 style="color: #585858; font-size: 18px; margin-top: 20px;margin-bottom: 20px;width: 150px "> إجمالي السعر </h6>
                                    </div>
                                </div>
                            </div> 
                            <?php foreach ($allitems as $item):
                            <div class="order" style="display: flex;justify-content: space-between; padding-bottom: 20px; padding-top: 20px; align-items: center;border-bottom: 1px dashed #ccc;">
                                <div>
                                    <h6 style="color: #585858; font-size: 18px; margin-top: 20px;margin-bottom: 20px;width: 300px">  ' .  $item['product_name']  . '</h6>
                                </div>
                                <div style="display: flex;justify-content: space-between;">
                                    <div>
                                        <h6 style="color: #585858; font-size: 18px; margin-top: 20px;margin-bottom: 20px;width: 150px"> ' . $item['quantity'] . '</h6>
                                    </div>
                                    <div>
                                        <h6 style="color: #585858; font-size: 18px; margin-top: 20px;margin-bottom: 20px;width: 150px"> ' . $item['price'] . '</h6>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            
                        </div>
                        <div class="order_totals">
                            <div class="price_sections" style="background-color: #E5F1E5; padding: 5px; border-radius: 10px; margin-top: 30px;">
                                <div class="first" style="display: flex; justify-content: space-between; align-items: center; padding: 10px;">
                                    <div>
                                        <h3 style="font-weight: bold;  font-size: 18px; color:#5c8e00;width:250px;"> تكلفة الإضافات: </h3>
                                        <p style="color: #A0B2B1;font-size: 15px; width:250px"> تكلفة الزراعة + تكلفة التغليف كهدية </p>
                                    </div>
                                    <div>
                                        <h2 class="total" style="color:#21522b">
                                            ' . $farm_service . ' ر.س
                                        </h2>
                                    </div>
                                </div>
                                <div class="first" style="display: flex; justify-content: space-between; align-items: center; padding: 10px;">
                                    <div>
                                        <h3 style="font-weight: bold;  font-size: 18px; color:#5c8e00;width:250px;"> الشحن والتسليم: </h3>
                                        <p style="color: #A0B2B1;font-size: 15px;width:250px"> يحدد سعر الشحن حسب الموقع </p>
                                    </div>
                                    <div>
                                        <h2 class="total" style="color:#21522b"> ' . $ship_price . ' ر.س
                                        </h2>
                                    </div>
                                </div>
                                <hr>
                                <div class="first" style="display: flex; justify-content: space-between; align-items: center; padding: 10px;">
                                    <div>
                                        <h3 style="font-weight: bold;  font-size: 18px; color:#5c8e00;width:250px"> إجمالي المبلغ: </h3>
                                        <p style="color: #A0B2B1;font-size: 14px;width:250px"> المبلغ المطلوب دفعه </p>
                                    </div>
                                    <div>
                                        <h2 class="total"  style="color:#21522b">
                                            ' . $grand_total . ' ر.س
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <p class="thanks" style="margin-top: 25px;color: #1b1b1b; font-size:18px;"> شكرا لتسوقكم من <a href="https://www.mshtly.com/" style="text-decoration: none; color:#5c8e00;"> مشتلي </a> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
';
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
