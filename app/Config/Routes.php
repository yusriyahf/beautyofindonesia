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
$routes->post('registrasi/process', 'RegistrasiController::process');
$routes->get('login', 'Login::index');

$routes->post('login/process', 'Login::process');
$routes->get('logout', 'Login::logout');

$routes->get('Admin/acc/(:num)', 'AdminController::accPengajuan/$1');
$routes->get('Admin/tolak/(:num)', 'AdminController::tolakPengajuan/$1');
$routes->get('Admin/prosesuser', 'AdminController::index');
// Daftarkan rute-rute admin di sini
$routes->get('sitemap.xml', 'Sitemap::index');
$routes->get('iklan-klik/(:num)', 'IklanUtamaController::klik/$1');
$routes->get('oleholeh/whatsapp-click/(:num)', 'OlehOleh::countWhatsappClick/$1');


$routes->group('admin', ['filter' => 'rolecheck:admin'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Admin\Dashboardctrl::index');
    $routes->get('update-status-iklan', 'Admin\ArtikelIklan::updateStatusIklan');

    $routes->get('saldo', 'Admin\Komisi::saldo/$1');
    $routes->get('saldo/penarikan', 'Admin\Komisi::penarikan');
    $routes->post('saldo/proses_penarikan', 'Admin\Komisi::proses_penarikan');
    $routes->get('saldo/permintaan', 'Admin\Komisi::permintaan');
    $routes->post('saldo/ubahstatus', 'Admin\Komisi::ubahstatus');
    $routes->post('saldo/tolakstatus', 'Admin\Komisi::tolakstatus');

    // Users
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/tambah', 'Admin\Users::tambah');
    $routes->post('users/proses_tambah', 'Admin\Users::proses_tambah');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/proses_edit/(:num)', 'Admin\Users::proses_edit/$1');
    $routes->get('users/delete/(:any)', 'Admin\Users::delete/$1');

    // Acc User Req
    $routes->get('userRequest', 'Admin\AccUserController::index');
    $routes->post('userRequest/approve/(:num)', 'Admin\AccUserController::approve/$1');
    $routes->post('userRequest/reject/(:num)', 'Admin\AccUserController::reject/$1');


    $routes->get('komisi', 'Admin\Komisi::index');
    $routes->get('komisi/tambah', 'Admin\Komisi::tambah');
    $routes->post('komisi/proses_tambah', 'Admin\Komisi::proses_tambah');
    $routes->get('komisi/edit/(:num)', 'Admin\Komisi::edit/$1');
    $routes->post('komisi/proses_edit/(:num)', 'Admin\Komisi::proses_edit/$1');
    $routes->get('komisi/delete/(:any)', 'Admin\Komisi::delete/$1');

    // Popup
    $routes->get('popup', 'Admin\Popup::index');
    $routes->get('popup/tambah', 'Admin\Popup::tambah');
    $routes->post('popup/proses_tambah', 'Admin\Popup::proses_tambah');
    $routes->get('popup/edit/(:num)', 'Admin\Popup::edit/$1');
    $routes->post('popup/proses_edit/(:num)', 'Admin\Popup::proses_edit/$1');
    $routes->get('popup/delete/(:any)', 'Admin\Popup::delete/$1');

    // Kategori Artikel
    $routes->get('kategori/index', 'Admin\Kategori::index');
    $routes->get('kategori/tambah', 'Admin\Kategori::tambah');
    $routes->post('kategori/proses_tambah', 'Admin\Kategori::proses_tambah');
    $routes->get('kategori/edit/(:num)', 'Admin\Kategori::edit/$1');
    $routes->post('kategori/proses_edit/(:num)', 'Admin\Kategori::proses_edit/$1');
    $routes->get('kategori/delete/(:any)', 'Admin\Kategori::delete/$1');

    // Meta
    $routes->get('meta/index', 'Admin\MetaController::index');
    $routes->get('meta/tambah', 'Admin\MetaController::tambah');
    $routes->post('meta/proses_tambah', 'Admin\MetaController::proses_tambah');
    $routes->get('meta/edit/(:num)', 'Admin\MetaController::edit/$1');
    $routes->post('meta/proses_edit/(:num)', 'Admin\MetaController::proses_edit/$1');
    $routes->get('meta/delete/(:any)', 'Admin\MetaController::delete/$1');

    // Artikel
    $routes->get('artikel/index', 'Admin\Artikel::index');
    $routes->get('artikel/tambah', 'Admin\Artikel::tambah');
    $routes->get('artikel/detail/(:num)/(:any)', 'Admin\Artikel::viewArtikel/$1/$2');
    $routes->post('artikel/proses_tambah', 'Admin\Artikel::proses_tambah');
    $routes->get('artikel/edit/(:num)', 'Admin\Artikel::edit/$1');
    $routes->post('artikel/proses_edit/(:num)', 'Admin\Artikel::proses_edit/$1');
    $routes->get('artikel/delete/(:any)', 'Admin\Artikel::delete/$1');

    // Daftar Penulis
    $routes->get('penulis/index', 'Admin\Penulis::index');
    $routes->get('penulis/tambah', 'Admin\Penulis::tambah');
    $routes->post('penulis/proses_tambah', 'Admin\Penulis::proses_tambah');
    $routes->get('penulis/edit/(:num)', 'Admin\Penulis::edit/$1');
    $routes->post('penulis/proses_edit/(:num)', 'Admin\Penulis::proses_edit/$1');
    $routes->get('penulis/delete/(:any)', 'Admin\Penulis::delete/$1');

    // Profil Perusahaan
    $routes->get('tentang/edit', 'Admin\Tentang::edit');
    $routes->post('tentang/edit', 'Admin\Tentang::edit');

    // Provinsi
    $routes->get('provinsi/index', 'Admin\Provinsi::index');
    $routes->get('provinsi/tambah', 'Admin\Provinsi::tambah');
    $routes->post('provinsi/proses_tambah', 'Admin\Provinsi::proses_tambah');
    $routes->get('provinsi/edit/(:num)', 'Admin\Provinsi::edit/$1');
    $routes->post('provinsi/proses_edit/(:num)', 'Admin\Provinsi::proses_edit/$1');
    $routes->get('provinsi/delete/(:any)', 'Admin\Provinsi::delete/$1');

    // Kabupaten
    $routes->get('kabupaten/index', 'Admin\Kabupaten::index');
    $routes->get('kabupaten/tambah', 'Admin\Kabupaten::tambah');
    $routes->post('kabupaten/proses_tambah', 'Admin\Kabupaten::proses_tambah');
    $routes->get('kabupaten/edit/(:num)', 'Admin\Kabupaten::edit/$1');
    $routes->post('kabupaten/proses_edit/(:num)', 'Admin\Kabupaten::proses_edit/$1');
    $routes->get('kabupaten/delete/(:any)', 'Admin\Kabupaten::delete/$1');

    // Kategori Wisata
    $routes->get('kategori_wisata/index', 'Admin\KategoriWisata::index');
    $routes->get('kategori_wisata/tambah', 'Admin\KategoriWisata::tambah');
    $routes->post('kategori_wisata/proses_tambah', 'Admin\KategoriWisata::proses_tambah');
    $routes->get('kategori_wisata/edit/(:num)', 'Admin\KategoriWisata::edit/$1');
    $routes->post('kategori_wisata/proses_edit/(:num)', 'Admin\KategoriWisata::proses_edit/$1');
    $routes->get('kategori_wisata/delete/(:any)', 'Admin\KategoriWisata::delete/$1');

    // Kategori Oleh Oleh
    $routes->get('kategori_oleholeh/index', 'Admin\KategoriOlehOleh::index');
    $routes->get('kategori_oleholeh/tambah', 'Admin\KategoriOlehOleh::tambah');
    $routes->post('kategori_oleholeh/proses_tambah', 'Admin\KategoriOlehOleh::proses_tambah');
    $routes->get('kategori_oleholeh/edit/(:num)', 'Admin\KategoriOlehOleh::edit/$1');
    $routes->post('kategori_oleholeh/proses_edit/(:num)', 'Admin\KategoriOlehOleh::proses_edit/$1');
    $routes->get('kategori_oleholeh/delete/(:num)', 'Admin\KategoriOlehOleh::delete/$1');

    // Tempat Wisata
    $routes->get('tempat_wisata/index', 'Admin\TempatWisata::index');
    $routes->get('tempat_wisata/tambah', 'Admin\TempatWisata::tambah');
    $routes->post('tempat_wisata/proses_tambah', 'Admin\TempatWisata::proses_tambah');
    $routes->get('tempat_wisata/edit/(:num)', 'Admin\TempatWisata::edit/$1');
    $routes->post('tempat_wisata/proses_edit/(:num)', 'Admin\TempatWisata::proses_edit/$1');
    $routes->get('tempat_wisata/detail/(:num)', 'Admin\TempatWisata::detail/$1');
    $routes->get('tempat_wisata/delete/(:num)', 'Admin\TempatWisata::delete/$1');

    // Oleh Oleh
    $routes->get('oleh_oleh/index', 'Admin\OlehOleh::index');
    $routes->get('oleh_oleh/tambah', 'Admin\OlehOleh::tambah');
    $routes->post('oleh_oleh/proses_tambah', 'Admin\OlehOleh::proses_tambah');
    $routes->get('oleh_oleh/edit/(:num)', 'Admin\OlehOleh::edit/$1');
    $routes->get('oleh_oleh/detail/(:segment)', 'Admin\OlehOleh::detail/$1');
    $routes->post('oleh_oleh/proses_edit/(:num)', 'Admin\OlehOleh::proses_edit/$1');
    $routes->get('oleh_oleh/delete/(:num)', 'Admin\OlehOleh::delete/$1');
    $routes->post('oleh_oleh/increment-whatsapp/(:num)', 'Admin\OlehOleh::incrementWhatsapp/$1');

    // Profil Pengguna
    $routes->get('profile/index', 'Admin\Profile::index');
    $routes->get('profile/edit/(:num)', 'Admin\Profile::edit/$1');
    $routes->post('profile/update/(:num)', 'Admin\Profile::update/$1');
    $routes->post('profile/update-photo/(:num)', 'Admin\Profile::update_photo/$1');
    $routes->post('profile/update-password', 'Admin\Profile::updatePassword');


    // IKLAN UTAMA
    $routes->get('acciklanutama', 'Admin\IklanUtamaController::index2');
    $routes->post('acciklanutama/tolakiklan', 'Admin\IklanUtamaController::tolakIklan');
    $routes->post('acciklanutama/ubahStatus', 'Admin\IklanUtamaController::ubahStatus');
    // Daftar Iklan Utama
    $routes->get('iklanutama', 'Admin\IklanUtamaController::index');
    $routes->get('iklanutama/tambah', 'Admin\IklanUtamaController::tambah');
    $routes->post('iklanutama/proses_tambah', 'Admin\IklanUtamaController::proses_tambah');
    // tipe iklan utama
    $routes->get('tipeiklanutama', 'Admin\TipeIklanUtama::index');
    $routes->get('tipeiklanutama/tambah', 'Admin\TipeIklanUtama::tambah');
    $routes->post('tipeiklanutama/proses_tambah', 'Admin\TipeIklanUtama::proses_tambah');
    $routes->get('tipeiklanutama/edit/(:num)', 'Admin\TipeIklanUtama::edit/$1');
    $routes->post('tipeiklanutama/proses_edit/(:num)', 'Admin\TipeIklanUtama::update/$1');
    $routes->get('tipeiklanutama/delete/(:num)', 'Admin\TipeIklanUtama::delete/$1');

    // IKLAN KONTEN
    $routes->get('daftariklankonten', 'Admin\IklanController::index');
    $routes->get('daftariklankonten/tambah', 'Admin\IklanController::tambah_artikel_iklan');
    $routes->post('daftariklankonten/proses_tambah', 'Admin\IklanController::proses_tambah');
    $routes->get('daftariklankonten/edit/(:num)', 'Admin\IklanController::edit/$1');
    $routes->get('daftariklankonten/detail/(:num)', 'Admin\IklanController::detail/$1');
    $routes->post('daftariklankonten/delete/(:num)', 'Admin\IklanController::delete/$1');
    $routes->get('acciklankonten', 'Admin\ArtikelIklan::index');
    $routes->post('acciklankonten/ubahstatus', 'Admin\ArtikelIklan::ubahStatus');
    $routes->post('acciklankonten/tolakiklan', 'Admin\ArtikelIklan::tolakIklan');

    // komisi dan riwayat komisi
    $routes->get('riwayatkomisi', 'Admin\PersenKomisiController::index');
    $routes->post('riwayatkomisi/tambah_default', 'Admin\PersenKomisiController::tambah_default');
    $routes->post('riwayatkomisi/update_default/(:num)', 'Admin\PersenKomisiController::update_default/$1');
    $routes->post('riwayatkomisi/delete_default/(:num)', 'Admin\PersenKomisiController::delete_default/$1');
    $routes->post('riwayatkomisi/tambah_custom', 'Admin\PersenKomisiController::tambah_custom');
    $routes->post('riwayatkomisi/delete_custom/(:num)', 'Admin\PersenKomisiController::delete_custom/$1');
    $routes->get('riwayatkomisi/get_detail_custom/(:num)', 'Admin\PersenKomisiController::get_detail_custom/$1');
});

