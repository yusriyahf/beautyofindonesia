<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Homectrl');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
// $routes->set404Override('App\Controllers\CustomErrorController::show404');



// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//ADMIN
$routes->get('registrasi', 'RegistrasiController::index');
$routes->get('login', 'Login::index');

$routes->post('login/process', 'Login::process');
$routes->get('logout', 'Login::logout');

$routes->get('admin/acc/(:num)', 'AdminController::accPengajuan/$1');
$routes->get('admin/tolak/(:num)', 'AdminController::tolakPengajuan/$1');
// Daftarkan rute-rute admin di sini
$routes->get('sitemap.xml', 'Sitemap::index');

$routes->get('iklan-klik/(:num)', 'IklanUtamaController::klik/$1');


$routes->group('admin', ['filter' => 'rolecheck:admin'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'admin\Dashboardctrl::index');

    // IKLAN UTAMA


    $routes->get('saldo', 'admin\Komisi::saldo/$1');
    $routes->get('saldo/penarikan', 'admin\Komisi::penarikan');
    $routes->post('saldo/proses_penarikan', 'admin\Komisi::proses_penarikan');
    $routes->get('saldo/permintaan', 'admin\Komisi::permintaan');
    $routes->post('saldo/ubahstatus', 'admin\Komisi::ubahstatus');

    // Users
    $routes->get('users', 'admin\Users::index');
    $routes->get('users/tambah', 'admin\Users::tambah');
    $routes->post('users/proses_tambah', 'admin\Users::proses_tambah');
    $routes->get('users/edit/(:num)', 'admin\Users::edit/$1');
    $routes->post('users/proses_edit/(:num)', 'admin\Users::proses_edit/$1');
    $routes->get('users/delete/(:any)', 'admin\Users::delete/$1');

    // Acc User Req
    // Users
    $routes->get('userRequest', 'admin\AccUserController::index');

    $routes->get('komisi', 'admin\Komisi::index');
    $routes->get('komisi/tambah', 'admin\Komisi::tambah');
    $routes->post('komisi/proses_tambah', 'admin\Komisi::proses_tambah');
    $routes->get('komisi/edit/(:num)', 'admin\Komisi::edit/$1');
    $routes->post('komisi/proses_edit/(:num)', 'admin\Komisi::proses_edit/$1');
    $routes->get('komisi/delete/(:any)', 'admin\Komisi::delete/$1');




    // Popup
    $routes->get('popup', 'admin\Popup::index');
    $routes->get('popup/tambah', 'admin\Popup::tambah');
    $routes->post('popup/proses_tambah', 'admin\Popup::proses_tambah');
    $routes->get('popup/edit/(:num)', 'admin\Popup::edit/$1');
    $routes->post('popup/proses_edit/(:num)', 'admin\Popup::proses_edit/$1');
    $routes->get('popup/delete/(:any)', 'admin\Popup::delete/$1');

    // Kategori Artikel
    $routes->get('kategori/index', 'admin\Kategori::index');
    $routes->get('kategori/tambah', 'admin\Kategori::tambah');
    $routes->post('kategori/proses_tambah', 'admin\Kategori::proses_tambah');
    $routes->get('kategori/edit/(:num)', 'admin\Kategori::edit/$1');
    $routes->post('kategori/proses_edit/(:num)', 'admin\Kategori::proses_edit/$1');
    $routes->get('kategori/delete/(:any)', 'admin\Kategori::delete/$1');

    // Meta
    $routes->get('meta/index', 'admin\MetaController::index');
    $routes->get('meta/tambah', 'admin\MetaController::tambah');
    $routes->post('meta/proses_tambah', 'admin\MetaController::proses_tambah');
    $routes->get('meta/edit/(:num)', 'admin\MetaController::edit/$1');
    $routes->post('meta/proses_edit/(:num)', 'admin\MetaController::proses_edit/$1');
    $routes->get('meta/delete/(:any)', 'admin\MetaController::delete/$1');

    // Artikel

    // Daftar Penulis
    $routes->get('penulis/index', 'admin\Penulis::index');
    $routes->get('penulis/tambah', 'admin\Penulis::tambah');
    $routes->post('penulis/proses_tambah', 'admin\Penulis::proses_tambah');
    $routes->get('penulis/edit/(:num)', 'admin\Penulis::edit/$1');
    $routes->post('penulis/proses_edit/(:num)', 'admin\Penulis::proses_edit/$1');
    $routes->get('penulis/delete/(:any)', 'admin\Penulis::delete/$1');

    // Profil Perusahaan
    $routes->get('tentang/edit', 'admin\Tentang::edit');
    $routes->post('tentang/edit', 'admin\Tentang::edit');

    // Provinsi
    $routes->get('provinsi/index', 'admin\Provinsi::index');
    $routes->get('provinsi/tambah', 'admin\Provinsi::tambah');
    $routes->post('provinsi/proses_tambah', 'admin\Provinsi::proses_tambah');
    $routes->get('provinsi/edit/(:num)', 'admin\Provinsi::edit/$1');
    $routes->post('provinsi/proses_edit/(:num)', 'admin\Provinsi::proses_edit/$1');
    $routes->get('provinsi/delete/(:any)', 'admin\Provinsi::delete/$1');

    // Kabupaten
    $routes->get('kabupaten/index', 'admin\Kabupaten::index');
    $routes->get('kabupaten/tambah', 'admin\Kabupaten::tambah');
    $routes->post('kabupaten/proses_tambah', 'admin\Kabupaten::proses_tambah');
    $routes->get('kabupaten/edit/(:num)', 'admin\Kabupaten::edit/$1');
    $routes->post('kabupaten/proses_edit/(:num)', 'admin\Kabupaten::proses_edit/$1');
    $routes->get('kabupaten/delete/(:any)', 'admin\Kabupaten::delete/$1');

    // Kategori Wisata
    $routes->get('kategori_wisata/index', 'admin\KategoriWisata::index');
    $routes->get('kategori_wisata/tambah', 'admin\KategoriWisata::tambah');
    $routes->post('kategori_wisata/proses_tambah', 'admin\KategoriWisata::proses_tambah');
    $routes->get('kategori_wisata/edit/(:num)', 'admin\KategoriWisata::edit/$1');
    $routes->post('kategori_wisata/proses_edit/(:num)', 'admin\KategoriWisata::proses_edit/$1');
    $routes->get('kategori_wisata/delete/(:any)', 'admin\KategoriWisata::delete/$1');

    // Kategori Oleh Oleh
    $routes->get('kategori_oleholeh/index', 'admin\KategoriOlehOleh::index');
    $routes->get('kategori_oleholeh/tambah', 'admin\KategoriOlehOleh::tambah');
    $routes->post('kategori_oleholeh/proses_tambah', 'admin\KategoriOlehOleh::proses_tambah');
    $routes->get('kategori_oleholeh/edit/(:num)', 'admin\KategoriOlehOleh::edit/$1');
    $routes->post('kategori_oleholeh/proses_edit/(:num)', 'admin\KategoriOlehOleh::proses_edit/$1');
    $routes->get('kategori_oleholeh/delete/(:num)', 'admin\KategoriOlehOleh::delete/$1');

    // Tempat Wisata
    $routes->get('tempat_wisata/index', 'admin\TempatWisata::index');
    $routes->get('tempat_wisata/tambah', 'admin\TempatWisata::tambah');
    $routes->post('tempat_wisata/proses_tambah', 'admin\TempatWisata::proses_tambah');
    $routes->get('tempat_wisata/edit/(:num)', 'admin\TempatWisata::edit/$1');
    $routes->post('tempat_wisata/proses_edit/(:num)', 'admin\TempatWisata::proses_edit/$1');
    $routes->get('tempat_wisata/detail/(:num)', 'admin\TempatWisata::detail/$1');
    $routes->get('tempat_wisata/delete/(:num)', 'admin\TempatWisata::delete/$1');

    // Oleh Oleh
    $routes->get('oleh_oleh/index', 'admin\OlehOleh::index');
    $routes->get('oleh_oleh/tambah', 'admin\OlehOleh::tambah');
    $routes->post('oleh_oleh/proses_tambah', 'admin\OlehOleh::proses_tambah');
    $routes->get('oleh_oleh/edit/(:num)', 'admin\OlehOleh::edit/$1');
    $routes->get('oleh_oleh/detail/(:segment)', 'admin\OlehOleh::detail/$1');
    $routes->post('oleh_oleh/proses_edit/(:num)', 'admin\OlehOleh::proses_edit/$1');
    $routes->get('oleh_oleh/delete/(:num)', 'admin\OlehOleh::delete/$1');
    $routes->post('oleh_oleh/increment-whatsapp/(:num)', 'admin\OlehOleh::incrementWhatsapp/$1');

    // Profil Pengguna
    $routes->get('profile/index', 'admin\Profile::index');
    $routes->get('profile/edit/(:num)', 'admin\Profile::edit/$1');
    $routes->post('profile/update/(:num)', 'admin\Profile::update/$1');


    // IKLAN UTAMA
    $routes->get('acciklanutama', 'admin\IklanUtamaController::index2');
    $routes->post('iklanutama/ubahStatus', 'admin\IklanUtamaController::ubahStatus');
    // Daftar Iklan Utama
    $routes->get('iklanutama', 'admin\IklanUtamaController::index');
    $routes->get('iklanutama/tambah', 'admin\IklanUtamaController::tambah');
    $routes->post('iklanutama/proses_tambah', 'admin\IklanUtamaController::proses_tambah');
    // tipe iklan utama
    $routes->get('tipeiklanutama', 'admin\TipeIklanUtama::index');
    $routes->get('tipeiklanutama/tambah', 'admin\TipeIklanUtama::tambah');
    $routes->post('tipeiklanutama/proses_tambah', 'admin\TipeIklanUtama::proses_tambah');
    $routes->get('tipeiklanutama/edit/(:num)', 'admin\TipeIklanUtama::edit/$1');
    $routes->post('tipeiklanutama/proses_edit/(:num)', 'admin\TipeIklanUtama::update/$1');
    $routes->get('tipeiklanutama/delete/(:num)', 'admin\TipeIklanUtama::delete/$1');

    // IKLAN KONTEN
    $routes->get('daftariklankonten', 'admin\IklanController::index');
    $routes->get('daftariklankonten/tambah', 'admin\IklanController::tambah_artikel_iklan');
    $routes->post('daftariklankonten/proses_tambah', 'admin\IklanController::proses_tambah');
    $routes->get('daftariklankonten/edit/(:num)', 'admin\IklanController::edit/$1');
    $routes->get('daftariklankonten/detail/(:num)', 'admin\IklanController::detail/$1');
    $routes->get('acciklankonten', 'admin\ArtikelIklan::index');
    $routes->post('acciklankonten/ubahstatus', 'admin\ArtikelIklan::ubahStatus');
    
});

