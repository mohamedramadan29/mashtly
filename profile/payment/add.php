<?php
ob_start();
session_start();
$page_title = ' اضافة طريقة دفع ';
include 'init.php';
$user_id = $_SESSION['user_id'];
if (isset($_POST['add_new_payment'])) {


    $formerror = [];
    $card_name = sanitizeInput($_POST['card_name']);
    $card_number = sanitizeInput($_POST['card_number']);
    $endDate = sanitizeInput($_POST['end_date']);
    $cvc = sanitizeInput($_POST['cvc']);
    // تنقية (Sanitization)
    $card_number = preg_replace('/[^0-9]/', '', $card_number);
    $endDate = preg_replace('/[^0-9\/]/', '', $endDate);
    $cvc = preg_replace('/[^0-9]/', '', $cvc);

    if (isset($_POST['default_payment'])) {
        $default_payment = 1;
        $stmt = $connect->prepare("UPDATE user_payments SET default_payment = 0");
        $stmt->execute();
    } else {
        $default_payment = 0;
    }

    // التحقق (Validation)
    if (empty($card_name) || empty($card_number) || empty($endDate) || empty($cvc)) {
        $formerror[] = 'الرجاء ملء جميع الحقول المطلوبة.';
    } elseif (strlen($card_number) !== 16) {
        $formerror[] = ' رقم البطاقة يجب ان يكون 16 رقم  ';
    } elseif (strlen($cvc) !== 3) {
        $formerror[] = ' يجب ادخال رمز التحقق من البطاقة المكون من 3 ارقام ';
    }

    // تحويل التاريخ إلى الصيغة المطلوبة (مثلاً: "mm/yy")
    $endDateFormatted = date("m/y", strtotime($endDate));

    // التحقق من التاريخ بالصيغة الصحيحة
    if ($endDate !== $endDateFormatted) {
        $formerror[] = "يرجى إدخال تاريخ انتهاء صحيح بالصيغة (06/23).";
    }
    // مفتاح سري مشترك للتشفير وفك التشفير
    $encryptionKey = "!#@_MOHAMED_!#@_MASHTLY";
    // تشفير رقم البطاقة
    $encryptedCardNumber = openssl_encrypt($card_number, "AES-128-ECB", $encryptionKey);
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO user_payments (user_id , card_name,card_number,end_date,
        cvc,default_payment) VALUES (:zuser_id, :zcard_name,:zcard_number,:zend_date,:zcvc,:zdefault)");
        $stmt->execute(array(
            "zuser_id" => $user_id,
            ":zcard_name" => $card_name,
            "zcard_number" => $encryptedCardNumber,
            "zend_date" => $endDate,
            "zcvc" => $cvc,
            "zdefault" => $default_payment
        ));
        if ($stmt) {
            $_SESSION['success'] = 'تم تسجيل بطاقة جديد بنجاح ';
            header('Location:index');
        }
    } else {
        $_SESSION['error'] = $formerror;
    }
}
?>
<div class="profile_page new_address_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="../index"> الرئيسية </a> \ <a href="../index"> حسابي </a> \ <a href="payments"> طرق الدفع </a>
                    \
                    <span> أضف بطاقة دفع جديدة</span>
                </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> أضف بطاقة دفع جديدة</h2>
                    <p> نستخدم أحدث طرق التشفير لحفط بياناتك </p>
                </div>
            </div>
            <div class="add_new_address add_new_payment">
                <?php
                include "../../success_error_msg.php";
                if (isset($_SESSION['error'])) {
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'])) {
                    unset($_SESSION['success']);
                }
                ?>
                <form action="#" method="post">
                    <div class='row'>

                        <div class='box'>
                            <div class="input_box">
                                <label for="card_number"> أضف رقم البطاقة </label>
                                <input id="card_number" type="text" name="card_number" class='form-control' placeholder=" 0000 0000 0000 0000">
                            </div>
                            <div class="input_box">
                                <label for="card_name"> اسم صاحب البطاقة </label>
                                <input id="card_name" type="text" name="card_name" class='form-control' placeholder="اكتب…">
                            </div>
                        </div>
                        <div class="box">

                            <div class="input_box">
                                <label for="end_date"> تاريخ الانتهاء</label>
                                <input id="end_date" type="text" name="end_date" class='form-control' placeholder="09 / 23">
                            </div>
                            <div class="input_box">
                                <label for="cvc"> CVC </label>
                                <input id="cvc" type="text" name="cvc" class='form-control' placeholder="102">
                            </div>
                        </div>

                        <div class="input_box">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="default_payment" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    تعيين كطريقة دفع افتراضية
                                </label>
                            </div>
                        </div>
                        <div class="submit_buttons">
                            <button class="btn global_button" type="reset"> إعادة تعيين </button>
                            <button type="submit" name="add_new_payment" class="btn global_button"> إضافة بطاقه جديدة </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>