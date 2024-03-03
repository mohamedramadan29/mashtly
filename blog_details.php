<?php
ob_start();
session_start();
$page_title = '  المدونة  ';
include "init.php";
// الحصول على الجزء من العنوان بعد اسم الملف (مثل product)
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', $url);
// البحث عن قيمة المتغير بدون كلمة slug
$key = array_search('index', $parts);
if ($key !== false && isset($parts[$key + 1])) {
    // يمكنك استخدام $parts[$key+1] كـ slug
    $slug = $parts[$key + 1];
    $slug =  urldecode($slug);
    
} else {
    // لم يتم العثور على slug
    echo "العنوان غير صحيح";
}
    $stmt = $connect->prepare("SELECT * FROM posts WHERE slug= ?");
    $stmt->execute(array($slug));
    $last_post = $stmt->fetch();
    $count_post = $stmt->rowCount();

    $post_head = $last_post['name'];
    $post_desc = $last_post['description'];

    $post_short_desc = $last_post['short_desc'];
    $post_date = $last_post['date'];
    $post_slug = $last_post['slug'];
    $post_image = $last_post['main_image'];

    // $date = new DateTime($post_date);
    // // Define an array of month names in Arabic
    // $arabic_months = [
    //     1 => "يناير", 2 => "فبراير", 3 => "مارس", 4 => "أبريل", 5 => "مايو", 6 => "يونيو",
    //     7 => "يوليو", 8 => "أغسطس", 9 => "سبتمبر", 10 => "أكتوبر", 11 => "نوفمبر", 12 => "ديسمبر"
    // ];

    // // Get the day, month, and year
    // $day = $date->format('d');
    // $month = $arabic_months[intval($date->format('m'))];
    // $year = $date->format('Y');

    // // Convert the day to Arabic numerals
    // $arabic_day = str_replace(range(0, 9), ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'], $day);

    // // Create the final formatted date
    // $formatted_date = $arabic_day . ' ' . $month . ' ' . $year;
?>
    <div class="profile_page adress_page">
        <div class='container'>
            <div class="data">
                <div class="breadcrump">
                    <p> <a href="index"> الرئيسية </a> \ <span> المدونة </span> </p>
                </div>
                <div class="post_details">
                    <!-- <h5> <img class="calendar_name" src="<?php echo $uploads ?>/calendar2.svg" alt=""> <?php echo $post_date; ?> </h5> -->
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
                            <!-- AddToAny BEGIN -->
                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                <!-- <a class="a2a_dd" href="https://www.addtoany.com/share"></a> -->
                                <a class="a2a_button_facebook"></a>
                                <a class="a2a_button_whatsapp"></a>
                                <a class="a2a_button_linkedin"></a>
                                <a class="a2a_button_twitter"></a>
                                <a class="a2a_button_x"></a>
                                <a class="a2a_button_telegram"></a>
                            </div>
                            <script async src="https://static.addtoany.com/menu/page.js"></script>
                            <!-- AddToAny END -->
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