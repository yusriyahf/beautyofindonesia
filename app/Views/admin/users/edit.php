<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Edit Tampil Users</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/users/proses_edit/' . $users->id_user) ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?= $users->username; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <textarea class="form-control" id="email" name="email" rows="3" required><?= $users->email; ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?= $users->full_name; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <input type="text" class="form-control" id="role" name="role" value="<?= $users->role; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Bank Account Number</label>
                                        <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" value="<?= $users->bank_account_number; ?>" required>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex gap-2">
                                    <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>

                                </div>
                                <div class="col">
                                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                                        <div class="alert alert-success" role="alert">
                                            <?= session()->getFlashdata('success') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-4">
    </div>
</div>

<?= $this->endSection('content') ?>