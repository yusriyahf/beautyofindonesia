<?php

namespace App\Controllers;

use App\Controllers\user\BaseController;
use App\Models\OlehOlehModel;
use App\Models\KategoriOlehOlehModel;
use App\Models\TentangModel;
use App\Models\KategoriWisataModel;
use App\Models\TempatWisataModel;
use App\Models\KategoriModel;
use App\Models\ProvinsiModel; // Add this line
use App\Models\KabupatenModel; // Add this
use App\Models\MetaModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\Cookie\Cookie;

class OlehOleh extends BaseController
{
    private $KategoriModel;
    private $OlehOlehModel;
    private $TempatWisataModel;
    private $KategoriOlehOlehModel;
    private $TentangModel;
    private $KategoriWisataModel;
    private $ProvinsiModel; // Add this line
    private $KabupatenModel; // Add this
    private $MetaModel; // Add this

    public function __construct()
    {
        $this->KategoriModel = new KategoriModel();
        $this->OlehOlehModel = new OlehOlehModel();
        $this->KategoriOlehOlehModel = new KategoriOlehOlehModel();
        $this->TempatWisataModel = new TempatWisataModel();
        $this->TentangModel = new TentangModel();
        $this->KategoriWisataModel = new KategoriWisataModel();
        $this->ProvinsiModel = new ProvinsiModel(); // Initialize the ProvinsiModel
        $this->KabupatenModel = new KabupatenModel(); // Initialize KabupatenModel
        $this->MetaModel = new MetaModel(); // Initialize KabupatenModel
    }

