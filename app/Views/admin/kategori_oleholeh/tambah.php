<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Tambah Kategori Oleh-Oleh</h1>
        <hr class="mb-4">

        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <!-- Tampilkan error validasi -->
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('admin/kategori_oleholeh/proses_tambah') ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="nama_kategori_oleholeh" class="form-label">Nama Kategori Oleh-Oleh (in)</label>
                                <input type="text" class="form-control <?= isset($validation) && $validation->hasError('nama_kategori_oleholeh') ? 'is-invalid' : '' ?>" id="nama_kategori_oleholeh" name="nama_kategori_oleholeh" value="<?= old('nama_kategori_oleholeh') ?>">
                                <div class="invalid-feedback">
                                    <?= isset($validation) ? $validation->getError('nama_kategori_oleholeh') : '' ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nama_kategori_oleholeh_en" class="form-label">Nama Kategori Oleh-Oleh (en)</label>
                                <input type="text" class="form-control <?= isset($validation) && $validation->hasError('nama_kategori_oleholeh_en') ? 'is-invalid' : '' ?>" id="nama_kategori_oleholeh_en" name="nama_kategori_oleholeh_en" value="<?= old('nama_kategori_oleholeh_en') ?>">
                                <div class="invalid-feedback">
                                    <?= isset($validation) ? $validation->getError('nama_kategori_oleholeh_en') : '' ?>
                                </div>
                            </div>

                            

                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="<?= base_url('admin/kategori_oleholeh/index') ?>" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="col">
                                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php echo session()->getFlashdata('success') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!--//app-card-->
            </div>
        </div><!--//row-->

        <hr class="my-4">
    </div><!--//container-xl-->
</div><!--//app-content-->

<?= $this->endSection('content'); ?>