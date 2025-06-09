<?= $this->extend('user/template/template') ?>
<?= $this->section('content'); ?>
<div class="container-fluid pt-5 mb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Main Content Start -->
                <div class="position-relative mb-3">
                    <div class="image-container position-relative">
                        <?php
                        // Set the default image path
                        $defaultImage = base_url('assets-baru/img/error_logo.webp');

                        // Check if the wisata image exists, use the default image if it doesn't
                        $imagePath = 'asset-user/uploads/foto_wisata/' . $wisata['foto_wisata'];
                        $imageToDisplay = file_exists(FCPATH . $imagePath) && !empty($wisata['foto_wisata']) ? base_url($imagePath) : $defaultImage;
                        ?>

                        <img class="img-fluid w-100 lazyload"
                            src="<?= esc($imageToDisplay) ?>"
                            alt="<?= esc($wisata['nama_wisata_eng'] ?? $wisata['nama_wisata_ind']) ?>"
                            loading="lazy"
                            style="object-fit: cover;">


                        <?php if (!empty($wisata['sumber_foto'])): ?>
                            <div class="sumber-foto position-absolute">
                                <p class="mb-0"><?= lang('Blog.btnSource') ?> : <?= esc($wisata['sumber_foto']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="bg-white border border-top-0 p-4">
                        <h1 class="text-uppercase font-weight-bold">
                            <?= esc($lang === 'en' ? $wisata['nama_wisata_eng']   : $wisata['nama_wisata_ind']) ?> </h1>
                        <div class="mb-2">
                            <?php
                            // Use a default value or handle cases where the slug may not exist
                            $slug_kategori = $lang === 'en' && isset($wisata['slug_kategori_wisata_en']) ? $wisata['slug_kategori_wisata_en'] : (isset($wisata['slug_kategori_wisata']) ? $wisata['slug_kategori_wisata'] : '#');
                            ?>
                            <a href="<?= base_url($lang === 'en' ? $lang . '/destinations/destinations-category/' . ($wisata['slug_kategori_wisata_en'] ?? '') : $lang . '/wisata/kategori-wisata/' . ($wisata['slug_kategori_wisata'] ?? '')) ?>"
                                class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2">
                                <?= esc($lang === 'en' ? ($wisata['nama_kategori_wisata_en'] ?? 'Unknown Category') : ($wisata['nama_kategori_wisata'] ?? 'Unknown Category')) ?>
                            </a>
                        </div>
                        <small class="location1">
                            <p class="text-body">
                                <small class="location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span class="location-details">
                                        <?php
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
                        </small>

                        <?= session('lang') === 'en'
                            ? str_replace(
                                ['<h1>', '</h1>', '<h2>', '</h2>'],
                                ['<h1 class="h2">', '</h1>', '<h2 class="h4">', '</h2>'],
                                $wisata['deskripsi_wisata_eng']
                            )
                            : str_replace(
                                ['<h1>', '</h1>', '<h2>', '</h2>'],
                                ['<h1 class="h2">', '</h1>', '<h2 class="h4">', '</h2>'],
                                $wisata['deskripsi_wisata_ind']
                            );
                        ?>
                    </div>
                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                        <div class="d-flex align-items-center">
                            <img class="rounded-circle mr-2" src="<?= base_url('assets-baru') ?>/img/penulis.jpg" width="25" height="25" alt="">
                            <span>Fernandes Raymond</span>
                        </div>
                    </div>
                </div>
                <!-- Main Content End -->
            </div>

            <div class="col-lg-4">
                <!-- Sidebar Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold"><?= lang('Blog.btnOtherDestinationss') ?></h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">


                        <?php if (!empty($randomWisata) && is_array($randomWisata)) :  ?>
                            <?php foreach ($randomWisata as $wisataLainnya) : ?>
                                <div class="d-flex align-items-center bg-white mb-3" style="height: 110px; object-fit: cover;">
                                    <?php
                                    // Set th e default image path
                                    $defaultImage = base_url('assets-baru/img/error_logo.webp');

                                    // Check if the wisata image exists, use the default image if it doesn't
                                    $imagePath = 'asset-user/uploads/foto_wisata/' . $wisataLainnya['foto_wisata'];
                                    $imageToDisplay = file_exists(FCPATH . $imagePath) && !empty($wisataLainnya['foto_wisata']) ? base_url($imagePath) : $defaultImage;
                                    ?>

                                    <div class="d-flex align-items-center justify-content-center border rounded" style="width: 170px; height: 110px; overflow: hidden;">
                                        <img class="img-fluid object-fit-cover w-100 h-100"
                                            src="<?= esc($imageToDisplay) ?>"
                                            alt="<?= esc($wisataLainnya['nama_wisata_eng'] ?? $wisataLainnya['nama_wisata_ind']) ?>"
                                            loading="lazy">
                                    </div>

                                    <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                        <div class="mb-1 mt-3">
                                            <a href="<?= base_url($lang === 'en' ? $lang . '/destinations/destinations-category/' . ($wisata['slug_kategori_wisata_en'] ?? '') : $lang . '/wisata/kategori-wisata/' . ($wisata['slug_kategori_wisata'] ?? '')) ?>"
                                                class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" style="font-size: 11px;">
                                                <?= esc($lang === 'en' ? ($wisata['nama_kategori_wisata_en'] ?? 'Unknown Category') : ($wisata['nama_kategori_wisata'] ?? 'Unknown Category')) ?>
                                            </a>

                                        </div>

                                        <?php
                                        // Construct the URL based on the selected language
                                        $url = base_url(
                                            $lang . '/' .
                                                ($lang === 'en' ? 'destinations' : 'wisata') . '/' .
                                                strtolower(str_replace(' ', '-', ($lang === 'en' ? $wisataLainnya['nama_kategori_wisata_en'] : $wisataLainnya['nama_kategori_wisata']))) . '/' .
                                                ($lang === 'en' ? $wisataLainnya['slug_wisata_eng'] : $wisataLainnya['slug_wisata_ind'])
                                        );

                                        // Determine the title based on the selected language
                                        $title = esc($lang === 'en' ? $wisataLainnya['nama_wisata_eng'] : $wisataLainnya['nama_wisata_ind']);
                                        ?>

                                        <a class="h6 m-0 text-secondary font-weight-bold mt-1"
                                            href="<?= $url ?>"
                                            title="<?= $title ?>">
                                            <?= $title ?>
                                        </a>
                                        <p class="text-body">
                                            <small class="location">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span class="location-details">
                                                    <?php
                                                    $provinsiSlug = $lang === 'en'
                                                        ? ($wisataLainnya['provinsi_slug_eng'] ?? strtolower(str_replace(' ', '-', $wisataLainnya['nama_provinsi_eng'] ?? '')))
                                                        : ($wisataLainnya['provinsi_slug'] ?? strtolower(str_replace(' ', '-', $wisataLainnya['nama_provinsi'] ?? '')));
                                                    $kabupatenSlug = $lang === 'en'
                                                        ? ($wisataLainnya['kabupaten_slug_eng'] ?? strtolower(str_replace(' ', '-', $wisataLainnya['nama_kotakabupaten_eng'] ?? '')))
                                                        : ($wisataLainnya['kabupaten_slug'] ?? strtolower(str_replace(' ', '-', $wisataLainnya['nama_kotakabupaten'] ?? '')));
                                                    ?>
                                                    <span class="kabupaten">
                                                        <a href="<?= base_url("wisata?provinsiSlug={$provinsiSlug}&kabupatenSlug={$kabupatenSlug}") ?>">
                                                            <?= esc($lang === 'en' ? ($wisataLainnya['nama_kotakabupaten_eng'] ?? 'Unknown City') : ($wisataLainnya['nama_kotakabupaten'] ?? 'Unknown City')) ?>
                                                        </a>
                                                    </span>
                                                    <span class="provinsi">
                                                        <a href="<?= base_url("wisata?provinsiSlug={$provinsiSlug}") ?>">
                                                            <?= esc($lang === 'en' ? ($wisataLainnya['nama_provinsi_eng'] ?? 'Unknown Province') : ($wisataLainnya['nama_provinsi'] ?? 'Unknown Province')) ?>
                                                        </a>
                                                    </span>
                                                </span>

                                            </small>
                                        </p>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="text-center"><?= lang('Blog.noDestinationsFound') ?></p>
                        <?php endif; ?>

                    </div>

                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold"><?= lang('Blog.headerRelatedSouvenirs') ?></h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <?php
                            foreach ($randomOlehOleh as $olehlain) : ?>
                                <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                    <?php
                                    // Set the default image path
                                    $defaultImage = base_url('assets-baru/img/error_logo.webp');

                                    // Check if the oleh-oleh image exists, use the default image if it doesn't
                                    $imagePath = '/assets-baru/img/foto_oleholeh/' . $olehlain['foto_oleholeh'];
                                    $imageToDisplay = file_exists(FCPATH . $imagePath) && !empty($olehlain['foto_oleholeh']) ? base_url($imagePath) : $defaultImage;
                                    ?>

                                    <img class="img-fluid lazyload" style="width: 110px; height: 110px; object-fit: cover;"
                                        src="<?= esc($imageToDisplay) ?>"
                                        alt="<?= esc($olehlain['nama_oleholeh']) ?>"
                                        loading="lazy">

                                    <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                        <div class="mb-1 mt-3">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" style="font-size: 11px;"
                                                href="<?= base_url($lang === 'en' ? $lang . '/souvenirs/souvenirs-category/' . $olehlain['slug_kategori_oleholeh_en'] : $lang . '/oleh-oleh/kategori-oleh-oleh/' . $olehlain['slug_kategori_oleholeh']) ?>">
                                                <?= esc($lang === 'en' ? $olehlain['nama_kategori_oleholeh_en'] : $olehlain['nama_kategori_oleholeh']) ?>
                                            </a>
                                        </div>
                                        <a class="h6 m-0 text-secondary font-weight-bold mt-1"
                                            href="<?= base_url(
                                                        $lang . '/' .
                                                            ($lang === 'en' ? 'souvenirs' : 'oleh-oleh') . '/' .
                                                            strtolower(str_replace(' ', '-', ($lang === 'en' ? $olehlain['nama_kategori_oleholeh_en'] : $olehlain['nama_kategori_oleholeh']))) . '/' .
                                                            ($lang === 'en' ? $olehlain['slug_en'] : $olehlain['slug_oleholeh'])
                                                    ) ?>"
                                            title="<?= esc($olehlain['nama_oleholeh']) ?>">
                                            <?= esc(substr($olehlain['nama_oleholeh'], 0, 27)) ?>

                                        </a>
                                        <p class="text-body mt-1">
                                            <small class="location">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span class="location-details">
                                                    <?php
                                                    // Ensure the slug is taken from the $olehlain data with a fallback to a more specific format
                                                    $provinsiSlug = $lang === 'en'
                                                        ? ($olehlain['provinsi_slug_eng'] ?? strtolower(str_replace(' ', '-', $olehlain['nama_provinsi_eng'] ?? '')))
                                                        : ($olehlain['provinsi_slug'] ?? strtolower(str_replace(' ', '-', $olehlain['nama_provinsi'] ?? '')));

                                                    $kabupatenSlug = $lang === 'en'
                                                        ? ($olehlain['kabupaten_slug_eng'] ?? strtolower(str_replace(' ', '-', $olehlain['nama_kotakabupaten_eng'] ?? '')))
                                                        : ($olehlain['kabupaten_slug'] ?? strtolower(str_replace(' ', '-', $olehlain['nama_kotakabupaten'] ?? '')));
                                                    ?>
                                                    <span class="kabupaten">
                                                        <a class="kabupaten font-weight-bold" href="<?= base_url("oleholeh?provinsiSlug={$provinsiSlug}&kabupatenSlug={$kabupatenSlug}") ?>">
                                                            <?= esc($lang === 'en' ? ($olehlain['nama_kotakabupaten_eng'] ?? 'Unknown City') : ($olehlain['nama_kotakabupaten'] ?? 'Unknown City')) ?>
                                                        </a>
                                                    </span>
                                                    <span class="provinsi">
                                                        <a class="kabupaten font-weight-bold" href="<?= base_url("oleholeh?provinsiSlug={$provinsiSlug}") ?>">
                                                            <?= esc($lang === 'en' ? ($olehlain['nama_provinsi_eng'] ?? 'Unknown Province') : ($olehlain['nama_provinsi'] ?? 'Unknown Province')) ?>
                                                        </a>
                                                    </span>
                                                </span>
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // Set language from session or default to 'id' (Indonesian)
            $lang = session()->get('lang') ?? 'id';

            // Language content array
            $translations = [
                'id' => [
                    'promotion_title' => 'Anda UMKM dan ingin mempromosikan produk Anda di website kami Secara Gratis?',
                    'promotion_text' => 'Klik tombol di bawah ini:',
                    'promotion_button' => 'Promosikan Produk Anda',
                    'wa_message' => 'Halo Admin Beauty Of Indonesia! Saya mau mendaftarkan produk Saya menjadi salah satu Oleh-Oleh di Website BeautyOfIndonesia.com. Minta informasi lebih lanjutnya ya Min, Terima Kasih...'
                ],
                'en' => [
                    'promotion_title' => 'Are you an SME and want to promote your products on our website for free?',
                    'promotion_text' => 'Click the button below:',
                    'promotion_button' => 'Promote Your Product',
                    'wa_message' => 'Hello Beauty Of Indonesia Admin! I would like to register my product as one of the Souvenirs on the BeautyOfIndonesia.com Website. Please provide more information, thank you...'
                ]
            ];
            ?>

            <!-- Promotional Section -->
            <div class="mt-3 mb-5 text-center promotional-section animate__animated animate__fadeInUp">
                <div class="bg-light p-4 rounded shadow-sm">
                    <h4 class="text-uppercase font-weight-bold">
                        <?php echo $translations[$lang]['promotion_title']; ?>
                    </h4>
                    <p class="lead">
                        <?php echo $translations[$lang]['promotion_text']; ?>
                    </p>
                    <a href="https://wa.me/6282131222331?text=<?php echo urlencode($translations[$lang]['wa_message']); ?>"
                        class="btn btn-primary btn-lg shadow">
                        <?php echo $translations[$lang]['promotion_button']; ?>
                    </a>
                </div>
            </div>

        </div>

    </div>
    <!-- Sidebar End -->


    <div class="col-lg-12 text-center mt-5 mb-4">
        <!-- Slogan di tengah dengan jarak sama di atas dan bawah -->
        <h6 class="slogan text-uppercase font-weight-bold mb-4">
            <?php
            echo lang('Blog.headerMapsDetail') . ' - ' . esc($lang === 'en' ? $wisata['nama_wisata_eng'] : $wisata['nama_wisata_ind']);
            ?>
        </h6>
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


    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([<?= $wisata['wisata_latitude'] ?>, <?= $wisata['wisata_longitude'] ?>], 15);

        // Layer peta dasar
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Ikon untuk tempat wisata
        var wisataIcon = L.icon({
            iconUrl: '/assets-baru/img/icon_wisata.png',
            iconSize: [32, 42],
            iconAnchor: [20, 50],
            popupAnchor: [0, -42]
        });

        // Tambahkan marker wisata
        var wisataMarker = L.marker([<?= $wisata['wisata_latitude'] ?>, <?= $wisata['wisata_longitude'] ?>], {
            icon: wisataIcon
        }).addTo(map);

        // Isi popup dengan detail wisata
        wisataMarker.bindPopup(`
        <div style="text-align: center;">
            <img 
                src="/asset-user/uploads/foto_wisata/<?= $wisata['foto_wisata'] ?>" 
                alt="<?= $lang === 'en' ? $wisata['nama_wisata_eng'] : $wisata['nama_wisata_ind'] ?>" 
                style="width:200px; height:200px; margin-bottom: 5px; object-fit: cover;" 
                onerror="this.onerror=null; this.src='/assets-baru/img/error_logo1.png';"
            /><br>
            <strong><?= $lang === 'en' ? $wisata['nama_wisata_eng'] : $wisata['nama_wisata_ind'] ?></strong><br>
            <?= $wisata['nama_kotakabupaten'] ?>, <?= $wisata['nama_provinsi'] ?><br>
            <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $wisata['wisata_latitude'] ?>,<?= $wisata['wisata_longitude'] ?>" target="_blank" class="popup-button"><?= $lang === 'en' ? 'Get Directions' : 'Petunjuk Arah' ?></a>
        </div>
    `).openPopup();
    </script>


    <!-- Menggunakan jQuery untuk AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Menyembunyikan overlay loading saat halaman pertama dimuat
            $('#loading-overlay').show(); // Menampilkan overlay loading

            // Mendapatkan path bahasa saat ini (id atau en)
            var currentLang = window.location.pathname.split('/')[1]; // id atau en

            // Menentukan URL AJAX sesuai dengan bahasa yang dipilih
            var ajaxUrl = '/' + currentLang + '/ajax/load-data';

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
    <br>


    <style>
        .promotional-section {
            background-color: #f8f9fa;
            /* Light background */
            border-radius: 10px;
            /* Rounded corners */
            padding: 20px;
            /* Padding for spacing */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Soft shadow */
            margin-bottom: 30px;
            /* Space below the section */
            animation: growShrink 2s infinite;
            /* Apply grow and shrink animation */
        }

        /* Keyframes for the grow and shrink effect */
        @keyframes growShrink {

            0%,
            100% {
                transform: scale(1);
                /* Original size */
            }

            50% {
                transform: scale(1.05);
                /* Slightly larger */
            }
        }

        /* Import Animate.css for fade-in effect */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');


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
            font-size: 11px;
            /* Adjust this value to change the font size */
        }

        .image-container {
            position: relative;
        }

        .sumber-foto {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            /* White background with slight transparency */
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }

        .sumber-foto p {
            margin: 0;
            color: #333;
            /* Darker text color for contrast */
        }
    </style>

    <?php
    // Panggil PopupController untuk mengecek popup
    $popupController = new \App\Controllers\User\PopupController();
    echo $popupController->checkPopup();
    ?>

    <?= $this->endSection('content'); ?>