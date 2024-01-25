<?php
ob_start();
session_start();
$page_title = 'الرئيسية';
include "init.php";
?>
<div class="profile_page adress_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> اتصل بنا </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> اتصل بنا </h2>
                </div>
            </div>
        </div>
        <div class="faqs">
            <div class="row">
                <div class="col-4">
                    <div class="faq">
                        <a href="faq">
                            <img src="<?php echo $uploads ?>faq_join.svg" alt="">
                            <h2> الأسئلة الشائعة </h2>
                        </a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="faq">
                        <a href="join_us">
                            <img src="<?php echo $uploads ?>work_faq.svg" alt="">
                            <h2> انضم الينا </h2>
                        </a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="faq active">
                        <a href="contact">
                            <img src="<?php echo $uploads ?>contact.svg" alt="">
                            <h2> اتصل بنا </h2>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="address">
            <div class="row">
                <div class="col-lg-4">
                    <div class="data">
                        <span> عنواننا </span>
                        <h3> عنوان مكتبنا الرسمي </br> الرياض - السعودية </h3>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="data">
                        <span> البريد الإلكتروني </span>
                        <h3> contact@mshtly.com </h3>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="data">
                        <span> الهاتف </span>
                        <h3> +9660530047542 </h3>
                    </div>
                </div>
            </div>
            <div class="map">
                <img src="<?php echo $uploads ?>map.png" alt="">
            </div>
        </div>
        <div class="purches_header">
            <div class="data_header_name">
                <h2 class='header2'>تحدث معنا</h2>
                <p> برجاء ملئ الحقول التالية </p>
            </div>
        </div>
        <div class="add_new_address">
            <form action="#" method="post">
                <div class='row'>
                    <div class="box">
                        <div class="input_box">
                            <label for="country"> سبب الاتصال </label>
                            <select required name="reason" id="" class='form-control select2'>
                                <option value=""> اختر من القائمة </option>
                                <option value="1"> السبب الاول 1 </option>
                                <option value="2"> السبب الثاني 2 </option>
                                <option value="3"> السبب الثالث 3 </option>
                                <option value="4"> السبب الرابع 4 </option>
                            </select>
                        </div>
                        <div class="input_box">
                            <label for="name"> الاسم </label>
                            <input value="<?php if (isset($_REQUEST['name'])) echo $_REQUEST['name'] ?>" required id="name" type="text" name="name" class='form-control' placeholder="اكتب…">
                        </div>
                    </div>
                    <div class='box'>
                        <div class="input_box">
                            <label for="phone"> رقم الجوال </label>
                            <input value="<?php if (isset($_REQUEST['phone'])) echo $_REQUEST['phone'] ?>" required id="phone" type="text" name="phone" class='form-control' placeholder="اكتب…">
                        </div>
                        <div class="input_box">
                            <label for="email"> البريد الألكتروني </label>
                            <input value="<?php if (isset($_REQUEST['email'])) echo $_REQUEST['email'] ?>" required id="email" type="email" name="email" class='form-control' placeholder="اكتب…">
                        </div>
                    </div>
                    <div class="box textarea">
                        <div class="input_box" style="width: 100%;">
                            <label for="email"> الرسالة </label>
                            <textarea value="" required name="message" id="reason_contact" class="form-control" placeholder="ادخل النص…"><?php if (isset($_REQUEST['message'])) echo $_REQUEST['message'] ?></textarea>
                        </div>
                    </div>
                    <div class="submit_buttons">
                        <button class="btn global_button" name="send_message"> ارسال </button>
                    </div>
                </div>
            </form>
            <?php
            if (isset($_POST['send_message'])) {
                $reason = sanitizeInput($_POST['reason']);
                $name = sanitizeInput($_POST['name']);
                $phone = sanitizeInput($_POST['phone']);
                $email = sanitizeInput($_POST['email']);
                $message = sanitizeInput($_POST['message']);
                $formerror = [];
                if (empty($name) || empty($reason) || empty($phone) || empty($email) || empty($message)) {
                    $formerror[] = 'من فضلك ادخل المعلومات كاملة ';
                }
                if (empty($formerror)) {
                    $stmt = $connect->prepare("INSERT INTO contact_us (reason,name,phone,email,message)
                    VALUES(:zreason,:zname,:zphone,:zemail,:zmessage)
                    ");
                    $stmt->execute(array(
                        "zreason" => $reason,
                        "zname" => $name,
                        "zphone" => $phone,
                        "zemail" => $email,
                        "zmessage" => $message,
                    ));
                    if ($stmt) {
                        alertsendmessage();
                        header('refresh:1.5;url=contact');
                    }
                } else {
            ?>
                    <div class="alert alert-danger"> من فضلك ادخل معلوماتك بشكل كامل </div>
            <?php
                }
            }

            ?>
        </div>
    </div>

</div>

<?php
include $tem . 'footer.php';
ob_end_flush();
?>