$routes->group('penulis', ['filter' => 'rolecheck:penulis'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Penulis\Dashboard::index');

    // Artikel Penulis
    $routes->get('artikel/index', 'Admin\Artikel::index');  // Artikel Penulis
    $routes->get('artikel/tambah', 'Admin\Artikel::tambah');
    $routes->get('artikel/detail/(:num)/(:any)', 'Admin\Artikel::viewArtikel/$1/$2');
    $routes->post('artikel/proses_tambah', 'Admin\Artikel::proses_tambah');
    $routes->get('artikel/edit/(:num)', 'Admin\Artikel::edit/$1');
    $routes->post('artikel/proses_edit/(:num)', 'Admin\Artikel::proses_edit/$1');
    $routes->get('artikel/delete/(:any)', 'Admin\Artikel::delete/$1');

    // Kategori Artikel
    $routes->get('kategori/index', 'Admin\Kategori::index');
    $routes->get('kategori/tambah', 'Admin\Kategori::tambah');
    $routes->post('kategori/proses_tambah', 'Admin\Kategori::proses_tambah');
    $routes->get('kategori/edit/(:num)', 'Admin\Kategori::edit/$1');
    $routes->post('kategori/proses_edit/(:num)', 'Admin\Kategori::proses_edit/$1');
    $routes->get('kategori/delete/(:any)', 'Admin\Kategori::delete/$1');

    // TEMPAT WISATA
    $routes->get('tempat_wisata/index', 'Admin\TempatWisata::index');
    $routes->get('tempat_wisata/tambah', 'Admin\TempatWisata::tambah');
    $routes->post('tempat_wisata/proses_tambah', 'Admin\TempatWisata::proses_tambah');
    $routes->get('tempat_wisata/edit/(:num)', 'Admin\TempatWisata::edit/$1');
    $routes->post('tempat_wisata/proses_edit/(:num)', 'Admin\TempatWisata::proses_edit/$1');
    $routes->get('tempat_wisata/detail/(:num)', 'Admin\TempatWisata::detail/$1');
    $routes->get('tempat_wisata/delete/(:num)', 'Admin\TempatWisata::delete/$1');

    // KATEGORI WISATA
    $routes->get('kategori_wisata/index', 'Admin\KategoriWisata::index');
    $routes->get('kategori_wisata/tambah', 'Admin\KategoriWisata::tambah');
    $routes->post('kategori_wisata/proses_tambah', 'Admin\KategoriWisata::proses_tambah');
    $routes->get('kategori_wisata/edit/(:num)', 'Admin\KategoriWisata::edit/$1');
    $routes->post('kategori_wisata/proses_edit/(:num)', 'Admin\KategoriWisata::proses_edit/$1');
    $routes->get('kategori_wisata/delete/(:any)', 'Admin\KategoriWisata::delete/$1');

    // OLEH OLEJ
    $routes->get('oleh_oleh/index', 'Admin\OlehOleh::index');
    $routes->get('oleh_oleh/tambah', 'Admin\OlehOleh::tambah');
    $routes->post('oleh_oleh/proses_tambah', 'Admin\OlehOleh::proses_tambah');
    $routes->get('oleh_oleh/edit/(:num)', 'Admin\OlehOleh::edit/$1');
    $routes->get('oleh_oleh/detail/(:segment)', 'Admin\OlehOleh::detail/$1');
    $routes->post('oleh_oleh/proses_edit/(:num)', 'Admin\OlehOleh::proses_edit/$1');
    $routes->get('oleh_oleh/delete/(:num)', 'Admin\OlehOleh::delete/$1');

    // KATEGORI OLEH OLEH
    $routes->get('kategori_oleholeh/index', 'Admin\KategoriOlehOleh::index');
    $routes->get('kategori_oleholeh/tambah', 'Admin\KategoriOlehOleh::tambah');
    $routes->post('kategori_oleholeh/proses_tambah', 'Admin\KategoriOlehOleh::proses_tambah');
    $routes->get('kategori_oleholeh/edit/(:num)', 'Admin\KategoriOlehOleh::edit/$1');
    $routes->post('kategori_oleholeh/proses_edit/(:num)', 'Admin\KategoriOlehOleh::proses_edit/$1');
    $routes->get('kategori_oleholeh/delete/(:num)', 'Admin\KategoriOlehOleh::delete/$1');

    // Daftar Iklan Utama
    $routes->get('iklanutama', 'Admin\IklanUtamaController::index');

    // Iklan Konten
    $routes->get('daftariklankonten', 'Admin\IklanController::index');

    // saldo
    $routes->get('saldo', 'Admin\Komisi::saldo/$1');
    $routes->get('saldo/penarikan', 'Admin\Komisi::penarikan');
    $routes->post('saldo/proses_penarikan', 'Admin\Komisi::proses_penarikan');

    // Profil Pengguna
    $routes->get('profile/index', 'Admin\Profile::index');
    $routes->get('profile/edit/(:num)', 'Admin\Profile::edit/$1');
    $routes->post('profile/update/(:num)', 'Admin\Profile::update/$1');
    $routes->post('profile/update-password', 'Admin\Profile::updatePassword');
});