$routes->group('penulis', ['filter' => 'rolecheck:penulis'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'penulis\Dashboard::index');

    // Artikel Penulis
    $routes->get('artikel/index', 'admin\Artikel::index');  // Artikel Penulis
    $routes->get('artikel/tambah', 'penulis\Artikel::tambah');
    $routes->post('artikel/proses_tambah', 'penulis\Artikel::proses_tambah');
    $routes->get('artikel/edit/(:num)', 'penulis\Artikel::edit/$1');
    $routes->post('artikel/proses_edit/(:num)', 'penulis\Artikel::proses_edit/$1');
    $routes->get('artikel/delete/(:any)', 'penulis\Artikel::delete/$1');

    // Kategori Artikel
    $routes->get('kategori/index', 'penulis\Kategori::index');
    $routes->get('kategori/tambah', 'penulis\Kategori::tambah');
    $routes->post('kategori/proses_tambah', 'penulis\Kategori::proses_tambah');
    $routes->get('kategori/edit/(:num)', 'penulis\Kategori::edit/$1');
    $routes->post('kategori/proses_edit/(:num)', 'penulis\Kategori::proses_edit/$1');
    $routes->get('kategori/delete/(:any)', 'penulis\Kategori::delete/$1');

    // TEMPAT WISATA
    $routes->get('tempat_wisata/index', 'admin\TempatWisata::index');
    $routes->get('tempat_wisata/tambah', 'admin\TempatWisata::tambah');
    $routes->post('tempat_wisata/proses_tambah', 'admin\TempatWisata::proses_tambah');
    $routes->get('tempat_wisata/edit/(:num)', 'admin\TempatWisata::edit/$1');
    $routes->post('tempat_wisata/proses_edit/(:num)', 'admin\TempatWisata::proses_edit/$1');
    $routes->get('tempat_wisata/detail/(:num)', 'admin\TempatWisata::detail/$1');
    $routes->get('tempat_wisata/delete/(:num)', 'admin\TempatWisata::delete/$1');

    // KATEGORI WISATA
    $routes->get('kategori_wisata/index', 'admin\KategoriWisata::index');
    $routes->get('kategori_wisata/tambah', 'admin\KategoriWisata::tambah');
    $routes->post('kategori_wisata/proses_tambah', 'admin\KategoriWisata::proses_tambah');
    $routes->get('kategori_wisata/edit/(:num)', 'admin\KategoriWisata::edit/$1');
    $routes->post('kategori_wisata/proses_edit/(:num)', 'admin\KategoriWisata::proses_edit/$1');
    $routes->get('kategori_wisata/delete/(:any)', 'admin\KategoriWisata::delete/$1');

    // OLEH OLEJ
    $routes->get('oleh_oleh/index', 'admin\OlehOleh::index');
    $routes->get('oleh_oleh/tambah', 'admin\OlehOleh::tambah');
    $routes->post('oleh_oleh/proses_tambah', 'admin\OlehOleh::proses_tambah');
    $routes->get('oleh_oleh/edit/(:num)', 'admin\OlehOleh::edit/$1');
    $routes->get('oleh_oleh/detail/(:segment)', 'admin\OlehOleh::detail/$1');
    $routes->post('oleh_oleh/proses_edit/(:num)', 'admin\OlehOleh::proses_edit/$1');
    $routes->get('oleh_oleh/delete/(:num)', 'admin\OlehOleh::delete/$1');

    // KATEGORI OLEH OLEH
    $routes->get('kategori_oleholeh/index', 'admin\KategoriOlehOleh::index');
    $routes->get('kategori_oleholeh/tambah', 'admin\KategoriOlehOleh::tambah');
    $routes->post('kategori_oleholeh/proses_tambah', 'admin\KategoriOlehOleh::proses_tambah');
    $routes->get('kategori_oleholeh/edit/(:num)', 'admin\KategoriOlehOleh::edit/$1');
    $routes->post('kategori_oleholeh/proses_edit/(:num)', 'admin\KategoriOlehOleh::proses_edit/$1');
    $routes->get('kategori_oleholeh/delete/(:num)', 'admin\KategoriOlehOleh::delete/$1');

    // Daftar Iklan Utama
    $routes->get('iklanutama', 'admin\IklanUtamaController::index');
    $routes->get('iklanutama/tambah', 'admin\IklanUtamaController::tambah');
    $routes->post('iklanutama/proses_tambah', 'admin\IklanUtamaController::proses_tambah');
});


