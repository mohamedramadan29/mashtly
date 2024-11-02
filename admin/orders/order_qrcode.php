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
    $stmt = $connect->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute(array($order_id));
    $order_data = $stmt->fetch();
    $ship_price = $order_data['ship_price'];
    $order_date = $order_data['order_date'];
    $total_price = $order_data['total_price'];
}
$pagetitle = 'Mohamed';
?>
<?php

include 'order_qrcode/phpqrcode/qrlib.php';

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> ملصقات الطلب </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> ملصقات الطلب </li>
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
                <div class="card-body" id="print">
                    <?php
                    $stmt = $connect->prepare("SELECT * FROM order_details WHERE order_id = ?");
                    $stmt->execute(array($order_id));
                    $alldetails = $stmt->fetchAll();
                    foreach ($alldetails as $details) {
                        // get product data
                        $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                        $stmt->execute(array($details['product_id']));
                        $product_data = $stmt->fetch();
                        // رابط صفحة المنتج
                        $productUrl = 'https://www.mshtly.com/product/' . $product_data['slug'];

                        // توليد رمز QR كصورة Base64
                        ob_start();
                        QRcode::png($productUrl, null, QR_ECLEVEL_L, 4);
                        $imageString = base64_encode(ob_get_contents());
                        ob_end_clean();

                        $qrCodeImage = 'data:image/png;base64,' . $imageString;
                    ?>
                        <div class="">
                            <!-- <div class="logo text-center">
                                <img style="max-width: 100%;" src="uploads/qr_header.png" alt="">
                            </div> -->

                            <div class="shap_info">
                                <img class="shap_logo" src="uploads/logo.png">
                                <div class="product_info">
                                    <div style="max-width: 50%;">
                                        <h4> اسم المنتج : </h4>
                                        <p> <?php echo $product_data['name']; ?> </p>
                                    </div>
                                    <div>
                                        <h4> رمز QR لصفحة المنتج: </h4>
                                        <img src="<?php echo $qrCodeImage; ?>" alt="QR Code لصفحة المنتج">
                                    </div>
                                </div>
                                <div class="person_info">
                                    <p> <span> اسم العميل :: </span> <?php echo $order_data['name']; ?> </p>
                                    <input type="hidden" id="customername" value="<?php echo $order_data['name']; ?>">
                                    <p> <span> رقم الطلب :: </span> # <?php echo $order_data['order_number']; ?> </p>
                                </div>
                                <div class="more_info">
                                    <h5> لمزيد من المعلومات والعناية، </br> تواصل مع خبرائنا أسفل البطاقة </h5>
                                    <img src="uploads/last_shap_image.png" alt="">
                                </div>
                            </div>
                            <!-- <div class="mshtly_qr">
                                <img src="uploads/mshtly_qr.png" alt="">
                            </div> -->
                        </div>
                        </br>
                        </br>
                        </br>
                        </br>
                    <?php
                    }
                    ?>
                    <div class="row" style="text-align: center;margin: auto;display: block;">
                        <button id="print_Button" onclick="setPrintTitle(); window.print(); return false;" class="global_button btn print-link btn-primary btn-sm"> طباعة الفاتورة <i class="fa fa-print"></i> </button>
                    </div>
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
                </div>
            </div>
        </div>
        <style>
            .shap_info {
                border: 2px solid #000;
                padding-top: 20px;
                margin: 15px;
            }

            .shap_info .shap_logo {
                display: block;
                width: 90px;
                text-align: center;
                margin: auto;
            }

            .shap_info .product_info {
                display: flex;
                justify-content: space-between;
                padding: 10px;
                border-bottom: 2px solid #000;
            }

            .shap_info .product_info h4 {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 15px;
                color: #000;
            }

            .shap_info .product_info p {}

            .shap_info .product_info img {}

            .person_info {
                padding: 10px;
            }

            .person_info p {
                font-weight: bold;
                color: #000;
            }

            .person_info p span {}

            .more_info {
                padding: 10px;
                border-top: 2px solid #000;
                display: flex;
                justify-content: space-between;
            }

            .more_info h5 {
                font-weight: bold;
                line-height: 1.8;
                color: #000;
            }

            .more_info img {
                width: 90px;
            }

            .mshtly_qr {}

            .mshtly_qr img {
                max-width: 75%;
                margin: auto;
                display: block;
            }
        </style>
    </div>
    <!-- /.container-fluid -->
</section>

<style>
    #print {
        width: 15cm !important;
        height: auto;
        /* الطول يكون بحسب المحتوى */
        margin: auto;
        padding: 0;
        background-color: #fff;
    }


    @media print {

        .footer,
        .bottom_footer,
        .main_navbar,
        .instagrame_footer,
        .main-sidebar,
        #copy-btn {
            display: none !important;
        }


        #print {
            width: 15cm !important;
            height: auto;
            /* الطول يكون بحسب المحتوى */
            margin: auto;
            padding: 0;
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