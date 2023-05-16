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
    $client_progress_note = $_POST['client_proceess_note'];
    $company_progress_note = $_POST['company_proceess_note'];
    $step_name = 'التجهيز';
    $product_names = $_POST['product_name'];
    $formerror = [];
    if (empty($step_name)) {
        $formerror[] = ' من فضلك حدد حالة التواصل ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date , step_name,step_status,client_progress_note,company_progress_note)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zstatus,:zclient_note,:zcompany_note)");
        $stmt->execute(array(
            "zorder_id" => $order_id,
            "zorder_number" => $order_number,
            "zusername" => $username,
            "zdate" => $date,
            "zstep_name" => 'التجهيز',
            "zstatus" => 'تم التجهيز وفي انتظار موافقه الجودة',
            'zclient_note' => $client_progress_note,
            'zcompany_note' => $company_progress_note,
        ));
        for ($i = 0; $i < count($product_names); $i++) {
            $product_name = $product_names[$i];
            $product_image_name = $_FILES['product_images']['name'][$i];
            $product_image_temp = $_FILES['product_images']['tmp_name'][$i];
            $product_image_type = $_FILES['product_images']['type'][$i];
            $product_image_size = $_FILES['product_images']['size'][$i];
            $product_image_uploaded = time() . '_' . $product_image_name;
            move_uploaded_file(
                $product_image_temp,
                'steps_images/' . $product_image_uploaded
            );
            $stmt = $connect->prepare("INSERT INTO order_step_details (order_id ,order_number ,product_name , 
            product_image) VALUES (:zorder_id,:zorder_number,:zproduct_name,:zproduct_image)");
            $stmt->execute(array(
                "zorder_id" => $order_id,
                "zorder_number" => $order_number,
                "zproduct_name" => $product_name,
                "zproduct_image" => $product_image_uploaded,
            ));
        }


        if ($stmt) {

            // 1 - تحديد الموظف الخاص بالجودة
            // 2 - تسجيل خطوة الجودة في خطوات الطلب 
            $stmt = $connect->prepare("SELECT * FROM employes WHERE role_name='الجودة'");
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
                "zstep_name" => ' الجودة ',
                "zstatus" => 'تم التجهيز وفي مرحلة ملاحظات الجودة',
            ));
            // تحديث بيانات الطلب 
            $stmt = $connect->prepare("UPDATE orders SET status_value=' انتظار مراجعه الجودة ' WHERE id=?");
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
                <h1 class="m-0 text-dark"> تجهيز الطلب </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> مرحلة تجهيز الطلب </li>
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
                            <!-- <ul>
                                <h4> المتطلبات </h4>
                                <li class="badge badge-warning"> 1- ارفاق صورة لكل منتج في الطلب </li>
                                <li class="badge badge-warning"> 2- ملاحظات مجهز الطلب للعميل (اختياري) </li>
                                <li class="badge badge-warning"> 3- ملاحظاته للإدارة (اختياري) </li>
                                <li class="badge badge-warning"> 4- ترسل صور المنتجات على رقم العميل واتس أو نصية أو بريد الكتروني مرتبة حسب التوفر. </li>
                                <li class="badge badge-warning"> 5- إثبات موافقة العميل على الصور كصورة مراسالات أو كتابة توضيح للإدارة بموافقة العميل شفوياً. </li>
                            </ul>
-->
                            <?php
                            $stmt = $connect->prepare("SELECT * FROM order_details WHERE order_id = ?");
                            $stmt->execute(array($order_id));
                            $all_order_data = $stmt->fetchAll();
                            foreach ($all_order_data as $order_data) {
                                $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                $stmt->execute(array($order_data['product_id']));
                                $product_data = $stmt->fetch();
                            ?>
                                <div class="form-group">
                                    <label for=""> اسم المنتج </label>
                                    <input type="text" name="product_name[]" class="form-control" value="<?php echo $product_data['name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""> اختر صورة المنتج </label>
                                    <input type="file" name="product_images[]" class="form-control">
                                </div>
                                <hr>
                            <?php
                            }
                            ?>
                            <div class="form-group">
                                <label for="description"> ملاحظاتك للعميل :</label>
                                <textarea id="description" name="client_proceess_note" class="form-control" rows="4"><?php if (isset($_REQUEST['description'])) echo $_REQUEST['description'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="description"> ملاحظاتك للإدارة :</label>
                                <textarea id="description" name="company_proceess_note" class="form-control" rows="4"><?php if (isset($_REQUEST['description'])) echo $_REQUEST['description'] ?></textarea>
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

<script>
    // احضر العناصر اللازمة من الصفحة
    /* const selectEl = document.getElementById('select2');
     const dateEl = document.getElementById('arrival_date');
     const arrival_step = document.getElementById('arrival_step');
     const not_respose = document.getElementById('not_response');
     const response_delay = document.getElementById('response_delay');
     const arrival_delay = document.getElementById('arrival_delay');
     const cancel_order = document.getElementById('cancel_order');
     const return_file = document.getElementById('return_file');
     const cancel_return = document.getElementById('cancel_return');
     // أضف حدثًا onchange إلى القائمة المنسدلة
     selectEl.onchange = function() {
         const selectedValue = selectEl.value;
         // فحص القيمة المحددة وإظهار / إخفاء الحقول الأخرى
         if (selectedValue === 'تم التواصل') {
             dateEl.style.display = 'block';
             not_respose.style.display = 'none';
             response_delay.style.display = 'none';
         } else {
             dateEl.style.display = 'none';
         }
         if (selectedValue === 'تواصل بدون رد') {
             not_respose.style.display = 'block';
             arrival_step.style.display = 'none';
             response_delay.style.display = 'none';
         }
         if (selectedValue === 'تأجيل') {
             response_delay.style.display = 'block';
             arrival_delay.style.display = 'block';
             not_respose.style.display = 'none';
             arrival_step.style.display = 'none';
         } else {
             arrival_delay.style.display = 'none';
         }
         if (selectedValue === 'ملغي، يدويا') {
             response_delay.style.display = 'none';
             arrival_delay.style.display = 'none';
             not_respose.style.display = 'none';
             arrival_step.style.display = 'none';
             cancel_order.style.display = 'block';
         }
         if (selectedValue === 'ملغي تم الاسترجاع') {
             response_delay.style.display = 'none';
             arrival_delay.style.display = 'none';
             not_respose.style.display = 'none';
             arrival_step.style.display = 'none';
             cancel_order.style.display = 'none';
             return_file.style.display = 'block';
             cancel_return.style.display = 'block';
         }
     };*/
</script>
<style>

</style>