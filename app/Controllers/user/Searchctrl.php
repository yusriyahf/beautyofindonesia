<?php

namespace App\Controllers\user;

use App\Controllers\user\BaseController;
use App\Models\KategoriModel;
use App\Models\ArtikelModel;
use App\Models\TentangModel;
use App\Models\KategoriWisataModel;
use App\Models\KategoriOlehOlehModel;
use App\Models\OlehOlehModel;
use App\Models\TempatWisataModel;

class SearchCtrl extends BaseController
{
    private $KategoriModel;
    private $ArtikelModel;
    private $WisataModel;
    private $OlehOlehModel;
    private $TentangModel;
    private $KategoriWisataModel;
    private $KategoriOlehOlehModel;

    public function __construct()
    {
        $this->KategoriModel = new KategoriModel();
        $this->ArtikelModel = new ArtikelModel();
        $this->WisataModel = new TempatWisataModel();
        $this->OlehOlehModel = new OlehOlehModel();
        $this->TentangModel = new TentangModel();
        $this->KategoriWisataModel = new KategoriWisataModel();
        $this->KategoriOlehOlehModel = new KategoriOlehOlehModel();
    }

    public function search()
    {
        $lang = session()->get('lang') ?? 'en';
        $keyword = $this->request->getGet('q'); // Ambil query parameter

        // Buat canonical URL dengan query string jika ada
        $canonical = base_url("$lang/" . ($lang === 'id' ? 'cari' : 'search'));
        if (!empty($keyword)) {
            $canonical .= "?q=" . urlencode($keyword);
        }

        // Pastikan current_url() mempertimbangkan query string
        $currentFullUrl = current_url();
        if (!empty($_SERVER['QUERY_STRING'])) {
            $currentFullUrl .= '?' . $_SERVER['QUERY_STRING'];
        }

        // Cegah infinite redirect loop
        if ($currentFullUrl !== $canonical) {
            return redirect()->to($canonical);
        }

        $nama_tentang = $this->TentangModel->getNamaTentang();
        $today = date('Y-m-d');

        $artikelResults = $this->ArtikelModel->searchArtikel($keyword, $today);
        $olehOlehResults = $this->OlehOlehModel->searchOlehOleh($keyword);
        $wisataResults = $this->WisataModel->searchTempatWisata($keyword);

        dd($wisataResults);

        $head = $lang === 'id' ? 'Hasil Pencarian Dengan Kata Kunci' : 'Search Results with Keyword';
        $title = $head . ' "' . $keyword . '"';
        $OGtitle = $head . ' ' . $keyword;

        $headWisata = $lang === 'id' ? 'Hasil Pencarian Wisata Dengan Kata Kunci' : 'Search Results with Keyword';
        $titleWisata = $headWisata . ' "' . $keyword . '"';

        $headOlehOleh = $lang === 'id' ? 'Hasil Pencarian Oleh Oleh Dengan Kata Kunci' : 'Search Results with Keyword';
        $titleOlehOleh = $headOlehOleh . ' "' . $keyword . '"';

        $headArtikel = $lang === 'id' ? 'Hasil Pencarian Artikel Dengan Kata Kunci' : 'Search Results with Keyword';
        $titleArtikel = $headArtikel . ' "' . $keyword . '"';



        $image = base_url('assets-baru/img/error_logo.webp');

        $metaOG = [
            'title'       => $OGtitle,
            'description' => $OGtitle,
            'image'       => $image,
            'url'         => $canonical,
            'type'        => 'article',
        ];

        $meta = (object) [
            'meta_title_id' => $title ?? '',
            'meta_title_en' => $title ?? '',
            'meta_description_id' =>  $title ?? '',
            'meta_description_en' =>  $title ?? ''
        ];

        $data = [
            'kategori' => $this->KategoriModel->getKategori(),
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'artikel' => $artikelResults,
            'oleholeh' => $olehOlehResults,
            'wisata' => $wisataResults,
            'tentang' => $this->TentangModel->getTentangDepan(),
            'title' => $title,
            'lang' => $lang,
            'canonical' => $canonical,
            'metaOG' => $metaOG,
            'meta' => $meta,
            'titleWisata' => $titleWisata,
            'titleOlehOleh' => $titleOlehOleh,
            'titleArtikel' => $titleArtikel,
        ];

        return view('user/search', $data);
    }


    public function searchByTag()
    {
        $lang = session()->get('lang') ?? 'en';
        $keyword = $this->request->getGet('q');
        $new_keyword = $keyword;

        // $current_lang_segment = $this->request->uri->getSegment(1);

        // // Tentukan prefix berdasarkan bahasa (artikel untuk 'id' dan article untuk 'en')
        // $url_prefix = $lang === 'id' ? 'tag' : 'tag';

        // if ($current_lang_segment !== $lang) {
        //     // Use urlencode for keyword to ensure it's passed correctly in the URL
        //     return redirect()->to(base_url("{$lang}/{$url_prefix}/{$new_keyword}"));
        // }

        $canonical = base_url("$lang/" . ($lang === 'id' ? 'tag' : 'tag'));
        if (!empty($keyword)) {
            $canonical .= "?q=" . urlencode($keyword);
        }

        // Pastikan current_url() mempertimbangkan query string
        $currentFullUrl = current_url();
        if (!empty($_SERVER['QUERY_STRING'])) {
            $currentFullUrl .= '?' . $_SERVER['QUERY_STRING'];
        }

        // Cegah infinite redirect loop
        if ($currentFullUrl !== $canonical) {
            return redirect()->to($canonical);
        }

        $nama_tentang = $this->TentangModel->getNamaTentang(); // Fetches `nama_tentang`


        $today = date('Y-m-d');

        $artikelResults = $this->ArtikelModel->searchArtikel($keyword, $today);



        $head = $lang === 'id' ? 'Hasil Pencarian Artikel Dengan Kata Kunci' : 'Search Results for Articles with Keyword';

        $title = $head . ' #' . $keyword;

        $image = base_url('assets-baru/img/error_logo.webp');

        $metaOG = [
            'title'       => $title,
            'description' => $title,
            'image'       => $image,
            'url'         => $canonical,
            'type'        => 'article',
        ];

        $meta = (object) [
            'meta_title_id' => $title ?? '',
            'meta_title_en' => $title ?? '',
            'meta_description_id' =>  $title ?? '',
            'meta_description_en' =>  $title ?? ''
        ];
        // Data passed to the view
        $data = [
            'kategori' => $this->KategoriModel->getKategori(),
            'artikel' => $artikelResults,
            'tentang' => $this->TentangModel->getTentangDepan(),
            'title' => $title,
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'lang' => $lang,
            'meta' => $meta,
            'canonical' => $canonical,
            'metaOG' => $metaOG,
            'tentang' => $this->TentangModel->getTentangDepan(),
        ];

        return view('user/tag', $data);
    }
}
