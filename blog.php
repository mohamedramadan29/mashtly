<?php
ob_start();
session_start();
$page_title = ' المدونة ';
include "init.php";
$stmt = $connect->prepare("SELECT * FROM posts WHERE publish = 1");
$stmt->execute();
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
            $stmt = $connect->prepare("SELECT * FROM posts WHERE publish = 1 ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            $last_post = $stmt->fetch();
            $post_id = $last_post['id'];
            $post_head = $last_post['name'];
            $post_desc = $last_post['description'];
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
                        <img src="admin/posts/images/<?php echo $post_image; ?>" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <a style="text-decoration: none;" href="blog_details?slug=<?php echo $post_slug; ?>">
                        <div class="info">
                            <h3> <?php echo $post_head; ?> </h3>
                            <p> <?php echo $post_desc_last . '...' ?> </p>
                        </div>
                    </a>
                </div>
            </div>
            <div class='from_blog'>
                <div class='row'>
                    <?php
                    $stmt = $connect->prepare("SELECT * FROM posts WHERE publish = 1 AND id !=?");
                    $stmt->execute(array($post_id));
                    $allposts = $stmt->fetchAll();
                    foreach ($allposts as $post) {
                        $post_desc = explode(' ', $post['description']);
                        $post_desc = implode(' ', array_slice($post_desc, 0, 20));
                    ?>
                        <div class="col-lg-4">
                            <a href="blog_details?slug=<?php echo $post['slug']; ?>" style="text-decoration: none;">
                                <div class="post_info">
                                    <img src="admin/posts/images/<?php echo $post['main_image'] ?>" alt="">
                                    <h4> <?php echo $post['name']; ?> </h4>
                                    <p> <?php echo $post_desc . "..."; ?> </p>
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
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