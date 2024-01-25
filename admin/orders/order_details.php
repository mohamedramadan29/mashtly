<style>
  .nav-tabs .nav-link.active {
    color: #111 !important;
  }
</style>
<?php
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
  $order_id = $_GET['order_id'];
  // get order
  $stmt = $connect->prepare("SELECT * FROM orders WHERE id = ?");
  $stmt->execute(array($order_id));
  $order_data = $stmt->fetch();
  // get order details 
  $stmt = $connect->prepare("SELECT * FROM order_details WHERE order_id = ?");
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
          <h1 class="m-0 text-dark"> الطلبات </h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
            <li class="breadcrumb-item active"> جميع الطلبات </li>
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
                  <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false"> العمليات علي الطلب </a>
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
                        <!--
                        <div class="form-group">
                          <label for="inputName"> المدينة </label>
                          <input required type="text" id="city" name="city" class="form-control" value="<?php echo $order_data['city']; ?>">
                        </div>
-->
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

                        <!--
                        <div class="form-group">
                          <label for="inputName"> المدينة </label>
                          <input required type="text" id="ship_city" name="ship_city" class="form-control" value="<?php echo $order_data['ship_city']; ?>">
                        </div>
-->
                        <div class="form-group">
                          <label for="inputName"> الشارع او الحي </label>
                          <input required type="text" id="ship_address" name="ship_address" class="form-control" value="<?php echo $order_data['ship_address']; ?>">
                        </div>
                        <!--
                        <div class="form-group">
                          <label for="inputName"> ملاحظات الشحن </label>
                          <textarea type="text" id="ship_notes" name="ship_notes" class="form-control"><?php echo $order_data['ship_notes']; ?></textarea>
                        </div>
-->
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
                          <p class="badge badge-info" style="font-size: 16px;"> السعر الكلي ::: </p>
                          <span> <strong> <?php echo $order_data['total_price']; ?> </strong> ريال </span>
                        </div>
                      </div>
                    </div>

                  </form>
                </div>
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
                                  $stmt = $connect->prepare("SELECT * FROM order_steps WHERE order_id=? AND username=?");
                                  $stmt->execute(array($order_id, $_SESSION['id']));
                                } else {
                                  $stmt = $connect->prepare("SELECT * FROM order_steps WHERE order_id=?");
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
                        <td> <a href="main.php?dir=orders&page=order_invoice&order_id=<?php echo $order_id; ?>" class="btn btn-primary btn-sm"> مشاهدة الفاتورة <i class="fa fa-file-invoice"></i> </a> </td>
                      </tr>
                    </tbody>
                  </table>
                  <table class="table table-bordered">
                    <thead>
                      <h6 class="badge badge-warning"> الصور بعد مراجعه الجودة </h6>
                      <tr>
                        <th> رقم الطلب </th>
                        <th> -- </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td> <?php echo $order_data['order_number']; ?> </td>
                        <td> <a href="main.php?dir=orders&page=order_products_rev&order_id=<?php echo $order_id; ?>" class="btn btn-primary btn-sm"> مشاهدة صور المنتجات <i class="fa fa-file-invoice"></i> </a> </td>
                      </tr>
                    </tbody>
                  </table>
                  <table class="table table-bordered">
                    <thead>
                      <h6 class="badge badge-warning"> اثباتات تسليم الطلب </h6>
                      <tr>
                        <th> رقم الطلب </th>
                        <th> -- </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td> <?php echo $order_data['order_number']; ?> </td>
                        <td> <a href="main.php?dir=orders&page=order_done&order_id=<?php echo $order_id; ?>" class="btn btn-primary btn-sm"> مشاهدة اثباتات التسليم <i class="fa fa-file-invoice"></i> </a> </td>
                      </tr>
                    </tbody>
                  </table>
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