<?php
ob_start();
session_start();
$page_title = ' الأرجاع ';
$description = ' لا يوجد سجل بهذة البيانات  ';
include 'init.php';
?>
<div class="profile_page retrun_orders nnn">
    <div class='container'>
        <div class="data"> 
            <div class="not_found_orders">
                <div class="info">
                    <img src="<?php echo $uploads ?>plant.png" alt="">
                    <br>
                    <h1 class="title" style="color: var(--main-color);font-size: 15px;font-weight: bold;"> لا يوجد سجل بهذة البيانات </h1>
                    <br>
                    
                    <a href="index" class="btn global_button"> الرئيسية </a>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>