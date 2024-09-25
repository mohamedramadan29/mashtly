<?php
// hero_section.php
?>
<div id='hero_lg'></div>
<div id='hero_mobile'></div>

<script>
    // دالة للتحقق من حجم الشاشة وتحميل القسم المناسب
    function loadBlogSection() {
        document.getElementById('hero_lg').innerHTML = '';
        document.getElementById('hero_mobile').innerHTML = '';

        if (window.innerWidth > 991) {
            document.getElementById('hero_lg').innerHTML = `
            <div class="hero">
                <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img loading="lazy" src="uploads/lgbanner1.webp" class="d-block w-100" alt="عروض اليوم الوطني">
                        </div>
                        <div class="carousel-item">
                            <img src="uploads/lgbanner2.webp" class="d-block w-100" alt="عروض اليوم الوطني">
                        </div>
                        <div class="carousel-item">
                            <img src="uploads/lgbanner3.webp" class="d-block w-100" alt="عروض اليوم الوطني">
                        </div>
                    </div>
                </div>
            </div>`;
        } else {
            document.getElementById('hero_mobile').innerHTML = `
            <div class="hero">
                <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img loading="lazy" src="uploads/mbanner11.webp" class="d-block w-100" alt="عروض اليوم الوطني">
                        </div>
                        <div class="carousel-item">
                            <img src="uploads/mbanner2.webp" class="d-block w-100" alt="عروض اليوم الوطني">
                        </div>
                        <div class="carousel-item">
                            <img src="uploads/mbanner3.webp" class="d-block w-100" alt="عروض اليوم الوطني">
                        </div>
                    </div>
                </div>
            </div>`;
        }
    }

    loadBlogSection();
    window.addEventListener('resize', loadBlogSection);
</script>
