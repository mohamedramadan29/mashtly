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
                    <li class="breadcrumb-item active"> المنتجات </li>
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
                        <a href="main.php?dir=products&page=add" class="btn btn-primary waves-effect"> أضافة منتج جديد <i class="fa fa-plus"></i> </a>
                    </div>
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
                                    position: 'top-end',
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

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th>الأسم </th>
                                        <th> النوع </th>
                                        <th> slug </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM categories");
                                    $stmt->execute();
                                    $allcat = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allcat as $cat) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo  $cat['name']; ?> </td>
                                            <td> <?php
                                                    if ($cat['parent_id'] != 0) { ?>
                                                    <span class="badge badge-warning"> قسم فرعي </span>
                                                    <?php
                                                        $stmt = $connect->prepare("SELECT * FROM categories WHERE id = ? LIMIT 1");
                                                        $stmt->execute(array($cat['parent_id']));
                                                        $sub_data = $stmt->fetch();
                                                    ?>
                                                    <span class="badge badge-info"> <?php echo $sub_data['name']; ?> </span>
                                                    <?php
                                                    ?>
                                                <?php
                                                    } else { ?>
                                                    <span class="badge badge-success"> قسم رئيسي </span>
                                                <?php
                                                    }  ?>
                                            </td>
                                            <td> <?php echo  $cat['slug']; ?> </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $cat['id']; ?>"> تعديل <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=categories&page=delete&cat_id=<?php echo $cat['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
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
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>