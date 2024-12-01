<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> المقالات </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> المقالات </li>
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
                        <a href="main.php?dir=posts&page=add" type="button" class="btn btn-primary waves-effect btn-sm"> أضافة مقال جديد <i class="fa fa-plus"></i> </a>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="form_new_search">

                                <?php
                                if (isset($_SESSION['admin_username'])) {
                                ?>
                                    <form method="post" action="">
                                        <div class="d-flex justify-content-center align-items-center flex-wrap">
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="post_name" placeholder=" بحث  " value="<?php if (isset($_POST['post_name'])) echo $_POST['post_name'] ?>">
                                            </div>
                                            <div>
                                                <button name="search" class="btn btn-dark btn-sm"> بحث <i class="fa fa-search"></i> </button>
                                            </div>
                                        </div>
                                    </form>
                                <?php
                                }
                                ?>
                                <?php
                                if (isset($_SESSION['writer'])) {
                                    $stmt = $connect->prepare("SELECT * FROM posts where writer_id = ?");
                                    $stmt->execute(array($_SESSION['writer_id']));
                                } else {
                                    $stmt = $connect->prepare("SELECT * FROM posts");
                                    $stmt->execute();
                                }

                                $totalRecords = count($stmt->fetchAll());
                                // تحديد عدد السجلات في كل صفحة والصفحة الحالية
                                $recordsPerPage = 30;
                                $report_page = isset($_GET['report_page']) ? (int)$_GET['report_page'] : 1; // Cast to integer
                                $report_page = max(1, $report_page); // Ensure $page is at least 1
                                // حساب الإزاحة
                                $offset = ($report_page - 1) * $recordsPerPage;
                                if (isset($_POST['search'])) {
                                    $conditions = array();
                                    $values = array();
                                    if (!empty($_POST['post_name'])) {
                                        $post_name = $_POST['post_name'];
                                        $conditions[] = 'name LIKE ?';
                                        $values[] = '%' . $post_name . '%';
                                    }
                                    $query = "SELECT * FROM posts";
                                    if (!empty($conditions)) {
                                        $query .= " WHERE " . implode(" AND ", $conditions);
                                    }

                                    $query .= " ORDER BY id DESC";

                                    $stmt = $connect->prepare($query);
                                    $stmt->execute($values);
                                    $allposts = $stmt->fetchAll();
                                    $count = count($allposts);
                                    $i = 0;
                                } else {
                                    if (isset($_SESSION['writer'])) {
                                        $stmt = $connect->prepare("SELECT * FROM posts where writer_id = ? ORDER BY id DESC");
                                        $stmt->execute(array($_SESSION['writer_id']));
                                    } else {
                                        $stmt = $connect->prepare("SELECT * FROM posts ORDER BY id DESC");
                                        $stmt->execute();
                                    }

                                    $totalRecords = count($stmt->fetchAll());
                                    // تحديد عدد السجلات في كل صفحة والصفحة الحالية
                                    $recordsPerPage = 30;
                                    $report_page = isset($_GET['report_page']) ? (int)$_GET['report_page'] : 1; // Cast to integer
                                    $report_page = max(1, $report_page); // Ensure $page is at least 1
                                    // حساب الإزاحة
                                    $offset = ($report_page - 1) * $recordsPerPage;

                                    /////////////
                                    // استعلام SQL لاسترداد البيانات للصفحة الحالية
                                    if (isset($_SESSION['writer'])) {
                                        // echo $_SESSION['writer'];
                                        // echo $_SESSION['writer_id'];
                                        $query = "SELECT * FROM posts WHERE writer_id = :writer_id ORDER BY id DESC LIMIT :offset, :limit";
                                        $statement = $connect->prepare($query);
                                        $statement->bindValue(':writer_id', intval($_SESSION['writer_id']), PDO::PARAM_INT);
                                        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
                                        $statement->bindValue(':limit', $recordsPerPage, PDO::PARAM_INT);
                                    } else {
                                        $query = "SELECT * FROM posts ORDER BY id DESC LIMIT :offset, :limit";
                                        $statement = $connect->prepare($query);
                                        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
                                        $statement->bindValue(':limit', $recordsPerPage, PDO::PARAM_INT);
                                    }
                                    // تنفيذ الاستعلام
                                    $statement->execute();
                                    $allposts = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    $i = 0;
                                } ?>
                            </div>
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th>الأسم </th>
                                        <th> القسم </th>
                                        <th> الكاتب </th>
                                        <th> الصورة </th>
                                        <th> الحالة </th>
                                        <th> العمليات </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($allposts as $post) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $i; ?>
                                            </td>
                                            <td>
                                                <a href="main.php?dir=posts&page=edit&post_id=<?php echo $post['id']; ?>"> <?php echo $post['name']; ?> </a>
                                            </td>
                                            <td>
                                                <?php
                                                /*
                                                $stmt = $connect->prepare("SELECT * FROM category_posts WHERE id=?");
                                                $stmt->execute(array($post['cat_id']));
                                                $cat_data = $stmt->fetch();
                                                */
                                                echo $post['category']; ?>
                                            </td>
                                            <td> <?php
                                                    if (!empty($post['writer_id'])) {
                                                        $stmt = $connect->prepare("SELECT * FROM employes WHERE id = ?");
                                                        $stmt->execute(array($post["writer_id"]));
                                                        $writer_data =  $stmt->fetch();
                                                        echo   $writer_data["username"];
                                                    } else {
                                                        echo "الادمن ";
                                                    }
                                                    ?>
                                            </td>

                                            <td> <img style="width: 60px; height:60px" src="posts/images/<?php echo $post['main_image']; ?> " alt=""></td>

                                            <td>
                                                <?php
                                                if ($post['publish'] == 1) {
                                                ?>
                                                    <span class="badge badge-success"> تم النشر </span>
                                                <?php
                                                } else {
                                                ?>
                                                    <span class="badge badge-danger"> ارشيف </span>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="main.php?dir=posts&page=edit&post_id=<?php echo $post['id']; ?>" class="btn btn-success btn-sm"> <i class='fa fa-pen'></i>
                                                </a>
                                                <?php
                                                if (isset($_SESSION['admin_username'])) {
                                                ?>
                                                    <a href="main.php?dir=posts&page=delete&post_id=<?php echo $post['id']; ?>" class="confirm btn btn-danger btn-sm"> <i class='fa fa-trash'></i>
                                                    </a>
                                                <?php
                                                }
                                                ?>

                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $post['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل المقال </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=posts&page=edit" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type='hidden' name="post_id" value="<?php echo $post['id']; ?>">
                                                                <label for="Company-2" class="block"> عنوان القال </label>
                                                                <input id="Company-2" required name="name" type="text" class="form-control required" value="<?php echo $post['name'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> القسم </label>
                                                                <select name="cat_id" class='form-control select2' id="">
                                                                    <option value=""> حدد القسم </option>
                                                                    <?php
                                                                    $stmt = $connect->prepare("SELECT * FROM category_posts");
                                                                    $stmt->execute();
                                                                    $allcat = $stmt->fetchAll();
                                                                    foreach ($allcat as $cat) { ?>
                                                                        <option <?php if ($post['cat_id'] == $cat['id'])
                                                                                    echo 'selected'; ?> value="<?php echo $cat['id']; ?>">
                                                                            <?php echo $cat['name']; ?> </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> الوصف </label>
                                                                <textarea class="summernote" style="height: 150px;" id="summernote" name="description" class="form-control"><?php echo $post['description']; ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> وصف مختصر </label>
                                                                <textarea style="height: 70px;" id="Company-2" name="short_desc" class="form-control"><?php echo $post['short_desc']; ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="customFile"> تعديل صورة القسم </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile" accept='image/*' name="main_image">
                                                                    <label class="custom-file-label" for="customFile">اختر
                                                                        الصورة</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> اضافة التاج <span class="badge badge-danger"> من فضلك افصل بين كل تاج والاخر (,) </span> </label>
                                                                <input required id="Company-2" name="tags" type="text" class="form-control" value="<?php echo $post['tags']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> نشر المقال </label>
                                                                <select name="publish" id="" class="form-control select2">
                                                                    <option value=""> اختر الحالة </option>
                                                                    <option <?php if ($post['publish'] == 1) echo 'selected'; ?> value="1"> نشر المقال </option>
                                                                    <option <?php if ($post['publish'] == 0) echo 'selected'; ?> value="0"> ارشيف </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit_cat" class="btn btn-primary waves-effect waves-light "> تعديل
                                                            </button>
                                                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">رجوع</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                            </table>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php
                                    $totalPages = ceil($totalRecords / $recordsPerPage);
                                    for ($i = 1; $i <= $totalPages; $i++) {
                                    ?>
                                        <li class="page-item"><a class="page-link" href="main.php?dir=posts&page=report&report_page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- ADD NEW CATEGORY MODAL   -->
                <div class="modal fade" id="add-Modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> اضافة مقال جديد </h4>
                            </div>
                            <form action="main.php?dir=posts&page=add" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> العنوان </label>
                                        <input required id="Company-2" name="name" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> القسم </label>
                                        <select name="cat_id" class='form-control select2' id="">
                                            <option value=""> حدد القسم </option>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM category_posts");
                                            $stmt->execute();
                                            $allcat = $stmt->fetchAll();
                                            foreach ($allcat as $cat) { ?>
                                                <option value="<?php echo $cat['id']; ?>"> <?php echo $cat['name']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> الوصف </label>
                                        <textarea class="summernote" style="height: 150px;" id="summernote" name="description" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> وصف مختصر </label>
                                        <textarea style="height: 70px;" id="Company-2" name="short_desc" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="customFile"> صورة المقال </label>
                                        <div class="custom-file">
                                            <input required type="file" class="dropify" id="customFile" accept='image/*' name="main_image">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> اضافة التاج <span class="badge badge-danger"> من فضلك افصل بين كل تاج والاخر (,) </span> </label>
                                        <input required id="Company-2" name="tags" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> نشر المقال </label>
                                        <select name="publish" id="" class="form-control select2">
                                            <option value=""> اختر الحالة </option>
                                            <option value="1"> نشر المقال </option>
                                            <option value="0"> ارشيف </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="add_cat" class="btn btn-primary waves-effect waves-light "> حفظ </button>
                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">
                                        رجوع </button>
                                </div>
                            </form>
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