$routes->group('marketing', ['filter' => 'rolecheck:marketing'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Marketing\Dashboard::index');

    // Artikel Iklan
    $routes->get('artikeliklan/index', 'Marketing\ArtikelIklan::index');

    $routes->get('iklanutama', 'Admin\IklanUtamaController::index');
    $routes->get('iklanutama/tambah', 'Admin\IklanUtamaController::tambah');
    $routes->post('iklanutama/proses_tambah', 'Admin\IklanUtamaController::proses_tambah');
    $routes->get('iklanutama/edit/(:num)', 'Admin\IklanUtamaController::edit/$1');
    $routes->post('iklanutama/proses_edit/(:num)', 'Admin\IklanUtamaController::proses_edit/$1');
    $routes->get('iklanutama/detail/(:num)', 'Admin\IklanUtamaController::detail/$1');
    $routes->get('iklanutama/delete/(:any)', 'Admin\IklanUtamaController::delete/$1');

    // IKLAN KONTEN
    $routes->get('daftariklankonten', 'Admin\IklanController::index');
    $routes->get('daftariklankonten/tambah', 'Admin\IklanController::tambah_artikel_iklan');
    $routes->post('daftariklankonten/proses_tambah', 'Admin\IklanController::proses_tambah');
    $routes->get('daftariklankonten/edit/(:num)', 'Admin\IklanController::edit/$1');
    $routes->post('daftariklankonten/proses_edit/(:num)', 'Admin\IklanController::proses_edit/$1');
    $routes->get('daftariklankonten/detail/(:num)', 'Admin\IklanController::detail/$1');
    $routes->post('daftariklankonten/delete/(:num)', 'Admin\IklanController::delete/$1');


    // Saldo
    $routes->get('saldo', 'Admin\Komisi::saldo/$1');
    $routes->get('saldo/penarikan', 'Admin\Komisi::penarikan');
    $routes->post('saldo/proses_penarikan', 'Admin\Komisi::proses_penarikan');

    // Artikel
    $routes->get('artikel/index', 'Admin\Artikel::index');  // Artikel Penulis
    $routes->get('artikel/detail/(:num)/(:any)', 'Admin\Artikel::viewArtikel/$1/$2');

    // Kategori Artikel
    $routes->get('kategori/index', 'Admin\Kategori::index');

    // TEMPAT WISATA
    $routes->get('tempat_wisata/index', 'Admin\TempatWisata::index');
    $routes->get('tempat_wisata/detail/(:num)', 'Admin\TempatWisata::detail/$1');

    // KATEGORI WISATA
    $routes->get('kategori_wisata/index', 'Admin\KategoriWisata::index');

    // OLEH OLEJ
    $routes->get('oleh_oleh/index', 'Admin\OlehOleh::index');
    $routes->get('oleh_oleh/detail/(:segment)', 'Admin\OlehOleh::detail/$1');

    // KATEGORI OLEH OLEH
    $routes->get('kategori_oleholeh/index', 'Admin\KategoriOlehOleh::index');

    // Profil Pengguna
    $routes->get('profile/index', 'Admin\Profile::index');
    $routes->get('profile/edit/(:num)', 'Admin\Profile::edit/$1');
    $routes->post('profile/update/(:num)', 'Admin\Profile::update/$1');
    $routes->post('profile/update-password', 'Admin\Profile::updatePassword');

});




