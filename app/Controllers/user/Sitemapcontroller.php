<?php

namespace App\Controllers\User;

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

class Sitemapcontroller extends BaseController
{
    public function generate()
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
        $ebookData = $ebookModel->findAll();
        $penulisData = $penulisModel->findAll();
        $kategoriWisataData = $kategoriWisataModel->findAll();
        $kategoriOlehOlehData = $kategoriOlehOlehModel->findAll();
        $tempatWisataData = $tempatWisataModel->getAllWisata();
        $olehOlehData = $olehOlehModel->findAll();

        // Data untuk halaman statis dalam bentuk array URL
        $data = [
            'home_id' => base_url('id'),
            'home_en' => base_url('en'),
            'about_id' => base_url('id/tentang'),
            'about_en' => base_url('en/about'),

            // Static pages
            'wisata_id' => base_url('id/wisata'),
            'wisata_en' => base_url('en/destinations'),
            'souvenirs_id' => base_url('id/oleh-oleh'),
            'souvenirs_en' => base_url('en/souvenirs'),
            'kategori_id' => base_url('kategori/semua-artikel'),
            'kategori_en' => base_url('categories/all-article'),
        ];

        // detail artikel
        foreach ($artikelData as $artikel) {
            $data['articles_id'][] = base_url('id/artikel/detail/' . $artikel->slug);
            $data['articles_en'][] = base_url('en/article/details/' . $artikel->slug_en);
        }

        // detail wisata
        foreach ($tempatWisataData as $tempatWisata) {
            $data['detail_wisata_id'][] = base_url('id/wisata/detail/' . $tempatWisata['slug_wisata_ind']);
            $data['detail_wisata_en'][] = base_url('en/destinations/details/' . $tempatWisata['slug_wisata_eng']);
        }

        // detail oleh-oleh
        foreach ($olehOlehData as $olehOleh) {
            $data['detail_oleh_id'][] = base_url('id/oleh-oleh/detail/' . $olehOleh['slug_oleholeh']);
            $data['detail_oleh_en'][] = base_url('en/souvenirs/details/' . $olehOleh['slug_en']);
        }

        // kategori wisata
        foreach ($kategoriWisataData as $kategoriWisata) {
            $data['kategori_wisata_id'][] = base_url('id/wisata/kategori-wisata/' . $kategoriWisata->slug_kategori_wisata);
            $data['kategori_wisata_en'][] = base_url('en/destinations/destinations-category/' . $kategoriWisata->slug_kategori_wisata_en);
        }

        // kategori oleh-oleh
        foreach ($kategoriOlehOlehData as $kategoriOlehOleh) {
            $data['kategori_oleh_id'][] = base_url('id/oleh-oleh/kategori-oleh-oleh/' . $kategoriOlehOleh->slug_kategori_oleholeh);
            $data['kategori_oleh_en'][] = base_url('en/souvenirs/souvenirs-category/' . $kategoriOlehOleh->slug_kategori_oleholeh_en);
        }

        return view('sitemapp', ['data' => $data]);
    }
}
