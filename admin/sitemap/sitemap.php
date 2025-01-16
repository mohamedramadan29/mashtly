<?php
include "vendor/autoload.php";

$yourSiteUrl = 'https://mshtly.com/';
$outputDir = getcwd();
$sitemapFileName = "../sitemap.xml";

try {
    // قاعدة البيانات: جلب المنتجات
    $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1");
    $stmt->execute();
    $allproducts = $stmt->fetchAll();

    // إعداد الروابط الخاصة بالمنتجات
    foreach ($allproducts as $product) {
        $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
        $stmt->execute([$product['id']]);
        $productImage = $stmt->fetch();
        $imagePath = !empty($productImage) ? 'https://mshtly.com/uploads/products/' . $productImage['main_image'] : null;

        $urls[] = [
            'loc' => 'https://mshtly.com/product/' . $product['slug'],
            'lastmod' => (new DateTime($product['updated_at']))->format('c'),
            'changefreq' => 'always',
            'priority' => 0.5,
            'image' => $imagePath ? [
                'loc' => $imagePath,
                'title' => htmlspecialchars($product['name']),
            ] : null,
        ];
    }

    // جلب الفئات
    $stmt = $connect->prepare("SELECT * FROM categories");
    $stmt->execute();
    $allcategories = $stmt->fetchAll();

    foreach ($allcategories as $category) {
        $urls[] = [
            'loc' => 'https://mshtly.com/product-category/' . $category['slug'],
            'lastmod' => (new DateTime())->format('c'),
            'changefreq' => 'always',
            'priority' => 0.5,
        ];
    }

    // جلب المقالات
    $stmt = $connect->prepare("SELECT * FROM posts");
    $stmt->execute();
    $allarticles = $stmt->fetchAll();

    foreach ($allarticles as $article) {
        $imagePath = !empty($article['image']) ? 'https://mshtly.com/uploads/posts/' . $article['image'] : null;

        $articleData = [
            'loc' => 'https://mshtly.com/blog/' . $article['slug'],
            'lastmod' => (new DateTime($article['updated_at']))->format('c'),
            'changefreq' => 'always',
            'priority' => 0.5,
        ];

        if ($imagePath) {
            $articleData['image'] = [
                'loc' => $imagePath,
                'title' => htmlspecialchars($article['title']),
            ];
        }

        $urls[] = $articleData;
    }

    // إضافة روابط أخرى ثابتة
    $urls = array_merge($urls, [
        [
            'loc' => 'https://mshtly.com',
            'lastmod' => (new DateTime('2024-11-01'))->format('c'),
            'changefreq' => 'daily',
            'priority' => 1.0,
        ],
        [
            'loc' => 'https://mshtly.com/cart',
            'lastmod' => (new DateTime('2024-11-01'))->format('c'),
            'changefreq' => 'daily',
            'priority' => 0.9,
        ],
        [
            'loc' => 'https://mshtly.com/checkout',
            'lastmod' => (new DateTime('2024-11-01'))->format('c'),
            'changefreq' => 'weekly',
            'priority' => 0.8,
        ],
        [
            'loc' => 'https://mshtly.com/shop',
            'lastmod' => (new DateTime('2024-11-01'))->format('c'),
            'changefreq' => 'weekly',
            'priority' => 0.8,
        ],
        [
            'loc' => 'https://mshtly.com/faq',
            'lastmod' => (new DateTime('2024-11-01'))->format('c'),
            'changefreq' => 'monthly',
            'priority' => 0.7,
        ],
        [
            'loc' => 'https://mshtly.com/terms',
            'lastmod' => (new DateTime('2024-11-01'))->format('c'),
            'changefreq' => 'yearly',
            'priority' => 0.5,
        ],
    ]);

    // إنشاء ملف XML
    $xml = new XMLWriter();
    $xml->openUri($sitemapFileName);
    $xml->setIndent(true);
    $xml->startDocument('1.0', 'UTF-8');
    $xml->startElement('urlset');
    $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    $xml->writeAttribute('xmlns:image', 'http://www.google.com/schemas/sitemap-image/1.1');

    foreach ($urls as $url) {
        $xml->startElement('url');
        $xml->writeElement('loc', $url['loc']);
        $xml->writeElement('lastmod', $url['lastmod']);
        $xml->writeElement('changefreq', $url['changefreq']);
        $xml->writeElement('priority', $url['priority']);

        if (isset($url['image'])) {
            $xml->startElement('image:image');
            $xml->writeElement('image:loc', $url['image']['loc']);
            $xml->writeElement('image:title', $url['image']['title']);
            $xml->endElement();
        }

        $xml->endElement();
    }

    $xml->endElement();
    $xml->endDocument();
    $xml->flush();
    echo "تم إنشاء وتحديث ملف sitemap بنجاح!";
} catch (\Exception $e) {
    echo "حدثت مشكلة أثناء إنشاء وتحديث ملف sitemap: " . $e->getMessage();
}
