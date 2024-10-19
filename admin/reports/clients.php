<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> تقرير العملاء </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> تقارير العملاء </li>
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
                            <input type="hidden" name="page" value="client_report">
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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title"> رسم بياني لتسجيل العملاء </div>
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
                                        <div>
                                            <canvas id="usersChart"></canvas>
                                        </div>
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                        <script>
                                            // بيانات الرسم البياني
                                            const months = <?php echo json_encode($months); ?>;
                                            const users = <?php echo json_encode($users); ?>;
                                            // إعداد الرسم البياني
                                            const ctxuser = document.getElementById('usersChart').getContext('2d');
                                            const usersChart = new Chart(ctxuser, {
                                                type: 'bar', // يمكنك تغيير نوع الرسم البياني إلى 'bar' أو 'pie' أو غيرها
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
                    </div>

                    <div class="card-body">
                        <div class="card-header">
                            <h3 class="card-title"> اكثر العملاء طلبا من مشتلي </h3>
                        </div>
                        <div class="row">

                            <!-- /.card-header -->
                            <div class="card-body p-0" style="height: 605px;overflow: scroll;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th> #</th>
                                            <th> البريد الالكتروني </th>
                                            <th> عدد الطلبات</th>
                                            <th> قيمة المشتريات </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $stmt = $connect->prepare("SELECT email, COUNT(*) as total_orders , SUM(total_price) as total_purchases  FROM orders WHERE status_value !='ملغي' AND status_value !='pending'
                                               GROUP BY email ORDER BY total_orders DESC LIMIT 100");
                                        $stmt->execute();
                                        $top_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        $i = 1;
                                        foreach ($top_users as $user) {
                                        ?>
                                            <tr>
                                                <td><?php echo $i++; ?> </td>
                                                <td>
                                                    <?php
                                                    // $stmt = $connect->prepare("SELECT * FROM users WHERE id = ?");
                                                    // $stmt->execute(array(($user['user_id'])));
                                                    // $pro_data = $stmt->fetch();
                                                    // $pro_name = $pro_data['user_name'];
                                                    // $pro_email = $pro_data['email'];
                                                    echo $user['email'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $user['total_orders']; ?>
                                                </td>
                                                <td>
                                                <?php echo number_format($user['total_purchases'], 2); ?>
                                            ريال   
                                            </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
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