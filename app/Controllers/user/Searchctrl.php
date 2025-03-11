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
        $keyword = $this->request->getGet('q');
        $new_keyword = $keyword;

        $current_lang_segment = $this->request->uri->getSegment(1);

        $url_prefix = $lang === 'id' ? 'cari' : 'search';

        if ($current_lang_segment !== $lang) {
            return redirect()->to(base_url("{$lang}/{$url_prefix}/{$new_keyword}"));
        }

        $nama_tentang = $this->TentangModel->getNamaTentang();
        $today = date('Y-m-d');

        $artikelResults = $this->ArtikelModel->searchArtikel($keyword, $today);
        $olehOlehResults = $this->OlehOlehModel->searchOlehOleh($keyword);
        $wisataResults = $this->WisataModel->searchTempatWisata($keyword);

        $title = $keyword ? "$keyword - $nama_tentang" : "Hasil Pencarian - $nama_tentang";

        $head = $lang === 'id' ? 'Artikel Wisata' : 'Travel Articles';

        $title = $head . ' : #' . $keyword;

        $data = [
            'kategori' => $this->KategoriModel->getKategori(),
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),

            'artikel' => $artikelResults,
            'oleholeh' => $olehOlehResults,
            'wisata' => $wisataResults,
            'tentang' => $this->TentangModel->getTentangDepan(),
            'title' => $title,
            'lang' => $lang
        ];

        return view('user/search', $data);
    }
}