$routes->group('marketing', ['filter' => 'rolecheck:marketing'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'marketing\Dashboard::index');

    // Artikel Iklan
    $routes->get('artikeliklan/index', 'marketing\ArtikelIklan::index');

    $routes->get('iklanutama', 'admin\IklanUtamaController::index');
    $routes->get('iklanutama/tambah', 'admin\IklanUtamaController::tambah');
    $routes->post('iklanutama/proses_tambah', 'admin\IklanUtamaController::proses_tambah');
    $routes->get('iklanutama/edit/(:num)', 'admin\IklanUtamaController::edit/$1');
    $routes->post('iklanutama/proses_edit/(:num)', 'admin\IklanUtamaController::proses_edit/$1');
    $routes->get('iklanutama/delete/(:any)', 'admin\IklanUtamaController::delete/$1');

    // IKLAN KONTEN
    $routes->get('daftariklankonten', 'admin\IklanController::index');
    $routes->get('daftariklankonten/tambah', 'admin\IklanController::tambah_artikel_iklan');
    $routes->post('daftariklankonten/proses_tambah', 'admin\IklanController::proses_tambah');
    $routes->get('daftariklankonten/edit/(:num)', 'admin\IklanController::edit/$1');
    $routes->get('daftariklankonten/detail/(:num)', 'admin\IklanController::detail/$1');

    // Saldo
    $routes->get('saldo', 'admin\Komisi::saldo/$1');
    $routes->get('saldo/penarikan', 'admin\Komisi::penarikan');
    $routes->post('saldo/proses_penarikan', 'admin\Komisi::proses_penarikan');
    $routes->get('saldo/permintaan', 'admin\Komisi::permintaan');
    $routes->post('saldo/ubahstatus', 'admin\Komisi::ubahstatus');

    // Artikel
    $routes->get('artikel/index', 'admin\Artikel::index');  // Artikel Penulis
    $routes->get('artikel/tambah', 'penulis\Artikel::tambah');
    $routes->post('artikel/proses_tambah', 'penulis\Artikel::proses_tambah');
    $routes->get('artikel/edit/(:num)', 'penulis\Artikel::edit/$1');
    $routes->post('artikel/proses_edit/(:num)', 'penulis\Artikel::proses_edit/$1');
    $routes->get('artikel/delete/(:any)', 'penulis\Artikel::delete/$1');

    // Kategori Artikel
    $routes->get('kategori/index', 'admin\Kategori::index');
    $routes->get('kategori/tambah', 'admin\Kategori::tambah');
    $routes->post('kategori/proses_tambah', 'admin\Kategori::proses_tambah');
    $routes->get('kategori/edit/(:num)', 'admin\Kategori::edit/$1');
    $routes->post('kategori/proses_edit/(:num)', 'admin\Kategori::proses_edit/$1');
    $routes->get('kategori/delete/(:any)', 'admin\Kategori::delete/$1');

    // TEMPAT WISATA
    $routes->get('tempat_wisata/index', 'admin\TempatWisata::index');
    $routes->get('tempat_wisata/tambah', 'admin\TempatWisata::tambah');
    $routes->post('tempat_wisata/proses_tambah', 'admin\TempatWisata::proses_tambah');
    $routes->get('tempat_wisata/edit/(:num)', 'admin\TempatWisata::edit/$1');
    $routes->post('tempat_wisata/proses_edit/(:num)', 'admin\TempatWisata::proses_edit/$1');
    $routes->get('tempat_wisata/detail/(:num)', 'admin\TempatWisata::detail/$1');
    $routes->get('tempat_wisata/delete/(:num)', 'admin\TempatWisata::delete/$1');

    // KATEGORI WISATA
    $routes->get('kategori_wisata/index', 'admin\KategoriWisata::index');
    $routes->get('kategori_wisata/tambah', 'admin\KategoriWisata::tambah');
    $routes->post('kategori_wisata/proses_tambah', 'admin\KategoriWisata::proses_tambah');
    $routes->get('kategori_wisata/edit/(:num)', 'admin\KategoriWisata::edit/$1');
    $routes->post('kategori_wisata/proses_edit/(:num)', 'admin\KategoriWisata::proses_edit/$1');
    $routes->get('kategori_wisata/delete/(:any)', 'admin\KategoriWisata::delete/$1');

    // OLEH OLEJ
    $routes->get('oleh_oleh/index', 'admin\OlehOleh::index');
    $routes->get('oleh_oleh/tambah', 'admin\OlehOleh::tambah');
    $routes->post('oleh_oleh/proses_tambah', 'admin\OlehOleh::proses_tambah');
    $routes->get('oleh_oleh/edit/(:num)', 'admin\OlehOleh::edit/$1');
    $routes->get('oleh_oleh/detail/(:segment)', 'admin\OlehOleh::detail/$1');
    $routes->post('oleh_oleh/proses_edit/(:num)', 'admin\OlehOleh::proses_edit/$1');
    $routes->get('oleh_oleh/delete/(:num)', 'admin\OlehOleh::delete/$1');

    // KATEGORI OLEH OLEH
    $routes->get('kategori_oleholeh/index', 'admin\KategoriOlehOleh::index');
    $routes->get('kategori_oleholeh/tambah', 'admin\KategoriOlehOleh::tambah');
    $routes->post('kategori_oleholeh/proses_tambah', 'admin\KategoriOlehOleh::proses_tambah');
    $routes->get('kategori_oleholeh/edit/(:num)', 'admin\KategoriOlehOleh::edit/$1');
    $routes->post('kategori_oleholeh/proses_edit/(:num)', 'admin\KategoriOlehOleh::proses_edit/$1');
    $routes->get('kategori_oleholeh/delete/(:num)', 'admin\KategoriOlehOleh::delete/$1');
});

