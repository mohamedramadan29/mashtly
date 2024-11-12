<?php
ob_start();
session_start();
$page_title = ' المدونة ';
include "init.php";

// الحصول على الجزء من العنوان بعد اسم الملف (مثل product)
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', $url);
// البحث عن قيمة المتغير بدون كلمة slug
$key = array_search('blog-categories-details', $parts);
$keyPage = array_search('page', $parts);
if ($key !== false && isset($parts[$key + 1])) {
    // يمكنك استخدام $parts[$key+1] كـ slug
    $cat_slug  = $parts[$key + 1];
    $cat_slug =  urldecode($cat_slug);
} else {
    // لم يتم العثور على slug
    echo "العنوان غير صحيح";
}
if ($keyPage !== false && isset($parts[$keyPage + 1])) {
    $keyPage = $parts[$keyPage + 1];
    // $keyPage = $currentpage;
    $currentpage = $keyPage;
} else {
    $currentpage = 1;
}
// echo $cat_slug;
/////////// Get The Category Data 

$stmt = $connect->prepare("SELECT * FROM category_posts WHERE slug =?");
$stmt->execute(array($cat_slug));
$cat_data = $stmt->fetch();
$check_cat = $stmt->rowCount();

if ($check_cat > 0) {
    $cat_id = $cat_data['id'];
}

$stmt = $connect->prepare("SELECT * FROM posts WHERE cat_id = ? AND   publish = 1");
$stmt->execute(array($cat_id));
$count_post = count(($stmt->fetchAll()));
?>
<div class="profile_page adress_page">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> المدونة </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> المدونة </h2>
                    <p> اجمالي عدد المقالات : <span> <?php echo $count_post; ?> </span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- START POST INDEX -->
<div class='index_posts blogs'>
    <div class="container">
        <div class="data">
            <?php
            $stmt = $connect->prepare("SELECT * FROM posts WHERE cat_id = ? AND  publish = 1 ORDER BY id DESC LIMIT 1");
            $stmt->execute(array($cat_id));
            $last_post = $stmt->fetch();
            $post_id = $last_post['id'];
            $post_head = $last_post['name'];
            $cleaned_desc = strip_tags($last_post['description']);
            $post_desc = $cleaned_desc;
            $post_desc = explode(' ', $post_desc);
            // استخدم array_slice للحصول على أول 10 كلمات
            $post_desc_last = implode(' ', array_slice($post_desc, 0, 80));
            $post_short_desc = $last_post['short_desc'];
            $post_date = $last_post['date'];
            $post_slug = $last_post['slug'];
            $post_image = $last_post['main_image'];
            ?>
            <div class='row main_blog'>
                <div class="col-lg-6">
                    <div class="info">
                        <img src="https://www.mshtly.com/admin/posts/images/<?php echo $post_image; ?>" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <a style="text-decoration: none;" href="blog/<?php echo $post_slug; ?>">
                        <div class="info">
                            <h3> <?php echo $post_head; ?> </h3>
                            <p> <?php echo $post_desc_last . '...' ?> </p>
                        </div>
                    </a>
                </div>
            </div>
            <div class='from_blog' >
                <div class='row' id="content_section">
                    <?php
                    $pageSize = 6; // عدد العناصر التي سيتم تحميلها في كل مرة
                    $offset = 0; // البداية من الصفحة الأولى عند التحميل الأول
                    // $stmt = $connect->prepare("SELECT * FROM posts WHERE cat_id = ? AND  publish = 1 AND id !=?");
                    // $stmt->execute(array($cat_id, $post_id));
                    // $num_blogs = $stmt->rowCount();
                    // $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
                    // $pageSize = 12;
                    // $offset = ($currentpage - 1) * $pageSize;

                    $stmt = $connect->prepare("SELECT * FROM posts WHERE cat_id = $cat_id AND  publish = 1  ORDER BY id DESC LIMIT $pageSize OFFSET :offset");
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->execute();
                    $allposts = $stmt->fetchAll();
                    // $totalposts = count($allposts);
                    /////////////////////////////////
                    // $totalPages = ceil($num_blogs / $pageSize);

                    // جلب أول مجموعة من المنشورات
                    // $stmt = $connect->prepare("SELECT * FROM posts WHERE cat_id = ? AND publish = 1 ORDER BY id DESC LIMIT $pageSize OFFSET ?");
                    // $stmt->execute(array($cat_id, $offset));
                    // $allposts = $stmt->fetchAll();

                    // التأكد من أن الصفحة المطلوبة لا تتجاوز العدد الكلي للصفحات
                    // if ($currentpage > $totalPages) {
                    //     // إعادة توجيه المستخدم إلى الصفحة الأخيرة
                    //     header("Location: ?page=$totalPages");
                    //     exit;
                    // }

                    foreach ($allposts as $post) {
                        if ($post['description'] != null) {
                            // إزالة التاجات HTML من الوصف
                            $cleaned_desc = strip_tags($post['description']);

                            // تقسيم النص المنظف إلى كلمات
                            $post_desc = explode(' ', $cleaned_desc);

                            // اختيار أول 20 كلمة
                            $post_desc = implode(' ', array_slice($post_desc, 0, 20));
                        } else {
                            $post_desc = ' ';
                        }
                    ?>
                        <div class="col-lg-4">
                            <a href="https://www.mshtly.com/blog/<?php echo $post['slug']; ?>" style="text-decoration: none;">
                                <div class="post_info">
                                    <img src="https://www.mshtly.com/admin/posts/images/<?php echo $post['main_image'] ?>" alt="<?php echo $post['name'] ?>">
                                    <h4> <?php echo $post['name']; ?> </h4>
                                    <p> <?php echo $post_desc . "..."; ?> </p>
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="load-more-section text-center mt-3">
                    <button id="loadMoreButton" class="btn global_button">مشاهدة المزيد</button>
                </div>


            </div>
        </div>
    </div>
</div>
<!-- END  POST INDEX -->

<?php
include $tem . 'footer.php';
ob_end_flush();
?>

<script>
    let currentPage = 1;
    const pageSize = <?php echo $pageSize; ?>;

    document.getElementById('loadMoreButton').addEventListener('click', function() {
        currentPage++;
        loadMoreContent(currentPage);
    });

    function loadMoreContent(page) {
        fetch(`https://localhost/mashtly/load_more.php?page=${page}&pageSize=${pageSize}&cat_id=<?php echo $cat_id; ?>`)
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "") {
                    // إخفاء الزر إذا لم يكن هناك المزيد من المحتوى
                    document.getElementById('loadMoreButton').style.display = 'none';
                } else {
                    // إضافة المحتوى الجديد
                    document.getElementById('content_section').innerHTML += data;
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>