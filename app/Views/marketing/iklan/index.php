<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Tampil Artikel Iklan</h1>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?php echo base_url() . "admin/popup/tambah" ?>" class="btn btn-primary me-md-2">+ Tambah Artikel Iklan</a>
            </div>
        </div>

        <div class="col">
            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead class="atas">
                                    <tr>
                                        <th class="text-center" valign="middle">No</th>
                                        <th class="text-center" valign="middle">Artikel</th>
                                        <th class="text-center" valign="middle">Iklan</th>
                                        <th class="text-center" valign="middle">User</th>
                                        <th class="text-center" valign="middle">Tanggal Mulai</th>
                                        <th class="text-center" valign="middle">Tanggal Selesai</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($all_data_artikeliklan as $artikeliklan) : ?>
                                        <tr>
                                            <td class="text-center" valign="middle"><?= $i++ ?></td>
                                            <td class="text-center" valign="middle"><?= isset($artikeliklan['id_artikel']) ? $artikeliklan['id_artikel'] : 'Nama Popup Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($artikeliklan['id_iklan']) ? $artikeliklan['id_iklan'] : 'Nama Popup Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($artikeliklan['id_user']) ? $artikeliklan['id_user'] : 'Link Popup Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($artikeliklan['tanggal_mulai']) ? $artikeliklan['tanggal_mulai'] : 'Nama Tombol Tidak Tersedia' ?></td>
                                            <td class="text-center" valign="middle"><?= isset($artikeliklan['tanggal_selesai']) ? $artikeliklan['tanggal_selesai'] : 'Nama Tombol Tidak Tersedia' ?></td>


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