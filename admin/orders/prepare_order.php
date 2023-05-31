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
}

// اعادة تقيم الجودة

if (isset($_POST['quality_rating_repeat'])) {
    $order_step_detail_ids = $_POST['order_step_detail_id'];
    for ($i = 0; $i < count($order_step_detail_ids); $i++) {
        $step_detail_id = $order_step_detail_ids[$i];
        if (isset($_FILES['product_images']['name'][$i])) {
            $product_image_name = $_FILES['product_images']['name'][$i];
            $product_image_temp = $_FILES['product_images']['tmp_name'][$i];
            $product_image_type = $_FILES['product_images']['type'][$i];
            $product_image_size = $_FILES['product_images']['size'][$i];
            $product_image_uploaded = time() . '_' . $product_image_name;
            move_uploaded_file(
                $product_image_temp,
                'steps_images/' . $product_image_uploaded
            );
        } else {
            $product_image_uploaded = '';
        }
        // Check if $_FILES['product_images']['name'][$i] is set before executing the update statement
        if ($_FILES['product_images']['name'][$i] != '') {
            $stmt = $connect->prepare("UPDATE order_step_details SET product_image = ? WHERE id = ? ");
            $stmt->execute(array($product_image_uploaded, $step_detail_id));
        }
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
            "zstatus" => 'تم عمل ملاحظات الجودة وفي انتظار التاكيد ',
        ));
        // تحديث بيانات الطلب 
        $stmt = $connect->prepare("UPDATE orders SET status_value=' انتظار مراجعه الجودة ' WHERE id=?");
        $stmt->execute(array($order_id));
        $_SESSION['success_message'] = " تمت التعديل  بنجاح  ";
        header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
        exit();
    }
}

// تم التجهيز بنجاح 

if (isset($_POST['quality_compelete'])) {
    $step_name = 'التوصيل';
    $formerror = [];
    if (empty($step_name)) {
        $formerror[] = ' من فضلك حدد حالة التواصل ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date , step_name,step_status)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zstatus)");
        $stmt->execute(array(
            "zorder_id" => $order_id,
            "zorder_number" => $order_number,
            "zusername" => $username,
            "zdate" => $date,
            "zstep_name" => 'التوصيل',
            "zstatus" => 'تم تجهيز الطلب والان في مرحلة التوصيل',
        ));
    }
    if ($stmt) {
        // 1 - تحديد الموظف الخاص بالجودة
        // 2 - تسجيل خطوة الجودة في خطوات الطلب 
        $stmt = $connect->prepare("SELECT * FROM employes WHERE role_name='التوصيل'");
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
            "zstep_name" => 'التوصيل',
            "zstatus" => 'تم تجهيز الطلب والان في مرحلة التوصيل',
        ));
        // تحديث بيانات الطلب 
        $stmt = $connect->prepare("UPDATE orders SET status_value='تم تجهيز الطلب والان في مرحلة التوصيل' WHERE id=?");
        $stmt->execute(array($order_id));
        $_SESSION['success_message'] = " تمت التعديل  بنجاح  ";
        header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
        exit();
    }
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
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <!--- هل تم تجهيز الطلب من قبل وتحت المراجعه  -->
                        <?php
                        $stmt = $connect->prepare("SELECT * FROM order_steps WHERE step_name = 'الجودة' AND order_id = ?");
                        $stmt->execute(array($order_id));
                        $count = $stmt->rowCount();
                        if ($count > 0) {
                        ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM order_step_details WHERE order_id = ?");
                                $stmt->execute(array($order_id));
                                $order_steps_data = $stmt->fetchAll();
                                foreach ($order_steps_data as $step_data) {
                                ?>
                                    <div class="form-group">
                                        <input type="hidden" name="order_step_detail_id[]" value="<?php echo $step_data['id']; ?>">
                                        <label for=""> اسم المنتج :</label>
                                        <input disabled type="text" name="product_name[]" class="form-control" value="<?php echo $step_data['product_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for=""> صورة المنتج لمعاينة الجودة :</label>
                                        <a href="steps_images/<?php echo $step_data['product_image'] ?>" target="_blank"> <img style="width: 150px; height:150px" src="steps_images/<?php echo $step_data['product_image'] ?>" alt=""> </a>
                                    </div>
                                    <div class="form-group">
                                        <label for=""> تعديل صورة المنتج : </label>
                                        <input type="file" name="product_images[]" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for=""> تقيم الجودة للمنتج :</label>
                                        <span class="badge badge-danger"><?php echo $step_data['product_image_rating']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for=""> ملاحظة الجودة :</label>
                                        <textarea disabled class="form-control"> <?php echo $step_data['product_notes']; ?> </textarea>
                                    </div>
                                    <hr>
                                <?php
                                }
                                ?>
                                <div class="row" style="display: flex;justify-content: space-between;">
                                    <button type="submit" id="quality_rating" class="btn btn-warning quality_compelete btn-sm" name="quality_compelete"> اتمام تجهيز الطلب <i class="fa fa-save"></i> </button>
                                    <button type="submit" id="quality_rating" class="btn btn-primary quality_rating btn-sm" name="quality_rating_repeat"> اعادة تقيم جودة <i class="fa fa-retweet"></i> </button>
                                </div>
                            </form>
                        <?php
                        } else {
                        ?>
                            <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
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
    <?php
                        }
    ?>

    <br>
    <br>
    </div>
    <!-- /.container-fluid -->
</section>