<!-- Navbar Start -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-light navbar-dark py-2 py-lg-0 px-lg-5">
        <div class="container-fluid">
            <!-- Logo on the left -->
            <a href="/" class="navbar-brand">
                <img src="<?= base_url('assets/images/logoHeader.webp') ?>" alt="Beautyofindonesia logo" style="height: 60px; width: 135px;" class="d-inline-block align-middle">
            </a>

            <!-- Toggler for Sidebar -->
            <button type="button" class="navbar-toggler" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
                <!-- Navbar links and search form aligned to the right (for larger screens) -->
                <ul class="navbar-nav ml-auto py-0 d-none d-lg-flex">
                    <?php
                    // Ambil bahasa yang disimpan di session
                    $lang = session()->get('lang') ?? 'id'; // Default ke 'id' jika tidak ada di session

                    $current_url = uri_string();

                    // Simpan segmen bahasa saat ini
                    $segments = explode('/', trim($current_url, '/'));
                    $lang_segment = $segments[0] . '/'; // Menyimpan 'id/' atau 'en/'


                    // Definisikan tautan untuk setiap halaman berdasarkan bahasa
                    $destinationsLink = ($lang_segment === 'en/') ? 'destinations' : 'wisata';
                    $souvenirsLink = ($lang_segment === 'en/') ? 'souvenirs' : 'oleh-oleh';
                    $articleLink = ($lang_segment === 'en/') ? 'article' : 'artikel';
                    $aboutLink = ($lang_segment === 'en/') ? 'about' : 'tentang';
                    $languageLink = ($lang_segment === 'en/') ? 'language' : 'bahasa';

                    // Buat array untuk menggantikan segmen berdasarkan bahasa
                    $replace_map = [
                        'wisata' => 'destinations',
                        'kategori-wisata' => 'destinations-category',
                        'oleh-oleh' => 'souvenirs',
                        'artikel' => 'article',
                        'tentang' => 'about',
                    ];

                    // Ambil bagian dari URL tanpa segmen bahasa
                    $url_without_lang = substr($current_url, strlen($lang_segment));

                    // Pecah URL menjadi segmen-segmen
                    $url_segments = explode('/', $url_without_lang);

                    // Tentukan bahasa yang ingin digunakan
                    $new_lang_segment = ($lang_segment === 'en/') ? 'id/' : 'en/';

                    // Gantikan hanya segmen kedua dalam URL berdasarkan bahasa yang aktif
                    if (isset($url_segments[0])) {
                        foreach ($replace_map as $indonesian_segment => $english_segment) {
                            if ($lang_segment === 'en/') {
                                // Jika bahasa yang dipilih adalah 'en', maka ganti segmen ID ke EN
                                if ($url_segments[0] === $english_segment) {
                                    $url_segments[0] = $indonesian_segment;
                                }
                            } else {
                                // Jika bahasa yang dipilih adalah 'id', maka ganti segmen EN ke ID
                                if ($url_segments[0] === $indonesian_segment) {
                                    $url_segments[0] = $english_segment;
                                }
                            }
                        }
                    }

                    // Gabungkan kembali URL
                    $url_without_lang = implode('/', $url_segments);

                    // Tautan dengan bahasa yang baru
                    $clean_url = $new_lang_segment . ltrim($url_without_lang, '/');

                    // Cek apakah $clean_url sudah memiliki segmen bahasa yang tepat
                    if (!preg_match('/^(en|id)\//', $clean_url)) {
                        // Jika tidak, tambahkan segmen bahasa yang sesuai di depan
                        $clean_url = $new_lang_segment . ltrim($clean_url, '/');
                    }

                    // Tautan Bahasa Inggris
                    if (strpos($url_without_lang, 'en/') === false) {
                        // Jika tidak ada segmen bahasa Inggris, tambahkan
                        $english_url = base_url('en/' . ltrim($url_without_lang, '/'));
                    } else {
                        // Jika sudah ada segmen bahasa Inggris, gunakan yang ada
                        $english_url = base_url($url_without_lang);
                    }

                    // Tautan Bahasa Indonesia
                    if (strpos($url_without_lang, 'id/') === false) {
                        // Jika tidak ada segmen bahasa Indonesia, tambahkan
                        $indonesia_url = base_url('id/' . ltrim($url_without_lang, '/'));
                    } else {
                        // Jika sudah ada segmen bahasa Indonesia, gunakan yang ada
                        $indonesia_url = base_url($url_without_lang);
                    }

                    $is_indonesian = ($lang === 'id');
                    $is_english = ($lang === 'en');

                    ?>

                    <?php helper('url'); ?>
                    <li class="nav-item">
                        <a href="<?= base_url($lang . '/') ?>" class="nav-link <?= current_url() === base_url('/') ? 'active' : '' ?>"><?php echo lang('Blog.headerHome'); ?></a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="kategoriWisataDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= lang('Blog.headerTour'); ?>
                        </a>
                        <div class="dropdown-menu">
                            <!-- Option for All Destinations -->
                            <a class="dropdown-item" href="<?= base_url($lang === 'en' ? $lang . '/destinations' : $lang . '/wisata') ?>">
                                <?php if (session()->get('lang') === 'en'): ?>
                                    All Destinations
                                <?php else: ?>
                                    Semua Wisata
                                <?php endif; ?>
                            </a>

                            <!-- Loop through categories -->
                            <?php if (!empty($kategoriwisata)): ?>
                                <?php foreach ($kategoriwisata as $row) : ?>
                                    <a class="dropdown-item"
                                        href="<?= base_url($lang === 'en' ? $lang . '/destinations/' . $row->slug_kategori_wisata_en : $lang . '/wisata/' . $row->slug_kategori_wisata) ?>">
                                        <?php if ($lang === 'en'): ?>
                                            <?= esc($row->nama_kategori_wisata_en) ?> <!-- Assuming you have English names -->
                                        <?php else: ?>
                                            <?= esc($row->nama_kategori_wisata) ?>
                                        <?php endif; ?>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="kategoriDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo lang('Blog.headerSouvenir'); ?>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= base_url($lang === 'en' ? $lang . '/souvenirs' : $lang . '/oleh-oleh') ?>">
                                <?php if (session()->get('lang') === 'en'): ?>
                                    All Souvenirs
                                <?php else: ?>
                                    Semua Oleh-Oleh
                                <?php endif; ?>
                            </a>

                            <?php if (!empty($kategoriOlehOleh)): ?>
                                <?php foreach ($kategoriOlehOleh as $row) : ?>
                                    <a class="dropdown-item" href="<?= base_url($lang === 'en' ? $lang . '/souvenirs/' . $row->slug_kategori_oleholeh_en : $lang . '/oleh-oleh/' . $row->slug_kategori_oleholeh) ?>">
                                        <?php if (session()->get('lang') === 'en'): ?>
                                            <?= esc($row->nama_kategori_oleholeh_en) ?>
                                        <?php else: ?>
                                            <?= esc($row->nama_kategori_oleholeh) ?>
                                        <?php endif; ?>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= strpos(current_url(), base_url($lang . '/' . $articleLink)) === 0 || strpos(current_url(), base_url($lang . '/artikel/')) === 0 ? 'active' : '' ?>"
                            href="#" id="kategoriDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo lang('Blog.headerArticel'); ?> <!-- Language key for 'Articles' -->
                        </a>

                        <div class="dropdown-menu">
                            <!-- Add "All Articles" option with language support -->
                            <a class="dropdown-item <?= current_url() === base_url($lang === 'en' ? 'en/article' : 'id/artikel') ? 'active' : '' ?>"
                                href="<?= base_url($lang === 'en' ? 'en/article' : 'id/artikel') ?>">
                                <?php if (session()->get('lang') === 'en'): ?>
                                    All Articles
                                <?php else: ?>
                                    Semua Artikel
                                <?php endif; ?>
                            </a>

                            <?php if (!empty($kategori)): ?>
                                <?php foreach ($kategori as $row) : ?>
                                    <a class="dropdown-item <?= current_url() === base_url($lang . '/artikel/' . $row['slug_kategori']) ? 'active' : '' ?>"
                                        href="<?= base_url($lang === 'en' ? 'en/article/' . $row['slug_kategori_en'] : 'id/artikel/' . $row['slug_kategori']) ?>">
                                        <?php if (session()->get('lang') === 'en'): ?>
                                            <?= esc($row['nama_kategori_en']) ?> <!-- English category name -->
                                        <?php else: ?>
                                            <?= esc($row['nama_kategori']) ?> <!-- Default category name -->
                                        <?php endif; ?>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a href="<?= base_url($lang . '/' . $aboutLink) ?>" class="nav-link <?= current_url() === base_url($lang . '/' . $aboutLink) ? 'active' : '' ?>"><?php echo lang('Blog.headerAbout'); ?></a>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo lang('Blog.headerLanguage'); ?></a>
                        <div class="dropdown-menu m-0">
                            <a href="<?= $is_indonesian ? '#' : $indonesia_url ?>" class="dropdown-item <?= $is_indonesian ? 'disabled' : '' ?>" <?= $is_indonesian ? 'onclick="return false;"' : '' ?>>
                                <img src="<?= base_url('assets-baru/img/in.png') ?>" alt="Indonesia" style="width: 20px; height: 20px; <?= $is_indonesian ? 'filter: grayscale(100%);' : '' ?>" class="mr-2"> Indonesia
                            </a>
                            <a href="<?= $is_english ? '#' : $english_url ?>" class="dropdown-item <?= $is_english ? 'disabled' : '' ?>" <?= $is_english ? 'onclick="return false;"' : '' ?>>
                                <img src="<?= base_url('assets-baru/img/en.png') ?>" alt="English" style="width: 20px; height: 20px; <?= $is_english ? 'filter: grayscale(100%);' : '' ?>" class="mr-2"> English
                            </a>
                        </div>
                    </li>

                </ul>


                <!-- Search form (for larger screens) -->
                <form id="search-form" action="<?= base_url($lang === 'en' ?  'en/search' : '/id/cari') ?>" method="GET" class="d-none d-lg-flex ml-2 d-flex">
                    <div class="input-group search-container">
                        <input type="text" class="form-control border-0 search-input form-control me-2" name="q" placeholder="<?php echo lang('Blog.headerSearch'); ?>">
                        <div class="input-group-append">
                            <button class="input-group-text bg-primary text-dark border-0 px-3" type="submit" aria-label="Cari Produk">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </nav>
