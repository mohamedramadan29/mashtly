<?php
$stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ?");
$stmt->execute(array($cookie_id));
$cartitemscount = $stmt->rowCount();
$allitems = $stmt->fetchAll();

?>
<div class="offcanvas offcanvas-start cart_offcanvas" tabindex="-1" id="cartItems" aria-labelledby="cartItemsLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="cartItemsLabel"> سلة الشراء </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvas_cart">
            <?php
            if ($cartitemscount > 0) {
                $total_price = 0;
                foreach ($allitems as $item) {
                    $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                    $stmt->execute(array($item['product_id']));
                    $product_data = $stmt->fetch();
                    $pro_slug = $product_data['slug'];
                    $total_price += $item['price'] * $item['quantity'];
                    ?>
                    <div class="cart_item">
                        <div class="item">
                            <div class="item_image">
                                <a href="product/<?php echo $pro_slug ?>">
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                                    $stmt->execute(array($item['product_id']));
                                    $count_image = $stmt->rowCount();
                                    if ($count_image > 0) {
                                        $product_data_image = $stmt->fetch();
                                        ?>
                                        <img class="main_image"
                                            src="uploads/products/<?php echo $product_data_image['main_image']; ?>"
                                            alt="<?php echo $product_data_image['image_alt']; ?>">
                                        <?php
                                    } else {
                                        ?>
                                        <img class="main_image" src="uploads/product.png" alt="">
                                        <?php
                                    }
                                    ?>
                                </a>
                            </div>
                            <div class="item_details">
                                <p> <a href="product/<?php echo $pro_slug ?>"> <?php
                                   $product_name = $item['product_name'];
                                   $product_words = explode(" ", $product_name);
                                   if (count($product_words) > 8) {
                                       $product_name = implode(" ", array_slice($product_words, 0, 8)) . '...';
                                   }
                                   echo $product_name; ?> </a></p>
                                <p dir="rtl"> <span> <?php echo $item['quantity']; ?> </span> <i class="bi bi-x"></i> <span>
                                        <?php echo number_format($item['price'], 2); ?> ريال </span></p>
                                <?php
                                if ($item['vartion_name'] != null && $item['vartion_name'] != '') {
                                    $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE id = ?");
                                    $stmt->execute(array($item['vartion_name']));
                                    $var_data = $stmt->fetch();
                                    $var_name = $var_data['vartions_name'];
                                    ?>
                                    <span class="var_name"> <?php echo $var_name; ?> </span>
                                    <br>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="clear">
                            <form action="" method="post">
                                <div class="">
                                    <input type="hidden" name="item_id" value="<?php echo $item['id'] ?>">
                                    <button type="submit" onclick="return confirm('هل أنت متأكد من رغبتك في حذف المنتج ؟ ');"
                                        name="remove_item" class="remove_item">
                                        <span class="bi bi-x"> </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="cart_total">
                    <div class="total">
                        <span> المجموع </span>
                        <span class="price"> <?php echo $total_price; ?> ريال </span>
                    </div>
                    <div class="buttons">
                        <a href="cart" class="btn global_button"> مشاهدة سلة الشراء </a>
                        <a href="checkout" class="btn global_button checkout"> الدفع واتمام الطلب </a>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="not_found_orders">
                    <div class="info" style="flex-direction: column;">
                        <img src="<?php echo $uploads ?>plant.png" alt="">
                        <br>
                        <h3> لا يوجد منتجات في السلة في الوقت الحالي </h3>
                        <br>
                        <a href="shop" class="btn global_button"> تسوق الان </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
// delete Items From the cart
if (isset($_POST['remove_item'])) {
    $item_id = $_POST['item_id'];
    $stmt = $connect->prepare("DELETE FROM cart WHERE id = ? AND cookie_id=?");
    $stmt->execute(array($item_id, $cookie_id));

    if ($stmt) {

        $total_price = 0;
        // إعادة حساب الإجمالي بعد الحذف
        $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ?");
        $stmt->execute(array($cookie_id));
        $count = $stmt->rowCount();
        $allitems = $stmt->fetchAll();
        foreach ($allitems as $item) {
            $total_price = $total_price + ($item['price'] * $item['quantity']);
        }
        // تحديث قيمة الجلسة
        $_SESSION['total'] = $total_price;
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit; // تأكد من إنهاء التنفيذ بعد إعادة التوجيه
    }
}
?>