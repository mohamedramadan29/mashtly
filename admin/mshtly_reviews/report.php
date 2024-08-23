<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> تقيمات المتجر   </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> تقيمات المتجر </li>
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
                <div class="card"> 

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> رقم الهاتف  </th>
                                        <th> النجوم / 5  </th>
                                        <th> وصف التقيم  </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM mshtly_reviews ORDER BY id DESC");
                                    $stmt->execute();
                                    $allreviews = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allreviews as $review) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo  $review['email']; ?> </td>
                                            <td> <?php echo  $review['star']; ?> </td>
                                            <td> <?php echo  $review['description']; ?> </td> 
                                         
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
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>