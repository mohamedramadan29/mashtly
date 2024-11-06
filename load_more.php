<?php
require 'admin/connect.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = isset($_GET['pageSize']) ? (int)$_GET['pageSize'] : 8;
$cat_id = isset($_GET['cat_id']) ? (int)$_GET['cat_id'] : 0;
$offset = ($page - 1) * $pageSize;

if ($cat_id > 0) {
    // استعلام لجلب المنشورات بناءً على الصفحة
    $query = sprintf("SELECT * FROM posts WHERE cat_id = :cat_id AND publish = 1 ORDER BY id DESC LIMIT %d OFFSET %d", $pageSize, $offset);
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll();

    foreach ($posts as $post) {
        $post_desc = !empty($post['description']) ? implode(' ', array_slice(explode(' ', strip_tags($post['description'])), 0, 20)) : ' ';
    ?>
        <div class="col-lg-4">
            <a href="https://www.mshtly.com/blog/<?php echo htmlspecialchars($post['slug']); ?>" style="text-decoration: none;">
                <div class="post_info">
                    <img src="https://www.mshtly.com/admin/posts/images/<?php echo htmlspecialchars($post['main_image']); ?>" alt="">
                    <h4><?php echo htmlspecialchars($post['name']); ?></h4>
                    <p><?php echo htmlspecialchars($post_desc) . "..."; ?></p>
                </div>
            </a>
        </div>
    <?php
    }
} else {
    echo "Invalid category ID.";
}
?>
