<?php

$countries = [
    'dza' => 'الجزائر',
    'bhr' => 'البحرين',
    'egy' => 'مصر',
    'irq' => 'العراق',
    'jor' => 'الأردن',
    'kwt' => 'الكويت',
    'lbn' => 'لبنان',
    'lby' => 'ليبيا',
    'mar' => 'المغرب',
    'oma' => 'عمان',
    'qat' => 'قطر',
    'sau' => 'السعودية',
    'sud' => 'السودان',
    'syr' => 'سوريا',
    'tun' => 'تونس',
    'are' => 'الإمارات',
    'yem' => 'اليمن',
    'pal' => 'فلسطين',
    'com' => 'جزر القمر',
    'dj' => 'جيبوتي',
    'mrt' => 'موريتانيا',
    'som' => 'الصومال',
    // الدول الأخرى
    'omn' => 'عمان',
    'pse' => 'فلسطين',
    'isr' => 'إسرائيل',
    'deu' => 'ألمانيا',
    'tur' => 'تركيا',
    'usa' => 'الولايات المتحدة الأمريكية',
    'zzz' => 'غير محدد',
    'sdn' => 'السودان',
    'fra' => 'فرنسا',
    'gbr' => 'المملكة المتحدة',
    'can' => 'كندا',
    'nld' => 'هولندا',
    'swe' => 'السويد',
    'aus' => 'أستراليا',
    'ita' => 'إيطاليا',
];

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> احصائيات الموقع </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> احصائيات الموقع </li>
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
                    <?php
                    session_start();
                    require 'config.php';

                    if (!isset($_SESSION['access_token'])) {
                        header('Location: index.php');
                        exit;
                    }

                    $site_url = 'https://www.mshtly.com/'; // ضع عنوان موقعك هنا
                    $encoded_site_url = urlencode($site_url);
                    $access_token = $_SESSION['access_token'];

                    // 1. الطلب الأول لجلب الإحصائيات الإجمالية
                    $request_url = 'https://searchconsole.googleapis.com/webmasters/v3/sites/' . $encoded_site_url . '/searchAnalytics/query';
                    $request_data_total = [
                        'startDate' => '2024-07-01',
                        'endDate' => '2024-10-17',
                        'dimensions' => [], // لا توجد أبعاد لجلب الإحصائيات الإجمالية
                    ];

                    $ch = curl_init($request_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $access_token,
                        'Content-Type: application/json',
                    ]);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data_total));

                    $response_total = curl_exec($ch);
                    $response_data_total = json_decode($response_total, true);
                    curl_close($ch);

                    // التحقق من وجود أخطاء في الاستجابة
                    if (isset($response_data_total['error'])) {
                        echo 'خطأ: ' . htmlspecialchars($response_data_total['error']['message']);
                        exit;
                    }

                    function format_number($number)
                    {
                        if ($number >= 1000000) {
                            return round($number / 1000000, 2) . 'M'; // مليون
                        } elseif ($number >= 1000) {
                            return round($number / 1000, 2) . 'K'; // ألف
                        }
                        return $number; // إذا كان الرقم أقل من ألف، لا يتم اختصاره
                    }

                    // حساب الإحصائيات الإجمالية
                    $total_clicks = $response_data_total['rows'][0]['clicks'] ?? 0;
                    $total_impressions = $response_data_total['rows'][0]['impressions'] ?? 0;
                    $total_ctr = ($total_impressions > 0) ? ($total_clicks / $total_impressions) * 100 : 0;
                    $total_position = $response_data_total['rows'][0]['position'] ?? 0;

                    // 2. الطلب الثاني لجلب الإحصائيات التفصيلية (للصفحات أو الاستعلامات)
                    $request_data_query = [
                        'startDate' => '2024-07-01',
                        'endDate' => '2024-10-17',
                        'dimensions' => ['query'], // لجلب الاستعلامات التفصيلية
                    ];

                    // 2. الطلب الثاني لجلب الإحصائيات التفصيلية (للصفحات)
                    $request_data_pages = [
                        'startDate' => '2024-07-01',
                        'endDate' => '2024-10-17',
                        'dimensions' => ['page'], // لجلب بيانات الصفحات
                    ];

                    // 3. الطلب الثالث لجلب الإحصائيات التفصيلية (للبلدان)
                    $request_data_countries = [
                        'startDate' => '2024-07-01',
                        'endDate' => '2024-10-17',
                        'dimensions' => ['country'], // لجلب بيانات الدول
                    ];

                    $ch = curl_init($request_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $access_token,
                        'Content-Type: application/json',
                    ]);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data_query));

                    $response_query = curl_exec($ch);
                    $response_data_query = json_decode($response_query, true);
                    curl_close($ch);


                    // طلب لجلب بيانات الصفحات
                    $ch_pages = curl_init($request_url);
                    curl_setopt($ch_pages, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch_pages, CURLOPT_POST, true);
                    curl_setopt($ch_pages, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $access_token,
                        'Content-Type: application/json',
                    ]);
                    curl_setopt($ch_pages, CURLOPT_POSTFIELDS, json_encode($request_data_pages));
                    $response_pages = curl_exec($ch_pages);
                    $response_data_pages = json_decode($response_pages, true);
                    curl_close($ch_pages);

                    // طلب لجلب بيانات الدول
                    $ch_countries = curl_init($request_url);
                    curl_setopt($ch_countries, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch_countries, CURLOPT_POST, true);
                    curl_setopt($ch_countries, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $access_token,
                        'Content-Type: application/json',
                    ]);
                    curl_setopt($ch_countries, CURLOPT_POSTFIELDS, json_encode($request_data_countries));
                    $response_countries = curl_exec($ch_countries);
                    $response_data_countries = json_decode($response_countries, true);
                    curl_close($ch_countries);

                    // التحقق من وجود أخطاء في استجابة الاستعلامات
                    if (isset($response_data_query['error'])) {
                        echo 'خطأ: ' . htmlspecialchars($response_data_query['error']['message']);
                        exit;
                    }
                    ?>
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3> <?php echo format_number($total_clicks) ?> </h3>
                                    <p class="text-bold"> إجمالي النقرات: </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3> <?php echo format_number($total_impressions) ?> </h3>
                                    <p class="text-bold"> إجمالي الانطباعات: </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3> <?php echo round($total_ctr, 2) ?> % </h3>
                                    <p class="text-bold"> متوسط معدل النقرات (CTR): </p>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3> <?php echo round($total_position, 2) ?> </h3>
                                    <p class="text-bold"> متوسط الموضع: </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>


                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="queries-tab" data-toggle="pill" href="#queries" role="tab" aria-controls="queries" aria-selected="true"> الاستعلامات </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pages-tab" data-toggle="pill" href="#pages" role="tab" aria-controls="pages" aria-selected="false"> الصفحات </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="countries-tab" data-toggle="pill" href="#countries" role="tab" aria-controls="countries" aria-selected="false"> الدول </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="queries" role="tabpanel" aria-labelledby="queries-tab">
                                <div class="mt-3">
                                    <table id="queries_table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th> الاستعلام </th>
                                                <th> النقرات </th>
                                                <th> الانطباعات </th>
                                                <th> معدل النقرات (CTR) </th>
                                                <th> الموضع </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // عرض بيانات الاستعلامات
                                            $i = 1;
                                            if (isset($response_data_query['rows']) && count($response_data_query['rows']) > 0) {
                                                foreach ($response_data_query['rows'] as $row) {
                                            ?>
                                                    <tr>
                                                        <td> <?php echo  $i++ ?> </td>
                                                        <td> <?php echo htmlspecialchars($row['keys'][0]) ?></td>
                                                        <td> <?php echo htmlspecialchars($row['clicks']) ?> </td>
                                                        <td> <?php echo htmlspecialchars($row['impressions']) ?> </td>
                                                        <td> <?php echo round(($row['impressions'] > 0 ? ($row['clicks'] / $row['impressions']) * 100 : 0), 2) ?> % </td>
                                                        <td> <?php echo round($row['position'], 2); ?> </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo 'لا توجد بيانات';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pages" role="tabpanel" aria-labelledby="pages-tab">
                                <div class="mt-3">
                                    <table id="pages_table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th> الصفحة </th>
                                                <th> النقرات </th>
                                                <th> الانطباعات </th>
                                                <th> معدل النقرات (CTR) </th>
                                                <th> الموضع </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // عرض بيانات الصفحات
                                            $i = 1;
                                            if (isset($response_data_pages['rows']) && count($response_data_pages['rows']) > 0) {
                                                foreach ($response_data_pages['rows'] as $row) {
                                                      $page_url = htmlspecialchars($row['keys'][0]);
                                                       
                                                       $page_url_decoded = rawurldecode($page_url);
                                            ?>
                                                    <tr>
                                                        <td> <?php echo  $i++ ?> </td>
                                                        <td> 
                                                           <a href="<?php echo $page_url; ?>" target="_blank">
                                                                <?php echo $page_url_decoded; ?>
                                                            </a>
                                                        </td>
                                                        <td> <?php echo htmlspecialchars($row['clicks']) ?> </td>
                                                        <td> <?php echo htmlspecialchars($row['impressions']) ?> </td>
                                                        <td> <?php echo round(($row['impressions'] > 0 ? ($row['clicks'] / $row['impressions']) * 100 : 0), 2) ?> % </td>
                                                        <td> <?php echo round($row['position'], 2); ?> </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo 'لا توجد بيانات';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="countries" role="tabpanel" aria-labelledby="countries-tab">
                                <div class="mt-3">
                                    <table id="countries_table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th> الدولة </th>
                                                <th> النقرات </th>
                                                <th> الانطباعات </th>
                                                <th> معدل النقرات (CTR) </th>
                                                <th> الموضع </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // عرض بيانات الدول
                                            $i = 1;
                                            if (isset($response_data_countries['rows']) && count($response_data_countries['rows']) > 0) {
                                                foreach ($response_data_countries['rows'] as $row) {
                                                       // الحصول على رمز الدولة
                                         $country_code = htmlspecialchars($row['keys'][0]);
                                           // الحصول على اسم الدولة من المصفوفة
                                         $country_name = isset($countries[$country_code]) ? $countries[$country_code] : $country_code; // إذا لم يكن موجوداً، استخدم الرمز كاسم


                                            ?>
                                                    <tr>
                                                        <td> <?php echo  $i++ ?> </td>
                                                         <td> <?php echo $country_name; ?></td>
                                                        <td> <?php echo htmlspecialchars($row['clicks']) ?> </td>
                                                        <td> <?php echo htmlspecialchars($row['impressions']) ?> </td>
                                                        <td> <?php echo round(($row['impressions'] > 0 ? ($row['clicks'] / $row['impressions']) * 100 : 0), 2) ?> % </td>
                                                        <td> <?php echo round($row['position'], 2); ?> </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo 'لا توجد بيانات';
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
    </div>
</section>