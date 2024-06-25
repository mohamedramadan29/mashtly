<?php
ob_start();
session_start();
$page_title = ' مشتلي  | التصنيفات  ';
include "init.php";

// الحصول على الجزء من العنوان بعد اسم الملف (مثل product)
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', $url);
// البحث عن قيمة المتغير بدون كلمة slug
$key = array_search('product-category', $parts);
$keyPage = array_search('page', $parts);
if ($key !== false && isset($parts[$key + 1])) {
    // يمكنك استخدام $parts[$key+1] كـ slug
    $cat_slug  = $parts[$key + 1];
    $cat_slug =  urldecode($cat_slug);
} else {
    // لم يتم العثور على slug
    echo "العنوان غير صحيح";
}
if ($keyPage !== false && isset($parts[$keyPage + 1])) {
    $keyPage = $parts[$keyPage + 1];
    // $keyPage = $currentpage;
    $currentpage = $keyPage;
} else {
    $currentpage = 1;
}
//$cat_slug =$_GET['cat'];

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
    $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ? AND product_id = ?");
    $stmt->execute(array($cookie_id, $product_id));
    $cart_data = $stmt->fetch();
    $count_product = $stmt->rowCount();
    if ($count_product > 0) {
        $new_qty = $cart_data['quantity'] + 1; // زيادة الكمية بواحد
        $stmt = $connect->prepare("UPDATE cart SET quantity = ?, total_price = ? WHERE cookie_id = ? AND product_id = ?");
        $stmt->execute(array($new_qty, $cart_data['price'] * $new_qty, $cookie_id, $product_id)); // تحديث الكمية والسعر الإجمالي
    } else {
        $stmt = $connect->prepare("INSERT INTO cart (user_id, cookie_id, product_id, product_name, quantity, price, total_price)
        VALUES (:zuser_id, :zcookie_id, :zproduct_id, :zproduct_name, :zquantity, :zprice, :ztotal_price)");
        $stmt->execute(array(
            "zuser_id" => $user_id,
            "zcookie_id" => $cookie_id,
            "zproduct_id" => $product_id,
            "zproduct_name" => $product_name,
            "zquantity" => 1,
            "zprice" => $price,
            "ztotal_price" => $price,
        ));
    }
    if ($stmt) {
        alertcart();
    }
}
// start get all products
// check if url has cat or not 

