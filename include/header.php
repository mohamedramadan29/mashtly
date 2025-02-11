<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <?php
  // URL الحالي للصفحة
  $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  ?>
  <?php include $tem . 'get_product_meta.php'; ?>
  <title><?php echo isset($meta_title) ? $meta_title : $page_title; ?></title>
  <meta name="description" content="<?php echo isset($meta_short_description) ? $meta_short_description : $description; ?>">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  <meta name="keywords" content="<?php echo isset($meta_keywords) ? $meta_keywords : $page_keywords; ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="<?php echo isset($meta_title) ? $meta_title : $page_title; ?>">
  <meta property="og:description" content="<?php echo isset($meta_short_description) ? $meta_short_description : $description; ?>">
  <!-- <meta property="og:image" content="<?php echo $uploads; ?>/logo.png"> -->
  <meta property="og:image" content="<?php echo isset($pro_image) && $pro_image != '' ? 'uploads/products/' . $pro_image : $uploads . '/logo.png'; ?>">
  <meta property="og:url" content="<?php echo $current_url; ?>">
  <meta property="og:type" content="website"> <!-- يجب أن يكون النوع "website" أو نوع مناسب آخر -->
  <!-- يمكنك أيضًا إضافة Twitter Cards إذا كنت ترغب في ذلك -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?php echo isset($meta_title) ? $meta_title : $page_title; ?>" />
  <meta name="twitter:description" content="<?php echo isset($meta_short_description) ? $meta_short_description : $description; ?>" />
  <meta name="twitter:image" content="<?php echo isset($pro_image) && $pro_image != '' ? 'uploads/products/' . $pro_image : $uploads . '/logo.png'; ?>" />
  <link rel="alternate" href="http://mshtly.com/" hreflang="ar-SA" />
  <link rel="alternate" href="http://mshtly.com/" hreflang="x-default" />
  <link rel="icon" href="<?php echo isset($pro_image) && $pro_image != '' ? 'uploads/products/' . $pro_image : $uploads . '/logo.png'; ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.rtl.min.css">
  <link rel="stylesheet" rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- <link rel="stylesheet" rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
     -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" /> -->
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css">
  <!-- <link rel="stylesheet" href="<?php echo $css; ?>slick.css">
    <link rel="stylesheet" href="<?php echo $css; ?>slick-theme.css"> -->
  <link rel="stylesheet" rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" /> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/default-skin/default-skin.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lite-youtube-embed/src/lite-yt-embed.css" />
  <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.default.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $css; ?>magnific-popup.css">
  <link rel="stylesheet" href="<?php echo $css; ?>select2.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
  <link rel="stylesheet" href="<?php echo $css ?>main.css">
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-Y96EGZ5SEY"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-Y96EGZ5SEY');
  </script>
  <!------------- nnnnnnnnnnnnnnnnnnn    ---------->
  <script src="https://apis.google.com/js/platform.js?onload=renderBadge" defer></script>
  <script>
    window.renderBadge = function() {
      var ratingBadgeContainer = document.createElement("div");
      document.body.appendChild(ratingBadgeContainer);
      window.gapi.load('ratingbadge', function() {
        window.gapi.ratingbadge.render(ratingBadgeContainer, {
          "merchant_id": 5343261729
        });
      });
    }
  </script>
</head>

<body>