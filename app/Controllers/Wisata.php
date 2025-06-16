<?php

namespace App\Controllers;

use App\Controllers\user\BaseController;
use App\Models\ArtikelIklanModel;
use App\Models\IklanUtamaModel;
use App\Models\TempatWisataModel;
use App\Models\KategoriModel;
use App\Models\TentangModel;
use App\Models\KategoriWisataModel;
use App\Models\KategoriOlehOlehModel;
use App\Models\ProvinsiModel;
use App\Models\KabupatenModel;
use App\Models\MetaModel;
use App\Models\OlehOlehModel; // Add this line
use App\Models\TipeIklanUtama;

class Wisata extends BaseController
{
    private $KategoriModel;
    private $TentangModel;
    private $KategoriWisataModel;
    private $KategoriOlehOlehModel;
    private $TempatWisataModel;
    private $ProvinsiModel;
    private $KabupatenModel;
    private $OlehOlehModel; // Add this line
    private $MetaModel; // Add this line
    private $tipeIklanModel; // Add this line
    private $iklanUtamaModel; // Add this line
    private $ArtikelIklanModel; // Add this line

    public function __construct()
    {
        $this->KategoriModel = new KategoriModel();
        $this->TentangModel = new TentangModel();
        $this->KategoriWisataModel = new KategoriWisataModel();
        $this->KategoriOlehOlehModel = new KategoriOlehOlehModel();
        $this->TempatWisataModel = new TempatWisataModel();
        $this->ProvinsiModel = new ProvinsiModel();
        $this->KabupatenModel = new KabupatenModel();
        $this->OlehOlehModel = new OlehOlehModel();
        $this->MetaModel = new MetaModel();
        $this->tipeIklanModel = new TipeIklanUtama();
        $this->iklanUtamaModel = new IklanUtamaModel();
        $this->ArtikelIklanModel = new ArtikelIklanModel();
    }

    public function index()
    {
        $lang = session()->get('lang') ?? 'en';

        $canonical = base_url("$lang/" . ($lang === 'id' ? 'wisata' : 'destinations'));
        $meta = $this->MetaModel->where('nama_halaman', 'Wisata')->first();

        if (current_url() !== $canonical) {
            return redirect()->to($canonical);
        }

        $title = $lang == 'id' ? $meta->meta_title_id : $meta->meta_title_en;
        $title = explode(' - ', $title)[0];

        // Inisialisasi query wisata
        $wisataQuery = $this->TempatWisataModel;

        // $provinsiSlug = 15;
        $provinsiSlug = $this->request->getGet('provinsiSlug');
        $kabupatenSlug = $this->request->getGet('kabupatenSlug');

        $idProvinsi = $this->ProvinsiModel->getProvinceIdBySlug($provinsiSlug);
        $idKabupaten = $this->KabupatenModel->getKotakabupatenBySlug($kabupatenSlug);

        $wisataBos = $this->TempatWisataModel->getAllWisata(9);

        if ($provinsiSlug) {
            $wisataBos = $this->TempatWisataModel->getWisataByProvinsi($idProvinsi->id_provinsi);
        }

        if ($kabupatenSlug) {
            $wisataBos = $this->TempatWisataModel->getWisataByKotakabupaten($idKabupaten);
        }

        $image = base_url('assets-baru/img/error_logo.webp');

        $metaOG = [
            'title'       => $lang == 'id' ? $meta->meta_title_id : $meta->meta_title_en,
            'description' => $lang == 'id' ? $meta->meta_description_id : $meta->meta_description_en,
            'image'       => $image,
            'url'         => $canonical,
            'type'        => 'article',
        ];

        $iklanHeaderCek = $this->tipeIklanModel->cekTipeIklan('Wisata - Header');
        $iklanHeader = $iklanHeaderCek ? $this->iklanUtamaModel->getIklanAktifByTipe($iklanHeaderCek['id_tipe_iklan_utama']) : null;

        $iklanFooterCek = $this->tipeIklanModel->cekTipeIklan('Wisata - Footer');
        $iklanFooter = $iklanFooterCek ? $this->iklanUtamaModel->getIklanAktifByTipe($iklanFooterCek['id_tipe_iklan_utama']) : null;


        $data = [
            'iklanHeaderCek' => $iklanHeaderCek,
            'iklanFooterCek' => $iklanFooterCek,
            'iklanHeader' => $iklanHeader,
            'iklanFooter' => $iklanFooter,
            'tempatwisata' => $wisataBos,
            'pager' => $wisataQuery->pager,
            'provinsiYus' => $this->ProvinsiModel->getAllProvinsi(),
            'kabupaten' => $this->KabupatenModel->getKabupaten($lang),
            'provinsiSlug' => $this->ProvinsiModel->getProvinsiSlug($lang),
            'kabupatenSlug' => $this->KabupatenModel->getKabupatenSlug($lang),
            'tentang' => $this->TentangModel->getTentangDepan(),
            'title' => $title,
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'lang' => $lang,
            'kategori' => $this->KategoriModel->getKategori(),
            'meta' => $meta,
            'canonical' => $canonical,
            'metaOG' => $metaOG,
        ];
        return view('user/wisata/index', $data);
    }

