<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Tampil Popup</h1>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?php echo base_url() . "admin/tampilpopup/tambah" ?>" class="btn btn-primary me-md-2">+ Tambah Tampil Popup</a>
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
                                        <th class="text-center" valign="middle">URL Popup</th>
                                        <th class="text-center" valign="middle">Jenis URL</th>
                                        <th class="text-center" valign="middle">Nama Popup</th>
                                        <th class="text-center" valign="middle">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($all_data_tampilpopup as $tampilPopup) : ?>
                                        <tr>
                                            <td class="text-center" valign="middle"><?= $i++ ?></td>

                                            <td class="text-center" valign="middle"><?= isset($tampilPopup['url_tampil_popup']) ? $tampilPopup['url_tampil_popup'] : 'Judul Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($tampilPopup['jenis_url_tampil_popup']) ? $tampilPopup['jenis_url_tampil_popup'] : 'Judul Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($tampilPopup['nama_popup']) ? $tampilPopup['nama_popup'] : 'Kategori Tidak Tersedia' ?></td>

                                            <td valign="middle">
                                                <div class="d-grid gap-2">
                                                    <a href="<?= base_url('admin/tampilpopup/edit') . '/' . $tampilPopup['id_link_tampil_popup'] ?>" class="btn btn-primary">Ubah</a>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $tampilPopup['id_link_tampil_popup'] ?>">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Delete-->
                                        <div class="modal fade" id="deleteModal<?= $tampilPopup['id_link_tampil_popup'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $tampilPopup['id_link_tampil_popup'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel<?= $tampilPopup['id_link_tampil_popup'] ?>">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus data ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <a href="<?= base_url('admin/tampilpopup/delete') . '/' . $tampilPopup['id_link_tampil_popup'] ?>" class="btn btn-danger">Hapus</a>
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

<?= $this->endSection('content') ?>