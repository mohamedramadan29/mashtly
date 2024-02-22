<?php
ob_start();
session_start();
$page_title = ' مشتلي - المتجر  ';
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
// start get all products
// check if url has cat or not 
if (isset($_GET['cat'])) {
    $cat_slug = $_GET['cat'];
    $stmt = $connect->prepare("SELECT * FROM categories WHERE slug = ?");
    $stmt->execute(array($cat_slug));
    $cat_data = $stmt->fetch();
    $cat_id = $cat_data['id'];
}
$stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND name !='' AND price !='' ");
$stmt->execute();
$num_products = $stmt->rowCount();
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 20;
$offset = ($currentpage - 1) * $pageSize;

// استعلام البيانات الأساسي
$stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND name !='' AND price !='' ");

// جزء الترتيب
$order_by = "";

if (isset($_GET['sort']) && !empty($_GET['sort'])) {
    $sort = $_GET['sort'];
    // تحديد الترتيب
    switch ($sort) {
        case 'heigh_to_low':
            $order_by = " ORDER BY price DESC";
            break;
        case 'low_to_heigh':
            $order_by = " ORDER BY price DESC";
            break;
        case 'newest':
            $order_by = " ORDER BY id DESC";
            break;
        case 'oldest':
            $order_by = " ORDER BY id ASC";
            break;
        default:
            // الترتيب الافتراضي
            $order_by = "";
            break;
    }
}
// إضافة ترتيب إلى الاستعلام
$stmt->execute();
$num_products = $stmt->rowCount();

