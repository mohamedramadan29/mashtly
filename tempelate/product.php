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
        <a href="http://localhost/mashtly/product/<?php echo $product['slug']; ?>">
            <img class="main_image" src="http://localhost/mashtly/admin/product_images/<?php echo $product_data_image['main_image']; ?>" alt="<?php echo $product['name']; ?>">
        </a>
    <?php
    } else {
    ?>
        <img class="main_image" src="uploads/product.png" alt="صورة المنتج">
    <?php
    }
    ?>
    <div class="product_details">
        <?php
        // استخراج الاسم
        $name = $product['name'];

        // تحويل الاسم إلى مصفوفة من الكلمات
        $words = explode(' ', $name);

        // الحصول على الكلمات الأولى 15
        $shortened_name = implode(' ', array_slice($words, 0, 5));

        // إضافة نقطتين بعد الاسم المختصر
        if (count($words) > 5) {
            $shortened_name .= ' ...';
        }

        // عرض الاسم المختصر

        ?>
        <h2> <a href="http://localhost/mashtly/product/<?php echo $product['slug']; ?>"> <?php echo $shortened_name; ?> </a> </h2>
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
            if ($maximumPrice === $minimumPrice) {
        ?>
                <h4 class='price'> <?php echo number_format($minimumPrice, 2); ?> ر.س </h4>
            <?php
            } else {
            ?>
                <h4 class='price'> <?php echo number_format($minimumPrice, 2); ?> - <?php echo number_format($maximumPrice, 2); ?> ر.س </h4>
            <?php
            }
            ?>

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

            <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
            <input type="hidden" name="price" value="<?php if ($product['sale_price'] != '' && $product['sale_price'] != 0) {
                                                            echo $product['sale_price'];
                                                        } else {
                                                            echo $product['price'];
                                                        } ?>">
            <div class='add_cart'>
                <div>
                    <?php
                    // if (checkIfProductInCart($connect, $cookie_id, $product['id'])) {
                    ?>
                    <!-- <a href="cart" class='btn global_button'> <img src="uploads/shopping-cart.png" alt="سلة الشراء">
                            مشاهدة السلة
                        </a> -->
                    <?php
                    // } else {
                    ?>
                    <?php
                    if ($count_pro_attr > 0) {
                    ?>
                        <?php
                        if ($product['product_status_store'] != 1) {
                        ?>
                            <p class="btn global_button"> المنتج غير متوفر </p>
                        <?php
                        } else {
                        ?>
                            <a href="http://localhost/mashtly/product/<?php echo $product['slug']; ?>" class='btn global_button'> <img src="uploads/shopping-cart.png" alt="">
                                مشاهدة الاختيارات
                            </a>
                        <?php
                        }
                        ?>

                    <?php
                    } else {
                    ?>
                        <?php
                        if ($product['product_status_store'] != 1)  {
                        ?>
                            <button class="btn global_button"> المنتج غير متوفر </button>
                        <?php
                        } else {
                        ?>
                            <button name="add_to_cart" class='btn global_button'>

                                <img alt="سلة الشراء " src="<?php echo $uploads ?>/shopping-cart.png"> أضف
                                الي السلة
                            </button>
                        <?php
                        }
                        ?>

                    <?php
                    }
                    ?>
                    <?php
                    //}
                    ?>
                </div>
                <div class="heart">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                    <?php
                    if (isset($_SESSION['user_id']) && checkIfProductIsFavourite($connect, $_SESSION['user_id'], $product['id'])) {
                    ?>
                        <img src="<?php echo $uploads; ?>/heart2.svg" alt="المفضلة">
                    <?php
                    } else {
                    ?>
                        <button name="add_to_fav" type="submit" style="border: none; background-color:transparent">
                            <img src="<?php echo $uploads ?>/heart.png" alt="المفضلة">
                        </button>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>