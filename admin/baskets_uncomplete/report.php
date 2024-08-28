<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> السلات المتروكة </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> السلات المتروكة </li>

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
                        <span class="badge badge-danger"> مشاهدة السلات المتروكة منذ يومين او اكثر من جانب العملاء </span>
                    </div>
                    <?php
                    if (isset($_SESSION['success_message'])) {
                        $message = $_SESSION['success_message'];
                        unset($_SESSION['success_message']);
                    ?>
                        <?php
                        ?>
                        <script src="plugins/jquery/jquery.min.js"></script>
                        <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
                        <script>
                            $(function() {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: '<?php echo $message; ?>',
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            })
                        </script>
                        <?php
                    } elseif (isset($_SESSION['error_messages'])) {
                        $formerror = $_SESSION['error_messages'];
                        foreach ($formerror as $error) {
                        ?>
                            <div class="alert alert-danger alert-dismissible" style="max-width: 800px; margin:20px">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $error; ?>
                            </div>
                    <?php
                        }
                        unset($_SESSION['error_messages']);
                    }
                    ?>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> المستخدم </th>
                                        <th> تفاصيل السلة </th>
                                        <th> التاريخ </th>
                                        <?php
                                        if (isset($_SESSION['admin_username'])) {
                                        ?>
                                            <th> </th>
                                        <?php
                                        }
                                        ?>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // الحصول على التاريخ الحالي
                                    $currentDate = new DateTime();
                                    $formattedCurrentDate = $currentDate->format('Y-m-d H:i:s');

                                    // حساب التاريخ الذي يجب تجاوزه (التاريخ الحالي ناقصًا منه يومين)
                                    $dateTwoDaysAgo = $currentDate->sub(new DateInterval('P2D'));
                                    $formattedDateTwoDaysAgo = $dateTwoDaysAgo->format('Y-m-d H:i:s');

                                    // عرض التواريخ للتحقق
                                    // echo "Current Date: " . $formattedCurrentDate . "<br>";
                                    // echo "Date Two Days Ago: " . $formattedDateTwoDaysAgo . "<br>";
                                    // إعداد الطلب للحصول على السلات التي تم إنشاؤها قبل أكثر من يومين من التاريخ الحالي
                                    $stmt = $connect->prepare("SELECT * FROM cart WHERE start_date < ? GROUP BY user_id ORDER BY id DESC");
                                    // تنفيذ الطلب
                                    $stmt->execute([$formattedDateTwoDaysAgo]);
                                    // جلب جميع النتائج
                                    $allcart = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    $i = 0;
                                    foreach ($allcart as $cart) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php
                                                    if ($cart['user_id'] != null) {
                                                    ?>
                                                    <a href="main.php?dir=users&page=details&user_id=<?php echo $cart['user_id'] ?>" class="btn btn-warning btn-sm"> مشاهدة العميل </a>
                                                <?php
                                                    } else {
                                                ?>
                                                    <span class="badge badge-danger"> لا يوجد بيانات للعميل </span>
                                                <?php
                                                    } ?>
                                            </td>
                                            <td> <a href="main.php?dir=baskets_uncomplete&page=details&cookie_id=<?php echo $cart['cookie_id']; ?>" class="btn btn-success btn-sm"> تفاصيل السلة المتروكة </a> </td>
                                            <td> <?php echo $cart['start_date'] ?> </td>

                                            <?php
                                            if (isset($_SESSION['admin_username'])) {
                                            ?>
                                                <td>
                                                    <a href="main.php?dir=baskets_uncomplete&page=delete&cart_id=<?php echo $cart['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                                </td>
                                            <?php
                                            }
                                            ?>

                                        </tr>

                                    <?php
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