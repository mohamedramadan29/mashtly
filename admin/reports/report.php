<?php

// استلام المدخلات من النموذج
$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : null;
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : null;
$groupBy = isset($_GET['groupBy']) ? $_GET['groupBy'] : 'day'; // القيمة الافتراضية 'day'

// تحويل التواريخ إلى تنسيق 'Y-m-d H:i:s'
$fromDateFormatted = date('Y-m-d H:i:s', strtotime($fromDate));
$toDateFormatted = date('Y-m-d H:i:s', strtotime($toDate));

// تحديد شرط التجميع بناءً على القيمة المحددة في `groupBy`
switch ($groupBy) {
    case 'week':
        $groupCondition = "DATE_FORMAT(order_date, '%Y-%u')";
        break;
    case 'month':
        $groupCondition = "DATE_FORMAT(order_date, '%Y-%m')";
        break;
    case 'year':
        $groupCondition = "YEAR(order_date)";
        break;
    case 'day':
    default:
        $groupCondition = "DATE(order_date)";
        break;
}

$stmt = $connect->prepare("
    SELECT 
        CASE 
            WHEN '$groupBy' = 'day' THEN DATE(STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p'))
            WHEN '$groupBy' = 'week' THEN DATE_FORMAT(STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p'), '%Y-%u')
            
            WHEN '$groupBy' = 'month' THEN DATE_FORMAT(STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p'), '%Y-%m')
            WHEN '$groupBy' = 'year' THEN YEAR(STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p'))
        END as group_date, 
        COUNT(id) as total_orders, 
        SUM(total_price) as total_price 
    FROM orders 
    WHERE status_value !='pending' AND STR_TO_DATE(order_date, '%m/%d/%Y %h:%i %p') BETWEEN STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') 
    GROUP BY group_date 
    ORDER BY group_date ASC
");

$stmt->execute(array($fromDateFormatted, $toDateFormatted));
// جلب النتائج
$groupedOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">  نتائج التقرير حسب <?php   
                if($groupBy == 'day'){
                    echo " يومي ";
                }elseif($groupBy == 'week'){
                    echo "اسبوعي ";
                }elseif($groupBy == 'year'){
                    echo "سنوي";
                }elseif($groupBy == 'month'){
                    echo 'شهري';
                }
                ucfirst($groupBy); ?> </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active">  نتائج التقرير حسب <?php echo ucfirst($groupBy); ?> </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content-header -->


<!-- عرض الرسم البياني -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body"> 
                        <canvas id="ordersChart" width="400" height="200"></canvas>
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            const ctx = document.getElementById('ordersChart').getContext('2d');
                            const ordersChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: [
                                        <?php
                                        foreach ($groupedOrders as $order) {
                                            // عرض التواريخ بشكل صحيح بناءً على نوع التجميع
                                            if ($groupBy == 'day') {
                                                echo "'" . date('Y-m-d', strtotime($order['group_date'])) . "', ";
                                            } elseif ($groupBy == 'week') {
                                                // استخدام 'o-W' للتأكد من السنة الصحيحة
                                                //echo "'" . date('o-W', strtotime($order['group_date'])) . "', ";
                                                // تحويل رقم الأسبوع إلى تاريخ بداية الأسبوع
                                                $yearWeek = explode('-', $order['group_date']); // تقسيم على الشرطتين
                                                $year = $yearWeek[0];
                                                $weekNumber = $yearWeek[1];

                                                // حساب تاريخ بداية الأسبوع (الاثنين)
                                                $startOfWeek = new DateTime();
                                                $startOfWeek->setISODate($year, $weekNumber);
                                                echo "'" . $startOfWeek->format('Y-m-d') . "', ";
                                            } elseif ($groupBy == 'month') {
                                               // echo "'" . date('F Y', strtotime($order['group_date'])) . "', ";
                                                echo "'" . date('F Y', strtotime($order['group_date'])) . "', "; 
                                            } elseif ($groupBy == 'year') {
                                                echo "'" . date('Y', strtotime($order['group_date'])) . "', ";
                                            }
                                        }
                                        ?>
                                    ],
                                    datasets: [{
                                        label: 'عدد الطلبات',
                                        data: [
                                            <?php
                                            foreach ($groupedOrders as $order) {
                                                echo $order['total_orders'] . ", "; // عرض عدد الطلبات في كل فترة
                                            }
                                            ?>
                                        ],
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 3
                                    }]
                                },
                                options: {
                                    tooltips: {
                                        callbacks: {
                                            label: function(tooltipItem, data) {
                                                let date = tooltipItem.label;
                                                let value = tooltipItem.value;
                                                return 'الفترة: ' + date + ' | عدد الطلبات: ' + value;
                                            }
                                        }
                                    },
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>