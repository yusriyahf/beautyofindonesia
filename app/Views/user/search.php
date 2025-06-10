<?= $this->extend('user/template/template') ?>
<?= $this->Section('content'); ?>


<!-- News With Sidebar Start -->
<div class="container-fluid mt-5 pt-3">
    <div class="container">
        <div class="row">

            <!-- START WISATA -->
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h4 class="m-0 text-uppercase font-weight-bold"><?= esc($titleWisata); ?></h4>
                        </div>
                    </div>
                    <?php if (!empty($wisata)): ?>
                        <?php $count = 0; ?>
                        <?php foreach ($wisata as $row) : ?>
                            <div class="col-lg-4 mb-3 wisata-item" data-index="<?= $count; ?>" <?= $count >= 3 ? 'style="display: none;"' : '' ?>>
                                <div class="artikel-card position-relative d-flex flex-column h-100 mb-3">
                                    <a class="artikel-link" href="<?= base_url(
                                                                        $lang . '/' .
                                                                            ($lang === 'en' ? 'article' : 'artikel') . '/' .
                                                                            strtolower(str_replace(' ', '-', ($lang === 'en' ? $row['slug_kategori_wisata_en'] : $row['slug_kategori_wisata']))) . '/' .
                                                                            ($lang === 'en' ? $row['slug_wisata_eng'] : $row['slug_wisata_ind'])
                                                                    )  ?>">
                                        <?php
                                        // Set the default image path
                                        $defaultImage = base_url('assets-baru/img/error_logo.webp');

                                        // Check if the article image exists, use the default image if it doesn't
                                        $imagePath = 'asset-user/uploads/foto_wisata/' . $row['foto_wisata'];
                                        $imageToDisplay = file_exists(FCPATH . '/' . $imagePath) && !empty($row['foto_wisata']) ? base_url($imagePath) : $defaultImage;
                                        ?>

                                        <img class="img-fluid w-100" style="height: 150px; object-fit: cover; border-radius: 15px 15px 0 0;" src="<?= $imageToDisplay ?>" loading="lazy">

                                        <div class="bg-white border border-top-0 p-4 flex-grow-1">
                                            <div class="mb-2">
                                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2 
        <?= current_url() === base_url($lang . ($lang === 'en' ? '/destinations/' : '/wisata/') .
                                ($lang === 'en' ? ($row['slug_kategori_wisata_en'] ?? '') : ($row['slug_kategori_wisata'] ?? ''))) ? 'active' : '' ?>"
                                                    href="<?= base_url($lang . ($lang === 'en' ? '/destinations/' : '/wisata/') .
                                                                ($lang === 'en' ? ($row['slug_kategori_wisata_en'] ?? '') : ($row['slug_kategori_wisata'] ?? ''))) ?>">
                                                    <?= esc($lang === 'en' ? ($row['nama_kategori_wisata_en'] ?? 'Unknown Category') : ($row['nama_kategori_wisata'] ?? 'Unknown Category')) ?>
                                                </a>

                                            </div>
                                            <p class="text-body">
                                                <small class="location">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span class="location-details">

                                                        <?php
                                                        $provinsiSlug = $lang === 'en'
                                                            ? ($row['provinsi_slug_eng'] ?? strtolower(str_replace(' ', '-', $row['nama_provinsi_eng'] ?? '')))
                                                            : ($row['provinsi_slug'] ?? strtolower(str_replace(' ', '-', $row['nama_provinsi'] ?? '')));
                                                        $kabupatenSlug = $lang === 'en'
                                                            ? ($row['kabupaten_slug_eng'] ?? strtolower(str_replace(' ', '-', $row['nama_kotakabupaten_eng'] ?? '')))
                                                            : ($row['kabupaten_slug'] ?? strtolower(str_replace(' ', '-', $row['nama_kotakabupaten'] ?? '')));
                                                        ?>

                                                        <span class="kabupaten">
                                                            <a class="kabupaten font-weight-bold" href="<?= base_url("$lang/wisata?provinsiSlug={$provinsiSlug}&kabupatenSlug={$kabupatenSlug}") ?>">
                                                                <?= esc($lang === 'en' ? ($row['nama_kotakabupaten_eng'] ?? 'Unknown City') : ($row['nama_kotakabupaten'] ?? 'Unknown City')) ?>
                                                            </a>
                                                        </span>
                                                        <span class="provinsi">
                                                            <a class="kabupaten font-weight-bold" href="<?= base_url("$lang/wisata?provinsiSlug={$provinsiSlug}") ?>">
                                                                <?= esc($lang === 'en' ? ($row['nama_provinsi_eng'] ?? 'Unknown Province') : ($row['nama_provinsi'] ?? 'Unknown Province')) ?>
                                                            </a>
                                                        </span>
                                                    </span>

                                                </small>
                                            </p>

                                            <?php
                                            // Check the current language
                                            $currentLang = session('lang');
                                            ?>

                                            <a class="h4 d-block mb-3 text-secondary font-weight-bold" href="<?= base_url(
                                                                                                                    $lang . '/' .
                                                                                                                        ($lang === 'en' ? 'article' : 'artikel') . '/' .
                                                                                                                        strtolower(str_replace(' ', '-', ($lang === 'en' ? $row['slug_kategori_wisata_en'] : $row['slug_kategori_wisata_en']))) . '/' .
                                                                                                                        ($lang === 'en' ? $row['slug_wisata_eng'] : $row['slug_wisata_ind'])
                                                                                                                ) ?>">
                                                <?php if ($currentLang === 'en'): ?>
                                                    <?= $row['nama_wisata_eng']; ?>
                                                <?php else: ?>
                                                    <?= $row['nama_wisata_ind']; ?>
                                                <?php endif; ?>
                                            </a>

                                            <p style="margin-bottom: -65px;">
                                                <?php if ($currentLang === 'en'): ?>
                                                    <?= substr(strip_tags($row['deskripsi_wisata_eng']), 0, 100); ?>...
                                                <?php else: ?>
                                                    <?= substr(strip_tags($row['deskripsi_wisata_ind']), 0, 100); ?>...
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-between bg-white border border-top-0 p-4" style="border-radius: 0 0 15px 15px;">
                                            <!-- Optional footer for author and views -->
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php $count++; ?>
                        <?php endforeach; ?>
                        <div class="col-12 text-center">
                            <button id="loadMoreWisata" class="btn btn-primary mt-3 mb-3"><?= $lang === 'id' ? 'Tampilkan Lebih' : 'Show More'; ?></button>
                        </div>
                        <style>
                            /* Styling card article */
                            .artikel-card {
                                border-radius: 15px;
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                transition: transform 0.3s, box-shadow 0.3s;
                            }

                            .artikel-card:hover {
                                transform: translateY(-10px);
                                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                            }

                            /* Make the entire card a link */
                            .artikel-link {
                                display: block;
                                text-decoration: none;
                                color: inherit;
                            }

                            /* Views counter styling */
                            .views-counter {
                                color: #0091EA;
                                transition: color 0.3s;
                            }
                        </style>
                    <?php else : ?>
                        <div class="col-lg-12">
                            <div class="position-relative mb-3">
                                <div class="bg-white border p-4">
                                    <p><?= $lang === 'id' ? 'Tidak ada Tempat Wisata terkait.' : 'No related tourist attractions.'; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- END TEMPAT WISATA -->

            <!-- START OLEH OLEH -->
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h4 class="m-0 text-uppercase font-weight-bold"><?= esc($titleOlehOleh); ?></h4>
                        </div>
                    </div>
                    <?php if (!empty($oleholeh)): ?>
                        <?php $count = 0; ?>
                        <?php foreach ($oleholeh as $row) : ?>
                            <div class="col-lg-4 mb-3 oleholeh-item" data-index="<?= $count; ?>" <?= $count >= 3 ? 'style="display: none;"' : '' ?>>
                                <div class="artikel-card position-relative d-flex flex-column h-100 mb-3">
                                    <a class="artikel-link" href="<?= base_url(
                                                                        $lang . '/' .
                                                                            ($lang === 'en' ? 'souvenirs' : 'oleh-oleh') . '/' .
                                                                            strtolower(str_replace(' ', '-', ($lang === 'en' ? $row['slug_kategori_oleholeh_en'] : $row['slug_kategori_oleholeh']))) . '/' .
                                                                            ($lang === 'en' ? $row['slug_en'] : $row['slug_oleholeh'])
                                                                    )  ?>">

                                        <?php
                                        // Set the default image path
                                        $defaultImage = base_url('assets-baru/img/error_logo.webp');

                                        // Check if the article image exists, use the default image if it doesn't
                                        $imagePath = '/assets-baru/img/foto_oleholeh/' . $row['foto_oleholeh'];
                                        $imageToDisplay = file_exists(FCPATH . '/' . $imagePath) && !empty($row['foto_oleholeh']) ? base_url($imagePath) : $defaultImage;
                                        ?>

                                        <img class="img-fluid w-100" style="height: 150px; object-fit: cover; border-radius: 15px 15px 0 0;" src="<?= $imageToDisplay ?>" loading="lazy">



                                        <div class="bg-white border border-top-0 p-4 flex-grow-1">
                                            <div class="mb-2">
                                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="<?= base_url($lang . ($lang === 'en' ? '/souvenirs/' : '/oleh-oleh/') .
                                                                                                                                        ($lang === 'en' ? ($row['slug_kategori_oleholeh_en'] ?? '') : ($row['slug_kategori_oleholeh'] ?? ''))) ?>">
                                                    <?= esc($lang === 'en' ? $row['nama_kategori_oleholeh_en'] : $row['nama_kategori_oleholeh']) ?>
                                                </a>
                                            </div>
                                            <p class=" text-body">
                                                <small class="location">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span class="location-details">

                                                        <?php
                                                        $provinsiSlug = $lang === 'en'
                                                            ? ($row['provinsi_slug_eng'] ?? strtolower(str_replace(' ', '-', $row['nama_provinsi_eng'] ?? '')))
                                                            : ($row['provinsi_slug'] ?? strtolower(str_replace(' ', '-', $row['nama_provinsi'] ?? '')));
                                                        $kabupatenSlug = $lang === 'en'
                                                            ? ($row['kabupaten_slug_eng'] ?? strtolower(str_replace(' ', '-', $row['nama_kotakabupaten_eng'] ?? '')))
                                                            : ($row['kabupaten_slug'] ?? strtolower(str_replace(' ', '-', $row['nama_kotakabupaten'] ?? '')));
                                                        ?>

                                                        <span class="kabupaten">
                                                            <a class="kabupaten font-weight-bold" href="<?= base_url("$lang/wisata?provinsiSlug={$provinsiSlug}&kabupatenSlug={$kabupatenSlug}") ?>">
                                                                <?= esc($lang === 'en' ? ($row['nama_kotakabupaten_eng'] ?? 'Unknown City') : ($row['nama_kotakabupaten'] ?? 'Unknown City')) ?>
                                                            </a>
                                                        </span>
                                                        <span class="provinsi">
                                                            <a class="kabupaten font-weight-bold" href="<?= base_url("$lang/wisata?provinsiSlug={$provinsiSlug}") ?>">
                                                                <?= esc($lang === 'en' ? ($row['nama_provinsi_eng'] ?? 'Unknown Province') : ($row['nama_provinsi'] ?? 'Unknown Province')) ?>
                                                            </a>
                                                        </span>
                                                    </span>

                                                </small>
                                            </p>
                                            <a class="h4 d-block mb-3 text-secondary font-weight-bold" href="<?= base_url(
                                                                                                                    $lang . '/' .
                                                                                                                        ($lang === 'en' ? 'souvenirs' : 'oleh-oleh') . '/' .
                                                                                                                        strtolower(str_replace(' ', '-', ($lang === 'en' ? $row['slug_kategori_oleholeh_en'] : $row['slug_kategori_oleholeh']))) . '/' .
                                                                                                                        ($lang === 'en' ? $row['slug_en'] : $row['slug_oleholeh'])
                                                                                                                )  ?>">
                                                <?= $lang === 'en' ? $row['nama_oleholeh_eng'] : $row['nama_oleholeh']; ?>
                                            </a>
                                            <p style="margin-bottom: -65px;">
                                                <?php if ($lang === 'en'): ?>
                                                    <?= substr(strip_tags($row['deskripsi_oleholeh_eng']), 0, 100); ?>...
                                                <?php else: ?>
                                                    <?= substr(strip_tags($row['deskripsi_oleholeh']), 0, 100); ?>...
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-between bg-white border border-top-0 py-3 px-4" style="border-radius: 0 0 15px 15px;">
                                            <small><i class="far fa-eye mr-2"></i>views <?= esc($row['views']); ?></small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php $count++; ?>
                        <?php endforeach; ?>
                        <div class="col-12 text-center">
                            <button id="loadMoreOlehOleh" class="btn btn-primary mt-3 mb-3">
                                <?= $lang === 'id' ? 'Tampilkan Lebih' : 'Show More'; ?>
                            </button>
                        </div>



                        <style>
                            .artikel-card {
                                border-radius: 15px;
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                transition: transform 0.3s, box-shadow 0.3s;
                            }

                            .artikel-card:hover {
                                transform: translateY(-10px);
                                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                            }

                            .artikel-link {
                                display: block;
                                text-decoration: none;
                                color: inherit;
                            }

                            .views-counter {
                                color: #0091EA;
                                transition: color 0.3s;
                            }
                        </style>
                    <?php else : ?>
                        <div class="col-lg-12">
                            <div class="position-relative mb-3">
                                <div class="bg-white border p-4">
                                    <p><?= $lang === 'id' ? 'Tidak ada Oleh Oleh terkait.' : 'No related souvenirs.'; ?></p>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
            <!-- END OLEH OLEH -->

            <!-- START ARTIKEL -->
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h4 class="m-0 text-uppercase font-weight-bold"><?= esc($titleArtikel); ?></h4>
                        </div>
                    </div>
                    <?php if (!empty($artikel)): ?>
                        <?php $count = 0; ?>
                        <?php foreach ($artikel as $row) : ?>
                            <div class="col-lg-4 mb-3 artikel-item" data-index="<?= $count; ?>" <?= $count >= 3 ? 'style="display: none;"' : '' ?>>
                                <div class="artikel-card position-relative d-flex flex-column h-100 mb-3">
                                    <a class="artikel-link" href="<?= base_url(
                                                                        $lang . '/' .
                                                                            ($lang === 'en' ? 'article' : 'artikel') . '/' .
                                                                            strtolower(str_replace(' ', '-', ($lang === 'en' ? $row['slug_kategori_en'] : $row['slug_kategori']))) . '/' .
                                                                            ($lang === 'en' ? $row['slug_en'] : $row['slug'])
                                                                    )  ?>">
                                        <img class="img-fluid w-100" style="height: 150px; object-fit: cover; border-radius: 15px 15px 0 0;" src="<?= base_url('assets-baru/img/foto_artikel/' . $row['foto_artikel']) ?>" loading="lazy">

                                        <div class="bg-white border border-top-0 p-4 flex-grow-1">
                                            <div class="mb-2">
                                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="<?= base_url($lang . ($lang === 'en' ? '/articles/' : '/artikel/') .
                                                                                                                                        ($lang === 'en' ? ($row['slug_kategori_en'] ?? '') : ($row['slug_kategori'] ?? ''))) ?>">
                                                    <?= esc($lang === 'en' ? $row['nama_kategori_en'] : $row['nama_kategori']) ?>
                                                </a>
                                            </div>
                                            <p class="text-body"><small><?= date('d F Y', strtotime($row['tgl_publish'])); ?></small></p>
                                            <a class="h4 d-block mb-3 text-secondary font-weight-bold" href="<?= base_url(
                                                                                                                    $lang . '/' .
                                                                                                                        ($lang === 'en' ? 'article' : 'artikel') . '/' .
                                                                                                                        strtolower(str_replace(' ', '-', ($lang === 'en' ? $row['slug_kategori_en'] : $row['slug_kategori']))) . '/' .
                                                                                                                        ($lang === 'en' ? $row['slug_en'] : $row['slug'])
                                                                                                                )  ?>">
                                                <?= $lang === 'en' ? $row['judul_artikel_en'] : $row['judul_artikel']; ?>
                                            </a>
                                            <p style="margin-bottom: -65px;">
                                                <?php if ($lang === 'en'): ?>
                                                    <?= substr(strip_tags($row['deskripsi_artikel_en']), 0, 100); ?>...
                                                <?php else: ?>
                                                    <?= substr(strip_tags($row['deskripsi_artikel']), 0, 100); ?>...
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-between bg-white border border-top-0 p-4" style="border-radius: 0 0 15px 15px;">
                                            <!-- Optional footer for author and views -->
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php $count++; ?>
                        <?php endforeach; ?>
                        <div class="col-12 text-center">
                            <button id="loadMoreArtikel" class="btn btn-primary mt-3 mb-3"><?= $lang === 'id' ? 'Tampilkan Lebih' : 'Show More'; ?></button>
                        </div>


                        <style>
                            /* Styling card article */
                            .artikel-card {
                                border-radius: 15px;
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                transition: transform 0.3s, box-shadow 0.3s;
                            }

                            .artikel-card:hover {
                                transform: translateY(-10px);
                                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                            }

                            /* Make the entire card a link */
                            .artikel-link {
                                display: block;
                                text-decoration: none;
                                color: inherit;
                            }

                            /* Views counter styling */
                            .views-counter {
                                color: #0091EA;
                                transition: color 0.3s;
                            }
                        </style>
                    <?php else : ?>
                        <div class="col-lg-12">
                            <div class="position-relative mb-3">
                                <div class="bg-white border p-4">
                                    <p><?= $lang === 'id' ? 'Tidak ada Oleh Oleh terkait.' : 'No related souvenirs.'; ?></p>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
            <!-- END ARTIKEL -->

        </div>
    </div>
