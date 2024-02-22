<?php
ob_start();
session_start();
$page_title = 'البحث';
include "init.php";
// add to favorite
if (isset($_POST['add_to_fav'])) {
    if (isset($_SESSION['user_id'])) {
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user_id'];
        $stmt = $connect->prepare("INSERT INTO user_favourite (user_id, product_id)
        VALUES(:zuser_id, :zproduct_id)
        ");
        $stmt->execute(array(
            "zuser_id" => $user_id,
            "zproduct_id" => $product_id
        ));
        if ($stmt) {
            alertfavorite();
        }
    } else {
        header("Location:login");
    }
}
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = null;
    }
    $stmt = $connect->prepare("INSERT INTO cart (user_id, cookie_id, product_id,product_name,quantity,price,total_price)
    VALUES(:zuser_id, :zcookie_id , :zproduct_id,:zproduct_name,:zquantity ,:zprice , :ztotal_price)
    ");
    $stmt->execute(array(
        "zuser_id" => $user_id,
        "zcookie_id" => $cookie_id,
        "zproduct_id" => $product_id,
        "zproduct_name" => $product_name,
        "zquantity" => 1,
        "zprice" => $price,
        "ztotal_price" => $price,
    ));
    if ($stmt) {
        alertcart();
    }
}
// start header search

if (isset($_GET['search']) && $_GET['search'] != '') {
    $search = $_GET['search'];
    $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND price !='' AND name LIKE '%$search%'");
} else {
    // start get all products
    $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND name !='' AND price !=''");
}
$stmt->execute();
$num_products = $stmt->rowCount();
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 20;
$offset = ($currentpage - 1) * $pageSize;
if (isset($_GET['search']) && $_GET['search'] != '') {
    $search = $_GET['search'];
    $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND name LIKE '%$search%'  ORDER BY id DESC LIMIT $pageSize OFFSET :offset");
} else {
    $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1  ORDER BY id DESC LIMIT $pageSize OFFSET :offset");
}
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$allproducts = $stmt->fetchAll();
$totalProducts = count($allproducts);
$totalPages = ceil($num_products / $pageSize);
?>
<!-- START SELECT DATA HEADER -->
<div class="select_plan_head">
    <div class="container">
        <div class="data">
            <div class="head">
                <img src="<?php echo $uploads ?>plant.svg" alt="">
                <h2> اختر النباتات الملائمة لاحتياجاتك </h2>
                <p>
                    ان اختيار النباتات الملائمة أمرًا مهمًا للحصول على حديقة نباتية جميلة وصحية. لذلك، يجب النظر في المساحة المتاحة ومدى تعرض النباتات للضوء والرطوبة ودرجة الحرارة والتربة في المنطقة التي تعيش فيها بالاضافة الي العديد من العوامل الاخري.
                </p>
            </div>
        </div>
    </div>
</div>
<!-- END SELECT DATA HEADER -->
<!-- START INDEX ALL CATEGORY  -->
<div class="index_all_cat select_plants">
    <div class="container">
        <div class="data">
            <div class="data_header">
                <div class="data_header_name">
                    <h2 class='header2'> النباتات </h2>
                    <p> اجمالي النتائج :<span> <?php echo $num_products; ?> </span> </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <?php
                        foreach ($allproducts as $product) {
                        ?>
                            <div class="col-lg-3 col-6">
                                <?php
                                include 'tempelate/product.php';
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="pagination_section">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item <?php echo ($currentpage == 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?search=<?php echo $search; ?>&page=<?php echo ($currentpage > 1) ? ($currentpage - 1) : 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>

                                <?php
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo '<li class="page-item';
                                    if ($i == $currentpage) {
                                        echo ' active';
                                    }
                                    echo '"><a class="page-link" href="?search=' . $search . '&page=' . $i . '">' . $i . '</a></li>';
                                }
                                ?>
                                <li class="page-item <?php echo ($currentpage == $totalPages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?search=<?php echo $search; ?>&page=<?php echo ($currentpage < $totalPages) ? ($currentpage + 1) : $totalPages; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END INDEX ALL CATEGORY  -->
<?php
include $tem . 'footer.php';
ob_end_flush();
?>