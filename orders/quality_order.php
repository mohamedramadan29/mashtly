<?php
if (isset($_GET['step_id'])) {
    $step_id = $_GET['step_id'];
    $stmt = $connect->prepare("SELECT * FROM order_steps WHERE id=?");
    $stmt->execute(array($step_id));
    $step_data = $stmt->fetch();
    $order_id = $step_data['order_id'];
    $order_number = $step_data['order_number'];
    $username = $_SESSION['id'];

    // get the  date
    date_default_timezone_set('Asia/Riyadh'); // تحديد المنطقة الزمنية
    $date = date('d/m/Y h:i a'); // تنسيق التاريخ والوقت

    // get the order data 
    $stmt = $connect->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute(array($order_id));
    $order_data = $stmt->fetch();
    $payment_method = $order_data['payment_method'];
}
// تم التواصل بنجاح 
if (isset($_POST['quality_rating'])) {
    $order_step_detail_ids = $_POST['order_step_detail_id'];
    $product_notes = $_POST['product_notes'];
    $product_image_ratings = $_POST['product_image_rating'];

    $formerror = [];

    if (empty($formerror)) {
        for ($i = 0; $i < count($order_step_detail_ids); $i++) {
            $step_detail_id = $order_step_detail_ids[$i];
            $product_note = $product_notes[$i];
            $product_rating = $product_image_ratings[$i];
            $stmt = $connect->prepare("UPDATE order_step_details SET product_image_rating=?, product_notes = ? WHERE id = ?");
            $stmt->execute(array($product_rating, $product_note, $step_detail_id));
        }
        $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date , step_name,step_status)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zstatus)");
        $stmt->execute(array(
            "zorder_id" => $order_id,
            "zorder_number" => $order_number,
            "zusername" => $username,
            "zdate" => $date,
            "zstep_name" => 'الجودة',
            "zstatus" => 'تمت مراجعه الجودة',
        ));

        if ($stmt) {

            // 1 - تحديد الموظف الخاص بالجودة
            // 2 - تسجيل خطوة الجودة في خطوات الطلب 
            $stmt = $connect->prepare("SELECT * FROM employes WHERE role_name='التجهيز'");
            $stmt->execute();
            $emp_data = $stmt->fetch();
            $emp_id = $emp_data['id'];
            // تسجيل خطوة الجودة في خطوات تنفيذ الطلب 
            $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date , step_name,step_status)
            VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zstatus)");
            $stmt->execute(array(
                "zorder_id" => $order_id,
                "zorder_number" => $order_number,
                "zusername" => $emp_id,
                "zdate" => $date,
                "zstep_name" => 'التجهيز',
                "zstatus" => 'تمت مراجعه الجودة',
            ));
            // تحديث بيانات الطلب 
            $stmt = $connect->prepare("UPDATE orders SET status_value='تمت مراجعه الجودة' WHERE id=?");
            $stmt->execute(array($order_id));
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
        exit();
    }
    // تم التواصل اكثر من ثلاث مرات ولاكن لم يتم الرد 
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> ملاحظات الجودة </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> مرحلة تجهيز وملاحظات الجودة </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content-header -->
<!-- DOM/Jquery table start -->
<section class="content">
    <div class="container-fluid">
        <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="row">
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM order_step_details WHERE order_id = ?");
                                $stmt->execute(array($order_id));
                                $order_details = $stmt->fetchAll();
                                foreach ($order_details as $detail) {
                                ?>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="hidden" name="order_step_detail_id[]" value="<?php echo $detail['id'] ?>">
                                            <label for=""> اسم المنتج </label>
                                            <input type="text" name="product_name[]" class="form-control" value="<?php echo $detail['product_name']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for=""> صورة المنتج </label>
                                            <a href="steps_images/<?php echo $detail['product_image']; ?>" target="_blank"><img style="width: 100px; height:100px" src="steps_images/<?php echo $detail['product_image']; ?>"></a>
                                        </div>
                                        <div class="form-group">
                                            <label for=""> تقيم المنتج </label>
                                            <select name="product_image_rating[]" id="" class="form-control select2">
                                                <option value=""> -- قيم صورة المنتج -- </option>
                                                <option value="سيئ">سيئ</option>
                                                <option value="مقبول">مقبول</option>
                                                <option value="جيد">جيد</option>
                                                <option value="جيد جدا">جيد جدا</option>
                                                <option value="ممتاز">ممتاز</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="description"> ملاحظات الجودة علي المنتج </label>
                                            <textarea id="description" name="product_notes[]" class="form-control" rows="4"><?php if (isset($_REQUEST['product_notes'])) echo $_REQUEST['product_notes'] ?></textarea>
                                        </div>
                                        <hr>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="row" style="display: flex;justify-content: space-between;">
                <button type="submit" id="quality_rating" class="btn btn-primary quality_rating" name="quality_rating">ارسال لتقيم الجودة <i class="fa fa-save"></i> </button>
                <!-- <a href="main.php?dir=products&page=report" class="btn btn-secondary">رجوع <i class="fa fa-backward"></i> </a> -->
            </div>
        </form>
        <br>
        <br>
    </div>
    <!-- /.container-fluid -->
</section>

<style>

</style>