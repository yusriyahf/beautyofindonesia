<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Edit Nama Kategori Wisata</h1>
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

                        <form action="<?= base_url('admin/kategori_wisata/proses_edit/' . $kategoriWisataData->id_kategori_wisata) ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="nama_kategori_wisata" class="form-label">Nama Kategori Wisata (in)</label>
                                <input type="text" class="form-control <?= $validation->hasError('nama_kategori_wisata') ? 'is-invalid' : '' ?>" id="nama_kategori_wisata" name="nama_kategori_wisata" value="<?= old('nama_kategori_wisata', $kategoriWisataData->nama_kategori_wisata) ?>" required>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nama_kategori_wisata') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nama_kategori_wisata" class="form-label">Nama Kategori Wisata (en)</label>
                                <input type="text" class="form-control <?= $validation->hasError('nama_kategori_wisata_en') ? 'is-invalid' : '' ?>" id="nama_kategori_wisata_en" name="nama_kategori_wisata_en" value="<?= old('nama_kategori_wisata_en', $kategoriWisataData->nama_kategori_wisata_en) ?>" required>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nama_kategori_wisata_en') ?>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="<?= base_url('admin/kategori_wisata/index') ?>" class="btn btn-secondary">Kembali</a>
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