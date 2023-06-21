<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="themes/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="themes/css/slick-theme.css" />
   
    <style>
        .slider1,
        .slider2 {
            width: 300px;
            margin: 0 auto;
        }

        .slider2 {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="slider1">
        <div><img src="uploads/product.png" alt="Image 1"></div>
        <div><img src="uploads/product.png" alt="Image 2"></div>
        <div><img src="uploads/product.png" alt="Image 3"></div>
    </div>
    <div class="slider2">
        <div><img src="uploads/product.png" alt="Image 1"></div>
        <div><img src="uploads/product.png" alt="Image 2"></div>
        <div><img src="uploads/product.png" alt="Image 3"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="themes/js/slick.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.slider1').slick({
                arrows: false,
                asNavFor: '.slider2'
            });

            $('.slider2').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                asNavFor: '.slider1',
                centerMode: true,
                focusOnSelect: true
            });
        });
    </script>
</body>

</html>