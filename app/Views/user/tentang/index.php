<?= $this->extend('user/template/template') ?>
<?= $this->Section('content'); ?>

<div class="container-fluid pt-5 mb-3">
    <div class="container">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold"><?php echo lang('Blog.btnAboutme'); ?></h4>
        </div>
        <div class="bg-white border border-top-0 p-4 mb-3">
            <div class="mb-4 tentang-kami">
                <?php foreach ($tentang as $row) : ?>
                    <div>
                        <h1 class="text-uppercase font-weight-bold"><?= $row['nama_tentang']; ?></h1>

                        <?php
                        // Menampilkan deskripsi sesuai bahasa
                        if (session('lang') === 'id') {
                            echo '<p class="mb-4">' . $row['deskripsi_tentang'] . '</p>';
                        } else {
                            echo '<p class="mb-4">' . $row['deskripsi_tentang_en'] . '</p>';
                        }
                        ?>

                        <?php
                        // Periksa apakah pengguna memiliki foto
                        $userPhotoUrl = base_url('assets-baru/img/' . $row['foto_tentang']);
                        if (!empty($row['foto_tentang']) && file_exists('assets-baru/img/' . $row['foto_tentang'])) {
                        ?>
                            <div class="text-center">
                                <img class="img-fluid" src="<?= $userPhotoUrl; ?>" alt="" loading="lazy">
                            </div>
                        <?php } ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>

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

<?php
// Panggil PopupController untuk mengecek popup
$popupController = new \App\Controllers\user\PopupController();
echo $popupController->checkPopup();
?>


<?= $this->endSection('content') ?>