<?php
ob_start();
session_start();
$page_title = ' تفاصيل التنسيق  ';
include "init.php";
// get the design details
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
} else {
    header("Location:index");
}
$stmt = $connect->prepare("SELECT * FROM landscap WHERE slug = ?");
$stmt->execute(array($slug));
$design_data = $stmt->fetch();
$name = $design_data['name'];
$description = $design_data['description'];
$image = $design_data['image'];
$land_id = $design_data['id'];
?>
<div class="profile_page adress_page">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> <a href="landscap"> تنسيق الحدائق </a> </span> \ <span> <?php echo $name ?></span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> <?php echo $name ?> </h2>
                    <p> <?php echo $description ?> </p>
                </div>
            </div>
        </div>
        <div class="landscap_details">
            <div class="row">
                <h6> نمط التصميم </h6>
                <img src="admin/landscap/images/<?php echo $image ?>" alt="">

            </div>
        </div>
    </div>
</div>
<div class="join_form add_new_address import_request" style="background-color: #FFFFFF9A; border: 2px solid #D6E0DF;" >
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
                <label for="area"> حدد مساحة المكان المراد تنسيقها </label>
                <input required value="<?php if (isset($_REQUEST['area'])) echo $_REQUEST['area'] ?>" id="area" type="text" name="area" class='form-control' placeholder="اكتب…">
            </div>
        </div>
        <div class='box'>
            <div class="input_box">
                <label for="attachment"> رفع صور للمساحة / الحديقة </label>
                <input required id="attachment" type="file" name="order_attachment" class='form-control'>
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
        $area = sanitizeInput($_POST['area']);
        $date = date("Y-m-d");
        $formerror = [];
        if (empty($name) || empty($phone) || empty($area)) {
            $formerror[] = 'من فضلك ادخل المعلومات كاملة ';
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
                'admin/landsscap_orders/attachments/' . $main_image_uploaded
            );
        } else {
            $formerror[] = 'من فضلك ادخل صورة الحديقة او المساحة ';
        }
        if (empty($formerror)) {
            $stmt = $connect->prepare("INSERT INTO landscap_request (design_id,name,phone,area,attachment,order_date)
                    VALUES(:zdesign_id,:zname,:zphone,:zarea,:zattachment,:zorder_date)
                    ");
            $stmt->execute(array(
                "zdesign_id" => $land_id,
                "zname" => $name,
                "zphone" => $phone,
                "zarea" => $area,
                "zattachment" => $main_image_uploaded,
                "zorder_date" => $date,
            ));
            if ($stmt) {
                alertsendmessage();
                $encoded_slug = urlencode($slug); // ترميز الـ slug
                header('refresh:1.5;url=land_details?slug=' . $encoded_slug);
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