<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Tambahkan Penulis</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/penulis/proses_tambah') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Penulis</label>
                                        <input type="text" class="form-control" id="nama_penulis" name="nama_penulis" value="<?= old('nama_penulis') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Penulis</label>
                                        <textarea type="text" class="form-control tiny" id="deskripsi_penulis" name="deskripsi_penulis"><?= old('deskripsi_penulis') ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Foto Penulis</label>
                                        <input class="form-control <?= ($validation->hasError('foto_penulis')) ? 'is-invalid' : '' ?>" type="file" id="foto_penulis" name="foto_penulis">
                                        <?= $validation->getError('foto_penulis') ?>
                                    </div>
                                    <p>*Ukuran foto maksimal 572x572 pixels</p>
                                    <p>*Foto harus berekstensi jpg/png/jpeg</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
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
    </div><!--//container-fluid-->
</div><!--//app-content-->

<?= $this->endSection('content'); ?>