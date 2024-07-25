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
                        $email = sanitizeInput($_POST['email']);
                        $rating = sanitizeInput($_POST['rating']);
                        $description = sanitizeInput($_POST['description']);
                        $stmt = $connect->prepare("INSERT INTO mshtly_reviews (email,star,description)
                        VALUES(:zemail,:zstar,:zdescription)
                        ");
                        $stmt->execute(array(
                            'zemail' => $email,
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
                                    <label for="email"> البريد الالكتروني </label>
                                    <input type="text" class="form-control" name="email" value="<?php echo $user_mail; ?>">
                                </div>
                            </div>
                            <div class="box textarea">
                                <div class="input_box" style="width: 100%;">
                                    <label for="rating"> تقيم </label>
                                    <br>
                                    <div class="star-rating">
                                        <input type="radio" name="rating" id="star1" value="5"><label for="star1" title="5 stars"> <i style="font-size: 20px;" class="fa fa-star"></i> </label>
                                        <input type="radio" name="rating" id="star2" value="4"><label for="star2" title="4 stars"><i style="font-size: 20px;" class="fa fa-star"></i> </label>
                                        <input type="radio" name="rating" id="star3" value="3"><label for="star3" title="3 stars"><i style="font-size: 20px;" class="fa fa-star"></i> </label>
                                        <input type="radio" name="rating" id="star4" value="2"><label for="star4" title="2 stars"><i style="font-size: 20px;" class="fa fa-star"></i> </label>
                                        <input type="radio" name="rating" id="star5" value="1"><label for="star5" title="1 star"><i style="font-size: 20px;" class="fa fa-star"></i> </label>
                                    </div>
                                </div>
                            </div>
                            <div class="box textarea">
                                <div class="input_box" style="width: 100%;">
                                    <label for="description"> اكتب تقيمك </label>
                                    <textarea name="description" id="description" class="form-control" placeholder="التقيم ..."></textarea>
                                </div>
                            </div>

                            <div class="submit_buttons">
                                <button class="btn global_button" name="make_review" type="submit"> اضافة تقيم </button>
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
        display: inline-block;
        font-size: 0;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        font-size: 2em;
        color: #ddd;
        cursor: pointer;
    }

    .star-rating input:checked~label {
        color: #f5b301;
    }

    .star-rating label:hover,
    .star-rating label:hover~label,
    .star-rating input:checked~label:hover,
    .star-rating input:checked~label:hover~label,
    .star-rating input:checked~label:hover~label~label {
        color: #f5b301;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-rating input');
        stars.forEach(star => {
            star.addEventListener('change', () => {
                console.log(`Selected rating: ${star.value}`);
            });
        });
    });
</script>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>