<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src='<?php echo $js; ?>/jquery.min.js'></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src='<?php echo $js; ?>/bootstrap.min.js'></script> -->
<!-- <script src="https://kit.fontawesome.com/588e070751.js" crossorigin="anonymous"></script> -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"> -->
<script src=""></script>
<!--<script src='<?php echo $js; ?>/slick.min.js'></script> -->
<!-- start large image -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe-ui-default.min.js" defer></script>
<!-- end large image -->
<!-- Sweet Alert  -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- <script src='<?php echo $js; ?>/select2.min.js'></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src='<?php echo $js; ?>/jquery.magnific-popup.min.js'></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/lite-youtube-embed/src/lite-yt-embed.js"></script>
<script src='<?php echo $js; ?>/slick.min.js'></script>
<script src='<?php echo $js; ?>/slick-custom.js'></script>

<script src='<?php echo $js; ?>/main.js'></script>
</body>

</html>

<!-- for insta footer -->
<script>
    $(document).ready(function() {
        $('.insta_slider').slick({
            rtl: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            infinite: true,
            prevArrow: false,
            nextArrow: false,
            centerMode: true,
            variableWidth: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,

                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]

        });
    });
</script>

<!-- for products -->


<script>
    $(document).ready(function() {
        $('.products').slick({
            rtl: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            infinite: true,
            prevArrow: '<button type="button" class="slick-prev" aria-label="Previous slide"><i class="bi bi-chevron-right"></i></button>',
            nextArrow: '<button type="button" class="slick-next" aria-label="Next slide"><i class="bi bi-chevron-left"></i></button>',
            centerMode: true,
            variableWidth: false,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        variableWidth: true,
                    }
                }
            ]

        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.products_thumnails').slick({
            rtl: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            infinite: true,
            prevArrow: '<button type="button" class="slick-prev" aria-label="Previous slide"><i class="bi bi-chevron-right"></i></button>',
            nextArrow: '<button type="button" class="slick-next" aria-label="Next slide"><i class="bi bi-chevron-left"></i></button>',
            centerMode: false,
            variableWidth: false,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,

                    }
                },
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]

        });
    });
</script>

<!-- for testmonails -->
<script>
    $(document).ready(function() {
        $('.testmon').slick({
            rtl: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            infinite: true,
            prevArrow: '<img class="right_arrow" alt="right arrow" src="<?php echo $uploads ?>/right_arrow.png">',
            nextArrow: '<img class="left_arrow" alt="left arrow" src="<?php echo $uploads ?>/left_arrow.png">',
            centerMode: false,
            variableWidth: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,

                    }
                },
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]

        });
    });
</script>
