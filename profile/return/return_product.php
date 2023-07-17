<?php
ob_start();
session_start();
$page_title = ' إرجاع المنتجات ';
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
                        <p> <a href="../index"> الرئيسية </a> \ <a href="index"> حسابي </a> \
                            <span> إرجاع المنتجات </span>
                        </p>
                    </div>
                    <div class="purches_header">
                        <div class="data_header_name">
                            <h2 class='header2'> إرجاع المنتجات </h2>
                        </div>
                    </div>
                    <div class="return_product">
                        <div class="product">
                            <div class="image">
                                <img src="<?php echo $uploads ?>product.png" alt="">
                            </div>
                            <div>
                                <h2> <?php echo $pro_name ?> </h2>
                                <span> <?php echo number_format($pro_price, 2); ?> ر.س </span>
                            </div>
                        </div>
                        <div class="add_new_address">
                            <form action="" method="post">
                                <div class='row'>
                                    <div class="box">
                                        <div class="input_box" style="width: 100%;">
                                            <label for="return_reason"> لماذا تريد إرجاع هذا المنتج؟ </label>
                                            <select required name="return_reason" id="" class='form-control'>
                                                <option> اختر من القائمة </option>
                                                <option value="يوجد مشكلة في المنتج "> يوجد مشكلة في المنتج </option>
                                                <option value=" ليس هو المنتج المرغوب فية "> ليس هو المنتج المرغوب فية </option>
                                                <option value="اخري">اخري</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="box textarea">
                                        <div class="input_box" style="width: 100%;">
                                            <label for="return_description"> أكتب سبب الإرجاع </label>
                                            <textarea name="return_description" id="return_description" class="form-control" placeholder=" اكتب السبب… "></textarea>
                                        </div>
                                    </div>
                                    <div class="submit_buttons">
                                        <p> قم بإرجاع السلع قبل 19 مايو, 2023 </p>
                                        <button class="btn global_button" name="return_order" type="submit"> قم بالإرجاع </button>
                                    </div>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['return_order'])) {
                                $order_number = $order_number;
                                $product_id = $product_id;
                                $user_id = $user_id;
                                $return_reason = sanitizeInput($_POST['return_reason']);
                                $return_description = sanitizeInput($_POST['return_description']);
                                $table = "return_products";
                                $data = array(
                                    "order_number" => $order_number,
                                    "product_id" => $product_id,
                                    "user_id" => $user_id,
                                    "return_reason" => $return_reason,
                                    "return_description" => $return_description,
                                );
                                $stmt = insertData($connect, $table, $data);
                                if ($stmt) {
                                    $stmt = $connect->prepare("SELECT * FROM  return_products ORDER BY id DESC LIMIT 1");
                                    $stmt->execute();
                                    $return_order = $stmt->fetch();
                                    $return_number = $return_order['id']; 
                                    header('Location:request?num='.$return_number);
                                }
                            }
                            ?>
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
    header("Location:../../index");
}
include $tem . 'footer.php';
ob_end_flush();
?>