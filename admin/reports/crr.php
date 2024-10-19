<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> معدل الاحتفاظ بالعملاء </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> معدل الاحتفاظ بالعملاء </li>
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
                        <form method="post" action="">
                            <input type="hidden" name="dir" value="reports">
                            <input type="hidden" name="page" value="crr">
                            <div class="d-flex" style="align-items:center;justify-content:space-between">
                                <div style="width: 30%;">
                                    <label for="fromDate"> بداية الفترة : </label>
                                    <input class="form-control" type="date" id="fromDate" name="fromDate" required value="<?php if (isset($_REQUEST['fromDate'])) echo $_REQUEST['fromDate']; ?>">
                                </div>
                                <div style="width: 30%;">
                                    <label for="toDate"> نهاية الفترة : </label>
                                    <input class="form-control" type="date" id="toDate" name="toDate" required value="<?php if (isset($_REQUEST['toDate'])) echo $_REQUEST['toDate']; ?>">
                                </div>
                                <div style="width: 20%; margin-top:30px">
                                    <button class="btn btn-primary" name="show" type="submit"> عرض النسبة <i class="fa fa-eye"></i></button>
                                </div>
                            </div>
                        </form>

                        <?php
                        // إعداد القيم الافتراضية للتواريخ
                        $fromDateFormatted = date('Y-m-d H:i:s', strtotime('-2 months'));  // بداية الشهر الحالي
                        $toDateFormatted = date('Y-m-d H:i:s'); // التاريخ الحالي

                        if (isset($_POST['show'])) {
                            // استلام المدخلات من النموذج
                            $fromDate = $_POST['fromDate'];
                            $toDate = $_POST['toDate'];

                            // تحويل التواريخ إلى تنسيق 'Y-m-d H:i:s'
                            $fromDateFormatted = date('Y-m-d H:i:s', strtotime($fromDate));
                            $toDateFormatted = date('Y-m-d H:i:s', strtotime($toDate));
                        }

                        // عدد العملاء في بداية الفترة (S)
                        $stmt = $connect->prepare("SELECT COUNT(DISTINCT user_id) AS start_customers FROM orders WHERE status_value != 'pending' AND STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p') < ?");
                        $stmt->execute([$fromDateFormatted]);
                        $startCustomers = $stmt->fetch(PDO::FETCH_ASSOC)['start_customers'];

                        // استعلام لجلب عدد العملاء في نهاية الفترة الزمنية (E)
                        $stmt = $connect->prepare("SELECT COUNT(DISTINCT user_id) AS end_customers FROM orders WHERE status_value != 'pending' AND STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p') <= ?");
                        $stmt->execute([$toDateFormatted]);
                        $endCustomers = $stmt->fetch(PDO::FETCH_ASSOC)['end_customers'];

                        // استعلام لجلب العملاء الذين قاموا بأول طلباتهم خلال الفترة الزمنية
                        $stmt = $connect->prepare("
                                SELECT COUNT(DISTINCT user_id) AS new_customers 
                                FROM orders 
                                WHERE user_id IN (
                                    SELECT user_id 
                                    FROM orders 
                                    WHERE STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p') BETWEEN ? AND ?
                                    GROUP BY user_id
                                    HAVING MIN(STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p')) BETWEEN ? AND ?
                                )
                                ");
                        $stmt->execute([$fromDateFormatted, $toDateFormatted, $fromDateFormatted, $toDateFormatted]);
                        $newCustomers = $stmt->fetch(PDO::FETCH_ASSOC)['new_customers'];

                        // حساب CRR
                        $crr = (($endCustomers - $newCustomers) / $startCustomers) * 100;

                        ?>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3> <?php echo $startCustomers; ?> </h3>
                                        <p class="text-bold"> عدد العملاء في بداية الفترة </p>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3> <?php echo $endCustomers; ?> </h3>
                                        <p class="text-bold"> عدد العملاء في نهاية الفترة </p>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3> <?php echo $newCustomers; ?> </h3>
                                        <p class="text-bold"> عدد العملاء الجدد في الفترة </p>
                                    </div> 
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3> <?php echo round($crr, 2); ?> % </h3>
                                        <p class="text-bold">  نسبة الاحتفاظ بالعملاء (CRR) </p>
                                    </div> 
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-body">

                        <div class='row'>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title"> معدل الاحتفاظ بالعملاء </div>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="crrChart" width="400" height="200"></canvas>
                                    </div>
                                </div>

                                <!-- إضافة مكتبة Chart.js -->
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <script>
                                    // إعداد البيانات للرسم البياني
                                    const crrData = {
                                        labels: ['نسبة الاحتفاظ بالعملاء'],
                                        datasets: [{
                                            label: 'CRR',
                                            data: [<?php echo round($crr, 2); ?>],
                                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                            borderColor: 'rgba(54, 162, 235, 1)',
                                            borderWidth: 1
                                        }]
                                    };

                                    // إعداد الرسم البياني
                                    const config = {
                                        type: 'bar',
                                        data: crrData,
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    };

                                    // رسم الرسم البياني
                                    const crrChart = new Chart(
                                        document.getElementById('crrChart'),
                                        config
                                    );
                                </script>
                            </div>

                        </div>
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