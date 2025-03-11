<?= $this->extend('user/template/template') ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12 mt-5">
            <div class="section-title">
                <h1 class="m-0 text-uppercase font-weight-bold h4"><?= esc($title); ?></h1>
            </div>
        </div>

        <?php
        // Sort the articles by 'tgl_publish' in descending order
        usort($artikel, function ($a, $b) {
            return strtotime($b->tgl_publish) - strtotime($a->tgl_publish);
        });
        ?>

        <!-- Display filtered articles -->
        <?php if (!empty($artikel)) : ?>
            <?php foreach ($artikel as $row) : ?>
                <div class="col-lg-4 mb-4">

                    <a href="<?= base_url($lang . '/' . ($lang === 'en' ? 'article' : 'artikel') . '/' . strtolower(str_replace(' ', '-', ($lang === 'en' ? $row->slug_kategori_en : $row->slug_kategori))) . '/' . ($lang === 'en' ? $row->slug_en : $row->slug)) ?>" class="text-decoration-none artikel-link">
                        <div class="position-relative d-flex flex-column h-100 mb-3 artikel-card">
                            <?php
                            // Set the default image path
                            $defaultImage = base_url('assets-baru/img/error_logo.webp');

                            // Check if the article image exists, use the default image if it doesn't
                            $imagePath = 'assets-baru/img/foto_artikel/' . $row->foto_artikel;
                            $imageToDisplay = file_exists(FCPATH . $imagePath) && !empty($row->foto_artikel) ? base_url($imagePath) : $defaultImage;
                            ?>

                            <img class="img-fluid w-100 lazyload" style="object-fit: cover;" src="<?= $imageToDisplay ?>" loading="lazy">

                            <div class="bg-white border border-top-0 p-4 flex-grow-1">
                                <div class="mb-2">
                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2 
                                        <?= current_url() === base_url($lang . ($lang === 'en' ? '/categories/' : '/kategori/') .
                                            ($lang === 'en' ? ($row->slug_kategori_en ?? '') : ($row->slug_kategori ?? ''))) ? 'active' : '' ?>"
                                        href="<?= base_url($lang . ($lang === 'en' ? '/categories/' : '/kategori/') .
                                                    ($lang === 'en' ? ($row->slug_kategori_en ?? '') : ($row->slug_kategori ?? ''))) ?>">
                                        <?= esc($lang === 'en' ? ($row->slug_kategori_en ?? 'Unknown Category') : ($row->slug_kategori ?? 'Unknown Category')) ?>
                                    </a>
                                </div>
                                <p class="text-body"><?= date('d F Y', strtotime($row->tgl_publish)); ?></p>

                                <a class="h4 d-block mb-3 text-secondary font-weight-bold" href="<?= base_url($lang . '/' . ($lang === 'en' ? 'article' : 'artikel') . '/' . strtolower(str_replace(' ', '-', ($lang === 'en' ? $row->slug_kategori_en : $row->slug_kategori))) . '/' . ($lang === 'en' ? $row->slug_en : $row->slug))  ?>">
                                    <?= esc($lang === 'en' ? $row->judul_artikel_en : $row->judul_artikel) ?>
                                </a>

                                <p style="margin-bottom: -4rem;">
                                    <?= esc(substr(strip_tags($lang === 'en' ? $row->deskripsi_artikel_en : $row->deskripsi_artikel), 0, 200)); ?>...
                                </p>
                            </div>
                            <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                <!-- Optional: Additional information like author name or view count can be added here -->
                            </div>
                        </div>
                    </a>
                </div>

            <?php endforeach; ?>
        <?php else : ?>
            <p>No articles available.</p>
        <?php endif; ?>
    </div>

    <div class="pagination-container mb-4">
        <?= $pager->links('artikel', 'default_pagination') ?>
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
        height: 250px;
        object-fit: cover;
        border-radius: 15px 15px 0 0;
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
$popupController = new \App\Controllers\user\PopupController();
echo $popupController->checkPopup();
?>

<?= $this->endSection('content'); ?>