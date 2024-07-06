 <!-- Content Header (Page header) -->
 <section class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0 text-dark"> المنتجات </h1>
             </div>
             <!-- /.col -->
             <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-left">
                     <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                     <li class="breadcrumb-item active"> المنتجات</li>
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
                     <div class="card-header">
                         <a href="main.php?dir=products&page=add" class="btn btn-primary waves-effect btn-sm"> أضافة منتج
                             جديد <i class="fa fa-plus"></i> </a>

                     </div>
                     <div class="card-body product_table">
                         <div class="table-responsive">

                             <?php
                                $stmt = $connect->prepare("SELECT * FROM products");
                                $stmt->execute();
                                $totalRecords = count($stmt->fetchAll());
                                // استعلام SQL لاسترداد البيانات للصفحة الحالية
                                $stmt = $connect->prepare("SELECT * FROM products ORDER BY id DESC ");
                                $stmt->execute();
                                $allpro = $stmt->fetchAll();
                                ?>
                             <table id="my_table_new_report" class="table table-striped table-bordered">
                                 <thead>
                                     <tr>

                                         <th> #</th>
                                         <th>الأسم</th>
                                         <th> نباتات / مستلزمات </th>
                                         <th> رابط المنتج </th>
                                         <th> معلومات اضافية </th>
                                         <th> السعر</th>
                                         <th> الوزن </th>
                                         <th> الطول لتحديد الوزن </th>


                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                        $i = 0;
                                        foreach ($allpro as $pro) {
                                            $i++;
                                        ?>
                                         <tr>

                                             <td> <?php echo $i; ?> </td>

                                             <td> <?php echo $pro['name']; ?> </td>
                                             <td> <?php
                                                    $stmt = $connect->prepare("SELECT * FROM categories WHERE id = ? LIMIT 1");
                                                    $stmt->execute(array($pro['cat_id']));
                                                    $sub_data = $stmt->fetch();
                                                    if ($sub_data['main_category'] == 1) {
                                                        echo "نباتات";
                                                    } else {
                                                        echo "مستلزمات";
                                                    }
                                                    ?> </td>
                                             <td> <a href="https://www.mshtly.com/product/<?php echo $pro['slug'] ?>"> https://www.mshtly.com/product/<?php echo $pro['slug'] ?> </a> </td>
                                             <td>
                                                 <?php
                                                    $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ?");
                                                    $stmt->execute(array($pro['id']));
                                                    $details2 = $stmt->fetchAll();
                                                    $count_var = $stmt->rowCount();
                                                    if ($count_var > 0) {
                                                        foreach ($details2 as $detil) {
                                                            echo $detil['vartions_name'] . "</br>";
                                                        }
                                                    } else {
                                                        echo "منتج بسيط";
                                                    }
                                                    ?>
                                             </td>
                                             <td> <?php echo $pro['price']; ?> </td>


                                             <th> <?php
                                                    if ($pro['ship_weight'] != '' && $pro['ship_weight'] != 0) {
                                                        echo $pro['ship_weight'];
                                                        echo "كجم ";
                                                    } else {
                                                    ?>
                                                     <span style="color: red;"> لا يوجد وزن </span>
                                                 <?php
                                                    }
                                                    ?>
                                             </th>
                                             <th> <?php
                                                    if ($pro['ship_tail'] != '' && $pro['ship_tail'] != 0) {
                                                        echo $pro['ship_tail'];
                                                        echo "متر";
                                                    } else {
                                                    ?>
                                                     <span style="color: red;"> لا يوجد طول </span>
                                                 <?php
                                                    }
                                                    ?>
                                             </th>

                                         </tr>

                                     <?php
                                        }

                                        ?>
                             </table>


                         </div>
                     </div>
                 </div>
                 <style>
                     .dataTables_length {
                         display: none;
                     }
                 </style>
             </div>
             <!-- /.col -->
         </div>
         <!-- /.row -->
     </div>
     <!-- /.container-fluid -->
 </section>

 <script>
     if (window.history.replaceState) {
         window.history.replaceState(null, null, window.location.href);
     }
 </script>