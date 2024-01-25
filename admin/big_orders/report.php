<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> الطبلبات الكبيرة </h1>
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
                        <div class="table-responsive">
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
                                    if (isset($_SESSION['admin_username'])) {
                                        $stmt = $connect->prepare("SELECT * FROM big_orders ORDER By id DESC");
                                        $stmt->execute();
                                        $allorders = $stmt->fetchAll();
                                        $i = 0;
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>