</div>
<!-- News With Sidebar End -->

<?php
$popupController = new \App\Controllers\User\PopupController();
echo $popupController->checkPopup();
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let visibleCountArticles = 3; // Artikel yang terlihat awalnya
        const incrementArticles = 6; // Jumlah artikel yang ditampilkan setiap kali tombol diklik
        const articles = document.querySelectorAll(".artikel-item");
        const loadMoreArticlesBtn = document.getElementById("loadMoreArtikel");

        loadMoreArticlesBtn.addEventListener("click", function() {
            let newVisibleCountArticles = visibleCountArticles + incrementArticles;

            // Menampilkan artikel tambahan
            for (let i = visibleCountArticles; i < newVisibleCountArticles && i < articles.length; i++) {
                articles[i].style.display = "block";
            }

            visibleCountArticles = newVisibleCountArticles;

            // Sembunyikan tombol jika semua artikel sudah ditampilkan
            if (visibleCountArticles >= articles.length) {
                loadMoreArticlesBtn.style.display = "none";
            }
        });

        let visibleCountOlehOleh = 3; // Artikel yang terlihat awalnya
        const incrementOlehOleh = 6; // Jumlah artikel yang ditampilkan setiap kali tombol diklik
        const olehOleh = document.querySelectorAll(".oleholeh-item");
        const loadMoreOlehOlehBtn = document.getElementById("loadMoreOlehOleh");

        loadMoreOlehOlehBtn.addEventListener("click", function() {
            let newVisibleCountOlehOleh = visibleCountOlehOleh + incrementOlehOleh;

            // Menampilkan artikel tambahan
            for (let i = visibleCountOlehOleh; i < newVisibleCountOlehOleh && i < olehOleh.length; i++) {
                olehOleh[i].style.display = "block";
            }

            visibleCountOlehOleh = newVisibleCountOlehOleh;

            // Sembunyikan tombol jika semua artikel sudah ditampilkan
            if (visibleCountOlehOleh >= wisata.length) {
                loadMoreOlehOlehBtn.style.display = "none";
            }
        });


        let visibleCountWisata = 3; // Artikel yang terlihat awalnya
        const incrementWisata = 6; // Jumlah artikel yang ditampilkan setiap kali tombol diklik
        const wisata = document.querySelectorAll(".wisata-item");
        const loadMoreWisataBtn = document.getElementById("loadMoreWisata");
        loadMoreWisataBtn.addEventListener("click", function() {
            let newVisibleCountWisata = visibleCountWisata + incrementWisata;

            // Menampilkan artikel tambahan
            for (let i = visibleCountWisata; i < newVisibleCountWisata && i < wisata.length; i++) {
                wisata[i].style.display = "block";
            }

            visibleCountWisata = newVisibleCountWisata;

            // Sembunyikan tombol jika semua artikel sudah ditampilkan
            if (visibleCountWisata >= wisata.length) {
                loadMoreWisataBtn.style.display = "none";
            }
        });
    });
</script>


<?= $this->endSection('content'); ?>