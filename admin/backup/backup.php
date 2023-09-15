<div class="container">
    <div class="card text-center">
        <div class="card-body">

            <?php
            // مسار المجلد الرئيسي للموقع
            $sourceFolder = "../../mashtly";

            // اسم ملف النسخة الاحتياطية
            $backupFile = "../../backups/backup_" . date("Y-m-d_H-i-s") . ".zip";

            // الأمر لعمل نسخة احتياطية من قاعدة البيانات باستخدام mysqldump
            $dbHost = 'localhost'; // عنوان استضافة قاعدة البيانات
            $dbUsername = 'root'; // اسم المستخدم لقاعدة البيانات
            $dbPassword = ''; // كلمة المرور لقاعدة البيانات
            $dbName = 'mashtly'; // اسم قاعدة البيانات

            $command = "mysqldump -h $dbHost -u $dbUsername -p$dbPassword $dbName > $sourceFolder/database_backup.sql";
            exec($command);

            // إنشاء ملف النسخة الاحتياطية المضغوط للملفات وقاعدة البيانات
            $zip = new ZipArchive();
            if ($zip->open($backupFile, ZipArchive::CREATE) === TRUE) {
                // إضافة ملفات الموقع إلى الملف المضغوط
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($sourceFolder),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($sourceFolder) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }

                // إضافة نسخة قاعدة البيانات إلى الملف المضغوط
                $zip->addFile("$sourceFolder/database_backup.sql", "database_backup.sql");

                $zip->close();

                if (file_exists($backupFile)) {
                    echo "تم إنشاء نسخة احتياطية للملفات وقاعدة البيانات بنجاح.";
                } else {
            ?>
                    <div class="alert alert-success"> فشل في إنشاء نسخة احتياطية. </div>
                <?php
                }
            } else {
                ?>
                <div class="alert alert-danger"> فشل في إنشاء ملف النسخة الاحتياطية. </div>
            <?php
            }
            ?>
            <br>
            <h4>تنزيل النسخة الاحتياطية</h4>
            <br>
            <p><a class="m-auto btn btn-primary btn-sm" href="<?php echo $backupFile; ?>" download>اضغط هنا لتنزيل النسخة الاحتياطية</a></p>
        </div>
    </div>

</div>