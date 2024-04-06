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
                        <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=emp_dashboard">الرئيسية</a></li>
                    <?php
                    } else {
                    ?>
                        <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <?php
                    } ?>

                    <li class="breadcrumb-item active"> جميع الطلبات </li>
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
                            <a href="main.php?dir=orders&page=add" class="btn btn-primary waves-effect btn-sm"> أضافة طلب جديد <i class="fa fa-plus"></i> </a>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="card-body">
                        <div class="form_new_search">
                            <form method="post" action="">
                                <div class="d-flex justify-content-center align-items-center flex-wrap">
                                    <div class="form-group">
                                        <select required id="" class="form-control custom-select select2" name="order_month">
                                            <option value=""> -- حدد الشهر --</option>
                                            <option value="1"> 1 </option>
                                            <option value="2"> 2 </option>
                                            <option value="3"> 3 </option>
                                            <option value="4"> 4 </option>
                                            <option value="5"> 5 </option>
                                            <option value="6"> 6 </option>
                                            <option value="7"> 7 </option>
                                            <option value="8"> 8 </option>
                                            <option value="9"> 9 </option>
                                            <option value="10"> 10 </option>
                                            <option value="11"> 11 </option>
                                            <option value="12"> 12 </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select required id="" class="form-control custom-select select2" name="order_year">
                                            <option value=""> -- حدد السنة --</option>
                                            <option value="2023"> 2023 </option>
                                            <option value="2024"> 2024 </option>
                                            <option value="2025"> 2025 </option>
                                            <option value="2026"> 2026 </option>
                                            <option value="2027"> 2027 </option>
                                        </select>
                                    </div>
                                    <div>
                                        <button name="search" class="btn btn-dark btn-sm"> بحث <i class="fa fa-search"></i> </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <?php
                            if (isset($_POST['search'])) {
                                $order_month = $_POST['order_month'];
                                $order_year = $_POST['order_year'];
                                // echo $order_month;
                                // echo "</br>";
                                // echo $order_year;
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
                                            <th> # </th>
                                            <th> رقم الطلب </th>
                                            <th> اسم العميل </th>
                                            <th> البريد الالكتروني </th>
                                            <th> تاريخ الطلب </th>
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
                                                <td> <?php echo  $order['order_number']; ?> </td>
                                                <td> <?php echo  $order['name']; ?> </td>
                                                <td> <?php echo  $order['email']; ?> </td>
                                                <td> <?php echo  $order['order_date']; ?> </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                </table>
                                <?php

                                ?>

                            <?php
                            } else {
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
                                            <th> السعر الكلي </th>
                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_SESSION['admin_username'])) {
                                            $stmt = $connect->prepare("SELECT * FROM orders WHERE archieve = 0 ORDER By id DESC");
                                            $stmt->execute();
                                            $allorders = $stmt->fetchAll();
                                            $i = 0;
                                            foreach ($allorders as $order) {
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

                                                        <span class="badge badge-danger"> <?php echo  $order['payment_method']; ?> </span>
                                                    </td>
                                                    <td> <span class="badge badge-info"> <?php echo  $order['status_value']; ?> </span>
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
                                                    <td> <?php echo  $order['total_price']; ?> ر.س </td>
                                                    <td>
                                                        <a href="main.php?dir=orders&page=order_details&order_id=<?php echo $order['id']; ?>" class="btn btn-success waves-effect btn-sm"> تفاصيل الطلب <i class='fa fa-eye'></i></a>
                                                        <?php
                                                        if (isset($_SESSION['admin_username'])) {
                                                        ?>
                                                            <a href="main.php?dir=orders&page=delete&order_id=<?php echo $order['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
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
                                                    <td> <?php echo  $order['order_number']; ?> </td>
                                                    <td> <?php echo  $order['name']; ?> </td>
                                                    <td> <?php echo  $order['city']; ?> </td>
                                                    <td> <?php echo  $order['email']; ?> </td>
                                                    <td> <?php echo  $order['order_date']; ?> </td>
                                                    <td> <span class="badge badge-info"> <?php echo  $order['status_value']; ?> </span> </td>
                                                    <td> <?php echo  $order['total_price']; ?> </td>
                                                    <td>
                                                        <a href="main.php?dir=orders&page=order_details&order_id=<?php echo $order['id']; ?>" class="btn btn-success btn-sm"> تفاصيل الطلب <i class='fa fa-eye'></i></a>
                                                        <?php
                                                        if (isset($_SESSION['admin_username'])) {
                                                        ?>
                                                            <a href="main.php?dir=orders&page=delete&order_id=<?php echo $order['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                            //   }
                                            // $stmt = $connect->prepare("SELECT * FROM orders WHERE id = ?");
                                        } else {
                                            $allorders = 0;
                                        }

                                        ?>
                                </table>
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