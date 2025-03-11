<?php
// Set header untuk XML
header('Content-Type: application/xml; charset=utf-8');

// Fungsi untuk mendapatkan waktu saat ini dalam format ISO 8601
function getCurrentTimestamp() {
    return gmdate('Y-m-d\TH:i:s+00:00');
}

// Buat dokumen XML
$dom = new DOMDocument('1.0', 'UTF-8');
$dom->formatOutput = true;

// Elemen root
$urlset = $dom->createElement('urlset');
$urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
$dom->appendChild($urlset);

// Tambahkan URL statis
$staticUrls = [
    ['loc' => $data['home_id'], 'priority' => '1.00'],
    ['loc' => $data['home_en'], 'priority' => '1.00'],
    ['loc' => $data['about_id'], 'priority' => '0.80'],
    ['loc' => $data['about_en'], 'priority' => '0.80'],
    ['loc' => $data['wisata_id'], 'priority' => '0.80'],
    ['loc' => $data['wisata_en'], 'priority' => '0.80'],
    ['loc' => $data['souvenirs_id'], 'priority' => '0.80'],
    ['loc' => $data['souvenirs_en'], 'priority' => '0.80'],
    ['loc' => $data['kategori_id'], 'priority' => '0.70'],
    ['loc' => $data['kategori_en'], 'priority' => '0.70'],
];

foreach ($staticUrls as $url) {
    $urlElement = $dom->createElement('url');
    $urlset->appendChild($urlElement);

    $loc = $dom->createElement('loc', $url['loc']);
    $urlElement->appendChild($loc);

    $lastmod = $dom->createElement('lastmod', getCurrentTimestamp());
    $urlElement->appendChild($lastmod);

    $priority = $dom->createElement('priority', $url['priority']);
    $urlElement->appendChild($priority);
}

// Tambahkan URL dinamis (contoh: articles_id)
$dynamicUrls = [
    'articles_id' => ['data' => $data['articles_id'], 'priority' => '0.70'],
    'articles_en' => ['data' => $data['articles_en'], 'priority' => '0.70'],
    'detail_wisata_id' => ['data' => $data['detail_wisata_id'], 'priority' => '0.80'],
    'detail_wisata_en' => ['data' => $data['detail_wisata_en'], 'priority' => '0.80'],
    'detail_oleh_id' => ['data' => $data['detail_oleh_id'], 'priority' => '0.80'],
    'detail_oleh_en' => ['data' => $data['detail_oleh_en'], 'priority' => '0.80'],
    'kategori_wisata_id' => ['data' => $data['kategori_wisata_id'], 'priority' => '0.70'],
    'kategori_wisata_en' => ['data' => $data['kategori_wisata_en'], 'priority' => '0.70'],
];

foreach ($dynamicUrls as $key => $value) {
    if (!empty($value['data'])) {
        foreach ($value['data'] as $url) {
            $urlElement = $dom->createElement('url');
            $urlset->appendChild($urlElement);

            $loc = $dom->createElement('loc', $url);
            $urlElement->appendChild($loc);

            $lastmod = $dom->createElement('lastmod', getCurrentTimestamp());
            $urlElement->appendChild($lastmod);

            $priority = $dom->createElement('priority', $value['priority']);
            $urlElement->appendChild($priority);
        }
    }
}

// Outputkan XML
echo $dom->saveXML();
die;

?>