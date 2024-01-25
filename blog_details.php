<?php
ob_start();
session_start();
$page_title = '  المدونة  ';
include "init.php";
$slug = $_GET['slug'];
$stmt = $connect->prepare("SELECT * FROM posts WHERE slug= ?");
$stmt->execute(array($slug));
$last_post = $stmt->fetch();
$post_head = $last_post['name'];
$post_desc = $last_post['description'];

$post_short_desc = $last_post['short_desc'];
$post_date = $last_post['date'];
$post_slug = $last_post['slug'];
$post_image = $last_post['main_image'];

$date = new DateTime($post_date);
// Define an array of month names in Arabic
$arabic_months = [
    1 => "يناير", 2 => "فبراير", 3 => "مارس", 4 => "أبريل", 5 => "مايو", 6 => "يونيو",
    7 => "يوليو", 8 => "أغسطس", 9 => "سبتمبر", 10 => "أكتوبر", 11 => "نوفمبر", 12 => "ديسمبر"
];

// Get the day, month, and year
$day = $date->format('d');
$month = $arabic_months[intval($date->format('m'))];
$year = $date->format('Y');

// Convert the day to Arabic numerals
$arabic_day = str_replace(range(0, 9), ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'], $day);

// Create the final formatted date
$formatted_date = $arabic_day . ' ' . $month . ' ' . $year;
?>
<div class="profile_page adress_page">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> المدونة </span> </p>
            </div>
            <div class="post_details">
                <h5> <img class="calendar_name" src="<?php echo $uploads ?>/calendar2.svg" alt=""> <?php echo $formatted_date; ?> </h5>
                <h2> <?php echo $post_head; ?> </h2>
                <img src="admin/posts/images/<?php echo $post_image; ?>" alt="">
                <p class="description"> <?php echo $post_desc; ?> </p>

            </div>
            <div class="product_details">
                <div class="data">
                    <div class="social_share" style="margin-top: 0;">
                        <div>
                            <p> شارك عبر </p>
                        </div>
                        <div>
                            <ul class="list-unstyled">
                                <li> <a href="#"> <i class="fa fa-facebook"></i> </a> </li>
                                <li> <a href="#"> <i class="fa fa-twitter"></i> </a> </li>
                                <li> <a href="#"> <i class="fa fa-whatsapp"></i> </a> </li>
                                <li> <a href="#"> <i class="fa fa-instagram"></i> </a> </li>
                            </ul>
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