$routes->group('penulis', ['filter' => 'rolecheck:penulis'], function ($routes) {

    $routes->get('dashboard', 'penulis\Dashboard::index');
    $routes->get('artikel/index', 'admin\Artikel::index');
    $routes->get('artikel/detail/(:num)/(:any)', 'admin\Artikel::viewArtikel/$1/$2');
    $routes->get('artikel/tambah', 'admin\Artikel::tambah');
    $routes->post('artikel/proses_tambah', 'admin\Artikel::proses_tambah');
    $routes->get('artikel/edit/(:num)', 'admin\Artikel::edit/$1');
    $routes->post('artikel/proses_edit/(:num)', 'admin\Artikel::proses_edit/$1');
    $routes->get('artikel/delete/(:any)', 'admin\Artikel::delete/$1');

    $routes->get('saldo', 'admin\Komisi::saldo/$1');
    $routes->get('saldo/penarikan', 'admin\Komisi::penarikan');
    $routes->post('saldo/proses_penarikan', 'admin\Komisi::proses_penarikan');
    $routes->get('saldo/permintaan', 'admin\Komisi::permintaan');
    $routes->post('saldo/ubahstatus', 'admin\Komisi::ubahstatus');

    // IKLAN KONTEN
    $routes->get('daftariklankonten', 'admin\IklanController::index');
    $routes->get('daftariklankonten/tambah', 'admin\IklanController::tambah_artikel_iklan');
    $routes->post('daftariklankonten/proses_tambah', 'admin\IklanController::proses_tambah');
    $routes->get('daftariklankonten/edit/(:num)', 'admin\IklanController::edit/$1');
    $routes->get('daftariklankonten/detail/(:num)', 'admin\IklanController::detail/$1');
});



