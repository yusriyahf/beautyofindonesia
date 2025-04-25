<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Artikel</h1>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?php echo base_url() . "admin/artikel/tambah" ?>" class="btn btn-primary me-md-2">+ Tambah Artikel</a>
            </div>
        </div>

        <!-- Date Filter Form -->
        <form method="get" action="<?= base_url('admin/artikel') ?>" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 me-2" style="background-color: #0d6efd; border-color: #0d6efd; color: white;">
                        Filter
                    </button>

                    <a href="<?= base_url('admin/artikel/index') ?>" class="btn btn-secondary w-100">Tampilkan Semua</a>
                </div>

            </div>
        </form>

        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead class="atas">
                                    <tr>
                                        <th class="text-center" valign="middle">No</th>
                                        <th class="text-center" valign="middle">Judul Artikel</th>
                                        <th class="text-center" valign="middle">Judul Artikel (English)</th>
                                        <th class="text-center" valign="middle">Kategori Artikel</th>
                                        <th class="text-center" valign="middle">Penulis Artikel</th>
                                        <th class="text-center" valign="middle">Deskripsi Artikel</th>
                                        <th class="text-center" valign="middle">Deskripsi Artikel (English)</th>
                                        <th class="text-center" valign="middle">Tags (ID)</th>
                                        <th class="text-center" valign="middle">Tags (EN)</th>
                                        <th class="text-center" valign="middle">Meta Title (ID)</th>
                                        <th class="text-center" valign="middle">Meta Title (EN)</th>
                                        <th class="text-center" valign="middle">Meta Deskripsi (ID)</th>
                                        <th class="text-center" valign="middle">Meta Deskripsi (EN)</th>
                                        <th class="text-center" valign="middle">Foto Artikel</th>
                                        <th class="text-center" valign="middle">Tanggal Upload</th>
                                        <th class="text-center" valign="middle">Aksi</th>
                                    </tr>
                                </thead>

                                <?php
                                // Sort the articles by 'tgl_publish' in descending order
                                usort($all_data_artikel, function ($a, $b) {
                                    return strtotime($b['tgl_publish']) - strtotime($a['tgl_publish']);
                                });
                                ?>


                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($all_data_artikel as $tampilArtikel) : ?>
                                        <!-- Check if the tgl_publish is within the selected date range -->
                                        <?php
                                        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
                                        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;
                                        $tglPublish = $tampilArtikel['tgl_publish'];

                                        if (
                                            ($startDate && $tglPublish < $startDate) ||
                                            ($endDate && $tglPublish > $endDate)
                                        ) {
                                            continue; // Skip this row if it's not in the date range
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-center" valign="middle"><?= $i++ ?></td>
                                            <td class="text-center" valign="middle"><?= isset($tampilArtikel['judul_artikel']) ? $tampilArtikel['judul_artikel'] : 'Judul Tidak Tersedia' ?></td>
                                            <td class="text-center" valign="middle"><?= isset($tampilArtikel['judul_artikel_en']) ? $tampilArtikel['judul_artikel_en'] : 'Judul Tidak Tersedia' ?></td>
                                            <td class="text-center" valign="middle"><?= isset($tampilArtikel['nama_kategori']) ? $tampilArtikel['nama_kategori'] : 'Kategori Tidak Tersedia' ?></td>
                                            <td class="text-center" valign="middle"><?= isset($tampilArtikel['nama_penulis']) ? $tampilArtikel['nama_penulis'] : 'Penulis Tidak Tersedia' ?></td>
                                            <td class="text-center col-4" valign="middle">
                                                <?= isset($tampilArtikel['deskripsi_artikel']) ? substr(strip_tags($tampilArtikel['deskripsi_artikel']), 0, 60) . '...' : 'Deskripsi Tidak Tersedia' ?>
                                            </td>
                                            <td class="text-center col-4" valign="middle">
                                                <?= isset($tampilArtikel['deskripsi_artikel_en']) ? substr(strip_tags($tampilArtikel['deskripsi_artikel_en']), 0, 60) . '...' : 'Deskripsi Tidak Tersedia' ?>
                                            </td>
                                            <td class="text-center" valign="middle"><?= isset($tampilArtikel['tags']) ? $tampilArtikel['tags'] : 'Tag Tidak Tersedia' ?></td>
                                            <td class="text-center" valign="middle"><?= isset($tampilArtikel['tags_en']) ? $tampilArtikel['tags_en'] : 'Tag Tidak Tersedia' ?></td>
                                            <td class="text-center" valign="middle"><?= isset($tampilArtikel['meta_title_id']) ? $tampilArtikel['meta_title_id'] : 'Meta Title Tidak Tersedia' ?></td>
                                            <td class="text-center" valign="middle"><?= isset($tampilArtikel['meta_title_en']) ? $tampilArtikel['meta_title_en'] : 'Meta Title Tidak Tersedia' ?></td>
                                            <td class="text-center" valign="middle"><?= isset($tampilArtikel['meta_description_id']) ? $tampilArtikel['meta_description_id'] : 'Meta Deskripsi Tidak Tersedia' ?></td>
                                            <td class="text-center" valign="middle"><?= isset($tampilArtikel['meta_description_en']) ? $tampilArtikel['meta_description_en'] : 'Meta Deskripsi Tidak Tersedia' ?></td>
                                            <td class="text-center col-2" valign="middle">
                                                <img src="<?= base_url() . 'assets-baru/img/foto_artikel/' . (isset($tampilArtikel['foto_artikel']) ? $tampilArtikel['foto_artikel'] : 'default.jpg') ?>" class="img-fluid" alt="Foto Artikel">
                                            </td>
                                            <td class="text-center" valign="middle"><?= $tglPublish ?></td>
                                            <td valign="middle">
                                                <div class="d-grid gap-2">
                                                    <a href="<?= base_url('admin/artikel/delete') . '/' . $tampilArtikel['id_artikel'] ?>" class="btn btn-danger">Hapus</a>
                                                    <a href="<?= base_url('admin/artikel/edit') . '/' . $tampilArtikel['id_artikel'] ?>" class="btn btn-primary">Ubah</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div><!--//table-responsive-->
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//tab-pane-->
        </div><!--//tab-content-->
    </div><!--//container-xl-->
</div><!--//app-content-->

<?= $this->endSection('content') ?>