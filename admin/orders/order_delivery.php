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
// تم التواصل مع العميل والان في مرحلة التوصيل 
if (isset($_POST['contect_customer_done'])) {
    $delivery_date = $_POST['delivery_date'];
    $delivery_place = $_POST['delivery_place'];
    $deliver_client_notes = $_POST['deliver_client_notes'];
    $deliver_emp_notes =  $_POST['deliver_emp_notes'];
    $formerror = [];
    if (empty($delivery_date)) {
        $formerror[] = ' من فضلك حدد وقت وتاريخ الاستلام  ';
    }
    if (empty($delivery_place)) {
        $formerror[] = ' من فضلك حدد موقع التوصيل  ';
    }
    $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date , step_name,step_status,deliver_date_time,
    delivery_place,delivery_client_note,delivery_emp_note)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zstatus,:zdtime,:zdplace,:zdclient_note,:zdemp_note)");
    $stmt->execute(array(
        "zorder_id" => $order_id,
        "zorder_number" => $order_number,
        "zusername" => $username,
        "zdate" => $date,
        "zstep_name" => 'التوصيل',
        "zstatus" => 'تتم الان عملية التوصيل',
        "zdtime" => $delivery_date,
        "zdplace" => $delivery_place,
        "zdclient_note" => $deliver_client_notes,
        "zdemp_note" => $deliver_emp_notes,
    ));
    if ($stmt) {
        // تحديث بيانات الطلب 
        $stmt = $connect->prepare("UPDATE orders SET status_value='تتم الان عملية التوصيل' WHERE id=?");
        $stmt->execute(array($order_id));
        $_SESSION['success_message'] = "  تتم الان عملية التوصيل الي العميل  ";
        header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
        exit();
    }
}
// تم استلام الطلب بنجاح 
elseif (isset($_POST['delivery_compelete_done'])) {
    $deliver_com_notes = $_POST['deliver_com_notes'];
    // product gallary 
    $file = '';
    $file_tmp = '';
    $location = "";
    $uploadplace = "delivery_compelete_images/";
    if (isset($_FILES['delivery_images']['name'])) {
        foreach ($_FILES['delivery_images']['name'] as $key => $val) {
            $file = $_FILES['delivery_images']['name'][$key];
            $file = str_replace(' ', '', $file);
            $file_tmp = $_FILES['delivery_images']['tmp_name'][$key];
            move_uploaded_file($file_tmp, $uploadplace . $file);
            $location .= $file . ",";
        }
    }
    $formerror = [];
    if ($_FILES['delivery_images']['name'] == '') {
        $formerror[] = ' من فضلك ادخل صور التسليم  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date , step_name,step_status,delivery_com_images,delivery_com_notes)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zstatus,:zcom_images,:zcom_notes)");
        $stmt->execute(array(
            "zorder_id" => $order_id,
            "zorder_number" => $order_number,
            "zusername" => $username,
            "zdate" => $date,
            "zstep_name" => 'التوصيل',
            "zstatus" => 'تمت عملية التوصيل واستلام الطلب بنجاح',
            "zcom_images" => $location,
            "zcom_notes" => $deliver_com_notes,
        ));
        if ($stmt) {
            // 1 - تحديد الموظف الخاص بالمحاسبة 
            // 2 - تسجيل خطوة المحاسبة في خطوات الطلب 
            $stmt = $connect->prepare("SELECT * FROM employes WHERE role_name='المحاسبة'");
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
                "zstep_name" => 'المحاسبة',
                "zstatus" => 'تم تسليم الطلب والان في مرحلة المحاسبة',
            ));
            // تحديث بيانات الطلب 
            $stmt = $connect->prepare("UPDATE orders SET status_value='تمت عملية التوصيل واستلام الطلب بنجاح' WHERE id=?");
            $stmt->execute(array($order_id));
            $_SESSION['success_message'] = "  تمت عملية استلام الطلب بنجاح  ";
            header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
        exit();
    }
}
// لم يتم التسليم 
elseif (isset($_POST['delivery_not_compeletee'])) {
    $deliver_not_com_reason = $_POST['deliver_not_com_reason'];
    $formerror = [];
    if (empty($deliver_not_com_reason)) {
        $formerror[] = ' من فضلك ادخل سبب عد التسليم ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date , step_name,step_status,delivery_not_com_notes)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zstatus,:zdelivery_not_com_notes)");
        $stmt->execute(array(
            "zorder_id" => $order_id,
            "zorder_number" => $order_number,
            "zusername" => $username,
            "zdate" => $date,
            "zstep_name" => 'التوصيل',
            "zstatus" => 'لم تتم عملية التسليم بنجاح',
            "zdelivery_not_com_notes" => $deliver_not_com_reason,
        ));
        if ($stmt) {
            // تحديث بيانات الطلب 
            $stmt = $connect->prepare("UPDATE orders SET status_value='لم تتم عملية التسليم بنجاح' WHERE id=?");
            $stmt->execute(array($order_id));
            $_SESSION['success_message'] = "  لم يتم عملية التسليم بنجاح ";
            header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
        exit();
    }
}
//  لا يتم الرد من العميل 
elseif (isset($_POST['not_response'])) {
    $formerror = [];

    $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date , step_name,step_status)
        VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zstatus)");
    $stmt->execute(array(
        "zorder_id" => $order_id,
        "zorder_number" => $order_number,
        "zusername" => $username,
        "zdate" => $date,
        "zstep_name" => 'التوصيل',
        "zstatus" => 'لا يتم الرد',
    ));
    if ($stmt) {
        // حساب عدد مرات عدم الرد للتحويل الي معلق 
        $stmt = $connect->prepare("SELECT * FROM order_steps WHERE order_id = ? AND step_name = 'التوصيل' AND step_status = 'لا يتم الرد' ");
        $stmt->execute(array($order_id));
        $count_not_response = $stmt->rowCount();
        if ($count_not_response >= 3) {
            $stmt = $connect->prepare("INSERT INTO order_steps (order_id , order_number, username ,date , step_name,step_status)
    VALUES (:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zstatus)");
            $stmt->execute(array(
                "zorder_id" => $order_id,
                "zorder_number" => $order_number,
                "zusername" => $username,
                "zdate" => $date,
                "zstep_name" => 'التوصيل',
                "zstatus" => 'طلب معلق بسبب عدم الرد في مرحلة التوصيل',
            ));
            // تحديث بيانات الطلب 
            $stmt = $connect->prepare("UPDATE orders SET status_value='تم تعليق الطلب بسبب عدم الرد في مرحلة التوصيل ' WHERE id=?");
            $stmt->execute(array($order_id));
            $_SESSION['success_message'] = "لا يتم الرد";
            header('Location:main.php?dir=orders&page=order_details&order_id=' . $order_id);
        } else {
            // تحديث بيانات الطلب 
            $stmt = $connect->prepare("UPDATE orders SET status_value='مرحلة التوصيل ولاكن لا يتم الرد ' WHERE id=?");
            $stmt->execute(array($order_id));
            $_SESSION['success_message'] = "لا يتم الرد";
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
                <h1 class="m-0 text-dark"> توصيل الطلب </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> مرحلة توصيل الطلب الي العميل </li>
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
                                <label for=""> اختر حالة العميل </label>
                                <select name="" id="select2" class="form-control select2">
                                    <option value="" selected disabled> -- اختر -- </option>
                                    <option value="تم التواصل"> تم التواصل لتحديد الموقع والوقت </option>
                                    <option value="تم التسليم"> تمت عملية التسليم بنجاح </option>
                                    <option value="لم يتم التسليم"> لم تتم عملية التسليم </option>
                                    <option value="لا يرد"> لا يرد </option>
                                </select>
                            </div>
                            <div id="delivery_options">
                                <div class="form-group">
                                    <label for=""> تاريخ ووقت التسليم </label>
                                    <input type="datetime-local" name="delivery_date" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label for=""> موقع التوصيل </label>
                                    <input type="text" name="delivery_place" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label for=""> ملاحظات العميل للتوصيل </label>
                                    <textarea name="deliver_client_notes" id="" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for=""> ملاحظات الموصل </label>
                                    <textarea name="deliver_emp_notes" id="" class="form-control"></textarea>
                                </div>
                            </div>
                            <div id="delivery_compelete">
                                <div class="form-group">
                                    <label for=""> صور التسليم </label>
                                    <input type="file" multiple name="delivery_images[]" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for=""> ملاحظات اخري عند التسليم </label>
                                    <textarea name="deliver_com_notes" id="" class="form-control"></textarea>
                                </div>
                            </div>
                            <div id="delivery_not_compelete">
                                <div class="form-group">
                                    <label for=""> سبب عدم الاستلام </label>
                                    <textarea name="deliver_not_com_reason" id="" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row" style="display: flex;justify-content: space-between;">
                                <button type="submit" id="contect_customer_done" class="btn btn-primary" name="contect_customer_done"> يتم التوصيل في الوقت الحالي <i class="fa fa-save"></i> </button>
                                <button type="submit" id="delivery_compelete_done" class="btn btn-primary" name="delivery_compelete_done"> تم التسليم <i class="fa fa-save"></i> </button>
                                <button type="submit" id="delivery_not_compeletee" class="btn btn-primary" name="delivery_not_compeletee"> لم تتم عملية التسليم <i class="fa fa-save"></i> </button>
                                <button type="submit" id="not_response" class="btn btn-primary" name="not_response">لا يرد<i class="fa fa-save"></i> </button>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
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
    const delivery_options = document.getElementById('delivery_options');
    const delivery_compelete = document.getElementById('delivery_compelete');
    const delivery_not_compelete = document.getElementById('delivery_not_compelete');
    // أضف حدثًا onchange إلى القائمة المنسدلة
    selectEl.onchange = function() {
        const selectedValue = selectEl.value;
        // فحص القيمة المحددة وإظهار / إخفاء الحقول الأخرى
        if (selectedValue === 'تم التواصل') {
            delivery_options.style.display = 'block';
            contect_customer_done.style.display = 'block';
        } else {
            delivery_options.style.display = 'none';
            contect_customer_done.style.display = 'none';
        }
        if (selectedValue === 'لا يرد') {
            not_response.style.display = 'block';
        } else {
            not_response.style.display = 'none';
        }
        if (selectedValue === 'تم التسليم') {
            delivery_compelete.style.display = 'block';
            delivery_compelete_done.style.display = 'block';
        } else {
            delivery_compelete.style.display = 'none';
            delivery_compelete_done.style.display = 'none';
        }
        if (selectedValue === 'لم يتم التسليم') {
            delivery_not_compelete.style.display = 'block';
            delivery_not_compeletee.style.display = 'block';
        } else {
            delivery_not_compelete.style.display = 'none';
            delivery_not_compeletee.style.display = 'none';
        }
    };
</script>
<style>
    #delivery_options {
        display: none;
    }

    #contect_customer_done {
        display: none;
    }

    #not_response {
        display: none;
    }

    #delivery_compelete {
        display: none;
    }

    #delivery_compelete_done {
        display: none;
    }

    #delivery_not_compelete {
        display: none;
    }

    #delivery_not_compeletee {
        display: none;
    }
</style>