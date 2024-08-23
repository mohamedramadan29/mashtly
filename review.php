<?php
ob_start();
session_start();
$page_title = ' استبيان للموقع   ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $connect->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute(array($user_id));
    $user_data = $stmt->fetch();
    $user_mail = $user_data['email'];
} else {
    $user_mail = '';
}
?>
<div class="profile_page retrun_orders">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \
                    <span> تقيم تجربتك مع مشتلي </span>
                </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> تقيم تجربتك مع مشتلي </h2>
                </div>
            </div>
            <div class="return_product justify-content-evenly">
                <div class="add_new_address">
                    <?php
                    if (isset($_POST['make_review'])) {
                        $phone = sanitizeInput($_POST['phone']);
                        $rating = sanitizeInput($_POST['rating']);
                        $description = sanitizeInput($_POST['description']);
                        $stmt = $connect->prepare("INSERT INTO mshtly_reviews (email,star,description)
                        VALUES(:zemail,:zstar,:zdescription)
                        ");
                        $stmt->execute(array(
                            'zemail' => $phone,
                            'zstar' => $rating,
                            'zdescription' => $description,
                        ));
                        if ($stmt) {
                    ?>
                            <div class="alert alert-success"> شكرا لك !! تم اضافة التقيم الخاص بك بنجاح </div>
                    <?php
                        }
                    }
                    ?>
                    <br>
                    <form action="" method="post">
                        <div class='row'>
                            <div class="box textarea">
                                <div class="input_box" style="width: 100%;">
                                    <label for="email"> رقم الهاتف </label>
                                    <?php
                                    if (isset($_SESSION['user_id'])) {
                                        $stmt = $connect->prepare("SELECT * FROM users WHERE id=?");
                                        $stmt->execute(array($_SESSION['user_id']));
                                        $user_data = $stmt->fetch();
                                        $phone = $user_data['phone'];
                                    ?>
                                        <input required type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" style="margin-bottom: 15px;">
                                    <?php
                                    } else {
                                    }
                                    ?> 
                                </div>
                            </div>

                            <div class="box textarea">
                                <div class="input_box" style="width: 100%;">
                                    <label for="rating"> تقييم </label>
                                    <br>
                                    <div class="star-rating">
                                        <input type="radio" name="rating" id="star1" value="1"><label style="font-size:22px" for="star1" title="1 stars"> ★ </label>
                                        <input type="radio" name="rating" id="star2" value="2"><label style="font-size:22px" for="star2" title="2 stars"> ★ </label>
                                        <input type="radio" name="rating" id="star3" value="3"><label style="font-size:22px" for="star3" title="3 stars"> ★ </label>
                                        <input type="radio" name="rating" id="star4" value="4"><label style="font-size:22px" for="star4" title="4 stars"> ★ </label>
                                        <input type="radio" name="rating" id="star5" value="5"><label style="font-size:22px" for="star5" title="5 star"> ★ </label>
                                    </div>
                                </div>
                            </div>

                            <div class="box textarea">
                                <div class="input_box" style="width: 100%;">
                                    <label for="description"> اكتب تقييمك </label>
                                    <textarea name="description" id="description" class="form-control" placeholder="التقييم ..." style="margin-bottom: 15px;"></textarea>
                                </div>
                            </div>

                            <div class="submit_buttons">
                                <button class="btn global_button" name="make_review" type="submit" style="padding: 10px 20px; background-color: #f5b301; color: white; border: none; border-radius: 5px;"> إضافة تقييم </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

?>
<?php

include $tem . 'footer.php';
ob_end_flush();
?>
<style>
    .star-rating {
        direction: rtl;
        display: inline-flex;
        font-size: 1.5em;
    }

    .star-rating input {
        opacity: 0;
        position: absolute;
    }

    .star-rating label {
        color: #ddd;
        cursor: pointer;
        transition: color 0.3s ease;
        padding: 0 5px;
    }

    .star-rating input:checked~label,
    .star-rating input:checked~label~label {
        color: #f5b301;
    }

    .star-rating label:hover,
    .star-rating label:hover~label {
        color: #f5b301;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-rating input');

        stars.forEach(star => {
            star.addEventListener('change', () => {
                // Clear all colors
                stars.forEach(s => s.nextElementSibling.style.color = '#ddd');

                // Color the selected star and all previous stars
                star.nextElementSibling.style.color = '#f5b301';
                let previousSibling = star.previousElementSibling;
                while (previousSibling) {
                    if (previousSibling.tagName === 'INPUT') {
                        previousSibling.nextElementSibling.style.color = '#f5b301';
                    }
                    previousSibling = previousSibling.previousElementSibling;
                }
            });
        });
    });
</script>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>