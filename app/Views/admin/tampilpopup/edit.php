<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Edit Tampil Popup</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/tampilpopup/proses_edit/' . $tampilPopupData->id_link_tampil_popup) ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">URL Popup</label>
                                        <input type="text" class="form-control" id="url_tampil_popup" name="url_tampil_popup" value="<?= $tampilPopupData->url_tampil_popup; ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jenis URL</label>
                                        <select class="form-select form-control" name="jenis_url_tampil_popup">
                                            <option value="URL Only" <?= $tampilPopupData->jenis_url_tampil_popup == "URL Only" ? 'selected' : '' ?>>URL Only</option>
                                            <option value="URL & Prefix" <?= $tampilPopupData->jenis_url_tampil_popup == "URL & Prefix" ? 'selected' : '' ?>>URL & Prefix</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jenis Popup</label>
                                        <select class="form-select form-control" name="id_popup">
                                            <option value="" disabled>Pilih kategori wisata</option>
                                            <?php foreach ($listPopup as $popup) : ?>
                                                <option value="<?= $popup->id_popup ?>" <?= ($popup->id_popup == $tampilPopupData->id_popup) ? 'selected' : '' ?>><?= $popup->nama_popup ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Pilih kategori wisata.</div>
                                    </div>




                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex gap-2">
                                    <a href="<?= base_url('admin/tampilpopup') ?>" class="btn btn-secondary">Kembali</a>
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