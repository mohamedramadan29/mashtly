<?php
ob_start();
session_start();
$page_title = ' اضافة تقيم علي المنتج  ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (isset($_GET['order'])) {
        $order_number = $_GET['order'];
    } else {
        header("Location:../index");
    }
    if (isset($_GET['product']) && is_numeric($_GET['product'])) {
        $product_id = $_GET['product'];
        // get product data
        $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute(array($product_id));
        $count_pro = $stmt->rowCount();
        if ($count_pro > 0) {
            $product_data = $stmt->fetch();
            $pro_name = $product_data['name'];
            $pro_price = $product_data['price'];
        } else {
            header("Location:../index");
        }
    } else {
        header("Location:../index");
    }
    // get the product image s
    $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
    $stmt->execute(array($product_id));
    $product_image_data = $stmt->fetch();
    $product_image = "../../admin/product_images/" . $product_image_data['main_image'];

    // Check if this order from this user or not 
    $stmt = $connect->prepare("SELECT * FROM orders WHERE order_number = ? AND user_id = ?");
    $stmt->execute(array($order_number, $user_id));
    $count = $stmt->fetch();
    if ($count > 0) {
?>
        <div class="profile_page retrun_orders">
            <div class='container'>
                <div class="data">
                    <div class="breadcrump">
                        <p> <a href="../index"> الرئيسية </a> \ <a href="../index"> حسابي </a> \
                            <span> اضافه تقيم علي المنتج </span>
                        </p>
                    </div>
                    <div class="purches_header">
                        <div class="data_header_name">
                            <h2 class='header2'> اضافه تقيم علي المنتج </h2>
                        </div>
                    </div>
                    <div class="return_product justify-content-evenly">
                        <div class="product">
                            <div class="image">
                                <img src="<?php echo $product_image; ?>" alt="">
                            </div>
                            <div>
                                <h2> <?php echo $pro_name ?> </h2>
                                <span> <?php echo number_format($pro_price, 2); ?> ر.س </span>
                            </div>
                        </div>
                        <div class="add_new_address">
                            <?php
                            if (isset($_POST['return_order'])) {
                                $order_number = $order_number;
                                $product_id = $product_id;
                                $user_id = $user_id;
                                $review = sanitizeInput($_POST['return_description']);
                                $date = date("Y-m-d");
                                $table = "product_reviews";
                                $data = array(
                                    "order_number" => $order_number,
                                    "product_id" => $product_id,
                                    "user_id" => $user_id,
                                    "date" => $date,
                                    "review" => $review,
                                );
                                $stmt = insertData($connect, $table, $data);
                                if ($stmt) {
                            ?>
                                    <div class="alert alert-success"> شكرا لك تم اضافة تقيمك علي المنتج بنجاح </div>
                            <?php
                                }
                            }
                            ?>
                            <form action="" method="post">
                                <div class='row'>

                                    <div class="box textarea">
                                        <div class="input_box" style="width: 100%;">
                                            <label for="return_description"> اكتب تقيمك </label>
                                            <textarea name="return_description" id="return_description" class="form-control" placeholder="التقيم ..."></textarea>
                                        </div>
                                    </div>
                                    <div class="submit_buttons">
                                        <button class="btn global_button" name="return_order" type="submit"> اضافة تقيم </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {
        header("location:../index");
    }
    ?>
<?php
} else {
    header("location:../../login");
}
include $tem . 'footer.php';
ob_end_flush();
?>