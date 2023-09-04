<?php
ob_start();
session_start();
$page_title = ' خدمات الاستيراد ';
include "init.php";

?>
<div class="profile_page adress_page">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> خدمات الاستيراد </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> خدمات الاستيراد </h2>
                    <p> هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="join_form add_new_address import_request" style="max-width: 65%;">
    <form action="" method="post" enctype="multipart/form-data">
        <h2> اطلب الخدمة </h2>
        <p> برجاء ملئ الحقول التالية </p>
        <div class='box'>
            <div class="input_box">
                <label for="name"> الاسم بالكامل </label>
                <input required value="<?php if (isset($_REQUEST['name'])) echo $_REQUEST['name'] ?>" id="name" type="text" name="name" class='form-control' placeholder="اكتب…">
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
                <label for="email"> البريد الألكتروني </label>
                <input required value="<?php if (isset($_REQUEST['email'])) echo $_REQUEST['email'] ?>" id="email" type="email" name="email" class='form-control' placeholder="اكتب…">
            </div>
        </div>
        <div class='box'>
            <div class="input_box">
                <label for="products"> حدد المنتجات المراد استيرادها </label>
                <select required name="products[]" class="form-control select2" id="products" multiple placeholder='حدد المنتجات'>
                    <option value=""> -- حدد المنتجات -- </option>
                    <option value="المنتج الاول"> المنتج الاول </option>
                    <option value="المنتج الثاني"> المنتج الثاني </option>
                    <option value="المنتج الثالث"> المنتج الثالث </option>
                </select>
            </div>
        </div>
        <div class="box">
            <button class="btn global_button" name="request_order"> طلب الخدمة </button>
        </div>
    </form>
    <?php
    if (isset($_POST['request_order'])) {
        $name = sanitizeInput($_POST['name']);
        $phone = sanitizeInput($_POST['phone']);
        $email = sanitizeInput($_POST['email']);
        $products = $_POST['products'];
        $products = implode(',', (array) $products);
        $date = date("Y-m-d");
        $formerror = [];
        if (empty($name) || empty($phone) || empty($email) || empty($products)) {
            $formerror[] = 'من فضلك ادخل المعلومات كاملة ';
        }
        if (empty($formerror)) {
            $stmt = $connect->prepare("INSERT INTO import_services (name,phone,email,products,order_date)
                    VALUES(:zname,:zphone,:zemail,:zproducts,:zorder_date)
                    ");
            $stmt->execute(array(
                "zname" => $name,
                "zphone" => $phone,
                "zemail" => $email,
                "zproducts" => $products,
                "zorder_date" => $date,
            ));
            if ($stmt) {
                alertsendmessage();
                header('refresh:1.5;url=import_service');
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