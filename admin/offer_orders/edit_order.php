<style>
    .nav-tabs .nav-link.active {
        color: #111 !important;
    }
</style>
<?php
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    // get order
    $stmt = $connect->prepare("SELECT * FROM offer_orders WHERE id = ?");
    $stmt->execute(array($order_id));
    $order_data = $stmt->fetch();
    // get order details 
    $stmt = $connect->prepare("SELECT * FROM offer_order_details WHERE order_id = ?");
    $stmt->execute(array($order_id));
    $order_details_data = $stmt->fetchAll();
    $items_count = $stmt->rowCount();
    $last_total_price = $order_data['total_price'];
    /// /////// Start Edit Order ////////////
    if (isset($_POST['edit_product_order'])) {
        $product_new_qty = $_POST['product_qty'];
        $record_id = $_POST['record_id'];
        $product_price = $_POST['record_price'];
        $product_old_qty = $_POST['record_qty'];
        if ($product_new_qty != $product_old_qty) {
            $stmt = $connect->prepare("UPDATE offer_order_details SET qty = ? WHERE id = ?");
            $stmt->execute(array($product_new_qty, $record_id));
            // Update Order Tottal Price
            if ($product_new_qty > $product_old_qty) {
                $plus_number_qty = $product_new_qty - $product_old_qty;
                $new_total_price = $last_total_price + ($product_price * $plus_number_qty);
            } elseif ($product_new_qty < $product_old_qty) {
                $minus_number_qty = $product_old_qty - $product_new_qty;
                $new_total_price = $last_total_price - ($product_price * $minus_number_qty);
            }
            $stmt = $connect->prepare("UPDATE offer_orders SET total_price = ? WHERE id = ?");
            $stmt->execute(array($new_total_price, $order_id));
            if ($stmt) {
                header("Location:main.php?dir=offer_orders&page=edit_order&order_id=" . $order_id);
            }
        }
    }
    //// Delete Product From Order 
    if (isset($_POST['delete_product_order'])) {
        $record_id = $_POST['record_id'];
        $product_price = $_POST['record_price'];
        $product_qty = $_POST['record_qty'];
        // Edit Order Total Price
        $new_total_price = $last_total_price - ($product_price * $product_qty);
        $stmt = $connect->prepare("UPDATE offer_orders SET total_price = ? WHERE id = ?");
        $stmt->execute(array($new_total_price, $order_id));
        if ($stmt) {
            $stmt = $connect->prepare("DELETE FROM offer_order_details WHERE id = ?");
            $stmt->execute(array($record_id));
            header("Location:main.php?dir=offer_orders&page=edit_order&order_id=" . $order_id);
        }
    }
    /// Start Add Products
    if (isset($_POST['add_products'])) {
        $select_product = $_POST['select_product'];
        $select_product_vartion = $_POST['select_product_vartion'];
        $product_qty = $_POST['product_qty'];
        $formerror = [];
        if (empty($formerror)) {
            if ($select_product_vartion != '' && $select_product_vartion != null) {
                // Get Product Vartion Price
                $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE id= ?");
                $stmt->execute(array($select_product_vartion));
                $get_vartion_data = $stmt->fetch();
                $product_price = $get_vartion_data['price'];
            } else {
                // Get The Product Price
                $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->execute(array($select_product));
                $product_data = $stmt->fetch();
                $product_price = $product_data['price'];
            }
            $stmt = $connect->prepare("INSERT INTO offer_order_details (order_id,order_number,product_id,qty,product_price,more_details)
            VALUES(:zorder_id,:zorder_number,:zproduct_id,:zqty,:zproduct_price,:zmore_details)
            ");
            $stmt->execute(array(
                'zorder_id' => $order_id,
                "zorder_number" => $order_data['order_number'],
                'zproduct_id' => $select_product,
                "zqty" => $product_qty,
                "zproduct_price" => $product_price,
                "zmore_details" => $select_product_vartion,
            ));
            if ($stmt) {
                // Update Order Total Price
                $new_total_price = $last_total_price + ($product_price * $product_qty);
                $stmt = $connect->prepare("UPDATE offer_orders SET total_price = ? WHERE id = ?");
                $stmt->execute(array($new_total_price, $order_id));
                header("Location:main.php?dir=offer_orders&page=edit_order&order_id=" . $order_id);
?>

    <?php
            }
        }
    }
    ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">  تعديل الطلب الخارجي  </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                        <li class="breadcrumb-item active"> تعديل الطلب الخارجي  </li>
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
    <?php
    if (isset($_SESSION['success_message'])) {
        $message = $_SESSION['success_message'];
        unset($_SESSION['success_message']);
    ?>
        <?php
        ?>
        <script src="plugins/jquery/jquery.min.js"></script>
        <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
        <script>
            $(function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '<?php echo $message; ?>',
                    showConfirmButton: false,
                    timer: 2000
                })
            })
        </script>
        <?php
    } elseif (isset($_SESSION['error_messages'])) {
        $formerror = $_SESSION['error_messages'];
        foreach ($formerror as $error) {
        ?>
            <div class="alert alert-danger alert-dismissible" style="max-width: 800px; margin:20px">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error; ?>
            </div>
    <?php
        }
        unset($_SESSION['error_messages']);
    }
    ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"> معلومات العميل </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  active" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"> تفاصيل الطلب </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-product-tab" data-toggle="pill" href="#custom-tabs-one-product" role="tab" aria-controls="custom-tabs-one-product" aria-selected="false"> اضف منتجات </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                    <!-- START USER ORDER  -->
                                    <!----------------- Start Edit User Data --------------->
                                    <?php
                                    if (isset($_POST['edit_customer_data'])) {
                                        $name = sanitizeInput($_POST['name']);
                                        $email = sanitizeInput($_POST['email']);
                                        $phone = sanitizeInput($_POST['phone']);
                                        $area = sanitizeInput($_POST['area']);
                                        $address = sanitizeInput($_POST['address']);
                                        $stmt = $connect->prepare("UPDATE offer_orders SET name = ?, email = ? , phone = ? , area = ? , address = ? WHERE id = ?");
                                        $stmt->execute(array($name, $email, $phone, $area, $address, $order_id));
                                        if ($stmt) {
                                            header("Location:main.php?dir=offer_orders&page=edit_order&order_id=" . $order_id);
                                        }
                                    }
                                    ?>
                                    <form action="" method="post">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="inputName"> الأسم </label>
                                                    <input required type="text" id="name" name="name" class="form-control" value="<?php echo $order_data['name']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputName"> البريد الألكتروني </label>
                                                    <input required type="text" id="email" name="email" class="form-control" value="<?php echo $order_data['email']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputName"> رقم الهاتف </label>
                                                    <input required type="text" id="phone" name="phone" class="form-control" value="<?php echo $order_data['phone']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputName"> المنطقة </label>
                                                    <input required type="text" id="area" name="area" class="form-control" value="<?php echo $order_data['area']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputName"> الشارع او الحي </label>
                                                    <input required type="text" id="address" name="address" class="form-control" value="<?php echo $order_data['address']; ?>">
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <button type="submit" class="btn btn-primary btn-sm" name="edit_customer_data"> <i class="fa fa-edit"></i> تعديل معلومات العميل </button>
                                        </div>

                                    </form>
                                </div>
                                <div class="tab-pane fade show active" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="">
                                                <?php
                                                foreach ($order_details_data as $order_details) {
                                                    $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                                    $stmt->execute(array($order_details['product_id']));
                                                    $product_data = $stmt->fetch();
                                                    // get the product image 
                                                    $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id=?");
                                                    $stmt->execute(array($product_data['id']));
                                                    $image_data = $stmt->fetch();
                                                    $product_image = $image_data['main_image'];
                                                ?>
                                                    <form method="post" action="">
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <img style="width: 80px; height:80px;" src="product_images/<?php echo $product_image; ?>" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-10">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="record_id" value="<?php echo $order_details['id']; ?>">
                                                                    <input type="hidden" name="record_price" value="<?php echo $order_details['product_price'] ?>">
                                                                    <input type="hidden" name="record_qty" value="<?php echo $order_details['qty'] ?>">
                                                                    <label for="inputStatus"> اسم المنتج </label>
                                                                    <input disabled type="text" name="pro_name" class="form-control" value="<?php echo $product_data['name']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label for="inputName"> العدد </label>
                                                                    <input required min="1" type="number" id="product_qty" name="product_qty" class="form-control" value="<?php echo $order_details['qty']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label for="inputName"> سعر المنتج </label>
                                                                    <input disabled required type="text" id="product_qty" name="product_qty" class="form-control" value="<?php echo $order_details['product_price']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label for="inputName"> المجموع الفرعي </label>
                                                                    <input disabled required type="text" id="sale_price" name="sale_price" class="form-control" value="<?php echo $order_details['product_price'] * $order_details['qty']; ?>">
                                                                </div>
                                                            </div>
                                                            <?php
                                                            // get more details data
                                                            $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE id = ?");
                                                            $stmt->execute(array($order_details['more_details']));
                                                            $more_details_data = $stmt->fetch();
                                                            $more_detail_name = $more_details_data['vartions_name']
                                                            ?>
                                                            <p class="badge badge-danger"><?php echo $more_detail_name; ?></p>
                                                            <br>
                                                            <p style="display: block; width: 100%;"> امكانية الزراعه ::
                                                                <?php if ($order_details['farm_service'] == 0) {
                                                                    echo "لا";
                                                                } else {
                                                                    echo "نعم ";
                                                                } ?> </p>
                                                            <?php
                                                            if ($order_details['as_present'] != null) {
                                                            ?>
                                                                <p> الهدية : <?php
                                                                                $stmt = $connect->prepare("SELECT * FROM gifts WHERE id = ?");
                                                                                $stmt->execute(array($order_details['as_present']));
                                                                                $gift_data = $stmt->fetch();
                                                                                echo $gift_data['name']; ?></p>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <button type="submit" name="edit_product_order" class="btn btn-primary btn-sm"> تعديل <i class="fa fa-edit"></i> </button>
                                                        <button type="submit" name="delete_product_order" class=" confirm btn btn-danger btn-sm"> حذف <i class="fa fa-trash"></i> </button>
                                                    </form>
                                                    <hr>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="description"> ملاحظات</label>
                                                <textarea id="order_details" name="order_details" class="form-control" rows="3"><?php echo $order_data['order_details']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <p class="badge badge-warning" style="font-size: 16px;"> عدد المنتجات ::: </p>
                                                <?php
                                                ?>
                                                <span class="text-strong"> <strong> <?php echo $items_count; ?> </strong> </span>
                                            </div>
                                            <div class="form-group">
                                                <p class="badge badge-secondary" style="font-size: 16px;"> سعر الشحن ::: </p>
                                                <span> <strong> <?php echo $order_data['ship_price']; ?> </strong> ريال </span>
                                            </div>
                                            <div class="form-group">
                                                <p class="badge badge-primary" style="font-size: 16px;"> سعر الاضافات ::: </p>
                                                <span> <strong> <?php echo $order_data['farm_service_price']; ?> </strong> ريال </span>
                                            </div>
                                            <?php
                                            if ($order_data['coupon_code'] != '') {
                                            ?>
                                                <div class="form-group">
                                                    <p class="badge badge-danger" style="font-size: 16px;"> كوبون الخصم ::: </p>
                                                    <span> <strong> <?php echo $order_data['coupon_code']; ?> </strong> </span>
                                                </div>
                                                <div class="form-group">
                                                    <p class="badge badge-danger" style="font-size: 16px;"> قيمه الخصم ::: </p>
                                                    <span> <strong> <?php echo $order_data['discount_value']; ?> </strong> ريال </span>
                                                </div>
                                            <?php
                                            }
                                            ?>

                                            <div class="form-group">
                                                <p class="badge badge-info" style="font-size: 16px;"> السعر الكلي ::: </p>
                                                <span> <strong> <?php echo $order_data['total_price']; ?> </strong> ريال </span>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-product" role="tabpanel" aria-labelledby="custom-tabs-one-product">
                                    <!-- START USER ORDER  -->
                                    <form action="" method="post">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="inputName"> حدد المنتج </label>
                                                    <!-- قائمة المنتجات -->
                                                    <select id="select_products" class="form-control select2" name="select_product">
                                                        <option> - حدد المنتجات - </option>
                                                        <?php
                                                        $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1");
                                                        $stmt->execute();
                                                        $allproducts = $stmt->fetchAll();
                                                        // استعلام لاسترجاع المنتجات
                                                        foreach ($allproducts as $product) {
                                                        ?>
                                                            <option value="<?php echo $product['id'] ?>"><?php echo $product['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label> حدد المتغيرات </label>
                                                    <!-- قائمة المتغيرات -->
                                                    <select id="select_product_vartions" class="form-control select2" name="select_product_vartion">
                                                        <option> -- حدد -- </option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label> العدد </label>
                                                    <input type="text" name="product_qty" required class="form-control">
                                                </div>

                                                <div>
                                                    <br>
                                                    <button class="btn btn-primary btn-sm" name="add_products"> تعديل الطلب <i class="fa fa-plus"></i> </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

            </div>

        </div>

        <!-- /.container-fluid -->
    </section>
<?php
} else {
    header('Location:main.php?dir=offer_orders&page=report');
    exit();
}


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#select_products').change(function() {
            var product_id = $(this).val(); // قيمة المنتج المحدد
            $.ajax({
                url: 'orders/load_variations.php', // المسار إلى ملف PHP الذي يحمل المتغيرات
                type: 'post',
                data: {
                    product_id: product_id
                },
                success: function(response) {
                    $('#select_product_vartions').html(response);
                }
            });
        });
    });
</script>