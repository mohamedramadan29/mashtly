<?php
ob_start();
session_start();
$page_title = ' اضافة عنوان جديد  ';
include 'init.php';
?>
<div class="profile_page new_address_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="../index"> الرئيسية </a> \ <a href="index"> حسابي </a> \ <a href="address"> عناويني </a> \
                    <span> أضف عنوان جديد </span>
                </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> أضف عنوان جديد </h2>
                    <p> تحكم في عناوين الشحن الخاصه بك </p>
                </div>
            </div>
            <div class="add_new_address">
                <form action="#" method="post">
                    <div class='row'>
                        <div class="box">
                            <div class="input_box">
                                <label for="country"> البلد / الدولة </label>
                                <select name="country" id="" class='form-control'>
                                    <option value=""> المملكة العربية السعودية </option>
                                    <option value=""> مصر </option>
                                </select>
                            </div>
                            <div class="input_box">
                                <label for="country"> المدينة </label>
                                <select name="country" id="" class='form-control'>
                                    <option value=""> القاهرة </option>
                                    <option value=""> الرياض </option>
                                </select>
                            </div>
                        </div>
                        <div class='box'>
                            <div class="input_box">
                                <label for="name"> الاسم بالكامل </label>
                                <input id="name" type="text" name="name" class='form-control' placeholder="اكتب…">
                            </div>
                            <div class="input_box">
                                <label for="phone"> رقم الجوال </label>
                                <input id="phone" type="text" name="phone" class='form-control' placeholder="اكتب…">
                            </div>
                        </div>
                        <div class="box">

                            <div class="input_box">
                                <label for="street"> اسم الشارع </label>
                                <input id="street" type="text" name="street" class='form-control' placeholder="اكتب…">
                            </div>
                            <div class="input_box">
                                <label for="num_building"> رقم المبني </label>
                                <input id="num_building" type="text" name="num_building" class='form-control'
                                    placeholder="اكتب…">
                            </div>
                        </div>

                        <div class="input_box">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    تعيين كعنوان رئيسي
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