    public function getKabupatenByProvinsi($provinsiSlug)
    {
        $lang = session()->get('lang') ?? 'id'; // Ambil bahasa dari session, default ke 'id'

        // Tentukan kolom slug provinsi berdasarkan bahasa
        $slug_provinsi_field = ($lang === 'en') ? 'slug_provinsi_eng' : 'slug_provinsi_ind';
        $slug_kabupaten_field = ($lang === 'en') ? 'slug_kotakabupaten_eng' : 'slug_kotakabupaten_ind';
        $nama_kabupaten_field = ($lang === 'en') ? 'nama_kotakabupaten_eng' : 'nama_kotakabupaten';

        // Ambil data kabupaten berdasarkan slug provinsi
        $kabupatenSlug = $this->KabupatenModel->where($slug_provinsi_field, $provinsiSlug)
            ->select("$slug_kabupaten_field AS slug_kotakabupaten, $nama_kabupaten_field AS nama_kotakabupaten")
            ->findAll();

        // Kirim data kabupaten sebagai JSON
        return $this->response->setJSON($kabupatenSlug);
    }

    public function detail($nama_kategori_wisata, $slug_wisata)
    {
        $lang = session()->get('lang') ?? 'id';

        $wisata = $this->TempatWisataModel->getWisataDetail($slug_wisata);

        $category = $this->KategoriWisataModel->getKategoriDetail($nama_kategori_wisata);

        $meta = $this->MetaModel->where('nama_halaman', 'Wisata')->first();

        if (!$wisata) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Wisata with slug $slug_wisata not found");
        }

        // Ambil iklan berdasarkan id artikel (id_content)
        $id_wisata = $wisata['id_wisata'];
        $iklan = $this->ArtikelIklanModel->getLinkIklanByArtikelId($id_wisata);

        // Determine the URL prefix based on the language (wisata for 'id' and destinations for 'en')
        $url_prefix = $lang === 'id' ? 'wisata' : 'destinations';

        // Select the correct slug for the current language
        $correct_slug_id = $wisata['slug_wisata_ind'];
        $correct_slug_en = $wisata['slug_wisata_eng'];

        // Get the correct category slug based on the language
        $correct_kategori_slug_id = $wisata['slug_kategori_wisata'];
        $correct_kategori_slug_en = $wisata['slug_kategori_wisata_en'];

        // Redirect to the correct slug if it doesn't match the current one
        if ($lang === 'id' && $slug_wisata !== $correct_slug_id) {
            return redirect()->to(base_url("{$lang}/{$url_prefix}/{$correct_kategori_slug_id}/{$correct_slug_id}"));
        } elseif ($lang === 'en' && $slug_wisata !== $correct_slug_en) {
            return redirect()->to(base_url("{$lang}/{$url_prefix}/{$correct_kategori_slug_en}/{$correct_slug_en}"));
        }

        $this->TempatWisataModel->incrementViews($wisata['id_wisata']);



        $metaTitle = ($lang === 'id' ? $wisata['nama_wisata_ind'] . ' - WAJIB Baca Ini Sebelum Berkunjung!' : $wisata['nama_wisata_eng'] . ' - READ THIS Before You Visit!');

        $metaDescription = ($lang === 'id'
            ? 'Sebelum ke ' . $wisata['nama_wisata_ind'] . ', WAJIB baca ini! Lokasi, Akses, Aktivitas, & Keindahan dari '
            . $wisata['nama_wisata_ind'] . ', ' . $wisata['nama_kotakabupaten'] . ', ' . $wisata['nama_provinsi'] . ' dikupas habis di sini.'
            : 'Before visiting ' . $wisata['nama_wisata_eng'] . ', READ THIS! Location, Access, Activities, & the Beauty of ' . $wisata['nama_wisata_eng'] . ' — everything you need to know is here!'
        );