$routes->get('oleholeh/whatsapp-click/(:num)', 'OlehOleh::countWhatsappClick/$1');


// Define routes for Indonesian language
$routes->group('id', function ($routes) {
    $routes->get('tentang', 'user\Tentangctrl::index');

    // start front end routes

    $routes->get('/', 'user\Homectrl::index');
    $routes->get('ajax/load-data', 'user\Homectrl::loadAjaxData');


    // route halaman ebook
    $routes->get('/ebook', 'user\Ebookctrl::index');
    $routes->get('/ebook/detail/(:any)', 'user\Ebookctrl::viewEbook/$1');

    // route halaman penulis
    $routes->get('/penulis', 'user\Penulisctrl::index');
    $routes->get('/penulis/detail/(:any)', 'user\Penulisctrl::viewPenulis/$1');
    $routes->get('/penulis/artikel_penulis/(:any)', 'user\Penulisctrl::artikelPenulis/$1');

    // route halaman tentang

    $routes->get('wisata', 'Wisata::index');
    $routes->get('wisata/(:segment)', 'Wisata::kategoriWisata/$1');
    $routes->get('wisata/(:segment)/(:segment)', 'Wisata::detail/$1/$2');

    $routes->get('oleh-oleh', 'OlehOleh::index');
    $routes->get('oleh-oleh/(:segment)', 'OlehOleh::kategoriOleh/$1');
    $routes->get('oleh-oleh/(:segment)/(:segment)', 'OlehOleh::detail/$1/$2');

    $routes->get('lang/(:segment)', 'user\Homectrl::language/$1');

    $routes->get('api/wisata', 'User\WisataController::index');

    $routes->get('cari', 'user\Searchctrl::search');
    $routes->get('tag', 'user\Searchctrl::searchByTag');


    $routes->get('artikel', 'user\Artikelctrl::semuaArtikel');
    $routes->get('artikel/(:segment)', 'user\Artikelctrl::index/$1');
    $routes->get('artikel/(:segment)/(:segment)', 'user\Homectrl::viewArtikel/$1/$2');

    // If using tags for search




    $routes->get('ajax/load-data', 'User\Homectrl::loadAjaxData');

    $routes->get('popup', 'user\PopupController::index');

    $routes->get('sitemap', 'user\Sitemapctrl::');
    $routes->get('sitemap.xml', 'user\Sitemapcontroller::generate');
    $routes->get('(:segment)', 'ContentController::index');
    $routes->get('(:segment)/(:segment)', 'ContentController::category');
    $routes->get('(:segment)/(:segment)/(:segment)', 'ContentController::detail');
});




