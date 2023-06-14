<?php
ob_start();
session_start();
$page_title = ' إرجاع المنتجات ';
include 'init.php';
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
                        <h2> شجيرة التيكوما </h2>
                        <span> 87.00 ر.س </span>
                    </div>
                </div>
                <div class="add_new_address">
                    <form action="#" method="post">
                        <div class='row'>
                            <div class="box">
                                <div class="input_box" style="width: 100%;">
                                    <label for="country"> لماذا تريد إرجاع هذا المنتج؟ </label>
                                    <select name="country" id="" class='form-control'>
                                        <option value=""> اختر من القائمة </option>
                                        <option value=""> مصر </option>
                                    </select>
                                </div>
                            </div>
                            <div class="box textarea">
                                <div class="input_box" style="width: 100%;">
                                    <label for="email"> أكتب سبب الإرجاع </label>
                                    <textarea name="reason_contact" id="reason_contact" class="form-control" placeholder=" اكتب السبب… "></textarea>
                                </div>
                            </div>
                            <div class="submit_buttons">
                                <p> قم بإرجاع السلع قبل 19 مايو, 2023 </p>
                                <button class="btn global_button"> قم بالإرجاع </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>