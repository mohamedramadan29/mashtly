<?php
if (isset($_GET['report_page'])) {
    $report_page = $_GET['report_page'];
} else {
    $report_page = 1;
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> المستلزمات الزراعية </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> المستلزمات الزراعية </li>
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
                    <div class="card-body product_table">
                        <div class="table-responsive">
                            <div class="form_new_search">
                                <form method="post" action="">
                                    <div class="d-flex justify-content-center align-items-center flex-wrap">
                                        <div class="form-group">
                                            <select id="" class="form-control custom-select select2" name="cat_id">
                                                <option value=""> -- حدد القسم --</option>
                                                <?php
                                                $stmt = $connect->prepare("SELECT * FROM categories WHERE main_category = 2");
                                                $stmt->execute();
                                                $allcat = $stmt->fetchAll();
                                                foreach ($allcat as $cat) {
                                                ?>
                                                    <option <?php if (isset($_POST['cat_id']) && $_POST['cat_id'] == $cat['id']) echo 'selected'; ?> value="<?php echo $cat['id'] ?>"> <?php echo $cat['name']; ?> </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div>
                                            <button name="search" class="btn btn-dark btn-sm"> بحث <i class="fa fa-search"></i> </button>
                                        </div>
                                    </div>
                                </form>
                                <br>
                                <?php
                                if (isset($_POST['search'])) {
                                    $cat_id = $_POST['cat_id'];
                                    // استعلام للحصول على جميع المنتجات المرتبطة بالقسم الرئيسي أو الأقسام الفرعية
                                    $query = "
                                        SELECT p.*
                                        FROM products p
                                        JOIN categories c_main ON p.cat_id = c_main.id
                                        LEFT JOIN categories c_sub ON FIND_IN_SET(c_sub.id, p.more_cat)
                                        WHERE c_main.id = :cat_id 
                                        OR FIND_IN_SET(:cat_id, p.more_cat)
                                    ";

                                    // تحضير وتنفيذ الاستعلام
                                    $stmt = $connect->prepare($query);
                                    $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $allpro = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    $count = count($allpro);

                                ?>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th>الأسم</th>
                                                <th> القسم</th>
                                                <th> نباتات / مستلزمات </th>
                                                <th> سعر الشراء </th>
                                                <th> سعر البيع </th>
                                                <th> سعر التخفيض</th>
                                                <th> المخزون</th>
                                                <th> نشر المنتج</th>
                                                <!-- <th> صورة</th> -->
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
                                                            if ($pro['cat_id'] != null) { ?>
                                                            <?php
                                                                $stmt = $connect->prepare("SELECT * FROM categories WHERE id = ? LIMIT 1");
                                                                $stmt->execute(array($pro['cat_id']));
                                                                $sub_data = $stmt->fetch();
                                                            ?>
                                                            <span class="badge badge-info"> <?php echo $sub_data['name']; ?> </span>
                                                            <?php
                                                            ?>
                                                        <?php
                                                            } else { ?>
                                                            <span class="badge badge-danger"> لا يوجد </span>
                                                        <?php
                                                            } ?>
                                                    </td>
                                                    <td> <?php
                                                            if ($sub_data['main_category'] == 1) {
                                                                echo "نباتات";
                                                            } else {
                                                                echo "مستلزمات";
                                                            }
                                                            ?> </td>

                                                    <td> <?php echo $pro['purchase_price']; ?> </td>
                                                    <td> <?php echo $pro['price']; ?> </td>
                                                    <td> <?php echo $pro['sale_price']; ?> </td>
                                                    <td> <?php
                                                            if ($pro['product_status_store'] == 1) {
                                                            ?>
                                                            <span class="badge badge-success"> متوفر </span>
                                                        <?php
                                                            } elseif ($pro['product_status_store'] == 0) {
                                                        ?>
                                                            <span class="badge badge-danger"> غير متوفر </span>
                                                        <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($pro['publish'] == 1) {
                                                        ?>
                                                            <span class="badge badge-success"> منشور </span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="badge badge-danger"> ارشيف </span>
                                                        <?php
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ? LIMIT 1");
                                                        $stmt->execute(array($pro['id']));
                                                        $image_count = $stmt->rowCount();
                                                        if ($image_count > 0) {
                                                            $product_img_data = $stmt->fetch();
                                                        ?>
                                                            <img class="img-thumbnail" style="width: 80px; height:80px;" src="product_images/<?php echo $product_img_data['main_image']; ?>" alt="">
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>

                                            <?php
                                            }
                                        } else { 
                                        // الاستعلام الأول: جلب المنتجات التابعة للأقسام 942 و1184 (الأسمدة)
                                        $query_fertilizers = "
                                            SELECT p.* 
                                            FROM products p
                                            JOIN categories c_main ON p.cat_id = c_main.id
                                            LEFT JOIN categories c_sub ON FIND_IN_SET(c_sub.id, p.more_cat)
                                            WHERE p.publish = 1
                                            AND (c_main.main_category = 2 OR c_sub.main_category = 2)
                                            AND (p.cat_id IN (942, 1184) OR FIND_IN_SET(942, p.more_cat) OR FIND_IN_SET(1184, p.more_cat))
                                            ORDER BY p.id DESC
                                        ";
                                        $statement_fertilizers = $connect->prepare($query_fertilizers);
                                        $statement_fertilizers->execute();
                                        $fertilizers = $statement_fertilizers->fetchAll(PDO::FETCH_ASSOC);

                                        // الاستعلام الثاني: جلب باقي المنتجات (غير التابعة للأقسام 942 و1184)
                                        $query_others = "
                                            SELECT p.* 
                                            FROM products p
                                            JOIN categories c_main ON p.cat_id = c_main.id
                                            LEFT JOIN categories c_sub ON FIND_IN_SET(c_sub.id, p.more_cat)
                                            WHERE p.publish = 1
                                            AND (c_main.main_category = 2 OR c_sub.main_category = 2)
                                            AND p.cat_id NOT IN (942, 1184)
                                            AND NOT FIND_IN_SET(942, p.more_cat)
                                            AND NOT FIND_IN_SET(1184, p.more_cat)
                                            ORDER BY p.id DESC
                                        ";
                                        $statement_others = $connect->prepare($query_others);
                                        $statement_others->execute();
                                        $others = $statement_others->fetchAll(PDO::FETCH_ASSOC);

                                        // دمج النتائج: الأسمدة أولاً، ثم باقي المنتجات
                                        $allpro = array_merge($fertilizers, $others);
                                            ?>
                                            <form action="" method="post">
                                                <table id="my_table" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr> 
                                                            <th>الأسم</th>
                                                            <th>الرابط</th>
                                                            <th> القسم</th>
                                                            <th> نباتات / مستلزمات </th>
                                                            <th> سعر الشراء </th>
                                                            <th> سعر البيع </th>
                                                            <th> سعر التخفيض</th>
                                                            <th> المخزون</th>
                                                            <th> نشر المنتج</th>
                                                            <!-- <th> صورة</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($fertilizers as $pro) {
                                                            $i++;
                                                        ?>
                                                            <tr>
 
                                                              <td>
                                                                   <?php echo $pro['name']; ?>
                                                                </td>

                                                                <td>
                                                                    <a href="https://www.mshtly.com/product/<?php echo $pro['slug']; ?>"><?php echo $pro['name']; ?></a>
                                                                    <span class="url-hidden" style="display:none;"> <?php echo "https://www.mshtly.com/product/" . $pro['slug']; ?> </span>
                                                                </td>
                                                                <td> <?php
                                                                        if ($pro['cat_id'] != null) { ?>
                                                                        <?php
                                                                            $stmt = $connect->prepare("SELECT * FROM categories WHERE id = ? LIMIT 1");
                                                                            $stmt->execute(array($pro['cat_id']));
                                                                            $sub_data = $stmt->fetch();
                                                                        ?>
                                                                        <span class="badge badge-info"> <?php echo $sub_data['name']; ?> </span>
                                                                        <?php
                                                                        ?>
                                                                    <?php
                                                                        } else { ?>
                                                                        <span class="badge badge-danger"> لا يوجد </span>
                                                                    <?php
                                                                        } ?>
                                                                </td>
                                                                <td> <?php
                                                                        if ($sub_data['main_category'] == 1) {
                                                                            echo "نباتات";
                                                                        } else {
                                                                            echo "مستلزمات";
                                                                        }
                                                                        ?> </td>
                                                                <td> <?php echo $pro['purchase_price']; ?> </td>
                                                                <td> <?php echo $pro['price']; ?> </td>
                                                                <td> <?php echo $pro['sale_price']; ?> </td>
                                                                <td> <?php
                                                                        if ($pro['product_status_store'] == 1) {
                                                                        ?>
                                                                        <span class="badge badge-success"> متوفر </span>
                                                                    <?php
                                                                        } elseif ($pro['product_status_store'] == 0) {
                                                                    ?>
                                                                        <span class="badge badge-danger"> غير متوفر </span>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($pro['publish'] == 1) {
                                                                    ?>
                                                                        <span class="badge badge-success"> منشور </span>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <span class="badge badge-danger"> ارشيف </span>
                                                                    <?php
                                                                    } ?>
                                                                </td> 
                                                            </tr>
                                                            <?php 
                                                        }
                                                        ?>
                                                        
                                            </form>
                                            <?php

                                            ?>
                            </div>
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

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script> 

<script> 
    $('#my_table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: 'Export to Excel',
                exportOptions: {
                    columns: ':visible',
                    format: {
                        body: function(data, row, column, node) {
                            // العمود الثاني (الأسم) يحتوي على الرابط
                            if (column === 1) { // العمود الثاني (الأسم)
                                var url = $(node).find('.url-hidden').text().trim(); // استخراج الرابط من span
                                var text = $(node).find('a').text().trim(); // استخراج اسم المنتج
                                if (url && text) {
                                    // تنظيف النص والرابط من الأحرف الخاصة
                                    url = url.replace(/"/g, '""'); // التعامل مع علامات الاقتباس
                                    text = text.replace(/"/g, '""'); // التعامل مع علامات الاقتباس
                                    // إرجاع صيغة HYPERLINK
                                    return url;
                                }
                                return text || data; // إرجاع النص فقط إذا لم يكن هناك رابط
                            }
                            // معالجة العمود الثالث (القسم) لاستخراج النص فقط
                            if (column === 2) {
                                return $(node).text().trim(); // استخراج النص من span (مثل "سماد" أو "لا يوجد")
                            }
                            // إرجاع البيانات كما هي للأعمدة الأخرى
                            return data;
                        }
                    }
                },
                customize: function(xlsx) {
                    // ضمان دعم النصوص العربية والروابط التشعبية في Excel
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row c', sheet).each(function() {
                        // تعيين نمط يدعم النصوص العربية
                        $(this).attr('s', '25');
                        // التأكد من أن الخلايا التي تحتوي على صيغة HYPERLINK تُعامَل كصيغ
                        if ($(this).text().startsWith('=HYPERLINK')) {
                            $(this).attr('t', 'str'); // تعيين نوع الخلية كصيغة
                        }
                    });
                }
            }
        ],
 
    });
 
</script>