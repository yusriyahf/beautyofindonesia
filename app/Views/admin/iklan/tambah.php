<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Tambah Iklan</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/iklan/proses_tambah') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col">

                                    <div class="mb-3">
                                        <label class="form-label">Nama Iklan</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Harga</label>
                                        <input type="number" class="form-control" id="harga" name="harga" value="<?= old('harga') ?>" required>
                                    </div>

                                    <!-- <div class="mb-3">
                                        <label class="form-label">ID Popup</label>
                                        <input type="text" class="form-control" id="id_popup" name="id_popup" value="<?= old('id_popup') ?>" required>
                                    </div> -->

                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col">
                                    <a href="<?= base_url('admin/iklan') ?>" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div><!--//card-body-->
                </div><!--//app-card-->
            </div>
        </div>
        <hr class="my-4">
    </div>
</div>

<?= $this->endSection(); ?>
