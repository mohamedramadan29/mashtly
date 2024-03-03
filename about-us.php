<?php
ob_start();
session_start();
$page_title = 'من نحن';
include "init.php";
?>
<div class="profile_page adress_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> من نحن </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> من نحن </h2>
                </div>
            </div>
        </div>
        <div class="join_us">
            <p style='font-size:18px'>
                تم انشاء متجر <strong style="font-weight: bold; font-size:20px"> مشتلي </strong> ليصبح المرجع الأول لتلبية الاحتياجات الزراعية المختلفة لكافة المهتمين في هذا المجال، وقد حرصنا عند انشاءه على مراعاة الأذواق والرغبات المتنوعة لعملائنا وعلى سياسة تسعير منافسة مع تسهيل عمليات الدفع والتوصيل والارجاع.
                وفي المدى القريب ان شاء الله سيسعى المتجر للتوسع جغرافيا لتغطية مواقع ومدن جديدة، ونوعيا بإضافة مجالات واهتمامات زراعية عديدة تشبع مختلف رغبات محبي الزراعة والبستنة.
            </p>
            <a href="contact" class="btn global_button"> تواصل معنا </a>
        </div>
        <div class="d-flex justify-content-between align-items-center main_about" style="margin-top: 40px;">
            <div>
                <img style="max-width: 100%; border-radius:5px;" src="uploads/about_us.webp" alt="">
            </div>
            <div style="margin-right: 20px;">
                <h4 style="color: var(--second-color);margin-top:20px;margin-bottom:20px"> فريق العمل </h4>
                <p style="line-height: 1.8;"> تفضل بالتواصل معنا وفريق العمل على أتم الاستعداد لتلبية طلباتك بكل سرور وسيتم توصيل طلبك الى منزلك, ماعليك إلا أن تشتري ماتريد ونحن سوف نهتم بالباقي. </p>
                <ul class="list-unstyled social_icon2">
                    <li> <a href="https://twitter.com/mshtly"> <i class='fa fa-twitter'> </i> </a> </li>
                    <li> <a href="https://www.instagram.com/mshtly1/"> <i class='fa fa-instagram'> </i> </a> </li>
                    <li> <a href="https://www.youtube.com/channel/UC97csCKptQNPdwQX1AidVXg"> <i class='fa fa-youtube'> </i> </a> </li>
                </ul>
                <style>
                    .social_icon2 li {
                        display: inline-block;
                        margin: 0 10px;
                    }
                    .social_icon2 li i{
                        font-size: 25px;
                        color: var(--second-color);
                    }
                    .social_icon2 a{
                        text-decoration: none;
                    }
                    @media(max-width:991px){
                        .main_about{
                            flex-direction: column;
                        }
                    }
                </style>
            </div>
        </div>
    </div>

</div>

<?php
include $tem . 'footer.php';
ob_end_flush();
?>