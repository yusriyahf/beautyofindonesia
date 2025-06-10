<?php

namespace App\Controllers\User;

use App\Controllers\User\BaseController;
use App\Models\KategoriModel;
use App\Models\TentangModel;
use App\Models\KategoriWisataModel;
use App\Models\KategoriOlehOlehModel;
use App\Models\MetaModel;
use App\Models\TempatWisataModel;
use App\Models\OlehOlehModel;

class Tentangctrl extends BaseController
{
    private $KategoriModel;
    private $TentangModel;
    private $KategoriWisataModel;
    private $KategoriOlehOlehModel;
    private $TempatWisataModel;
    private $OlehOlehModel;
    private $MetaModel;

    public function __construct()
    {
        $this->KategoriModel = new KategoriModel();
        $this->TentangModel = new TentangModel();
        $this->KategoriWisataModel = new KategoriWisataModel();
        $this->KategoriOlehOlehModel = new KategoriOlehOlehModel();
        $this->TempatWisataModel = new TempatWisataModel();
        $this->OlehOlehModel = new OlehOlehModel();
        $this->MetaModel = new MetaModel();
    }

    public function index()
    {
        $meta = $this->MetaModel->where('nama_halaman', 'Tentang')->first();

        $lang = session()->get('lang') ?? 'id';
        $canonical = base_url("$lang/" . ($lang === 'id' ? 'tentang' : 'about'));

        $nama_tentang = $this->TentangModel->getNamaTentang();

        $image = base_url('assets-baru/img/error_logo.webp');

        $metaOG = [
            'title'       => $lang == 'id' ? $meta->meta_title_id : $meta->meta_title_en,
            'description' => $lang == 'id' ? $meta->meta_description_id : $meta->meta_description_en,
            'image'       => $image,
            'url'         => $canonical,
            'type'        => 'article',
        ];

        // Mengambil data dari model
        $data = [
            'kategori' => $this->KategoriModel->getKategori(),
            'tentang' => $this->TentangModel->getTentangDepan(),
            'title' => "Tentang - $nama_tentang", // Judul halaman dinamis
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'tempatWisata' => $this->TempatWisataModel->getAllWisata(),
            'olehOleh' => $this->OlehOlehModel->getAllOlehOleh(),
            'lang' => $lang,
            'meta' => $meta,
            'canonical' => $canonical,
            'metaOG' => $metaOG,
        ];

        // Cek apakah data 'tentang' yang diambil berbentuk array
        if (!empty($data['tentang']) && is_array($data['tentang'])) {
            // Cek apakah bahasa yang dipilih adalah Bahasa Indonesia atau Inggris
            if (session('lang') === 'in') {
                // Gunakan deskripsi dalam bahasa Indonesia
                $data['deskripsi_tentang'] = strip_tags($data['tentang'][0]['deskripsi_tentang']);
            } else {
                // Gunakan deskripsi dalam bahasa Inggris
                $data['deskripsi_tentang'] = strip_tags($data['tentang'][0]['deskripsi_tentang_en']);
            }
        } else {
            // Jika data tidak ditemukan atau formatnya salah
            $data['deskripsi_tentang'] = "Deskripsi tidak tersedia.";
        }

        // Menampilkan view dengan data yang sudah diproses
        return view('user/tentang/index', $data);
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
            'tempatWisata' => $tempatWisata,  // Data wisata sudah disaring
            'olehOleh' => $this->OlehOlehModel->getAllOlehOleh(),
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'randomWisata' => $this->TempatWisataModel->getRandomWisata(),
            'randomOlehOleh' => $this->OlehOlehModel->getRandomOlehOleh(3),
            'lang' => $lang,
            'meta' => $meta
        ];

        // Memuat view ajax_content dengan data yang diteruskan
        return view('user/tentang/ajax_content', $data);
    }
}
