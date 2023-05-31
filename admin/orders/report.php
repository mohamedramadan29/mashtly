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
                        <div class="table-responsive">
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> رقم الطلب </th>
                                        <th> اسم العميل </th>
                                        <th> المدينة </th>
                                        <th> البريد الالكتروني </th>
                                        <th> تاريخ الطلب </th>
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
                                                <td> <span class="badge badge-info"> <?php echo  $order['status_value']; ?> </span>
                                                    <?php
                                                    $stmt = $connect->prepare("SELECT * FROM order_steps WHERE order_id = ? ORDER BY id DESC LIMIT 1");
                                                    $stmt->execute(array($order['id']));
                                                    $order_step = $stmt->fetch();
                                                    $count = $stmt->rowCount();
                                                    if ($count > 0) { ?>
                                                        <span class="badge badge-info"> <?php echo $order_step['date']; ?> </span>

                                                    <?php
                                                    }

                                                    ?>
                                                </td>
                                                <td> <?php echo  $order['total_price']; ?> </td>
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