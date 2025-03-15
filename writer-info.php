<?php
ob_start();
session_start();
$page_title = ' معلومات الكاتب ';
include "init.php";
$username = $_GET['username'];


$stmt = $connect->prepare("SELECT * FROM employes WHERE username = ?");
$stmt->execute(array($username));
$writer = $stmt->fetch();

?>
<div class="profile_page adress_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> معلومات الكاتب </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> معلومات الكاتب </h2>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-start align-items-center main_about" style="margin-top: 40px;">
            <div>
                <?php
                if ($writer['image'] != '') {
                    echo "<img style='max-width: 100%; border-radius:5px;' src='uploads/emp/" . $writer['image'] . "' alt=''>";
                } else {
                    echo "<img style='max-width: 100%; border-radius:5px;' src='uploads/about_us.webp' alt=''>";
                }
                ?>
            </div>
            <div style="margin-right: 20px;">
                <h4 style="color: var(--second-color);margin-top:20px;margin-bottom:20px">
                    <?php echo $writer['username']; ?> </h4>
                <p style="line-height: 1.8;"> <?php echo $writer['writer_info']; ?> </p>
                <ul class="list-unstyled social_icon2">
                    <li> <a href="https://twitter.com/mshtly"> <i class='fa fa-twitter'> </i> </a> </li>
                    <li> <a href="https://www.instagram.com/mshtly1/"> <i class='fa fa-instagram'> </i> </a> </li>
                    <li> <a href="https://www.youtube.com/channel/UC97csCKptQNPdwQX1AidVXg"> <i class='fa fa-youtube'>
                            </i> </a> </li>
                </ul>
                <style>
                    .social_icon2 li {
                        display: inline-block;
                        margin: 0 10px;
                    }

                    .social_icon2 li i {
                        font-size: 25px;
                        color: var(--second-color);
                    }

                    .social_icon2 a {
                        text-decoration: none;
                    }

                    @media(max-width:991px) {
                        .main_about {
                            flex-direction: column;
                        }
                    }
                </style>
            </div>
        </div>
    </div>

</div>

<?php
include $tem . 'footer.php';
ob_end_flush();
?>