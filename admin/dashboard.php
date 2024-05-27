<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"> الرئيسية </h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
          <li class="breadcrumb-item active"> مشتلي </li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content-header -->
<!----------- Orders Reports -------------->
<?php
$stmt = $connect->prepare("SELECT * FROM orders");
$stmt->execute();
$count_orders = $stmt->rowCount();
?>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3> <?php echo $count_orders; ?> </h3>
            <p class="text-bold"> الطلبات </p>
          </div>
          <div class="icon">
            <i class="fa fa-file"></i>
          </div>
          <a href="main.php?dir=orders&page=report" class="small-box-footer"> التقاصيل <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3></h3>

            <p class="text-bold">الأقسام </p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="main.php?dir=categories&page=report" class="small-box-footer"> التقاصيل <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3></h3>

            <p class="text-bold"> المنتجات </p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="main.php?dir=products&page=report" class="small-box-footer"> التقاصيل <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3></h3>
            <p class="text-bold"> الموظفين </p>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
          <a href="main.php?dir=employee&page=report" class="small-box-footer"> التقاصيل <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
    <br>

    <div class='row'>
      <div class='col-lg-6'>
        <?php
        $stmt = $connect->prepare("SELECT * FROM orders");
        $stmt->execute();
        $count_orders = $stmt->rowCount();
        ///////////////////////
        $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'لم يبدا '");
        $stmt->execute();
        $count_orders_not_started = $stmt->rowCount();
        //////////////////////////
        $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'مكتمل'");
        $stmt->execute();
        $count_orders_compeleted = $stmt->rowCount();
        ////////////////////////
        $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'قيد الانتظار'");
        $stmt->execute();
        $count_orders_waits = $stmt->rowCount();
        /////////////////////////
        $stmt = $connect->prepare("SELECT * FROM orders WHERE status_value = 'ملغي'");
        $stmt->execute();
        $count_orders_cancelled = $stmt->rowCount();
        ?>
        <div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title"> تقارير الطلبات ومبيعات المتجر </h3>
          </div>
          <div class="card-body p-0">
            <canvas id="orderschart" style="width:100%;max-width:700px"></canvas>
            <ul style="margin-right: 10px;" class="list-unstyled products_report">
              <style>
                .products_report li {
                  border-bottom: 1px solid #f5f2f2;
                  padding-bottom: 10px;
                  color: #555;
                  font-size: 15px;
                }
              </style>
              <li> <a href="main.php?dir=orders&page=report" style="color: #555;"> عدد الطلبات الكلي :: </a> <span id="totalOrders" class="badge" style="background-color: #3498db; color:#fff"> <?php echo $count_orders; ?> </span> </li>
              <li> <a href="main.php?dir=orders&page=compeleted_orders" style="color: #555;"> طلبات مكتملة :: </a> <span id="completedOrders" class="badge" style="background-color: #2ecc71; color:#fff"> <?php echo $count_orders_compeleted; ?> </span> </li>
              <li> طلبات لم تبدا :: <span id="notStartedOrders" class="badge" style="background-color: #2980b9; color:#fff"> <?php echo $count_orders_not_started; ?> </span> </li>
              <li> طلبات قيد الانتظار :: <span id="pendingOrders" class="badge" style="background-color: #f1c40f; color:#fff"> <?php echo $count_orders_waits;; ?> </span> </li>
              <li> طلبات ملغية :: <span id="canceledOrders" class="badge" style="background-color: #2c3e50; color:#fff"> <?php echo $count_orders_cancelled; ?> </span> </li>
            </ul>
            <table class="table table-bordered" dir='rtl'>
              <tbody>
                <tr>
                  <th> مجموع الطلبات المكتملة :: </th>
                  <td> <span class="badge badge-success"> <?php echo $count_orders; ?> طلب </span></td>
                </tr>
                <tr>
                  <th> سعر الكلي :: </th>
                  <?php
                  $stmt = $connect->prepare("SELECT SUM(total_price) as TotalCompeletedOrders FROM orders WHERE  archieve = 0 AND status_value = 'مكتمل'");
                  $stmt->execute();
                  $data = $stmt->fetch();
                  $total_price = $data['TotalCompeletedOrders'];

                  ///////////
                  ?>
                  <td> <span class="badge badge-info"> <?php echo $total_price; ?> ريال </span> </td>
                </tr>
                <tr>
                  <th> سعر الشحن :: </th>
                  <?php
                  $stmt = $connect->prepare("SELECT SUM(ship_price) as TotalShippedOrders FROM orders WHERE  archieve = 0 AND status_value = 'مكتمل'");
                  $stmt->execute();
                  $data_ship = $stmt->fetch();
                  $total_shipping = $data_ship['TotalShippedOrders'];
                  ?>
                  <td> <span class="badge badge-primary"> <?php echo $total_shipping; ?> ريال </span> </td>
                </tr>
                <tr>
                  <th> سعر الاضافات :: </th>
                  <?php
                  $stmt = $connect->prepare("SELECT SUM(farm_service_price) as TotalFarmOrders FROM orders WHERE  archieve = 0 AND status_value = 'مكتمل'");
                  $stmt->execute();
                  $data_farm = $stmt->fetch();
                  $total_farming = $data_farm['TotalFarmOrders'];
                  ?>
                  <td> <span class="badge badge-warning"> <?php echo $total_farming; ?> ريال </span> </td>
                </tr>
                <tr>
                  <th> صافي الربح :: </th>
                  <?php
                  $total_earning = $total_price - ($total_shipping + $total_farming);

                  ?>
                  <th> <span class="badge badge-danger"> <strong> <?php echo $total_earning; ?> ريال </strong> </span> </th>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
      <div class='col-lg-6'>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> اخر المنتجات </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <ul class="products-list product-list-in-card pl-2 pr-2">
              <?php
              $stmt = $connect->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 5");
              $stmt->execute();
              $allproducts = $stmt->fetchAll();
              foreach ($allproducts as $product) {
              ?>
                <li class="item">
                  <div class="product-img">
                    <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                  </div>
                  <div class="product-info">
                    <a href="main.php?dir=products&page=edit&pro_id=<?php echo $product['id']; ?>" class="product-title"> <?php echo $product['name']; ?>
                      <span class="badge badge-warning float-right"><?php echo $product['price']; ?> ر.س</span></a>
                    <span class="product-description">
                      <?php echo $product['short_desc']; ?>
                    </span>
                  </div>
                </li>
              <?php
              }
              ?>
              <!-- /.item -->
            </ul>
          </div>
          <!-- /.card-body -->
          <div class="card-footer text-center">
            <a href="main.php?dir=products&page=report" class="uppercase"> مشاهدة جميع المنتجات </a>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
      </div>
    </div>


  </div>
</section>
</div>