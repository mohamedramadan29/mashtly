<style>
    .small-box h3 {
        font-size: 20px;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> الرئيسية </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> مشتلي</li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!----------- Orders Reports -------------->
<?php
$stmt = $connect->prepare("SELECT * FROM orders");
$stmt->execute();
$count_orders = $stmt->rowCount();
?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3> <?php echo $count_orders; ?> </h3>
                        <p class="text-bold"> الطلبات </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file"></i>
                    </div>
                    <a href="main.php?dir=orders&page=report" class="small-box-footer"> التقاصيل <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- ./col -->
            <?php
            $stmt = $connect->prepare("SELECT * FROM outside_orders");
            $stmt->execute();
            $count_outside_orders = $stmt->rowCount();
            ?>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3> <?php echo $count_outside_orders; ?> </h3>
                        <p class="text-bold"> الطلبات الخارجية </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file"></i>
                    </div>
                    <a href="main.php?dir=outside_orders&page=report" class="small-box-footer"> التقاصيل <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <?php
            $stmt = $connect->prepare("SELECT * FROM offer_orders");
            $stmt->execute();
            $count_outside_orders = $stmt->rowCount();
            ?>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box" style="background-color:#8e44ad;color:#fff">
                    <div class="inner">
                        <h3> <?php echo $count_outside_orders; ?> </h3>
                        <p class="text-bold"> عروض الاسعار </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file"></i>
                    </div>
                    <a href="main.php?dir=offer_orders&page=report" class="small-box-footer"> التقاصيل <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <?php
                $stmt = $connect->prepare('SELECT * FROM categories');
                $stmt->execute();
                $count_categories = $stmt->rowCount();
                ?>
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3> <?php echo $count_categories; ?> </h3>

                        <p class="text-bold"> اقسام المنتجات </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="main.php?dir=categories&page=report" class="small-box-footer"> التقاصيل <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <?php
                $stmt = $connect->prepare('SELECT * FROM products');
                $stmt->execute();
                $product_count = $stmt->rowCount();

                ?>
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3> <?php echo $product_count; ?> </h3>

                        <p class="text-bold"> المنتجات </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="main.php?dir=products&page=report" class="small-box-footer"> التقاصيل <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <?php
                $stmt = $connect->prepare("SELECT * From users");
                $stmt->execute();
                $count_users = $stmt->rowCount();
                ?>
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3> <?php echo $count_users; ?> </h3>
                        <p class="text-bold"> العملاء </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="main.php?dir=users&page=report" class="small-box-footer"> التقاصيل <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <br>

        <div class='row'>
            <div class='col-lg-6'>
                <?php
                $stmt = $connect->prepare("SELECT * FROM orders");
                $stmt->execute();
                $count_orders = $stmt->rowCount();
                ///////////////////////
                $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'لم يبدا '");
                $stmt->execute();
                $count_orders_not_started = $stmt->rowCount();
                //////////////////////////
                $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'مكتمل'");
                $stmt->execute();
                $count_orders_compeleted = $stmt->rowCount();
                ////////////////////////
                $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'قيد الانتظار'");
                $stmt->execute();
                $count_orders_waits = $stmt->rowCount();
                /////////////////////////
                $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'ملغي'");
                $stmt->execute();
                $count_orders_cancelled = $stmt->rowCount();
                ?>
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title"> متابعة الطلبات والمبيعات </h3>
                    </div>
                    <div class="card-body p-0">
                        <label for="timePeriod">اختر الفترة الزمنية:</label>
                        <select id="timePeriod">
                            <option value=""> -- حدد الفترة الزمنية -- </option>
                            <option value="current_year">السنة الحالية</option>
                            <option value="previous_month">الشهر السابق</option>
                            <option value="current_month">الشهر الجاري</option>
                            <option value="last_7_days">آخر 7 أيام</option>
                            <option value="custom">تحديد الفترة</option>
                        </select>

                        <div id="customDateRange" style="display:none;">
                            <label for="startDate">من تاريخ:</label>
                            <input type="date" id="startDate">
                            <label for="endDate">إلى تاريخ:</label>
                            <input type="date" id="endDate">
                        </div>
                        <canvas id="orderschart" style="width:100%;max-width:700px"></canvas>
                        <ul style="margin-right: 10px;" class="list-unstyled products_report">
                            <style>
                                .products_report li {
                                    border-bottom: 1px solid #f5f2f2;
                                    padding-bottom: 10px;
                                    color: #555;
                                    font-size: 15px;
                                }
                            </style>
                            <li><a href="main.php?dir=orders&page=report" style="color: #555;"> عدد الطلبات الكلي
                                    :: </a> <span id="totalOrders" class="badge" style="background-color: #3498db; color:#fff"> <?php echo $count_orders; ?> </span>
                            </li>
                            <li><a href="main.php?dir=orders&page=compeleted_orders" style="color: #555;"> طلبات مكتملة
                                    :: </a> <span id="completedOrders" class="badge" style="background-color: #2ecc71; color:#fff"> <?php echo $count_orders_compeleted; ?> </span>
                            </li>
                            <li> طلبات لم تبدا :: <span id="notStartedOrders" class="badge" style="background-color: #8e44ad; color:#fff"> <?php echo $count_orders_not_started; ?> </span>
                            </li>
                            <li> طلبات قيد الانتظار :: <span id="pendingOrders" class="badge" style="background-color: #f1c40f; color:#fff"> <?php echo $count_orders_waits;; ?> </span>
                            </li>
                            <li> طلبات ملغية :: <span id="canceledOrders" class="badge" style="background-color: #c0392b; color:#fff"> <?php echo $count_orders_cancelled; ?> </span>
                            </li>
                        </ul>
                        <table class="table table-bordered" dir='rtl'>
                            <tbody>
                                <tr>
                                    <th> مجموع الطلبات المكتملة ::</th>
                                    <td>
                                        <span class="badge badge-success"> <?php echo $count_orders_compeleted; ?> طلب </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th> السعر الكلي للطلبات المكتملة ::</th>
                                    <?php
                                    $stmt = $connect->prepare("SELECT SUM(total_price) as TotalCompeletedOrders FROM orders WHERE  archieve = 0 AND status_value = 'مكتمل'");
                                    $stmt->execute();
                                    $data = $stmt->fetch();
                                    $total_price = $data['TotalCompeletedOrders'];

                                    ///////////
                                    ?>
                                    <td><span class="badge badge-info"> <?php echo $total_price; ?> ريال </span></td>
                                </tr>
                                <tr>
                                    <th> سعر الشحن ::</th>
                                    <?php
                                    $stmt = $connect->prepare("SELECT SUM(ship_price) as TotalShippedOrders FROM orders WHERE  archieve = 0 AND status_value = 'مكتمل'");
                                    $stmt->execute();
                                    $data_ship = $stmt->fetch();
                                    $total_shipping = $data_ship['TotalShippedOrders'];
                                    ?>
                                    <td><span class="badge badge-primary"> <?php echo $total_shipping; ?> ريال </span></td>
                                </tr>
                                <tr>
                                    <th> سعر الاضافات ::</th>
                                    <?php
                                    $stmt = $connect->prepare("SELECT SUM(farm_service_price) as TotalFarmOrders FROM orders WHERE  archieve = 0 AND status_value = 'مكتمل'");
                                    $stmt->execute();
                                    $data_farm = $stmt->fetch();
                                    $total_farming = $data_farm['TotalFarmOrders'];
                                    ?>
                                    <td><span class="badge badge-warning"> <?php echo $total_farming; ?> ريال </span></td>
                                </tr>
                                <!--                            <tr>-->
                                <!--                                <th> صافي الربح ::</th>-->
                                <!--                                --><?php
                                                                        //                                $total_earning = $total_price - ($total_shipping + $total_farming);
                                                                        //
                                                                        //                                
                                                                        ?>
                                <!--                                <th>-->
                                <!--                                    <span class="badge badge-danger"> <strong> -->
                                <?php //echo $total_earning; 
                                ?><!-- ريال </strong> </span>-->
                                <!--                                </th>-->
                                <!--                            </tr>-->
                            </tbody>
                        </table>
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            const totalOrders = parseInt(document.getElementById('totalOrders').textContent);
                            const completedOrders = parseInt(document.getElementById('completedOrders').textContent);
                            const notStartedOrders = parseInt(document.getElementById('notStartedOrders').textContent);
                            const pendingOrders = parseInt(document.getElementById('pendingOrders').textContent);
                            const canceledOrders = parseInt(document.getElementById('canceledOrders').textContent);

                            const xValues = ["عدد الطلبات الكلي", "طلبات مكتملة", "طلبات لم تبدا", "طلبات قيد الانتظار", "طلبات ملغية"];
                            const yValues = [totalOrders, completedOrders, notStartedOrders, pendingOrders, canceledOrders];
                            const barColors = ["#3498db", "#2ecc71", "#8e44ad", "#f1c40f", "#c0392b"];

                            new Chart("orderschart", {
                                type: "bar",
                                data: {
                                    labels: xValues,
                                    datasets: [{
                                        backgroundColor: barColors,
                                        data: yValues
                                    }]
                                },
                            });











                            document.getElementById('timePeriod').addEventListener('change', function() {
                                const period = this.value;

                                if (period === 'custom') {
                                    document.getElementById('customDateRange').style.display = 'block';
                                } else {
                                    document.getElementById('customDateRange').style.display = 'none';
                                    loadChartData(period);
                                }
                            });

                            document.getElementById('endDate').addEventListener('change', function() {
                                const startDate = document.getElementById('startDate').value;
                                const endDate = this.value;
                                if (startDate && endDate) {
                                    loadChartData('custom', startDate, endDate);
                                }
                            });

                            function loadChartData(period, startDate = null, endDate = null) {
                                // هنا يتم استخدام AJAX لجلب البيانات بناءً على الفترة الزمنية المحددة
                                let url = `fetch_orders.php?period=${period}`;

                                if (period === 'custom') {
                                    url += `&start_date=${startDate}&end_date=${endDate}`;
                                }

                                fetch(url)
                                    .then(response => response.json())
                                    .then(data => {
                                        updateChart(data.labels, data.data);
                                    });
                            }

                            function updateChart(labels, data) {
                                const ctx = document.getElementById('orderschart').getContext('2d');
                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'عدد الطلبات',
                                            backgroundColor: ["#3498db", "#2ecc71", "#8e44ad", "#f1c40f", "#c0392b"],
                                            data: data
                                        }]
                                    },
                                    options: {
                                        tooltips: {
                                            callbacks: {
                                                label: function(tooltipItem, data) {
                                                    return 'عدد الطلبات: ' + tooltipItem.yLabel;
                                                }
                                            }
                                        },
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            }

                            // تحميل البيانات الافتراضية عند تحميل الصفحة
                            loadChartData('current_year');
                        </script>

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
                            FROM orders WHERE status_value !='ملغي'
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

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"> رسم بياني شهري لتسجيل العملاء </div>
                    </div>
                    <div class="card-body">
                        <?php
                        // استعلام للحصول على عدد العملاء لكل شهر
                        $stmt = $connect->prepare("
                        SELECT DATE_FORMAT(STR_TO_DATE(created_at, '%c/%e/%Y %l:%i %p'), '%Y-%m') AS month, COUNT(*) AS total_users
                        FROM users
                        GROUP BY month
                        ORDER BY month 
                    ");
                        $stmt->execute();
                        $users_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        // تحضير البيانات للعرض
                        $months = [];
                        $users = [];
                        foreach ($users_data as $data) {
                            $months[] = $data['month'];
                            $users[] = $data['total_users'];
                        }
                        ?>

                        <canvas id="usersChart" height="250"></canvas>
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            // بيانات الرسم البياني
                            const months = <?php echo json_encode($months); ?>;
                            const users = <?php echo json_encode($users); ?>;
                            // إعداد الرسم البياني
                            const ctxuser = document.getElementById('usersChart').getContext('2d');
                            const usersChart = new Chart(ctxuser, {
                                type: 'line', // يمكنك تغيير نوع الرسم البياني إلى 'bar' أو 'pie' أو غيرها
                                data: {
                                    labels: months,
                                    datasets: [{
                                        label: ' عدد العملاء ',
                                        data: users,
                                        backgroundColor: 'rgba(255, 99, 132, 0.2)', // لون الخلفية للعملاء
                                        borderColor: 'rgba(255, 99, 132, 1)', // لون الحدود للعملاء
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
            </div>
        </div>


        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> افضل 20 منتجات مبيعا في مشتلي </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0" style="height: 605px;overflow: scroll;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th> اسم المنتج</th>
                                    <th> عدد مرات البيع</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $stmt = $connect->prepare("SELECT product_id, COUNT(*) as total_sales FROM order_details
                                            GROUP BY product_id ORDER BY total_sales DESC LIMIT 20");
                                $stmt->execute();
                                $top_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $i = 1;
                                foreach ($top_products as $product) {
                                ?>
                                    <tr>
                                        <td><?php echo $i++; ?> </td>
                                        <td>
                                            <a href="main.php?dir=products&page=edit&pro_id=<?php echo $product['product_id'] ?>" class="product-title"> <?php
                                                                                                                                                            $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                                                                                                                                            $stmt->execute(array(($product['product_id'])));
                                                                                                                                                            $pro_data = $stmt->fetch();
                                                                                                                                                            $pro_name = $pro_data['name'];
                                                                                                                                                            echo $pro_name; ?>
                                        </td>
                                        <td>
                                            <?php echo $product['total_sales']; ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>


                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="main.php?dir=products&page=products_report" class="uppercase"> مشاهدة تفاصيل
                            التقرير </a>
                    </div>
                    <!-- /.card-footer -->
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> اكثر العملاء طلبا من مشتلي </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0" style="height: 605px;overflow: scroll;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th> اسم المستخدم</th>
                                    <th> عدد الطلبات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $stmt = $connect->prepare("SELECT user_id, COUNT(*) as total_orders FROM orders
                                               GROUP BY user_id ORDER BY total_orders DESC LIMIT 20");
                                $stmt->execute();
                                $top_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $i = 1;
                                foreach ($top_users as $user) {
                                ?>
                                    <tr>
                                        <td><?php echo $i++; ?> </td>
                                        <td>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM users WHERE id = ?");
                                            $stmt->execute(array(($user['user_id'])));
                                            $pro_data = $stmt->fetch();
                                            $pro_name = $pro_data['user_name'];
                                            $pro_email = $pro_data['email'];
                                            echo $pro_name;

                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $user['total_orders']; ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>


                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="main.php?dir=users&page=report" class="uppercase"> مشاهدة تفاصيل
                            التقرير </a>
                    </div>
                    <!-- /.card-footer -->
                </div>
            </div>
        </div>





        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> اكثر المدن طلبا </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0" style="height: 605px;overflow: scroll;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th> اسم المدينة </th>
                                    <th> عدد مرات البيع</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $stmt = $connect->prepare("SELECT city, COUNT(*) as total_city FROM orders
                                               GROUP BY city ORDER BY total_city DESC LIMIT 20");
                                $stmt->execute();
                                $top_citizen = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $i = 1;
                                foreach ($top_citizen as $city) {
                                ?>
                                    <tr>
                                        <td><?php echo $i++; ?> </td>
                                        <td>
                                            <?php echo $city['city'] ?>
                                        </td>
                                        <td>
                                            <?php echo $city['total_city']; ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>


                    </div>
                    <!-- /.card-footer -->
                </div>
            </div>
        </div>




















    </div>
</section>
</div>