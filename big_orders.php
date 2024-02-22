<?php
ob_start();
session_start();
$page_title = ' الطلبات الكبيرة  ';
include "init.php";

?>
<div class="profile_page adress_page">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> الطلبات الكبيرة </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> الطلبات الكبيرة </h2>
                    <p> -- </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="join_form add_new_address import_request">
    <form action="" method="post" enctype="multipart/form-data" id="send_form">
        <h2> اطلب الخدمة </h2>
        <p> برجاء ملئ الحقول التالية </p>
        <div class='box'>
            <div class="input_box">
                <label for="name"> اسم (المؤسسة - الشركة)
                </label>
                <input required value="<?php if (isset($_REQUEST['company_name'])) echo $_REQUEST['company_name'] ?>" id="name" type="text" name="company_name" class='form-control' placeholder="اكتب…">
            </div>
        </div>
        <div class='box'>
            <div class="input_box">
                <label for="name"> اسم ممثل الشركة </label>
                <input required value="<?php if (isset($_REQUEST['company_person_name'])) echo $_REQUEST['company_person_name'] ?>" id="name" type="text" name="company_person_name" class='form-control' placeholder="اكتب…">
            </div>
        </div>
        <div class="box">
            <div class="input_box">
                <label for="phone"> رقم الجوال </label>
                <input required value="<?php if (isset($_REQUEST['phone'])) echo $_REQUEST['phone'] ?>" id="phone" type="text" name="phone" class='form-control' placeholder="اكتب…">
            </div>
        </div>
        <div class='box'>
            <div class="input_box">
                <label for="email"> البريد الإلكتروني </label>
                <input required value="<?php if (isset($_REQUEST['email'])) echo $_REQUEST['email'] ?>" id="email" type="email" name="email" class='form-control' placeholder="اكتب…">
            </div>
        </div>
        <div class='box'>
            <div class="input_box">
                <label for="name"> المدينة </label>
                <input required value="<?php if (isset($_REQUEST['city'])) echo $_REQUEST['city'] ?>" id="name" type="text" name="city" class='form-control' placeholder="اكتب…">
            </div>
        </div>
        <div class='box'>
            <div class="input_box">
                <label for="products"> نوع الطلبية </label>
                <select required name="request_type[]" class="form-control select2" id="products" multiple placeholder='حدد المنتجات'>
                    <option value=""> -- حدد المنتجات -- </option>
                    <option value="نباتات"> نباتات </option>
                    <option value="مستلزمات"> مستلزمات </option>
                </select>
            </div>
        </div>
        <div class='box'>
            <div class="input_box">
                <label for="name"> وصف الطلبية </label>
                <textarea required id="name" type="text" name="order_details" class='form-control' placeholder="اكتب…"><?php if (isset($_REQUEST['order_details'])) echo $_REQUEST['order_details'] ?></textarea>
            </div>
        </div>
        <div class='box'>
            <div class="input_box">
                <label for="name"> مرفقات للطلبية </label>
                <input id="name" type="file" name="order_attachment" class='form-control'>
            </div>
        </div>
        <div class="box">
            <button class="btn global_button" name="request_order" id="send_message"> طلب الخدمة </button>
        </div>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $company_name = sanitizeInput($_POST['company_name']);
        $company_person_name = sanitizeInput($_POST['company_person_name']);
        $phone = sanitizeInput($_POST['phone']);
        $email = sanitizeInput($_POST['email']);
        $city = sanitizeInput($_POST['city']);
        $order_details = sanitizeInput($_POST['order_details']);
        $request_type = $_POST['request_type'];
        $request_type = implode(',', (array) $request_type);
        $date = date("Y-m-d");
        $formerror = [];
        if (empty($company_name) || empty($company_person_name) || empty($phone) || empty($email) || empty($city)  || empty($request_type) || empty($order_details)) {
            $formerror[] = 'من فضلك ادخل المعلومات كاملة ';
        }
        if (empty($email)) {
            $formerror[] = " يجب اضافة البريد الالكتروني  ";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $formerror[] = " يجب إدخال عنوان بريد إلكتروني صالح ";
        } elseif (strlen($email) > 100) {
            $formerror[] = "طول البريد الإلكتروني يجب أن لا يتجاوز 100 حرفًا";
        } elseif (!preg_match('/^[a-zA-Z0-9.@ـ\-\_\+\,\']+$/u', $email)) {
            $formerror[] = "البريد الإلكتروني يجب أن يحتوي على أحرف وأرقام ورموز صحيحة فقط";
        } elseif (strpos($email, '..') !== false) {
            $formerror[] = "البريد الإلكتروني يحتوي على أحرف غير صالحة";
        }
        // main image
        if (!empty($_FILES['order_attachment']['name'])) {
            $main_image_name = $_FILES['order_attachment']['name'];
            $main_image_temp = $_FILES['order_attachment']['tmp_name'];
            $main_image_type = $_FILES['order_attachment']['type'];
            $main_image_size = $_FILES['order_attachment']['size'];
            $main_image_uploaded = time() . '_' . $main_image_name;
            move_uploaded_file(
                $main_image_temp,
                'admin/big_orders/attachments/' . $main_image_uploaded
            );
        } else {
            $main_image_uploaded = '';
        }
        if (empty($formerror)) {
            $stmt = $connect->prepare("INSERT INTO big_orders (company_name,company_person_name,phone,email,city,request_type,order_details,order_attachments,order_date)
                    VALUES(:zcompany_name,:zcompany_person_name,:zphone,:zemail,:zcity,:zrequest_type,:zorder_details,:zorder_attachments,:zorder_date)
                    ");
            $stmt->execute(array(
                "zcompany_name" => $company_name,
                "zcompany_person_name" => $company_person_name,
                "zphone" => $phone,
                "zemail" => $email,
                "zcity" => $city,
                "zrequest_type" => $request_type,
                "zorder_details" => $order_details,
                "zorder_attachments" => $main_image_uploaded,
                "zorder_date" => $date,
            ));
            if ($stmt) {
                alertsendmessage();
                header('refresh:1.5;url=big_orders');
            }
        } else {
            foreach ($formerror as $error) {
    ?>
                <div class="alert alert-danger"> <?php echo $error; ?> </div>
            <?php
            }
            ?>
    <?php
        }
    }
    ?>
</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<script>
    // disable button untill Send 
    $(document).ready(function($) {
        // قائمة لتخزين معلومات الملفات المختارة
        let selectedFiles = [];
        $('#send_form').submit(function() {
            var submitButton = document.getElementById('send_message');
            submitButton.setAttribute('disabled', 'disabled');
        });
    });
</script>