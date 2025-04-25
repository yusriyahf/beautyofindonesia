<?= $this->extend('user/template/template') ?>
<?= $this->Section('content'); ?>

<!-- Main News Slider Start -->

<!-- Main News Slider End -->


<!-- News With Sidebar Start -->
<div class="container-fluid mt-4 pt-3">
    <div class="container">
        <div class="col-lg-12 text-center">
            <!-- Slogan di tengah dengan jarak sama di atas dan bawah -->
            <?php foreach ($tentang as $row) : ?>
                <h6 class="slogan text-uppercase font-weight-bold mb-4"><?= $row['slogan']; ?></h6>
            <?php endforeach; ?>
        </div>

        <!-- START ARTIKEL -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="section-title">
                    <h4 class="m-0 text-uppercase font-weight-bold"><?php echo lang('Blog.headerRelatedTour'); ?></h4>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $displayedWisata = array_slice($randomWisata, 0, 3); // Menampilkan hanya 9 item
            foreach ($displayedWisata as $wisata) : ?>
                <div class="col-lg-4 mb-3">
                    <div class="artikel-card position-relative d-flex flex-column h-100 mb-3">
                        <a class="artikel-link" href="<?= base_url(
                                                            $lang . '/' .
                                                                ($lang === 'en' ? 'destinations' : 'wisata') . '/' .
                                                                strtolower(str_replace(' ', '-', ($lang === 'en' ? $wisata['nama_kategori_wisata_en'] : $wisata['nama_kategori_wisata']))) . '/' .
                                                                ($lang === 'en' ? $wisata['slug_wisata_eng'] : $wisata['slug_wisata_ind'])
                                                        )  ?>">
                            <?php
                            // Set the default image path
                            $defaultImage = base_url('assets-baru/img/error_logo.webp');

                            // Check if the wisata image exists, use the default image if it doesn't
                            $imagePath = 'asset-user/uploads/foto_wisata/' . $wisata['foto_wisata'];
                            $imageToDisplay = file_exists(FCPATH . $imagePath) && !empty($wisata['foto_wisata']) ? base_url($imagePath) : $defaultImage;
                            ?>

                            <img class="img-fluid lazyload" style="object-fit: cover;"
                                src="<?= esc($imageToDisplay) ?>"
                                alt="<?= esc($lang === 'en' ? $wisata['nama_wisata_eng'] : $wisata['nama_wisata_ind']) ?>"
                                loading="lazy" width="300" height="200">


                            <div class="bg-white border border-top-0 p-4 flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="<?= base_url($lang === 'en' ? $lang . '/destinations/' . $wisata['slug_kategori_wisata_en'] : $lang . '/wisata/' . $wisata['slug_kategori_wisata']) ?>"
                                        class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2">
                                        <?= esc($lang === 'en' ? $wisata['nama_kategori_wisata_en'] : $wisata['nama_kategori_wisata']) ?>

                                    </a>
                                </div>
                                <p class="text-body">
                                    <small class="location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span class="location-details">
                                            <?php
                                            // Pastikan slug diambil dari data $wisata dengan fallback yang lebih spesifik
                                            $provinsiSlug = $lang === 'en'
                                                ? ($wisata['provinsi_slug_eng'] ?? strtolower(str_replace(' ', '-', $wisata['nama_provinsi_eng'] ?? '')))
                                                : ($wisata['provinsi_slug'] ?? strtolower(str_replace(' ', '-', $wisata['nama_provinsi'] ?? '')));
                                            $kabupatenSlug = $lang === 'en'
                                                ? ($wisata['kabupaten_slug_eng'] ?? strtolower(str_replace(' ', '-', $wisata['nama_kotakabupaten_eng'] ?? '')))
                                                : ($wisata['kabupaten_slug'] ?? strtolower(str_replace(' ', '-', $wisata['nama_kotakabupaten'] ?? '')));
                                            ?>
                                            <span class="kabupaten">
                                                <a class="kabupaten font-weight-bold" href="<?= base_url("wisata?provinsiSlug={$provinsiSlug}&kabupatenSlug={$kabupatenSlug}") ?>">
                                                    <?= esc($lang === 'en' ? ($wisata['nama_kotakabupaten_eng'] ?? 'Unknown City') : ($wisata['nama_kotakabupaten'] ?? 'Unknown City')) ?>
                                                </a>
                                            </span>
                                            <span class="provinsi">
                                                <a class="kabupaten font-weight-bold" href="<?= base_url("wisata?provinsiSlug={$provinsiSlug}") ?>">
                                                    <?= esc($lang === 'en' ? ($wisata['nama_provinsi_eng'] ?? 'Unknown Province') : ($wisata['nama_provinsi'] ?? 'Unknown Province')) ?>
                                                </a>
                                            </span>
                                        </span>

                                    </small>
                                </p>

                                <a class="h4 d-block mb-3 text-secondary font-weight-bold" href="<?= base_url(
                                                                                                        $lang . '/' .
                                                                                                            ($lang === 'en' ? 'destinations' : 'wisata') . '/' .
                                                                                                            strtolower(str_replace(' ', '-', ($lang === 'en' ? $wisata['nama_kategori_wisata_en'] : $wisata['nama_kategori_wisata']))) . '/' .
                                                                                                            ($lang === 'en' ? $wisata['slug_wisata_eng'] : $wisata['slug_wisata_ind'])
                                                                                                    ) ?>">
                                    <?= esc($lang === 'en' ? $wisata['nama_wisata_eng'] : $wisata['nama_wisata_ind']) ?>
                                </a>
                                <p>
                                    <?= esc(substr(strip_tags($lang === 'en' ? $wisata['deskripsi_wisata_eng'] : $wisata['deskripsi_wisata_ind']), 0, 100)); ?>...
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- END ARTIKEL -->

        <!-- START OLEH OLEH -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="section-title">
                    <h4 class="m-0 text-uppercase font-weight-bold"><?php echo lang('Blog.headerRelatedSouvenirss'); ?></h4>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $displayedOlehOleh = array_slice($randomOlehOleh, 0, 3); // Menampilkan hanya 3 item
            foreach ($displayedOlehOleh as $oleh): ?>
                <div class="col-lg-4 mb-3">
                    <div class="artikel-card position-relative d-flex flex-column h-100 mb-3">
                        <a class="artikel-link" href="<?= base_url(
                                                            $lang . '/' .
                                                                ($lang === 'en' ? 'souvenirs' : 'oleh-oleh') . '/' .
                                                                strtolower(str_replace(' ', '-', ($lang === 'en' ? $oleh['nama_kategori_oleholeh_en'] : $oleh['nama_kategori_oleholeh']))) . '/' .
                                                                ($lang === 'en' ? $oleh['slug_en'] : $oleh['slug_oleholeh'])
                                                        ) ?>">
                            <?php
                            // Set the default image path
                            $defaultImage = base_url('assets-baru/img/error_logo.webp');

                            // Check if the oleh-oleh image exists, use the default image if it doesn't
                            $imagePath = '/assets-baru/img/foto_oleholeh/' . $oleh['foto_oleholeh'];
                            $imageToDisplay = file_exists(FCPATH . $imagePath) && !empty($oleh['foto_oleholeh']) ? base_url($imagePath) : $defaultImage;
                            ?>

                            <img class="img-fluid lazyload" style="object-fit: cover;"
                                src="<?= esc($imageToDisplay) ?>"
                                alt="<?= esc($oleh['nama_oleholeh']) ?>"
                                loading="lazy" width="300" height="200">

                            <div class="bg-white border border-top-0 p-4 flex-grow-1">
                                <div class="mb-2">
                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                        href="<?= base_url($lang === 'en' ? $lang . '/souvenirs/' . $oleh['slug_kategori_oleholeh_en'] : $lang . '/oleh-oleh/' . $oleh['slug_kategori_oleholeh']) ?>">
                                        <?= esc($lang === 'en' ? $oleh['nama_kategori_oleholeh_en'] : $oleh['nama_kategori_oleholeh']) ?>
                                    </a>



                                </div>
                                <p class="text-body">
                                    <small class="location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span class="location-details">
                                            <?php
                                            $provinsiSlug = $lang === 'en'
                                                ? ($oleh['provinsi_slug_eng'] ?? strtolower(str_replace(' ', '-', $oleh['nama_provinsi_eng'] ?? '')))
                                                : ($oleh['provinsi_slug'] ?? strtolower(str_replace(' ', '-', $oleh['nama_provinsi'] ?? '')));

                                            $kabupatenSlug = $lang === 'en'
                                                ? ($oleh['kabupaten_slug_eng'] ?? strtolower(str_replace(' ', '-', $oleh['nama_kotakabupaten_eng'] ?? '')))
                                                : ($oleh['kabupaten_slug'] ?? strtolower(str_replace(' ', '-', $oleh['nama_kotakabupaten'] ?? '')));
                                            ?>
                                            <span class="kabupaten">
                                                <a class="kabupaten font-weight-bold" href="<?= base_url("OlehOleh?provinsiSlug={$provinsiSlug}&kabupatenSlug={$kabupatenSlug}") ?>">
                                                    <?= esc($lang === 'en' ? ($oleh['nama_kotakabupaten_eng'] ?? 'Unknown City') : ($oleh['nama_kotakabupaten'] ?? 'Unknown City')) ?>
                                                </a>
                                            </span>
                                            <span class="provinsi">
                                                <a class="kabupaten font-weight-bold" href="<?= base_url("OlehOleh?provinsiSlug={$provinsiSlug}") ?>">
                                                    <?= esc($lang === 'en' ? ($oleh['nama_provinsi_eng'] ?? 'Unknown Province') : ($oleh['nama_provinsi'] ?? 'Unknown Province')) ?>
                                                </a>
                                            </span>
                                        </span>
                                    </small>
                                </p>
                                <a class="h4 d-block mb-2 text-secondary font-weight-bold" href="<?= base_url(
                                                                                                        $lang . '/' .
                                                                                                            ($lang === 'en' ? 'souvenirs' : 'oleh-oleh') . '/' .
                                                                                                            strtolower(str_replace(' ', '-', ($lang === 'en' ? $oleh['nama_kategori_oleholeh_en'] : $oleh['nama_kategori_oleholeh']))) . '/' .
                                                                                                            ($lang === 'en' ? $oleh['slug_en'] : $oleh['slug_oleholeh'])
                                                                                                    ) ?>">
                                    <?= esc($lang === 'en' ? $oleh['nama_oleholeh_eng'] : $oleh['nama_oleholeh']) ?>
                                </a>
                                <p style="margin-bottom: -40px;">
                                    <?= esc(substr(strip_tags($lang === 'en' ? $oleh['deskripsi_oleholeh_eng'] : $oleh['deskripsi_oleholeh']), 0, 100)); ?>...
                                </p>
                            </div>
                            <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                <small><i class="far fa-eye mr-2"></i><?php echo lang('Blog.views'); ?> <?= esc($oleh['views']); ?></small>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- END OLEH OLEH -->


        <!-- START ARTIKEL -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="section-title">
                    <h4 class="m-0 text-uppercase font-weight-bold"><?php echo lang('Blog.btnLatestarticel'); ?></h4>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            // Sort the articles by 'tgl_publish' in descending order
            usort($artikelterbaru, function ($a, $b) {
                return strtotime($b['tgl_publish']) - strtotime($a['tgl_publish']);
            });
            ?>

            <?php foreach ($artikelterbaru as $row) : ?>
                <div class="col-lg-4 mb-4">
                    <a href="<?= base_url(
                                    $lang . '/' .
                                        ($lang === 'en' ? 'article' : 'artikel') . '/' .
                                        strtolower(str_replace(' ', '-', ($lang === 'en' ? $row['nama_kategori_en'] : $row['nama_kategori']))) . '/' .
                                        ($lang === 'en' ? $row['slug_en'] : $row['slug'])
                                )
                                ?>" class="text-decoration-none artikel-link">
                        <div class="position-relative d-flex flex-column h-100 mb-3 artikel-card">
                            <?php
                            // Set the default image path
                            $defaultImage = base_url('assets-baru/img/error_logo.webp');

                            // Check if the article image exists, use the default image if it doesn't
                            $imagePath = 'assets-baru/img/foto_artikel/' . $row['foto_artikel'];
                            $imageToDisplay = file_exists(FCPATH . $imagePath) && !empty($row['foto_artikel']) ? base_url($imagePath) : $defaultImage;
                            ?>

                            <img class="img-fluid lazyload" style="object-fit: cover;"
                                src="<?= $imageToDisplay ?>"
                                alt="<?= esc($lang === 'en' ? $row['judul_artikel_en'] : $row['judul_artikel']) ?>"
                                loading="lazy" width="300" height="200">

                            <div class="bg-white border border-top-0 p-4 flex-grow-1">
                                <div class="mb-2">
                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2 <?= current_url() === base_url($lang . ($lang === 'en' ? '/article/' : '/artikel/') . ($lang === 'en' ? $row['slug_kategori_en'] : $row['slug_kategori'])) ? 'active' : '' ?>" href="<?= base_url($lang . ($lang === 'en' ? '/article/' : '/artikel/') . ($lang === 'en' ? $row['slug_kategori_en'] : $row['slug_kategori'])) ?>">
                                        <?= esc($lang === 'en' ? $row['nama_kategori_en'] : $row['nama_kategori'] ?? 'Unknown Category') ?>
                                    </a>

                                </div>
                                <p class="text-body"><?= date('d F Y', strtotime($row['tgl_publish'])); ?></p>

                                <?php
                                // Determine the current language
                                $currentLang = session('lang');
                                // var_dump($currentLang);
                                // die();
                                ?>

                                <a class="h4 d-block mb-3 text-secondary font-weight-bold" href="<?= base_url($lang . '/' . ($lang === 'en' ? 'article' : 'artikel') . '/' .
                                                                                                        strtolower(str_replace(' ', '-', ($lang === 'en' ? $row['slug_kategori_en'] : $row['slug_kategori']))) . '/' .
                                                                                                        ($lang === 'en' ? $row['slug_en'] : $row['slug']))
                                                                                                    ?>">
                                    <?php if ($currentLang === 'en'): ?>
                                        <?= strip_tags($row['judul_artikel_en']); ?>
                                    <?php else: ?>
                                        <?= strip_tags($row['judul_artikel']); ?>
                                    <?php endif; ?>
                                </a>

                                <p style="margin-bottom: -4rem;">
                                    <?php if ($currentLang === 'en'): ?>
                                        <?= substr(strip_tags($row['deskripsi_artikel_en']), 0, 200); ?>...
                                    <?php else: ?>
                                        <?= substr(strip_tags($row['deskripsi_artikel']), 0, 200); ?>...
                                    <?php endif; ?>
                                </p>

                            </div>
                            <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                <!-- <div class="d-flex align-items-center nama-penulis">
                                    <small class="font-weight-bold"><?= $row['nama_penulis']; ?></small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <small class="ml-3 views-counter"><i class="far fa-eye mr-2"></i><?= $row['views']; ?></small>
                                </div> -->
                            </div>
                        </div>
                    </a>
                </div>

            <?php endforeach; ?>
        </div>
        <!-- END ARTIKEL -->



    </div>
