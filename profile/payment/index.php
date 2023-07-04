<?php
ob_start();
session_start();
$page_title = ' طرق الدفع  ';
include 'init.php';
$user_id = $_SESSION['user_id'];
?>
<div class="profile_page adress_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="../index"> الرئيسية </a> \ <a href="../index"> حسابي </a> \ <span> طرق الدفع </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> طرق الدفع </h2>
                    <p> نستخدم أحدث طرق التشفير لحفط بياناتك </p>
                </div>
            </div>

            <div class="addresses">
                <div class="row">
                    <?php
                    $encryptionKey = "!#@_MOHAMED_!#@_MASHTLY";
                    $stmt = $connect->prepare("SELECT * FROM user_payments WHERE user_id = ?");
                    $stmt->execute(array($user_id));
                    $allpayments = $stmt->fetchAll();
                    foreach ($allpayments as $payment) {
                        $id = $payment['id'];
                        $card_name = $payment['card_name'];
                        $card_number = $payment['card_number'];
                        $card_number = openssl_decrypt($card_number, "AES-128-ECB", $encryptionKey);
                        $first_number = substr($card_number, 0, 1);
                        $lastFourDigits = substr($card_number, -4);
                        $end_date = $payment['end_date'];
                        $cvc = $payment['cvc'];
                        $default = $payment['default_payment'];
                    ?>
                        <div class="col-lg-4">
                            <div class="address payment_method <?php if ($default == 1) echo "active" ?>">
                                <div class='add_head'>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault<?php echo $id; ?>" <?php if ($default == 1) echo "checked"; ?>>
                                        <label class="form-check-label" for="flexRadioDefault<?php echo $id; ?>" class='<?php if ($default == 1) echo "active" ?>'>
                                            تعيين كطريقة دفع افتراضية
                                        </label>
                                    </div>
                                    <form action="delete" method="post">
                                        <input type="hidden" name="card_id" value="<?php echo $id; ?>">
                                        <div class='remove_add'>
                                            <button id="confirm_delete" name="delete_card" type="submit" onclick="return confirm('هل أنت متأكد من رغبتك في حذف البطاقة ؟ ')"> <i class='fa fa-close'></i> حذف البطاقة</button>
                                        </div>
                                    </form>
                                </div>
                                <div class='add_content'>
                                    <div class="card_image">
                                        <?php
                                        $visa_public_name = 'فيزا';
                                        if ($first_number == 5 || $first_number == 2) {
                                            $visa_public_name = 'ماستر كارد ';
                                        ?>
                                            <img src="<?php echo $uploads ?>master.png" alt="">
                                        <?php
                                        } elseif ($first_number == 4) {
                                            $visa_public_name = 'فيزا';
                                        ?>
                                            <img src="<?php echo $uploads ?>visa.svg" alt="">
                                        <?php
                                        } else {
                                        ?>
                                            <img src="<?php echo $uploads ?>visa.svg" alt="">

                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="card_data">
                                        <p class="number"><?php echo $lastFourDigits; ?> **** **** **** </p>
                                        <p class="end_date"> تاريخ الانتهاء <span> <?php echo $end_date; ?></span> </p>
                                        <p class="name"> <?php echo $card_name; ?> </p>
                                    </div>
                                </div>
                                <div class='edit'>
                                    <a href="edit?card=<?php echo $id; ?>"> تعديل <img src="<?php echo $uploads ?>edit_button.svg" alt=""> </a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="col-lg-4">
                        <div class="add_new_address">
                            <a href="add">
                                <i class="fa fa-plus"></i>
                                <h3> أضف بطاقة جديدة </h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>