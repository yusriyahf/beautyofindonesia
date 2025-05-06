<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Tambahkan Jenis Iklan Utama</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/jenisiklanutama/proses_tambah') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col">

                                    <div class="mb-3">
                                        <label class="form-label">Nama Jenis Iklan</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" required>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label">Harga</label>
                                        <input type="number" class="form-control" id="harga" name="harga" value="<?= old('harga') ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select <?= ($validation && $validation->hasError('status')) ? 'is-invalid' : '' ?>" name="status" required>
                                            <option value="" disabled selected>Pilih status</option>
                                            <option value="ada" <?= old('status') == 'ada' ? 'selected' : '' ?>>Ada</option>
                                            <option value="tidak" <?= old('status') == 'tidak' ? 'selected' : '' ?>>Tidak</option>
                                        </select>
                                        <?php if ($validation) : ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('status') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <a href="<?= base_url('admin/jenisiklanutama') ?>" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
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

<?= $this->endSection('content');?>