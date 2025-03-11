<?php

namespace App\Controllers\user;

use App\Controllers\user\BaseController;
use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\PenulisModel;
use App\Models\TentangModel;
use App\Models\TempatWisataModel;
use App\Models\OlehOlehModel;
use App\Models\KategoriWisataModel;
use App\Models\KategoriOlehOlehModel;
use App\Models\MetaModel;
use App\Models\ProvinsiModel;
use App\Models\KabupatenModel;

class Homectrl extends BaseController
{
    private $ArtikelModel;
    private $KategoriModel;
    private $PenulisModel;
    private $TentangModel;
    private $TempatWisataModel;
    private $OlehOlehModel;
    private $KategoriWisataModel;
    private $KategoriOlehOlehModel;
    private $ProvinsiModel;
    private $KabupatenModel;
    private $MetaModel;

    public function __construct()
    {
        $this->ArtikelModel = new ArtikelModel();
        $this->ProvinsiModel = new ProvinsiModel();
        $this->KabupatenModel = new KabupatenModel();
        $this->KategoriModel = new KategoriModel();
        $this->PenulisModel = new PenulisModel();
        $this->TentangModel = new TentangModel();
        $this->TempatWisataModel = new TempatWisataModel();
        $this->OlehOlehModel = new OlehOlehModel();
        $this->KategoriWisataModel = new KategoriWisataModel();
        $this->KategoriOlehOlehModel = new KategoriOlehOlehModel();
        $this->MetaModel = new MetaModel();
    }

    public function index()
    {
        $lang = session()->get('lang') ?? 'en';

        $meta = $this->MetaModel->where('nama_halaman', 'Beranda')->first();

        $canonical = base_url("$lang/");

        $nama_beranda = 'Beranda';
        $nama_tentang = $this->TentangModel->getNamaTentang();
        $title = "$nama_beranda - $nama_tentang";

        // Ambil data tempat wisata
        $tempatWisata = $this->TempatWisataModel->getAllWisataMaps();

        // Hapus kolom tertentu untuk menyembunyikan
        foreach ($tempatWisata as &$wisata) {
            unset($wisata['deskripsi_wisata_ind']);
            unset($wisata['deskripsi_wisata_eng']);
            unset($wisata['id_penulis']);
            unset($wisata['views']);
            unset($wisata['sumber_foto']);
            unset($wisata['meta_title_id']);
            unset($wisata['meta_title_en']);
            unset($wisata['meta_deskription_id']);
            unset($wisata['meta_description_en']);
            unset($wisata['nama_kategori_wisata']);
            unset($wisata['nama_kategori_wisata_en']);
            unset($wisata['id_kategori_wisata']);
            unset($wisata['nama_penulis']);
            unset($wisata['id_kotakabupaten']);
        }

        // Ambil data tempat wisata
        $olehOleh = $this->OlehOlehModel->getAllOlehOleh();

        // Hapus kolom tertentu untuk menyembunyikan
        foreach ($olehOleh as &$oleh) {
            unset($oleh['id_kategori_oleholeh']);
        }

        $image = base_url('assets-baru/img/error_logo.webp');

        $metaOG = [
            'title'       => $lang == 'id' ? $meta->meta_title_id : $meta->meta_title_en,
            'description' => $lang == 'id' ? $meta->meta_description_id : $meta->meta_description_en,
            'image'       => $image,
            'url'         => $canonical,
            'type'        => 'article',
        ];

        $data = [
            'artikel' => $this->ArtikelModel->getArtikelRandom(),
            'provinsi' => $this->ProvinsiModel->getProvinsi($lang),
            'kabupaten' => $this->KabupatenModel->getKabupaten($lang),
            'artikelpopular' => $this->ArtikelModel->getPopularArtikel(),
            'artikelterpopular' => $this->ArtikelModel->getTerpopularArtikel(),
            'artikelterbaru' => $this->ArtikelModel->getArtikelTerbaru(),
            'kategori' => $this->KategoriModel->getKategori(),
            'penulis' => $this->PenulisModel->getRandomPenulis(),
            'tentang' => $this->TentangModel->getTentangDepan(),
            'title' => $title,

            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'randomWisata' => $this->TempatWisataModel->getRandomWisata(),
            'randomOlehOleh' => $this->OlehOlehModel->getTopOlehOleh(),
            'lang' => $lang,
            'meta' => $meta,
            'canonical' => $canonical,
            'metaOG' => $metaOG,
        ];

        return view('user/home/index', $data);
    }





    public function viewArtikel($slug, $slug_artikel)
    {
        // dd($slug);

        $lang = session()->get('lang') ?? 'id';
        $canonical = base_url("$lang/" . ($lang === 'id' ? 'artikel' : 'article') . '/' . $slug . '/' . $slug_artikel);
        // $canonical = base_url("$lang/" . ($lang === 'id' ? 'artikel' : 'article') . '/' . ($lang === 'id' ? 'anjai' : 'travel-tips') . '/' . $slug_artikel);

        if (current_url() !== $canonical) {
            return redirect()->to($canonical);
        }
        //   
        $meta = $this->MetaModel->where('nama_halaman', 'Artikel')->first();

        // Fetch article details using the slug and language
        $detail_artikel = $this->ArtikelModel->getDetailArtikelBySlug($slug_artikel);

        $artikel_detail = $this->ArtikelModel->getAllArtikelWithKategori2($slug_artikel);

        // var_dump($slug_artikel);
        // die();

        // Periksa apakah artikel ditemukan
        if (!$artikel_detail) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Artikel tidak ditemukan");
        }