$stmt = $connect->prepare("SELECT * FROM categories WHERE slug = ?");
$stmt->execute(array($cat_slug));
$cat_data = $stmt->fetch();
$check_cat = $stmt->rowCount();
if ($check_cat > 0) {
    $cat_id = $cat_data['id'];
    // إعداد الاستعلام
    // $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND name != '' AND price != '' AND (cat_id = ? OR FIND_IN_SET(?, more_cat) > 0)");
    // $stmt->execute(array($cat_id, $cat_id));

    $num_products = $stmt->rowCount();

    // $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
    // echo $currentpage;
    $pageSize = 20;
    $offset = ($currentpage - 1) * $pageSize;


    // استعلام البيانات الأساسي
    //$stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND name !='' AND price !='' AND cat_id = $cat_id");
    $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND product_status_store = 1 AND name != '' AND price != '' AND (cat_id = $cat_id OR FIND_IN_SET($cat_id, more_cat) > 0)");
    if (isset($_GET['sort']) && !empty($_GET['sort'])) {
        $sort = $_GET['sort'];
        // تحديد الترتيب
        switch ($sort) {
            case 'heigh_to_low':
                $order_by = " ORDER BY price DESC";
                break;
            case 'low_to_heigh':
                $order_by = " ORDER BY price ASC";
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
    $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND product_status_store = 1 AND name !='' AND price !='' AND (cat_id = $cat_id OR FIND_IN_SET($cat_id, more_cat) > 0) $order_by LIMIT $pageSize OFFSET :offset");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $allproducts = $stmt->fetchAll();
    $totalProducts = count($allproducts);
    /////////////////////////////////
    $totalPages = ceil($num_products / $pageSize);
} else {
    header("location:index");
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
                    <h2 class='header2'> <a href="shop" style="text-decoration: none; color: var(--main-color);">المتجر</a> / <span style="color: var(--main-color);"> <?php echo $cat_data['name'] ?> </span> </h2>
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
                                } elseif (isset($_REQUEST['newest'])) {
                                    echo "الأحدث <i class='fa fa-check'></i>";
                                } elseif (isset($_REQUEST['oldest'])) {
                                    echo "الأقدم <i class='fa fa-check'></i>";
                                } else {
                                    echo "----";
                                } ?> </span> </button> -->
                        <div class="os">
                            <form action="" method="get" name="sortProducts" id="sortProducts">
                                <select class="form-control" name="sort" id="sort" style="border-radius: 24px;padding: 8px;border-color: var(--second-color);background: transparent;color: var(--second-color);min-width: 230px;">
                                    <option value=""> رتب حسب ... </option>
                                    <option <?php if (isset($_GET['sort']) && $_GET['sort'] == 'newest') echo "selected"; ?> value="newest"> الاحدث </option>
                                    <option <?php if (isset($_GET['sort']) && $_GET['sort'] == 'oldest') echo "selected"; ?> value="oldest"> الاقدم </option>
                                    <!-- <option <?php if (isset($_GET['sort']) && $_GET['sort'] == 'heigh_to_low') echo "selected"; ?> value="heigh_to_low">  السعر من الاعلي الي الاقل  </option>
                                <option <?php if (isset($_GET['sort']) && $_GET['sort'] == 'low_to_heigh') echo "selected"; ?> value="low_to_heigh"> السعر من الاقل الي الاعلي  </option> -->

                                    <!-- تضمين قيمة الفئة -->
                                    <input type="hidden" name="cat" value="<?php echo isset($_GET['cat']) ? $_GET['cat'] : ''; ?>">
                                </select>
                            </form>
                        </div>
                        <div class="options">
                            <form action="" method="post">
                                <div class="form-check">
                                    <input name="newest" class="form-check-input" type="checkbox" value="" id="flexCheck3" onclick="submit();">
                                    <label class="form-check-label" for="flexCheck3">
                                        الأحدث
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input name="oldest" class="form-check-input" type="checkbox" value="" id="flexCheck4" onclick="submit();">
                                    <label class="form-check-label" for="flexCheck4">
                                        الأقدم
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input name="height_price" class="form-check-input" type="checkbox" value="" id="flexCheck1" onclick="submit();">
                                    <label class="form-check-label" for="flexCheck1">
                                        السعر من الاعلي الي الاقل
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input name="low_price" class="form-check-input" type="checkbox" value="" id="flexCheck2" onclick="submit();">
                                    <label class="form-check-label" for="flexCheck2">
                                        السعر من الاقل الي الاعلي
                                    </label>
                                </div>
                                <!-- Add more options here -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- <div class="col-lg-2">
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
                </div> -->
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
                    <?php
                    if ($totalPages > 1) {
                    ?>
                        <div class="pagination_section">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item <?php echo ($currentpage == 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="/product-category/<?php echo urlencode($cat_slug); ?>/page/<?php echo ($currentpage > 1) ? ($currentpage - 1) : 1; ?>/<?php echo isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : ''; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                    for ($i = 1; $i <= $totalPages; $i++) {
                                        echo '<li class="page-item';
                                        if ($i == $currentpage) {
                                            echo ' active';
                                        }
                                        echo '"><a class="page-link" href="/product-category/' . urlencode($cat_slug) . '/page/' . $i . '/' . (isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '') . '">' . $i . '</a></li>';
                                    }
                                    ?>
                                    <li class="page-item <?php echo ($currentpage == $totalPages) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="/product-category/<?php echo urlencode($cat_slug); ?>/page/<?php echo ($currentpage < $totalPages) ? ($currentpage + 1) : $totalPages; ?>/<?php echo isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : ''; ?>" aria-label="Next">
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