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
  // get order attachment 
  // get order process
?>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">  تفاصيل عرض السعر  </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
            <li class="breadcrumb-item active"> تفاصيل عرض السعر  </li>
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
                  <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"> معلومات العميل </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"> تفاصيل الطلب </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-outsideproduct-tab" data-toggle="pill" href="#custom-tabs-one-outsideproduct" role="tab" aria-controls="custom-tabs-one-outsideproduct" aria-selected="false"> المنتجات الخارجية </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-outsideservices-tab" data-toggle="pill" href="#custom-tabs-one-outsideservices" role="tab" aria-controls="custom-tabs-one-outsideservices" aria-selected="false"> الخدمات الخارجية </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-order_status" role="tab" aria-controls="custom-tabs-one-order_status" aria-selected="false"> حاله الطلب </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false"> المرفقات </a>
                </li>

              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                  <!-- START USER ORDER  -->
                  <form action="" method="post">
                    <div class="row">
                      <div class="col-lg-6">
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
                      <div class="col-lg-6">
                        <div class="card-header bg-warning">
                          معلومات الشحن
                        </div>
                        <div class="form-group">
                          <label for="inputName"> الأسم </label>
                          <input required type="text" id="ship_name" name="ship_name" class="form-control" value="<?php echo $order_data['ship_name']; ?>">
                        </div>
                        <div class="form-group">
                          <label for="inputName"> رقم الهاتف </label>
                          <input required type="text" id="ship_phone" name="ship_phone" class="form-control" value="<?php echo $order_data['ship_phone']; ?>">
                        </div>
                        <?php
                        if (!empty($order_data['ship_area'])) {
                          $ship_area = $order_data['ship_area'];
                          $stmt = $connect->prepare("SELECT * FROM area WHERE id=?");
                          $stmt->execute(array($ship_area));
                          $ship_area_data = $stmt->fetch();
                        ?>
                          <div class="form-group">
                            <label for="inputName"> المنطقة </label>
                            <input required type="text" id="ship_area" name="ship_area" class="form-control" value="<?php echo $ship_area_data['name']; ?>">
                          </div>
                        <?php
                        } else {
                        ?>
                          <div class="form-group">
                            <label for="inputName"> المنطقة </label>
                            <input required type="text" id="ship_area" name="ship_area" class="form-control" value="">
                          </div>
                        <?php
                        }

                        ?>
                        <div class="form-group">
                          <label for="inputName"> الشارع او الحي </label>
                          <input required type="text" id="ship_address" name="ship_address" class="form-control" value="<?php echo $order_data['ship_address']; ?>">
                        </div>
                      </div>
                    </div>

                  </form>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                  <form action="" method="post">
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
                            <div class="row">
                              <div class="col-lg-2">
                                <div class="form-group">
                                  <img style="width: 80px; height:80px;" src="product_images/<?php echo $product_image; ?>" alt="">
                                </div>
                              </div>
                              <div class="col-lg-10">
                                <div class="form-group">
                                  <label for="inputStatus"> اسم المنتج </label>
                                  <input type="text" name="pro_name" class="form-control" value="<?php echo $product_data['name']; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-4">
                                <div class="form-group">
                                  <label for="inputName"> العدد </label>
                                  <input required type="text" id="product_qty" name="product_qty" class="form-control" value="<?php echo $order_details['qty']; ?>">
                                </div>
                              </div>
                              <div class="col-4">
                                <div class="form-group">
                                  <label for="inputName"> سعر المنتج </label>
                                  <input required type="text" id="product_qty" name="product_qty" class="form-control" value="<?php echo $order_details['product_price']; ?>">
                                </div>
                              </div>
                              <div class="col-4">
                                <div class="form-group">
                                  <label for="inputName"> المجموع الفرعي </label>
                                  <input required type="text" id="sale_price" name="sale_price" class="form-control" value="<?php echo $order_details['product_price'] * $order_details['qty']; ?>">
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
                            <hr>
                          <?php
                          }
                          ?>
                        </div>

                        <!------------------------------------------- Start OutSide Products ---------------->
                        <h6 class='bg bg-primary' style="padding: 6px;"> المنتجات الخارجية </h6>
                        <form action="" method="post">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="">
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM offer_products WHERE order_id = ?");
                                $stmt->execute(array($order_id));
                                $alloutside_products = $stmt->fetchAll();
                                $count_outsideproducts = $stmt->rowCount();
                                $total_outsideproducts = 0;
                                foreach ($alloutside_products as $outside_product) {
                                  $total_outsideproducts = $total_outsideproducts + ($outside_product['main_price'] * $outside_product['product_qty']);
                                ?>
                                  <div class="row">
                                    <div class="col-lg-8">
                                      <div class="form-group">
                                        <label for="inputStatus"> اسم المنتج </label>
                                        <input type="text" name="pro_name" class="form-control" value="<?php echo $outside_product['product_name']; ?>">
                                      </div>
                                    </div>
                                    <div class="col-lg-4">
                                      <div class="form-group">
                                        <label for="inputStatus"> نوع المنتج </label>
                                        <input type="text" name="pro_name" class="form-control" value="<?php echo $outside_product['product_type']; ?>">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-3">
                                      <div class="form-group">
                                        <label for="inputName"> العدد </label>
                                        <input required type="text" id="product_qty" name="product_qty" class="form-control" value="<?php echo $outside_product['product_qty']; ?>">
                                      </div>
                                    </div>
                                    <div class="col-3">
                                      <div class="form-group">
                                        <label for="inputName"> السعر الاولي </label>
                                        <input required type="text" id="product_qty" name="product_qty" class="form-control" value="<?php echo $outside_product['first_price']; ?>">
                                      </div>
                                    </div>
                                    <div class="col-3">
                                      <div class="form-group">
                                        <label for="inputName"> سعر التنفيذ </label>
                                        <input required type="text" id="product_qty" name="product_qty" class="form-control" value="<?php echo $outside_product['main_price']; ?>">
                                      </div>
                                    </div>
                                    <div class="col-3">
                                      <div class="form-group">
                                        <label for="inputName"> المجموع الفرعي </label>
                                        <input required type="text" id="sale_price" name="sale_price" class="form-control" value="<?php echo $outside_product['main_price'] * $outside_product['product_qty']; ?>">
                                      </div>
                                    </div>
                                    <p class="badge badge-danger"> طول المنتج : <?php echo $outside_product['product_tail']; ?></p>
                                  </div>

                                <?php
                                }
                                ?>
                              </div>
                            </div>

                          </div>

                        </form>

                        <!------------------------------------------- End OutSide Products ---------------->

                        <!------------------------------------------- Start OutSide Services ---------------->
                        <h6 class='bg bg-primary' style="padding: 6px;"> الخدمات الخارجية </h6>
                        <form action="" method="post">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="">
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM offer_services WHERE order_id = ?");
                                $stmt->execute(array($order_id));
                                $alloutside_services = $stmt->fetchAll();
                                $count_outsideservices = $stmt->rowCount();
                                $total_outsideservices = 0;
                                foreach ($alloutside_services as $outside_services) {
                                  $total_outsideservices = $total_outsideservices + $outside_services['main_price'];
                                ?>

                                  <div class="row">
                                    <div class="col-lg-12">
                                      <div class="form-group">
                                        <label for="inputStatus"> اسم الخدمة </label>
                                        <input type="text" name="pro_name" class="form-control" value="<?php echo $outside_services['serv_name']; ?>">
                                      </div>
                                    </div>

                                  </div>
                                  <div class="row">

                                    <div class="col-6">
                                      <div class="form-group">
                                        <label for="inputName"> السعر الاولي </label>
                                        <input required type="text" id="product_qty" name="product_qty" class="form-control" value="<?php echo $outside_services['first_price']; ?>">
                                      </div>
                                    </div>
                                    <div class="col-6">
                                      <div class="form-group">
                                        <label for="inputName"> سعر التنفيذ </label>
                                        <input required type="text" id="product_qty" name="product_qty" class="form-control" value="<?php echo $outside_services['main_price']; ?>">
                                      </div>
                                    </div>
                                  </div>
                                <?php
                                }
                                ?>
                              </div>
                            </div>

                          </div>

                        </form>

                        <!------------------------------------------ End OutSide Services --------------->
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="description"> ملاحظات</label>
                          <textarea id="order_details" name="order_details" class="form-control" rows="3"><?php echo $order_data['order_details']; ?></textarea>
                        </div>
                        <div class="form-group">
                          <p class="badge badge-warning" style="font-size: 16px;"> عدد المنتجات من المتجر ::: </p>
                          <span class="text-strong"> <strong> <?php echo $items_count; ?> </strong> </span>
                        </div>

                        <div class="form-group">
                          <p class="badge badge-warning" style="font-size: 16px;"> عدد المنتجات الخارجية ::: </p>
                          <span class="text-strong"> <strong> <?php echo $count_outsideproducts; ?> </strong> </span>
                        </div>

                        <div class="form-group">
                          <p class="badge badge-warning" style="font-size: 16px;"> عدد الخدمات الخارجية ::: </p>
                          <span class="text-strong"> <strong> <?php echo $count_outsideservices; ?> </strong> </span>
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

                  </form>
                </div>

                <!-------------------------------- Start Main  OutSide Product ------------------------------>

                <div class="tab-pane fade" id="custom-tabs-one-outsideproduct" role="tabpanel" aria-labelledby="custom-tabs-one-outsideproduct-tab">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="">
                        <?php
                        $stmt = $connect->prepare("SELECT * FROM offer_products WHERE order_id = ?");
                        $stmt->execute(array($order_id));
                        $alloutside_products = $stmt->fetchAll();

                        foreach ($alloutside_products as $outside_product) {
                        ?>
                          <form method="post" action="">
                            <div class="row">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <input type='hidden' name='outside_product_id' value="<?php echo $outside_product['id']; ?>">
                                  <label for="inputStatus"> اسم المنتج </label>
                                  <input type="text" name="outsideproduct_name" class="form-control" value="<?php echo $outside_product['product_name']; ?>">
                                </div>
                              </div>
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label for="inputStatus"> نوع المنتج </label>
                                  <select class='select2 form-control' name="outsideproduct_type">
                                    <option <?php if ($outside_product['product_type'] == 'نباتات') echo 'selected'; ?> value="نباتات">نباتات</option>
                                    <option <?php if ($outside_product['product_type'] == 'مستلزمات') echo 'selected'; ?> value="مستلزمات"> مستلزمات </option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label for="inputStatus"> طول المنتج </label>
                                  <select name="outside_product_tail" id="product_tail" class='form-control select2'>
                                    <option value=""> حدد الطول</option>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM shipping_weight_tools");
                                    $stmt->execute();
                                    $alltails = $stmt->fetchAll();
                                    foreach ($alltails as $tail) {
                                    ?>
                                      <option <?php if ($tail['tail'] == $outside_product['product_tail']) echo 'selected'; ?> value="<?php echo $tail['tail']; ?>"> <?php echo $tail['tail']; ?> </option>
                                    <?php
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-3">
                                <div class="form-group">
                                  <label for="inputName"> العدد </label>
                                  <input required type="text" id="outsideproduct_qty" name="outsideproduct_qty" class="form-control" value="<?php echo $outside_product['product_qty']; ?>">
                                </div>
                              </div>
                              <div class="col-3">
                                <div class="form-group">
                                  <label for="inputName"> السعر الاولي </label>
                                  <input required type="text" id="outsideproduct_first_price" name="outsideproduct_first_price" class="form-control" value="<?php echo $outside_product['first_price']; ?>">
                                </div>
                              </div>
                              <div class="col-3">
                                <div class="form-group">
                                  <label for="inputName"> سعر التنفيذ </label>
                                  <input required type="text" id="product_qty" name="outsideproduct_main_price" class="form-control" value="<?php echo $outside_product['main_price']; ?>">
                                </div>
                              </div>
                              <div class="col-3">
                                <div class="form-group">
                                  <label for="inputName"> المجموع الفرعي </label>
                                  <input disabled type="text" id="sale_price" name="sale_price" class="form-control" value="<?php echo $outside_product['main_price'] * $outside_product['product_qty']; ?>">
                                </div>
                              </div>
                              <p class="badge badge-danger"> طول المنتج : <?php echo $outside_product['product_tail']; ?></p>
                            </div>
                            <div class='d-flex'>
                              <button type="submit" name="edit_outsideproduct" class="btn btn-primary btn-sm"> تعديل <i class="fa fa-edit"></i> </button>
                              <button type="submit" name="delete_outsideproduct" class=" confirm btn btn-danger btn-sm"> حذف <i class="fa fa-trash"></i> </button>
                            </div>
                          </form>
                          <?php
                          if (isset($_POST['edit_outsideproduct'])) {
                            $outsideproduct_id = $_POST['outside_product_id'];
                            $outsideproduct_name = $_POST['outsideproduct_name'];
                            $outsideproduct_type = $_POST['outsideproduct_type'];
                            $outsideproduct_qty = $_POST['outsideproduct_qty'];
                            $outsideproduct_first_price = $_POST['outsideproduct_first_price'];
                            $outsideproduct_main_price = $_POST['outsideproduct_main_price'];
                            $outside_product_tail = $_POST['outside_product_tail'];

                            $stmt = $connect->prepare("UPDATE offer_products SET product_name=?,product_qty=?,product_type=?,product_tail=?,first_price=?,main_price=? WHERE id = ?");
                            $stmt->execute(array($outsideproduct_name, $outsideproduct_qty, $outsideproduct_type, $outside_product_tail, $outsideproduct_first_price, $outsideproduct_main_price, $outsideproduct_id));

                            if ($stmt) {
                              header("Location:main.php?dir=offer_orders&page=order_details&order_id=" . $order_id);
                            }
                          }

                          if (isset($_POST['delete_outsideproduct'])) {
                            $outsideproduct_id = $_POST['outside_product_id'];
                            $stmt = $connect->prepare("DELETE FROM offer_products  WHERE id = ?");
                            $stmt->execute(array($outsideproduct_id));
                            if ($stmt) {
                              header("Location:main.php?dir=offer_orders&page=order_details&order_id=" . $order_id);
                            }
                          }
                          ?>

                        <?php
                        }
                        ?>
                      </div>
                    </div>
                    <div class="col-lg-6">

                      <div class="form-group">
                        <p class="badge badge-info" style="font-size: 16px;"> السعر الكلي للمنتجات الخارجية ::: </p>
                        <span> <strong> <?php echo $total_outsideproducts; ?> </strong> ريال </span>
                      </div>
                    </div>
                  </div>
                </div>

                <!------------------------------------- End Main OutSide Product ------------------------------->



                <!-------------------------------- Start Main OutSide Services  ------------------------------>

                <div class="tab-pane fade" id="custom-tabs-one-outsideservices" role="tabpanel" aria-labelledby="custom-tabs-one-outsideservices-tab">

                  <div class="row">
                    <div class="col-lg-6">
                      <div class="">
                        <?php
                        $stmt = $connect->prepare("SELECT * FROM offer_services WHERE order_id = ?");
                        $stmt->execute(array($order_id));
                        $alloutside_services = $stmt->fetchAll();
                        foreach ($alloutside_services as $outside_services) {
                        ?>
                          <form method='post' action="">
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="form-group">
                                  <input type='hidden' name='outsideserv_id' value='<?php echo $outside_services['id'] ?>'>
                                  <label for="inputStatus"> اسم الخدمة </label>
                                  <input type="text" name="outside_service_name" class="form-control" value="<?php echo $outside_services['serv_name']; ?>">
                                </div>
                              </div>

                            </div>
                            <div class="row">

                              <div class="col-6">
                                <div class="form-group">
                                  <label for="inputName"> السعر الاولي </label>
                                  <input required type="text" id="outside_service_first_price" name="outside_service_first_price" class="form-control" value="<?php echo $outside_services['first_price']; ?>">
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group">
                                  <label for="inputName"> سعر التنفيذ </label>
                                  <input required type="text" id="outside_service_main_price" name="outside_service_main_price" class="form-control" value="<?php echo $outside_services['main_price']; ?>">
                                </div>
                              </div>
                            </div>
                            <div class='d-flex'>
                              <button type="submit" name="edit_outsideserv" class="btn btn-primary btn-sm"> تعديل <i class="fa fa-edit"></i> </button>
                              <button type="submit" name="delete_outsideserv" class=" confirm btn btn-danger btn-sm"> حذف <i class="fa fa-trash"></i> </button>
                            </div>
                          </form>
                          <?php
                          if (isset($_POST['edit_outsideserv'])) {
                            $outsideserv_id = $_POST['outsideserv_id'];
                            $outside_service_name = $_POST['outside_service_name'];
                            $outside_service_first_price = $_POST['outside_service_first_price'];
                            $outside_service_main_price = $_POST['outside_service_main_price'];

                            $stmt = $connect->prepare("UPDATE offer_services SET serv_name=?,first_price = ? , main_price=? WHERE id=?");
                            $stmt->execute(array($outside_service_name, $outside_service_first_price, $outside_service_main_price, $outsideserv_id));

                            if ($stmt) {
                              header("Location:main.php?dir=offer_orders&page=order_details&order_id=" . $order_id);
                            }
                          }
                          if (isset($_POST['delete_outsideserv'])) {
                            $outsideserv_id = $_POST['outsideserv_id'];

                            $stmt = $connect->prepare("DELETE FROM offer_services WHERE id = ?");
                            $stmt->execute(array($outsideserv_id));

                            if ($stmt) {
                              header("Location:main.php?dir=offer_orders&page=order_details&order_id=" . $order_id);
                            }
                          }
                          ?>
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                    <div class="col-lg-6">

                      <div class="form-group">
                        <p class="badge badge-info" style="font-size: 16px;"> السعر الكلي للخدمات الخارجية ::: </p>
                        <span> <strong> <?php echo $total_outsideservices ?> </strong> ريال </span>
                      </div>
                    </div>
                  </div>

                </div>

                <!------------------------------------- Start Main  OutSide Services  ------------------------------->
                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <?php
                        if (isset($_SESSION['admin_username'])) { ?>
                          <!-- <button type="button" class="btn btn-warning waves-effect" data-toggle="modal" data-target="#add-Modal"> اضافة عملية جديدة علي الطلب <i class="fa fa-plus"></i> </button> -->
                        <?php
                        }
                        ?>
                        <div class="card-body">
                          <div class="table-responsive">
                            <table id="my_table2" class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                  <th> # </th>
                                  <th> رقم الطلب </th>
                                  <th> اسم العملية </th>
                                  <th> تاريخ العملية </th>
                                  <th> حالة العملية </th>
                                  <th> الموظف </th>
                                  <th> </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                if (isset($_SESSION['username'])) {
                                  $stmt = $connect->prepare("SELECT * FROM offer_order_steps WHERE order_id=? AND username=?");
                                  $stmt->execute(array($order_id, $_SESSION['id']));
                                } else {
                                  $stmt = $connect->prepare("SELECT * FROM offer_order_steps WHERE order_id=?");
                                  $stmt->execute(array($order_id));
                                }
                                $allsteps = $stmt->fetchAll();
                                $i = 0;
                                foreach ($allsteps as $step) {
                                  $i++;
                                ?>
                                  <tr>
                                    <td> <?php echo $i; ?> </td>
                                    <td> <?php echo  $step['order_number']; ?> </td>
                                    <td> <span class="badge badge-danger"> <?php echo  $step['step_name']; ?> </span> </td>
                                    <td> <?php echo  $step['date']; ?> </td>
                                    <td> <span class="badge badge-info"> <?php echo  $step['step_status']; ?> </span> </td>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM employes WHERE id = ?");
                                    $stmt->execute(array($step['username']));
                                    $user_data = $stmt->fetch();
                                    ?>
                                    <td> <?php echo  $user_data['username']; ?> </td>
                                    <td>
                                      <?php
                                      if (isset($_SESSION['admin_username'])) {
                                      ?>
                                        <!--   <a href="main.php?dir=orders&page=order_details&order_id=<?php echo $step['id']; ?>" class="btn btn-success waves-effect btn-sm"> متابعة العملية <i class='fa fa-eye'></i></a> -->
                                        <?php
                                      } elseif (isset($_SESSION['username'])) {
                                        if ($user_data['role_name'] == 'التواصل') {
                                        ?>
                                          <a href="main.php?dir=orders&page=edit_step&step_id=<?php echo $step['id']; ?>" class="btn btn-info waves-effect btn-sm"> متابعه التواصل مع العميل <i class='fa fa-eye'></i></a>
                                        <?php
                                        } elseif ($user_data['role_name'] == 'التجهيز') {
                                        ?>
                                          <a href="main.php?dir=orders&page=prepare_order&step_id=<?php echo $step['id']; ?>" class="btn btn-info waves-effect btn-sm"> تجهيز الطلب <i class='fa fa-eye'></i></a>
                                        <?php
                                        } elseif ($user_data['role_name'] == 'الجودة') {
                                        ?>
                                          <a href="main.php?dir=orders&page=quality_order&step_id=<?php echo $step['id']; ?>" class="btn btn-info waves-effect btn-sm"> ملاحظات الجودة <i class='fa fa-eye'></i></a>
                                        <?php
                                        } elseif ($user_data['role_name'] == 'التوصيل') {
                                        ?>
                                          <a href="main.php?dir=orders&page=order_delivery&step_id=<?php echo $step['id']; ?>" class="btn btn-info waves-effect btn-sm"> توصيل واتمام الطلب <i class='fa fa-eye'></i></a>
                                        <?php
                                        } elseif ($user_data['role_name'] == 'المحاسبة') {
                                        ?>
                                          <a href="main.php?dir=orders&page=accounting&step_id=<?php echo $step['id']; ?>" class="btn btn-info waves-effect btn-sm"> المحاسبة <i class='fa fa-eye'></i></a>
                                      <?php
                                        }
                                      }
                                      ?>
                                    </td>
                                  </tr>
                                <?php
                                }
                                ?>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.col -->
                    <!-- ADD NEW CATEGORY MODAL   -->
                    <div class="modal fade" id="add-Modal" tabindex="-1" role="dialog">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">أضافة عملية </h4>
                          </div>
                          <form action="main.php?dir=orders&page=add_step" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                              <div class="form-group">
                                <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                                <input type="hidden" name="order_number" value="<?php echo $order_data['order_number']; ?>">
                                <label for="Company-2" class="block"> الموظف </label>
                                <select required class='form-control select2' name='username'>
                                  <option value=""> -- اختر -- </option>
                                  <?php
                                  $stmt = $connect->prepare("SELECT * FROM employes");
                                  $stmt->execute();
                                  $allemp = $stmt->fetchAll();
                                  foreach ($allemp as $emp) {
                                  ?>
                                    <option value="<?php echo $emp['id']; ?>"> <?php echo $emp['username'] ?> </option>
                                  <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="Company-2" class="block"> حدد العملية الجديدة </label>
                                <select required class='form-control select2' name='step_name'>
                                  <option value=""> -- اختر -- </option>
                                  <option value="تواصل">تواصل</option>
                                  <option value="تنفيذ">تنفيذ</option>
                                  <option value="توصيل">توصيل</option>
                                  <option value="تسليم">تسليم</option>
                                </select>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" name="add_cat" class="btn btn-primary waves-effect waves-light "> حفظ </button>
                              <button type="button" class="btn btn-default waves-effect " data-dismiss="modal"> رجوع </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                  <table class="table table-bordered">
                    <thead>
                      <h6 class="badge badge-warning"> فاتورة الطلب </h6>
                      <tr>
                        <th> رقم الطلب </th>
                        <th> -- </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td> <?php echo $order_data['order_number']; ?> </td>
                        <td> <a href="main.php?dir=offer_orders&page=order_invoice&order_id=<?php echo $order_id; ?>" class="btn btn-primary btn-sm"> مشاهدة الفاتورة <i class="fa fa-file-invoice"></i> </a> </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-order_status" role="tabpanel" aria-labelledby="custom-tabs-one-order_status-tab">

                  <?php
                  // get all order status and the last status 
                  $stmt = $connect->prepare("SELECT * FROM offer_order_statuses where order_id = ? ");
                  $stmt->execute(array($order_id));
                  $count_order_status = $stmt->rowCount();
                  $order_status = $stmt->fetchAll();
                  if ($count_order_status > 0) {
                  ?>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th> تاريخ الحاله </th>
                          <th> الحاله </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($order_status as $status) {
                        ?>
                          <tr>
                            <td> <?php echo $status['change_date'] ?> </td>
                            <td> <?php echo $status['status'] ?> </td>
                          </tr>
                        <?php
                        }
                        ?>
                        <tr></tr>
                      </tbody>
                    </table>
                  <?php
                  }
                  ?>
                  <?php

                  // get The Last Status Of Order
                  $stmt = $connect->prepare("SELECT * FROM offer_order_statuses where order_id = ? ORDER BY id DESC ");
                  $stmt->execute(array($order_id));
                  $count_last_status = $stmt->rowCount();
                  $status_data = $stmt->fetch();
                  ?>
                  <form action="" method="post">
                    <div class="form-group">
                      <label for=""> حاله الطلب الحاليه </label>
                      <select name="order_status" class="form-control select2" id="">
                        <option <?php if ($status_data['status'] == 'لم يبدا' || $count_last_status == 0) echo "selected"; ?> value="لم يبدا"> لم يبدا </option>
                        <option <?php if ($status_data['status'] == 'قيد الانتظار') echo 'selected'; ?> value="قيد الانتظار"> قيد الانتظار </option>
                        <option <?php if ($status_data['status'] == 'قيد التنفيذ') echo 'selected'; ?> value="قيد التنفيذ"> قيد التنفيذ </option>

                        <option <?php if ($status_data['status'] == 'مكتمل') echo 'selected'; ?> value="مكتمل"> مكتمل </option>
                        <option <?php if ($status_data['status'] == 'ملغي') echo 'selected'; ?> value="ملغي">ملغي</option>
                        <option <?php if ($status_data['status'] == 'مسوده') echo 'selected'; ?> value="مسوده">مسوده</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <button type="submit" name="change_status" class="btn btn-primary"> تعديل حاله الطلب </button>
                    </div>
                  </form>
                  <?php
                  if (isset($_POST['change_status'])) {
                    $order_status = $_POST['order_status'];
                    // Insert New Order Status 
                    $stmt = $connect->prepare("INSERT INTO offer_order_statuses (order_id,change_date,status)
                    VALUES(:zorder_id,:zchange_date,:zstatus)
                    ");
                    $stmt->execute(array(
                      'zorder_id' => $order_id,
                      'zchange_date' => date("n/j/Y g:i A"),
                      "zstatus" => $order_status,
                    ));
                    if ($stmt) {
                      // change status in order 
                      $stmt = $connect->prepare("UPDATE offer_orders SET status_value = ? WHERE id = ?");
                      $stmt->execute(array($order_status, $order_id));
                      header("Location:main.php?dir=offer_orders&page=order_details&order_id=" . $order_id);
                  ?>

                      <div class="alert alert-danger"> تم اضافه الطلب بنجاح </div>
                  <?php
                    }
                  }
                  ?>


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
  header('Location:main.php?dir=orders&page=report');
  exit();
}


?>