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
if (isset($_POST['add_arrival_step'])) {
    $step_name = $_POST['step_name'];
    $description = $_POST['arrival_description'];
    $arrival_date = $_POST['arrival_date'];
    $formerror = [];
    if (empty($step_name)) {
        $formerror[] = ' من فضلك حدد حالة التواصل ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date, arrival_date , step_name,description,step_status)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zarrival_date,:zstep_name,:zdesc,:zstatus)");
        $stmt->execute(array(
            "zorder_id" => $order_id,
            "zorder_number" => $order_number,
            "zusername" => $username,
            "zdate" => $date,
            "zarrival_date" => $arrival_date,
            "zstep_name" => $step_name,
            "zdesc" => $description,
            "zstatus" => 'تم التواصل مع العميل',
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
    // تم التواصل اكثر من ثلاث مرات ولاكن لم يتم الرد 
} elseif (isset($_POST['not_response_step'])) {
    $step_name = $_POST['step_name'];
    $description = $_POST['arrival_description'];
    $formerror = [];
    if (empty($step_name)) {
        $formerror[] = ' من فضلك حدد حالة التواصل ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date , step_name,description,step_status)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zdesc,:zstatus)");
        $stmt->execute(array(
            "zorder_id" => $order_id,
            "zorder_number" => $order_number,
            "zusername" => $username,
            "zdate" => $date,
            "zstep_name" => $step_name,
            "zdesc" => $description,
            "zstatus" => ' تم التوصل ولم يتم الرد ',
        ));
        if ($stmt) {
            $stmt = $connect->prepare("SELECT * FROM order_steps WHERE order_id = ? AND step_name='تواصل بدون رد'");
            $stmt->execute(array($order_id));
            $count = $stmt->rowCount();
            if ($count >= 3) {
                $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date,step_name,description,step_status)
                VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zdesc,:zstatus)");
                $stmt->execute(array(
                    "zorder_id" => $order_id,
                    "zorder_number" => $order_number,
                    "zusername" => $username,
                    "zdate" => $date,
                    "zstep_name" => 'طلب معلق',
                    "zdesc" => $description,
                    "zstatus" => ' تم تعليق الطلب لعدم استجابة العميل ',
                ));
            }
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
        exit();
    }
} elseif (isset($_POST['response_delay'])) {
    $step_name = $_POST['step_name'];
    $description = $_POST['arrival_description'];
    $delay_date = $_POST['delay_date'];
    $formerror = [];
    if (empty($step_name)) {
        $formerror[] = ' من فضلك حدد حالة التواصل ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date, delay_date , step_name,description,step_status)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zdelay_date,:zstep_name,:zdesc,:zstatus)");
        $stmt->execute(array(
            "zorder_id" => $order_id,
            "zorder_number" => $order_number,
            "zusername" => $username,
            "zdate" => $date,
            "zdelay_date" => $delay_date,
            "zstep_name" => $step_name,
            "zdesc" => $description,
            "zstatus" => '  تم تأجيل الطلب الي تاريخ   ' . $delay_date,
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
    // تم الغاء الطلب 
} elseif (isset($_POST['cancel_order'])) {
    if ($payment_method == 'الدفع عند الاستلام') {
        $step_name = $_POST['step_name'];
        $status = ' تم الغاء الطلب يدويا ';
    } else {
        $step_name = 'ملغي لم يسترجع';
        $status = ' تم الغاء الطلب ولم يسترجع      ';
    }

    $description = $_POST['arrival_description'];
    $formerror = [];
    if (empty($step_name)) {
        $formerror[] = ' من فضلك حدد حالة التواصل ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date , step_name,description,step_status)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zdesc,:zstatus)");
        $stmt->execute(array(
            "zorder_id" => $order_id,
            "zorder_number" => $order_number,
            "zusername" => $username,
            "zdate" => $date,
            "zstep_name" => $step_name,
            "zdesc" => $description,
            "zstatus" => $status,
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
// تم الغاء الطلب وتم الاسترجاع 
elseif (isset($_POST['cancel_return'])) {
    $step_name = $_POST['step_name'];
    $description = $_POST['arrival_description'];

    $formerror = [];
    if (empty($formerror)) {
        if (!empty($_FILES['main_image']['name'])) {
            $main_image_name = $_FILES['main_image']['name'];
            $main_image_temp = $_FILES['main_image']['tmp_name'];
            $main_image_type = $_FILES['main_image']['type'];
            $main_image_size = $_FILES['main_image']['size'];
            $main_image_uploaded = time() . '_' . $main_image_name;
            move_uploaded_file(
                $main_image_temp,
                'steps_images/' . $main_image_uploaded
            );
        } else {
            $formerror[] = ' من فضلك ادخل صورة  الاثبات    ';
        }
    }
    if (empty($step_name)) {
        $formerror[] = ' من فضلك حدد حالة التواصل ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date , step_name,description,step_status,return_file)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zdesc,:zstatus,:zreturn_file)");
        $stmt->execute(array(
            "zorder_id" => $order_id,
            "zorder_number" => $order_number,
            "zusername" => $username,
            "zdate" => $date,
            "zstep_name" => $step_name,
            "zdesc" => $description,
            "zstatus" => 'تم الالغاء والاسترجاع',
            "zreturn_file" => $main_image_uploaded,
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
                <h1 class="m-0 text-dark"> متابعه تنفيذ الطلب </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> متابعه الطلب </li>
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
                                <label for="inputStatus"> حدد حالة التواصل : </label>
                                <select required id="select2" class="form-control custom-select" name="step_name">
                                    <option selected disabled> -- اختر -- </option>
                                    <option value="تم التواصل"> تم التواصل </option>
                                    <option value="تواصل بدون رد"> تواصل بدون رد </option>
                                    <option value="تأجيل"> تأجيل </option>
                                    <option value="ملغي، يدويا"> ملغي، يدويا </option>
                                    <option value="ملغي تم الاسترجاع"> ملغي تم الاسترجاع </option>
                                </select>
                            </div>
                            <div class="form-group" id="arrival_date">
                                <label> موعد التوصيل هو :</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <input type="date" name="arrival_date" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group" id="arrival_delay">
                                <label> تم التأجير الي تاريخ :</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <input type="date" name="delay_date" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group" id="return_file">
                                <label> صورة اثبات الأرجاع :</label>
                                <input type="file" name="main_image" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="description"> ملاحظات :</label>
                                <textarea id="description" name="arrival_description" class="form-control" rows="4"><?php if (isset($_REQUEST['description'])) echo $_REQUEST['description'] ?></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="row" style="display: flex;justify-content: space-between;">
                <button type="submit" id="arrival_step" class="btn btn-primary arrival_step" name="add_arrival_step"> تم التواصل <i class="fa fa-save"></i> </button>
                <button type="submit" id="not_response" class="btn btn-primary not_response" name="not_response_step"> لم يتم الرد <i class="fa fa-save"></i> </button>
                <button type="submit" id="response_delay" class="btn btn-primary response_delay" name="response_delay"> تأجيل الطلب <i class="fa fa-save"></i> </button>
                <button type="submit" id="cancel_order" class="btn btn-primary cancel_order" name="cancel_order"> الغاء الطلب يدويا <i class="fa fa-save"></i> </button>
                <button type="submit" id="cancel_return" class="btn btn-primary cancel_return" name="cancel_return"> الغاء واسترجاع <i class="fa fa-save"></i> </button>
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
    const selectEl = document.getElementById('select2');
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
    };
</script>
<style>
    #arrival_date {
        display: none;
    }

    .not_response {
        display: none;
    }

    .response_delay {
        display: none;
    }

    #arrival_delay {
        display: none;
    }

    #cancel_order {
        display: none;
    }

    #return_file {
        display: none;
    }

    #cancel_return {
        display: none;
    }
</style>