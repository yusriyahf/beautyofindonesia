<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Tambahkan Tampil Popup</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/tampilpopup/proses_tambah') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col">

                                    <div class="mb-3">
                                        <label class="form-label">URL Popup</label>
                                        <input type="text" class="form-control" id="url_tampil_popup" name="url_tampil_popup" value="<?= old('url_tampil_popup') ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jenis URL</label>
                                        <select required class="form-select form-control" name="jenis_url_tampil_popup">
                                            <option value="" disabled selected>Pilih Jenis URL</option>
                                            <option value="URL Only">URL Only</option>
                                            <option value="URL & Prefix">URL & Prefix</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jenis Popup</label>
                                        <select required class="form-control form-select" name="id_popup">
                                            <option value="" disabled selected>Pilih Jenis Popup</option>
                                            <?php foreach ($listPopup as $popup) : ?>
                                                <option value="<?= $popup->id_popup; ?>"><?= $popup->nama_popup; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <a href="<?= base_url('admin/tampilpopup') ?>" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
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