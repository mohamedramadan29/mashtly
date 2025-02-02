<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> الطلبات </h1>
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

                    <li class="breadcrumb-item active"> جميع الطلبات</li>
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
                        <?php
                        if (isset($_SESSION['admin_username'])) { ?>
                            <a href="main.php?dir=orders&page=add" class="btn btn-primary waves-effect btn-sm"> أضافة
                                طلب جديد <i class="fa fa-plus"></i> </a>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION['admin_username'])) {
                        ?>
                            <div class="form_new_search"
                                style="box-shadow: 0px 0px 10px 2px #ebebeb;padding: 14px;margin-bottom: 10px; border-radius: 10px;">
                                <span class="badeg badge-info" style="border-radius: 10px;font-size: 15px"> استخراج تقرير ايميلات الشهر </span>
                                <br>
                                <br>
                                <form method="post" action="">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="form-group" style="width: 40%">
                                            <select required id="" class="form-control custom-select select2"
                                                name="order_month">
                                                <option value=""> -- حدد الشهر --</option>
                                                <option value="1"> 1</option>
                                                <option value="2"> 2</option>
                                                <option value="3"> 3</option>
                                                <option value="4"> 4</option>
                                                <option value="5"> 5</option>
                                                <option value="6"> 6</option>
                                                <option value="7"> 7</option>
                                                <option value="8"> 8</option>
                                                <option value="9"> 9</option>
                                                <option value="10"> 10</option>
                                                <option value="11"> 11</option>
                                                <option value="12"> 12</option>
                                            </select>
                                        </div>
                                        <div class="form-group" style="width: 40%">
                                            <select required id="" class="form-control custom-select select2"
                                                name="order_year">
                                                <option value=""> -- حدد السنة --</option>
                                                <option value="2023"> 2023</option>
                                                <option value="2024"> 2024</option>
                                                <option value="2025"> 2025</option>
                                                <option value="2026"> 2026</option>
                                                <option value="2027"> 2027</option>
                                            </select>
                                        </div>
                                        <div style="width: 10%">
                                            <button name="search" class="btn btn-dark btn-sm"> بحث <i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php
                        }
                        ?>


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
                                            <option <?php if (isset($_REQUEST['status_value']) && $_REQUEST['status_value'] == 'لم يبدا ') echo 'selected'; ?>
                                                value="لم يبدا "> لم يبدا
                                            </option>
                                            <option <?php if (isset($_REQUEST['status_value']) && $_REQUEST['status_value'] == 'ملغي') echo 'selected'; ?>
                                                value="ملغي">ملغي
                                            </option>
                                            <option <?php if (isset($_REQUEST['status_value']) && $_REQUEST['status_value'] == 'مكتمل') echo 'selected'; ?>
                                                value="مكتمل">مكتمل
                                            </option>
                                            <option <?php if (isset($_REQUEST['status_value']) && $_REQUEST['status_value'] == 'قيد الانتظار') echo 'selected'; ?>
                                                value="قيد الانتظار">قيد الانتظار
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
                            ?>
                                <table id="my_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th> #</th>
                                            <th> رقم الطلب</th>
                                            <th> اسم العميل</th>
                                            <th> البريد الالكتروني</th>
                                            <th> تاريخ الطلب</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($allorders as $order) {
                                            $i++;
                                        ?>
                                            <tr>
                                                <td> <?php echo $i; ?> </td>
                                                <td> <?php echo $order['order_number']; ?> </td>
                                                <td> <?php echo $order['name']; ?> </td>
                                                <td> <?php echo $order['email']; ?> </td>
                                                <td> <?php echo $order['order_date']; ?> </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                </table>


                            <?php
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
                                        $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value !='pending' AND  STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p') BETWEEN STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND status_value = ?");
                                        $stmt->execute(array($start_date_formatted, $end_date_formatted, $status_value));
                                    } else {
                                        // استعلام لجلب الطلبات بين التاريخين بدون الشرط الإضافي
                                        $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value !='pending' AND  STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p') BETWEEN STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s')");
                                        $stmt->execute(array($start_date_formatted, $end_date_formatted));
                                    }
                                    // جلب جميع النتائج
                                    $allorders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    $count_orders = $stmt->rowCount();
                                } else {
                                    $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value !='pending' AND archieve = 0  ORDER By id DESC");
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
                                                        <td> <?php echo number_format($order['total_price'],2); ?>   ر.س</td>
                                                        <td> <?php echo $order['shipping_problem']; ?> </td>
                                                        <?php
                                                        if (isset($_SESSION['admin_username'])) {
                                                        ?>
                                                            <td>
                                                                <a href="main.php?dir=orders&page=order_details&order_id=<?php echo $order['id']; ?>"
                                                                    class="btn btn-success waves-effect btn-sm"> تفاصيل الطلب <i
                                                                        class='fa fa-eye'></i></a>
                                                                <?php
                                                                if (isset($_SESSION['admin_username'])) {
                                                                ?>
                                                                    <a href="main.php?dir=orders&page=edit_order&order_id=<?php echo $order['id']; ?>"
                                                                        class="btn btn-primary waves-effect btn-sm"> <i
                                                                            class='fa fa-edit'></i></a>

                                                                    <a href="main.php?dir=orders&page=delete&order_id=<?php echo $order['id']; ?>"
                                                                        class="confirm btn btn-danger btn-sm"> حذف <i
                                                                            class='fa fa-trash'></i> </a>
                                                                <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php
                                                }
                                            } elseif (isset($_SESSION['username'])) {

                                                $stmt = $connect->prepare("SELECT DISTINCT o.id, o.order_number, o.order_date, o.status_value, o.address, o.total_price,o.name,o.city,o.email 
                                        FROM orders o 
                                        INNER JOIN order_steps os ON o.id = os.order_id 
                                        WHERE os.username = ? 
                                        ORDER BY o.id DESC");
                                                $stmt->execute(array($_SESSION['id']));
                                                $allorders = $stmt->fetchAll();
                                                $count = count($allorders);
                                                $i = 0;
                                                foreach ($allorders as $order) {
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
                                                            <span class="badge badge-info"> <?php echo $order['status_value']; ?> </span>
                                                        </td>
                                                        <td> <?php echo $order['total_price']; ?> </td>
                                                        <?php
                                                        if (isset($_SESSION['admin_username'])) {
                                                        ?>
                                                            <td>
                                                                <a href="main.php?dir=orders&page=order_details&order_id=<?php echo $order['id']; ?>"
                                                                    class="btn btn-success btn-sm"> تفاصيل الطلب <i
                                                                        class='fa fa-eye'></i></a>
                                                                <?php
                                                                if (isset($_SESSION['admin_username'])) {
                                                                ?>
                                                                    <a href="main.php?dir=orders&page=delete&order_id=<?php echo $order['id']; ?>"
                                                                        class="confirm btn btn-danger btn-sm"> حذف <i
                                                                            class='fa fa-trash'></i> </a>
                                                                <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        <?php
                                                        }
                                                        ?>

                                                    </tr>
                                            <?php
                                                }
                                                //   }
                                                // $stmt = $connect->prepare("SELECT * FROM orders WHERE id = ?");
                                            } else {
                                                $allorders = 0;
                                            }

                                            ?>
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered" dir='rtl'>
                                        <tbody>
                                            <tr>
                                                <th>عدد الطلبات ::</th>
                                                <td>
                                                    <span class="badge badge-success"> <?php echo $count_orders; ?> طلب </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>مجموع الطلبات الكلي ::</th>
                                                <td><span class="badge badge-info"> <?php echo $total_price; ?> ريال </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th> مجموع الشحن الكلي ::</th>
                                                <td>
                                                    <span class="badge badge-primary"> <?php echo $total_shipping; ?> ريال </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th> مجموع الاضافات الكلي ::</th>
                                                <td>
                                                    <span class="badge badge-warning"> <?php echo $total_farming; ?> ريال </span>
                                                </td>
                                            </tr>
                                            <!--                                        <tr>-->
                                            <!--                                            <th> صافي الربح :: </th>-->
                                            <!--                                            --><?php
                                                                                                //                                            $total_earning = $total_price - ($total_shipping + $total_farming);
                                                                                                //
                                                                                                //                                            
                                                                                                ?>
                                            <!--                                            <th> <span class="badge badge-danger"> <strong> -->
                                            <?php //echo $total_earning; 
                                            ?><!-- ريال </strong> </span> </th>-->
                                            <!--                                        </tr>-->
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