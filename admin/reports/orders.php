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
                                $stmt = $connect->prepare("SELECT * FROM orders WHERE  status_value !='pending' ");
                                $stmt->execute();
                                $count_orders = $stmt->rowCount();

                                $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'لم يبدا '");
                                $stmt->execute();
                                $count_orders_not_started = $stmt->rowCount();

                                $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'مكتمل'");
                                $stmt->execute();
                                $count_orders_completed = $stmt->rowCount();

                                $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'قيد الانتظار'");
                                $stmt->execute();
                                $count_orders_waiting = $stmt->rowCount();

                                $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'ملغي'");
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
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"> رسم بياني شهري للمبيعات </h3>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        // استعلام للحصول على عدد المبيعات لكل شهر
                                        $stmt = $connect->prepare("
                            SELECT DATE_FORMAT(STR_TO_DATE(order_date, '%c/%e/%Y %l:%i %p'), '%Y-%m') AS month, COUNT(*) AS total_sales
                            FROM orders WHERE status_value !='ملغي' AND status_value !='pending' 
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
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header border-transparent">
                                        <h3 class="card-title"> تقرير عن وسائل الدفع </h3>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $stmt = $connect->prepare("SELECT payment_method, COUNT(*) as count FROM orders GROUP BY payment_method");
                                        $stmt->execute();
                                        $payment_methods = $stmt->fetchAll();
                                        ?>
                                        <div style="width: 350px; height:350px">
                                            <canvas id="paymentChart"></canvas>
                                        </div>

                                        <script>
                                            var ctxpayment = document.getElementById('paymentChart').getContext('2d');
                                            var paymentMethods = <?php echo json_encode(array_column($payment_methods, 'payment_method')); ?>;
                                            var paymentCounts = <?php echo json_encode(array_column($payment_methods, 'count')); ?>;

                                            var chart = new Chart(ctxpayment, {
                                                type: 'doughnut',
                                                data: {
                                                    labels: paymentMethods,
                                                    datasets: [{
                                                        label: 'عدد الطلبات حسب طريقة الدفع',
                                                        data: paymentCounts,
                                                        backgroundColor: ['#3498db', '#2ecc71', '#e74c3c', '#f1c40f'],
                                                        borderColor: '#fff',
                                                        borderWidth: 1
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    plugins: {
                                                        legend: {
                                                            position: 'top',
                                                        },
                                                        tooltip: {
                                                            callbacks: {
                                                                label: function(tooltipItem) {
                                                                    return paymentMethods[tooltipItem.dataIndex] + ': ' + paymentCounts[tooltipItem.dataIndex] + ' طلبات';
                                                                }
                                                            }
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
            </div>
        </div>
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>