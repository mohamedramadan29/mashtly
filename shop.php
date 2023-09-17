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
    $price = $_POST['price'];
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = null;
    }
    $stmt = $connect->prepare("INSERT INTO cart (user_id, cookie_id, product_id,quantity,price,total_price)
    VALUES(:zuser_id, :zcookie_id , :zproduct_id,:zquantity ,:zprice , :ztotal_price)
    ");
    $stmt->execute(array(
        "zuser_id" => $user_id,
        "zcookie_id" => $cookie_id,
        "zproduct_id" => $product_id,
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
$stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1");
$stmt->execute();
$num_products = $stmt->rowCount();
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 20;
$offset = ($currentpage - 1) * $pageSize;

if (isset($_POST['height_price'])) {
    $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1  ORDER BY price DESC LIMIT $pageSize OFFSET :offset");
} elseif (isset($_POST['low_price'])) {
    $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1  ORDER BY price ASC LIMIT $pageSize OFFSET :offset");
} elseif (isset($_POST['newest'])) {
    $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1  ORDER BY id DESC LIMIT $pageSize OFFSET :offset");
} elseif (isset($_POST['oldest'])) {
    $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1  ORDER BY id ASC LIMIT $pageSize OFFSET :offset");
} elseif (isset($_POST['search_options'])) {
    $selectedOptions = $_POST['options'];
    if (!empty($selectedOptions)) {
        // Get product IDs from options table
        $placeholders = implode(',', array_fill(0, count($selectedOptions), '?'));
        $stmt = $connect->prepare("SELECT DISTINCT product_id FROM product_properties_plants WHERE option_id IN ($placeholders)");
        $stmt->execute($selectedOptions);
        $productIDs = $stmt->fetchAll(PDO::FETCH_COLUMN);
        // Get all products with matching IDs
        if (!empty($productIDs)) {
            $productIDsStr = implode(',', $productIDs);
            $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND id IN ($productIDsStr) ORDER BY id DESC LIMIT $pageSize OFFSET :offset");
        }
    }
} else {
    $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1  ORDER BY id DESC LIMIT $pageSize OFFSET :offset");
}
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$allproducts = $stmt->fetchAll();
$totalProducts = count($allproducts);
/////////////////////////////////
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
                        <button class="global_button btn" id="search_orders"> رتب حسب: <span class="selected_search">
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
                                } ?> </span> </button>
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
                                <div class="product_info">
                                    <!-- get the product image -->
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                                    $stmt->execute(array($product['id']));
                                    //  getproductimage($connect,$product['id']);
                                    $count_image = $stmt->rowCount();
                                    $product_data_image = $stmt->fetch();
                                    if ($count_image > 0) {
                                    ?>
                                        <img class="main_image" src="admin/product_images/<?php echo $product_data_image['main_image']; ?>" alt="<?php echo $product_data_image['image_alt']; ?>">
                                    <?php
                                    } else {
                                    ?>
                                        <img class="main_image" src="uploads/product.png" alt="">
                                    <?php
                                    }
                                    ?>

                                    <div class="product_details">
                                        <h2> <a href="product?slug=<?php echo $product['slug']; ?>"> <?php echo $product['name']; ?> </a> </h2>
                                        <?php
                                        $maximumPrice = -INF; // قيمة أقصى سعر ممكنة
                                        $minimumPrice = INF; // قيمة أدنى سعر ممكنة
                                        // نشوف علي المنتج يحتوي علي متغيرات او لا
                                        $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ? AND price != ''");
                                        $stmt->execute(array($product['id']));
                                        $count_pro_attr = $stmt->rowCount();
                                        if ($count_pro_attr > 0) {
                                            $allproduct_data = $stmt->fetchAll();
                                            foreach ($allproduct_data as $product_data) {
                                                $pro_price =  $product_data['price'];
                                                $maximumPrice = max($maximumPrice, $pro_price);
                                                $minimumPrice = min($minimumPrice, $pro_price);
                                            }
                                        ?>
                                            <h4 class='price'> <?php echo number_format($minimumPrice, 2); ?> - <?php echo number_format($maximumPrice, 2); ?> ر.س </h4>
                                        <?php
                                        } else {
                                        ?>
                                            <h4 class='price'> <?php
                                                                if ($product['sale_price'] != '' && $product['sale_price'] != 0) {
                                                                    echo $product['sale_price'];
                                                                } else {
                                                                    echo $product['price'];
                                                                }
                                                                ?> ر.س </h4>
                                        <?php
                                        }
                                        ?>
                                        <form action="" method="post">
                                            <input type="hidden" name="price" value="<?php if ($product['sale_price'] != '' && $product['sale_price'] != 0) {
                                                                                            echo $product['sale_price'];
                                                                                        } else {
                                                                                            echo $product['price'];
                                                                                        } ?>">
                                            <div class='add_cart'>
                                                <div>
                                                    <?php
                                                    if (checkIfProductInCart($connect, $cookie_id, $product['id'])) {
                                                    ?>
                                                        <a href="cart" class='btn global_button'> <img src="uploads/shopping-cart.png" alt="">
                                                            مشاهدة السلة
                                                        </a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <?php
                                                        if ($count_pro_attr > 0) {
                                                        ?>
                                                            <a href="product?slug=<?php echo $product['slug']; ?>" class='btn global_button'> <img src="uploads/shopping-cart.png" alt="">
                                                                مشاهدة الاختيارات
                                                            </a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <button name="add_to_cart" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                                الي السلة
                                                            </button>
                                                        <?php
                                                        }
                                                        ?>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="heart">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                    <?php
                                                    if (isset($_SESSION['user_id']) && checkIfProductIsFavourite($connect, $_SESSION['user_id'], $product['id'])) {
                                                    ?>
                                                        <img src="<?php echo $uploads; ?>/heart2.svg" alt="">
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <button name="add_to_fav" type="submit" style="border: none; background-color:transparent">
                                                            <img src="<?php echo $uploads ?>/heart.png" alt="">
                                                        </button>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="pagination_section">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo '<li class="page-item';
                                    if ($i == $currentpage) {
                                        echo ' active';
                                    }
                                    echo '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                }
                                ?>
                                <li class="page-item">
                                    <a class="page-link" href="" aria-label="Next">
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