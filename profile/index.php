<?php
ob_start();
session_start();
$page_title = ' حسابي  ';
include 'init.php';
?>
<div class="profile_page">

<div class='container'>
    <div class="data">
        <div class="breadcrump">
            <p> <a href="#"> الرئيسية   </a> / <span> حسابي  </span> </p>
        </div>
    </div>
</div>

</div>
<?php
include $tem .'footer.php';
ob_end_flush();
?>