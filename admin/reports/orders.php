<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> تقارير الطلبات </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> تقارير الطلبات </li>
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
                        <form method="GET" action="main.php">
                            <input type="hidden" name="dir" value="reports">
                            <input type="hidden" name="page" value="report">
                            <div class="d-flex" style="align-items:center;justify-content:space-between">
                                <div style="width: 30%;">
                                    <label for="fromDate">من تاريخ:</label>
                                    <input class="form-control" type="date" id="fromDate" name="fromDate" required>
                                </div>
                                <div style="width: 30%;">
                                    <label for="toDate">إلى تاريخ:</label>
                                    <input class="form-control" type="date" id="toDate" name="toDate" required>
                                </div>
                                <div style="width: 20%;">
                                    <label for="groupBy">عرض حسب:</label>
                                    <select class="form-control" id="groupBy" name="groupBy" required>
                                        <option value="day">اليوم</option>
                                        <option value="week">الأسبوع</option>
                                        <option value="month">الشهر</option>
                                        <option value="year">السنة</option>
                                    </select>
                                </div>
                                <div style="width: 20%; margin-top:30px">
                                    <button class="btn btn-primary" type="submit"> عرض التقرير <i class="fa fa-eye"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">

                        <div class='row'>
                            <div class='col-lg-6'>
                                <?php
                                // Prepare order statistics
                                $stmt = $connect->prepare("SELECT * FROM orders WHERE  status_value !='pending' UNION ALL SELECT * FROM orders_old ");
                                $stmt->execute();
                                $count_orders = $stmt->rowCount();

                                // حساب عدد الطلبات
                                // $stmt = $connect->prepare("
                                //     SELECT COUNT(*) AS total_orders FROM (
                                //         SELECT * FROM orders WHERE status_value != 'pending'
                                //         UNION ALL
                                //         SELECT * FROM orders_old
                                //     ) AS combined_orders
                                //     ");
                                // $stmt->execute();
                                // $count_orders = $stmt->fetchColumn();

                                $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'لم يبدا ' ");
                                $stmt->execute();
                                $count_orders_not_started = $stmt->rowCount();

                                $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'مكتمل' UNION ALL SELECT * FROM orders_old WHERE status_value = 'completed' ");
                                $stmt->execute();
                                $count_orders_completed = $stmt->rowCount();

                                $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'قيد الانتظار'  UNION ALL SELECT * FROM orders_old WHERE status_value = 'processing' ");
                                $stmt->execute();
                                $count_orders_waiting = $stmt->rowCount();

                                $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'ملغي'  UNION ALL SELECT * FROM orders_old WHERE status_value = 'cancelled' ");
                                $stmt->execute();
                                $count_orders_cancelled = $stmt->rowCount();
                                ?>

                                <div class="card">
                                    <div class="card-header border-transparent">
                                        <h3 class="card-title"> متابعة الطلبات والمبيعات </h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <canvas id="orderschart2" style="width:100%;max-width:700px"></canvas>
                                        <ul style="margin-right: 10px;" class="list-unstyled products_report">
                                            <style>
                                                .products_report li {
                                                    border-bottom: 1px solid #f5f2f2;
                                                    padding-bottom: 10px;
                                                    color: #555;
                                                    font-size: 15px;
                                                }
                                            </style>
                                            <li><a href="main.php?dir=orders&page=report" style="color: #555;">عدد الطلبات الكلي ::</a>
                                                <span id="totalOrders" class="badge" style="background-color: #3498db; color:#fff"><?php echo $count_orders; ?></span>
                                            </li>
                                            <li><a href="main.php?dir=orders&page=compeleted_orders" style="color: #555;">طلبات مكتملة ::</a>
                                                <span id="completedOrders" class="badge" style="background-color: #2ecc71; color:#fff"><?php echo $count_orders_completed; ?></span>
                                            </li>
                                            <li>طلبات لم تبدأ ::
                                                <span id="notStartedOrders" class="badge" style="background-color: #8e44ad; color:#fff"><?php echo $count_orders_not_started; ?></span>
                                            </li>
                                            <li>طلبات قيد الانتظار ::
                                                <span id="pendingOrders" class="badge" style="background-color: #f1c40f; color:#fff"><?php echo $count_orders_waiting; ?></span>
                                            </li>
                                            <li>طلبات ملغاة ::
                                                <span id="canceledOrders" class="badge" style="background-color: #c0392b; color:#fff"><?php echo $count_orders_cancelled; ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Include Chart.js library -->
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                                <script>
                                    // Get order counts from PHP variables
                                    const totalOrders = <?php echo json_encode($count_orders); ?>;
                                    const completedOrders = <?php echo json_encode($count_orders_completed); ?>;
                                    const notStartedOrders = <?php echo json_encode($count_orders_not_started); ?>;
                                    const waitingOrders = <?php echo json_encode($count_orders_waiting); ?>;
                                    const canceledOrders = <?php echo json_encode($count_orders_cancelled); ?>;

                                    // Create the chart
                                    const ctx2 = document.getElementById('orderschart2').getContext('2d');
                                    const ordersChart2 = new Chart(ctx2, {
                                        type: 'bar', // You can change this to 'pie', 'line', etc. based on your preference
                                        data: {
                                            labels: ['عدد الطلبات الكلي', 'طلبات مكتملة', 'طلبات لم تبدأ', 'طلبات قيد الانتظار', 'طلبات ملغاة'],
                                            datasets: [{
                                                label: 'عدد الطلبات',
                                                data: [totalOrders, completedOrders, notStartedOrders, waitingOrders, canceledOrders],
                                                backgroundColor: [
                                                    '#3498db',
                                                    '#2ecc71',
                                                    '#8e44ad',
                                                    '#f1c40f',
                                                    '#c0392b'
                                                ],
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                </script>
                            </div>
                            <div class='col-lg-6'>
                                <?php
                                // استعلام لجلب إجمالي الإيرادات
                                $stmtRevenue = $connect->prepare("SELECT SUM(total_price) AS total_revenue FROM orders WHERE status_value != 'pending'");
                                $stmtRevenue->execute();
                                $totalRevenue = $stmtRevenue->fetch(PDO::FETCH_ASSOC)['total_revenue'];

                                // استعلام لجلب إجمالي الإيرادات من القديم 
                                $stmtRevenue_old = $connect->prepare("SELECT SUM(total_price) AS total_revenue_old FROM orders_old");
                                $stmtRevenue_old->execute();
                                $totalRevenue_old = $stmtRevenue_old->fetch(PDO::FETCH_ASSOC)['total_revenue_old'];

                                // استعلام لجلب عدد الطلبات
                                $stmtCount = $connect->prepare("SELECT COUNT(*) AS order_count FROM orders WHERE status_value != 'pending'");
                                $stmtCount->execute();
                                $count_orders = $stmtCount->fetch(PDO::FETCH_ASSOC)['order_count'];

                                // استعلام لجلب عدد الطلبات
                                $stmtCount_old = $connect->prepare("SELECT COUNT(*) AS order_count_old FROM orders_old");
                                $stmtCount_old->execute();
                                $count_orders_old = $stmtCount_old->fetch(PDO::FETCH_ASSOC)['order_count_old'];




                                ?>

                                <div class="card">
                                    <div class="card-header border-transparent">
                                        <h3 class="card-title">متوسط قيمة الطلب </h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-bordered table-primary">
                                            <thead>
                                                <tr>
                                                    <th> إجمالي عدد الطلبات </th>
                                                    <th> إجمالي الإيرادات </th>
                                                    <th> متوسط قيمة الطلب </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $alltotalrev = $totalRevenue + $totalRevenue_old;
                                                $alltotalcount = $count_orders + $count_orders_old;
                                                ?>
                                                <tr>
                                                    <td> <?php echo $alltotalcount ?> </td>
                                                    <td> <?php echo  number_format($alltotalrev, 2)  ?> ريال </td>
                                                    <td> <strong> <?php echo  number_format($alltotalrev / $alltotalcount, 2)  ?> </strong> ريال </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class='col-lg-6'>
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"> رسم بياني شهري للمبيعات </h3>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        // استعلام للحصول على عدد المبيعات لكل شهر
                                        $stmt = $connect->prepare("
                            SELECT DATE_FORMAT(STR_TO_DATE(order_date, '%c/%e/%Y %l:%i %p'), '%Y-%m') AS month, COUNT(*) AS total_sales
                            FROM orders WHERE status_value !='pending' 
                            GROUP BY month
                            ORDER BY month 
                        ");
                                        $stmt->execute();
                                        $sales_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        // تحضير البيانات للعرض
                                        $ordermonths = [];
                                        $sales = [];

                                        foreach ($sales_data as $data) {
                                            $ordermonths[] = $data['month'];
                                            $sales[] = $data['total_sales'];
                                        }

                                        ?>

                                        <canvas id="salesChart" height="250"></canvas>
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                        <script>
                                            // بيانات الرسم البياني
                                            const ordermonths = <?php echo json_encode($ordermonths); ?>;
                                            const sales = <?php echo json_encode($sales); ?>;
                                            // إعداد الرسم البياني
                                            const ctx = document.getElementById('salesChart').getContext('2d');
                                            const salesChart = new Chart(ctx, {
                                                type: 'bar', // يمكنك تغيير نوع الرسم البياني إلى 'bar' أو 'pie' أو غيرها
                                                data: {
                                                    labels: ordermonths,
                                                    datasets: [{
                                                        label: 'عدد المبيعات',
                                                        data: sales,
                                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                                        borderColor: 'rgba(54, 162, 235, 1)',
                                                        borderWidth: 3
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true
                                                        }
                                                    }
                                                }
                                            });
                                        </script>

                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>


                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header border-transparent">
                                        <h3 class="card-title"> تقرير عن وسائل الدفع </h3>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        // احصل على البيانات من جدول orders
                                        $stmt = $connect->prepare("
   SELECT 
       CASE 
           WHEN LOWER(TRIM(payment_method)) IN ('الدفع عند الاستلام', 'دفع عند الاستلام') THEN 'الدفع عند الاستلام'
           WHEN LOWER(TRIM(payment_method)) IN ('دفع الكتروني', 'الدفع الالكتروني', 'دفع إلكتروني') THEN 'الدفع الالكتروني'
           ELSE payment_method
       END as payment_method, 
       COUNT(*) as count 
   FROM orders
   GROUP BY payment_method
");
                                        $stmt->execute();
                                        $payment_methods_orders = $stmt->fetchAll();

                                        // احصل على البيانات من جدول orders_old
                                        $stmt = $connect->prepare("
   SELECT 
       CASE 
           WHEN LOWER(TRIM(payment_method)) IN ('الدفع عند الاستلام', 'دفع عند الاستلام') THEN 'الدفع عند الاستلام'
           WHEN LOWER(TRIM(payment_method)) IN ('دفع الكتروني', 'الدفع الالكتروني', 'دفع إلكتروني') THEN 'الدفع الالكتروني'
           ELSE payment_method
       END as payment_method, 
       COUNT(*) as count 
   FROM orders_old
   GROUP BY payment_method
");
                                        $stmt->execute();
                                        $payment_methods_orders_old = $stmt->fetchAll();

                                        // دمج البيانات من كلا الجدولين
                                        $combined_payment_methods = [];

                                        // دمج بيانات جدول orders
                                        foreach ($payment_methods_orders as $row) {
                                            $method = $row['payment_method'];
                                            if (!isset($combined_payment_methods[$method])) {
                                                $combined_payment_methods[$method] = 0;
                                            }
                                            $combined_payment_methods[$method] += $row['count'];
                                        }

                                        // دمج بيانات جدول orders_old
                                        foreach ($payment_methods_orders_old as $row) {
                                            $method = $row['payment_method'];
                                            if (!isset($combined_payment_methods[$method])) {
                                                $combined_payment_methods[$method] = 0;
                                            }
                                            $combined_payment_methods[$method] += $row['count'];
                                        }

                                        // تحويل النتائج إلى صيغة مناسبة للعرض
                                        $payment_methods = [];
                                        foreach ($combined_payment_methods as $method => $count) {
                                            $payment_methods[] = [
                                                'payment_method' => $method,
                                                'count' => $count
                                            ];
                                        }

                                        // طباعة النتائج للتحقق (اختياري)
                                        // echo "<pre>";
                                        // print_r($payment_methods);
                                        // echo "</pre>";
                                        ?>
                                        <div style="height:450px">
                                            <canvas id="paymentChart"></canvas>
                                        </div>


                                        <script>
                                            var ctxpayment = document.getElementById('paymentChart').getContext('2d');
                                            var paymentMethods = <?php echo json_encode(array_column($payment_methods, 'payment_method')); ?>;
                                            var paymentCounts = <?php echo json_encode(array_column($payment_methods, 'count')); ?>;

                                            var paymentChart = new Chart(ctxpayment, {
                                                type: 'pie',
                                                data: {
                                                    labels: paymentMethods,
                                                    datasets: [{
                                                        label: 'عدد الطلبات',
                                                        data: paymentCounts,
                                                        backgroundColor: [
                                                            'rgba(75, 192, 192, 0.6)', // لون 1
                                                            'rgba(255, 99, 132, 0.6)', // لون 2
                                                            'rgba(255, 205, 86, 0.6)', // لون 3
                                                            'rgba(54, 162, 235, 0.6)', // لون 4
                                                            'rgba(153, 102, 255, 0.6)', // لون 5
                                                            'rgba(201, 203, 207, 0.6)', // لون 6
                                                            'rgba(255, 159, 64, 0.6)' // لون 7
                                                        ],
                                                        borderColor: [
                                                            'rgba(75, 192, 192, 1)', // حدود اللون 1
                                                            'rgba(255, 99, 132, 1)', // حدود اللون 2
                                                            'rgba(255, 205, 86, 1)', // حدود اللون 3
                                                            'rgba(54, 162, 235, 1)', // حدود اللون 4
                                                            'rgba(153, 102, 255, 1)', // حدود اللون 5
                                                            'rgba(201, 203, 207, 1)', // حدود اللون 6
                                                            'rgba(255, 159, 64, 1)' // حدود اللون 7
                                                        ],
                                                        borderWidth: 1
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true
                                                        }
                                                    }
                                                }
                                            });
                                        </script>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
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