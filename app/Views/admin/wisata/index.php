<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">List of Tempat Wisata</h1>
            </div>
            </br>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= base_url('admin/tempat_wisata/tambah') ?>" class="btn btn-primary me-md-2">+ Add New Wisata</a>
            </div>
        </div>

        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover table-bordered mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="text-center" valign="middle">No</th>
                                        <th class="text-center" valign="middle">Nama Wisata (in)</th>
                                        <th class="text-center" valign="middle">Nama Wisata (en)</th>
                                        <th class="text-center" valign="middle">Kategori Wisata (in)</th>
                                        <th class="text-center" valign="middle">Kategori Wisata (en)</th>
                                        <th class="text-center" valign="middle">Kabupaten</th>
                                        <th class="text-center" valign="middle">Deskripsi Wisata (in)</th>
                                        <th class="text-center" valign="middle">Deskripsi Wisata (en)</th>
                                        <th class="text-center" valign="middle">Foto Wisata</th>
                                        <th class="text-center" valign="middle">Sumber Foto</th>
                                        <th class="text-center" valign="middle">Wisata Latitude</th>
                                        <th class="text-center" valign="middle">Wisata Longitude</th>
                                        <th class="text-center" valign="middle">Meta Title (in)</th>
                                        <th class="text-center" valign="middle">Meta Title (en)</th>
                                        <th class="text-center" valign="middle">Meta Deskripsi (in)</th>
                                        <th class="text-center" valign="middle">Meta Deskripsi (en)</th>
                                        <th class="text-center" valign="middle">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($wisata) > 0): ?>
                                        <?php foreach ($wisata as $index => $w): ?>
                                            <tr>
                                                <td class="text-center" valign="middle"><?= $index + 1 ?></td>
                                                <td class="text-center" valign="middle"><?= $w['nama_wisata_ind'] ?></td>
                                                <td class="text-center" valign="middle"><?= $w['nama_wisata_eng'] ?></td>
                                                <td class="text-center" valign="middle"><?= $w['nama_kategori_wisata'] ?></td>
                                                <td class="text-center" valign="middle"><?= $w['nama_kategori_wisata_en'] ?></td>
                                                <td class="text-center" valign="middle"><?= $w['nama_kotakabupaten'] ?></td>
                                                <td class="text-center col-4" valign="middle">
                                                    <?= isset($w['deskripsi_wisata_ind']) ? substr(strip_tags($w['deskripsi_wisata_ind']), 0, 60) . '...' : 'Deskripsi Tidak Tersedia' ?>
                                                </td>
                                                <td class="text-center col-4" valign="middle">
                                                    <?= isset($w['deskripsi_wisata_eng']) ? substr(strip_tags($w['deskripsi_wisata_eng']), 0, 60) . '...' : 'Deskripsi Tidak Tersedia' ?>
                                                </td>

                                                <td class="text-center col-2" valign="middle">
                                                    <img src="<?= base_url() . 'asset-user/uploads/foto_wisata/' . (isset($w['foto_wisata']) ? $w['foto_wisata'] : 'default.jpg') ?>" class="img-fluid" alt="Foto Wisata">
                                                </td>
                                                <td class="text-center" valign="middle"><?= $w['sumber_foto'] ?></td>
                                                <td class="text-center" valign="middle"><?= $w['wisata_latitude'] ?></td>
                                                <td class="text-center" valign="middle"><?= $w['wisata_longitude'] ?></td>
                                                <td class="text-center" valign="middle"><?= isset($w['meta_title_id']) ? $w['meta_title_id'] : 'Meta Title Tidak Tersedia' ?></td>
                                                <td class="text-center" valign="middle"><?= isset($w['meta_title_en']) ? $w['meta_title_en'] : 'Meta Title Tidak Tersedia' ?></td>
                                                <td class="text-center" valign="middle"><?= isset($w['meta_deskription_id']) ? $w['meta_deskription_id'] : 'Meta Deskripsi Tidak Tersedia' ?></td>
                                                <td class="text-center" valign="middle"><?= isset($w['meta_description_en']) ? $w['meta_description_en'] : 'Meta Deskripsi Tidak Tersedia' ?></td>

                                                <td valign="middle">
                                                    <div class="d-grid gap-2">
                                                        <a href="<?= base_url('admin/tempat_wisata/edit') . '/' . $w['id_wisata'] ?>" class="btn btn-primary">Ubah</a>
                                                        <a href="<?= base_url('admin/tempat_wisata/delete') . '/' . $w['id_wisata'] ?>" class="btn btn-danger">Hapus</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div><!--//table-responsive-->
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//tab-pane-->
        </div><!--//container-fluid-->
    </div><!--//app-content-->
</div><!--//app-wrapper-->

<?= $this->endSection('content'); ?>