        $wisata = $wisata ? array_merge($wisata, [
            'meta_title_id' => $metaTitle ?? '',
            'meta_title_en' => $metaTitle ?? '',
            'meta_description_id' =>  $metaDescription ?? '',
            'meta_description_en' =>  $metaDescription ?? ''
        ]) : null;



        // Fetch the kabupaten ID
        $id_kabupaten = $wisata['id_kotakabupaten'];


        $randomWisata = $this->TempatWisataModel->randomWisata($id_kabupaten, 5);

        $randomOlehOleh = $this->OlehOlehModel->randomOlehOleh($id_kabupaten, 5);

        $canonical = base_url("$lang/" . ($lang === 'id' ? 'wisata' : 'destinations') . '/' . ($lang === 'id' ? $wisata['slug_kategori_wisata'] : $wisata['slug_kategori_wisata_en']) . '/' . $slug_wisata);


        if (current_url() !== $canonical) {
            return redirect()->to($canonical);
        }

        // Cek apakah foto wisata ada dan valid


        $image = base_url('asset-user/uploads/foto_wisata/' . $wisata['foto_wisata']);


        $metaOG = [
            'title'       => $metaTitle,
            'description' => $metaDescription,
            'image'       => $image,
            'url'         => $canonical,
            'type'        => 'article',
        ];

        $data = [
            'provinsi' => $this->ProvinsiModel->getProvinsi($lang),
            'kabupaten' => $this->KabupatenModel->getKabupaten($lang),
            'tempatWisata' => $this->TempatWisataModel->getAllWisata(),
            'olehOleh' => $this->OlehOlehModel->getAllOlehOleh(),
            'wisata' => $wisata,
            'title' => $wisata['nama_wisata_eng'] ?? $wisata['nama_wisata_ind'],
            'randomWisata' => $randomWisata,
            'randomOlehOleh' => $randomOlehOleh,
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'kategori' => $this->KategoriModel->getKategori(),
            'tentang' => $this->TentangModel->getTentangDepan(),
            'meta' => $meta,
            'lang' => $lang,
            'canonical' => $canonical,
            'metaOG' => $metaOG,
            'link_iklan' => $iklan['link_iklan'] ?? '',
            'thumbnail_iklan'=>$iklan['thumbnail_iklan'] ?? '',
        ];