    public function index()
    {
        $lang = session()->get('lang') ?? 'en';  // Get the active language from session, default to 'en'
        $canonical = base_url("$lang/" . ($lang === 'id' ? 'oleh-oleh' : 'souvenirs'));
        // Get meta data for the page
        $meta = $this->MetaModel->where('nama_halaman', 'Oleh')->first();

        $title = $lang == 'id' ? $meta->meta_title_id : $meta->meta_title_en;
        $title = explode(' - ', $title)[0];

        // Initialize query for Oleh-Oleh data
        $olehOlehQuery = $this->OlehOlehModel;

        $provinsiSlug = $this->request->getGet('provinsiSlug');
        $kabupatenSlug = $this->request->getGet('kabupatenSlug');

        $idProvinsi = $this->ProvinsiModel->getProvinceIdBySlug($provinsiSlug);
        $idKabupaten = $this->KabupatenModel->getKotakabupatenBySlug($kabupatenSlug);

        $olehData = $this->OlehOlehModel->getAllOlehOleh(9);

        if ($provinsiSlug) {
            $olehData = $this->OlehOlehModel->getOlehOlehByProvinsi($idProvinsi->id_provinsi);
        }

        if ($kabupatenSlug) {
            $olehData = $this->OlehOlehModel->getOlehOlehByKabupaten($idKabupaten);
        }

        $image = base_url('assets-baru/img/error_logo.webp');

        $metaOG = [
            'title'       => $lang == 'id' ? $meta->meta_title_id : $meta->meta_title_en,
            'description' => $lang == 'id' ? $meta->meta_description_id : $meta->meta_description_en,
            'image'       => $image,
            'url'         => $canonical,
            'type'        => 'article',
        ];

        // Fetch filtered results with pagination
        $data = [
            'olehData' => $olehData,  // Make sure to use the query with filters applied
            'pager' => $olehOlehQuery->pager,  // Instance pager for pagination
            'provinsiYus' => $this->ProvinsiModel->getAllProvinsi(),
            'kabupaten' => $this->KabupatenModel->getKabupaten($lang),  // Get kabupaten based on language
            'provinsiSlug' => $this->ProvinsiModel->getProvinsiSlug($lang),  // Get provinsi slugs based on language
            'kabupatenSlug' => $this->KabupatenModel->getKabupatenSlug($lang),  // Get kabupaten slugs based on language
            'title' => $title,
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'tentang' => $this->TentangModel->getTentangDepan(),
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategori' => $this->KategoriModel->getKategori(),
            'lang' => $lang,  // Send the language variable to the view
            'meta' => $meta,
            'canonical' => $canonical,
            'metaOG' => $metaOG,
        ];

        return view('user/oleholeh/index', $data);  // Render the view with data
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

    public function detail($nama_kategori_oleholeh, $slug)
    {
        $lang = session()->get('lang') ?? 'en';

        // Fetch oleh-oleh detail using slug
        $oleh = $this->OlehOlehModel->getOlehOlehDetailBySlug($slug);

        $canonical = base_url("$lang/" . ($lang === 'id' ? 'oleh-oleh' : 'souvenirs') . '/' . ($lang === 'id' ? $oleh['slug_kategori_oleholeh'] : $oleh['slug_kategori_oleholeh_en']) . '/' . $slug);


        if (current_url() !== $canonical) {
            return redirect()->to($canonical);
        }

        if (!$oleh) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Oleh-Oleh with slug '$slug' not found");
        }

        // Cek cookie apakah user sudah melihat halaman ini
        $cookieName = 'viewed_oleholeh_' . $oleh['id_oleholeh'];
        helper('cookie'); // Pastikan helper cookie sudah dimuat

        if (!get_cookie($cookieName)) {
            // Jika belum ada cookie, tambahkan views dan set cookie baru
            $this->OlehOlehModel->increaseViews($oleh['id_oleholeh']);
            set_cookie($cookieName, 'true', 86400 * 30); // Expired dalam 30 hari
        }

        // Redirect jika slug tidak sesuai dengan bahasa
        $url_prefix = $lang === 'id' ? 'oleh-oleh' : 'souvenirs';
        $correct_slug_id = $oleh['slug_oleholeh'];
        $correct_slug_en = $oleh['slug_en'];
        $correct_kategori_slug_id = $oleh['slug_kategori_oleholeh'];
        $correct_kategori_slug_en = $oleh['slug_kategori_oleholeh_en'];

        if ($lang === 'id' && $slug !== $correct_slug_id) {
            return redirect()->to(base_url("{$lang}/{$url_prefix}/{$correct_kategori_slug_id}/{$correct_slug_id}"));
        } elseif ($lang === 'en' && $slug !== $correct_slug_en) {
            return redirect()->to(base_url("{$lang}/{$url_prefix}/{$correct_kategori_slug_en}/{$correct_slug_en}"));
        }

        // Get the kabupaten ID from the oleh-oleh
        $id_kabupaten = $oleh['id_kotakabupaten'];

        $randomWisata = $this->TempatWisataModel->randomWisata($id_kabupaten, 5);

        $randomOlehOleh = $this->OlehOlehModel->randomOlehOleh($id_kabupaten, 5);

        $image = base_url('/assets-baru/img/foto_oleholeh/' . $oleh['foto_oleholeh']);

        $metaOG = [
            'title' => ($lang === 'id') ? $oleh['meta_title_id'] : $oleh['meta_title_en'],
            'description' => ($lang === 'id') ? $oleh['meta_description_id'] : $oleh['meta_description_en'],
            'image'       => $image,
            'url'         => $canonical,
            'type'        => 'product',
        ];

        $data = [
            'provinsi' => $this->ProvinsiModel->getProvinsi($lang),
            'kabupaten' => $this->KabupatenModel->getKabupaten($lang),
            'oleh' => $oleh,
            'title' => $oleh['nama_oleholeh'],
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'tentang' => $this->TentangModel->getTentangDepan(),
            'kategori' => $this->KategoriModel->getKategori(),
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'tempatWisata' => $this->TempatWisataModel->getAllWisata(),
            'olehOleh' => $this->OlehOlehModel->getAllOlehOleh(),
            'randomWisata' => $randomWisata,
            'randomOlehOleh' => $randomOlehOleh,
            'lang' => $lang,
            'meta' => $this->MetaModel->where('nama_halaman', 'Oleh')->first(),
            'canonical' => $canonical,
            'metaOG' => $metaOG,
        ];

        return view('user/oleholeh/detail', $data);
    }

