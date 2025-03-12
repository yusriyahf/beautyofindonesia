<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Tampil Popup</h1>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?php echo base_url() . "admin/popup/tambah" ?>" class="btn btn-primary me-md-2">+ Tambah Popup</a>
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
                                        <th class="text-center" valign="middle">Nama Popup</th>
                                        <th class="text-center" valign="middle">Title Popup</th>
                                        <th class="text-center" valign="middle">Link Popup</th>
                                        <th class="text-center" valign="middle">Nama Tombol</th>
                                        <th class="text-center" valign="middle">Foto Popup</th>
                                        <th class="text-center" valign="middle">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($all_data_popup as $popup) : ?>
                                        <tr>
                                            <td class="text-center" valign="middle"><?= $i++ ?></td>
                                            <td class="text-center" valign="middle"><?= isset($popup['nama_popup']) ? $popup['nama_popup'] : 'Nama Popup Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($popup['title_popup']) ? $popup['title_popup'] : 'Nama Popup Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($popup['link_popup']) ? $popup['link_popup'] : 'Link Popup Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($popup['nama_tombol']) ? $popup['nama_tombol'] : 'Nama Tombol Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle">
                                                <div style="width: 100px; height: 100px; background-image: url('<?= base_url() . 'uploads/popups/' . (isset($popup['foto_popup']) ? $popup['foto_popup'] : 'default.jpg') ?>'); background-size: cover; background-position: center; border-radius: 5px;">
                                                </div>
                                            </td>



                                            <td valign="middle">
                                                <div class="d-grid gap-2">
                                                    <a href="<?= base_url('admin/popup/edit') . '/' . $popup['id_popup'] ?>" class="btn btn-primary">Ubah</a>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $popup['id_popup'] ?>">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Delete-->
                                        <div class="modal fade" id="deleteModal<?= $popup['id_popup'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $popup['id_popup'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel<?= $popup['id_popup'] ?>">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus data ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <a href="<?= base_url('admin/popup/delete') . '/' . $popup['id_popup'] ?>" class="btn btn-danger">Hapus</a>
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