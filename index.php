<?php
ob_start();
session_start();
$page_title = 'مشتلي - الرئيسية';
include 'init.php';
?>
<div class="hero">

    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">

            <div class="carousel-item carousel-item1 active" style="backh">
                <div class="overlay"></div>
                <div class="carousel-caption">
                    <h5>العناية بالنباتات المنزلية 1 </h5>
                    <p> يرغب في تمتعك بنباتات صحية ونامية، وأن تتوفق لأفضل المنتجات المناسبة لك ,لذلك وفرنا خبراء
                        متخصصين بالهندسة الزراعية لتقديم الدعم والتوجيه، ولنساعدك في اختيار النباتات </p>
                    <a href="#" class="btn"> تواصل مع الخبير </a>
                </div>
            </div>
            <div class="carousel-item carousel-item1">
                <div class="overlay"></div>
                <div class="carousel-caption">
                    <h5> العناية بالنباتات المنزلية 2 </h5>
                    <p>يرغب في تمتعك بنباتات صحية ونامية، وأن تتوفق لأفضل المنتجات المناسبة لك ,لذلك وفرنا خبراء متخصصين
                        بالهندسة الزراعية لتقديم الدعم والتوجيه، ولنساعدك في اختيار
                    </p>
                    <a href="#" class="btn"> تواصل مع الخبير </a>
                </div>
            </div>
            <div class="carousel-item carousel-item1">
                <div class="overlay"></div>
                <div class="carousel-caption">
                    <h5> العناية بالنباتات المنزلية 3</h5>
                    <p> يرغب في تمتعك بنباتات صحية ونامية، وأن تتوفق لأفضل المنتجات المناسبة لك ,لذلك وفرنا خبراء
                        متخصصين بالهندسة الزراعية لتقديم الدعم والتوجيه، ولنساعدك في اختيار النباتات </p>
                    <a href="#" class="btn global_buttom"> تواصل مع الخبير </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- START AUTOMATIC SEARCH INDEX -->

<div class="index_automatic_search">
    <div class="container">
        <div class="data">
            <div class="row">
                <div class="col-lg-6">
                    <div class="info info2">
                        <h2> استخدم باحث مشتلي الآلي </h2>
                        <p> إن تحديد المواصفات المرغوبة بشكل مسبق في النباتات التي تبحث عنها سيسهل عليك الوصول إليها
                            ويساعدك في اختيار الأنسب، سواء كنت تبحث عن نبات يمتاز بشكل جمالي معين أو بسهولة العناية أو
                            لاستخدامه في مكان محدد أو يتحمل ضروف بيئية معينة …. أو غير ذالك. </p>
                        <a href="#" class="global_buttom"> جرب الباحث الآلي الآن <img src="uploads/search_arrow.svg" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info">
                        <img src="uploads/index_d_search.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- END AUTOMATIC SEARCH INDEX -->
<?php
include $tem . 'footer.php';
ob_end_flush();
?>