<?php
// Template untuk menampilkan List Oleh-Oleh
?>

<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">List of Oleh-Oleh</h1>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= base_url('admin/oleh_oleh/tambah') ?>" class="btn btn-primary">+ Add New Oleh-Oleh</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table class="table app-table-hover table-bordered mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nama Oleh-Oleh</th>
                                <th class="text-center">Nama Oleh-Oleh (English)</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Kabupaten</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">Deskripsi (English)</th>
                                <th class="text-center">Sumber Foto</th>
                                <th class="text-center">Nomor Telepon</th>
                                <th class="text-center">Link Website</th>
                                <th class="text-center">Meta Title (ID)</th>
                                <th class="text-center">Meta Title (EN)</th>
                                <th class="text-center">Meta Description (ID)</th>
                                <th class="text-center">Meta Description (EN)</th>
                                <th class="text-center">Latitude</th>
                                <th class="text-center">Longitude</th>
                                <th class="text-center">Foto</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data_oleh_oleh) && is_array($data_oleh_oleh)): ?>
                                <?php foreach ($data_oleh_oleh as $index => $item): ?>
                                    <tr>
                                        <td class="text-center"><?= $index + 1 ?></td>
                                        <td class="text-center"><?= esc($item['nama_oleholeh']) ?></td>
                                        <td class="text-center"><?= esc($item['nama_oleholeh_eng']) ?></td>
                                        <td class="text-center"><?= esc($item['nama_kategori_oleholeh']) ?></td>
                                        <td class="text-center"><?= esc($item['nama_kotakabupaten']) ?></td>
                                        <td class="text-center"><?= isset($item['deskripsi_oleholeh']) ? substr(strip_tags($item['deskripsi_oleholeh']), 0, 60) . '...' : 'Deskripsi Tidak Tersedia' ?></td>
                                        <td class="text-center"><?= isset($item['deskripsi_oleholeh_eng']) ? substr(strip_tags($item['deskripsi_oleholeh_eng']), 0, 60) . '...' : 'Description Not Available' ?></td>
                                        <td class="text-center"><?= esc($item['sumber_foto']) ?></td>
                                        <td class="text-center"><?= esc($item['nomor_tlp']) ?></td>
                                        <td class="text-center">
                                            <?php if (!empty($item['link_website'])): ?>
                                                <a href="<?= esc($item['link_website']) ?>" target="_blank">Visit</a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><?= esc($item['meta_title_id']) ?></td>
                                        <td class="text-center"><?= esc($item['meta_title_en']) ?></td>
                                        <td class="text-center"><?= esc($item['meta_description_id']) ?></td>
                                        <td class="text-center"><?= esc($item['meta_description_en']) ?></td>
                                        <td class="text-center"><?= esc($item['oleholeh_latitude']) ?></td>
                                        <td class="text-center"><?= esc($item['oleholeh_longitude']) ?></td>
                                        <td class="text-center">
                                            <img src="<?= base_url('assets-baru/img/foto_oleholeh/' . $item['foto_oleholeh']) ?>" alt="Foto Oleh-Oleh" width="100">
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('admin/oleh_oleh/edit/' . $item['id_oleholeh']) ?>" class="btn btn-warning">Edit</a>
                                            <a href="<?= base_url('admin/oleh_oleh/delete/' . $item['id_oleholeh']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="18" class="text-center">No data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>