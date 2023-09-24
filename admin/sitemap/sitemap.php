<?php
include "vendor/autoload.php";
$yourSiteUrl = 'https://kuwaitcode.tech/new_mashtly/';

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
    $productUrl = 'https://kuwaitcode.tech/new_mashtly/product?slug=' . $product['slug'];
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
    $categoryUrl = 'https://kuwaitcode.tech/new_mashtly/category_products?slug=' . $category['slug'];
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
    $articleUrl = 'https://kuwaitcode.tech/new_mashtly/blog_details?slug=' . $article['slug'];
    $urls[] = [
        'loc' => $articleUrl,
        'lastmod' => (new DateTime())->format('c'),
        'changefreq' => 'always',
        'priority' => 0.5,
    ];
}

// Add other pages to the sitemap
$urls[] = [
    'loc' => 'https://kuwaitcode.tech/new_mashtly',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'daily',
    'priority' => 0.8,
];
$urls[] = [
    'loc' => 'https://kuwaitcode.tech/cart',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'daily',
    'priority' => 1.0,
];

$urls[] = [
    'loc' => 'https://kuwaitcode.tech/checkout',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://kuwaitcode.tech/big_orders',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://kuwaitcode.tech/contact',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://kuwaitcode.tech/import_service',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://kuwaitcode.tech/join_us',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://kuwaitcode.tech/gifts',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://kuwaitcode.tech/faq',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://kuwaitcode.tech/delivery_policy',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://kuwaitcode.tech/blog',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://kuwaitcode.tech/landscap',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://kuwaitcode.tech/shop',
    'lastmod' => (new DateTime())->format('c'),
    'changefreq' => 'monthly',
    'priority' => 0.7,
];
$urls[] = [
    'loc' => 'https://kuwaitcode.tech/terms',
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

    // Update robots.txt file in the output directory or create a new one
    // (You can add code for this if needed)

    // Submit your sitemap to search engines
    // (You can add code for this if needed)

    echo "تم إنشاء وتحديث ملف sitemap بنجاح!";
} catch (\Exception $e) {
    echo "حدثت مشكلة أثناء إنشاء وتحديث ملف sitemap: " . $e->getMessage();
}
