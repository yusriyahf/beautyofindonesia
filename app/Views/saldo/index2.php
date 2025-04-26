<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<!-- app/Views/saldo/detail.php -->
<h2>Saldo User: <?= esc($saldo['user_id']) ?> - <?= esc($saldo['username']) ?></h2>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>User ID</th>
            <th>Nama</th>
            <th>Total Masuk</th>
            <th>Total Keluar</th>
            <th>Saldo</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= esc($saldo['user_id']) ?></td>
            <td><?= esc($saldo['username']) ?></td>
            <td><?= number_format($saldo['total_masuk'], 2) ?></td>
            <td><?= number_format($saldo['total_keluar'], 2) ?></td>
            <td><?= number_format($saldo['saldo'], 2) ?></td>
        </tr>
    </tbody>
</table>


<a href="<?php echo base_url() . "admin/popup/tambah" ?>" class="btn btn-primary me-md-2">Tarik saldo</a>


<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Penarikan</h1>
            </div>
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
                                        <th class="text-center" valign="middle">User_id</th>
                                        <th class="text-center" valign="middle">Jumlah</th>
                                        <th class="text-center" valign="middle">Status</th>
                                        <th class="text-center" valign="middle">Tanggal Pengajuan</th>
                                        <th class="text-center" valign="middle">Tanggal Persetujuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($all_data_penarikan_saldo as $saldo) : ?>
                                        <tr>
                                            <td class="text-center" valign="middle"><?= $i++ ?></td>
                                            <td class="text-center" valign="middle"><?= isset($saldo['user_id']) ? $saldo['user_id'] : 'Nama Users Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($saldo['jumlah']) ? $saldo['jumlah'] : 'Nama Users Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($saldo['status']) ? $saldo['status'] : 'Link Users Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($saldo['tanggal_pengajuan']) ? $saldo['tanggal_pengajuan'] : 'Nama Tombol Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($saldo['tanggal_persetujuan']) ? $saldo['tanggal_persetujuan'] : 'Nama Tombol Tidak Tersedia' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div><!--//table-responsive-->
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//tab-pane-->
        </div><!--//tab-content-->

        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Penarikan</h1>
            </div>
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
                                        <th class="text-center" valign="middle">User_id</th>
                                        <th class="text-center" valign="middle">Jumlah</th>
                                        <th class="text-center" valign="middle">Status</th>
                                        <th class="text-center" valign="middle">Tanggal Pengajuan</th>
                                        <th class="text-center" valign="middle">Tanggal Persetujuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($all_data_penarikan_saldo as $saldo) : ?>
                                        <tr>
                                            <td class="text-center" valign="middle"><?= $i++ ?></td>
                                            <td class="text-center" valign="middle"><?= isset($saldo['user_id']) ? $saldo['user_id'] : 'Nama Users Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($saldo['jumlah']) ? $saldo['jumlah'] : 'Nama Users Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($saldo['status']) ? $saldo['status'] : 'Link Users Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($saldo['tanggal_pengajuan']) ? $saldo['tanggal_pengajuan'] : 'Nama Tombol Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($saldo['tanggal_persetujuan']) ? $saldo['tanggal_persetujuan'] : 'Nama Tombol Tidak Tersedia' ?></td>
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