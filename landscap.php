<?php
ob_start();
session_start();
$page_title = ' تنسيق وصيانة الحدائق  ';
$description = 'تنسيق وصيانة الحدائق يضفي جمالًا وأناقة على المساحات الخارجية. استمتع بخدمات العناية بالحدائق التي تشمل الزراعة، التشذيب، والري لتوفير بيئة مريحة وجذابة.';
include "init.php";

?>
<div class="profile_page adress_page">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> تنسيق وصيانة الحدائق  </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> تنسيق وصيانة الحدائق  </h2>
                </div>
            </div>
        </div>
        <div class="landscap">
            <div class="row">
                <?php
                // get all landscap design
                $stmt = $connect->prepare("SELECT * FROM  landscap");
                $stmt->execute();
                $alllandscaps = $stmt->fetchAll();
                foreach ($alllandscaps as $landscap) {
                ?>
                    <div class="col-lg-3">
                        <div class="info">
                            <img src="admin/landscap/images/<?php  echo $landscap['image'] ?>" alt="">
                            <div class="heading">
                                <h3> <?php echo $landscap['name']; ?> </h3>
                                <a href="land/<?php echo $landscap['slug']; ?>" class="global_button"> المزيد عن الخدمة </a>
                            </div>
                        </div>
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