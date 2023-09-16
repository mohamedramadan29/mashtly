<?php

include "vendor/autoload.php";

$yourSiteUrl = 'https://www.mshtly.com/';

// Setting the current working directory to be the output directory
$outputDir = getcwd();

$generator = new \Icamys\SitemapGenerator\SitemapGenerator($yourSiteUrl, $outputDir);

// Create a compressed sitemap
$generator->enableCompression();

// Determine how many URLs should be put into one file;
$generator->setMaxUrlsPerSitemap(50000);

// Set the sitemap file name
$generator->setSitemapFileName("sitemap.xml"); // انتبه إلى امتداد الملف المضغوط

// Set the sitemap index file name
$generator->setSitemapIndexFileName("sitemap-index.xml");

// Define an array of product slugs or IDs (assuming you have a list)
// get all products 

$stmt = $connect->prepare("SELECT * FROM products");
$stmt->execute();
$allproducts = $stmt->fetchAll();
foreach ($allproducts as $product) {
    $productUrl = 'https://www.mshtly.com/products/' . $product['slug'];
    $generator->addURL($productUrl, new DateTime(), 'always', 0.5);
}
// Add other pages to the sitemap
$generator->addURL('https://www.mshtly.com/', new DateTime(), 'daily', 1.0);
$generator->addURL('https://www.mshtly.com/contact', new DateTime(), 'daily', 0.8);
$generator->addURL('https://www.mshtly.com/privacy-policy', new DateTime(), 'monthly', 0.7);

try {
    // Flush all stored URLs from memory to the disk and close all necessary tags.
    $generator->flush();

    // Move flushed files to their final location. Compress if the option is enabled.
    $generator->finalize();

    // Update robots.txt file in the output directory or create a new one
    $generator->updateRobots();

    // Submit your sitemap to search engines
    $generator->submitSitemap();

    echo "تم إنشاء ملف sitemap بنجاح! يمكنك تنزيل الملف المضغوط من هذا الرابط: ";
    echo '<a href="sitemap.xml.gz">تنزيل الملف المضغوط</a>';
} catch (\Exception $e) {
    echo "حدثت مشكلة أثناء إنشاء ملف sitemap: " . $e->getMessage();
}
