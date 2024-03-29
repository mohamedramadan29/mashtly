<?php
ob_start();
session_start();
$page_title = 'الأسئلة الشائعة';
include "init.php";
?>
<div class="profile_page adress_page">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> الأسئلة الشائعة </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> الأسئلة الشائعة </h2>
                </div>
            </div>
        </div>
        <div class="faqs">
            <div class="row">
                <div class="col-4">
                    <div class="faq active">
                        <a href="faq">
                            <img src="<?php echo $uploads ?>quest.svg" alt="">
                            <h2> الأسئلة الشائعة </h2>
                        </a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="faq">
                        <a href="join_us">
                            <img src="<?php echo $uploads ?>work_faq.svg" alt="">
                            <h2> انضم الينا </h2>
                        </a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="faq">
                        <a href="contact">
                            <img src="<?php echo $uploads ?>contact_faq.svg" alt="">
                            <h2> اتصل بنا </h2>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="question">
            <div class="row">
                <div class="col-lg-3">
                    <div class="ques_contact">
                        <h2> اذا لم تجد استفسارك هنا </h2>
                        <p> يمكنكم أيضا التواصل معنا وارسال استفساراتكم عبر هذا الرابط </p>
                        <a href="#" class="btn global_button"> اتصل بنا </a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="resposne">
                        <span class="last_update"> آخر تحديث: ٢٣ أكتوبر ٢٠٢٣ </span>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingthree">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree" aria-expanded="true" aria-controls="collapsethree">
                                        ما هو موقع مشتلي ؟
                                    </button>
                                </h2>
                                <div id="collapsethree" class="accordion-collapse collapse show" aria-labelledby="headingthree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p> مشتلي متجر إلكتروني يوفر لكم أصناف عديدة و متنوعة من النباتات المحلية و المستوردة ، بالإضافة لكل أنواع المستلزمات الزراعية التي يمكن أن يحتاجها مالكو النباتات و المزارعين من أجل استخدامها لزراعة و رعاية مزروعاتهم . </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        هل يمكن طلب النباتات بكمية كبيرة ؟
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>
                                            أهلا بكم في متجر مشتلي ، نعم يمكنكم طلب الكميات الكبيرة و ذلك عبر زيارة الصفحة المخصصة (للطلبيات الكبيرة - رابط داخلي ) التي قمنا بإعدادها خصيصا لعملائنا من المؤسسات التجارية و غيرها.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingtwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        هل يمكن الدفع عند الاستلام ؟
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p> نعم ، نحرص في متجر مشتلي على توفير أساليب الدفع الملائمة للجميع ، يمكنكم الإختيار بين الدفع الالكتروني و الدفع عند الإستلام خلال عملية إتمام الطلب . </p>
                                    </div>
                                </div>
                            </div>


                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingfive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
                                        هل يمكن شحن النباتات خارج المملكة ؟
                                    </button>
                                </h2>
                                <div id="collapsefive" class="accordion-collapse collapse" aria-labelledby="headingfive" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p> النباتات منتجات حساسة لعوامل التهوية ، الإضاءة و الرطوبة ، فهي إذا تحتاج لظروف شحن خاصة للحفاظ على سلامتها ، لذلك لا يقوم متجر مشتلي بالشحن الدولي كما أنه يقوم بتوصيلها لمناطق محددة فقط داخل المملكة حسب توفر الظروف الملائمة التي تضمن سلامتها. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingsix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesix" aria-expanded="false" aria-controls="collapsesix">
                                        هل توفر مشتلي نباتات طبية ؟
                                    </button>
                                </h2>
                                <div id="collapsesix" class="accordion-collapse collapse" aria-labelledby="headingsix" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p> لا ، مع حرص متجر مشتلي على توفير النبااتات التي تلبي احتياجات عملائه إلا أنه لا يمكن أن يوفر منتجات تحتاج لتعليمات خاصة للاستعمال مثل النباتات الطبية .
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingseven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
                                        هل يمكن الحصول على استشارات عن العناية بالنباتات ؟
                                    </button>
                                </h2>
                                <div id="collapseseven" class="accordion-collapse collapse" aria-labelledby="headingseven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>
                                            بكل تأكيد ، نحرص في متجرنا على مواكبة كل عملائنا خلال عملية زراعة و رعاية نباتاتهم بعد توصلهم بها ، كما أننا نتيح خدمة الإستشارة مجانا لكل زوار المت </p>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
include $tem . 'footer.php';
ob_end_flush();
?>