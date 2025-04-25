<?= $this->extend('user/template/template') ?>
<?= $this->Section('content'); ?>

<!-- News With Sidebar Start -->
<div class="container-fluid pt-5 mb-3">
    <div class="container">
        <div class="row">

            <div class="col-lg-8">
                <!-- News Detail Start -->
                <?php if (!empty($artikel['iklan_banner']) && $artikel['iklan_banner'] == 'ada') : ?>
                    <img src="<?= base_url('assets-baru/img/banner_utama.png'); ?>" alt="" width="100%" class="mb-3">
                <?php else : ?>
                    <img src="<?= base_url('assets-baru/img/banner_utama2.png'); ?>" alt="" width="100%" class="mb-3">
                <?php endif; ?>

                <div class="position-relative mb-3">
                    <div class="image-container">
                        <?php
                        // Set the default image path
                        $defaultImage = base_url('assets-baru/img/error_logo.webp');

                        // Check if the article image exists, use the default image if it doesn't
                        $imagePath = 'assets-baru/img/foto_artikel/' . $artikel['foto_artikel'];
                        $imageToDisplay = file_exists(FCPATH . $imagePath) && !empty($artikel['foto_artikel']) ? base_url($imagePath) : $defaultImage;
                        ?>

                        <img class="img-fluid w-100 lazyload" src="<?= $imageToDisplay ?>" style="object-fit: cover;" loading="lazy">

                        <?php if (!empty($artikel['sumber_foto'])): ?>
                            <div class="sumber-foto">
                                <p><?= lang('Blog.btnSource') ?> : <?= $artikel['sumber_foto']; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="bg-white border border-top-0 p-4">
                        <div class="mb-3">
                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2 <?= current_url() === base_url($lang . ($lang === 'en' ? '/categories/' : '/kategori/') . ($lang === 'en' ? $artikel['slug_kategori_en'] : $artikel['slug_kategori'])) ? 'active' : '' ?>" href="<?= base_url($lang . ($lang === 'en' ? '/categories/' : '/kategori/') . ($lang === 'en' ? $artikel['slug_kategori_en'] : $artikel['slug_kategori'])) ?>">
                                <?= esc($lang === 'en' ? $artikel['nama_kategori_en'] : $artikel['nama_kategori'] ?? 'Unknown Category') ?>
                            </a>
                        </div>
                        <p class="text-body"><?= date('d F Y', strtotime($artikel['tgl_publish'])); ?></p>
                        <h1 class="mb-3 text-secondary font-weight-bold">
                            <?= session('lang') === 'en' ? $artikel['judul_artikel_en'] : $artikel['judul_artikel']; ?>
                        </h1>

                        <?= session('lang') === 'en'
                            ? str_replace(
                                ['<h1>', '</h1>', '<h2>', '</h2>'],
                                ['<h1 class="h2">', '</h1>', '<h2 class="h4">', '</h2>'],
                                $artikel['deskripsi_artikel_en']
                            )
                            : str_replace(
                                ['<h1>', '</h1>', '<h2>', '</h2>'],
                                ['<h1 class="h2">', '</h1>', '<h2 class="h4">', '</h2>'],
                                $artikel['deskripsi_artikel']
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
                <!-- News Detail End -->
            </div>


            <div class="col-lg-4">
                <img src="<?= base_url('assets-baru/img/banner_sidebar.png'); ?>" alt="" width="100%" class="mb-3">
                <!-- Popular News Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold"><?php echo lang('Blog.btnReadmore'); ?></h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">

                        <?php foreach ($artikel_lain as $artikel_item) :
                            // Check the current language
                            $lang = session('lang');

                            $slug_kategori = $lang === 'en' ? ($artikel_item['slug_kategori_en'] ?? $artikel_item['slug_kategori']) : $artikel_item['slug_kategori'];

                            // Define the article slug based on the language.
                            $slug = $lang === 'en' ? ($artikel_item['slug_en'] ?? $artikel_item['slug']) : $artikel_item['slug'];
                        ?>
                            <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                <?php
                                $defaultImage = base_url('assets-baru/img/error_logo1.png');

                                $imagePath = 'assets-baru/img/foto_artikel/' . $artikel_item['foto_artikel'];
                                $imageToDisplay = file_exists(FCPATH . $imagePath) && !empty($artikel_item['foto_artikel']) ? base_url($imagePath) : $defaultImage;
                                ?>

                                <img class="img-fluid lazyload" style="width: 110px; object-fit: cover; height: 110px;" src="<?= $imageToDisplay ?>" alt="" loading="lazy">

                                <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                    <div class="mb-3">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2 <?= current_url() === base_url($lang . ($lang === 'en' ? '/categories/' : '/kategori/') . ($lang === 'en' ? $artikel_item['slug_kategori_en'] : $artikel_item['slug_kategori'])) ? 'active' : '' ?>" href="<?= base_url($lang . ($lang === 'en' ? '/categories/' : '/kategori/') . ($lang === 'en' ? $artikel_item['slug_kategori_en'] : $artikel_item['slug_kategori'])) ?>">
                                            <?= esc($lang === 'en' ? $artikel_item['nama_kategori_en'] : $artikel_item['nama_kategori'] ?? 'Unknown Category') ?>
                                        </a>

                                    </div>
                                    <a class="h6 m-0 text-secondary font-weight-bold"
                                        href="<?= base_url(
                                                    $lang . '/' .
                                                        ($lang === 'en' ? 'article' : 'artikel') . '/' .
                                                        strtolower(str_replace(' ', '-', $slug_kategori)) . '/' .
                                                        $slug
                                                ) ?>"
                                        title="<?= $lang === 'en' ? $artikel_item['judul_artikel_en'] : $artikel_item['judul_artikel'] ?>">
                                        <?= $lang === 'en' ? $artikel_item['judul_artikel_en'] : $artikel_item['judul_artikel'] ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Popular News End -->

                <!-- Tags Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Tags</h4>
                    </div>
                    <!-- <div class="bg-white border border-top-0 p-3">
                            <div class="d-flex flex-wrap m-n1">
                                <a href="" class="btn btn-sm btn-outline-secondary m-1"><?= $artikel['tags']; ?></a>
                            </div>
                        </div> -->
                    <div class="bg-white border border-top-0 p-3">
                        <div class="d-flex flex-wrap m-n1">
                            <?php
                            // Tentukan tags berdasarkan bahasa yang dipilih
                            $tags = preg_split('/#/', $lang === 'en' ? $artikel['tags_en'] : $artikel['tags'], -1, PREG_SPLIT_NO_EMPTY);
                            ?>
                            <?php foreach ($tags as $tag) : ?>
                                <a href="<?= base_url($lang === 'en' ? $lang . '/tag?q=' . urlencode(trim($tag)) : $lang . '/tag?q=' . urlencode(trim($tag))) ?>"
                                    class="btn btn-sm btn-outline-secondary m-1">
                                    #<?= trim($tag) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- Tags End -->
            </div>

            <div class="col-lg-12">
                <img src="<?= base_url('assets-baru/img/banner_footer.png'); ?>" alt="" width="100%" class="mb-3">
            </div>
        </div>
    </div>
</div>
<!-- News With Sidebar End -->


<div class="col-lg-12 text-center mt-4 mb-5">
    <!-- Slogan di tengah dengan jarak sama di atas dan bawah -->
    <h6 class="slogan text-uppercase font-weight-bold mb-4"><?php echo lang('Blog.headerMaps'); ?></h6>
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
<br>

<style>
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
$popupController = new \App\Controllers\user\PopupController();
echo $popupController->checkPopup();
?>

<?= $this->endSection('content'); ?>