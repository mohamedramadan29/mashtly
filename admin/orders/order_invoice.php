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
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> فاتورة الطلب </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> فاتورة الطلب </li>
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
                            </div>
                            <div class="header_data">
                                <div class="row" style=" padding:10px; margin-top:10px; margin-bottom:10px">
                                    <h2> مرحبا <?php echo $order_data['name']; ?> </h2>
                                    <p> شكرا لطلبك، من مشتلي تم تأكيد طلبك وسوف يصلك في الوقت المحدد لإلغاء الطلب أو تعديله يرجي زيارة الموقع قسم <span style="color: #7a9d12;">مشترياتي</span> </p>
                                    <p style="display: block;"> يوجد أدناه فاتورة برقم الطلب وتفاصيله </p>
                                    <div class="d-flex ul_div">
                                        <ul class="list-unstyled">
                                            <li> <span> رقم الطلب: </span> </li>
                                            <li> <span> تاريخ الطلب: </span> </li>
                                            <li> <span> الاسم: </span> </li>
                                            <li> <span> البريد الألكتروني : </span> </li>
                                            <li> <span> رقم الجوال: </span> </li>
                                        </ul>
                                        <ul class="list-unstyled">
                                            <li> <?php echo $order_data['order_number']; ?> </li>
                                            <li> <?php echo $order_data['order_date']; ?> </li>
                                            <li> <?php echo $order_data['name']; ?> </li>
                                            <li> <?php echo $order_data['email']; ?> </li>
                                            <li> <?php echo $order_data['phone']; ?> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="order_details">
                                <h4> تفاصيل الطلب </h4>
                                <div class="order">
                                    <div>
                                        <h6> المنتج </h6>
                                    </div>
                                    <div style="display: flex;justify-content: space-between;min-width: 40%;">
                                        <div>
                                            <h6> الكمية </h6>
                                        </div>
                                        <div>
                                            <h6> إجمالي السعر </h6>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM order_details WHERE order_id = ?");
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
                                    <div class="order" style="display: flex;">
                                        <div>
                                            <div class="product_data">
                                                <div class="image">
                                                    <img src="product_images/<?php echo $image ?>" alt="">
                                                </div>
                                                <div>
                                                    <h4> <?php echo $product_data['name']; ?> </h4>
                                                    <p> <?php echo number_format($product_data['price'], 2); ?> ر.س </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display: flex;justify-content: space-between;min-width: 30%;">
                                            <div>
                                                <span> <?php echo $details['qty']; ?> </span>
                                            </div>
                                            <div>
                                                <span> <?php echo  number_format($details['qty'] * $details['total'], 2); ?> ر.س </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }

                                ?>
                            </div>
                            <div class="order_totals">
                                <div class="price_sections">
                                    <div class="first">
                                        <div>
                                            <h3> المجموع الفرعي: </h3>
                                            <p> إجمالي سعر المنتجات في السلة </p>
                                        </div>
                                        <div>
                                            <h2 class="total"> <?php echo number_format(50, 2); ?> ر.س </h2>
                                        </div>
                                    </div>
                                    <div class="first">
                                        <div>
                                            <h3> تكلفة الإضافات: </h3>
                                            <p> تكلفة الزراعة + تكلفة التغليف كهدية </p>
                                        </div>
                                        <div>
                                            <h2 class="total"> <?php echo number_format(40, 2); ?> ر.س </h2>
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
                                            <h3> ضريبة القيمة المضافة VAT: </h3>
                                            <p> القيمة المضافة تساوي 15% من اجمالي الطلب </p>
                                        </div>
                                        <div>
                                            <?php
                                            $vat = $total_price * (15 / 100);

                                            ?>
                                            <h2 class="total"> <?php echo number_format($vat, 2); ?> ر.س </h2>
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
                                <p class="thanks"> شكرا لتسوقكم من <a href="#"> مشتلي </a> </p>
                            </div>

                        </div>
                        <div class="row" style="display: flex;justify-content: space-between;">
                            <button id="print_Button" onclick="window.print(); return false;" class="global_button btn print-link btn-primary"> طباعة الفاتورة <i class="fa fa-print"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<style>
    @media print {

        .footer,
        .bottom_footer,
        .main_navbar,
        .instagrame_footer,
        .main-sidebar {
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