<?= $this->extend('user/template/template') ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-md-12 text-center">

            <?php if ($iklanHeaderCek): ?>
                <?php if ($iklanHeaderCek['status'] === 'tidak'): ?>

                    <img src="<?= base_url('assets-baru/img/banner_utama.png'); ?>" alt="" width="100%" class="mt-2" loading="lazy">

                <?php else: ?>
                    <a href="<?= esc($iklanHeader['link_iklan']) ?>" target="_blank">
                        <img src="<?= base_url('assets/images/iklan_utama/' . esc($iklanHeader['thumbnail_iklan'])) ?>" alt="" width="100%" class="mt-2" loading="lazy">
                    </a>
                <?php endif; ?>
            <?php endif; ?>

        </div>

        <div class="col-12 mt-3">
            <div class="section-title">
                <h1 id="sectionTitle" class="m-0 text-uppercase font-weight-bold h4">
                    <?= esc($title); ?>
                </h1>
            </div>
        </div>


        <!-- Filter form -->
        <div class="col-12 mb-4">
            <form method="get" action="<?= base_url($lang === 'en' ? 'en/destinations' : 'id/wisata') ?>">

                <div class="row">
                    <!-- Provinsi Filter -->
                    <div class="col-md-5 mb-2">
                        <select name="provinsiSlug" id="provinsiSlug" class="form-control">
                            <option value=""><?= lang('Blog.btnAllProvinsi'); ?></option>
                            <?php foreach ($provinsiYus as $prov) : ?>
                                <option
                                    value="<?= esc($lang === 'id' ? $prov->slug_provinsi_ind : $prov->slug_provinsi_eng) ?>"
                                    <?= (isset($_GET['provinsiSlug']) && $_GET['provinsiSlug'] == ($lang === 'id' ? $prov->slug_provinsi_ind : $prov->slug_provinsi_eng)) ? 'selected' : '' ?>>
                                    <?= esc($lang === 'id' ? $prov->nama_provinsi : $prov->nama_provinsi_eng) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Kabupaten Filter -->
                    <div class="col-md-5 mb-2">
                        <select name="kabupatenSlug" id="kabupatenSlug" class="form-control">
                            <option value=""><?= lang('Blog.btnAllKabupaten'); ?></option>
                        </select>
                    </div>

                    <!-- Filter button -->
                    <div class="col-md-2 mb-2 align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                        <a href="<?= base_url($lang === 'en' ? $lang . '/souvenirs' : $lang . '/oleh-oleh') ?>" class="btn btn-secondary w-100 mt-2">Reset</a>
                    </div>
                </div>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                const lang = "<?= $lang; ?>";

                function updatePageTitle(title) {
                    document.title = title + " - BeautyOfIndonesia.com";
                }

                // Fungsi untuk mengupdate title section
                function updateSectionTitle(provinsiName, kabupatenName) {
                    let title = "<?= lang('Blog.btnDestinationssData'); ?>";

                    if (kabupatenName && kabupatenName !== "" && kabupatenName !== "<?= lang('Blog.btnAllKabupaten') ?>") {
                        title = lang === 'id' ?
                            `Wisata ${kabupatenName}` :
                            `Tourism in ${kabupatenName}`;

                    } else if (provinsiName && provinsiName !== "") {
                        title = lang === 'id' ?
                            `Wisata ${provinsiName}` :
                            `Tourism in ${provinsiName}`;
                    }

                    $('#sectionTitle').text(title);
                    updatePageTitle(title);
                }

                const initialProvinsiSlug = $('#provinsiSlug').val();
                const initialKabupatenSlug = "<?= isset($_GET['kabupatenSlug']) ? $_GET['kabupatenSlug'] : '' ?>";

                if (initialProvinsiSlug) {
                    $.ajax({
                        url: '<?= base_url("OlehOleh/getKabupatenByProvinsi") ?>/' + initialProvinsiSlug,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#kabupatenSlug').empty();
                            $('#kabupatenSlug').append('<option value="">' + "<?= lang('Blog.btnAllKabupaten') ?>" + '</option>');
                            $.each(data, function(key, kabupaten) {
                                $('#kabupatenSlug').append('<option value="' + kabupaten.slug_kotakabupaten + '"' + (kabupaten.slug_kotakabupaten === initialKabupatenSlug ? ' selected' : '') + '>' + kabupaten.nama_kotakabupaten + '</option>');
                            });

                            // Perbarui title section jika ada data awal
                            updateSectionTitle($('#provinsiSlug option:selected').text(), $('#kabupatenSlug option:selected').text());
                        },
                        error: function() {
                            alert('Error retrieving kabupaten data.');
                        }
                    });
                }

                // Load Kabupaten saat Provinsi diubah
                $('#provinsiSlug').change(function() {
                    var provinsiSlug = $(this).val();
                    $('#kabupatenSlug').empty();

                    if (provinsiSlug) {
                        $.ajax({
                            url: '<?= base_url("OlehOleh/getKabupatenByProvinsi") ?>/' + provinsiSlug,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                $('#kabupatenSlug').append('<option value="">' + "<?= lang('Blog.btnAllKabupaten') ?>" + '</option>');
                                $.each(data, function(key, kabupaten) {
                                    $('#kabupatenSlug').append('<option value="' + kabupaten.slug_kotakabupaten + '">' + kabupaten.nama_kotakabupaten + '</option>');
                                });

                                // Perbarui title section
                                updateSectionTitle($('#provinsiSlug option:selected').text(), "");
                            },
                            error: function() {
                                alert('Error retrieving kabupaten data.');
                            }
                        });
                    } else {
                        $('#kabupatenSlug').append('<option value="">' + "<?= lang('Blog.btnAllKabupaten') ?>" + '</option>');
                        // Perbarui title section
                        updateSectionTitle("", "");
                    }
                });

                // Ubah title saat Kabupaten diubah
                $('#kabupatenSlug').change(function() {
                    updateSectionTitle($('#provinsiSlug option:selected').text(), $('#kabupatenSlug option:selected').text());
                });

                $('form').submit(function(event) {
                    event.preventDefault(); // Mencegah form dikirim langsung

                    let form = $(this);
                    let provinsiSlug = $('#provinsiSlug').val();
                    let kabupatenSlug = $('#kabupatenSlug').val();
                    let url = form.attr('action'); // Ambil action dari form
                    let params = new URLSearchParams();

                    if (provinsiSlug) {
                        params.append('provinsiSlug', provinsiSlug);
                    }

                    if (kabupatenSlug) {
                        params.append('kabupatenSlug', kabupatenSlug);
                    }

                    let queryString = params.toString();
                    let finalUrl = queryString ? `${url}?${queryString}` : url;

                    window.location.href = finalUrl; // Redirect ke URL yang telah difilter
                });

            });
        </script>

        <!-- Display filtered wisata -->
        <?php if (!empty($tempatwisata) && is_array($tempatwisata)) :  ?>
            <?php foreach ($tempatwisata as $wisata) : ?>
                <div class="col-lg-4 mb-3">
                    <div class="artikel-card position-relative d-flex flex-column h-100 mb-3">
                        <a class="artikel-link" href=<?= base_url(
                                                            $lang . '/' .
                                                                ($lang === 'en' ? 'destinations' : 'wisata') . '/' .
                                                                strtolower(str_replace(' ', '-', ($lang === 'en' ? $wisata['nama_kategori_wisata_en'] : $wisata['nama_kategori_wisata']))) . '/' .
                                                                ($lang === 'en' ? $wisata['slug_wisata_eng'] : $wisata['slug_wisata_ind'])
                                                        ) ?>>
                            <?php
                            // Set the default image path
                            $defaultImage = base_url('assets-baru/img/error_logo.webp');

                            // Check if the wisata image exists, use the default image if it doesn't
                            $imagePath = 'asset-user/uploads/foto_wisata/' . $wisata['foto_wisata'];
                            $imageToDisplay = file_exists(FCPATH . $imagePath) && !empty($wisata['foto_wisata']) ? base_url($imagePath) : $defaultImage;
                            ?>

                            <img class="img-fluid w-100 lazyload" style="object-fit: cover;"
                                data-src="<?= esc($imageToDisplay) ?>"
                                alt="<?= esc($wisata['nama_wisata_eng'] ?? $wisata['nama_wisata']) ?>"
                                loading="lazy">



                            <div class="bg-white border border-top-0 p-4 flex-grow-1">
                                <div class="mb-2">
                                    <a href=<?= base_url(
                                                $lang . '/' .
                                                    ($lang === 'en' ? '/destinations/destinations-category/' : '/wisata/kategori-wisata/') . '/' .
                                                    strtolower(str_replace(' ', '-', ($lang === 'en' ? $wisata['nama_kategori_wisata_en'] : $wisata['nama_kategori_wisata'])))
                                            ) ?>
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
                                                <a class="kabupaten font-weight-bold" href="<?= base_url("$lang/wisata?provinsiSlug={$provinsiSlug}&kabupatenSlug={$kabupatenSlug}") ?>">
                                                    <?= esc($lang === 'en' ? ($wisata['nama_kotakabupaten_eng'] ?? 'Unknown City') : ($wisata['nama_kotakabupaten'] ?? 'Unknown City')) ?>
                                                </a>
                                            </span>
                                            <span class="provinsi">
                                                <a class="kabupaten font-weight-bold" href="<?= base_url("$lang/wisata?provinsiSlug={$provinsiSlug}") ?>">
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
        <?php else : ?>
            <p>No wisata data available.</p>
        <?php endif; ?>
    </div>






    <div class="col-md-12 text-center">

        <?php if ($iklanFooterCek): ?>
            <?php if ($iklanFooterCek['status'] === 'tidak'): ?>

                <img src="<?= base_url('assets-baru/img/banner_utama.png'); ?>" alt="" width="100%" class="mt-2" loading="lazy">

            <?php else: ?>
                <a href="<?= esc($iklanFooter['link_iklan']) ?>" target="_blank">
                    <img src="<?= base_url('assets/images/iklan_utama/' . esc($iklanFooter['thumbnail_iklan'])) ?>" alt="" width="80%" class="mt-2" loading="lazy">
                </a>
            <?php endif; ?>
        <?php endif; ?>

    </div>
    <div class="pagination-container mb-4">
        <?= $pager->links('tempatwisata', 'default_pagination') ?>
    </div>

