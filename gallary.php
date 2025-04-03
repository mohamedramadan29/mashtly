<?php
ob_start();
session_start();
$page_title = ' معرض الصور ';
$description = ' مشتلي هي منصة إلكترونية مبتكرة تتيح للعملاء شراء مختلف أنواع النباتات، بما في ذلك الأشجار والزهور والنباتات المنزلية، بشكل مريح وسريع. تتميز المنصة بتوفير تجربة تسوق فريدة من نوعها، حيث يمكن للعميل اختيار النباتات التي تناسب احتياجاته دون الحاجة لزيارة المشاتل التقليدية، مما يسهل عليه الحصول على كل ما يحتاجه من راحة منزله.  ';
include "init.php";

?>
<div class="profile_page adress_page">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> معرض الصور </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> معرض الصور </h2>
                </div>
            </div>
        </div>
        <div class="landscap">
            <div class="row">
                <?php
                // get all landscap design
                $stmt = $connect->prepare("SELECT * FROM categories_gallary where status = 1");
                $stmt->execute();
                $categories = $stmt->fetchAll();
                foreach ($categories as $category) {
                    ?>
                    <div class="col-lg-3">
                        <a href="gallary/<?php echo $category['slug'] ?>" style="text-decoration: none;">
                            <div class="info">
                                <img src="uploads/gallary/<?php echo $category['image'] ?>" alt="">
                                <div class="heading" style="padding: 8px;">
                                    <h3 style="margin-bottom: 10px;"> <?php echo $category['name']; ?> </h3>
                                    <p style="color: #3c3b3b;"> <?php echo $category['cat_desc'] ?> </p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                ?>

            </div>
        </div>
    </div>

</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>