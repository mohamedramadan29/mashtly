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
            <h3></h3>

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

        <!-- TABLE: LATEST ORDERS -->
        <div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title"> اخر الطلبات </h3>

          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th>رقم الطلب </th>
                    <th>حالة الطلب </th>
                    <th> السعر </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $stmt = $connect->prepare("SELECT * FROM orders WHERE archieve = 0 ORDER BY id DESC LIMIT 5");
                  $stmt->execute();
                  $allorders = $stmt->fetchAll();
                  foreach ($allorders as $order) {
                  ?>
                    <tr>
                      <td><a href="main.php?dir=orders&page=order_details&order_id=<?php echo $order['id']; ?>"> <?php echo $order['order_number'] ?> </a></td>
                      <td><span class="badge badge-success"> <?php echo $order['status_value'] ?> </span></td>
                      <td><span class="text-strong"> <?php echo $order['total_price'] ?> ر.س </span></td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <a href="main.php?dir=orders&page=report" class="btn btn-sm btn-secondary float-right"> مشاهدة جميع الطلبات </a>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
      </div>
      <div class='col-lg-6'>

        <!-- PRODUCT LIST -->
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
    <div class='row'>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <p class="text-center">
              <strong> حالة الطلبات </strong>
            </p>
          </div>
          <div class="card-body">
            <div class="progress-group">
              لم يبدا
              <span class="float-right"><b>160</b>/200</span>
              <div class="progress progress-lg">
                <div class="progress-bar bg-primary" style="width: 80%"></div>
              </div>
            </div>
            <!-- /.progress-group -->

            <div class="progress-group">
              جاري التنفيذ
              <span class="float-right"><b>310</b>/400</span>
              <div class="progress progress-lg">
                <div class="progress-bar bg-danger" style="width: 75%"></div>
              </div>
            </div>

            <!-- /.progress-group -->
            <div class="progress-group">
              <span class="progress-text"> تم التواصل للتنفيذ </span>
              <span class="float-right"><b>480</b>/800</span>
              <div class="progress progress-lg">
                <div class="progress-bar bg-success" style="width: 60%"></div>
              </div>
            </div>

            <!-- /.progress-group -->
            <div class="progress-group">
              تم التنفيذ
              <span class="float-right"><b>250</b>/500</span>
              <div class="progress progress-lg">
                <div class="progress-bar bg-warning" style="width: 50%"></div>
              </div>
            </div>
            <!-- /.progress-group -->
          </div>

        </div>
      </div>

    </div>


  </div>
</section>
</div>