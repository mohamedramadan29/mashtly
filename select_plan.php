<?php
ob_start();
session_start();
$page_title = 'الرئيسية';
    include "init.php";
?>
<!-- START SELECT DATA HEADER -->
<div class="select_plan_head">
    <div class="container">
        <div class="data">
            <div class="head">
                <img src="<?php echo $uploads ?>plant.svg" alt="">
                <h2> اختر النباتات الملائمة لاحتياجاتك </h2>
                <p>
                    ان اختيار النباتات الملائمة أمرًا مهمًا للحصول على حديقة نباتية جميلة وصحية. لذلك، يجب النظر في المساحة المتاحة ومدى تعرض النباتات للضوء والرطوبة ودرجة الحرارة والتربة في المنطقة التي تعيش فيها بالاضافة الي العديد من العوامل الاخري.
                </p>
            </div>
        </div>
    </div>
</div>
<!-- END SELECT DATA HEADER -->

<!-- START INDEX ALL CATEGORY  -->
<div class="index_all_cat select_plants">
    <div class="container-fluid">
        <div class="data">
            <div class="data_header">
                <div class="data_header_name">
                    <h2 class='header2'> النباتات </h2>
                    <p> اجمالي نتائج البحث:<span> 1110 </span> </p>
                </div>
                <div class="search_types">
                    <div class="brach_cat">
                        <button class="global_button btn" id="brach_orders"> <img src="<?php echo $uploads ?>filter.png" alt=""> تصنيف حسب </button>
                    </div>
                    <div class="search">
                        <button class="global_button btn" id="search_orders"> رتب حسب: <span class="selected_search"> ----- </span> </button>
                        <div class="options">
                            <form action="">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheck1">
                                    <label class="form-check-label" for="flexCheck1">
                                        السعر من الاعلي الي الاقل
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheck2">
                                    <label class="form-check-label" for="flexCheck2">
                                        السعر من الاقل الي الاعلي
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheck3">
                                    <label class="form-check-label" for="flexCheck3">
                                        الأكثر شعبية
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheck4">
                                    <label class="form-check-label" for="flexCheck4">
                                        الأعلي تقييما
                                    </label>
                                </div>
                                <!-- Add more options here -->
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <div class="all_cat">
                        <div class="search_one">
                            <h4 class="select_search"> تحمل الحرارة <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="search_one">
                            <h4 class="select_search"> موسم الزراعة <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="search_one">
                            <h4 class="select_search"> تحمل الملوحة <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="search_one">
                            <h4 class="select_search"> سهولة العناية <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="search_one">
                            <h4 class="select_search"> الحاجة إلى الإضاءة داخلي <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="search_one">
                            <h4 class="select_search"> الحاجة إلى ضوء الشمس خارجي <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="search_one">
                            <h4 class="select_search"> الموقع المناسب / خارجي <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="search_one">
                            <h4 class="select_search"> الموقع المناسب / داخلي <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="search_one">
                            <h4 class="select_search"> الصلاحية للأكل** <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="search_one">
                            <h4 class="select_search"> استهلاك المياه <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="search_one">
                            <h4 class="select_search"> دور الحياة <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="search_one">
                            <h4 class="select_search"> الاحتياج للرطوبة <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="search_one">
                            <h4 class="select_search"> تحمل التيارات الهوائية <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="search_one">
                            <h4 class="select_search"> سرعة النمو <i class="fa fa-chevron-down"></i> </h4>
                            <div class="options">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تحمل الحرارة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للبرودة)0-20
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة المعتدلة)10–35
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            (محب للحرارة العالية) 30-45
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            يتحمل الصقيع والحرارة العالية
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            غير منطبق
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="product_info">
                                <img class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2>نبات ملكة النهار</h2>
                                    <h4 class='price'> 87.00 ر.س </h4>
                                    <div class='add_cart'>
                                        <div>
                                            <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                الي السلة </a>
                                        </div>
                                        <div class="heart">
                                            <img src="uploads/heart.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="product_info">
                                <img class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2>نبات ملكة النهار</h2>
                                    <h4 class='price'> 87.00 ر.س </h4>
                                    <div class='add_cart'>
                                        <div>
                                            <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                الي السلة </a>
                                        </div>
                                        <div class="heart">
                                            <img src="uploads/heart.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="product_info">
                                <img class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2>نبات ملكة النهار</h2>
                                    <h4 class='price'> 87.00 ر.س </h4>
                                    <div class='add_cart'>
                                        <div>
                                            <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                الي السلة </a>
                                        </div>
                                        <div class="heart">
                                            <img src="uploads/heart.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="product_info">
                                <img class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2>نبات ملكة النهار</h2>
                                    <h4 class='price'> 87.00 ر.س </h4>
                                    <div class='add_cart'>
                                        <div>
                                            <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                الي السلة </a>
                                        </div>
                                        <div class="heart">
                                            <img src="uploads/heart.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="product_info">
                                <img class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2>نبات ملكة النهار</h2>
                                    <h4 class='price'> 87.00 ر.س </h4>
                                    <div class='add_cart'>
                                        <div>
                                            <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                الي السلة </a>
                                        </div>
                                        <div class="heart">
                                            <img src="uploads/heart.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="product_info">
                                <img class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2>نبات ملكة النهار</h2>
                                    <h4 class='price'> 87.00 ر.س </h4>
                                    <div class='add_cart'>
                                        <div>
                                            <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                الي السلة </a>
                                        </div>
                                        <div class="heart">
                                            <img src="uploads/heart.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="product_info">
                                <img class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2>نبات ملكة النهار</h2>
                                    <h4 class='price'> 87.00 ر.س </h4>
                                    <div class='add_cart'>
                                        <div>
                                            <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                الي السلة </a>
                                        </div>
                                        <div class="heart">
                                            <img src="uploads/heart.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="product_info">
                                <img class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2>نبات ملكة النهار</h2>
                                    <h4 class='price'> 87.00 ر.س </h4>
                                    <div class='add_cart'>
                                        <div>
                                            <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                الي السلة </a>
                                        </div>
                                        <div class="heart">
                                            <img src="uploads/heart.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="product_info">
                                <img class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2>نبات ملكة النهار</h2>
                                    <h4 class='price'> 87.00 ر.س </h4>
                                    <div class='add_cart'>
                                        <div>
                                            <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                الي السلة </a>
                                        </div>
                                        <div class="heart">
                                            <img src="uploads/heart.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="product_info">
                                <img class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2>نبات ملكة النهار</h2>
                                    <h4 class='price'> 87.00 ر.س </h4>
                                    <div class='add_cart'>
                                        <div>
                                            <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                الي السلة </a>
                                        </div>
                                        <div class="heart">
                                            <img src="uploads/heart.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="product_info">
                                <img class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2>نبات ملكة النهار</h2>
                                    <h4 class='price'> 87.00 ر.س </h4>
                                    <div class='add_cart'>
                                        <div>
                                            <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                الي السلة </a>
                                        </div>
                                        <div class="heart">
                                            <img src="uploads/heart.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="product_info">
                                <img class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2>نبات ملكة النهار</h2>
                                    <h4 class='price'> 87.00 ر.س </h4>
                                    <div class='add_cart'>
                                        <div>
                                            <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                الي السلة </a>
                                        </div>
                                        <div class="heart">
                                            <img src="uploads/heart.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="pagination_section">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link active" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END INDEX ALL CATEGORY  -->

<?php
include $tem . 'footer.php';
ob_end_flush();
?>