</div>

<style>
    /* Styling card article */
    .artikel-card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        overflow: hidden;
    }

    .artikel-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .artikel-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Membuat link untuk seluruh card */
    .artikel-link {
        display: block;
        text-decoration: none;
        color: inherit;
    }

    .location {
        display: flex;
        align-items: center;
        /* Center-align icon and text vertically */
    }

    .location i {
        margin-right: 8px;
        /* Spacing between icon and text */
    }

    .location-details {
        display: flex;
        flex-direction: column;
        /* Stack text elements vertically */
    }

    .kabupaten,
    .provinsi {
        display: block;
    }
</style>

<div class="col-lg-12 text-center mt-4 mb-4">
    <!-- Gunakan h2 atau h3 tergantung pada struktur halaman -->
    <h3 class="slogan text-uppercase font-weight-bold mb-4">
        <?php echo lang('Blog.headerMaps'); ?>
    </h3>
</div>





<!-- Tambahkan link CSS dan JS Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<!-- Tambahkan Plugin MarkerCluster -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<style>
    /* Overlay animasi loading */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        /* Latar belakang transparan putih */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 999;
        /* Pastikan overlay di atas peta */
    }

    /* Spinner animasi */
    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
    }

    /* Animasi berputar */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .map-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        position: relative;
        margin-top: 20px;
    }

    #map {
        height: 500px;
        width: 95%;
        max-width: 1120px;
        border: 2px solid #94D9F6;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .search-container {
        margin: 5px;
        margin-bottom: 10px;
        display: flex;
        justify-content: center;
        position: relative;
    }

    .search-input {
        padding: 8px;
        font-size: 16px;
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .search-btn {
        padding: 8px 12px;
        margin-left: 8px;
        background-color: #1976D2;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-btn:hover {
        background-color: #45a049;
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #ccc;
        background-color: #fff;
        width: 300px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 9999;
        border-radius: 4px;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #ddd;
    }

    .autocomplete-items div:last-child {
        border-bottom: none;
    }

    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    .popup-button {
        margin-top: 10px;
        padding: 8px 12px;
        background-color: #FFCC00;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-align: center;
        display: block;
        text-decoration: none;
    }

    .popup-button:hover {
        background-color: #e6b800;
    }

    /* CSS tambahan untuk menonjolkan marker */
    .leaflet-marker-icon {
        filter: drop-shadow(0 0 5px rgba(0, 0, 0, 0.5));
    }

    .leaflet-marker-icon:hover {
        filter: drop-shadow(0 0 8px rgba(255, 0, 0, 0.6));
    }

    /* CSS untuk panel informasi */
    .info-panel {
        background: white;
        padding: 10px;
        border: 2px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-size: 14px;
    }

    .info-panel label {
        display: block;
        margin-bottom: 5px;
    }

    .leaflet-control-info-panel {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 1000;
        /* Pastikan di atas layer peta */
    }

    /* Mengubah warna angka cluster menjadi hitam */
    .marker-cluster-small div,
    .marker-cluster-medium div,
    .marker-cluster-large div {
        color: black !important;
        /* Mengubah warna angka cluster menjadi hitam */
        font-weight: bold;
        /* Membuat angka lebih tebal agar terlihat jelas */
    }
</style>

<!-- Search Box dengan Autocomplete -->
<div class="container d-flex justify-content-center align-items-center ">
    <div class="search-container d-flex">
        <input type="text" id="searchInput" class="form-control me-2" placeholder="<?php echo lang('Blog.btnKetSearch'); ?>" oninput="showAutocomplete(this.value)">
        <button class="btn btn-primary" onclick="searchLocation()"><?php echo lang('Blog.btnSearch'); ?></button>
    </div>
</div>

<div class="col-lg-7 px-0 map-container">
    <div id="autocomplete-list" class="autocomplete-items"></div>
    <div id="map" class="map-container">
        <div id="loading-overlay" class="loading-overlay">
            <div class="spinner"></div> <!-- Spinner atau animasi lainnya -->
        </div>
    </div>
</div>


<!-- Konten AJAX -->
<div id="ajax-content">
    <!-- Konten AJAX akan dimuat di sini -->
</div>

<!-- Menggunakan jQuery untuk AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Menyembunyikan overlay loading saat halaman pertama dimuat
        $('#loading-overlay').show(); // Menampilkan overlay loading

        // Mendapatkan path bahasa saat ini (id atau en)
        var currentLang = window.location.pathname.split('/')[1]; // id atau en

        // Menentukan URL AJAX sesuai dengan bahasa yang dipilih
        var ajaxUrl = window.location.origin + '/' + currentLang + '/ajax/load-data';

        // Melakukan permintaan AJAX
        $.ajax({
            url: ajaxUrl,
            type: 'GET',
            success: function(response) {
                // Menyembunyikan overlay loading setelah data berhasil dimuat
                $('#loading-overlay').hide();

                // Menampilkan konten AJAX ke dalam #ajax-content
                $('#ajax-content').html(response);
            },
            error: function() {
                // Menyembunyikan overlay loading jika terjadi error
                $('#loading-overlay').hide();

                // Menampilkan pesan error
                $('#ajax-content').html('<p>Gagal memuat data.</p>');
            }
        });
    });