// Define routes for Indonesian language
$routes->group('id', function ($routes) {
    $routes->get('tentang', 'User\Tentangctrl::index');

    // start front end routes

    $routes->get('/', 'User\Homectrl::index');
    $routes->get('ajax/load-data', 'User\Homectrl::loadAjaxData');


    // route halaman ebook
    $routes->get('/ebook', 'User\Ebookctrl::index');
    $routes->get('/ebook/detail/(:any)', 'User\Ebookctrl::viewEbook/$1');

    // route halaman penulis
    $routes->get('/penulis', 'User\Penulisctrl::index');
    $routes->get('/penulis/detail/(:any)', 'User\Penulisctrl::viewPenulis/$1');
    $routes->get('/penulis/artikel_penulis/(:any)', 'User\Penulisctrl::artikelPenulis/$1');

    // route halaman tentang

    $routes->get('wisata', 'Wisata::index');
    $routes->get('wisata/(:segment)', 'Wisata::kategoriWisata/$1');
    $routes->get('wisata/(:segment)/(:segment)', 'Wisata::detail/$1/$2');

    $routes->get('oleh-oleh', 'OlehOleh::index');
    $routes->get('oleh-oleh/(:segment)', 'OlehOleh::kategoriOleh/$1');
    $routes->get('oleh-oleh/(:segment)/(:segment)', 'OlehOleh::detail/$1/$2');

    $routes->get('lang/(:segment)', 'User\Homectrl::language/$1');

    $routes->get('api/wisata', 'User\WisataController::index');

    $routes->get('cari', 'User\Searchctrl::search');
    $routes->get('tag', 'User\Searchctrl::searchByTag');


    $routes->get('artikel', 'User\Artikelctrl::semuaArtikel');
    $routes->get('artikel/(:segment)', 'User\Artikelctrl::index/$1');
    $routes->get('artikel/(:segment)/(:segment)', 'User\Homectrl::viewArtikel/$1/$2');

    // If using tags for search




    $routes->get('ajax/load-data', 'User\Homectrl::loadAjaxData');

    $routes->get('popup', 'User\PopupController::index');

    $routes->get('sitemap', 'User\Sitemapctrl::');
    $routes->get('sitemap.xml', 'User\Sitemapcontroller::generate');
    $routes->get('(:segment)', 'ContentController::index');
    $routes->get('(:segment)/(:segment)', 'ContentController::category');
    $routes->get('(:segment)/(:segment)/(:segment)', 'ContentController::detail');
});




