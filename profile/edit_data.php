<?php
ob_start();
session_start();
$page_title = ' تعديل بياناتي ';
include 'init.php';
?>
<div class="profile_page new_address_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="../index"> الرئيسية </a> \ <a href="index"> حسابي </a> \
                    <span> تعديل بياناتي </span>
                </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> تعديل بياناتي </h2>
                    <p> تعديل البيانات الشخصية </p>
                </div>
            </div>
            <div class="add_new_address">
                <form action="#" method="post">
                    <div class='row'>
                        <div class='box'>
                            <div class="input_box">
                                <label for="name"> اسم المستخدم  </label>
                                <input id="name" type="text" name="name" class='form-control' placeholder="اكتب…">
                            </div>
                            <div class="input_box">
                                <label for="phone"> رقم الجوال </label>
                                <input id="phone" type="text" name="phone" class='form-control' placeholder="اكتب…">
                            </div>
                        </div>
                        
                        <div class="box">

                            <div class="input_box">
                                <label for="email"> البريد الألكتروني </label>
                                <input id="email" type="text" name="email" class='form-control' placeholder="mashtly@gmail.com">
                            </div>
                            <div class="input_box">
                                <label for="country"> البلد / الدولة </label>
                                <select name="country" id="" class='form-control'>
                                    <option value=""> المملكة العربية السعودية </option>
                                    <option value=""> مصر </option>
                                </select>
                            </div>
                        </div>
 
                        <div class="input_box">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                اشترك في القائمة البريدية لتصلك آخر العروض والخصومات
                                </label>
                            </div>
                        </div>
                        <div class="submit_buttons">
                            <button class="btn global_button" type="reset"> إعادة تعيين </button>
                            <button class="btn global_button"> إضافة عنوان جديد </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>