<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Tampil Users</h1>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?php echo base_url() . "admin/popup/tambah" ?>" class="btn btn-primary me-md-2">+ Tambah Users</a>
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
                                        <th class="text-center" valign="middle">Username</th>
                                        <th class="text-center" valign="middle">Email</th>
                                        <th class="text-center" valign="middle">Full Name</th>
                                        <th class="text-center" valign="middle">Role</th>
                                        <th class="text-center" valign="middle">Bank Account Name</th>
                                        <th class="text-center" valign="middle">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($all_data_users as $user) : ?>
                                        <tr>
                                            <td class="text-center" valign="middle"><?= $i++ ?></td>
                                            <td class="text-center" valign="middle"><?= isset($user['username']) ? $user['username'] : 'Nama Users Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($user['email']) ? $user['email'] : 'Nama Users Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($user['full_name']) ? $user['full_name'] : 'Link Users Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($user['role']) ? $user['role'] : 'Nama Tombol Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($user['bank_account_number']) ? $user['bank_account_number'] : 'Nama Tombol Tidak Tersedia' ?></td>

                                            <td valign="middle">
                                                <div class="d-grid gap-2">
                                                    <a href="<?= base_url('admin/users/edit') . '/' . $user['id_user'] ?>" class="btn btn-primary">Ubah</a>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $user['id_user'] ?>">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Delete-->
                                        <div class="modal fade" id="deleteModal<?= $user['id_user'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $user['id_user'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel<?= $user['id_user'] ?>">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus data ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <a href="<?= base_url('admin/users/delete') . '/' . $user['id_user'] ?>" class="btn btn-danger">Hapus</a>
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