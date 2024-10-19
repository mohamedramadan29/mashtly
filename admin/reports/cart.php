<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> تقرير عن السلات </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> تقرير عن السلات </li>
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
                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM orders where  status_value !='pending' ");
                                $stmt->execute();
                                $count_orders = $stmt->rowCount();

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
                                $stmt = $connect->prepare("SELECT * FROM cart WHERE start_date < ? GROUP BY cookie_id ORDER BY id DESC");
                                // تنفيذ الطلب
                                $stmt->execute([$formattedDateTwoDaysAgo]);
                                // جلب جميع النتائج
                                $allcart = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $count_uncompeletedcart = count($allcart);

                                // حساب نسبة الطلبات المكتملة إلى السلات المتروكة
                                if ($count_uncompeletedcart > 0) {
                                    //$percent1 = ($count_orders / $count_uncompeletedcart) * 100;
                                    $percent1 = ($count_orders / ($count_orders + $count_uncompeletedcart)) * 100;
                                } else {
                                    $percent1 = 0; // في حال عدم وجود سلات متروكة لتجنب القسمة على صفر
                                }
                                ?>
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3> <?php echo number_format($percent1, 2) . "%"; ?> </h3>
                                        <p class="text-bold"> نسبة الطلبات المكتملة إلى السلات المتروكة </p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-file"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <?php

                                // حساب نسبة الطلبات المكتملة إلى السلات المتروكة
                                if ($count_uncompeletedcart > 0) {
                                    //$percent1 = ($count_orders / $count_uncompeletedcart) * 100;
                                    $percent2 = ($count_uncompeletedcart / ($count_orders + $count_uncompeletedcart)) * 100;
                                } else {
                                    $percent2 = 0; // في حال عدم وجود سلات متروكة لتجنب القسمة على صفر
                                }
                                ?>
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3> <?php echo number_format($percent2, 2) . "%"; ?> </h3>
                                        <p class="text-bold"> نسبة السلات المتروكة </p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-file"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h6> تفاصيل اضافية علي كيفية النسبة </h6>
                        <table class="table table-bordered table-active">
                            <tbody>
                                <tr>
                                    <th> عدد الطلبات الكلي </th>
                                    <td> <?php echo $count_orders; ?> طلبات </td>
                                </tr>
                                <tr>
                                    <th> عدد السلات المتروكة </th>
                                    <td> <?php echo count($allcart); ?> سلات  </td>
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