// Define routes for English language
$routes->group('en', function ($routes) {
    // start front end routes
    $routes->get('/', 'user\Homectrl::index');
    $routes->get('ajax/load-data', 'user\Homectrl::loadAjaxData');

    // route ebook page
    $routes->get('/ebook', 'user\Ebookctrl::index');
    $routes->get('/ebook/detail/(:any)', 'user\Ebookctrl::viewEbook/$1');

    // route author page
    $routes->get('/penulis', 'user\Penulisctrl::index');
    $routes->get('/penulis/detail/(:any)', 'user\Penulisctrl::viewPenulis/$1');
    $routes->get('/penulis/artikel_penulis/(:any)', 'user\Penulisctrl::artikelPenulis/$1');

    $routes->get('about', 'user\Tentangctrl::index');

    $routes->get('search', 'user\Searchctrl::search');
    $routes->get('tag', 'user\Artikelctrl::searchByTag');

    $routes->get('article', 'user\Artikelctrl::semuaArtikel');
    $routes->get('article/(:segment)', 'user\Artikelctrl::index/$1');
    $routes->get('article/(:segment)/(:segment)', 'user\Homectrl::viewArtikel/$1/$2');

    $routes->get('destinations', 'Wisata::index');
    $routes->get('destinations/(:segment)', 'Wisata::kategoriWisata/$1');
    $routes->get('destinations/(:segment)/(:segment)', 'Wisata::detail/$1/$2');

    $routes->get('nature-tourism/(:any)', 'Wisata::kategoriWisata/$1');
    $routes->get('nature-tourism', 'Wisata::kategoriWisata');

    $routes->get('souvenirs', 'OlehOleh::index');
    $routes->get('souvenirs/(:segment)', 'OlehOleh::kategoriOleh/$1');
    $routes->get('souvenirs/(:segment)/(:segment)', 'OlehOleh::detail/$1/$2');

    $routes->get('lang/(:segment)', 'user\Homectrl::language/$1');

    $routes->get('api/wisata', 'User\WisataController::index');


    $routes->get('popup', 'user\PopupController::index');




    $routes->get('ajax/load-data', 'User\Homectrl::loadAjaxData');

    $routes->get('sitemap', 'user\Sitemapctrl::index');
    $routes->get('sitemap.xml', 'user\Sitemapcontroller::generate');

    $routes->addRedirect('natural-tourism/(:any)', 'nature-tourism/$1');
    $routes->addRedirect('natural-tourism', 'nature-tourism');
    $routes->get('(:segment)', 'ContentController::index');
    $routes->get('(:segment)/(:segment)', 'ContentController::category');
    $routes->get('(:segment)/(:segment)/(:segment)', 'ContentController::detail');
});



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
