<?php
// get the product data
$product_id = $_GET['pro_id'];
$stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute(array($product_id));
$product_data = $stmt->fetch();
$product_name = $product_data['name']; 
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> اسئلة المنتج <span class="text-danger"> [<?php echo $product_name ?>]  </span> </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> الاسئلة </li>
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
                        <button type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal" data-target="#add-faqs"> أضافة سؤال جديد <i class="fa fa-plus"></i> </button>
                        <?php
                        if (isset($_POST['delete_selected'])) {
                            if (isset($_POST["products_id"]) && !empty($_POST["products_id"])) {
                                $selectedProducts = implode(",", $_POST["products_id"]);
                                $stmt = $connect->prepare("DELETE FROM products WHERE id IN ($selectedProducts)");
                                $stmt->execute();
                                if ($stmt) {
                                    $_SESSION['success_message'] = " تم حذف السؤال بنجاح ";
                                }
                            }
                        }
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
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr> 
                                        <th> # </th>
                                        <th> السؤال </th>
                                        <th> الوصف </th>
                                        <th> العمليات </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM product_faqs WHERE product_id = ? ORDER BY id DESC");
                                    $stmt->execute(array($product_id));
                                    $allfaqs = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allfaqs as $faq) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo  $faq['faq_head']; ?> </td>
                                            <td> <?php echo  $faq['faq_descriptiion']; ?> </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $faq['id']; ?>"> تعديل <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=products/faqs&page=delete&faq_id=<?php echo $faq['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                            </td>
                                        </tr>
                                    <?php
                                    include 'edit.php';
                                    }
                                    ?>
                            </table>
                        </div>
                    </div>
                    <?php
                    include "add.php";
                    ?>
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>