    public function kategoriOleh($slug_kategori_oleholeh)
    {
        // Get the current language from session or default to 'en'
        $lang = session()->get('lang') ?? 'en';
        $canonical = base_url("$lang/" . ($lang === 'id' ? 'oleh-oleh' : 'souvenirs') . '/' . $slug_kategori_oleholeh);

        if (current_url() !== $canonical) {
            return redirect()->to($canonical);
        }

        $kategori = $this->KategoriOlehOlehModel->where('slug_kategori_oleholeh_en', $slug_kategori_oleholeh)
            ->orWhere('slug_kategori_oleholeh', $slug_kategori_oleholeh)->first();

        $title = $lang == 'id' ? $kategori->meta_title_id : $kategori->meta_title_en;
        $title = explode(' - ', $title)[0];

        $meta = $kategori ? (object)[
            'meta_title_id' => $kategori->meta_title_id,
            'meta_title_en' => $kategori->meta_title_en,
            'meta_description_id' => $kategori->meta_description_id ?? '',
            'meta_description_en' => $kategori->meta_description_en ?? ''
        ] : null;

        // Ambil segmen slug kategori wisata dari URL
        $slug_oleh_oleh = $this->request->uri->getSegment(4); // Segmen ke-4 biasanya adalah slug

        $url_prefix = $lang === 'id' ? 'oleh-oleh' : 'souvenirs';
        $url_prefix2 = $lang === 'id' ? 'kategori-oleh-oleh' : 'souvenirs-category';

        // Memilih slug wisata berdasarkan bahasa
        $correct_slug_id = $kategori->slug_kategori_oleholeh ?? null;
        $correct_slug_en = $kategori->slug_kategori_oleholeh_en ?? null;

        $correctSlug = $lang === 'id' ? $kategori->slug_kategori_oleholeh : $kategori->slug_kategori_oleholeh_en;

        if ($slug_kategori_oleholeh !== $correctSlug) {
            return redirect()->to(base_url($lang === 'id' ? "id/oleh-oleh/$correctSlug" : "en/souvenirs/$correctSlug"));
        }

        // if ($lang === 'id' && $slug_oleh_oleh !== $correct_slug_id) {
        //     // Redirect ke slug yang benar dalam bahasa Indonesia
        //     return redirect()->to(base_url("{$lang}/{$url_prefix}/{$url_prefix2}/{$correct_slug_id}"));
        // } elseif ($lang === 'en' && $slug_oleh_oleh !== $correct_slug_en) {
        //     // Redirect ke slug yang benar dalam bahasa Inggris
        //     return redirect()->to(base_url("{$lang}/{$url_prefix}/{$url_prefix2}/{$correct_slug_en}"));
        // }

        $provinsiSlug = $this->request->getGet('provinsiSlug');
        $kabupatenSlug = $this->request->getGet('kabupatenSlug');

        $idProvinsi = $this->ProvinsiModel->getProvinceIdBySlug($provinsiSlug);
        $idKabupaten = $this->KabupatenModel->getKotakabupatenBySlug($kabupatenSlug);

        $olehData =  $this->OlehOlehModel->getOlehOlehByCategory($kategori->id_kategori_oleholeh, 9);

        if ($provinsiSlug) {
            $olehData = $this->OlehOlehModel->getOlehOlehByProvinsiAndKategori($idProvinsi->id_provinsi, $kategori->id_kategori_oleholeh);
        }

        if ($kabupatenSlug) {
            $olehData = $this->OlehOlehModel->getOlehOlehByKabupatenAndKategori($idKabupaten,  $kategori->id_kategori_oleholeh);
        }

        $image = base_url('assets-baru/img/error_logo.webp');

        $metaOG = [
            'title'       => $lang == 'id' ? $kategori->meta_title_id : $kategori->meta_title_en,
            'description' => $lang == 'id' ? $kategori->meta_description_id : $kategori->meta_description_en,
            'image'       => $image,
            'url'         => $canonical,
            'type'        => 'article',
        ];

        $data = [
            'kategoriFix' => $kategori,
            'slug' => $slug_kategori_oleholeh,
            'olehData' => $olehData,
            'provinsi' => $this->ProvinsiModel->getAllProvinsi(),
            'kabupaten' => $this->KabupatenModel->getKabupaten($lang),
            'provinsiSlug' => $this->ProvinsiModel->getProvinsiSlug($lang),
            'kabupatenSlug' => $this->KabupatenModel->getKabupatenSlug($lang),
            'kategori' => $this->KategoriModel->getKategori(),
            'title' => $title,
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
            'tentang' => $this->TentangModel->getTentangDepan(),
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'lang' => $lang,
            'pager' => $this->OlehOlehModel->pager,
            'meta' => $meta,
            'canonical' => $canonical,
            'metaOG' => $metaOG,
        ];

        return view('user/oleholeh/kategori', $data);
    }

    public function countWhatsappClick($id)
    {

        // Update jumlah klik WhatsApp berdasarkan ID oleh-oleh
        $this->OlehOlehModel->incrementWhatsappClicks($id);

        // Redirect ke link WhatsApp
        return redirect()->to("https://wa.me/" . esc($this->request->getGet('nomor_tlp')));
    }
}
