<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Edit Harga Iklan</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/iklan/proses_edit/' . $iklan['id']) ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col">
                                    <!-- Nama -->
                                    <div class="mb-3">
                                        <label class="form-label">Nama Iklan</label>
                                        <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama', $iklan['nama']) ?>" required>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama'); ?>
                                        </div>
                                    </div>

                                    <!-- Harga -->
                                    <div class="mb-3">
                                        <label class="form-label">Harga</label>
                                        <input type="number" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : ''; ?>" id="harga" name="harga" value="<?= old('harga', $iklan['harga']) ?>" required>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('harga'); ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col d-flex gap-2">
                                    <a href="<?= base_url('admin/iklan') ?>" class="btn btn-secondary">Kembali</a>
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

<?= $this->endSection(); ?>
