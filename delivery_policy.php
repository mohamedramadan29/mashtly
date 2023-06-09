<?php
ob_start();
session_start();
$page_title = 'الرئيسية';
    include "init.php";
?>
<div class="profile_page new_address_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \
                    <span> التوصيل والإرجاع </span>
                </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> التوصيل والإرجاع </h2>
                    <p class="last_update"> تاريخ آخر تحديث: <span> ١٣ أبريل ٢٠٢٣ </span> </p>
                </div>
            </div>
            <div class="payment_policy">
                <h2> مقدمة </h2>
                <p> مرحبًا بك في صفحة التوصيل والإرجاع لموقع مشتلي لبيع النباتات الالكتروني. نحن نسعى دائمًا لتوفير تجربة شراء مريحة وسهلة لعملائنا، ولذلك نقدم خدمات توصيل موثوقة وإرجاع سلس لضمان رضا العملاء. </p>
                <p> 1- التوصيل: نقوم بتوصيل النباتات إلى المناطق التي يتم تغطيتها من قبل خدمات الشحن المعتمدة في المملكة العربية السعودية. تعتمد تكلفة الشحن على الوزن والحجم وموقع العميل، ويتم تحديد تكلفة الشحن أثناء عملية الشراء. </p>
                <p> 2- مدة التوصيل: يتم تحديد مدة التوصيل حسب المنطقة التي يتم توصيل النباتات إليها، وتتراوح مدة التوصيل بين 2 و 5 أيام عمل.
                </p>
                <p> 3- الإرجاع: يمكن للعميل إرجاع النباتات إذا كانت تعاني من أي مشكلة في الجودة أو الحالة الصحية خلال مدة 3 أيام من استلام الشحنة. يجب على العميل الاتصال بفريق خدمة العملاء لدينا وتزويدنا بالتفاصيل اللازمة لترتيب إرجاع النباتات. </p>
                <p> 4- شروط الإرجاع: يجب أن تكون النباتات في حالة جيدة وغير مستخدمة، ويتحمل العميل تكاليف الشحن لإرجاع النباتات. يتم إجراء فحص للنباتات المرتجعة قبل </p>
                <p> 5- الاسترداد: يتم استرداد المبلغ المدفوع بعد استلام النباتات المرتجعة وتأكيد حالتها الجيدة. يتم استرداد المبلغ بنفس طريقة الدفع التي استخدمت في عملية الشراء. </p>
                <p> نحن نعمل بجد لتوفير خدمات توصيل وإرجاع ممتازة لعملائنا، ويمكنك الاعتماد علينا في تلبية احتياجاتك في مجال الحاصلات الزراعية. في حال وجود أي استفسارات أو مشكلات، يرجى عدم التردد في الاتصال بفريق دعم العملاء لدينا. </p>
                <h2> ما هي المناطق التي يتم توصيل النباتات إليها؟ </h2>

                <p>تعتمد المناطق التي يتم توصيل النباتات إليها على سياسة التوصيل التي نتبعها في موقع مشتلي. يمكننا توصيل النباتات إلى جميع أنحاء المملكة، علما بأن التوصيل المجاني متاح حاليا لسكان مدينة الرياض فقط ونتطلع مستقبلا لتغطية كافة أنحاء المملكة، وذلك يعتمد على الخدمات التي نقدمها وعلى الترتيبات التي نتخذها. </p>
                <p>
                    نحن نسعى دائماً لتوفير خدمة التوصيل الموثوقة والفعالة لعملائنا، ونحن نعمل مع شركاء توصيل موثوقين لنضمن وصول النباتات إلى باب منزلك بأفضل حالاتها ، يمكنكم التواصل معنا إذا كان لديكم أي استفسارات حول سياسة التوصيل التي نتبعها </p>

            </div>
        </div>
    </div>

</div>


<?php
include $tem . 'footer.php';
ob_end_flush();
?>