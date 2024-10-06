<style>
    @media print {
        body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        #print_Button {
            display: none !important;
        }
    }
</style>


<?php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    // get the order data
    $stmt = $connect->prepare("SELECT * FROM outside_orders WHERE id = ?");
    $stmt->execute(array($order_id));
    $order_data = $stmt->fetch();
    $ship_price = $order_data['ship_price'];
    $order_date = $order_data['order_date'];
    $total_price = $order_data['total_price'];
}
$pagetitle = 'Mohamed';
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> فاتورة طلب خارجي </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> فاتورة طلب خارجي </li>
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
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body" id="print">
                        <div class="inv_header">
                            <div class="logo text-center">
                                <img src="uploads/logo.png" alt="">
                                <h3 style="margin-top: 20px;font-size: 22px;color: #000;"> فاتورة طلب خارجي   </h3>
                            </div>
                            <div class="header_data">
                                <div class="row" style=" padding:10px; margin-top:10px; margin-bottom:10px">
                                    <h2> مرحبا <?php echo $order_data['name']; ?> </h2>
                                    <p> شكرا لطلبك، من مشتلي تم تأكيد طلبك وسوف يصلك في الوقت المحدد لإلغاء الطلب أو تعديله يرجي زيارة الموقع قسم <span style="color: #7a9d12;">مشترياتي</span> </p>
                                    <p style="display: block;"> يوجد أدناه فاتورة برقم الطلب وتفاصيله </p>
                                    <p class="no_sheap_price">
                                        <img src="<?php echo $uploads ?>free.svg" alt="">
                                        مدة الشحن المتوقعة 2-7 ايام
                                    </p>
                                    <div class="print_head">
                                        <table class="table table-bordered" id="order-table">
                                            <tr>
                                                <th> <span> رقم الطلب: </span> </th>
                                                <th> # <?php echo $order_data['order_number']; ?> </th>
                                            </tr>
                                            <tr>
                                                <th> <span> تاريخ الطلب: </span> </th>
                                                <th> <?php echo $order_data['order_date']; ?> </th>
                                            </tr>
                                            <tr>
                                                <th> <span> الاسم: </span> </th>
                                                <th><?php echo $order_data['name']; ?> </th>
                                            </tr>
                                            <input type="hidden" id="customername" value="<?php echo $order_data['name']; ?>">
                                            <tr>
                                                <th> <span> البريد الألكتروني : </span> </th>
                                                <th> <?php echo $order_data['email']; ?> </th>
                                            </tr>
                                            <tr>
                                                <th> <span> رقم الجوال: </span> </th>
                                                <th> <?php echo $order_data['phone']; ?> </th>
                                            </tr>
                                            <tr>
                                                <th> <span> وسية الدفع : </span> </th>
                                                <th>
                                                    <?php echo $order_data['payment_method']; ?>
                                                    <?php
                                                    if ($order['payment_status'] == 0) {
                                                    ?>
                                                        <span class="badge badge-danger"> لم يتم الدفع الالكتروني بشكل صحيح </span>
                                                    <?php
                                                    }
                                                    ?>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th> <span> العنوان: </span> </th>
                                                <th> <?php echo $order_data['address']; ?> </th>
                                            </tr>
                                            <tr>
                                                <th> <span> ملاحظات اضافية : </span> </th>
                                                <th> <?php echo $order_data['order_details']; ?> </th>
                                            </tr>

                                        </table>
                                        <button class="btn btn-primary" id="copy-btn" data-clipboard-target="#order-table">نسخ المحتوى</button>
                                    </div>
                                </div>
                            </div>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
                            <script>
                                // تهيئة Clipboard.js
                                new ClipboardJS('#copy-btn');
                            </script>
                            <div class="order_details">
                                <h4> تفاصيل الطلب </h4>
                                <br>
                                <table class="table table-bordered">
                                    <tr>
                                        <th> المنتج </th>
                                        <th> الكمية </th>
                                        <th> إجمالي السعر </th>
                                    </tr>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM outside_order_details WHERE order_id = ?");
                                    $stmt->execute(array($order_id));
                                    $alldetails = $stmt->fetchAll();
                                    foreach ($alldetails as $details) {
                                        // get product data
                                        $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                        $stmt->execute(array($details['product_id']));
                                        $product_data = $stmt->fetch();
                                        // get the product image
                                        $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                                        $stmt->execute(array($product_data['id']));
                                        $product_image = $stmt->fetch();
                                        $image = $product_image['main_image'];
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="product_data d-flex">
                                                    <div class="image">
                                                        <img style="width: 80px;height: 80px;border: 1px solid #ccc;border-radius: 10px;margin-left: 20px;" src="product_images/<?php echo $image ?>" alt="">
                                                    </div>
                                                    <div>
                                                        <h4 style="font-size: 18px;"> <?php echo $product_data['name']; ?> </h4>
                                                        <p style="color: #5c8e00;font-size: 15px;"> <?php echo number_format($details['product_price'], 2); ?> ر.س </p>
                                                        <?php
                                                        // get more details data
                                                        $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE id = ?");
                                                        $stmt->execute(array($details['more_details']));
                                                        $more_details_data = $stmt->fetch();
                                                        echo $more_details_data['vartions_name'];
                                                        echo $details['more_details'];
                                                        $more_detail_name = $more_details_data['vartions_name']
                                                        ?>
                                                        <p style="display: block; width: 100%;"><?php echo $more_detail_name; ?></p>
                                                        <br>
                                                        <p style="display: block; width: 100%;"> امكانية الزراعه ::
                                                            <?php if ($details['farm_service'] == 0) {
                                                                echo "لا";
                                                            } else {
                                                                echo "نعم ";
                                                            } ?> </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span> <?php echo $details['qty']; ?> </span>
                                            </td>
                                            <td>
                                                <span> <?php echo  number_format($details['qty'] * $details['product_price'], 2); ?> ر.س </span>
                                            </td>
                                        </tr>

                                    <?php
                                    } ?>

                                    <?php

                                    $stmt = $connect->prepare("SELECT * FROM outside_products WHERE order_id = ?");
                                    $stmt->execute(array($order_id));
                                    $alloutsideproducts = $stmt->fetchAll();

                                    foreach ($alloutsideproducts as $outsidepro) {
                                    ?>
                                        <tr>
                                            <td> <?php echo $outsidepro['product_name'] ?> </td>
                                            <td> <?php echo $outsidepro['product_qty'] ?> </td>
                                            <td> <?php echo $outsidepro['product_qty'] * $outsidepro['main_price']; ?> ر.س </td>
                                            <td></td>
                                        </tr>
                                    <?php
                                    }

                                    ?>
                                </table>
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM outside_services WHERE order_id = ?");
                                $stmt->execute(array($order_id));
                                $alloutsideservs = $stmt->fetchAll();
                                $count_services = $stmt->rowCount();
                                if ($count_services > 0) {
                                ?>
                                    <table class='table table-bordered'>
                                        <thead>
                                            <tr>
                                                <th> اسم الخدمة </th>
                                                <th> سعر الخدمة </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            foreach ($alloutsideservs as $serv) {
                                            ?>
                                                <tr>
                                                    <td> <?php echo $serv['serv_name'] ?> </td>
                                                    <td> <?php echo $serv['main_price'] ?> ر.س </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            <tr>
                                                <td> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php
                                }
                                ?>

                            </div>
                            <div class="order_totals">
                                <div class="price_sections">

                                    <div class="first">

                                        <div>
                                            <h3> تكلفة الإضافات: </h3>
                                            <p> تكلفة الزراعة + تكلفة التغليف كهدية </p>
                                        </div>
                                        <div>
                                            <h2 class="total"> <?php echo number_format($order_data['farm_service_price'], 2); ?> ر.س </h2>
                                        </div>
                                    </div>
                                    <div class="first">
                                        <div>
                                            <h3> الشحن والتسليم: </h3>
                                            <p> يحدد سعر الشحن حسب الموقع </p>
                                        </div>
                                        <div>
                                            <h2 class="total"><?php echo number_format($ship_price, 2); ?> ر.س </h2>
                                        </div>
                                    </div>

                                    <div class="first">
                                        <div>
                                            <h3> كوبون الخصم : </h3>
                                        </div>
                                        <div>
                                            <h2 class="total"><?php
                                                                if ($order_data['coupon_code'] != '') {
                                                                    echo $order_data['coupon_code'];
                                                                } else {
                                                                    echo " لا يوجد ";
                                                                }
                                                                ?> </h2>
                                        </div>
                                    </div>
                                    <div class="first">
                                        <div>
                                            <h3> قيمة الخصم : </h3>
                                        </div>
                                        <div>
                                            <h2 class="total"><?php
                                                                if ($order_data['discount_value'] != '') {
                                                                    echo $order_data['discount_value'];
                                                                } else {
                                                                    echo "0";
                                                                } ?> ر.س </h2>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="first">
                                        <div>
                                            <h3> إجمالي المبلغ: </h3>
                                            <p> المبلغ المطلوب دفعه </p>
                                        </div>
                                        <div>
                                            <h2 class="total"> <?php echo number_format($total_price, 2); ?> ر.س </h2>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <p class="thanks" style="font-size: 14px;"> الرقم الضريبي  <a href="#">  310600908300003   </a> </p>
                                <p class="thanks"> شكرا لتسوقكم من <a href="#"> مشتلي</a> </p>
                            </div>

                        </div>
                        <div class="row" style="display: flex;justify-content: space-between;">
                            <button id="print_Button" onclick="setPrintTitle(); window.print(); return false;" class="global_button btn print-link btn-primary"> طباعة الفاتورة <i class="fa fa-print"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<script>
    function setPrintTitle() {
        // تعيين عنوان مخصص للصفحة ليتم طباعته
        document.title = document.getElementById('customername').value;

        // التأكد من أن العنوان الجديد قد تم تعيينه بشكل صحيح
        console.log("تم تعيين عنوان مخصص للطباعة: " + document.title);

        // إضافة استماع لحدث اكتمال الطباعة لاستعادة العنوان الأصلي بعد الطباعة
        window.onafterprint = function() {
            document.title = document.getElementById('customername').value;
            console.log("استعادة عنوان الصفحة الأصلي: " + document.title);
        };
    }
</script>
<style>
    @media print {

        .footer,
        .bottom_footer,
        .main_navbar,
        .instagrame_footer,
        .main-sidebar,
        #copy-btn {
            display: none !important;
        }

        .print_order {
            max-width: 100% !important;
            padding: 10px !important;
        }

        body {
            background-color: #fff;
        }

        #print_Button {
            display: none !important;
        }

        .print-link {
            display: none !important;
        }

        @page {
            margin: 0;
        }

        body {
            margin: 1.6cm;
        }
    }
</style>