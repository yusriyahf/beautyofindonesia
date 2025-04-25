<?php

namespace App\Controllers\user;

use App\Controllers\user\BaseController;
use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\TentangModel;
use App\Models\KategoriWisataModel;
use App\Models\KategoriOlehOlehModel;
use App\Models\MetaModel;

class Artikelctrl extends BaseController
{
    private $ArtikelModel;
    private $KategoriModel;
    private $TentangModel;
    private $KategoriWisataModel;
    private $KategoriOlehOlehModel;
    private $MetaModel;
    protected $lang;

    public function __construct()
    {
        $this->ArtikelModel = new ArtikelModel();
        $this->KategoriModel = new KategoriModel();
        $this->TentangModel = new TentangModel();
        $this->KategoriWisataModel = new KategoriWisataModel();
        $this->KategoriOlehOlehModel = new KategoriOlehOlehModel();
        $this->MetaModel = new MetaModel();
        $this->lang = session()->get('lang') ?? 'id';
    }

    public function index($slug_kategori)
    {
        $lang = session()->get('lang') ?? 'en';


        $kategoriModel = new KategoriModel();
        $artikelModel = new ArtikelModel();

        $kategori = $kategoriModel->where('slug_kategori', $slug_kategori)
            ->orWhere('slug_kategori_en', $slug_kategori)
            ->first();

        $slug_kategori_url = $this->request->uri->getSegment(3);

        // Prefix URL berdasarkan bahasa
        $url_prefix = $lang === 'id' ? 'artikel' : 'article';

        // Validasi slug kategori
        $correct_slug_id = $kategori->slug_kategori ?? null;
        $correct_slug_en = $kategori->slug_kategori_en ?? null;

        $canonical = base_url("$lang/" . ($lang === 'id' ? 'artikel' : 'article') . '/' . $slug_kategori);

        if (current_url() !== $canonical) {
            return redirect()->to($canonical);
        }

        if ($lang === 'id' && $slug_kategori_url !== $correct_slug_id) {
            return redirect()->to(base_url("{$lang}/{$url_prefix}/{$correct_slug_id}"));
        } elseif ($lang === 'en' && $slug_kategori_url !== $correct_slug_en) {
            return redirect()->to(base_url("{$lang}/{$url_prefix}/{$correct_slug_en}"));
        }

        // Pagination
        $limit = 9; // Jumlah artikel per halaman
        $artikelQuery = $artikelModel->select('tb_artikel.*, 
                                           tb_kategori.nama_kategori, 
                                           tb_kategori.nama_kategori_en, 
                                           tb_kategori.slug_kategori, 
                                           tb_kategori.slug_kategori_en')
            ->join('tb_kategori', 'tb_artikel.id_kategori = tb_kategori.id_kategori')
            ->where('tb_artikel.id_kategori', $kategori->id_kategori)
            ->where('tb_artikel.tgl_publish <=', date('Y-m-d'))
            ->orderBy('tb_artikel.tgl_publish', 'DESC'); // Urutkan berdasarkan tgl_publish terbaru

        // Ambil artikel dengan paginate
        $articles = $artikelQuery->paginate($limit, 'artikel');
        $pager = $artikelModel->pager;

        $title = $lang == 'id' ? $kategori->meta_title_id : $kategori->meta_title_en;
        $title = explode(' - ', $title)[0];

        $meta = $kategori ? (object)[
            'meta_title_id' => $kategori->meta_title_id ?? '',
            'meta_title_en' => $kategori->meta_title_en ?? '',
            'meta_description_id' => $kategori->meta_description_id ?? '',
            'meta_description_en' => $kategori->meta_description_en ?? ''
        ] : null;

        $image = base_url('assets-baru/img/error_logo.webp');

        $metaOG = [
            'title'       => $lang == 'id' ? $kategori->meta_title_id : $kategori->meta_title_en,
            'description' => $lang == 'id' ? $kategori->meta_description_id : $kategori->meta_description_en,
            'image'       => $image,
            'url'         => $canonical,
            'type'        => 'article',
        ];

        $data = [
            'canonical' => $canonical,
            'artikel' => $articles,
            'pager' => $pager,
            'kategori' => $this->KategoriModel->getKategori(),
            'judul_kategori' => $kategori,
            'tentang' => $this->TentangModel->getTentangDepan(),
            'title' => $title,
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'lang' => $lang,
            'meta' => $meta,
            'metaOG' => $metaOG
        ];

        return view('user/kategori/index', $data);
    }



    public function semuaArtikel()
    {

        $lang = session()->get('lang') ?? 'en';
        $meta = $this->MetaModel->where('nama_halaman', 'Artikel')->first();

        $canonical = base_url("$lang/" . ($lang === 'id' ? 'artikel' : 'article'));


        // Redirect to the correct URL if the current URL doesn't match the expected pattern
        // if ($lang === 'id' && $url_kategori !== $url_prefix2) {
        //     // Redirect to the correct slug in Indonesian
        //     return redirect()->to(base_url("{$lang}/{$url_prefix}/{$url_prefix2}"));
        // } elseif ($lang === 'en' && $url_kategori !== $url_prefix2) {
        //     // Redirect to the correct slug in English
        //     return redirect()->to(base_url("{$lang}/{$url_prefix}/{$url_prefix2}"));
        // }


        $title = $lang == 'id' ? $meta->meta_title_id : $meta->meta_title_en;
        $title = explode(' - ', $title)[0];

        // Inisialisasi query wisata
        $artikelQuery = $this->ArtikelModel;
        $limit = 9;

        $image = base_url('assets-baru/img/error_logo.webp');

        $metaOG = [
            'title'       => $lang == 'id' ? $meta->meta_title_id : $meta->meta_title_en,
            'description' => $lang == 'id' ? $meta->meta_description_id : $meta->meta_description_en,
            'image'       => $image,
            'url'         => $canonical,
            'type'        => 'article',
        ];

        // Ambil semua artikel sebagai array
        $data = [
            'artikel' => $artikelQuery->getAllArtikelWithKategori($limit),
            'pager' => $artikelQuery->pager, // Pass pager object
            'kategori' => $this->KategoriModel->getKategori(),
            'judul_kategori' => 'Semua Artikel',
            'tentang' => $this->TentangModel->getTentangDepan(),
            'title' => $title,
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'lang' => $lang,
            'meta' => $meta,
            'metaOG' => $metaOG,
        ];

        return view('user/kategori/semua_artikel', $data);
    }

    public function searchByTag()
    {
        $tag = $this->request->getGet('q'); // Get the tag from the query parameter


        if ($tag) {
            $lang = session()->get('lang') ?? 'en';

            $nama_tentang = $this->TentangModel->getNamaTentang();
            $title = "Search Results for #$tag - $nama_tentang";

            $data = [
                'artikel' => $this->ArtikelModel->getArtikelByTag($tag),
                'kategori' => $this->KategoriModel->getKategori(),
                'judul_kategori' => "Tag: #$tag",
                'tentang' => $this->TentangModel->getTentangDepan(),
                'title' => $title,
                'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
                'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
                'lang' => $lang,
                'meta' => $this->MetaModel->where('nama_halaman', 'Artikel')->first(),
            ];

            return view('user/kategori/tags', $data);
        } else {
            // Redirect or show an error message if no tag is provided
            return redirect()->to('/artikel');
        }
    }
}
