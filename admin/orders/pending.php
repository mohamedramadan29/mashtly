<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> طلبات لم يكتمل فيها الدفع  </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <?php if (!isset($_SESSION['admin_username'])) { ?>
                        <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=emp_dashboard">الرئيسية</a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <?php
                    } ?>

                    <li class="breadcrumb-item active"> طلبات لم يكتمل فيها الدفع  </li>
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
                     
                    <div class="card-body">
                        

                        <!------------------------------------------------- ///////////////////////////////// -- ------------->
                        <div class="table-responsive">
                            <?php
                            if (isset($_POST['search'])) {
                                $order_month = $_POST['order_month'];
                                $order_year = $_POST['order_year'];
                                // تحويل التواريخ إلى تنسيق قابل للمقارنة
                                $search_date = date('Y-m-d', strtotime("$order_year-$order_month-01"));
                                //echo $search_date;
                                // استعلام SQL
                                $stmt = $connect->prepare("SELECT * FROM orders WHERE MONTH(STR_TO_DATE(order_date, '%c/%e/%Y %l:%i %p')) = ?");
                                $stmt->execute([$order_month]);
                                $allorders = $stmt->fetchAll();
                                $count = $stmt->rowCount();
                                //echo $count;
                                // echo $order['order_date'];
                         
                            } else {

                                if (isset($_POST['pro_search'])) {
                                    $start_date = $_POST['start_date'];
                                    $end_date = $_POST['end_date'];
                                    // $status_value = $_POST['status_value'];

                                    // تحويل التواريخ إلى تنسيق 'Y-m-d H:i:s'
                                    $start_date_formatted = date('Y-m-d H:i:s', strtotime($start_date));
                                   // $end_date_formatted = date('Y-m-d H:i:s', strtotime($end_date));
                                    $end_date_formatted = date('Y-m-d H:i:s', strtotime($end_date . ' +1 day'));

                                    // echo "تاريخ البداية: " . $start_date_formatted . "<br>";
                                    // echo "تاريخ النهاية: " . $end_date_formatted . "<br>";

                                    // استعلام لجلب الطلبات بين التاريخين
                                    // التحقق مما إذا كانت قيمة 'status_value' موجودة
                                    if (isset($_POST['status_value']) && !empty($_POST['status_value'])) {
                                        $status_value = $_POST['status_value'];

                                        // استعلام لجلب الطلبات بين التاريخين مع الشرط الإضافي
                                        $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value ='pending' AND  STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p') BETWEEN STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND status_value = ?");
                                        $stmt->execute(array($start_date_formatted, $end_date_formatted, $status_value));
                                    } else {
                                        // استعلام لجلب الطلبات بين التاريخين بدون الشرط الإضافي
                                        $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value ='pending' AND  STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p') BETWEEN STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s')");
                                        $stmt->execute(array($start_date_formatted, $end_date_formatted));
                                    }
                                    // جلب جميع النتائج
                                    $allorders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    $count_orders = $stmt->rowCount();
                                } else {
                                    $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value ='pending' AND archieve = 0  ORDER By id DESC");
                                    $stmt->execute();
                                    $allorders = $stmt->fetchAll();
                                    $count_orders = $stmt->rowCount();
                                }
                            ?>
                                <div style="display: flex;flex-direction: column-reverse">
                                    <table id="my_table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th> #</th>
                                                <th> رقم الطلب</th>
                                                <th> اسم العميل</th>
                                                <th> المدينة</th>
                                                <th> البريد الالكتروني</th>
                                                <th> تاريخ الطلب</th>
                                                <th> طريقة الدفع</th>
                                                <th> حالة الطلب</th>
                                                <th> خصم</th>
                                                <th> الهدية  </th>
                                                <th> السعر الكلي</th>
                                                <th> مشاكل شحن</th>
                                                <?php
                                                if (isset($_SESSION['admin_username'])) {
                                                ?>
                                                    <th></th>
                                                <?php
                                                }
                                                ?>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_SESSION['admin_username']) || $_SESSION['marketer']) {

                                                $i = 0;
                                                $total_price = 0;
                                                $total_shipping = 0;
                                                $total_farming = 0;
                                                foreach ($allorders as $order) {

                                                    $total_price += floatval($order['total_price']);
                                                    $total_shipping += floatval($order['ship_price']);
                                                    $total_farming += floatval($order['farm_service_price']);

                                                    $i++;
                                            ?>
                                                    <tr>
                                                        <td> <?php echo $i; ?> </td>
                                                        <td> <?php echo $order['order_number']; ?> </td>
                                                        <td> <?php echo $order['name']; ?> </td>
                                                        <td> <?php echo $order['city']; ?> </td>
                                                        <td> <?php echo $order['email']; ?> </td>
                                                        <td> <?php echo $order['order_date']; ?> </td>
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
                                                                <span class="badge badge-primary"> <?php echo $order['status_value']; ?> </span>
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
                                                        <td>
                                                            <?php 
                                                            if($order['present_id'] != null){
                                                            ?>
                                                            <span class="badge badge-info"> <?php echo $order['present_id']; ?> </span>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td> <?php echo $order['total_price']; ?> ر.س</td>
                                                        <td> <?php echo $order['shipping_problem']; ?> </td>
                                                        <?php
                                                        if (isset($_SESSION['admin_username'])) {
                                                        ?>
                                                            <td>
                                                                <a href="main.php?dir=orders&page=order_details&order_id=<?php echo $order['id']; ?>"
                                                                    class="btn btn-success waves-effect btn-sm"> تفاصيل الطلب <i
                                                                        class='fa fa-eye'></i></a>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php
                                                }
                                            } elseif (isset($_SESSION['username'])) {
 
                                            } else {
                                                $allorders = 0;
                                            }

                                            ?>
                                        </tbody>
                                    </table> 
                                </div>
                            <?php
                            }
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