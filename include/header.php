<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <?php include $tem . 'get_product_meta.php'; ?>
    <title> <?php if (isset($meta_title)) {
                echo $meta_title;
            } else {
                echo $page_title;
            } ?> </title>
    <meta name="description" content="<?php if (isset($meta_short_description)){ echo $meta_short_description;}else{
        echo $description;
    } ?>">
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
    <meta name="keywords" content="<?php if (isset($meta_keywords)){ echo $meta_keywords;}else{echo $page_keywords;} ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image" href="<?php echo $uploads ?>/logo.png">
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>slick.css">
    <link rel="stylesheet" href="<?php echo $css; ?>slick-theme.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/default-skin/default-skin.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>magnific-popup.css">
    <link rel="stylesheet" href="<?php echo $css; ?>select2.min.css">
    <link rel="stylesheet" href="<?php echo $css ?>main.css">

</head>

<body>