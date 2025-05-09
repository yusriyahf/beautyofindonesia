<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Tipe Iklan</h1>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= base_url('admin/tipeiklanutama/tambah') ?>" class="btn btn-primary me-md-2">+ Tambah tipe Iklan</a>
            </div>
        </div>

        <div class="col">
            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="tab-content" id="tipe-iklan-table-tab-content">
            <div class="tab-pane fade show active" id="tipe-iklan-all" role="tabpanel">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama tipe Iklan</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($tipeiklanutama as $tipe) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="text-center"><?= esc($tipe['nama']) ?></td>
                                            <td class="text-center">Rp<?= number_format($tipe['harga'], 0, ',', '.') ?></td>
                                            <td class="text-center">
                                                <?php if ($tipe['status'] == 'ada') : ?>
                                                    <span class="badge bg-success">Ada</span>
                                                <?php else : ?>
                                                    <span class="badge bg-secondary">Tidak</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-grid gap-2">
                                                    <a href="<?= base_url('admin/tipeiklanutama/edit/' . $tipe['id_tipe_iklan_utama']) ?>" class="btn btn-primary">Ubah</a>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $tipe['id_tipe_iklan_utama'] ?>">Hapus</button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Hapus -->
                                        <div class="modal fade" id="deleteModal<?= $tipe['id_tipe_iklan_utama'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $tipe['id_tipe_iklan_utama'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel<?= $tipe['id_tipe_iklan_utama'] ?>">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus tipe iklan ini?
                                                    </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <a href="<?= base_url('admin/tipeiklanutama/delete/' . $tipe['id_tipe_iklan_utama']) ?>" class="btn btn-danger">Hapus</a>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>

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

<?= $this->endSection('content');?>