</script>




<div class="container-fluid bg-dark pt-5 px-sm-3 px-md-5 mt-5">
    <div class="row py-4 d-flex align-items-stretch">
        <div class="col-lg-3 col-md-6 mb-5 position-relative">
            <div class="logo-container">
                <img
                    src="https://beautyofindonesia.com/assets/images/logoHeader.webp"
                    alt="Beauty Of Indonesia Logo"
                    class="logo-image"
                    loading="lazy">

            </div>
        </div>

        <style>
            .logo-container {
                background-image: url('https://beautyofindonesia.com/assets/images/your-background-image.jpg');
                background-size: cover;
                background-position: center;
                position: relative;
                width: 100%;
                height: 200px;
                clip-path: polygon(0 0, 100% 0, 100% 85%, 50% 100%, 0 85%);
            }

            .logo-image {
                position: absolute;
                top: 35%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 250px;
                height: 120px;
            }

            /* Align text left */
            .text-left {
                text-align: left !important;
            }
        </style>

        <?php
        // Set language from session or default to 'id' (Indonesian)
        $lang = session()->get('lang') ?? 'id';

        // Language content array
        $translations = [
            'id' => [
                'attention' => 'PERHATIAN',
                'attention_content' => 'Jika Anda menemukan penyalahgunaan konten atau pelanggaran hak cipta, harap menghubungi Admin di',
                'contact' => '082131222331',
                'partnership' => 'KERJA SAMA',
                'partnership_content' => 'Jika Anda ingin tulisan atau oleh-oleh Anda dimuat di dalam website <strong>BeautyOfIndonesia.com</strong>, atau Anda ingin memasang iklan, silakan hubungi Admin di',
                'thank_you' => 'Terima Kasih!'
            ],
            'en' => [
                'attention' => 'ATTENTION',
                'attention_content' => 'If you find content misuse or copyright infringement, please contact Admin at',
                'contact' => '082131222331',
                'partnership' => 'PARTNERSHIP',
                'partnership_content' => 'If you want your article or souvenir featured on <strong>BeautyOfIndonesia.com</strong>, or if you wish to advertise, please contact Admin at',
                'thank_you' => 'Thank you!'
            ]
        ];
        ?>

        <div class="col-lg-3 col-md-6 mb-5 d-flex flex-column text-left">
            <h4 class="mb-4 text-white text-uppercase font-weight-bold">
                <?php echo $translations[$lang]['attention']; ?>
            </h4>

            <p class="font-weight-medium text-white">
                <?php echo $translations[$lang]['attention_content']; ?>
                <a href="https://wa.me/6282131222331?text=Halo%20Admin%20Beauty%20Of%20Indonesia!%20Saya%20ingin%20melaporkan%20penyalahgunaan%20konten%20atau%20pelanggaran%20hak%20cipta.%20Minta%20informasi%20lebih%20lanjutnya%20ya%20Min,%20Terima%20Kasih..."
                    style="color: #0091EA; text-decoration: none;">
                    <strong><?php echo $translations[$lang]['contact']; ?></strong>
                </a> <?php echo $translations[$lang]['thank_you']; ?>
            </p>
        </div>

        <div class="col-lg-3 col-md-6 mb-5 d-flex flex-column text-left">
            <h4 class="mb-4 text-white text-uppercase font-weight-bold">
                <?php echo $translations[$lang]['partnership']; ?>
            </h4>
            <p class="font-weight-medium text-white">
                <?php echo $translations[$lang]['partnership_content']; ?>
                <a href="https://wa.me/6282131222331?text=Halo%20admin%20beauty%20of%20indonesia!%20Saya%20mau%20mendaftarkan%20produk%20saya%20menjadi%20salah%20satu%20oleh-oleh%20di%20website%20beautyofindonesia.com.%20Minta%20informasi%20lebih%20lanjut."
                    style="color: #0091EA; text-decoration: none;">
                    <strong><?php echo $translations[$lang]['contact']; ?></strong>
                </a> <?php echo $translations[$lang]['thank_you']; ?>
            </p>
        </div>


        <!-- Navbar links and search form aligned to the right (for larger screens) -->
        <div class="col-lg-3 col-md-12">
            <h4 class="mb-4 text-white text-uppercase font-weight-bold">MENU</h4>
            <div class="menu-links d-flex flex-column">
                <?php
                // Ambil bahasa yang disimpan di session
                $lang = session()->get('lang') ?? 'en'; // Default ke 'en' jika tidak ada di session

                // Definisikan tautan untuk setiap halaman berdasarkan bahasa
                $destinationsLink = ($lang === 'en') ? 'destinations' : 'wisata';
                $souvenirsLink = ($lang === 'en') ? 'souvenirs' : 'oleh-oleh';
                $articleLink = ($lang === 'en') ? 'article' : 'artikel';
                $aboutLink = ($lang === 'en') ? 'about' : 'tentang';
                ?>

                <?php helper('url'); ?>

                <a href="<?= base_url($lang . '/') ?>" class="menu-link py-2 <?= current_url() === base_url('/') ? 'active' : '' ?>" style="color: #FFCC00;">
                    <?php echo lang('Blog.headerHome'); ?>
                </a>

                <a href="<?= base_url($lang . '/' . $destinationsLink) ?>" class="menu-link py-2 <?= current_url() === base_url($lang . '/' . $destinationsLink) ? 'active' : '' ?>" style="color: #FFCC00;">
                    <?php echo lang('Blog.headerTour'); ?>
                </a>

                <?php $souvenirsLink = ($lang === 'en') ? 'souvenirs' : 'oleh-oleh'; ?>

                <a href="<?= base_url($lang . '/' . $souvenirsLink) ?>" class="menu-link py-2 <?= current_url() === base_url($lang . '/' . $souvenirsLink) ? 'active' : '' ?>" style="color: #FFCC00;">
                    <?php echo lang('Blog.headerSouvenir'); ?>
                </a>


                <a href="<?= base_url($lang === 'en' ? 'en/article' : 'id/artikel') ?>"
                    class="menu-link py-2 <?= current_url() === base_url($lang === 'en' ? 'en/article' : 'id/artikel') ? 'active' : '' ?>" style="color: #FFCC00;">
                    <?= lang('Blog.headerArticel') ?>
                </a>

                <a href="<?= base_url($lang . '/' . $aboutLink) ?>" class="menu-link py-2 <?= current_url() === base_url($lang . '/' . $aboutLink) ? 'active' : '' ?>" style="color: #FFCC00;">
                    <?php echo lang('Blog.headerAbout'); ?>
                </a>

                <!-- Pilihan bahasa horizontal -->
                <div class="d-flex flex-row justify-content-start mt-4">
                    <a href="<?= base_url('id/') ?>" class="btn btn-secondary btn-sm mr-2 d-flex align-items-center">
                        <img src="<?= base_url('assets-baru/img/in.png') ?>" alt="Bendera Indonesia" style="width: 15px; height: 15px;" class="mr-1"> Indonesia
                    </a>
                    <a href="<?= base_url('en/') ?>" class="btn btn-secondary btn-sm d-flex align-items-center">
                        <img src="<?= base_url('assets-baru/img/en.png') ?>" alt="Bendera Inggris" style="width: 15px; height: 15px;" class="mr-1"> English
                    </a>
                </div>

            </div>


        </div>
    </div>


</div>

<?php
// Panggil PopupController untuk mengecek popup
$popupController = new \App\Controllers\user\PopupController();
echo $popupController->checkPopup();
?>


<?= $this->endSection('content'); ?>