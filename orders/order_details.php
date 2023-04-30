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
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
              <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"> العميل </a>
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
                      <label for="inputName"> العنوان </label>
                      <input required type="text" id="address" name="address" class="form-control" value="<?php echo $order_data['address']; ?>">
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
                          ?>
                            <div class="form-group">
                              <label for="inputStatus"> المنتج </label>
                              <input type="text" name="pro_name" class="form-control" value="<?php echo $product_data['name']; ?>">
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
                                  <label for="inputName"> السعر </label>
                                  <input required type="text" id="product_qty" name="product_qty" class="form-control" value="<?php echo $order_details['product_price']; ?>">
                                </div>
                              </div>
                              <div class="col-4">
                                <div class="form-group">
                                  <label for="inputName"> السعر المخفض </label>
                                  <input required type="text" id="sale_price" name="sale_price" class="form-control" value="<?php echo $order_details['sale_price']; ?>">
                                </div>
                              </div>
                            </div>
                            <hr>
                          <?php
                          }
                          ?>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="description"> وصف الطلب </label>
                          <textarea id="order_details" name="order_details" class="form-control" rows="3"><?php echo $order_data['order_details']; ?></textarea>
                        </div>
                        <div class="form-group">
                          <label for="description"> ملاحظات </label>
                          <textarea id="notes" name="notes" class="form-control" rows="3"><?php echo $order_data['notes'];  ?></textarea>
                        </div>
                        <div class="form-group">
                          <p class="badge badge-warning" style="font-size: 16px;"> عدد المنتجات  </p>
                          <span class="text-strong"> 2 </span>
                        </div>
                        <div class="form-group">
                          <p class="badge badge-info"  style="font-size: 16px;"> السعر الكلي  </p>
                          <span> 100 </span>
                        </div>
                      </div>
                    </div>

                  </form>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                  العمليات علي الطلب
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                  مرفقات الطلب
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