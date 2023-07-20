<?php
ob_start();
session_start();
$page_title = 'الرئيسية';
include "init.php";
?>
<div class="profile_page adress_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> انضم الينا </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> الأسئلة الشائعة </h2>
                </div>
            </div>
        </div>
        <div class="faqs">
            <div class="row">
                <div class="col-4">
                    <div class="faq">
                        <a href="faq">
                            <img src="<?php echo $uploads ?>faq_join.svg" alt="">
                            <h2> الأسئلة الشائعة </h2>
                        </a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="faq active">
                        <a href="join_us">
                            <img src="<?php echo $uploads ?>join.svg" alt="">
                            <h2> انضم الينا </h2>
                        </a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="faq">
                        <a href="contact">
                            <img src="<?php echo $uploads ?>contact_faq.svg" alt="">
                            <h2> اتصل بنا </h2>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="join_us">
            <p> إذا كنت تبحث عن فرصة عمل شيقة ومثيرة في مجال بيع النباتات عبر الإنترنت، فإن شركة مشتلي تدعوك للانضمام إلى فريقها المتميز. نحن نبحث دائمًا عن المواهب المبدعة والملتزمة لتعزيز فريقنا وتحقيق رؤيتنا المستقبلية. </p>
            <p> كعضو في فريق عمل مشتلي، ستكون جزءًا من مجموعة متنوعة من الشخصيات والخبرات، وستحصل على فرصة لتطوير مهاراتك والاستفادة من خبرات الآخرين. ستعمل على تحقيق أهدافنا المشتركة وتقديم تجربة تسوق رائعة لعملائنا عبر الإنترنت. </p>
            <p> نحن نبحث عن أفراد موهوبين ومتحمسين للعمل في مجالات مثل التسويق الرقمي وتصميم الويب وتطوير البرمجيات وخدمة العملاء والإدارة واللوجستيات. نحن نقدر التنوع والشغف والابتكار، ونحن نلتزم بتوفير بيئة عمل صحية ومرنة ومحفزة. </p>
            <p> إذا كنت ترغب في الانضمام إلى فريقنا، يرجى إرسال سيرتك الذاتية عبر النموذج التالي. سنقوم بالتواصل مع المرشحين المناسبين وترتيب مقابلات شخصية لمناقشة الفرص المتاحة. نحن نتطلع إلى سماع أخبارك والعمل معًا لتحقيق نجاحات جديدة ومثيرة. </p>
        </div>
        <div class="join_form add_new_address">
            <form action="#" method="post" enctype="multipart/form-data">
                <h2> انضم الينا </h2>
                <p> برجاء ملئ الحقول التالية </p>
                <div class='box'>
                    <div class="input_box">
                        <label for="name"> الاسم بالكامل </label>
                        <input id="name" type="text" name="name" class='form-control' placeholder="اكتب…">
                    </div>
                </div>
                <div class="box">
                    <div class="input_box">
                        <label for="phone"> رقم الجوال </label>
                        <input id="phone" type="text" name="phone" class='form-control' placeholder="اكتب…">
                    </div>
                </div>
                <div class='box'>
                    <div class="input_box">
                        <label for="email"> البريد الألكتروني </label>
                        <input id="email" type="email" name="email" class='form-control' placeholder="اكتب…">
                    </div>
                </div>
                <div class='box'>
                    <div class="input_box">
                        <label for="file"> السيرة الذاتية </label>
                        <input id="file" type="file" name="file" class='form-control' placeholder="اكتب…">
                    </div>
                </div>
                <div class="box">
                    <button class="btn global_button" name="join_us"> ارسال </button>
                </div>
            </form>
            <?php
            if (isset($_POST['join_us'])) {
                $name = sanitizeInput($_POST['name']);
                $phone = sanitizeInput($_POST['phone']);
                $email = sanitizeInput($_POST['email']);
                // File
                if (!empty($_FILES['file']['name'])) {
                    $file_name = $_FILES['file']['name'];
                    $file_temp = $_FILES['file']['tmp_name'];
                    $file_type = $_FILES['file']['type'];
                    $file_size = $_FILES['file']['size'];
                    $file_uploaded = time() . '_' . $file_name;
                    move_uploaded_file(
                        $file_temp,
                        'users_attachments/join_files/' . $file_uploaded
                    );
                } else {
                    $formerror[] = 'من فضلك ادخل الملف الخاص بك';
                }
                $formerror = [];
                if (empty($name) || empty($phone) || empty($email)) {
                    $formerror[] = 'من فضلك ادخل المعلومات كاملة ';
                }
                if (empty($formerror)) {
                    $stmt = $connect->prepare("INSERT INTO join_us (name,phone,email,file)
                    VALUES(:zname,:zphone,:zemail,:zfile)
                    ");
                    $stmt->execute(array(
                        "zname" => $name,
                        "zphone" => $phone,
                        "zemail" => $email,
                        "zfile" => $file_uploaded,
                    ));
                    if ($stmt) {
                        alertsendmessage();
                        header('refresh:1.5;url=join_us');
                    }
                } else {
                    foreach ($formerror as $error) {
            ?>
                        <div class="alert alert-danger"> <?php echo $error; ?> </div>
                    <?php
                    }
                    ?>

            <?php
                }
            }

            ?>
        </div>
    </div>

</div>

<?php
include $tem . 'footer.php';
ob_end_flush();
?>