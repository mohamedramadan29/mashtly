<?php
include "vendor/autoload.php";

$yourSiteUrl = 'https://mshtly.com/';
$outputDir = getcwd();
$sitemapFileName = "../sitemap-images.xml";

try {
    // قاعدة البيانات: جلب صور المنتجات
    $stmt = $connect->prepare("SELECT p.id, p.slug, p.name, pi.main_image FROM products p 
                              JOIN products_image pi ON p.id = pi.product_id WHERE p.publish = 1");
    $stmt->execute();
    $allProductImages = $stmt->fetchAll();

    // جلب صور المقالات
    $stmt = $connect->prepare("SELECT slug, name, main_image FROM posts WHERE main_image IS NOT NULL");
    $stmt->execute();
    $allArticleImages = $stmt->fetchAll();

    // إنشاء ملف XML
    $xml = new XMLWriter();
    $xml->openUri($sitemapFileName);
    $xml->setIndent(true);
    $xml->startDocument('1.0', 'UTF-8');
    $xml->startElement('urlset');
    $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    $xml->writeAttribute('xmlns:image', 'http://www.google.com/schemas/sitemap-image/1.1');

    // إضافة صور المنتجات إلى Sitemap
    foreach ($allProductImages as $product) {
        $imagePath = 'https://mshtly.com/uploads/products/' . $product['main_image'];
        $xml->startElement('url');
        $xml->writeElement('loc', $yourSiteUrl . 'product/' . $product['slug']);
        $xml->startElement('image:image');
        $xml->writeElement('image:loc', $imagePath);
        $xml->writeElement('image:title', htmlspecialchars($product['name']));
        $xml->endElement();
        $xml->endElement();
    }

    // إضافة صور المقالات إلى Sitemap
    foreach ($allArticleImages as $article) {
        $imagePath = 'https://mshtly.com/uploads/posts/' . $article['image'];
        $xml->startElement('url');
        $xml->writeElement('loc', $yourSiteUrl . 'blog/' . $article['slug']);
        $xml->startElement('image:image');
        $xml->writeElement('image:loc', $imagePath);
        $xml->writeElement('image:title', htmlspecialchars($article['title']));
        $xml->endElement();
        $xml->endElement();
    }

    $xml->endElement();
    $xml->endDocument();
    $xml->flush();
    echo "✅ تم إنشاء وتحديث ملف sitemap-images.xml بنجاح!";
} catch (\Exception $e) {
    echo "❌ حدثت مشكلة أثناء إنشاء وتحديث ملف sitemap: " . $e->getMessage();
}
