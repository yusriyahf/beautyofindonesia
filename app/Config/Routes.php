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
$routes->get('login', 'Login::index');
$routes->post('login/process', 'Login::process');
$routes->get('logout', 'Login::logout');

// Daftarkan rute-rute admin di sini


$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'admin\Dashboardctrl::index');

    $routes->get('popup', 'admin\Popup::index');
    $routes->get('popup/tambah', 'admin\Popup::tambah');
    $routes->post('popup/proses_tambah', 'admin\Popup::proses_tambah');
    $routes->get('popup/edit/(:num)', 'admin\Popup::edit/$1');
    $routes->post('popup/proses_edit/(:num)', 'admin\Popup::proses_edit/$1');
    $routes->get('popup/delete/(:any)', 'admin\Popup::delete/$1');

    $routes->get('tampilpopup', 'admin\TampilPopup::index');
    $routes->get('tampilpopup/tambah', 'admin\TampilPopup::tambah');
    $routes->post('tampilpopup/proses_tambah', 'admin\TampilPopup::proses_tambah');
    $routes->get('tampilpopup/edit/(:num)', 'admin\TampilPopup::edit/$1');
    $routes->post('tampilpopup/proses_edit/(:num)', 'admin\TampilPopup::proses_edit/$1');
    $routes->get('tampilpopup/delete/(:any)', 'admin\TampilPopup::delete/$1');

    $routes->get('kategori/index', 'admin\Kategori::index');
    $routes->get('kategori/tambah', 'admin\Kategori::tambah');
    $routes->post('kategori/proses_tambah', 'admin\Kategori::proses_tambah');
    $routes->get('kategori/edit/(:num)', 'admin\Kategori::edit/$1');
    $routes->post('kategori/proses_edit/(:num)', 'admin\Kategori::proses_edit/$1');
    $routes->get('kategori/delete/(:any)', 'admin\Kategori::delete/$1');

    $routes->get('meta/index', 'admin\MetaController::index');
    $routes->get('meta/tambah', 'admin\MetaController::tambah');
    $routes->post('meta/proses_tambah', 'admin\MetaController::proses_tambah');
    $routes->get('meta/edit/(:num)', 'admin\MetaController::edit/$1');
    $routes->post('meta/proses_edit/(:num)', 'admin\MetaController::proses_edit/$1');
    $routes->get('meta/delete/(:any)', 'admin\MetaController::delete/$1');

    $routes->get('artikel/index', 'admin\Artikel::index');
    $routes->get('artikel/detail/(:num)/(:any)', 'admin\Artikel::viewArtikel/$1/$2');
    $routes->get('artikel/tambah', 'admin\Artikel::tambah');
    $routes->post('artikel/proses_tambah', 'admin\Artikel::proses_tambah');
    $routes->get('/artikel/edit/(:num)', 'admin\Artikel::edit/$1');
    $routes->post('artikel/proses_edit/(:num)', 'admin\Artikel::proses_edit/$1');
    $routes->get('artikel/delete/(:any)', 'admin\Artikel::delete/$1');

    $routes->get('penulis/index', 'admin\Penulis::index');
    $routes->get('penulis/tambah', 'admin\Penulis::tambah');
    $routes->post('penulis/proses_tambah', 'admin\Penulis::proses_tambah');
    $routes->get('/penulis/edit/(:num)', 'admin\Penulis::edit/$1');
    $routes->post('penulis/proses_edit/(:num)', 'admin\Penulis::proses_edit/$1');
    $routes->get('penulis/delete/(:any)', 'admin\Penulis::delete/$1');

    $routes->get('/tentang/edit', 'admin\Tentang::edit');
    $routes->post('tentang/edit', 'admin\Tentang::edit');

    $routes->get('wisata/index', 'admin\Wisata::index');
    $routes->get('wisata/tambah', 'admin\Wisata::tambah');
    $routes->post('wisata/proses_tambah', 'admin\Wisata::proses_tambah');
    $routes->get('wisata/edit/(:num)', 'admin\Wisata::edit/$1');
    $routes->post('wisata/proses_edit/(:num)', 'admin\Wisata::proses_edit/$1');
    $routes->get('wisata/delete/(:any)', 'admin\Wisata::delete/$1');

    $routes->get('provinsi/index', 'admin\Provinsi::index');
    $routes->get('provinsi/tambah', 'admin\Provinsi::tambah');
    $routes->post('provinsi/proses_tambah', 'admin\Provinsi::proses_tambah');
    $routes->get('provinsi/edit/(:num)', 'admin\Provinsi::edit/$1');
    $routes->post('provinsi/proses_edit/(:num)', 'admin\Provinsi::proses_edit/$1');
    $routes->get('provinsi/delete/(:any)', 'admin\Provinsi::delete/$1');

    $routes->get('kabupaten/index', 'admin\Kabupaten::index');
    $routes->get('kabupaten/tambah', 'admin\Kabupaten::tambah');
    $routes->post('kabupaten/proses_tambah', 'admin\Kabupaten::proses_tambah');
    $routes->get('kabupaten/edit/(:num)', 'admin\Kabupaten::edit/$1');
    $routes->post('kabupaten/proses_edit/(:num)', 'admin\Kabupaten::proses_edit/$1');
    $routes->get('kabupaten/delete/(:any)', 'admin\Kabupaten::delete/$1');

    $routes->get('kategori_wisata/index', 'admin\KategoriWisata::index');
    $routes->get('kategori_wisata/tambah', 'admin\KategoriWisata::tambah');
    $routes->post('kategori_wisata/proses_tambah', 'admin\KategoriWisata::proses_tambah');
    $routes->get('kategori_wisata/edit/(:num)', 'admin\KategoriWisata::edit/$1');
    $routes->post('kategori_wisata/proses_edit/(:num)', 'admin\KategoriWisata::proses_edit/$1');
    $routes->get('kategori_wisata/delete/(:any)', 'admin\KategoriWisata::delete/$1');

    $routes->get('kategori_oleholeh/index', 'admin\KategoriOlehOleh::index');
    $routes->get('kategori_oleholeh/tambah', 'admin\KategoriOlehOleh::tambah');
    $routes->post('kategori_oleholeh/proses_tambah', 'admin\KategoriOlehOleh::proses_tambah');
    $routes->get('kategori_oleholeh/edit/(:num)', 'admin\KategoriOlehOleh::edit/$1');
    $routes->post('kategori_oleholeh/proses_edit/(:num)', 'admin\KategoriOlehOleh::proses_edit/$1');
    $routes->get('kategori_oleholeh/delete/(:num)', 'admin\KategoriOlehOleh::delete/$1');

    $routes->get('tempat_wisata/index', 'admin\TempatWisata::index');
    $routes->get('tempat_wisata/tambah', 'admin\TempatWisata::tambah');
    $routes->post('tempat_wisata/proses_tambah', 'admin\TempatWisata::proses_tambah');
    $routes->get('tempat_wisata/edit/(:num)', 'admin\TempatWisata::edit/$1');
    $routes->post('tempat_wisata/proses_edit/(:num)', 'admin\TempatWisata::proses_edit/$1');
    $routes->get('tempat_wisata/delete/(:num)', 'admin\TempatWisata::delete/$1');

    $routes->get('oleh_oleh/index', 'admin\OlehOleh::index');
    $routes->get('oleh_oleh/tambah', 'admin\OlehOleh::tambah');
    $routes->post('oleh_oleh/proses_tambah', 'admin\OlehOleh::proses_tambah');
    $routes->get('oleh_oleh/edit/(:num)', 'admin\OlehOleh::edit/$1');
    $routes->post('oleh_oleh/proses_edit/(:num)', 'admin\OlehOleh::proses_edit/$1');
    $routes->get('oleh_oleh/delete/(:num)', 'admin\OlehOleh::delete/$1');
});



$routes->set404Override('App\Controllers\user\Homectrl::notFound');

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