</div>

<style>
    /* Styling card article */
    .artikel-card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        overflow: hidden;
        /* Ensures that the overflow is hidden */
    }

    .artikel-card img {
        width: 100%;
        /* Make the image fill the card width */
        height: 200px;
        /* Set a fixed height for uniformity */
        object-fit: cover;
        /* Ensure the image covers the area */
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

    /* Menambahkan transisi pada views-counter */
    .views-counter {
        color: #0091EA;
        transition: color 0.3s;
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

    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    /* Pagination Styling */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination li {
        margin: 0 5px;
        /* Jarak antar tombol */
    }

    .pagination a {
        display: inline-block;
        padding: 10px 15px;
        text-decoration: none;
        color: #007bff;
        font-size: 16px;
        font-weight: 600;
        border: 1px solid #ddd;
        background-color: #fff;
        transition: all 0.3s ease;
        border-radius: 5px;
        /* Sedikit lengkungan */
    }

    /* Hover Effect */
    .pagination a:hover {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    /* Active Page Styling */
    .pagination .active a {
        background-color: #007bff;
        /* Warna latar tombol aktif */
        color: #fff;
        /* Warna teks putih pada tombol aktif */
        border-color: #007bff;
        /* Border warna aktif */
        font-weight: bold;
        /* Menebalkan teks pada tombol aktif */
    }

    /* Disabled State */
    .pagination .disabled a {
        background-color: #f8f9fa;
        color: #6c757d;
        border-color: #ddd;
        cursor: not-allowed;
    }
</style>

<?php
// Panggil PopupController untuk mengecek popup
$popupController = new \App\Controllers\User\PopupController();
echo $popupController->checkPopup();
?>

<?= $this->endSection('content'); ?>