// ترتيب النتائج
$stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND name !='' AND price !='' $order_by LIMIT $pageSize OFFSET :offset");
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$allproducts = $stmt->fetchAll();
$totalProducts = count($allproducts);
/////////////////////////////////
$totalPages = ceil($num_products / $pageSize);
if (isset($_POST['search_options'])) {
    $selectedOptions = $_POST['options'];
    if (!empty($selectedOptions)) {
        // Get product IDs from options table
        $placeholders = implode(',', array_fill(0, count($selectedOptions), '?'));
        $stmt = $connect->prepare("SELECT DISTINCT product_id FROM product_properties_plants WHERE option_id IN ($placeholders)");
        $stmt->execute($selectedOptions);
        $productIDs = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $num_products = $stmt->rowCount();
        // Get all products with matching IDs
        if (!empty($productIDs)) {
            $productIDsStr = implode(',', $productIDs);
            $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND name !='' AND price !='' AND id IN ($productIDsStr) ORDER BY id DESC LIMIT $pageSize OFFSET :offset");
            $num_products = $stmt->rowCount();
        }
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $allproducts = $stmt->fetchAll();
        $totalProducts = count($allproducts);
        /////////////////////////////////
        $totalPages = ceil($num_products / $pageSize);
    }
}
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
    <div class="container-fluid">
        <div class="data">
            <div class="data_header">
                <div class="data_header_name">
                    <h2 class='header2'> النباتات </h2>
                    <p> اجمالي النتائج :<span> <?php echo $num_products; ?> </span> </p>
                </div>
                <div class="search_types">
                    <div class="brach_cat">
                        <button class="global_button btn" id="brach_orders"> <img src="<?php echo $uploads ?>filter.png" alt=""> تصنيف حسب </button>
                    </div>
                    <div class="search">
                        <!-- <button class="global_button btn" id="search_orders"> رتب حسب: <span class="selected_search">
                                <?php
                                if (isset($_REQUEST['height_price'])) {
                                    echo "السعر من الاعلي الي الاقل <i class='fa fa-check'></i>";
                                } elseif (isset($_REQUEST['low_price'])) {
                                    echo "السعر من الاقل الي الاعلي <i class='fa fa-check'></i>";
                                }
                                if (isset($_REQUEST['newest'])) {
                                    echo "الأحدث <i class='fa fa-check'></i>";
                                } elseif (isset($_REQUEST['oldest'])) {
                                    echo "الأقدم <i class='fa fa-check'></i>";
                                } else {
                                    echo "----";
                                } ?> </span> </button> -->
                        <div class="os">
                            <form action="" method="get" name="sortProducts" id="sortProducts">
                                <select class="form-control" name="sort" id="sort" style="border-radius: 24px;padding: 8px;border-color: var(--second-color);background: transparent;color: var(--second-color);min-width: 230px;">
                                    <option value=""> رتب حسب .. </option>
                                    <option <?php if (isset($_GET['sort']) && $_GET['sort'] == 'newest') echo "selected"; ?> value="newest"> الاحدث </option>
                                    <option <?php if (isset($_GET['sort']) && $_GET['sort'] == 'oldest') echo "selected"; ?> value="oldest"> الاقدم </option>
                                    <!-- <option <?php if (isset($_GET['sort']) && $_GET['sort'] == 'heigh_to_low') echo "selected"; ?> value="heigh_to_low">  السعر من الاعلي الي الاقل  </option>
                                <option <?php if (isset($_GET['sort']) && $_GET['sort'] == 'low_to_heigh') echo "selected"; ?> value="low_to_heigh"> السعر من الاقل الي الاعلي  </option> -->
                                </select>
                            </form>
                        </div>
                        <div class="options">
                            <form action="" method="get">
                                <div class="form-check">
                                    <input name="newest" class="form-check-input" type="checkbox" value="newest" id="flexCheck3">
                                    <label class="form-check-label" for="flexCheck3">
                                        الأحدث
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input name="oldest" class="form-check-input" type="checkbox" value="" id="flexCheck4">
                                    <label class="form-check-label" for="flexCheck4">
                                        الأقدم
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input name="height_price" class="form-check-input" type="checkbox" value="height_price" id="flexCheck1">
                                    <label class="form-check-label" for="flexCheck1">
                                        السعر من الاعلي الي الاقل
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input name="low_price" class="form-check-input" type="checkbox" value="low_price" id="flexCheck2">
                                    <label class="form-check-label" for="flexCheck2">
                                        السعر من الاقل الي الاعلي
                                    </label>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <div class="all_cat">
                        <form action="" method="post">
                            <?php
                            $stmt = $connect->prepare("SELECT * FROM plant_properties");
                            $stmt->execute();
                            $allplant_props = $stmt->fetchAll();
                            foreach ($allplant_props as $plant_props) {
                            ?>
                                <div class="search_one">
                                    <h4 class="select_search"> <?php echo $plant_props['properity_name']; ?> <i class="fa fa-chevron-down"></i> </h4>
                                    <div class="options">
                                        <?php
                                        $stmt = $connect->prepare("SELECT * FROM plant_properity_options WHERE properity_id=?");
                                        $stmt->execute(array($plant_props['id']));
                                        $alloptions = $stmt->fetchAll();
                                        foreach ($alloptions as $option) {
                                        ?>
                                            <div class="form-check">
                                                <input name="options[]" class="form-check-input" type="checkbox" value="<?php echo $option['id'] ?>" id="option<?php echo $option['id'] ?>">
                                                <label class="form-check-label" for="option<?php echo $option['id'] ?>">
                                                    <?php echo $option['name'] ?>
                                                </label>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <button type="submit" name="search_options" class="global_button search_options"> بحث <i class="fa fa-search"></i> </button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-10">
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
                    <?php
                    if ($totalPages > 1) {
                    ?>
                        <div class="pagination_section">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item <?php echo ($currentpage == 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo ($currentpage > 1) ? ($currentpage - 1) : 1; ?>&sort=<?php echo isset($_GET['sort']) ? $_GET['sort'] : ''; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                    for ($i = 1; $i <= $totalPages; $i++) {
                                        echo '<li class="page-item';
                                        if ($i == $currentpage) {
                                            echo ' active';
                                        }
                                        echo '"><a class="page-link" href="?page=' . $i . '&sort=' . (isset($_GET['sort']) ? $_GET['sort'] : '') . '">' . $i . '</a></li>';
                                    }
                                    ?>
                                    <li class="page-item <?php echo ($currentpage == $totalPages) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo ($currentpage < $totalPages) ? ($currentpage + 1) : $totalPages; ?>&sort=<?php echo isset($_GET['sort']) ? $_GET['sort'] : ''; ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>

                                </ul>
                            </nav>
                        </div>
                    <?php
                    }

                    ?>

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

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>