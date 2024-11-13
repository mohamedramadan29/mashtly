<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> الطلبات الكبيرة </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <?php if (!isset($_SESSION['admin_username'])) { ?>
                        <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=emp_dashboard">الرئيسية</a></li>
                    <?php
                    } else {
                    ?>
                        <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <?php
                    } ?>
                    <li class="breadcrumb-item active"> الطبلبات الكبيرة </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <!------------------------------------------------- ///////////////////////////////// -- ------------->

                        <div class="form_new_search"
                            style="box-shadow: 0px 0px 10px 2px #ebebeb;padding: 14px;margin-bottom: 10px; border-radius: 10px;">
                            <span class="badeg badge-info" style="border-radius: 10px;font-size: 15px"> حدد الفترة الزمنية للبحث </span>
                            <br>
                            <br>
                            <form method="post" action="">
                                <div class="d-flex justify-content-around align-items-center">
                                    <div class="form-group">
                                        <label> حدد بداية الفترة </label>
                                        <input style="width: 300px;" class="form-control" required type="date"
                                            name="start_date"
                                            value="<?php if (isset($_REQUEST['start_date'])) echo $_REQUEST['start_date']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label> حدد نهاية الفترة </label>
                                        <input style="width: 300px" class="form-control" required type="date"
                                            name="end_date"
                                            value="<?php if (isset($_REQUEST['end_date'])) echo $_REQUEST['end_date']; ?>">
                                    </div>
                                    <div class="form-group">

                                        <label> حالة الطلب </label>
                                        <select name="status_value" id="" class="form-control select2">
                                            <option value=""> -- حدد حالة الطلب --</option>
                                            <option <?php if (isset($_REQUEST['status_value']) && $_REQUEST['status_value'] == '0') echo 'selected'; ?>
                                                value="0"> تحت المراجعه
                                            </option>
                                            <option <?php if (isset($_REQUEST['status_value']) && $_REQUEST['status_value'] == '1') echo 'selected'; ?>
                                                value="1"> تم التنفيذ
                                            </option>
                                        
                                        </select>
                                    </div>
                                    <div>
                                        <button style="margin-top: 25px;" name="pro_search"
                                            class="btn btn-primary btn-sm"> بحث <i
                                                class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div style="display: flex;flex-direction: column-reverse">
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> اسم الشركة </th>
                                        <th> اسم ممثل الشركة </th>
                                        <th> البريد الالكتروني </th>
                                        <th> رقم الجوال </th>
                                        <th> المدينة </th>
                                        <th> نوع الطلبية </th>
                                        <th> تاريخ الطلب </th>
                                        <th> حالة الطلب </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if (isset($_POST['pro_search'])) {
                                        $start_date = $_POST['start_date'];
                                        $end_date = date('Y-m-d', strtotime($end_date . ' +1 day'));
                                        if (isset($_POST['status_value']) && !empty($_POST['status_value'])) {
                                            $status_value = $_POST['status_value'];
                                            

                                            // استعلام لجلب الطلبات بين التاريخين مع الشرط الإضافي
                                            $stmt = $connect->prepare("SELECT * FROM big_orders WHERE  order_date BETWEEN ? AND ? AND status = ?");
                                            $stmt->execute(array($start_date, $end_date, $status_value));
                                        } else {
                                            // استعلام لجلب الطلبات بين التاريخين بدون الشرط الإضافي
                                            $stmt = $connect->prepare("SELECT * FROM big_orders WHERE  order_date BETWEEN ? AND ?");
                                            $stmt->execute(array($start_date, $end_date));
                                        }
                                        // جلب جميع النتائج
                                        $allorders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        $count_orders = $stmt->rowCount();
                                    } else {
                                        $stmt = $connect->prepare("SELECT * FROM big_orders ORDER By id DESC");
                                        $stmt->execute();
                                        $allorders = $stmt->fetchAll();
                                        $count_orders = $stmt->rowCount();
                                        $i = 0;
                                    }
                                    if (isset($_SESSION['admin_username'])) {

                                        foreach ($allorders as $order) {
 
                                            $i++;
                                    ?>
                                            <tr>
                                                <td> <?php echo $i; ?> </td>
                                                <td> <?php echo  $order['company_name']; ?> </td>
                                                <td> <?php echo  $order['company_person_name']; ?> </td>
                                                <td> <?php echo  $order['email']; ?> </td>
                                                <td> <?php echo  $order['phone']; ?> </td>
                                                <td> <?php echo  $order['city']; ?> </td>
                                                <td> <?php echo  $order['request_type']; ?> </td>
                                                <td> <?php echo  $order['order_date']; ?> </td>
                                                <td> <span class="badge badge-info">
                                                        <?php
                                                        if ($order['status'] == 0) {
                                                            echo "تحت المراجعه";
                                                        } else {
                                                            echo "تم التنفيذ";
                                                        } ?> </span>
                                                </td>
                                                <td>
                                                    <a href="main.php?dir=big_orders&page=edit&order_id=<?php echo $order['id']; ?>" class="btn btn-success btn-sm"> تفاصيل الطلب <i class='fa fa-pen'></i> </a>
                                                    <a href="main.php?dir=big_orders&page=delete&order_id=<?php echo $order['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                            </table>
                            <table class="table table-bordered" dir='rtl'>
                                <tbody>
                                    <tr>
                                        <th>عدد الطلبات ::</th>
                                        <td>
                                            <span class="badge badge-success"> <?php echo $count_orders; ?> طلب </span>
                                        </td>
                                    </tr>
                        
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>