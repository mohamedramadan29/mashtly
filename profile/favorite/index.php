<?php
ob_start();
session_start();
$page_title = ' المفضلة  ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $connect->prepare("SELECT * FROM user_favourite WHERE user_id=?");
    $stmt->execute(array($user_id));
    $allfav = $stmt->fetchAll();
    $count = $stmt->rowCount();
?>
    <div class="profile_page adress_page">
        <div class='container'>
            <div class="data">
                <div class="breadcrump">
                    <p> <a href="../index"> الرئيسية </a> \ <a href="../index"> حسابي </a> \ <span> المفضلة </span> </p>
                </div>
                <div class="purches_header">
                    <div class="data_header_name">
                        <h2 class='header2'> المفضلة </h2>
                        <p> عدد عناصر المفضلة: <?php echo $count; ?></p>
                    </div>
                </div>
            </div>

            <?php
            // remove items 
            if (isset($_POST['remove'])) {
                $product_id = $_POST['product_id'];
                $stmt = $connect->prepare("DELETE FROM user_favourite WHERE user_id = ? AND product_id = ?");
                $stmt->execute(array($user_id, $product_id));
                if ($stmt) {
                    header("location:index");
                }
            }
            ?>
            <?php
            if ($count > 0) {
            ?>

                <div class="favorite">
                    <?php
                    foreach ($allfav as $fav) {
                        $stmt = $connect->prepare("SELECT * FROM products WHERE id=?");
                        $stmt->execute(array($fav['product_id']));
                        $product_data = $stmt->fetch();
                    ?>
                        <div class="fav_data">
                            <div class="product_data">
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                                $stmt->execute(array($product_data['id']));
                                //  getproductimage($connect,$product['id']);
                                $count_image = $stmt->rowCount();
                                $product_data_image = $stmt->fetch();
                                ?>
                                <a href="../../product?slug=<?php echo $product_data['slug']; ?>">
                                    <div class="image">
                                        <img src="../../admin/product_images/<?php echo $product_data_image['main_image'];  ?>" alt="">
                                    </div>
                                </a>
                                <div>
                                    <a style="text-decoration: none; color:#4e4e4e" href="../../product?slug=<?php echo $product_data['slug']; ?>">
                                        <h3> <?php echo $product_data['name']; ?> </h3>
                                    </a>
                                    <span> <?php echo number_format($product_data['price'], 2) ?> ر.س </span>
                                </div>
                            </div>
                            <div class="remove">
                                <form action="" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $product_data['id']; ?>">
                                    <!-- <button class="btn global_button"> أضف الي السلة </button> -->
                                    <p> <span class="fa fa-close"></span> <button id="remove"  type="submit" name="remove" onclick="return confirmDelete();"> إزالة من المفضلة </button> </p>
                                </form>
                            </div>
                        </div>
                    <?php
                    }

                    ?>
                </div>
            <?php
            } else {
            ?>
                <div class="alert alert-success text-center"> لا يوجد لديك عناصر في المفضلة !! </div>
            <?php
            }

            ?>
        </div>
    </div>
<?php
} else {
    header("location:../../login");
}
?>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>

<script>
    function confirmDelete() {
        return confirm("هل أنت متأكد من رغبتك في الحذف؟");
    }
</script>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>