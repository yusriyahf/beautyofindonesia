<?php

namespace App\Controllers\user;

use App\Controllers\BaseController;
use App\Models\AktivitasModel;
use App\Models\ProdukModel;
use App\Models\ArtikelModel;
use App\Models\EbookModel;
use App\Models\PenulisModel;
use App\Models\KategoriWisataModel;
use App\Models\KategoriOlehOlehModel;
use App\Models\TempatWisataModel;
use App\Models\OlehOlehModel;

class Sitemapctrl extends BaseController
{
    public function index()
    {
        // Inisialisasi model
        $artikelModel = new ArtikelModel();
        $ebookModel = new EbookModel();
        $penulisModel = new PenulisModel();
        $kategoriWisataModel = new KategoriWisataModel();
        $kategoriOlehOlehModel = new KategoriOlehOlehModel();
        $tempatWisataModel = new TempatWisataModel();
        $olehOlehModel = new OlehOlehModel();

        // Ambil data dari database
        $artikelData = $artikelModel->where('tgl_publish <=', date('Y-m-d'))->findAll();
        $tempatWisataData = $tempatWisataModel->getAllWisata();
        $olehOlehData = $olehOlehModel->findAll();
        $kategoriWisataData = $kategoriWisataModel->findAll();
        $kategoriOlehOlehData = $kategoriOlehOlehModel->findAll();
        $ebookData = $ebookModel->findAll();
        $penulisData = $penulisModel->findAll();

        // Data untuk halaman statis
        $data = [
            'pages' => [
                ['name' => 'Beranda', 'url' => base_url('id')],
                ['name' => 'Home', 'url' => base_url('en')],
                ['name' => 'Tentang Kami', 'url' => base_url('id/tentang')],
                ['name' => 'About Us', 'url' => base_url('en/about')],
                ['name' => 'Wisata', 'url' => base_url('id/wisata')],
                ['name' => 'Destinations', 'url' => base_url('en/destinations')],
                ['name' => 'Oleh-oleh', 'url' => base_url('id/oleh-oleh')],
                ['name' => 'Souvenirs', 'url' => base_url('en/souvenirs')],
                ['name' => 'Kategori Artikel', 'url' => base_url('kategori/semua-artikel')],
                ['name' => 'Categories', 'url' => base_url('categories/all-article')],
            ],
            'articles' => [],
            'wisata' => [],
            'souvenirs' => [],
            'kategori_wisata' => [],
            'kategori_oleh' => []
        ];

        // Tambahkan artikel
        foreach ($artikelData as $artikel) {
            $data['articles'][] = [
                'name' => $artikel->judul_artikel, 
                'url_id' => base_url('id/artikel/detail/' . $artikel->slug),
                'url_en' => base_url('en/article/details/' . $artikel->slug_en)
            ];
        }

        // Tambahkan wisata
        foreach ($tempatWisataData as $tempatWisata) {
            $data['wisata'][] = [
                'name' => $tempatWisata['nama_wisata_ind'],
                'url_id' => base_url('id/wisata/detail/' . $tempatWisata['slug_wisata_ind']),
                'url_en' => base_url('en/destinations/details/' . $tempatWisata['slug_wisata_eng'])
            ];
        }

        // Tambahkan oleh-oleh
        foreach ($olehOlehData as $olehOleh) {
            $data['souvenirs'][] = [
                'name' => $olehOleh['nama_oleholeh'],
                'url_id' => base_url('id/oleh-oleh/detail/' . $olehOleh['slug_oleholeh']),
                'url_en' => base_url('en/souvenirs/details/' . $olehOleh['slug_en'])
            ];
        }

        // Tambahkan kategori wisata
        foreach ($kategoriWisataData as $kategoriWisata) {
            $data['kategori_wisata'][] = [
                'name' => $kategoriWisata->nama_kategori_wisata,
                'url_id' => base_url('id/wisata/kategori-wisata/' . $kategoriWisata->slug_kategori_wisata),
                'url_en' => base_url('en/destinations/destinations-category/' . $kategoriWisata->slug_kategori_wisata_en)
            ];
        }

        // Tambahkan kategori oleh-oleh
        foreach ($kategoriOlehOlehData as $kategoriOlehOleh) {
            $data['kategori_oleh'][] = [
                'name' => $kategoriOlehOleh->nama_kategori_oleholeh,
                'url_id' => base_url('id/oleh-oleh/kategori-oleh-oleh/' . $kategoriOlehOleh->slug_kategori_oleholeh),
                'url_en' => base_url('en/souvenirs/souvenirs-category/' . $kategoriOlehOleh->slug_kategori_oleholeh_en)
            ];
        }

        return view('sitemap', ['data' => $data]);
    }
}