// Define routes for English language
$routes->group('en', function ($routes) {
    // start front end routes
    $routes->get('/', 'User\Homectrl::index');
    $routes->get('ajax/load-data', 'User\Homectrl::loadAjaxData');

    // route ebook page
    $routes->get('/ebook', 'User\Ebookctrl::index');
    $routes->get('/ebook/detail/(:any)', 'User\Ebookctrl::viewEbook/$1');

    // route author page
    $routes->get('/penulis', 'User\Penulisctrl::index');
    $routes->get('/penulis/detail/(:any)', 'User\Penulisctrl::viewPenulis/$1');
    $routes->get('/penulis/artikel_penulis/(:any)', 'User\Penulisctrl::artikelPenulis/$1');

    $routes->get('about', 'User\Tentangctrl::index');

    $routes->get('search', 'User\Searchctrl::search');
    $routes->get('tag', 'User\Artikelctrl::searchByTag');

    $routes->get('article', 'User\Artikelctrl::semuaArtikel');
    $routes->get('article/(:segment)', 'User\Artikelctrl::index/$1');
    $routes->get('article/(:segment)/(:segment)', 'User\Homectrl::viewArtikel/$1/$2');

    $routes->get('destinations', 'Wisata::index');
    $routes->get('destinations/(:segment)', 'Wisata::kategoriWisata/$1');
    $routes->get('destinations/(:segment)/(:segment)', 'Wisata::detail/$1/$2');

    $routes->get('nature-tourism/(:any)', 'Wisata::kategoriWisata/$1');
    $routes->get('nature-tourism', 'Wisata::kategoriWisata');

    $routes->get('souvenirs', 'OlehOleh::index');
    $routes->get('souvenirs/(:segment)', 'OlehOleh::kategoriOleh/$1');
    $routes->get('souvenirs/(:segment)/(:segment)', 'OlehOleh::detail/$1/$2');

    $routes->get('lang/(:segment)', 'User\Homectrl::language/$1');

    $routes->get('api/wisata', 'User\WisataController::index');


    $routes->get('popup', 'User\PopupController::index');




    $routes->get('ajax/load-data', 'User\Homectrl::loadAjaxData');

    $routes->get('sitemap', 'User\Sitemapctrl::index');
    $routes->get('sitemap.xml', 'User\Sitemapcontroller::generate');

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
