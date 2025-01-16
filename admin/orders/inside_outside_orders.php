<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> تقرير الطلبات الخارجية والداخلية </h1>
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

                    <li class="breadcrumb-item active"> تقرير الطلبات الخارجية والداخلية </li>
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

                        <div class="form_new_search" style="padding: 14px;margin-bottom: 10px;">
                            <span class="badeg badge-info" style="font-size: 15px"> حدد الفترة
                                الزمنية للبحث </span>
                            <br>
                            <br>
                            <form method="post" action="">
                                <div class="d-flex justify-content-around align-items-center">
                                    <div class="form-group">
                                        <label> حدد بداية الفترة </label>
                                        <input style="width: 300px;" class="form-control" required type="date"
                                            name="start_date" value="<?php if (isset($_REQUEST['start_date']))
                                                echo $_REQUEST['start_date']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label> حدد نهاية الفترة </label>
                                        <input style="width: 300px" class="form-control" required type="date"
                                            name="end_date" value="<?php if (isset($_REQUEST['end_date']))
                                                echo $_REQUEST['end_date']; ?>">
                                    </div>
                                    <div class="form-group">

                                        <label> حالة الطلب </label>
                                        <select name="status_value" id="" class="form-control select2">
                                            <option value=""> -- حدد حالة الطلب --</option>
                                            <option <?php if (isset($_REQUEST['status_value']) && $_REQUEST['status_value'] == 'لم يبدا ')
                                                echo 'selected'; ?>
                                                value="لم يبدا "> لم يبدا
                                            </option>
                                            <option <?php if (isset($_REQUEST['status_value']) && $_REQUEST['status_value'] == 'ملغي')
                                                echo 'selected'; ?>
                                                value="ملغي">ملغي
                                            </option>
                                            <option <?php if (isset($_REQUEST['status_value']) && $_REQUEST['status_value'] == 'مكتمل')
                                                echo 'selected'; ?>
                                                value="مكتمل">مكتمل
                                            </option>
                                            <option <?php if (isset($_REQUEST['status_value']) && $_REQUEST['status_value'] == 'قيد الانتظار')
                                                echo 'selected'; ?>
                                                value="قيد الانتظار">قيد الانتظار
                                            </option>
                                        </select>
                                    </div>
                                    <div>
                                        <button style="margin-top: 25px;" name="pro_search"
                                            class="btn btn-primary btn-sm"> بحث <i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <?php
                            if (isset($_POST['pro_search'])) {
                                $start_date = $_POST['start_date'];
                                $end_date = $_POST['end_date'];
                                // $status_value = $_POST['status_value'];
                                // تحويل التواريخ إلى تنسيق 'Y-m-d H:i:s'
                                $start_date_formatted = date('Y-m-d H:i:s', strtotime($start_date));
                                // $end_date_formatted = date('Y-m-d H:i:s', strtotime($end_date));
                                $end_date_formatted = date('Y-m-d H:i:s', strtotime($end_date . ' +1 day'));

                                if (isset($_POST['status_value']) && !empty($_POST['status_value'])) {
                                    $status_value = $_POST['status_value'];
                                    // استعلام لجلب الطلبات بين التاريخين مع الشرط الإضافي
                                    $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value !='pending' AND  STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p') BETWEEN STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND status_value = ?");
                                    $stmt->execute(array($start_date_formatted, $end_date_formatted, $status_value));
                                    #################### Get Out Side Orders ##########################################
                                    $stmt_outside = $connect->prepare("SELECT * FROM outside_orders WHERE STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p') BETWEEN STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND status_value = ?");
                                    $stmt_outside->execute(array($start_date_formatted, $end_date_formatted, $status_value));
                                } else {
                                    // استعلام لجلب الطلبات بين التاريخين بدون الشرط الإضافي
                                    $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value !='pending' AND  STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p') BETWEEN STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s')");
                                    $stmt->execute(array($start_date_formatted, $end_date_formatted));
                                    ############################### Start Get OutSide #############################
                                    $stmt_outside = $connect->prepare("SELECT * FROM outside_orders WHERE STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p') BETWEEN STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s')");
                                    $stmt_outside->execute(array($start_date_formatted, $end_date_formatted));
                                }
                                // جلب جميع النتائج
                                $allorders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $count_orders = $stmt->rowCount();
                                ######### Get All Out Side Orders 
                                $allorders_outside = $stmt_outside->fetchAll(PDO::FETCH_ASSOC);
                                $count_orders_outside = $stmt_outside->rowCount();
                            } else {
                                $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value !='pending' AND archieve = 0  ORDER By id DESC");
                                $stmt->execute();
                                $allorders = $stmt->fetchAll();
                                $count_orders = $stmt->rowCount();
                                ########################## Get Out Side Orders 
                                $stmt_outside = $connect->prepare("SELECT * FROM outside_orders WHERE archieve = 0 ORDER By id DESC");
                                $stmt_outside->execute();
                                $allorders_outside = $stmt_outside->fetchAll();
                                $count_orders_outside = $stmt_outside->rowCount();
                            }
                            ?>
                            <div>
                                <?php
                                $total_price = 0;
                                $total_shipping = 0;
                                $total_farming = 0;
                                $total_price_outside = 0;
                                $total_shipping_outside = 0;
                                $total_farming_outside = 0;

                                foreach ($allorders as $order) {

                                    $total_price += floatval($order['total_price']);
                                    $total_shipping += floatval($order['ship_price']);
                                    $total_farming += floatval($order['farm_service_price']);
                                
                                }
                                ################## OutSide Orders #################
                                foreach ($allorders_outside as $order_outside) {
                                    $total_price_outside += floatval($order_outside['total_price']);
                                    $total_shipping_outside += floatval($order_outside['ship_price']);
                                    $total_farming_outside += floatval($order_outside['farm_service_price']);
                                }
                                ?>
                                    <h6>  المجموع الكلي  </h6>
                                <table class="table table-bordered" dir='rtl'>
                                    <tbody>
                                        <tr>
                                            <th>عدد الطلبات ::</th>
                                            <td>
                                                <span class="badge badge-success">
                                                    <?php echo $count_orders + $count_orders_outside ; ?> طلب
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>مجموع الطلبات الكلي ::</th>
                                            <td><span class="badge badge-info">
                                                    <?php echo $total_price + $total_price_outside; ?> ريال
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> مجموع الشحن الكلي ::</th>
                                            <td>
                                                <span class="badge badge-primary">
                                                    <?php echo $total_shipping + $total_shipping_outside; ?> ريال
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> مجموع الاضافات الكلي ::</th>
                                            <td>
                                                <span class="badge badge-warning">
                                                    <?php echo $total_farming + $total_farming_outside; ?> ريال
                                                </span>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <hr>
                                <h6> الطلبات الداخلية  </h6>
                                <table class="table table-bordered" dir='rtl'>
                                    <tbody>
                                        <tr>
                                            <th>عدد الطلبات ::</th>
                                            <td>
                                                <span class="badge badge-success">
                                                    <?php echo $count_orders; ?> طلب
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>مجموع الطلبات الكلي ::</th>
                                            <td><span class="badge badge-info">
                                                    <?php echo $total_price; ?> ريال
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> مجموع الشحن الكلي ::</th>
                                            <td>
                                                <span class="badge badge-primary">
                                                    <?php echo $total_shipping; ?> ريال
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> مجموع الاضافات الكلي ::</th>
                                            <td>
                                                <span class="badge badge-warning">
                                                    <?php echo $total_farming; ?> ريال
                                                </span>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
<hr>
                                <!---------------------------------- Out Side Orders ---------------->
                                <h6>  الطلبات الخارجية  </h6>
                                <table class="table table-bordered" dir='rtl'>
                                    <tbody>
                                        <tr>
                                            <th>عدد الطلبات ::</th>
                                            <td>
                                                <span class="badge badge-success">
                                                    <?php echo $count_orders_outside; ?> طلب
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>مجموع الطلبات الكلي ::</th>
                                            <td><span class="badge badge-info">
                                                    <?php echo $total_price_outside; ?> ريال
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> مجموع الشحن الكلي ::</th>
                                            <td>
                                                <span class="badge badge-primary">
                                                    <?php echo $total_shipping_outside; ?> ريال
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> مجموع الاضافات الكلي ::</th>
                                            <td>
                                                <span class="badge badge-warning">
                                                    <?php echo $total_farming_outside; ?> ريال
                                                </span>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>


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