<?php
include "vendor/autoload.php";
$yourSiteUrl = 'https://mshtly.com/';

// Setting the current working directory to be the output directory
$outputDir = getcwd();

// Set the sitemap file name
$sitemapFileName = "../sitemap.xml";

// Define an array of product slugs or IDs (assuming you have a list)

// get all products 

$stmt = $connect->prepare("SELECT * FROM products");
$stmt->execute();
$allproducts = $stmt->fetchAll();
foreach ($allproducts as $product) {
    $productUrl = 'https://mshtly.com/product/' . $product['slug'];
    $urls[] = [
        'loc' => $productUrl,
        'lastmod' => (new DateTime())->format('c'),
        'changefreq' => 'always',
        'priority' => 0.5,
    ];
}
// get all product Category

$stmt = $connect->prepare("SELECT * FROM categories");
$stmt->execute();
$allcategories = $stmt->fetchAll();
foreach ($allcategories as $category) {
    $categoryUrl = 'https://mshtly.com/product-category/' . $category['slug'];
    $urls[] = [
        'loc' => $categoryUrl,
        'lastmod' => (new DateTime())->format('c'),
        'changefreq' => 'always',
        'priority' => 0.5,
    ];
}
// get all Articles

$stmt = $connect->prepare("SELECT * FROM posts");
$stmt->execute();
$allarticles = $stmt->fetchAll();
foreach ($allarticles as $article) {
    $articleUrl = 'https://mshtly.com/blog/' . $article['slug'];
    $urls[] = [
        'loc' => $articleUrl,
        'lastmod' => (new DateTime())->format('c'),
        'changefreq' => 'always',
        'priority' => 0.5,
    ];
}

// Add other pages to the sitemap
$urls[] = [
    'loc' => 'https://mshtly.com',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'daily',
    'priority' => 0.8,
];
$urls[] = [
    'loc' => 'https://mshtly.com/cart',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'daily',
    'priority' => 1.0,
];

$urls[] = [
    'loc' => 'https://mshtly.com/checkout',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://mshtly.com/big_orders',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://mshtly.com/contact',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
// $urls[] = [
//     'loc' => 'https://mshtly.com/import_service',
//     'lastmod' => (new DateTime())->format('c'),
//     'changefreq' => 'monthly',
//     'priority' => 0.7,
// ];
$urls[] = [
    'loc' => 'https://mshtly.com/join_us',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
// $urls[] = [
//     'loc' => 'https://mshtly.com/gifts',
//     'lastmod' => (new DateTime())->format('c'),
//     'changefreq' => 'monthly',
//     'priority' => 0.7,
// ];
$urls[] = [
    'loc' => 'https://mshtly.com/faq',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://mshtly.com/delivery_policy',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://mshtly.com/blog',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://mshtly.com/landscap',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://mshtly.com/shop',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://mshtly.com/terms',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
try {
    $xml = new XMLWriter();
    $xml->openUri($sitemapFileName);
    $xml->setIndent(true);
    $xml->startDocument('1.0', 'UTF-8');
    $xml->startElement('urlset');
    $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    foreach ($urls as $url) {
        $xml->startElement('url');
        $xml->writeElement('loc', $url['loc']);
        $xml->writeElement('lastmod', $url['lastmod']);
        $xml->writeElement('changefreq', $url['changefreq']);
        $xml->writeElement('priority', $url['priority']);
        $xml->endElement();
    }
    $xml->endElement();
    $xml->endDocument();
    $xml->flush();


    echo "تم إنشاء وتحديث ملف sitemap بنجاح!";
} catch (\Exception $e) {
    echo "حدثت مشكلة أثناء إنشاء وتحديث ملف sitemap: " . $e->getMessage();
}
// crontab -e
// 0 2 */2 * * /usr/bin/php /http://localhost/mashtly/admin/sitemap/sitemap.php
// /usr/bin/php /http://localhost/mashtly/admin/sitemap/sitemap.php
