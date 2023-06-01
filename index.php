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

            <div class="carousel-item active">
                <div class="overlay"></div>
                <img src="uploads/header1.png" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>العناية بالنباتات المنزلية 1 </h5>
                    <p> يرغب في تمتعك بنباتات صحية ونامية، وأن تتوفق لأفضل المنتجات المناسبة لك ,لذلك وفرنا خبراء
                        متخصصين بالهندسة الزراعية لتقديم الدعم والتوجيه، ولنساعدك في اختيار النباتات </p>
                    <a href="#" class="btn"> تواصل مع الخبير </a>
                </div>

            </div>
            <div class="carousel-item">
                <div class="overlay"></div>
                <img src="uploads/header1.png" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5> العناية بالنباتات المنزلية  2 </h5>
                    <p>يرغب في تمتعك بنباتات صحية ونامية، وأن تتوفق لأفضل المنتجات المناسبة لك ,لذلك وفرنا خبراء متخصصين
                        بالهندسة الزراعية لتقديم الدعم والتوجيه، ولنساعدك في اختيار
                    </p>
                    <a href="#" class="btn"> تواصل مع الخبير </a>
                </div>
            </div>
            <div class="carousel-item">
                <div class="overlay"></div>
                <img src="uploads/header1.png" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5> العناية بالنباتات المنزلية   3</h5>
                    <p> يرغب في تمتعك بنباتات صحية ونامية، وأن تتوفق لأفضل المنتجات المناسبة لك ,لذلك وفرنا خبراء
                        متخصصين بالهندسة الزراعية لتقديم الدعم والتوجيه، ولنساعدك في اختيار النباتات </p>
                    <a href="#" class="btn"> تواصل مع الخبير </a>
                </div>
            </div>
        </div>
    </div>
</div>






<?php
include $tem . 'footer.php';
ob_end_flush();
?>