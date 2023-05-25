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

                                <div class="row" style="background-color: #f1f1f1; padding:10px; margin-top:10px; margin-bottom:10px">
                                    <div class="col-lg-4">
                                        <h3 style="font-size: 20px; color:#7a9d12;margin-top:15px;margin-bottom:20px"> شكرًا لك على طلبك </h3>
                                        <p style="border-bottom: 1px solid #ccc;"> لقد تلقينا طلبك رقم :: <span class="text-bold"><?php echo $order_data['order_number']; ?></span> </p>
                                        <p style="border-bottom: 1px solid #ccc;"> وذلك بتاريخ :: <span class="text-bold"><?php echo $order_data['order_date']; ?></span> </p>
                                        <p> حالة الدفع :: <span class="text-bold"><?php echo $order_data['payment_method']; ?></span> </p>
                                    </div>
                                    <hr>
                                    <div class="col-lg-4">
                                        <h3 style="font-size: 20px; color:#7a9d12;margin-top:15px;margin-bottom:20px"> عنوان الفاتورة </h3>
                                        <ul class="list-unstyled" style="line-height: 2;">
                                            <li style="border-bottom: 1px solid #ccc;"> الاسم : <?php echo $order_data['name']; ?></li>
                                            <li style="border-bottom: 1px solid #ccc;"> البريد الالكتروني : <?php echo $order_data['email']; ?></li>
                                            <li style="border-bottom: 1px solid #ccc;"> رقم الهاتف : <?php echo $order_data['phone']; ?></li>
                                            <li style="border-bottom: 1px solid #ccc;"> المنطقة : <?php
                                                                                                    $stmt = $connect->prepare("SELECT * FROM area WHERE id = ?");
                                                                                                    $stmt->execute(array($order_data['area']));
                                                                                                    $area_data = $stmt->fetch();
                                                                                                    echo $area_data['name']; ?></li>
                                            <li> المدينة : <?php echo $order_data['city']; ?></li>
                                            <li> العنوان : <?php echo $order_data['address']; ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-4">
                                        <h3 style="font-size: 20px; color:#7a9d12;margin-top:15px;margin-bottom:20px"> عنوان الشحن </h3>
                                        <ul class="list-unstyled" style="line-height: 2;">
                                            <li style="border-bottom: 1px solid #ccc;"> الاسم : <?php
                                                                                                if (!empty($order_data['ship_name'])) {
                                                                                                    echo $order_data['ship_name'];
                                                                                                } else {
                                                                                                    echo $order_data['name'];
                                                                                                }
                                                                                                ?></li>
                                            <li style="border-bottom: 1px solid #ccc;"> رقم الهاتف : <?php if (!empty($order_data['ship_phone'])) {
                                                                                                            echo $order_data['ship_phone'];
                                                                                                        } else {
                                                                                                            echo $order_data['phone'];
                                                                                                        } ?></li>
                                            <li style="border-bottom: 1px solid #ccc;"> المنطقة : <?php
                                                                                                    if (!empty($order_data['ship_area'])) {
                                                                                                        $ship_area = $order_data['ship_area'];
                                                                                                    } else {
                                                                                                        $ship_area = $order_data['area'];
                                                                                                    }
                                                                                                    $stmt = $connect->prepare("SELECT * FROM area WHERE id =  ?");
                                                                                                    $stmt->execute(array($ship_area));
                                                                                                    $area_data = $stmt->fetch();
                                                                                                    echo $area_data['name']; ?>
                                            </li>
                                            <li> المدينة : <?php
                                                            if (!empty($order_data['ship_city'])) {
                                                                echo $order_data['ship_city'];
                                                            } else {
                                                                echo $order_data['city'];
                                                            }
                                                            ?></li>
                                            <li> العنوان : <?php
                                                            if (!empty($order_data['ship_address'])) {
                                                                echo $order_data['ship_address'];
                                                            } else {
                                                                echo $order_data['address'];
                                                            }
                                                            ?></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div class="order_details">
                                <h3 style="font-size: 20px; color:#7a9d12;margin-top:15px;"> تفاصيل الطلب </h3>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th> المنتج </th>
                                            <th> صورة المنتج </th>
                                            <th> الكمية </th>
                                            <th> السعر </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stmt = $connect->prepare("SELECT * FROM order_details WHERE order_id = ?");
                                        $stmt->execute(array($order_id));
                                        $allorder_details = $stmt->fetchAll();
                                        foreach ($allorder_details as $order_detail) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                                    $stmt->execute(array($order_detail['product_id']));
                                                    $product_data = $stmt->fetch();
                                                    echo $product_data['name'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($product_data['main_image']) && strpos($product_data['main_image'], "https://www.mshtly.com") !== false) { ?>
                                                        <img style="width: 80px; height:80px;" src="<?php echo $product_data['main_image']; ?>" alt="">
                                                    <?php } elseif (!empty($product_data['main_image'])) { ?>
                                                        <img style="width: 80px; height:80px;" src="product_images/<?php echo $product_data['main_image']; ?>" alt="">
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $order_detail['qty']; ?> </td>
                                                <td><?php echo $order_detail['total']; ?> ر.س </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th> تكلفه الشحن </th>
                                            <th> اجمالي الفاتورة </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> <?php echo  $order_data['ship_price'] ?> ر.س </td>
                                            <td class="text-bold"> <?php echo  $order_data['total_price'] ?> ر.س </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="row" style="display: flex;justify-content: space-between;">
                            <button class="btn btn-primary btn-sm" id="print_Button" onclick="printDiv()"> <i class="fa fa-print"></i> طباعه الفاتورة </button>
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
        body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        #print_Button {
            display: none !important;
        }
    }
</style>
<script type="text/javascript">
    function printDiv() {
        var printContents = document.getElementById('print').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>