        return view('user/wisata/detail', $data);
    }


    public function kategoriWisata($slug_kategori_wisata)
    {
        $lang = session()->get('lang') ?? 'en';


        // Ambil data kategori berdasarkan slug
        $kategoriWisata = $this->KategoriWisataModel->where('slug_kategori_wisata', $slug_kategori_wisata)
            ->orWhere('slug_kategori_wisata_en', $slug_kategori_wisata)
            ->first();


        if (!$kategoriWisata) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Kategori Wisata dengan slug $slug_kategori_wisata tidak ditemukan");
        }

        $canonical = base_url("$lang/" . ($lang === 'id' ? 'wisata' : 'destinations') .  '/' . ($lang === 'id' ? $kategoriWisata->slug_kategori_wisata : $kategoriWisata->slug_kategori_wisata_en));

        if (current_url() !== $canonical) {
            return redirect()->to($canonical);
        }

        // kategori
        $title = $lang == 'id' ? $kategoriWisata->meta_title_id : $kategoriWisata->meta_title_en;
        $title = explode(' - ', $title)[0];

        $meta = $kategoriWisata ? (object)[
            'meta_title_id' => $kategoriWisata->meta_title_id,
            'meta_title_en' => $kategoriWisata->meta_title_en,
            'meta_description_id' => $kategoriWisata->meta_description_id ?? '',
            'meta_description_en' => $kategoriWisata->meta_description_en ?? ''
        ] : null;

        $correct_slug_id = $kategoriWisata->slug_kategori_wisata ?? null;
        $correct_slug_en = $kategoriWisata->slug_kategori_wisata_en ?? null;

        // Ambil slug dari URI
        $slug_kategori_wisata2 = $this->request->uri->getSegment(4);

        // Tentukan prefix URL berdasarkan bahasa
        $url_prefix = $lang === 'id' ? 'wisata' : 'destinations';

        $correctSlug = $lang === 'id' ? $kategoriWisata->slug_kategori_wisata : $kategoriWisata->slug_kategori_wisata_en;

        if ($slug_kategori_wisata !== $correctSlug) {
            return redirect()->to(base_url($lang === 'id' ? "id/wisata/$correctSlug" : "en/destinations/$correctSlug"));
        }

        // Redirect jika slug tidak sesuai
        // if ($lang === 'id' && $slug_kategori_wisata2 !== $correct_slug_id) {
        //     return redirect()->to(base_url("{$lang}/{$url_prefix}/{$correct_slug_id}"));
        // } elseif ($lang === 'en' && $slug_kategori_wisata2 !== $correct_slug_en) {
        //     return redirect()->to(base_url("{$lang}/{$url_prefix}/{$correct_slug_en}"));
        // }

        $wisataBos = $this->TempatWisataModel->getAllWisataByKategori($kategoriWisata->id_kategori_wisata);

        $provinsiSlug = $this->request->getGet('provinsiSlug');
        $kabupatenSlug = $this->request->getGet('kabupatenSlug');

        $idProvinsi = $this->ProvinsiModel->getProvinceIdBySlug($provinsiSlug);
        $idKabupaten = $this->KabupatenModel->getKotakabupatenBySlug($kabupatenSlug);

        if ($provinsiSlug) {
            $wisataBos = $this->TempatWisataModel->getWisataByProvinsiAndKategori($idProvinsi->id_provinsi, $kategoriWisata->id_kategori_wisata);
        }

        if ($kabupatenSlug) {
            $wisataBos = $this->TempatWisataModel->getWisataByKotakabupatenAndKategori($idKabupaten, $kategoriWisata->id_kategori_wisata);
        }

        $image = base_url('assets-baru/img/error_logo.webp');

        $metaOG = [
            'title'       => $lang == 'id' ? $kategoriWisata->meta_title_id : $kategoriWisata->meta_title_en,
            'description' => $lang == 'id' ? $kategoriWisata->meta_description_id : $kategoriWisata->meta_description_en,
            'image'       => $image,
            'url'         => $canonical,
            'type'        => 'article',
        ];

        $namaIklanHeader = formatNamaIklan('Wisata', $slug_kategori_wisata, 'Header');
        $namaIklanFooter = formatNamaIklan('Wisata', $slug_kategori_wisata, 'Footer');


        $iklanHeaderCek = $this->tipeIklanModel->cekTipeIklan($namaIklanHeader);
        $iklanHeader = $iklanHeaderCek ? $this->iklanUtamaModel->getIklanAktifByTipe($iklanHeaderCek['id_tipe_iklan_utama']) : null;

        $iklanFooterCek = $this->tipeIklanModel->cekTipeIklan($namaIklanFooter);
        $iklanFooter = $iklanFooterCek ? $this->iklanUtamaModel->getIklanAktifByTipe($iklanFooterCek['id_tipe_iklan_utama']) : null;

        // Data untuk view
        $data = [
            'iklanHeaderCek' => $iklanHeaderCek,
            'iklanFooterCek' => $iklanFooterCek,
            'iklanHeader' => $iklanHeader,
            'iklanFooter' => $iklanFooter,
            'tempatwisata' => $kategoriWisata,
            'kategori' => $this->KategoriModel->getKategori(),
            'wisataList' => $wisataBos,
            'pager' => $this->TempatWisataModel->pager, // Instance pager
            // 'title' => $kategoriWisata->nama_kategori_wisata,
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'tentang' => $this->TentangModel->getTentangDepan(),
            'provinsiYus' => $this->ProvinsiModel->getAllProvinsi(),
            'kabupaten' => $this->KabupatenModel->getKabupaten($lang),
            'provinsiSlug' => $this->ProvinsiModel->getProvinsiSlug($lang),  // Ambil provinsi berdasarkan bahasa
            'kabupatenSlug' => $this->KabupatenModel->getKabupatenSlug($lang),  // Ambil kabupaten berdasarkan bahasa
            'lang' => $lang,
            'meta' => $meta,
            'title' => $title,
            'canonical' => $canonical,
            'metaOG' => $metaOG,
        ];

        return view('user/wisata/kategori', $data);
    }

    public function incrementViews($id_wisata)
    {
        try {
            $this->TempatWisataModel->incrementViews($id_wisata);
        } catch (\Exception $e) {
            log_message('error', 'Failed to update views for wisata ID ' . $id_wisata . ': ' . $e->getMessage());
        }
    }
}
