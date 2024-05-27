<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> احصائيات الطلبات المكتملة </h1>
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

                    <li class="breadcrumb-item active"> الطلبات المكتملة </li>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="form_new_search">
                            <form method="post" action="">
                                <div class="d-flex justify-content-around align-items-center">
                                    <div class="form-group">
                                        <label> حدد بداية الفترة </label>
                                        <input style="width: 300px;" class="form-control" type="date" name="start_date" value="<?php if (isset($_REQUEST['start_date'])) echo $_REQUEST['start_date']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label> حدد نهاية الفترة </label>
                                        <input style="width: 300px" class="form-control" type="date" name="end_date" value="<?php if (isset($_REQUEST['end_date'])) echo $_REQUEST['end_date']; ?>">
                                    </div>
                                    <div>
                                        <button style="margin-top: 25px;" name="search" class="btn btn-primary"> بحث <i class="fa fa-search"></i> </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <?php
                            if (isset($_POST['search'])) {
                                $start_date = $_POST['start_date'];
                                $end_date = $_POST['end_date'];

                                // تحويل التواريخ إلى تنسيق 'Y-m-d H:i:s'
                                $start_date_formatted = date('Y-m-d H:i:s', strtotime($start_date));
                                $end_date_formatted = date('Y-m-d H:i:s', strtotime($end_date));

                                // echo "تاريخ البداية: " . $start_date_formatted . "<br>";
                                // echo "تاريخ النهاية: " . $end_date_formatted . "<br>";

                                // استعلام لجلب الطلبات بين التاريخين
                                $stmt = $connect->prepare("SELECT * FROM orders WHERE STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p') BETWEEN STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND status_value = 'مكتمل'");
                                $stmt->execute(array($start_date_formatted, $end_date_formatted));
                                // جلب جميع النتائج
                                $allorders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $count_orders = $stmt->rowCount();
                            }else{
                                $stmt = $connect->prepare("SELECT * FROM orders WHERE archieve = 0 AND status_value = 'مكتمل' ORDER By id DESC");
                                $stmt->execute();
                                $allorders = $stmt->fetchAll();
                                $count_orders = $stmt->rowCount();
                            }
                            ?>
                                <table id="my_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> رقم الطلب </th>
                                            <th> اسم العميل </th>
                                            <th> المدينة </th>
                                            <th> البريد الالكتروني </th>
                                            <th> تاريخ الطلب </th>
                                            <th> طريقة الدفع </th>
                                            <th> حالة الطلب </th>
                                            <th> خصم </th>
                                            <th> السعر الكلي </th>
                                            <th> مشاكل شحن </th>
                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $total_price = 0;
                                        $total_shipping = 0;
                                        $total_farming = 0;
                                        foreach ($allorders as $order) {
                                            $total_price = $total_price + $order['total_price'];
                                            $total_shipping = $total_shipping + $order['ship_price'];
                                            $total_farming = $total_farming + $order['farm_service_price'];
                                            $i++;
                                        ?>
                                            <tr>
                                                <td> <?php echo $i; ?> </td>
                                                <td> <?php echo  $order['order_number']; ?> </td>
                                                <td> <?php echo  $order['name']; ?> </td>
                                                <td> <?php echo  $order['city']; ?> </td>
                                                <td> <?php echo  $order['email']; ?> </td>
                                                <td> <?php echo  $order['order_date']; ?> </td>
                                                <td>
                                                    <?php
                                                    if ($order['payment_method'] == 'الدفع الالكتروني') {
                                                    ?>
                                                        <span class="badge badge-primary"> الدفع الالكتروني </span>
                                                        <?php
                                                        if ($order['payment_status'] == 0) {
                                                        ?>
                                                            <span class="badge badge-danger"> لم يتم الدفع الالكتروني بشكل صحيح </span>
                                                        <?php
                                                        }
                                                        ?>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="badge badge-success"> الدفع عن الاستلام </span>
                                                    <?php

                                                    }

                                                    ?>

                                                </td>
                                                <td> <?php
                                                        if ($order['status_value'] == 'لم يبدا ') {
                                                        ?>
                                                        <span class="badge badge-info"> لم يبدا </span>
                                                    <?php
                                                        } elseif ($order['status_value'] == 'ملغي') {
                                                    ?>
                                                        <span class="badge badge-danger"> ملغي </span>
                                                    <?php

                                                        } elseif ($order['status_value'] == 'مكتمل') {
                                                    ?>
                                                        <span class="badge badge-success"> مكتمل </span>
                                                    <?php
                                                        } elseif ($order['status_value'] == 'قيد الانتظار') {
                                                    ?>
                                                        <span class="badge badge-warning"> قيد الانتظار </span>
                                                    <?php
                                                        } else {
                                                    ?>
                                                        <span class="badge badge-primary"> <?php echo  $order['status_value']; ?> </span>
                                                    <?php
                                                        } ?>
                                                    <?php
                                                    $stmt = $connect->prepare("SELECT * FROM order_statuses WHERE order_id = ? ORDER BY id DESC LIMIT 1");
                                                    $stmt->execute(array($order['id']));
                                                    $order_step = $stmt->fetch();
                                                    $count = $stmt->rowCount();
                                                    if ($count > 0) { ?>
                                                        <span class="badge badge-info"> <?php echo $order_step['change_date']; ?> </span>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($order['coupon_code'] != '') {
                                                    ?>
                                                        <span class="badge badge-info"><?php echo $order['discount_value']; ?> ر.س </span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="badge badge-danger"> لا يوجد خصم </span>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td> <?php echo  $order['total_price']; ?> ر.س </td>
                                                <td> <?php echo $order['shipping_problem']; ?> </td>
                                                <td>
                                                    <a href="main.php?dir=orders&page=order_details&order_id=<?php echo $order['id']; ?>" class="btn btn-success waves-effect btn-sm"> تفاصيل الطلب <i class='fa fa-eye'></i></a>
                                                    <?php
                                                    if (isset($_SESSION['admin_username'])) {
                                                    ?>
                                                        <a href="main.php?dir=orders&page=edit_order&order_id=<?php echo $order['id']; ?>" class="btn btn-primary waves-effect btn-sm"> <i class='fa fa-edit'></i></a>

                                                        <a href="main.php?dir=orders&page=delete&order_id=<?php echo $order['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                </table>
                                <table class="table table-bordered" dir='rtl'>
                                    <tbody>
                                        <tr>
                                            <th> مجموع الطلبات :: </th>
                                            <td> <span class="badge badge-success"> <?php echo $count_orders; ?> طلب </span></td>
                                        </tr>
                                        <tr>
                                            <th> سعر الطلبات الكلي :: </th>
                                            <td> <span class="badge badge-info"> <?php echo $total_price; ?> ريال </span> </td>
                                        </tr>
                                        <tr>
                                            <th> سعر الشحن الكلي :: </th>
                                            <td> <span class="badge badge-primary"> <?php echo $total_shipping; ?> ريال </span> </td>
                                        </tr>
                                        <tr>
                                            <th> سعر الاضافات الكلي :: </th>
                                            <td> <span class="badge badge-warning"> <?php echo $total_farming; ?> ريال </span> </td>
                                        </tr>
                                        <tr>
                                            <th> صافي الربح :: </th>
                                            <?php
                                            $total_earning = $total_price - ($total_shipping + $total_farming);

                                            ?>
                                            <th> <span class="badge badge-danger"> <strong> <?php echo $total_earning; ?> ريال </strong> </span> </th>

                                        </tr>
                                    </tbody>
                                </table>
                                <?php

                                ?>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>