</div>



<!-- Sidebar for mobile (hidden by default) -->
<div id="sidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="toggleSidebar()">&times;</a>
    <ul class="navbar-nav">
        <?php
        // Ambil bahasa yang disimpan di session
        $lang = session()->get('lang') ?? 'en'; // Default ke 'en' jika tidak ada di session
        $current_url = uri_string();
        $lang_segment = substr($current_url, 0, strpos($current_url, '/') + 1);

        $tourLink = base_url($lang === 'en' ? $lang . '/destinations' : $lang . '/wisata');
        $souvenirLink = base_url($lang === 'en' ? $lang . '/souvenirs' : $lang . '/oleh-oleh');
        $articleLink = base_url($lang === 'en' ? $lang . '/article' : $lang . '/artikel');
        $aboutLink = base_url($lang === 'en' ? $lang . '/about' : $lang . '/tentang');
        ?>

        <li class="nav-item">
            <a href="<?= base_url($lang . '/') ?>" class="nav-link <?= current_url() === base_url('/') ? 'active' : '' ?>">
                <?= lang('Blog.headerHome') ?>
            </a>
        </li>

        <!-- Destinations Dropdown -->
        <li class="nav-item dropdown">
            <a href="javascript:void(0)" class="nav-link dropdown-toggle" onclick="toggleDropdown('tourDropdown')">
                <?= lang('Blog.headerTour') ?>
            </a>
            <ul id="tourDropdown" class="dropdown-content">
                <li>
                    <a href="<?= $tourLink ?>" class="dropdown-item">
                        <?= $lang === 'en' ? 'All Destinations' : 'Semua Wisata' ?>
                    </a>
                </li>
                <?php if (!empty($kategoriwisata)) : ?>
                    <?php foreach ($kategoriwisata as $row) : ?>
                        <li>
                            <a href="<?= base_url($lang === 'en' ? $lang . '/destinations/' . $row->slug_kategori_wisata_en : $lang . '/wisata/' . $row->slug_kategori_wisata) ?>" class="dropdown-item">
                                <?= $lang === 'en' ? esc($row->nama_kategori_wisata_en) : esc($row->nama_kategori_wisata) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </li>

        <!-- Souvenirs Dropdown -->
        <li class="nav-item dropdown">
            <a href="javascript:void(0)" class="nav-link dropdown-toggle" onclick="toggleDropdown('souvenirDropdown')">
                <?= lang('Blog.headerSouvenir') ?>
            </a>
            <ul id="souvenirDropdown" class="dropdown-content">
                <li>
                    <a href="<?= $souvenirLink ?>" class="dropdown-item">
                        <?= $lang === 'en' ? 'All Souvenirs' : 'Semua Oleh-Oleh' ?>
                    </a>
                </li>
                <?php if (!empty($kategoriOlehOleh)) : ?>
                    <?php foreach ($kategoriOlehOleh as $row) : ?>
                        <li>
                            <a href="<?= base_url($lang === 'en' ? $lang . '/souvenirs/' . $row->slug_kategori_oleholeh_en : $lang . '/oleh-oleh/' . $row->slug_kategori_oleholeh) ?>" class="dropdown-item">
                                <?= $lang === 'en' ? esc($row->nama_kategori_oleholeh_en) : esc($row->nama_kategori_oleholeh) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </li>

        <!-- Articles Dropdown -->
        <li class="nav-item dropdown">
            <a href="javascript:void(0)" class="nav-link dropdown-toggle" onclick="toggleDropdown('articleDropdown')">
                <?= lang('Blog.headerArticel') ?>
            </a>
            <ul id="articleDropdown" class="dropdown-content">
                <li>
                    <a href="<?= base_url($lang === 'en' ? 'en/categories/all-article' : 'id/artikel') ?>" class="dropdown-item">
                        <?= $lang === 'en' ? 'All Articles' : 'Semua Artikel' ?>
                    </a>
                </li>
                <?php if (!empty($kategori)) : ?>
                    <?php foreach ($kategori as $row) : ?>
                        <li>
                            <a href="<?= base_url($lang === 'en' ? 'en/article/' . $row['slug_kategori_en'] : 'id/artikel/' . $row['slug_kategori']) ?>" class="dropdown-item">
                                <?= $lang === 'en' ? esc($row['nama_kategori_en']) : esc($row['nama_kategori']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </li>

        <!-- About Link -->
        <li class="nav-item">
            <a href="<?= $aboutLink ?>" class="nav-link"><?= lang('Blog.headerAbout') ?></a>
        </li>

        <!-- Language Switch -->
        <li class="nav-item dropdown">
            <a href="javascript:void(0)" class="nav-link dropdown-toggle" onclick="toggleDropdown('languageDropdown')">
                <?= lang('Blog.headerLanguage') ?>
            </a>
            <ul id="languageDropdown" class="dropdown-content">
                <li>
                    <a href="<?= base_url('id/') ?>" class="dropdown-item">
                        <img src="<?= base_url('assets-baru/img/in.png') ?>" alt="Indonesia" style="width: 20px; height: 20px;" class="mr-2"> Indonesia
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('en/') ?>" class="dropdown-item">
                        <img src="<?= base_url('assets-baru/img/en.png') ?>" alt="English" style="width: 20px; height: 20px;" class="mr-2"> English
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>



<!-- Overlay to close the sidebar when clicked outside -->
<div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

<style>
    .search-container {
        transition: all 0.3s ease-in-out;
        max-width: 300px;
    }

    .search-container.expanded {
        max-width: 100%;
    }

    .navbar-nav .dropdown-menu {
        margin-top: 0px !important;
        /* Menghapus jarak default Bootstrap */
        padding-top: 0;
        /* Menghapus padding atas jika ada */
        transform: translateY(-5px);
        /* Mengangkat dropdown lebih dekat ke navbar */
        transition: all 0.2s ease-in-out;
        display: none;
        /* Default tersembunyi */
    }

    /* Menampilkan dropdown hanya saat hover */
    .navbar-nav .dropdown:hover .dropdown-menu {
        display: block;
        visibility: visible;
        opacity: 1;
    }

    /* Mengurangi jarak padding antar item di dalam dropdown */
    .navbar-nav .dropdown-menu .dropdown-item {
        padding: 8px 15px;
        /* Bisa disesuaikan */
    }

    /* Menghapus efek klik agar dropdown tidak tetap terbuka */
    .navbar-nav .dropdown>a {
        pointer-events: none;
    }



    /* Tambahan agar dropdown lebih responsif */


    /* Sidebar styles */
    .sidebar {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1000;
        top: 0;
        right: 0;
        background-color: #f8f9fa;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    .sidebar a {
        padding: 10px 15px;
        text-decoration: none;
        font-size: 18px;
        color: #333;
        display: block;
        transition: 0.3s;
    }

    .sidebar a:hover {
        color: #007bff;
    }

    .sidebar .closebtn {
        position: absolute;
        top: 10px;
        right: 25px;
        font-size: 36px;
    }

    /* Overlay effect when sidebar is opened */
    .overlay {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .sidebar.active {
        width: 250px;
    }

    .overlay.active {
        display: block;
    }

    /* Dropdown content */
    .dropdown-content {
        display: none;
        background-color: #f8f9fa;
        padding-left: 15px;
    }

    .dropdown-content a {
        padding: 8px 16px;
        text-decoration: none;
        color: #333;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #007bff;
        color: white;
    }

    .dropdown-toggle {
        cursor: pointer;
    }

    .dropdown-content.show {
        display: block;
    }

    /* Enhancements */
    .nav-item {
        padding: 10px 0;
    }



    /* Responsive behavior for larger screens */
    @media (min-width: 992px) {
        .sidebar {
            display: none;
        }
    }
</style>

<script>
    // Function to toggle the sidebar
    function toggleSidebar() {
        var sidebar = document.getElementById("sidebar");
        var overlay = document.getElementById("overlay");

        sidebar.classList.toggle("active");
        overlay.classList.toggle("active");
    }

    // Function to toggle the dropdown inside the sidebar
    function toggleDropdown(dropdownId) {
        var dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle("show");
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.querySelector(".search-input");
        const searchContainer = document.querySelector(".search-container");

        searchInput.addEventListener("focus", function() {
            searchContainer.classList.add("expanded");
        });

        searchInput.addEventListener("blur", function() {
            searchContainer.classList.remove("expanded");
        });
    });
</script>