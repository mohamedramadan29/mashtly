<?php
if (isset($_GET['step_id'])) {
    $step_id = $_GET['step_id'];
    $stmt = $connect->prepare("SELECT * FROM order_steps WHERE id=?");
    $stmt->execute(array($step_id));
    $step_data = $stmt->fetch();
}
if (isset($_POST['add_step'])) {
    $order_id = $step_data['order_id'];
    $order_number = $step_data['order_number'];
    $username = $_SESSION['id'];
    $step_name = $_POST['step_name'];
    $description = $_POST['description'];
    $new_date = $_POST['new_date'];
    // get the  date
    date_default_timezone_set('Asia/Riyadh'); // تحديد المنطقة الزمنية
    $date = date('d/m/Y h:i a'); // تنسيق التاريخ والوقت
    $formerror = [];
    if (empty($username)) {
        $formerror[] = 'من فضلك ادخل اسم المستخدم ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username , date , step_name,description,step_status)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zdesc,:zstatus)");
        $stmt->execute(array(
            "zorder_id" => $order_id,
            "zorder_number" => $order_number,
            "zusername" => $username,
            "zdate" => $new_date,
            "zstep_name" => $step_name,
            "zdesc" => $description,
            "zstatus" => 'انتهت',
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
        }
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
                <h1 class="m-0 text-dark"> اضافة حالة جديدة </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> اضافة حالة جديدة</li>
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
                            <div class="form-group">
                                <label for="inputStatus"> اختر الحالة الجديدة </label>
                                <select required id="select2" class="form-control custom-select" name="step_name">
                                    <option selected disabled> -- اختر -- </option>
                                    <option value="تم التواصل"> تم التواصل </option>
                                    <option value="تواصل بدون رد"> تواصل بدون رد </option>
                                    <option value="تأجيل"> تأجيل </option>
                                    <option value="ملغي، يدويا"> ملغي، يدويا </option>
                                    <option value="ملغي لم يسترجع"> ملغي لم يسترجع </option>
                                    <option value="ملغي تم الاسترجاع"> ملغي تم الاسترجاع </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> موعد التوصيل </label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <input type="text" name="new_date" class="form-control datetimepicker-input" data-target="#reservationdatetime" />
                                    <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description"> ملاحظات </label>
                                <textarea id="description" name="description" class="form-control" rows="4"><?php if (isset($_REQUEST['description'])) echo $_REQUEST['description'] ?></textarea>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>
            <div class="row" style="display: flex;justify-content: space-between;">
                <button type="submit" class="btn btn-primary" name="add_step"> <i class="fa fa-save"></i> حفظ </button>
                <!-- <a href="main.php?dir=products&page=report" class="btn btn-secondary">رجوع <i class="fa fa-backward"></i> </a> -->
            </div>
        </form>
        <br>
        <br>
    </div>
    <!-- /.container-fluid -->
</section>