        // Tentukan prefix berdasarkan bahasa (artikel untuk 'id' dan article untuk 'en')
        $url_prefix = $lang === 'id' ? 'artikel' : 'article';

        // Dapatkan slug kategori berdasarkan bahasa
        $correct_kategori_slug_id = $artikel_detail->slug_kategori;
        $correct_kategori_slug_en = $artikel_detail->slug_kategori_en;

        // Dapatkan slug artikel_detail->erdasarkanahasa
        $correct_slug_id = $artikel_detail->slug;
        $correct_slug_en = $artikel_detail->slug_en;

        // Jika slug tidak sesuai dengan slug dalam bahasa saat ini, redirect ke slug yang benar dengan kategori
        if ($lang === 'id' && $slug !== $correct_kategori_slug_id && $slug_artikel !== $correct_slug_id) {
            return redirect()->to(base_url("{$lang}/{$url_prefix}/{$correct_kategori_slug_id}/{$correct_slug_id}"));
        } elseif ($lang === 'en' && $slug_artikel !== $correct_slug_en) {
            return redirect()->to(base_url("{$lang}/{$url_prefix}/{$correct_kategori_slug_en}/{$correct_slug_en}"));
        }

        // Lanjutkan ke logika lainnya jika slug sudah benar


        // Increment views for the article using the slug
        $this->ArtikelModel->incrementViewsBySlug($slug);

        // Extract the article title and additional information
        $judul_artikel = $detail_artikel['judul_artikel'] ?? 'Judul Artikel Tidak Ditemukan';
        $nama_tentang = $this->TentangModel->getNamaTentang(); // Assuming TentangModel is loaded

        $title = "$judul_artikel - $nama_tentang";

        // Get the article photo or a default image
        $foto_artikel = $detail_artikel['foto_artikel'] ?? 'default.jpg';

        $image = base_url('assets-baru/img/error_logo.webp');

        $metaOG = [
            'title' => $lang == 'id' ? $detail_artikel['meta_title_id'] : $detail_artikel['meta_title_en'],
            'description' => $lang == 'id' ? $detail_artikel['meta_description_id'] : $detail_artikel['meta_description_en'],
            'image'       => $image,
            'url'         => $canonical,
            'type'        => 'article',
        ];

        // Prepare the data to be passed to the view
        $data = [
            'artikel' => $detail_artikel,
            'artikel_lain' => $this->ArtikelModel->getArtikelLainnyaBySlug($slug, 4), // Fetch related articles
            'kategori' => $this->KategoriModel->getKategori(),
            'tentang' => $this->TentangModel->getTentangDepan(),
            'tempatWisata' => $this->TempatWisataModel->getAllWisata(),
            'olehOleh' => $this->OlehOlehModel->getAllOlehOleh(),
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'title' => $title, // Set the page title
            'foto_artikel' => $foto_artikel, // Set the article photo
            'meta' => $meta,
            'lang' => $lang,
            'canonical' => $canonical,
            'metaOG' => $metaOG,
        ];

        return view('user/home/detail', $data);
    }




    public function redirectToHome()
    {
        return redirect()->to('/');
    }

    public function language($locale)
    {
        $session = session();

        // Validasi bahasa yang diterima
        if ($locale === 'id' || $locale === 'en') {
            // Mengatur sesi bahasa ke bahasa yang dipilih
            $session->set('lang', $locale);
        }

        // Redirect kembali ke halaman sebelumnya
        return redirect()->back();
    }


    public function loadAjaxData()
    {
        $lang = session()->get('lang') ?? 'en';

        $meta = $this->MetaModel->where('nama_halaman', 'Beranda')->first();

        $nama_beranda = 'Beranda';
        $nama_tentang = $this->TentangModel->getNamaTentang();
        $title = "$nama_beranda - $nama_tentang";

        // Ambil data tempat wisata
        $tempatWisata = $this->TempatWisataModel->getAllWisataMaps();

        // Hapus kolom tertentu untuk menyembunyikan
        foreach ($tempatWisata as &$wisata) {
            unset($wisata['deskripsi_wisata_ind']);
            unset($wisata['deskripsi_wisata_eng']);
            unset($wisata['id_penulis']);
            unset($wisata['views']);
            unset($wisata['sumber_foto']);
            unset($wisata['meta_title_id']);
            unset($wisata['meta_title_en']);
            unset($wisata['meta_deskription_id']);
            unset($wisata['meta_description_en']);
            unset($wisata['nama_kategori_wisata']);
            unset($wisata['nama_kategori_wisata_en']);
            unset($wisata['id_kategori_wisata']);
            unset($wisata['nama_penulis']);
            unset($wisata['id_kotakabupaten']);
        }

        // Ambil data tempat wisata
        $olehOleh = $this->OlehOlehModel->getAllOlehOleh();

        // Hapus kolom tertentu untuk menyembunyikan
        foreach ($olehOleh as &$oleh) {
            unset($oleh['id_kategori_oleholeh']);
        }

        $data = [

            'provinsi' => $this->ProvinsiModel->getProvinsi($lang),
            'kabupaten' => $this->KabupatenModel->getKabupaten($lang),

            'title' => $title,
            'tempatWisata' => $tempatWisata,  // Data wisata sudah disaring
            'olehOleh' => $this->OlehOlehModel->getAllOlehOleh(),

            'lang' => $lang,
            'meta' => $meta
        ];

        // Memuat view ajax_content dengan data yang diteruskan
        return view('user/home/ajax_content', $data);
    }

    public function notFound()
    {
        return redirect()->to('/')->setStatusCode(301);
    }
}
