<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Artikel;
use App\Models\ArtikelModel;
use App\Models\Kabupaten;
use App\Models\KabupatenModel;
use App\Models\KategoriArtikel;
use App\Models\KategoriModel;
use App\Models\KategoriOlehOleh;
use App\Models\KategoriOlehOlehModel;
use App\Models\OlehOleh;
use App\Models\OlehOlehModel;
use App\Models\Provinsi;
use App\Models\ProvinsiModel;
use App\Models\TempatWisataModel;
use App\Models\Wisata;
use CodeIgniter\HTTP\ResponseInterface;

class Sitemap extends BaseController
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = base_url();
    }

    public function index()
    {
        header("Content-Type: application/xml; charset=UTF-8");

        // Inisialisasi model
        $wisataModel = new TempatWisataModel();
        $provinsiModel = new ProvinsiModel();
        $kabupatenModel = new KabupatenModel();
        $olehOlehModel = new OlehOlehModel();
        $kategoriOlehOlehModel = new KategoriOlehOlehModel();
        $artikelModel = new ArtikelModel();
        $kategoriArtikelModel = new KategoriModel();

        $kategoriArtikelList = $kategoriArtikelModel->select('id_kategori, slug_kategori,slug_kategori_en')->findAll() ?? [];
        $artikelList = $artikelModel->where('tgl_publish <=', date('Y-m-d'))
            ->select('id_kategori, slug, slug_en')
            ->findAll() ?? [];



        $wisataList = $wisataModel->select('slug_wisata_ind , slug_wisata_eng')->findAll() ?? [];
        $provinsiList = $provinsiModel->select('id_provinsi,slug_provinsi_ind , slug_provinsi_eng')->findAll() ?? [];
        $kabupatenList = $kabupatenModel->select('id_kotakabupaten, slug_kotakabupaten_ind, slug_kotakabupaten_eng, id_provinsi')->findAll() ?? [];
        $kategoriOlehOlehList = $kategoriOlehOlehModel->select('id_kategori_oleholeh, slug_kategori_oleholeh, slug_kategori_oleholeh_en')->findAll() ?? [];

        $olehOlehList = $olehOlehModel->select('slug_oleholeh, id_kategori_oleholeh, slug_en')->findAll() ?? [];

        $xml = new \SimpleXMLElement('<urlset/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');


        $this->addUrl($xml, "{$this->baseUrl}id", '1.0');
        $this->addUrl($xml, "{$this->baseUrl}id/tentang", '0.8');
        $this->addUrl($xml, "{$this->baseUrl}id/wisata", '0.7');
        $this->addUrl($xml, "{$this->baseUrl}id/wisata/wisata-alam", '0.7');

        foreach ($wisataList as $wisata) {
            $this->addUrl($xml, "{$this->baseUrl}id/wisata/wisata-alam/{$wisata['slug_wisata_ind']}", '0.6');
        }

        foreach ($provinsiList as $provinsi) {
            $this->addUrl($xml, "{$this->baseUrl}id/wisata/wisata-alam?provinsiSlug={$provinsi['slug_provinsi_ind']}", '0.6');
        }

        foreach ($provinsiList as $provinsi) {
            foreach ($kabupatenList as $kabupaten) {
                if ($kabupaten['id_provinsi'] == $provinsi['id_provinsi']) {
                    $this->addUrl($xml, "{$this->baseUrl}id/wisata?provinsiSlug={$provinsi['slug_provinsi_ind']}&kabupatenSlug={$kabupaten['slug_kotakabupaten_ind']}", '0.6');
                }
            }
        }

        foreach ($provinsiList as $provinsi) {
            foreach ($kabupatenList as $kabupaten) {
                if ($kabupaten['id_provinsi'] == $provinsi['id_provinsi']) {
                    $this->addUrl($xml, "{$this->baseUrl}id/wisata/wisata-alam?provinsiSlug={$provinsi['slug_provinsi_ind']}&kabupatenSlug={$kabupaten['slug_kotakabupaten_ind']}", '0.6');
                }
            }
        }

        foreach ($kategoriArtikelList as $kategori) {
            $this->addUrl($xml, "{$this->baseUrl}id/artikel/{$kategori['slug_kategori']}", '0.7');
        }

        foreach ($artikelList as $artikel) {
            foreach ($kategoriArtikelList as $kategori) {
                if ($kategori['id_kategori'] == $artikel['id_kategori']) {
                    $slugKategori = $kategori['slug_kategori'];
                    break;
                }
            }
            $this->addUrl($xml, "{$this->baseUrl}id/artikel/{$slugKategori}/{$artikel['slug']}", '0.6');
        }

        foreach ($kategoriOlehOlehList as $kategori) {
            $this->addUrl($xml, "{$this->baseUrl}id/oleh-oleh/{$kategori['slug_kategori_oleholeh']}", '0.7');
        }

        foreach ($olehOlehList as $olehOleh) {
            foreach ($kategoriOlehOlehList as $kategori) {
                if ($kategori['id_kategori_oleholeh'] == $olehOleh['id_kategori_oleholeh']) {
                    $slugKategori = $kategori['slug_kategori_oleholeh'];
                    break;
                }
            }

            $this->addUrl($xml, "{$this->baseUrl}id/oleh-oleh/{$slugKategori}/{$olehOleh['slug_oleholeh']}", '0.6');
            foreach ($provinsiList as $provinsi) {
                foreach ($kabupatenList as $kabupaten) {
                    if ($kabupaten['id_provinsi'] == $provinsi['id_provinsi']) {
                        $this->addUrl($xml, "{$this->baseUrl}id/oleh-oleh/{$slugKategori}?provinsiSlug={$provinsi['slug_provinsi_ind']}&kabupatenSlug={$kabupaten['slug_kotakabupaten_ind']}", '0.6');
                    }
                }
            }
        }


        // english version
        $this->addUrl($xml, "{$this->baseUrl}en", '1.0');
        $this->addUrl($xml, "{$this->baseUrl}en/about", '0.8');
        $this->addUrl($xml, "{$this->baseUrl}en/destinations", '0.7');
        $this->addUrl($xml, "{$this->baseUrl}en/destinations/nature-tourism", '0.7');

        foreach ($wisataList as $wisata) {
            $this->addUrl($xml, "{$this->baseUrl}en/destinations/nature-tourism/{$wisata['slug_wisata_eng']}", '0.6');
        }

        foreach ($provinsiList as $provinsi) {
            $this->addUrl($xml, "{$this->baseUrl}en/destinations?provinsiSlug={$provinsi['slug_provinsi_eng']}", '0.6');
        }

        foreach ($provinsiList as $provinsi) {
            foreach ($kabupatenList as $kabupaten) {
                if ($kabupaten['id_provinsi'] == $provinsi['id_provinsi']) {
                    $this->addUrl($xml, "{$this->baseUrl}en/destinations?provinsiSlug={$provinsi['slug_provinsi_eng']}&kabupatenSlug={$kabupaten['slug_kotakabupaten_eng']}", '0.6');
                }
            }
        }

        foreach ($provinsiList as $provinsi) {
            foreach ($kabupatenList as $kabupaten) {
                if ($kabupaten['id_provinsi'] == $provinsi['id_provinsi']) {
                    $this->addUrl($xml, "{$this->baseUrl}en/destinations/nature-tourism?provinsiSlug={$provinsi['slug_provinsi_eng']}&kabupatenSlug={$kabupaten['slug_kotakabupaten_eng']}", '0.6');
                }
            }
        }

        foreach ($kategoriArtikelList as $kategori) {
            $this->addUrl($xml, "{$this->baseUrl}en/{$kategori['slug_kategori_en']}", '0.7');
        }

        foreach ($artikelList as $artikel) {
            foreach ($kategoriArtikelList as $kategori) {
                if ($kategori['id_kategori'] == $artikel['id_kategori']) {
                    $slugKategori = $kategori['slug_kategori_en'];
                    break;
                }
            }
            $this->addUrl($xml, "{$this->baseUrl}en/article/{$slugKategori}/{$artikel['slug_en']}", '0.6');
        }

        foreach ($kategoriOlehOlehList as $kategori) {
            $this->addUrl($xml, "{$this->baseUrl}en/souvenirs/{$kategori['slug_kategori_oleholeh_en']}", '0.7');
        }

        foreach ($olehOlehList as $olehOleh) {
            foreach ($kategoriOlehOlehList as $kategori) {
                if ($kategori['id_kategori_oleholeh'] == $olehOleh['id_kategori_oleholeh']) {
                    $slugKategori = $kategori['slug_kategori_oleholeh_en'];
                    break;
                }
            }

            $this->addUrl($xml, "{$this->baseUrl}en/souvenirs/{$slugKategori}/{$olehOleh['slug_en']}", '0.6');
            foreach ($provinsiList as $provinsi) {
                foreach ($kabupatenList as $kabupaten) {
                    if ($kabupaten['id_provinsi'] == $provinsi['id_provinsi']) {
                        $this->addUrl($xml, "{$this->baseUrl}en/souvenirs/{$slugKategori}?provinsiSlug={$provinsi['slug_provinsi_eng']}&kabupatenSlug={$kabupaten['slug_kotakabupaten_eng']}", '0.6');
                    }
                }
            }
        }



        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());

        $xslt = $dom->createProcessingInstruction(
            'xml-stylesheet',
            'type="text/xsl" href="http://localhost:8080/sitemap.xsl"'
        );
        $dom->insertBefore($xslt, $dom->documentElement);

        echo $dom->saveXML();
    }

    private function addUrl($xml, $loc, $priority = '0.5')
    {
        $url = $xml->addChild('url');
        $url->addChild('loc', htmlspecialchars($loc, ENT_QUOTES, 'UTF-8'));
        $url->addChild('lastmod', date('Y-m-d'));
        $url->addChild('changefreq', 'weekly');
        $url->addChild('priority', $priority);
    }
}
